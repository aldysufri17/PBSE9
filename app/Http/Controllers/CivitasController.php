<?php

namespace App\Http\Controllers;

use App\Models\academic_community;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CivitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post_by = Auth::user()->user_id;
        if (Auth::user()->section_id == 128) {
            $civitas = academic_community::select('post_by')
                ->groupBy('post_by')
                ->get();
        } else {
            $civitas = academic_community::where('post_by', $post_by)
                ->select(DB::raw('YEAR(created_at) year'), 'post_by')
                ->groupBy('year', 'post_by')
                ->get();
        }

        return view('backend.civitas.index', compact('civitas', 'post_by'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Carbon::now()->format('Y');
        $civitas = academic_community::where('post_by', Auth::user()->user_id)
            ->whereYear('created_at', '=', $id)
            ->first();
        return view('backend.civitas.add', compact('civitas', 'id'));
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

        if (Auth::user()->section_id == 128) {
            $user_id =  $request->post_by;
        } else {
            $user_id = Auth::user()->user_id;
        }


        // if ($request->id_civitas) {
        //     academic_community::where('ac_id', $request->id_civitas)->delete();
        // }

        academic_community::where('ac_id', $request->id_civitas)->update([
            'incoming_students' => json_encode($incoming_students),
            'graduate_students' => json_encode($graduate_students),
            'employee'          => json_encode($employee),
            'post_by'           => $user_id,
        ]);

        return redirect()->route('civitas.index')->with('success', 'Data autdit civitas ' . Carbon::now()->format('F') . ' berhasil disimpan.!');
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
            $post_by = Auth::user()->user_id;
            $civitas = academic_community::where('post_by', $post_by)
                ->whereYear('created_at', '=', $id)
                ->first();
            return view('backend.civitas.add', compact('post_by', 'id', 'civitas'));
        } else {
            $post_by = $id;
            $civitas = academic_community::where('post_by', $post_by)
                ->select(DB::raw('YEAR(created_at) year'), 'post_by')
                ->groupBy('year', 'post_by')
                ->get();
            return view('backend.civitas.show_admin', compact('civitas', 'post_by'));
        }
    }

    public function detailAdmin($id, $post_by)
    {
        $civitas = academic_community::where('post_by', $post_by)
            ->whereYear('created_at', '=', $id)
            ->first();
        return view('backend.civitas.add', compact('id', 'civitas', 'post_by'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
