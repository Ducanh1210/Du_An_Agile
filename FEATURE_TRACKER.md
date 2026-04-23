# 📋 Danh Sách Cần Hoàn Thiện - Dự Án Quản Lý Gym (Du_An_Agile)

Tài liệu này liệt kê các tính năng hiện có và các khoảng trống cần thực hiện để hoàn thiện dự án.

---

## 🟢 1. CÁC TÍNH NĂNG ĐÃ HOÀN THÀNH (READY)
Các tính năng này đã có Route, Model và UI cơ bản:

- **Hệ thống Hội viên (Memberships):**
    - [x] CRUD Gói tập (Admin).
    - [x] Đăng ký gói tập & Thanh toán VNPay.
    - [x] Quản lý gói tập cá nhân (Renew/Cancel).
- **Quản lý HLV & Đặt lịch (PT Booking):**
    - [x] Đặt lịch 1-on-1 với HLV.
    - [x] Check-in buổi tập (HLV thực hiện).
    - [x] Báo cáo buổi tập & Cập nhật chỉ số sức khỏe (Health Metrics).
    - [x] Xin nghỉ dạy & Duyệt nghỉ dạy.
- **Quản lý Lớp học (Class Schedule):**
    - [x] Thời khóa biểu dạng Weekly Calendar.
    - [x] Đăng ký tham gia lớp học.
    - [x] Quản lý lịch lớp (Admin).
- **Nội dung & CMS:**
    - [x] Quản lý tin tức (Bài viết, Danh mục, Tag, Bình luận).
    - [x] Trình soạn thảo văn bản chuyên nghiệp.
- **Doanh thu & Hệ thống:**
    - [x] Thống kê doanh thu (Biểu đồ ApexCharts).
    - [x] Quản lý người dùng & Phân quyền (Admin, Staff, Trainer, User).
    - [x] Lấy lại mật khẩu qua mã OTP.

---

## 🟡 2. CÁC TÍNH NĂNG ĐANG DỞ DANG / CẦN LÀM (TODO)
Dựa trên khảo sát mã nguồn, đây là những phần bạn nên tập trung tiếp theo:

### ⚡ Ưu tiên cao (Trải nghiệm người dùng)
- [ ] **Thông báo tự động (Notifications & Reminders):**
    - Gửi email/thông báo khi gói tập sắp hết hạn (còn 3 ngày).
    - Nhắc lịch tập trước 30 phút.
- [ ] **Kiểm soát số lượng (Capacity Management):**
    - Giới hạn số người tham gia lớp (Hiện tại store booking chưa check số lượng tối đa).
- [ ] **Mã giảm giá (Coupons/Promotions):**
    - Hệ thống mã giảm giá khi thanh toán mua gói tập.

### 🛠️ Quản lý vận hành (Admin/Staff)
- [ ] **Nhật ký thiết bị (Equipment Maintenance):**
    - Hiện tại đã có CRUD thiết bị, nhưng thiếu phần theo dõi lịch bảo trì/hỏng hóc.
- [ ] **Chấm công & Lương (Payroll):**
    - Tính lương cho HLV dựa trên số buổi thực dạy (Session Reports).
- [ ] **Xuất báo cáo (Report Export):**
    - Xuất file Excel/PDF cho bảng lương hoặc báo cáo doanh thu tháng.

### 📱 Tính năng mở rộng
- [ ] **Đăng nhập mạng xã hội (Social Login):**
    - Routes đang được comment lại trong `web.php`. Cần cấu hình Google/Facebook Login.
- [ ] **Đánh giá HLV (Review & Feedback):**
    - Sau khi hoàn thành buổi tập, khách hàng có thể đánh giá sao và comment cho HLV đó.
- [ ] **Thư viện bài tập (Workout Library):**
    - Tạo các video hoặc bài hướng dẫn tập luyện cho khách hàng xem trên app.

---

## 🔴 3. KIỂM TRA LỖI & TỐI ƯU (QA)
- [ ] **SEO Optimization:** Cần bổ sung Meta tags động cho các bài viết và gói tập.
- [ ] **Mobile Responsiveness:** Kiểm tra lại hiển thị lịch lớp (Calendar) trên điện thoại vì lịch tuần thường rất rộng.
- [ ] **Security Scan:** Kiểm tra lại các quyền truy cập Admin (Role Middleware) trên từng Route để tránh lộ dữ liệu.

---

> [!TIP]
> **Lời khuyên:** Bạn nên bắt đầu với phần **Thông báo tự động (CRON Job)** và **Giới hạn số lượng người lớp học** trước, vì đây là các logic nghiệp vụ quan trọng nhất còn thiếu.

