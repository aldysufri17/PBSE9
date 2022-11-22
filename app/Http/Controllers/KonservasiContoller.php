<?php

namespace App\Http\Controllers;

use App\Models\conservation_item;
use App\Models\conservation_management;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KonservasiContoller extends Controller
{
    public function index()
    {
        $konservasi = conservation_item::all();
        return view('backend.konservasi.index', compact('konservasi'));
    }

    public function create()
    {
        return view('backend.konservasi.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        conservation_item::create([
            'name' => $request->name,
            'category' => $request->category
        ]);
        return redirect()->route('konservasi.index')->with('success', 'Item Konservasi berhasil disimpan.!');
    }

    public function edit($id)
    {
        $konservasi = conservation_item::where('coi_id', $id)->first();
        return view('backend.konservasi.edit', compact('konservasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        conservation_item::where('coi_id', $id)->update([
            'name' => $request->name,
            'category' => $request->category
        ]);

        return redirect()->route('konservasi.index')->with('success', 'Item Konservasi berhasil disimpan.!');
    }

    public function destroy(Request $request, $id)
    {
        $delete = conservation_item::where('coi_id', $request->delete_id)->delete();
        if ($delete) {
            return redirect()->route('konservasi.index')->with('success', 'Item Konservasi berhasil dihapus!.');
        }
    }

    public function konservasiusageIndex()
    {
        $konservasi = conservation_management::select('post_by')->groupBy('post_by')->get();
        return view('backend.konservasi.usage.index', compact('konservasi'));
    }

    public function konservasiusageYears($id)
    {
        $konservasi = conservation_management::where('post_by', $id)
            ->select(DB::raw('YEAR(created_at) year'), 'post_by')
            ->groupBy('year', 'post_by')
            ->get();
        return view('backend.konservasi.usage.years', compact('konservasi'));
    }

    public function konservasiusageShowYears($id, $year)
    {
        $year = Carbon::now()->format('Y');
        $konservasi = conservation_management::where('post_by', $id)
            ->whereYear('created_at', '=', $year)
            ->where('category', 0)
            ->get();
        return view('backend.konservasi.usage.show-year', compact('konservasi'));
    }

    public function konservasiusageMonth($id)
    {
        $konservasi = conservation_management::where('post_by', $id)
            ->select(DB::raw('MONTH(created_at) month'), 'post_by')
            ->groupBy('month', 'post_by')
            ->get();
        return view('backend.konservasi.usage.month', compact('konservasi'));
    }

    public function konservasiusageShowMonth($id, $month)
    {
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $konservasi = conservation_management::where('post_by', $id)
            ->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->where('category', 1)
            ->get();
        return view('backend.konservasi.usage.show-month', compact('konservasi'));
    }
}
