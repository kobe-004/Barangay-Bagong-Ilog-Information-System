-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2026 at 10:37 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bagong_ilog`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admin_password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `created_at`, `modified_at`, `admin_password`) VALUES
(1, 'veliganioroden0404@gmail.com', '2024-06-01 13:18:37', '2024-06-15 14:41:58', 'hello123');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcement_id` int(11) NOT NULL,
  `announcement_title` varchar(255) NOT NULL,
  `announcement_description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_announcement` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_id`, `announcement_title`, `announcement_description`, `date`, `status`, `timestamp`, `image_announcement`) VALUES
(2, 'New Feature Releases', 'We are excited to announce the release of our new feature.', '2024-06-05', 'active', '2024-06-15 02:12:50', 'IMG-666cf8a2c24bc7.16750420.png'),
(3, 'Scheduled Meetings', 'There will be a scheduled meeting for all staff on Friday.', '2024-04-03', 'active', '2024-06-15 02:13:01', 'IMG-666cf8ad802070.87891617.png'),
(4, 'Holiday Notice', 'The office will be closed on 4th of July in observance of Independence Day.', '2024-07-04', 'active', '2024-06-15 02:13:12', 'IMG-666cf8b834f451.10361553.png'),
(5, 'Policy Update', 'Please be aware of the new updates to our company policies.', '2024-06-11', 'active', '2024-06-15 02:13:28', 'IMG-666cf8c856a349.10762656.png'),
(9, 'Roden', 'announce', '2024-05-28', 'inactive', '2024-06-15 01:24:43', 'IMG-666af6e6977692.19574580.jpg'),
(10, 'Santacruzan', 'Ako', '2024-06-10', 'inactive', '2024-06-15 01:24:52', 'IMG-666aff9dac25c6.36256140.jpg'),
(11, 'Santacruzan', 'Ako', '2024-06-18', 'inactive', '2024-06-15 01:24:49', 'IMG-666b027d99d9b3.85259008.jpg'),
(12, 'QWWEQWEQW', 'Ako', '2024-06-27', 'inactive', '2024-06-15 01:24:54', 'IMG-666cadb5b6dba3.60675496.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE `audit_trail` (
  `audit_id` int(11) NOT NULL,
  `action_type` varchar(10) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `record_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `action_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_trail`
--

