@extends('layouts.dashboard')
@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col col-lg-8 col-md-8 mb-2">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Item</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>
                      No
                    </th>
                    <th>
                      Kode
                    </th>
                    <th>
                      Nama
                    </th>
                    <th>
                      Harga
                    </th>
                    <th>
                      Qty
                    </th>
                    <th>
                      Subtotal
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($order->detail as $detail)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $detail->produk->kode_produk }}</td>
                      <td>{{ $detail->produk->nama_produk }}</td>
                      <td class="text-right">{{ number_format($detail->harga, 2) }}</td>
                      <td class="text-right">{{ number_format($detail->qty, 2) }}</td>
                      <td class="text-right">{{ number_format($detail->subtotal, 2) }}</td>
                    </tr>
                  @endforeach
                  <tr>
                    <td colspan="5">
                      <b>Total</b>
                    </td>
                    <td class="text-right">
                      <b>{{ number_format($order->subtotal, 2) }}</b>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-danger">Tutup</a>
          </div>
        </div>
      </div>
      <div class="col col-lg-4 col-md-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Ringkasan</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <form action="{{ route('transaksi.update', $order->id) }}" method="post">
                  @csrf
                  @method('patch')
                  <tbody>
                    <tr>
                      <td>Total</td>
                      <td><input type="text" name="total" id="total" class="form-control" value="{{ $order->total }}">
                      </td>
                    </tr>
                    <tr>
                      <td>Subtotal</td>
                      <td><input type="text" name="subtotal" id="subtotal" class="form-control"
                          value="{{ $order->subtotal }}"></td>
                    </tr>
                    <tr>
                      <td>Diskon</td>
                      <td><input type="text" name="diskon" id="diskon" class="form-control" value="{{ $order->diskon }}">
                      </td>
                    </tr>
                    <tr>
                      <td>Ongkir</td>
                      <td><input type="text" name="ongkir" id="ongkir" class="form-control" value="{{ $order->ongkir }}">
                      </td>
                    </tr>
                    <tr>
                      <td>Ekspedisi</td>
                      <td><input type="text" name="ekspedisi" id="ekspedisi" class="form-control"
                          value="{{ $order->ekspedisi }}"></td>
                    </tr>
                    <tr>
                      <td>No. Resi</td>
                      <td><input type="text" name="no_resi" id="no_resi" class="form-control"
                          value="{{ $order->no_resi }}"></td>
                    </tr>
                    <tr>
                      <td>Status Pembayaran</td>
                      <td>
                        <select name="status_pembayaran" id="status_pembayaran" class="form-control">
                          <option value="sudah" {{ $order->status_pembayaran == 'sudah' ? 'selected' : '' }}>Sudah Dibayar
                          </option>
                          <option value="belum" {{ $order->status_pembayaran == 'belum' ? 'selected' : '' }}>Belum Dibayar
                          </option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>Status</td>
                      <td>
                        <select name="status" id="status" class="form-control">
                          <option value="menunggu" {{ $order->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                          <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                          <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                          <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                          <option value="batal" {{ $order->status == 'batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td><button type="submit" class="btn btn-primary">Update</button></td>
                    </tr>
                  </tbody>
                </form>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection