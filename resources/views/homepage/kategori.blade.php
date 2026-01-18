@extends('layouts.template')
@section('content')
  <div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kategori</li>
      </ol>
    </nav>

    <!-- Kategori Produk -->
    <div class="row mt-4">
      <div class="col col-md-12 col-sm-12 mb-4">
        <h2 class="text-center">Kategori Produk</h2>
        <p class="text-center text-muted">Pilih kategori untuk melihat produk</p>
      </div>
      @forelse($itemkategori as $kategori)
        <div class="col-md-4 col-sm-6">
          <div class="card mb-4 shadow-sm">
            <a href="{{ route('kategori.detail', $kategori->slug_kategori) }}">
              @if($kategori->foto)
                <img src="{{ \Storage::url($kategori->foto) }}" alt="{{ $kategori->nama_kategori }}" class="card-img-top"
                  style="height: 200px; object-fit: cover;">
              @else
                <img src="{{ asset('images/bag.jpg') }}" alt="{{ $kategori->nama_kategori }}" class="card-img-top"
                  style="height: 200px; object-fit: cover;">
              @endif
            </a>
            <div class="card-body text-center">
              <a href="{{ route('kategori.detail', $kategori->slug_kategori) }}" class="text-decoration-none">
                <h5 class="card-title">{{ $kategori->nama_kategori }}</h5>
              </a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-info text-center">
            Belum ada kategori tersedia.
          </div>
        </div>
      @endforelse
    </div>
    <!-- End Kategori Produk -->

    <hr class="my-4">

    <!-- Produk Terbaru -->
    <div class="row mt-4">
      <div class="col col-md-12 col-sm-12 mb-4">
        <h2 class="text-center">Produk Terbaru</h2>
        <p class="text-center text-muted">Koleksi produk terbaru kami</p>
      </div>
      @forelse($itemproduk as $produk)
        <div class="col-md-4 col-sm-6">
          <div class="card mb-4 shadow-sm">
            <a href="{{ route('produk.detail', $produk->id) }}">
              @if($produk->foto)
                <img src="{{ \Storage::url($produk->foto) }}" alt="{{ $produk->nama_produk }}" class="card-img-top"
                  style="height: 200px; object-fit: cover;">
              @else
                <img src="{{ asset('images/bag.jpg') }}" alt="{{ $produk->nama_produk }}" class="card-img-top"
                  style="height: 200px; object-fit: cover;">
              @endif
            </a>
            <div class="card-body">
              <a href="{{ route('produk.detail', $produk->id) }}" class="text-decoration-none">
                <h6 class="card-title text-dark">{{ $produk->nama_produk }}</h6>
              </a>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="text-primary font-weight-bold">Rp. {{ number_format($produk->harga, 0, ',', '.') }}</span>
                <button class="btn btn-outline-danger btn-sm">
                  <i class="far fa-heart"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-info text-center">
            Belum ada produk tersedia.
          </div>
        </div>
      @endforelse
    </div>
    <!-- End Produk Terbaru -->

    <!-- Lihat Semua Produk -->
    <div class="row mb-4">
      <div class="col-12 text-center">
        <a href="{{ route('homepage.produk') }}" class="btn btn-primary">
          Lihat Semua Produk <i class="fas fa-arrow-right ml-2"></i>
        </a>
      </div>
    </div>
  </div>
@endsection