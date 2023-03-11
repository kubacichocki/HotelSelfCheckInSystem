-- Create database
CREATE DATABASE IF NOT EXISTS hotel_self_check_in;

-- select database
USE hotel_self_check_in;

-- Table structure for table rooms
CREATE TABLE `rooms` (
  `room_id` int(50) NOT NULL,
  `room_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `floor` int(15) NOT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Table structure for table users
CREATE TABLE `users` (
  `user_id` int(50) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Table structure for table reservations
CREATE TABLE `reservations` (
  `reservation_id` int(50) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `is_checked_in` BOOLEAN NOT NULL DEFAULT FALSE,
  `is_checked_out` BOOLEAN NOT NULL DEFAULT FALSE,
  `user_id` int(10) NOT NULL,
  `room_id` int(50),
  PRIMARY KEY (`reservation_id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`user_id`),
  FOREIGN KEY (`room_id`) REFERENCES rooms(`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table rooms
INSERT INTO `rooms` (`room_id`, `room_type`, `floor`)
VALUES
    ('101', 'single', '1'),
    ('102', 'double', '1'),
    ('103', 'twin', '1'),
    ('104', 'twin', '1'),
    ('105', 'single', '1'),
    ('106', 'double', '1'),
    ('201', 'twin', '2'),
    ('202', 'double', '2'),
    ('203', 'single', '2'),
    ('302', 'twin', '3'),
    ('303', 'single', '3'),
    ('304', 'twin', '3'),
    ('305', 'double', '3'),
    ('306', 'single', '3'),
    ('307', 'twin', '3'),
    ('401', 'twin', '4'),
    ('402', 'twin', '4'),
    ('403', 'double', '4'),
    ('404', 'twin', '4'),
    ('405', 'single', '4');

-- Data for table users
INSERT INTO `users` (`user_id`, `name`, `email`, `phone_number`)
VALUES 
('1', 'Patrick Randall', 'PatrickRandall@gmail.com', '+4477879195412'),
    ('2', 'Keira Parker', 'KeiraParker@jourrapide.com' , '+4477744834269'),
    ('3', 'Amelie Pickering', 'AmeliePickering@armyspy.com', '+4477843801161'),
    ('4', 'Spencer Blackburn', 'SpencerBlackburn@rhyta.com', '+4477949549646'),
    ('5', 'Thomas Myers', 'ThomasMyers@dayrep.com', '+4477744735473'),
    ('6', 'Nicholas Weston', 'NicholasWeston@yahoo.com', '+4477927460933'),
    ('7', 'Lewis Goodwin', 'LewisGoodwin@jourrapide.com', '+4477848629119'),
    ('8', 'Zoe Tyler', 'ZoeTyler@rhyta.com', '+4477751500008'),
    ('9', 'Madison Matthews', 'MadisonMatthews@gmail.com', '+4477965949879'),
    ('10', 'Courtney Giles', 'CourtneyGiles@dayrep.com', '+4477944785065'),
    ('11', 'Rebecca Coles', 'RebeccaColes@yahoo.com', '+4477748431596');

    -- Data for table reservations
INSERT INTO `reservations` (`reservation_id`,`check_in_date`, `check_out_date`, `user_id`, `room_id`)
VALUES
    ('12234', '2023-10-02', '2023-10-15', '5', NULL),
    ('12345', '2023-03-05', '2023-03-10', '2', NULL),
    ('12456', '2023-02-23', '2023-02-28', '1', NULL),
    ('12567', '2023-02-27', '2023-03-03', '1', NULL),
    ('12678', '2023-03-05', '2023-03-15', '6', NULL),
    ('12789', '2023-03-08', '2023-03-12', '5', NULL),
    ('12910', '2023-03-10', '2023-03-18', '4', NULL),
    ('12112', '2023-03-15', '2023-03-20', '5', NULL),
    ('12113', '2023-04-05', '2023-04-10', '2', NULL),
    ('12114', '2023-04-07', '2023-04-10', '3', NULL),
    ('12115', '2023-04-10', '2023-04-15', '4', NULL),
    ('12116', '2023-04-12', '2023-04-15', '8', NULL),
    ('12117', '2023-04-18', '2023-04-20', '7', NULL),
    ('12118', '2023-04-21', '2023-04-25', '9', NULL),
    ('12119', '2023-05-01', '2023-05-07', '11', NULL),
    ('12120', '2023-05-05', '2023-05-08', '1', NULL),
    ('12121', '2023-05-10', '2023-05-15', '2', NULL),
    ('12122', '2023-05-15', '2023-05-17', '4', NULL),
    ('12123', '2023-05-20', '2023-05-25', '6', NULL),
    ('12124', '2023-05-15', '2023-05-20', '3', NULL);