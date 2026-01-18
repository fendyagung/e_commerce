@extends('layouts.template')
@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
            </div>
        </div>

        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Order Summary -->
                <div class="col-md-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom-0 pb-0">
                            <h5 class="mb-0">Item</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Produk</th>
                                            <th class="text-right">Harga</th>
                                            <th class="text-right">Diskon</th>
                                            <th class="text-right">Qty</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($itemcart->detail as $detail)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>
                                                    {{ $detail->produk->nama_produk }}<br>
                                                    <small class="text-muted">{{ $detail->produk->kode_produk }}</small>
                                                </td>
                                                <td class="text-right">{{ number_format($detail->harga, 2) }}</td>
                                                <td class="text-right">{{ number_format($detail->diskon, 2) }}</td>
                                                <td class="text-right">{{ number_format($detail->qty, 2) }}</td>
                                                <td class="text-right font-weight-bold">
                                                    {{ number_format($detail->subtotal, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom-0 pb-0">
                            <h5 class="mb-0">Alamat Pengiriman</h5>
                        </div>
                        <div class="card-body">
                            @if($itemalamat->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>Nama Penerima</th>
                                                <th>Alamat</th>
                                                <th>No tlp</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                // Ambil alamat utama, jika tidak ada ambil yang pertama
                                                $alamat_utama = $itemalamat->where('status', 'utama')->first();
                                                if (!$alamat_utama && $itemalamat->count() > 0) {
                                                    $alamat_utama = $itemalamat->first();
                                                }
                                            @endphp

                                            @if($alamat_utama)
                                                <tr>
                                                    <td>{{ $alamat_utama->nama_penerima }}</td>
                                                    <td>
                                                        {{ $alamat_utama->alamat }}<br>
                                                        {{ $alamat_utama->kota }}, {{ $alamat_utama->provinsi }}<br>
                                                        {{ $alamat_utama->provinsi }} - {{ $alamat_utama->kode_pos }}
                                                    </td>
                                                    <td>{{ $alamat_utama->no_tlp }}</td>
                                                    <td class="text-right">
                                                        <input type="hidden" name="alamat_pengiriman_id"
                                                            value="{{ $alamat_utama->id }}">
                                                        <a href="{{ route('alamatpengiriman.index') }}"
                                                            class="btn btn-success btn-sm">Ubah Alamat</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    Anda belum memiliki alamat pengiriman.
                                </div>
                            @endif
                            <div class="mt-3">
                                <a href="{{ route('alamatpengiriman.index') }}" class="btn btn-primary btn-sm">Tambah
                                    Alamat</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checkout Summary -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Ringkasan</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-between">
                                <span class="text-muted">No Invoice</span>
                                <span>{{ $itemcart->no_invoice }}</span>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <span class="text-muted">Subtotal</span>
                                <span>{{ number_format($itemcart->subtotal, 2) }}</span>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <span class="text-muted">Diskon</span>
                                <span>{{ number_format($itemcart->diskon, 2) }}</span>
                            </div>
                            <div class="mb-4 d-flex justify-content-between">
                                <span class="text-muted">Total</span>
                                <span class="font-weight-bold">{{ number_format($itemcart->total, 2) }}</span>
                            </div>

                            <!-- Hidden input for ekspedisi to pass validation -->
                            <input type="hidden" name="ekspedisi" value="JNE">

                            <button type="submit" class="btn btn-danger btn-block font-weight-bold" {{ $itemalamat->count() == 0 ? 'disabled' : '' }}>
                                Buat Pesanan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection