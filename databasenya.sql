-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2018 at 02:15 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fp_mbd`
--

DELIMITER $$
--
-- Procedures
--
CREATE  PROCEDURE `sp_bayar` (`p_orderid` INT)  BEGIN
		if exists (select 1 from `tbl_order` where `order_id`= p_orderid) then
			update `tbl_order` set `status`= 'dibayar' where `order_id`=p_orderid;
			update `tblorderproduct` set `status`='dibayar' where `order_id`=p_orderid;
		end if;
	END$$

CREATE  PROCEDURE `sp_edit` (`p_productid` INT, `p_nama` VARCHAR(255), `p_price` DOUBLE, `p_jenis` VARCHAR(2))  BEGIN
	IF EXISTS (SELECT 1 FROM tbl_product WHERE product_id=p_productid) THEN
	update tbl_product set Nama=p_nama, price=p_price, Jenis=p_jenis where product_id=p_productid;
	SELECT 1;
	ELSE SELECT 0;
	END IF;
		
	END$$

CREATE  PROCEDURE `sp_getidusr` (`p_name` VARCHAR(255))  BEGIN
	SELECT person_id FROM tbl_person WHERE `name`=p_name;
    END$$

CREATE  PROCEDURE `sp_getoid` (`p_date` DATETIME)  BEGIN
	SELECT order_id from tbl_order where order_date=p_date;
    END$$

CREATE  PROCEDURE `sp_lihatpesan` (`p_orderid` INT)  BEGIN
select
  `tbl_order`.`order_id` AS `order_id`,
  `tbl_order`.`order_date` AS `order_date`,
  tbl_order.`person_id` AS `person_id`,
  `tbl_product`.`Nama`     AS `Nama`,
  tblorderproduct.`quantity` AS `quantity`,
  `tblorderproduct`.`status`     AS `status`
  
from ((`tblorderproduct`
    join `tbl_order`
      on ((`tblorderproduct`.`order_id` = `tbl_order`.`order_id`)))
   join `tbl_product`
     on ((`tblorderproduct`.`product_id` = `tbl_product`.`product_id`)))
     where tbl_order.`order_id`=p_orderid;
	END$$

CREATE  PROCEDURE `sp_login` (`p_name` VARCHAR(255), `p_password` VARCHAR(50))  BEGIN
	IF EXISTS(SELECT 1 FROM `tbl_person`
		where `name`=p_name and `password`= md5(p_password)) THEN
		SELECT 1;
	else if exists(SELECT 1 FROM `tbl_waitreess`
		where `name`=p_name and `password`= md5(p_password)) THEN
		SELECT `waitreess_id` from `tbl_waitreess` where `name`=p_name;
	ELSE
		SELECT -1;
	END IF;
	END IF;
    END$$

CREATE  PROCEDURE `sp_mulai` (`p_orderid` INT, `p_personid` INT, `p_orderdate` DATETIME, `p_status` VARCHAR(30))  BEGIN
	insert into `tbl_order`(`order id`,`person id`,`order date`,`status`)
		values(p_orderid,p_personid,p_orderdate,p_status);

END$$

CREATE  PROCEDURE `sp_order` (`p_personid` INT, `p_date` DATETIME, `p_status` VARCHAR(30))  BEGIN
	insert into `tbl_order`(`person_id`,`order_date`,`status`) values (p_personid,p_date,p_status);
	
    END$$

CREATE  PROCEDURE `sp_pesan` (`p_orderid` INT, `p_productid` INT, `p_quantity` INT)  BEGIN
	insert into `tblorderproduct`(`order_id`,`product_id`,`quantity`,`status`)
		values(p_orderid,p_productid,p_quantity,'dipesan');

END$$

CREATE  PROCEDURE `sp_tambahmenu` (`p_nama` VARCHAR(100), `p_harga` DOUBLE, `p_jenis` VARCHAR(2))  BEGIN
if not exists (select 1 from tbl_product where Nama=p_nama) then
	INSERT INTO tbl_product(Nama,price,Jenis)
		VALUES(p_nama,p_harga,p_jenis);
	select 0, 'tambah menu sukses';
	else select -1, 'Gagal, menu sudah ada!';
	end if;
		
	END$$

CREATE  PROCEDURE `sp_ubahstat` (`p_orderid` INT, `p_productid` INT, `p_status` VARCHAR(30))  BEGIN
		if exists (select 1 from `tbl_order` where `order_id`=p_orderid) then
			update `tblorderproduct` set `status`= p_status where `product_id`=p_productid and `order_id`=p_orderid;
			select 1;
		else select -1;
		end if;
	END$$

--
-- Functions
--
CREATE  FUNCTION `fn_cekstatus` (`p_orderid` INT) RETURNS TINYINT(1) BEGIN
	-- aktifitas user paling akhir kurang dari 3 hari yang lalu
	SET @jumlah = (
		select count(`status`) from tblorderproduct where tblorderproduct.order_id=p_orderid and tblorderproduct.`status`<>'dimasak'
		);
	RETURN (@jumlah);
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblorderproduct`
--

CREATE TABLE `tblorderproduct` (
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`id`, `name`, `code`, `image`, `price`) VALUES
(1, '3D Camera', '3DcAM01', 'product-images/camera.jpg', 1500.00),
(2, 'External Hard Drive', 'USB02', 'product-images/external-hard-drive.jpg', 800.00),
(3, 'Wrist Watch', 'wristWear03', 'product-images/watch.jpg', 300.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jenis`
--

CREATE TABLE `tbl_jenis` (
  `jenis` varchar(2) NOT NULL,
  `nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_jenis`
--

INSERT INTO `tbl_jenis` (`jenis`, `nama`) VALUES
('A', 'Acai'),
('B', 'Blended'),
('C', 'Coffee'),
('E', 'Sweet Treats'),
('K', 'Topping Food'),
('N', 'Topping Drinks'),
('O', 'Others'),
('P', 'Pasta'),
('R', 'Rice'),
('S', 'Shared Bites'),
('T', 'Tea'),
('W', 'Western');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `order_id` int(11) NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_person`
--

CREATE TABLE `tbl_person` (
  `person_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` char(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_person`
--

INSERT INTO `tbl_person` (`person_id`, `name`, `password`) VALUES
(1, 'meja1', '10705f86b703823d889c434c01419350'),
(2, 'meja2', '7b2c6d18787edfdbfd9e67ccdbb15c4b'),
(3, 'meja3', 'e37d2cd2c6fda2c179aa38efcaad5c49'),
(4, 'meja4', '16d8fbd62375c5a77962ffd96c9275a2'),
(5, 'meja5', '334399afe2f67145c62d4e9773f8c2e3'),
(6, 'meja6', 'd07cf74071a8cae70ad0eb6c79928f88'),
(7, 'meja7', 'f797f82f9a74d685af9bc0029589122e');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(11) NOT NULL,
  `Nama` varchar(255) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `Jenis` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `Nama`, `price`, `Jenis`) VALUES
(1, 'chili beef fries or nachos', 30, 'S'),
(2, 'cheesy mix fries', 28, 'S'),
(3, 'libreria fried sampler', 30, 'S'),
(4, 'seafood sampler', 32, 'S'),
(5, 'cheesy pizza', 47, 'S'),
(6, 'mushroom pizza', 50, 'S'),
(7, 'supreme pizza', 48, 'S'),
(8, 'meatlover pizza', 50, 'S'),
(9, 'grilled chicken salad', 30, 'W'),
(10, 'meatballsmash', 40, 'W'),
(11, 'chicken \'n chips parmigiana', 40, 'W'),
(12, 'house burger', 40, 'W'),
(13, 'coney dog', 42, 'W'),
(14, 'all day egg', 42, 'W'),
(15, 'sausage and egg', 42, 'W'),
(16, 'bbq chicken steak', 42, 'W'),
(17, 'aglio olio', 33, 'P'),
(18, 'seafood mariana', 33, 'P'),
(19, 'chicken pesto', 33, 'P'),
(20, 'carbonara', 33, 'P'),
(21, 'bolognese', 33, 'P'),
(22, 'chicken katsu woku', 30, 'R'),
(23, 'dory sambal matah', 30, 'R'),
(24, 'nasi goreng libreria', 30, 'R'),
(25, 'nasi gila', 30, 'R'),
(26, 'hot beef rice', 30, 'R'),
(27, 'crushed chicken rice', 30, 'R'),
(28, 'salted egg chicken rice', 32, 'R'),
(29, 'beef bulgogi rice', 32, 'R'),
(30, 'mango acai bowl', 35, 'A'),
(31, 'dragonfruit acai bowl', 35, 'A'),
(32, 'egg', 6, 'K'),
(33, 'rice', 6, 'K'),
(34, 'cheddar cheese', 8, 'K'),
(35, 'mushroom', 8, 'K'),
(36, 'cheese sauce', 8, 'K'),
(37, 'sausage', 12, 'K'),
(38, 'mozarella cheese', 12, 'K'),
(39, 'espresso', 13, 'C'),
(40, 'double espresso', 15, 'C'),
(41, 'americano hot', 17, 'C'),
(42, 'americano ice', 20, 'C'),
(43, 'piccolo', 22, 'C'),
(44, 'cappuccino hot', 25, 'C'),
(45, 'cappuccino ice', 30, 'C'),
(46, 'latte hot', 27, 'C'),
(47, 'latte ice', 30, 'C'),
(48, 'caramel latte hot', 30, 'C'),
(49, 'caramel latte ice', 33, 'C'),
(50, 'hazelnut latte hot', 30, 'C'),
(51, 'hazelnut latte ice', 33, 'C'),
(52, 'mocha caramel frappe', 35, 'C'),
(53, 'salted caramel frape', 35, 'C'),
(54, 'baileys frappe', 35, 'C'),
(55, 'tiramisu', 35, 'C'),
(56, 'hot tea bag by dilmah', 25, 'T'),
(57, 'hot tea pot by gryphon', 30, 'T'),
(58, 'iced tea', 16, 'T'),
(59, 'iced longan tea', 25, 'T'),
(60, 'iced apple tea', 25, 'T'),
(61, 'iced lemon tea', 25, 'T'),
(62, 'iced berry tea', 25, 'T'),
(63, 'iced aloe lavender tea', 25, 'T'),
(64, 'iced thai tea', 25, 'T'),
(65, 'cookies \'n cream', 32, 'B'),
(66, 'choco cookies \'n cream', 32, 'B'),
(67, 'vanilla hazelnut frappe', 32, 'B'),
(68, 'vanilla milkshake', 32, 'B'),
(69, 'choco milkshake', 32, 'B'),
(70, 'choco peanut butter', 35, 'B'),
(71, 'oatvomaltine', 35, 'B'),
(72, 'stracciatella chocochips', 35, 'B'),
(73, 'lemon sorbet', 27, 'O'),
(74, 'strawberry sorbet', 27, 'O'),
(75, 'kiwi cucumber soda', 30, 'O'),
(76, 'honey longan lime soda', 30, 'O'),
(77, 'strawberry smoothies', 32, 'O'),
(78, 'mango yoghhurt', 32, 'O'),
(79, 'green tea hot', 30, 'O'),
(80, 'green tea ice', 35, 'O'),
(81, 'taro hot', 30, 'O'),
(82, 'taro ice', 35, 'O'),
(83, 'red velvet hot', 30, 'O'),
(84, 'red velvet ice', 35, 'O'),
(85, 'chocolate hot', 30, 'O'),
(86, 'chocolate ice', 32, 'O'),
(87, 'mineral water (600 ml)', 16, 'O'),
(88, 'affogato', 21, 'E'),
(89, 'pancake with ice cream', 28, 'E'),
(90, 'waffle with ice cream', 28, 'E'),
(91, 'classic american style pancake', 28, 'E'),
(92, 'cookie dough brownies', 30, 'E'),
(93, 'ovomaltine smores waffle', 30, 'E'),
(94, 'ice cream', 8, 'N'),
(95, 'extra caramel', 8, 'N'),
(96, 'extra hazelnut', 8, 'N'),
(97, 'extra choco', 8, 'N'),
(98, 'extra maple', 8, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_waitreess`
--

CREATE TABLE `tbl_waitreess` (
  `waitreess_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` char(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_waitreess`
--

INSERT INTO `tbl_waitreess` (`waitreess_id`, `name`, `password`) VALUES
(5, 'pelayan', '511cc40443f2a1ab03ab373b77d28091'),
(6, 'koki', 'c38be0f1f87d0e77a0cd2fe6941253eb'),
(7, 'kasir', 'c7911af3adbd12a035b289556d96470a'),
(8, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_acai`
-- (See below for the actual view)
--
CREATE TABLE `v_acai` (
`product_id` int(11)
,`Nama` varchar(255)
,`price` double
,`Jenis` varchar(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_blended`
-- (See below for the actual view)
--
CREATE TABLE `v_blended` (
`product_id` int(11)
,`Nama` varchar(255)
,`price` double
,`Jenis` varchar(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_coffee`
-- (See below for the actual view)
--
CREATE TABLE `v_coffee` (
`product_id` int(11)
,`Nama` varchar(255)
,`price` double
,`Jenis` varchar(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_others`
-- (See below for the actual view)
--
CREATE TABLE `v_others` (
`product_id` int(11)
,`Nama` varchar(255)
,`price` double
,`Jenis` varchar(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pasta`
-- (See below for the actual view)
--
CREATE TABLE `v_pasta` (
`product_id` int(11)
,`Nama` varchar(255)
,`price` double
,`Jenis` varchar(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pembayaran`
-- (See below for the actual view)
--
CREATE TABLE `v_pembayaran` (
`order_id` int(11)
,`person_id` int(11)
,`product_id` int(11)
,`Nama` varchar(255)
,`price` double
,`order_date` datetime
,`quantity` int(11)
,`status` varchar(30)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pemesanan`
-- (See below for the actual view)
--
CREATE TABLE `v_pemesanan` (
`order_id` int(11)
,`person_id` int(11)
,`product_id` int(11)
,`Nama` varchar(255)
,`order_date` datetime
,`quantity` int(11)
,`status` varchar(30)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_rice`
-- (See below for the actual view)
--
CREATE TABLE `v_rice` (
`product_id` int(11)
,`Nama` varchar(255)
,`price` double
,`Jenis` varchar(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_sajikan`
-- (See below for the actual view)
--
CREATE TABLE `v_sajikan` (
`order_id` int(11)
,`person_id` int(11)
,`product_id` int(11)
,`Nama` varchar(255)
,`order_date` datetime
,`quantity` int(11)
,`status` varchar(30)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_sharedbites`
-- (See below for the actual view)
--
CREATE TABLE `v_sharedbites` (
`product_id` int(11)
,`Nama` varchar(255)
,`price` double
,`Jenis` varchar(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_sweet`
-- (See below for the actual view)
--
CREATE TABLE `v_sweet` (
`product_id` int(11)
,`Nama` varchar(255)
,`price` double
,`Jenis` varchar(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_tea`
-- (See below for the actual view)
--
CREATE TABLE `v_tea` (
`product_id` int(11)
,`Nama` varchar(255)
,`price` double
,`Jenis` varchar(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_topdrinks`
-- (See below for the actual view)
--
CREATE TABLE `v_topdrinks` (
`product_id` int(11)
,`Nama` varchar(255)
,`price` double
,`Jenis` varchar(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_topfood`
-- (See below for the actual view)
--
CREATE TABLE `v_topfood` (
`product_id` int(11)
,`Nama` varchar(255)
,`price` double
,`Jenis` varchar(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_western`
-- (See below for the actual view)
--
CREATE TABLE `v_western` (
`product_id` int(11)
,`Nama` varchar(255)
,`price` double
,`Jenis` varchar(2)
);

-- --------------------------------------------------------

--
-- Structure for view `v_acai`
--
DROP TABLE IF EXISTS `v_acai`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_acai`  AS  (select `tbl_product`.`product_id` AS `product_id`,`tbl_product`.`Nama` AS `Nama`,`tbl_product`.`price` AS `price`,`tbl_product`.`Jenis` AS `Jenis` from `tbl_product` where (`tbl_product`.`Jenis` = 'A')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_blended`
--
DROP TABLE IF EXISTS `v_blended`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_blended`  AS  (select `tbl_product`.`product_id` AS `product_id`,`tbl_product`.`Nama` AS `Nama`,`tbl_product`.`price` AS `price`,`tbl_product`.`Jenis` AS `Jenis` from `tbl_product` where (`tbl_product`.`Jenis` = 'B')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_coffee`
--
DROP TABLE IF EXISTS `v_coffee`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_coffee`  AS  (select `tbl_product`.`product_id` AS `product_id`,`tbl_product`.`Nama` AS `Nama`,`tbl_product`.`price` AS `price`,`tbl_product`.`Jenis` AS `Jenis` from `tbl_product` where (`tbl_product`.`Jenis` = 'C')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_others`
--
DROP TABLE IF EXISTS `v_others`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_others`  AS  (select `tbl_product`.`product_id` AS `product_id`,`tbl_product`.`Nama` AS `Nama`,`tbl_product`.`price` AS `price`,`tbl_product`.`Jenis` AS `Jenis` from `tbl_product` where (`tbl_product`.`Jenis` = 'O')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_pasta`
--
DROP TABLE IF EXISTS `v_pasta`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_pasta`  AS  (select `tbl_product`.`product_id` AS `product_id`,`tbl_product`.`Nama` AS `Nama`,`tbl_product`.`price` AS `price`,`tbl_product`.`Jenis` AS `Jenis` from `tbl_product` where (`tbl_product`.`Jenis` = 'P')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_pembayaran`
--
DROP TABLE IF EXISTS `v_pembayaran`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_pembayaran`  AS  (select `tbl_order`.`order_id` AS `order_id`,`tbl_order`.`person_id` AS `person_id`,`tbl_product`.`product_id` AS `product_id`,`tbl_product`.`Nama` AS `Nama`,`tbl_product`.`price` AS `price`,`tbl_order`.`order_date` AS `order_date`,`tblorderproduct`.`quantity` AS `quantity`,`tbl_order`.`status` AS `status` from ((`tblorderproduct` join `tbl_order` on((`tblorderproduct`.`order_id` = `tbl_order`.`order_id`))) join `tbl_product` on((`tblorderproduct`.`product_id` = `tbl_product`.`product_id`))) where (`tblorderproduct`.`status` = 'disajikan')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_pemesanan`
--
DROP TABLE IF EXISTS `v_pemesanan`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_pemesanan`  AS  (select `tbl_order`.`order_id` AS `order_id`,`tbl_order`.`person_id` AS `person_id`,`tbl_product`.`product_id` AS `product_id`,`tbl_product`.`Nama` AS `Nama`,`tbl_order`.`order_date` AS `order_date`,`tblorderproduct`.`quantity` AS `quantity`,`tbl_order`.`status` AS `status` from ((`tblorderproduct` join `tbl_order` on((`tblorderproduct`.`order_id` = `tbl_order`.`order_id`))) join `tbl_product` on((`tblorderproduct`.`product_id` = `tbl_product`.`product_id`))) where (`tblorderproduct`.`status` = 'dipesan')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_rice`
--
DROP TABLE IF EXISTS `v_rice`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_rice`  AS  (select `tbl_product`.`product_id` AS `product_id`,`tbl_product`.`Nama` AS `Nama`,`tbl_product`.`price` AS `price`,`tbl_product`.`Jenis` AS `Jenis` from `tbl_product` where (`tbl_product`.`Jenis` = 'R')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_sajikan`
--
DROP TABLE IF EXISTS `v_sajikan`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_sajikan`  AS  (select `tbl_order`.`order_id` AS `order_id`,`tbl_order`.`person_id` AS `person_id`,`tbl_product`.`product_id` AS `product_id`,`tbl_product`.`Nama` AS `Nama`,`tbl_order`.`order_date` AS `order_date`,`tblorderproduct`.`quantity` AS `quantity`,`tbl_order`.`status` AS `status` from ((`tblorderproduct` join `tbl_order` on((`tblorderproduct`.`order_id` = `tbl_order`.`order_id`))) join `tbl_product` on((`tblorderproduct`.`product_id` = `tbl_product`.`product_id`))) where (`tblorderproduct`.`status` = 'dimasak')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_sharedbites`
--
DROP TABLE IF EXISTS `v_sharedbites`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_sharedbites`  AS  (select `tbl_product`.`product_id` AS `product_id`,`tbl_product`.`Nama` AS `Nama`,`tbl_product`.`price` AS `price`,`tbl_product`.`Jenis` AS `Jenis` from `tbl_product` where (`tbl_product`.`Jenis` = 'B')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_sweet`
--
DROP TABLE IF EXISTS `v_sweet`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_sweet`  AS  (select `tbl_product`.`product_id` AS `product_id`,`tbl_product`.`Nama` AS `Nama`,`tbl_product`.`price` AS `price`,`tbl_product`.`Jenis` AS `Jenis` from `tbl_product` where (`tbl_product`.`Jenis` = 'E')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_tea`
--
DROP TABLE IF EXISTS `v_tea`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_tea`  AS  (select `tbl_product`.`product_id` AS `product_id`,`tbl_product`.`Nama` AS `Nama`,`tbl_product`.`price` AS `price`,`tbl_product`.`Jenis` AS `Jenis` from `tbl_product` where (`tbl_product`.`Jenis` = 'T')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_topdrinks`
--
DROP TABLE IF EXISTS `v_topdrinks`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_topdrinks`  AS  (select `tbl_product`.`product_id` AS `product_id`,`tbl_product`.`Nama` AS `Nama`,`tbl_product`.`price` AS `price`,`tbl_product`.`Jenis` AS `Jenis` from `tbl_product` where (`tbl_product`.`Jenis` = 'N')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_topfood`
--
DROP TABLE IF EXISTS `v_topfood`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_topfood`  AS  (select `tbl_product`.`product_id` AS `product_id`,`tbl_product`.`Nama` AS `Nama`,`tbl_product`.`price` AS `price`,`tbl_product`.`Jenis` AS `Jenis` from `tbl_product` where (`tbl_product`.`Jenis` = 'K')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_western`
--
DROP TABLE IF EXISTS `v_western`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_western`  AS  (select `tbl_product`.`product_id` AS `product_id`,`tbl_product`.`Nama` AS `Nama`,`tbl_product`.`price` AS `price`,`tbl_product`.`Jenis` AS `Jenis` from `tbl_product` where (`tbl_product`.`Jenis` = 'W')) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblorderproduct`
--
ALTER TABLE `tblorderproduct`
  ADD KEY `order id` (`order_id`),
  ADD KEY `product id` (`product_id`);

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`code`);

--
-- Indexes for table `tbl_jenis`
--
ALTER TABLE `tbl_jenis`
  ADD PRIMARY KEY (`jenis`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `person id` (`person_id`);

--
-- Indexes for table `tbl_person`
--
ALTER TABLE `tbl_person`
  ADD PRIMARY KEY (`person_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `Jenis` (`Jenis`);

--
-- Indexes for table `tbl_waitreess`
--
ALTER TABLE `tbl_waitreess`
  ADD PRIMARY KEY (`waitreess_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_person`
--
ALTER TABLE `tbl_person`
  MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblorderproduct`
--
ALTER TABLE `tblorderproduct`
  ADD CONSTRAINT `tblorderproduct_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblorderproduct_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`order_id`);

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `tbl_order_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `tbl_person` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD CONSTRAINT `tbl_product_ibfk_1` FOREIGN KEY (`Jenis`) REFERENCES `tbl_jenis` (`jenis`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
