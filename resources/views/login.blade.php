<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Sistem Peminjaman Perpustakaan | Login</title>
</head>
<style>
    .main {
        margin: 50px;
        height: 100vh;
        box-sizing: border-box;
    }
    .login-box{
        width: 500px;
        border: solid 1px;
        max-width: 400px;
        margin: 0 auto;
        padding: 30px;
    }

    form div{
        margin-bottom: 15px;

    }
</style>
<body>
    <div class="main d-flex justify-content-center align-items-center">
        <div class="login-box">
            <form action="{{ url('/login') }}" method="POST">
                @csrf

                <div>
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>

                <div>
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <button class="btn btn-primary form-control">
                    Login
                </button>
            </form>

        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>