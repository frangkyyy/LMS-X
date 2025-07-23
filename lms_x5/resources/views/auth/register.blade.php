<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | LMS X</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-info-subtle d-flex justify-content-center align-items-center" style="height: 100vh;">

<div class="card shadow-lg p-4 border-0" style="width: 100%; max-width: 420px;">
    <div class="text-center mb-4">
        <h3 class="text-primary">Sign Up</h3>
        <p class="text-success">Create your account and explore more</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label text-primary">Full Name</label>
            <input id="name" type="text"
                   class="form-control @error('name') is-invalid @enderror"
                   name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label text-primary">Email Address</label>
            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label text-primary">Password</label>
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label text-primary">Confirm Password</label>
            <input id="password_confirmation" type="password"
                   class="form-control"
                   name="password_confirmation" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="agree" required>
            <label class="form-check-label text-success" for="agree">
                I agree to the <a href="#" class="text-decoration-none text-primary">terms and conditions</a>
            </label>
        </div>

        <div class="d-grid mb-2">
            <button type="submit" class="btn btn-success">Register</button>
        </div>

        <div class="text-center mt-3">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Sign In</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
