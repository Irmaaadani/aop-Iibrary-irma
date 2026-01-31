@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Data User</h3>
    <a href="/add-user">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
            Tambah User
        </button>
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th>Addres</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody id="loanTable">
                {{-- <tr>
                    <td colspan="6" class="text-center text-muted">
                        Memuat data...
                    </td>
                </tr> --}}
                @forelse ($user as $index => $u)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->role ?? '-' }}</td>
                        <td>{{ $u->phone ?? '-' }}</td>
                        <td>{{ $u->address ?? '-' }}</td>
                        <td>
                            <a href="/edit-user/{{ $u->id }}" class="btn btn-sm btn-warning">
                                Edit
                            </a>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $u->id }}">
                                Hapus
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Data user tidak tersedia
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {

    // CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .content
        }
    });

    // DELETE USER
    $(document).on('click', '.btn-delete', function () {

        let id = $(this).data('id');

        if (!confirm('Yakin hapus user ini?')) {
            return;
        }

        $.ajax({
            url: '/user-delete/' + id,
            type: 'DELETE',
            success: function (res) {
                alert(res.message);
                location.reload(); // reload table
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Gagal menghapus user');
            }
        });
    });

});
</script>
@endsection
