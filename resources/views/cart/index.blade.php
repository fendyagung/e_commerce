@extends('layouts.template')
@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
            </div>
        </div>

        @if($itemcart && $itemcart->detail->count() > 0)
            <div class="row">
                <!-- Item Section -->
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Item</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="bg-light text-center font-weight-bold">
                                        <tr>
                                            <th>No</th>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Diskon</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($itemcart->detail as $detail)
                                            <tr>
                                                <td class="text-center align-middle">{{ $no++ }}</td>
                                                <td class="align-middle">
                                                    {{ $detail->produk->nama_produk }}<br>
                                                    <small class="text-muted">{{ $detail->produk->kode_produk }}</small>
                                                </td>
                                                <td class="text-right align-middle">{{ number_format($detail->harga, 2) }}</td>
                                                <td class="text-right align-middle">{{ number_format($detail->diskon, 2) }}</td>
                                                <td class="text-center align-middle">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <form action="{{ route('cartdetail.update', $detail->id) }}" method="POST"
                                                            class="m-0">
                                                            @csrf
                                                            @method('patch')
                                                            <input type="hidden" name="param" value="kurang">
                                                            <button class="btn btn-primary btn-sm px-2" type="submit">-</button>
                                                        </form>
                                                        <input type="text" class="form-control form-control-sm text-center mx-1"
                                                            value="{{ number_format($detail->qty, 2) }}"
                                                            style="width: 70px; display: inline-block;" readonly>
                                                        <form action="{{ route('cartdetail.update', $detail->id) }}" method="POST"
                                                            class="m-0">
                                                            @csrf
                                                            @method('patch')
                                                            <input type="hidden" name="param" value="tambah">
                                                            <button class="btn btn-primary btn-sm px-2" type="submit">+</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td class="text-right align-middle font-weight-bold text-center">
                                                    {{ number_format($detail->subtotal, 2) }}</td>
                                                <td class="text-center align-middle">
                                                    <form action="{{ route('cartdetail.destroy', $detail->id) }}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Hapus item ini?')">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary Section -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Ringkasan</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3 mt-4">
                                <span class="text-muted">No Invoice</span>
                                <span class="font-weight-bold">{{ $itemcart->no_invoice }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Subtotal</span>
                                <span>{{ number_format($itemcart->subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Diskon</span>
                                <span>{{ number_format($itemcart->diskon, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-5">
                                <span class="text-muted">Total</span>
                                <span class="font-weight-bold">{{ number_format($itemcart->total, 2) }}</span>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('checkout') }}"
                                        class="btn btn-primary btn-block py-2 font-weight-bold shadow-sm">Checkout</a>
                                </div>
                                <div class="col-6">
                                    <form action="{{ url('kosongkan/' . $itemcart->id) }}" method="POST">
                                        @csrf
                                        @method('patch')
                                        <button type="submit" class="btn btn-danger btn-block py-2 font-weight-bold shadow-sm"
                                            onclick="return confirm('Kosongkan keranjang?')">Kosongkan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <div class="bg-light p-5 rounded shadow-sm">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                    <h4>Wah, keranjang belanjamu kosong!</h4>
                    <p class="text-muted">Yuk, cari produk favoritmu sekarang.</p>
                    <a href="{{ route('homepage') }}" class="btn btn-primary mt-3 px-4">Mulai Belanja</a>
                </div>
            </div>
        @endif
    </div>
@endsection