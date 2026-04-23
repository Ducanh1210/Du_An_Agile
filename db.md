# CHI TIẾT CẤU TRÚC 20 BẢNG CƠ SỞ DỮ LIỆU - GYM MANAGEMENT

Tài liệu này liệt kê chi tiết cấu trúc các cột dữ liệu theo thứ tự từ bảng gốc đến các bảng phụ thuộc.

---

### 1. Bảng `users` (Người dùng & HLV)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID tự tăng |
| 2 | name | varchar(255) | | Họ và tên |
| 3 | email | varchar(255) | unique | Email đăng nhập |
| 4 | phone | varchar(255) | | Số điện thoại |
| 5 | height | double(8,2) | | Chiều cao (cm) |
| 6 | password | varchar(255) | | Mật khẩu (Hash) |
| 7 | role | varchar(255) | | user, staff, admin, trainer |
| 8 | specialization | enum | | Chuyên môn: gym, yoga, both |
| 9 | price_per_session | decimal(12,2) | | Giá thuê PT theo buổi |
| 10 | is_available | tinyint(1) | | 1: Sẵn sàng, 0: Bận |
| 11 | avatar_url | varchar(255) | | Link ảnh đại diện |
| 12 | is_active | tinyint | | Trạng thái (1: Đang dùng) |
| 13 | email_verified_at | timestamp | | Xác thực email |
| 14 | remember_token | varchar(100) | | Token ghi nhớ |
| 15 | created_at | timestamp | | Ngày tạo |
| 16 | updated_at | timestamp | | Ngày cập nhật |

### 2. Bảng `password_reset_tokens`
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | email | varchar(255) | pk | Email nhận mã |
| 2 | token | varchar(255) | | Mã xác thực khôi phục |
| 3 | created_at | timestamp | | Thời gian yêu cầu |

### 3. Bảng `memberships` (Các gói tập)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID Gói |
| 2 | name | varchar(150) | | Tên gói: Gym 1 Tháng... |
| 3 | category | enum | | gym, yoga |
| 4 | description | text | | Mô tả gói tập |
| 5 | duration_days | int | | Số ngày hiệu lực |
| 6 | price | decimal(12,2) | | Giá gói |
| 7 | allow_pt | tinyint | | 1: Có PT, 0: Không |
| 8 | pt_sessions | int | | Số buổi PT có sẵn |
| 9 | is_active | tinyint | | 1: Kinh doanh, 0: Ngừng |

### 4. Bảng `subscriptions` (Hợp đồng hội viên)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID Hợp đồng |
| 2 | user_id | bigint unsigned | fk | ID Khách hàng |
| 3 | membership_id | bigint unsigned | fk | Gói tập đã chọn |
| 4 | trainer_id | bigint unsigned | fk | PT phụ trách |
| 5 | start_date | date | | Ngày bắt đầu |
| 6 | end_date | date | | Ngày hết hạn |
| 7 | final_price | decimal(12,2) | | Giá thực thu |
| 8 | pt_sessions_left | int | | Số buổi PT còn lại |
| 9 | status | enum | | pending_payment, active, expired, cancelled, frozen |
| 10 | cancel_reason | text | | Lý do hủy hợp đồng |
| 11 | cancelled_at | datetime | | Ngày hủy |
| 12 | frozen_until | date | | Đóng băng đến ngày |

### 5. Bảng `payments` (Thanh toán hóa đơn)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID Giao dịch |
| 2 | subscription_id | bigint unsigned | fk | Liên kết hợp đồng |
| 3 | amount | decimal(12,2) | | Số tiền trả |
| 4 | method | enum | | cash, transfer, e_wallet |
| 5 | status | enum | | pending, completed, refunded, cancelled |
| 6 | invoice_code | varchar(100) | | Mã hóa đơn hệ thống |
| 7 | note | text | | Ghi chú từ khách/nhân viên |
| 8 | confirmed_by | bigint unsigned | fk | Nhân viên duyệt tiền |

### 6. Bảng `schedules` (Lịch lớp học tập thể)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID Lịch |
| 2 | title | varchar(200) | | Tên buổi tập |
| 3 | category | enum | | gym, yoga |
| 4 | trainer_id | bigint unsigned | fk | HLV phụ trách lớp |
| 5 | start_time | datetime | | Giờ mở lớp |
| 6 | end_time | datetime | | Giờ tan lớp |
| 7 | capacity | int | | Số lượng tối đa |
| 8 | current_enrolled | int | | Số người đã đăng ký |
| 9 | status | enum | | upcoming, ongoing, completed, cancelled |

### 7. Bảng `bookings` (Đặt chỗ & Báo cáo PT)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID Booking |
| 2 | user_id | bigint unsigned | fk | ID Người tập |
| 3 | subscription_id | bigint unsigned | fk | Hợp đồng áp dụng |
| 4 | booking_type | enum | | class, pt_session |
| 5 | target_area | varchar(255) | | Vùng tập (Tay, Ngực...) |
| 6 | schedule_id | bigint unsigned | fk | Link bảng schedules |
| 7 | trainer_id | bigint unsigned | fk | Link bảng users (PT) |
| 8 | start_time | datetime | | Thời gian tập |
| 9 | end_time | datetime | | Thời gian kết thúc |
| 10 | status | enum | | confirmed, cancelled, completed |
| 11 | reschedule_status| enum | | none, pending, approved, rejected |
| 12 | reschedule_reason| text | | Lý do dời lịch |
| 13 | reschedule_at | timestamp | | Lúc gửi yêu cầu dời |
| 14 | report_content | text | | Nhận xét chi tiết của PT |
| 15 | effort_rating | int | | Chấm điểm nỗ lực (1-10) |
| 16 | session_intensity| varchar(255) | | Cường độ (Low, Med, High) |

