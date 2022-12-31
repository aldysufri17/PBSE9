<?php

namespace App\Http\Controllers;

use App\Models\infrastructure_legality;
use App\Models\infrastucture_legality_items;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LegalityController extends Controller
{

    public function index(Request $request)
    {
        $year = Carbon::now()->format('Y');

        if ($request->has('year')) {
            $year = $request->year;
        }

        if (Auth::user()->section_id == 128) {
            $post_by = $request->post_by;
        } else {
            $post_by = Auth::user()->user_id;
        }

        $legality = infrastructure_legality::where('post_by', $post_by)
            ->whereYear('created_at', $year)
            ->get();
        $items = infrastucture_legality_items::all();
        return view('backend.legality.index', compact('legality', 'post_by', 'year', 'items'));
    }

    public function indexAdmin()
    {
        $legality = infrastructure_legality::select('post_by')
            ->groupBy('post_by')
            ->get();
        return view('backend.legality.index_admin', compact('legality'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nidi'      => 'required|array',
            "nidi.*"    => 'mimes:jpeg,png,jpg,svg,pdf,doc,csv,xlsx,xls,docx|max:20000',
            'slo'       => 'required|array',
            "slo.*"     => 'mimes:jpeg,png,jpg,svg,pdf,doc,csv,xlsx,xls,docx|max:20000',
            'io'        => 'required|array',
            "io.*"      => 'mimes:jpeg,png,jpg,svg,pdf,doc,csv,xlsx,xls,docx|max:20000',
            'ttb'       => 'required|array',
            "ttb.*"     => 'mimes:jpeg,png,jpg,svg,pdf,doc,csv,xlsx,xls,docx|max:20000',
            'sopo'      => 'required|array',
            "sopo.*"    => 'mimes:jpeg,png,jpg,svg,pdf,doc,csv,xlsx,xls,docx|max:20000',
            'sopm'      => 'required|array',
            "sopm.*"    => 'mimes:jpeg,png,jpg,svg,pdf,doc,csv,xlsx,xls,docx|max:20000',
        ]);

        $post_by = $request->post_by;
        $year = $request->year;
        $item_id = $request->item_id;

        $dt = Carbon::create($year, 1, 1, 0);

        // legalitas
        foreach ($item_id as $key => $item) {
            $item_name = infrastucture_legality_items::where('ili_id', $item)->value('item');
            $user_name = User::where('user_id', $post_by)->value('name');

            // NIDI
            $nidi_name = null;
            if ($request->has('nidi.' . $key)) {
                $nidi = $request->nidi[$key];
                $nidi_name = date('Y-m-d') . '-' . 'NIDI' . "-" . $item_name . "-" . $user_name . "." . $nidi->getClientOriginalExtension();
                $destination = 'file/legalitas/nidi';
                $nidi->move($destination, $nidi_name);
            }

            // SLO
            $slo_name = null;
            if ($request->has('slo.' . $key)) {
                $slo = $request->slo[$key];
                $slo_name = date('Y-m-d') . '-' . 'SLO' . "-" . $item_name . "-" . $user_name . "." . $slo->getClientOriginalExtension();
                $destination = 'file/legalitas/slo';
                $slo->move($destination, $slo_name);
            }

            // io
            $io_name = null;
            if ($request->has('io.' . $key)) {
                $io = $request->io[$key];
                $io_name = date('Y-m-d') . '-' . 'IJIN_OPERASI' . "-" . $item_name . "-" . $user_name . "." . $io->getClientOriginalExtension();
                $destination = 'file/legalitas/ijin_operasi';
                $io->move($destination, $io_name);
            }

            // ttb
            $ttb_name = null;
            if ($request->has('ttb.' . $key)) {
                $ttb = $request->ttb[$key];
                $ttb_name = date('Y-m-d') . '-' . 'TTB' . "-" . $item_name . "-" . $user_name . "." . $ttb->getClientOriginalExtension();
                $destination = 'file/legalitas/ttb';
                $ttb->move($destination, $ttb_name);
            }

            // sopo
            $sopo_name = null;
            if ($request->has('sopo.' . $key)) {
                $sopo = $request->sopo[$key];
                $sopo_name = date('Y-m-d') . '-' . 'SOP_OPERASI' . "-" . $item_name . "-" . $user_name . "." . $sopo->getClientOriginalExtension();
                $destination = 'file/legalitas/sop_operasi';
                $sopo->move($destination, $sopo_name);
            }

            // SOPM
            $sopm_name = null;
            if ($request->has('sopm.' . $key)) {
                $sopm = $request->sopm[$key];
                $sopm_name = date('Y-m-d') . '-' . 'SOP_PEMELIHARAAN' . "-" . $item_name . "-" . $user_name . "." . $sopm->getClientOriginalExtension();
                $destination = 'file/legalitas/sop_pemeliharaan';
                $sopm->move($destination, $sopm_name);
            }

            infrastructure_legality::create([
                'ili_id'            => $item,
                'NDI'               => $nidi_name,
                'SLO'               => $slo_name,
                'IJIN_OPERASI'      => $io_name,
                'TTB'               => $ttb_name,
                'SOP_OPERASI'       => $sopo_name,
                'SOP_PELIHARA'      => $sopm_name,
                'post_by'           => $post_by,
                'created_at'        => $dt->toDateTimeString()
            ]);
        }
        redirect()->route('legalitas.index')->with('success', 'Legalitas Infrastruktur' . $year . 'Berhasil disimpan.');
    }

    public function edit($id, $post_by)
    {
        $legality = infrastructure_legality::where('il_id', $id)->first();
        $year = $legality->created_at->format('Y');
        return view('backend.legality.edit', compact('legality', 'post_by', 'year'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nidi'      => 'required|mimes:jpeg,png,jpg,svg,pdf,doc,csv,xlsx,xls,docx|max:20000',
            'slo'       => 'required|mimes:jpeg,png,jpg,svg,pdf,doc,csv,xlsx,xls,docx|max:20000',
            'io'        => 'required|mimes:jpeg,png,jpg,svg,pdf,doc,csv,xlsx,xls,docx|max:20000',
            'ttb'       => 'required|mimes:jpeg,png,jpg,svg,pdf,doc,csv,xlsx,xls,docx|max:20000',
            'sopo'      => 'required|mimes:jpeg,png,jpg,svg,pdf,doc,csv,xlsx,xls,docx|max:20000',
            'sopm'      => 'required|mimes:jpeg,png,jpg,svg,pdf,doc,csv,xlsx,xls,docx|max:20000',
        ]);

        // legalitas
        $item_name = infrastucture_legality_items::where('ili_id', $request->ili_id)->value('item');
        $user_name = User::where('user_id', $post_by)->value('name');
        $legality = infrastructure_legality::where('il_id', $id)->first();
        $year = $request->year;

        // NIDI
        $nidi_name = null;
        if ($request->has('nidi')) {
            if (file_exists(public_path('file/legalitas/nidi') . $legality->NDI)) {
                unlink(public_path('file/legalitas/nidi') . $legality->NDI); //menghapus file lama
            }
            $nidi = $request->nidi;
            $nidi_name = date('Y-m-d') . '-' . 'NIDI' . "-" . $item_name . "-" . $user_name . "." . $nidi->getClientOriginalExtension();
            $destination = 'file/legalitas/nidi';
            $nidi->move($destination, $nidi_name);
        }

        // SLO
        $slo_name = null;
        if ($request->has('slo')) {
            if (file_exists(public_path('file/legalitas/nidi') . $legality->SLO)) {
                unlink(public_path('file/legalitas/slo') . $legality->SLO); //menghapus file lama
            }
            $slo = $request->slo;
            $slo_name = date('Y-m-d') . '-' . 'SLO' . "-" . $item_name . "-" . $user_name . "." . $slo->getClientOriginalExtension();
            $destination = 'file/legalitas/slo';
            $slo->move($destination, $slo_name);
        }

        // io
        $io_name = null;
        if ($request->has('io')) {
            if (file_exists(public_path('file/legalitas/nidi') . $legality->IJIN_OPERASI)) {
                unlink(public_path('file/legalitas/ijin_operasi') . $legality->IJIN_OPERASI); //menghapus file lama
            }
            $io = $request->io;
            $io_name = date('Y-m-d') . '-' . 'IJIN_OPERASI' . "-" . $item_name . "-" . $user_name . "." . $io->getClientOriginalExtension();
            $destination = 'file/legalitas/ijin_operasi';
            $io->move($destination, $io_name);
        }

        // ttb
        $ttb_name = null;
        if ($request->has('ttb')) {
            if (file_exists(public_path('file/legalitas/ttb') . $legality->TTB)) {
                unlink(public_path('file/legalitas/ttb') . $legality->TTB); //menghapus file lama
            }
            $ttb = $request->ttb;
            $ttb_name = date('Y-m-d') . '-' . 'TTB' . "-" . $item_name . "-" . $user_name . "." . $ttb->getClientOriginalExtension();
            $destination = 'file/legalitas/ttb';
            $ttb->move($destination, $ttb_name);
        }

        // sopo
        $sopo_name = null;
        if ($request->has('sopo')) {
            if (file_exists(public_path('file/legalitas/sop_operasi') . $legality->SOP_OPERASI)) {
                unlink(public_path('file/legalitas/sop_operasi') . $legality->SOP_OPERASI); //menghapus file lama
            }
            $sopo = $request->sopo;
            $sopo_name = date('Y-m-d') . '-' . 'SOP_OPERASI' . "-" . $item_name . "-" . $user_name . "." . $sopo->getClientOriginalExtension();
            $destination = 'file/legalitas/sop_operasi';
            $sopo->move($destination, $sopo_name);
        }

        // SOPM
        $sopm_name = null;
        if ($request->has('sopm')) {
            if (file_exists(public_path('file/legalitas/sop_pemeliharaan') . $legality->SOP_PELIHARA)) {
                unlink(public_path('file/legalitas/sop_pemeliharaan') . $legality->SOP_PELIHARA); //menghapus file lama
            }
            $sopm = $request->sopm;
            $sopm_name = date('Y-m-d') . '-' . 'SOP_PEMELIHARAAN' . "-" . $item_name . "-" . $user_name . "." . $sopm->getClientOriginalExtension();
            $destination = 'file/legalitas/sop_pemeliharaan';
            $sopm->move($destination, $sopm_name);
        }

        infrastructure_legality::where('il_id', $id)->update([
            'NDI'               => $nidi_name,
            'SLO'               => $slo_name,
            'IJIN_OPERASI'      => $io_name,
            'TTB'               => $ttb_name,
            'SOP_OPERASI'       => $sopo_name,
            'SOP_PELIHARA'      => $sopm_name,
        ]);

        redirect()->back()->with('success', 'Legalitas Infrastruktur' . $year . 'Berhasil diubah.');
    }

    public function indexItem()
    {
        $items = infrastucture_legality_items::all();
        return view('backend.legality.item.index', compact('items'));
    }

    public function createItem(Request $request)
    {
        return view('backend.legality.item.add');
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'name'  => 'required'
        ]);

        infrastucture_legality_items::create([
            'item' => $request->name
        ]);

        return redirect()->route('index_legalitas.item')->with('success', 'Item berhasil ditambah');
    }

    public function editItem($id)
    {
        $item = infrastucture_legality_items::where('ili_id', $id)->first();
        return view('backend.legality.item.edit', compact('item'));
    }

    public function updateItem(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required'
        ]);

        infrastucture_legality_items::where('ili_id', $id)->update([
            'item' => $request->name
        ]);

        return redirect()->route('index_legalitas.item')->with('success', 'Item berhasil diubah');
    }

    public function deleteItem(Request $request)
    {
        infrastucture_legality_items::where('ili_id', $request->delete_id)->delete();

        return redirect()->route('index_legalitas.item')->with('success', 'Item berhasil dihapus');
    }
}
