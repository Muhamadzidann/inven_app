{{-- resources/views/admin/categories/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Categories Management</h5>
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus"></i> Add Category
        </button>
        
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Division PJ</th>
                        <th>Total Items</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->division_pj }}</td>
                        <td>{{ $category->items_count }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn" 
                                    data-id="{{ $category->id }}"
                                    data-name="{{ $category->name }}"
                                    data-division="{{ $category->division_pj }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
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

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category Forms</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="division_pj" class="form-label">Division PJ</label>
                        <select class="form-select" id="division_pj" name="division_pj" required>
                            <option value="">Select Division PJ</option>
                            <option value="Sarpras">Sarpras</option>
                            <option value="Tata Usaha">Tata Usaha</option>
                            <option value="Tefa">Tefa</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Category Forms</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_division_pj" class="form-label">Division PJ</label>
                        <select class="form-select" id="edit_division_pj" name="division_pj" required>
                            <option value="Sarpras">Sarpras</option>
                            <option value="Tata Usaha">Tata Usaha</option>
                            <option value="Tefa">Tefa</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(function() {
        const base = @json(url('/admin/categories'));
        $('.edit-btn').on('click', function() {
            var id = $(this).data('id');
            $('#editForm').attr('action', base + '/' + id);
            $('#edit_name').val($(this).data('name'));
            $('#edit_division_pj').val($(this).data('division'));
            bootstrap.Modal.getOrCreateInstance(document.getElementById('editModal')).show();
        });
    });
</script>
@endpush
@endsection