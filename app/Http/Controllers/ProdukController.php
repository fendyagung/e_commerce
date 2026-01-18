<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\ProdukImage; // Import model ProdukImage
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');

        if ($keyword) {
            $itemproduk = Produk::where('nama_produk', 'LIKE', "%$keyword%")
                ->orWhere('kode_produk', 'LIKE', "%$keyword%")
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } else {
            $itemproduk = Produk::orderBy('created_at', 'desc')->paginate(20);
        }

        $data = array(
            'title' => 'Produk',
            'itemproduk' => $itemproduk,
            'keyword' => $keyword
        );

        return view('produk.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $itemkategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        $data = array(
            'title' => 'Form Produk Baru',
            'itemkategori' => $itemkategori
        );
        return view('produk.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produk',
            'nama_produk' => 'required',
            'slug_produk' => 'required',
            'kategori_id' => 'required',
            'qty' => 'required|numeric',
            'satuan' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $itemuser = $request->user();
        $inputan = $request->all();
        $inputan['user_id'] = $itemuser->id;
        $inputan['status'] = 'publish';

        if ($request->hasFile('foto')) {
            $fileupload = $request->file('foto');
            $path = $fileupload->store('assets/images', 'public');
            $inputan['foto'] = $path;
        }

        $itemproduk = Produk::create($inputan);

        return redirect()->route('produk.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     * Mengambil produk beserta relasi images-nya
     */
    public function show($id)
    {
        $itemproduk = Produk::with('images')->findOrFail($id);
        $data = array(
            'title' => 'Foto Produk',
            'itemproduk' => $itemproduk
        );

        return view('produk.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $itemproduk = Produk::findOrFail($id);
        $itemkategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        $data = array(
            'title' => 'Form Edit Produk',
            'itemproduk' => $itemproduk,
            'itemkategori' => $itemkategori
        );
        return view('produk.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'slug_produk' => 'required',
            'kategori_id' => 'required',
            'qty' => 'required|numeric',
            'satuan' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $itemproduk = Produk::findOrFail($id);
        $inputan = $request->all();

        if ($request->hasFile('foto')) {
            // hapus foto lama
            if ($itemproduk->foto) {
                Storage::disk('public')->delete($itemproduk->foto);
            }
            $fileupload = $request->file('foto');
            $path = $fileupload->store('assets/images', 'public');
            $inputan['foto'] = $path;
        }

        $itemproduk->update($inputan);

        return redirect()->route('produk.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $itemproduk = Produk::findOrFail($id);

        // Hapus detail keranjang yang terkait dengan produk ini
        \DB::table('cart_details')->where('produk_id', $itemproduk->id)->delete();

        // Hapus promo terkait (karena tidak ada cascade delete di DB)
        $itemproduk->promos()->delete();

        // Hapus gallery images terkait (karena tidak ada cascade delete di DB)
        foreach ($itemproduk->images as $image) {
            if ($image->foto) {
                Storage::disk('public')->delete($image->foto);
            }
            $image->delete();
        }

        // Hapus foto utama
        if ($itemproduk->foto) {
            Storage::disk('public')->delete($itemproduk->foto);
        }

        if ($itemproduk->delete()) {
            return back()->with('success', 'Data berhasil dihapus');
        } else {
            return back()->with('error', 'Data gagal dihapus');
        }
    }

    /**
     * Fungsi untuk menyimpan gambar ke tabel produk_images
     */
    public function uploadimage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'produk_id' => 'required',
        ]);

        $produk_id = $request->produk_id;
        $fileupload = $request->file('image');
        $path = $fileupload->store('assets/images', 'public');

        $inputan['produk_id'] = $produk_id;
        $inputan['foto'] = $path;

        ProdukImage::create($inputan);

        return back()->with('success', 'Image berhasil diupload');
    }

    /**
     * Fungsi untuk menghapus gambar dari tabel produk_images
     */
    public function deleteimage($id)
    {
        $itemimage = ProdukImage::findOrFail($id);

        // Hapus file fisik dari storage
        Storage::disk('public')->delete($itemimage->foto);

        // Hapus data dari database
        $itemimage->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    /**
     * Mengambil data produk secara asynchronous untuk fitur promo
     */
    public function loadasync($id)
    {
        $itemproduk = Produk::findOrFail($id);
        $respon = [
            'status' => 'success',
            'msg' => 'Data ditemukan',
            'itemproduk' => $itemproduk
        ];
        return response()->json($respon, 200);
    }
}