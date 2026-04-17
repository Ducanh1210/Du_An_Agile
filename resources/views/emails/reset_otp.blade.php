<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Xác thực OTP - GYM FIT+</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; padding: 40px; border: 1px solid #eee; border-radius: 20px; background-color: #fff; }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { font-size: 32px; font-weight: 900; color: #9c3f00; text-decoration: none; letter-spacing: -1px; }
        .otp-box { background-color: #fff4ef; padding: 30px; border-radius: 15px; text-align: center; margin: 25px 0; border: 1px dashed #ff7a2f; }
        .otp-code { font-size: 40px; font-weight: 900; color: #9c3f00; letter-spacing: 12px; margin: 0; }
        .footer { text-align: center; font-size: 12px; color: #999; margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="#" class="logo">GYM FIT+</a>
        </div>
        
        <h2>Xin chào quý khách,</h2>
        <p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Vui lòng sử dụng mã OTP dưới đây để hoàn tất quá trình xác thực:</p>
        
        <div class="otp-box">
            <h1 class="otp-code">{{ $otp }}</h1>
        </div>
        
        <p>Mã này có hiệu lực trong vòng <strong>15 phút</strong>. Tuyệt đối không chia sẻ mã này cho bất kỳ ai, kể cả nhân viên của GYM FIT+.</p>
        
        <p>Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này để đảm bảo an toàn cho tài khoản.</p>
        
        <div class="footer">
            <p>© {{ date('Y') }} GYM FIT+ PERFORMANCE CENTER<br>Vững mạnh tinh thần - Bứt phá thể chất</p>
        </div>
    </div>
</body>
</html>
