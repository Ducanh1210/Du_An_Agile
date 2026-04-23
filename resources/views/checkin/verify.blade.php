<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận Vào phòng - EXTRA FIT+</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --color-primary: #10B981;
            --color-secondary: #064E3B;
            --bg-gradient: linear-gradient(135deg, #064E3B 0%, #10B981 100%);
        }
        body {
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            padding: 20px;
        }
        .verify-card {
            background: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 450px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .verify-header {
            margin-bottom: 30px;
        }
        .logo-box {
            background: var(--bg-gradient);
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 30px;
        }
        .form-control {
            border-radius: 12px;
            padding: 15px;
            border: 2px solid #e2e8f0;
            text-align: center;
            font-size: 1.1rem;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }
        .btn-verify {
            background: var(--bg-gradient);
            border: none;
            color: white;
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 20px;
            transition: transform 0.2s;
        }
        .btn-verify:active {
            transform: scale(0.98);
        }
        .status-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            z-index: 10;
        }
        .success-icon {
            color: var(--color-primary);
            font-size: 80px;
            margin-bottom: 20px;
        }
        .error-icon {
            color: #ef4444;
            font-size: 80px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="verify-card">
    <div class="verify-header">
        <div class="logo-box">
            <i class="fas fa-dumbbell"></i>
        </div>
        <h2 class="fw-bold">Xác nhận Vào phòng</h2>
        <p class="text-muted">Vui lòng nhập Email để hệ thống kiểm tra gói tập của bạn</p>
    </div>

    <form id="verifyForm">
        <div class="mb-3">
            <input type="email" id="email" class="form-control" placeholder="example@gmail.com" required>
        </div>
        <button type="submit" class="btn-verify" id="btnSubmit">XÁC NHẬN VÀO TẬP</button>
    </form>

    <!-- Overlay Success/Error -->
    <div id="statusOverlay" class="status-overlay">
        <div id="statusContent"></div>
        <button class="btn btn-outline-secondary mt-4 w-100" onclick="resetForm()">THỬ LẠI</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#verifyForm').on('submit', function(e) {
        e.preventDefault();
        
        const email = $('#email').val();
        const btn = $('#btnSubmit');
        
        btn.html('<i class="fas fa-spinner fa-spin"></i> ĐANG KIỂM TRA...').prop('disabled', true);

        $.ajax({
            url: '/checkin/verify',
            method: 'POST',
            data: {
                email: email,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                showStatus(true, res.message, res.user);
            },
            error: function(err) {
                const msg = err.responseJSON ? err.responseJSON.message : 'Có lỗi xảy ra, vui lòng thử lại.';
                showStatus(false, msg);
            },
            complete: function() {
                btn.html('XÁC NHẬN VÀO TẬP').prop('disabled', false);
            }
        });
    });

    function showStatus(isSuccess, message, user = null) {
        const overlay = $('#statusOverlay');
        const content = $('#statusContent');
        
        overlay.css('display', 'flex');
        
        if (isSuccess) {
            content.innerHTML = ''; // Clear
            content.html(`
                <div class="animate__animated animate__bounceIn">
                    <i class="fas fa-check-circle success-icon"></i>
                    <h3 class="fw-bold">THÀNH CÔNG!</h3>
                    <div class="my-4">
                        <img src="${user.avatar}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid var(--color-primary)">
                        <div class="mt-2 fw-bold fs-5">${user.name}</div>
                    </div>
                    <p class="text-muted">${message}</p>
                </div>
            `);
            // Ẩn nút thử lại nếu thành công
            overlay.find('button').hide();
            // Tự động reload sau 3s
            setTimeout(() => window.location.reload(), 3000);
        } else {
            content.html(`
                <div class="animate__animated animate__shakeX">
                    <i class="fas fa-times-circle error-icon"></i>
                    <h3 class="fw-bold text-danger">THẤT BẠI</h3>
                    <p class="text-muted mt-3">${message}</p>
                </div>
            `);
            overlay.find('button').show();
        }
    }

    function resetForm() {
        $('#statusOverlay').hide();
        $('#email').val('').focus();
    }
</script>

</body>
</html>
