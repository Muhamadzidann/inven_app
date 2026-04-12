<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f4f4;
        }

        .login-card {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .btn-close-custom {
            background-color: #ff7a45;
            color: white;
        }

        .btn-submit-custom {
            background-color: #5fd3bc;
            color: white;
        }

        .btn-close-custom:hover {
            background-color: #ff6a2e;
        }

        .btn-submit-custom:hover {
            background-color: #4bc2aa;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h3 class="text-center mb-4">Login</h3>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <!-- Email -->
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-between">
            <a href="/" class="btn btn-close-custom">Close</a>
            <button type="submit" class="btn btn-submit-custom">Submit</button>
        </div>
    </form>
</div>

</body>
</html>