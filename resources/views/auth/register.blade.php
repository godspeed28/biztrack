@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
    <h4 class="mb-2">Daftar sekarang! 🚀</h4>
    <p class="mb-4">Kelola keuangan dan produk UMKM anda dengan lebih mudah!</p>

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

    <form id="formAuthentication" class="mb-3" action="{{ route('auth.register.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="username" class="form-label">Nama Pengguna</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                name="username" placeholder="Masukkan nama pengguna" autofocus value="{{ old('username') }}" />
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                placeholder="Masukkan email" value="{{ old('email') }}" />
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password">Kata Sandi</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" placeholder="••••••••••••" />
                <span class="input-group-text cursor-pointer">
                    <i class="bx bx-hide"></i>
                </span>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                    placeholder="••••••••••••" />
                <span class="input-group-text cursor-pointer">
                    <i class="bx bx-hide"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary d-grid w-100">
            Daftar
        </button>
    </form>

    <p class="text-center">
        <span>Sudah punya akun?</span>
        <a href="{{ route('login') }}">
            <span>Masuk di sini</span>
        </a>
    </p>
@endsection
