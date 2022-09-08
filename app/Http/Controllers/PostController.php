<?php

namespace App\Http\Controllers;

use App\Models\Energi;
use App\Models\Energy;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('backend.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('role_id', 2)->get();
        $energi = Energy::all();
        return view('backend.posts.add', compact('user', 'energi'));
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
            'user_id' => 'required',
            'energi_id' => 'required',
            'nilai_energi' => 'required',
            'date' => 'required',
        ]);
        $post = Post::create($request->all());
        if ($post) {
            return redirect()->route('post.index')->with('success', 'Post berhasil ditambah');
        }
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
        $user = User::where('role_id', 2)->get();
        $energi = Energy::all();
        $post = Post::whereId($id)->first();
        return view('backend.posts.edit', compact('user', 'energi', 'post'));
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
        $request->validate([
            'user_id' => 'required',
            'energi_id' => 'required',
            'nilai_energi' => 'required',
            'date' => 'required',
        ]);
        Post::whereId($id)->update(request()->except(['_token', '_method']));
        return redirect()->route('post.index')->with('success', 'Post berhasil diubah.!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        Post::whereId($request->delete_id)->delete();
        return redirect()->back()->with('success', 'Post berhasil dihapus.!');
    }
}
