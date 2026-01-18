@extends('layouts.dashboard')
@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col col-lg-4 col-md-4">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              @if($itemuser->foto)
                <img src="{{ asset('storage/' . $itemuser->foto) }}" alt="profil"
                  class="profile-user-img img-responsive img-circle">
              @else
                <img src="{{ asset('img/user2-160x160.jpg') }}" alt="profil"
                  class="profile-user-img img-responsive img-circle">
              @endif
            </div>
            <h3 class="profile-username text-center">{{ $itemuser->name }}</h3>
            <p class="text-muted text-center">Member since : {{ $itemuser->created_at->format('d M Y') }}</p>
            <hr>
            <strong>
              <i class="fas fa-map-marker mr-2"></i>
              Alamat
            </strong>
            <p class="text-muted">
              {{ $itemuser->alamat ?? 'Belum diisi' }}
            </p>
            <hr>
            <strong>
              <i class="fas fa-envelope mr-2"></i>
              Email
            </strong>
            <p class="text-muted">
              {{ $itemuser->email }}
            </p>
            <hr>
            <strong>
              <i class="fas fa-phone mr-2"></i>
              No Tlp
            </strong>
            <p class="text-muted">
              {{ $itemuser->phone ?? 'Belum diisi' }}
            </p>
            <hr>
            <a href="{{ URL::to('admin/setting') }}" class="btn btn-primary btn-block">Setting</a>
          </div>
        </div>
      </div>
      <div class="col col-lg-8 col-md-8">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">History Transaksi</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Sub Total</th>
                    <th>Diskon</th>
                    <th>Ongkir</th>
                    <th>Total</th>
                    <th>Status Pembayaran</th>
                    <th>Status</th>
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
                        <a href="{{ route('transaksi.show', $order->id) }}" class="btn btn-sm btn-info mb-2">
                          Detail
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              {{ $itemorder->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection