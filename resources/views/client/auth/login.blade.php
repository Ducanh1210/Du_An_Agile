@extends('layouts.client')

@section('title', 'Đăng nhập')

@section('styles')
<style>
.auth-form {
    max-width: 400px;
    margin: 2rem auto;
    padding: 2rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.auth-form h2 {
    text-align: center;
    margin-bottom: 1.5rem;
    color: #333;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.form-group input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.form-group input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}

.btn-primary {
    width: 100%;
    padding: 0.75rem;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    margin-top: 1rem;
}

.btn-primary:hover {
    background: #0056b3;
}

.auth-links {
    text-align: center;
    margin-top: 1rem;
}

.auth-links a {
    color: #007bff;
    text-decoration: none;
}

.auth-links a:hover {
    text-decoration: underline;
}

.error-message {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
</style>
@endsection

@section('content')
<div class="auth-form">
    <h2>Đăng nhập</h2>

    <!-- Session Status -->
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('client.login') }}">
        @csrf

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-group">
            <label>
                <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
            </label>
        </div>

        <button type="submit" class="btn-primary">Đăng nhập</button>
    </form>

    <div class="auth-links">
        <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
        <br>
        <a href="{{ route('client.register') }}">Chưa có tài khoản? Đăng ký</a>
    </div>
</div>
@endsection