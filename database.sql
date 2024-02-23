-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 22, 2024 at 06:18 AM
-- Server version: 11.3.1-MariaDB-log
-- PHP Version: 8.2.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(5) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `displayname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `email`, `password`, `avatar`, `displayname`) VALUES
(1, 'petergamez', 'chanakan.kea@gmail.com', '$2y$10$trwmKFzclW09ub8I3cxxfuygwxB783/fWShFLD6SNzv0idveCUxly', '/uploads/profile/1707631536.png', 'PeterGamez'),
(2, '7eleven', 'faq@7eleven.co.th', '$2y$10$6rm5vKCgzJ8YZk1pYX1Wo.8HMyTvCcsFtqR62flSxTBSjBWjBqQEW', '/uploads/profile/1707631637.jpg', '7-Eleven Thailand'),
(3, 'hostatom', 'sales@hostatom.com', '$2y$10$6rm5vKCgzJ8YZk1pYX1Wo.8HMyTvCcsFtqR62flSxTBSjBWjBqQEW', '/uploads/profile/1707631659.jpg', 'Hostatom'),
(4, 'kasetsart', 'admin@ku.th', '$2y$10$ngLkXp7cO84alXWgcPD42usRne96Y7KzGVK878mUl7Pt9xcYL6F.a', '/uploads/profile/1707644229.jpg', 'Kasetsart University');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(5) NOT NULL,
  `account_id` int(5) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `account_id`, `message`) VALUES
(1, 3, 'Web Hosting \r\nการันตีผู้ใช้กว่า 2 หมื่นราย\r\nราคาคุ้มค่า Support ระดับฮีโร่ 24/7 \r\nเลือก hostatom \r\n.\r\n.\r\n.\r\n.\r\n🛒ซื้อเลยที่ \r\nhttps://www.hostatom.com/web-hosting\r\n❤️โฮสอะตอม โฮสติ้งที่มืออาชีพไว้วางใจ ❤️\r\nหากมีคำถามหรือข้อสงสัยในการใช้งาน Web Hosting ไม่ว่าในจุดใด\r\nกรุณาอย่าลังเลที่จะติดต่อเรา\r\n📞 0-2107-3466\r\n💙 Facebook: https://www.facebook.com/hostatomdotcom\r\n❤️ YouTube: https://www.youtube.com/user/hostatom\r\n💚 Line: @hostatom'),
(2, 1, 'มอบตัวเป็น #DekDPU วันนี้ \r\nรับทุนการศึกษา 20,000 บาท \r\nฟรี! iPad Gen 10 ตั้งแต่ปี 1 มูลค่ารวม 38,000*.- \r\n🖱 https://bit.ly/3SoADYT ด่วน! #จำนวนจำกัด'),
(3, 1, 'ลดแรง แถมพี๊คคค❤️🔥 Galaxy Tab A9| A9+ รับฟรี Book Cover มูลค่า 1,390.- (ของแถมมีจำนวนจำกัด) ราคาเริ่มเพียง 6,990.-\r\nพร้อมรับสิทธิพิเศษ\r\n✔️รับส่วนลด 30% สำหรับแลกซื้อ Watch 6, Buds 2 pro, Buds 2, Buds FE และ 20% สำหรับแลกซื้อ Galaxy Watch4\r\nโปรโมชั่นวันที่ 8 ก.พ. 67 - 11 ก.พ. 67 เท่านั้น'),
(4, 1, 'มีเงิน 8 แสนบาท ซื้อรถเงินสดหรือโปะบ้านดี 🚗🏡💸'),
(6, 2, 'เซเว่นแจกอั่งเปา🧧 รับตรุษจีนให้กับชาว ALL member ค้าบบบ💙\r\nเพียงซื้อสินค้าครบ 100.- (ยกเว้นสินค้าที่ไม่ร่วมรายการ)✨\r\nรับคะแนน ALL Point เพิ่มไปเลย 99 คะแนน🥰\r\nช้อปเลย 📲>> https://7eleventh.page.link/bR5m\r\n📌เฉพาะวันนี้วันเดียวเท่านั้น\r\n📌จำกัด 1 สิทธื/สมาชิก ตลอดรายการ\r\n#ALLmember #รีวิวเซเว่น #แจกอั่งเปา #7ElevenTH #ตรุษจีน #มงคล'),
(7, 1, '🏮ซินเจียยู่อี่ ซินนี้ฮวดไช้ รับปีมังกร ร่ำรวยทันใจ ได้เงินได้ทองทันที 🙏พรนี้จะสมหวังแค่มา 💥เขย่าเซียมซีมหาเฮง \r\n.\r\n🧧แค่ส่งอั่งเปาหาเพื่อน ให้เพื่อนกดรับซอง พร้อมสะสมของมงคลให้ครบตามจำนวน แลกรับรางวัลได้ทันที แจกหนักรวมกว่า 7ล้านบาท เชียวน้า 👉https://tmn.app.link/PHB10FFB\r\n.\r\nยังไม่พอ Cap & Share หน้าที่ได้รับรางวัล  ได้ลุ้นเพิ่มอีก 10,000 บาททุกวัน  \r\n#ตรุษจีน #อั่งเปา #อั่งเปาทรูมันนี่'),
(8, 1, 'สัมผัสประสบการณ์การเช่าที่พักอาศัยในฐานะผู้เช่าหรือเจ้าของที่ดินเมื่อคุณซื้อชุดเสริมสําหรับ The Sims™ 4'),
(9, 3, '🧧 เทศกาลตรุษจีน 2024 มาถึงแล้ว 🎊\r\nร่ำรวยเงินทอง 💵💎🪙 สุขภาพแข็งแรงนะคะ 💪\r\n-----------------------------------------------------\r\n❤️โฮสอะตอม โฮสติ้งที่มืออาชีพไว้วางใจ ❤️\r\n📞 0-2107-3466\r\n💙 Facebook: https://www.facebook.com/hostatomdotcom\r\n❤️ YouTube: https://www.youtube.com/user/hostatom\r\n💚 Line: @hostatom'),
(10, 2, '#วาเลนไทน์ ปีนี้ 7-Eleven มีอะไรจะบอก😘…ก็บอก “โปรเลิฟ บอกรัก”🤟❤️ ไงคร้าบบ มอบให้เลยส่วนลดพิเศษ🔖 สินค้าทานเล่นฟินๆ กรุบกริบหัวใจ ใครชอบชิ้นไหน 🛒กดสั่ง7Delivery เลยย\r\n🏃รีบพุ่งตัวไปเลยที่ 7-Eleven\r\n🛵สั่งผ่าน 7DELIVERY\r\n>> https://7eleventh.page.link/h6HA\r\n#7ElevenTH #ALLmember #โปรเลิฟบอกรัก'),
(11, 2, '“ชาแอปเปิ้ล” 🍎🍹เติมความสดชื่นให้ร่างกาย ด้วยรสชาติ  หวานอมเปรี้ยว พร้อมกลิ่นหอมแอปเปิ้ล อันเป็นเอกลักษณ์ ผสานเข้ากับชาเขียวคุณภาพ🌱  มีวิตามินซีสูง💪🏽\r\n🛵สั่งผ่าน 7DELIVERY กดเลย > https://7eleventh.page.link/eCi4\r\n🔥Size M ราคาเพียง 20 บาท หาซื้อได้แล้วที่ 7-Eleven นะครับ\r\n#อิ่มได้24ชั่วโมง #ของใหม่เซเว่น #ซื้อง่ายใกล้บ้าน #รีวิวเซเว่น #7ElevenThailand #ชาแอปเปิ้ล'),
(15, 2, 'มัดรวมโปรสินค้ามัดใจเธอ✨ กับ เมนูหวานๆของคนอินเลิฟฟฟฟฟฟฟฟ\r\nสะดวกสบาย สั่งผ่าน 7DELIVERY ก็ได้นะครับ คลิก📲 >\r\nhttps://www.7eleven.mobi/navPage/SE003...\r\nพิเศษสำหรับชาว ALL member เมื่อซื้อสินค้าที่ร่วมรายการรับคะแนนเพิ่ม 100 คะแนน\r\n📍ตั้งแต่วันนี้ - 23 ก.พ. 2567 เฉพาะที่เซเว่นเท่านั้นนะ\r\n#7ElevenThailand #รีวิวเซเว่น #ALLmember #โปรอภิมหาเฮง  #สินค้าราคาพิเศษ #เริ่ม24จบ23 #วาเลนไทน์ #Valentine'),
(16, 4, 'มหาวิทยาลัยเกษตรศาสตร์\r\nคณะกรรมการจัดงานเกษตรแฟร์ ประจำปี 2567\r\nขอขอบคุณทุกภาคส่วนที่ร่วมกันจัดงานเกษตรแฟร์ \r\nได้รับผลสำเร็จและบรรลุวัตถุประสงค์อย่างดียิ่ง\r\n10 กุมภาพันธ์ 2567\r\n#เกษตรแฟร์2567 #kasetfair #kasetsart #เกษตรศาสตรฺ์'),
(17, 4, 'มหาวิทยาลัยเกษตรศาสตร์ ต้นแบบพื้นที่เศรษฐกิจสีเขียว | นครฮีลใจ\r\nมหาวิทยาลัยเกษตรศาสตร์ บางเขน เป็นมหาวิทยาลัยที่ได้รับการจัดอันดับให้เป็นสถาบันการศึกษาสีเขียวที่เป็นมิตรกับสิ่งแวดล้อม ติด Top 50 มหาวิทยาลัยสีเขียวโลก มหาวิทยาลัยเกษตรศาสตร์ ได้มีการจัดโครงการวิทยาเขตสีเขียว KU Green Campus ภายใต้วิทยาเขตสีเขียวแห่งนี้มีโครงการที่อนุรักษ์ และแก้ไขปัญหาสิ่งแวดล้อม และพลังงานในระดับชุมชนมากมาย เพื่อเป็นต้นแบบแก่สถาบันการศึกษา และชุมชนต่าง ๆ ทั่วประเทศ ในการส่งเสริมคุณภาพชีวิตของนิสิต บุคลากร ที่อยู่ในเกษตรกลางบางเขน\r\nhttps://youtu.be/D_JP2nq2NYo?si=5KywJbAzdKLyobGR\r\nขอขอบคุณ\r\nThai PBS เป็นสื่อกระจายเสียงและแพร่ภาพสาธารณะของไทย'),
(19, 2, 'Kiss จะบอกรัก ต้อง KitKat 🩷🍫\r\n🛵อร่อยได้แล้ววันนี้ที่ 7-Eleven หรือสั่งผ่าน 7DELIVERY กด Link ใต้ภาพ\r\n#อิ่มได้24ชั่วโมง #ของใหม่เซเว่น #ซื้อง่ายใกล้บ้าน #ช็อกโกแลต #วาเลนไทน์');

-- --------------------------------------------------------

--
-- Table structure for table `post_comment`
--

CREATE TABLE `post_comment` (
  `id` int(5) NOT NULL,
  `post_id` int(5) NOT NULL,
  `account_id` int(5) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_image`
--

CREATE TABLE `post_image` (
  `id` int(5) NOT NULL,
  `post_id` int(5) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_image`
--

INSERT INTO `post_image` (`id`, `post_id`, `image`) VALUES
(1, 1, '/uploads/post/17075753890.jpg'),
(2, 2, '/uploads/post/17075754140.jpg'),
(3, 3, '/uploads/post/17075756600.jpg'),
(4, 4, '/uploads/post/17075756810.jpg'),
(7, 6, '/uploads/post/17075758440.jpg'),
(8, 7, '/uploads/post/17075759190.jpg'),
(9, 8, '/uploads/post/17075759510.jpg'),
(10, 9, '/uploads/post/17075766260.jpg'),
(11, 10, '/uploads/post/17076421110.jpg'),
(12, 10, '/uploads/post/17076421111.jpg'),
(13, 11, '/uploads/post/17076438560.jpg'),
(20, 15, '/uploads/post/17076440500.jpg'),
(21, 15, '/uploads/post/17076440501.jpg'),
(22, 16, '/uploads/post/17076442470.jpg'),
(23, 19, '/uploads/post/17076606470.jpg'),
(24, 19, '/uploads/post/17076606471.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_comment`
--
ALTER TABLE `post_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_image`
--
ALTER TABLE `post_image`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `post_comment`
--
ALTER TABLE `post_comment`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `post_image`
--
ALTER TABLE `post_image`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
