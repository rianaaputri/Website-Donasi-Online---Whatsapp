@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4>Verifikasi OTP</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('verify.otp') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="otp" class="form-label">Kode OTP</label>
                            <input type="text" class="form-control @error('otp') is-invalid @enderror" 
                                   id="otp" name="otp" placeholder="Masukkan 6 digit OTP" required>
                            @error('otp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Verifikasi</button>
                    </form>

                    <form method="POST" action="{{ route('resend.otp') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-link w-100">Kirim Ulang OTP</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
