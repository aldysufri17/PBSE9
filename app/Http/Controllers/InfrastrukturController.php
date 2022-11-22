<?php

namespace App\Http\Controllers;

use App\Exports\ISExport;
use App\Models\infrastructure;
use App\Models\infrastructure_quantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class InfrastrukturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $infrastruktur = infrastructure::select('name')->groupBy('name')->get();
        return view('backend.infrastruktur.index', compact('infrastruktur'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.infrastruktur.add');
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
            'name' => 'required',
            "type.*" => 'required',
            "type" => 'required|array',
        ]);

        $post_by = Auth::user()->user_id;

        foreach ($request->type as $type) {
            infrastructure::create([
                'name' => $request->name,
                'type' => $type,
                'post_by' => $post_by
            ]);
        }
        return redirect()->route('infrastruktur.index')->with('success', 'Infrastruktur berhasil disimpan.!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $infrastruktur = infrastructure_quantity::where('post_by', $id)
            ->select(DB::raw('YEAR(created_at) year'), 'post_by')
            ->groupBy('year', 'post_by')
            ->get();
        return view('backend.infrastruktur.rekap.order_tahun', compact('infrastruktur'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $infrastruktur = infrastructure::where('name', $id)->first();
        return view('backend.infrastruktur.edit', compact('infrastruktur'));
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
        infrastructure::where('name', $request->Iname)->delete();
        $post_by = Auth::user()->user_id;
        foreach ($request->type as $value) {
            if ($value != null) {
                infrastructure::create([
                    'name' => $request->name,
                    'type' => $value,
                    'post_by' => $post_by
                ]);
            }
        }

        return redirect()->route('infrastruktur.index')->with('success', 'Infrastruktur berhasil dibaharui.!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $name = $request->delete_id;
        infrastructure::where('name', $name)->delete();
        return redirect()->route('infrastruktur.index')->with('success', 'Infrastruktur berhasil dihapus.!');
    }

    public function rekapInfrastruktur()
    {
        $infrastruktur = infrastructure_quantity::select('post_by')->groupBy('post_by')->get();
        return view('backend.infrastruktur.rekap.index', compact('infrastruktur'));
    }

    public function infrastrukturYear($year, $post_by)
    {
        $infrastruktur = infrastructure_quantity::where('post_by', $post_by)
            ->whereYear('created_at', '=', $year)->get();
        return view('backend.infrastruktur.rekap.rekap', compact('infrastruktur', 'year'));
    }

    public function export($id, $year, $month=null)
    {
        $fileName = date('Y-m-d') . '_' . 'Data Pengguna' . '.xlsx';
        /*if ($month==null){
            return Excel::download(new ISExportMonth($id, $year), $fileName);
        }else{*/
            return Excel::download(new ISExport($id, $year, $month),  $fileName);
        //}
    }
}
