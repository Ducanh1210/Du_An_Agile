@extends('layouts.client')

@section('title', 'Xác nhận Email')

@section('styles')
<style>
.verify-form {
    max-width: 500px;
    margin: 2rem auto;
    padding: 2rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    text-align: center;
}

.verify-form h2 {
    margin-bottom: 1rem;
    color: #333;
}

.verify-form p {
    margin-bottom: 1.5rem;
    color: #666;
    line-height: 1.6;
}

.btn-primary {
    padding: 0.75rem 1.5rem;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
}

.btn-primary:hover {
    background: #0056b3;
}

.resend-form {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #eee;
}

.resend-form p {
    margin-bottom: 1rem;
}

.resend-btn {
    background: #28a745;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
}

.resend-btn:hover {
    background: #218838;
}
</style>
@endsection

@section('content')
<div class="verify-form">
    <h2>Xác nhận Email</h2>

    <p>
        Trước khi tiếp tục, vui lòng kiểm tra email của bạn để xác nhận tài khoản.
        Nếu bạn không nhận được email, chúng tôi có thể gửi lại.
    </p>

    <p>
        <strong>{{ auth()->user()->email }}</strong>
    </p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf

        <button type="submit" class="btn-primary">
            Gửi lại email xác nhận
        </button>
    </form>

    <div class="resend-form">
        <p>Đã xác nhận? <a href="{{ route('client.login') }}">Đăng nhập lại</a></p>

        <form method="POST" action="{{ route('client.logout') }}">
            @csrf
            <button type="submit" class="resend-btn">
                Đăng xuất
            </button>
        </form>
    </div>
</div>
@endsection