<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Medical Studio</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --bg: #f8fafc;
            --surface: #ffffff;
            --border: #e2e8f0;
            --ink: #0f172a;
            --muted: #64748b;
            --primary: #0f172a;
            --primary-hover: #334155;
            --danger: #ef4444;
            --danger-bg: #fef2f2;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: var(--bg); color: var(--ink); display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 2rem; }
        .login-wrapper { width: 100%; max-width: 400px; display: flex; flex-direction: column; align-items: center; }
        .logo-container { margin-bottom: 2.5rem; text-align: center; }
        .logo-container img { height: 48px; width: auto; object-fit: contain; }
        .login-card { background: var(--surface); width: 100%; border-radius: 16px; border: 1px solid var(--border); box-shadow: 0 10px 30px rgba(0,0,0,0.03); padding: 2.5rem; }
        .login-title { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; text-align: center; letter-spacing: -0.02em; }
        .login-subtitle { font-size: 0.95rem; color: var(--muted); text-align: center; margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--ink); margin-bottom: 0.5rem; }
        .input-group { position: relative; display: flex; align-items: center; }
        .input-group i { position: absolute; left: 1rem; color: var(--muted); font-size: 1rem; }
        .form-control { width: 100%; padding: 0.85rem 1rem 0.85rem 2.75rem; font-size: 0.95rem; border: 1px solid var(--border); border-radius: 10px; background: var(--bg); color: var(--ink); transition: all 0.2s; }
        .form-control:focus { outline: none; border-color: var(--primary); background: var(--surface); box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.05); }
        .btn-login { width: 100%; padding: 0.85rem; background: var(--primary); color: #fff; border: none; border-radius: 10px; font-size: 0.95rem; font-weight: 600; cursor: pointer; transition: background 0.2s; margin-top: 1rem; }
        .btn-login:hover { background: var(--primary-hover); }
        .alert-error { background: var(--danger-bg); color: var(--danger); padding: 1rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1.5rem; border: 1px solid rgba(239, 68, 68, 0.2); text-align: center; }
        .error-text { color: var(--danger); font-size: 0.8rem; margin-top: 0.4rem; display: block; }
        .is-invalid { border-color: var(--danger) !important; background: var(--danger-bg) !important; }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="logo-container" style="display:flex; flex-direction:column; align-items:center; gap: 0.5rem;">
            <img src="{{ asset('images/logo.png') }}" alt="Medical Studio Logo">
            <h2 style="font-size:1.5rem; font-weight:800; color:var(--ink); letter-spacing:-0.03em;">Medical Studio</h2>
        </div>
        
        <div class="login-card">
            <h1 class="login-title">Welcome Back</h1>
            <p class="login-subtitle">Sign in to your admin dashboard</p>

            @if (session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" id="loginForm">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <div class="input-group">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" name="email" id="email" class="form-control" placeholder="admin@medicalstudio.in" value="{{ old('email') }}">
                    </div>
                    <span class="error-text" id="email-error">@error('email') {{ $message }} @enderror</span>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••">
                    </div>
                    <span class="error-text" id="password-error"></span>
                </div>

                <button type="submit" class="btn-login" onclick="return validateLogin()">Sign In</button>
            </form>
        </div>
    </div>

    <script>
        function validateLogin() {
            let email = document.getElementById('email').value.trim();
            let password = document.getElementById('password').value.trim();
            let valid = true;

            if (!email) {
                document.getElementById('email').classList.add('is-invalid');
                document.getElementById('email-error').innerText = "Email is required.";
                valid = false;
            } else {
                document.getElementById('email').classList.remove('is-invalid');
                document.getElementById('email-error').innerText = "";
            }

            if (!password) {
                document.getElementById('password').classList.add('is-invalid');
                document.getElementById('password-error').innerText = "Password is required.";
                valid = false;
            } else {
                document.getElementById('password').value = password; // Set trimmed
                document.getElementById('password').classList.remove('is-invalid');
                document.getElementById('password-error').innerText = "";
            }

            return valid;
        }
    </script>
</body>
</html>