@extends('layouts.staff')

@section('title', 'Kiosk Điểm Danh - EXTRA FIT+')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;500;700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary-dark: #0f172a;
        --accent-color: #10b981;
        --glass-bg: rgba(30, 41, 59, 0.7);
        --neon-glow: 0 0 20px rgba(16, 185, 129, 0.4);
    }

    .main-wrapper {
        background: radial-gradient(circle at top right, #1e293b, #070b14);
        min-height: calc(100vh - 100px);
        color: #f1f5f9;
        margin: -24px;
        padding: 40px;
        font-family: 'Space Grotesk', sans-serif;
    }

    /* Premium QR Card */
    .qr-card {
        background: var(--glass-bg);
        backdrop-filter: blur(30px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 40px;
        padding: 50px 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .qr-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 4px;
        background: linear-gradient(90deg, transparent, var(--accent-color), transparent);
    }

    .qr-container {
        position: relative;
        display: inline-block;
        margin: 30px 0;
    }

    .qr-wrapper {
        background: white;
        padding: 20px;
        border-radius: 30px;
        display: inline-block;
        box-shadow: 0 0 50px rgba(0,0,0,0.5), var(--neon-glow);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .qr-wrapper.expired {
        filter: blur(8px) grayscale(1);
        opacity: 0.3;
        transform: scale(0.95);
    }

    /* Expiration Overlay */
    .qr-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 10;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .qr-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .reload-btn {
        width: 80px;
        height: 80px;
        background: var(--accent-color);
        color: var(--primary-dark);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        box-shadow: 0 0 30px var(--accent-color);
        animation: pulseReload 2s infinite;
    }

    @keyframes pulseReload {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1.1); box-shadow: 0 0 0 20px rgba(16, 185, 129, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    /* History List */
    .history-card {
        background: var(--glass-bg);
        backdrop-filter: blur(30px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 40px;
        height: 100%;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .checkin-item {
        background: rgba(255, 255, 255, 0.03);
        margin: 10px 20px;
        padding: 15px 25px;
        border-radius: 25px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .checkin-item.new {
        animation: slideInRight 0.5s forwards, highlight 2s forwards;
    }

    @keyframes highlight {
        0% { background: rgba(16, 185, 129, 0.3); }
        100% { background: rgba(255, 255, 255, 0.03); }
    }

    .avatar-wrap {
        width: 60px;
        height: 60px;
        border-radius: 20px;
        overflow: hidden;
        margin-right: 20px;
        border: 2px solid var(--accent-color);
    }

    /* Timer Bar */
    .timer-bar-container {
        width: 200px;
        height: 6px;
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        margin: 20px auto 0;
        overflow: hidden;
    }

    .timer-progress {
        height: 100%;
        background: var(--accent-color);
        width: 100%;
        transition: width 1s linear;
    }

    .timer-text {
        font-size: 0.8rem;
        color: var(--accent-color);
        margin-top: 8px;
        font-weight: bold;
    }
</style>

<div class="main-wrapper">
    <div class="row g-4">
        <!-- Cột Bên Trái: QR Code -->
        <div class="col-lg-5">
            <div class="qr-card">
                <div class="animate__animated animate__fadeInDown">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill mb-3" style="letter-spacing: 2px; font-size: 0.7rem;">SYSTEM PERMANENT</span>
                    <h2 class="fw-bold">QUÉT MÃ ĐIỂM DANH</h2>
                    <p class="opacity-50 small">Sử dụng QR này để quét vào phòng tập</p>
                </div>

                <div class="qr-container">
                    <div id="qrWrapper" class="qr-wrapper animate__animated animate__zoomIn">
                        <div id="qrcode"></div>
                    </div>
                </div>

                <div class="mt-5 p-4 rounded-4 text-start" style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="small opacity-50">TRẠNG THÁI KẾT NỐI:</div>
                        @if($method === 'ENV_CONFIG' || $method === 'TUNNEL_FILE')
                            <span class="badge bg-success" style="font-size: 0.6rem;"><i class="fas fa-globe me-1"></i> PUBLIC</span>
                        @else
                            <span class="badge bg-warning text-dark" style="font-size: 0.6rem;"><i class="fas fa-wifi me-1"></i> LOCAL</span>
                        @endif
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="fw-bold text-primary">{{ $localIp }}</div>
                            <div class="small opacity-25" style="font-size: 0.6rem;">{{ $checkinUrl }}</div>
                        </div>
                        <button class="btn btn-sm btn-outline-light border-0 opacity-25" onclick="editIp()">
                            <i class="fas fa-cog"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột Bên Phải: Lịch sử -->
        <div class="col-lg-7">
            <div class="history-card">
                <div class="p-4 d-flex justify-content-between align-items-center border-bottom border-white border-opacity-5">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-history me-3 text-success"></i>LỊCH SỬ VÀO TẬP</h5>
                    <div id="liveClock" class="fw-bold opacity-50 fs-4"></div>
                </div>
                
                <div id="checkinHistory" class="py-3" style="max-height: 700px; overflow-y: auto;">
                    <div class="text-center py-5 opacity-25">
                        <i class="fas fa-user-clock fa-3x mb-3"></i>
                        <p>Đang chờ lượt điểm danh mới...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    let lastCheckinTime = null;
    let timerValue = 15;
    let timerInterval;
    let currentCheckinUrl = "{{ $checkinUrl }}";

    // Khởi tạo QR Code
    let qrcode = new QRCode(document.getElementById("qrcode"), {
        text: currentCheckinUrl,
        width: 280,
        height: 280,
        colorDark : "#0f172a",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });

    // Logic Timer & Expiration đã được loại bỏ để làm QR vĩnh viễn
    function reloadQR() {
        window.location.reload();
    }

    // 2. Beep Sound Synthesizer (Chuyên nghiệp hơn)
    function playBeep() {
        try {
            const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioCtx.createOscillator();
            const gainNode = audioCtx.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);

            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(880, audioCtx.currentTime); // Nốt A5
            gainNode.gain.setValueAtTime(0.1, audioCtx.currentTime);

            oscillator.start();
            oscillator.stop(audioCtx.currentTime + 0.3);
        } catch (e) {
            console.error("Audio error:", e);
        }
    }

    // 3. Clock
    function updateClock() {
        const now = new Date();
        document.getElementById('liveClock').innerText = now.toLocaleTimeString('vi-VN', { hour12: false });
    }
    setInterval(updateClock, 1000);
    updateClock();

    // 4. Fetch History & New Checkin Detection
    async function fetchCheckins() {
        try {
            const res = await fetch('/api/checkin/recent');
            const data = await res.json();
            const container = document.getElementById('checkinHistory');
            
            if (data.length > 0) {
                const latest = data[0].checked_in_at;
                
                if (lastCheckinTime && latest !== lastCheckinTime) {
                    playBeep(); // Phát tiếng bíp khi có người mới
                }
                
                lastCheckinTime = latest;

                container.innerHTML = data.map((item, index) => `
                    <div class="checkin-item ${index === 0 ? 'new' : ''}">
                        <div class="avatar-wrap">
                            <img src="${item.avatar_url || '/images/default-avatar.png'}" style="width:100%; height:100%; object-fit:cover;">
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold fs-5 text-white">${item.name}</div>
                            <div class="small opacity-50">Vừa vào phòng tập</div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-success" style="font-size: 1.2rem;">
                                ${new Date(item.checked_in_at).toLocaleTimeString('vi-VN', {hour: '2-digit', minute:'2-digit'})}
                            </div>
                        </div>
                    </div>
                `).join('');
            }
        } catch (err) {
            console.error("Fetch error:", err);
        }
    }

    function editIp() {
        const newIp = prompt("Nhập địa chỉ IP WiFi của máy tính:", "{{ $localIp }}");
        if (newIp) {
            location.href = location.pathname + "?manual_ip=" + newIp;
        }
    }

    // Initialize
    setInterval(fetchCheckins, 2000);
    fetchCheckins();

    // Unlock Audio Context on first click
    document.addEventListener('click', () => {
        const ctx = new (window.AudioContext || window.webkitAudioContext)();
        if (ctx.state === 'suspended') ctx.resume();
    }, { once: true });

</script>
@endsection
