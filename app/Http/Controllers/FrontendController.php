<?php

namespace App\Http\Controllers;

use App\Models\Energy;
use App\Models\energy_usage;
use App\Models\infrastructure;
use App\Models\infrastructure_quantity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function auditInput()
    {
        $month = Carbon::now()->format('m');
        $usage = energy_usage::where('post_by', Auth::user()->user_id)
            ->whereMonth('created_at', '=', $month)->first();
        $energi = Energy::all();
        $infrastruktur = infrastructure::select('name')->groupBy('name')->paginate(4);
        return view('frontend.audit.inputan-audit', compact('energi', 'usage', 'infrastruktur'));
    }

    public function auditRekap()
    {
        $energi = Energy::paginate(4);
        return view('frontend.audit.rekap-audit', compact('energi'));
    }

    public function bulananStore(Request $request)
    {
        $request->validate([
            'energy_id' => 'required|array',
            "energy_id.*" => 'required',
            "usage.*" => 'required',
            "usage" => 'required|array',
            "cost.*" => 'required',
            "cost" => 'required|array',
            'start_date' => 'required|array',
            "start_date.*" => 'required',
            'end_date' => 'required|array',
            "end_date.*" => 'required',
            'invoice' => 'required|array',
            "invoice.*" => 'required|mimes:jpeg,png,svg,pdf|max:20000',
            "blueprint" => 'required|mimes:pdf|max:20000'
        ]);

        $user_id = Auth::user()->user_id;
        $energy_id = $request->energy_id;
        $usage = $request->usage;
        $cost = $request->cost;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        foreach ($energy_id as $key => $energi) {
            // Invoice Name
            $invoice = $request->invoice[$key];
            $energi_name = Energy::whereId($invoice)->value('name');
            $invoice_name = date('Y-m-d') . '-' . 'Invoice' . "-" . $energi_name . "-" . Auth::user()->name . "." . $invoice->getClientOriginalExtension();
            $destination = 'file/invoice';
            $invoice->move($destination, $invoice_name);

            // Create Post
            energy_usage::create([
                'energy_id' => $energi,
                'usage' => $usage[$key],
                'cost' => $cost[$key],
                'invoice' => $invoice_name,
                'start_date' => $start_date[$key],
                'end_date' => $end_date[$key],
                'post_by' => $user_id,
            ]);

            // Blueprint
            // $blueprint = $request->blueprint;
            // $blueprint_name = "Peta Instalasi Energi Gedung " . Auth::user()->name . "." . $blueprint->getClientOriginalExtension();
            // $destination = 'file/blueprints';
            // $blueprint->move($destination, $blueprint_name);

            // if ($request->file) {
            //     $file = $request->file;
            //     foreach ($file as $key => $value) {
            //         $name = date('Y-m-d') . '-' . 'File Tambahan' . $key + 1 . "-" . Auth::user()->name . "." . $value->getClientOriginalExtension();
            //         $destination = 'file/file-tambahan';
            //         $value->move($destination, $name);

            //         $file[$key] = $name;
            //     }

            //     $file_json = json_encode($file);

            //     foreach ($energy_id as $key => $energi) {
            //         // Invoice Name
            //         $invoice = $request->invoice[$key];
            //         $energi_name = Energy::whereId($invoice)->value('name');
            //         $invoice_name = date('Y-m-d') . '-' . 'Invoice' . "-" . $energi_name . "-" . Auth::user()->name . "." . $invoice->getClientOriginalExtension();
            //         $destination = 'file/invoice';
            //         $invoice->move($destination, $invoice_name);

            //         // Create Post
            //         EnergyUsages::create([
            //             'user_id' => $user_id,
            //             'energy_id' => $energi,
            //             'usage' => $usage[$key],
            //             'cost' => $cost[$key],
            //             'invoice' => $invoice_name,
            //             'start_date' => $start_date[$key],
            //             'end_date' => $end_date[$key],
            //             'file'  => $file_json,
            //         ]);
            //     }
            // } else {
            //     foreach ($energy_id as $key => $energi) {
            //         // Invoice Name
            //         $invoice = $request->invoice[$key];
            //         $energi_name = Energy::whereId($invoice)->value('name');
            //         $invoice_name = date('Y-m-d') . '-' . 'Invoice' . "-" . $energi_name . "-" . Auth::user()->name . "." . $invoice->getClientOriginalExtension();
            //         $destination = 'file/invoice';
            //         $invoice->move($destination, $invoice_name);

            //         // Create Post
            //         EnergyUsages::create([
            //             'user_id' => $user_id,
            //             'energy_id' => $energi,
            //             'usage' => $usage[$key],
            //             'cost' => $cost[$key],
            //             'invoice' => $invoice_name,
            //             'start_date' => $start_date[$key],
            //             'end_date' => $end_date[$key],
            //         ]);
            //     }
            // }
        }

        return redirect()->route('bulanan.audit')->with('success', 'Data autdit bulan' . Carbon::now()->format('F') . 'berhasi disimpan.!');
    }

    public function auditStore(Request $request)
    {
        // $request->validate([
        //     'energy_id' => 'required|array',
        //     "energy_id.*" => 'required',
        //     "usage.*" => 'required',
        //     "usage" => 'required|array',
        //     "cost.*" => 'required',
        //     "cost" => 'required|array',
        //     'start_date' => 'required|array',
        //     "start_date.*" => 'required',
        //     'end_date' => 'required|array',
        //     "end_date.*" => 'required',
        //     'qty' => 'required|array',
        //     "qty.*" => 'required',
        //     'cty' => 'required|array',
        //     "cty.*" => 'required',
        //     'invoice' => 'required|array',
        //     "invoice.*" => 'required|mimes:jpeg,png,svg,pdf|max:20000',
        //     // "blueprint" => 'required|mimes:pdf|max:20000'
        // ]);
        $post_by = Auth::user()->user_id;
        $energy_id = $request->energy_id;
        $usage = $request->usage;
        $cost = $request->cost;
        $start_date = $request->start_date;
        $end_date = $request->end_date;


        // Quantity Infrastructure
        foreach ($request->qty as $key => $qty) {
            $qty = infrastructure_quantity::create([
                'is_id'     => $key,
                'capacity'  => $request->cty[$key],
                'quantity'  => $qty,
                'post_by'   => $post_by
            ]);
        }

        // Energy Usage
        foreach ($energy_id as $key => $energi) {
            // Invoice Name
            $invoice = $request->invoice[$key];
            $energi_name = Energy::where('energy_id', $energi)->value('name');
            $invoice_name = date('Y-m-d') . '-' . 'Invoice' . "-" . $energi_name . "-" . Auth::user()->name . "." . $invoice->getClientOriginalExtension();
            $destination = 'file/invoice';
            $invoice->move($destination, $invoice_name);

            // Create Post
            energy_usage::create([
                'energy_id' => $energi,
                'usage' => $usage[$key],
                'cost' => $cost[$key],
                'invoice' => $invoice_name,
                'start_date' => $start_date[$key],
                'end_date' => $end_date[$key],
                'post_by' => $post_by
                //'user_id' => $post_by,
            ]);
        }

        return redirect()->route('rekap.audit')->with('success', 'Data autdit bulan ' . Carbon::now()->format('F') . ' berhasil disimpan.!');
    }

    /*public function auditHistory()
    {
        $user_id = Auth::user()->user_id;
        $posts = Post::where('user_id', $user_id)->get();
        return view('frontend.posts-history', compact('posts'));
    }*/
}
