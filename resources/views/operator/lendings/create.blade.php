@extends('layouts.operator')

@section('title', 'Buat Peminjaman')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form peminjaman (multi barang)</h5>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('operator.lendings.store') }}" method="POST" id="lendingForm">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama peminjam</label>
                <input type="text" name="borrower_name" class="form-control" value="{{ old('borrower_name') }}" required>
            </div>
            <div class="mb-2 d-flex justify-content-between align-items-center">
                <label class="form-label mb-0">Barang</label>
                <button type="button" class="btn btn-sm btn-outline-primary" id="addLine">More</button>
            </div>
            <div class="table-responsive">
                <table class="table" id="linesTable">
                    <thead><tr><th>Barang</th><th>Jumlah</th><th></th></tr></thead>
                    <tbody id="linesBody">
                        <tr class="line-row">
                            <td style="min-width:220px">
                                <select name="lines[0][item_id]" class="form-select item-select" required>
                                    <option value="">— pilih —</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} (tersedia: {{ $item->available }})</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width:120px">
                                <input type="number" name="lines[0][quantity]" class="form-control" min="1" value="1" required>
                            </td>
                            <td style="width:80px">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-line" disabled>Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('operator.lendings') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    let idx = 0;
    const tbody = document.getElementById('linesBody');
    const templateOptions = @json($items->map(fn ($i) => ['id' => $i->id, 'label' => $i->name.' (tersedia: '.$i->available.')']));

    function initSelect2($el) {
        if (!$.fn.select2) return;
        $el.select2({ width: '100%' });
    }

    function refreshRemoveState() {
        const rows = tbody.querySelectorAll('.line-row');
        rows.forEach(function(row) {
            row.querySelector('.remove-line').disabled = rows.length <= 1;
        });
    }

    $('#addLine').on('click', function() {
        idx++;
        let opts = '<option value="">— pilih —</option>';
        templateOptions.forEach(function(o) {
            opts += '<option value="'+o.id+'">'+o.label+'</option>';
        });
        const $tr = $('<tr class="line-row">' +
            '<td><select name="lines['+idx+'][item_id]" class="form-select item-select" required>'+opts+'</select></td>' +
            '<td><input type="number" name="lines['+idx+'][quantity]" class="form-control" min="1" value="1" required></td>' +
            '<td><button type="button" class="btn btn-sm btn-outline-danger remove-line">Hapus</button></td>' +
            '</tr>');
        $('#linesBody').append($tr);
        initSelect2($tr.find('.item-select'));
        refreshRemoveState();
    });

    tbody.addEventListener('click', function(e) {
        if (!e.target.classList.contains('remove-line')) return;
        const row = e.target.closest('.line-row');
        if (tbody.querySelectorAll('.line-row').length <= 1) return;
        var $sel = $(row).find('.item-select');
        if ($sel.hasClass('select2-hidden-accessible')) $sel.select2('destroy');
        row.remove();
        refreshRemoveState();
    });

    initSelect2($('#linesBody .item-select'));
    refreshRemoveState();
});
</script>
@endpush
