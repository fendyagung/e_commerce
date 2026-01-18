<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $itemkategori = Kategori::orderBy('created_at', 'desc')->paginate(20);
        $data = array(
            'title' => 'Kategori Produk',
            'itemkategori' => $itemkategori
        );
        return view('kategori.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = array('title' => 'Form Kategori');
        return view('kategori.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|unique:kategoris',
            'nama_kategori' => 'required',
            'slug_kategori' => 'required',
        ]);

        $inputan = $request->all();
        $inputan['status'] = 'publish';
        $inputan['user_id'] = auth()->id();

        $itemkategori = Kategori::create($inputan);

        return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $itemkategori = Kategori::findOrFail($id);
        $data = array(
            'title' => 'Detail Kategori',
            'itemkategori' => $itemkategori
        );
        return view('kategori.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $itemkategori = Kategori::findOrFail($id);
        $data = array(
            'title' => 'Form Edit Kategori',
            'itemkategori' => $itemkategori
        );
        return view('kategori.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_kategori' => 'required|unique:kategoris,kode_kategori,' . $id,
            'nama_kategori' => 'required',
            'slug_kategori' => 'required',
        ]);

        $itemkategori = Kategori::findOrFail($id);
        $inputan = $request->all();
        $inputan['user_id'] = auth()->id();

        $itemkategori->update($inputan);

        return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $itemkategori = Kategori::findOrFail($id);

            \DB::transaction(function () use ($itemkategori) {
                // Hapus semua produk dalam kategori ini beserta dependensinya
                foreach ($itemkategori->produk as $produk) {
                    // Hapus detail keranjang yang terkait dengan produk ini
                    \DB::table('cart_details')->where('produk_id', $produk->id)->delete();

                    // Hapus promo terkait produk ini
                    $produk->promos()->delete();

                    // Hapus gallery images terkait produk ini
                    foreach ($produk->images as $image) {
                        if ($image->foto) {
                            Storage::disk('public')->delete($image->foto);
                        }
                        $image->delete();
                    }

                    // Hapus foto utama produk
                    if ($produk->foto) {
                        Storage::disk('public')->delete($produk->foto);
                    }

                    $produk->delete();
                }

                // Hapus foto kategori
                if ($itemkategori->foto) {
                    Storage::disk('public')->delete($itemkategori->foto);
                }

                $itemkategori->delete();
            });

            return back()->with('success', 'Data kategori berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }

    public function uploadimage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kategori_id' => 'required',
        ]);
        $itemuser = $request->user();
        $itemkategori = Kategori::where('id', $request->kategori_id)
            ->first();
        if ($itemkategori) {
            $fileupload = $request->file('image');
            $folder = 'assets/images';
            $itemgambar = (new ImageController)->upload($fileupload, $itemuser, $folder);
            $inputan['foto'] = $itemgambar->url;//ambil url file yang barusan diupload
            $itemkategori->update($inputan);
            return back()->with('success', 'Image berhasil diupload');
        } else {
            return back()->with('error', 'Kategori tidak ditemukan');
        }
    }

    public function deleteimage(Request $request, $id)
    {
        $itemuser = $request->user();
        $itemkategori = Kategori::where('id', $id)
            ->first();
        if ($itemkategori) {
            // kita cari dulu database berdasarkan url gambar
            $itemgambar = \App\Models\Image::where('url', $itemkategori->foto)->first();
            // hapus imagenya
            if ($itemgambar) {
                Storage::delete($itemgambar->url);
                $itemgambar->delete();
            }
            // baru update foto kategori
            $itemkategori->update(['foto' => null]);
            return back()->with('success', 'Data berhasil dihapus');
        } else {
            return back()->with('error', 'Data tidak ditemukan');
        }
    }
}
