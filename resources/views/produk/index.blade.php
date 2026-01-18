@extends('layouts.dashboard')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Produk</h3>
            <div class="card-tools">
              <a href="{{ route('produk.create') }}" class="btn btn-sm btn-primary">
                Baru
              </a>
            </div>
          </div>
          <div class="card-body">
            <form action="#">
              <div class="row">
                <div class="col">
                  <input type="text" name="keyword" id="keyword" class="form-control" placeholder="ketik keyword di sini"
                    value="{{ $keyword }}">
                </div>
                <div class="col-auto">
                  <button type="submit" class="btn btn-primary">
                    Cari
                  </button>
                </div>
              </div>
            </form>
          </div>
          <div class="card-body">
            @if ($message = Session::get('success'))
              <div class="alert alert-success">
                <p>{{ $message }}</p>
              </div>
            @endif
            @if ($message = Session::get('error'))
              <div class="alert alert-warning">
                <p>{{ $message }}</p>
              </div>
            @endif
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th width="50px">No</th>
                    <th>Gambar</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($itemproduk as $produk)
                    <tr>
                      <td>{{ ++$no }}</td>
                      <td>
                        @if($produk->foto)
                          <img src="{{ \Storage::url($produk->foto) }}" alt="{{ $produk->nama_produk }}" width="50px">
                        @else
                          <img src="{{ asset('images/no-image.png') }}" alt="no image" width="50px">
                        @endif
                      </td>
                      <td>{{ $produk->kode_produk }}</td>
                      <td>{{ $produk->nama_produk }}</td>
                      <td>{{ $produk->kategori->nama_kategori }}</td>
                      <td>{{ $produk->qty }} {{ $produk->satuan }}</td>
                      <td>{{ number_format($produk->harga, 2) }}</td>
                      <td>{{ $produk->status }}</td>
                      <td>
                        <a href="{{ route('produk.show', $produk->id) }}" class="btn btn-sm btn-primary">
                          Detail
                        </a>
                        <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-sm btn-primary">
                          Edit
                        </a>
                        <form action="{{ route('produk.destroy', $produk->id) }}" method="post" style="display:inline;">
                          @csrf
                          {{ method_field('delete') }}
                          <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                            Hapus
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              {{ $itemproduk->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection