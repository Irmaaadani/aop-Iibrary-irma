{{-- resources\views\loans\index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')

@php
    $role = auth()->user()->role;
    $canManageLoan = in_array($role, ['admin', 'librarian']);
@endphp


<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Data Peminjaman Buku</h3>
    @if ($canManageLoan)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
            Tambah Peminjaman
        </button>
    @endif
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Catatan</th>
                    @if ($canManageLoan)
                        <th width="160">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody id="loanTable">
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Memuat data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

<div class="modal fade" id="modalAdd">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAdd">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label class="form-label">Judul Buku</label>
                    <select name="book_id" class="form-select mb-2" required>
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}">{{ $book->title }}</option>
                        @endforeach
                    </select>
                    <label class="form-label">Peminjam (Member)</label>
                    <select name="member_id" class="form-select mb-2" required>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </select>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Pengembalian</label>
                        <input type="date" name="returned_at" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="note" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditLoan">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" id="edit_book" class="form-control" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Peminjam</label>
                        <input type="text" id="edit_member" class="form-control" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Pengembalian</label>
                        <input type="date" name="returned_at" id="edit_returned_at" class="form-control">
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="note" id="edit_note" class="form-control"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Jquery Mengatur Role Tombol Aksi
const CAN_MANAGE_LOAN = @json($canManageLoan);
// Mencatat token CSRF
const csrf = document.querySelector('meta[name="csrf-token"]').content;

function toDateInput(value) {
    if (!value) return '';
    return value.substring(0, 10);
}

function loadLoans() {
    $.get('/loans/data', function(res) {
        let html = '';

        if (res.data.length === 0) {
            html = `
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Belum ada data peminjaman
                    </td>
                </tr>`;
        } else {
            res.data.forEach((loan, i) => {

            let actionColumn = '';

            if (CAN_MANAGE_LOAN) {
                actionColumn = `
                    <td>
                        <button class="btn btn-warning btn-sm btn-edit"
                            data-id="${loan.id}"
                            data-book="${loan.book ? loan.book.title : ''}"
                            data-member="${loan.member ? loan.member.name : ''}"
                            data-note="${loan.note ?? ''}"
                            data-returned="${loan.returned_at ?? ''}">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete"
                            data-id="${loan.id}">
                            Delete
                        </button>
                    </td>
                `;
            }

            html += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${loan.book ? loan.book.title : '-'}</td>
                    <td>${loan.member ? loan.member.name : '-'}</td>
                    <td>${loan.loan_at ?? '-'}</td>
                    <td>${loan.returned_at ?? '-'}</td>
                    <td>${loan.note ?? '-'}</td>
                    ${CAN_MANAGE_LOAN ? actionColumn : ''}
                </tr>
            `;
        });


        }

        $('#loanTable').html(html);
    });
}

$('#formAdd').submit(function(e){
    e.preventDefault();

    $.ajax({
        url: '/loans',
        type: 'POST',
        data: $(this).serialize(),
        headers: {
            'X-CSRF-TOKEN': csrf
        },
        success: function(res){
            alert(res.message);
            location.reload();
        },
        error: function(xhr){
            if (xhr.status === 422 && xhr.responseJSON?.message) {
                alert(xhr.responseJSON.message);
            } else {
                alert('Terjadi kesalahan');
            }
        }
    });
});

$(document).on('click', '.btn-edit', function () {
    $('#edit_id').val($(this).data('id'));
    $('#edit_book').val($(this).data('book'));
    $('#edit_member').val($(this).data('member'));
     $('#edit_loan_at').val(toDateInput($(this).data('loan-at')));
    $('#edit_note').val($(this).data('note'));
    $('#edit_returned_at').val(
        toDateInput($(this).data('returned'))
    );

    new bootstrap.Modal(document.getElementById('modalEdit')).show();
});

$('#formEditLoan').submit(function(e){
    e.preventDefault();

    let id = $('#edit_id').val();

    $.ajax({
        url: '/loans/' + id,
        type: 'PUT',
        data: {
            _token: csrf,
            note: $('#edit_note').val()
        },
        success: function(res){
            loadLoans();
            alert(res.message);
            bootstrap.Modal.getInstance(
                document.getElementById('modalEdit')
            ).hide();
        }
    });
});

$(document).on('click', '.btn-delete', function(){
    if (!confirm('Yakin hapus data ini?')) return;

    let id = $(this).data('id');

    $.ajax({
        url: '/loans/' + id,
        type: 'DELETE',
        data: {_token: csrf},
        success: function(res){
            loadLoans();
            alert(res.message);
        }
    });
});


$(document).ready(function(){
    loadLoans();
});
</script>
@endsection
