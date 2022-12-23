<?php

namespace App\Http\Controllers;

use App\Models\building;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->section_id != 128) {
            $building = building::where('section_id', Auth::user()->section_id)
                ->where('post_by', Auth::user()->user_id)
                ->get();
        } else {
            $building = building::select('section_id')->groupBy('section_id')->get();
        }
        return view('backend.building.index', compact('building'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.building.add');
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
            'room' => 'required|array',
            "room.*" => 'required',
            "building" => 'required',
        ]);
        $building_id = building::withTrashed()->max('building_id') + 1;
        $section = Auth::user()->section_id;
        $building = building::create([
            'building_id' => $building_id,
            'section_id' => $section,
            'name' => $request->building,
            'post_by' => Auth::user()->user_id
        ]);

        foreach ($request->room as $key => $name) {
            Room::create([
                'building_id' => $building_id,
                'name'  => $name
            ]);
        }
        return redirect()->route('building.index')->with('success', 'Data Gedung berhasil disimpan.!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->section_id != 128) {
            $building = building::where('building_id', $id)->first();
            $room = Room::where('building_id', $id)->get();
            return view('backend.building.show', compact('building', 'room'));
        } else {
            $building = building::where('section_id', $id)->get();
            return view('backend.building.show', compact('building'));
        }
    }

    public function showAdmin($id)
    {
        $building = building::where('building_id', $id)->first();
        $room = Room::where('building_id', $id)->get();
        return view('backend.building.admin_show', compact('building', 'room'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'room_in' => 'required|array',
            "room_in.*" => 'required',
            "building_name" => 'required',
        ]);

        $building = building::where('building_id', $request->building_id)->update([
            'name' => $request->building_name
        ]);

        foreach ($request->room_in as $key => $name) {
            Room::where('room_id', $key)->delete();
            Room::create([
                'building_id' => $request->building_id,
                'name'  => $name
            ]);
        }

        if ($request->room) {
            foreach ($request->room as $key => $name) {
                Room::create([
                    'building_id' => $request->building_id,
                    'name'  => $name
                ]);
            }
        }

        return redirect()->route('building.index')->with('success', 'Data Gedung berhasil diubah.!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $delete = building::wherekey($request->delete_id)->delete();
        if ($delete) {
            Room::where('building_id', $request->delete_id)->delete();
            return redirect()->route('building.index')->with('success', 'Gedung Berhasil dihapus!.');
        } else {
            return redirect()->back()->with('error', 'Departemen Gagal dihapus!.');
        }
    }
}
