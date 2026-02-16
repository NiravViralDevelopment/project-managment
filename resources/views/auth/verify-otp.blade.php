<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify OTP - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-100 d-flex align-items-center justify-content-center p-3">
    <div class="w-100" style="max-width: 400px;">
        <div class="card shadow">
            <div class="card-body p-4">
                <h1 class="h4 text-center mb-2">OTP Verification</h1>
                <p class="text-center text-muted small mb-4">Enter the 6-digit code sent to your email</p>
                @if (!isset($pendingVerification) || !$pendingVerification)
                    <div class="alert alert-info small">
                        <strong>Temporary:</strong> Please <a href="{{ route('login') }}">log in</a> first to receive an OTP by email, then you will be redirected here to enter it.
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                @if (!empty($otpDisplay))
                    <div class="alert alert-primary d-flex align-items-center justify-content-between">
                        <span class="small">Your OTP (enter below):</span>
                        <strong class="fs-4" style="letter-spacing: 0.2em;">{{ $otpDisplay }}</strong>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('verify-otp') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="otp" class="form-label">Verification code</label>
                        <input type="text" name="otp" id="otp" value="{{ old('otp') }}" required autofocus
                               maxlength="6" pattern="[0-9]*" inputmode="numeric" placeholder="000000"
                               class="form-control form-control-lg text-center @error('otp') is-invalid @enderror"
                               style="letter-spacing: 0.5em;">
                        @error('otp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Verify & sign in</button>
                </form>
                <p class="text-center mt-3 mb-0">
                    <a href="{{ route('login') }}" class="text-muted small">Back to login</a>
                </p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var otpInput = document.getElementById('otp');
        @if(!empty($otpDisplay))
        otpInput.value = '{{ $otpDisplay }}';
        @endif
        otpInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').slice(0, 6);
        });
    </script>
</body>
</html>
