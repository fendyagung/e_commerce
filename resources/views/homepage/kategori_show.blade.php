@extends('layouts.template')
@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col col-md-12 col-sm-12 mb-4">
                <h2 class="text-center">{{ $kategori->nama_kategori }}</h2>
            </div>
            @foreach($itemproduk as $produk)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <a href="{{ route('produk.detail', $produk->slug_produk) }}">
                            @if($produk->foto)
                                <img src="{{ \Storage::url($produk->foto) }}" alt="{{ $produk->nama_produk }}" class="card-img-top">
                            @else
                                <img src="{{ asset('images/bag.jpg') }}" alt="{{ $produk->nama_produk }}" class="card-img-top">
                            @endif
                        </a>
                        <div class="card-body">
                            <a href="{{ route('produk.detail', $produk->slug_produk) }}" class="text-decoration-none">
                                <p class="card-text">
                                    {{ $produk->nama_produk }}
                                </p>
                            </a>
                            <div class="row mt-4">
                                <div class="col">
                                    <button class="btn btn-light">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                                <div class="col-auto">
                                    <p>
                                        Rp. {{ number_format($produk->harga, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-md-12">
                {{ $itemproduk->links() }}
            </div>
        </div>
    </div>
@endsection