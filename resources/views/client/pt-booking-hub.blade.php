@extends('layouts.client')

@section('title', 'PT Booking Hub — Elite Personal Training')

@section('styles')
<style>
    :root {
        --p-color: #FF6B35;
        --p-glow: rgba(255, 107, 53, 0.4);
        --bg-dark: #0f172a;
    }

    body { background: var(--bg-dark); color: #fff; }

    .premium-glass {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* --- Hero & Stats --- */
    .hub-hero {
        position: relative;
        padding: 80px 0 40px;
        background: radial-gradient(circle at 70% 30%, rgba(255,107,53,0.1) 0%, transparent 50%);
    }

    /* --- Date Scroller --- */
    .date-scroller {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding: 20px 0;
        scrollbar-width: none;
    }
    .date-scroller::-webkit-scrollbar { display: none; }

    .date-card {
        flex: 0 0 100px;
        padding: 20px 10px;
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        text-align: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .date-card:hover { border-color: var(--p-color); }
    .date-card.active {
        background: var(--p-color);
        border-color: transparent;
        box-shadow: 0 10px 25px var(--p-glow);
    }
    .date-card .day-name { font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; }
    .date-card.active .day-name { color: rgba(255,255,255,0.8); }
    .date-card .day-num { font-size: 24px; font-weight: 900; margin: 4px 0; }
    .date-card .month-label { font-size: 10px; font-weight: 700; color: #64748b; }
    .date-card.active .month-label { color: rgba(255,255,255,0.8); }

    /* --- Trainer Selection --- */
    .trainer-hub-card {
        border-radius: 32px;
        overflow: hidden;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    .trainer-hub-grid {
        display: grid;
        grid-template-columns: 350px 1fr;
        min-height: 450px;
    }

    .trainer-info-panel {
        padding: 40px;
        background: rgba(255,255,255,0.02);
        border-right: 1px solid rgba(255,255,255,0.05);
        display: flex;
        flex-direction: column;
    }
    .trainer-hub-img {
        width: 120px; height: 120px;
        border-radius: 30px;
        object-fit: cover;
        margin-bottom: 20px;
        border: 2px solid var(--p-color);
    }

    /* --- Time Slot Grid --- */
    .booking-panel {
        padding: 40px;
        display: flex;
        flex-direction: column;
    }
    .slot-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }
    .slot-btn {
        padding: 16px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        color: #94a3b8;
        font-weight: 800;
        text-align: center;
        transition: all 0.2s ease;
    }
    .slot-btn:not(:disabled):hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: var(--p-color);
        color: #fff;
    }
    .slot-btn.selected {
        background: var(--p-color);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 5px 15px var(--p-glow);
    }
    .slot-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }
    .slot-btn.booked {
        background: rgba(239, 68, 68, 0.1);
        border-color: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }
    .slot-btn.class-busy {
        background: rgba(234, 179, 8, 0.1);
        border-color: rgba(234, 179, 8, 0.2);
        color: #eab308;
    }

    /* --- Subscription Status --- */
    .sub-badge {
        padding: 12px 24px;
        border-radius: 100px;
        background: rgba(255, 107, 53, 0.1);
        border: 1px solid rgba(255, 107, 53, 0.2);
        color: var(--p-color);
        font-weight: 900;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
    }

    .btn-confirm-hub {
        margin-top: auto;
        width: 100%;
        padding: 20px;
        border-radius: 20px;
        background: var(--p-color);
        color: #fff;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 10px 30px var(--p-glow);
        transition: all 0.3s ease;
    }
    .btn-confirm-hub:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px var(--p-glow);
    }
    .btn-confirm-hub:disabled { opacity: 0.5; cursor: not-allowed; }

    @media (max-width: 1024px) {
        .trainer-hub-grid { grid-template-columns: 1fr; }
        .trainer-info-panel { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.05); }
    }
</style>
@endsection

