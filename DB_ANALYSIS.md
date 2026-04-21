# Báo cáo Phân tích Hệ thống Database (Đã tối ưu)

Dựa trên trạng thái hiện tại của Database, dưới đây là thống kê chi tiết 24 bảng đang hoạt động. Các bảng thừa đã được loại bỏ thành công.

## 1. Thống kê chung (Sau tối ưu)
- **Tổng số bảng:** 24 bảng (Giảm 2 bảng so với ban đầu).
- **Trạng thái:** Tinh gọn, chỉ giữ lại các bảng có sử dụng trong mã nguồn.

## 2. Danh sách các bảng & Mục đích sử dụng

### Nhóm Cốt lõi (Quan trọng nhất)
| Tên bảng | Trạng thái | Mục đích |
| :--- | :--- | :--- |
| `users` | Hoạt động | Lưu trữ tài khoản người dùng, admin, PT, nhân viên. |
| `memberships` | Hoạt động | Danh mục các gói tập (Gym, Yoga, PT). |
| `subscriptions` | Hoạt động | Các gói tập mà người dùng đã mua thực tế. |
| `payments` | Hoạt động | Lịch sử giao dịch VNPAY hoặc tiền mặt. |

### Nhóm Tập luyện & Đặt chuyển
| Tên bảng | Trạng thái | Mục đích |
| :--- | :--- | :--- |
| `schedules` | Hoạt động | Lịch học của các lớp Gym/Yoga cố định. |
| `bookings` | Hoạt động | Danh sách đăng ký lớp hoặc đặt lịch PT 1-1. |
| `checkins` | Hoạt động | Quản lý điểm danh bằng QR Code. |
| `trainers` | Hoạt động | Thông tin chuyên môn của huấn luyện viên. |
| `reschedule_requests` | Hoạt động | Yêu cầu đổi lịch tập của hội viên. |
| `session_reports` | Hoạt động | Báo cáo kết quả buổi tập từ PT cho hội viên. |

### Nhóm Nội dung & Tương tác
| Tên bảng | Trạng thái | Mục đích |
| :--- | :--- | :--- |
| `news` | Hoạt động | Bài viết tin tức. |
| `news_categories` | Hoạt động | Chuyên mục tin tức. |
| `news_tags` / `news_post_tag` | Hoạt động | Gắn thẻ bài viết (Sử dụng cho SEO). |
| `news_comments` | Hoạt động | Bình luận của người dùng. |
| `reviews` | Hoạt động | Đánh giá PT từ hội viên. |
| `health_metrics` | Hoạt động | Theo dõi chỉ số cơ thể (BMI, cân nặng). |
| `notifications` | Hoạt động | Thông báo hệ thống (Đã chuẩn hóa Laravel). |

### Nhóm Hệ thống (Laravel Standard)
- `migrations`: Theo dõi lịch sử cập nhật DB.
- `jobs` / `failed_jobs`: Xử lý hàng đợi (gửi mail, quét lịch tập).
- `password_reset_tokens`: Quên mật khẩu.
- `equipments`: Quản lý trang thiết bị phòng tập.

---

## 3. Các thành phần đã loại bỏ (Dọn dẹp)
1.  ~~`personal_access_tokens`~~: Đã xóa vì không sử dụng API/Mobile App.
2.  ~~`support_tickets`~~: Đã xóa vì chưa phát triển chức năng hỗ trợ qua ticket.

## 4. Trạng thái hiện tại
- [x] Database đã được tinh gọn.
- [x] Model User đã được gỡ bỏ Sanctum (HasApiTokens).
- [x] Toàn bộ Index và Foreign Keys được giữ nguyên để đảm bảo hiệu năng.

---
*Báo cáo này được cập nhật lần cuối vào ngày 21/04/2026 sau khi hoàn tất dọn dẹp.*
