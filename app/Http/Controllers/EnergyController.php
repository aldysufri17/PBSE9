<?php

namespace App\Http\Controllers;

use App\Models\Energi;
use App\Models\Energy;
use App\Models\energy_usage;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnergyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $energi = Energy::all();
        return view('backend.energi.index', compact('energi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.energi.add');
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
            'unit' => 'required',
        ]);

        $energi = Energy::create($request->all());

        if ($energi) {
            return redirect()->route('energy.index')->with('success', 'Jenis energi berhasil ditambah!.');
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
    public function edit($id)
    {
        $energi = Energy::whereId($id)->first();
        return view('backend.energi.edit', compact('energi'));
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
            'nama' => 'required',
            'satuan' => 'required',
        ]);

        $energi = Energy::whereId($id)->update(request()->except(['_token', '_method']));

        if ($energi) {
            return redirect()->route('energy.index')->with('success', 'Jenis energi berhasil diubah!.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $delete = Energy::where('energy_id', $request->delete_id)->delete();
        if ($delete) {
            return redirect()->route('energy.index')->with('success', 'Jenis energi berhasil dihapus!.');
        }
    }

    public function enegiusageIndex()
    {
        $usage = energy_usage::select('post_by')->groupBy('post_by')->get();
        return view('backend.energi.usage.index', compact('usage'));
    }

    public function enegiusageYears($id)
    {
        $usage = energy_usage::where('post_by', $id)
            ->select(DB::raw('YEAR(created_at) year'), 'post_by')
            ->groupBy('year', 'post_by')
            ->get();
        return view('backend.energi.usage.years', compact('usage'));
    }

    public function enegiusageMonth($id, $year)
    {
        $usage = energy_usage::where('post_by', $id)
            ->whereYear('created_at', '=', $year)
            ->select(DB::raw('MONTH(created_at) month'), 'post_by')
            ->groupBy('month', 'post_by')
            ->get();
        return view('backend.energi.usage.month', compact('usage', 'year'));
    }

    public function enegiusageShow($id, $year, $month)
    {
        $dateObj = DateTime::createFromFormat('!m', $month);
        $monthName = $dateObj->format('F');
        $usage = energy_usage::where('post_by', $id)
            ->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->get();
        return view('backend.energi.usage.show', compact('usage', 'monthName', 'year'));
    }
}
