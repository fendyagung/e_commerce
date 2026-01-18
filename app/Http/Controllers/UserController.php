<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemuser = $request->user();
        $itemorder = \App\Models\Order::where('user_id', $itemuser->id)->orderBy('created_at', 'desc')->paginate(10);
        $data = array(
            'title' => 'User Profil',
            'itemuser' => $itemuser,
            'itemorder' => $itemorder
        );
        return view('user.index', $data);
    }

    public function setting()
    {
        $data = array('title' => 'Setting Profil');
        return view('user.setting', $data);
    }

    public function updateprofil(Request $request)
    {
        $itemuser = $request->user();
        $itemuser->update($request->only('name', 'phone'));
        return back()->with('success', 'Profil berhasil diupdate');
    }

    public function uploadfoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $itemuser = $request->user();

        // delete foto lama jika ada
        if ($itemuser->foto) {
            \Storage::delete('public/' . $itemuser->foto);
        }

        $path = $request->file('foto')->store('profil', 'public');
        $itemuser->update(['foto' => $path]);
        return back()->with('success', 'Foto profil berhasil diupload');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
