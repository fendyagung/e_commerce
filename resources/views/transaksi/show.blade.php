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
                <tbody>
                  <tr>
                    <td>Total</td>
                    <td>{{ number_format($order->total, 2) }}</td>
                  </tr>
                  <tr>
                    <td>Subtotal</td>
                    <td>{{ number_format($order->subtotal, 2) }}</td>
                  </tr>
                  <tr>
                    <td>Diskon</td>
                    <td>{{ number_format($order->diskon, 2) }}</td>
                  </tr>
                  <tr>
                    <td>Ongkir</td>
                    <td>{{ number_format($order->ongkir, 2) }}</td>
                  </tr>
                  <tr>
                    <td>Ekspedisi</td>
                    <td>{{ $order->ekspedisi }}</td>
                  </tr>
                  <tr>
                    <td>No. Resi</td>
                    <td>{{ $order->no_resi }}</td>
                  </tr>
                  <tr>
                    <td>Status Pembayaran</td>
                    <td>{{ $order->status_pembayaran == 'sudah' ? 'Sudah dibayar' : 'Belum dibayar' }}</td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td>{{ ucfirst($order->status) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection