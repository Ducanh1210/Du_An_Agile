@extends('layouts.staff')

@section('title', 'Kiosk Điểm Danh - EXTRA FIT+')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    :root {
        --glass-bg: rgba(15, 23, 42, 0.7);
        --accent-color: #10b981;
        --neon-glow: 0 0 15px rgba(16, 185, 129, 0.5);
    }

    .main-wrapper {
        background: radial-gradient(circle at top right, #1e293b, #0f172a);
        min-height: calc(100vh - 100px);
        color: #f1f5f9;
        margin: -24px;
        padding: 40px;
        font-family: 'Inter', sans-serif;
    }

    /* Khung QR với hiệu ứng Neon */
    .qr-card {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 32px;
        padding: 60px 40px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .qr-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(from 0deg, transparent, var(--accent-color), transparent 30%);
        animation: rotate 4s linear infinite;
        opacity: 0.2;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .qr-wrapper {
        position: relative;
        z-index: 2;
        background: white;
        padding: 20px;
        border-radius: 24px;
        display: inline-block;
        box-shadow: 0 0 40px rgba(0,0,0,0.4), var(--neon-glow);
        transform: translateZ(0);
        transition: transform 0.3s ease;
    }

    .qr-wrapper:hover {
        transform: scale(1.02);
    }

    /* Danh sách hội viên phong cách Glass */
    .history-card {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 32px;
        height: 100%;
    }

    .history-header {
        padding: 24px 32px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .checkin-item {
        background: rgba(255, 255, 255, 0.02);
        margin: 12px 24px;
        padding: 16px 20px;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .checkin-item:hover {
        background: rgba(255, 255, 255, 0.05);
        transform: translateX(10px);
    }

    .avatar-ring {
        position: relative;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        padding: 3px;
        background: linear-gradient(135deg, var(--accent-color), #34d399);
        margin-right: 16px;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #0f172a;
    }

    .status-dot {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        background: #10b981;
        border: 2px solid #0f172a;
        border-radius: 50%;
        box-shadow: 0 0 10px #10b981;
    }

    /* Hiệu ứng Pulse cho QR */
    .pulse-effect {
        position: absolute;
        width: 100px;
        height: 100px;
        background: var(--accent-color);
        border-radius: 50%;
        opacity: 0;
        z-index: 1;
        pointer-events: none;
    }

    .header-info {
        margin-bottom: 40px;
    }

    .badge-status {
        background: rgba(16, 185, 129, 0.1);
        color: var(--accent-color);
        padding: 6px 16px;
        border-radius: 100px;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 1px;
    }
</style>

<div class="main-wrapper">
    <div class="row g-5">
        <div class="col-lg-5">
            <div class="qr-card">
                <div class="header-info animate__animated animate__fadeIn">
                    <div class="badge-status mb-3">KIOSK MODE ACTIVE</div>
                    <h1 class="fw-bold mb-2">QUÉT MÃ QR</h1>
                    <p class="text-secondary opacity-75">Hội viên đưa mã trước cổng quét để điểm danh</p>
                </div>

                <div class="qr-wrapper animate__animated animate__zoomIn">
                    <div id="qrcode"></div>
                </div>

                <div class="mt-5 p-4 rounded-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-signal-stream text-primary animate__animated animate__pulse animate__infinite"></i>
                            <span class="small opacity-50">Hệ thống đang sẵn sàng trên: </span>
                            <span class="badge bg-dark border border-secondary" id="displayIp">{{ $localIp }}</span>
                        </div>
                        <div class="small text-secondary opacity-50 mt-1" id="displayUrl" style="word-break: break-all; font-size: 0.7rem;">
                            URL: {{ $checkinUrl }}
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-sm btn-outline-secondary opacity-50" onclick="editIp()">
                                <i class="fas fa-edit me-1"></i> Đổi IP thủ công
                            </button>
                        </div>
                        <div class="small text-warning opacity-75 mt-2">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Hãy đảm bảo đã chạy: <code>php artisan serve --host=0.0.0.0</code>
                        </div>
                    </div>
                </div>

                <button class="btn btn-link text-secondary mt-3 opacity-50 text-decoration-none" onclick="testBeep()">
                    <i class="fas fa-volume-up me-2"></i> Kiểm tra âm thanh
                </button>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="history-card shadow-lg">
                <div class="history-header">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-bolt-lightning me-3 text-warning"></i> 
                        NHẬT KÝ RA VÀO
                    </h5>
                    <div id="liveClock" class="fw-mono opacity-50"></div>
                </div>
                
                <div id="checkinHistory" class="p-2" style="max-height: 600px; overflow-y: auto;">
                    <!-- JS sẽ nạp dữ liệu ở đây -->
                    <div class="text-center py-5 opacity-25">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>Chưa có lượt điểm danh nào</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<audio id="beepSound" preload="auto">
    <source src="data:audio/wav;base64,UklGRl9vT19XQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YU9vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19vT19u" type="audio/wav">
</audio>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    let lastCheckinTime = null;

    let currentCheckinUrl = "{{ $checkinUrl }}";

    // Khởi tạo QR Code nội bộ
    let qrcode = new QRCode(document.getElementById("qrcode"), {
        text: currentCheckinUrl,
        width: 280,
        height: 280,
        colorDark : "#0f172a",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });

    function editIp() {
        const newIp = prompt("Nhập địa chỉ IP WiFi của máy tính (Ví dụ: 192.168.1.15):", "{{ $localIp }}");
        if (newIp && newIp !== "{{ $localIp }}") {
            const newUrl = currentCheckinUrl.replace("{{ $localIp }}", newIp);
            currentCheckinUrl = newUrl;
            
            // Cập nhật giao diện
            document.getElementById('displayIp').innerText = newIp;
            document.getElementById('displayUrl').innerText = "URL: " + newUrl;
            
            // Cập nhật QR
            document.getElementById("qrcode").innerHTML = "";
            qrcode = new QRCode(document.getElementById("qrcode"), {
                text: newUrl,
                width: 280,
                height: 280,
                colorDark : "#0f172a",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        }
    }

    function updateClock() {
        const now = new Date();
        document.getElementById('liveClock').innerText = now.toLocaleTimeString('vi-VN', { hour12: false });
    }
    setInterval(updateClock, 1000);
    updateClock();

    function testBeep() {
        const audio = document.getElementById('beepSound');
        audio.play().catch(e => console.log("Audio unlock required"));
    }

    async function fetchCheckins() {
        try {
            const res = await fetch('/api/checkin/recent');
            const data = await res.json();
            const container = document.getElementById('checkinHistory');
            
            if (data.length > 0) {
                const latest = data[0].checked_in_at;
                
                if (lastCheckinTime && latest !== lastCheckinTime) {
                    document.getElementById('beepSound').play();
                    triggerWave();
                }
                
                lastCheckinTime = latest;

                container.innerHTML = data.map((item, index) => `
                    <div class="checkin-item animate__animated ${index === 0 ? 'animate__slideInLeft' : ''}">
                        <div class="avatar-ring">
                            <img src="${item.avatar_url || '/images/default-avatar.png'}" class="avatar-img">
                            <div class="status-dot"></div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold fs-5">${item.name}</div>
                            <div class="text-secondary small opacity-50">Hội viên vừa vào tập</div>
                        </div>
                        <div class="text-end">
                            <div class="fw-mono text-emerald" style="color: var(--accent-color)">
                                ${new Date(item.checked_in_at).toLocaleTimeString('vi-VN', {hour: '2-digit', minute:'2-digit'})}
                            </div>
                            <div class="small opacity-25">Hôm nay</div>
                        </div>
                    </div>
                `).join('');
            }
        } catch (err) {
            console.error("Fetch error:", err);
        }
    }

    function triggerWave() {
        const qr = document.querySelector('.qr-wrapper');
        qr.classList.add('animate__pulse');
        setTimeout(() => qr.classList.remove('animate__pulse'), 1000);
    }

    setInterval(fetchCheckins, 2000);
    fetchCheckins();

    document.addEventListener('click', () => console.log("Init audio"), { once: true });
</script>
@endsection
