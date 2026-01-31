@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Tambah Data User</h3>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-max">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Form Tambah User</h5>
                    </div>
                    <div class="card-body">
                        <form id="formAddUser" method="POST">
                            @csrf
                            <div class="row">
                       
                                <div class="col-md-6">
                            
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                          <span class="text-danger">*</span>
                                        <input type="text" name="name" class="form-control"
                                        id="addName"
                                            value="{{ old('name') }}" required>
                                    </div>

                                  
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <span class="text-danger">*</span>
                                        <input type="email" name="email" class="form-control"
                                        id="addEmail"
                                            value="{{ old('email') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <span class="text-danger">*</span>
                                        <input id="addPassword" type="password" name="password" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                   
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <span class="text-danger">*</span>
                                        <select name="role" id="addRole" class="form-select" required>
                                            <option value="" disabled selected>-- Pilih Role --</option>
                                            <option value="admin">Admin</option>
                                            <option value="librarian">Librarian</option>
                                            <option value="member">Member</option>
                                        </select>
                                    </div>

                                 
                                    <div class="mb-3">
                                        <label class="form-label">No. Telepon</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" name="phone" class="form-control"
                                        id="addPhone"
                                            value="{{ old('phone') }}">
                                    </div>

                                  
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <span class="text-danger">*</span>
                                        <textarea name="address" id="addAdress" rows="3" class="form-control">{{ old('address') }}</textarea>
                                    </div>
                                </div>
                            </div>

                           
                            <div class="d-flex justify-content-end mt-3">
                                <a href="/user" class="btn btn-secondary me-2">Kembali</a>
                                <button type="button" id="btnSaveAdd" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {

    // CSRF SETUP
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .content
        }
    });

    $('#btnSaveAdd').on('click', function () {

        let name     = $('#addName').val().trim();
        let email    = $('#addEmail').val().trim();
        let password = $('#addPassword').val();
        let role     = $('#addRole').val();
        let phone    = $('#addPhone').val().trim();
        let address  = $('#addAdress').val().trim();

        // VALIDASI
        if (!name) {
            alert('Nama wajib diisi');
            return;
        }
        if (!email) {
            alert('Email wajib diisi');
            return;
        }
        if (!password) {
            alert('Password wajib diisi');
            return;
        }
        if (!role) {
            alert('Role wajib dipilih');
            return;
        }

        $.ajax({
            url: '/user-store',
            type: 'POST',
            data: {
                name,
                email,
                password,
                role,
                phone,
                address
            },
            success: function (res) {
                alert(res.message ?? 'User berhasil ditambahkan');
                window.location.href = '/user';
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Gagal menambahkan user');
            }
        });
    });

});
</script>
@endsection
