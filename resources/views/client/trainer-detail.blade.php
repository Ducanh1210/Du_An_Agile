@extends('layouts.client')

@section('title', $trainer->user->name . ' — Elite Coach')

@section('styles')
<style>
    :root {
        --p-color: #FF6B35;
        --p-glow: rgba(255, 107, 53, 0.4);
    }

    body { background: #0f172a; color: #fff; }

    .premium-glass {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* Hero Section */
    .trainer-detail-hero {
        position: relative;
        padding: 100px 0;
        overflow: hidden;
    }
    .hero-bg-blur {
        position: absolute;
        top: 0; right: 0;
        width: 60%; height: 100%;
        background: radial-gradient(circle at 70% 30%, var(--p-glow) 0%, transparent 70%);
        filter: blur(100px);
        z-index: 0;
    }

    .trainer-profile-img {
        width: 400px;
        height: 500px;
        object-fit: cover;
        border-radius: 40px;
        box-shadow: 0 40px 80px rgba(0,0,0,0.5);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Booking Sidebar */
    .booking-sidebar {
        position: sticky;
        top: 100px;
        padding: 40px;
        border-radius: 40px;
    }

    .time-slot-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-top: 20px;
    }
    .time-slot {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 12px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .time-slot:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: var(--p-color);
    }
    .time-slot.active {
        background: var(--p-color);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 5px 15px var(--p-glow);
    }

    .btn-submit-booking {
        width: 100%;
        padding: 20px;
        border-radius: 20px;
        background: var(--p-color);
        color: #fff;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 30px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px var(--p-glow);
    }
    .btn-submit-booking:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px var(--p-glow);
    }
    .btn-submit-booking:disabled {
        background: #334155;
        box-shadow: none;
        cursor: not-allowed;
        opacity: 0.5;
    }

    /* Input Styling */
    .premium-input {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        padding: 16px;
        border-radius: 16px;
        width: 100%;
        outline: none;
        transition: all 0.3s ease;
    }
    .premium-input:focus {
        border-color: var(--p-color);
        background: rgba(255, 255, 255, 0.05);
    }

    /* Animations */
    @keyframes slideRight {
        from { opacity: 0; transform: translateX(-50px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-right { animation: slideRight 0.8s cubic-bezier(0.19, 1, 0.22, 1) forwards; }
</style>
@endsection

@section('content')
<div class="trainer-detail-hero">
    <div class="hero-bg-blur"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col lg:flex-row gap-20">
            
            <!-- Sidebar: Avatar & Info -->
            <div class="lg:w-1/3 animate-right">
                <img src="{{ $trainer->user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($trainer->user->name).'&background=FF6B35&color=fff&size=800' }}" 
                     class="trainer-profile-img mb-10" alt="{{ $trainer->user->name }}">
                
                <h1 class="text-5xl font-black mb-4 uppercase tracking-tighter">{{ $trainer->user->name }}</h1>
                <div class="flex items-center gap-4 mb-8">
                    <span class="px-4 py-1.5 rounded-full bg-white/10 border border-white/10 text-[10px] font-black uppercase tracking-widest">
                        Certified Coach
                    </span>
                    <span class="text-primary font-bold text-xs">Gym & Fitness Expert</span>
                </div>

                <div class="space-y-6 text-slate-400 leading-relaxed">
                    <p>Với hơn 5 năm kinh nghiệm thực chiến trong việc thay đổi hình thể, Coach {{ $trainer->user->name }} nổi tiếng với phương pháp huấn luyện khoa học, kết hợp giữa dinh dưỡng và cường độ tập luyện khắt khe.</p>
                    <p>Mục tiêu của {{ $trainer->user->name }} không chỉ là giúp bạn đẹp hơn, mà là xây dựng một lối sống kỉ luật và bền bỉ.</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-12">
                    <div class="premium-glass p-6 rounded-[30px] text-center">
                        <div class="text-3xl font-black text-white">200+</div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase mt-1">Hội viên</div>
                    </div>
                    <div class="premium-glass p-6 rounded-[30px] text-center">
                        <div class="text-3xl font-black text-white">4.9/5</div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase mt-1">Đánh giá</div>
                    </div>
                </div>
            </div>

            <!-- Main: Booking Interface -->
            <div class="lg:w-2/3">
                <div class="premium-glass booking-sidebar" x-data="ptBooking()">
                    <h2 class="text-3xl font-black mb-2 uppercase italic tracking-tighter">Đặt lịch tập 1-Kèm-1</h2>
                    <p class="text-slate-500 text-sm mb-8 font-medium">Chọn thời gian phù hợp để bắt đầu hành trình của bạn.</p>

                    @php
                        $subscription = auth()->user()->subscriptions()
                            ->where('status', 'active')
                            ->where('pt_sessions_left', '>', 0)
                            ->first();
                    @endphp

                    @if($subscription)
                        <div class="flex items-center gap-3 p-4 bg-primary/10 rounded-2xl border border-primary/20 mb-10">
                            <i class="fas fa-bolt text-primary"></i>
                            <span class="text-xs font-black uppercase tracking-widest text-primary">
                                Bạn còn {{ $subscription->pt_sessions_left }} buổi PT khả dụng
                            </span>
                        </div>

                        <form action="{{ route('pt-bookings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="trainer_id" value="{{ $trainer->id }}">
                            <input type="hidden" name="time_slot" x-model="selectedSlot">

                            <div class="space-y-8">
                                <div>
                                    <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-3">1. Chọn ngày tập luyện</label>
                                    <input type="date" name="date" class="premium-input" x-model="selectedDate" min="{{ date('Y-m-d') }}">
                                </div>

                                <div>
                                    <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-3">2. Chọn khung giờ (1 giờ/buổi)</label>
                                    <div class="time-slot-grid">
                                        <template x-for="slot in slots">
                                            <div class="time-slot" 
                                                 :class="{ 'active': selectedSlot === slot }"
                                                 @click="selectedSlot = slot"
                                                 x-text="slot"></div>
                                        </template>
                                    </div>
                                </div>

                                <button type="submit" 
                                        class="btn-submit-booking" 
                                        :disabled="!selectedSlot || !selectedDate">
                                    Xác nhận đăng ký buổi tập
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-10 bg-slate-800/50 rounded-3xl border border-white/5">
                            <div class="text-slate-600 mb-4"><i class="fas fa-lock text-4xl"></i></div>
                            <h3 class="text-lg font-bold text-white mb-2">Bạn chưa có buổi PT nào</h3>
                            <p class="text-slate-500 text-sm max-w-xs mx-auto mb-6">Vui lòng mua thêm gói luyện tập kèm HLV để sử dụng tính năng này.</p>
                            <a href="{{ route('client.memberships') }}" class="inline-block px-8 py-3 rounded-full bg-white text-slate-900 font-black text-xs uppercase tracking-widest hover:bg-primary hover:text-white transition-all">
                                Mua gói tập ngay
                            </a>
                        </div>
                    @endif

                    <div class="mt-10 pt-10 border-t border-white/5">
                        <h4 class="text-white font-black text-xs uppercase tracking-widest mb-4">Lưu ý khi đặt lịch</h4>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3 text-sm text-slate-500">
                                <i class="fas fa-check-circle text-primary mt-1"></i>
                                <span>Bạn có thể hủy hoặc đổi lịch trước giờ tập ít nhất 2 tiếng.</span>
                            </li>
                            <li class="flex items-start gap-3 text-sm text-slate-500">
                                <i class="fas fa-check-circle text-primary mt-1"></i>
                                <span>Buổi tập sẽ tự động trừ khi huấn luyện viên xác nhận check-in.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function ptBooking() {
        return {
            selectedDate: '{{ date('Y-m-d') }}',
            selectedSlot: '',
            slots: [
                '08:00', '09:00', '10:00', '11:00',
                '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'
            ]
        }
    }
</script>
@endsection
