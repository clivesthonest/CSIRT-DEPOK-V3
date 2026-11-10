<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | CSIRT Depok</title>
    <link rel="icon" href="https://csirt.depok.go.id/storage/image-property/kRUUbk4sYstbeQYsR1PayVtCwSQCJcyR4FsEucOn.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cyber-dark text-white">
    <div class="admin-auth-page">
        <div class="admin-auth-card">
            <div class="admin-auth-logo"><i class='bx bx-shield-quarter'></i></div>
            <h1>Admin Panel</h1>
            <div class="admin-auth-subtitle">Masuk ke dashboard pengelolaan website CSIRT</div>

            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="admin-form-label" for="email">Email</label>
                    <input id="email" name="email" class="admin-form-control" type="email" value="{{ old('email', 'admin@csirt.depok.go.id') }}" required>
                </div>

                <div class="mb-3">
                    <label class="admin-form-label" for="password">Password</label>
                    <input id="password" name="password" class="admin-form-control" type="password" value="admin123" required>
                </div>

                <div class="admin-options">
                    <label class="admin-remember">
                        <input type="checkbox" name="remember" checked>
                        <span>Ingat saya</span>
                    </label>
                    <a href="#" class="text-cyber-cyan text-decoration-none">Lupa password?</a>
                </div>

                <button type="submit" class="admin-login-btn">
                    <i class='bx bx-log-in-circle me-2'></i> Masuk ke Dashboard
                </button>
            </form>

            <div class="admin-register-link">
                <span>Belum punya akses admin?</span>
                <a href="#">Hubungi Administrator</a>
            </div>
        </div>
    </div>
</body>
</html>
