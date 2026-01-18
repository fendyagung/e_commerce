@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h3 class="card-title">Laporan Penjualan Bulan {{ $bulan }} Tahun {{ $tahun }}</h3>
                    </div>
                    <div class="card-body">
                        <!-- Placeholder for report data -->
                        <p>Menampilkan data laporan untuk bulan {{ $bulan }} tahun {{ $tahun }}...</p>
                        <!-- Logic to display data would go here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection