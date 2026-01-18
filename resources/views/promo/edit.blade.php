@extends('layouts.dashboard')
@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col col-lg-6 col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
            <div class="card-tools">
              <a href="{{ route('promo.index') }}" class="btn btn-sm btn-danger">
                Tutup
              </a>
            </div>
          </div>
          <div class="card-body">
            @if(count($errors) > 0)
              @foreach($errors->all() as $error)
                <div class="alert alert-warning">{{ $error }}</div>
              @endforeach
            @endif
            @if ($message = Session::get('error'))
              <div class="alert alert-warning">
                <p>{{ $message }}</p>
              </div>
            @endif
            @if ($message = Session::get('success'))
              <div class="alert alert-success">
                <p>{{ $message }}</p>
              </div>
            @endif
            <form action="{{ route('promo.update', $itempromo->id) }}" method="post">
              @csrf
              {{ method_field('patch') }}
              <div class="form-group">
                <label for="produk_id">Produk</label>
                <input type="text" class="form-control"
                  value="{{ $itempromo->produk->nama_produk }} - {{ $itempromo->produk->kode_produk }}" readonly>
                <input type="hidden" name="produk_id" value="{{ $itempromo->produk_id }}">
              </div>
              <div class="form-group">
                <label for="harga_awal">Harga Awal</label>
                <input type="number" name="harga_awal" id="harga_awal" class="form-control"
                  value="{{ $itempromo->harga_awal }}" readonly required>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="diskon_persen">Diskon (%)</label>
                    <input type="number" name="diskon_persen" id="diskon_persen" class="form-control"
                      value="{{ $itempromo->diskon_persen }}" required>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="diskon_nominal">Diskon (Nominal)</label>
                    <input type="number" name="diskon_nominal" id="diskon_nominal" class="form-control"
                      value="{{ $itempromo->diskon_nominal }}" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="harga_akhir">Harga Akhir</label>
                <input type="number" name="harga_akhir" id="harga_akhir" class="form-control"
                  value="{{ $itempromo->harga_akhir }}" readonly required>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="reset" class="btn btn-warning">Reset</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // cari nominal diskon berdasarkan persen
    $('#diskon_persen').on('keyup mouseup', function () {
      var harga_awal = parseFloat($('#harga_awal').val()) || 0;
      var diskon_persen = parseFloat($(this).val()) || 0;
      var diskon_nominal = (diskon_persen / 100) * harga_awal;
      $('#diskon_nominal').val(diskon_nominal.toFixed(0));
      calculatePrice();
    });

    // cari persen diskon berdasarkan nominal
    $('#diskon_nominal').on('keyup mouseup', function () {
      var harga_awal = parseFloat($('#harga_awal').val()) || 0;
      var diskon_nominal = parseFloat($(this).val()) || 0;
      var diskon_persen = 0;
      if (harga_awal > 0) {
        diskon_persen = (diskon_nominal / harga_awal) * 100;
      }
      $('#diskon_persen').val(diskon_persen.toFixed(2));
      calculatePrice();
    });

    function calculatePrice() {
      var harga_awal = parseFloat($('#harga_awal').val()) || 0;
      var diskon_nominal = parseFloat($('#diskon_nominal').val()) || 0;
      var harga_akhir = harga_awal - diskon_nominal;
      $('#harga_akhir').val(harga_akhir.toFixed(0));
    }
  </script>
@endsection