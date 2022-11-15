<?php

namespace App\Http\Controllers;

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
        $energy = Energy::all();
        return view('backend.energy.index', compact('energy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.energy.add');
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

        $energy = Energy::create($request->all());

        if ($energy) {
            return redirect()->route('energy.index')->with('success', 'Jenis energy berhasil ditambah!.');
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
        $energy = Energy::whereenergy_id($id)->first();
        return view('backend.energy.edit', compact('energy'));
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
            'name' => 'required',
            'unit' => 'required',
        ]);

        $energy = Energy::whereenergy_id($id)->update(request()->except(['_token', '_method']));

        if ($energy) {
            return redirect()->route('energy.index')->with('success', 'Jenis energy berhasil diubah!.');
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
            return redirect()->route('energy.index')->with('success', 'Jenis energy berhasil dihapus!.');
        }
    }

    public function enegiusageIndex()
    {
        $usage = energy_usage::select('post_by')->groupBy('post_by')->get();
        return view('backend.energy.usage.index', compact('usage'));
    }

    public function enegiusageYears($id)
    {
        $usage = energy_usage::where('post_by', $id)
            ->select(DB::raw('YEAR(created_at) year'), 'post_by')
            ->groupBy('year', 'post_by')
            ->get();
        return view('backend.energy.usage.years', compact('usage'));
    }

    public function enegiusageMonth($id, $year)
    {
        $usage = energy_usage::where('post_by', $id)
            ->whereYear('created_at', '=', $year)
            ->select(DB::raw('MONTH(created_at) month'), 'post_by')
            ->groupBy('month', 'post_by')
            ->get();
        return view('backend.energy.usage.month', compact('usage', 'year'));
    }

    public function enegiusageShow($id, $year, $month)
    {
        $dateObj = DateTime::createFromFormat('!m', $month);
        $monthName = $dateObj->format('F');
        $usage = energy_usage::where('post_by', $id)
            ->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->get();
        return view('backend.energy.usage.show', compact('usage', 'monthName', 'year'));
    }
}
