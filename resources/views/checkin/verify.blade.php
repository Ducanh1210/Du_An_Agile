<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Xác nhận Điểm danh — EXTRA FIT+</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        :root {
            --primary-bg: #0f172a;
            --accent-color: #10b981;
            --card-bg: rgba(30, 41, 59, 0.7);
        }

        body {
            background-color: var(--primary-bg);
            color: #f1f5f9;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
        }

        .verify-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 32px;
            padding: 40px 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .logo-wrap {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent-color), #34d399);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 2rem;
            color: #0f172a;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 15px 20px;
            color: #fff;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            color: #fff;
        }

        .btn-checkin {
            background: var(--accent-color);
            border: none;
            border-radius: 16px;
            padding: 15px;
            font-weight: 700;
            width: 100%;
            margin-top: 20px;
            color: #0f172a;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-checkin:active {
            transform: scale(0.98);
        }

        .success-animation {
            display: none;
        }

        .checkmark-circle {
            width: 100px;
            height: 100px;
            position: relative;
            display: inline-block;
            vertical-align: top;
            margin-bottom: 20px;
        }

        .checkmark-circle .background {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--accent-color);
            position: absolute;
        }

        .checkmark-circle .check {
            border-radius: 3px;
            border-left: 5px solid #0f172a;
            border-bottom: 5px solid #0f172a;
            width: 50px;
            height: 25px;
            transform: rotate(-45deg);
            position: absolute;
            top: 33px;
            left: 25px;
        }

        .loader {
            display: none;
            width: 24px;
            height: 24px;
            border: 3px solid rgba(15, 23, 42, 0.3);
            border-radius: 50%;
            border-top-color: #0f172a;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div class="verify-card animate__animated animate__zoomIn">
    <div id="formSection">
        <div class="logo-wrap">
            <i class="fas fa-qrcode"></i>
        </div>
        <h2 class="fw-bold mb-2">ĐIỂM DANH</h2>
        <p class="text-secondary mb-4">Vui lòng nhập Email để vào tập</p>

        <form id="checkinForm">
            @csrf
            <div class="mb-3">
                <input type="email" id="email" name="email" class="form-control" placeholder="example@email.com" required>
            </div>
            <button type="submit" class="btn-checkin" id="submitBtn">
                <span class="btn-text">XÁC NHẬN VÀO TẬP</span>
                <div class="loader"></div>
            </button>
        </form>
    </div>

    <div id="successSection" class="success-animation animate__animated">
        <div class="checkmark-circle">
            <div class="background"></div>
            <div class="check"></div>
        </div>
        <h2 class="fw-bold mb-2">THÀNH CÔNG!</h2>
        <p id="successMessage" class="text-secondary mb-4"></p>
        <div class="user-info d-flex align-items-center justify-content-center mt-3 p-3 rounded-4" style="background: rgba(255,255,255,0.05)">
            <img id="userAvatar" src="" alt="Avatar" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
            <div class="text-start">
                <div class="fw-bold" id="userName"></div>
                <div class="small opacity-50">Hội viên chính thức</div>
            </div>
        </div>
        <p class="small text-secondary mt-4 opacity-50">Trang sẽ đóng sau 5 giây...</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const form = document.getElementById('checkinForm');
    const formSection = document.getElementById('formSection');
    const successSection = document.getElementById('successSection');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const loader = submitBtn.querySelector('.loader');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Show loading
        btnText.style.display = 'none';
        loader.style.display = 'block';
        submitBtn.disabled = true;

        const email = document.getElementById('email').value;

        try {
            // Sử dụng đường dẫn tương đối để tránh lỗi CORS/Mixed Content trên Tunnel
            const response = await fetch('/checkin/verify', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ email })
            });

            const data = await response.json();

            if (data.success) {
                // Show success
                formSection.style.display = 'none';
                successSection.style.display = 'block';
                successSection.classList.add('animate__fadeInUp');
                
                document.getElementById('successMessage').innerText = data.message;
                document.getElementById('userName').innerText = data.user.name;
                document.getElementById('userAvatar').src = data.user.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.user.name);

                // Auto close or redirect after 5s
                setTimeout(() => {
                    window.location.href = '/';
                }, 5000);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi điểm danh',
                    text: data.message,
                    background: '#1e293b',
                    color: '#f1f5f9',
                    confirmButtonColor: '#10b981'
                });
                
                // Reset button
                btnText.style.display = 'inline';
                loader.style.display = 'none';
                submitBtn.disabled = false;
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Lỗi hệ thống',
                text: 'Không thể kết nối tới máy chủ. Vui lòng thử lại sau.',
                background: '#1e293b',
                color: '#f1f5f9'
            });
            
            // Reset button
            btnText.style.display = 'inline';
            loader.style.display = 'none';
            submitBtn.disabled = false;
        }
    });
</script>

</body>
</html>
