@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
    <h4 class="mb-2">Selamat datang di BizTrack! 👋</h4>
    <p class="mb-4">Silakan masuk ke akun anda untuk memulai</p>

    <form id="formAuthentication" class="mb-3" action="{{ route('auth.login.submit') }}" method="POST">
        @csrf

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <!-- Rate Limiting Alert -->
        @if ($errors->has('login') && Str::contains($errors->first('login'), 'Too many login attempts'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Terlalu banyak percobaan login. Silakan coba lagi beberapa saat.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <!-- Login field -->
        <div class="mb-3">
            <label for="login" class="form-label">Email atau Username</label>
            <input type="text" class="form-control @error('login') is-invalid @enderror" id="login" name="login"
                placeholder="Masukkan email atau username" autofocus value="{{ old('login') }}" />
            @error('login')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password field -->
        <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Kata Sandi</label>
                <a href="{{ route('auth.forgotpass') }}">
                    <small>Lupa Kata Sandi?</small>
                </a>
            </div>

            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" placeholder="••••••••••••" aria-describedby="password" />
                <span class="input-group-text cursor-pointer">
                    <i class="bx bx-hide"></i>
                </span>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Remember Me -->
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me" name="remember"
                    {{ old('remember') ? 'checked' : '' }} />
                <label class="form-check-label" for="remember-me">
                    Ingat Saya
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary d-grid w-100" id="submit-btn">
                <span class="spinner-border spinner-border-sm me-2 d-none" id="spinner"></span>
                <span id="btn-text">Masuk</span>
            </button>
        </div>
    </form>

    <p class="text-center">
        <span>Belum punya akun?</span>
        <a href="{{ route('auth.register') }}">
            <span>Daftar sekarang</span>
        </a>
    </p>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const toggleIcons = document.querySelectorAll('.input-group-text.cursor-pointer');

            toggleIcons.forEach(icon => {
                icon.addEventListener('click', function() {
                    const passwordInput = this.parentElement.querySelector('input');
                    const iconElement = this.querySelector('i');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        iconElement.classList.replace('bx-hide', 'bx-show');
                    } else {
                        passwordInput.type = 'password';
                        iconElement.classList.replace('bx-show', 'bx-hide');
                    }
                });
            });

            // Loading state saat submit form
            const form = document.getElementById('formAuthentication');
            const submitBtn = document.getElementById('submit-btn');
            const spinner = document.getElementById('spinner');
            const btnText = document.getElementById('btn-text');

            if (form && submitBtn) {
                form.addEventListener('submit', function() {
                    submitBtn.disabled = true;
                    spinner.classList.remove('d-none');
                    btnText.textContent = 'Sedang masuk...';
                });
            }

            // Auto-focus ke field login jika ada error
            @if ($errors->has('login') || $errors->has('password'))
                const loginField = document.getElementById('login');
                if (loginField) {
                    loginField.focus();
                }
            @endif
        });
    </script>
@endsection
