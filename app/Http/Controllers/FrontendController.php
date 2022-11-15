<?php

namespace App\Http\Controllers;

use App\Models\academic_community;
use App\Models\conservation_item;
use App\Models\conservation_management;
use App\Models\Energy;
use App\Models\energy_usage;
use App\Models\infrastructure;
use App\Models\infrastructure_quantity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function auditInput()
    {
        $month = Carbon::now()->format('m');
        $cekPemakaian = energy_usage::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();
        $cekInfrastruktur = infrastructure_quantity::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();
        $cekKonservasi = conservation_management::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();
        $energy = Energy::all();
        $infrastruktur = infrastructure::select('name')->groupBy('name')->paginate(4);
        $konservasi = conservation_item::all();
        return view('frontend.audit.inputan-audit', compact('energy', 'infrastruktur', 'konservasi', 'cekPemakaian', 'cekInfrastruktur', 'cekKonservasi'));
    }

    public function auditRekap()
    {
        $year = Carbon::now()->format('Y');
        $energi = Energy::paginate(4);
        $civitas = academic_community::where('post_by', Auth::user()->user_id)
            ->whereYear('created_at', '=', $year)
            ->first();
        return view('frontend.audit.rekap-audit', compact('energi', 'civitas'));
    }

    public function infrastrukturInput(Request $request)
    {
        $request->validate([
            'qty' => 'required|array',
            "qty.*" => 'required',
            'cty' => 'required|array',
            "cty.*" => 'required',
        ]);

        $post_by = Auth::user()->user_id;

        // Quantity Infrastructure
        foreach ($request->qty as $key => $qty) {
            $qty = infrastructure_quantity::create([
                'is_id'     => $key,
                'capacity'  => $request->cty[$key],
                'quantity'  => $qty,
                'post_by'   => $post_by
            ]);
        }

        $month = Carbon::now()->format('m');
        $cekPemakaian = energy_usage::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();
        $cekInfrastruktur = infrastructure_quantity::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();
        $cekKonservasi = conservation_management::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();

        if ($cekPemakaian && $cekInfrastruktur && $cekKonservasi) {
            return redirect()->route('rekap.audit')->with('success', 'Data audit bulan ' . Carbon::now()->format('F') . ' berhasil disimpan.!');
        } else {
            return redirect()->route('audit.input')->with('success', 'Data audit Infrastruktur bulan ' . Carbon::now()->format('F') . ' berhasil disimpan.!');
        }
    }

    public function PemakaianInput(Request $request)
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
            "invoice.*" => 'required|mimes:jpeg,png,svg,pdf|max:20000',
            // "blueprint" => 'required|mimes:pdf|max:20000'
        ]);

        $post_by = Auth::user()->user_id;
        $energy_id = $request->energy_id;
        $usage = $request->usage;
        $cost = $request->cost;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

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
                'post_by' => $post_by
                //'user_id' => $post_by,
            ]);
        }

        $month = Carbon::now()->format('m');
        $cekPemakaian = energy_usage::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();
        $cekInfrastruktur = infrastructure_quantity::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();
        $cekKonservasi = conservation_management::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();

        if ($cekPemakaian && $cekInfrastruktur && $cekKonservasi) {
            return redirect()->route('rekap.audit')->with('success', 'Data audit bulan ' . Carbon::now()->format('F') . ' berhasil disimpan.!');
        } else {
            return redirect()->route('audit.input')->with('success', 'Data audit Pemakaian bulan ' . Carbon::now()->format('F') . ' berhasil disimpan.!');
        }
    }

    public function KonservasiInput(Request $request)
    {
        $post_by = Auth::user()->user_id;
        $answer = $request->answer;
        $desc_kon = $request->desc_kon;

        foreach ($answer as $key => $value) {
            if (is_null($desc_kon[$key])) {
                $item = [
                    $key => array(
                        'item' => $value,
                        'desc' => '-',
                    )
                ];
            } else {
                $item = [
                    $key => array(
                        'item' => $value,
                        'desc' => $desc_kon[$key],
                    )
                ];
            }

            conservation_management::create([
                'item' => json_encode($item),
                'post_by'   => $post_by
            ]);
        }

        $month = Carbon::now()->format('m');
        $cekPemakaian = energy_usage::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();
        $cekInfrastruktur = infrastructure_quantity::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();
        $cekKonservasi = conservation_management::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();

        if ($cekPemakaian && $cekInfrastruktur && $cekKonservasi) {
            return redirect()->route('rekap.audit')->with('success', 'Data audit bulan ' . Carbon::now()->format('F') . ' berhasil disimpan.!');
        } else {
            return redirect()->route('audit.input')->with('success', 'Data audit Konservasi bulan ' . Carbon::now()->format('F') . ' berhasil disimpan.!');
        }
    }

    public function inputCivitas()
    {
        $id = Auth::user()->user_id;
        $year = Carbon::now()->format('Y');
        $civitas = academic_community::where('post_by', Auth::user()->user_id)
            ->whereYear('created_at', '=', $year)
            ->first();
        return view('frontend.input-civitas', compact('civitas'));
    }

    public function civitasStore(Request $request)
    {
        $request->validate([
            'S1in' => 'required',
            'S2in' => 'required',
            'S3in' => 'required',
            'S1out' => 'required',
            'S2out' => 'required',
            'S3out' => 'required',
            'S1emp' => 'required',
            'S2emp' => 'required',
            'S3emp' => 'required',
        ]);

        $incoming_students = [
            's1' => $request->S1in,
            's2' => $request->S2in,
            's3' => $request->S3in,
        ];

        $graduate_students = [
            's1' => $request->S1out,
            's2' => $request->S2out,
            's3' => $request->S3out,
        ];

        $employee = [
            's1' => $request->S1emp,
            's2' => $request->S2emp,
            's3' => $request->S3emp,
        ];

        $user_id = Auth::user()->user_id;

        if ($request->id_civitas) {
            academic_community::where('ac_id', $request->id_civitas)->delete();
        }

        academic_community::create([
            'incoming_students' => json_encode($incoming_students),
            'graduate_students' => json_encode($graduate_students),
            'employee'          => json_encode($employee),
            'post_by'           => $user_id,
        ]);

        return redirect()->route('rekap.audit')->with('success', 'Data autdit civitas ' . Carbon::now()->format('F') . ' berhasil disimpan.!');
    }
}
