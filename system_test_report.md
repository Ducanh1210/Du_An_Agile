# Báo cáo Kiểm thử Hệ thống (System Test Report)

**Dự án:** Hệ thống Quản lý Phòng tập EXTRA FIT+
**Ngày báo cáo:** 24/04/2026
**Trạng thái tổng quát:** 44/53 PASS (83%) | 9/53 FAIL (17%)

---

## 1. Kết quả chi tiết theo nhóm đối tượng

### 1.1. Khách vãng lai
| Mã test | Tên test | Kết quả mong đợi | Kết quả thực tế | Trạng thái | Ghi chú |
| :--- | :--- | :--- | :--- | :--- | :--- |
| TC01 | Truy cập trang chủ | Hiển thị giao diện trang chủ | PASS | ✅ PASS | |
| TC02 | Trang chủ load chậm | Load < 3s | PASS | ✅ PASS | |
| TC03 | Tìm sản phẩm hợp lệ | Hiển thị đúng sản phẩm | PASS | ✅ PASS | |
| TC04 | Tìm sản phẩm không tồn tại | Thông báo không có kết quả | PASS | ✅ PASS | |
| TC05 | Lọc theo giá | Hiển thị đúng khoảng giá | PASS | ✅ PASS | |
| TC06 | Xem chi tiết sản phẩm | Hiển thị đầy đủ thông tin | PASS | ✅ PASS | |
| **TC07** | **Sản phẩm lỗi** | **Báo lỗi / không hiển thị** | **FAIL** | ❌ **FAIL** | **Chưa xử lý xử lý lỗi 404/Null** |
| TC08 | Đăng ký hợp lệ | Tạo tài khoản thành công | PASS | ✅ PASS | |
| **TC09** | **Email sai định dạng** | **Báo lỗi** | **FAIL** | ❌ **FAIL** | **Không validate định dạng email** |
| TC10 | Login đúng | Đăng nhập thành công | PASS | ✅ PASS | |
| TC11 | Sai mật khẩu | Báo lỗi | PASS | ✅ PASS | |
| TC12 | Bỏ trống đăng nhập | Không cho submit | PASS | ✅ PASS | |

### 1.2. Admin
| Mã test | Tên test | Kết quả mong đợi | Kết quả thực tế | Trạng thái | Ghi chú |
| :--- | :--- | :--- | :--- | :--- | :--- |
| TC13 | Đăng nhập admin hợp lệ | Vào dashboard | PASS | ✅ PASS | |
| TC14 | Đăng nhập sai | Báo lỗi | PASS | ✅ PASS | |
| TC15 | Xem dashboard | Hiện thị thống kê | PASS | ✅ PASS | |
| TC16 | Thêm danh mục | Thành công | PASS | ✅ PASS | |
| TC17 | Xóa danh mục | Thành công | PASS | ✅ PASS | |
| TC18 | Thêm sản phẩm | Thành công | PASS | ✅ PASS | |
| **TC19** | **Thêm SP thiếu dữ liệu** | **Báo lỗi** | **FAIL** | ❌ **FAIL** | **Ko validate trường bắt buộc** |
| TC20 | Sửa sản phẩm | Cập nhật thành công | PASS | ✅ PASS | |
| TC21 | Xóa sản phẩm | Xóa thành công | PASS | ✅ PASS | |
| TC22 | Quản lý User | Hiển thị danh sách | PASS | ✅ PASS | |
| **TC23** | **Phân quyền user** | **Đúng role** | **FAIL** | ❌ **FAIL** | **Lỗi phân quyền khi gán role** |
| TC24 | Tạo mã giảm giá | Thành công | PASS | ✅ PASS | |
| TC25 | Mã giảm giá hết hạn | Không áp dụng | PASS | ✅ PASS | |
| TC26 | Quản lý đơn hàng | Hiển thị danh sách | PASS | ✅ PASS | |
| TC27 | Cập nhật trạng thái đơn | Thành công | PASS | ✅ PASS | |

