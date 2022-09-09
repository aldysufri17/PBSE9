<?php

namespace App\Http\Controllers;

use App\Models\Blueprint;
use App\Models\Energi;
use App\Models\Energy;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function inputAudit()
    {
        $energi = Energy::paginate(4);
        return view('frontend.input-audit', compact('energi'));
    }

    public function auditStore(Request $request)
    {
        $request->validate([
            'energy_id' => 'required|array',
            "energy_id.*" => 'required',
            "usage.*" => 'required',
            "usage" => 'required|array',
            'start_date' => 'required|array',
            "start_date.*" => 'required',
            'end_date' => 'required|array',
            "end_date.*" => 'required',
            'invoice' => 'required|array',
            "invoice.*" => 'required|mimes:jpeg,png,svg,pdf|max:20000',
            "blueprint" => 'required|mimes:pdf|max:20000'
        ]);
<<<<<<< HEAD

        $user_id = Auth::user()->id;
        $energy_id = $request->energy_id;
        $usage = $request->usage;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        // Blueprint
        $blueprint = $request->blueprint;
        $blueprint_name = "Peta Instalasi Energi Gedung " . Auth::user()->name . "." . $blueprint->getClientOriginalExtension();
        $destination = 'file/blueprints';
        $blueprint->move($destination, $blueprint_name);

        if ($request->file) {
            $file = $request->file;
            foreach ($file as $key => $value) {
                $name = date('Y-m-d') . '-' . 'File Tambahan' . $key + 1 . "-" . Auth::user()->name . "." . $value->getClientOriginalExtension();
                $destination = 'file/file-tambahan';
                $value->move($destination, $name);

                $file[$key] = $name;
            }

            $file_json = json_encode($file);

            foreach ($energy_id as $key => $energi) {
                // Invoice Name
                $invoice = $request->invoice[$key];
                $energi_name = Energy::whereId($invoice)->value('name');
                $invoice_name = date('Y-m-d') . '-' . 'Invoice' . "-" . $energi_name . "-" . Auth::user()->name . "." . $invoice->getClientOriginalExtension();
                $destination = 'file/invoice';
                $invoice->move($destination, $invoice_name);

                // Create Post
                Post::create([
                    'user_id' => $user_id,
                    'blueprint'  => $blueprint_name,
                    'energy_id' => $energi,
                    'usage' => $usage[$key],
                    'file'  => $file_json,
                    'start_date' => $start_date[$key],
                    'end_date' => $end_date[$key],
                    'invoice' => $invoice_name,
                ]);
            }
        } else {
            foreach ($energy_id as $key => $energi) {
                // Invoice Name
                $invoice = $request->invoice[$key];
                $energi_name = Energy::whereId($invoice)->value('name');
                $invoice_name = date('Y-m-d') . '-' . 'Invoice' . "-" . $energi_name . "-" . Auth::user()->name . "." . $invoice->getClientOriginalExtension();
                $destination = 'file/invoice';
                $invoice->move($destination, $invoice_name);

                // Create Post
                Post::create([
                    'user_id' => $user_id,
                    'blueprint'  => $blueprint_name,
                    'energy_id' => $energi,
                    'usage' => $usage[$key],
                    'start_date' => $start_date[$key],
                    'end_date' => $end_date[$key],
                    'invoice' => $invoice_name,
                ]);
            }
=======
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
>>>>>>> a3887105c866b2b791879f7f020e37a34b2a6510
        }

        return redirect()->route('riwayat.audit')->with('success', 'Data berhasi disimpan.!');
    }

    public function auditHistory()
    {
        $user_id = Auth::user()->id;
        $posts = Post::where('user_id', $user_id)->get();
        return view('frontend.posts-history', compact('posts'));
    }
}
