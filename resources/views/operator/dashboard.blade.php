@extends('layouts.operator')

@section('title', 'Dashboard')

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Peminjaman aktif</h5>
                <h2>{{ $activeLendings }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total barang</h5>
                <h2>{{ $totalItems }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">Peminjaman terbaru</div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>ID</th><th>Peminjam</th><th>Oleh</th><th>Status</th></tr></thead>
            <tbody>
                @foreach($recentLendings as $l)
                <tr>
                    <td>{{ $l->id }}</td>
                    <td>{{ $l->borrower_name }}</td>
                    <td>{{ $l->user->name }}</td>
                    <td>{{ $l->returned_at ? 'Selesai' : 'Aktif' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
