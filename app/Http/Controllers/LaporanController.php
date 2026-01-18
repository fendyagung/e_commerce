<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Laporan Penjualan',
        );
        return view('laporan.index', $data);
    }

    public function proses(Request $request)
    {
        $data = array(
            'title' => 'Laporan Penjualan',
            'bulan' => $request->bulan,
            'tahun' => $request->tahun
        );
        return view('laporan.proses', $data);
    }
}
