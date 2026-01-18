<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $itemproduk = \App\Models\Produk::orderBy('created_at', 'desc')->limit(5)->get();
        $produkCount = \App\Models\Produk::count();
        $kategoriCount = \App\Models\Kategori::count();
        $userCount = \App\Models\User::where('role', 'user')->count();

        $data = array(
            'title' => 'Dashboard',
            'itemproduk' => $itemproduk,
            'produkCount' => $produkCount,
            'kategoriCount' => $kategoriCount,
            'userCount' => $userCount
        );
        return view('dashboard.index', $data);
    }
}
