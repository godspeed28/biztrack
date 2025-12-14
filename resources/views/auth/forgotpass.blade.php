@extends('layouts.app')

@section('title', 'Lupa Kata Sandi')

@section('content')
    <h4 class="mb-2">Lupa Kata Sandi? 🔒</h4>
    <p class="mb-4">Masukkan email Anda dan kami akan mengirimkan instruksi untuk mengatur ulang kata sandi</p>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-error-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <!-- Rate Limiting Alert -->
    @if ($errors->has('email') && Str::contains($errors->first('email'), 'Too many reset attempts'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bx bx-time me-2"></i>
            Terlalu banyak percobaan reset. Silakan coba lagi beberapa saat.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <form id="formAuthentication" class="mb-3" action="{{ route('auth.forgotpass.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                placeholder="Masukkan email Anda" autofocus value="{{ old('email') }}" />
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary d-grid w-100" id="submit-btn">
            <span class="spinner-border spinner-border-sm me-2 d-none" id="spinner"></span>
            <span id="btn-text">Kirim Tautan Reset</span>
        </button>
    </form>

    <div class="text-center">
        <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
            <i class="bx bx-chevron-left scaleX-n1-rtl"></i>
            Kembali ke halaman masuk
        </a>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Loading state saat submit form
            const form = document.getElementById('formAuthentication');
            const submitBtn = document.getElementById('submit-btn');
            const spinner = document.getElementById('spinner');
            const btnText = document.getElementById('btn-text');

            if (form && submitBtn) {
                form.addEventListener('submit', function() {
                    submitBtn.disabled = true;
                    spinner.classList.remove('d-none');
                    btnText.textContent = 'Mengirim...';
                });
            }

            // Auto-focus ke field email jika ada error
            @if ($errors->has('email'))
                const emailField = document.getElementById('email');
                if (emailField) {
                    emailField.focus();
                }
            @endif
        });
    </script>
@endsection
