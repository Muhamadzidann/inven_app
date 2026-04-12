{{-- resources/views/admin/items/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Item')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Item Forms</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.items.update', $item) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $item->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select select2 @error('category_id') is-invalid @enderror" 
                        id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="total" class="form-label">Total</label>
                <input type="number" class="form-control @error('total') is-invalid @enderror" 
                       id="total" name="total" value="{{ old('total', $item->total) }}" min="0" required>
                @error('total')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="new_broke_item" class="form-label">New Broke Item (currently: {{ $item->repair }})</label>
                <input type="number" class="form-control" 
                       id="new_broke_item" name="new_broke_item" value="0" min="0">
                <small class="text-muted">Add new broken items to increase repair count</small>
            </div>
            
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.items') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush
@endsection