<x-guest-layout>
    <main class="main">
        @vite('resources/css/signin.css')
        <section>
                <div class="container">
                    <div>
                        <div>
                            <div>
                                <div>
                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    @error('message')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    @error('email')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    @error('password')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div>
                                    <form role="form" method="POST" action="{{ route('login.post') }}">
                                        @csrf
                                        <div>
                                            <h2>Welcome back!</h2>
                                            <p>Sign in with your credentials:</p>
                                        </div>
                                        <div class="input-field">
                                            <label for="email"></label>
                                            <input type="email" 
                                                id="email"
                                                name="email" 
                                                class="form-control @error('email') is-invalid @enderror" 
                                                placeholder="Enter your email"
                                                value="{{ old('email') }}"
                                                required
                                                autofocus>
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="input-field">
                                            <label for="password"></label>
                                            <input type="password" 
                                                id="password" 
                                                name="password"
                                                class="form-control @error('password') is-invalid @enderror" 
                                                aria-label="Password" 
                                                placeholder="Enter your password"
                                                aria-describedby="password-addon"
                                                required>
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="forget">
                                            <a href="{{ route('password.request') }}">Forgot password?</a>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit">Sign in</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="register">
                                    <p>
                                        Don't have an account?
                                        <a href="{{ route('register') }}">Sign up</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </main>
</x-guest-layout>
