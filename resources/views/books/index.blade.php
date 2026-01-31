@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')

@php
    $role = auth()->user()->role;
    $canManage = in_array($role, ['admin', 'librarian']);
@endphp


<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Data Buku</h3>
    @if ($canManage)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
            Tambah Buku
        </button>
    @endif
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Judul Buku</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    @if ($canManage)
                        <th width="150">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($data_books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>
                        @foreach ($book->categories as $cat)
                            <span class="badge bg-secondary">{{ $cat->name }}</span>
                        @endforeach
                    </td>
                    <td>{{ $book->description }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->isbn }}</td>

                    @if ($canManage)
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"data-bs-target="#modalEdit{{ $book->id }}">Edit</button>

                            <button class="btn btn-danger btn-sm btn-delete"
                                data-id="{{ $book->id }}">
                                Delete
                            </button>
                        </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL ADD --}}
<div class="modal fade" id="modalAdd">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAdd">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {{-- Judul Buku --}}
                    <div class="mb-2">
                        <label class="form-label">Judul Buku</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               placeholder="Masukkan judul buku"
                               required>
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-2">
                        <label class="form-label">Kategori Buku</label>
                        <select name="categories[]"
                                class="form-select select2"
                                multiple required>
                            @foreach ($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">
                            Bisa memilih lebih dari satu kategori
                        </small>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-2">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Deskripsi singkat buku"
                                  required></textarea>
                    </div>

                    {{-- Author --}}
                    <div class="mb-2">
                        <label class="form-label">Author</label>
                        <input type="text"
                               name="author"
                               class="form-control"
                               placeholder="Nama penulis"
                               required>
                    </div>

                    {{-- ISBN --}}
                    <div class="mb-2">
                        <label class="form-label">ISBN</label>
                        <input type="text"
                               name="isbn"
                               class="form-control"
                               placeholder="Nomor ISBN"
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
@foreach ($data_books as $book)
<div class="modal fade" id="modalEdit{{ $book->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="formEdit" data-id="{{ $book->id }}">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Judul Buku</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $book->title }}"
                               readonly>
                        <small class="text-muted">
                            Judul buku tidak dapat diubah
                        </small>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Kategori Buku</label>
                        <select name="categories[]"
                                class="form-select select2-edit"
                                multiple required>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ $book->categories->contains($cat->id) ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">
                            Pilih kategori yang sesuai
                        </small>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="3"
                                  required>{{ $book->description }}</textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Author</label>
                        <input type="text"
                               name="author"
                               class="form-control"
                               value="{{ $book->author }}"
                               required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">ISBN</label>
                        <input type="text"
                               name="isbn"
                               class="form-control"
                               value="{{ $book->isbn }}"
                               required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach



@endsection

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
});

const CAN_MANAGE = @json($canManage);

if (CAN_MANAGE) {
    $('#formAdd').submit(function(e){
        e.preventDefault();
        $.post('/books', $(this).serialize(), function(res){
            alert(res.message);
            location.reload();
        });
    });

    $('.btn-delete').click(function(){
        if (!confirm('Yakin hapus?')) return;
        let id = $(this).data('id');
        $.post('/books/' + id, {_method: 'DELETE'}, function(res){
            alert(res.message);
            location.reload();
        });
    });
}


$('#modalAdd').on('shown.bs.modal', function () {
    $('.select2').select2({
        dropdownParent: $('#modalAdd'),
        width: '100%',
        placeholder: 'Pilih kategori'
    });
});

$('.modal').on('shown.bs.modal', function () {
    $(this).find('.select2-edit').select2({
        dropdownParent: $(this),
        width: '100%',
        placeholder: 'Pilih kategori'
    });
});

$('.formEdit').submit(function(e){
    e.preventDefault();

    let id = $(this).data('id');

    $.ajax({
        url: '/books/' + id,
        type: 'POST',
        data: $(this).serialize(),
        success: function(res){
            alert(res.message);
            location.reload();
        },
        error: function(xhr){
            console.error(xhr.responseText);
            alert('Gagal update');
        }
    });
});


$('.btn-delete').click(function(){
    if (!confirm('Yakin hapus?')) return;

    let id = $(this).data('id');

    $.post('/books/' + id, {
        _method: 'DELETE'
    }, function(res){
        alert(res.message);
        location.reload();
    });
});


</script>
@endsection
