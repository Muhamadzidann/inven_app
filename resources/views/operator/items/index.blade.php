@extends('layouts.operator')

@section('title', 'Stok Barang')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Stok barang</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Total</th>
                        <th>Repair</th>
                        <th>Lending</th>
                        <th>Available</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->total }}</td>
                        <td>{{ $item->repair > 0 ? $item->repair : '-' }}</td>
                        <td>{{ $item->lending_total }}</td>
                        <td><strong>{{ $item->available }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
