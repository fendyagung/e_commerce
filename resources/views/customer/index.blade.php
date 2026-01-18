@extends('layouts.dashboard')
@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              Data Customer
            </h3>
          </div>
          <div class="card-body">
            <form action="{{ route('customer.index') }}" method="get">
              <div class="row">
                <div class="col">
                  <input type="text" name="keyword" id="keyword" class="form-control" placeholder="ketik keyword disini"
                    value="{{ request('keyword') }}">
                </div>
                <div class="col-auto">
                  <button class="btn btn-primary">
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
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Tlp</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($itemcustomer as $customer)
                    <tr>
                      <td>{{ ++$no }}</td>
                      <td>{{ $customer->name }}</td>
                      <td>{{ $customer->email }}</td>
                      <td>{{ $customer->phone }}</td>
                      <td>{{ $customer->alamat }}</td>
                      <td>{{ $customer->status }}</td>
                      <td>
                        <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-sm btn-primary">Edit</a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              {{ $itemcustomer->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection