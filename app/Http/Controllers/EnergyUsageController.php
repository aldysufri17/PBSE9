<?php

namespace App\Http\Controllers;

use App\Models\building;
use App\Models\Energy;
use App\Models\energy_usage;
use App\Models\infrastructure_quantity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Exports\EUExport;
use Maatwebsite\Excel\Facades\Excel;

class EnergyUsageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $energy = Energy::all();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');

        if (Auth::user()->section_id != 128) {
            $post_by = Auth::user()->user_id;
        } else {
            $post_by = $request->post_by;
        }

        $usage = energy_usage::where('post_by', $post_by)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $building = building::where('post_by', $post_by)->get();

        if ($request->get('year')) {
            $usage = energy_usage::where('post_by', $post_by)
                ->whereYear('created_at', $request->get('year'))
                ->whereMonth('created_at', $request->get('month'))
                ->where('building_id', $request->get('building'))
                ->get();
        }

        return view('backend.energy.usage.index', compact('energy', 'usage', 'post_by', 'building'));
    }

    public function indexAdmin()
    {
        $usage = energy_usage::select('post_by')
            ->groupBy('post_by')
            ->get();
        return view('backend.energy.usage.index_admin', compact('usage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'energy_id' => 'required|array',
            "energy_id.*" => 'required',
            "usage.*" => 'required',
            "usage" => 'required|array',
            "cost.*" => 'required',
            "cost" => 'required|array',
            'start_date' => 'required|array',
            "start_date.*" => 'required',
            'end_date' => 'required|array',
            "end_date.*" => 'required',
            'invoice' => 'required|array',
            "invoice.*" => 'required|mimes:jpeg,png,jpg,svg,pdf|max:20000',
            // "blueprint" => 'required|mimes:pdf|max:20000'
        ]);

        $post_by = $request->post_by;
        $energy_id = $request->energy_id;
        $usage = $request->usage;
        $cost = $request->cost;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $dt = Carbon::create($request->year, $request->month, 1, 0);

        // Energy Usage
        foreach ($energy_id as $key => $energi) {
            // Invoice Name
            $invoice = $request->invoice[$key];
            $energi_name = Energy::where('energy_id', $energi)->value('name');
            $invoice_name = date('Y-m-d') . '-' . 'Invoice' . "-" . $energi_name . "-" . Auth::user()->name . "." . $invoice->getClientOriginalExtension();
            $destination = 'file/invoice';
            $invoice->move($destination, $invoice_name);

            // Create Post
            energy_usage::create([
                'energy_id' => $energi,
                'usage' => $usage[$key],
                'cost' => $cost[$key],
                'invoice' => $invoice_name,
                'start_date' => $start_date[$key],
                'end_date' => $end_date[$key],
                'post_by' => $post_by,
                'building_id' => $request->building_id,
                'created_at' => $dt->toDateTimeString()
            ]);
        }

        if (Auth::user()->section_id == 128) {
            return redirect()->route('energy-usage.index_admin')->with('success', 'Data berhasil diubah.!');
        } else {
            return redirect()->route('energy-usage.index')->with('success', 'Data berhasil diubah.!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $post_by)
    {
        $usage = energy_usage::where('eu_id', $id)->first();
        return view('backend.energy.usage.edit', compact('usage', 'post_by'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "usage" => 'required',
            "cost" => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            "invoice" => 'required',
        ]);

        // Invoice Name
        $invoice = $request->invoice;
        $energi_name = Energy::where('energy_id', $request->energi)->value('name');
        $image_old = energy_usage::where('eu_id', $id)->value('invoice');
        $name_user = User::where('user_id', $request->post_by)->value('name');

        if (file_exists(public_path('/file/invoice/') . $image_old)) {
            unlink(public_path('/file/invoice/') . $image_old); //menghapus file lama
        }
        $invoice_name = date('Y-m-d') . '-' . 'Invoice' . "-" . $energi_name . "-" . $name_user . "." . $invoice->getClientOriginalExtension();
        $destination = 'file/invoice';
        $invoice->move($destination, $invoice_name);

        energy_usage::where('eu_id', $id)->update([
            'usage' => $request->usage,
            'cost' => $request->cost,
            'invoice' => $invoice_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);


        if (Auth::user()->section_id == 128) {
            return redirect()->route('energy-usage.index_admin')->with('success', 'Data berhasil diubah.!');
        } else {
            return redirect()->route('energy-usage.index')->with('success', 'Data berhasil diubah.!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $id = $request->delete_id;
        $tes = energy_usage::where('eu_id', $id)->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.!');
    }

    public function export($id, $year=null, $month=null, $building=null)
    {
        $depar = User::whereuser_id($id)->value("name");
        $fileName = date('Y-m-d') . '_Data Penggunaan Energi_'. $depar . '_' . $year. '_' . $month. '.xlsx';
        return Excel::download(new EUExport($id, $year, $month, $building), $fileName);
    }
}
