-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 26, 2025 at 04:13 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `website_cloudvps`
--

-- --------------------------------------------------------

--
-- Table structure for table `addon_vps`
--

CREATE TABLE `addon_vps` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `type_addon` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `detail` longtext CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `price` longtext CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `created_at` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `updated_at` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `site` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `addon_vps`
--

INSERT INTO `addon_vps` (`id`, `product_id`, `name`, `type_addon`, `detail`, `price`, `created_at`, `updated_at`, `site`) VALUES
(9, 2, 'Addon CPU', 'addon_cpu', '{\"product_id\":2,\"name\":\"Addon CPU\",\"cpu\":1,\"ram\":0,\"disk\":0,\"type_addon\":\"addon_cpu\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Th\\u00e1ng\",\"amount\":35000},\"twomonthly\":{\"billing_cycle\":\"2 Th\\u00e1ng\",\"amount\":70000},\"quarterly\":{\"billing_cycle\":\"3 Th\\u00e1ng\",\"amount\":90000},\"semi_annually\":{\"billing_cycle\":\"6 Th\\u00e1ng\",\"amount\":180000},\"annually\":{\"billing_cycle\":\"1 N\\u0103m\",\"amount\":360000},\"biennially\":{\"billing_cycle\":\"2 N\\u0103m\",\"amount\":720000},\"triennially\":{\"billing_cycle\":\"3 N\\u0103m\",\"amount\":1080000}}}', '{\"product_id\":2,\"name\":\"Addon CPU\",\"cpu\":1,\"ram\":0,\"disk\":0,\"type_addon\":\"addon_cpu\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Th\\u00e1ng\",\"amount\":35000},\"twomonthly\":{\"billing_cycle\":\"2 Th\\u00e1ng\",\"amount\":70000},\"quarterly\":{\"billing_cycle\":\"3 Th\\u00e1ng\",\"amount\":90000},\"semi_annually\":{\"billing_cycle\":\"6 Th\\u00e1ng\",\"amount\":180000},\"annually\":{\"billing_cycle\":\"1 N\\u0103m\",\"amount\":360000},\"biennially\":{\"billing_cycle\":\"2 N\\u0103m\",\"amount\":720000},\"triennially\":{\"billing_cycle\":\"3 N\\u0103m\",\"amount\":1080000}}}', '1762704305', '1762704305', 'VNCLOUD'),
(10, 3, 'Addon Ram', 'addon_ram', '{\"product_id\":3,\"name\":\"Addon Ram\",\"cpu\":0,\"ram\":1,\"disk\":0,\"type_addon\":\"addon_ram\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Th\\u00e1ng\",\"amount\":20000},\"twomonthly\":{\"billing_cycle\":\"2 Th\\u00e1ng\",\"amount\":40000},\"quarterly\":{\"billing_cycle\":\"3 Th\\u00e1ng\",\"amount\":60000},\"semi_annually\":{\"billing_cycle\":\"6 Th\\u00e1ng\",\"amount\":120000},\"annually\":{\"billing_cycle\":\"1 N\\u0103m\",\"amount\":240000},\"biennially\":{\"billing_cycle\":\"2 N\\u0103m\",\"amount\":480000},\"triennially\":{\"billing_cycle\":\"3 N\\u0103m\",\"amount\":720000}}}', '{\"product_id\":3,\"name\":\"Addon Ram\",\"cpu\":0,\"ram\":1,\"disk\":0,\"type_addon\":\"addon_ram\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Th\\u00e1ng\",\"amount\":20000},\"twomonthly\":{\"billing_cycle\":\"2 Th\\u00e1ng\",\"amount\":40000},\"quarterly\":{\"billing_cycle\":\"3 Th\\u00e1ng\",\"amount\":60000},\"semi_annually\":{\"billing_cycle\":\"6 Th\\u00e1ng\",\"amount\":120000},\"annually\":{\"billing_cycle\":\"1 N\\u0103m\",\"amount\":240000},\"biennially\":{\"billing_cycle\":\"2 N\\u0103m\",\"amount\":480000},\"triennially\":{\"billing_cycle\":\"3 N\\u0103m\",\"amount\":720000}}}', '1762704305', '1762704305', 'VNCLOUD'),
(11, 4, 'Addon DISK', 'addon_disk', '{\"product_id\":4,\"name\":\"Addon DISK\",\"cpu\":0,\"ram\":0,\"disk\":10,\"type_addon\":\"addon_disk\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Th\\u00e1ng\",\"amount\":12000},\"twomonthly\":{\"billing_cycle\":\"2 Th\\u00e1ng\",\"amount\":24000},\"quarterly\":{\"billing_cycle\":\"3 Th\\u00e1ng\",\"amount\":36000},\"semi_annually\":{\"billing_cycle\":\"6 Th\\u00e1ng\",\"amount\":72000},\"annually\":{\"billing_cycle\":\"1 N\\u0103m\",\"amount\":140000},\"biennially\":{\"billing_cycle\":\"2 N\\u0103m\",\"amount\":288000},\"triennially\":{\"billing_cycle\":\"3 N\\u0103m\",\"amount\":576000}}}', '{\"product_id\":4,\"name\":\"Addon DISK\",\"cpu\":0,\"ram\":0,\"disk\":10,\"type_addon\":\"addon_disk\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Th\\u00e1ng\",\"amount\":12000},\"twomonthly\":{\"billing_cycle\":\"2 Th\\u00e1ng\",\"amount\":24000},\"quarterly\":{\"billing_cycle\":\"3 Th\\u00e1ng\",\"amount\":36000},\"semi_annually\":{\"billing_cycle\":\"6 Th\\u00e1ng\",\"amount\":72000},\"annually\":{\"billing_cycle\":\"1 N\\u0103m\",\"amount\":140000},\"biennially\":{\"billing_cycle\":\"2 N\\u0103m\",\"amount\":288000},\"triennially\":{\"billing_cycle\":\"3 N\\u0103m\",\"amount\":576000}}}', '1762704305', '1762704305', 'VNCLOUD');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int NOT NULL,
  `bank` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `accountNumber` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `accountName` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `status` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `bank`, `accountNumber`, `accountName`, `status`) VALUES
(1, 'MBBank', '220620045555', 'Nguyễn Trung Chính', 'on'),
(2, 'VieTinbank', '104873744089', 'Nguyễn Trí Dũng', 'on');

-- --------------------------------------------------------

--
-- Table structure for table `card_history`
--

CREATE TABLE `card_history` (
  `id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `telco` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `serial` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `code` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `request_id` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `status` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `time` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `card_history`
--

INSERT INTO `card_history` (`id`, `username`, `telco`, `amount`, `serial`, `code`, `request_id`, `status`, `time`) VALUES
(1, 'admin', 'mobifone', 20000, '10004783347811', '123456789012377', 'ymvWqBrJtzK410gdNFWsix', 'SUCCESS', '1763459406'),
(2, 'admin', 'viettel', 20000, '10004783347811', '123456789012345', 'ymvWqBrJtzK410gdNFWsix', 'PENDING', '1765210340'),
(3, 'user1', 'mobifone', 50000, '22345678901234', '234567890123456', 'abc123def456ghi789jkl', 'SUCCESS', '1765296740'),
(4, 'user2', 'vinaphone', 100000, '33456789012345', '345678901234567', 'mnop123qrst456uvwx789', 'FAILED', '1765123940'),
(5, 'vip1', 'viettel', 500000, '44567890123456', '456789012345678', 'yzab123cdef456ghij789', 'PENDING', '1765365140'),
(6, 'test1', 'vietnamobile', 10000, '55678901234567', '567890123456789', 'klmn123opqr456stuv789', 'SUCCESS', '1765339940'),
(7, 'user3', 'zing', 200000, '66789012345678', '678901234567890', 'wxyz123abcd456efgh789', 'PENDING', '1765296740'),
(8, 'admin', 'gate', 50000, '77890123456789', '789012345678901', 'ijkl123mnop456qrst789', 'SUCCESS', '1765210340'),
(9, 'user4', 'viettel', 100000, '88901234567890', '890123456789012', 'uvwx123yzab456cdef789', 'FAILED', '1765037540'),
(10, 'vip2', 'mobifone', 500000, '99012345678901', '901234567890123', 'ghij123klmn456opqr789', 'PENDING', '1765361540'),
(11, 'test2', 'vinaphone', 20000, '10123456789012', '012345678901234', 'stuv123wxyz456abcd789', 'SUCCESS', '1765354340'),
(12, 'user5', 'vietnamobile', 10000, '11234567890123', '123456789012345', 'efgh123ijkl456mnop789', 'PENDING', '1765123940'),
(13, 'admin', 'zing', 50000, '12345678901234', '234567890123456', 'qrst123uvwx456yzab789', 'SUCCESS', '1765296740'),
(14, 'user1', 'gate', 100000, '13456789012345', '345678901234567', 'cdef123ghij456klmn789', 'FAILED', '1765210340'),
(15, 'user2', 'viettel', 200000, '14567890123456', '456789012345678', 'opqr123stuv456wxyz789', 'PENDING', '1764951140'),
(16, 'vip1', 'mobifone', 500000, '15678901234567', '567890123456789', 'abcd123efgh456ijkl789', 'SUCCESS', '1765347140'),
(17, 'test1', 'vinaphone', 10000, '16789012345678', '678901234567890', 'mnop123qrst456uvwx789', 'PENDING', '1765296740'),
(18, 'user3', 'vietnamobile', 50000, '17890123456789', '789012345678901', 'yzab123cdef456ghij789', 'SUCCESS', '1765210340'),
(19, 'admin', 'zing', 100000, '18901234567890', '890123456789012', 'klmn123opqr456stuv789', 'FAILED', '1765123940'),
(20, 'user4', 'gate', 200000, '19012345678901', '901234567890123', 'wxyz123abcd456efgh789', 'PENDING', '1765037540'),
(21, 'vip2', 'viettel', 500000, '20123456789012', '012345678901234', 'ijkl123mnop456qrst789', 'SUCCESS', '1765361540'),
(22, 'user1', 'viettel', 50000, '21345678901234', '234567890123456', 'ymvWqBrJtzK410gdNFWsix', 'PENDING', '1765210340'),
(23, 'user2', 'mobifone', 100000, '22345678901235', '345678901234567', 'abc123def456ghi789jkl', 'SUCCESS', '1765296740'),
(24, 'user3', 'vinaphone', 200000, '23345678901236', '456789012345678', 'mnop123qrst456uvwx789', 'FAILED', '1765123940'),
(25, 'user4', 'vietnamobile', 500000, '24345678901237', '567890123456789', 'yzab123cdef456ghij789', 'PENDING', '1765365140'),
(26, 'user5', 'zing', 10000, '25345678901238', '678901234567890', 'klmn123opqr456stuv789', 'SUCCESS', '1765339940'),
(27, 'vip1', 'gate', 50000, '26345678901239', '789012345678901', 'wxyz123abcd456efgh789', 'PENDING', '1765296740'),
(28, 'vip2', 'viettel', 100000, '27345678901240', '890123456789012', 'ijkl123mnop456qrst789', 'SUCCESS', '1765210340'),
(29, 'test1', 'mobifone', 200000, '28345678901241', '901234567890123', 'stuv123wxyz456abcd789', 'FAILED', '1765037540'),
(30, 'test2', 'vinaphone', 500000, '29345678901242', '012345678901234', 'efgh123ijkl456mnop789', 'PENDING', '1765361540'),
(31, 'admin', 'vietnamobile', 10000, '30345678901243', '123456789012345', 'qrst123uvwx456yzab789', 'SUCCESS', '1765354340');

-- --------------------------------------------------------

--
-- Table structure for table `chat_logs`
--

CREATE TABLE `chat_logs` (
  `id` int NOT NULL,
  `conversation_id` varchar(50) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `sender` enum('user','bot','system') COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `order_id` int DEFAULT NULL,
  `is_converted` tinyint(1) DEFAULT '0',
  `created_at` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `chat_logs`
--

INSERT INTO `chat_logs` (`id`, `conversation_id`, `username`, `sender`, `message`, `order_id`, `is_converted`, `created_at`) VALUES
(1, 'conv_001', 'hoangnam', 'user', 'Chào bạn, mình cần thuê cloud cho 3 website, tầm 50k lượt truy cập/tháng.', NULL, 0, NULL),
(2, 'conv_001', 'hoangnam', 'bot', 'Dạ anh cho em hỏi thêm, mình cần khoảng bao nhiêu GB lưu trữ ạ?', NULL, 0, NULL),
(3, 'conv_001', 'hoangnam', 'user', 'Khoảng 100GB, ngân sách dưới 700k/tháng.', NULL, 0, NULL),
(4, 'conv_001', 'hoangnam', 'bot', 'Em đề xuất gói Cloud Pro 4 CPU – 8GB RAM – 100GB SSD, giá 650.000đ/tháng ạ.', NULL, 0, NULL),
(5, 'conv_001', 'hoangnam', 'user', 'Ok đăng ký gói đó giúp mình.', NULL, 0, NULL),
(6, 'conv_001', 'hoangnam', 'bot', 'Em đã tạo đơn, anh bấm nút \"Mua ngay\" trong khung chat để thanh toán giúp em.', NULL, 0, NULL),
(7, '7ds8JfoBWR', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1763567650'),
(8, 'Q78pn4gws9', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1763567671'),
(9, 'Q78pn4gws9', 'admin', 'bot', 'Chào bạn! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ khách hàng chọn gói dịch vụ phù hợp nhất. Bạn có cần tư vấn về dịch vụ Cloud VPS hoặc Hosting không?', NULL, 0, '1763567671'),
(10, 'itnIaHNWJF', 'admin', 'user', 'tôi muốn ăn cút', NULL, 0, '1763567694'),
(11, 'itnIaHNWJF', 'admin', 'bot', 'Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ khách hàng chọn gói dịch vụ phù hợp nhất. Bạn có thể cho tôi biết rõ hơn về nhu cầu của bạn liên quan đến dịch vụ Cloud, VPS hoặc Hosting không? Bạn có cần biết về cấu hình như CPU, RAM hay Disk không?', NULL, 0, '1763567694'),
(12, 'JH7zWdkwCa', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1763568196'),
(13, 'JH7zWdkwCa', 'admin', 'bot', 'Chào bạn! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ bạn chọn gói dịch vụ Cloud VPS hoặc Hosting phù hợp nhất. Bạn có thể cho tôi biết nhu cầu của bạn không? Bạn cần sử dụng dịch vụ cho mục đích gì và yêu cầu về tài nguyên như thế nào?', NULL, 0, '1763568196'),
(14, 'JH7zWdkwCa', 'admin', 'user', 'tôi cần bạn giúp 1 chuyện', NULL, 0, '1763568208'),
(15, 'JH7zWdkwCa', 'admin', 'bot', 'Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ khách hàng chọn gói dịch vụ phù hợp nhất. Bạn cần giúp đỡ về dịch vụ Cloud VPS hay Hosting? Bạn có thể cho tôi biết mục đích sử dụng và yêu cầu cụ thể của bạn không?', NULL, 0, '1763568208'),
(16, 'JH7zWdkwCa', 'admin', 'user', 'bạn code được gì ko', NULL, 0, '1763568221'),
(17, 'JH7zWdkwCa', 'admin', 'bot', 'Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ khách hàng chọn gói dịch vụ phù hợp nhất. Bạn có cần hỗ trợ về Cloud VPS hoặc Hosting không? Hãy cho tôi biết nhu cầu của bạn để tôi có thể tư vấn một cách chính xác.', NULL, 0, '1763568221'),
(18, 'bwivO4Cspf', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1763568438'),
(19, 'bwivO4Cspf', 'admin', 'bot', 'Xin chào! Tôi rất vui được hỗ trợ bạn. Bạn đang tìm kiếm dịch vụ Cloud VPS hay Hosting? Hãy cho tôi biết nhu cầu của bạn để tôi có thể tư vấn gói dịch vụ phù hợp nhất!', NULL, 0, '1763568438'),
(20, 'bwivO4Cspf', 'admin', 'user', 'bên mình có gói host nào', NULL, 0, '1763568456'),
(21, 'bwivO4Cspf', 'admin', 'bot', 'Bạn có nhu cầu về gói hosting như thế nào? Dưới đây là một gói hosting mà chúng tôi cung cấp:<br />\n<br />\n- **Gói VN_01**<br />\n  - Dung lượng: 1.000 MB<br />\n  - Giá: 8.000 VNĐ<br />\n<br />\nBạn có thể cho tôi biết thêm thông tin như dự kiến sử dụng cho trang web gì? Có bao nhiêu lưu lượng truy cập mỗi ngày không? Từ đó tôi có thể tư vấn tốt hơn cho bạn.', NULL, 0, '1763568456'),
(22, '4fBcRJ7Wp1', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1763568533'),
(23, '4fBcRJ7Wp1', 'admin', 'bot', 'Chào bạn! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ khách hàng chọn gói dịch vụ phù hợp nhất. Bạn có cần tư vấn về Cloud VPS hoặc Hosting không?', NULL, 0, '1763568533'),
(24, '4fBcRJ7Wp1', 'admin', 'user', 'bên mình có gói vps nào', NULL, 0, '1763568563'),
(25, '4fBcRJ7Wp1', 'admin', 'bot', 'Bạn đang tìm kiếm gói VPS cho mục đích gì? Bạn cần thông số kỹ thuật như CPU, RAM và dung lượng disk ra sao? Hay bạn có ngân sách cụ thể cho gói dịch vụ này? Những thông tin đó sẽ giúp tôi tư vấn gói dịch vụ phù hợp nhất cho bạn.', NULL, 0, '1763568563'),
(26, '6HEeWSQ8ih', 'admin', 'user', 'aMrxPduWy1MP6ZsO4ufzYxCVDOVlt+SCgiPv+B1FZwGQvMN+Ekhrx03BmjVjAxyLh/H2m57mHJooz6Qd+SzOa2rVQ3b0hhboq4rZtTLNP0FsT4vvSZsMac3+wgJiOb+UmFriGecPGlh2lI/EgVs9o8U+2pDxxglQGnfAzhOgGy+H3qxPtW4L7AURpTTgHMF96ndTMHqmJwPE7HelQnpB8DnBj1yRq0/YjRAFYR8P3YDnFDW9dDWhcWx0E4fD5rHfWaBe0r9VhCdfComaLYsdzSrL/3MrXdXAqpyJP6Ht6wgzQRD+AZ23G7mCxHCTcZdwvhR5ttmLJa5D/q8x8JFCIw==', NULL, 0, '1763568652'),
(27, '6HEeWSQ8ih', 'admin', 'bot', '', NULL, 0, '1763568652'),
(28, '1ByCJhKIwb', 'admin', 'user', 'P/qi6nlk4WDrLhFLm/516v36A9J+S1Z74jze+SXxpmWVgKhJEHgKNZHco3wWs4LAELOIx8tKR/C5rwfMxUoR1IuqVh/9GgZylmcD/j/5UYfpPJx2PnfubHEEOI2SBWDAhSiljAiwHa7eyl2Oq7dF7rLtS1x2T+wwbGaovG1keRaDXh6C+Jw4nEmpQYrgdIm8My7nH9A64Kmm47WGTzAfiyyItYCf5p9DCZDo0C5UAqEuIlRdkjdSpITuzHesEkC7r42EYmGcX95qPnHFjr9Wurkx8tiFcRctAjEouBusK2Qf2/cjpi1bqB52Otie40zei1Xramt3xkj8FVIRs1/Shg==', NULL, 0, '1763568672'),
(29, '1ByCJhKIwb', 'admin', 'bot', 'U6FGuYEKOR2ESr02+RxuzXV2cXxGLMGvm3oEm/uirViSRT9DLpYa/Vf9rKW6gb5XWObaKznBZFYCwbitdpKpgKZMH3XSeQt5FmMCy1PN5/uJMqBKN9MvEIsD2tgiA2/83tfVaucBymiP402TK0e6PNGZ1FrtwZTJhtm1mzH9kaM4FRHcGTf8mdi0xhlKZuZw7PfIvkbKdGGzh++m/2ZlSz6i7XTL9BWZf82ys/is/HDEQfRd6vMLHSsmK+sHfQmb5upTfsRiuFod132zBunZMrpNWL8kJGP+hT/nlUw/ai98n27yvAgizNhIgp3kFVyDiKhPwAkCi5uOvDHlxB8G+w==', NULL, 0, '1763568672'),
(30, 'ORgouliSWv', 'admin', 'user', 'eSP0Ouih9YFFSQz+MdSe8jyRFq1Z1NpPamRnf9zSSsC853LUyyTFe9FKIr2DldPVG9VfnQGdmSdGkcpXEwNzxZmYWfyFJKosi/XgP8Zn1We6/nuRSd4oY6JHgiGdRNrxroJ72bdLdJq3kqY2MCM19tqfSLCt1Oongka7cIGxv225LClIJE/q0LZzAqkIUAr9PoFysGXSgT53qf2kVwZSunju703KpYgEOtVw/k9RjcqfRVoV6HTjQLqqLnQSRx1kCBUhvf9fv0xneXNfm5eoI5thya3C5H2RCvk+uAUzdnIzC6lBiUXD6fn7arUNs6fIQuJtfYCOOtKeGC4NU5g4Xg==', NULL, 0, '1763599721'),
(31, 'ORgouliSWv', 'admin', 'bot', 'ejK+USamG0GtPYt0yEDJ0AwdP+JNugBSzZ7HZSoJ46cHrVC9b13kmmO8WgmRgWWFJNbhKWtv1p8K6a/g0aH4YEfEwBgyaoDfK7SiIHSV7R5IUWYcRwuJKvtylovPW9lfA2NTe6f8rvu7RJ3wjLfeCLLNfjy7Icd1jFHgOqUAT5fqnykkr+3GcRf0eokUuSgDaOWK8YeMWRFbqa/XS2d5qLPINwbGPzglGsPJoENrdGsj78fxJVKD4uIqGA/UtR5x0HOJ7eASmbdxaNHNCSrJIIXdisjY9qzfVuXnXie70YaQrClOWWxweLHhUdKgHSSGFCtzcYDMgnCtthOXPxWqzg==', NULL, 0, '1763599721'),
(32, 'ORgouliSWv', 'admin', 'user', 'L5WMPha8O1z91q6loskmk1PAd6qwyttS3/dGYLJ0wiHrzJntm4bOpK5BvOm5kMYnQk5+FGxGgQtWIg+QEZX9CxD/D2qAFF1C2UggZc9wLVbgfkfqiIDvCgnzwVcc48fesEoLJFDsgavKvdH+j2B7bEHG2uvWN93FSO5fv25VltLwRNiRYQVL5vXllLsziOfZLxPVG3ftfBaA5GuO6hdCQapaFw3mOcwSgHC4zp7aOT8LBmG4VSC6fI2GDH02QuEMWAspxgtxu6u3zcqz7SCtf79+ff+hEH876lR3roJqUL95hG/OzLzFz+hsLLEAiRKVMu3lb4ewDbHkh75fArUh9Q==', NULL, 0, '1763599738'),
(33, 'ORgouliSWv', 'admin', 'bot', '', NULL, 0, '1763599738'),
(34, 'ORgouliSWv', 'admin', 'user', 'rtuUrJ+5VgSBPOgRl1uqSpnUEH7EMWn1mXNEk0HDbRvZldR3ZrKDhKY4Ccp6isofSb56v+6qnPpS+FmSxty8epGe4L5/ZPI/PsGgSevZo7cmo3fnuIJOz2bp+hhBfdEymQLdZ1OBESqkwHL73is3qbvA4k23jh0hvJQc9HESUJm2F2R8MXg5TVC6zoJO/mgQdRjnVHqIXgxhwFx+tuT0oalu2d0pCyckHbkpFJDGpPiuBFrN/BECnWnebHhtQiMnhmSByFKsaD+/SLEngffOG8dZAwGpKdxrj4sE7s4pQjLKpZIdUjEb8YEGNpXtQ5pGacZpXHhsiBHzzkMnitgQog==', NULL, 0, '1763599751'),
(35, 'ORgouliSWv', 'admin', 'bot', '', NULL, 0, '1763599751'),
(36, 'ORgouliSWv', 'admin', 'user', 'B1AIu1Xn+p6dPtFXUokhWYrYJY2cjePziFndkzdfbkorf1ZhOGhBWjvZqrttO0+hRmPNGeSg05EmsZ08qamDPCKQEq8CehOYMvgEIqubLu+yP/MFffvRKR+AVOh5wVKyOH3xgLYrouc/s5r69R81dP49CkXB/toKMNha6eMkUI5Bl6lvljfh6G/rU+8wXc+WMcsN20jBIy4prpdrPGN45CXIu+nOe7eaamTJILiNmhOBn/KI0/z5JlJvNGWHiM6pT8Xvnh+4zOU1lwr19ET96APWBjnLhagVriA31Qlo7RHfC8WFof+yAOoraN74qHIhhypCwftXKzreDxjJmGNBwQ==', NULL, 0, '1763599769'),
(37, 'ORgouliSWv', 'admin', 'bot', '', NULL, 0, '1763599769'),
(38, 'JjQuIz9CpJ', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1763599822'),
(39, 'JjQuIz9CpJ', 'admin', 'bot', 'Chào bạn! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ khách hàng chọn gói dịch vụ phù hợp nhất. Bạn đang tìm kiếm dịch vụ Cloud VPS hay Hosting? Hãy cho tôi biết nhu cầu của bạn!', NULL, 0, '1763599822'),
(40, 'JjQuIz9CpJ', 'admin', 'user', 'tôi cần mua gói hosting cho cộng đồng sex gay', NULL, 0, '1763599862'),
(41, 'JjQuIz9CpJ', 'admin', 'bot', 'Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ khách hàng chọn gói dịch vụ phù hợp nhất. Để giúp bạn lựa chọn gói hosting thích hợp, tôi cần hỏi thêm một số câu hỏi:\n\n1. Dự kiến lượng truy cập hàng tháng cho website của bạn là bao nhiêu?\n2. Bạn cần dung lượng lưu trữ cho các tệp tin và nội dung là bao nhiêu?\n3. Bạn có cần sử dụng các tính năng đặc biệt nào không, ví dụ như hỗ trợ SSL hay email?\n\nSau khi có thêm thông tin, tôi sẽ giúp bạn tìm ra gói hosting phù hợp nhất.', NULL, 0, '1763599862'),
(42, '3ghsudc6J7', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1764054194'),
(43, '3ghsudc6J7', 'admin', 'bot', 'Chào bạn! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ khách hàng chọn gói dịch vụ phù hợp nhất. Bạn cần tư vấn về dịch vụ Cloud VPS hay Hosting? Hãy cho tôi biết nhu cầu của bạn để tôi có thể giúp đỡ tốt hơn!', NULL, 0, '1764054194'),
(44, 'K2CCvimnkN', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1764056756'),
(45, 'K2CCvimnkN', 'admin', 'bot', 'Chào bạn! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ bạn chọn gói dịch vụ Cloud VPS hoặc Hosting phù hợp nhất. Bạn có thể cho tôi biết về nhu cầu của bạn không?', NULL, 0, '1764056756'),
(46, '9tljWFE8Kb', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1764056764'),
(47, '9tljWFE8Kb', 'admin', 'bot', 'Chào bạn! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ khách hàng chọn gói dịch vụ phù hợp nhất. Bạn có cần tư vấn về Cloud VPS hoặc Hosting không? Nếu có, xin vui lòng cho tôi biết nhu cầu của bạn.', NULL, 0, '1764056764'),
(48, 'ag6EhROJ3k', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1764056767'),
(49, 'ag6EhROJ3k', 'admin', 'bot', 'Chào bạn! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ khách hàng chọn gói dịch vụ phù hợp nhất. Bạn có thể cho tôi biết nhu cầu của bạn về Cloud VPS hoặc Hosting để tôi có thể tư vấn tốt hơn không?', NULL, 0, '1764056767'),
(50, 'rgpjHxC8QI', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1764058836'),
(51, 'rgpjHxC8QI', 'admin', 'bot', 'Chào bạn! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ bạn chọn gói dịch vụ Cloud VPS hoặc Hosting phù hợp nhất với nhu cầu của bạn. Bạn có thể cho tôi biết về yêu cầu của mình không?', NULL, 0, '1764058836'),
(52, '8zxlrSi1EQ', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1764809580'),
(53, '8zxlrSi1EQ', 'admin', 'bot', 'Chào bạn! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ bạn chọn gói dịch vụ Cloud VPS hoặc Hosting phù hợp nhất. Bạn cần tư vấn về dịch vụ nào?', NULL, 0, '1764809580'),
(54, 'oBJz71qvsk', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1764811228'),
(55, 'oBJz71qvsk', 'admin', 'bot', 'Xin chào! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ bạn chọn gói dịch vụ Cloud VPS hoặc Hosting phù hợp nhất với nhu cầu của bạn. Bạn có thể cho tôi biết một chút về yêu cầu của bạn không? Ví dụ, bạn cần sức mạnh CPU/RAM như thế nào, và dung lượng lưu trữ bạn muốn là bao nhiêu?', NULL, 0, '1764811228'),
(56, 'oBJz71qvsk', 'admin', 'user', 'tôi cần tư vấn dịch vụ vps', NULL, 0, '1764811244'),
(57, 'oBJz71qvsk', 'admin', 'bot', 'Tốt, tôi có thể giúp bạn với dịch vụ VPS. Để hiểu rõ hơn về nhu cầu của bạn, bạn có thể cho tôi biết:\n\n1. Bạn dự định sử dụng VPS cho mục đích gì? (Ví dụ: website, ứng dụng, lưu trữ dữ liệu...).\n2. Bạn có yêu cầu cụ thể nào về CPU, RAM hoặc dung lượng ổ đĩa không?\n3. Ngân sách của bạn cho dịch vụ VPS là bao nhiêu?\n\nThông tin này sẽ giúp tôi tư vấn gói dịch vụ phù hợp nhất cho bạn.', NULL, 0, '1764811244'),
(58, 'oBJz71qvsk', 'admin', 'user', 'websize bán hàng cá nhân', NULL, 0, '1764811270'),
(59, 'oBJz71qvsk', 'admin', 'bot', 'Để tư vấn gói dịch vụ phù hợp cho bạn, tôi cần một số thông tin thêm:\n\n1. Bạn dự định có bao nhiêu sản phẩm trên trang web bán hàng của mình?\n2. Bạn có dự kiến tăng trưởng trong tương lai không? Có nhiều người dùng truy cập vào trang web một lúc hay không?\n3. Bạn cần dung lượng lưu trữ lớn hay vừa đủ cho hình ảnh sản phẩm?\n\nDựa vào những thông tin này, tôi có thể giúp bạn chọn gói dịch vụ phù hợp nhất về Cloud VPS hoặc Hosting.', NULL, 0, '1764811270'),
(60, 'oBJz71qvsk', 'admin', 'user', 'số lượng nhỏ', NULL, 0, '1764811320'),
(61, 'oBJz71qvsk', 'admin', 'bot', 'Để tư vấn chính xác hơn về gói dịch vụ phù hợp với yêu cầu của bạn, tôi cần hỏi thêm một vài câu:\n\n1. Bạn cần sử dụng VPS hay Hosting cho mục đích gì? Ví dụ: lưu trữ website, ứng dụng, hay dịch vụ nào đó?\n2. Bạn có yêu cầu cụ thể nào về tài nguyên như CPU, RAM hay dung lượng đĩa không?\n3. Bạn dự kiến lưu trữ bao nhiêu dữ liệu và có số lượng người truy cập tối đa là bao nhiêu?\n\nNhững thông tin này sẽ giúp tôi chọn gói dịch vụ phù hợp nhất cho bạn.', NULL, 0, '1764811320'),
(62, 'oBJz71qvsk', 'admin', 'user', 'là website bán quần áo cá nhân', NULL, 0, '1764811340'),
(63, 'oBJz71qvsk', 'admin', 'bot', 'Cảm ơn bạn đã chia sẻ thông tin về website bán quần áo cá nhân. Để có thể tư vấn chính xác hơn về gói hosting hoặc Cloud VPS phù hợp với nhu cầu của bạn, tôi xin hỏi thêm vài câu:\n\n1. Dự kiến lưu lượng truy cập hàng ngày của website của bạn khoảng bao nhiêu?\n2. Bạn có cần sử dụng hệ thống quản lý nội dung (CMS) như WordPress hay không?\n3. Bạn có dự định lưu trữ nhiều hình ảnh hoặc video chất lượng cao trên website không?\n\nThông tin này sẽ giúp tôi phân tích và đề xuất gói dịch vụ tốt nhất cho bạn.', NULL, 0, '1764811340'),
(64, 'HlSkCsEqvW', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1764811896'),
(65, 'HlSkCsEqvW', 'admin', 'bot', 'Xin chào! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ bạn chọn gói dịch vụ Cloud VPS hoặc Hosting phù hợp nhất với nhu cầu của bạn. Bạn có thể cho tôi biết bạn đang tìm kiếm dịch vụ nào và yêu cầu cụ thể của bạn là gì không?', NULL, 0, '1764811896'),
(66, 'HlSkCsEqvW', 'admin', 'user', 'tôi cần làm 1 web bán quần áo', NULL, 0, '1764811984'),
(67, 'HlSkCsEqvW', 'admin', 'bot', 'Để giúp bạn chọn gói dịch vụ phù hợp cho website bán quần áo, tôi cần hiểu thêm về nhu cầu của bạn:\n\n1. Bạn dự định lưu trữ bao nhiêu sản phẩm trên website?\n2. Bạn dự kiến lượng truy cập hàng ngày vào web là bao nhiêu?\n3. Bạn có kế hoạch chạy các chương trình khuyến mãi hay quảng cáo nào không? \n\nVới thông tin này, tôi có thể đề xuất một gói dịch vụ tốt nhất cho bạn.', NULL, 0, '1764811984'),
(68, 'HlSkCsEqvW', 'admin', 'user', 'tầm 100 -200 cái áo khách hàng tầm 1000 đổ về ko có khuyến mãi', NULL, 0, '1764812005'),
(69, 'HlSkCsEqvW', 'admin', 'bot', 'Để giúp bạn chọn gói dịch vụ phù hợp, tôi xin hỏi bạn một số câu hỏi:\n\n1. Bạn dự định sử dụng VPS hoặc Hosting cho mục đích nào (ví dụ: website bán hàng, lưu trữ dữ liệu, hay phát triển ứng dụng)?\n2. Lượng truy cập dự kiến của bạn là bao nhiêu trong một tháng (số lượng người dùng truy cập website)?\n3. Bạn có cần hỗ trợ về mặt bảo mật và sao lưu dữ liệu không?\n\nNgoài ra, với thông tin mà bạn đã cung cấp, có vẻ như bạn cần một gói có khả năng xử lý tốt và có dung lượng lưu trữ đủ lớn để phục vụ cho việc kinh doanh của mình. \n\nNếu bạn cần một gói VPS, tôi khuyến nghị gói PLATIUM (4-4-40) với 4 CPU, 4GB RAM và 40GB dung lượng lưu trữ. Gói này sẽ giúp bạn xử lý lượng truy cập tốt với giá thành hợp lý (150.000 VNĐ).\n\n- **CPU:** 4 - Phù hợp với việc xử lý nhiều yêu cầu từ khách hàng.\n- **RAM:** 4GB - Giúp cải thiện tốc độ và hiệu suất trang web.\n- **Disk:** 40GB - Đủ không gian cho các tệp tin và dữ liệu liên quan đến áo mà bạn đang bán.\n\nBạn có thể tìm thấy gói dịch vụ tại đây: <a href=\'https://localhost/client/vps-order/16\' target=\'_blank\'>Mua ngay</a>. \n\nVui lòng cho tôi biết thêm thông tin để tôi có thể hỗ trợ bạn tốt hơn!', NULL, 0, '1764812005'),
(70, 't4sNyCeE0O', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1764812847'),
(71, 't4sNyCeE0O', 'admin', 'bot', 'Chào bạn! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ bạn trong việc chọn gói dịch vụ Cloud VPS/Hosting phù hợp nhất. Bạn cần tìm gói dịch vụ nào? Có thể cho tôi biết nhu cầu sử dụng của bạn không?', NULL, 0, '1764812847'),
(72, 'xQ6OyqnalJ', 'admin', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1764813118'),
(73, 'xQ6OyqnalJ', 'admin', 'bot', 'Chào bạn! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ bạn chọn gói dịch vụ Cloud VPS hoặc Hosting phù hợp nhất. Bạn có thể cho tôi biết nhu cầu của bạn không?', NULL, 0, '1764813118'),
(74, '3x7yJ9aNtz', '', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1765947450'),
(75, '3x7yJ9aNtz', '', 'bot', 'Xin chào! Rất vui được hỗ trợ bạn. Bạn đang tìm kiếm dịch vụ Cloud VPS hoặc Hosting cho nhu cầu nào? Hãy cho tôi biết thêm thông tin để tôi có thể tư vấn gói phù hợp nhất!', NULL, 0, '1765947450'),
(76, 'tFCWfEN8Hj', '', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1765947457'),
(77, 'tFCWfEN8Hj', '', 'bot', 'Chào bạn! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ khách hàng chọn gói dịch vụ phù hợp nhất. Bạn cần tư vấn về dịch vụ nào? Cloud VPS hay Hosting?', NULL, 0, '1765947457'),
(78, 'Wyjm6upxCr', '', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1765947460'),
(79, 'Wyjm6upxCr', '', 'bot', 'Chào bạn! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ bạn chọn gói dịch vụ phù hợp nhất. Bạn đang tìm kiếm dịch vụ Cloud, VPS hay Hosting? Hãy cho tôi biết nhu cầu của bạn để tôi có thể tư vấn tốt nhất!', NULL, 0, '1765947460'),
(80, 'Jth1rRdNWq', 'SharkDunggg', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1765950872'),
(81, 'Jth1rRdNWq', 'SharkDunggg', 'bot', 'Xin chào! Rất vui được hỗ trợ bạn. Bạn cần tư vấn về dịch vụ Cloud VPS hoặc Hosting nào không? Hãy cho tôi biết nhu cầu của bạn để tôi có thể giúp đỡ tốt nhất!', NULL, 0, '1765950872'),
(82, '3dIERgJvyC', '', 'user', 'Hãy gửi lời chào khách hàng', NULL, 0, '1765985976'),
(83, '3dIERgJvyC', '', 'bot', 'Xin chào! Tôi là trợ lý kỹ thuật của hệ thống APIIT, hỗ trợ khách hàng chọn gói dịch vụ phù hợp nhất. Bạn cần tư vấn về gói Cloud, VPS hoặc Hosting nào không?', NULL, 0, '1765985976');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `id` int NOT NULL,
  `code` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `amount` int NOT NULL,
  `used` int NOT NULL,
  `discount` int NOT NULL,
  `createdate` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `enddate` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `min` int NOT NULL,
  `max` int NOT NULL,
  `type` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`id`, `code`, `amount`, `used`, `discount`, `createdate`, `enddate`, `min`, `max`, `type`, `status`) VALUES
(1, 'nacnaoo', 10000, 0, 10, '1012012212', '1012012212', 10000, 200000, 'fixed', 'on'),
(2, 'chinhapi', 10, 0, 10, '1012012212', '1012012212', 10000, 200000, 'percent', 'off'),
(3, 'OLVRF97T', 1, 0, 0, '1765985400', '1766244600', 3, 5, 'fixed', 'on'),
(4, 'E7OEHSVR', 1, 0, 0, '1765985820', '1766158620', 3, 4, 'fixed', 'on');

-- --------------------------------------------------------

--
-- Table structure for table `history_buy_hosting`
--

CREATE TABLE `history_buy_hosting` (
  `id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `domain` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `pk_host` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `sv_host` int DEFAULT NULL,
  `money` int DEFAULT NULL,
  `total_money` int DEFAULT NULL,
  `account` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `password` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `creatAt` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `endAt` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `status` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `note` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `time` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `history_buy_hosting`
--

INSERT INTO `history_buy_hosting` (`id`, `username`, `domain`, `pk_host`, `sv_host`, `money`, `total_money`, `account`, `password`, `creatAt`, `endAt`, `status`, `note`, `time`) VALUES
(23, 'admin', 'chinhapi.gay', 'vn_01', 1, 0, 0, 'Ym/zWRa5Im5xXwNmlDze+QGmmCX9rdlZJgxnhNpuPOnhjG3Wr1FhCsgUK5mcPoPNnz7Xy3nr3wdATXuVVmOuyciKUXqPfCbdtGpo/FrpJQdTZ0NSCUzXutWVzhorVm3DzU1Ux9oILZzBXVnGBQ8cn1mEDrndcVkTIXTnXBdvIbFXogzHl8QtdP6RVKidTm4P/KWbAs8twfFe8i9pS4Dc5UHdvZ0TkV6xFoiUhOOtkuTkfViUiPR0iYfjbDHN8ChN8Dc14Wu6GA7LFp2GvRA8fEigMX83VeVSPC8OMjB/S0SA2PFnEEqfafoXWkZnk4u88TqcGSklOM3M1cD3eK5Iqg==', 'DUDWvqZhv+3GuHLNeqUDf8xKq/l/F9MkHoVuoeW+1OuAbc5WjyaOC/xnQQrLVPdGwkEvgMPg8ZkTgD6ByMCX0T6J18EKrejo85xymLVsEk49rl5IrDZG2y784IaBPEMVd5hFA3GyRV50mdjH1Q0hpJlgkDH3g61wbT+uP9qTZbp7LO5mnu7VmK2pG1QIfxyP9krC/WzcOr9S/CswBsMXed6GBUaUOXjjVX3Mm5kIgP0NVeLUFNNIffjVvRFpM2vcJYaWhSBewn0DPJG5OV6vMcu2HTEHaOxHZGNCrJmmFwH0QyT+CJJgAGjfiaLQS6fyR6HMcKKJC0NSvLtoKmwYOg==', '1764923065', '1770107065', 'hethan', 'Hoàn tất', '1764923065'),
(24, 'admin', 'chinhapi.com', 'vn_01', 1, 0, 0, 'RNcQ7asVGViTXWhuGIdBy6Pd1NBng/+bSWkyDx7WFB3sREH8xNWa2e5I3EiwLCRs/jAcoBNPc10v235DBIO98HSsaZxCrk6Gh6bUS1F66G5ZeOLfVMadXHuHCk3uVBbCpAPdnBuhthg7vxvZALBo0VXh8L3CxQ/rHfg1pJ5Os5RiLyr3SJ1vYuW4L5WzDRwGCh/CxbBcvnWY38FD6vzatgvTbLuOHD9xN6cgTmU86UIE76VT0jyTXQNsGitaSmhwcBMMs2HCyHgZ7u1NwAI5tL2qq/1beQVxi3ugFqNkU6m2+YvNR1VfZVtUhLhuq9nIlSOz+JlsLX2h+JK7oQ8HBA==', 'Ghf0ih/+y+hgu/txmLoySRg/YH+jAEyM/FThNmZODhJpB2Hbg7nruB6cQT6fsPjr2sQyJcbX7VzWIlpVlei6aPPhOzZUMiNC6RpI2nAIazD3KQ7VbeulHjH5NopWS3nxxAEotKNeNTyEpdS0o/zMXnlwBJWDE90dDMaUJhK1+pb8PA4OOvqZNz02qXrbtZO7rJo9ZJarq8e5IZm9oyb4OwqAuPtBtlYG90kBjzbD7b8mQnB5T0CcHq3eL1JEDXf8xBG8aovitU0vnThpPtIx35ZCDjo8q/x1ir2X+4XfD3E1I2GIxX8e0+57KC45U7DE+lbGiSIXSwosTlS+iU0vqQ==', '1764930402', '1767522402', 'delete_vps', 'Người dùng xóa', '1764930402'),
(25, 'SharkDunggg', 'dungbios.com', 'vn_02', 2, 75000, 75000, 'gQSAdf5+1Kpd749hOVX/o9y474XSwEoOC/k+FVR50JeSlVgGIkdE2eB1z32jJfgIP4BPtEpNs31E03V2S/p9LmM/b1kLS+1V0JhV3JXQdVbAwSQtmlVcnJ89sOv3g89WfuO9NviEr1OAE1n5RlBttHmnb404XXL/CAHXmpmaDngU6oeKv1szE3+nJcHXWI1nJ4a5OkdWldLKXQ1GLMBONwBiGsm5FBr8WPc/YTzGOCDstVqX+1P6MO3jOL7ZQuALkgR6PipLFw/iLrohdA3p7BYauaTVRaCaappYPNEqHBxVlkx2So69ov2tUN0pJEdcPQptpgk5jOqlLZSXiGRAoA==', 'XZa3X0rXYoY/yxhP5WJj+T8pkzWCXbYauvDNg9Di1BdmWkSfGk737YYEQOUJIWDAP6cMdh7H7BL9zIvbmVG0/VNxN6KBKaBXYxp+vVFGM0OCE4lrqoUu1jZcZBvvrM33agyKdrDB/bYWYTZsVTctNLC0MUHwgBFZzfof1dQs+IKQKL5LVWfqGZMdDpuhxjK3Si6IhcHlVfyLCa6EP6luWhuqei9hgGLrqmiVj6qDJ4C7qCdfqtR6PkggYALPEWakRsI/fV2778p8bnmWrdoff1BHHfKPYCjIo3sknTHEiQpNjgTNU2bHvrmBK4O1HrCLo2ZtzaKavMVl32zAMnXhrA==', '1765952743', '1768544743', 'progressing', 'progressing', '1765952743'),
(26, '20223155eauteduvn', 'dungbio2s.com', 'vn_02', 2, 75000, 75000, 'Cz4JKEgXb+Rg9R0ld/pTZFFtI0BUOy+qqtWE/g4L+XzC4F/UWVZmbV9F1cocg3T1sToJchlKf87wI6laffaq7UDboofMlpzQOiZ0y695YnBwjCu9TZw1LR88vnSayX/yo4ZFvzNxWYDithPSFR2e7lHqfzpZ/wahNSCySN3kP+RBs6sVeNypug/E//o7SC/GLldWvF48XV1dCS7xTAZTwrFJJqIJxD6D4GuBABvWD6MHJcLyxIhKX/kn0QrW4d6o1ZlUK+XSRntOzxlvtEalSOl+RbYrFo2UeM/A3eviyL5w2dQ7A+IqnlkhwzA45aqx0XgeCf4TidrJwv0RnjtbRA==', 'sF/zdZHQuNPLH4G8Rw/xEW4CH/yGcUen1DX18aV8GogqHADOgpVsdfGeyO7LyHmOHfawVBveJtiGJp9aqmR8328T+hyqo2WS5ySjKaAIq4yOI5wNEo6Ol6xAW09/AGZgU9HDuG7dyQGLU5j4zRPyI2zY50U6PhPqKq6NGRV4sUzNvL3lDE0m1OtIHeJypwyKzaqs0biXWVz1bnyDbeoNY63sNzT0qzPE/zQsNX6TEjo238k/jHxDDpaQahKXi8GD3SmXzkit7GUITIWiTer8ABacy0wE8ZOGWko7uEb3xwyU35Uk1h3wUYMyi00onZXZ1XIj4ucMABV2HOWgeSA47A==', '1766152566', '1768744566', 'progressing', 'progressing', '1766152566');

-- --------------------------------------------------------

--
-- Table structure for table `history_recharge`
--

CREATE TABLE `history_recharge` (
  `id` int NOT NULL,
  `transaction_id` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `type` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `title` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `money` int DEFAULT NULL,
  `status` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `time` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `history_recharge`
--

INSERT INTO `history_recharge` (`id`, `transaction_id`, `username`, `type`, `title`, `money`, `status`, `time`) VALUES
(1, 'mzznmvnzvka\r\n', 'admin', 'ACB', 'Nạp tiền auto', 10000, 'thanhcong', '10001231313');

-- --------------------------------------------------------

--
-- Table structure for table `his_login`
--

CREATE TABLE `his_login` (
  `id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `browser` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `device` varchar(100) CHARACTER SET utf32 COLLATE utf32_hungarian_ci DEFAULT NULL,
  `ip` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `time` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `his_login`
--

INSERT INTO `his_login` (`id`, `username`, `title`, `browser`, `device`, `ip`, `address`, `time`) VALUES
(1, 'xBgEWfwelC2Rsyjca6CWQWvntI39H5J8', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', NULL, '1761028917'),
(2, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', NULL, '1761028968'),
(3, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', NULL, '1761029027'),
(4, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1761030859'),
(5, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1761182101'),
(6, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1761209762'),
(7, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1761265114'),
(8, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1761352400'),
(9, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1761456767'),
(10, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1761529507'),
(11, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1761611109'),
(12, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1761698104'),
(13, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1761784321'),
(14, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1761819220'),
(15, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1761878374'),
(16, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1761957858'),
(17, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1762440172'),
(18, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1762474730'),
(19, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1762571246'),
(20, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1762675165'),
(21, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1762733523'),
(22, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1762828901'),
(23, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1762916924'),
(24, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1762921110'),
(25, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1762921566'),
(26, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1762921673'),
(27, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1762939524'),
(28, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1763005637'),
(29, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1763025830'),
(30, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1763079566'),
(31, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1763079587'),
(32, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1763454227'),
(33, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1763566635'),
(34, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1763599716'),
(35, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1764054069'),
(36, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1764809549'),
(37, 'admin', 'Đăng nhập hệ thống', 'Chrome', 'Mac OS X', '::1', '', '1764918470');

-- --------------------------------------------------------

--
-- Table structure for table `img_os`
--

CREATE TABLE `img_os` (
  `id` int NOT NULL,
  `id_os` int DEFAULT NULL,
  `os_name` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `image_url` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `created_at` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `updated_at` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `img_os`
--

INSERT INTO `img_os` (`id`, `id_os`, `os_name`, `image_url`, `created_at`, `updated_at`) VALUES
(17, 1, 'Windows Server 2012 R2AA', 'https://h2vps.com/modules/images/os/windows.png', '1762703904', '1765985911'),
(18, 2, 'Windows Server 2016', 'https://h2vps.com/modules/images/os/windows.png', '1762703904', '1762703904'),
(19, 3, 'Linux CentOS 7 64bit', 'https://h2vps.com/modules/images/os/centos.png', '1762703904', '1762703904'),
(20, 4, 'Windows Server 2019', 'https://h2vps.com/modules/images/os/windows.png', '1762703904', '1762703904'),
(21, 5, 'Windows 10 64bit', 'https://h2vps.com/modules/images/os/windows.png', '1762703904', '1762703904'),
(22, 6, 'Linux Ubuntu-20.04', 'https://h2vps.com/modules/images/os/ubuntu.png', '1762703904', '1762703904'),
(23, 7, 'Linux Ubuntu-22.04', 'https://h2vps.com/modules/images/os/ubuntu.png', '1762703904', '1762703904'),
(24, 9, 'AlmaLinux 8', 'https://h2vps.com/modules/images/os/almalinux.png', '1762703904', '1762703904'),
(25, 10, 'Debian 12', 'https://h2vps.com/modules/images/os/debian.png', '1762703904', '1762703904'),
(26, 11, 'Linux Ubuntu-24.04', 'https://h2vps.com/modules/images/os/ubuntu.png', '1762703904', '1762703904'),
(27, 14, 'aaPanel-Nginx', 'https://h2vps.com/modules/images/os/nginx.png', '1762703904', '1762703904'),
(28, 15, 'aaPanel-Apache', 'https://h2vps.com/modules/images/os/aapanel.png', '1762703904', '1762703904'),
(29, 16, 'aaPanel-Litespeed', 'https://h2vps.com/modules/images/os/aapanel.png', '1762703904', '1762703904'),
(30, 17, 'cPanel-full', 'https://h2vps.com/modules/images/os/cpanel.png', '1762703904', '1762703904'),
(31, 18, 'cPanel-Litespeed', 'https://h2vps.com/modules/images/os/litespeed.png', '1762703904', '1762703904');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `id_oder` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `title` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `time` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `username`, `id_oder`, `title`, `time`) VALUES
(1, 'admin', 'zefna', 'Đặt hàng VPS', '10123123132'),
(2, 'admin', 'zefnc', 'Đặt hàng VPS', '10123123132'),
(3, 'admin', 'gaJvw', 'Đặt hàng VPS', '1762705725'),
(4, 'admin', 'dkJH6', 'Đặt hàng VPS', '1762705853'),
(5, 'admin', 'KJ4w7', 'Đặt hàng Hosting', '1762748451'),
(6, 'admin', 'HJWrv', 'Đặt hàng Hosting', '1762748543'),
(7, 'admin', 'lNQqt', 'Đặt hàng Hosting', '1762749017'),
(8, 'admin', '0JBSW', 'Đặt hàng Hosting', '1762749378'),
(9, 'admin', 'Wh7Re', 'Đặt hàng VPS', '1762921122'),
(15, 'admin', 'rbpJJ', 'Đặt hàng Hosting', '1764921339'),
(16, 'admin', 'uiaeW', 'Đặt hàng Hosting', '1764922818'),
(19, 'admin', 'nWJHJ', 'Đặt hàng Hosting', '1764923065'),
(20, 'admin', 'QSkrO', 'Đặt hàng Hosting', '1764930402'),
(21, 'SharkDunggg', '9QRN5', 'Đặt hàng Hosting', '1765952743'),
(22, '20223155eauteduvn', 'sHmwj', 'Đặt hàng Hosting', '1766152566');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int NOT NULL,
  `key` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `value` longtext CHARACTER SET utf32 COLLATE utf32_vietnamese_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `key`, `value`) VALUES
(1, 'title', 'Cloudserver  – Cloud Server Chất Lượng...'),
(2, 'description', 'ChinhApi - Cung Cấp Dịch Vụ Mã Nguồn , VPS , Hosting'),
(3, 'keywords', 'chinhapi, hosting, vps, dedi, cloud, server, web, website, blog, news, tin tức, thông tin, thị trường, thị trường hosting, thị trường vps, thị trường dedi, thị trường cloud, thị trường server, thị trường web, thị trường blog, thị trường tin tức, thị trường thông tin, thị trường thị trường, thị trường thị trường hosting, thị trường thị trường vps, thị trường thị trường dedi, thị trường thị trường cloud, thị trường thị trường server, thị trường thị trường web, thị trường thị trường blog, thị trường thị trường tin tức, thị trường thị trường thông tin'),
(4, 'favicon', 'https://chinhapi.com/upload/setting/1756917218371.png'),
(5, 'banner', 'https://i.imgur.com/mdy0jww.png'),
(6, 'logo', 'https://chinhapi.com/upload/setting/1756917217984.png'),
(7, 'facebook', 'https://facebook.com/'),
(8, 'email_smtp', 'chinhapiit@gmail.com'),
(9, 'pass_email_smtp', 'xtzhvpaslyfkgiek'),
(10, 'api_username', 'chinhnt.k4@gmail.com'),
(11, 'api_app', 'ak1hdyD9pZUcF6FZJGPKtytd'),
(12, 'api_secret', 'yGi0o8RZn5oPMTNqd7rOxw3TeQ6mFWBVag9YBSWtfSBtdUxUc2cxtdG0iTLZg0Azz5TS5TNfamim2IKUKn6S2D5tkHL5P1tANr7kGyFT5I55bjdFlIbgJvkQoUJRcErn'),
(13, 'auth_token_vps', 'wVUpk7hJ0QLylWmXRQBTPjbmxfnLzNebXbrYZ2cs4doimqjPHzN5X4Byf4G6Jj1tb1uFDV997DIWdyUHX2zJ5hojtpsSeICCPqWARFjfRyM4wtj1RresQEm7Y1NAg7c4EQU6pbOoDfyDtubbSaXAByarGAHeJmyyQ7cClbH6nwq32qILPpAdlR6U2vTMHOwTspSUah9QhkgxtAdFRvfWsJDpwgcOj4k1cHLbs356YFKYIrQVZPlPqQLFHO'),
(14, 'site_name', 'ChinhApi\r\n'),
(15, 'partner_id_card', '17847400787'),
(16, 'partner_key_card', 'ccb82ec583a8fc18e4526ec23acad776'),
(19, 'api_card', 'https://nappay.vn/');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `code` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `billing_cycle` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `created_at` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `total_money` int DEFAULT NULL,
  `balance_before` int DEFAULT NULL,
  `balance_after` int DEFAULT NULL,
  `status` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `username`, `name`, `code`, `billing_cycle`, `created_at`, `quantity`, `total_money`, `balance_before`, `balance_after`, `status`) VALUES
(1, 'admin', 'CS 1-1-20', '', 'monthly', '10121231313', 1, 100000, 122600, 115400, 'choxuly'),
(2, 'admin', 'CS 1-2-25', 'zefnm', 'monthly', '10121231313', 2, 100000, NULL, NULL, 'choxuly'),
(3, 'admin', 'test', 'zefnc', 'monthly', '1762705119', 1, 50000, NULL, NULL, 'thatbai'),
(4, 'admin', 'test', 'gaJvw', 'monthly', '1762705725', 1, 50000, NULL, NULL, 'thatbai'),
(5, 'admin', 'test', 'dkJH6', 'monthly', '1762705853', 1, 50000, NULL, NULL, 'thanhcong'),
(7, 'admin', 'VN_01', 'KJ4w7', 'monthly', '1762748451', 1, 8000, NULL, NULL, 'thanhcong'),
(8, 'admin', 'VN_01', 'HJWrv', 'monthly', '1762748543', 1, 8000, NULL, NULL, 'thanhcong'),
(9, 'admin', 'VN_01', 'lNQqt', 'monthly', '1762749017', 1, 7200, NULL, NULL, 'thanhcong'),
(10, 'admin', 'VN_01', '0JBSW', 'monthly', '1762749378', 1, 7200, 122600, 115400, 'thanhcong'),
(11, 'admin', 'test', 'Wh7Re', 'monthly', '1762921122', 1, 50000, NULL, NULL, 'thanhcong'),
(12, 'admin', 'CS 1-1-20', NULL, 'monthly', '10121231313', 1, 100000, NULL, NULL, 'thanhcong'),
(13, 'admin', 'CS 1-2-25', NULL, 'monthly', '10121231313', 2, 100000, NULL, NULL, 'thanhcong'),
(14, 'admin', 'test', 'zefnc', 'monthly', '1762705119', 1, 50000, NULL, NULL, 'thanhcong'),
(15, 'admin', 'test', 'gaJvw', 'monthly', '1762705725', 1, 50000, NULL, NULL, 'thanhcong'),
(16, 'admin', 'test', 'dkJH6', 'monthly', '1762705853', 1, 50000, NULL, NULL, 'thanhcong'),
(17, 'admin', 'VN_01', 'KJ4w7', 'monthly', '1762748451', 1, 8000, NULL, NULL, 'thanhcong'),
(18, 'admin', 'VN_01', 'HJWrv', 'monthly', '1762748543', 1, 8000, NULL, NULL, 'thanhcong'),
(19, 'admin', 'VN_01', 'lNQqt', 'monthly', '1762749017', 1, 7200, NULL, NULL, 'thanhcong'),
(20, 'admin', 'VN_01', '0JBSW', 'monthly', '1762749378', 1, 7200, 122600, 115400, 'thanhcong'),
(21, 'admin', 'test', 'Wh7Re', 'monthly', '1762921122', 1, 50000, NULL, NULL, 'thanhcong'),
(27, 'admin', 'VN_01', 'rbpJJ', 'monthly', '1764921339', 1, 0, 7000, 7000, 'thanhcong'),
(28, 'admin', 'VN_01', 'uiaeW', 'monthly', '1764922818', 1, 0, 7000, 7000, 'thanhcong'),
(31, 'admin', 'VN_01', 'nWJHJ', 'monthly', '1764923065', 1, 0, 7000, 7000, 'thanhcong'),
(32, 'admin', 'VN_01', 'QSkrO', 'monthly', '1764930402', 1, 0, 5000, 5000, 'thanhcong'),
(33, 'SharkDunggg', 'VN_02', '9QRN5', 'monthly', '1765952743', 1, 75000, 206000, 131000, 'thanhcong'),
(34, '20223155eauteduvn', 'VN_02', 'sHmwj', 'monthly', '1766152566', 1, 75000, 77000, 2000, 'thanhcong');

-- --------------------------------------------------------

--
-- Table structure for table `package_cloudvps`
--

CREATE TABLE `package_cloudvps` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `detail` longtext CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `pricing` longtext CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `price` longtext CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `status` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `created_at` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `updated_at` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `site` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `package_cloudvps`
--

INSERT INTO `package_cloudvps` (`id`, `product_id`, `name`, `detail`, `pricing`, `price`, `status`, `created_at`, `updated_at`, `site`) VALUES
(8, 5, 'CS 1-1-20', '{\"product_id\":5,\"name\":\"CS 1-1-20\",\"special\":0,\"cpu\":1,\"ram\":1,\"disk\":20,\"ip\":\"1\",\"os\":\"Windows\\/Linux\",\"bandwidth\":\"100 Mb\\/10 Mb\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":49000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":96040},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":142590},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":276360},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":517440},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":893760},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":1128960}}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":49000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":96040},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":142590},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":276360},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":517440},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":893760},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":1128960}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":49000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":96040},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":142590},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":276360},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":517440},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":893760},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":1128960}}', 'on', '1761819201', '1761820602', 'VNCLOUD'),
(9, 9, 'CS 1-2-25', '{\"product_id\":9,\"name\":\"CS 1-2-25\",\"special\":0,\"cpu\":1,\"ram\":2,\"disk\":25,\"ip\":\"1\",\"os\":\"Windows\\/Linux\",\"bandwidth\":\"100 Mb\\/10 Mb\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":63000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":123480},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":183330},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":355320},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":665280},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":1149120},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":1451520}}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":63000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":123480},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":183330},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":355320},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":665280},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":1149120},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":1451520}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":63000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":123480},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":183330},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":355320},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":665280},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":1149120},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":1451520}}', 'on', '1761819201', '1761820602', 'VNCLOUD'),
(10, 10, 'CS 2-4-30', '{\"product_id\":10,\"name\":\"CS 2-4-30\",\"special\":0,\"cpu\":2,\"ram\":4,\"disk\":30,\"ip\":\"1\",\"os\":\"Windows\\/Linux\",\"bandwidth\":\"100 Mb\\/10 Mb\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":105000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":205800},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":305550},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":592200},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":1108800},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":1915200},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":2419200}}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":105000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":205800},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":305550},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":592200},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":1108800},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":1915200},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":2419200}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":105000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":205800},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":305550},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":592200},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":1108800},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":1915200},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":2419200}}', 'on', '1761819201', '1761820602', 'VNCLOUD'),
(11, 11, 'CS 4-8-50', '{\"product_id\":11,\"name\":\"CS 4-8-50\",\"special\":0,\"cpu\":4,\"ram\":8,\"disk\":50,\"ip\":\"1\",\"os\":\"Windows\\/Linux\",\"bandwidth\":\"100 Mb\\/10 Mb\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":210000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":411600},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":611100},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":1184400},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":2217600},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":3830400},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":4838400}}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":210000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":411600},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":611100},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":1184400},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":2217600},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":3830400},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":4838400}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":210000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":411600},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":611100},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":1184400},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":2217600},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":3830400},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":4838400}}', 'on', '1761819201', '1761820602', 'VNCLOUD'),
(12, 12, 'CS 8-16-70', '{\"product_id\":12,\"name\":\"CS 8-16-70\",\"special\":0,\"cpu\":8,\"ram\":16,\"disk\":70,\"ip\":\"1\",\"os\":\"Windows\\/Linux\",\"bandwidth\":\"100 Mb\\/10 Mb\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":406000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":795760},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":1181460},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":2289840},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":4287360},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":7405440},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":9354240}}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":406000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":795760},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":1181460},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":2289840},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":4287360},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":7405440},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":9354240}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":406000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":795760},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":1181460},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":2289840},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":4287360},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":7405440},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":9354240}}', 'on', '1761819201', '1761820602', 'VNCLOUD'),
(13, 13, 'CS 16-32-100', '{\"product_id\":13,\"name\":\"CS 16-32-100\",\"special\":0,\"cpu\":16,\"ram\":32,\"disk\":100,\"ip\":\"1\",\"os\":\"Windows\\/Linux\",\"bandwidth\":\"100 Mb\\/10 Mb\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":770000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":1509200},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":2240700},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":4342800},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":8131200},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":14044800},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":17740800}}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":770000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":1509200},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":2240700},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":4342800},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":8131200},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":14044800},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":17740800}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":770000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":1509200},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":2240700},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":4342800},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":8131200},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":14044800},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":17740800}}', 'on', '1761819201', '1761820602', 'VNCLOUD'),
(14, 27, 'Mini Cloud (1-2-20)', '{\"product_id\":27,\"name\":\"Mini Cloud (1-2-20)\",\"special\":0,\"cpu\":1,\"ram\":2,\"disk\":20,\"ip\":\"1 IPv4 Riêng\",\"os\":\"Windows\\/ linux\",\"bandwidth\":\"Không giới hạn\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":50000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":400000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":800000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":1200000}}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":50000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":400000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":800000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":1200000}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":50000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":400000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":800000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":1200000}}', 'hoatdong', '1762694697', '1762701807', 'VNCLOUD'),
(15, 100, 'PLATIUM  (2-2-30)', '{\"product_id\":100,\"name\":\"PLATIUM  (2-2-30)\",\"special\":0,\"cpu\":2,\"ram\":2,\"disk\":30,\"ip\":\"1 IPv4 Riêng\",\"os\":\"Windows\\/Linux\",\"bandwidth\":\"Không giới hạn\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":60000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":700000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":1400000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":2100000}}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":60000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":700000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":1400000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":2100000}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":60000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":700000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":1400000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":2100000}}', 'hoatdong', '1762694697', '1762701807', 'VNCLOUD'),
(16, 49, 'PLATIUM SALE (4-4-40)', '{\"product_id\":49,\"name\":\"PLATIUM SALE (4-4-40)\",\"special\":0,\"cpu\":4,\"ram\":4,\"disk\":40,\"ip\":\"1 IPv4 Riêng\",\"os\":\"Windows\\/Linux\",\"bandwidth\":\"Không giới hạn\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":150000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":899000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":1798000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":2697000}}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":150000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":899000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":1798000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":2697000}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":150000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":899000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":1798000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":2697000}}', 'hoatdong', '1762694697', '1762701807', 'VNCLOUD'),
(17, 50, 'PLATIUM VIP (4-8-80)', '{\"product_id\":50,\"name\":\"PLATIUM VIP (4-8-80)\",\"special\":0,\"cpu\":4,\"ram\":8,\"disk\":80,\"ip\":\"1 IPv4 Riêng\",\"os\":\"Windows\\/Linux\",\"bandwidth\":\"Không giới hạn\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":220000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":440000},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":660000},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":1320000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":980000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":5280000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":7920000}}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":220000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":440000},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":660000},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":1320000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":980000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":5280000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":7920000}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":220000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":440000},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":660000},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":1320000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":980000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":5280000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":7920000}}', 'hoatdong', '1762694697', '1762701807', 'VNCLOUD'),
(18, 84, 'PLATIUM PREMIUM (8-18-120)', '{\"product_id\":84,\"name\":\"PLATIUM PREMIUM (8-18-120)\",\"special\":0,\"cpu\":8,\"ram\":18,\"disk\":120,\"ip\":\"1ipv4 Riêng\",\"os\":\"Windows\\/ linux\",\"bandwidth\":\"Không giới hạn\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":460000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":800000},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":1200000},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":2400000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":4800000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":9600000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":14400000}}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":460000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":800000},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":1200000},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":2400000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":4800000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":9600000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":14400000}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":460000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":800000},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":1200000},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":2400000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":4800000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":9600000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":14400000}}', 'hoatdong', '1762694697', '1762701807', 'VNCLOUD'),
(19, 85, 'PLATIUM ULTIMATE (18-42-240)', '{\"product_id\":85,\"name\":\"PLATIUM ULTIMATE (18-42-240)\",\"special\":0,\"cpu\":18,\"ram\":42,\"disk\":240,\"ip\":\"1 IPv4 Riêng\",\"os\":\"Windows\\/ linux\",\"bandwidth\":\"Không giới hạn\",\"pricing\":{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":1100000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":2200000},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":3300000},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":6600000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":13200000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":26000000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":39600000}}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":1100000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":2200000},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":3300000},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":6600000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":13200000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":26000000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":39600000}}', '{\"monthly\":{\"billing_cycle\":\"1 Tháng\",\"amount\":1100000},\"twomonthly\":{\"billing_cycle\":\"2 Tháng\",\"amount\":2200000},\"quarterly\":{\"billing_cycle\":\"3 Tháng\",\"amount\":3300000},\"semi_annually\":{\"billing_cycle\":\"6 Tháng\",\"amount\":6600000},\"annually\":{\"billing_cycle\":\"1 Năm\",\"amount\":13200000},\"biennially\":{\"billing_cycle\":\"2 Năm\",\"amount\":26000000},\"triennially\":{\"billing_cycle\":\"3 Năm\",\"amount\":39600000}}', 'hoatdong', '1762694697', '1762701807', 'VNCLOUD');

-- --------------------------------------------------------

--
-- Table structure for table `package_hosting`
--

CREATE TABLE `package_hosting` (
  `id` int NOT NULL,
  `name_host` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `code_host` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `server_host` int DEFAULT NULL,
  `money` int DEFAULT NULL,
  `disk` int DEFAULT NULL,
  `other_domain` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `alias_domain` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `status` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `package_hosting`
--

INSERT INTO `package_hosting` (`id`, `name_host`, `code_host`, `server_host`, `money`, `disk`, `other_domain`, `alias_domain`, `status`) VALUES
(1, 'VN_01', 'vn_01', 1, 0, 1000, 'Không giới hạn', 'Không giới hạn', 'on'),
(2, 'VN_TEST', 'vn_test', 1, 140000, 4000, 'Không giới hạn', 'Không giới hạn', 'on'),
(3, 'VN_02', 'vn_02', 2, 75000, 3000, 'Không giới hạn', 'Không giới hạn', 'on'),
(4, 'US_BASIC', 'us_basic', 3, 120000, 5000, 'Có giới hạn', 'Có giới hạn', 'off'),
(5, 'EU_PRO', 'eu_pro', 4, 300000, 10000, 'Không giới hạn', 'Có giới hạn', 'off'),
(6, 'VN_BASIC', 'vn_basic', 1, 50000, 2000, 'Có giới hạn', 'Có giới hạn', 'on'),
(7, 'VN_ADVANCE', 'vn_advance', 2, 180000, 6000, 'Không giới hạn', 'Không giới hạn', 'on'),
(8, 'US_STANDARD', 'us_standard', 3, 200000, 8000, 'Không giới hạn', 'Có giới hạn', 'off'),
(9, 'US_PREMIUM', 'us_premium', 4, 450000, 15000, 'Không giới hạn', 'Không giới hạn', 'off'),
(10, 'EU_BASIC', 'eu_basic', 5, 90000, 4000, 'Có giới hạn', 'Có giới hạn', 'off'),
(11, 'EU_ADVANCE', 'eu_advance', 6, 280000, 12000, 'Không giới hạn', 'Không giới hạn', 'off'),
(12, 'ASIA_STARTER', 'asia_starter', 7, 30000, 1000, 'Có giới hạn', 'Không giới hạn', 'off'),
(13, 'ASIA_BUSINESS', 'asia_business', 8, 350000, 20000, 'Không giới hạn', 'Không giới hạn', 'off'),
(14, 'GLOBAL_PRO', 'global_pro', 9, 600000, 30000, 'Không giới hạn', 'Không giới hạn', 'off'),
(15, 'STUDENT_SPECIAL', 'student_special', 10, 20000, 500, 'Có giới hạn', 'Có giới hạn', 'off');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `stt` int NOT NULL,
  `type` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `title` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `image` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `slug` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `content` longtext CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `status` varchar(100) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `view` int NOT NULL,
  `time` varchar(100) COLLATE utf8mb4_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `username`, `stt`, `type`, `title`, `image`, `slug`, `content`, `status`, `view`, `time`) VALUES
(1, 'admin', 1, 'huong-dan', 'Tận dụng dịch vụ tiếp thị kỹ thuật số cho doanh nghiệp nhỏ', 'https://sieuthicode.net/upload/blog/blogSX2V.png', 'tan-dung-ky-thuat', 'PGgxPiZuYnNwOzwvaDE+DQoNCjxwIGRpcj0ibHRyIj48YSBocmVmPSJodHRwczovL25oYW5ob2EuY29tL3Rpbi10dWMvby1jdW5nLXNhdGEuaHRtbCI+4buUIGPhu6luZyBTQVRBPC9hPiBsJmFncmF2ZTsgbeG7mXQgdHJvbmcgbmjhu69uZyB0aGnhur90IGLhu4sgbMawdSB0cuG7ryBk4buvIGxp4buHdSBoaeG7h24gbmF5LCDEkcaw4bujYyBz4butIGThu6VuZyB0cm9uZyBj4bqjIG0mYWFjdXRlO3kgdCZpYWN1dGU7bmggYyZhYWN1dGU7IG5oJmFjaXJjO24gbOG6q24gbSZhYWN1dGU7eSBjaOG7py4gVuG7m2kgxrB1IMSRaeG7g20gduG7gSB04buRYyDEkeG7mSB0cnV54buBbiB04bqjaSDhu5VuIMSR4buLbmgsIGR1bmcgbMaw4bujbmcgbOG7m24gdiZhZ3JhdmU7IGdpJmFhY3V0ZTsgcGjhuqNpIGNoxINuZywg4buVIGPhu6luZyBTQVRBIHbhuqtuIGdp4buvIHZhaSB0ciZvZ3JhdmU7IHF1YW4gdHLhu41uZyBkJnVncmF2ZTsgU1NEIG5nJmFncmF2ZTt5IGMmYWdyYXZlO25nIHBo4buVIGJp4bq/bi4gQyZ1Z3JhdmU7bmcgTmgmYWNpcmM7biBIbyZhZ3JhdmU7IHQmaWdyYXZlO20gaGnhu4N1IGNoaSB0aeG6v3QgduG7gSDhu5UgY+G7qW5nIFNBVEEgdiZhZ3JhdmU7IHPhu7Ega2gmYWFjdXRlO2MgYmnhu4d0IHNvIHbhu5tpIFNTRCBuaCZlYWN1dGU7ITwvcD4NCg0KPGgyIGRpcj0ibHRyIj4mbmJzcDs8L2gyPg0KDQo8cD7hu5QgY+G7qW5nIFNBVEEgbCZhZ3JhdmU7IGcmaWdyYXZlOz88L3A+DQoNCjxwIGRpcj0ibHRyIj7hu5QgY+G7qW5nIFNBVEEgKFNlcmlhbCBBZHZhbmNlZCBUZWNobm9sb2d5IEF0dGFjaG1lbnQpIGwmYWdyYXZlOyBsb+G6oWkg4buVIGPhu6luZyBz4butIGThu6VuZyBjaHXhuqluIGdpYW8gdGnhur9wIFNBVEEgxJHhu4Mga+G6v3QgbuG7kWkgduG7m2kgYm8gbeG6oWNoIGNo4bunLiBDaHXhuqluIG4mYWdyYXZlO3kgcmEgxJHhu51pIG5o4bqxbSB0aGF5IHRo4bq/IFBBVEEgKElERSkgduG7m2kgdOG7kWMgxJHhu5kgdHJ1eeG7gW4gdOG6o2kgbmhhbmggaMahbiwgYyZvYWN1dGU7IHRo4buDIMSR4bqhdCDEkeG6v24gNiBHYi9zLiBOaOG7nSB24bqteSwg4buVIGPhu6luZyBTQVRBIG1hbmcgbOG6oWkga2jhuqMgbsSDbmcgeOG7rSBsJnlhY3V0ZTsgZOG7ryBsaeG7h3Ug4buVbiDEkeG7i25oIHYmYWdyYXZlOyBoaeG7h3UgcXXhuqMgaMahbi48L3A+DQoNCjxwIGRpcj0ibHRyIj5OZ28mYWdyYXZlO2kgcmEsIOG7lSBj4bupbmcgU0FUQSBjJm9ncmF2ZTtuIG7hu5VpIGLhuq10IG5o4budIG3hu6ljIHRpJmVjaXJjO3UgdGjhu6UgxJFp4buHbiBuxINuZyB0aOG6pXAgdiZhZ3JhdmU7IMSR4buZIHRpbiBj4bqteSBjYW8uIENoJnVhY3V0ZTtuZyBo4buXIHRy4bujIGMmYWFjdXRlO2MgdCZpYWN1dGU7bmggbsSDbmcgaGnhu4duIMSR4bqhaSBuaMawIGhvdC1zd2FwcGluZyB2JmFncmF2ZTsgTkNRIGdpJnVhY3V0ZTtwIHTEg25nIHThu5FjIMSR4buZIMSR4buNYyBnaGkuIE5o4budIG5o4buvbmcgxrB1IMSRaeG7g20gbiZhZ3JhdmU7eSwgU0FUQSDEkSZhdGlsZGU7IHRy4bufIHRoJmFncmF2ZTtuaCB0aSZlY2lyYzt1IGNodeG6qW4gcGjhu5UgYmnhur9uIGNobyDhu5UgY+G7qW5nIHRyJmVjaXJjO24gY+G6oyBtJmFhY3V0ZTt5IHQmaWFjdXRlO25oIMSR4buDIGImYWdyYXZlO24gbOG6q24gbGFwdG9wLjwvcD4NCg==', 'on', 83, '1002130123');

-- --------------------------------------------------------

--
-- Table structure for table `purchased_cloudvps`
--

CREATE TABLE `purchased_cloudvps` (
  `id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `id_produc` int DEFAULT NULL,
  `id_vps` int NOT NULL,
  `billingcycle` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `billingcycleday` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `info` longtext CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `data` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `status` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `money` int DEFAULT NULL,
  `cost` int DEFAULT NULL,
  `total_money` int DEFAULT NULL,
  `total_cost` int DEFAULT NULL,
  `created_at` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `end_date` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `updated_at` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `site` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `purchased_cloudvps`
--

INSERT INTO `purchased_cloudvps` (`id`, `username`, `id_produc`, `id_vps`, `billingcycle`, `billingcycleday`, `info`, `data`, `status`, `money`, `cost`, `total_money`, `total_cost`, `created_at`, `end_date`, `updated_at`, `site`) VALUES
(16, 'admin', 27, 4377, 'monthly', '30', '[{\"vps-id\":4377,\"date_create\":\"09-11-2025\",\"next_due_date\":\"2025-12-09\",\"vps-status\":\"progressing\",\"is-special\":0,\"ip\":\"103.139.154.144\",\"username\":\"Administrator\",\"password\":\"ND093S4ZnNxvwhl3\",\"service_type\":\"vps\",\"vps_os\":\"Windows 10 64bit\"}]', '{\"ip\":\"103.139.154.144\",\"cpu\":1,\"ram\":2,\"disk\":20,\"text-config\":\"1 CPU - 2 RAM - 20 Disk\",\"day-left\":\"Còn hạn 52 ngày\",\"username\":\"root\",\"password\":\"QrjgbvjEGttT2fHe\"}', 'on', 50000, 50000, 50000, 50000, '1762696054', '1773067340', '2025-11-18 15:48:18', 'CHINHAPI'),
(23, 'nguyenvanA', 1, 1001, 'monthly', '15', '{\"cpu\": \"2 cores\", \"ram\": \"4GB\", \"storage\": \"50GB SSD\"}', '{\"ip\": \"192.168.1.100\", \"os\": \"Ubuntu 22.04\"}', 'on', 150000, 100000, 150000, 100000, '1705305600', '1707987200', '1705305600', 'site1'),
(24, 'tranthiB', 2, 1002, 'quarterly', '01', '{\"cpu\": \"4 cores\", \"ram\": \"8GB\", \"storage\": \"100GB SSD\"}', '{\"ip\": \"192.168.1.101\", \"os\": \"CentOS 8\"}', 'on', 400000, 280000, 1200000, 840000, '1704067200', '1711929600', '1704067200', 'site2'),
(25, 'levanC', 3, 1003, 'yearly', '10', '{\"cpu\": \"1 core\", \"ram\": \"2GB\", \"storage\": \"30GB SSD\"}', '{\"ip\": \"192.168.1.102\", \"os\": \"Debian 11\"}', 'on', 1000000, 700000, 1000000, 700000, '1704844800', '1736380800', '1704844800', 'site1'),
(26, 'phamthiD', 1, 1004, 'monthly', '20', '{\"cpu\": \"2 cores\", \"ram\": \"4GB\", \"storage\": \"50GB SSD\"}', '{\"ip\": \"192.168.1.103\", \"os\": \"Windows Server 2022\"}', 'off', 200000, 150000, 200000, 150000, '1706832000', '1709510400', '1708992000', 'site3'),
(27, 'hoangvanE', 4, 1005, 'trial', '25', '{\"cpu\": \"1 core\", \"ram\": \"1GB\", \"storage\": \"20GB SSD\"}', '{\"ip\": \"192.168.1.104\", \"os\": \"Ubuntu 20.04\"}', 'on', 0, 0, 0, 0, '1708300800', '1708992000', '1708300800', 'site1'),
(28, 'doanh_nghiepF', 5, 1006, 'yearly', '05', '{\"cpu\": \"8 cores\", \"ram\": \"16GB\", \"storage\": \"200GB SSD\"}', '{\"ip\": \"192.168.1.105\", \"os\": \"Red Hat Enterprise\"}', 'on', 2500000, 1800000, 2500000, 1800000, '1704412800', '1735948800', '1704412800', 'site2'),
(29, 'nguyenminhG', 1, 1007, 'monthly', 'today', '{\"cpu\": \"2 cores\", \"ram\": \"4GB\", \"storage\": \"50GB SSD\"}', '{\"ip\": \"192.168.1.106\", \"os\": \"Ubuntu 22.04\"}', 'on', 150000, 100000, 150000, 100000, '1709251200', '1711929600', '1709251200', 'site1'),
(30, 'tranhoangH', 2, 1008, 'semiannual', '12', '{\"cpu\": \"4 cores\", \"ram\": \"8GB\", \"storage\": \"100GB SSD\"}', '{\"ip\": \"192.168.1.107\", \"os\": \"CentOS 8\"}', 'on', 750000, 500000, 1500000, 1000000, '1707696000', '1717286400', '1707696000', 'site3'),
(31, 'levietI', 3, 1009, 'monthly', '28', '{\"cpu\": \"1 core\", \"ram\": \"2GB\", \"storage\": \"30GB SSD\"}', '{\"ip\": \"192.168.1.108\", \"os\": \"Debian 11\"}', 'on', 90000, 60000, 90000, 60000, '1706832000', '1709337600', '1706832000', 'site1'),
(32, 'phanthiK', 1, 1010, 'monthly', '03', '{\"cpu\": \"2 cores\", \"ram\": \"4GB\", \"storage\": \"50GB SSD\"}', '{\"ip\": \"192.168.1.109\", \"os\": \"Ubuntu 22.04\"}', 'off', 150000, 100000, 150000, 100000, '1701561600', '1704240000', '1701561600', 'site2'),
(33, 'caocapL', 6, 1011, 'yearly', '15', '{\"cpu\": \"12 cores\", \"ram\": \"32GB\", \"storage\": \"500GB SSD\"}', '{\"ip\": \"192.168.1.110\", \"os\": \"Windows Server 2022\"}', 'on', 5000000, 3500000, 5000000, 3500000, '1705276800', '1736812800', '1705276800', 'site3'),
(34, 'developerM', 3, 1012, 'monthly', 'random', '{\"cpu\": \"2 cores\", \"ram\": \"4GB\", \"storage\": \"50GB SSD\"}', '{\"ip\": \"192.168.1.111\", \"os\": \"Ubuntu 22.04\"}', 'on', 120000, 80000, 120000, 80000, '1708473600', '1711152000', '1708473600', 'site1'),
(35, 'testerN', 4, 1013, 'trial', '30', '{\"cpu\": \"1 core\", \"ram\": \"1GB\", \"storage\": \"20GB SSD\"}', '{\"ip\": \"192.168.1.112\", \"os\": \"CentOS 7\"}', 'on', 0, 0, 0, 0, '1709596800', '1710288000', '1709596800', 'site2'),
(36, 'doanhnghiepO', 2, 1014, 'quarterly', '20', '{\"cpu\": \"4 cores\", \"ram\": \"8GB\", \"storage\": \"100GB SSD\"}', '{\"ip\": \"192.168.1.113\", \"os\": \"Ubuntu 22.04\"}', 'on', 450000, 300000, 1350000, 900000, '1705708800', '1713571200', '1705708800', 'site3'),
(37, 'budgetP', 1, 1015, 'monthly', '05', '{\"cpu\": \"1 core\", \"ram\": \"2GB\", \"storage\": \"30GB SSD\"}', '{\"ip\": \"192.168.1.114\", \"os\": \"Debian 11\"}', 'on', 80000, 50000, 80000, 50000, '1707091200', '1709769600', '1707091200', 'site1'),
(38, 'gamerQ', 5, 1016, 'monthly', '10', '{\"cpu\": \"8 cores\", \"ram\": \"16GB\", \"storage\": \"200GB SSD\"}', '{\"ip\": \"192.168.1.115\", \"os\": \"Windows 10\"}', 'on', 300000, 200000, 300000, 200000, '1707523200', '1710201600', '1707523200', 'site2'),
(39, 'webserverR', 3, 1017, 'yearly', '25', '{\"cpu\": \"4 cores\", \"ram\": \"8GB\", \"storage\": \"100GB SSD\"}', '{\"ip\": \"192.168.1.116\", \"os\": \"Ubuntu 22.04\"}', 'on', 1200000, 800000, 1200000, 800000, '1706169600', '1737705600', '1706169600', 'site3'),
(40, 'databaseS', 2, 1018, 'monthly', '15', '{\"cpu\": \"4 cores\", \"ram\": \"8GB\", \"storage\": \"100GB SSD\"}', '{\"ip\": \"192.168.1.117\", \"os\": \"CentOS 8\"}', 'on', 180000, 120000, 180000, 120000, '1707955200', '1710633600', '1707955200', 'site1'),
(41, 'backupT', 1, 1019, 'monthly', 'lastday', '{\"cpu\": \"2 cores\", \"ram\": \"4GB\", \"storage\": \"100GB HDD\"}', '{\"ip\": \"192.168.1.118\", \"os\": \"Ubuntu 20.04\"}', 'on', 100000, 70000, 100000, 70000, '1709164800', '1711843200', '1709164800', 'site2'),
(42, 'newuserU', 4, 1020, 'trial', 'today', '{\"cpu\": \"1 core\", \"ram\": \"1GB\", \"storage\": \"20GB SSD\"}', '{\"ip\": \"192.168.1.119\", \"os\": \"Ubuntu 22.04\"}', 'on', 0, 0, 0, 0, '1710028800', '1710720000', '1710028800', 'site3');

-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

CREATE TABLE `ranks` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `description` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `image` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `min_points` int NOT NULL,
  `max_points` int NOT NULL,
  `discount_percent` int NOT NULL,
  `sitecon` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `status` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `time` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `ranks`
--

INSERT INTO `ranks` (`id`, `name`, `description`, `image`, `min_points`, `max_points`, `discount_percent`, `sitecon`, `status`, `time`) VALUES
(1, 'Cộng Tác Viên', 'Nạp 500k ', 'cac', 0, 500000, 5, 'off', 'on', '1230132913'),
(2, 'Test111', 'Alo alo', '/assets/images/ranks/rank_1765612225_693d1ac15b0bf.png', 30, 53, 1, 'off', 'off', '1765612225'),
(3, 'Afghanistan', 'lllllll', '/assets/images/ranks/rank_1765985397_6942cc75201b5.jpeg', 5, 6, 0, 'off', 'off', '1765985397'),
(4, 'NguenDug2ka4', 'aaaaaaaa', '/assets/images/ranks/rank_1765985835_6942ce2be2201.png', 4, 6, 5, 'off', 'on', '1765985835');

-- --------------------------------------------------------

--
-- Table structure for table `server_hosting`
--

CREATE TABLE `server_hosting` (
  `id` int NOT NULL,
  `name_server` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `to_slug` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `link_login` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `account_whm` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `password_whm` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `ip_whm` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `name_server1` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `name_server2` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `status` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `server_hosting`
--

INSERT INTO `server_hosting` (`id`, `name_server`, `to_slug`, `link_login`, `account_whm`, `password_whm`, `ip_whm`, `name_server1`, `name_server2`, `status`) VALUES
(2, 'Việt Nam', 'viet-nam', 'HI4OPceaJMzeBy0ovZiUPuCrYkgbGYKSgUdqU3edcmWRYi7bCjQ+3kBo8q8czPjs0arLI6ERts8Q55lgqImtiD0lEDdUC4faA8Mq9/TKqRzgWYrHVkvuYSuE7Q4kCUbq2EikOEj2o1VtSdQ9Y3z+eYNhkWemii8Dox2qhETMegBjjqs0uEFNHUeCaNtMR0yLfSXUZq93oJHYwnB1XhqTfYdrhgDDW+FLXsglkqT3PUMli04Y9qWg/Bo1Lq1GqGaIZ6xbf/dfG9fx/cRZ3DFP9yCBgXPyOjUWQsUeQuP7Ajp7x+fv+esEQKCHcsoIzIf6AWDNqAo0hBYzk+qURFXSrA==', 'v4hFTKPUNGCgmW4Ze/6HhNbSLEhWX5Xf4h0UiQEeHSbx8Yco9rFQaKlpnhTbrweGSDMBKqMR2hQ4//qMQgrAupuWoGIII7dT5VJ3k6NN17BXwRSTBzkNgoeOWdKpRPW1Htbe/NmFDAQuOQr7XJnmNh4KmfM1ZIDpyPG5ZMCgOlxwjN2lv++PC5eGVCjsqQZ7SyKuP02TxTZ9/Slcw+ZwnvtP5wafK5tk4XzoruBZ2pdBpKuMjCMLiBfhT+vzTY4HmQNwFLqlsQWpBsz0zmH2KM0uMsQp+YbOgsIgy23PmAIYDNDySkY4t5xrB+Dror8ZONxkO940kIhvSAfQSvmJWg==', 'JsEXq/QMYuYim6anJhxh804N+cnWjxMyl33/LwMvpqlk5ZUiPHTv+0ixovYjPvAByRIUo1Y3OhTapFbLA92ybyAfZ7GPxDfu3ZkJYP77hbaZpPmN2MvMDx2yZPU3wWWeUAt4ARKFwExhx6+lDSgemGVT3ObuMhK3peVV+THynxEAGh0YVtqBypk5ldQ7d5EV3hrF5+YrSRFTHtvd3kuGsYY/4WbFNjhRGW0ckHKIyjMBwgcC0Mqi2XkOg/F3yuD3jGHx2kBTHfzY991lV9qcWj1Sxzi0cHqgcPg0KufjvzRzMdCgbEuPFfafCxj4hoQCpFbPOrMBleChJFPQUYKtvg==', 'V8Xb6w3M8gHQgmwWaXa2bkkvIfKIyHRHexVGcP+zEYKPdUURh656IJr/iiqs7oLUX1zyK5hAPmr6swzvKWwCq2kP0qAsZTw1jR7TLrztSztoddHB+kU0wPmHPYsV1ENE+xUvMQLbl39zUdbcqbFeNs2+5ePz1v0g81ZXzxHF91VZYgtOct+tNW/fQauVXZp+DAIVPYpO/doO1X5vBuPzq5U+Uf9zbfviRQ4RgL5/A2KqC0rE2FOu3I2BIpBZUqD8dFLRmTdN7z2kffsl1oMkutMRgSTvFpwsmKHedUCXsF7g6uLunzjBaKf8SZwHFbcd+2bxQZ96sWm2dHfWjxWFYw==', 'ns1.dungbios.com', 'ns2.dungbios.com', 'on');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `fullname` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `username` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci NOT NULL,
  `password` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci NOT NULL,
  `phone` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `money` int NOT NULL,
  `total_money` int NOT NULL,
  `session_token` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `level` int NOT NULL,
  `band` int NOT NULL,
  `ip_adr` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `tb_email` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `tb_tele` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `id_tele` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `token` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `veri_otp` int DEFAULT NULL,
  `veri_email` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `createdate` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `time` varchar(100) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `email`, `phone`, `money`, `total_money`, `session_token`, `level`, `band`, `ip_adr`, `address`, `tb_email`, `tb_tele`, `id_tele`, `token`, `veri_otp`, `veri_email`, `createdate`, `time`) VALUES
(1, 'Nguyễn Trung Chínhsdasdasd', 'chinhapiit', '$2y$10$KBXOpVl4OgGkiOzBgEfYLeYSclMM4TdKK.Jap6s57NGrjt7fz/FJO', 'chinhapiit@gmail.comasdasd', '0388 674 883', 512000, 512000, 'FbwW1aWrRth45lQnWRzCHJjkedSvN3Qy', 0, 0, '192.168.1.1', 'Hà Nộiasdasddasd', 'off', 'off', NULL, NULL, NULL, 'off', NULL, '1765691289'),
(2, 'Nguyễn Văn Chính', 'admin', '$2y$10$kxuZQBBM23fZRyUkPsZjv.9vm5xEj3GGR7E05HsNZhiVeEMx1SO1m', 'chinhnt.k4@gmail.com', '0388674883', 5000, 500000, 'E1wQS8H32BWeutWo90QKpcijRhJCsy4J', 1, 0, '::1', '', 'off', 'off', '123123123', 'GNHsUxkQ7g29B2qHWVvx8FhCiOIGY90KjheQbJ4kbdks+znPh0FVgx/lt2N1y0TnTwdKxPXReTs763BkSH6rtzYbJtOy/fqbi+Sv5IsQ2Z4P+Rv7BEfueXnIziIHXMsIU8FKDa4Bku75uAvb0OR3KH6JpAbPINJB5n38foW5K/PVYknD//At2Zlt+nHBCZrVfD3e+OlyH2FKY19UcmW9E4f8VySz6WwGNpapjyivx94EU4Uiu0XykW+rLlKeVdPczEwaNtwwnBPeiwk3hiQ0E9RZEQaTDH7866ujycCDs/O6xmoe/RSwkEfpdTmcgjUWvBSCikrAPjcNdptWz1BE0A==', 531981, 'on', NULL, '1764918470'),
(3, 'Nguyễn Văn Chính  AAA BBB AC', 'chinhapi', '$2y$10$r/b1g3MNUqouUIv4VpNhHe/dTO5.dtJTi5.68vCysqZXCp7dmaZEa', 'chinhapi@gmail.com', '0388 674 881', 17000, 19000, 'K6ck9QlgoW3JfQj1mszanibd7JJWWFqe', 1, 1, '::1', '', 'off', 'off', NULL, 'KLzho0dbfoI1aFh+XQhlAdXLV6+FxQyNq+OUpRybVIAzh2BvIVRKb8ti50Cktt2kkSCPvYKLT3kSqTn46KZMqo2/g9uX7H19IQWoUIPBMekCNrk6WfofZp8spGMOJhelru8MVEmo6AKii0YhHydxk2oYpM0XpoVnc+V/41B3oXiEQ97iqMh5qdhNS/V13tupIMa6lkBV8lEG+NWNmETowFEPIb8KHUONczGaPPDvwWVK4lEUP4VLxiiCyds9aoXiRjDSc+sggzPyK9cmnvL/On4J3m0EljfFWqxbbHvzZnbudZhe5t8g/RlAWoW7fiJr96qHmwjS9pTgj3wzSyeGXw==', 812306, 'on', '1762922040', '1765682060'),
(4, 'Nguyễn Văn Quản trị', 'admin_system', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@company.com', '0912345001', 5000000, 15000000, 'sess_adm_001_xyz789', 1, 0, '192.168.100.1', 'Tầng 10, Tòa nhà A, 123 Nguyễn Huệ, Quận 1, TP.HCM', 'on', 'on', '@adminsystem', 'tok_adm_001_abcdef123456', 123456, 'on', '1701394200', '1711614015'),
(5, 'Trần Thị Quản lý', 'manager_01', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'manager@company.com', '0912345002', 3000000, 9500000, 'sess_mgr_002_qwe456', 1, 0, '192.168.100.2', '456 Lê Lợi, Quận Hoàn Kiếm, Hà Nội', 'on', 'off', '@manager01', 'tok_mgr_002_ghijk789', 654321, 'on', '1701746100', '1711701930'),
(6, 'Lê Hoàng Phát', 'admin_senior', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'senior.admin@company.com', '0912345003', 7500000, 25000000, 'sess_sen_003_asd987', 1, 0, '192.168.100.3', '789 Trần Hưng Đạo, Quận 5, TP.HCM', 'on', 'on', '@senioradmin', 'tok_sen_003_lmnop456', 111111, 'on', '1700042400', '1711787445'),
(7, 'Phạm Minh Anh', 'phamminh', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'minhanh.pham@gmail.com', '0912345004', 2500000, 8000000, 'sess_usr_004_zxc123', 0, 0, '113.161.78.123', 'Số 12, Ngõ 45, Phố Lý Thường Kiệt, Quận Hoàn Kiếm, Hà Nội', 'on', 'on', '@phamminhanh', 'tok_usr_004_qwerty789', 222222, 'on', '1704878400', '1711335320'),
(8, 'Nguyễn Thị Bảo Ngọc', 'baongoc_nt', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'baongoc.nguyen@email.com', '0912345005', 800000, 3200000, 'sess_usr_005_vbn456', 0, 0, '115.78.45.67', '45/12 Đường 3/2, Quận 10, TP.HCM', 'on', 'off', NULL, 'tok_usr_005_yuiop123', 333333, 'on', '1705304700', '1711449010'),
(9, 'Trần Đức Cường', 'tranduccuong', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cuong.tran@business.com', '0912345006', 1500000, 4500000, 'sess_usr_006_mnb789', 0, 0, '123.24.56.78', 'Tầng 5, Tòa nhà B, 56 Lê Văn Sỹ, Quận 3, TP.HCM', 'off', 'on', '@tranduccuong', 'tok_usr_006_asdfgh456', 444444, 'off', '1705750200', '1711518335'),
(10, 'Lê Thị Diễm My', 'diemmyle', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'my.le@example.com', '0912345007', 300000, 1200000, 'sess_usr_007_jkl012', 0, 0, '117.89.34.12', '78 Phan Văn Trị, Quận Gò Vấp, TP.HCM', 'off', 'off', NULL, 'tok_usr_007_zxcvbn789', 555555, 'on', '1706155800', '1711588840'),
(11, 'Vũ Mạnh Hùng', 'vumanhhung', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hung.vu@finance.com', '0912345008', 4200000, 12500000, 'sess_usr_008_qwe345', 0, 0, '118.45.67.89', '234 Nguyễn Trãi, Quận Thanh Xuân, Hà Nội', 'on', 'on', '@vumanhhung', 'tok_usr_008_lkjhgf123', 666666, 'on', '1706763600', '1711705225'),
(12, 'Hoàng Thị Phương Anh', 'phuonganh_ht', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'phuonganh.hoang@email.com', '0912345009', 50000, 50000, 'sess_usr_009_rty678', 0, 0, '119.12.34.56', '12 Lý Tự Trọng, Quận Hải Châu, Đà Nẵng', 'on', 'on', '@phuonganhht', 'tok_usr_009_mnbvcx456', 777777, 'off', '1709288400', '1711771810'),
(13, 'Đặng Văn Hải', 'danghai', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hai.dang@email.com', '0912345010', 150000, 1800000, 'sess_usr_010_fgh901', 0, 1, '120.67.89.01', '34 Trần Cao Vân, Quận Thanh Khê, Đà Nẵng', 'on', 'off', '@danghai', 'tok_usr_010_poiuyt123', 888888, 'on', '1707543000', '1711356630'),
(14, 'John David Smith', 'johnsmith', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'john.smith@international.com', '+441234567890', 750000, 2800000, 'sess_usr_011_abc234', 0, 0, '193.156.34.78', '123 Oxford Street, London, UK', 'on', 'on', '@johnsmithuk', 'tok_usr_011_lkjhgf234', 999999, 'on', '1708008300', '1711621845'),
(15, 'Nguyễn Thị Thu Hà', 'thuha_nguyen', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'thuha.nguyen@gmail.com', '0912345012', 600000, 3500000, 'sess_usr_012_def567', 0, 0, '121.34.56.78', '567 Hoàng Diệu, Quận 4, TP.HCM', 'off', 'on', '@thuhanguyen', 'tok_usr_012_mnbvcxz567', 101010, 'on', '1708404300', '1711682720'),
(16, 'Test User One', 'testuser01', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'test.user01@test.com', '0912345013', 0, 0, 'sess_usr_013_ghi890', 0, 0, '192.168.1.100', 'Test Address 1, Test City', 'off', 'off', NULL, 'tok_usr_013_qwertyui890', 121212, 'off', '1709625600', '1709625600'),
(17, '김지은 (Kim Ji Eun)', 'kimjieun', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'jieun.kim@korea.com', '+821012345678', 1200000, 5200000, 'sess_usr_014_jkl123', 0, 0, '210.89.45.67', '456 Gangnam-daero, Gangnam-gu, Seoul, South Korea', 'on', 'on', '@kimjieun_official', 'tok_usr_014_asdfghjk123', 131313, 'on', '1708859700', '1711535750'),
(18, '山田 太郎 (Yamada Taro)', 'yamadataro', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'taro.yamada@japan.jp', '+81312345678', 950000, 4100000, 'sess_usr_015_mno456', 0, 0, '203.145.67.89', '1-2-3 Shibuya, Shibuya-ku, Tokyo, Japan', 'on', 'off', '@yamadataro_jp', 'tok_usr_015_zxcvbnm456', 141414, 'on', '1709119800', '1711781115'),
(19, '王明 (Wang Ming)', 'wangming', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ming.wang@china.cn', '+8613812345678', 1800000, 6800000, 'sess_usr_016_pqr789', 0, 0, '220.181.38.148', 'No. 10, Chaoyangmen Street, Beijing, China', 'on', 'on', '@wangming_cn', 'tok_usr_016_qwertyuiop789', 151515, 'on', '1709365500', '1711628430'),
(20, 'Trần Quốc Bảo', 'tranquocbao', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'bao.tran@business.vn', '0912345017', 3500000, 9800000, 'sess_usr_017_stu012', 0, 0, '125.78.90.12', 'Tầng 8, Tòa nhà C, 789 Lê Đại Hành, Quận 11, TP.HCM', 'on', 'on', '@tranquocbao_biz', 'tok_usr_017_asdfghjkl012', 161616, 'on', '1706638800', '1711698940'),
(21, 'Lê Minh Tuấn', 'minhtuan_le', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tuan.le@student.edu.vn', '0912345018', 150000, 450000, 'sess_usr_018_vwx345', 0, 0, '127.45.67.89', 'Ký túc xá Đại học Bách Khoa, 268 Lý Thường Kiệt, Quận 10, TP.HCM', 'on', 'on', '@minhtuanle', 'tok_usr_018_zxcvbnmas345', 171717, 'off', '1710037800', '1711782925'),
(22, 'Phan Thị Hương Giang', 'huonggiang', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'giang.phan@freelance.com', '0912345019', 750000, 3200000, 'sess_usr_019_yza678', 0, 0, '129.12.34.56', '45/6A Nguyễn Văn Trỗi, Quận Phú Nhuận, TP.HCM', 'on', 'off', '@huonggiang_freelance', 'tok_usr_019_qwertyuiopas678', 181818, 'on', '1707727500', '1711446035'),
(23, 'Hoàng Văn Đức', 'hoangduc', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'duc.hoang@email.com', '0912345020', 25000, 1250000, 'sess_usr_020_bcd901', 0, 1, '130.78.90.12', '78 Trần Não, Quận 2, TP.HCM', 'off', 'off', NULL, 'tok_usr_020_lkjhgfdsa901', 191919, 'on', '1707135600', '1710901845'),
(24, 'Đỗ Thị Thanh Hà', 'thanhha_do', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'thanhha.do@email.com', '0912345021', 200000, 1800000, 'sess_usr_021_efg234', 0, 0, '131.45.67.89', '12 Lý Thái Tổ, Quận Hoàn Kiếm, Hà Nội', 'off', 'off', NULL, 'tok_usr_021_mnbvcxzlkj234', 202020, 'on', '1705569000', '1707985230'),
(25, 'Nguyễn Văn Thịnh', 'vanthinh', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'thinh.nguyen@trader.com', '0912345022', 2800000, 12500000, 'sess_usr_022_hij567', 0, 0, '132.12.34.56', 'Tầng 12, Tòa nhà D, 456 Phạm Văn Đồng, Hà Nội', 'on', 'on', '@vanthinh_trader', 'tok_usr_022_poiuytrewq567', 212121, 'on', '1703057400', '1711695920'),
(26, 'Trần Thị Bích Ngọc', 'bichngoc_tran', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'bichngoc.tran@email.com', '0912345023', 950000, 4200000, 'sess_usr_023_klm890', 0, 0, '133.78.90.12', '34 Nguyễn Thị Minh Khai, Quận 3, TP.HCM', 'on', 'on', '@bichngoctran', 'tok_usr_023_lkjhgfdsazx890', 222222, 'on', '1705916700', '1711584940'),
(27, 'Lê Văn Sơn', 'levanson', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'son.le@danang.com', '0912345024', 450000, 2800000, 'sess_usr_024_nop123', 0, 0, '134.45.67.89', '78 Trần Phú, Quận Hải Châu, Đà Nẵng', 'on', 'off', '@levanson_dn', 'tok_usr_024_mnbvcxzlkjh123', 232323, 'on', '1707366000', '1711518625'),
(28, 'Vũ Thị Hồng Nhung', 'hongnhung_vu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hongnhung.vu@haiphong.com', '0912345025', 620000, 3500000, 'sess_usr_025_qrs456', 0, 0, '135.12.34.56', '123 Điện Biên Phủ, Quận Hồng Bàng, Hải Phòng', 'off', 'on', '@hongnhungvu', 'tok_usr_025_qwertyuioplkj456', 242424, 'off', '1707894900', '1711683635'),
(29, 'Phan Văn Khải', 'phanvankhai', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'khai.phan@cantho.com', '0912345026', 380000, 2100000, 'sess_usr_026_tuv789', 0, 0, '136.78.90.12', '45 Nguyễn Văn Cừ, Quận Ninh Kiều, Cần Thơ', 'on', 'on', '@phanvankhai_ct', 'tok_usr_026_asdfghjklzx789', 252525, 'on', '1708263000', '1711783245'),
(30, 'Bùi Thị Mai Lan', 'mailan_bui', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'mailan.bui@email.com', '0912345027', 1200000, 6500000, 'sess_usr_027_wxy012', 0, 0, '137.45.67.89', '56 Lê Duẩn, Quận 1, TP.HCM', 'on', 'on', '@mailanbui', 'tok_usr_027_zxcvbnmkljh012', 262626, 'on', '1700905500', '1711589130'),
(31, 'Đinh Văn Đức Anh', 'ducanh_dinh', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ducanh.dinh@special.com', '0912345028', 850000, 3800000, 'sess_usr_028_zab345', 0, 0, '138.12.34.56', '78/9A Trường Chinh, Quận Tân Bình, TP.HCM', 'on', 'off', '@ducanhdinh', 'tok_usr_028_qwertyuioplkjh345', 272727, 'on', '1704455400', '1711446940'),
(32, 'Test User Two', 'testuser02', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'test.user02@test.com', '0912345029', 100000, 100000, 'sess_usr_029_cde678', 0, 0, '192.168.1.101', 'Test Address 2, Test City', 'off', 'off', NULL, 'tok_usr_029_asdfghjklqwe678', 282828, 'off', '1710495000', '1710495000'),
(33, 'Cao Thị Kim Oanh', 'kimoanh_cao', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kimoanh.cao@final.com', '0912345030', 1750000, 7200000, 'sess_usr_030_fgh901', 0, 0, '139.78.90.12', '123 Võ Văn Kiệt, Quận 1, TP.HCM', 'on', 'on', '@kimoanhcao', 'tok_usr_030_zxcvbnmqwert901', 292929, 'on', '1704672900', '1711789855'),
(34, NULL, '0378519357', '$2y$10$kYjTr7ZKjMonTDpmrihyxOT4aE3/xPWl1VJaKYs6SD9vBDavhQBf2', 'nguyendung2004nb@gmail.com', '0378519357', 0, 0, 'pNg0CcWRJ7kefbQC8StQrWW2Kx54qzvE', 1, 0, '::1', '', 'off', 'off', NULL, NULL, NULL, 'off', '1765947625', '1765947625'),
(35, NULL, 'SharkDunggg', '$2y$10$LQTrkEeAkmfCmlMkYQGoe..xtdpiLPkhc5oHQN5OPfAFP/ZrFUsGm', 'tridug77@gmail.com', '0378519357', 131000, 206000, 'Bn5hqso0WlbcQidWtJ2gakRWzHQyCvm1', 1, 0, '::1', '', 'off', 'off', NULL, 'b9u2XLvsGmd5DcMXZo3tngEScH01p23PiXCvLwXYkTXPo4+y6WYl9jvMlx1gDXJy7uLYL/BPdIfSJEHSyZAjlotGn2QYE5wa3udZtapZVZb7FjBTB5c3mlsSpcA5P/onb7joHL8AY+vOvOjnel7R3eVcDTbmr6MIlB29jefT/63VtD0m9kVgIDnLKtEtTfVGhEHXQo+lVzWQiwUjQxh6MXDYvy1U7of7PJgA3KTFBF2PGpFALv+ZjXBEhZbI1gyrr/CeZ8+vYL9zCnJRDED/K8XMlwdXMSqAx+TvaIqRBuhn469fIA+vRFxlrw8FNB3hC4SSJkNVwb4Wk5GgJaClgQ==', 370524, 'off', '1765950852', '1765951791'),
(36, NULL, '20223155eauteduvn', '$2y$10$OB/WCTIZkp7iJ0p7bW.1DuFyprGFmr8nEJBXp3WsYbSAQytk8Nbke', '20223155@gmail.com', '0388674883', 2000, 77000, 'in64W5K7rz2tCecmS1sIl8OyRBapouRW', 1, 0, '::1', '', 'off', 'off', NULL, NULL, NULL, 'off', '1766152494', '1766152526'),
(37, NULL, 'DungNB', '$2y$10$55W/k7RlbzIkIgghawBPD.S/9PRB0o5yudxQr0FIY5kDqlHfvub1G', 'nguyendung2004nb11@gmail.com', '034569871', 0, 0, 'EQNJy4vsRlQWuWotRJWFgB1Spz6J9nHj', 1, 0, '::1', '', 'off', 'off', NULL, NULL, NULL, 'off', '1766206473', '1766206473');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addon_vps`
--
ALTER TABLE `addon_vps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card_history`
--
ALTER TABLE `card_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_logs`
--
ALTER TABLE `chat_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_buy_hosting`
--
ALTER TABLE `history_buy_hosting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_recharge`
--
ALTER TABLE `history_recharge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `his_login`
--
ALTER TABLE `his_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `img_os`
--
ALTER TABLE `img_os`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_cloudvps`
--
ALTER TABLE `package_cloudvps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_hosting`
--
ALTER TABLE `package_hosting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchased_cloudvps`
--
ALTER TABLE `purchased_cloudvps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ranks`
--
ALTER TABLE `ranks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `server_hosting`
--
ALTER TABLE `server_hosting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addon_vps`
--
ALTER TABLE `addon_vps`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `card_history`
--
ALTER TABLE `card_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `chat_logs`
--
ALTER TABLE `chat_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `history_buy_hosting`
--
ALTER TABLE `history_buy_hosting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `history_recharge`
--
ALTER TABLE `history_recharge`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `his_login`
--
ALTER TABLE `his_login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `img_os`
--
ALTER TABLE `img_os`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `package_cloudvps`
--
ALTER TABLE `package_cloudvps`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `package_hosting`
--
ALTER TABLE `package_hosting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchased_cloudvps`
--
ALTER TABLE `purchased_cloudvps`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `ranks`
--
ALTER TABLE `ranks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `server_hosting`
--
ALTER TABLE `server_hosting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
