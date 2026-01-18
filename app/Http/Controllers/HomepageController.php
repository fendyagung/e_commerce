<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Slideshow;
use App\Models\ProdukPromo;

class HomepageController extends Controller
{
    public function index()
    {
        $itemproduk = Produk::orderBy('created_at', 'desc')->limit(6)->get();
        $itempromo = ProdukPromo::orderBy('created_at', 'desc')->limit(6)->get();
        $itemkategori = Kategori::orderBy('nama_kategori', 'asc')->limit(6)->get();
        $itemslide = Slideshow::get();
        $data = array(
            'title' => 'Homepage',
            'itemproduk' => $itemproduk,
            'itempromo' => $itempromo,
            'itemkategori' => $itemkategori,
            'itemslide' => $itemslide,
        );
        return view('homepage.index', $data);
    }

    public function about()
    {
        $data = array('title' => 'Tentang Kami');
        return view('homepage.about', $data);
    }

    public function kontak()
    {
        $data = array('title' => 'Kontak Kami');
        return view('homepage.kontak', $data);
    }

    public function kategori($slug = null)
    {
        // Jika ada slug, tampilkan produk dari kategori tersebut
        if ($slug) {
            $kategori = Kategori::where('slug_kategori', $slug)->firstOrFail();
            $itemproduk = Produk::where('kategori_id', $kategori->id)->orderBy('created_at', 'desc')->paginate(12);
            $itemkategori = Kategori::orderBy('nama_kategori', 'asc')->get();
            $data = array(
                'title' => $kategori->nama_kategori,
                'kategori' => $kategori,
                'itemkategori' => $itemkategori,
                'itemproduk' => $itemproduk,
            );
            return view('homepage.kategori_show', $data);
        }

        // Jika tidak ada slug, tampilkan semua kategori
        $itemkategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        $itemproduk = Produk::orderBy('created_at', 'desc')->limit(6)->get();
        $data = array(
            'title' => 'Kategori Produk',
            'itemkategori' => $itemkategori,
            'itemproduk' => $itemproduk,
        );
        return view('homepage.kategori', $data);
    }

    public function produk()
    {
        $itemproduk = Produk::orderBy('created_at', 'desc')->paginate(12);
        $data = array(
            'title' => 'Semua Produk',
            'itemproduk' => $itemproduk,
        );
        return view('homepage.produk', $data);
    }

    public function produkdetail($id)
    {
        $produk = Produk::findOrFail($id);
        // Ambil produk lain dari kategori yang sama
        $produklainnya = Produk::where('kategori_id', $produk->kategori_id)
            ->where('id', '!=', $produk->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        $data = array(
            'title' => $produk->nama_produk,
            'produk' => $produk,
            'produklainnya' => $produklainnya,
        );
        return view('homepage.produkdetail', $data);
    }
}