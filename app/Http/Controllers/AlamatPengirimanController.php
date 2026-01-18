<?php

namespace App\Http\Controllers;

use App\Models\AlamatPengiriman;
use Illuminate\Http\Request;

class AlamatPengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $itemuser = $request->user();
        $itemalamat = AlamatPengiriman::where('user_id', $itemuser->id)->paginate(10);
        $data = array(
            'title' => 'Alamat Pengiriman',
            'itemalamat' => $itemalamat
        );
        return view('alamatpengiriman.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required',
            'no_tlp' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'kode_pos' => 'required',
        ]);
        $itemuser = $request->user();
        $inputan = $request->all();
        $inputan['user_id'] = $itemuser->id;
        $inputan['status'] = 'biasa';
        AlamatPengiriman::create($inputan);
        return back()->with('success', 'Alamat berhasil disimpan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $itemalamat = AlamatPengiriman::findOrFail($id);
        $itemalamat->update(['status' => 'utama']);
        AlamatPengiriman::where('id', '!=', $id)
            ->where('user_id', $request->user()->id)
            ->update(['status' => 'biasa']);
        return back()->with('success', 'Alamat utama berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $itemalamat = AlamatPengiriman::findOrFail($id);
        $itemalamat->delete();
        return back()->with('success', 'Alamat berhasil dihapus');
    }
}
