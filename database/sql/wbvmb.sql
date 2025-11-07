-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 07, 2025 lúc 03:45 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `wbvmb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bai_viet`
--

CREATE TABLE `bai_viet` (
  `id` int(11) NOT NULL,
  `id_danh_muc` int(11) NOT NULL,
  `id_tac_gia` int(11) NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `mo_ta_ngan` text DEFAULT NULL COMMENT 'Mô tả ngắn/sapo cho bài viết',
  `noi_dung` longtext NOT NULL,
  `hinh_anh_dai_dien` varchar(255) DEFAULT NULL,
  `trang_thai` enum('xuat_ban','nhap','cho_duyet') NOT NULL DEFAULT 'nhap',
  `luot_xem` int(11) NOT NULL DEFAULT 0,
  `ngay_xuat_ban` datetime DEFAULT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp(),
  `ngay_cap_nhat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bai_viet`
--

INSERT INTO `bai_viet` (`id`, `id_danh_muc`, `id_tac_gia`, `tieu_de`, `slug`, `mo_ta_ngan`, `noi_dung`, `hinh_anh_dai_dien`, `trang_thai`, `luot_xem`, `ngay_xuat_ban`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 3, 1, 'Đổi ngày bay, giờ bay, hành trình bay như thế nào?', 'doi-ngay-gio-hanh-trinh-bay', 'Hướng dẫn cách thay đổi thông tin chuyến bay như ngày, giờ, hành trình dễ dàng.', '<p>Để đổi ngày bay, giờ bay hoặc hành trình, hành khách cần liên hệ trực tiếp với hãng hàng không hoặc đại lý nơi mua vé. \r\nTùy theo hạng vé, bạn có thể phải trả thêm phí đổi hoặc chênh lệch giá vé. \r\nMột số hãng cho phép đổi trực tuyến trên website hoặc ứng dụng di động.</p>', NULL, 'xuat_ban', 6, '2025-10-28 00:04:31', '2025-10-27 17:04:31', '2025-11-05 17:29:34'),
(2, 3, 1, 'Mẹo xử lý tại sân bay tránh mất tiền oan', 'meo-xu-ly-tai-san-bay-tranh-mat-tien-oan', 'Những lưu ý khi làm thủ tục, gửi hành lý, và di chuyển trong sân bay để tránh rủi ro mất tiền.', '<p>Khi ở sân bay, không nên nhận giữ hộ hành lý của người lạ, luôn kiểm tra kỹ vé và giấy tờ cá nhân. \r\nHạn chế đổi tiền hoặc mua hàng tại khu vực không rõ nguồn gốc. \r\nNếu gặp vấn đề, hãy liên hệ ngay với quầy thông tin hoặc an ninh sân bay để được hỗ trợ.</p>', NULL, 'xuat_ban', 1, '2025-10-28 00:04:31', '2025-10-27 17:04:31', '2025-11-05 17:29:42'),
(3, 3, 1, 'Thủ tục đi máy bay', 'thu-tuc-di-may-bay', 'Hướng dẫn chi tiết các bước làm thủ tục từ khi đến sân bay cho đến khi lên máy bay.', '<p>Hành khách cần có mặt tại sân bay trước giờ khởi hành ít nhất 2 tiếng đối với chuyến nội địa và 3 tiếng với chuyến quốc tế. \r\nCác bước gồm: check-in, gửi hành lý, kiểm tra an ninh, và lên máy bay. \r\nNhớ mang theo giấy tờ tùy thân hợp lệ (CMND/CCCD, hộ chiếu, vé điện tử).</p>', NULL, 'xuat_ban', 0, '2025-10-28 00:04:31', '2025-10-27 17:04:31', '2025-10-27 17:04:31'),
(4, 3, 1, 'Tổng hợp xe trung chuyển từ sân bay về trung tâm thành phố', 'xe-trung-chuyen-tu-san-bay-ve-trung-tam', 'Danh sách các dịch vụ xe trung chuyển, taxi, bus từ sân bay về trung tâm thành phố.', '<p>Các sân bay lớn như Nội Bài, Tân Sơn Nhất, Đà Nẵng đều có xe buýt, taxi, và dịch vụ trung chuyển. \r\nHành khách có thể đặt xe công nghệ (Grab, Be) hoặc đi xe bus sân bay với giá rẻ hơn. \r\nLuôn kiểm tra bảng giá niêm yết để tránh bị chặt chém.</p>', NULL, 'xuat_ban', 0, '2025-10-28 00:04:31', '2025-10-27 17:04:31', '2025-10-27 17:04:31'),
(5, 3, 1, 'Những quy định về hành lý khi đi máy bay', 'quy-dinh-hanh-ly-di-may-bay', 'Tổng hợp quy định về trọng lượng, kích thước và vật phẩm cấm mang theo khi đi máy bay.', '<p>Hành khách được mang 7kg hành lý xách tay và 20–30kg hành lý ký gửi tùy hãng. \r\nKhông được mang chất lỏng quá 100ml, vật sắc nhọn hoặc chất dễ cháy. \r\nNên dán tên và số điện thoại lên vali để tránh thất lạc.</p>', NULL, 'xuat_ban', 0, '2025-10-28 00:04:31', '2025-10-27 17:04:31', '2025-10-27 17:04:31'),
(6, 3, 1, 'Những quy định đi máy bay đối với phụ nữ mang thai', 'quy-dinh-di-may-bay-voi-phu-nu-mang-thai', 'Các quy định và lưu ý cho phụ nữ mang thai khi di chuyển bằng đường hàng không.', '<p>Phụ nữ mang thai dưới 32 tuần thường được phép bay bình thường. \r\nTừ 32 đến 36 tuần, cần giấy xác nhận sức khỏe của bác sĩ. \r\nTrên 36 tuần, đa số hãng hàng không từ chối vận chuyển để đảm bảo an toàn. \r\nLuôn nên hỏi kỹ hãng trước khi đặt vé.</p>', NULL, 'xuat_ban', 0, '2025-10-28 00:04:31', '2025-10-27 17:04:31', '2025-10-27 17:04:31'),
(7, 3, 1, 'Những giấy tờ cần xuất trình khi đi máy bay', 'giay-to-can-xuat-trinh-khi-di-may-bay', 'Danh sách các loại giấy tờ bắt buộc khi làm thủ tục bay nội địa và quốc tế.', '<p>Đối với chuyến bay nội địa, hành khách cần mang theo CCCD, CMND hoặc giấy khai sinh cho trẻ em. \r\nVới chuyến bay quốc tế, cần có hộ chiếu và visa (nếu yêu cầu). \r\nNên chuẩn bị bản sao hoặc ảnh chụp dự phòng trong trường hợp thất lạc giấy tờ.</p>', NULL, 'xuat_ban', 2, '2025-10-28 00:04:31', '2025-10-27 17:04:31', '2025-11-03 18:12:00'),
(8, 2, 1, 'Vé máy bay đi Hà Nội – Đón Tết sum vầy cùng Vietjet!', 've-may-bay-di-ha-noi-don-tet-sum-vay-cung-vietjet', 'Vietjet Air mang đến cho hành khách chương trình ưu đãi hấp dẫn khi đặt vé Tết. Hành khách chỉ cần liên hệ Sanvemaybay.vn để được hỗ trợ trọn gói thủ tục mua vé máy bay Tết 2025 Vietjet Air với giá khuyến mãi bất ngờ chỉ từ 99.000Đ. Đặt vé sớm, nhận thêm ưu đãi từ đại lý chính thức của hãng.', '<p><strong>Giá vé máy bay Tết 2026 Vietjet Air có đắt không?</strong></p><p>Vietjet Air là hãng hàng không giá rẻ, hãng bay quen thuộc của nhiều hành khách trên hành trình nội địa cũng như quốc tế. Vào mỗi dịp Tết cũng như mùa cao điểm trong năm, bên cạnh thường xuyên mang đến cho hành khách nhiều chương trình ưu đãi vé hấp dẫn, hãng cũng tăng tần suất nhiều đường bay nội địa, giúp hành khách dễ dàng lựa chọn chuyến bay về quê trong mùa cao điểm Tết.</p><p>Đặt vé máy bay Tết Vietjet Air hành khách dễ dàng lựa chọn các chuyến bay nội địa, trong đó phổ biến nhất là các chuyến bay đến Tp Hồ Chí Minh, Hà Nội, Vinh, Thanh Hóa, Hải Phòng, Đà Nẵng, Huế, Chu Lai… Đường bay giữa Tp Hồ Chí Minh – Đà Nẵng – Hà Nội do hãng khai thác được nhiều hành khách quan tâm, lựa chọn nhất. Bên cạnh các đường bay nội địa, Vietjet Air cũng mang đến cho hành khách nhiều đường bay quốc tế phổ biến, giúp cộng đồng người Việt đang sinh sống ở nước ngoài dễ dàng hồi hương đón Tết đoàn viên.</p><p><figure data-trix-attachment=\"{&quot;contentType&quot;:&quot;image/jpeg&quot;,&quot;filename&quot;:&quot;app-ve-web.jpg&quot;,&quot;filesize&quot;:52048,&quot;height&quot;:254,&quot;href&quot;:&quot;http://localhost/wbvmb/public/storage/JNdp8uYJjO9lnfYD8lhXkdFXypOzs8YjhQhViej5.jpg&quot;,&quot;url&quot;:&quot;http://localhost/wbvmb/public/storage/JNdp8uYJjO9lnfYD8lhXkdFXypOzs8YjhQhViej5.jpg&quot;,&quot;width&quot;:512}\" data-trix-content-type=\"image/jpeg\" data-trix-attributes=\"{&quot;presentation&quot;:&quot;gallery&quot;}\" class=\"attachment attachment--preview attachment--jpg\"><a href=\"http://localhost/wbvmb/public/storage/JNdp8uYJjO9lnfYD8lhXkdFXypOzs8YjhQhViej5.jpg\"><img src=\"http://localhost/wbvmb/public/storage/JNdp8uYJjO9lnfYD8lhXkdFXypOzs8YjhQhViej5.jpg\" width=\"512\" height=\"254\"><figcaption class=\"attachment__caption\"><span class=\"attachment__name\">app-ve-web.jpg</span> <span class=\"attachment__size\">50.83 KB</span></figcaption></a></figure></p><p><strong>Cập Nhật Đầy Đủ Thông Tin </strong><a href=\"https://sanvemaybay.vn/ve-may-bay-di-ha-noi\"><strong>Vé Máy Bay đi Hà Nội</strong></a><strong>&nbsp;</strong></p><p>Khi cần đặt chỗ trên các chuyến bay đi Hà Nội&nbsp; ở thời điểm hiện tại, bạn sẽ thấy được hầu như tất cả các vé máy bay có giá thấp nhất đều đến từ hãng hàng không Vietjet Air. Nguyên nhân là bởi vì tiêu chí của hãng là phục vụ chuyến bay giá rẻ, hướng đến người tiêu dùng tầm trung nhưng dịch vụ vẫn phải đảm bảo đạt chuẩn hàng không quốc tế.</p><p>Khi tra, quý khách có thể thấy giá vé máy bay Vietjet Hà Nội không cao. Hiện tại vé máy bay đi Hà Nội của Vietjet đang có giá một chiều là 1.437.000 – 1.804.000 VNĐ/người và giá khứ hồi là 2.875.000 – 3.480.000 VNĐ/người (đã gộp thuế và các phụ phí).</p><p>Đáp ứng nhu cầu của người dân và du khách dịp Tết Nguyên đán 2026, Vietjet mở bán sớm 2,5 triệu vé bay trong giai đoạn từ 3/2/2026 – 2/3/2026, tức 16 tháng Chạp năm Giáp Thìn đến ngày 13 tháng Giêng năm Bính Ngọ.</p><p>Cụ thể, giá vé từ TP.HCM đi Phú Quốc chỉ từ 610.000 đồng (chưa bao gồm thuế, phí). Các chặng bay từ TP.HCM đi Đà Nẵng, Nha Trang, Buôn Ma Thuột… có giá từ 1.000.000 đồng (chưa bao gồm thuế, phí). Giá vé trên các đường bay đến Hà Nội, Vinh, Thanh Hóa, Hải Phòng… có giá từ 1.610.000 đồng (chưa bao gồm thuế, phí). Ở chiều ngược lại, giá vé chỉ từ 0 đồng (chưa bao gồm thuế, phí), đáp ứng nhu cầu du xuân và khám phá những vùng đất mới, trải nghiệm mới của du khách những ngày xuân.</p><p><strong>Lưu ý:</strong></p><p>Giá vé trên chỉ là giá tham khảo tại thời điểm hiện tại và có thể thay đổi tùy theo thời điểm đặt vé, ngày bay và các chương trình khuyến mãi.</p><p>Giá vé dịp Tết thường sẽ cao hơn nhiều so với ngày thường, đặc biệt là vào các ngày cao điểm.</p><p>Để có giá tốt nhất, bạn nên đặt vé sớm ngay từ bây giờ, vì vé Tết Âm lịch 2026 đã bắt đầu mở bán từ tháng 8 và tháng 9 năm 2025.</p><p>Bạn muốn tìm hiểu giá vé máy bay đi Hà Nội hiện nay là bao nhiêu để đặt vé cho hành trình tham quan thú vị của mình, hãy nhanh tay gọi điện đến đại lý Sanvemaybay.vn&nbsp; để được các tư vấn viên của chúng tôi hướng dẫn book vé và hành trình ưng ý nhất.</p><p>Trang website Sanvemaybay.vn luôn cập nhật các khuyến mãi hấp dẫn thường xuyên cho nhiều đường bay khác nhau, vì vậy hãy thường xuyên truy cập để chủ động đặt vé các bạn nhé! Nếu không có nhiều thời gian tự tìm kiếm, tổng đài Sanvemaybay.vn hotline: 1900 2690 – 02871 065 065 sẽ hỗ trợ bạn tìm giá <a href=\"https://sanvemaybay.vn/\"><span style=\"text-decoration: underline;\">vé máy bay giá rẻ</span></a> Vietjet Hà Nội tốt nhất và đặt ngay trong chưa đến 5 phút kết nối.</p>', 'bai-viet/BHUAcWmEtQ6ggDlRR5ug6K6JKEor63-metadGV0LW8tcGhvLWNvLWhhLW5vaS1lMTc2MjMxODE3MjQwMC5qcGc=-.jpg', 'nhap', 4, '2025-11-06 03:39:28', '2025-11-05 20:42:55', '2025-11-05 20:48:04'),
(9, 2, 1, 'Vé máy bay đi Hà Nội – Đón Tết sum vầy cùng Vietjet Lần 2!', 've-may-bay-di-ha-noi-don-tet-sum-vay-cung-vietjet-lan-2', 'Vietjet Air mang đến cho hành khách chương trình ưu đãi hấp dẫn khi đặt vé Tết. Hành khách chỉ cần liên hệ Sanvemaybay.vn để được hỗ trợ trọn gói thủ tục mua vé máy bay Tết 2025 Vietjet Air với giá khuyến mãi bất ngờ chỉ từ 99.000Đ. Đặt vé sớm, nhận thêm ưu đãi từ đại lý chính thức của hãng.', '<p><strong>Giá vé máy bay Tết 2026 Vietjet Air có đắt không?</strong></p><p>Vietjet Air là hãng hàng không giá rẻ, hãng bay quen thuộc của nhiều hành khách trên hành trình nội địa cũng như quốc tế. Vào mỗi dịp Tết cũng như mùa cao điểm trong năm, bên cạnh thường xuyên mang đến cho hành khách nhiều chương trình ưu đãi vé hấp dẫn, hãng cũng tăng tần suất nhiều đường bay nội địa, giúp hành khách dễ dàng lựa chọn chuyến bay về quê trong mùa cao điểm Tết.</p><p>Đặt vé máy bay Tết Vietjet Air hành khách dễ dàng lựa chọn các chuyến bay nội địa, trong đó phổ biến nhất là các chuyến bay đến Tp Hồ Chí Minh, Hà Nội, Vinh, Thanh Hóa, Hải Phòng, Đà Nẵng, Huế, Chu Lai… Đường bay giữa Tp Hồ Chí Minh – Đà Nẵng – Hà Nội do hãng khai thác được nhiều hành khách quan tâm, lựa chọn nhất. Bên cạnh các đường bay nội địa, Vietjet Air cũng mang đến cho hành khách nhiều đường bay quốc tế phổ biến, giúp cộng đồng người Việt đang sinh sống ở nước ngoài dễ dàng hồi hương đón Tết đoàn viên.</p><p><br></p><p><strong>Cập Nhật Đầy Đủ Thông Tin </strong><a href=\"https://sanvemaybay.vn/ve-may-bay-di-ha-noi\"><strong>Vé Máy Bay đi Hà Nội</strong></a><strong>&nbsp;</strong></p><p>Khi cần đặt chỗ trên các chuyến bay đi Hà Nội&nbsp; ở thời điểm hiện tại, bạn sẽ thấy được hầu như tất cả các vé máy bay có giá thấp nhất đều đến từ hãng hàng không Vietjet Air. Nguyên nhân là bởi vì tiêu chí của hãng là phục vụ chuyến bay giá rẻ, hướng đến người tiêu dùng tầm trung nhưng dịch vụ vẫn phải đảm bảo đạt chuẩn hàng không quốc tế.</p><p>Khi tra, quý khách có thể thấy giá vé máy bay Vietjet Hà Nội không cao. Hiện tại vé máy bay đi Hà Nội của Vietjet đang có giá một chiều là 1.437.000 – 1.804.000 VNĐ/người và giá khứ hồi là 2.875.000 – 3.480.000 VNĐ/người (đã gộp thuế và các phụ phí).</p><p>Đáp ứng nhu cầu của người dân và du khách dịp Tết Nguyên đán 2026, Vietjet mở bán sớm 2,5 triệu vé bay trong giai đoạn từ 3/2/2026 – 2/3/2026, tức 16 tháng Chạp năm Giáp Thìn đến ngày 13 tháng Giêng năm Bính Ngọ.</p><p>Cụ thể, giá vé từ TP.HCM đi Phú Quốc chỉ từ 610.000 đồng (chưa bao gồm thuế, phí). Các chặng bay từ TP.HCM đi Đà Nẵng, Nha Trang, Buôn Ma Thuột… có giá từ 1.000.000 đồng (chưa bao gồm thuế, phí). Giá vé trên các đường bay đến Hà Nội, Vinh, Thanh Hóa, Hải Phòng… có giá từ 1.610.000 đồng (chưa bao gồm thuế, phí). Ở chiều ngược lại, giá vé chỉ từ 0 đồng (chưa bao gồm thuế, phí), đáp ứng nhu cầu du xuân và khám phá những vùng đất mới, trải nghiệm mới của du khách những ngày xuân.</p><p><strong>Lưu ý:</strong></p><p>Giá vé trên chỉ là giá tham khảo tại thời điểm hiện tại và có thể thay đổi tùy theo thời điểm đặt vé, ngày bay và các chương trình khuyến mãi.</p><p>Giá vé dịp Tết thường sẽ cao hơn nhiều so với ngày thường, đặc biệt là vào các ngày cao điểm.</p><p>Để có giá tốt nhất, bạn nên đặt vé sớm ngay từ bây giờ, vì vé Tết Âm lịch 2026 đã bắt đầu mở bán từ tháng 8 và tháng 9 năm 2025.</p><p>Bạn muốn tìm hiểu giá vé máy bay đi Hà Nội hiện nay là bao nhiêu để đặt vé cho hành trình tham quan thú vị của mình, hãy nhanh tay gọi điện đến đại lý Sanvemaybay.vn&nbsp; để được các tư vấn viên của chúng tôi hướng dẫn book vé và hành trình ưng ý nhất.</p><p>Trang website Sanvemaybay.vn luôn cập nhật các khuyến mãi hấp dẫn thường xuyên cho nhiều đường bay khác nhau, vì vậy hãy thường xuyên truy cập để chủ động đặt vé các bạn nhé! Nếu không có nhiều thời gian tự tìm kiếm, tổng đài Sanvemaybay.vn hotline: 1900 2690 – 02871 065 065 sẽ hỗ trợ bạn tìm giá <a href=\"https://sanvemaybay.vn/\"><span style=\"text-decoration: underline;\">vé máy bay giá rẻ</span></a> Vietjet Hà Nội tốt nhất và đặt ngay trong chưa đến 5 phút kết nối.</p>', 'bai-viet/nJQ62FjpRN6hXjsxwzOlUJeU9uPphf-metadGV0LW8tcGhvLWNvLWhhLW5vaS1lMTc2MjMxODE3MjQwMC5qcGc=-.jpg', 'xuat_ban', 4, '2025-11-06 03:49:34', '2025-11-05 20:51:52', '2025-11-07 06:55:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `id_nguoi_dung` int(11) NOT NULL,
  `ma_booking` varchar(50) NOT NULL,
  `ngay_dat` timestamp NOT NULL DEFAULT current_timestamp(),
  `tong_tien` decimal(12,2) NOT NULL DEFAULT 0.00,
  `trang_thai` enum('cho_thanh_toan','da_thanh_toan','huy') DEFAULT 'cho_thanh_toan',
  `phuong_thuc_tt` enum('momo','zalopay','the_tin_dung','tien_mat','khong') DEFAULT 'khong',
  `id_khuyen_mai` int(11) DEFAULT NULL,
  `giam_gia` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `booking`
--

INSERT INTO `booking` (`id`, `id_nguoi_dung`, `ma_booking`, `ngay_dat`, `tong_tien`, `trang_thai`, `phuong_thuc_tt`, `id_khuyen_mai`, `giam_gia`) VALUES
(1, 1, 'VMBJYTNRRFE', '2025-11-02 09:15:21', 1911600.00, 'da_thanh_toan', 'momo', NULL, 0.00),
(2, 1, 'VMBLXBK94BD', '2025-11-02 09:31:44', 1620000.00, 'cho_thanh_toan', 'khong', NULL, 0.00),
(3, 1, 'VMBAIGUL4QH', '2025-11-02 09:32:01', 1620000.00, 'cho_thanh_toan', 'tien_mat', NULL, 0.00),
(4, 1, 'VMBZBFNKEYO', '2025-11-02 09:37:46', 1782000.00, 'cho_thanh_toan', 'tien_mat', NULL, 0.00),
(5, 1, 'VMBWWJ4AO0C', '2025-11-02 09:41:02', 1620000.00, 'cho_thanh_toan', 'tien_mat', NULL, 0.00),
(6, 1, 'VMB5JY5UQOG', '2025-11-02 09:45:05', 1512000.00, 'da_thanh_toan', 'momo', NULL, 0.00),
(7, 1, 'VMBKDCW46NF', '2025-11-02 10:42:42', 1252800.00, 'cho_thanh_toan', 'tien_mat', 1, 0.00),
(8, 1, 'VMBRWCLY5HG', '2025-11-02 10:55:50', 1360800.00, 'cho_thanh_toan', 'khong', NULL, 0.00),
(9, 1, 'VMBDMDLWCRM', '2025-11-02 10:56:06', 1360800.00, 'cho_thanh_toan', 'tien_mat', NULL, 0.00),
(10, 1, 'VMBZNB4IX7P', '2025-11-02 11:06:09', 1782000.00, 'cho_thanh_toan', 'tien_mat', NULL, 0.00),
(11, 1, 'VMBB5TXVNBP', '2025-11-02 11:12:21', 1911600.00, 'cho_thanh_toan', 'tien_mat', NULL, 0.00),
(12, 1, 'VMBU8JXTCCR', '2025-11-02 11:21:48', 1620000.00, 'cho_thanh_toan', 'tien_mat', NULL, 0.00),
(13, 1, 'VMBX3YGQZZM', '2025-11-02 11:26:08', 3192750.00, 'cho_thanh_toan', 'tien_mat', NULL, 0.00),
(14, 1, 'VMBQLQQ8AL9', '2025-11-02 11:35:54', 2835000.00, 'cho_thanh_toan', 'tien_mat', NULL, 0.00),
(15, 1, 'VMBH5YLQLOV', '2025-11-02 11:38:02', 2835000.00, 'cho_thanh_toan', 'tien_mat', NULL, 0.00),
(16, 1, 'VMBQZCLHSBX', '2025-11-02 19:45:23', 2813400.00, 'cho_thanh_toan', 'tien_mat', NULL, 0.00),
(17, 1, 'VMBLWSKAXMF', '2025-11-02 20:25:06', 1814400.00, 'cho_thanh_toan', 'tien_mat', 1, 0.00),
(18, 1, 'VMBONFNIKY6', '2025-11-02 20:45:22', 1252800.00, 'cho_thanh_toan', 'khong', 1, 0.00),
(19, 1, 'VMBUO2AJECU', '2025-11-02 20:45:37', 1566000.00, 'huy', 'khong', NULL, 0.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_hoa_don`
--

CREATE TABLE `chi_tiet_hoa_don` (
  `id` int(11) NOT NULL,
  `id_hoa_don` int(11) NOT NULL,
  `id_ve` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL DEFAULT 1,
  `gia` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_hoa_don`
--

INSERT INTO `chi_tiet_hoa_don` (`id`, `id_hoa_don`, `id_ve`, `so_luong`, `gia`) VALUES
(1, 1, 1, 1, 1620000.00),
(2, 1, 2, 1, 1566000.00),
(3, 2, 4, 1, 1404000.00),
(4, 3, 5, 1, 1566000.00),
(5, 4, 6, 1, 1620000.00),
(6, 5, 7, 1, 1296000.00),
(7, 6, 7, 1, 1296000.00),
(8, 7, 7, 1, 1296000.00),
(9, 8, 8, 1, 1566000.00),
(10, 9, 8, 1, 1566000.00),
(11, 10, 8, 1, 1566000.00),
(12, 11, 8, 1, 1566000.00),
(13, 12, 8, 1, 1566000.00),
(14, 13, 10, 1, 1296000.00),
(15, 14, 10, 1, 1296000.00),
(16, 15, 10, 1, 1296000.00),
(17, 16, 10, 1, 1296000.00),
(18, 17, 10, 1, 1296000.00),
(19, 18, 10, 1, 1296000.00),
(20, 19, 11, 1, 1620000.00),
(21, 20, 11, 1, 1620000.00),
(22, 21, 12, 1, 1566000.00),
(23, 21, 13, 1, 1620000.00),
(24, 22, 14, 1, 1620000.00),
(25, 23, 15, 1, 1620000.00),
(26, 23, 16, 1, 1215000.00),
(27, 24, 17, 1, 1620000.00),
(28, 24, 18, 1, 1215000.00),
(29, 25, 19, 1, 1620000.00),
(30, 25, 20, 1, 1215000.00),
(31, 26, 21, 1, 1296000.00),
(32, 26, 22, 1, 972000.00),
(33, 27, 23, 1, 1296000.00),
(34, 27, 24, 1, 972000.00),
(35, 28, 23, 1, 1296000.00),
(36, 28, 24, 1, 972000.00),
(37, 29, 26, 1, 1566000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chuyen_bay`
--

CREATE TABLE `chuyen_bay` (
  `id` int(11) NOT NULL,
  `ma_chuyen_bay` varchar(50) NOT NULL,
  `id_may_bay` int(11) NOT NULL,
  `id_san_bay_di` int(11) NOT NULL,
  `id_san_bay_den` int(11) NOT NULL,
  `thoi_gian_di` datetime NOT NULL,
  `thoi_gian_den` datetime NOT NULL,
  `gia_ve` decimal(10,2) NOT NULL DEFAULT 0.00,
  `trang_thai` enum('dang_ban','tam_hoan','hoan_tat','huy') NOT NULL DEFAULT 'dang_ban'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chuyen_bay`
--

INSERT INTO `chuyen_bay` (`id`, `ma_chuyen_bay`, `id_may_bay`, `id_san_bay_di`, `id_san_bay_den`, `thoi_gian_di`, `thoi_gian_den`, `gia_ve`, `trang_thai`) VALUES
(1, 'VN1201', 1, 1, 2, '2025-12-05 08:00:00', '2025-12-05 10:10:00', 1500000.00, 'dang_ban'),
(2, 'VN1202', 1, 2, 1, '2025-12-05 17:00:00', '2025-12-05 19:10:00', 1450000.00, 'dang_ban'),
(3, 'VJ305', 2, 1, 3, '2025-12-10 09:30:00', '2025-12-10 11:00:00', 1200000.00, 'dang_ban'),
(4, 'QH221', 3, 3, 2, '2025-12-12 13:00:00', '2025-12-12 14:40:00', 1300000.00, 'dang_ban'),
(5, 'VN1507', 1, 2, 8, '2025-12-22 07:00:00', '2025-12-22 09:00:00', 1900000.00, 'dang_ban'),
(6, 'VJ903', 2, 1, 4, '2025-12-24 10:00:00', '2025-12-24 11:30:00', 1250000.00, 'dang_ban');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_muc_bai_viet`
--

CREATE TABLE `danh_muc_bai_viet` (
  `id` int(11) NOT NULL,
  `ten_danh_muc` varchar(150) NOT NULL,
  `slug` varchar(170) NOT NULL,
  `id_danh_muc_cha` int(11) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `trang_thai` enum('hien_thi','an') DEFAULT 'hien_thi',
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danh_muc_bai_viet`
--

INSERT INTO `danh_muc_bai_viet` (`id`, `ten_danh_muc`, `slug`, `id_danh_muc_cha`, `mo_ta`, `trang_thai`, `ngay_tao`) VALUES
(1, 'Vé khuyến mãi', 've-khuyen-mai', NULL, 'Cập nhật các chương trình giảm giá, ưu đãi vé máy bay mới nhất.', 'hien_thi', '2025-10-27 16:59:12'),
(2, 'Tin tức', 'tin-tuc', NULL, 'Các tin tức mới về hãng hàng không và du lịch.', 'hien_thi', '2025-10-27 16:59:12'),
(3, 'Câu Hỏi Thường Gặp', 'cau-hoi-thuong-gap', NULL, 'Trả lời câu hỏi của khách hàng', 'hien_thi', '2025-10-27 16:59:12'),
(4, 'Kinh nghiệm bay', 'kinh-nghiem-bay', NULL, 'Chia sẻ bí quyết đặt vé, check-in, và kinh nghiệm đi máy bay.', 'hien_thi', '2025-10-27 16:59:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `doanh_thu`
--

CREATE TABLE `doanh_thu` (
  `id` int(11) NOT NULL,
  `id_hoa_don` int(11) DEFAULT NULL,
  `thang` int(11) NOT NULL,
  `nam` int(11) NOT NULL,
  `doanh_thu` decimal(14,2) NOT NULL DEFAULT 0.00,
  `ngay_cap_nhat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ghe`
--

CREATE TABLE `ghe` (
  `id` int(11) NOT NULL,
  `id_may_bay` int(11) NOT NULL,
  `so_ghe` varchar(10) NOT NULL,
  `loai_ghe` enum('phổ thông','thương gia','hạng nhất') NOT NULL DEFAULT 'phổ thông',
  `trang_thai` enum('trong','da_dat') NOT NULL DEFAULT 'trong'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ghe`
--

INSERT INTO `ghe` (`id`, `id_may_bay`, `so_ghe`, `loai_ghe`, `trang_thai`) VALUES
(1, 1, 'A1', 'phổ thông', 'trong'),
(2, 1, 'A2', 'phổ thông', 'trong'),
(3, 1, 'A3', 'phổ thông', 'trong'),
(4, 1, 'A4', 'phổ thông', 'trong'),
(5, 1, 'A5', 'phổ thông', 'trong'),
(6, 1, 'A6', 'phổ thông', 'trong'),
(7, 1, 'A7', 'phổ thông', 'trong'),
(8, 1, 'A8', 'phổ thông', 'trong'),
(9, 1, 'A9', 'phổ thông', 'trong'),
(10, 1, 'A10', 'phổ thông', 'trong'),
(11, 1, 'A11', 'phổ thông', 'trong'),
(12, 1, 'A12', 'phổ thông', 'trong'),
(13, 1, 'A13', 'phổ thông', 'trong'),
(14, 1, 'A14', 'phổ thông', 'trong'),
(15, 1, 'A15', 'phổ thông', 'trong'),
(16, 1, 'A16', 'phổ thông', 'trong'),
(17, 1, 'A17', 'phổ thông', 'trong'),
(18, 1, 'A18', 'phổ thông', 'trong'),
(19, 1, 'A19', 'phổ thông', 'trong'),
(20, 1, 'A20', 'phổ thông', 'trong'),
(21, 1, 'A21', 'phổ thông', 'trong'),
(22, 1, 'A22', 'phổ thông', 'trong'),
(23, 1, 'A23', 'phổ thông', 'trong'),
(24, 1, 'A24', 'phổ thông', 'trong'),
(25, 1, 'A25', 'phổ thông', 'trong'),
(26, 1, 'A26', 'phổ thông', 'trong'),
(27, 1, 'A27', 'phổ thông', 'trong'),
(28, 1, 'A28', 'phổ thông', 'trong'),
(29, 1, 'A29', 'phổ thông', 'trong'),
(30, 1, 'A30', 'phổ thông', 'trong'),
(31, 1, 'B1', 'phổ thông', 'trong'),
(32, 1, 'B2', 'phổ thông', 'trong'),
(33, 1, 'B3', 'phổ thông', 'trong'),
(34, 1, 'B4', 'phổ thông', 'trong'),
(35, 1, 'B5', 'phổ thông', 'trong'),
(36, 1, 'B6', 'phổ thông', 'trong'),
(37, 1, 'B7', 'phổ thông', 'trong'),
(38, 1, 'B8', 'phổ thông', 'trong'),
(39, 1, 'B9', 'phổ thông', 'trong'),
(40, 1, 'B10', 'phổ thông', 'trong'),
(41, 1, 'B11', 'phổ thông', 'trong'),
(42, 1, 'B12', 'phổ thông', 'trong'),
(43, 1, 'B13', 'phổ thông', 'trong'),
(44, 1, 'B14', 'phổ thông', 'trong'),
(45, 1, 'B15', 'phổ thông', 'trong'),
(46, 1, 'B16', 'phổ thông', 'trong'),
(47, 1, 'B17', 'phổ thông', 'trong'),
(48, 1, 'B18', 'phổ thông', 'trong'),
(49, 1, 'B19', 'phổ thông', 'trong'),
(50, 1, 'B20', 'phổ thông', 'trong'),
(51, 1, 'B21', 'phổ thông', 'trong'),
(52, 1, 'B22', 'phổ thông', 'trong'),
(53, 1, 'B23', 'phổ thông', 'trong'),
(54, 1, 'B24', 'phổ thông', 'trong'),
(55, 1, 'B25', 'phổ thông', 'trong'),
(56, 1, 'B26', 'phổ thông', 'trong'),
(57, 1, 'B27', 'phổ thông', 'trong'),
(58, 1, 'B28', 'phổ thông', 'trong'),
(59, 1, 'B29', 'phổ thông', 'trong'),
(60, 1, 'B30', 'phổ thông', 'trong'),
(61, 1, 'C1', 'phổ thông', 'trong'),
(62, 1, 'C2', 'phổ thông', 'trong'),
(63, 1, 'C3', 'phổ thông', 'trong'),
(64, 1, 'C4', 'phổ thông', 'trong'),
(65, 1, 'C5', 'phổ thông', 'trong'),
(66, 1, 'C6', 'phổ thông', 'trong'),
(67, 1, 'C7', 'phổ thông', 'trong'),
(68, 1, 'C8', 'phổ thông', 'trong'),
(69, 1, 'C9', 'phổ thông', 'trong'),
(70, 1, 'C10', 'phổ thông', 'trong'),
(71, 1, 'C11', 'phổ thông', 'trong'),
(72, 1, 'C12', 'phổ thông', 'trong'),
(73, 1, 'C13', 'phổ thông', 'trong'),
(74, 1, 'C14', 'phổ thông', 'trong'),
(75, 1, 'C15', 'phổ thông', 'trong'),
(76, 1, 'C16', 'phổ thông', 'trong'),
(77, 1, 'C17', 'phổ thông', 'trong'),
(78, 1, 'C18', 'phổ thông', 'trong'),
(79, 1, 'C19', 'phổ thông', 'trong'),
(80, 1, 'C20', 'phổ thông', 'trong'),
(81, 1, 'C21', 'phổ thông', 'trong'),
(82, 1, 'C22', 'phổ thông', 'trong'),
(83, 1, 'C23', 'phổ thông', 'trong'),
(84, 1, 'C24', 'phổ thông', 'trong'),
(85, 1, 'C25', 'phổ thông', 'trong'),
(86, 1, 'C26', 'phổ thông', 'trong'),
(87, 1, 'C27', 'phổ thông', 'trong'),
(88, 1, 'C28', 'phổ thông', 'trong'),
(89, 1, 'C29', 'phổ thông', 'trong'),
(90, 1, 'C30', 'phổ thông', 'trong'),
(91, 1, 'D1', 'phổ thông', 'trong'),
(92, 1, 'D2', 'phổ thông', 'trong'),
(93, 1, 'D3', 'phổ thông', 'trong'),
(94, 1, 'D4', 'phổ thông', 'trong'),
(95, 1, 'D5', 'phổ thông', 'trong'),
(96, 1, 'D6', 'phổ thông', 'trong'),
(97, 1, 'D7', 'phổ thông', 'trong'),
(98, 1, 'D8', 'phổ thông', 'trong'),
(99, 1, 'D9', 'phổ thông', 'trong'),
(100, 1, 'D10', 'phổ thông', 'trong'),
(101, 1, 'D11', 'phổ thông', 'trong'),
(102, 1, 'D12', 'phổ thông', 'trong'),
(103, 1, 'D13', 'phổ thông', 'trong'),
(104, 1, 'D14', 'phổ thông', 'trong'),
(105, 1, 'D15', 'phổ thông', 'trong'),
(106, 1, 'D16', 'phổ thông', 'trong'),
(107, 1, 'D17', 'phổ thông', 'trong'),
(108, 1, 'D18', 'phổ thông', 'trong'),
(109, 1, 'D19', 'phổ thông', 'trong'),
(110, 1, 'D20', 'phổ thông', 'trong'),
(111, 1, 'D21', 'phổ thông', 'trong'),
(112, 1, 'D22', 'phổ thông', 'trong'),
(113, 1, 'D23', 'phổ thông', 'trong'),
(114, 1, 'D24', 'phổ thông', 'trong'),
(115, 1, 'D25', 'phổ thông', 'trong'),
(116, 1, 'D26', 'phổ thông', 'trong'),
(117, 1, 'D27', 'phổ thông', 'trong'),
(118, 1, 'D28', 'phổ thông', 'trong'),
(119, 1, 'D29', 'phổ thông', 'trong'),
(120, 1, 'D30', 'phổ thông', 'trong'),
(121, 1, 'E1', 'phổ thông', 'trong'),
(122, 1, 'E2', 'phổ thông', 'trong'),
(123, 1, 'E3', 'phổ thông', 'trong'),
(124, 1, 'E4', 'phổ thông', 'trong'),
(125, 1, 'E5', 'phổ thông', 'trong'),
(126, 1, 'E6', 'phổ thông', 'trong'),
(127, 1, 'E7', 'phổ thông', 'trong'),
(128, 1, 'E8', 'phổ thông', 'trong'),
(129, 1, 'E9', 'phổ thông', 'trong'),
(130, 1, 'E10', 'phổ thông', 'trong'),
(131, 1, 'E11', 'phổ thông', 'trong'),
(132, 1, 'E12', 'phổ thông', 'trong'),
(133, 1, 'E13', 'phổ thông', 'trong'),
(134, 1, 'E14', 'phổ thông', 'trong'),
(135, 1, 'E15', 'phổ thông', 'trong'),
(136, 1, 'E16', 'phổ thông', 'trong'),
(137, 1, 'E17', 'phổ thông', 'trong'),
(138, 1, 'E18', 'phổ thông', 'trong'),
(139, 1, 'E19', 'phổ thông', 'trong'),
(140, 1, 'E20', 'phổ thông', 'trong'),
(141, 1, 'E21', 'phổ thông', 'trong'),
(142, 1, 'E22', 'phổ thông', 'trong'),
(143, 1, 'E23', 'phổ thông', 'trong'),
(144, 1, 'E24', 'phổ thông', 'trong'),
(145, 1, 'E25', 'phổ thông', 'trong'),
(146, 1, 'E26', 'phổ thông', 'trong'),
(147, 1, 'E27', 'phổ thông', 'trong'),
(148, 1, 'E28', 'phổ thông', 'trong'),
(149, 1, 'E29', 'phổ thông', 'trong'),
(150, 1, 'E30', 'phổ thông', 'trong'),
(151, 1, 'F1', 'phổ thông', 'trong'),
(152, 1, 'F2', 'phổ thông', 'trong'),
(153, 1, 'F3', 'phổ thông', 'trong'),
(154, 1, 'F4', 'phổ thông', 'trong'),
(155, 1, 'F5', 'phổ thông', 'trong'),
(156, 1, 'F6', 'phổ thông', 'trong'),
(157, 1, 'F7', 'phổ thông', 'trong'),
(158, 1, 'F8', 'phổ thông', 'trong'),
(159, 1, 'F9', 'phổ thông', 'trong'),
(160, 1, 'F10', 'phổ thông', 'trong'),
(161, 1, 'F11', 'phổ thông', 'trong'),
(162, 1, 'F12', 'phổ thông', 'trong'),
(163, 1, 'F13', 'phổ thông', 'trong'),
(164, 1, 'F14', 'phổ thông', 'trong'),
(165, 1, 'F15', 'phổ thông', 'trong'),
(166, 1, 'F16', 'phổ thông', 'trong'),
(167, 1, 'F17', 'phổ thông', 'trong'),
(168, 1, 'F18', 'phổ thông', 'trong'),
(169, 1, 'F19', 'phổ thông', 'trong'),
(170, 1, 'F20', 'phổ thông', 'trong'),
(171, 1, 'F21', 'phổ thông', 'trong'),
(172, 1, 'F22', 'phổ thông', 'trong'),
(173, 1, 'F23', 'phổ thông', 'trong'),
(174, 1, 'F24', 'phổ thông', 'trong'),
(175, 1, 'F25', 'phổ thông', 'trong'),
(176, 1, 'F26', 'phổ thông', 'trong'),
(177, 1, 'F27', 'phổ thông', 'trong'),
(178, 1, 'F28', 'phổ thông', 'trong'),
(179, 1, 'F29', 'phổ thông', 'trong'),
(180, 1, 'F30', 'phổ thông', 'trong'),
(181, 2, 'A1', 'thương gia', 'trong'),
(182, 2, 'A2', 'thương gia', 'trong'),
(183, 2, 'A3', 'thương gia', 'trong'),
(184, 2, 'A4', 'thương gia', 'trong'),
(185, 2, 'A5', 'thương gia', 'trong'),
(186, 2, 'A6', 'thương gia', 'trong'),
(187, 2, 'A7', 'thương gia', 'trong'),
(188, 2, 'A8', 'thương gia', 'trong'),
(189, 2, 'A9', 'thương gia', 'trong'),
(190, 2, 'A10', 'thương gia', 'trong'),
(191, 2, 'A11', 'thương gia', 'trong'),
(192, 2, 'A12', 'thương gia', 'trong'),
(193, 2, 'A13', 'thương gia', 'trong'),
(194, 2, 'A14', 'thương gia', 'trong'),
(195, 2, 'A15', 'thương gia', 'trong'),
(196, 2, 'A16', 'thương gia', 'trong'),
(197, 2, 'A17', 'thương gia', 'trong'),
(198, 2, 'A18', 'thương gia', 'trong'),
(199, 2, 'A19', 'thương gia', 'trong'),
(200, 2, 'A20', 'thương gia', 'trong'),
(201, 2, 'A21', 'thương gia', 'trong'),
(202, 2, 'A22', 'thương gia', 'trong'),
(203, 2, 'A23', 'thương gia', 'trong'),
(204, 2, 'A24', 'thương gia', 'trong'),
(205, 2, 'A25', 'thương gia', 'trong'),
(206, 2, 'A26', 'thương gia', 'trong'),
(207, 2, 'A27', 'thương gia', 'trong'),
(208, 2, 'A28', 'thương gia', 'trong'),
(209, 2, 'A29', 'thương gia', 'trong'),
(210, 2, 'A30', 'thương gia', 'trong'),
(211, 2, 'B1', 'thương gia', 'trong'),
(212, 2, 'B2', 'thương gia', 'trong'),
(213, 2, 'B3', 'thương gia', 'trong'),
(214, 2, 'B4', 'thương gia', 'trong'),
(215, 2, 'B5', 'thương gia', 'trong'),
(216, 2, 'B6', 'thương gia', 'trong'),
(217, 2, 'B7', 'thương gia', 'trong'),
(218, 2, 'B8', 'thương gia', 'trong'),
(219, 2, 'B9', 'thương gia', 'trong'),
(220, 2, 'B10', 'thương gia', 'trong'),
(221, 2, 'B11', 'thương gia', 'trong'),
(222, 2, 'B12', 'thương gia', 'trong'),
(223, 2, 'B13', 'thương gia', 'trong'),
(224, 2, 'B14', 'thương gia', 'trong'),
(225, 2, 'B15', 'thương gia', 'trong'),
(226, 2, 'B16', 'thương gia', 'trong'),
(227, 2, 'B17', 'thương gia', 'trong'),
(228, 2, 'B18', 'thương gia', 'trong'),
(229, 2, 'B19', 'thương gia', 'trong'),
(230, 2, 'B20', 'thương gia', 'trong'),
(231, 2, 'B21', 'thương gia', 'trong'),
(232, 2, 'B22', 'thương gia', 'trong'),
(233, 2, 'B23', 'thương gia', 'trong'),
(234, 2, 'B24', 'thương gia', 'trong'),
(235, 2, 'B25', 'thương gia', 'trong'),
(236, 2, 'B26', 'thương gia', 'trong'),
(237, 2, 'B27', 'thương gia', 'trong'),
(238, 2, 'B28', 'thương gia', 'trong'),
(239, 2, 'B29', 'thương gia', 'trong'),
(240, 2, 'B30', 'thương gia', 'trong'),
(241, 2, 'C1', 'phổ thông', 'trong'),
(242, 2, 'C2', 'phổ thông', 'trong'),
(243, 2, 'C3', 'phổ thông', 'trong'),
(244, 2, 'C4', 'phổ thông', 'trong'),
(245, 2, 'C5', 'phổ thông', 'trong'),
(246, 2, 'C6', 'phổ thông', 'trong'),
(247, 2, 'C7', 'phổ thông', 'trong'),
(248, 2, 'C8', 'phổ thông', 'trong'),
(249, 2, 'C9', 'phổ thông', 'trong'),
(250, 2, 'C10', 'phổ thông', 'trong'),
(251, 2, 'C11', 'phổ thông', 'trong'),
(252, 2, 'C12', 'phổ thông', 'trong'),
(253, 2, 'C13', 'phổ thông', 'trong'),
(254, 2, 'C14', 'phổ thông', 'trong'),
(255, 2, 'C15', 'phổ thông', 'trong'),
(256, 2, 'C16', 'phổ thông', 'trong'),
(257, 2, 'C17', 'phổ thông', 'trong'),
(258, 2, 'C18', 'phổ thông', 'trong'),
(259, 2, 'C19', 'phổ thông', 'trong'),
(260, 2, 'C20', 'phổ thông', 'trong'),
(261, 2, 'C21', 'phổ thông', 'trong'),
(262, 2, 'C22', 'phổ thông', 'trong'),
(263, 2, 'C23', 'phổ thông', 'trong'),
(264, 2, 'C24', 'phổ thông', 'trong'),
(265, 2, 'C25', 'phổ thông', 'trong'),
(266, 2, 'C26', 'phổ thông', 'trong'),
(267, 2, 'C27', 'phổ thông', 'trong'),
(268, 2, 'C28', 'phổ thông', 'trong'),
(269, 2, 'C29', 'phổ thông', 'trong'),
(270, 2, 'C30', 'phổ thông', 'trong'),
(271, 2, 'D1', 'phổ thông', 'trong'),
(272, 2, 'D2', 'phổ thông', 'trong'),
(273, 2, 'D3', 'phổ thông', 'trong'),
(274, 2, 'D4', 'phổ thông', 'trong'),
(275, 2, 'D5', 'phổ thông', 'trong'),
(276, 2, 'D6', 'phổ thông', 'trong'),
(277, 2, 'D7', 'phổ thông', 'trong'),
(278, 2, 'D8', 'phổ thông', 'trong'),
(279, 2, 'D9', 'phổ thông', 'trong'),
(280, 2, 'D10', 'phổ thông', 'trong'),
(281, 2, 'D11', 'phổ thông', 'trong'),
(282, 2, 'D12', 'phổ thông', 'trong'),
(283, 2, 'D13', 'phổ thông', 'trong'),
(284, 2, 'D14', 'phổ thông', 'trong'),
(285, 2, 'D15', 'phổ thông', 'trong'),
(286, 2, 'D16', 'phổ thông', 'trong'),
(287, 2, 'D17', 'phổ thông', 'trong'),
(288, 2, 'D18', 'phổ thông', 'trong'),
(289, 2, 'D19', 'phổ thông', 'trong'),
(290, 2, 'D20', 'phổ thông', 'trong'),
(291, 2, 'D21', 'phổ thông', 'trong'),
(292, 2, 'D22', 'phổ thông', 'trong'),
(293, 2, 'D23', 'phổ thông', 'trong'),
(294, 2, 'D24', 'phổ thông', 'trong'),
(295, 2, 'D25', 'phổ thông', 'trong'),
(296, 2, 'D26', 'phổ thông', 'trong'),
(297, 2, 'D27', 'phổ thông', 'trong'),
(298, 2, 'D28', 'phổ thông', 'trong'),
(299, 2, 'D29', 'phổ thông', 'trong'),
(300, 2, 'D30', 'phổ thông', 'trong'),
(301, 2, 'E1', 'hạng nhất', 'trong'),
(302, 2, 'E2', 'hạng nhất', 'trong'),
(303, 2, 'E3', 'hạng nhất', 'trong'),
(304, 2, 'E4', 'hạng nhất', 'trong'),
(305, 2, 'E5', 'hạng nhất', 'trong'),
(306, 2, 'E6', 'hạng nhất', 'trong'),
(307, 2, 'E7', 'hạng nhất', 'trong'),
(308, 2, 'E8', 'hạng nhất', 'trong'),
(309, 2, 'E9', 'hạng nhất', 'trong'),
(310, 2, 'E10', 'hạng nhất', 'trong'),
(311, 2, 'E11', 'hạng nhất', 'trong'),
(312, 2, 'E12', 'hạng nhất', 'trong'),
(313, 2, 'E13', 'hạng nhất', 'trong'),
(314, 2, 'E14', 'hạng nhất', 'trong'),
(315, 2, 'E15', 'hạng nhất', 'trong'),
(316, 2, 'E16', 'hạng nhất', 'trong'),
(317, 2, 'E17', 'hạng nhất', 'trong'),
(318, 2, 'E18', 'hạng nhất', 'trong'),
(319, 2, 'E19', 'hạng nhất', 'trong'),
(320, 2, 'E20', 'hạng nhất', 'trong'),
(321, 2, 'E21', 'hạng nhất', 'trong'),
(322, 2, 'E22', 'hạng nhất', 'trong'),
(323, 2, 'E23', 'hạng nhất', 'trong'),
(324, 2, 'E24', 'hạng nhất', 'trong'),
(325, 2, 'E25', 'hạng nhất', 'trong'),
(326, 2, 'E26', 'hạng nhất', 'trong'),
(327, 2, 'E27', 'hạng nhất', 'trong'),
(328, 2, 'E28', 'hạng nhất', 'trong'),
(329, 2, 'E29', 'hạng nhất', 'trong'),
(330, 2, 'E30', 'hạng nhất', 'trong'),
(331, 2, 'F1', 'hạng nhất', 'trong'),
(332, 2, 'F2', 'hạng nhất', 'trong'),
(333, 2, 'F3', 'hạng nhất', 'trong'),
(334, 2, 'F4', 'hạng nhất', 'trong'),
(335, 2, 'F5', 'hạng nhất', 'trong'),
(336, 2, 'F6', 'hạng nhất', 'trong'),
(337, 2, 'F7', 'hạng nhất', 'trong'),
(338, 2, 'F8', 'hạng nhất', 'trong'),
(339, 2, 'F9', 'hạng nhất', 'trong'),
(340, 2, 'F10', 'hạng nhất', 'trong'),
(341, 2, 'F11', 'hạng nhất', 'trong'),
(342, 2, 'F12', 'hạng nhất', 'trong'),
(343, 2, 'F13', 'hạng nhất', 'trong'),
(344, 2, 'F14', 'hạng nhất', 'trong'),
(345, 2, 'F15', 'hạng nhất', 'trong'),
(346, 2, 'F16', 'hạng nhất', 'trong'),
(347, 2, 'F17', 'hạng nhất', 'trong'),
(348, 2, 'F18', 'hạng nhất', 'trong'),
(349, 2, 'F19', 'hạng nhất', 'trong'),
(350, 2, 'F20', 'hạng nhất', 'trong'),
(351, 2, 'F21', 'hạng nhất', 'trong'),
(352, 2, 'F22', 'hạng nhất', 'trong'),
(353, 2, 'F23', 'hạng nhất', 'trong'),
(354, 2, 'F24', 'hạng nhất', 'trong'),
(355, 2, 'F25', 'hạng nhất', 'trong'),
(356, 2, 'F26', 'hạng nhất', 'trong'),
(357, 2, 'F27', 'hạng nhất', 'trong'),
(358, 2, 'F28', 'hạng nhất', 'trong'),
(359, 2, 'F29', 'hạng nhất', 'trong'),
(360, 2, 'F30', 'hạng nhất', 'trong'),
(361, 3, 'A1', 'thương gia', 'trong'),
(362, 3, 'A2', 'thương gia', 'trong'),
(363, 3, 'A3', 'thương gia', 'trong'),
(364, 3, 'A4', 'thương gia', 'trong'),
(365, 3, 'A5', 'thương gia', 'trong'),
(366, 3, 'A6', 'thương gia', 'trong'),
(367, 3, 'A7', 'thương gia', 'trong'),
(368, 3, 'A8', 'thương gia', 'trong'),
(369, 3, 'A9', 'thương gia', 'trong'),
(370, 3, 'A10', 'thương gia', 'trong'),
(371, 3, 'A11', 'thương gia', 'trong'),
(372, 3, 'A12', 'thương gia', 'trong'),
(373, 3, 'A13', 'thương gia', 'trong'),
(374, 3, 'A14', 'thương gia', 'trong'),
(375, 3, 'A15', 'thương gia', 'trong'),
(376, 3, 'A16', 'thương gia', 'trong'),
(377, 3, 'A17', 'thương gia', 'trong'),
(378, 3, 'A18', 'thương gia', 'trong'),
(379, 3, 'A19', 'thương gia', 'trong'),
(380, 3, 'A20', 'thương gia', 'trong'),
(381, 3, 'A21', 'thương gia', 'trong'),
(382, 3, 'A22', 'thương gia', 'trong'),
(383, 3, 'A23', 'thương gia', 'trong'),
(384, 3, 'A24', 'thương gia', 'trong'),
(385, 3, 'A25', 'thương gia', 'trong'),
(386, 3, 'A26', 'thương gia', 'trong'),
(387, 3, 'A27', 'thương gia', 'trong'),
(388, 3, 'A28', 'thương gia', 'trong'),
(389, 3, 'A29', 'thương gia', 'trong'),
(390, 3, 'A30', 'thương gia', 'trong'),
(391, 3, 'B1', 'thương gia', 'trong'),
(392, 3, 'B2', 'thương gia', 'trong'),
(393, 3, 'B3', 'thương gia', 'trong'),
(394, 3, 'B4', 'thương gia', 'trong'),
(395, 3, 'B5', 'thương gia', 'trong'),
(396, 3, 'B6', 'thương gia', 'trong'),
(397, 3, 'B7', 'thương gia', 'trong'),
(398, 3, 'B8', 'thương gia', 'trong'),
(399, 3, 'B9', 'thương gia', 'trong'),
(400, 3, 'B10', 'thương gia', 'trong'),
(401, 3, 'B11', 'thương gia', 'trong'),
(402, 3, 'B12', 'thương gia', 'trong'),
(403, 3, 'B13', 'thương gia', 'trong'),
(404, 3, 'B14', 'thương gia', 'trong'),
(405, 3, 'B15', 'thương gia', 'trong'),
(406, 3, 'B16', 'thương gia', 'trong'),
(407, 3, 'B17', 'thương gia', 'trong'),
(408, 3, 'B18', 'thương gia', 'trong'),
(409, 3, 'B19', 'thương gia', 'trong'),
(410, 3, 'B20', 'thương gia', 'trong'),
(411, 3, 'B21', 'thương gia', 'trong'),
(412, 3, 'B22', 'thương gia', 'trong'),
(413, 3, 'B23', 'thương gia', 'trong'),
(414, 3, 'B24', 'thương gia', 'trong'),
(415, 3, 'B25', 'thương gia', 'trong'),
(416, 3, 'B26', 'thương gia', 'trong'),
(417, 3, 'B27', 'thương gia', 'trong'),
(418, 3, 'B28', 'thương gia', 'trong'),
(419, 3, 'B29', 'thương gia', 'trong'),
(420, 3, 'B30', 'thương gia', 'trong'),
(421, 3, 'C1', 'phổ thông', 'trong'),
(422, 3, 'C2', 'phổ thông', 'trong'),
(423, 3, 'C3', 'phổ thông', 'trong'),
(424, 3, 'C4', 'phổ thông', 'trong'),
(425, 3, 'C5', 'phổ thông', 'trong'),
(426, 3, 'C6', 'phổ thông', 'trong'),
(427, 3, 'C7', 'phổ thông', 'trong'),
(428, 3, 'C8', 'phổ thông', 'trong'),
(429, 3, 'C9', 'phổ thông', 'trong'),
(430, 3, 'C10', 'phổ thông', 'trong'),
(431, 3, 'C11', 'phổ thông', 'trong'),
(432, 3, 'C12', 'phổ thông', 'trong'),
(433, 3, 'C13', 'phổ thông', 'trong'),
(434, 3, 'C14', 'phổ thông', 'trong'),
(435, 3, 'C15', 'phổ thông', 'trong'),
(436, 3, 'C16', 'phổ thông', 'trong'),
(437, 3, 'C17', 'phổ thông', 'trong'),
(438, 3, 'C18', 'phổ thông', 'trong'),
(439, 3, 'C19', 'phổ thông', 'trong'),
(440, 3, 'C20', 'phổ thông', 'trong'),
(441, 3, 'C21', 'phổ thông', 'trong'),
(442, 3, 'C22', 'phổ thông', 'trong'),
(443, 3, 'C23', 'phổ thông', 'trong'),
(444, 3, 'C24', 'phổ thông', 'trong'),
(445, 3, 'C25', 'phổ thông', 'trong'),
(446, 3, 'C26', 'phổ thông', 'trong'),
(447, 3, 'C27', 'phổ thông', 'trong'),
(448, 3, 'C28', 'phổ thông', 'trong'),
(449, 3, 'C29', 'phổ thông', 'trong'),
(450, 3, 'C30', 'phổ thông', 'trong'),
(451, 3, 'D1', 'phổ thông', 'trong'),
(452, 3, 'D2', 'phổ thông', 'trong'),
(453, 3, 'D3', 'phổ thông', 'trong'),
(454, 3, 'D4', 'phổ thông', 'trong'),
(455, 3, 'D5', 'phổ thông', 'trong'),
(456, 3, 'D6', 'phổ thông', 'trong'),
(457, 3, 'D7', 'phổ thông', 'trong'),
(458, 3, 'D8', 'phổ thông', 'trong'),
(459, 3, 'D9', 'phổ thông', 'trong'),
(460, 3, 'D10', 'phổ thông', 'trong'),
(461, 3, 'D11', 'phổ thông', 'trong'),
(462, 3, 'D12', 'phổ thông', 'trong'),
(463, 3, 'D13', 'phổ thông', 'trong'),
(464, 3, 'D14', 'phổ thông', 'trong'),
(465, 3, 'D15', 'phổ thông', 'trong'),
(466, 3, 'D16', 'phổ thông', 'trong'),
(467, 3, 'D17', 'phổ thông', 'trong'),
(468, 3, 'D18', 'phổ thông', 'trong'),
(469, 3, 'D19', 'phổ thông', 'trong'),
(470, 3, 'D20', 'phổ thông', 'trong'),
(471, 3, 'D21', 'phổ thông', 'trong'),
(472, 3, 'D22', 'phổ thông', 'trong'),
(473, 3, 'D23', 'phổ thông', 'trong'),
(474, 3, 'D24', 'phổ thông', 'trong'),
(475, 3, 'D25', 'phổ thông', 'trong'),
(476, 3, 'D26', 'phổ thông', 'trong'),
(477, 3, 'D27', 'phổ thông', 'trong'),
(478, 3, 'D28', 'phổ thông', 'trong'),
(479, 3, 'D29', 'phổ thông', 'trong'),
(480, 3, 'D30', 'phổ thông', 'trong'),
(481, 3, 'E1', 'hạng nhất', 'trong'),
(482, 3, 'E2', 'hạng nhất', 'trong'),
(483, 3, 'E3', 'hạng nhất', 'trong'),
(484, 3, 'E4', 'hạng nhất', 'trong'),
(485, 3, 'E5', 'hạng nhất', 'trong'),
(486, 3, 'E6', 'hạng nhất', 'trong'),
(487, 3, 'E7', 'hạng nhất', 'trong'),
(488, 3, 'E8', 'hạng nhất', 'trong'),
(489, 3, 'E9', 'hạng nhất', 'trong'),
(490, 3, 'E10', 'hạng nhất', 'trong'),
(491, 3, 'E11', 'hạng nhất', 'trong'),
(492, 3, 'E12', 'hạng nhất', 'trong'),
(493, 3, 'E13', 'hạng nhất', 'trong'),
(494, 3, 'E14', 'hạng nhất', 'trong'),
(495, 3, 'E15', 'hạng nhất', 'trong'),
(496, 3, 'E16', 'hạng nhất', 'trong'),
(497, 3, 'E17', 'hạng nhất', 'trong'),
(498, 3, 'E18', 'hạng nhất', 'trong'),
(499, 3, 'E19', 'hạng nhất', 'trong'),
(500, 3, 'E20', 'hạng nhất', 'trong'),
(501, 3, 'E21', 'hạng nhất', 'trong'),
(502, 3, 'E22', 'hạng nhất', 'trong'),
(503, 3, 'E23', 'hạng nhất', 'trong'),
(504, 3, 'E24', 'hạng nhất', 'trong'),
(505, 3, 'E25', 'hạng nhất', 'trong'),
(506, 3, 'E26', 'hạng nhất', 'trong'),
(507, 3, 'E27', 'hạng nhất', 'trong'),
(508, 3, 'E28', 'hạng nhất', 'trong'),
(509, 3, 'E29', 'hạng nhất', 'trong'),
(510, 3, 'E30', 'hạng nhất', 'trong'),
(511, 3, 'F1', 'hạng nhất', 'trong'),
(512, 3, 'F2', 'hạng nhất', 'trong'),
(513, 3, 'F3', 'hạng nhất', 'trong'),
(514, 3, 'F4', 'hạng nhất', 'trong'),
(515, 3, 'F5', 'hạng nhất', 'trong'),
(516, 3, 'F6', 'hạng nhất', 'trong'),
(517, 3, 'F7', 'hạng nhất', 'trong'),
(518, 3, 'F8', 'hạng nhất', 'trong'),
(519, 3, 'F9', 'hạng nhất', 'trong'),
(520, 3, 'F10', 'hạng nhất', 'trong'),
(521, 3, 'F11', 'hạng nhất', 'trong'),
(522, 3, 'F12', 'hạng nhất', 'trong'),
(523, 3, 'F13', 'hạng nhất', 'trong'),
(524, 3, 'F14', 'hạng nhất', 'trong'),
(525, 3, 'F15', 'hạng nhất', 'trong'),
(526, 3, 'F16', 'hạng nhất', 'trong'),
(527, 3, 'F17', 'hạng nhất', 'trong'),
(528, 3, 'F18', 'hạng nhất', 'trong'),
(529, 3, 'F19', 'hạng nhất', 'trong'),
(530, 3, 'F20', 'hạng nhất', 'trong'),
(531, 3, 'F21', 'hạng nhất', 'trong'),
(532, 3, 'F22', 'hạng nhất', 'trong'),
(533, 3, 'F23', 'hạng nhất', 'trong'),
(534, 3, 'F24', 'hạng nhất', 'trong'),
(535, 3, 'F25', 'hạng nhất', 'trong'),
(536, 3, 'F26', 'hạng nhất', 'trong'),
(537, 3, 'F27', 'hạng nhất', 'trong'),
(538, 3, 'F28', 'hạng nhất', 'trong'),
(539, 3, 'F29', 'hạng nhất', 'trong'),
(540, 3, 'F30', 'hạng nhất', 'trong'),
(541, 4, 'A1', 'thương gia', 'trong'),
(542, 4, 'A2', 'thương gia', 'trong'),
(543, 4, 'A3', 'thương gia', 'trong'),
(544, 4, 'A4', 'thương gia', 'trong'),
(545, 4, 'A5', 'thương gia', 'trong'),
(546, 4, 'A6', 'thương gia', 'trong'),
(547, 4, 'A7', 'thương gia', 'trong'),
(548, 4, 'A8', 'thương gia', 'trong'),
(549, 4, 'A9', 'thương gia', 'trong'),
(550, 4, 'A10', 'thương gia', 'trong'),
(551, 4, 'A11', 'thương gia', 'trong'),
(552, 4, 'A12', 'thương gia', 'trong'),
(553, 4, 'A13', 'thương gia', 'trong'),
(554, 4, 'A14', 'thương gia', 'trong'),
(555, 4, 'A15', 'thương gia', 'trong'),
(556, 4, 'A16', 'thương gia', 'trong'),
(557, 4, 'A17', 'thương gia', 'trong'),
(558, 4, 'A18', 'thương gia', 'trong'),
(559, 4, 'A19', 'thương gia', 'trong'),
(560, 4, 'A20', 'thương gia', 'trong'),
(561, 4, 'A21', 'thương gia', 'trong'),
(562, 4, 'A22', 'thương gia', 'trong'),
(563, 4, 'A23', 'thương gia', 'trong'),
(564, 4, 'A24', 'thương gia', 'trong'),
(565, 4, 'A25', 'thương gia', 'trong'),
(566, 4, 'A26', 'thương gia', 'trong'),
(567, 4, 'A27', 'thương gia', 'trong'),
(568, 4, 'A28', 'thương gia', 'trong'),
(569, 4, 'A29', 'thương gia', 'trong'),
(570, 4, 'A30', 'thương gia', 'trong'),
(571, 4, 'B1', 'thương gia', 'trong'),
(572, 4, 'B2', 'thương gia', 'trong'),
(573, 4, 'B3', 'thương gia', 'trong'),
(574, 4, 'B4', 'thương gia', 'trong'),
(575, 4, 'B5', 'thương gia', 'trong'),
(576, 4, 'B6', 'thương gia', 'trong'),
(577, 4, 'B7', 'thương gia', 'trong'),
(578, 4, 'B8', 'thương gia', 'trong'),
(579, 4, 'B9', 'thương gia', 'trong'),
(580, 4, 'B10', 'thương gia', 'trong'),
(581, 4, 'B11', 'thương gia', 'trong'),
(582, 4, 'B12', 'thương gia', 'trong'),
(583, 4, 'B13', 'thương gia', 'trong'),
(584, 4, 'B14', 'thương gia', 'trong'),
(585, 4, 'B15', 'thương gia', 'trong'),
(586, 4, 'B16', 'thương gia', 'trong'),
(587, 4, 'B17', 'thương gia', 'trong'),
(588, 4, 'B18', 'thương gia', 'trong'),
(589, 4, 'B19', 'thương gia', 'trong'),
(590, 4, 'B20', 'thương gia', 'trong'),
(591, 4, 'B21', 'thương gia', 'trong'),
(592, 4, 'B22', 'thương gia', 'trong'),
(593, 4, 'B23', 'thương gia', 'trong'),
(594, 4, 'B24', 'thương gia', 'trong'),
(595, 4, 'B25', 'thương gia', 'trong'),
(596, 4, 'B26', 'thương gia', 'trong'),
(597, 4, 'B27', 'thương gia', 'trong'),
(598, 4, 'B28', 'thương gia', 'trong'),
(599, 4, 'B29', 'thương gia', 'trong'),
(600, 4, 'B30', 'thương gia', 'trong'),
(601, 4, 'C1', 'phổ thông', 'trong'),
(602, 4, 'C2', 'phổ thông', 'trong'),
(603, 4, 'C3', 'phổ thông', 'trong'),
(604, 4, 'C4', 'phổ thông', 'trong'),
(605, 4, 'C5', 'phổ thông', 'trong'),
(606, 4, 'C6', 'phổ thông', 'trong'),
(607, 4, 'C7', 'phổ thông', 'trong'),
(608, 4, 'C8', 'phổ thông', 'trong'),
(609, 4, 'C9', 'phổ thông', 'trong'),
(610, 4, 'C10', 'phổ thông', 'trong'),
(611, 4, 'C11', 'phổ thông', 'trong'),
(612, 4, 'C12', 'phổ thông', 'trong'),
(613, 4, 'C13', 'phổ thông', 'trong'),
(614, 4, 'C14', 'phổ thông', 'trong'),
(615, 4, 'C15', 'phổ thông', 'trong'),
(616, 4, 'C16', 'phổ thông', 'trong'),
(617, 4, 'C17', 'phổ thông', 'trong'),
(618, 4, 'C18', 'phổ thông', 'trong'),
(619, 4, 'C19', 'phổ thông', 'trong'),
(620, 4, 'C20', 'phổ thông', 'trong'),
(621, 4, 'C21', 'phổ thông', 'trong'),
(622, 4, 'C22', 'phổ thông', 'trong'),
(623, 4, 'C23', 'phổ thông', 'trong'),
(624, 4, 'C24', 'phổ thông', 'trong'),
(625, 4, 'C25', 'phổ thông', 'trong'),
(626, 4, 'C26', 'phổ thông', 'trong'),
(627, 4, 'C27', 'phổ thông', 'trong'),
(628, 4, 'C28', 'phổ thông', 'trong'),
(629, 4, 'C29', 'phổ thông', 'trong'),
(630, 4, 'C30', 'phổ thông', 'trong'),
(631, 4, 'D1', 'phổ thông', 'trong'),
(632, 4, 'D2', 'phổ thông', 'trong'),
(633, 4, 'D3', 'phổ thông', 'trong'),
(634, 4, 'D4', 'phổ thông', 'trong'),
(635, 4, 'D5', 'phổ thông', 'trong'),
(636, 4, 'D6', 'phổ thông', 'trong'),
(637, 4, 'D7', 'phổ thông', 'trong'),
(638, 4, 'D8', 'phổ thông', 'trong'),
(639, 4, 'D9', 'phổ thông', 'trong'),
(640, 4, 'D10', 'phổ thông', 'trong'),
(641, 4, 'D11', 'phổ thông', 'trong'),
(642, 4, 'D12', 'phổ thông', 'trong'),
(643, 4, 'D13', 'phổ thông', 'trong'),
(644, 4, 'D14', 'phổ thông', 'trong'),
(645, 4, 'D15', 'phổ thông', 'trong'),
(646, 4, 'D16', 'phổ thông', 'trong'),
(647, 4, 'D17', 'phổ thông', 'trong'),
(648, 4, 'D18', 'phổ thông', 'trong'),
(649, 4, 'D19', 'phổ thông', 'trong'),
(650, 4, 'D20', 'phổ thông', 'trong'),
(651, 4, 'D21', 'phổ thông', 'trong'),
(652, 4, 'D22', 'phổ thông', 'trong'),
(653, 4, 'D23', 'phổ thông', 'trong'),
(654, 4, 'D24', 'phổ thông', 'trong'),
(655, 4, 'D25', 'phổ thông', 'trong'),
(656, 4, 'D26', 'phổ thông', 'trong'),
(657, 4, 'D27', 'phổ thông', 'trong'),
(658, 4, 'D28', 'phổ thông', 'trong'),
(659, 4, 'D29', 'phổ thông', 'trong'),
(660, 4, 'D30', 'phổ thông', 'trong'),
(661, 4, 'E1', 'hạng nhất', 'trong'),
(662, 4, 'E2', 'hạng nhất', 'trong'),
(663, 4, 'E3', 'hạng nhất', 'trong'),
(664, 4, 'E4', 'hạng nhất', 'trong'),
(665, 4, 'E5', 'hạng nhất', 'trong'),
(666, 4, 'E6', 'hạng nhất', 'trong'),
(667, 4, 'E7', 'hạng nhất', 'trong'),
(668, 4, 'E8', 'hạng nhất', 'trong'),
(669, 4, 'E9', 'hạng nhất', 'trong'),
(670, 4, 'E10', 'hạng nhất', 'trong'),
(671, 4, 'E11', 'hạng nhất', 'trong'),
(672, 4, 'E12', 'hạng nhất', 'trong'),
(673, 4, 'E13', 'hạng nhất', 'trong'),
(674, 4, 'E14', 'hạng nhất', 'trong'),
(675, 4, 'E15', 'hạng nhất', 'trong'),
(676, 4, 'E16', 'hạng nhất', 'trong'),
(677, 4, 'E17', 'hạng nhất', 'trong'),
(678, 4, 'E18', 'hạng nhất', 'trong'),
(679, 4, 'E19', 'hạng nhất', 'trong'),
(680, 4, 'E20', 'hạng nhất', 'trong'),
(681, 4, 'E21', 'hạng nhất', 'trong'),
(682, 4, 'E22', 'hạng nhất', 'trong'),
(683, 4, 'E23', 'hạng nhất', 'trong'),
(684, 4, 'E24', 'hạng nhất', 'trong'),
(685, 4, 'E25', 'hạng nhất', 'trong'),
(686, 4, 'E26', 'hạng nhất', 'trong'),
(687, 4, 'E27', 'hạng nhất', 'trong'),
(688, 4, 'E28', 'hạng nhất', 'trong'),
(689, 4, 'E29', 'hạng nhất', 'trong'),
(690, 4, 'E30', 'hạng nhất', 'trong'),
(691, 4, 'F1', 'hạng nhất', 'trong'),
(692, 4, 'F2', 'hạng nhất', 'trong'),
(693, 4, 'F3', 'hạng nhất', 'trong'),
(694, 4, 'F4', 'hạng nhất', 'trong'),
(695, 4, 'F5', 'hạng nhất', 'trong'),
(696, 4, 'F6', 'hạng nhất', 'trong'),
(697, 4, 'F7', 'hạng nhất', 'trong'),
(698, 4, 'F8', 'hạng nhất', 'trong'),
(699, 4, 'F9', 'hạng nhất', 'trong'),
(700, 4, 'F10', 'hạng nhất', 'trong'),
(701, 4, 'F11', 'hạng nhất', 'trong'),
(702, 4, 'F12', 'hạng nhất', 'trong'),
(703, 4, 'F13', 'hạng nhất', 'trong'),
(704, 4, 'F14', 'hạng nhất', 'trong'),
(705, 4, 'F15', 'hạng nhất', 'trong'),
(706, 4, 'F16', 'hạng nhất', 'trong'),
(707, 4, 'F17', 'hạng nhất', 'trong'),
(708, 4, 'F18', 'hạng nhất', 'trong'),
(709, 4, 'F19', 'hạng nhất', 'trong'),
(710, 4, 'F20', 'hạng nhất', 'trong'),
(711, 4, 'F21', 'hạng nhất', 'trong'),
(712, 4, 'F22', 'hạng nhất', 'trong'),
(713, 4, 'F23', 'hạng nhất', 'trong'),
(714, 4, 'F24', 'hạng nhất', 'trong'),
(715, 4, 'F25', 'hạng nhất', 'trong'),
(716, 4, 'F26', 'hạng nhất', 'trong'),
(717, 4, 'F27', 'hạng nhất', 'trong'),
(718, 4, 'F28', 'hạng nhất', 'trong'),
(719, 4, 'F29', 'hạng nhất', 'trong'),
(720, 4, 'F30', 'hạng nhất', 'trong'),
(721, 5, 'A1', 'thương gia', 'trong'),
(722, 5, 'A2', 'thương gia', 'trong'),
(723, 5, 'A3', 'thương gia', 'trong'),
(724, 5, 'A4', 'thương gia', 'trong'),
(725, 5, 'A5', 'thương gia', 'trong'),
(726, 5, 'A6', 'thương gia', 'trong'),
(727, 5, 'A7', 'thương gia', 'trong'),
(728, 5, 'A8', 'thương gia', 'trong'),
(729, 5, 'A9', 'thương gia', 'trong'),
(730, 5, 'A10', 'thương gia', 'trong'),
(731, 5, 'A11', 'thương gia', 'trong'),
(732, 5, 'A12', 'thương gia', 'trong'),
(733, 5, 'A13', 'thương gia', 'trong'),
(734, 5, 'A14', 'thương gia', 'trong'),
(735, 5, 'A15', 'thương gia', 'trong'),
(736, 5, 'A16', 'thương gia', 'trong'),
(737, 5, 'A17', 'thương gia', 'trong'),
(738, 5, 'A18', 'thương gia', 'trong'),
(739, 5, 'A19', 'thương gia', 'trong'),
(740, 5, 'A20', 'thương gia', 'trong'),
(741, 5, 'A21', 'thương gia', 'trong'),
(742, 5, 'A22', 'thương gia', 'trong'),
(743, 5, 'A23', 'thương gia', 'trong'),
(744, 5, 'A24', 'thương gia', 'trong'),
(745, 5, 'A25', 'thương gia', 'trong'),
(746, 5, 'A26', 'thương gia', 'trong'),
(747, 5, 'A27', 'thương gia', 'trong'),
(748, 5, 'A28', 'thương gia', 'trong'),
(749, 5, 'A29', 'thương gia', 'trong'),
(750, 5, 'A30', 'thương gia', 'trong'),
(751, 5, 'B1', 'thương gia', 'trong'),
(752, 5, 'B2', 'thương gia', 'trong'),
(753, 5, 'B3', 'thương gia', 'trong'),
(754, 5, 'B4', 'thương gia', 'trong'),
(755, 5, 'B5', 'thương gia', 'trong'),
(756, 5, 'B6', 'thương gia', 'trong'),
(757, 5, 'B7', 'thương gia', 'trong'),
(758, 5, 'B8', 'thương gia', 'trong'),
(759, 5, 'B9', 'thương gia', 'trong'),
(760, 5, 'B10', 'thương gia', 'trong'),
(761, 5, 'B11', 'thương gia', 'trong'),
(762, 5, 'B12', 'thương gia', 'trong'),
(763, 5, 'B13', 'thương gia', 'trong'),
(764, 5, 'B14', 'thương gia', 'trong'),
(765, 5, 'B15', 'thương gia', 'trong'),
(766, 5, 'B16', 'thương gia', 'trong'),
(767, 5, 'B17', 'thương gia', 'trong'),
(768, 5, 'B18', 'thương gia', 'trong'),
(769, 5, 'B19', 'thương gia', 'trong'),
(770, 5, 'B20', 'thương gia', 'trong'),
(771, 5, 'B21', 'thương gia', 'trong'),
(772, 5, 'B22', 'thương gia', 'trong'),
(773, 5, 'B23', 'thương gia', 'trong'),
(774, 5, 'B24', 'thương gia', 'trong'),
(775, 5, 'B25', 'thương gia', 'trong'),
(776, 5, 'B26', 'thương gia', 'trong'),
(777, 5, 'B27', 'thương gia', 'trong'),
(778, 5, 'B28', 'thương gia', 'trong'),
(779, 5, 'B29', 'thương gia', 'trong'),
(780, 5, 'B30', 'thương gia', 'trong'),
(781, 5, 'C1', 'phổ thông', 'trong'),
(782, 5, 'C2', 'phổ thông', 'trong'),
(783, 5, 'C3', 'phổ thông', 'trong'),
(784, 5, 'C4', 'phổ thông', 'trong'),
(785, 5, 'C5', 'phổ thông', 'trong'),
(786, 5, 'C6', 'phổ thông', 'trong'),
(787, 5, 'C7', 'phổ thông', 'trong'),
(788, 5, 'C8', 'phổ thông', 'trong'),
(789, 5, 'C9', 'phổ thông', 'trong'),
(790, 5, 'C10', 'phổ thông', 'trong'),
(791, 5, 'C11', 'phổ thông', 'trong'),
(792, 5, 'C12', 'phổ thông', 'trong'),
(793, 5, 'C13', 'phổ thông', 'trong'),
(794, 5, 'C14', 'phổ thông', 'trong'),
(795, 5, 'C15', 'phổ thông', 'trong'),
(796, 5, 'C16', 'phổ thông', 'trong'),
(797, 5, 'C17', 'phổ thông', 'trong'),
(798, 5, 'C18', 'phổ thông', 'trong'),
(799, 5, 'C19', 'phổ thông', 'trong'),
(800, 5, 'C20', 'phổ thông', 'trong'),
(801, 5, 'C21', 'phổ thông', 'trong'),
(802, 5, 'C22', 'phổ thông', 'trong'),
(803, 5, 'C23', 'phổ thông', 'trong'),
(804, 5, 'C24', 'phổ thông', 'trong'),
(805, 5, 'C25', 'phổ thông', 'trong'),
(806, 5, 'C26', 'phổ thông', 'trong'),
(807, 5, 'C27', 'phổ thông', 'trong'),
(808, 5, 'C28', 'phổ thông', 'trong'),
(809, 5, 'C29', 'phổ thông', 'trong'),
(810, 5, 'C30', 'phổ thông', 'trong'),
(811, 5, 'D1', 'phổ thông', 'trong'),
(812, 5, 'D2', 'phổ thông', 'trong'),
(813, 5, 'D3', 'phổ thông', 'trong'),
(814, 5, 'D4', 'phổ thông', 'trong'),
(815, 5, 'D5', 'phổ thông', 'trong'),
(816, 5, 'D6', 'phổ thông', 'trong'),
(817, 5, 'D7', 'phổ thông', 'trong'),
(818, 5, 'D8', 'phổ thông', 'trong'),
(819, 5, 'D9', 'phổ thông', 'trong'),
(820, 5, 'D10', 'phổ thông', 'trong'),
(821, 5, 'D11', 'phổ thông', 'trong'),
(822, 5, 'D12', 'phổ thông', 'trong'),
(823, 5, 'D13', 'phổ thông', 'trong'),
(824, 5, 'D14', 'phổ thông', 'trong'),
(825, 5, 'D15', 'phổ thông', 'trong'),
(826, 5, 'D16', 'phổ thông', 'trong'),
(827, 5, 'D17', 'phổ thông', 'trong'),
(828, 5, 'D18', 'phổ thông', 'trong'),
(829, 5, 'D19', 'phổ thông', 'trong'),
(830, 5, 'D20', 'phổ thông', 'trong'),
(831, 5, 'D21', 'phổ thông', 'trong'),
(832, 5, 'D22', 'phổ thông', 'trong'),
(833, 5, 'D23', 'phổ thông', 'trong'),
(834, 5, 'D24', 'phổ thông', 'trong'),
(835, 5, 'D25', 'phổ thông', 'trong'),
(836, 5, 'D26', 'phổ thông', 'trong'),
(837, 5, 'D27', 'phổ thông', 'trong'),
(838, 5, 'D28', 'phổ thông', 'trong'),
(839, 5, 'D29', 'phổ thông', 'trong'),
(840, 5, 'D30', 'phổ thông', 'trong'),
(841, 5, 'E1', 'hạng nhất', 'trong'),
(842, 5, 'E2', 'hạng nhất', 'trong'),
(843, 5, 'E3', 'hạng nhất', 'trong'),
(844, 5, 'E4', 'hạng nhất', 'trong'),
(845, 5, 'E5', 'hạng nhất', 'trong'),
(846, 5, 'E6', 'hạng nhất', 'trong'),
(847, 5, 'E7', 'hạng nhất', 'trong'),
(848, 5, 'E8', 'hạng nhất', 'trong'),
(849, 5, 'E9', 'hạng nhất', 'trong'),
(850, 5, 'E10', 'hạng nhất', 'trong'),
(851, 5, 'E11', 'hạng nhất', 'trong'),
(852, 5, 'E12', 'hạng nhất', 'trong'),
(853, 5, 'E13', 'hạng nhất', 'trong'),
(854, 5, 'E14', 'hạng nhất', 'trong'),
(855, 5, 'E15', 'hạng nhất', 'trong'),
(856, 5, 'E16', 'hạng nhất', 'trong'),
(857, 5, 'E17', 'hạng nhất', 'trong'),
(858, 5, 'E18', 'hạng nhất', 'trong'),
(859, 5, 'E19', 'hạng nhất', 'trong'),
(860, 5, 'E20', 'hạng nhất', 'trong'),
(861, 5, 'E21', 'hạng nhất', 'trong'),
(862, 5, 'E22', 'hạng nhất', 'trong'),
(863, 5, 'E23', 'hạng nhất', 'trong'),
(864, 5, 'E24', 'hạng nhất', 'trong'),
(865, 5, 'E25', 'hạng nhất', 'trong'),
(866, 5, 'E26', 'hạng nhất', 'trong'),
(867, 5, 'E27', 'hạng nhất', 'trong'),
(868, 5, 'E28', 'hạng nhất', 'trong'),
(869, 5, 'E29', 'hạng nhất', 'trong'),
(870, 5, 'E30', 'hạng nhất', 'trong'),
(871, 5, 'F1', 'hạng nhất', 'trong'),
(872, 5, 'F2', 'hạng nhất', 'trong'),
(873, 5, 'F3', 'hạng nhất', 'trong'),
(874, 5, 'F4', 'hạng nhất', 'trong'),
(875, 5, 'F5', 'hạng nhất', 'trong'),
(876, 5, 'F6', 'hạng nhất', 'trong'),
(877, 5, 'F7', 'hạng nhất', 'trong'),
(878, 5, 'F8', 'hạng nhất', 'trong'),
(879, 5, 'F9', 'hạng nhất', 'trong'),
(880, 5, 'F10', 'hạng nhất', 'trong'),
(881, 5, 'F11', 'hạng nhất', 'trong'),
(882, 5, 'F12', 'hạng nhất', 'trong'),
(883, 5, 'F13', 'hạng nhất', 'trong'),
(884, 5, 'F14', 'hạng nhất', 'trong'),
(885, 5, 'F15', 'hạng nhất', 'trong'),
(886, 5, 'F16', 'hạng nhất', 'trong'),
(887, 5, 'F17', 'hạng nhất', 'trong'),
(888, 5, 'F18', 'hạng nhất', 'trong'),
(889, 5, 'F19', 'hạng nhất', 'trong'),
(890, 5, 'F20', 'hạng nhất', 'trong'),
(891, 5, 'F21', 'hạng nhất', 'trong'),
(892, 5, 'F22', 'hạng nhất', 'trong'),
(893, 5, 'F23', 'hạng nhất', 'trong'),
(894, 5, 'F24', 'hạng nhất', 'trong'),
(895, 5, 'F25', 'hạng nhất', 'trong'),
(896, 5, 'F26', 'hạng nhất', 'trong'),
(897, 5, 'F27', 'hạng nhất', 'trong'),
(898, 5, 'F28', 'hạng nhất', 'trong'),
(899, 5, 'F29', 'hạng nhất', 'trong'),
(900, 5, 'F30', 'hạng nhất', 'trong'),
(901, 6, 'A1', 'thương gia', 'trong'),
(902, 6, 'A2', 'thương gia', 'trong'),
(903, 6, 'A3', 'thương gia', 'trong'),
(904, 6, 'A4', 'thương gia', 'trong'),
(905, 6, 'A5', 'thương gia', 'trong'),
(906, 6, 'A6', 'thương gia', 'trong'),
(907, 6, 'A7', 'thương gia', 'trong'),
(908, 6, 'A8', 'thương gia', 'trong'),
(909, 6, 'A9', 'thương gia', 'trong'),
(910, 6, 'A10', 'thương gia', 'trong'),
(911, 6, 'A11', 'thương gia', 'trong'),
(912, 6, 'A12', 'thương gia', 'trong'),
(913, 6, 'A13', 'thương gia', 'trong'),
(914, 6, 'A14', 'thương gia', 'trong'),
(915, 6, 'A15', 'thương gia', 'trong'),
(916, 6, 'A16', 'thương gia', 'trong'),
(917, 6, 'A17', 'thương gia', 'trong'),
(918, 6, 'A18', 'thương gia', 'trong'),
(919, 6, 'A19', 'thương gia', 'trong'),
(920, 6, 'A20', 'thương gia', 'trong'),
(921, 6, 'A21', 'thương gia', 'trong'),
(922, 6, 'A22', 'thương gia', 'trong'),
(923, 6, 'A23', 'thương gia', 'trong'),
(924, 6, 'A24', 'thương gia', 'trong'),
(925, 6, 'A25', 'thương gia', 'trong'),
(926, 6, 'A26', 'thương gia', 'trong'),
(927, 6, 'A27', 'thương gia', 'trong'),
(928, 6, 'A28', 'thương gia', 'trong'),
(929, 6, 'A29', 'thương gia', 'trong'),
(930, 6, 'A30', 'thương gia', 'trong'),
(931, 6, 'B1', 'thương gia', 'trong'),
(932, 6, 'B2', 'thương gia', 'trong'),
(933, 6, 'B3', 'thương gia', 'trong'),
(934, 6, 'B4', 'thương gia', 'trong'),
(935, 6, 'B5', 'thương gia', 'trong'),
(936, 6, 'B6', 'thương gia', 'trong'),
(937, 6, 'B7', 'thương gia', 'trong'),
(938, 6, 'B8', 'thương gia', 'trong'),
(939, 6, 'B9', 'thương gia', 'trong'),
(940, 6, 'B10', 'thương gia', 'trong'),
(941, 6, 'B11', 'thương gia', 'trong'),
(942, 6, 'B12', 'thương gia', 'trong'),
(943, 6, 'B13', 'thương gia', 'trong'),
(944, 6, 'B14', 'thương gia', 'trong'),
(945, 6, 'B15', 'thương gia', 'trong'),
(946, 6, 'B16', 'thương gia', 'trong'),
(947, 6, 'B17', 'thương gia', 'trong'),
(948, 6, 'B18', 'thương gia', 'trong'),
(949, 6, 'B19', 'thương gia', 'trong'),
(950, 6, 'B20', 'thương gia', 'trong'),
(951, 6, 'B21', 'thương gia', 'trong'),
(952, 6, 'B22', 'thương gia', 'trong'),
(953, 6, 'B23', 'thương gia', 'trong'),
(954, 6, 'B24', 'thương gia', 'trong'),
(955, 6, 'B25', 'thương gia', 'trong'),
(956, 6, 'B26', 'thương gia', 'trong'),
(957, 6, 'B27', 'thương gia', 'trong'),
(958, 6, 'B28', 'thương gia', 'trong'),
(959, 6, 'B29', 'thương gia', 'trong'),
(960, 6, 'B30', 'thương gia', 'trong'),
(961, 6, 'C1', 'phổ thông', 'trong'),
(962, 6, 'C2', 'phổ thông', 'trong'),
(963, 6, 'C3', 'phổ thông', 'trong'),
(964, 6, 'C4', 'phổ thông', 'trong'),
(965, 6, 'C5', 'phổ thông', 'trong'),
(966, 6, 'C6', 'phổ thông', 'trong'),
(967, 6, 'C7', 'phổ thông', 'trong'),
(968, 6, 'C8', 'phổ thông', 'trong'),
(969, 6, 'C9', 'phổ thông', 'trong'),
(970, 6, 'C10', 'phổ thông', 'trong'),
(971, 6, 'C11', 'phổ thông', 'trong'),
(972, 6, 'C12', 'phổ thông', 'trong'),
(973, 6, 'C13', 'phổ thông', 'trong'),
(974, 6, 'C14', 'phổ thông', 'trong'),
(975, 6, 'C15', 'phổ thông', 'trong'),
(976, 6, 'C16', 'phổ thông', 'trong'),
(977, 6, 'C17', 'phổ thông', 'trong'),
(978, 6, 'C18', 'phổ thông', 'trong'),
(979, 6, 'C19', 'phổ thông', 'trong'),
(980, 6, 'C20', 'phổ thông', 'trong'),
(981, 6, 'C21', 'phổ thông', 'trong'),
(982, 6, 'C22', 'phổ thông', 'trong'),
(983, 6, 'C23', 'phổ thông', 'trong'),
(984, 6, 'C24', 'phổ thông', 'trong'),
(985, 6, 'C25', 'phổ thông', 'trong'),
(986, 6, 'C26', 'phổ thông', 'trong'),
(987, 6, 'C27', 'phổ thông', 'trong'),
(988, 6, 'C28', 'phổ thông', 'trong'),
(989, 6, 'C29', 'phổ thông', 'trong'),
(990, 6, 'C30', 'phổ thông', 'trong'),
(991, 6, 'D1', 'phổ thông', 'trong'),
(992, 6, 'D2', 'phổ thông', 'trong'),
(993, 6, 'D3', 'phổ thông', 'trong'),
(994, 6, 'D4', 'phổ thông', 'trong'),
(995, 6, 'D5', 'phổ thông', 'trong'),
(996, 6, 'D6', 'phổ thông', 'trong'),
(997, 6, 'D7', 'phổ thông', 'trong'),
(998, 6, 'D8', 'phổ thông', 'trong'),
(999, 6, 'D9', 'phổ thông', 'trong'),
(1000, 6, 'D10', 'phổ thông', 'trong'),
(1001, 6, 'D11', 'phổ thông', 'trong'),
(1002, 6, 'D12', 'phổ thông', 'trong'),
(1003, 6, 'D13', 'phổ thông', 'trong'),
(1004, 6, 'D14', 'phổ thông', 'trong'),
(1005, 6, 'D15', 'phổ thông', 'trong'),
(1006, 6, 'D16', 'phổ thông', 'trong'),
(1007, 6, 'D17', 'phổ thông', 'trong'),
(1008, 6, 'D18', 'phổ thông', 'trong'),
(1009, 6, 'D19', 'phổ thông', 'trong'),
(1010, 6, 'D20', 'phổ thông', 'trong'),
(1011, 6, 'D21', 'phổ thông', 'trong'),
(1012, 6, 'D22', 'phổ thông', 'trong'),
(1013, 6, 'D23', 'phổ thông', 'trong'),
(1014, 6, 'D24', 'phổ thông', 'trong'),
(1015, 6, 'D25', 'phổ thông', 'trong'),
(1016, 6, 'D26', 'phổ thông', 'trong'),
(1017, 6, 'D27', 'phổ thông', 'trong'),
(1018, 6, 'D28', 'phổ thông', 'trong'),
(1019, 6, 'D29', 'phổ thông', 'trong'),
(1020, 6, 'D30', 'phổ thông', 'trong'),
(1021, 6, 'E1', 'hạng nhất', 'trong'),
(1022, 6, 'E2', 'hạng nhất', 'trong'),
(1023, 6, 'E3', 'hạng nhất', 'trong'),
(1024, 6, 'E4', 'hạng nhất', 'trong'),
(1025, 6, 'E5', 'hạng nhất', 'trong'),
(1026, 6, 'E6', 'hạng nhất', 'trong'),
(1027, 6, 'E7', 'hạng nhất', 'trong'),
(1028, 6, 'E8', 'hạng nhất', 'trong'),
(1029, 6, 'E9', 'hạng nhất', 'trong'),
(1030, 6, 'E10', 'hạng nhất', 'trong'),
(1031, 6, 'E11', 'hạng nhất', 'trong'),
(1032, 6, 'E12', 'hạng nhất', 'trong'),
(1033, 6, 'E13', 'hạng nhất', 'trong'),
(1034, 6, 'E14', 'hạng nhất', 'trong'),
(1035, 6, 'E15', 'hạng nhất', 'trong'),
(1036, 6, 'E16', 'hạng nhất', 'trong'),
(1037, 6, 'E17', 'hạng nhất', 'trong'),
(1038, 6, 'E18', 'hạng nhất', 'trong'),
(1039, 6, 'E19', 'hạng nhất', 'trong'),
(1040, 6, 'E20', 'hạng nhất', 'trong'),
(1041, 6, 'E21', 'hạng nhất', 'trong'),
(1042, 6, 'E22', 'hạng nhất', 'trong'),
(1043, 6, 'E23', 'hạng nhất', 'trong'),
(1044, 6, 'E24', 'hạng nhất', 'trong'),
(1045, 6, 'E25', 'hạng nhất', 'trong'),
(1046, 6, 'E26', 'hạng nhất', 'trong'),
(1047, 6, 'E27', 'hạng nhất', 'trong'),
(1048, 6, 'E28', 'hạng nhất', 'trong'),
(1049, 6, 'E29', 'hạng nhất', 'trong'),
(1050, 6, 'E30', 'hạng nhất', 'trong'),
(1051, 6, 'F1', 'hạng nhất', 'trong'),
(1052, 6, 'F2', 'hạng nhất', 'trong'),
(1053, 6, 'F3', 'hạng nhất', 'trong'),
(1054, 6, 'F4', 'hạng nhất', 'trong'),
(1055, 6, 'F5', 'hạng nhất', 'trong'),
(1056, 6, 'F6', 'hạng nhất', 'trong'),
(1057, 6, 'F7', 'hạng nhất', 'trong'),
(1058, 6, 'F8', 'hạng nhất', 'trong'),
(1059, 6, 'F9', 'hạng nhất', 'trong'),
(1060, 6, 'F10', 'hạng nhất', 'trong'),
(1061, 6, 'F11', 'hạng nhất', 'trong'),
(1062, 6, 'F12', 'hạng nhất', 'trong'),
(1063, 6, 'F13', 'hạng nhất', 'trong'),
(1064, 6, 'F14', 'hạng nhất', 'trong'),
(1065, 6, 'F15', 'hạng nhất', 'trong'),
(1066, 6, 'F16', 'hạng nhất', 'trong'),
(1067, 6, 'F17', 'hạng nhất', 'trong'),
(1068, 6, 'F18', 'hạng nhất', 'trong'),
(1069, 6, 'F19', 'hạng nhất', 'trong'),
(1070, 6, 'F20', 'hạng nhất', 'trong'),
(1071, 6, 'F21', 'hạng nhất', 'trong'),
(1072, 6, 'F22', 'hạng nhất', 'trong'),
(1073, 6, 'F23', 'hạng nhất', 'trong'),
(1074, 6, 'F24', 'hạng nhất', 'trong'),
(1075, 6, 'F25', 'hạng nhất', 'trong'),
(1076, 6, 'F26', 'hạng nhất', 'trong'),
(1077, 6, 'F27', 'hạng nhất', 'trong'),
(1078, 6, 'F28', 'hạng nhất', 'trong'),
(1079, 6, 'F29', 'hạng nhất', 'trong'),
(1080, 6, 'F30', 'hạng nhất', 'trong');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoa_don`
--

CREATE TABLE `hoa_don` (
  `id` int(11) NOT NULL,
  `id_booking` int(11) DEFAULT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp(),
  `tong_tien` decimal(12,2) NOT NULL DEFAULT 0.00,
  `trang_thai` enum('chua_thanh_toan','da_thanh_toan','huy') DEFAULT 'chua_thanh_toan',
  `phuong_thuc_tt` enum('momo','zalopay','the_tin_dung','tien_mat','khong') DEFAULT 'khong'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hoa_don`
--

INSERT INTO `hoa_don` (`id`, `id_booking`, `ngay_tao`, `tong_tien`, `trang_thai`, `phuong_thuc_tt`) VALUES
(1, 1, '2025-11-02 09:15:38', 1911600.00, 'da_thanh_toan', 'momo'),
(2, 3, '2025-11-02 09:33:01', 1620000.00, 'chua_thanh_toan', 'tien_mat'),
(3, 4, '2025-11-02 09:37:54', 1782000.00, 'chua_thanh_toan', 'tien_mat'),
(4, 5, '2025-11-02 09:41:05', 1620000.00, 'chua_thanh_toan', 'tien_mat'),
(5, 6, '2025-11-02 09:45:08', 1512000.00, 'chua_thanh_toan', 'tien_mat'),
(6, 6, '2025-11-02 09:45:39', 1512000.00, 'chua_thanh_toan', 'tien_mat'),
(7, 6, '2025-11-02 09:45:42', 1512000.00, 'da_thanh_toan', 'momo'),
(8, 7, '2025-11-02 10:42:56', 1252800.00, 'chua_thanh_toan', 'tien_mat'),
(9, 7, '2025-11-02 10:47:48', 1252800.00, 'chua_thanh_toan', 'tien_mat'),
(10, 7, '2025-11-02 10:49:08', 1252800.00, 'chua_thanh_toan', 'tien_mat'),
(11, 7, '2025-11-02 10:50:04', 1252800.00, 'chua_thanh_toan', 'tien_mat'),
(12, 7, '2025-11-02 10:54:05', 1252800.00, 'chua_thanh_toan', 'tien_mat'),
(13, 9, '2025-11-02 10:56:10', 1360800.00, 'chua_thanh_toan', 'tien_mat'),
(14, 9, '2025-11-02 10:57:47', 1360800.00, 'chua_thanh_toan', 'tien_mat'),
(15, 9, '2025-11-02 10:57:57', 1360800.00, 'chua_thanh_toan', 'tien_mat'),
(16, 9, '2025-11-02 11:01:59', 1360800.00, 'chua_thanh_toan', 'tien_mat'),
(17, 9, '2025-11-02 11:03:24', 1360800.00, 'chua_thanh_toan', 'tien_mat'),
(18, 9, '2025-11-02 11:05:26', 1360800.00, 'chua_thanh_toan', 'tien_mat'),
(19, 10, '2025-11-02 11:06:12', 1782000.00, 'chua_thanh_toan', 'tien_mat'),
(20, 10, '2025-11-02 11:08:37', 1782000.00, 'chua_thanh_toan', 'tien_mat'),
(21, 11, '2025-11-02 11:12:24', 1911600.00, 'chua_thanh_toan', 'tien_mat'),
(22, 12, '2025-11-02 11:21:51', 1620000.00, 'chua_thanh_toan', 'tien_mat'),
(23, 13, '2025-11-02 11:26:12', 3192750.00, 'chua_thanh_toan', 'tien_mat'),
(24, 14, '2025-11-02 11:35:59', 2835000.00, 'chua_thanh_toan', 'tien_mat'),
(25, 15, '2025-11-02 11:38:07', 2835000.00, 'chua_thanh_toan', 'tien_mat'),
(26, 16, '2025-11-02 19:45:28', 2813400.00, 'chua_thanh_toan', 'tien_mat'),
(27, 17, '2025-11-02 20:25:11', 1814400.00, 'chua_thanh_toan', 'tien_mat'),
(28, 17, '2025-11-02 20:39:00', 1814400.00, 'chua_thanh_toan', 'tien_mat'),
(29, 19, '2025-11-02 20:45:42', 1566000.00, 'huy', 'tien_mat');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyen_mai`
--

CREATE TABLE `khuyen_mai` (
  `id` int(11) NOT NULL,
  `ma_khuyen_mai` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `gia_tri` int(11) NOT NULL DEFAULT 0,
  `loai_gia_tri` enum('phan_tram','tien_mat') DEFAULT 'phan_tram',
  `ngay_bat_dau` date DEFAULT NULL,
  `ngay_ket_thuc` date DEFAULT NULL,
  `trang_thai` enum('hieu_luc','het_han') DEFAULT 'hieu_luc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khuyen_mai`
--

INSERT INTO `khuyen_mai` (`id`, `ma_khuyen_mai`, `mo_ta`, `gia_tri`, `loai_gia_tri`, `ngay_bat_dau`, `ngay_ket_thuc`, `trang_thai`) VALUES
(1, 'NOEL2025', 'Giảm giá mùa Giáng Sinh 20% cho tất cả các chuyến bay nội địa.', 20, 'phan_tram', '2025-11-01', '2025-12-31', 'hieu_luc'),
(2, 'TET2026', 'Giảm 300,000đ vé bay Tết sớm.', 300000, 'tien_mat', '2025-12-15', '2026-01-15', 'hieu_luc'),
(3, 'YEAR-END25', 'Khuyến mãi cuối năm – giảm 15% toàn hệ thống.', 15, 'phan_tram', '2025-12-10', '2025-12-31', 'hieu_luc'),
(4, 'KMTEST-1', 'test cái', 99, 'phan_tram', '2025-11-06', '2025-12-31', 'het_han');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lich_su_dang_nhap`
--

CREATE TABLE `lich_su_dang_nhap` (
  `id` int(11) NOT NULL,
  `id_nguoi_dung` int(11) NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `thoi_gian` timestamp NOT NULL DEFAULT current_timestamp(),
  `thanh_cong` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `may_bay`
--

CREATE TABLE `may_bay` (
  `id` int(11) NOT NULL,
  `ma_may_bay` varchar(50) NOT NULL,
  `ten_may_bay` varchar(100) DEFAULT NULL,
  `hang_hang_khong` varchar(100) DEFAULT NULL,
  `so_ghe` int(11) NOT NULL DEFAULT 0,
  `trang_thai` enum('dang_bay','bao_duong','san_sang') NOT NULL DEFAULT 'san_sang'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `may_bay`
--

INSERT INTO `may_bay` (`id`, `ma_may_bay`, `ten_may_bay`, `hang_hang_khong`, `so_ghe`, `trang_thai`) VALUES
(1, 'VN123', 'Airbus A123', 'Vietnam Airlines', 180, 'san_sang'),
(2, 'VN999', 'Boeing 787', 'Vietnam Airlines', 180, 'san_sang'),
(3, 'VN-A321', 'Airbus A321', 'Vietnam Airlines', 180, 'san_sang'),
(4, 'VJ-A320', 'Airbus A320', 'VietJet Air', 180, 'san_sang'),
(5, 'QH-B737', 'Boeing 737', 'Bamboo Airways', 160, 'san_sang'),
(6, 'BL-A320', 'Airbus A320', 'Pacific Airlines', 180, 'bao_duong');

--
-- Bẫy `may_bay`
--
DELIMITER $$
CREATE TRIGGER `trg_after_insert_may_bay` AFTER INSERT ON `may_bay` FOR EACH ROW BEGIN
    DECLARE r CHAR(1);
    DECLARE seat_num INT;

    SET r = 'A';
    WHILE r <= 'F' DO
        SET seat_num = 1;
        WHILE seat_num <= 30 DO
            INSERT INTO ghe (id_may_bay, so_ghe, loai_ghe, trang_thai)
            VALUES (
                NEW.id,
                CONCAT(r, seat_num),
                CASE 
                    WHEN r IN ('A', 'B') THEN 'thương gia'
                    WHEN r IN ('E', 'F') THEN 'hạng nhất'
                    ELSE 'phổ thông'
                END,
                'trống'
            );
            SET seat_num = seat_num + 1;
        END WHILE;
        SET r = CHAR(ASCII(r) + 1);
    END WHILE;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `dia_chi` text DEFAULT NULL,
  `vai_tro` enum('admin','nhan_vien','khach_hang') NOT NULL DEFAULT 'khach_hang',
  `trang_thai` enum('hoat_dong','khoa') NOT NULL DEFAULT 'hoat_dong',
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id`, `ho_ten`, `email`, `mat_khau`, `remember_token`, `so_dien_thoai`, `dia_chi`, `vai_tro`, `trang_thai`, `ngay_tao`) VALUES
(1, 'haian', 'an2392k4@gmail.com', '$2y$10$IY/4REeNrpYfDq9u5oydvOeuP1Ado1c.LSYhNAJuQaKnoTp2UyfSO', 'gy9FFzO2iqUsMBRcKk0ulLy25GPCi6y1fYD5ySxBCbqf7rP70oxsyogSOqP3', NULL, NULL, 'admin', 'hoat_dong', '2025-10-27 07:38:08'),
(2, 'test', '123@gmail.com', '$2y$10$h09so90zyTIJ3G/3Uhxz3.Tga6E0fzpXKMmY4vliEad6zbNG56AMe', NULL, NULL, NULL, 'khach_hang', 'hoat_dong', '2025-11-04 03:32:15'),
(3, 'nhanvien', 'nv1@gmail.com', '$2y$10$Hh.pAhPje0M49Ykr2eSz5eLq6rpbk8rZ7/6N5nkOB9Fry.i4W9ZtS', NULL, '0123123123', '123', 'nhan_vien', 'hoat_dong', '2025-11-05 21:03:48'),
(4, 'Nguyen Van A', 'testuser1762479391916@example.com', '$2y$10$kQOp388qTSlc7TKKsyJXbO69smlKLBX5YEt41W9kqrdmAPmdsAwmy', NULL, NULL, NULL, 'khach_hang', 'hoat_dong', '2025-11-06 18:36:35'),
(5, 'Nguyen Van A', 'testuser1762479488565@example.com', '$2y$10$CIOMFOUaynuq4HgbxlUEGOv0nVxXMXUrZZE2YKH5ZOz/wUiIprvSy', NULL, NULL, NULL, 'khach_hang', 'hoat_dong', '2025-11-06 18:38:11'),
(6, 'Nguyen Van A', 'testuser1762479541599@example.com', '$2y$10$Wkpaf/nCQ.NOSS1LInw.eOkTYhB5KY.oLV8cN/.FogU3iSx4KeUPe', NULL, NULL, NULL, 'khach_hang', 'hoat_dong', '2025-11-06 18:39:04'),
(7, 'Nguyen Van A', 'testuser1762479773646@example.com', '$2y$10$EjDL9iGIDLcnoqtr5otYEuKClNzHt6B42K246LluJcmccP9EQ0MZ2', NULL, NULL, NULL, 'khach_hang', 'hoat_dong', '2025-11-06 18:42:56'),
(8, 'Nguyen Van A', 'testuser1762479903920@example.com', '$2y$10$awQLPOpn8m03PsCau7RD4eM7TuMD7VQ6aWjscJZy5RxuPOTS1u1pe', NULL, NULL, NULL, 'khach_hang', 'hoat_dong', '2025-11-06 18:45:06'),
(9, 'Nguyen Van A', 'testuser1762480287829@example.com', '$2y$10$cEPPsuc66n9I0lrcbjhn6uDQB0P/xV7bv8GhABOR./rCQc7VALu0O', NULL, NULL, NULL, 'khach_hang', 'hoat_dong', '2025-11-06 18:51:31'),
(10, 'Nguyen Van A', 'testuser1762481134366@example.com', '$2y$10$q0tkxcUWos4IJqD8PjQ6leAhfRwRxYf6D.f4HPirI09HTm6IWsuHe', NULL, NULL, NULL, 'khach_hang', 'hoat_dong', '2025-11-06 19:05:38'),
(11, 'Nguyen Van A', 'testuser1762481685947@example.com', '$2y$10$6XOgalfNdDBlH3eXT1iB.ezItLxAYbPwkB.QSBMZU.ryRO5k92pxe', NULL, NULL, NULL, 'khach_hang', 'hoat_dong', '2025-11-06 19:14:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_bay`
--

CREATE TABLE `san_bay` (
  `id` int(11) NOT NULL,
  `ma_san_bay` varchar(20) NOT NULL,
  `ten_san_bay` varchar(100) NOT NULL,
  `dia_chi` text DEFAULT NULL,
  `quoc_gia` varchar(100) DEFAULT NULL,
  `tinh_thanh` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `san_bay`
--

INSERT INTO `san_bay` (`id`, `ma_san_bay`, `ten_san_bay`, `dia_chi`, `quoc_gia`, `tinh_thanh`) VALUES
(1, 'SGN', 'Sân bay quốc tế Tân Sơn Nhất', 'Phường 2, Quận Tân Bình', 'Việt Nam', 'TP. Hồ Chí Minh'),
(2, 'HAN', 'Sân bay quốc tế Nội Bài', 'Sóc Sơn', 'Việt Nam', 'Hà Nội'),
(3, 'DAD', 'Sân bay quốc tế Đà Nẵng', 'Hòa Thuận Tây, Hải Châu', 'Việt Nam', 'Đà Nẵng'),
(4, 'CXR', 'Sân bay quốc tế Cam Ranh', 'Cam Lâm', 'Việt Nam', 'Khánh Hòa'),
(5, 'VCA', 'Sân bay quốc tế Cần Thơ', 'Quận Bình Thủy', 'Việt Nam', 'Cần Thơ'),
(6, 'VII', 'Sân bay quốc tế Vinh', 'Nghi Liên, Nghi Lộc', 'Việt Nam', 'Nghệ An'),
(7, 'HUI', 'Sân bay quốc tế Phú Bài', 'Hương Thủy', 'Việt Nam', 'Thừa Thiên Huế'),
(8, 'PQC', 'Sân bay quốc tế Phú Quốc', 'Dương Tơ', 'Việt Nam', 'Kiên Giang'),
(9, 'HPH', 'Sân bay quốc tế Cát Bi', 'Đằng Lâm, Hải An', 'Việt Nam', 'Hải Phòng'),
(10, 'BMV', 'Sân bay Buôn Ma Thuột', 'Tân Lợi, Buôn Ma Thuột', 'Việt Nam', 'Đắk Lắk'),
(11, 'DLI', 'Sân bay Liên Khương', 'Liên Nghĩa, Đức Trọng', 'Việt Nam', 'Lâm Đồng'),
(12, 'THD', 'Sân bay Thọ Xuân', 'Thọ Xuân', 'Việt Nam', 'Thanh Hóa'),
(13, 'VCS', 'Sân bay Côn Đảo', 'Côn Đảo', 'Việt Nam', 'Bà Rịa - Vũng Tàu');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thong_bao`
--

CREATE TABLE `thong_bao` (
  `id` int(11) NOT NULL,
  `id_nguoi_dung` int(11) DEFAULT NULL,
  `tieu_de` varchar(255) DEFAULT NULL,
  `noi_dung` text DEFAULT NULL,
  `da_doc` tinyint(1) DEFAULT 0,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thong_tin_nguoi_di`
--

CREATE TABLE `thong_tin_nguoi_di` (
  `id` int(11) NOT NULL,
  `id_ve` int(11) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `dia_chi` text DEFAULT NULL,
  `ghi_chu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thong_tin_nguoi_di`
--

INSERT INTO `thong_tin_nguoi_di` (`id`, `id_ve`, `ho_ten`, `so_dien_thoai`, `email`, `dia_chi`, `ghi_chu`) VALUES
(1, 1, 'Nguyen Test Mot', '0123123123', 'tkbtnha@gmail.com', '123 Đường Chỗ Này, ngõ Chỗ kia, phường Chỗ khác, Tỉnh Chỗ đó', '0123123123123'),
(2, 2, 'Nguyen Test Mot', '0123123123', 'tkbtnha@gmail.com', '123 Đường Chỗ Này, ngõ Chỗ kia, phường Chỗ khác, Tỉnh Chỗ đó', '0123123123123'),
(3, 3, 'Nguyen Test Mot', '0123123124', 'test1@gmail.com', '123 Đường Chỗ Này, ngõ Chỗ kia, phường Chỗ khác, Tỉnh Chỗ đó', '0123123123'),
(4, 4, 'Nguyen Test Mot', '0123123124', 'test1@gmail.com', '123 Đường Chỗ Này, ngõ Chỗ kia, phường Chỗ khác, Tỉnh Chỗ đó', '0123123123'),
(5, 5, 'Nguyen Test Mot', '0123123124', 'test1@gmail.com', '123 Đường Chỗ Này, ngõ Chỗ kia, phường Chỗ khác, Tỉnh Chỗ đó', '123123123'),
(6, 6, 'Nguyen Test Mot', '0123123124', 'test1@gmail.com', '123 Đường Chỗ Này, ngõ Chỗ kia, phường Chỗ khác, Tỉnh Chỗ đó', '1'),
(7, 7, 'Nguyen Test Mot', '0123123124', 'test1@gmail.com', '123 Đường Chỗ Này, ngõ Chỗ kia, phường Chỗ khác, Tỉnh Chỗ đó', NULL),
(8, 8, 'Nguyen Van Test', '0123123123', 'test1@gmail.com', '123 ngõ Chỗ này, đường Chỗ nọ, phường Chỗ kia, tỉnh Chỗ đó', '0123123123'),
(9, 9, 'Nguyen Van Test', '0123123123', 'test1@gmail.com', '123 ngõ Chỗ này, đường Chỗ nọ, phường Chỗ kia, tỉnh Chỗ đó', '123123123123'),
(10, 10, 'Nguyen Van Test', '0123123123', 'test1@gmail.com', '123 ngõ Chỗ này, đường Chỗ nọ, phường Chỗ kia, tỉnh Chỗ đó', '123123123123'),
(11, 11, 'Nguyen Van Test', '0123123123', 'test1@gmail.com', '123 ngõ Chỗ này, đường Chỗ nọ, phường Chỗ kia, tỉnh Chỗ đó', '123123123123'),
(12, 12, 'Nguyen Van Test', '0123123123', 'test1@gmail.com', '123 ngõ Chỗ này, đường Chỗ nọ, phường Chỗ kia, tỉnh Chỗ đó', NULL),
(13, 13, 'Nguyen Van Test', '0123123123', 'test1@gmail.com', '123 ngõ Chỗ này, đường Chỗ nọ, phường Chỗ kia, tỉnh Chỗ đó', NULL),
(14, 14, 'Nguyen Van Test', '0123123123', 'test1@gmail.com', '123 ngõ Chỗ này, đường Chỗ nọ, phường Chỗ kia, tỉnh Chỗ đó', NULL),
(15, 15, 'Nguyen Van Test', '0123123123', 'test1@gmail.com', '123 ngõ Chỗ này, đường Chỗ nọ, phường Chỗ kia, tỉnh Chỗ đó', NULL),
(16, 16, 'Tran Tre Em', '0123111111', 't@gmail.com', '123 ngõ Chỗ này, đường Chỗ nọ, phường Chỗ kia, tỉnh Chỗ đó', NULL),
(17, 17, 'Nguyen Van Test', '0123123123', 'test1@gmail.com', '123 ngõ Chỗ này, đường Chỗ nọ, phường Chỗ kia, tỉnh Chỗ đó', NULL),
(18, 18, 'Tran Tre Em', '0123111111', 't@gmail.com', '123 ngõ Chỗ này, đường Chỗ nọ, phường Chỗ kia, tỉnh Chỗ đó', NULL),
(19, 19, 'Nguyen Van Test', '0123123123', 'test1@gmail.com', '123 ngõ Chỗ này, đường Chỗ nọ, phường Chỗ kia, tỉnh Chỗ đó', NULL),
(20, 20, 'Tran Tre Em', '0123111111', 't@gmail.com', '123 ngõ Chỗ này, đường Chỗ nọ, phường Chỗ kia, tỉnh Chỗ đó', NULL),
(21, 21, 'Nguyen Van Test', '0123123123', 'test1@gmail.com', '123 ngõ Chỗ này, đường Chỗ nọ, phường Chỗ kia, tỉnh Chỗ đó', NULL),
(22, 22, 'Tran Tre Em', '0123111111', 't@gmail.com', '123 ngõ Chỗ này, đường Chỗ nọ, phường Chỗ kia, tỉnh Chỗ đó', NULL),
(23, 23, 'Nguyen Van Test', NULL, NULL, NULL, NULL),
(24, 24, 'Tran Tre em', NULL, NULL, NULL, NULL),
(25, 25, 'Nguyen Van Test', NULL, NULL, NULL, NULL),
(26, 26, 'Nguyen Van Test', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ve`
--

CREATE TABLE `ve` (
  `id` int(11) NOT NULL,
  `id_booking` int(11) NOT NULL,
  `id_chuyen_bay` int(11) NOT NULL,
  `loai_hanh_khach` enum('nguoi_lon','tre_em','em_be') NOT NULL DEFAULT 'nguoi_lon',
  `loai_ghe` enum('phổ thông','thương gia','hạng nhất') NOT NULL DEFAULT 'phổ thông',
  `so_ghe` varchar(10) DEFAULT NULL,
  `gia_ve` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gia_hanh_ly` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gia_ghe` decimal(10,2) NOT NULL DEFAULT 0.00,
  `trang_thai` enum('cho_xac_nhan','da_thanh_toan','huy') NOT NULL DEFAULT 'cho_xac_nhan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ve`
--

INSERT INTO `ve` (`id`, `id_booking`, `id_chuyen_bay`, `loai_hanh_khach`, `loai_ghe`, `so_ghe`, `gia_ve`, `gia_hanh_ly`, `gia_ghe`, `trang_thai`) VALUES
(1, 1, 1, 'nguoi_lon', 'phổ thông', NULL, 1620000.00, 0.00, 0.00, 'da_thanh_toan'),
(2, 1, 2, 'nguoi_lon', 'phổ thông', NULL, 1566000.00, 0.00, 0.00, 'da_thanh_toan'),
(3, 2, 4, 'nguoi_lon', 'phổ thông', NULL, 1404000.00, 0.00, 0.00, 'cho_xac_nhan'),
(4, 3, 4, 'nguoi_lon', 'phổ thông', NULL, 1404000.00, 0.00, 0.00, 'cho_xac_nhan'),
(5, 4, 2, 'nguoi_lon', 'phổ thông', NULL, 1566000.00, 0.00, 0.00, 'cho_xac_nhan'),
(6, 5, 1, 'nguoi_lon', 'phổ thông', NULL, 1620000.00, 0.00, 0.00, 'cho_xac_nhan'),
(7, 6, 3, 'nguoi_lon', 'phổ thông', NULL, 1296000.00, 0.00, 0.00, 'da_thanh_toan'),
(8, 7, 2, 'nguoi_lon', 'phổ thông', NULL, 1566000.00, 0.00, 0.00, 'cho_xac_nhan'),
(9, 8, 3, 'nguoi_lon', 'phổ thông', NULL, 1296000.00, 0.00, 0.00, 'cho_xac_nhan'),
(10, 9, 3, 'nguoi_lon', 'phổ thông', NULL, 1296000.00, 0.00, 0.00, 'cho_xac_nhan'),
(11, 10, 1, 'nguoi_lon', 'phổ thông', NULL, 1620000.00, 0.00, 0.00, 'cho_xac_nhan'),
(12, 11, 2, 'nguoi_lon', 'phổ thông', NULL, 1566000.00, 0.00, 0.00, 'cho_xac_nhan'),
(13, 11, 1, 'nguoi_lon', 'phổ thông', NULL, 1620000.00, 0.00, 0.00, 'cho_xac_nhan'),
(14, 12, 1, 'nguoi_lon', 'phổ thông', NULL, 1620000.00, 0.00, 0.00, 'cho_xac_nhan'),
(15, 13, 1, 'nguoi_lon', 'phổ thông', NULL, 1620000.00, 0.00, 0.00, 'cho_xac_nhan'),
(16, 13, 1, 'nguoi_lon', 'phổ thông', NULL, 1215000.00, 0.00, 0.00, 'cho_xac_nhan'),
(17, 14, 1, 'nguoi_lon', 'phổ thông', NULL, 1620000.00, 0.00, 0.00, 'cho_xac_nhan'),
(18, 14, 1, 'nguoi_lon', 'phổ thông', NULL, 1215000.00, 0.00, 0.00, 'cho_xac_nhan'),
(19, 15, 1, 'nguoi_lon', 'phổ thông', NULL, 1620000.00, 0.00, 0.00, 'cho_xac_nhan'),
(20, 15, 1, 'nguoi_lon', 'phổ thông', NULL, 1215000.00, 0.00, 0.00, 'cho_xac_nhan'),
(21, 16, 3, 'nguoi_lon', 'phổ thông', NULL, 1296000.00, 0.00, 0.00, 'cho_xac_nhan'),
(22, 16, 3, 'nguoi_lon', 'phổ thông', NULL, 972000.00, 0.00, 0.00, 'cho_xac_nhan'),
(23, 17, 3, 'nguoi_lon', 'phổ thông', NULL, 1296000.00, 0.00, 0.00, 'cho_xac_nhan'),
(24, 17, 3, 'nguoi_lon', 'phổ thông', NULL, 972000.00, 0.00, 0.00, 'cho_xac_nhan'),
(25, 18, 2, 'nguoi_lon', 'phổ thông', NULL, 1566000.00, 0.00, 0.00, 'cho_xac_nhan'),
(26, 19, 2, 'nguoi_lon', 'phổ thông', NULL, 1566000.00, 0.00, 0.00, 'huy');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bai_viet`
--
ALTER TABLE `bai_viet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_bv_danhmuc` (`id_danh_muc`),
  ADD KEY `fk_bv_tacgia` (`id_tac_gia`),
  ADD KEY `idx_tieude` (`tieu_de`);

--
-- Chỉ mục cho bảng `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_booking` (`ma_booking`),
  ADD KEY `fk_booking_nguoidung` (`id_nguoi_dung`),
  ADD KEY `fk_booking_khuyenmai` (`id_khuyen_mai`);

--
-- Chỉ mục cho bảng `chi_tiet_hoa_don`
--
ALTER TABLE `chi_tiet_hoa_don`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cthd_hd` (`id_hoa_don`),
  ADD KEY `fk_cthd_ve` (`id_ve`);

--
-- Chỉ mục cho bảng `chuyen_bay`
--
ALTER TABLE `chuyen_bay`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_chuyen_bay` (`ma_chuyen_bay`),
  ADD KEY `fk_chuyenbay_maybay` (`id_may_bay`),
  ADD KEY `fk_cb_sanbay_di` (`id_san_bay_di`),
  ADD KEY `fk_cb_sanbay_den` (`id_san_bay_den`);

--
-- Chỉ mục cho bảng `danh_muc_bai_viet`
--
ALTER TABLE `danh_muc_bai_viet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_dm_cha` (`id_danh_muc_cha`);

--
-- Chỉ mục cho bảng `doanh_thu`
--
ALTER TABLE `doanh_thu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dt_hoadon` (`id_hoa_don`);

--
-- Chỉ mục cho bảng `ghe`
--
ALTER TABLE `ghe`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_maybay_soghe` (`id_may_bay`,`so_ghe`);

--
-- Chỉ mục cho bảng `hoa_don`
--
ALTER TABLE `hoa_don`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hd_booking` (`id_booking`);

--
-- Chỉ mục cho bảng `khuyen_mai`
--
ALTER TABLE `khuyen_mai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_khuyen_mai` (`ma_khuyen_mai`);

--
-- Chỉ mục cho bảng `lich_su_dang_nhap`
--
ALTER TABLE `lich_su_dang_nhap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ls_nguoidung` (`id_nguoi_dung`);

--
-- Chỉ mục cho bảng `may_bay`
--
ALTER TABLE `may_bay`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_may_bay` (`ma_may_bay`);

--
-- Chỉ mục cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`);

--
-- Chỉ mục cho bảng `san_bay`
--
ALTER TABLE `san_bay`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_san_bay` (`ma_san_bay`);

--
-- Chỉ mục cho bảng `thong_bao`
--
ALTER TABLE `thong_bao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_nguoidung` (`id_nguoi_dung`);

--
-- Chỉ mục cho bảng `thong_tin_nguoi_di`
--
ALTER TABLE `thong_tin_nguoi_di`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ttnguoidi_ve` (`id_ve`);

--
-- Chỉ mục cho bảng `ve`
--
ALTER TABLE `ve`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ve_booking` (`id_booking`),
  ADD KEY `fk_ve_chuyenbay` (`id_chuyen_bay`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bai_viet`
--
ALTER TABLE `bai_viet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `chi_tiet_hoa_don`
--
ALTER TABLE `chi_tiet_hoa_don`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `chuyen_bay`
--
ALTER TABLE `chuyen_bay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `danh_muc_bai_viet`
--
ALTER TABLE `danh_muc_bai_viet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `doanh_thu`
--
ALTER TABLE `doanh_thu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ghe`
--
ALTER TABLE `ghe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1081;

--
-- AUTO_INCREMENT cho bảng `hoa_don`
--
ALTER TABLE `hoa_don`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `khuyen_mai`
--
ALTER TABLE `khuyen_mai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `lich_su_dang_nhap`
--
ALTER TABLE `lich_su_dang_nhap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `may_bay`
--
ALTER TABLE `may_bay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `san_bay`
--
ALTER TABLE `san_bay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `thong_bao`
--
ALTER TABLE `thong_bao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `thong_tin_nguoi_di`
--
ALTER TABLE `thong_tin_nguoi_di`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `ve`
--
ALTER TABLE `ve`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bai_viet`
--
ALTER TABLE `bai_viet`
  ADD CONSTRAINT `fk_bv_danhmuc` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc_bai_viet` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bv_tacgia` FOREIGN KEY (`id_tac_gia`) REFERENCES `nguoi_dung` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `fk_booking_khuyenmai` FOREIGN KEY (`id_khuyen_mai`) REFERENCES `khuyen_mai` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_nguoidung` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chi_tiet_hoa_don`
--
ALTER TABLE `chi_tiet_hoa_don`
  ADD CONSTRAINT `fk_cthd_hd` FOREIGN KEY (`id_hoa_don`) REFERENCES `hoa_don` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cthd_ve` FOREIGN KEY (`id_ve`) REFERENCES `ve` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chuyen_bay`
--
ALTER TABLE `chuyen_bay`
  ADD CONSTRAINT `fk_cb_sanbay_den` FOREIGN KEY (`id_san_bay_den`) REFERENCES `san_bay` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cb_sanbay_di` FOREIGN KEY (`id_san_bay_di`) REFERENCES `san_bay` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_chuyenbay_maybay` FOREIGN KEY (`id_may_bay`) REFERENCES `may_bay` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `danh_muc_bai_viet`
--
ALTER TABLE `danh_muc_bai_viet`
  ADD CONSTRAINT `fk_dm_cha` FOREIGN KEY (`id_danh_muc_cha`) REFERENCES `danh_muc_bai_viet` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `doanh_thu`
--
ALTER TABLE `doanh_thu`
  ADD CONSTRAINT `fk_dt_hoadon` FOREIGN KEY (`id_hoa_don`) REFERENCES `hoa_don` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `ghe`
--
ALTER TABLE `ghe`
  ADD CONSTRAINT `fk_ghe_maybay` FOREIGN KEY (`id_may_bay`) REFERENCES `may_bay` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `hoa_don`
--
ALTER TABLE `hoa_don`
  ADD CONSTRAINT `fk_hd_booking` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `lich_su_dang_nhap`
--
ALTER TABLE `lich_su_dang_nhap`
  ADD CONSTRAINT `fk_ls_nguoidung` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `thong_bao`
--
ALTER TABLE `thong_bao`
  ADD CONSTRAINT `fk_tb_nguoidung` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `thong_tin_nguoi_di`
--
ALTER TABLE `thong_tin_nguoi_di`
  ADD CONSTRAINT `fk_ttnguoidi_ve` FOREIGN KEY (`id_ve`) REFERENCES `ve` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `ve`
--
ALTER TABLE `ve`
  ADD CONSTRAINT `fk_ve_booking` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ve_chuyenbay` FOREIGN KEY (`id_chuyen_bay`) REFERENCES `chuyen_bay` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
