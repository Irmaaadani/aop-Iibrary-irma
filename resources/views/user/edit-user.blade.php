@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Edit Data User</h3>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-max">

                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Form Edit User</h5>
                    </div>

                    <div class="card-body">
                        <form id="formEditUser" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <span class="text-danger">*</span>
                                        <input type="hidden" id="userId" value="{{ $user->id }}">
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $user->name) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <span class="text-danger">*</span>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $user->email) }}" required>
                                    </div>

                        
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Password <small class="text-muted">(kosongkan jika tidak diubah)</small>
                                        </label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <span class="text-danger">*</span>
                                        <select name="role" class="form-select" required>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="librarian" {{ $user->role == 'librarian' ? 'selected' : '' }}>
                                                Librarian</option>
                                            <option value="member" {{ $user->role == 'member' ? 'selected' : '' }}>Member
                                            </option>
                                        </select>
                                    </div>

                                    
                                    <div class="mb-3">
                                        <label class="form-label">No. Telepon</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ old('phone', $user->phone) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <span class="text-danger">*</span>
                                        <textarea name="address" rows="3" class="form-control">{{ old('address', $user->address) }}</textarea>
                                    </div>
                                </div>
                            </div>

                       
                            <div class="d-flex justify-content-end mt-3">
                                <a href="/user" class="btn btn-secondary me-2">Kembali</a>
                                <button type="button" id="btnUpdateUser" class="btn btn-warning">
                                    Update
                                </button>

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

    // CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .content
        }
    });

    $('#btnUpdateUser').on('click', function () {

        let id       = $('#userId').val();
        let name     = $('input[name="name"]').val().trim();
        let email    = $('input[name="email"]').val().trim();
        let password = $('input[name="password"]').val();
        let role     = $('select[name="role"]').val();
        let phone    = $('input[name="phone"]').val().trim();
        let address  = $('textarea[name="address"]').val().trim();

        // VALIDASI
        if (!name) {
            alert('Nama wajib diisi');
            return;
        }
        if (!email) {
            alert('Email wajib diisi');
            return;
        }
        if (!role) {
            alert('Role wajib dipilih');
            return;
        }

        $.ajax({
            url: '/user-update/' + id,
            type: 'PUT',
            data: {
                name,
                email,
                password,
                role,
                phone,
                address
            },
            success: function (res) {
                alert(res.message);
                window.location.href = '/user';
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let msg = '';
                    Object.values(errors).forEach(e => {
                        msg += e[0] + '\n';
                    });
                    alert(msg);
                } else {
                    console.error(xhr.responseText);
                    alert('Gagal mengupdate user');
                }
            }
        });

    });

});
</script>

@endsection
