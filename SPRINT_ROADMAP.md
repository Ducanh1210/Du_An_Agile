# 🗺️ Lộ trình Phát triển (Sprint Roadmap) - EXTRA FIT+

Tài liệu này phân loại các chức năng hiện có của dự án theo cấu trúc Sprint để theo dõi tiến độ và các phần còn thiếu.

---

## 🏃 SPRINT 1: Nền tảng cơ bản (Base Foundation)
*Mục tiêu: Đảm bảo khách hàng có thể vào web, tìm thông tin và mua gói tập.*

-   [x] **Hoàn thiện giao diện trang chủ**: UI hiện đại, Slider, các section HLV/Lớp học/Báo giá.
-   [x] **Tìm kiếm và lọc**:
    -   Lọc HLV theo mục tiêu tập luyện (Target Area).
    -   Tìm kiếm tin tức và danh mục lớp học.
-   [x] **Đăng ký, Đăng nhập, Quên mật khẩu**: Đã có hệ thống Auth (OTP qua email, đổi mật khẩu).
-   [x] **Giỏ hàng & Thanh toán (Gói tập)**: 
    -   Quy trình chọn gói tập (Membership selection).
    -   Tích hợp cổng thanh toán **VNPay**.

---

## 🏃 SPRINT 2: Hoàn thiện trải nghiệm Hội viên (User Experience)
*Mục tiêu: Khách hàng có thể quản lý lịch tập và tương tác với hệ thống.*

-   [x] **Mua hàng & Mã giảm giá**:
    -   Quy trình mua gói tập ổn định.
    -   *Chưa có: Hệ thống mã giảm giá (Coupon/Voucher) chưa triển khai hoàn chỉnh.*
-   [x] **Đánh giá & Bình luận**: 
    -   Bình luận tin tức (News comments).
    -   Đánh giá HLV sau buổi tập (Rating PT).
-   [x] **Quản lý hồ sơ cá nhân (Profile)**: Thay ảnh đại diện, thông tin cá nhân, mật khẩu.
-   [x] **Xem danh sách đơn hàng**: Lịch sử đăng ký gói tập và lịch sử giao dịch thanh toán.
-   [x] **Thao tác đơn hàng**: Hủy lịch tập (Booking cancellation), theo dõi trạng thái gói tập.

---

## 🏃 SPRINT 3: Quản trị & Vận hành (Admin + Staff)
*Mục tiêu: Hệ thống quản lý cho nhân viên và admin tại phòng tập.*

-   [x] **Đăng nhập trang quản trị**: Phân quyền Admin/Staff/Trainer.
-   [x] **Quản lý đơn hàng (Subscriptions)**: 
    -   Duyệt/Hủy thanh toán gói tập.
    -   Theo dõi thời hạn gói tập của hội viên.
-   [x] **Quản lý tồn kho (Thiết bị)**: Quản lý máy móc, trang thiết bị phòng tập (Equipment Management).
-   [x] **Quản lý sản phẩm (Membership Packages)**: Thêm/Sửa/Xóa các gói tập (1 tháng, 6 tháng, 12 tháng).

---

## 🏃 SPRINT 4: Nâng cao & Tối ưu (Advanced Features)
*Mục tiêu: Báo cáo, phân tích và mở rộng tính năng.*

-   [x] **Dashboard**: Thống kê doanh thu trực quan bằng biểu đồ (ApexCharts).
-   [x] **Quản lý danh mục**: Phân loại bài viết, phân loại gói tập, phân loại thiết bị.
-   [x] **Quản lý tài khoản & Phân quyền**: Quản lý danh sách nhân viên, gán vai trò (Roles).
-   [x] **Biến thể sản phẩm (Package Variations)**: 
    -   Gói tập có nhiều mức giá tùy theo quyền lợi (Basic, Premium, VIP).
    -   Gói tập kèm PT hoặc không kèm PT.

---

## 🚀 TÌNH TRẠNG HIỆN TẠI (Summary)

| Sprint | Trạng thái | Tỷ lệ hoàn thành |
| :--- | :--- | :--- |
| **Sprint 1** | ✅ Hoàn thành | 100% |
| **Sprint 2** | 🔄 Đang hoàn thiện | 90% (Thiếu mã giảm giá) |
| **Sprint 3** | ✅ Hoàn thành | 100% |
| **Sprint 4** | ✅ Hoàn thành | 95% |

---
> [!IMPORTANT]
> **Điểm nhấn**: Chức năng **Điểm danh QR (Check-in)** vừa được hoàn thiện là một bước tiến vượt bậc nằm ngoài lộ trình cơ bản ban đầu, giúp dự án trở nên chuyên nghiệp và thực tế hơn rất nhiều.

*Tài liệu được cập nhật bởi Antigravity AI.*
