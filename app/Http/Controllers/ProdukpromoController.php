<?php

namespace App\Http\Controllers;

use App\Models\ProdukPromo;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukPromoController extends Controller
{
    // Menampilkan daftar promo
    public function index(Request $request)
    {
        $itempromo = ProdukPromo::orderBy('id', 'desc')->paginate(20);
        $data = array(
            'title' => 'Produk Promo',
            'itempromo' => $itempromo
        );
        return view('promo.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
    }

    // Menampilkan form tambah promo
    public function create()
    {
        $itemproduk = Produk::orderBy('nama_produk', 'desc')->get();
        $data = array(
            'title' => 'Form Tambah Produk Promo',
            'itemproduk' => $itemproduk
        );
        return view('promo.create', $data);
    }

    // Menyimpan promo baru
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'harga_awal' => 'required',
            'harga_akhir' => 'required',
            'diskon_persen' => 'required',
            'diskon_nominal' => 'required',
        ]);

        $cekpromo = ProdukPromo::where('produk_id', $request->produk_id)->first();
        if ($cekpromo) {
            return back()->with('error', 'Data sudah ada');
        } else {
            $itemuser = $request->user();
            $inputan = $request->all();
            $inputan['user_id'] = $itemuser->id;
            ProdukPromo::create($inputan);
            return redirect()->route('promo.index')->with('success', 'Data berhasil disimpan');
        }
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $itempromo = ProdukPromo::findOrFail($id);
        $data = array(
            'title' => 'Form Edit Produk Promo',
            'itempromo' => $itempromo
        );
        return view('promo.edit', $data);
    }

    // Memperbarui data promo
    public function update(Request $request, $id)
    {
        $request->validate([
            'produk_id' => 'required',
            'harga_awal' => 'required',
            'harga_akhir' => 'required',
            'diskon_persen' => 'required',
            'diskon_nominal' => 'required',
        ]);

        $itempromo = ProdukPromo::findOrFail($id);
        $cekpromo = ProdukPromo::where('produk_id', $request->produk_id)
            ->where('id', '!=', $itempromo->id)
            ->first();

        if ($cekpromo) {
            return back()->with('error', 'Data sudah ada');
        } else {
            $itemuser = $request->user();
            $inputan = $request->all();
            $inputan['user_id'] = $itemuser->id;
            $itempromo->update($inputan);
            return redirect()->route('promo.index')->with('success', 'Data berhasil diupdate');
        }
    }

    // Menghapus promo
    public function destroy($id)
    {
        try {
            $itempromo = ProdukPromo::findOrFail($id);
            \DB::transaction(function () use ($itempromo) {
                // Promo biasanya tidak punya child, tapi kita pastikan data bersih
                $itempromo->delete();
            });
            return back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}