<?php

namespace App\Http\Controllers;

use App\Models\Energi;
use App\Models\Energy;
use Illuminate\Http\Request;

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
        $delete = Energy::whereId($request->delete_id)->delete();
        if ($delete) {
            return redirect()->route('energy.index')->with('success', 'Jenis energi berhasil dihapus!.');
        }
    }
}
