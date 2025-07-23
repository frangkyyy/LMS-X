<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful | LMS X</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-info-subtle d-flex justify-content-center align-items-center" style="height: 100vh;">

<div class="card shadow-lg p-4 border-0 text-center" style="width: 100%; max-width: 420px;">
    <div class="text-success mb-4">
        <h3 class="fw-bold">Registration Successful!</h3>
        <p class="fs-5 text-primary">Thank you for signing up. Your account is currently under review by the admin.</p>
    </div>

    <div class="alert alert-warning">
        <p>We have received your registration request. You will be notified once your account is approved.</p>
    </div>

    <div class="d-grid mb-3">
        <a href="{{ route('login') }}" class="btn btn-primary">Go to Login</a>
    </div>

    <div>
        <p>If you have any questions, feel free to contact us.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
