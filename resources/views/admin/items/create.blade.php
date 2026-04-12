{{-- resources/views/admin/items/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Add Item')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add Item Forms</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.items.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name') }}" required>
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
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                       id="total" name="total" value="{{ old('total', 0) }}" min="0" required>
                @error('total')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="repair" class="form-label">Repair</label>
                <input type="number" class="form-control @error('repair') is-invalid @enderror" 
                       id="repair" name="repair" value="{{ old('repair', 0) }}" min="0" required>
                @error('repair')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
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