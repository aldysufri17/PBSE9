<?php

namespace App\Http\Controllers;

use App\Models\conservation_item;
use App\Models\conservation_management;
use Illuminate\Http\Request;

class KonservasiContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $konservasi = conservation_item::all();
        return view('backend.konservasi.index', compact('konservasi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.konservasi.add');
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
            'item' => 'required',
        ]);

        conservation_item::create([
            'name' => $request->item
        ]);
        return redirect()->route('konservasi.index')->with('success', 'Item Konservasi berhasil disimpan.!');
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
        $konservasi = conservation_item::where('coi_id', $id)->first();
        return view('backend.konservasi.edit', compact('konservasi'));
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
        ]);

        conservation_item::where('coi_id', $id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('konservasi.index')->with('success', 'Item Konservasi berhasil disimpan.!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $delete = conservation_item::where('coi_id', $request->delete_id)->delete();
        if ($delete) {
            return redirect()->route('konservasi.index')->with('success', 'Item Konservasi berhasil dihapus!.');
        }
    }
}
