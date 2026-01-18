@extends('layouts.template')
@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col col-md-8">
                <div class="card">
                    @if($produk->foto)
                        <img src="{{ \Storage::url($produk->foto) }}" alt="{{ $produk->nama_produk }}" class="card-img-top">
                    @else
                        <img src="{{ asset('images/slide1.jpg') }}" alt="{{ $produk->nama_produk }}" class="card-img-top">
                    @endif
                </div>
            </div>
            <div class="col col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <span class="badge badge-info mb-2">{{ $produk->kategori->nama_kategori }}</span>
                        <h4 class="card-title font-weight-bold">{{ $produk->nama_produk }}</h4>

                        <div class="price-section my-4">
                            @if($produk->promos->count() > 0)
                                @php $itempromo = $produk->promos->first(); @endphp
                                <p class="card-text">
                                    <del class="text-muted">Rp. {{ number_format($itempromo->harga_awal) }}</del><br />
                                    <span class="text-danger h3 font-weight-bold">Rp.
                                        {{ number_format($itempromo->harga_akhir) }}</span>
                                </p>
                            @else
                                <p class="card-text h3 font-weight-bold">
                                    Rp. {{ number_format($produk->harga) }}
                                </p>
                            @endif
                        </div>

                        <hr>

                        <form action="{{ route('cartdetail.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                            <div class="form-group mb-4">
                                <label for="qty" class="text-muted small font-weight-bold">JUMLAH</label>
                                <div class="input-group" style="width: 140px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="var q = document.getElementById('qty'); if(q.value > 1) q.value--;">-</button>
                                    </div>
                                    <input type="number" name="qty" id="qty" class="form-control text-center" value="1"
                                        min="1">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="var q = document.getElementById('qty'); q.value++;">+</button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-primary btn-block py-2 font-weight-bold" type="submit">
                                    <i class="fas fa-shopping-cart mr-2"></i> Tambahkan Ke Keranjang
                                </button>
                                <button class="btn btn-outline-danger btn-block py-2 font-weight-bold mt-2" type="button">
                                    <i class="fas fa-heart mr-2"></i> Tambah ke Wishlist
                                </button>
                                <button class="btn btn-danger btn-block py-2 font-weight-bold mt-2" type="submit"
                                    name="buy_now" value="1">
                                    Beli Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-4 shadow-sm border-0">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col">
                                <i class="fas fa-truck text-primary mb-2"></i><br>
                                <small class="font-weight-bold">Pengiriman<br>Cepat</small>
                            </div>
                            <div class="col">
                                <i class="fas fa-undo text-primary mb-2"></i><br>
                                <small class="font-weight-bold">Garansi 7<br>hari</small>
                            </div>
                            <div class="col">
                                <i class="fas fa-shield-alt text-primary mb-2"></i><br>
                                <small class="font-weight-bold">Pembayaran<br>Aman</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Deskripsi
                    </div>
                    <div class="card-body">
                        <p>{{ $produk->deskripsi_produk }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection