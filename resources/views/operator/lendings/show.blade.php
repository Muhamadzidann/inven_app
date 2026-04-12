@extends('layouts.operator')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">#{{ $lending->id }} — {{ $lending->borrower_name }}</h5>
    </div>
    <div class="card-body">
        <p><strong>Operator:</strong> {{ $lending->user->name }}</p>
        <p><strong>Tanggal pinjam:</strong> {{ $lending->created_at->locale('id')->translatedFormat('j F Y H:i') }}</p>
        <p><strong>Tanggal kembali:</strong>
            @if($lending->returned_at)
                {{ $lending->returned_at->locale('id')->translatedFormat('j F Y H:i') }}
            @else
                -
            @endif
        </p>
        <table class="table">
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
        <div class="d-flex gap-2">
            <a href="{{ route('operator.lendings') }}" class="btn btn-secondary">Kembali</a>
            @if(!$lending->returned_at)
            <form action="{{ route('operator.lendings.return', $lending) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Returned</button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
