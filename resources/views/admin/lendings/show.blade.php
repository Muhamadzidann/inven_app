@extends('layouts.admin')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Peminjaman #{{ $lending->id }}</h5>
    </div>
    <div class="card-body">
        <p><strong>Peminjam:</strong> {{ $lending->borrower_name }}</p>
        <p><strong>Operator:</strong> {{ $lending->user->name }}</p>
        <p><strong>Dibuat:</strong> {{ $lending->created_at->locale('id')->translatedFormat('j F Y H:i') }}</p>
        <p><strong>Dikembalikan:</strong>
            @if($lending->returned_at)
                {{ $lending->returned_at->locale('id')->translatedFormat('j F Y H:i') }}
            @else
                —
            @endif
        </p>
        <h6 class="mt-4">Barang</h6>
        <table class="table table-sm">
            <thead><tr><th>Barang</th><th>Qty</th></tr></thead>
            <tbody>
                @foreach($lending->lendingItems as $li)
                <tr>
                    <td>{{ $li->item->name }}</td>
                    <td>{{ $li->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('admin.lendings.index', request()->only('item')) }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
