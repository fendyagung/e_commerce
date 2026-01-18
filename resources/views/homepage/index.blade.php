@extends('layouts.template')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col">
        <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="3000">
          <div class="carousel-inner">
            @foreach($itemslide as $index => $slide)
              @if($index == 0)
                <div class="carousel-item active">
                  <img src="{{ \Storage::url($slide->foto) }}" class="d-block w-100" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>{{ $slide->caption_title }}</h5>
                    <p>{{ $slide->caption_content }}</p>
                  </div>
                </div>
              @else
                <div class="carousel-item">
                  <img src="{{ \Storage::url($slide->foto) }}" class="d-block w-100" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>{{ $slide->caption_title }}</h5>
                    <p>{{ $slide->caption_content }}</p>
                  </div>
                </div>
              @endif
            @endforeach
          </div>
          <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col col-md-12 col-sm-12 mb-4">
        <h2 class="text-center">Kategori Produk</h2>
      </div>
      @foreach($itemkategori as $kategori)
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <a href="{{ route('kategori.detail', $kategori->slug_kategori) }}">
              @if($kategori->foto != null)
                <img src="{{ \Storage::url($kategori->foto) }}" alt="{{ $kategori->nama_kategori }}" class="card-img-top">
              @else
                <img src="{{ asset('images/bag.jpg') }}" alt="{{ $kategori->nama_kategori }}" class="card-img-top">
              @endif
            </a>
            <div class="card-body">
              <a href="{{ route('kategori.detail', $kategori->slug_kategori) }}" class="text-decoration-none">
                <p class="card-text">{{ $kategori->nama_kategori }}</p>
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="row mt-4">
      <div class="col col-md-12 col-sm-12 mb-4">
        <h2 class="text-center">Promo</h2>
      </div>
      @foreach($itempromo as $promo)
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <a href="{{ route('produk.detail', $promo->produk->id) }}">
              @if($promo->produk->foto != null)
                <img src="{{ \Storage::url($promo->produk->foto) }}" alt="{{ $promo->produk->nama_produk }}"
                  class="card-img-top">
              @else
                <img src="{{ asset('images/bag.jpg') }}" alt="{{ $promo->produk->nama_produk }}" class="card-img-top">
              @endif
            </a>
            <div class="card-body">
              <a href="{{ route('produk.detail', $promo->produk->id) }}" class="text-decoration-none">
                <p class="card-text">
                  {{ $promo->produk->nama_produk }}
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
                    <del>Rp. {{ number_format($promo->harga_awal, 2) }}</del>
                    <br />
                    Rp. {{ number_format($promo->harga_akhir, 2) }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="row mt-4">
      <div class="col col-md-12 col-sm-12 mb-4">
        <h2 class="text-center">Terbaru</h2>
      </div>
      @foreach($itemproduk as $produk)
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <a href="{{ route('produk.detail', $produk->id) }}">
              @if($produk->foto != null)
                <img src="{{ \Storage::url($produk->foto) }}" alt="{{ $produk->nama_produk }}" class="card-img-top">
              @else
                <img src="{{ asset('images/bag.jpg') }}" alt="{{ $produk->nama_produk }}" class="card-img-top">
              @endif
            </a>
            <div class="card-body">
              <a href="{{ route('produk.detail', $produk->id) }}" class="text-decoration-none">
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
    </div>
    <hr>
    <div class="row mt-4">
      <div class="col">
        <h5 class="text-center">Toko Online Menggunakan Laravel</h5>
        <p>
          Toko adalah demo membangun toko online menggunakan laravel framework. Di dalam demo ini terdapat user bisa
          menginput
          Lorem, ipsum dolor sit amet consectetur adipisicing elit. Hic laborum aliquam dolorum sequi nulla maiores quos
          incidunt.
        </p>
        <p>
          Toko adalah demo membangun toko online menggunakan laravel framework. Di dalam demo ini terdapat user bisa
          menginput
          Lorem, ipsum dolor sit amet consectetur adipisicing elit. Hic laborum aliquam dolorum sequi nulla maiores quos
          incidunt.
        </p>
        <p class="text-center">
          <a href="{{ route('about') }}" class="btn btn-outline-secondary">
            Baca Selengkapnya
          </a>
        </p>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      if (typeof $ !== 'undefined') {
        $('#carousel').carousel({
          interval: 3000,
          pause: false
        });
      }
    });
  </script>
@endsection