### 1.3. Nhân viên
| Mã test | Tên test | Kết quả mong đợi | Kết quả thực tế | Trạng thái | Ghi chú |
| :--- | :--- | :--- | :--- | :--- | :--- |
| TC28 | Đăng nhập NV hợp lệ | Đăng nhập thành công | PASS | ✅ PASS | |
| TC29 | Đăng nhập sai mật khẩu | Báo lỗi | PASS | ✅ PASS | |
| TC30 | Truy cập trang quản trị | Hiển thị dashboard NV | PASS | ✅ PASS | |
| TC31 | Xem danh sách đơn hàng | Hiển thị danh sách | PASS | ✅ PASS | |
| TC32 | Cập nhật trạng thái đơn | Cập nhật thành công | PASS | ✅ PASS | |
| **TC33** | **Xử lý đơn không hợp lệ** | **Báo lỗi** | **FAIL** | ❌ **FAIL** | **Chưa validate logic trạng thái** |
| TC34 | Quản lý tồn kho | Hiển thị tồn kho | PASS | ✅ PASS | |
| TC35 | Cập nhật số lượng kho | Thành công | PASS | ✅ PASS | |
| **TC36** | **Nhập số lượng âm** | **Báo lỗi** | **FAIL** | ❌ **FAIL** | **Không validate giá trị âm** |
| TC37 | Quản lý nội dung | Hiển thị nội dung | PASS | ✅ PASS | |
| TC38 | Sửa nội dung | Cập nhật thành công | PASS | ✅ PASS | |

### 1.4. Người dùng (Hội viên)
| Mã test | Tên test | Kết quả mong đợi | Kết quả thực tế | Trạng thái | Ghi chú |
| :--- | :--- | :--- | :--- | :--- | :--- |
| TC39 | Đánh giá sản phẩm hợp lệ | Gửi đánh giá thành công | PASS | ✅ PASS | |
| **TC40** | **Đánh giá thiếu nội dung** | **Báo lỗi** | **FAIL** | ❌ **FAIL** | **Không validate nội dung trống** |
| TC41 | Thêm sản phẩm vào giỏ | Thành công | PASS | ✅ PASS | |
| TC42 | Cập nhật số lượng giỏ | Cập nhật đúng | PASS | ✅ PASS | |
| TC43 | Thanh toán hợp lệ | Đặt hàng thành công | PASS | ✅ PASS | |
| **TC44** | **Thanh toán thiếu info** | **Báo lỗi** | **FAIL** | ❌ **FAIL** | **Bỏ trống địa chỉ không báo lỗi** |
| TC45 | Áp dụng mã giảm giá | Giảm giá đúng | PASS | ✅ PASS | |
| TC46 | Mã giảm giá sai | Báo lỗi | PASS | ✅ PASS | |
| TC47 | Đổi mật khẩu đúng | Thành công | PASS | ✅ PASS | |
| TC48 | Đổi mật khẩu sai pass | Báo lỗi | PASS | ✅ PASS | |
| TC49 | Xem hồ sơ cá nhân | Hiện thị thông tin | PASS | ✅ PASS | |
| TC50 | Cập nhật hồ sơ | Cập nhật thành công | PASS | ✅ PASS | |
| TC51 | Xem danh sách đơn hàng | Hiển thị danh sách | PASS | ✅ PASS | |
| TC52 | Hủy đơn hợp lệ | Hủy thành công | PASS | ✅ PASS | |
| **TC53** | **Hủy đơn đã giao** | **Không cho phép** | **FAIL** | ❌ **FAIL** | **Chưa xử lý logic chặn hủy** |

---

## 2. Tổng hợp các lỗi cần khắc phục

| Mức độ | Nhóm lỗi | Các mã test liên quan |
| :--- | :--- | :--- |
| 🔴 **Nghiêm trọng** | Logic Phân quyền & Trạng thái đơn | TC23, TC33, TC53 |
| 🟡 **Trung bình** | Xử lý lỗi 404 & Thiếu thông tin | TC07, TC44 |
| 🟢 **Thấp** | Thiếu Validation đầu vào | TC09, TC19, TC36, TC40 |

---
*Tài liệu được khởi tạo bởi Antigravity AI để hỗ trợ quá trình sửa lỗi.*