@section('content')
<div class="hub-hero">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-12">
            <div>
                <span class="sub-badge mb-4 inline-block">Elite PT Booking System</span>
                <h1 class="text-6xl font-black italic tracking-tighter uppercase">Lịch tập <span class="text-primary">1-Kèm-1</span></h1>
            </div>
            @if($userSubscription)
                <div class="premium-glass px-8 py-5 rounded-[30px] border-primary/20 bg-primary/5">
                    <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Gói hiện tại</div>
                    <div class="text-xl font-black text-white">{{ $userSubscription->membership ? $userSubscription->membership->name : 'N/A' }}</div>
                    <div class="text-primary font-bold text-xs mt-1">Còn {{ $userSubscription->pt_sessions_left }} buổi PT</div>
                </div>
            @else
                <div class="premium-glass px-8 py-5 rounded-[30px] border-white/10">
                    <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Trạng thái</div>
                    <div class="text-xl font-black text-white">Chưa đăng ký PT</div>
                    <a href="{{ route('client.memberships') }}" class="text-primary font-bold text-xs mt-1 hover:underline">Mua gói tập ngay</a>
                </div>
            @endif
        </div>

        <!-- Interactive Hub Master App -->
        <div x-data="hubApp()">
            
            <!-- Step 1: Date Selection -->
            <div class="mb-10">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-black uppercase tracking-[0.2em] text-slate-500">1. Chọn ngày tập luyện</h2>
                    <span class="text-xs text-slate-600 font-bold" x-text="'Đang xem: ' + selectedDateLabel"></span>
                </div>
                <div class="date-scroller">
                    @foreach($dates as $date)
                    <div class="date-card" 
                         :class="{ 'active': selectedDate === '{{ $date['full'] }}' }"
                         @click="setDate('{{ $date['full'] }}', '{{ $date['label'] }}')">
                        <div class="day-name">{{ $date['day_name'] }}</div>
                        <div class="day-num">{{ $date['date'] }}</div>
                        <div class="month-label">TH {{ $date['month'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Step 2: Trainer & Slot Selection -->
            <div class="space-y-10">
                <div class="flex items-center justify-between">
                    <h2 class="text-sm font-black uppercase tracking-[0.2em] text-slate-500">2. Chọn Huấn luyện viên & Khung giờ</h2>
                </div>

                <div class="grid grid-cols-1 gap-8">
                    @foreach($trainers as $trainer)
                    <div class="premium-glass trainer-hub-card" 
                         x-show="shouldShowTrainer('{{ $trainer->id }}')"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0">
                        
                        <div class="trainer-hub-grid">
                            <!-- Left: Profile Info -->
                            <div class="trainer-info-panel">
                                <div class="flex items-start gap-5">
                                    <img src="{{ $trainer->user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($trainer->user->name).'&background=FF6B35&color=fff&size=200' }}" 
                                         class="trainer-hub-img" alt="{{ $trainer->name }}">
                                    <div>
                                        <h3 class="text-2xl font-black text-white leading-none mb-2">{{ $trainer->name }}</h3>
                                        <span class="text-[10px] font-black uppercase tracking-widest text-primary">{{ $trainer->specialization }} Expert</span>
                                        <div class="flex gap-1 mt-3">
                                            @for($i=0; $i<5; $i++)
                                                <i class="fas fa-star text-[10px] text-yellow-500"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                
                                <p class="text-sm text-slate-400 mt-6 leading-relaxed flex-grow">
                                    {{ $trainer->bio }}
                                </p>

                                <div class="grid grid-cols-2 gap-4 mt-8">
                                    <div class="bg-white/5 p-4 rounded-2xl text-center border border-white/5">
                                        <div class="text-lg font-black text-white">{{ $trainer->experience }}Y+</div>
                                        <div class="text-[8px] font-bold text-slate-500 uppercase">Kinh nghiệm</div>
                                    </div>
                                    <div class="bg-white/5 p-4 rounded-2xl text-center border border-white/5">
                                        <div class="text-lg font-black text-white">{{ $trainer->students_count }}</div>
                                        <div class="text-[8px] font-bold text-slate-500 uppercase">Học viên</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Availability Grid -->
                            <div class="booking-panel">
                                <div class="flex justify-between items-center mb-6">
                                    <h4 class="text-xs font-black uppercase tracking-widest text-white">Khung giờ khả dụng</h4>
                                    <div class="flex gap-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                                            <span class="text-[9px] font-bold text-slate-500 uppercase">Lớp nhóm</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                            <span class="text-[9px] font-bold text-slate-500 uppercase">Đã đặt</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="slot-grid">
                                    <template x-for="slot in timeSlots">
                                        <button class="slot-btn"
                                                :class="getSlotClass('{{ $trainer->id }}', slot)"
                                                :disabled="isSlotDisabled('{{ $trainer->id }}', slot)"
                                                @click="selectSlot('{{ $trainer->id }}', slot)">
                                            <span x-text="slot"></span>
                                        </button>
                                    </template>
                                </div>

                                <div class="mt-auto pt-8">
                                    <form action="{{ route('pt-bookings.store') }}" method="POST" id="form_{{ $trainer->id }}">
                                        @csrf
                                        <input type="hidden" name="trainer_id" value="{{ $trainer->id }}">
                                        <input type="hidden" name="date" :value="selectedDate">
                                        <input type="hidden" name="time_slot" :value="selectedTrainer === '{{ $trainer->id }}' ? selectedSlot : ''">
                                        
                                        <button type="button" 
                                                class="btn-confirm-hub"
                                                :disabled="selectedTrainer !== '{{ $trainer->id }}' || !selectedSlot"
                                                @click="submitBooking('{{ $trainer->id }}')">
                                            <span x-show="selectedTrainer !== '{{ $trainer->id }}' || !selectedSlot">Chọn khung giờ để đặt</span>
                                            <span x-show="selectedTrainer === '{{ $trainer->id }}' && selectedSlot" x-text="'Xác nhận đặt lúc ' + selectedSlot"></span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function hubApp() {
        return {
            selectedDate: '{{ date('Y-m-d') }}',
            selectedDateLabel: '{{ $dates[0]['label'] }}',
            selectedTrainer: '{{ $selectedTrainerId }}' || null,
            selectedSlot: null,
            timeSlots: [
                '08:00', '09:00', '10:00', '11:00', 
                '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'
            ],
            availability: @json($trainerAvailability),
            
            setDate(date, label) {
                this.selectedDate = date;
                this.selectedDateLabel = label;
                this.selectedSlot = null; // Reset slot when date changes
            },

            shouldShowTrainer(id) {
                if (!this.selectedTrainer) return true;
                return this.selectedTrainer == id;
            },

            getSlotStatus(trainerId, slot) {
                const slots = this.availability[trainerId] || [];
                const found = slots.find(s => s.date === this.selectedDate && s.time === slot);
                return found ? found.type : 'available';
            },

            getSlotClass(trainerId, slot) {
                const status = this.getSlotStatus(trainerId, slot);
                if (status === 'class') return 'class-busy';
                if (status === 'pt') return 'booked';
                if (this.selectedTrainer == trainerId && this.selectedSlot === slot) return 'selected';
                return '';
            },

            isSlotDisabled(trainerId, slot) {
                const status = this.getSlotStatus(trainerId, slot);
                return status !== 'available';
            },

            selectSlot(trainerId, slot) {
                this.selectedTrainer = trainerId;
                this.selectedSlot = slot;
            },

            submitBooking(trainerId) {
                if (!this.selectedSlot) return;
                document.getElementById('form_' + trainerId).submit();
            }
        }
    }
</script>
@endsection
