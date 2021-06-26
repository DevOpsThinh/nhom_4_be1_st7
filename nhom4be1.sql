-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 26, 2021 at 03:19 AM
-- Server version: 8.0.21
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nhom4be1`
--

-- --------------------------------------------------------

--
-- Table structure for table `manufactures`
--

DROP TABLE IF EXISTS `manufactures`;
CREATE TABLE IF NOT EXISTS `manufactures` (
  `manu_id` int NOT NULL AUTO_INCREMENT,
  `manu_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`manu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manufactures`
--

INSERT INTO `manufactures` (`manu_id`, `manu_name`) VALUES
(1, 'Apple'),
(2, 'Dell'),
(3, 'Sony'),
(4, 'SamSung'),
(5, 'Anker'),
(11, 'Suzuki');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

DROP TABLE IF EXISTS `orderdetail`;
CREATE TABLE IF NOT EXISTS `orderdetail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `total` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `code` int NOT NULL,
  `created_at` timestamp NOT NULL,
  `cus_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cus_email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cus_phone` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cus_address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `manu_id` int NOT NULL,
  `type_id` int NOT NULL,
  `price` int NOT NULL,
  `pro_image` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `feature` tinyint NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `manu_id`, `type_id`, `price`, `pro_image`, `description`, `feature`, `created_at`) VALUES
(2, 'Iphone 6s Plus 64GB ', 1, 1, 2500000, 'iphone6splus.png', 'iPhone 6s Plus 64 GB được nâng cấp độ phân giải camera sau lên 12 MP (thay vì 8 MP như trên iPhone 6 Plus), camera cho tốc độ lấy nét và chụp nhanh, thao tác chạm để chụp nhẹ nhàng. Chất lượng ảnh trong các điều kiện chụp khác nhau tốt', 1, '2020-12-18 17:00:00'),
(4, 'Iphone 11 Pro MAX', 1, 1, 20000000, 'iphone11promax.png', 'Mặt lưng của iPhone 7 Plus được thiết kế với phần ăng-ten được đưa vòng lên trên thay vì cắt ngang mặt lưng như những phiên bản trước là iPhone 6 Plus mang lại cảm giác thoải mái khi cầm nắm.', 1, '2020-11-22 14:08:56'),
(5, 'Iphone XS MAX ', 1, 1, 15000000, 'iphonexsmax.jpg', 'Mặt lưng của iPhone 7 Plus được thiết kế với phần ăng-ten được đưa vòng lên trên thay vì cắt ngang mặt lưng như những phiên bản trước là iPhone 6 Plus mang lại cảm giác thoải mái khi cầm nắm.', 1, '2020-11-22 14:08:56'),
(6, 'Laptop Dell Vostro 3491 i3 1005G1/4GB/256GB/Win10 (70223127)', 2, 2, 11000000, 'lap1.jpg', 'Dell Vostro 3491 có thiết kế hiện đại, tối giản từ chất liệu nhựa, tông màu đen sang trọng. Máy có độ dày 21 mm, trọng lượng 1.66 kg dễ dàng để các bạn học sinh sinh viên có thể đem theo đến lớp, đi cà phê,..', 1, '2020-11-22 14:08:56'),
(7, 'Laptop Dell Vostro 3580 i3 8145U/4GB/1TB/Win10 (V5I3058W)\r\n', 2, 2, 10000000, 'lap2.jpg', 'Dell luôn được yêu thích vì độ bền cao, Dell Vostro 3580 là một chiếc laptop tối ưu với sức chịu đựng, cứng cáp, chắc chắn. Chiếc laptop có trọng lượng 2.16 kg, không quá nặng để bạn mang theo bên mình khi đi học hay đi làm.', 1, '2020-11-22 14:08:56'),
(8, 'Laptop Dell Inspiron 5584 i3 8145U/4GB/1TB/Win10 (70186849)\r\n', 2, 2, 12000000, 'lap3.jpg', 'Dell Inspiron 5584 i3 8145U (70186849) được thiết kế đơn giản, thanh lịch. Trọng lượng nhẹ và cấu hình khá, phù hợp cho sinh viên - nhân viên văn phòng khi đi làm và đi học.', 1, '2020-11-22 14:08:56'),
(9, 'Laptop Dell Inspiron 3476 i3 8130U/4GB/1TB/Win10/(8J61P11)\r\n', 2, 2, 14000000, 'lap4.jpg', 'Dell Inspiron 3476 i3 8130U là phiên bản máy tính xách tay được trang bị cấu hình cơ bản với chip Intel Core i3 Kabylake Refresh, RAM DDR4 4 GB, ổ cứng HDD lên đến 1 TB, cùng hệ điều hành Windows 10 được cài đặt sẵn. Đây sẽ là lựa chọn phù hợp cho đối tượng như học sinh - sinh viên cần một chiếc laptop đáp ứng tốt các nhu cầu cơ bản của công việc văn phòng cũng như học tập.', 1, '2020-11-22 14:08:56'),
(10, 'Laptop Dell Inspiron 3581 i3 7020U/4GB/1TB/Win10 (P75F005N81A)', 2, 2, 15000000, 'lap5.jpg', 'Không quá cầu kỳ, laptop Dell Inspiron 3581 có thiết kế truyền thống với cân nặng 2.28 kg.\r\n\r\nTrọng lượng này khá cồng kềnh nếu bạn là người phải thường xuyên di chuyển nhiều.', 1, '2020-11-22 14:08:56'),
(31, 'Apple Watch SE 40mm viền nhôm dây cao su', 1, 4, 7990000, 'applewatch2.jpg', 'Apple Watch SE 40mm viền nhôm dây cao su sở hữu ngoại hình khá giống với Series 5 với mặt kính cong 2.5D cho cảm giác vuốt và chạm thoải mái. Kích thước màn hình 1.57 inch cùng độ phân giải 324 x 394 pixels giúp hiển thị hình ảnh và các thông tin đầy đủ và sắc nét. Dây đeo làm từ chất liệu cao su có đàn hồi cao, tạo cảm giác thoải mái cho cổ tay khi đeo trong thời gian dài. Apple watch không chỉ là đồng hồ với nhiều tính năng thông minh mà còn là một phụ kiện thời trang cao cấp.', 1, '2020-12-03 02:45:59'),
(30, 'Apple Watch S6 LTE 40mm viền nhôm dây cao su', 1, 4, 14490000, 'applewatch1.jpg', 'Apple Watch S6 LTE 40mm viền nhôm dây cao su sở hữu màn hình 1.57 inch giúp hiển thị đầy đủ thông tin và hình ảnh sắc nét. Dây đeo được làm từ chất liệu cao su dẻo dai và êm ái, cho cảm giác dễ chịu khi mang. Thêm vào đó, mặt kính cường lực Sapphire giúp chống trầy, tăng độ bền cho thiết bị. Các đường nét được thiết kế tinh xảo làm nên sự đẳng cấp của Apple Watch.', 1, '2020-12-03 02:45:59'),
(29, 'Sony Xperia 10 Plus Likenew 99%', 3, 1, 4490000, 'sony5.png', 'Khi nói về thiết kế thì chiếc Sony Xperia 10 Plus được coi là smartphone có chiều dài dài nhất hiện nay. Với tỷ lệ màn hình khác biệt 21:9 theo chiều ngang và 9:21 theo chiều dọc. Chưa nói đến ưu điểm nhưng đây chắc chắn là 1 điểm gây ấn tượng với người dùng.', 1, '2020-12-03 02:30:38'),
(57, 'nhom 9 ', 1, 1, 50000000, 'dbcb8b94089af2c4ab8b.jpg', 'alo alo', 1, '2020-09-11 17:00:00'),
(27, 'Sony Xperia XZ3 Likenew 99%', 3, 1, 6190000, 'sony3.png', 'điện thoại sony máy cũ ', 1, '2020-12-17 12:16:16'),
(26, 'Sony Xperia 1 II ( Mark 2 ) Likenew 99%', 3, 1, 22490000, 'sony2.png', 'Sony Xperia 1 Mark II có một sự thay đổi về thiết kế so với phiên bản Sony Xperia 1 trước đó, thay đổi đầu tiên là \"em nó\" mang một cái tên mới \"Mark II\". Theo nguồn tin cho biết, Xperia 1 Mark II vẫn đâu đó mang đến một sự hấp dẫn kì lạ, với thân máy được gia công bằng kim loại phẳng đầy sang trọng và mặt trước, sau đều được phủ kính trong sáng bóng và lấp lánh.', 1, '2020-12-03 02:30:38'),
(25, 'Sony Xperia 5 II ( Mark 2 ) Mới 100% - FullBox', 3, 1, 24890000, 'sony1.png', 'Tiếp nối sự thành công đến từ 2 phiên bản Xperia 1 Mark 2 và Xperia 10 Mark 2 đều là những phiên bản nâng cấp của Xperia 1 và Xperia 10 Plus - đến lượt SONY tiếp tục con đường thành công thời gian gần đây với các mẫu smartphone thế hệ mới giới thiệu ra mắt sản phẩm Xperia 5 Mark 2 ( phiên bản nâng cấp của Xperia 5 ) vào tháng 9 vừa qua.', 1, '2020-12-03 02:30:38'),
(21, 'Tai nghe AirPods Pro sạc không dây Apple MWP22\r\n', 1, 3, 6990000, 'airpod1.jpg', 'Thiết kế in-ear hoàn toàn mới và độc đáo.\r\nTích hợp công nghệ chống ồn chủ động (Active Noise Cancellation).\r\nChip H1 mạnh mẽ, xử lý âm thanh kỹ thuật số với độ trễ gần như bằng không.\r\nNghe nhạc đến 4.5 giờ khi bật chống ồn, 5 giờ khi tắt chống ồn .\r\nSử dụng song song với hộp sạc có thể dùng được đến 24 giờ nghe nhạc.\r\nHỗ trợ sạc nhanh, cho thời gian sử dụng đến 1 giờ chỉ với 5 phút sạc.\r\nHộp sạc hỗ trợ sạc không dây chuẩn Qi, tiện lợi khi sạc lại.', 1, '2020-12-03 02:50:48'),
(22, 'Tai nghe nhét tai Earpods Apple MNHF2\r\n', 1, 3, 790000, 'earpod2.jpg', 'Thiết kế hiện đại, sang trọng và thoải mái.\r\nCó phím điều chỉnh âm lượng, nghe/nhận cuộc gọi.\r\nCổng 3.5mm phù hợp nhiều loại điện thoại, máy tính bảng, laptop.\r\nSản phẩm chính hãng Apple, nguyên seal 100%.\r\nLưu ý: Thanh toán trước khi mở seal.', 1, '2020-12-03 02:50:33'),
(23, 'Tai nghe nhét tai Sony MDR-E9LP', 3, 3, 139000, 'tainghesony1.jpg', 'Thiết kế sành điệu, bắt mắt.\r\nChất lượng âm thanh sống động và chân thực.\r\nSử dụng được cho hầu hết điện thoại, máy tính bảng, laptop có cổng 3.5mm\r\nTai nghe có dây dài 1.2 m, tiện lợi khi nghe nhạc với điện thoại bỏ trong balo, túi xách.\r\nThương hiệu Sony đến từ Nhật Bản, nổi tiếng toàn cầu trong lĩnh vực công nghệ, điện tử.', 0, '2020-12-03 02:51:15'),
(24, 'Tai nghe chụp tai Sony MDR - ZX110AP', 3, 3, 439000, 'tainghesony2.jpg', 'Thiết kế mạnh mẽ, hiện đại.\r\nĐệm tai nghe tạo cảm giác êm khi đeo và cách âm tốt.\r\nCó thể nới lỏng tai nghe thêm khoảng 4.5 cm để thoải mái khi đeo.\r\nGấp gọn dễ dàng khi cất, đựng trong balo, túi xách hoặc mang theo.\r\nDây dài 1.2 m và kết nối dễ dàng với thiết bị có cổng 3.5mm.\r\nCó nút dừng/phát nhạc, chuyển bài, nhận cuộc gọi dễ dàng.\r\nThương hiệu Sony đến từ Nhật Bản, nổi tiếng toàn cầu trong lĩnh vực công nghệ, điện tử.', 1, '2020-12-03 02:51:15'),
(32, 'Apple Watch S5 44mm viền nhôm dây cao su đen', 1, 4, 10000000, 'applewatch3.jpg', 'Apple Watch S5. chất lượng cực tốt xài sướng khỏi bàn', 1, '2020-12-16 17:00:00'),
(33, 'Apple Watch S3 LTE 42mm viền nhôm dây cao su trắng\r\n\r\n', 1, 4, 6990000, 'applewatch4.jpg', 'Đồng hồ thông minh Apple Watch được trang bị màn hình OLED Retina cho mọi hình ảnh sắc nét, hiển thị tốt cả khi sử dụng ngoài trời. Với kích thước 1.65 inch giúp bạn có thể theo dõi các thông tin to rõ, dễ dàng hơn. ', 1, '2020-12-03 02:45:59'),
(34, 'Apple Watch S6 LTE 44mm viền nhôm dây cao su', 1, 4, 15490000, 'applewatch5.jpg', 'Apple Watch S6 LTE là một trong những dòng đồng hồ được ưa chuộng nhiều nhất trên thế giới với thiết kế tinh tinh tế trong từng chi tiết, khung viền được gia công chắc chắn, dây đeo cao su đàn hồi tốt, màn hình sắc nét với mặt kính cường lực Sapphire đem lại sự thời thượng và sang trọng, cho bạn tự tin thể hiện đẳng cấp của mình', 1, '2020-12-03 02:45:59'),
(35, 'Tai nghe AirPods 2 sạc không dây Apple MRXJ2', 1, 3, 4900000, 'airpod2.jpg', 'Thiết kế đơn giản, thời trang và nhỏ gọn.\r\nTrang bị chip H1 hoàn toàn mới, cho tốc độ kết nối, chuyển đổi giữa các thiết bị nhanh chóng.\r\nKích hoạt nhanh trợ lý ảo Siri bằng cách nói \"Hey, Siri\".\r\nCó thể sử dụng nghe nhạc lên đến 5 giờ (âm lượng 50%) cho mỗi một lần sạc đầy.', 1, '2020-12-03 02:50:09'),
(36, 'Điện thoại Samsung Galaxy Note 20 Ultra', 4, 1, 24990000, 'ss1.png', 'Sau Galaxy Note 20 thì Galaxy Note 20 Ultra là phiên bản tiếp theo cao cấp hơn thuộc dòng Note 20 Series của Samsung, với nhiều thay đổi từ cụm camera hỗ trợ lấy nét laser AF cùng ống kính góc rộng mới, màn hình tràn viền lên đến 6.9 inch chắc chắn sẽ là chiếc điện thoại được săn đón của fan yêu thích công nghệ.', 1, '2020-12-03 02:58:47'),
(37, 'Điện thoại Samsung Galaxy Z Fold2 5G', 4, 1, 50000000, 'ss2.png', 'Samsung Galaxy Z Fold 2 là tên gọi chính thức của điện thoại màn hình gập cao cấp nhất của Samsung. Với nhiều nâng cấp tiên phong về thiết kế, hiệu năng và camera, hứa hẹn đây sẽ là một siêu phẩm thành công tiếp theo đến từ “ông trùm” sản xuất điện thoại lớn nhất thế giới.', 1, '2020-12-03 02:58:47'),
(38, 'Điện thoại Samsung Galaxy S20+', 4, 1, 23990000, 'ss3.png', 'Chiếc điện thoại Samsung Galaxy S20 Plus - Siêu phẩm với thiết kế màn hình tràn viền, hiệu năng đỉnh cao kết hợp cùng nhiều đột phá về công nghệ dẫn đầu thế giới smartphone.', 1, '2020-12-03 02:58:47'),
(39, 'Điện thoại Samsung Galaxy S20 FE', 4, 1, 15990000, 'ss4.png', 'Trong sự kiện Samsung Unpacked đặc biệt vừa qua, Samsung đã giới thiệu đến người dùng thành viên mới của dòng điện thoại thông minh S20 Series đó chính là Samsung Galaxy S20 FE. Đây là mẫu flagship cao cấp quy tụ nhiều tính năng mà Samfan yêu thích, hứa hẹn sẽ mang lại trải nghiệm cao cấp của dòng Galaxy S với mức giá dễ tiếp cận hơn.', 0, '2020-12-03 02:58:47'),
(40, 'Điện thoại Samsung Galaxy A50s', 4, 1, 6990000, 'ss5.png', 'Nằm trong sứ mệnh nâng cao khả năng cạnh tranh với các smartphone đến từ nhiều nhà sản xuất Trung Quốc, mới đây Samsung tiếp tục giới thiệu phiên bản Samsung Galaxy A50s với nhiều tính năng mà trước đây chỉ xuất hiện trên dòng cao cấp.', 1, '2020-12-03 02:58:47'),
(41, 'Adapter sạc 2 cổng USB 2.4A Type-C PD 3A Anker PowerPort - A2626 Trắng\r\n\r\n', 5, 5, 552000, 'sac1.jpg', 'Thiết kế chắc chắn và bền bỉ với chất liệu cao cấp.\r\nTích hợp cổng USB-C Power Delivery chuyên dụng.\r\nCông suất sạc tối đa 33W, an toàn, nhanh chóng.\r\nSạc mọi thiết bị USB tiêu chuẩn nhanh nhất có thể với PowerIQ 2.0.', 1, '2020-12-03 03:13:22'),
(42, 'Cáp Lightning MFI 0.9m Anker PowerLine+ II A8452', 5, 5, 430000, 'cap1.jpg', 'Thiết kế nhỏ gọn, độ dài 0.9 m tiện dụng.\r\nVỏ nylon kép chịu lực ấn tượng, độ bền cao.\r\nTốc độ sạc nhanh, truyền dữ liệu ổn định.\r\nĐược chứng nhận chuẩn MFi (Made For iPhone, iPad, iPod) bởi Apple.\r\nTương thích với các thiết bị có cổng kết nổi Lightning.', 1, '2020-12-03 03:16:16'),
(43, 'Cáp Lightning MFI 1.8 m Anker A8122xx2 Xám', 5, 5, 420000, 'cap2.jpg', 'Thiết kế nhỏ gọn, vỏ cáp làm bằng sợi nylon chống rối và đầu cáp bọc thép.\r\nVỏ cáp bền bỉ, chịu được lực kéo lên đến 80kg.\r\nCổng lightning dùng cho dòng iPhone 5, iPad 4 trở lên.\r\nCáp dài 1.8 m, có thể sạc thiết bị ở khoảng cách tương đối xa.\r\n', 1, '2020-12-03 03:16:16'),
(44, 'Adapter Sạc Type C 20W dùng cho iPhone/iPad Apple MHJE3 Trắng', 1, 5, 990000, 'sac2.png', 'Kiểu dáng adapter sạc đơn giản, trang nhã, chất lượng tốt cho độ bền cao. Thiết kế đầu cắm loại có 2 chấu quen thuộc, dùng được với các ổ điện ở mọi nơi từ nhà cho tới công sở, trường học, nhà hàng, khách sạn', 1, '2020-12-03 03:22:26'),
(45, 'Adapter Sạc 12W dùng cho iPhone/iPad/iPod Apple MGN03 Trắng', 1, 5, 439000, 'sac3.jpg', 'Kiểu dáng adapter sạc đơn giản, trang nhã, chất lượng tốt cho độ bền cao. Thiết kế đầu cắm loại có 2 chấu quen thuộc, dùng được với các ổ điện ở mọi nơi từ nhà cho tới công sở, trường học, nhà hàng, khách sạn', 1, '2020-12-03 03:22:26'),
(46, 'Cáp sạc không dây Apple Watch Magnetic 1 m Apple MX2E2 Trắng', 1, 5, 890000, 'cap4.jpg', 'Thiết kế nhỏ gọn, trang nhã.\r\nSản phẩm được thiết kế để sạc cho Apple Watch.\r\nĐầu nam châm tự động hút Apple Watch giúp dễ dàng sử dụng.\r\nĐầu sạc USB phù hợp với nhiều loại thiết bị.', 1, '2020-12-03 03:26:24'),
(47, 'Cáp Type C- Lightning 1m Apple MX0K2 Trắng\r\n', 1, 5, 590000, 'cap3.jpg', 'Cáp 1 đầu kết nối Type C và 1 đầu Lightning, dùng để sạc và truyền dữ liệu.\r\nDây dài 1 m tiện lợi khi sử dụng.\r\nCó thể sử dụng kèm theo Adapter 29 W, 30 W, 61 W, 87 W USB-C của Apple để sạc nhanh iPhone, iPad.\r\nSử dụng kèm được với nhiều Adapter hay pin dự phòng khác có cổng ra USB Type-C.\r\nSản phẩm chính hãng Apple, nguyên seal 100%', 1, '2020-12-03 03:28:54'),
(51, 'Iphone 12 Pro Max', 1, 1, 32000000, 'iphone12promax.jpg', 'Iphone 12 pro max thiết kế sang trọng', 1, '2020-12-05 17:00:00'),
(53, 'Iphone 8 Plus 64Gb', 1, 1, 10000000, 'iphone8plus.png', 'iPhone 7 32GB vẫn mang trên mình thiết kế quen thuộc của từ thời iPhone 6 nhưng có nhiều thay đổi lớn về phần cứng, dàn loa stereo và cấu hình cực mạnh.', 1, '2021-01-03 17:00:00'),
(54, 'Iphone 7 Plus 64Gb', 1, 1, 8600000, 'iphone7plus.png', 'iPhone 7 Plus 64GB vẫn mang trên mình thiết kế quen thuộc của từ thời iPhone 6 nhưng có nhiều thay đổi lớn về phần cứng, dàn loa stereo và cấu hình cực mạnh.', 1, '2020-12-23 17:00:00'),
(58, 'Pin sạc dự phòng 7500 mAh AVA DS630 ', 5, 1, 500, 'Pin sạc dự phòng 7500 mAh AVA DS630 .png', 'Very good', 1, '2021-06-18 17:00:00'),
(59, 'Samsung Z Fold2', 1, 1, 15, 'Samsung Z Fold2.png', 'gggggggggggggggggggggg', 0, '2021-06-18 17:00:00'),
(61, 'dddd', 1, 1, 100000000, 'R.ui.png', '', 1, '2021-06-25 17:00:00'),
(62, 'hinh', 2, 2, 10000000, '2.jpg', 'dddddddddddddddddd', 1, '2021-06-25 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `protypes`
--

DROP TABLE IF EXISTS `protypes`;
CREATE TABLE IF NOT EXISTS `protypes` (
  `type_id` int NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `protypes`
--

INSERT INTO `protypes` (`type_id`, `type_name`) VALUES
(1, 'SmartPhone '),
(2, 'Laptop'),
(4, 'SmartWatch'),
(3, 'Phone'),
(5, 'Sạc '),
(15, 'Adapter');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `role`) VALUES
(1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'Manager'),
(2, 'Teo', 'e10adc3949ba59abbe56e057f20f883e', 'Staff');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
