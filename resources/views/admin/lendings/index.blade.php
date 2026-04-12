@extends('layouts.admin')

@section('title', 'Peminjaman (Baca)')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Peminjaman</h5>
        @if($filterItem)
            <span class="badge bg-info">Filter barang: {{ $filterItem->name }}</span>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Peminjam</th>
                        <th>Barang</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th></th>
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
                        <td>
                            @if($lending->returned_at)
                                <span class="badge bg-success">Dikembalikan</span>
                            @else
                                <span class="badge bg-warning text-dark">Aktif</span>
                            @endif
                        </td>
                        <td>{{ $lending->created_at->locale('id')->translatedFormat('j F Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.lendings.show', $lending) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $lendings->links() }}
    </div>
</div>
@endsection
