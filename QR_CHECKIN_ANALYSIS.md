# Phân tích Chức năng: Check-in bằng Email (Phù hợp môi trường Local)

Tài liệu này mô tả luồng điểm danh dựa trên việc xác thực Email của hội viên, giúp dễ dàng kiểm tra và vận hành ngay cả khi chưa có Hosting chính thức.

---

## 1. Mục tiêu và Lợi ích

- **Mục tiêu**: Đơn giản hóa việc điểm danh, tập trung vào việc xác thực tư cách hội viên qua Email.
- **Lợi ích**:
    - Dễ dàng kiểm tra (Test) trên môi trường Local (Laragon).
    - Không yêu cầu hội viên phải duy trì đăng nhập phức tạp trên trình duyệt điện thoại.
    - Quy trình nhanh gọn: Quét -> Nhập Email -> Vào tập.

## 2. Luồng hoạt động (Workflow) - Tối ưu hóa cho Local Test

### Bước 1: Nhân viên hiển thị Mã QR điểm danh
1. Nhân viên mở trang **"Cổng điểm danh"** trên máy tính lễ tân.
2. Trang này hiển thị một mã QR chứa đường dẫn đến trang xác nhận: `http://[IP-CUA-BAN]/gym/checkin-verify`.
    - *Lưu ý*: Trong môi trường Local, bạn có thể in mã QR này ra giấy hoặc hiện lên màn hình. Hội viên chỉ cần quét mã để mở link.

### Bước 2: Hội viên xác thực danh tính (Phía Khách hàng)
1. Sau khi quét mã, một trang Web đơn giản hiện ra yêu cầu: **"Nhập Email của bạn để vào phòng"**.
2. Hội viên nhập địa chỉ Email mà họ đã dùng để đăng ký tài khoản tại Gym.
3. Nhấn **"Xác nhận vào tập"**.

### Bước 3: Thuật toán kiểm tra (Hệ thống)
Hệ thống sẽ thực hiện 3 bước kiểm tra liên tiếp:
1. **Kiểm tra Email**: Email có tồn tại trong bảng `users` không?
2. **Kiểm tra Gói tập**: User này có gói tập nào đang ở trạng thái `active` trong bảng `subscriptions` không?
3. **Kiểm tra Thời hạn**: Gói tập đó có còn ngày sử dụng không (so với ngày hiện tại)?

### Bước 4: Kết quả
- **Thành công**: 
    - Hiện thông báo: "Chào mừng [Tên khách]! Chúc bạn có buổi tập tuyệt vời."
    - Ghi một bản ghi vào bảng `checkins` để lưu lịch sử (ngày, giờ, user).
    - Tự động chuyển hướng về trang chủ sau 3 giây.
- **Thất bại**: Hiện thông báo "Email không tồn tại hoặc gói tập đã hết hạn. Vui lòng liên hệ lễ tân."

---

## 3. Ưu điểm khi làm theo cách này

1. **Dễ Test**: Bạn chỉ cần dùng máy tính truy cập link, nhập thử các Email khách nhau (Email đúng/Email sai/Email hết hạn) để xem hệ thống phản hồi.
2. **Bảo mật**: Dù khách hàng không đăng nhập, hệ thống vẫn kiểm tra chéo được quyền lợi dựa trên Email và trạng thái gói tập trong Database.
3. **Mở rộng**: Sau này khi có Hosting, bạn có thể nâng cấp lên việc tự động lấy Email từ tài khoản đang đăng nhập để khách không phải nhập tay nữa.

---

## 4. Các bước triển khai tiếp theo (Dự kiến)

1. **Backend**: Viết Route và Controller xử lý logic `POST` check-in (nhận Email -> Validate -> Save Checkin).
2. **Giao diện**: Tạo trang `checkin-verify.blade.php` với giao diện nhập Email sang trọng, chuyên nghiệp.
3. **QR**: Tạo trang hiển thị mã QR tĩnh/động cho nhân viên lễ tân.

---
**Kết luận**: Luồng này hoàn toàn khả thi và giải quyết được vấn đề chưa có Hosting của bạn. Nếu bạn đồng ý, tôi sẽ tạo Route và Controller để bắt đầu chạy thử tính năng này.
