{{-- resources\views\categories\index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Kategori Buku')

@section('content')

@php
    $role = auth()->user()->role;
    $canManage = in_array($role, ['admin', 'librarian']);
@endphp


<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Data Kategori Buku</h3>
    @if ($canManage)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
            Tambah Kategori
        </button>
    @endif
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0" id="categoryTable">
            <thead class="table-light">
                <tr>
                    <th width="70">No</th>
                    <th>Nama Kategori</th>                  
                    <th width="260">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_categories as $category)
                <tr id="row-{{ $category->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td class="cat-name">{{ $category->name }}</td>
                    <td>
                        <a href="/categories/{{ $category->id }}"
                        class="btn btn-info btn-sm">
                            Detail
                        </a>

                        @if ($canManage)
                            <button class="btn btn-warning btn-sm btn-edit"
                                data-id="{{ $category->id }}"
                                data-name="{{ $category->name }}">
                                Edit
                            </button>

                            <button class="btn btn-danger btn-sm btn-delete"
                                data-id="{{ $category->id }}">
                                Hapus
                            </button>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if ($canManage)
<div class="modal fade" id="modalAdd" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label>Nama Kategori</label>
                    <input type="text" id="addName" class="form-control">
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary" id="btnSaveAdd">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="editId">
                <div class="mb-3">
                    <label>Nama Kategori</label>
                    <input type="text" id="editName" class="form-control">
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary" id="btnSaveEdit">Edit</button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
const CAN_MANAGE = @json($canManage);
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document
            .querySelector('meta[name="csrf-token"]')
            .content
    }
});

if (CAN_MANAGE) {

    // ADD
    $('#btnSaveAdd').click(function () {
        let name = $('#addName').val();
        if (name === '') {
            alert('Nama kategori wajib diisi');
            return;
        }

        $.post('/categories', { name }, function (res) {
            alert(res.message);
            location.reload();
        });
    });

    // OPEN EDIT
    $(document).on('click', '.btn-edit', function () {
        $('#editId').val($(this).data('id'));
        $('#editName').val($(this).data('name'));

        new bootstrap.Modal(
            document.getElementById('modalEdit')
        ).show();
    });

    // UPDATE
    $('#btnSaveEdit').click(function () {
        let id = $('#editId').val();
        let name = $('#editName').val();

        $.ajax({
            url: '/categories/' + id,
            type: 'POST',
            data: {
                _method: 'PUT',
                name: name
            },
            success: function (res) {
                alert(res.message);
                location.reload();
            }
        });
    });

    // DELETE
    $(document).on('click', '.btn-delete', function () {
        if (!confirm('Yakin hapus kategori ini?')) return;

        let id = $(this).data('id');

        $.ajax({
            url: '/categories/' + id,
            type: 'POST',
            data: { _method: 'DELETE' },
            success: function (res) {
                alert(res.message);
                $('#row-' + id).remove();
            }
        });
    });

}

</script>
@endsection
