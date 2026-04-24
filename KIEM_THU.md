# CHƯƠNG 4: KIỂM THỬ, ĐÁNH GIÁ VÀ ĐỊNH HƯỚNG PHÁT TRIỂN

## 4.1. Kế hoạch và phương pháp kiểm thử

Trong quá trình xây dựng và hoàn thiện hệ thống website quản lý phòng tập **EXTRA FIT+**, nhóm đã tiến hành kiểm thử để đảm bảo hệ thống vận hành ổn định, đúng yêu cầu và mang lại trải nghiệm tốt nhất cho người dùng. Quá trình kiểm thử được chia thành hai giai đoạn chính: kiểm thử đơn vị (Unit Testing) và kiểm thử tích hợp (Integration Testing).

### 4.1.1. Phương pháp kiểm thử (Unit Test, Integration Test)
Để đảm bảo hệ thống vận hành đúng với các yêu cầu và chức năng đã đề ra, nhóm thực hiện hai phương pháp kiểm thử chính:

*   **Unit Test (Kiểm thử đơn vị):**
    Kiểm tra tính chính xác của từng module, hàm hoặc chức năng nhỏ trong hệ thống. Các kiểm thử đơn vị được thực hiện trực tiếp trên từng chức năng như đăng nhập, đăng ký gói tập, tính toán ngày hết hạn, xử lý logic trừ buổi tập PT... bằng framework PHPUnit tích hợp sẵn trong Laravel.

*   **Integration Test (Kiểm thử tích hợp):**
    Kiểm tra sự phối hợp giữa các module khi hoạt động cùng nhau. Các luồng thực tế như "Hội viên đăng ký gói → Thanh toán trực tuyến VNPay → Hệ thống cấp mã QR → Điểm danh tại quầy" hoặc "Hội viên đặt lịch PT → HLV xác nhận → Trừ buổi tập" được mô phỏng và kiểm thử để đảm bảo các thành phần hệ thống tương tác đúng và ổn định.

### 4.1.2. Kết quả kiểm thử các chức năng chính

| Giai đoạn | Nội dung kiểm thử | Người thực hiện | Thời gian |
| :--- | :--- | :--- | :--- |
| **Giai đoạn 1** | Kiểm thử đơn vị các module (Auth, Payment Logic, PT Booking) | Developer | 13/04 - 15/04 |
| **Giai đoạn 2** | Kiểm thử tích hợp toàn hệ thống (Luồng thanh toán & Check-in) | Developer + Tester | 18/04 - 20/04 |
| **Giai đoạn 3** | Kiểm thử giao diện người dùng (UI/UX Test trên Mobile & Desktop) | Tester | 21/04 - 22/04 |
| **Giai đoạn 4** | Sửa lỗi, hiệu chỉnh và kiểm thử lại hệ thống (Final Polish) | Developer | 23/04 - 24/04 |

**Bảng 4.1: Tiến độ và kết quả kiểm thử các chức năng chính**

---

## 4.2. Đánh giá kết quả kiểm thử

*   **Tính chính xác:** Các chức năng chính (Đăng ký gói, Thanh toán VNPay, Đặt lịch PT, Điểm danh QR) vận hành đúng như mong đợi. Dữ liệu được xử lý chính xác, không phát sinh lỗi nghiêm trọng về logic tài chính hay quản lý lịch tập.
*   **Tính ổn định:** Hệ thống hoạt động ổn định trong suốt quá trình kiểm thử, không bị gián đoạn hay crash ngay cả khi giả lập nhiều người dùng truy cập cùng lúc.
*   **Tính thân thiện với người dùng:** Giao diện trực quan, hiện đại, tối ưu hóa cho cả thiết bị di động (Responsive). Các quy trình phức tạp được tối giản hóa giúp người dùng dễ dàng thao tác.

**Kết luận:** Hệ thống đã sẵn sàng để triển khai thực tế tại trung tâm EXTRA FIT+, đáp ứng đầy đủ các yêu cầu của người dùng và đơn vị quản lý.

---

## 4.3. Định hướng phát triển trong tương lai

Để hệ thống ngày càng hoàn thiện và đáp ứng nhu cầu ngày càng đa dạng của thị trường Fitness, nhóm định hướng phát triển các tính năng sau:

1.  **Phát triển ứng dụng di động (Mobile App):** Xây dựng ứng dụng native trên Android và iOS để hội viên có thể nhận thông báo đẩy (Push Notification) về lịch tập, quét mã QR check-in tiện lợi và theo dõi chỉ số cơ thể.
2.  **Tích hợp AI hỗ trợ luyện tập:** Phân tích dữ liệu tập luyện để tự động gợi ý lộ trình tập (Workout Plan) và chế độ dinh dưỡng (Meal Plan) cá nhân hóa cho từng hội viên.
3.  **Tích hợp đa dạng cổng thanh toán:** Mở rộng kết nối với các ví điện tử phổ biến như MoMo, ZaloPay, ShopeePay để tăng tính tiện lợi khi đóng phí.
4.  **Hệ thống quản lý thiết bị thông minh (IoT):** Kết nối mã QR với hệ thống cửa xoay hoặc khóa tủ đồ thông minh tại phòng tập để tự động hóa hoàn toàn quy trình ra vào.
5.  **Cộng đồng hội viên (Social Fitness):** Cho phép hội viên chia sẻ kết quả tập luyện, tạo các thử thách (Challenge) nhóm để tăng tính tương tác và động lực tập luyện.
6.  **Hệ thống đánh giá HLV & Chất lượng dịch vụ:** Cho phép hội viên phản hồi, chấm điểm sau mỗi buổi tập với PT để nâng cao chất lượng phục vụ.
7.  **Phân tích dữ liệu kinh doanh (Business Intelligence):** Cung cấp các báo cáo chuyên sâu về xu hướng đăng ký, dự báo doanh thu và phân tích hiệu suất làm việc của đội ngũ HLV.

## KẾT LUẬN CHUNG

Trong suốt quá trình nghiên cứu và triển khai, nhóm đã xây dựng thành công hệ thống **EXTRA FIT+** - Website hỗ trợ quản lý và vận hành phòng tập Gym chuyên nghiệp. Đồ án không chỉ giải quyết được các yêu cầu cơ bản về quản lý hội viên, huấn luyện viên (PT), các gói tập và doanh thu, mà còn mở rộng thêm các tính năng hiện đại như điểm danh bằng mã QR, đặt lịch tập luyện tương tác và phân tích doanh thu trực quan.

Hệ thống góp phần số hóa toàn diện quy trình vận hành của phòng tập, giảm thiểu các sai sót thủ công trong việc kiểm soát ra vào và quản lý buổi tập PT. Điều này không chỉ tiết kiệm thời gian cho đội ngũ nhân viên quản lý mà còn mang đến trải nghiệm hiện đại, thuận tiện và minh bạch hơn cho hội viên.

Tuy vậy, do giới hạn về thời gian và nguồn lực, **EXTRA FIT+** vẫn còn một số hạn chế nhất định như: cần tối ưu hóa hơn nữa hiệu năng khi số lượng hội viên truy cập đồng thời tăng cao và giao diện cần tiếp tục tinh chỉnh để đạt độ hoàn mỹ cao nhất trên mọi loại thiết bị.

Trong tương lai, nhóm định hướng tiếp tục phát triển theo các hướng trọng tâm:
1.  Nâng cấp hệ thống thành nền tảng quản lý chuỗi phòng tập đa chi nhánh với khả năng đồng bộ dữ liệu thời gian thực.
2.  Ứng dụng AI để phân tích xu hướng tập luyện và đề xuất lộ trình cá nhân hóa sâu hơn cho khách hàng.
3.  Hoàn thiện hệ sinh thái di động (Mobile App) để tăng tính linh hoạt và gắn kết giữa phòng tập và hội viên.

Đồ án là minh chứng cho việc vận dụng kiến thức công nghệ đã học vào giải quyết các bài toán thực tế của ngành Fitness, đồng thời là nền tảng vững chắc để nhóm tiếp tục nghiên cứu, hoàn thiện và thương mại hóa hệ thống trong tương lai.

---
*Người báo cáo: Antigravity AI (Coding Assistant)*
*Ngày hoàn tất: 24/04/2026*
