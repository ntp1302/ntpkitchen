-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th5 29, 2024 lúc 02:24 AM
-- Phiên bản máy phục vụ: 8.0.31
-- Phiên bản PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mydb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cartitems`
--

CREATE TABLE `cartitems` (
  `cart_item_id` int NOT NULL,
  `cart_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cartitems`
--

INSERT INTO `cartitems` (`cart_item_id`, `cart_id`, `product_id`, `quantity`) VALUES
(29, 14, 12, 1),
(30, 14, 9, 1),
(31, 14, 5, 1),
(32, 14, 7, 2),
(33, 15, 9, 1),
(38, 19, 1, 1),
(39, 20, 11, 1),
(42, 23, 11, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `cart_id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`cart_id`, `username`, `created_at`, `status`) VALUES
(14, 'phatdz', '2024-05-25 11:40:41', 1),
(15, 'phatdz', '2024-05-25 11:58:30', 1),
(19, 'phatadmin', '2024-05-25 14:42:21', 1),
(20, 'phatadmin', '2024-05-25 15:03:50', 1),
(23, 'phatdz', '2024-05-28 17:33:13', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `category_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`) VALUES
(1, 'Dụng cụ nấu ăn', 'Các dụng cụ cần thiết cho việc nấu ăn như nồi, chảo, muỗng, thìa...'),
(2, 'Dụng cụ làm bánh', 'Các dụng cụ dùng để làm bánh như khuôn, que đánh trứng, máy trộn bột...'),
(3, 'Dụng cụ cắt gọt', 'Các dụng cụ để cắt, gọt thực phẩm như dao, kéo, dụng cụ bào...'),
(4, 'Đồ dùng nhà bếp', 'Các đồ dùng khác cho nhà bếp như thớt, bát, đĩa, hộp đựng thực phẩm...'),
(5, 'Thiết bị điện nhà bếp', 'Các thiết bị điện dùng trong nhà bếp như lò vi sóng, máy xay sinh tố, nồi cơm điện...');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `product_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `price` int NOT NULL,
  `stock_quantity` int NOT NULL DEFAULT '10',
  `category_id` int NOT NULL,
  `brand` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Đang cập nhật',
  `origin` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Đang cập nhật',
  `size` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Đang cập nhật',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `combo` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`product_id`, `name`, `description`, `price`, `stock_quantity`, `category_id`, `brand`, `origin`, `size`, `created_at`, `image`, `combo`) VALUES
(1, 'Nồi inox 5 lớp Kangaroo', 'Nồi inox cao cấp với 5 lớp đáy, giữ nhiệt tốt, không gỉ sét.', 750000, 50, 1, 'Kangaroo', 'Việt Nam', '28 x 17cm', '2024-05-24 05:31:59', 'noi_inox_5lop_kangaroo.jpg', 0),
(2, 'Chảo nhôm chống dính hiệu PoongNyun SERFP(IH)-28B', 'Chảo chống dính 28cm, lớp chống dính bền bỉ, dễ dàng vệ sinh.', 450000, 100, 1, 'PoongNyun', 'Việt Nam', '28cm', '2024-05-24 05:31:59', 'chao_chong_dinh_28b.jpg', 0),
(3, 'Khuôn làm bánh gato đế liền ', 'Khuôn tròn đường kính 20cm, chất liệu nhôm cao cấp, không dính.', 120000, 75, 2, 'Sanneng', 'Việt Nam', '2.SN5038- 7inch', '2024-05-24 05:31:59', 'khuon_lam_banh_gato_sanneng.jpg', 0),
(4, 'Que đánh trứng bằng tay', 'Que đánh trứng chất liệu bằng inox, dài 24cm, tay cầm chắc chắn.', 50000, 150, 2, 'Zen Khodolambanh', 'Việt Nam', '24cm', '2024-05-24 05:31:59', 'que_danh_trung_inox.png', 0),
(5, 'Bộ dao, kéo 7 món nhà bếp cao cấp Global Nhật Bản', 'Dao, kéo bếp Nhật sắc bén, chất liệu thép không gỉ.', 1190000, 80, 3, 'Global', 'Nhật Bản', '20cm x 6, 13.5cm', '2024-05-24 05:31:59', 'bo_dao_keo_global.png', 1),
(6, 'Dao bào đa năng cho rau củ', 'Dao Bào Đa Năng Cho Rau Củ (Bào Vỏ - Bào Sợi) Tiện Ích', 35000, 60, 3, 'Lazada', 'Việt Nam', '18cm', '2024-05-24 05:31:59', 'dao_bao_da_nang.png', 0),
(7, 'Khay gỗ, thớt gỗ Homie Decor', 'Khay gỗ, thớt gỗ Homie Decor - màu gỗ tự nhiên, an toàn, bền đẹp còn mới 100%', 199000, 90, 4, 'Homie Decor', 'Việt Nam', '20 x 30cm', '2024-05-24 05:31:59', 'thot_go_tu_nhien.jpg', 0),
(8, 'Bộ bát đĩa sứ Bát Tràng men trắng TABDT06', 'Bộ bát đĩa sứ trắng gồm 10 bát cơm, 1 bát mắm, 2 đĩa gia vị, 3 bát tô, 4 đĩa đựng thức ăn, 1 âu cơm 14x11cm, 6 thìa cơm', 1242000, 40, 4, 'Bát Tràng', 'Việt Nam', '20cm, 25 x 17cm, 22cm', '2024-05-24 05:31:59', 'bo-bat-dia-su-bat-trang.jpg', 1),
(9, 'Máy xay sinh tố 3 trong 1 Kochstar', 'Máy xay sinh tố 3 trong 1 Kochstar KSEBD-1000 (1.2L)', 1850000, 30, 5, 'Kochstar', 'Đức', '1.2L', '2024-05-24 05:31:59', 'may_xay_sinh_to_3in1.png', 0),
(10, 'Nồi Cơm Điện Tử BlueStone', 'Nồi Cơm Điện Tử BlueStone RCB-5949 1.5 Lít 860W', 2999000, 25, 5, 'BlueStone', 'Việt Nam', '1.5L', '2024-05-24 05:31:59', 'noi_com_dien_bluestone.png', 0),
(11, 'Tủ lạnh thông minh LG GR-R267LS', 'Tủ lạnh thông minh LG 626 lít GR-R267LS', 37850000, 10, 5, 'LG', ' Trung Quốc', '626L', '2024-05-24 13:15:40', 'tu_lanh_lg.jpg', 0),
(12, 'Tủ lạnh Sharp Inverter SJ-X198V-DG', 'Tủ lạnh Sharp Inverter 181 lít SJ-X198V-DG  với dung tích 181 lít phù hợp với các gia đình có từ 2 - 3 thành viên, trang bị công nghệ Inverter giúp tiết kiệm điện năng\r\n', 5190000, 10, 5, 'Sharp', 'Nhật Bản', '181L', '2024-05-24 13:19:25', 'tu_lanh_sharp.jpg', 0),
(21, 'Bộ nồi bếp từ', 'Lớp trên cùng tiếp xúc với thực phẩm là lớp inox 304, vệ sinh và an toàn hơn với thực phẩm.\r\nLớp lõi là nhôm nguyên chất giúp truyền nhiệt nhanh và tỏa nhiệt đều ra xung quanh.\r\nLớp đáy ngoài cùng là lớp inox 430, rất bền và dễ dàng vệ sinh.', 3100000, 10, 1, 'Đang cập nhật', 'Đang cập nhật', 'Đang cập nhật', '2024-05-28 14:59:37', 'bo_noi_bep_tu.jpg', 1),
(22, 'Dụng cụ làm bánh que', NULL, 205000, 10, 2, 'Đang cập nhật', 'Đang cập nhật', 'Đang cập nhật', '2024-05-28 18:20:42', 'Dung_cu_lam_banh_que.PNG', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `security_question` varchar(250) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `full_name`, `address`, `phone`, `create_at`, `security_question`) VALUES
(7, 'phatadmin', '$2y$10$eOos/kE1zXKCR62zCZoJKOW1EGX1ANCP4C1FEMEqKNz4YjL5wGgCy', 'nguyenthanhphat1302@gmail.com', 'Nguyễn Thành Phát', '1A DN', '0123456789', '2024-05-24 21:33:08', 'what is your name'),
(8, 'phatdz', '$2y$10$4fNSOADkKQAmw/fK4gQMUu2l4BlbqwnaNr06qr0y7CUGr608GqL/a', 'nguyenthanhphat1302@gmail.com', 'Phát DZZdzz', '1A DNnnNN', '0987654321', '2024-05-24 21:42:18', 'what is your name'),
(10, 'phatkh', '$2y$10$dS25VT7tZk.gv36pzxS5XOSZWaOYw3o8P5CMDX46i7vzsVmc.6.mW', 'ntp13022003@gmail.com', 'Phát khách', '1A DN', '0123456789', '2024-05-29 02:08:13', 'how are you');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `username` (`username`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username_unique` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `cart_item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `cartitems_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `cartitems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
