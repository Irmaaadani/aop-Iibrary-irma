<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
    }
</style>
<body>
    <div class="main d-flex justify-content-center align-items-center">
        <div class="login-box">
            <form action="" method="POST">
                @csrf
                <div> 
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                </div>
            </form>
        </div>
    </div>

{{-- @if ($errors->any())
    <p style="color:red">{{ $errors->first() }}</p>
@endif

<form method="POST" action="/login">
    @csrf

    <input type="email" name="email" placeholder="Email"><br><br>
    <input type="password" name="password" placeholder="Password"><br><br>

    <button type="submit">Login</button>
</form> --}}

</body>
</html>