### 8. Bảng `checkins` (Điểm danh QR)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID |
| 2 | user_id | bigint unsigned | fk | ID Khách |
| 3 | subscription_id | bigint unsigned | fk | Gói tập hợp lệ |
| 4 | qr_token | varchar(255) | unique| Mã QR động |
| 5 | expires_at | datetime | | Hết hạn mã QR |
| 6 | checked_in_at | datetime | | Giờ vào phòng tập |
| 7 | status | enum | | active, used, expired |

### 9. Bảng `health_metrics` (Chỉ số InBody)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID |
| 2 | user_id | bigint unsigned | fk | Khách hàng đo |
| 3 | trainer_id | bigint unsigned | fk | PT thực hiện đo |
| 4 | weight | double(8,2) | | Cân nặng (kg) |
| 5 | bmi | double(8,2) | | Chỉ số cơ thể |
| 6 | fat_percent | double(8,2) | | % Mỡ |
| 7 | recorded_by | enum | | user / trainer |

### 10. Bảng `reviews` (Đánh giá dịch vụ)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID |
| 2 | user_id | bigint unsigned | fk | Người đánh giá |
| 3 | trainer_id | bigint unsigned | fk | Đối tượng bị đánh giá |
| 4 | booking_id | bigint unsigned | fk | Theo buổi tập nào |
| 5 | rating | int | | 1 - 5 sao |
| 6 | comment | text | | Nội dung đánh giá |

### 11. Bảng `equipments` (Máy móc thiết bị)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID Máy |
| 2 | name | varchar(150) | | Tên thiết bị |
| 3 | description | text | | Mô tả công dụng |
| 4 | status | enum | | active, maintenance, broken |
| 5 | last_maintained_at| date | | Ngày bảo trì gần nhất |

### 12. Bảng `news_categories` (Danh mục tin tức)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID |
| 2 | name | varchar(255) | | Tên danh mục |
| 3 | slug | varchar(255) | unique | Link không dấu SEO |

### 13. Bảng `news` (Bài viết tin tức)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID News |
| 2 | title | varchar(255) | | Tiêu đề bài viết |
| 3 | slug | varchar(255) | unique | Link bài viết |
| 4 | content | longtext | | Nội dung chi tiết |
| 5 | tags_list | text | | Danh sách tag |
| 6 | news_status | enum | | draft, pending, published, hidden |
| 7 | views | int | | Số lượt xem |
| 8 | published_at | timestamp | | Ngày lên sóng |

### 14. Bảng `news_comments` (Bình luận bài viết)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID |
| 2 | news_id | bigint unsigned | fk | Bình luận vào bài nào |
| 3 | user_id | bigint unsigned | fk | Ai bình luận |
| 4 | content | text | | Nội dung bình luận |
| 5 | is_approved | tinyint(1) | | 1: Đã duyệt, 0: Chờ |

### 15. Bảng `leave_requests` (Yêu cầu nghỉ phép)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID |
| 2 | trainer_id | bigint unsigned | fk | PT xin nghỉ (HLV) |
| 3 | reason | text | | Lý do vắng mặt |
| 4 | status | enum | | pending, approved, rejected |
| 5 | admin_note | text | | Phản hồi từ quản lý |
| 6 | resolved_by | bigint unsigned | fk | Người duyệt đơn |

### 16. Bảng `notifications` (Thông báo)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | char(36) | pk | UUID thông báo |
| 2 | type | varchar(255) | | Loại (Model class) |
| 3 | notifiable_id | bigint unsigned | | ID người nhận |
| 4 | data | text | | Nội dung (Dạng Json) |
| 5 | read_at | timestamp | | Giờ người dùng mở xem |

### 17. Bảng `personal_access_tokens` (Token bảo mật Laravel)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID Token |
| 2 | tokenable_id | bigint unsigned | | ID đối tượng (users) |
| 3 | name | varchar(255) | | Tên token |
| 4 | token | varchar(64) | | Giá trị token |
| 5 | last_used_at | timestamp | | Lần cuối sử dụng |

### 18. Bảng `jobs` (Hàng đợi hệ thống)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID tác vụ |
| 2 | queue | varchar(255) | | Tên hàng đợi |
| 3 | payload | longtext | | Dữ liệu công việc |
| 4 | attempts | tinyint unsigned | | Số lần thử lại |

### 19. Bảng `failed_jobs` (Lịch sử lỗi hệ thống)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | bigint unsigned | pk | ID |
| 2 | uuid | varchar(255) | unique| Định danh lỗi |
| 3 | exception | longtext | | Chi tiết nguyên nhân lỗi |
| 4 | failed_at | timestamp | | Thời điểm xảy ra |

### 20. Bảng `migrations` (Lịch sử phiên bản CSDL)
| No. | Name | Type | Key | Ghi chú |
|:---:|---|---|:---:|---|
| 1 | id | int unsigned | pk | ID |
| 2 | migration | varchar(255) | | Tên tệp phiên bản |
| 3 | batch | int | | Nhóm cập nhật |
