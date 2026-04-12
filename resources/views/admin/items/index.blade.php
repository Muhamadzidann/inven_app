{{-- resources/views/admin/items/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Items')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Items Management</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <a href="{{ route('admin.items.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Item
            </a>
            <a href="{{ route('admin.items.export') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Total</th>
                        <th>Repair</th>
                        <th>Available</th>
                        <th>Lending Total</th>
                        <th>Actions</th>
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
                        <td>{{ $item->available }}</td>
                        <td>
                            @if($item->lending_total > 0)
                                <a href="{{ route('admin.lendings.index', ['item' => $item->id]) }}" class="text-primary">
                                    {{ $item->lending_total }}
                                </a>
                            @else
                                {{ $item->lending_total }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.items.destroy', $item) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection