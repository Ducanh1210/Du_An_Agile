@extends('layouts.client')

@section('title', '404 - Trang không tìm thấy')

@section('content')
<div class="container" style="padding: 100px 0; text-align: center;">
    <div style="font-size: 120px; font-weight: 900; background: linear-gradient(135deg, var(--color-primary), #FF9A5C); -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1;">404</div>
    <h1 style="font-size: 32px; font-weight: 800; margin: 24px 0; color: var(--color-text);">Úi! Trang này không tồn tại</h1>
    <p style="color: var(--color-text-muted); font-size: 18px; max-width: 600px; margin: 0 auto 40px;">Có vẻ như liên kết bạn đang truy cập đã bị hỏng hoặc trang web đã được di chuyển sang một địa chỉ khác.</p>
    <a href="{{ url('/') }}" class="btn btn-primary" style="padding: 14px 32px; font-weight: 700; border-radius: 50px;">Quay lại trang chủ</a>
</div>
@endsection
