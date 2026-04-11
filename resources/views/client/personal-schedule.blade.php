@extends('layouts.client')

@section('title', 'Lịch cá nhân - EXTRA FIT+')

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold mb-3" style="color: var(--primary);">Lịch cá nhân</h1>
            <p class="text-muted">Theo dõi các lớp học và buổi tập PT của bạn.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 mx-auto">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($bookings->isEmpty())
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                    <div class="mb-4">
                        <i class="fas fa-calendar-times display-1 text-light"></i>
                    </div>
                    <h3 class="fw-bold">Bạn chưa có lịch tập nào</h3>
                    <p class="text-muted">Hãy tham khảo các lớp học hoặc đăng ký PT để bắt đầu nhé!</p>
                    <div class="mt-4">
                        <a href="{{ route('schedule') }}" class="btn btn-primary px-4 py-2">Xem lịch lớp</a>
                    </div>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($bookings as $booking)
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="row g-0">
                                <div class="col-md-3 bg-light d-flex flex-column justify-content-center align-items-center p-4 border-end">
                                    <div class="text-center">
                                        <div class="h2 fw-bold mb-0 text-primary">{{ $booking->start_time->format('H:i') }}</div>
                                        <div class="text-muted small">{{ $booking->start_time->format('d/m/Y') }}</div>
                                        <div class="mt-2">
                                            @if($booking->booking_type === 'pt_session')
                                                <span class="badge bg-warning text-dark">PT Session</span>
                                            @else
                                                <span class="badge bg-info text-dark">Lớp học</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h4 class="fw-bold mb-1">
                                                {{ $booking->booking_type === 'pt_session' ? 'Tập cùng PT' : ($booking->schedule?->title ?? 'Lớp học') }}
                                            </h4>
                                            <p class="text-muted mb-0">
                                                <i class="fas fa-user-tie me-2"></i>
                                                HLV: <strong>{{ $booking->trainer?->user?->name ?? 'N/A' }}</strong>
                                            </p>
                                        </div>
                                        <div>
                                            @php
                                                $statusClasses = [
                                                    'confirmed' => 'bg-primary',
                                                    'completed' => 'bg-success',
                                                    'cancelled' => 'bg-danger'
                                                ];
                                            @endphp
                                            <span class="badge {{ $statusClasses[$booking->status] }} px-3 py-2">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    @if($booking->rescheduleRequests->isNotEmpty())
                                        @foreach($booking->rescheduleRequests as $request)
                                            <div class="alert alert-warning border-0 rounded-3 p-3 mt-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="fw-bold mb-1 underline"><i class="fas fa-clock me-2"></i> Yêu cầu đổi lịch từ PT</h6>
                                                        <p class="small mb-0">
                                                            PT muốn đổi từ <strong>{{ $request->original_start_time->format('H:i d/m') }}</strong> 
                                                            sang <strong>{{ $request->new_start_time->format('H:i d/m') }}</strong>.
                                                        </p>
                                                        <p class="small italic text-muted mt-1">Lý do: "{{ $request->reason }}"</p>
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <form action="{{ route('reschedule.respond', $request->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="action" value="approve">
                                                            <button type="submit" class="btn btn-success btn-sm px-3">Đồng ý</button>
                                                        </form>
                                                        <form action="{{ route('reschedule.respond', $request->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="action" value="reject">
                                                            <button type="submit" class="btn btn-outline-danger btn-sm px-3">Từ chối</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if($booking->sessionReport)
                                        <div class="mt-4 p-3 bg-light rounded-3 border-start border-4 border-success">
                                            <h6 class="fw-bold text-success mb-2"><i class="fas fa-clipboard-check me-2"></i> Báo cáo sau buổi tập</h6>
                                            <p class="small mb-2 fst-italic">"{{ $booking->sessionReport->notes }}"</p>
                                            <div class="d-flex gap-3 small">
                                                <span><i class="fas fa-bolt text-warning me-1"></i> Nỗ lực: <strong>{{ $booking->sessionReport->effort_rating }}/10</strong></span>
                                                <span><i class="fas fa-fire text-danger me-1"></i> Cường độ: <strong>{{ $booking->sessionReport->session_intensity }}</strong></span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>

<style>
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-5px); }
    .display-1 { font-size: 5rem; opacity: 0.1; }
    .space-y-4 > * + * { margin-top: 1.5rem; }
</style>
@endsection
