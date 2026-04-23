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
        <span class="text-primary font-black text-[10px] uppercase tracking-[0.3em] mb-4 inline-block">Hành trình của tôi</span>
        <h1 class="text-6xl font-black mb-4 tracking-tighter uppercase italic">Lịch biểu cá nhân</h1>
        <p class="text-slate-400 font-medium italic">Theo dõi lộ trình tập luyện và mục tiêu của bạn tại <span class="text-primary">Extra Fit+</span>.</p>
    </div>
</section>

<div class="container mx-auto px-6 -mt-10 relative z-20 max-w-5xl">
    <!-- Active Subscription Status -->
    <div class="bg-slate-900/80 backdrop-blur-3xl border border-white/10 rounded-[40px] p-8 shadow-2xl overflow-hidden relative group">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8 relative z-10">
            @if($activeSubscription)
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-primary/20 rounded-3xl flex items-center justify-center text-primary text-3xl">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-white uppercase tracking-tighter">{{ $activeSubscription->membership->name }}</h2>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                            Hết hạn: {{ $activeSubscription->end_date->format('d/m/Y') }} (Còn {{ $activeSubscription->daysRemaining() }} ngày)
                        </p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="text-center px-6 py-3 bg-white/5 rounded-2xl border border-white/5">
                        <div class="text-xl font-black text-white">{{ $activeSubscription->pt_sessions_left }}</div>
                        <div class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Buổi PT Còn Lại</div>
                    </div>
                    <div class="text-center px-6 py-3 bg-white/5 rounded-2xl border border-white/5">
                        <div class="text-xl font-black text-white">{{ $activeSubscription->progressPercent() }}%</div>
                        <div class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Tiến Độ Gói</div>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-slate-800 rounded-3xl flex items-center justify-center text-slate-500 text-3xl">
                        <i class="fas fa-ghost"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-400 uppercase tracking-tighter">Chưa có gói tập</h2>
                        <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Đăng ký ngay để bắt đầu tập luyện</p>
                    </div>
                </div>
                <a href="{{ route('client.memberships') }}" class="px-8 py-3 bg-primary text-white font-black text-xs uppercase tracking-widest rounded-xl hover:scale-105 transition-all">Mua gói ngay</a>
            @endif
        </div>
        <!-- Decorative bg -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/10 rounded-full blur-[100px] -mr-32 -mt-32"></div>
    </div>
</div>

