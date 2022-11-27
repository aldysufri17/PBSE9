<?php

namespace App\Http\Controllers;

use App\Models\academic_community;
use App\Models\building;
use App\Models\conservation_item;
use App\Models\conservation_management;
use App\Models\Energy;
use Carbon\Carbon;
use App\Models\energy_usage;
use App\Models\infrastructure;
use App\Models\infrastructure_quantity;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function auditInput()
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $cekPemakaian = energy_usage::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();
        $cekInfrastruktur = infrastructure_quantity::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();
        $cekKonservasi = conservation_management::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();
        $energy = Energy::all();
        $infrastruktur = infrastructure::select('name')->groupBy('name')->paginate(4);
        $konservasiValidate = conservation_management::where('post_by', Auth::user()->user_id)
            ->whereYear('created_at', '=', $year)->first();
        if ($konservasiValidate) {
            $konservasi = conservation_item::where('category', 1)->get();
        } else {
            $konservasi = conservation_item::all();
        }
        $building = building::where('section_id', Auth::user()->section_id)->get();
        return view('frontend.inputan-audit', compact('energy', 'infrastruktur', 'konservasi', 'cekPemakaian', 'cekInfrastruktur', 'cekKonservasi', 'building'));
    }

    public function auditMaster()
    {
        $year = Carbon::now()->format('Y');
        $energi = Energy::paginate(4);
        $building = building::where('section_id', Auth::user()->section_id)->paginate(5);
        $civitas = academic_community::where('post_by', Auth::user()->user_id)
            ->whereYear('created_at', '=', $year)
            ->first();
        $infrastruktur = infrastructure_quantity::whereHas('building', function ($q) {
            $q->where('section_id', Auth::user()->section_id);
        })->groupBy('building_id')->select('building_id')->paginate(5);
        return view('frontend.master-audit', compact('energi', 'civitas', 'building', 'infrastruktur'));
    }

    public function infrastrukturInput(Request $request)
    {
        $request->validate([
            "building" => 'required',
            "room" => 'required',
            'inf_in' => 'required|array',
            "inf_in.*" => 'required',
            'qty_in' => 'required|array',
            "qty_in.*" => 'required',
            'cty_in' => 'required|array',
            "cty_in.*" => 'required',
        ]);

        $post_by = Auth::user()->user_id;
        infrastructure_quantity::where('building_id', $request->building)->where('room_id', $request->room)->delete();

        // Quantity Infrastructure
        foreach ($request->qty_in as $key => $qty) {
            infrastructure_quantity::create([
                'building_id'  => $request->building,
                'room_id'  => $request->room,
                'name'      => $request->inf_in[$key],
                'capacity'  => $request->cty_in[$key],
                'quantity'  => $qty,
                'total'     => $request->cty_in[$key] * $qty,
                'post_by'   => $post_by
            ]);
        }

        if ($request->qty) {
            // Quantity Infrastructure
            foreach ($request->qty as $key => $qty) {
                infrastructure_quantity::create([
                    'building_id'  => $request->building,
                    'room_id'  => $request->room,
                    'name'      => $request->inf[$key],
                    'capacity'  => $request->cty[$key],
                    'quantity'  => $qty,
                    'total'     => $request->cty[$key] * $qty,
                    'post_by'   => $post_by
                ]);
            }
        }

        $month = Carbon::now()->format('m');
        $cekPemakaian = energy_usage::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();
        $cekInfrastruktur = infrastructure_quantity::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();
        $cekKonservasi = conservation_management::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();

        if ($cekPemakaian && $cekInfrastruktur && $cekKonservasi) {
            return redirect()->route('master.audit')->with('success', 'Data audit bulan ' . Carbon::now()->format('F') . ' berhasil disimpan.!');
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
            return redirect()->route('master.audit')->with('success', 'Data audit bulan ' . Carbon::now()->format('F') . ' berhasil disimpan.!');
        } else {
            return redirect()->route('audit.input')->with('success', 'Data audit Pemakaian bulan ' . Carbon::now()->format('F') . ' berhasil disimpan.!');
        }
    }

    public function KonservasiInput(Request $request)
    {
        $post_by = Auth::user()->user_id;
        $answer = $request->answer;
        $desc_kon = $request->desc_kon;
        $category = $request->category;

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
                'category' => $category[$key],
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
            return redirect()->route('master.audit')->with('success', 'Data audit bulan ' . Carbon::now()->format('F') . ' berhasil disimpan.!');
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

        return redirect()->route('master.audit')->with('success', 'Data autdit civitas ' . Carbon::now()->format('F') . ' berhasil disimpan.!');
    }

    public function buildingAdd()
    {
        return view('frontend.building-add');
    }

    public function buildingStore(Request $request)
    {
        $request->validate([
            'room' => 'required|array',
            "room.*" => 'required',
            "building" => 'required',
        ]);
        $building_id = building::withTrashed()->max('building_id') + 1;
        $section = Auth::user()->section_id;
        $building = building::create([
            'building_id' => $building_id,
            'section_id' => $section,
            'name' => $request->building
        ]);

        foreach ($request->room as $key => $name) {
            Room::create([
                'building_id' => $building_id,
                'name'  => $name
            ]);
        }
        return redirect()->route('master.audit')->with('success', 'Data Gedung berhasil disimpan.!');
    }

    public function buildingDetail($building_id)
    {
        $building = building::where('building_id', $building_id)->first();
        $room = Room::where('building_id', $building_id)->get();
        return view('frontend.gedung-detail', compact('building', 'room'));
    }

    public function deleteroom(Request $request)
    {
        $id = $request->id;

        Room::where('room_id', $id)->delete();

        return response()->json([
            'status' => 200,
        ]);
    }

    public function buildingUpdate(Request $request, $building_id)
    {
        $request->validate([
            'room_in' => 'required|array',
            "room_in.*" => 'required',
            "building" => 'required',
        ]);

        building::where('building_id', $building_id)->delete();

        $building_id = building::withTrashed()->max('building_id') + 1;

        $building = building::create([
            'building_id' => $building_id,
            'section_id'   => Auth::user()->section_id,
            'name' => $request->building
        ]);

        foreach ($request->room_in as $key => $name) {
            Room::where('room_id', $key)->delete();
            Room::create([
                'building_id' => $building_id,
                'name'  => $name
            ]);
        }

        if ($request->room) {
            foreach ($request->room as $key => $name) {
                Room::create([
                    'building_id' => $building_id,
                    'name'  => $name
                ]);
            }
        }

        return redirect()->route('master.audit')->with('success', 'Data Gedung berhasil diubah.!');
    }

    public function roomAjax(Request $request)
    {
        $room_id = $request->select;

        $room = Room::where('building_id', $room_id)->get();
        return response()->json($room);
    }

    public function buildingDelete($building_id)
    {
        building::where('building_id', $building_id)->delete();
        Room::where('building_id', $building_id)->delete();
        return redirect()->back()->with('success', 'Data Gedung Berhasil dihapus');
    }

    public function roomInfrastrukturAjax(Request $request)
    {
        $room_id = $request->select;
        $output = "";

        $infrastruktur = infrastructure_quantity::where('room_id', $room_id)->get();
        if ($infrastruktur->isEmpty()) {
            $cekNull = "0";
        } else {
            $cekNull = "";
            foreach ($infrastruktur as $key => $value) {
                $output .= '<div class="infrastruktur d-flex justify-content-between total mb-2 font-weight-bold">' .
                    '<div class="col">' .
                    '<span class="fw-bold">Nama Infrastruktur</span>' .
                    '<input required type="text" disabled placeholder="Nama Infrastruktur" class="form-control form-control-user value="' . $value->name . '"' . 'name="inf[]">' .
                    '</div>' .
                    '<div class="col mx-2">' .
                    '<span class="fw-bold">Kapasitas (Watt)</span>' .
                    '<input required type="number" disabled placeholder="Kapasitas" class="form-control form-control-user @error("cty") is-invalid @enderror" value="' . $value->capacity . '"' . ' name="cty[]" value="">' .
                    '</div>' .
                    '<div class="col">' .
                    '<span class="fw-bold">Kuantitas</span>' .
                    '<input required type="number" disabled placeholder="Kuantitas" class="form-control form-control-user @error("qty") is-invalid @enderror" value="' . $value->quantity . '"' . 'name="qty[]" value="">' .
                    '</div>' .
                    '<div class="col mx-2">' .
                    '<span class="fw-bold">Total Daya (Watt)</span>' .
                    '<input required type="number" disabled placeholder="Kuantitas" class="form-control form-control-user @error("qty") is-invalid @enderror" value="' . $value->total . '"' . 'name="qty[]" value="">' .
                    '</div>' .
                    '</div>';
            }
        }

        return response()->json([
            'output'  => $output,
            'cekNull'  => $cekNull
        ]);
    }

    public function updateInfrastrukturInput(Request $request)
    {
        $request->validate([
            "room" => 'required',
            "building" => 'required',
        ]);
        $infrastruktur = infrastructure_quantity::where('room_id', $request->room)->where('post_by', Auth::user()->user_id)->get();
        $building = building::where('building_id', $request->building)->first();
        $room = Room::where('room_id', $request->room)->first();
        return view('frontend.infrastruktur-detail', compact('infrastruktur', 'building', 'room'));
    }

    public function deleteinfras(Request $request)
    {
        $id = $request->id;

        infrastructure_quantity::where('iq_id', $id)->delete();

        return response()->json([
            'status' => 200,
        ]);
    }
}
