@extends('layouts.client')

@section('title', 'Đội ngũ Huấn luyện viên — PT Booking Hub')

@section('styles')
<style>
    /* ============================================================
       PT BOOKING HUB — LUXURY LIGHT EDITION
       ============================================================ */
    :root {
        --color-pt-primary: #FF6B35;
        --color-pt-glow: rgba(255, 107, 53, 0.2);
        --color-pt-bg: #F8F9FA;
        --color-pt-surface: #FFFFFF;
        --color-pt-card: #FFFFFF;
        --color-pt-text: #1A1A2E;
        --color-pt-text-muted: #64748B;
        --color-pt-border: #E2E8F0;
        
        --shadow-elite: 0 10px 40px -10px rgba(0,0,0,0.08);
        --shadow-elite-hover: 0 20px 50px -12px rgba(0,0,0,0.12);
        --transition-pt: 0.4s cubic-bezier(0.19, 1, 0.22, 1);
    }

    [data-theme="dark"] {
        --color-pt-bg:      #0F0F1A;
        --color-pt-surface: #1E1E2E;
        --color-pt-card:    #1E1E2E;
        --color-pt-text:    #F0F0F0;
        --color-pt-text-muted: #94A3B8;
        --color-pt-border:  #2E2E3E;
        --color-pt-glow:    rgba(255, 107, 53, 0.1);
        --shadow-elite:     0 10px 40px -10px rgba(0,0,0,0.3);
        --shadow-elite-hover: 0 20px 50px -12px rgba(0,0,0,0.5);
    }

    body {
        background-color: var(--color-pt-bg);
        color: var(--color-pt-text);
        transition: background-color var(--transition-slow), color var(--transition-slow);
    }

    .booking-hub-wrapper {
        min-height: 100vh;
        padding-bottom: var(--space-10);
    }

    /* ---- Hero Area ---- */
    .hub-hero {
        position: relative;
        padding: 120px 0 80px;
        background: radial-gradient(circle at 70% 30%, rgba(255, 107, 53, 0.08) 0%, transparent 50%),
                    radial-gradient(circle at 20% 70%, rgba(99, 102, 241, 0.05) 0%, transparent 50%);
        overflow: hidden;
    }
    .hub-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--color-pt-surface);
        border: 1px solid var(--color-pt-border);
        color: var(--color-pt-primary);
        padding: 8px 20px;
        border-radius: 99px;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .hub-title {
        font-size: clamp(40px, 8vw, 80px);
        font-weight: 950;
        line-height: 0.95;
        letter-spacing: -3px;
        margin-bottom: 24px;
        color: var(--color-pt-text);
    }
    .hub-title span {
        color: var(--color-pt-primary);
    }
    .hub-desc {
        font-size: 18px;
        color: var(--color-pt-text-muted);
        max-width: 600px;
        line-height: 1.6;
    }

    /* ---- Filter System ---- */
    .hub-filters {
        position: sticky;
        top: 72px;
        z-index: 100;
        padding: 16px 0;
        background: var(--color-pt-bg);
        opacity: 0.95;
        backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--color-pt-border);
        margin-bottom: 60px;
    }
    .filter-pills {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .filter-pill {
        background: var(--color-pt-surface);
        border: 1px solid var(--color-pt-border);
        color: var(--color-pt-text-muted);
        padding: 12px 28px;
        border-radius: 99px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    .filter-pill:hover {
        border-color: var(--color-pt-primary);
        color: var(--color-pt-primary);
        transform: translateY(-2px);
    }
    .filter-pill.active {
        background: var(--color-pt-text);
        border-color: var(--color-pt-text);
        color: var(--color-pt-bg);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    /* ---- Trainer Grid ---- */
    .trainer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 40px;
    }

    /* ---- Trainer Card ---- */
    .trainer-card {
        background: var(--color-pt-card);
        border-radius: 40px;
        overflow: hidden;
        border: 1px solid var(--color-pt-border);
        transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
        position: relative;
        box-shadow: var(--shadow-elite);
    }
    .trainer-card:hover {
        transform: translateY(-12px);
        box-shadow: var(--shadow-elite-hover);
        border-color: var(--color-pt-primary);
    }
    
    .card-photo-box {
        height: 380px;
        position: relative;
        overflow: hidden;
    }
    .card-photo {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 1s ease;
    }
    .trainer-card:hover .card-photo { transform: scale(1.1); }
    
    .card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, var(--color-pt-card) 0%, transparent 50%);
    }

    .card-content {
        padding: 32px;
        position: relative;
        background: var(--color-pt-card);
    }

    .trainer-meta {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }
    .meta-pill {
        background: var(--color-pt-bg);
        border: 1px solid var(--color-pt-border);
        border-radius: 14px;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 800;
        color: var(--color-pt-text);
    }
    .meta-pill i { color: var(--color-pt-primary); }

    .trainer-name {
        font-size: 28px;
        font-weight: 900;
        margin-bottom: 8px;
        color: var(--color-pt-text);
        letter-spacing: -0.5px;
    }
    .trainer-specialty {
        font-size: 11px;
        font-weight: 900;
        text-transform: uppercase;
        color: var(--color-pt-primary);
        letter-spacing: 2.5px;
        display: block;
        margin-bottom: 16px;
    }
    .trainer-preview-bio {
        font-size: 14px;
        color: var(--color-pt-text-muted);
        line-height: 1.6;
        margin-bottom: 28px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .btn-open-booking {
        width: 100%;
        background: var(--color-pt-text);
        color: var(--color-pt-bg);
        padding: 18px;
        border-radius: 20px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        border: none;
    }
    .trainer-card:hover .btn-open-booking {
        background: var(--color-pt-primary);
        box-shadow: 0 10px 25px var(--color-pt-glow);
    }

    /* ---- Booking Modal Luxury ---- */
    .pt-modal {
        position: fixed;
        inset: 0;
        z-index: 2000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
    }
    .pt-modal.active { opacity: 1; visibility: visible; }
    .pt-modal-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(10px);
    }
    .pt-modal-container {
        background: var(--color-pt-surface);
        width: 100%;
        max-width: 1100px;
        height: min(850px, 90vh);
        border-radius: 48px;
        display: flex;
        overflow: hidden;
        position: relative;
        transform: scale(0.9) translateY(40px);
        transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
        box-shadow: 0 40px 100px -20px rgba(0,0,0,0.25);
    }
    .pt-modal.active .pt-modal-container { transform: scale(1) translateY(0); }

    /* Left col: Profile */
    .pt-modal-coach {
        width: 360px;
        background: var(--color-pt-bg);
        padding: 48px;
        display: flex;
        flex-direction: column;
        border-right: 1px solid var(--color-pt-border);
    }
    .coach-avatar-lg {
        width: 130px;
        height: 130px;
        border-radius: 36px;
        object-fit: cover;
        margin-bottom: 28px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .coach-name-lg {
        font-size: 32px;
        font-weight: 900;
        margin-bottom: 8px;
        color: var(--color-pt-text);
        letter-spacing: -1px;
    }
    .coach-spec-lg {
        color: var(--color-pt-primary);
        font-weight: 900;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 3px;
        margin-bottom: 40px;
    }
    .coach-stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 40px;
    }
    .coach-stat-box {
        padding: 20px 12px;
        background: var(--color-pt-surface);
        border: 1px solid var(--color-pt-border);
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }
    .coach-stat-val {
        display: block;
        font-size: 22px;
        font-weight: 950;
        color: var(--color-pt-text);
    }
    .coach-stat-lbl {
        font-size: 10px;
        color: var(--color-pt-text-muted);
        text-transform: uppercase;
        font-weight: 800;
        margin-top: 4px;
        letter-spacing: 1px;
    }

    /* Right col: Booking */
    .pt-modal-booking {
        flex: 1;
        padding: 48px;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        background: var(--color-pt-surface);
    }
    .booking-section-title {
        font-size: 16px;
        font-weight: 900;
        color: var(--color-pt-text);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .booking-section-title span {
        width: 32px;
        height: 32px;
        background: var(--color-pt-primary);
        color: #fff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    /* Date Scroller */
    .date-scroller {
        display: flex;
        gap: 12px;
        margin-bottom: 48px;
        overflow-x: auto;
        padding-bottom: 12px;
    }
    .date-item {
        flex-shrink: 0;
        width: 76px;
        height: 96px;
        background: var(--color-pt-surface);
        border: 1.5px solid var(--color-pt-border);
        border-radius: 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .date-item:hover { transform: translateY(-4px); border-color: var(--color-pt-primary); }
    .date-item.active {
        background: var(--color-pt-text);
        border-color: var(--color-pt-text);
        color: var(--color-pt-bg);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15);
    }
    .date-num { font-size: 26px; font-weight: 950; line-height: 1; }
    .date-day-name { font-size: 10px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px; opacity: 0.6; }
    .date-month { font-size: 11px; font-weight: 700; opacity: 0.6; margin-top: 2px; }

    /* Time Grid */
    .time-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 12px;
        margin-bottom: 48px;
    }
    .time-slot {
        background: var(--color-pt-surface);
        border: 1.5px solid var(--color-pt-border);
        border-radius: 16px;
        padding: 16px;
        text-align: center;
        font-size: 16px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--color-pt-text);
    }
    .time-slot:hover:not(.busy) { border-color: var(--color-pt-primary); color: var(--color-pt-primary); }
    .time-slot.active {
        background: var(--color-pt-primary);
        color: #fff;
        border-color: var(--color-pt-primary);
        box-shadow: 0 8px 20px var(--color-pt-glow);
    }
    .time-slot.busy {
        background: var(--color-pt-bg);
        border-color: var(--color-pt-border);
        color: var(--color-pt-text-muted);
        cursor: not-allowed;
        opacity: 0.5;
    }

    /* Footer / Summary */
    .modal-booking-footer {
        margin-top: auto;
        padding: 32px;
        background: var(--color-pt-bg);
        border-radius: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .summary-info .lbl { font-size: 11px; font-weight: 800; color: var(--color-pt-text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; display: block; }
    .summary-info .val { font-size: 26px; font-weight: 950; color: var(--color-pt-text); }
    .summary-info .val span { font-size: 14px; font-weight: 700; color: var(--color-pt-text-muted); margin-left: 4px; }

    .btn-submit-booking {
        background: var(--color-pt-primary);
        color: #fff;
        padding: 18px 48px;
        border-radius: 20px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        box-shadow: 0 10px 30px var(--color-pt-glow);
        transition: all 0.3s ease;
        border: none;
    }
    .btn-submit-booking:hover:not(:disabled) { transform: scale(1.05); box-shadow: 0 15px 40px var(--color-pt-glow); }
    .btn-submit-booking:disabled { opacity: 0.3; cursor: not-allowed; box-shadow: none; }

    @media (max-width: 991px) {
        .pt-modal-container { flex-direction: column; overflow-y: auto; height: 98vh; border-radius: 32px; }
        .pt-modal-coach { width: 100%; padding: 32px; border-right: none; height: auto; }
        .pt-modal-booking { padding: 32px; height: auto; }
        .modal-booking-footer { flex-direction: column; gap: 24px; text-align: center; }
    }
</style>
@endsection

@section('content')
<div class="booking-hub-wrapper">

    {{-- Hero Section --}}
    <section class="hub-hero">
        <div class="container">
            <div class="hub-tag animate-up">
                Elite Coach Spotlight
            </div>
            <h1 class="hub-title animate-up" style="animation-delay:0.1s">
                MASTER THE<br><span>CRAFT.</span>
            </h1>
            <p class="hub-desc animate-up" style="animation-delay:0.2s">
                Trải nghiệm huấn luyện cá nhân đẳng cấp 5 sao. Xây dựng lộ trình riêng biệt, tối ưu kết quả cùng đội ngũ coach chuyên nghiệp.
            </p>
        </div>
    </section>

    {{-- Filters --}}
    <div class="hub-filters">
        <div class="container">
            <div class="filter-pills">
                <div class="filter-pill active" data-filter="all">Đội ngũ Coach</div>
                <div class="filter-pill" data-filter="gym">Gym / Fitness</div>
                <div class="filter-pill" data-filter="yoga">Yoga specialized</div>
                <div class="filter-pill" data-filter="both">Integrated Dual</div>
            </div>
        </div>
    </div>

    {{-- Trainer Grid --}}
    <section class="trainer-list-section">
        <div class="container">
            @if(session('success'))
                <div style="background: #ECFDF5; border: 1px solid #10B981; padding: 20px; border-radius: 20px; margin-bottom: 40px; color: #065F46; font-weight: 700; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-check-circle text-xl"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background: #FEF2F2; border: 1px solid #EF4444; padding: 20px; border-radius: 20px; margin-bottom: 40px; color: #991B1B; font-weight: 700; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-exclamation-circle text-xl"></i> {{ session('error') }}
                </div>
            @endif

            <div class="trainer-grid">
                @forelse($trainers as $trainer)
                <div class="trainer-card" data-specialty="{{ $trainer->specialization }}" data-id="{{ $trainer->id }}">
                    <div class="card-photo-box">
                        <img src="{{ $trainer->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($trainer->name).'&background=FF6B35&color=fff&size=500' }}" 
                             alt="{{ $trainer->name }}" class="card-photo">
                        <div class="card-overlay"></div>
                    </div>
                    <div class="card-content">
                        <span class="trainer-specialty">{{ $trainer->specialization }} Specialist</span>
                        <h3 class="trainer-name">{{ $trainer->name }}</h3>
                        
                        <div class="trainer-meta">
                            <div class="meta-pill">
                                <i class="fas fa-star"></i> {{ $trainer->rating }}
                            </div>
                            <div class="meta-pill">
                                <i class="fas fa-award"></i> {{ $trainer->experience }} Years
                            </div>
                        </div>

                        <p class="trainer-preview-bio">{{ $trainer->bio }}</p>

                        <button class="btn-open-booking" 
                                onclick="openBooking({{ json_encode($trainer) }})">
                            Book session now <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-user-slash empty-icon"></i>
                        <h3 class="empty-title">Không tìm thấy HLV</h3>
                        <p class="empty-desc">Rất tiếc, hiện tại không có huấn luyện viên nào phù hợp với bộ lọc của bạn.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>

{{-- Luxury Booking Modal --}}
<div class="pt-modal" id="bookingModal">
    <div class="pt-modal-overlay" onclick="closeModal()"></div>
    <div class="pt-modal-container">
        {{-- Profile --}}
        <div class="pt-modal-coach">
            <img class="coach-avatar-lg" id="modal-avatar" src="" alt="">
            <div class="coach-spec-lg" id="modal-spec"></div>
            <h2 class="coach-name-lg" id="modal-name"></h2>
            
            <div class="coach-stats-grid">
                <div class="coach-stat-box">
                    <span class="coach-stat-val" id="modal-rating"></span>
                    <span class="coach-stat-lbl">Rating</span>
                </div>
                <div class="coach-stat-box">
                    <span class="coach-stat-val" id="modal-exp"></span>
                    <span class="coach-stat-lbl">Experience</span>
                </div>
            </div>

            <div class="coach-bio-lg" id="modal-bio" style="font-size: 14px; color: var(--color-pt-text-muted); line-height: 1.7;">
            </div>

            <button onclick="closeModal()" class="mt-auto flex items-center justify-center gap-2 text-slate-400 hover:text-slate-900 transition-colors font-bold text-xs uppercase tracking-widest">
                <i class="fas fa-times"></i> Cancel & Close
            </button>
        </div>

        {{-- Process --}}
        <div class="pt-modal-booking">
            <h3 class="booking-section-title"><span>1</span> Chọn lịch tập</h3>
            <div class="date-scroller">
                @foreach($dates as $d)
                <div class="date-item {{ $d['is_today'] ? 'active' : '' }}" 
                     data-date="{{ $d['full'] }}"
                     onclick="selectDate(this)">
                    <span class="date-day-name">{{ $d['day_name'] }}</span>
                    <span class="date-num">{{ $d['date'] }}</span>
                    <span class="date-month">{{ $d['label'] }}</span>
                </div>
                @endforeach
            </div>

            <h3 class="booking-section-title"><span>2</span> Khung giờ sẵn sàng</h3>
            <div class="time-grid" id="timeGrid">
                {{-- Loaded by JS --}}
            </div>

            <h3 class="booking-section-title"><span>3</span> Bạn muốn tập gì hôm nay?</h3>
            <div class="flex flex-wrap gap-3 mb-10" id="targetAreaContainer">
                @foreach(['Toàn thân', 'Cơ ngực', 'Cơ lưng', 'Cơ tay', 'Cơ chân', 'Cơ bụng'] as $area)
                <label class="cursor-pointer group">
                    <input type="radio" name="target_area_radio" value="{{ $area }}" class="hidden peer" onchange="selectTargetArea(this)">
                    <div class="px-5 py-3 rounded-2xl border-2 border-main bg-main text-muted font-bold text-sm transition-all peer-checked:bg-orange-500 peer-checked:border-orange-500 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-orange-500/20 group-hover:border-orange-500/30">
                        {{ $area }}
                    </div>
                </label>
                @endforeach
            </div>

            <div class="modal-booking-footer">
                <div class="summary-info">
                    <span class="lbl">Chi phí buổi tập</span>
                    <div class="val" id="bookingPrice">
                        @if($userSubscription)
                            FREE <span>(Thành viên gói VIP)</span>
                        @else
                            {{ number_format(500000) }}đ <span>/ session</span>
                        @endif
                    </div>
                </div>
                
                <form action="{{ route('pt-bookings.store') }}" method="POST" id="bookingForm">
                    @csrf
                    <input type="hidden" name="trainer_id" id="formTrainerId">
                    <input type="hidden" name="date" id="formDate" value="{{ $dates[0]['full'] }}">
                    <input type="hidden" name="time_slot" id="formTime">
                    <input type="hidden" name="target_area" id="formTargetArea">
                    
                    <button type="submit" class="btn-submit-booking" id="submitBtn" disabled>
                        Confirm Booking <i class="fas fa-check ml-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const trainerAvailability = @json($trainerAvailability);
    let currentTrainer = null;
    let selectedDate = "{{ $dates[0]['full'] }}";
    let selectedTime = null;
    let selectedTargetArea = null;

    const timeSlotsMaster = [];
    for(let h = 5; h <= 21; h++) {
        timeSlotsMaster.push(`${h.toString().padStart(2, '0')}:00`);
    }

    function openBooking(trainer) {
        currentTrainer = trainer;
        document.getElementById('modal-avatar').src = trainer.avatar_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(trainer.name)}&background=FF6B35&color=fff&size=500`;
        document.getElementById('modal-name').textContent = trainer.name;
        document.getElementById('modal-spec').textContent = trainer.specialization + ' Specialist';
        document.getElementById('modal-rating').textContent = trainer.rating;
        document.getElementById('modal-exp').textContent = trainer.experience + ' Yrs';
        document.getElementById('modal-bio').textContent = trainer.bio;
        document.getElementById('formTrainerId').value = trainer.id;

        const priceLabel = document.getElementById('bookingPrice');
        @if(!$userSubscription)
            const price = parseInt(trainer.price || 500000);
            priceLabel.innerHTML = `${price.toLocaleString('vi-VN')}đ <span>/ session</span>`;
        @endif

        renderTimeSlots();
        document.getElementById('bookingModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('bookingModal').classList.remove('active');
        document.body.style.overflow = 'auto';
        selectedTime = null;
        selectedTargetArea = null;
        document.querySelectorAll('input[name="target_area_radio"]').forEach(r => r.checked = false);
        updateSubmitButton();
    }

    function selectDate(el) {
        document.querySelectorAll('.date-item').forEach(d => d.classList.remove('active'));
        el.classList.add('active');
        selectedDate = el.dataset.date;
        document.getElementById('formDate').value = selectedDate;
        selectedTime = null;
        renderTimeSlots();
        updateSubmitButton();
    }

    function renderTimeSlots() {
        const grid = document.getElementById('timeGrid');
        grid.innerHTML = '';

        const busySlots = (trainerAvailability[currentTrainer.id] || [])
            .filter(slot => slot.date === selectedDate);

        timeSlotsMaster.forEach(slot => {
            const busy = busySlots.find(b => b.time === slot);
            const slotEl = document.createElement('div');
            slotEl.className = 'time-slot';
            slotEl.textContent = slot;

            if (busy) {
                slotEl.classList.add('busy');
            } else {
                slotEl.onclick = () => selectTime(slotEl, slot);
                if (selectedTime === slot) slotEl.classList.add('active');
            }
            grid.appendChild(slotEl);
        });
    }

    function selectTime(el, time) {
        document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('active'));
        el.classList.add('active');
        selectedTime = time;
        document.getElementById('formTime').value = time;
        updateSubmitButton();
    }

    function selectTargetArea(el) {
        selectedTargetArea = el.value;
        document.getElementById('formTargetArea').value = selectedTargetArea;
        updateSubmitButton();
    }

    function updateSubmitButton() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = !(selectedTime && selectedTargetArea);
    }

    document.querySelectorAll('.filter-pill').forEach(pill => {
        pill.addEventListener('click', () => {
            document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
            const filter = pill.dataset.filter;
            document.querySelectorAll('.trainer-card').forEach(card => {
                const spec = (card.dataset.specialty || '').toLowerCase();
                if (filter === 'all' || spec === filter.toLowerCase()) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
