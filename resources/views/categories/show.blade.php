@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Detail Kategori</h3>
    <a href="/categories" class="btn btn-secondary">
        Kembali
    </a>
</div>

<p>
    <strong>Nama Kategori:</strong>
    <span class="badge bg-primary">
        {{ $category->name }}
    </span>
</p>

<hr>

<h5 class="mb-3">Daftar Buku</h5>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th width="70">No</th>
                    <th>Judul</th>
                    <th>Author</th>
                    <th>ISBN</th>
                </tr>
            </thead>
            <tbody id="bookTable">
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Memuat data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    let categoryId = {{ $category->id }};

    $.ajax({
        url: '/categories/' + categoryId + '/books',
        method: 'GET',
        success: function (res) {
            let rows = '';

            if (res.books.length === 0) {
                rows = `
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Belum ada buku pada kategori ini
                        </td>
                    </tr>
                `;
            } else {
                $.each(res.books, function (i, book) {
                    rows += `
                        <tr>
                            <td>${i + 1}</td>
                            <td>${book.title}</td>
                            <td>${book.author}</td>
                            <td>${book.isbn}</td>
                        </tr>
                    `;
                });
            }

            $('#bookTable').html(rows);
        },
        error: function () {
            $('#bookTable').html(`
                <tr>
                    <td colspan="4" class="text-center text-danger">
                        Gagal memuat data buku
                    </td>
                </tr>
            `);
        }
    });

});
</script>
@endsection
