@section('styles')
<style>
    :root {
        --p-color: #FF6B35;
        --p-glow: rgba(255, 107, 53, 0.4);
    }
    body { background: #0f172a; color: #fff; }
    
    .schedule-hero {
        padding: 80px 0;
        background: radial-gradient(circle at 50% 100%, #1e293b, #0f172a);
    }
    
    .booking-premium-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 30px;
        overflow: hidden;
        margin-bottom: 24px;
        transition: all 0.3s ease;
        position: relative;
    }
    .booking-premium-card:hover {
        transform: scale(1.01);
        border-color: rgba(255, 107, 53, 0.3);
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    .booking-type-indicator {
        position: absolute;
        top: 0; left: 0;
        width: 6px; height: 100%;
    }
    .indicator-pt { background: var(--p-color); box-shadow: 4px 0 15px var(--p-glow); }
    .indicator-class { background: #6366f1; box-shadow: 4px 0 15px rgba(99, 102, 241, 0.4); }

    .status-badge {
        font-size: 10px;
        font-weight: 900;
        padding: 6px 16px;
        border-radius: 100px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .status-confirmed { background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.1); }
    .status-completed { background: rgba(34, 197, 94, 0.1); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.2); }
    .status-cancelled { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }

    .trainer-avatar-sm {
        width: 48px; height: 48px;
        border-radius: 16px;
        object-fit: cover;
    }
</style>
@endsection

@section('content')
<section class="schedule-hero">
    <div class="container mx-auto px-6 text-center">
        <span class="text-primary font-black text-[10px] uppercase tracking-[0.3em] mb-4 inline-block">My Journey</span>
        <h1 class="text-6xl font-black mb-4 tracking-tighter uppercase italic">Lịch biểu cá nhân</h1>
        <p class="text-slate-400 font-medium">Theo dõi các lớp học và buổi tập PT của bạn tại Extra Fit.</p>
    </div>
</section>

<div class="container mx-auto px-6 py-20 max-w-5xl">
    
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-500 p-4 rounded-2xl mb-8 flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if($bookings->isEmpty())
        <div class="text-center py-20 premium-glass rounded-[40px]">
            <div class="text-slate-700 text-6xl mb-6"><i class="fas fa-calendar-alt"></i></div>
            <h3 class="text-xl font-black text-white mb-2">CHƯA CÓ LỊCH TẬP</h3>
            <p class="text-slate-500 mb-8 max-w-xs mx-auto text-sm">Hãy bắt đầu bằng việc đăng ký các lớp học hoặc đặt chỗ cùng huấn luyện viên.</p>
            <a href="{{ route('schedule') }}" class="inline-block px-8 py-3 bg-white text-slate-900 font-black text-xs uppercase tracking-widest rounded-full hover:bg-primary hover:text-white transition-all">KHÁM PHÁ NGAY</a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($bookings as $booking)
                <div class="booking-premium-card group">
                    <div class="booking-type-indicator {{ $booking->booking_type === 'pt_session' ? 'indicator-pt' : 'indicator-class' }}"></div>
                    
                    <div class="p-8 flex flex-col md:flex-row items-center gap-10">
                        <!-- Time/Date -->
                        <div class="text-center min-w-[120px]">
                            <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">
                                {{ $booking->start_time->format('D, d M') }}
                            </div>
                            <div class="text-4xl font-black text-white italic">
                                {{ $booking->start_time->format('H:i') }}
                            </div>
                            <div class="mt-3">
                                <span class="text-[9px] font-black uppercase tracking-widest {{ $booking->booking_type === 'pt_session' ? 'text-primary' : 'text-indigo-400' }}">
                                    {{ $booking->booking_type === 'pt_session' ? 'PT Session' : 'Group Class' }}
                                </span>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="flex-grow">
                            <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-4">
                                {{ $booking->booking_type === 'pt_session' ? 'Personal Training' : ($booking->schedule?->title ?? 'Group Class') }}
                            </h3>
                            
                            <div class="flex items-center gap-4">
                                <img src="{{ $booking->trainer?->user?->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($booking->trainer?->user?->name ?? 'T').'&background=FF6B35&color=fff' }}" 
                                     class="trainer-avatar-sm" alt="Coach">
                                <div>
                                    <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Coach</div>
                                    <div class="text-sm font-bold text-white">{{ $booking->trainer?->user?->name ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Action -->
                        <div class="text-right flex flex-col items-end gap-4 min-w-[150px]">
                            <span class="status-badge status-{{ $booking->status }}">
                                {{ $booking->status }}
                            </span>

                            @if($booking->status === 'confirmed' && now()->diffInHours($booking->start_time, false) >= 2)
                                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy lịch tập này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[10px] font-black text-slate-500 uppercase tracking-widest hover:text-red-500 transition-colors">
                                        Hủy lịch tập
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Reschedule Request & Report areas (Collapsed/Conditional) -->
                    @if($booking->rescheduleRequests->where('status', 'pending')->isNotEmpty())
                        <div class="bg-primary/5 border-t border-primary/10 p-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-black text-primary uppercase tracking-widest">Yêu cầu đổi lịch</div>
                                    <div class="text-sm text-slate-400">Coach đề xuất khung giờ mới</div>
                                </div>
                            </div>
                            <a href="{{ route('notifications.index') }}" class="px-6 py-2 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-full">Phản hồi</a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
@endsection