<div class="container mx-auto px-6 py-20 max-w-5xl">

    <!-- Workout Plan Suggestion for Regular Members -->
    @if($activeSubscription && $activeSubscription->pt_sessions_left == 0)
        @php
            $dayOfWeek = date('N'); // 1 (Mon) to 7 (Sun)
            $workoutPlans = [
                1 => ['name' => 'Cơ Ngực & Tay Sau (Chest & Triceps)', 'desc' => 'Tập trung vào các bài đẩy để xây dựng khung thân trên mạnh mẽ.'],
                2 => ['name' => 'Cơ Lưng & Tay Trước (Back & Biceps)', 'desc' => 'Các bài kéo giúp cải thiện vóc dáng và độ rộng của lưng.'],
                3 => ['name' => 'Cơ Vai & Bụng (Shoulders & Abs)', 'desc' => 'Xây dựng đôi vai rộng và cơ bụng săn chắc.'],
                4 => ['name' => 'Cơ Chân & Mông (Legs & Glutes)', 'desc' => 'Đừng bao giờ bỏ qua ngày tập chân! Đây là nhóm cơ lớn nhất cơ thể.'],
                5 => ['name' => 'Cardio & Hoạt động nhẹ', 'desc' => 'Chạy bộ hoặc đạp xe nhẹ nhàng để đốt cháy calo dư thừa.'],
                6 => ['name' => 'Toàn thân (Full Body)', 'desc' => 'Tổng hợp các bài tập đa khớp để kích hoạt toàn bộ cơ bắp.'],
                7 => ['name' => 'Nghỉ ngơi hồi phục', 'desc' => 'Hãy để cơ bắp của bạn được nghỉ ngơi và phát triển.'],
            ];
            $todayPlan = $workoutPlans[$dayOfWeek];
        @endphp
        <div class="mb-12 bg-indigo-500/10 border border-indigo-500/20 rounded-[30px] p-8 flex flex-col md:flex-row items-center gap-8">
            <div class="w-20 h-20 bg-indigo-500/20 rounded-2xl flex items-center justify-center text-indigo-400 text-3xl shrink-0">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="flex-grow">
                <div class="flex items-center gap-3 mb-2">
                    <h3 class="text-xl font-black text-white uppercase tracking-tight italic">Giáo án hôm nay</h3>
                    <span class="px-3 py-1 bg-indigo-500 text-white text-[8px] font-black uppercase rounded-lg">Gói tập tự do</span>
                </div>
                <h4 class="text-indigo-400 font-bold mb-1">{{ $todayPlan['name'] }}</h4>
                <p class="text-slate-400 text-sm italic leading-relaxed">{{ $todayPlan['desc'] }}</p>
            </div>
            <button class="px-6 py-3 bg-indigo-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-indigo-600 transition-all shrink-0">Xem chi tiết</button>
        </div>
    @endif
    
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-500 p-4 rounded-2xl mb-8 flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if($bookings->isEmpty())
        <div class="text-center py-24 bg-white/5 backdrop-blur-md rounded-[40px] border border-white/5">
            <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-8 text-primary shadow-2xl shadow-primary/20">
                <i class="fas fa-calendar-alt text-4xl"></i>
            </div>
            <h3 class="text-2xl font-black text-white mb-4 uppercase tracking-tighter">CHƯA CÓ LỊCH TẬP</h3>
            <p class="text-slate-400 mb-10 max-w-sm mx-auto text-sm font-medium leading-relaxed">
                Bạn chưa có lịch tập nào được ghi nhận. 
                <br><br>
                <span class="text-primary font-bold">Lưu ý:</span> Sau khi mua gói tập, bạn cần vào mục <span class="text-white">"Lịch Lớp"</span> để tự chọn và đăng ký các buổi học phù hợp.
            </p>
            <a href="{{ route('schedule') }}" class="inline-flex items-center gap-3 px-10 py-4 bg-primary text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-primary-dark transition-all shadow-xl shadow-primary/20">
                KHÁM PHÁ LỊCH LỚP <i class="fas fa-arrow-right"></i>
            </a>
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
                                    {{ $booking->booking_type === 'pt_session' ? 'Buổi tập PT' : 'Lớp tập thể' }}
                                </span>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="flex-grow">
                            <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-4">
                                {{ $booking->booking_type === 'pt_session' ? 'Luyện tập cùng Coach' : ($booking->schedule?->title ?? 'Lớp học nhóm') }}
                            </h3>
                            
                            <div class="flex items-center gap-4">
                                <img src="{{ $booking->trainer?->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($booking->trainer?->name ?? 'T').'&background=FF6B35&color=fff' }}" 
                                     class="trainer-avatar-sm" alt="Coach">
                                <div>
                                    <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Coach</div>
                                    <div class="text-sm font-bold text-white">{{ $booking->trainer?->name ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Action -->
                        <div class="text-right flex flex-col items-end gap-4 min-w-[150px]">
                            <span class="status-badge status-{{ $booking->status }}">
                                @switch($booking->status)
                                    @case('confirmed') Xác nhận @break
                                    @case('completed') Hoàn thành @break
                                    @case('cancelled') Đã hủy @break
                                    @default {{ $booking->status }}
                                @endswitch
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
                    @if($booking->reschedule_status === 'pending')
                        <div class="bg-primary/5 border-t border-primary/10 p-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-black text-primary uppercase tracking-widest">Yêu cầu đổi lịch</div>
                                    <div class="text-sm text-slate-400">Coach đề xuất đổi sang: <span class="text-white font-bold">{{ \Carbon\Carbon::parse($booking->reschedule_at)->format('H:i d/m') }}</span></div>
                                </div>
                            </div>
                            <a href="{{ route('notifications.index') }}" class="px-6 py-2 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-full">Phản hồi</a>
                        </div>
                    @endif

                    @if($booking->report_content)
                        <div class="bg-slate-800/50 border-t border-white/5 p-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-500 shrink-0">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="flex-grow">
                                    <div class="flex justify-between items-center mb-1">
                                        <div class="text-xs font-black text-emerald-500 uppercase tracking-widest">Báo cáo buổi tập</div>
                                        <div class="flex gap-1 text-[10px]">
                                            @for($i=1; $i<=10; $i++)
                                                <i class="fas fa-bolt {{ $i <= $booking->effort_rating ? 'text-primary' : 'text-slate-700' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-sm text-slate-400 italic">"{{ $booking->report_content }}"</p>
                                    <div class="mt-2 flex gap-4">
                                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Cường độ: <span class="text-slate-300">{{ $booking->session_intensity }}</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
@endsection
