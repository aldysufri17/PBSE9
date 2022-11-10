<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $section = section::wherekeynot(128)->get();
        return view('backend.section.index',compact('section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.section.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validations
        $request->validate([
            'name'          => 'required',
        ]);

        $section = section::create([
            'name'          => $request->name,
        ]);

        if ($section) {
            return redirect()->route('section.index')->with('success', 'Departemen Berhasil ditambah!.');
        }
        return redirect()->route('section.index')->with('error', 'Departemen Gagal ditambah!.');
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
        $section = section::wherekey($id)->first();
        return view('backend.section.edit',compact('section'));
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
        // Validations
        $request->validate([
            'name'          => 'required',
        ]);

        $section = section::wherekey($id)->update([
            'name'          => $request->name,
        ]);

        // Assign Role To section
        // $section->assignRole($section->role_id);
        if ($section) {
            return redirect()->route('section.index')->with('success', 'Departemen Berhasil diubah!.');
        }
        return redirect()->route('section.index')->with('error', 'Departemen Gagal diubah!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $delete = section::wherekey($request->delete_id)->delete();
        if ($delete) {
            $user = User::where('section_id',$id)->delete();
            return redirect()->route('section.index')->with('success', 'Departemen Berhasil dihapus!.');
        }else{
            return redirect()->back()->with('error', 'Departemen Gagal dihapus!.');
        }
    }
}
