<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpTrend | Login</title>
    <!-- CSS only -->
    @vite('resources/css/admin/login.css')
</head>
<body>
    <div class="container">
        <form method="POST" action="{{ route('dashboard') }}">
            @csrf
            <h2>Login</h2>
            <div class="input-field">
                <input id="email" type="email" 
                class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', 'admin@lightbp.com') }}" 
                required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                <label>Enter your email</label>
            </div>
            <div class="input-field">
                <input type="password" required>
                <label>Enter your password</label>
            </div>
            <div class="forget">
                <a href="#">Forgot password?</a>
            </div>
            <button type="submit">Log In</button>
            <div class="register">
                <p>Don't have an account? <a href="/registers">Register</a></p>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();

            setTimeout(function() {
                // after 1000 ms we add the class animated to the login/register card
                $('.card').removeClass('card-hidden');
            }, 700)
        });
    </script>
</body>
</html>