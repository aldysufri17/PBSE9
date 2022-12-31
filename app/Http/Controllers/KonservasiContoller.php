<?php

namespace App\Http\Controllers;

use App\Models\conservation_item;
use App\Models\conservation_management;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function konservasiusageIndex(Request $request)
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');

        if (Auth::user()->section_id == 128) {
            $post_by = $request->post_by;
        } else {
            $post_by = Auth::user()->user_id;
        }

        $konservasi = conservation_management::where('post_by', $post_by)
            ->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', $month)
            ->get();

        if ($request->has('year')) {
            $year = $request->year;
            $month = $request->month;
            $konservasi = conservation_management::where('post_by', $post_by)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get();
        }
        return view('backend.konservasi.usage.index', compact('konservasi', 'post_by', 'year', 'month'));
    }

    public function indexAdmin()
    {
        $usage = conservation_management::select('post_by')
            ->groupBy('post_by')
            ->get();
        return view('backend.konservasi.usage.index_admin', compact('usage'));
    }

    public function KonservasiInput(Request $request)
    {
        $post_by = $request->post_by;
        $desc = $request->desc;
        $item = $request->item;
        $category = $request->category;
        $coi_id = $request->coi_id;
        $file = $request->file;
        $dt = Carbon::create($request->year, $request->month, 1, 0);


        foreach ($coi_id as $key => $value) {
            // Invoice Name

            $file_name = null;
            if ($item[$key] == 'ada' && $request->has('file')) {
                $file = $request->file[$key];
                $coi_name = conservation_item::where('coi_id', $value)->value('name');
                $name_user = User::where('user_id', $post_by)->value('name');
                $file_name = date('Y-m-d') . '-' . 'Convertion' . "-" . $coi_name . "-" . $name_user . "." . $file->getClientOriginalExtension();
                $destination = 'file/convertion';
                $file->move($destination, $file_name);
            }

            conservation_management::create([
                'coi_id'   => $value,
                'desc'      => $item[$key] == 'ada' ? $desc[$key] : '-',
                'item' => $item[$key] == 'ada' ? $item[$key] : 'tidak',
                'file'  => $file_name,
                'category' => $category[$key],
                'post_by'   => $post_by,
                'created_at' => $dt->toDateTimeString()
            ]);
        }

        if (Auth::user()->section_id == 128) {
            return redirect()->route('konservasi_usage.index_admin')->with('success', 'Data audit Konservasi berhasil disimpan.!');
        } else {
            return redirect()->route('konservasi_usage.index')->with('success', 'Data audit Konservasi berhasil disimpan.!');
        }
    }


    public function Konservasiedit($id, $post_by)
    {
        $usage = conservation_management::where('cm_id', $id)->first();
        return view('backend.konservasi.usage.edit', compact('usage', 'post_by'));
    }

    public function Konservasiupdate(Request $request, $id)
    {
        $desc = $request->desc;
        $item = $request->item;
        $file = $request->file;
        $coi_id = $request->coi_id;
        $post_by = $request->post_by;
        $file_old = $request->file;


        $file_name = null;
        if ($item == 'ada' && $request->has('file')) {
            if (file_exists(public_path('/file/convertion') . $file_old)) {
                unlink(public_path('/file/convertion') . $file_old); //menghapus file lama
            }

            $coi_name = conservation_item::where('coi_id', $coi_id)->value('name');
            $name_user = User::where('user_id', $post_by)->value('name');
            $file_name = date('Y-m-d') . '-' . 'Convertion' . "-" . $coi_name . "-" . $name_user . "." . $file->getClientOriginalExtension();
            $destination = 'file/convertion';
            $file->move($destination, $file_name);
        }

        conservation_management::where('cm_id', $id)->update([
            'desc'      => $item == 'ada' ? $desc : '-',
            'item' => $item == 'ada' ? $item : 'tidak',
            'file'  => $file_name,
        ]);

        if (Auth::user()->section_id == 128) {
            return redirect()->route('konservasi_usage.index_admin')->with('success', 'Data audit Konservasi berhasil disimpan.!');
        } else {
            return redirect()->route('konservasi_usage.index')->with('success', 'Data audit Konservasi berhasil disimpan.!');
        }
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

    public function konservasiUsageDestroy(Request $request)
    {
        $konservasi = conservation_management::where('coi_id', $request->delete_id);

        if (!is_null($konservasi->first()->file)) {
            if (file_exists(public_path('/file/convertion') . $konservasi->first()->file)) {
                unlink(public_path('/file/convertion') . $konservasi->first()->file); //menghapus file lama
            }
        }

        $delete = $konservasi->update([
            'desc' => '-',
            'item' => 'tidak',
            'file' => null,
            'category'  => null
        ]);
        if ($delete) {
            return redirect()->route('konservasi_usage.index')->with('success', 'Data audit Konservasi berhasil dihapus.!');
        }
    }
}