INSERT INTO `audit_trail` (`audit_id`, `action_type`, `table_name`, `record_id`, `admin_id`, `old_values`, `new_values`, `action_timestamp`) VALUES
(342, 'INSERT', 'resident', 81, 1, NULL, '{\"pending_id\":\"36\",\"last_name_pen\":\"Veliganio\",\"middle_name_pen\":\"Romano\",\"first_name_pen\":\"Roden\",\"birthday_pen\":\"2004-04-04\",\"age_pen\":\"20\",\"gender_pen\":\"Male\",\"civil_status_pen\":\"single\",\"occupation_pen\":\"Student\",\"house_number_pen\":\"650\",\"street_pen\":\"A. Flores Street\",\"education_pen\":\"College UnderGraduate\",\"registered_voter_pen\":\"yes\",\"email_pen\":\"veliganio_roden@plpasig.edu.ph\",\"password_pen\":\"roden1234\",\"existing_image_pen\":\"IMG-6662b73ac6fb49.85206290.png\",\"submitAcceptResident\":\"\"}', '2024-06-07 01:31:49'),
(343, 'UPDATE', 'pending_account', 36, 1, NULL, '{\"pending_id\":\"36\",\"last_name_pen\":\"Veliganio\",\"middle_name_pen\":\"Romano\",\"first_name_pen\":\"Roden\",\"birthday_pen\":\"2004-04-04\",\"age_pen\":\"20\",\"gender_pen\":\"Male\",\"civil_status_pen\":\"single\",\"occupation_pen\":\"Student\",\"house_number_pen\":\"650\",\"street_pen\":\"A. Flores Street\",\"education_pen\":\"College UnderGraduate\",\"registered_voter_pen\":\"yes\",\"email_pen\":\"veliganio_roden@plpasig.edu.ph\",\"password_pen\":\"roden1234\",\"existing_image_pen\":\"IMG-6662b73ac6fb49.85206290.png\",\"submitAcceptResident\":\"\"}', '2024-06-07 01:31:49'),
(344, 'INSERT', 'household', 343, 1, NULL, '{\"pending_id\":\"36\",\"last_name_pen\":\"Veliganio\",\"middle_name_pen\":\"Romano\",\"first_name_pen\":\"Roden\",\"birthday_pen\":\"2004-04-04\",\"age_pen\":\"20\",\"gender_pen\":\"Male\",\"civil_status_pen\":\"single\",\"occupation_pen\":\"Student\",\"house_number_pen\":\"650\",\"street_pen\":\"A. Flores Street\",\"education_pen\":\"College UnderGraduate\",\"registered_voter_pen\":\"yes\",\"email_pen\":\"veliganio_roden@plpasig.edu.ph\",\"password_pen\":\"roden1234\",\"existing_image_pen\":\"IMG-6662b73ac6fb49.85206290.png\",\"submitAcceptResident\":\"\"}', '2024-06-07 01:31:49'),
(345, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-07 01:36:22'),
(346, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-07 01:37:40'),
(347, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-07 01:44:07'),
(348, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-07 01:48:57'),
(349, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-07 01:49:48'),
(350, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-07 01:50:54'),
(351, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-07 01:52:04'),
(352, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-07 01:55:26'),
(353, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-07 02:01:49'),
(354, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-07 02:02:18'),
(355, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-07 02:07:42'),
(356, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-07 02:17:42'),
(357, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-07 02:17:52'),
(358, 'UPDATE', 'barangay_officials', 20, 1, NULL, NULL, '2024-06-07 11:40:31'),
(359, 'UPDATE', 'barangay_officials', 20, 1, NULL, NULL, '2024-06-07 11:40:45'),
(360, 'UPDATE', 'barangay_officials', 20, 1, NULL, NULL, '2024-06-07 11:42:17'),
(361, 'UPDATE', 'resident', 78, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 17:03:03'),
(362, 'UPDATE', 'resident', 78, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 19:32:06'),
(363, 'UPDATE', 'resident', 78, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 21:13:53'),
(364, 'INSERT', 'announcements', 11, 1, NULL, '{\"announcement_name\":\"Roden\",\"description\":\"asdadsad\",\"annnouncement_date\":\"2024-06-25\",\"submitAnnouncement\":\"Add Announcement\"}', '2024-06-07 21:56:33'),
(365, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:06:07'),
(366, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:06:09'),
(367, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:06:10'),
(368, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:06:11'),
(369, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:06:11'),
(370, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:06:11'),
(371, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:06:23'),
(372, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:06:39'),
(373, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:09:22'),
(374, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:09:32'),
(375, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:09:34'),
(376, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:09:48'),
(377, 'UPDATE', 'events', 0, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-07 22:09:49'),
(378, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-07 22:10:06'),
(379, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-07 22:10:35'),
(380, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:10:36'),
(381, 'UPDATE', 'events', 4, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:14:11'),
(382, 'UPDATE', 'events', 5, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:14:15'),
(383, 'UPDATE', 'events', 7, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 22:14:17'),
(384, 'UPDATE', 'events', 4, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-07 22:14:23'),
(385, 'UPDATE', 'events', 5, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-07 22:14:25'),
(386, 'UPDATE', 'events', 7, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-07 22:14:28'),
(387, 'UPDATE', 'resident', 78, 1, NULL, '{\"status\":\"active\"}', '2024-06-07 23:58:57'),
(388, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-08 00:38:35'),
(389, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"active\"}', '2024-06-08 00:38:37'),
(390, 'UPDATE', 'events', 11, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-08 00:38:42'),
(391, 'DELETE', 'announcement', 11, 1, NULL, NULL, '2024-06-08 00:38:45'),
(392, 'DELETE', 'events and announcement', 11, 1, NULL, NULL, '2024-06-08 00:41:18'),
(393, 'INSERT', 'announcements', 12, 1, NULL, '{\"announcement_name\":\"Roden\",\"description\":\"asdadasdas\",\"annnouncement_date\":\"2024-06-27\",\"submitAnnouncement\":\"Add Announcement\"}', '2024-06-08 00:41:32'),
(394, 'INSERT', 'announcements', 13, 1, NULL, '{\"announcement_name\":\"Roden\",\"description\":\"asdadasdas\",\"annnouncement_date\":\"2024-06-27\",\"submitAnnouncement\":\"Add Announcement\"}', '2024-06-08 00:41:55'),
(395, 'INSERT', 'announcements', 14, 1, NULL, '{\"announcement_name\":\"renzel\",\"description\":\"Ako\",\"annnouncement_date\":\"2024-06-12\",\"submitAnnouncement\":\"Add Announcement\"}', '2024-06-08 00:42:42'),
(396, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-08 00:45:29'),
(397, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-08 00:52:40'),
(398, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-08 00:52:51'),
(399, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-08 00:52:58'),
(400, 'UPDATE', 'resident', 78, 1, NULL, NULL, '2024-06-08 00:53:23'),
(401, 'UPDATE', 'barangay_officials', 20, 1, NULL, NULL, '2024-06-08 01:08:28'),
(402, 'UPDATE', 'barangay_officials', 20, 1, NULL, NULL, '2024-06-08 01:08:34'),
(403, 'UPDATE', 'barangay_officials', 20, 1, NULL, NULL, '2024-06-08 01:08:41'),
(404, 'UPDATE', 'announcement', 0, 1, NULL, NULL, '2024-06-08 01:46:01'),
(405, 'UPDATE', 'announcement', 0, 1, NULL, NULL, '2024-06-08 01:46:07'),
(406, 'UPDATE', 'announcement', 0, 1, NULL, NULL, '2024-06-08 02:29:13'),
(407, 'UPDATE', 'announcement', 0, 1, NULL, NULL, '2024-06-08 02:38:06'),
(408, 'UPDATE', 'events', 8, 1, NULL, NULL, '2024-06-08 02:45:56'),
(409, 'UPDATE', 'resident', 78, 1, NULL, '{\"status\":\"active\"}', '2024-06-08 04:34:16'),
(410, 'UPDATE', 'barangay_officials', 20, 1, NULL, NULL, '2024-06-08 05:10:50'),
(411, 'UPDATE', 'hotline_numbers', 1, 1, NULL, NULL, '2024-06-08 05:10:58'),
(412, 'UPDATE', 'events', 8, 1, NULL, NULL, '2024-06-08 05:11:11'),
(413, 'INSERT', 'resident', 113, 1, NULL, '{\"last_name\":\"Capalaran\",\"middle_name\":\"Vidallo\",\"first_name\":\"Myrro Earl\",\"birthday\":\"2023-02-10\",\"age\":\"1\",\"gender\":\"Male\",\"civil_status\":\"married\",\"occupation\":\"Student\",\"house_number\":\"65B\",\"street\":\"Danny Floro\",\"education\":\"College Undergraduate\",\"registered_voter\":\"no\",\"submitResident\":\"\"}', '2024-06-08 05:17:23'),
(414, 'INSERT', 'household', 413, 1, NULL, '{\"last_name\":\"Capalaran\",\"middle_name\":\"Vidallo\",\"first_name\":\"Myrro Earl\",\"birthday\":\"2023-02-10\",\"age\":\"1\",\"gender\":\"Male\",\"civil_status\":\"married\",\"occupation\":\"Student\",\"house_number\":\"65B\",\"street\":\"Danny Floro\",\"education\":\"College Undergraduate\",\"registered_voter\":\"no\",\"submitResident\":\"\"}', '2024-06-08 05:17:23'),
(415, 'UPDATE', 'events', 12, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-08 05:29:31'),
(416, 'UPDATE', 'events', 13, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-08 05:29:31'),
(417, 'UPDATE', 'events', 14, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-08 05:29:32'),
(418, 'INSERT', 'announcements', 15, 1, NULL, '{\"announcement_name\":\"Meeting sa Konoha \",\"description\":\"Kagesamit \",\"annnouncement_date\":\"2024-06-12\",\"submitAnnouncement\":\"Add Announcement\"}', '2024-06-08 05:30:19'),
(419, 'INSERT', 'announcements', 16, 1, NULL, '{\"announcement_name\":\"Purok Leader Meeting\",\"description\":\"Meeting of street leaders\",\"annnouncement_date\":\"2024-06-17\",\"submitAnnouncement\":\"Add Announcement\"}', '2024-06-08 05:31:16'),
(420, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-08 05:40:31'),
(421, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-08 05:40:43'),
(422, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-08 05:42:00'),
(423, 'UPDATE', 'hotline_numbers', 1, 1, NULL, NULL, '2024-06-08 05:42:14'),
(424, 'UPDATE', 'events', 8, 1, NULL, NULL, '2024-06-08 08:57:09'),
(425, 'UPDATE', 'events', 15, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-08 08:57:28'),
(426, 'UPDATE', 'events', 12, 1, NULL, '{\"status\":\"active\"}', '2024-06-08 08:57:29'),
(427, 'UPDATE', 'events', 12, 1, NULL, '{\"status\":\"active\"}', '2024-06-08 09:17:23'),
(428, 'UPDATE', 'events', 12, 1, NULL, '{\"status\":\"active\"}', '2024-06-08 09:18:09'),
(429, 'UPDATE', 'events', 12, 1, NULL, '{\"status\":\"active\"}', '2024-06-08 09:22:27'),
(430, 'UPDATE', 'events', 12, 1, NULL, '{\"status\":\"active\"}', '2024-06-08 09:22:52'),
(431, 'UPDATE', 'events', 12, 1, NULL, '{\"status\":\"active\"}', '2024-06-08 09:25:44'),
(432, 'UPDATE', 'events', 12, 1, NULL, '{\"status\":\"active\"}', '2024-06-08 09:25:46'),
(433, 'UPDATE', 'events', 12, 1, NULL, '{\"status\":\"active\"}', '2024-06-08 09:26:42'),
(434, 'UPDATE', 'events', 12, 1, NULL, '{\"status\":\"active\"}', '2024-06-08 09:27:33'),
(435, 'UPDATE', 'events', 12, 1, NULL, '{\"status\":\"active\"}', '2024-06-08 09:29:09'),
(436, 'UPDATE', 'events', 12, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-08 09:38:04'),
(437, 'INSERT', 'announcements', 17, 1, NULL, '{\"announcement_name\":\"Santacruzan\",\"description\":\"Festival\",\"annnouncement_date\":\"2024-06-11\",\"submitAnnouncement\":\"Add Announcement\"}', '2024-06-08 09:38:52'),
(438, 'DELETE', 'events and announcement', 12, 1, NULL, NULL, '2024-06-08 09:38:58'),
(439, 'UPDATE', 'announcement', 16, 1, NULL, NULL, '2024-06-12 02:36:21'),
(440, 'UPDATE', 'announcement', 16, 1, NULL, NULL, '2024-06-12 02:36:31'),
(441, 'UPDATE', 'events', 8, 1, NULL, NULL, '2024-06-12 02:37:39'),
(442, 'UPDATE', 'events', 9, 1, NULL, NULL, '2024-06-12 02:37:45'),
(443, 'UPDATE', 'events', 10, 1, NULL, NULL, '2024-06-12 02:37:50'),
(444, 'UPDATE', 'announcement', 17, 1, NULL, NULL, '2024-06-12 02:37:59'),
(445, 'UPDATE', 'announcement', 16, 1, NULL, NULL, '2024-06-12 02:40:04'),
(446, 'UPDATE', 'announcement', 16, 1, NULL, NULL, '2024-06-12 02:43:30'),
(447, 'UPDATE', 'announcement', 16, 1, NULL, NULL, '2024-06-12 02:44:27'),
(448, 'UPDATE', 'announcement', 16, 1, NULL, NULL, '2024-06-12 02:46:00'),
(449, 'UPDATE', 'announcement', 3, 1, NULL, NULL, '2024-06-12 02:46:06'),
(450, 'UPDATE', 'announcement', 3, 1, NULL, NULL, '2024-06-12 02:47:31'),
(451, 'UPDATE', 'events', 8, 1, NULL, NULL, '2024-06-12 02:48:36'),
(452, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-12 04:40:34'),
(453, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-12 04:40:37'),
(454, 'UPDATE', 'barangay_officials', 20, 1, NULL, NULL, '2024-06-12 04:40:43'),
(455, 'UPDATE', 'barangay_officials', 21, 1, NULL, NULL, '2024-06-13 07:18:21'),
(456, 'UPDATE', 'barangay_officials', 22, 1, NULL, NULL, '2024-06-13 07:18:27'),
(457, 'UPDATE', 'barangay_officials', 23, 1, NULL, NULL, '2024-06-13 07:18:33'),
(458, 'UPDATE', 'barangay_officials', 24, 1, NULL, NULL, '2024-06-13 07:18:39'),
(459, 'UPDATE', 'barangay_officials', 25, 1, NULL, NULL, '2024-06-13 07:18:49'),
(460, 'UPDATE', 'barangay_officials', 26, 1, NULL, NULL, '2024-06-13 07:18:55'),
(461, 'UPDATE', 'barangay_officials', 27, 1, NULL, NULL, '2024-06-13 07:19:05'),
(462, 'DELETE', 'barangay_official', 28, 1, NULL, NULL, '2024-06-13 07:19:53'),
(463, 'DELETE', 'barangay_official', 29, 1, NULL, NULL, '2024-06-13 07:19:55'),
(464, 'DELETE', 'barangay_official', 30, 1, NULL, NULL, '2024-06-13 07:19:57'),
(465, 'DELETE', 'barangay_official', 31, 1, NULL, NULL, '2024-06-13 07:19:59'),
(466, 'INSERT', 'announcements', 8, 1, NULL, '{\"announcement_name\":\"Roden\",\"description\":\"asdadasdas\",\"annnouncement_date\":\"2024-05-27\",\"submitAnnouncement\":\"Add Announcement\"}', '2024-06-13 07:38:49'),
(467, 'UPDATE', 'announcement', 8, 1, NULL, NULL, '2024-06-13 07:38:58'),
(468, 'INSERT', 'announcements', 9, 1, NULL, '{\"announcement_name\":\"Roden\",\"description\":\"announce\",\"annnouncement_date\":\"2024-05-28\",\"submitAnnouncement\":\"Add Announcement\"}', '2024-06-13 07:40:54'),
(469, 'UPDATE', 'events', 8, 1, NULL, NULL, '2024-06-13 07:46:24'),
(470, 'UPDATE', 'announcement', 2, 1, NULL, NULL, '2024-06-13 07:49:32'),
(471, 'UPDATE', 'announcement', 5, 1, NULL, NULL, '2024-06-13 07:57:02'),
(472, 'UPDATE', 'announcement', 5, 1, NULL, NULL, '2024-06-13 07:58:05'),
(473, 'UPDATE', 'announcement', 2, 1, NULL, NULL, '2024-06-13 08:00:42'),
(474, 'UPDATE', 'announcement', 8, 1, NULL, NULL, '2024-06-13 08:01:12'),
(475, 'UPDATE', 'announcement', 8, 1, NULL, NULL, '2024-06-13 08:01:23'),
(476, 'UPDATE', 'announcement', 3, 1, NULL, NULL, '2024-06-13 08:03:15'),
(477, 'UPDATE', 'announcement', 3, 1, NULL, NULL, '2024-06-13 08:03:22'),
(478, 'UPDATE', 'announcement', 3, 1, NULL, NULL, '2024-06-13 08:08:17'),
(479, 'UPDATE', 'announcement', 2, 1, NULL, NULL, '2024-06-13 08:08:32'),
(480, 'UPDATE', 'announcement', 2, 1, NULL, NULL, '2024-06-13 08:09:01'),
(481, 'UPDATE', 'announcement', 2, 1, NULL, NULL, '2024-06-13 08:11:33'),
(482, 'INSERT', 'announcements', 10, 1, NULL, '{\"announcement_name\":\"Santacruzan\",\"description\":\"Ako\",\"annnouncement_date\":\"2024-06-10\",\"submitAnnouncement\":\"Add Announcement\"}', '2024-06-13 08:18:05'),
(483, 'UPDATE', 'announcement', 8, 1, NULL, NULL, '2024-06-13 08:18:18'),
(484, 'UPDATE', 'announcement', 8, 1, NULL, NULL, '2024-06-13 08:18:27'),
(485, 'UPDATE', 'announcement', 5, 1, NULL, NULL, '2024-06-13 08:18:49'),
(486, 'UPDATE', 'announcement', 3, 1, NULL, NULL, '2024-06-13 08:18:56'),
(487, 'UPDATE', 'announcement', 3, 1, NULL, NULL, '2024-06-13 08:19:04'),
(488, 'UPDATE', 'announcement', 3, 1, NULL, NULL, '2024-06-13 08:19:11'),
(489, 'UPDATE', 'announcement', 10, 1, NULL, NULL, '2024-06-13 08:19:26'),
(490, 'UPDATE', 'announcement', 8, 1, NULL, NULL, '2024-06-13 08:24:49'),
(491, 'UPDATE', 'announcement', 8, 1, NULL, NULL, '2024-06-13 08:25:00'),
(492, 'UPDATE', 'announcement', 5, 1, NULL, NULL, '2024-06-13 08:25:07'),
(493, 'UPDATE', 'announcement', 4, 1, NULL, NULL, '2024-06-13 08:26:11'),
(494, 'UPDATE', 'announcement', 8, 1, NULL, NULL, '2024-06-13 08:29:11'),
(495, 'INSERT', 'announcements', 11, 1, NULL, '{\"announcement_name\":\"Santacruzan\",\"description\":\"Ako\",\"annnouncement_date\":\"2024-06-18\",\"submitAnnouncement\":\"Add Announcement\"}', '2024-06-13 08:30:21'),
(496, 'UPDATE', 'announcement', 5, 1, NULL, NULL, '2024-06-13 08:30:43'),
(497, 'UPDATE', 'announcement', 2, 1, NULL, NULL, '2024-06-13 08:35:34'),
(498, 'UPDATE', 'announcement', 3, 1, NULL, NULL, '2024-06-13 08:35:42'),
(499, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 12:58:17'),
(500, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 12:58:23'),
(501, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:01:14'),
(502, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:01:44'),
(503, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:02:05'),
(504, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:02:33'),
(505, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:02:40'),
(506, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:02:42'),
(507, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:03:24'),
(508, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:03:45'),
(509, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:03:46'),
(510, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:26'),
(511, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:26'),
(512, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:38'),
(513, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:38'),
(514, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:38'),
(515, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:39'),
(516, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:39'),
(517, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:39'),
(518, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:41'),
(519, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:41'),
(520, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:41'),
(521, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:42'),
(522, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:53'),
(523, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:54'),
(524, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:54'),
(525, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:54'),
(526, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:05:54'),
(527, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:06:03'),
(528, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:06:03'),
(529, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:06:08'),
(530, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:06:09'),
(531, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:06:09'),
(532, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:06:09'),
(533, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:08:56'),
(534, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:09:11'),
(535, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-14 13:09:12'),
(536, 'UPDATE', 'events', 4, 1, NULL, '{\"status\":\"active\"}', '2024-06-14 14:37:51'),
(537, 'UPDATE', 'events', 4, 1, NULL, '{\"status\":\"active\"}', '2024-06-14 14:39:16'),
(538, 'UPDATE', 'events', 4, 1, NULL, '{\"status\":\"active\"}', '2024-06-14 14:39:32'),
(539, 'UPDATE', 'events', 4, 1, NULL, '{\"status\":\"active\"}', '2024-06-14 14:41:33'),
(540, 'UPDATE', 'events', 4, 1, NULL, '{\"status\":\"active\"}', '2024-06-14 14:42:07'),
(541, 'UPDATE', 'events', 4, 1, NULL, '{\"status\":\"active\"}', '2024-06-14 14:42:22'),
(542, 'UPDATE', 'events', 4, 1, NULL, '{\"status\":\"active\"}', '2024-06-14 14:42:38'),
(543, 'UPDATE', 'events', 4, 1, NULL, '{\"status\":\"active\"}', '2024-06-14 14:42:42'),
(544, 'UPDATE', 'events', 5, 1, NULL, '{\"status\":\"active\"}', '2024-06-14 14:43:08'),
(545, 'INSERT', 'announcements', 12, 1, NULL, '{\"announcement_name\":\"QWWEQWEQW\",\"description\":\"Ako\",\"annnouncement_date\":\"2024-06-27\",\"submitAnnouncement\":\"Add Announcement\"}', '2024-06-14 14:53:09'),
(546, 'UPDATE', 'announcement', 4, 1, NULL, NULL, '2024-06-14 19:12:41'),
(547, 'UPDATE', 'announcement', 5, 1, NULL, NULL, '2024-06-14 19:13:46'),
(548, 'INSERT', 'resident', 120, 1, NULL, '{\"pending_id\":\"38\",\"last_name_pen\":\"Veliganio\",\"middle_name_pen\":\"Romano\",\"first_name_pen\":\"Roden\",\"birthday_pen\":\"2024-06-10\",\"age_pen\":\"0\",\"gender_pen\":\"Male\",\"civil_status_pen\":\"widowed\",\"occupation_pen\":\"Student\",\"house_number_pen\":\"650\",\"street_pen\":\"Avis Extension\",\"education_pen\":\"College UnderGraduate\",\"registered_voter_pen\":\"no\",\"email_pen\":\"kobeveliganio444@gmail.com\",\"password_pen\":\"roden1234\",\"existing_image_pen\":\"IMG-666b0a2cebeb19.09426076.jpg\",\"submitAcceptResident\":\"\"}', '2024-06-14 19:21:45'),
(549, 'UPDATE', 'pending_account', 38, 1, NULL, '{\"pending_id\":\"38\",\"last_name_pen\":\"Veliganio\",\"middle_name_pen\":\"Romano\",\"first_name_pen\":\"Roden\",\"birthday_pen\":\"2024-06-10\",\"age_pen\":\"0\",\"gender_pen\":\"Male\",\"civil_status_pen\":\"widowed\",\"occupation_pen\":\"Student\",\"house_number_pen\":\"650\",\"street_pen\":\"Avis Extension\",\"education_pen\":\"College UnderGraduate\",\"registered_voter_pen\":\"no\",\"email_pen\":\"kobeveliganio444@gmail.com\",\"password_pen\":\"roden1234\",\"existing_image_pen\":\"IMG-666b0a2cebeb19.09426076.jpg\",\"submitAcceptResident\":\"\"}', '2024-06-14 19:21:45'),
(550, 'INSERT', 'household', 549, 1, NULL, '{\"pending_id\":\"38\",\"last_name_pen\":\"Veliganio\",\"middle_name_pen\":\"Romano\",\"first_name_pen\":\"Roden\",\"birthday_pen\":\"2024-06-10\",\"age_pen\":\"0\",\"gender_pen\":\"Male\",\"civil_status_pen\":\"widowed\",\"occupation_pen\":\"Student\",\"house_number_pen\":\"650\",\"street_pen\":\"Avis Extension\",\"education_pen\":\"College UnderGraduate\",\"registered_voter_pen\":\"no\",\"email_pen\":\"kobeveliganio444@gmail.com\",\"password_pen\":\"roden1234\",\"existing_image_pen\":\"IMG-666b0a2cebeb19.09426076.jpg\",\"submitAcceptResident\":\"\"}', '2024-06-14 19:21:45'),
(551, 'UPDATE', 'announcement', 8, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-14 19:24:40'),
(552, 'UPDATE', 'announcement', 9, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-14 19:24:43'),
(553, 'UPDATE', 'announcement', 11, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-14 19:24:49'),
(554, 'UPDATE', 'announcement', 10, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-14 19:24:52'),
(555, 'UPDATE', 'announcement', 12, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-14 19:24:54'),
(556, 'UPDATE', 'events', 5, 1, NULL, NULL, '2024-06-14 20:12:13'),
(557, 'UPDATE', 'announcement', 2, 1, NULL, NULL, '2024-06-14 20:12:50'),
(558, 'UPDATE', 'announcement', 3, 1, NULL, NULL, '2024-06-14 20:13:01'),
(559, 'UPDATE', 'announcement', 4, 1, NULL, NULL, '2024-06-14 20:13:12'),
(560, 'UPDATE', 'announcement', 5, 1, NULL, NULL, '2024-06-14 20:13:28'),
(561, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-15 01:03:21'),
(562, 'UPDATE', 'barangay_official', 20, 1, NULL, NULL, '2024-06-15 01:07:33'),
(563, 'UPDATE', 'events', 7, 1, NULL, '{\"status\":\"active\"}', '2024-06-15 01:09:22'),
(564, 'UPDATE', 'events', 7, 1, NULL, '{\"status\":\"inactive\"}', '2024-06-15 01:09:28'),
(565, 'DELETE', 'events', 7, 1, NULL, NULL, '2024-06-15 01:10:42'),
(566, 'DELETE', 'events', 15, 1, NULL, NULL, '2024-06-15 01:11:02'),
(567, 'DELETE', 'events', 14, 1, NULL, NULL, '2024-06-15 01:11:48'),
(568, 'DELETE', 'events and announcement', 1, 1, NULL, NULL, '2024-06-15 01:13:34'),
(569, 'DELETE', 'events and announcement', 1, 1, NULL, NULL, '2024-06-15 01:13:38'),
(570, 'DELETE', 'events and announcement', 1, 1, NULL, NULL, '2024-06-15 01:15:20'),
(571, 'DELETE', 'events and announcement', 8, 1, NULL, NULL, '2024-06-15 01:16:18'),
(572, 'DELETE', 'events', 13, 1, NULL, NULL, '2024-06-15 02:20:37'),
(573, 'INSERT', 'resident', 121, 1, NULL, '{\"pending_id\":\"37\",\"last_name_pen\":\"Gerona\",\"middle_name_pen\":\"Barredo\",\"first_name_pen\":\"Lorence\",\"birthday_pen\":\"2004-09-24\",\"age_pen\":\"19\",\"gender_pen\":\"Male\",\"civil_status_pen\":\"married\",\"occupation_pen\":\"Student\",\"house_number_pen\":\"39\",\"street_pen\":\"Francisco Street\",\"education_pen\":\"College UnderGraduate\",\"registered_voter_pen\":\"yes\",\"email_pen\":\"rencegeron55@gmail.com\",\"password_pen\":\"lorence1234\",\"existing_image_pen\":\"IMG-66642cb9b24a90.02590414.png\",\"submitAcceptResident\":\"\"}', '2024-06-16 07:20:52'),
(574, 'UPDATE', 'pending_account', 37, 1, NULL, '{\"pending_id\":\"37\",\"last_name_pen\":\"Gerona\",\"middle_name_pen\":\"Barredo\",\"first_name_pen\":\"Lorence\",\"birthday_pen\":\"2004-09-24\",\"age_pen\":\"19\",\"gender_pen\":\"Male\",\"civil_status_pen\":\"married\",\"occupation_pen\":\"Student\",\"house_number_pen\":\"39\",\"street_pen\":\"Francisco Street\",\"education_pen\":\"College UnderGraduate\",\"registered_voter_pen\":\"yes\",\"email_pen\":\"rencegeron55@gmail.com\",\"password_pen\":\"lorence1234\",\"existing_image_pen\":\"IMG-66642cb9b24a90.02590414.png\",\"submitAcceptResident\":\"\"}', '2024-06-16 07:20:52'),
(575, 'INSERT', 'household', 574, 1, NULL, '{\"pending_id\":\"37\",\"last_name_pen\":\"Gerona\",\"middle_name_pen\":\"Barredo\",\"first_name_pen\":\"Lorence\",\"birthday_pen\":\"2004-09-24\",\"age_pen\":\"19\",\"gender_pen\":\"Male\",\"civil_status_pen\":\"married\",\"occupation_pen\":\"Student\",\"house_number_pen\":\"39\",\"street_pen\":\"Francisco Street\",\"education_pen\":\"College UnderGraduate\",\"registered_voter_pen\":\"yes\",\"email_pen\":\"rencegeron55@gmail.com\",\"password_pen\":\"lorence1234\",\"existing_image_pen\":\"IMG-66642cb9b24a90.02590414.png\",\"submitAcceptResident\":\"\"}', '2024-06-16 07:20:52'),
(576, 'INSERT', 'resident', 122, 1, NULL, '{\"pending_id\":\"39\",\"last_name_pen\":\"Veliganio\",\"middle_name_pen\":\"Romano\",\"first_name_pen\":\"Clark\",\"birthday_pen\":\"2006-07-09\",\"age_pen\":\"17\",\"gender_pen\":\"Male\",\"civil_status_pen\":\"single\",\"occupation_pen\":\"Student\",\"house_number_pen\":\"650\",\"street_pen\":\"Arayat\",\"education_pen\":\"College UnderGraduate\",\"registered_voter_pen\":\"yes\",\"email_pen\":\"impreso_gemaica@plpasig.edu.ph\",\"password_pen\":\"gem123\",\"image_pen\":\"\",\"existing_image_pen\":\"IMG-666ff4b48af530.52401096.png\",\"submitAcceptResident\":\"\"}', '2024-06-17 02:33:26'),
(577, 'UPDATE', 'pending_account', 39, 1, NULL, '{\"pending_id\":\"39\",\"last_name_pen\":\"Veliganio\",\"middle_name_pen\":\"Romano\",\"first_name_pen\":\"Clark\",\"birthday_pen\":\"2006-07-09\",\"age_pen\":\"17\",\"gender_pen\":\"Male\",\"civil_status_pen\":\"single\",\"occupation_pen\":\"Student\",\"house_number_pen\":\"650\",\"street_pen\":\"Arayat\",\"education_pen\":\"College UnderGraduate\",\"registered_voter_pen\":\"yes\",\"email_pen\":\"impreso_gemaica@plpasig.edu.ph\",\"password_pen\":\"gem123\",\"image_pen\":\"\",\"existing_image_pen\":\"IMG-666ff4b48af530.52401096.png\",\"submitAcceptResident\":\"\"}', '2024-06-17 02:33:26'),
(578, 'INSERT', 'household', 577, 1, NULL, '{\"pending_id\":\"39\",\"last_name_pen\":\"Veliganio\",\"middle_name_pen\":\"Romano\",\"first_name_pen\":\"Clark\",\"birthday_pen\":\"2006-07-09\",\"age_pen\":\"17\",\"gender_pen\":\"Male\",\"civil_status_pen\":\"single\",\"occupation_pen\":\"Student\",\"house_number_pen\":\"650\",\"street_pen\":\"Arayat\",\"education_pen\":\"College UnderGraduate\",\"registered_voter_pen\":\"yes\",\"email_pen\":\"impreso_gemaica@plpasig.edu.ph\",\"password_pen\":\"gem123\",\"image_pen\":\"\",\"existing_image_pen\":\"IMG-666ff4b48af530.52401096.png\",\"submitAcceptResident\":\"\"}', '2024-06-17 02:33:26');

-- --------------------------------------------------------

--
-- Table structure for table `bagong_ilog_streets`
--

CREATE TABLE `bagong_ilog_streets` (
  `street_id` int(11) NOT NULL,
  `street_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bagong_ilog_streets`
--

INSERT INTO `bagong_ilog_streets` (`street_id`, `street_name`) VALUES
(1, 'Avis Extension'),
(2, 'Santiago Street'),
(3, 'Riverside Street'),
(4, 'San Roque Extension'),
(5, 'C5 G. Salonga'),
(6, 'Victorino Street'),
(7, 'Aurellana Street'),
(8, 'Avis (Kanan)'),
(9, 'F. Intalan Street'),
(10, 'San Roque Street'),
(11, 'Ikong Street'),
(12, 'Avis (Kaliwa)'),
(13, 'Limjoco Street'),
(14, 'Francisco Street'),
(15, 'M. Flores Street'),
(16, 'L. Intalan Street'),
(17, 'Velazquez Street'),
(18, 'R. Valdez Street'),
(19, 'Sgt. Pacua Street'),
(20, 'Pook Maligaya'),
(21, 'Valiente Street'),
(22, 'San Buenaventura (Kaliwa)'),
(23, 'A. Flores Street'),
(24, 'R. Valdez Extension'),
(25, 'Sgt. Santos Street'),
(26, 'B. Tatco Street'),
(27, 'Sgt. Santos Extension'),
(28, 'Ilaya A. Flores'),
(29, 'SRDL (Atom)'),
(30, 'San Buenaventura (Kanan)'),
(31, 'Retelco Drive'),
(32, 'Joe Borris'),
(33, 'CPI Cruz'),
(34, 'E. Mejia Street (Hilltop)'),
(35, 'F. Pike'),
(36, 'Aldion Compound'),
(37, 'Lakeview'),
(38, 'Arayat'),
(39, 'Danny Floro'),
(40, 'Kawilihan Village'),
(41, 'Lumier');

-- --------------------------------------------------------

--
-- Table structure for table `barangay_official`
--

CREATE TABLE `barangay_official` (
  `official_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `term_start` date NOT NULL,
  `term_end` date NOT NULL,
  `image` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_official`
--

INSERT INTO `barangay_official` (`official_id`, `first_name`, `middle_name`, `last_name`, `age`, `position`, `term_start`, `term_end`, `image`, `status`) VALUES
(20, 'Ferdinand', 'A.', 'Aviss', 41, 'Punong Barangay', '2024-06-12', '2024-06-19', 'IMG-6663467925f833.67839559.jpeg', 'active'),
(21, 'Cire', 'Yam', 'Gallano', 32, 'Kagawad', '2024-06-04', '2024-06-14', 'IMG-6660270f1d4502.42507046.jpeg', 'active'),
(22, 'Cesar', 'A.', 'Avis', 43, 'Kagawad', '2024-06-11', '2024-06-18', 'IMG-666027c2b29334.40739596.jpeg', 'active'),
(23, 'R.', 'Edgar', 'Angelo', 43, 'Kagawad', '2024-06-18', '2024-06-10', 'IMG-666027eedc3b68.85045672.jpeg', 'active'),
(24, 'M.', 'Michael', 'Estioco', 34, 'Kagawad', '2024-06-17', '2024-07-05', 'IMG-6660282dad48f6.09766236.jpeg', 'active'),
(25, 'P.', 'Rino', 'Intalan', 43, 'Kagawad', '2024-06-18', '2024-06-21', 'IMG-66602879e9e107.42768328.jpeg', 'active'),
(26, 'P.', 'Virgilio', 'Inocencio', 43, 'Kagawad', '2024-06-19', '2024-06-28', 'IMG-666028b36e05f6.27883852.jpeg', 'active'),
(27, 'M.', 'Arvin', 'Banaag', 43, 'Kagawad', '2024-06-26', '2024-06-19', 'IMG-666028e87a8441.99709628.jpeg', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `Event_ID` int(11) NOT NULL,
  `Event_Name` varchar(255) NOT NULL,
  `Type_of_Event` varchar(100) NOT NULL,
  `Date` date NOT NULL,
  `image` text DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`Event_ID`, `Event_Name`, `Type_of_Event`, `Date`, `image`, `status`) VALUES
(4, 'Art Exhibitions', 'Exhibition', '2024-07-20', 'IMG-665c7428c2c862.12576530.png', 'active'),
(5, 'Tech Meetup', 'Sample', '2024-11-30', 'IMG-665647e5a1ac87.94801657.png', 'active'),
(8, 'OPLAN LIBRENG TULI', 'Summer Event', '2024-01-18', 'IMG-6661746eeb5be4.00859018.png', 'active'),
(9, 'OPLAN LIBRENG TULI', 'Festival Events', '2024-05-31', 'IMG-666175331c0041.62406829.png', 'active'),
(10, 'LIBRENG EHERSISYO PARA KAY LOLO AT LOLA', 'Health Events', '2024-05-29', 'IMG-666175ae552205.65006002.png', 'active'),
(16, 'Purok Leader Meeting', '', '2024-06-17', 'IMG-66644104247155.91886022.png', 'active'),
(17, 'Santacruzan', '', '2024-06-11', 'IMG-66647b0c9a72a9.78635774.png', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `gender_id` int(11) NOT NULL,
  `gender_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`gender_id`, `gender_name`) VALUES
(1, 'Male'),
(2, 'Female'),
(3, 'Non-Binary'),
(4, 'Gender Queer'),
(5, 'Gender Fluid'),
(6, 'Agender'),
(7, 'Bigender');

-- --------------------------------------------------------

--
-- Table structure for table `hotline_numbers`
--

CREATE TABLE `hotline_numbers` (
  `Hotline_id` int(11) NOT NULL,
  `Department_Name` varchar(255) DEFAULT NULL,
  `Department_Number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotline_numbers`
--

INSERT INTO `hotline_numbers` (`Hotline_id`, `Department_Name`, `Department_Number`) VALUES
(1, 'Barangay Hotline', '09128154041'),
(2, 'Philippine National Police', '8477-7953'),
(3, 'Bureau Of Fire Protection', '8641-2815'),
(4, 'Pasig City DRRMO', '8643-0000'),
(5, 'Pasig City General Hospital', '8643-3333/8642-7379/8642-7381');

-- --------------------------------------------------------

--
-- Table structure for table `household`
--

CREATE TABLE `household` (
  `Household_ID` int(11) NOT NULL,
  `Last_name` varchar(255) DEFAULT NULL,
  `Middle_name` varchar(255) DEFAULT NULL,
  `First_name` varchar(255) DEFAULT NULL,
  `Street` varchar(255) DEFAULT NULL,
  `House_number` varchar(50) DEFAULT NULL,
  `Head_of_family` varchar(5) DEFAULT NULL,
  `House_structure` varchar(255) DEFAULT NULL,
  `Water_supply` varchar(255) DEFAULT NULL,
  `Residential_status` varchar(255) DEFAULT NULL,
  `Electricity` varchar(50) DEFAULT NULL,
  `Head_last_name` varchar(255) DEFAULT NULL,
  `Head_middle_name` varchar(255) DEFAULT NULL,
  `Head_first_name` varchar(255) DEFAULT NULL,
  `Relation_to_head` varchar(255) DEFAULT NULL,
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `resident_id` int(11) DEFAULT NULL,
  `pending_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `household`
--

INSERT INTO `household` (`Household_ID`, `Last_name`, `Middle_name`, `First_name`, `Street`, `House_number`, `Head_of_family`, `House_structure`, `Water_supply`, `Residential_status`, `Electricity`, `Head_last_name`, `Head_middle_name`, `Head_first_name`, `Relation_to_head`, `modified_at`, `resident_id`, `pending_id`) VALUES
(85, 'Zane', 'Lorence', 'Barredo', 'Arayat', '65B', 'Yes', 'Cemented', 'Public Water Supply', 'Owned,Caretaker', 'Own Meter', '', '', '', '', '2024-06-07 22:36:10', NULL, NULL),
(88, 'Smith', 'John', 'Doe', 'A. Flores Street', '12A', 'yes', 'Cemented', 'Public Water Supply', 'Owned', 'Own Meter', NULL, NULL, NULL, NULL, '2024-06-07 23:35:59', NULL, NULL),
(89, 'Johnson', 'Ann', 'Marie', 'Aldion Compound', '34', 'yes', 'Cemented', 'Public Water Supply', 'Owned', 'Own Meter', NULL, NULL, NULL, NULL, '2024-06-07 23:35:59', NULL, NULL),
(90, 'Williams', 'James', 'L', 'Arayat', '56', 'yes', 'Wooden', 'Private Water Supply', 'Rented', 'Shared Meter', NULL, NULL, NULL, NULL, '2024-06-07 23:35:59', NULL, NULL),
(91, 'Brown', 'Emma', 'S', 'Aurellana Street', '78B', 'yes', 'Cemented', 'Public Water Supply', 'Owned', 'Own Meter', NULL, NULL, NULL, NULL, '2024-06-07 23:35:59', NULL, NULL),
(92, 'Jones', 'Michael', 'T', 'Avis (Kaliwa)', '90', 'yes', 'Wooden', 'Public Water Supply', 'Caretaker', 'No Meter', NULL, NULL, NULL, NULL, '2024-06-07 23:35:59', NULL, NULL),
(93, 'Smith', 'Jane', 'Doe', 'A. Flores Street', '12A', 'no', NULL, NULL, NULL, NULL, 'Smith', 'John', 'Doe', 'Spouse', '2024-06-07 23:39:31', NULL, NULL),
(94, 'Smith', 'Tom', 'Doe', 'A. Flores Street', '12A', 'no', NULL, NULL, NULL, NULL, 'Smith', 'John', 'Doe', 'Child', '2024-06-07 23:39:31', NULL, NULL),
(95, 'Johnson', 'Jack', 'Marie', 'Aldion Compound', '34', 'no', NULL, NULL, NULL, NULL, 'Johnson', 'Ann', 'Marie', 'Spouse', '2024-06-07 23:39:31', NULL, NULL),
(96, 'Johnson', 'Jill', 'Marie', 'Aldion Compound', '34', 'no', NULL, NULL, NULL, NULL, 'Johnson', 'Ann', 'Marie', 'Child', '2024-06-07 23:39:31', NULL, NULL),
(97, 'Williams', 'Lily', 'L', 'Arayat', '56', 'no', NULL, NULL, NULL, NULL, 'Williams', 'James', 'L', 'Spouse', '2024-06-07 23:39:31', NULL, NULL),
(98, 'Williams', 'Lucas', 'L', 'Arayat', '56', 'no', NULL, NULL, NULL, NULL, 'Williams', 'James', 'L', 'Child', '2024-06-07 23:39:31', NULL, NULL),
(99, 'Brown', 'Grace', 'S', 'Aurellana Street', '78B', 'no', NULL, NULL, NULL, NULL, 'Brown', 'Emma', 'S', 'Spouse', '2024-06-07 23:39:31', NULL, NULL),
(100, 'Brown', 'Gary', 'S', 'Aurellana Street', '78B', 'no', NULL, NULL, NULL, NULL, 'Brown', 'Emma', 'S', 'Child', '2024-06-07 23:39:31', NULL, NULL),
(101, 'Jones', 'Linda', 'T', 'Avis (Kaliwa)', '90', 'no', NULL, NULL, NULL, NULL, 'Jones', 'Michael', 'T', 'Spouse', '2024-06-07 23:39:31', NULL, NULL),
(102, 'Jones', 'Leo', 'T', 'Avis (Kaliwa)', '90', 'no', NULL, NULL, NULL, NULL, 'Jones', 'Michael', 'T', 'Child', '2024-06-07 23:39:31', NULL, NULL),
(103, 'Smith', 'Mark', 'Doe', 'A. Flores Street', '12A', 'no', NULL, NULL, NULL, NULL, 'Smith', 'John', 'Doe', 'Child', '2024-06-07 23:39:31', NULL, NULL),
(104, 'Johnson', 'Sophia', 'Marie', 'Aldion Compound', '34', 'no', NULL, NULL, NULL, NULL, 'Johnson', 'Ann', 'Marie', 'Child', '2024-06-07 23:39:31', NULL, NULL),
(105, 'Williams', 'Paul', 'L', 'Arayat', '56', 'no', NULL, NULL, NULL, NULL, 'Williams', 'James', 'L', 'Child', '2024-06-07 23:39:31', NULL, NULL),
(106, 'Brown', 'Eva', 'S', 'Aurellana Street', '78B', 'no', NULL, NULL, NULL, NULL, 'Brown', 'Emma', 'S', 'Child', '2024-06-07 23:39:31', NULL, NULL),
(107, 'Jones', 'Amy', 'T', 'Avis (Kaliwa)', '90', 'no', NULL, NULL, NULL, NULL, 'Jones', 'Michael', 'T', 'Child', '2024-06-07 23:39:31', NULL, NULL),
(108, 'Smith', 'Nancy', 'Doe', 'A. Flores Street', '12A', 'no', NULL, NULL, NULL, NULL, 'Smith', 'John', 'Doe', 'Child', '2024-06-07 23:39:31', NULL, NULL),
(109, 'Johnson', 'Mia', 'Marie', 'Aldion Compound', '34', 'no', NULL, NULL, NULL, NULL, 'Johnson', 'Ann', 'Marie', 'Child', '2024-06-07 23:39:31', NULL, NULL),
(110, 'Williams', 'Peter', 'L', 'Arayat', '56', 'no', NULL, NULL, NULL, NULL, 'Williams', 'James', 'L', 'Child', '2024-06-07 23:39:31', NULL, NULL),
(111, 'Brown', 'Ella', 'S', 'Aurellana Street', '78B', 'no', NULL, NULL, NULL, NULL, 'Brown', 'Emma', 'S', 'Child', '2024-06-07 23:39:31', NULL, NULL),
(112, 'Jones', 'Max', 'T', 'Avis (Kaliwa)', '90', 'no', NULL, NULL, NULL, NULL, 'Jones', 'Michael', 'T', 'Child', '2024-06-07 23:39:31', NULL, NULL),
(113, 'Capalaran', 'Vidallo', 'Myrro Earl', 'Danny Floro', '65B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-08 11:17:23', 79, NULL),
(114, 'Zane', 'Lorence', 'Barredo', 'A. Flores Street', '65B', 'No', '', 'Own Meter,Public Water Supply', NULL, 'Own Meter', '', '', '', 'Spouse', '2024-06-08 11:35:38', NULL, NULL),
(115, 'Zane', 'Lorence', 'Barredo', 'A. Flores Street;', '65B', 'Yes', 'Wood/Stone', 'Public Water Supply', 'Owned,Caretaker', 'Sub Meter', '', '', '', '', '2024-06-13 18:09:36', NULL, NULL),
(116, 'Zane', 'Lorence', 'Barredo', 'A. Flores Street;', '65B', 'Yes', 'Wood/Stone,Cemented,With CR', 'Own Meter,Public Water Supply', 'Owned,Rented,Caretaker', 'Own Meter,Sub Meter', '', '', '', '', '2024-06-13 18:11:03', NULL, NULL),
(118, 'Zane', 'Barredo', 'Lorence', 'A. Flores Street;', '65B', 'Yes', 'With CR', 'Public Water Supply', 'Owned', 'Own Meter', '', '', '', '', '2024-06-13 18:26:55', NULL, NULL),
(119, 'Velganio', 'Romano', 'Roden', 'Danny Floro;', '65B', 'Yes', 'With CR', 'Public Water Supply', 'Caretaker', 'Own Meter', '', '', '', '', '2024-06-13 18:41:26', NULL, NULL),
(120, 'Veliganio', 'Romano', 'Roden', 'Avis Extension', '650', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15 01:21:44', NULL, 38),
(121, 'Gerona', 'Barredo', 'Lorence', 'Francisco Street', '39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-16 13:20:52', NULL, 37),
(122, 'Veliganio', 'Romano', 'Clark', 'Arayat', '650', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-17 08:33:26', NULL, 39);

-- --------------------------------------------------------

--
-- Table structure for table `pending_account`
--

CREATE TABLE `pending_account` (
  `pending_id` int(11) NOT NULL,
  `Last_name` varchar(50) DEFAULT NULL,
  `Middle_name` varchar(50) DEFAULT NULL,
  `First_name` varchar(50) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` varchar(50) DEFAULT NULL,
  `Civil_Status` varchar(50) DEFAULT NULL,
  `Occupation` varchar(70) DEFAULT NULL,
  `house_number` varchar(255) DEFAULT NULL,
  `Educational_Attainment` varchar(70) DEFAULT NULL,
  `Registered_Voter` varchar(10) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` varchar(70) NOT NULL DEFAULT 'Pending',
  `Email` varchar(70) DEFAULT NULL,
  `Password` varchar(70) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_account`
--

INSERT INTO `pending_account` (`pending_id`, `Last_name`, `Middle_name`, `First_name`, `Birthday`, `Age`, `Gender`, `Civil_Status`, `Occupation`, `house_number`, `Educational_Attainment`, `Registered_Voter`, `image`, `status`, `Email`, `Password`, `street`) VALUES
(36, 'Veliganio', 'Romano', 'Roden', '2004-04-04', 20, 'Male', 'single', 'Student', '650', 'College UnderGraduate', 'yes', 'IMG-6662b73ac6fb49.85206290.png', 'accepted', 'veliganio_roden@plpasig.edu.ph', 'roden1234', 'A. Flores Street'),
(37, 'Gerona', 'Barredo', 'Lorence', '2004-09-24', 19, 'Male', 'married', 'Student', '39', 'College UnderGraduate', 'yes', 'IMG-66642cb9b24a90.02590414.png', 'accepted', 'rencegeron55@gmail.com', 'lorence1234', 'Francisco Street'),
(38, 'Veliganio', 'Romano', 'Roden', '2024-06-10', 0, 'Male', 'widowed', 'Student', '650', 'College UnderGraduate', 'no', 'IMG-666b0a2cebeb19.09426076.jpg', 'Pending', 'kobeveliganio444@gmail.com', 'roden1234', 'Avis Extension'),
(39, 'Veliganio', 'Romano', 'Clark', '2006-07-09', 17, 'Male', 'single', 'Student', '650', 'College UnderGraduate', 'yes', 'IMG-666ff4b48af530.52401096.png', 'accepted', 'impreso_gemaica@plpasig.edu.ph', 'gem123', 'Arayat');

-- --------------------------------------------------------

--
-- Table structure for table `pending_documents`
--

CREATE TABLE `pending_documents` (
  `pending_document_id` int(11) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `document_type` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `reason_for_application` varchar(255) DEFAULT NULL,
  `business_name` varchar(150) DEFAULT NULL,
  `requirement` varchar(255) DEFAULT NULL,
  `status` varchar(70) NOT NULL DEFAULT 'Pending',
  `created_at` date DEFAULT curdate(),
  `business_location` varchar(255) DEFAULT NULL,
  `email_user` varchar(255) DEFAULT NULL,
  `requester_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_documents`
--

INSERT INTO `pending_documents` (`pending_document_id`, `full_name`, `document_type`, `address`, `reason_for_application`, `business_name`, `requirement`, `status`, `created_at`, `business_location`, `email_user`, `requester_name`) VALUES
(11, 'Lorence Barredo Lorence', NULL, '65B Arayat, Barangay Bagong Ilog, Pasig City ', 'Good Moral', NULL, NULL, 'Accepted', '2024-06-07', NULL, 'veliganio_roden@plpasig.edu.ph', ''),
(12, 'Lorence Barredo Lorence', NULL, '65B Arayat ', 'Good Moral', NULL, NULL, 'Accepted', '2024-06-07', NULL, 'veliganio_roden@plpasig.edu.ph', ''),
(13, 'Lorence Barredo Lorence', 'Barangay Clearance', '65B Arayat ', 'Good Moral', NULL, NULL, 'Accepted', '2024-06-07', NULL, 'veliganio_roden@plpasig.edu.ph', ''),
(14, NULL, 'Business Clearance', NULL, NULL, 'Tindahan', NULL, 'Accepted', '2024-06-07', NULL, 'veliganio_roden@plpasig.edu.ph', ''),
(15, 'Lorence Barredo Lorence', 'Business Clearance', NULL, NULL, 'Tindahan', NULL, 'Accepted', '2024-06-07', 'Bagong Ilog', 'veliganio_roden@plpasig.edu.ph', ''),
(16, NULL, 'Business Clearance', NULL, NULL, NULL, NULL, 'Accepted', '2024-06-08', NULL, 'veliganio_roden@plpasig.edu.ph', ''),
(17, NULL, 'Business Clearance', NULL, NULL, NULL, NULL, 'Pending', '2024-06-08', NULL, 'veliganio_roden@plpasig.edu.ph', ''),
(18, 'Lorence Barredo Lorence', 'Barangay Indigency', '65B Arayat', 'Scholar', NULL, NULL, 'Pending', '2024-06-08', NULL, 'veliganio_roden@plpasig.edu.ph', 'Gerona'),
(19, 'Lorence Barredo Gerona', 'Barangay Indigency', '65B Arayat', 'Scholar', NULL, NULL, 'Pending', '2024-06-08', NULL, 'veliganio_roden@plpasig.edu.ph', 'Gerona'),
(20, 'Lorence Barredo Zane', 'Barangay Clearance', '65B Arayat ', 'Good Moral', NULL, NULL, 'Accepted', '2024-06-08', NULL, 'veliganio_roden@plpasig.edu.ph', ''),
(21, 'Lorence Barredo Zane', 'Barangay Clearance', '65B Arayat ', 'Scholar', NULL, NULL, 'Accepted', '2024-06-08', NULL, 'veliganio_roden@plpasig.edu.ph', ''),
(22, 'Lorence Barredo Zane', 'Barangay Clearance', '65B Arayat ', 'Scholar', NULL, NULL, 'Accepted', '2024-06-08', NULL, 'veliganio_roden@plpasig.edu.ph', ''),
(23, 'Lorence Barredo Zane', 'Business Clearance', NULL, NULL, 'Tindahan', NULL, 'Pending', '2024-06-08', 'Bagong Ilog', 'veliganio_roden@plpasig.edu.ph', ''),
(24, 'Lorence Barredo Zane', 'Barangay Clearance', '65B A. Flores Street ', 'Good Moral', NULL, NULL, 'Pending', '2024-06-08', NULL, 'veliganio_roden@plpasig.edu.ph', ''),
(25, 'Lorence Barredo Zane', 'Barangay Clearance', '65B A. Flores Street ', 'Scholarship', NULL, NULL, 'Accepted', '2024-06-08', NULL, 'veliganio_roden@plpasig.edu.ph', ''),
(26, 'Lorence Barredo Zane', 'Barangay Clearance', '65B A. Flores Street ', 'Good Moral', NULL, NULL, 'Pending', '2024-06-13', NULL, 'veliganio_roden@plpasig.edu.ph', ''),
(27, 'Lorence Barredo Zane', 'Barangay Clearance', '65B A. Flores Street ', 'Scholar', NULL, NULL, 'Pending', '2024-06-13', NULL, 'veliganio_roden@plpasig.edu.ph', ''),
(28, 'Lorence Barredo Zane', 'Barangay Clearance', '65B A. Flores Street ', 'Scholar', NULL, NULL, 'Pending', '2024-06-13', NULL, 'veliganio_roden@plpasig.edu.ph', ''),
(29, 'Lorence Barredo Zane', 'Barangay Clearance', '65B A. Flores Street ', 'Good Moral', NULL, NULL, 'Pending', '2024-06-13', NULL, 'veliganio_roden@plpasig.edu.ph', ''),
(30, 'Roden Romano Velganio', 'Barangay Clearance', '65B Danny Floro ', 'Good Moral', NULL, NULL, 'Pending', '2024-06-14', NULL, 'rodenrommano@gmail.com', ''),
(31, 'Roden Romano Velganio', 'Business Clearance', NULL, NULL, 'Roden\'s Pagupitan', NULL, 'Pending', '2024-06-14', 'Bagong Ilog', 'rodenrommano@gmail.com', ''),
(32, 'Clark Romano Veliganio', 'Barangay Indigency', '650 Arayat', 'Good Moral', NULL, NULL, 'Pending', '2024-06-17', NULL, 'impreso_gemaica@plpasig.edu.ph', 'Gerona'),
(33, 'Clark Romano Veliganio', 'Business Clearance', NULL, NULL, 'Tindahan', NULL, 'Pending', '2024-06-17', 'Bagong Ilog', 'impreso_gemaica@plpasig.edu.ph', ''),
(34, 'Clark Romano Veliganio', 'Barangay Clearance', '650 Arayat ', 'Good Moral', NULL, NULL, 'Pending', '2024-06-17', NULL, 'impreso_gemaica@plpasig.edu.ph', ''),
(35, 'Lorence Barredo Zane', 'Barangay Clearance', '65B A. Flores Street ', 'Good Moral', NULL, NULL, 'Pending', '2024-12-03', NULL, 'veliganio_roden@plpasig.edu.ph', '');

-- --------------------------------------------------------

--
-- Table structure for table `resident`
--

CREATE TABLE `resident` (
  `resident_id` int(11) NOT NULL,
  `Last_name` varchar(50) DEFAULT NULL,
  `Middle_name` varchar(50) DEFAULT NULL,
  `First_name` varchar(50) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` varchar(50) DEFAULT NULL,
  `Civil_Status` varchar(50) DEFAULT NULL,
  `Occupation` varchar(70) DEFAULT NULL,
  `house_number` varchar(70) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `Educational_Attainment` varchar(70) DEFAULT NULL,
  `Registered_Voter` varchar(10) DEFAULT NULL,
  `status` varchar(70) DEFAULT 'active',
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resident`
--

INSERT INTO `resident` (`resident_id`, `Last_name`, `Middle_name`, `First_name`, `Birthday`, `Age`, `Gender`, `Civil_Status`, `Occupation`, `house_number`, `street`, `Educational_Attainment`, `Registered_Voter`, `status`, `modified_at`, `Email`, `Password`, `image`) VALUES
(78, 'Zane', 'Barredo', 'Lorence', '2004-07-07', 21, 'Bigender', 'Single', 'Developer', '65B', 'A. Flores Street', 'College UnderGraduate', 'Yes', 'inactive', '2024-12-03 10:05:15', 'veliganio_roden@plpasig.edu.ph', 'onac123', 'IMG-6664442552ff17.31587250.png'),
(79, 'Velganio', 'Romano', 'Roden', '2023-02-10', 1, 'Male', 'married', 'Student', '65B', 'Danny Floro', 'College Undergraduate', 'no', 'active', '2024-06-15 13:19:48', 'rodenromano@gmail.com', 'orims123', 'IMG-66643dc3274694.87140813.png'),
(80, 'Veliganio', 'Romano', 'Roden', '2024-06-10', 0, 'Male', 'widowed', 'Student', '650', 'Avis Extension', 'College UnderGraduate', 'no', 'active', '2024-12-12 13:20:40', 'kobeveliganio444@gmail.com', '12345', 'IMG-666b0a2cebeb19.09426076.jpg'),
(81, 'Gerona', 'Barredo', 'Lorence', '2004-09-24', 19, 'Male', 'married', 'Student', '39', 'Francisco Street', 'College UnderGraduate', 'yes', 'active', '2024-06-16 13:20:52', 'rencegeron55@gmail.com', 'lorence1234', 'IMG-66642cb9b24a90.02590414.png'),
(82, 'Veliganio', 'Romano', 'Clark', '2006-07-09', 17, 'Male', 'single', 'Student', '650', 'Arayat', 'College UnderGraduate', 'yes', 'active', '2024-06-17 08:33:26', 'impreso_gemaica@plpasig.edu.ph', 'gem123', 'IMG-666ff4b48af530.52401096.png');

-- --------------------------------------------------------

--
-- Table structure for table `statistics`
--

CREATE TABLE `statistics` (
  `statistic` varchar(250) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statistics`
--

INSERT INTO `statistics` (`statistic`, `content`) VALUES
('City Name', 'Pasig City'),
('Congressional District', 'District I'),
('Legal Basis of Creation', 'R.A. 7160'),
('Land Area', '120 hectares'),
('Total Population', '5'),
('Number of Households', '2582'),
('Number of Families', '5787'),
('Total Registered Voters', '11249'),
('Number of Precincts', '13'),
('Total Number of Zones', '15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indexes for table `bagong_ilog_streets`
--
ALTER TABLE `bagong_ilog_streets`
  ADD PRIMARY KEY (`street_id`);

--
-- Indexes for table `barangay_official`
--
ALTER TABLE `barangay_official`
  ADD PRIMARY KEY (`official_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`Event_ID`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`gender_id`);

--
-- Indexes for table `hotline_numbers`
--
ALTER TABLE `hotline_numbers`
  ADD PRIMARY KEY (`Hotline_id`);

--
-- Indexes for table `household`
--
ALTER TABLE `household`
  ADD PRIMARY KEY (`Household_ID`),
  ADD KEY `fk_resident` (`resident_id`),
  ADD KEY `fk_pending_account` (`pending_id`);

--
-- Indexes for table `pending_account`
--
ALTER TABLE `pending_account`
  ADD PRIMARY KEY (`pending_id`);

--
-- Indexes for table `pending_documents`
--
ALTER TABLE `pending_documents`
  ADD PRIMARY KEY (`pending_document_id`);

--
-- Indexes for table `resident`
--
ALTER TABLE `resident`
  ADD PRIMARY KEY (`resident_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `audit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=579;

--
-- AUTO_INCREMENT for table `bagong_ilog_streets`
--
ALTER TABLE `bagong_ilog_streets`
  MODIFY `street_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `barangay_official`
--
ALTER TABLE `barangay_official`
  MODIFY `official_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `Event_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `gender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hotline_numbers`
--
ALTER TABLE `hotline_numbers`
  MODIFY `Hotline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `household`
--
ALTER TABLE `household`
  MODIFY `Household_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `pending_account`
--
ALTER TABLE `pending_account`
  MODIFY `pending_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `pending_documents`
--
ALTER TABLE `pending_documents`
  MODIFY `pending_document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `resident`
--
ALTER TABLE `resident`
  MODIFY `resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `household`
--
ALTER TABLE `household`
  ADD CONSTRAINT `fk_pending_account` FOREIGN KEY (`pending_id`) REFERENCES `pending_account` (`pending_id`),
  ADD CONSTRAINT `fk_resident` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
