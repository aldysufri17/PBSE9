<?php

namespace App\Http\Controllers;

use App\Exports\MExport;
use App\Models\measurement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class MeasurementController extends Controller
{
    public function index(Request $request)
    {
        $year = Carbon::now()->format('Y');

        if ($request->has('year')) {
            $year = $request->year;
        }

        if (Auth::user()->section_id == 128) {
            $post_by = $request->post_by;
        } else {
            $post_by = Auth::user()->user_id;
        }

        $measurement = measurement::where('post_by', $post_by)
            ->whereYear('created_at', $year)
            ->get();
        return view('backend.measurement.index', compact('measurement', 'post_by', 'year'));
    }

    public function indexAdmin()
    {
        $measurement = measurement::select('post_by')
            ->groupBy('post_by')
            ->get();
        return view('backend.measurement.index_admin', compact('measurement'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'R'         => 'required|array',
            "R.*"       => 'required',
            'S'         => 'required|array',
            "S.*"       => 'required',
            'T'         => 'required|array',
            "T.*"       => 'required',
            'DT'         => 'required|array',
            "DT.*"       => 'required',
            'VRS'         => 'required|array',
            "VRS.*"       => 'required',
            'VST'         => 'required|array',
            "VST.*"       => 'required',
            'VTR'         => 'required|array',
            "VTR.*"       => 'required',
            'VRN'         => 'required',
            'VSN'         => 'required',
            'VTN'         => 'required',
            'f'         => 'required',
            'ha'         => 'required',
            'ht'         => 'required',
            'fd'         => 'required',
        ]);

        $daya_aktif = [
            'R' => $request->R[0],
            'S' => $request->S[0],
            'T' => $request->T[0],
            'TOTAL' => $request->DT[0],
        ];

        $daya_reaktif = [
            'R' => $request->R[1],
            'S' => $request->S[1],
            'T' => $request->T[1],
            'TOTAL' => $request->DT[1],
        ];

        $daya_semu = [
            'R' => $request->R[2],
            'S' => $request->S[2],
            'T' => $request->T[2],
            'TOTAL' => $request->DT[2],
        ];

        $tegangan_satu = [
            'VRN'   => $request->VRN,
            'VSN'   => $request->VSN,
            'VTN'   => $request->VTN,
        ];

        $tegangan_tiga = [
            'VRS'   => $request->VRS[0],
            'VST'   => $request->VST[0],
            'VTR'   => $request->VTR[0],
        ];

        $tegangan_unbalance = [
            'VRS'   => $request->VRS[1],
            'VST'   => $request->VST[1],
            'VTR'   => $request->VTR[1],
        ];

        $arus = [
            'R' => $request->R[3],
            'S' => $request->S[3],
            'T' => $request->T[3],
            'NETRAL' => $request->n,
        ];

        $year = $request->year;
        $post_by = $request->post_by;
        $dt = Carbon::create($year, 1, 1, 0);

        measurement::create([
            'daya_aktif'    => json_encode($daya_aktif),
            'daya_reaktif'  => json_encode($daya_reaktif),
            'daya_semu'     => json_encode($daya_semu),
            'tegangan_satu_fasa' => json_encode($tegangan_satu),
            'tegangan_tiga_fasa' => json_encode($tegangan_tiga),
            'tegangan_tidak_seimbang' => json_encode($tegangan_unbalance),
            'arus' => json_encode($arus),
            'frekuensi' => $request->f,
            'harmonisa_arus'   => $request->ha,
            'harmonisa_tegangan'    => $request->ht,
            'faktor_daya'   => $request->fd,
            'post_by'   => $post_by,
            'created_at'        => $dt->toDateTimeString()
        ]);
        return redirect()->route('measurement.index')->with('success', 'Kualitas Daya Tahun' . $year . 'Berhasil disimpan.');
    }

    public function edit($id, $post_by)
    {
        $measurement = measurement::where('m_id', $id)->first();
        $year = $measurement->created_at->format('Y');
        return view('backend.measurement.edit', compact('measurement', 'post_by', 'year'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'R'         => 'required|array',
            "R.*"       => 'required',
            'S'         => 'required|array',
            "S.*"       => 'required',
            'T'         => 'required|array',
            "T.*"       => 'required',
            'DT'         => 'required|array',
            "DT.*"       => 'required',
            'VRS'         => 'required|array',
            "VRS.*"       => 'required',
            'VST'         => 'required|array',
            "VST.*"       => 'required',
            'VTR'         => 'required|array',
            "VTR.*"       => 'required',
            'VRN'         => 'required',
            'VSN'         => 'required',
            'VTN'         => 'required',
            'f'         => 'required',
            'ha'         => 'required',
            'ht'         => 'required',
            'fd'         => 'required',
        ]);

        $daya_aktif = [
            'R' => $request->R[0],
            'S' => $request->S[0],
            'T' => $request->T[0],
            'TOTAL' => $request->DT[0],
        ];

        $daya_reaktif = [
            'R' => $request->R[1],
            'S' => $request->S[1],
            'T' => $request->T[1],
            'TOTAL' => $request->DT[1],
        ];

        $daya_semu = [
            'R' => $request->R[2],
            'S' => $request->S[2],
            'T' => $request->T[2],
            'TOTAL' => $request->DT[2],
        ];

        $tegangan_satu = [
            'VRN'   => $request->VRN,
            'VSN'   => $request->VSN,
            'VTN'   => $request->VTN,
        ];

        $tegangan_tiga = [
            'VRS'   => $request->VRS[0],
            'VST'   => $request->VST[0],
            'VTR'   => $request->VTR[0],
        ];

        $tegangan_unbalance = [
            'VRS'   => $request->VRS[1],
            'VST'   => $request->VST[1],
            'VTR'   => $request->VTR[1],
        ];

        $arus = [
            'R' => $request->R[3],
            'S' => $request->S[3],
            'T' => $request->T[3],
            'NETRAL' => $request->n,
        ];

        $year = $request->year;
        $post_by = $request->post_by;
        $dt = Carbon::create($year, 1, 1, 0);

        measurement::create([
            'daya_aktif'    => json_encode($daya_aktif),
            'daya_reaktif'  => json_encode($daya_reaktif),
            'daya_semu'     => json_encode($daya_semu),
            'tegangan_satu_fasa' => json_encode($tegangan_satu),
            'tegangan_tiga_fasa' => json_encode($tegangan_tiga),
            'tegangan_tidak_seimbang' => json_encode($tegangan_unbalance),
            'arus' => json_encode($arus),
            'frekuensi' => $request->f,
            'harmonisa_arus'   => $request->ha,
            'harmonisa_tegangan'    => $request->ht,
            'faktor_daya'   => $request->fd,
            'post_by'   => $post_by,
            'created_at'        => $dt->toDateTimeString()
        ]);

        measurement::where('m_id', $id)->delete();
        return redirect()->route('measurement.index')->with('success', 'Kualitas Daya Tahun' . $year . 'Berhasil disimpan.');
    }

    public function destroy(Request $request, $id)
    {
        $delete = measurement::where('m_id', $request->delete_id)->delete();
        if ($delete) {
            return redirect()->route('measurement.index')->with('success', 'Data audit Kualitas Daya berhasil dihapus.!');
        }
    }

    public function export($year)
    {
        $fileName = date('Y-m-d') . '_' . 'Kualitas daya' . '.xlsx';
        return Excel::download(new MExport($year), $fileName);
    }
}
