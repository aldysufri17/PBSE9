<?php

namespace App\Http\Controllers;

use App\Models\academic_community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CivitasController extends Controller
{
    public function rekapCivitas()
    {
        $civitas = academic_community::select('post_by')->groupBy('post_by')->get();
        return view('backend.civitas.index', compact('civitas'));
    }

    public function civitasYear($id)
    {
        $civitas = academic_community::where('post_by', $id)
            ->select(DB::raw('YEAR(created_at) year'), 'post_by')
            ->groupBy('year', 'post_by')
            ->get();
        return view('backend.civitas.years', compact('civitas'));
    }

    public function show($post_by, $year)
    {
        $civitas = academic_community::where('post_by', $post_by)
            ->whereYear('created_at', '=', $year)->first();
        return view('backend.civitas.show', compact('civitas', 'year'));
    }
}
