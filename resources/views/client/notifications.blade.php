@extends('layouts.client')

@section('title', 'Thông báo - EXTRA FIT+')

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fw-bold mb-0">Hộp thư thông báo</h1>
                <span class="badge bg-light text-dark border px-3 py-2">{{ $notifications->total() }} thông báo</span>
            </div>

            @if($notifications->isEmpty())
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                    <div class="mb-4">
                        <i class="fas fa-bell-slash display-1 text-light"></i>
                    </div>
                    <h3 class="fw-bold">Bạn chưa có thông báo nào</h3>
                    <p class="text-muted">Mọi thông tin quan trọng về lịch tập và ưu đãi sẽ xuất hiện ở đây.</p>
                </div>
            @else
                <div class="list-group list-group-flush shadow-sm rounded-4 overflow-hidden border">
                    @foreach($notifications as $notification)
                        <div class="list-group-item p-4 border-0 border-bottom {{ $notification->read_at ? '' : 'bg-light' }}">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    @php
                                        $icon = 'fa-bell';
                                        $color = 'text-primary';
                                        if($notification->data['type'] === 'session_report') { $icon = 'fa-clipboard-check'; $color = 'text-success'; }
                                        if($notification->data['type'] === 'reschedule_request') { $icon = 'fa-clock'; $color = 'text-warning'; }
                                    @endphp
                                    <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                        <i class="fas {{ $icon }} {{ $color }} fs-5"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold mb-0">{{ $notification->data['title'] ?? 'Thông báo mới' }}</h6>
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="text-muted small mb-2">{{ $notification->data['message'] }}</p>
                                    
                                    @if($notification->data['type'] === 'reschedule_request' || $notification->data['type'] === 'session_report')
                                        <a href="{{ route('personal.schedule') }}" class="btn btn-link p-0 btn-sm text-decoration-none fw-bold">Xem chi tiết <i class="fas fa-chevron-right ms-1 small"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
