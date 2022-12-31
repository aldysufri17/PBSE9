<?php

namespace App\Http\Controllers;

use App\Models\building;
use App\Models\infrastructure_quantity;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InfrastrukturController extends Controller
{
    public function index()
    {
        if (Auth::user()->section_id == 128) {
            $infrastruktur = infrastructure_quantity::select('post_by')
                ->groupBy('post_by')
                ->get();
        } else {
            $infrastruktur = infrastructure_quantity::where('post_by', Auth::user()->user_id)
                ->select(DB::raw('YEAR(created_at) year'), 'post_by')
                ->selectRaw("SUM(total) as total")
                ->groupBy('year', 'post_by')
                ->get();
        }

        return view('backend.infrastruktur.index', compact('infrastruktur'));
    }

    public function create()
    {
        $post_by = Auth::user()->user_id;
        $building = building::where('post_by', $post_by)->paginate(5);
        $year = Carbon::now()->format('Y');
        return view('backend.infrastruktur.add', compact('building', 'year', 'post_by'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "building" => 'required',
            "room" => 'required',
            'inf' => 'required|array',
            "inf.*" => 'required',
            'qty' => 'required|array',
            "qty.*" => 'required',
            'cty' => 'required|array',
            "cty.*" => 'required',
        ]);

        infrastructure_quantity::where('building_id', $request->building)
            ->where('post_by', $request->post_by)
            ->whereYear('created_at', $request->year)
            ->where('room_id', $request->room)->delete();

        // Quantity Infrastructure
        $dt = Carbon::create($request->year, 1, 1, 0);
        foreach ($request->qty as $key => $qty) {
            infrastructure_quantity::create([
                'section_id'  => DB::table('buildings')->where('building_id', $request->building)->value('section_id'),
                'building_id'  => $request->building,
                'room_id'  => $request->room,
                'name'      => $request->inf[$key],
                'capacity'  => $request->cty[$key],
                'quantity'  => $qty,
                'total'     => $request->cty[$key] * $qty,
                'post_by'   => $request->post_by,
                'created_at' => $dt->toDateTimeString()
            ]);
        }
        return redirect()->route('infrastruktur.index')->with('success', 'Data audit Infrastruktur Tahun ' . $request->year . ' berhasil disimpan.!');
    }

    public function show($id)
    {
        $infrastruktur = infrastructure_quantity::where('post_by', $id)
            ->select(DB::raw('YEAR(created_at) year'), 'post_by')
            ->selectRaw("SUM(total) as total")
            ->groupBy('year', 'post_by')
            ->get();

        return view('backend.infrastruktur.show_admin', compact('infrastruktur'));
    }

    public function edit($year, $post_by)
    {
        $building = building::where('post_by', $post_by)->paginate(5);
        return view('backend.infrastruktur.add', compact('building', 'year', 'post_by'));
    }

    public function destroy(Request $request, $id)
    {
        $id = $request->delete_id;
        $year = $request->year;
        $tes = infrastructure_quantity::where('post_by', $id)->whereYear('created_at', $year)->delete();

        return redirect()->route('infrastruktur.index')->with('success', 'Data audit Infrastruktur Tahun ' . $request->year . ' berhasil dihapus.!');
    }

    public function roomInfrastrukturAjax(Request $request)
    {
        $room_id = $request->select;
        $year = $request->year;
        $output = "";

        $infrastruktur = infrastructure_quantity::where('room_id', $room_id)
            ->whereYear('created_at', '=', $year)
            ->get();
        if ($infrastruktur->isEmpty()) {
            $cekNull = "0";
        } else {
            $cekNull = "";
            foreach ($infrastruktur as $key => $value) {
                if ($key > 0) {
                    $output .= '<div class="infrastruktur hdtuto d-flex justify-content-between total mb-2 font-weight-bold">' .
                        '<div class="col">' .
                        '<span class="fw-bold">Nama Infrastruktur</span>' .
                        '<input required type="text" placeholder="Nama Infrastruktur" class="form-control form-control-user" value="' . $value->name . '"' . 'name="inf[]">' .
                        '</div>' .
                        '<div class="col mx-2">' .
                        '<span class="fw-bold">Kapasitas</span>' .
                        '<input required type="number" placeholder="Kapasitas" class="form-control form-control-user @error("cty") is-invalid @enderror" value="' . $value->capacity . '"' . ' name="cty[]" value="">' .
                        '</div>' .
                        '<div class="col">' .
                        '<span class="fw-bold">Kuantitas</span>' .
                        '<input required type="number" placeholder="Kuantitas" class="form-control form-control-user @error("qty") is-invalid @enderror" value="' . $value->quantity . '"' . 'name="qty[]" value="">' .
                        '</div>' .
                        '<button class="btn btn-danger" id="rmv" type="button">' . 'Hapus' . '</button>' .
                        '</div>';
                } else {
                    $output .= '<div class="infrastruktur d-flex justify-content-between total mb-2 font-weight-bold">' .
                        '<div class="col">' .
                        '<span class="fw-bold">Nama Infrastruktur</span>' .
                        '<input required type="text" placeholder="Nama Infrastruktur" class="form-control form-control-user" value="' . $value->name . '"' . 'name="inf[]">' .
                        '</div>' .
                        '<div class="col mx-2">' .
                        '<span class="fw-bold">Kapasitas</span>' .
                        '<input required type="number" placeholder="Kapasitas" class="form-control form-control-user @error("cty") is-invalid @enderror" value="' . $value->capacity . '"' . ' name="cty[]" value="">' .
                        '</div>' .
                        '<div class="col">' .
                        '<span class="fw-bold">Kuantitas</span>' .
                        '<input required type="number" placeholder="Kuantitas" class="form-control form-control-user @error("qty") is-invalid @enderror" value="' . $value->quantity . '"' . 'name="qty[]" value="">' .
                        '</div>' .
                        '<button class="btn btn-success btn-add" type="button">' . 'Tambah' . '</button>' .
                        '</div>';
                }
            }
        }

        return response()->json([
            'output'  => $output,
            'cekNull'  => $cekNull
        ]);
    }

    public function roomAjax(Request $request)
    {
        $room_id = $request->select;

        $room = Room::where('building_id', $room_id)->get();
        return response()->json($room);
    }
}
