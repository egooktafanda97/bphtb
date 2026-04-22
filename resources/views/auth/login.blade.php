<x-guest-layout>
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Masuk ke Akun Anda</h2>
            
            @if (session('status'))
                <div class="alert alert-success mb-4 text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" autocomplete="off" novalidate>
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label class="form-label">{{ __('Email') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="your@email.com" required autofocus autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-2">
                    <label class="form-label">
                        {{ __('Password') }}
                        @if (Route::has('password.request'))
                            <span class="form-label-description">
                                <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                            </span>
                        @endif
                    </label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Your password" required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="mb-2">
                    <label class="form-check">
                        <input id="remember_me" type="checkbox" name="remember" class="form-check-input" />
                        <span class="form-check-label">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Log in') }}</button>
                </div>
            </form>
        </div>
        <div class="hr-text">atau</div>
        <div class="card-body pb-3">
            <div class="text-center text-secondary">
                Belum punya akun? <a href="{{ route('register') }}" tabindex="-1">Daftar sekarang</a>
            </div>
        </div>
    </div>
</x-guest-layout>
