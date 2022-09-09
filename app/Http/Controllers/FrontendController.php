<?php

namespace App\Http\Controllers;

use App\Models\Energi;
use App\Models\Energy;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function inputAudit()
    {
        $energi = Energy::all();
        return view('frontend.input-audit', compact('energi'));
    }
    public function auditStore(Request $request)
    {
        $request->validate([
            'energi_id' => 'required|array',
            "energi_id.*" => 'required',
            'nilai_energi' => 'required|array',
            "nilai_energi.*" => 'required',
            'date' => 'required|array',
            "date.*" => 'required',
        ]);
        $user_id = Auth::user()->user_id;
        $energi_id = $request->energi_id;
        $nilai_energi = $request->nilai_energi;
        $date = $request->date;
        foreach ($energi_id as $key => $energi) {
            Post::create([
                'user_id' => $user_id,
                'energi_id' => $energi,
                'nilai_energi' => $nilai_energi[$key],
                'date' => $date[$key]
            ]);
        }
        return redirect()->route('audit.input')->with('success', 'Data berhasi disimpan.!');
    }
}
