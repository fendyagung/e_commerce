@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col col-lg-4 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Kategori</h3>
                        <div class="card-tools">
                            <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-danger">
                                Tutup
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Kode Kategori</td>
                                    <td>{{ $itemkategori->kode_kategori }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Kategori</td>
                                    <td>{{ $itemkategori->nama_kategori }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>{{ $itemkategori->status }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-lg-8 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Produk dalam Kategori</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($itemkategori->produk as $index => $produk)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $produk->kode_produk }}</td>
                                            <td>{{ $produk->nama_produk }}</td>
                                            <td>{{ $produk->qty }} {{ $produk->satuan }}</td>
                                            <td>Rp. {{ number_format($produk->harga, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection