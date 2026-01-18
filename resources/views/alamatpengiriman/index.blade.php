@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Alamat Pengiriman</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Penerima</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($itemalamat as $alamat)
                                        <tr>
                                            <td>
                                                <strong>{{ $alamat->nama_penerima }}</strong><br>
                                                {{ $alamat->no_tlp }}
                                            </td>
                                            <td>
                                                {{ $alamat->alamat }}<br>
                                                {{ $alamat->kota }}, {{ $alamat->provinsi }} - {{ $alamat->kode_pos }}
                                            </td>
                                            <td>
                                                @if($alamat->status == 'utama')
                                                    <span class="badge badge-success">Utama</span>
                                                @else
                                                    <form action="{{ route('alamatpengiriman.update', $alamat->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('patch')
                                                        <button type="submit" class="btn btn-xs btn-outline-primary">Set
                                                            Utama</button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('alamatpengiriman.destroy', $alamat->id) }}"
                                                    method="POST" onsubmit="return confirm('Hapus alamat ini?')">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $itemalamat->links() }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Alamat Baru</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('alamatpengiriman.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama_penerima">Nama Penerima</label>
                                <input type="text" name="nama_penerima" id="nama_penerima" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="no_tlp">No. Telepon</label>
                                <input type="text" name="no_tlp" id="no_tlp" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat Lengkap</label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="kota">Kota</label>
                                <input type="text" name="kota" id="kota" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="provinsi">Provinsi</label>
                                <input type="text" name="provinsi" id="provinsi" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="kode_pos">Kode Pos</label>
                                <input type="text" name="kode_pos" id="kode_pos" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Simpan Alamat</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection