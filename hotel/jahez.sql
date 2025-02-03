-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2025 at 05:10 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jahez`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `about_id` int(11) NOT NULL,
  `About_site` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`about_id`, `About_site`) VALUES
(1, '\r\nمرحبًا بكم في منصة حجز الفنادق، حيث نهدف إلى تقديم تجربة فريدة للمستخدمين في عالم السفر والإقامة. تم بناء هذا المشروع من الصفر، حيث تم تصميمه باستخدام تقنيات حديثة مثل **HTML** و**CSS** و**JavaScript**، بالإضافة إلى **PHP** لربطه بقاعدة بيانات **SQL**. \r\n\r\nتسعى المنصة إلى تسهيل عملية البحث والحجز، مما يمنح المستخدمين القدرة على استكشاف مجموعة واسعة من الخيارات في بيئة سهلة الاستخدام. نحن نؤمن بأن كل رحلة تبدأ بخطوة، ومن خلال منصتنا، نساعدك في اتخاذ تلك الخطوة بثقة ويسر. ✈️\r\n\r\nفريقنا المتميز يعمل بجد لتقديم أفضل الخدمات وتحديث المحتوى بشكل دوري، مما يضمن لك تجربة سلسة وموثوقة. انضم إلينا واستمتع بتجربة حجز لا تُنسى! 🏨\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `number_of_guests` int(11) NOT NULL,
  `status` enum('confirmed','canceled','pending') DEFAULT 'pending',
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `hotel_id`, `check_in`, `check_out`, `number_of_guests`, `status`, `price`) VALUES
(49, 14, 4, '2025-02-20', '2025-02-14', 5, 'confirmed', '0.00'),
(50, 14, 4, '2025-02-20', '2025-02-14', 5, 'confirmed', '16560.00'),
(52, 18, 5, '2025-02-17', '2025-03-06', 2, 'pending', '3.36');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `email`, `message`, `created_at`) VALUES
(1, 'ahmedali.2004.20042.004@gmail.com', 'بلبىبؤ', '2025-01-25 23:28:19'),
(2, 'ahmedali.2004.20042.004@gmail.com', 'بلبىبؤ', '2025-01-25 23:30:12'),
(3, '202310101668@student.ust.edu.ye', 'يايفقفي', '2025-01-26 00:38:50'),
(4, 'ahmedali.2004.20042.004@gmail.com', 'هااي', '2025-02-02 18:18:17'),
(5, 'ahmedali.2004.20042.004@gmail.com', 'هااي', '2025-02-02 18:20:31');

-- --------------------------------------------------------

--
-- Table structure for table `developer_team`
--

CREATE TABLE `developer_team` (
  `id` int(11) NOT NULL,
  `developer_name` varchar(100) NOT NULL,
  `developer_phone` varchar(15) NOT NULL,
  `developer_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `developer_team`
--

INSERT INTO `developer_team` (`id`, `developer_name`, `developer_phone`, `developer_email`) VALUES
(1, 'م/ أحمد المتوكل', '775052259', 'ahmedali.2004.2004.2004@gmail.com'),
(2, 'م/ عدنان القحطاني', '770139797', 'adnan2000yemen@gmail.com'),
(3, 'م/ فاروق العواضي', '771810699', 'farouq@example.com'),
(4, 'م/ محمد المضواحي', '777637261', '202310101628@student.ust.edu.ye');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `rating` float NOT NULL,
  `price` float NOT NULL,
  `image` varchar(255) NOT NULL,
  `city` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `description`, `location`, `rating`, `price`, `image`, `city`) VALUES
(3, 'شهران', 'اتبخنسىتنيرىتيسنىرهيشسيرىص', 'بير العزب', 1.3, 9000.5, 'uploads/images.jpg', 'sa'),
(4, 'الربيع2', 'اتبخنسىتنيرىتيسنىرهيشسيرىص', 'شارع النصر', 1, 552, 'uploads/a.png', 'ad'),
(5, 'الراحه', 'اي حاجه', 'الجزاير', 3.2, 1.12, 'uploads/g1.jpg', 'ta'),
(6, 'الربيع', 'غلللللتانgnf', 'شارع النصر', 1.2, 53, '679ea19fa29bb_g1.jpg', 'عدن');

-- --------------------------------------------------------

--
-- Table structure for table `project_supervisors`
--

CREATE TABLE `project_supervisors` (
  `id` int(11) NOT NULL,
  `Project_Supervisors` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_supervisors`
--

INSERT INTO `project_supervisors` (`id`, `Project_Supervisors`) VALUES
(1, '🌺 د/ نسيبة المقطري\r\n🎓 د/ محمد العريقي\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `u_name` varchar(50) NOT NULL,
  `u_address` varchar(70) NOT NULL,
  `u_password` varchar(255) NOT NULL,
  `u_email` varchar(100) NOT NULL,
  `u_phone` int(13) NOT NULL,
  `user_role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `u_name`, `u_address`, `u_password`, `u_email`, `u_phone`, `user_role`) VALUES
(8, '', '', '', '', 0, 'user'),
(10, 'احمد علي المتوكل', 'شارع هائل', '55', '202310101668@studkent.ust.edu.ye', 775052259, 'user'),
(12, 'محمج', 'شارع هائل', '55', '202310101668@sthudent.ust.edu.ye', 775052259, 'user'),
(14, 'احمد علي', 'شارع هائل', '55', 'ahmedali.2004.20042.2005@gmail.com', 77505225, 'user'),
(16, 'احمد علي المتوكل', 'شارع هائ', '5', '202310101668@student.ust.eu.ye', 775052259, 'user'),
(18, 'جوانا لبوجيه', 'شارع هائل', '206996', '202310101668@student.uujst.edu.ye', 77505225, 'user'),
(26, 'احمد علي المتوكل', 'شارع هائل', '$2y$10$KW13Lh2OYIRshBjPEjiXb.iZ4Pt2nn1HxVc246Vq1vRgPuOciwG86', '202310101668@student.ust.edu.ye', 775052259, 'admin'),
(27, 'احمد', 'ببيس', '$2y$10$WDrzVwJNahuQAYaqa9po6.9XDlfxyJOn05wLnssVNiG06UqhtJykC', 'ahmedali.2004.20042.004@gmail.com', 2147483647, 'admin'),
(29, 'Ahmed Ali', 'hayl street', '$2y$10$ackzvF/3iRSAsUx3CjiKSeCE5PrG9QIa7vclibx.2XjMVru3sC46m', 'ahmedali.2004.200042.004@gmail.com', 775052259, 'user'),
(31, 'Ahmed Ali', 'hayl street', '$2y$10$vTyAUzl8GrhtQtxND4BD8eMYq/6UxD6/YehCiISRRRKZTW/Sv7Nc2', 'ahmedali.2004.0200042.004@gmail.com', 775052259, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`about_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `developer_team`
--
ALTER TABLE `developer_team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_supervisors`
--
ALTER TABLE `project_supervisors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_email` (`u_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `about_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `developer_team`
--
ALTER TABLE `developer_team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project_supervisors`
--
ALTER TABLE `project_supervisors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
