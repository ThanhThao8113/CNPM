-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 27, 2024 lúc 05:58 PM
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
-- Cơ sở dữ liệu: `food_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(1, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(12, 1, 13, 'Pizza rau củ', 229000, 2, 'pizza-2.png'),
(13, 1, 42, 'Kem', 30000, 1, 'dessert-5.png'),
(14, 1, 27, 'Nước chanh', 25000, 1, 'drink-3.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(1, 0, 'Thanh Thảo', 'tthanhthao0811@gmail.com', '0946325098', 'abcxyz'),
(2, 0, 'Burger gà', 'xyz@gmail.com', '0987654321', 'shgzrjdgjn'),
(3, 0, 'admin', 'xyz@gmail.com', '01234567', 'gshbsxfn'),
(4, 0, 'thanhthao', 'thanhthao08112k3@gmail.com', '0987654321', '                             '),
(5, 0, 'thanhthao', 'xyz@gmail.com', '0987654321', '                   abc                              ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(2, 1, 'Thanh Thảo', '0946325098', 'tthanhthao0811@gmail.com', 'Thanh toán khi nhận hàng', 'abc, xyz, www, VN', 'Pizza rau củ tổng hợp (50000 x 2) - ', 100000, '2024-05-14', 'Thành công'),
(3, 1, 'Thanh Thảo', '0946325098', 'tthanhthao0811@gmail.com', 'Thanh toán khi nhận hàng', 'cxecx,  fvcf, crvvr, drfr', 'Pizza rau củ tổng hợp (50000 x 3) - ', 150000, '2024-05-14', 'Hủy'),
(4, 1, 'Thanh Thảo', '0946325098', 'tthanhthao0811@gmail.com', 'Thanh toán khi nhận hàng', 'cxecx,  fvcf, crvvr, drfr', 'Pizza rau củ (40000 x 3) - ', 120000, '2024-05-14', 'Đang chờ'),
(5, 1, 'Thanh Thảo', '0946325098', 'tthanhthao0811@gmail.com', 'Momo', 'cxecx,  fvcf, crvvr, drfr', 'Pizza rau củ tổng hợp (259000 x 1) - Pizza rau củ (229000 x 1) - ', 488000, '2024-05-17', 'Hủy'),
(6, 1, 'Thanh Thảo', '0946325098', 'tthanhthao0811@gmail.com', 'Thanh toán khi nhận hàng', 'cxecx,  fvcf, crvvr, drfr', 'Pizza rau củ tổng hợp (259000 x 1) - ', 259000, '2024-05-20', 'Hủy'),
(7, 1, 'Thanh Thảo', '0946325098', 'tthanhthao0811@gmail.com', 'Thanh toán khi nhận hàng', 'acbsjbcksj', 'Pizza rau củ (229000 x 2) - ', 458000, '2024-05-23', 'Hủy');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `image`, `description`) VALUES
(13, 'Pizza rau củ', 'Đồ ăn nhanh', 229000, 'pizza-2.png', 'Pizza kết hợp với rau củ organic'),
(27, 'Nước chanh', 'Đồ uống', 25000, 'drink-3.png', NULL),
(29, 'Mỳ spaghetti', 'Món chính', 135000, 'dish-1.png', NULL),
(33, 'Pizza rau củ tổng hợp', 'Đồ ăn nhanh', 259000, 'pizza-1.png', NULL),
(34, 'Pizza xúc xích', 'Đồ ăn nhanh', 239000, 'pizza-3.png', NULL),
(35, 'Pizza phô mai', 'Đồ ăn nhanh', 259000, 'pizza-4.png', NULL),
(36, 'Pizza nấm', 'Đồ ăn nhanh', 229000, 'pizza-5.png', NULL),
(37, 'Burger bò Mỹ', 'Đồ ăn nhanh', 50000, 'burger-1.png', NULL),
(38, 'Burger gà', 'Đồ ăn nhanh', 50000, 'burger-2.png', NULL),
(39, 'Dâu tây đá xay', 'Tráng miệng', 45000, 'dessert-1.png', NULL),
(40, 'Cup cake', 'Tráng miệng', 35000, 'dessert-4.png', NULL),
(41, 'Socola sundae', 'Tráng miệng', 45000, 'dessert-3.png', NULL),
(42, 'Kem', 'Tráng miệng', 30000, 'dessert-5.png', NULL),
(43, 'Bánh dâu tây', 'Tráng miệng', 40000, 'dessert-6.png', NULL),
(44, 'Nước cam', 'Đồ uống', 30000, 'drink-1.png', NULL),
(45, 'Coffee', 'Đồ uống', 40000, 'drink-2.png', NULL),
(46, 'Trà dâu', 'Đồ uống', 30000, 'drink-4.png', NULL),
(47, 'Mỳ spaghetti rau củ', 'Món chính', 145000, 'dish-2.png', NULL),
(48, 'Mỳ spaghetti hải sản', 'Món chính', 170000, 'dish-3.png', NULL),
(49, 'Beafsteak', 'Món chính', 185000, 'dish-4.png', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `password`, `address`) VALUES
(1, 'Thanh Thảo', 'tthanhthao0811@gmail.com', '0946325098', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'số 10 kdv 14,Bằng Liệt, Hoàng Mai, Hà Nội'),
(2, 'Nguyễn Văn A', 'abc@gmail.com', '0456789123', 'bfe54caa6d483cc3887dce9d1b8eb91408f1ea7a', ''),
(3, 'thanhthao', 'thanhthao08112k3@gmail.com', '0123456789', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', ''),
(4, 'thanhthao', 'nguyenvan@gmail.com', '0943028728', 'c8be377df0e8a27429bf27d7f9714f3e6bc779b3', ''),
(5, 'Burger gà', 'axy@gmail.com', '0456187932', '7c4a8d09ca3762af61e59520943dc26494f8941b', '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
