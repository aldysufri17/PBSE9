<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user()->user_id;
        $user = User::wherekeynot($auth)->get();
        return view('backend.users.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $section = section::wherekeynot(128)->get();
        return view('backend.users.add',compact('section'));
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
            'email'         => 'required|unique:users,email|email:strict',
            'status'        =>  'required|numeric|in:0,1',
            'role'          =>  'required|numeric',
        ]);

        if ($request->role == 128 ) {
            $request->section = 128;
        }
        

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'role_id'       => $request->role,
            'section_id'    => $request->section,
            'status'        => $request->status,
            'password'      => bcrypt('secret')
        ]);

        if ($user) {
            return redirect()->route('user.index')->with('success', 'Pengguna Berhasil ditambah!.');
        }
        return redirect()->route('user.index')->with('error', 'Pengguna Gagal ditambah!.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $auth = Auth::user()->user_id;
        $user = User::wherekeynot($auth)->get();
        return view('backend.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        //dd($id);
        $user = User::wherekey($user_id)->first();
        $section = section::wherekeynot(128)->get();
        return view('backend.users.edit', compact('user','section'));
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
            // 'section'       => 'required|unique:users,email,' . $id . ',user_id',
            'status'        =>  'required|numeric|in:0,1',
            'role'          =>  'required|numeric',
        ]);

        if ($request->role == 128 ) {
            $request->section = 128;
        }

        $user = User::wherekey($id)->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'role_id'       => $request->role,
            'section_id'    => $request->section,
            'status'        => $request->status,
        ]);

        // Assign Role To User
        // $user->assignRole($user->role_id);
        if ($user) {
            return redirect()->route('user.index')->with('success', 'Pengguna Berhasil diubah!.');
        }
        return redirect()->route('user.index')->with('error', 'Pengguna Gagal diubah!.');
    }

    /**
     * Update Status Of User
     * @param Integer $status
     * @return List Page With Success
     * @author Shani Singh
     */
    public function updateStatus($user_id, $status)
    {
        // Validation
        Validator::make([
            'user_id'   => $user_id,
            'status'    => $status
        ], [
            'user_id'   =>  'required|exists:users,user_id',
            'status'    =>  'required|in:0,1',
        ]);
        $user_id = decrypt($user_id);
        // Update Status
        $user = User::wherekey($user_id)->update(['status' => $status]);

        // Masssage
        if ($user) {
            if ($status == 0) {
                return redirect()->route('user.index')->with('info', 'Status Pengguna Inactive!.');
            }
            return redirect()->route('user.index')->with('info', 'Status Pengguna Active!.');
        } else {
            return redirect()->route('user.index')->with('error', 'Gagal diperbarui');
        }
    }

    public function reset(Request $request)
    {
        $id = $request->reset_id;
        User::wherekey($id)->update(['password' => bcrypt('password')]);
        return redirect()->back()->with('success', 'Password Berhasil direset!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $auth = Auth::user()->user_id;
        if($request->delete_id === $auth){
            return redirect()->back()->with('error', 'Pengguna Gagal dihapus!.');
        }
        $delete = User::wherekey($request->delete_id)->delete();
        if ($delete) {
            return redirect()->route('user.index')->with('success', 'Pengguna Berhasil dihapus!.');
        }
        return redirect()->back()->with('error', 'Pengguna Gagal dihapus!.');
    }
}
