@extends('layouts.operator')

@section('title', 'Peminjaman')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <h5 class="mb-0">Peminjaman</h5>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('operator.lendings.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Buat peminjaman</a>
            <a href="{{ route('operator.lendings.export') }}" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Export Excel</a>
        </div>
    </div>
    <div class="card-body">
        @error('lines')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Peminjam</th>
                        <th>Barang</th>
                        <th>Tgl pinjam</th>
                        <th>Tgl kembali</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lendings as $lending)
                    <tr>
                        <td>{{ $lending->id }}</td>
                        <td>{{ $lending->borrower_name }}</td>
                        <td>
                            @foreach($lending->lendingItems as $li)
                                <div>{{ $li->item->name }} ({{ $li->quantity }})</div>
                            @endforeach
                        </td>
                        <td>{{ $lending->created_at->locale('id')->translatedFormat('j F Y') }}</td>
                        <td>
                            @if($lending->returned_at)
                                {{ $lending->returned_at->locale('id')->translatedFormat('j F Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('operator.lendings.show', $lending) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                            @if(!$lending->returned_at)
                            <form action="{{ route('operator.lendings.return', $lending) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Returned</button>
                            </form>
                            @endif
                            <form action="{{ route('operator.lendings.destroy', $lending) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus peminjaman ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted">Belum ada peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $lendings->links() }}
    </div>
</div>
@endsection
