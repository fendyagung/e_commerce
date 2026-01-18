@extends('layouts.dashboard')
@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header bg-white">
            <h3 class="card-title">Data Transaksi</h3>
          </div>
          <div class="card-body">
            @if ($message = Session::get('success'))
              <div class="alert alert-success">
                {{ $message }}
              </div>
            @endif

            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Sub Total</th>
                    <th>Diskon</th>
                    <th>Ongkir</th>
                    <th>Total</th>
                    <th>Status Pembayaran</th>
                    <th>Status Pengiriman</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($itemorder as $order)
                    <tr>
                      <td>{{ $loop->iteration + $itemorder->firstItem() - 1 }}</td>
                      <td>{{ $order->no_invoice }}</td>
                      <td>{{ number_format($order->subtotal, 2) }}</td>
                      <td>{{ number_format($order->diskon, 2) }}</td>
                      <td>{{ number_format($order->ongkir, 2) }}</td>
                      <td>{{ number_format($order->total, 2) }}</td>
                      <td>{{ $order->status_pembayaran }}</td>
                      <td>{{ $order->status }}</td>
                      <td>
                        <a href="{{ route('transaksi.show', $order->id) }}" class="btn btn-sm btn-info">Detail</a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="mt-3">
                {{ $itemorder->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection