# Đề xuất Chi tiết: Chiến lược Gộp bảng & Tối giản Database

Tài liệu này phân tích chi tiết khả năng gộp các bảng trong hệ thống Gym của bạn để giải quyết vấn đề "quá nhiều bảng gây rối mắt" (hiện tại là 24 bảng).

---

## 1. Phương án: Gộp Huấn luyện viên vào Người dùng
**Bảng mục tiêu:** `trainers` -> `users`

| Tiêu chí | Trước khi gộp | Sau khi gộp |
| :--- | :--- | :--- |
| **Cấu trúc** | 2 bảng riêng biệt, liên kết qua `user_id`. | Thêm các cột HLV trực tiếp vào bảng `users`. |
| **Truy vấn** | Phải dùng `Join` hoặc `With`. | Truy vấn trực tiếp từ bảng User. |
| **Ưu điểm** | Chuẩn hóa dữ liệu (Normalization). | **Cực kỳ đơn giản**, code ngắn gọn hơn. |
| **Hạn chế** | Nhiều bảng hơn. | Bảng User sẽ có nhiều cột bị NULL (nếu user không phải HLV). |

**Đánh giá:** ✅ **Nên làm.** Website của bạn quy mô 1 phòng tập, gộp lại sẽ giúp quản lý HLV trong trang Admin nhanh hơn rất nhiều.

---

## 2. Phương án: Gộp Đổi lịch & Báo cáo vào Đặt lịch
**Bảng mục tiêu:** `reschedule_requests`, `session_reports` -> `bookings`

| Tiêu chí | Trước khi gộp | Sau khi gộp |
| :--- | :--- | :--- |
| **Quản lý** | Dữ liệu buổi tập nằm rải rác 3 bảng. | Tất cả nằm trong 1 bản ghi `bookings`. |
| **Trạng thái** | Phải check bảng Request để biết có đổi lịch không. | Chỉ cần check cột `reschedule_status` trong Bookings. |
| **Ưu điểm** | Lưu trữ được nhiều yêu cầu đổi lịch. | **Dễ bao quát**, 1 buổi tập = 1 dòng dữ liệu. |

**Đánh giá:** ✅ **Nên làm.** Thông thường hội viên chỉ đổi lịch 1-2 lần cho 1 buổi tập, gộp vào bảng chính sẽ giúp Admin kiểm soát lịch trình tốt hơn.

---

## 3. Phương án: Gộp Thẻ Tin tức vào bài viết
**Bảng mục tiêu:** `news_tags`, `news_post_tag` -> `news`

| Tiêu chí | Trước khi gộp | Sau khi gộp |
| :--- | :--- | :--- |
| **Cách lưu** | Lưu ID thẻ trong bảng trung gian. | Lưu chuỗi `"gym, yoga, fitness"` vào cột `tags`. |
| **Tìm kiếm** | Tìm theo ID (Nhanh). | Tìm theo từ khóa (LIKE %tag%). |
| **Ưu điểm** | Chuyên nghiệp, chuẩn SEO. | **Giảm số lượng bảng lớn nhất** (bớt được 2 bảng). |

**Đánh giá:** ⚠️ **Cân nhắc.** Nếu bạn không có hàng ngàn bài viết, việc dùng chuỗi String cho Tag là lựa chọn tuyệt vời để giảm độ phức tạp của DB.

---

## 4. Phương án: Gộp Chỉ số Sức khỏe vào Người dùng
**Bảng mục tiêu:** `health_metrics` -> `users`

- **Nếu gộp:** Bạn chỉ biết được cân nặng/chiều cao *hiện tại*.
- **Nếu để riêng:** Bạn có thể vẽ biểu đồ xem tháng trước user nặng bao nhiêu, tháng này bao nhiêu.

**Đánh giá:** ❌ **Không nên.** Tính năng theo dõi sức khỏe thường cần lịch sử để tăng giá trị cho hội viên.

---

## Tác động kỹ thuật (Technical Impact)

Nếu chúng ta thực hiện gộp (Ví dụ gộp HLV và Đổi lịch):
1. **Migration:** Phải chạy migration để chuyển toàn bộ dữ liệu hiện có sang cột mới.
2. **Model:** Sửa file `Trainer.php` và `User.php`.
3. **Controller:** Sửa các hàm CRUD (Thêm/Sửa/Xóa) HLV và Lịch tập.
4. **View:** Cập nhật lại các trang hiển thị danh sách HLV và Lịch tập.

---

### Lời khuyên của tôi:
Để website của bạn trông "thoáng" nhất mà vẫn giữ được tính năng, bạn nên chọn gộp: **HLV (Trainers)** và **Biểu mẫu Đổi lịch/Báo cáo**. Việc này sẽ giúp bạn bớt được 3 bảng mà code lại dễ hiểu hơn.

**Bạn thấy phương án nào hợp lý nhất với mong muốn của mình?**
