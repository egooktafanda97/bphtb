<x-guest-layout>
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Daftar Akun Baru</h2>
            <form method="POST" action="{{ route('register') }}" autocomplete="off" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label required">Tipe Akun</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror">
                        <option value="wajib_pajak" {{ old('role') == 'wajib_pajak' ? 'selected' : '' }}>Wajib Pajak (Individu/Badan)</option>
                        <option value="ppat" {{ old('role') == 'ppat' ? 'selected' : '' }}>PPAT / Notaris</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label required">{{ __('Name') }}</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap" required autofocus autocomplete="name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label required">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" class="form-control @error('nik') is-invalid @enderror" placeholder="16 Digit NIK" required maxlength="16">
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label required">Nomor Telepon/WA</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="Contoh: 08123456789" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label required">{{ __('Email') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="your@email.com" required autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label required">{{ __('Password') }}</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="new-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label required">{{ __('Confirm Password') }}</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required autocomplete="new-password">
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
                </div>
            </form>
        </div>
        <div class="hr-text">atau</div>
        <div class="card-body pb-3">
            <div class="text-center text-secondary">
                Sudah punya akun? <a href="{{ route('login') }}" tabindex="-1">Masuk sekarang</a>
            </div>
        </div>
    </div>
</x-guest-layout>
