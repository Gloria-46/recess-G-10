<x-guest-layout>
    {{-- <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <x-guest.sidenav-guest />
            </div>
        </div>
    </div> --}}
    <main class="main">
        @vite('resources/css/signin.css')
        <section>
            {{-- <div class="page-header min-vh-100"> --}}
                <div class="container">
                    <div>
                        <div>
                            <div>
                                {{-- <div class="card-header pb-0 text-left bg-transparent text-center">
                                    <h3 class="font-weight-black text-dark display-6">Welcome back!</h3>
                                    <p class="mb-0">Sign in with your credentials:</p>
                                </div> --}}
                                <div>
                                    @if (session('status'))
                                        <div>
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    @error('message')
                                        <div role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div>
                                    <form role="form" method="POST" action="sign-in">
                                        @csrf
                                        <div>
                                            <h2>Welcome back!</h3>
                                            <p>Sign in with your credentials:</p>
                                        </div>
                                        <div class="input-field">
                                            <label id = "label">Enter your Email address</label>
                                                <input type="email" 
                                                {{-- id="email"  --}}
                                                name="email" class="form-control"
                                                    {{-- placeholder="Enter your email address" --}}
                                                    {{-- value="{{ old('email') ? old('email') : 'admin@corporateui.com' }}" --}}
                                                    {{-- aria-label="Email" aria-describedby="email-addon" --}}
                                                    >
                                        </div>
                                        <div class="input-field">
                                            <label>Enter your password</label>
                                                <input type="password" id="password" name="password"
                                                    {{-- value="{{ old('password') ? old('password') : 'secret' }}" --}}
                                                    class="form-control" aria-label="Password"
                                                    aria-describedby="password-addon">
                                        </div>
                                        <div class="forget">
                                            {{-- <div class="form-check form-check-info text-left mb-0">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault">
                                                <label class="font-weight-normal text-dark mb-0" for="flexCheckDefault">
                                                    Remember for 14 days
                                                </label>
                                            </div> --}}
                                            <a href= "{{ route('password.request') }}">Forgot password?</a>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit">Sign in</button>
                                            {{-- <button type="button" class="btn btn-white btn-icon w-100 mb-3">
                                                <span class="btn-inner--icon me-1">
                                                    <img class="w-5" src="../assets/img/logos/google-logo.svg"
                                                        alt="google-logo" />
                                                </span>
                                                <span class="btn-inner--text">Sign in with Google</span>
                                            </button> --}}
                                        </div>
                                    </form>
                                </div>
                                <div class="register">
                                    <p>
                                        Don't have an account?
                                        <a href="{{ route('sign-up') }}">Sign up</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="position-absolute w-40 top-0 end-0 h-100 d-md-block d-none">
                                <div class="oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 bg-cover ms-n8"
                                    style="background-image:url('../assets/img/image-sign-in.jpg')">
                                    <div
                                        class="blur mt-12 p-4 text-center border border-white border-radius-md position-absolute fixed-bottom m-4">
                                        <h2 class="mt-3 text-dark font-weight-bold">Enter our global community of
                                            developers.</h2>
                                        <h6 class="text-dark text-sm mt-5">Copyright © 2022 Corporate UI Design System
                                            by Creative Tim.</h6>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            {{-- </div> --}}
        </section>
    </main>

</x-guest-layout>
