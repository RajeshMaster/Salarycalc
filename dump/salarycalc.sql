/*
Navicat MySQL Data Transfer

Source Server         : laravel
Source Server Version : 50625
Source Host           : localhost:3306
Source Database       : salarycalc

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2020-09-24 10:15:33
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `company_details`
-- ----------------------------
DROP TABLE IF EXISTS `company_details`;
CREATE TABLE `company_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `companyNumber` varchar(13) DEFAULT NULL,
  `companyName` varchar(50) DEFAULT NULL,
  `companyBranch` varchar(50) DEFAULT NULL,
  `capital` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `TEL` varchar(50) DEFAULT NULL,
  `CEO` varchar(50) DEFAULT NULL,
  `referencenumber` int(8) DEFAULT NULL,
  `delflg` int(1) DEFAULT '0',
  `Ins_DT` date NOT NULL,
  `Ins_TM` time NOT NULL,
  `Up_DT` date NOT NULL,
  `UP_TM` time NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `UpdatedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of company_details
-- ----------------------------
INSERT INTO company_details VALUES ('1', '6120002067788', '株式会社 MICROBIT', '大阪', '1000万', '大阪市淀川区西中島５－６－３－３０５', '06-6305-1251', '代表取締役　ラジャゴパル　サティシュクマール', '600338', '0', '2020-07-04', '00:00:00', '2020-08-18', '00:00:00', 'Sathish Kumar', 'Sathish Kumar');

-- ----------------------------
-- Table structure for `dev_kessandetails`
-- ----------------------------
DROP TABLE IF EXISTS `dev_kessandetails`;
CREATE TABLE `dev_kessandetails` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Accountperiod` varchar(50) NOT NULL,
  `Startingyear` int(10) NOT NULL,
  `Startingmonth` int(10) NOT NULL,
  `Closingyear` int(10) NOT NULL,
  `Closingmonth` int(10) NOT NULL,
  `delflg` varchar(10) DEFAULT NULL,
  `Ins_DT` date NOT NULL,
  `Ins_TM` time NOT NULL,
  `Up_DT` date NOT NULL,
  `UP_TM` time NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `UpdatedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dev_kessandetails
-- ----------------------------
INSERT INTO dev_kessandetails VALUES ('2', '10', '2014', '11', '2015', '10', '0', '2015-11-12', '03:05:27', '2019-03-27', '12:40:55', 'Kumar&nbsp;Sathish', 'Kumar Sathish');

-- ----------------------------
-- Table structure for `dev_mstuser`
-- ----------------------------
DROP TABLE IF EXISTS `dev_mstuser`;
CREATE TABLE `dev_mstuser` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `usercode` varchar(50) DEFAULT NULL,
  `userid` varchar(50) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `conpassword` varchar(50) DEFAULT NULL,
  `userclassification` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `givenname` varchar(50) NOT NULL,
  `nickName` varchar(50) DEFAULT NULL,
  `dob` varchar(10) NOT NULL,
  `gender` int(1) NOT NULL,
  `mobileno` varchar(13) DEFAULT NULL,
  `email` text NOT NULL,
  `accessDate` varchar(10) DEFAULT NULL,
  `delflg` varchar(10) DEFAULT NULL,
  `langFlg` int(1) DEFAULT '0',
  `delchgflg` varchar(10) DEFAULT NULL,
  `Ins_DT` date NOT NULL,
  `Ins_TM` time NOT NULL,
  `Up_DT` date NOT NULL,
  `UP_TM` time NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `UpdatedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dev_mstuser
-- ----------------------------
INSERT INTO dev_mstuser VALUES ('1', 'MBINV001', 'INVSU001', '0192023a7bbd73250516f069df18b500', '21232f297a57a5a743894a0e4a801fc3', '4', 'Sathish', 'Kumar', 'Sathish nick', '1972-12-23', '1', '080-3138-1004', 'staff@microbit.co.jp', null, '0', '0', '0', '2015-09-08', '06:10:49', '2017-08-28', '02:45:26', 'システム&nbsp;管理者', 'Sathish');
INSERT INTO dev_mstuser VALUES ('2', '', 'gdfgfg', '', '', '0', 'Easa', 'Singh', null, '2001-09-06', '1', '344-3333-3333', 'dff@ererre.co.jp', null, '0', '0', '0', '0000-00-00', '00:00:00', '2017-07-10', '09:41:00', '', 'Sathish');
INSERT INTO dev_mstuser VALUES ('3', 'M0000001', 'test', '21232f297a57a5a743894a0e4a801fc3', '21232f297a57a5a743894a0e4a801fc3', '0', 'システム', '管理者', null, '2017-07-03', '1', '999-9999-9999', 'sabariflyboy@gmail.com', null, '1', '0', '0', '2010-05-01', '00:00:00', '2017-07-27', '06:56:06', '', 'Sathish');
INSERT INTO dev_mstuser VALUES ('4', 'M0704003', 'えｒｔｒてｔ', 'c4ca4238a0b923820dcc509a6f75849b', 'c4ca4238a0b923820dcc509a6f75849b', '0', '仙敷', '久善', null, '1986-05-25', '1', '333-3333-3333', 'aiueo@kakikukeko.com', null, '1', '0', '0', '2010-05-01', '00:00:00', '2017-07-07', '02:11:11', '', 'Sathish');
INSERT INTO dev_mstuser VALUES ('5', 'M1106001', 'mb0001', 'efa5109644ee314c364e06717512b16d', 'Wm$DcA}F$bnJoorq', '0', '鈴木', '一郎', null, '2007-02-04', '1', '06-6305-9999', 'aaaa@microbit.co.jp', null, '0', '0', '0', '2011-06-07', '15:04:28', '2015-01-07', '14:56:35', '', '');
INSERT INTO dev_mstuser VALUES ('6', 'M1501001', 'ichiro', 'vKXMEO514fA}F$bn', 'vKXMEO514fA}F$bn', '0', '田中', '一郎', null, '1994-01-04', '1', '090-1234-1234', 'tanaka@microbit.co.jp', null, '1', '0', '1', '2015-01-07', '17:23:10', '0000-00-00', '00:00:00', '', '');
INSERT INTO dev_mstuser VALUES ('7', 'senshiki', 'senshiki', 'Wm$DcA}F$bnJoorq', 'Wm$DcA}F$bnJoorq', '1', '仙敷', '久善', null, '1979-03-08', '1', '090-9999-9999', 'senshiki@microbit.co.jp', null, '1', '0', '0', '2010-10-06', '12:07:47', '2015-09-15', '20:00:05', '', '');
INSERT INTO dev_mstuser VALUES ('8', 'MBINV008', 'INV0123', 'c20ad4d76fe97759aa27a0c99bff6710', '202cb962ac59075b964b07152d234b70', '0', 'check', 'check', null, '1998-11-12', '1', '646-6545-4564', 'dsfsdf@dff.fff', null, '0', '1', '0', '2015-11-12', '03:16:10', '2016-06-09', '02:16:53', 'Kumar&nbsp;Sathish', 'Kumar&nbsp;Sathish');
INSERT INTO dev_mstuser VALUES ('9', 'MBINV009', 'Mb002', 'c20ad4d76fe97759aa27a0c99bff6710', 'b59c67bf196a4758191e42f76670ceba', '0', 'Shanmuga', 'Raj', null, '1984-03-21', '1', '235-3453-3453', 'shanmugaraj@gmail.com', null, '0', '0', '0', '2016-03-09', '02:49:27', '2016-08-12', '01:41:42', 'Kumar&nbsp;Sathish', 'Kumar&nbsp;Sathish');
INSERT INTO dev_mstuser VALUES ('10', 'MBINV010', 'CCCCCCC', 'e10adc3949ba59abbe56e057f20f883e', 'e10adc3949ba59abbe56e057f20f883e', '0', 'AAAAAAAAAAAAAAAA', 'AAAAAAAAAAAAAAAA', null, '1990-03-17', '1', '123-1232-2342', 'fdsfdgf@dfdf.gfg', null, '0', '0', '0', '2016-03-17', '03:28:46', '2016-03-18', '07:26:23', 'Kumar&nbsp;Sathish', 'Kumar&nbsp;Sathish');
INSERT INTO dev_mstuser VALUES ('11', 'MBINV011', 'BABU', 'c20ad4d76fe97759aa27a0c99bff6710', '1d1024d3946a656c6ed652c436117d0c', '0', 'BABU', 'asdasd', null, '1990-03-01', '1', '123-1231-1231', 'zcxzxc@fgd.gdf', null, '0', '0', '0', '2016-03-17', '03:51:44', '2016-06-09', '01:10:36', 'Kumar&nbsp;Sathish', 'Kumar&nbsp;Sathish');
INSERT INTO dev_mstuser VALUES ('12', 'MBINV012', 'sdgdfgdfg', 'f970e2767d0cfe75876ea857f92e319b', 'f970e2767d0cfe75876ea857f92e319b', '0', 'ｄｄｄｄｄｄｄｄｄｄｄｄｄｄ', 'ddddddddd', null, '1995-04-11', '1', '123-1231-1231', 'fdsdf@sdf.sdf', null, '0', '0', '0', '2016-04-07', '07:51:58', '2016-04-07', '07:52:37', 'Kumar&nbsp;Sathish', 'Kumar&nbsp;Sathish');
INSERT INTO dev_mstuser VALUES ('13', 'MBINV013', '', 'd41d8cd98f00b204e9800998ecf8427e', 'd41d8cd98f00b204e9800998ecf8427e', '', 'Jac', 'Jac', null, '', '0', '--', '', null, '0', '0', '0', '2016-04-13', '01:12:43', '0000-00-00', '00:00:00', 'Kumar&nbsp;Sathish', '');
INSERT INTO dev_mstuser VALUES ('14', 'MBINV014', 'tret', 'fa1d3eb08a879de9a4cd9995a1aa91e1', 'fa1d3eb08a879de9a4cd9995a1aa91e1', '0', 'rewrewree', 'ewrwre', null, '1992-04-04', '1', '234-4324-4324', 'gdfg@gamil.com', null, '1', '0', '0', '2016-04-15', '01:00:10', '0000-00-00', '00:00:00', 'Kumar&nbsp;Sathish', '');
INSERT INTO dev_mstuser VALUES ('15', 'MBINV015', 'ｈｊｄｇｆ', 'a9ddcf51419881bdee445181e32ede58', 'a9ddcf51419881bdee445181e32ede58', '0', 'ｄｆｇｖｆｄｃｇｂ', 'ｃｖｂｖｃｂ', null, '2000-10-17', '1', '243-6547-5436', 'fxdfxg@gmain.com', null, '0', '0', '0', '2016-04-26', '12:13:12', '0000-00-00', '00:00:00', 'Kumar&nbsp;Sathish', '');
INSERT INTO dev_mstuser VALUES ('16', 'MBINV016', 'ad0000', '0192023a7bbd73250516f069df18b500', '0192023a7bbd73250516f069df18b500', '4', 'krishnan', 'siva', null, '1998-06-24', '1', '345-5436-5465', 'info@.XXXXX.co.jp', null, '0', '0', '0', '2016-06-15', '05:04:33', '0000-00-00', '00:00:00', 'Kumar&nbsp;Sathish', '');
INSERT INTO dev_mstuser VALUES ('17', 'SINGH', 'EASA', 'easa', 'easa', '4', 'SINGH', 'easa', null, '2017-09-12', '2', '077-0878-0351', 'easasundarasingh@gmail.com', null, '0', '0', '0', '2017-07-07', '09:17:52', '2017-07-07', '09:50:08', 'Sathish', 'Sathish');
INSERT INTO dev_mstuser VALUES ('18', 'MBINV018', 'qw', '006d2143154327a64d86a264aea225f3', '006d2143154327a64d86a264aea225f3', '4', 'qw', 'qw', null, '2017-09-12', '2', '121-2121-1212', '1212', null, '0', '0', '0', '2017-07-07', '09:39:25', '2017-07-07', '09:39:46', 'Sathish', 'Sathish');
INSERT INTO dev_mstuser VALUES ('19', 'MBINV019', 'M000123', 'deaf06d1c5c58d32768e336d38edb666', 'deaf06d1c5c58d32768e336d38edb666', '0', 'Rayee', 'Rayees', null, '1993-07-15', '1', '999-9999-9999', 'rayees01@gmail.com', null, '0', '0', '0', '2017-07-27', '02:36:35', '2017-07-27', '02:36:35', 'Sathish', 'Sathish');
INSERT INTO dev_mstuser VALUES ('20', 'MBINV020', 'M000122', 'fa1aedd24cb30a829dc3d55111b2d70e', 'fa1aedd24cb30a829dc3d55111b2d70e', '2', 'Samy', 'Samye', null, '1993-07-11', '1', '999-9999-9999', 'samiee@gmail.com', null, '0', '0', '0', '2017-07-27', '03:13:10', '2017-07-27', '03:13:34', 'Sathish', 'Sathish');
INSERT INTO dev_mstuser VALUES ('21', 'MBINV021', '加賀田', 'c12e01f2a13ff5587e1e9e4aedb8242d', 'c12e01f2a13ff5587e1e9e4aedb8242d', '0', '加賀田', '加賀田', null, '2002-01-15', '1', 'あさご-がんたべ-ました。', 'kagata@gmail.com', null, '0', '0', '0', '2017-07-27', '05:55:33', '0000-00-00', '00:00:00', 'Kumar&nbsp;Sathish', '');
INSERT INTO dev_mstuser VALUES ('22', 'MBINV022', '加賀田', 'c12e01f2a13ff5587e1e9e4aedb8242d', 'c12e01f2a13ff5587e1e9e4aedb8242d', '3', '加賀田', '加賀田', '加賀田', '1998-07-27', '1', 'あいう-あいうえ-えおおお', 'kagata@gmail.com', null, '0', '0', '0', '2017-07-27', '06:04:20', '2017-10-20', '10:37:27', 'Sathish', 'Sathish');
INSERT INTO dev_mstuser VALUES ('23', 'MBINV023', '加賀田', 'c12e01f2a13ff5587e1e9e4aedb8242d', 'c12e01f2a13ff5587e1e9e4aedb8242d', '0', '加賀田', 'kagata', null, '2017-07-27', '1', 'あいう-あいうお-えおおお', 'kagata@gmail.com', null, '0', '0', '0', '2017-07-27', '06:07:37', '2017-07-27', '07:03:10', 'Sathish', 'Sathish');
INSERT INTO dev_mstuser VALUES ('24', 'MBINV024', 'kagata', 'c12e01f2a13ff5587e1e9e4aedb8242d', 'c12e01f2a13ff5587e1e9e4aedb8242d', '0', '加賀田', 'kagata', null, '2017-07-27', '1', 'あいう-あいうえ-えおおお', 'kagata@gmail.com', null, '0', '0', '0', '2017-07-27', '06:37:53', '2017-07-27', '06:37:53', 'Sathish', 'Sathish');
INSERT INTO dev_mstuser VALUES ('25', 'MBINV025', 'MB0064', '58d5d808343ca155f099483c162f43c1', '58d5d808343ca155f099483c162f43c1', '1', 'VENGAD', 'Vengad', 'ヴェンガット', '1988-11-21', '1', '999-4383-0880', 'vengad7@gmail.com', '', '0', '0', '0', '2017-08-11', '05:55:24', '2018-06-07', '10:45:42', 'Sathish', 'Sathish');
INSERT INTO dev_mstuser VALUES ('26', 'MBINV026', 'invsu011', '514f1b439f404f86f77090fa9edc96ce', '514f1b439f404f86f77090fa9edc96ce', '3', 'Raghul', 'Ramaiyan', 'Raghul Ramaiyan', '1999-09-29', '1', '333-3333-3333', 'Raghul@gmail.com', null, '0', '0', '0', '2017-10-20', '10:39:12', '2017-10-20', '10:40:04', 'Sathish', 'Sathish');
INSERT INTO dev_mstuser VALUES ('27', 'MBINV027', 'SINGH', '2865a5b14e5a70273a7d311bfc150f4f', '2865a5b14e5a70273a7d311bfc150f4f', '0', 'singh', 'singh', 'singh', '2000-01-03', '1', '123-3213-2132', 'easasundarasingh@gmail.com', '2018-01-01', '0', '1', '0', '2018-01-08', '11:53:36', '2018-01-08', '12:51:57', 'Sathish', 'singh');
INSERT INTO dev_mstuser VALUES ('28', 'MBINV028', 'easa12', '58d5d808343ca155f099483c162f43c1', '58d5d808343ca155f099483c162f43c1', '1', 'easa', 'easa', 'easa', '1999-12-27', '1', '213-4213-2132', 'easasundarasingh@gmail.com', '2018-01-02', '0', '1', '0', '2018-01-08', '12:49:30', '2018-01-08', '01:04:43', 'Sathish', 'easa');
INSERT INTO dev_mstuser VALUES ('29', 'MBINV029', 'sundar', '58d5d808343ca155f099483c162f43c1', '58d5d808343ca155f099483c162f43c1', '1', 'sundar', 'sundar', 'sundar', '2000-01-05', '1', '454-3545-4354', 'easasundarasingh@gmail.com', '2018-01-01', '0', '0', '0', '2018-01-08', '12:50:23', '2018-01-25', '02:25:23', 'Sathish', 'Sathish');
INSERT INTO dev_mstuser VALUES ('30', 'MBINV030', 'qwerty', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'd8578edf8458ce06fbc5bb76a58c5ca4', '3', 'qwerty', 'qwerty', 'qwerty', '1999-12-27', '1', '435-4354-3543', 'easasundarasingh@gmail.com', '2018-01-04', '0', '0', '0', '2018-01-08', '12:51:09', '2018-01-08', '12:51:09', 'Sathish', 'Sathish');
INSERT INTO dev_mstuser VALUES ('33', 'MBINV033', 'fds001', '47bce5c74f589f4867dbd57e9ca9f808', '47bce5c74f589f4867dbd57e9ca9f808', '1', 'sara', 'thiya', 'Nila', '1992-07-16', '2', '080-3138-4449', 'adasf@dsaf.co.jp', '2018-11-20', '0', '0', '0', '2018-11-20', '07:22:14', '2018-11-20', '07:22:14', 'Sathish', 'Sathish');
INSERT INTO dev_mstuser VALUES ('31', 'MBINV031', 'INV0012', '58d5d808343ca155f099483c162f43c1', '58d5d808343ca155f099483c162f43c1', '1', 'easa', 'easa', 'easa', '2000-01-03', '1', '234-3242-4234', 'easasundarasingh@gmail.com', '2018-01-01', '0', '0', '0', '2018-01-23', '05:10:54', '2018-01-23', '05:10:54', 'Sathish', 'Sathish');
INSERT INTO dev_mstuser VALUES ('32', 'MBINV032', 'kumaran', '79cfac6387e0d582f83a29a04d0bcdc4', '79cfac6387e0d582f83a29a04d0bcdc4', '1', 'kumaran', 'kumaran', 'kumar', '1993-01-27', '1', '234-2134-2314', 'asdfsd@sadf.asdaff', '2018-01-25', '0', '1', '0', '2018-01-25', '07:48:17', '2018-01-25', '08:03:31', 'Sathish', 'Sathish');
INSERT INTO dev_mstuser VALUES ('34', 'MBINV034', 'invsu0045', '47bce5c74f589f4867dbd57e9ca9f808', '47bce5c74f589f4867dbd57e9ca9f808', '0', 'aaliya', 'Rohan', 'geet', '2000-11-07', '2', '080-3１３８-3１３８', 'adasf@dsaf.co.jp', '2018-10-31', '0', '0', '0', '2018-11-20', '09:19:26', '2018-11-20', '09:19:26', 'Sathish', 'Sathish');
INSERT INTO dev_mstuser VALUES ('35', 'MBINV035', 'lee', '12eccbdd9b32918131341f38907cbbb5', '12eccbdd9b32918131341f38907cbbb5', '0', 'lee', 'lee', 'lee', '2000-11-01', '1', '234-2342-3423', 'lee@sdfsdf', '2018-10-31', '0', '0', '0', '2018-11-20', '01:02:28', '2018-11-20', '01:02:28', 'Sathish', 'Sathish');

-- ----------------------------
-- Table structure for `dev_ourdetails`
-- ----------------------------
DROP TABLE IF EXISTS `dev_ourdetails`;
CREATE TABLE `dev_ourdetails` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(50) NOT NULL,
  `CompanyNamekana` varchar(50) NOT NULL,
  `pincode` varchar(50) NOT NULL,
  `Prefecturename` varchar(50) NOT NULL,
  `Streetaddress` varchar(50) NOT NULL,
  `BuildingName` varchar(50) NOT NULL,
  `TEL` varchar(50) NOT NULL,
  `FAX` varchar(50) NOT NULL,
  `Commonmail` text NOT NULL,
  `URL` varchar(50) NOT NULL,
  `Establisheddate` date NOT NULL,
  `Closingmonth` int(10) NOT NULL,
  `Closingdate` int(10) NOT NULL,
  `systemname` varchar(250) DEFAULT NULL,
  `delflg` varchar(10) DEFAULT NULL,
  `Ins_DT` date NOT NULL,
  `Ins_TM` time NOT NULL,
  `Up_DT` date NOT NULL,
  `UP_TM` time NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `UpdatedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dev_ourdetails
-- ----------------------------
INSERT INTO dev_ourdetails VALUES ('2', 'Microbit 株式会社', 'マイクロビット', '532-0011', '大阪府', '大阪市淀川区西中島５－６－３－３０５', 'チサン第２', '006-6456-1251', '006-6305-1250', 'Raghulr175@gmail.co.jp', 'admin1234', '2006-01-20', '10', '31', 'Salary Calculation System', '0', '2015-11-12', '03:05:12', '2017-08-01', '06:31:36', 'Kumar&nbsp;Sathish', '');

-- ----------------------------
-- Table structure for `emp_esimyno_details`
-- ----------------------------
DROP TABLE IF EXISTS `emp_esimyno_details`;
CREATE TABLE `emp_esimyno_details` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `Emp_ID` varchar(10) NOT NULL,
  `Emp_Name` varchar(50) NOT NULL,
  `myNo` varchar(20) DEFAULT NULL,
  `esiRegDate` varchar(15) DEFAULT NULL,
  `esiNo` varchar(20) DEFAULT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDateTime` datetime NOT NULL,
  `updatedBy` varchar(30) DEFAULT NULL,
  `updatedDateTime` datetime DEFAULT NULL,
  `delFlg` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of emp_esimyno_details
-- ----------------------------

-- ----------------------------
-- Table structure for `emp_family_details`
-- ----------------------------
DROP TABLE IF EXISTS `emp_family_details`;
CREATE TABLE `emp_family_details` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `Emp_ID` varchar(10) NOT NULL,
  `relationType` int(3) NOT NULL,
  `subRelationType` int(3) NOT NULL DEFAULT '0',
  `FirstName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) NOT NULL,
  `Kana_FirstName` varchar(100) DEFAULT NULL,
  `Kana_LastName` varchar(100) NOT NULL,
  `gender` int(3) NOT NULL,
  `DOB` date DEFAULT NULL,
  `liveInJapan` int(3) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDateTime` datetime NOT NULL,
  `updatedBy` varchar(30) DEFAULT NULL,
  `updatedDateTime` datetime DEFAULT NULL,
  `regFlg` int(3) NOT NULL DEFAULT '0',
  `delFlg` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of emp_family_details
-- ----------------------------

-- ----------------------------
-- Table structure for `emp_mstemployees`
-- ----------------------------
DROP TABLE IF EXISTS `emp_mstemployees`;
CREATE TABLE `emp_mstemployees` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `Emp_ID` varchar(30) NOT NULL,
  `Old_ID` varchar(9) DEFAULT NULL,
  `DOJ` varchar(10) NOT NULL,
  `Title` int(1) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `KanaFirstName` varchar(50) NOT NULL,
  `KanaLastName` varchar(50) NOT NULL,
  `DOB` varchar(10) NOT NULL,
  `Gender` int(1) NOT NULL,
  `Picture` varchar(100) DEFAULT NULL,
  `Emailpersonal` text NOT NULL,
  `BankName` varchar(200) DEFAULT NULL,
  `BranchName` varchar(200) DEFAULT NULL,
  `AccNo` varchar(30) DEFAULT NULL,
  `BranchNo` varchar(20) DEFAULT NULL,
  `Ins_DT` date NOT NULL,
  `Ins_TM` time NOT NULL,
  `Up_DT` date NOT NULL,
  `UP_TM` time NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `UpdatedBy` varchar(50) NOT NULL,
  `resign_id` int(1) DEFAULT '0',
  `Address` varchar(200) DEFAULT NULL,
  `Address1` varchar(200) NOT NULL,
  `Mobile1` varchar(13) DEFAULT NULL,
  `mailSend` int(1) NOT NULL DEFAULT '0',
  `delFlg` int(1) NOT NULL DEFAULT '0',
  `nickname` text,
  `resignedDate` date DEFAULT NULL,
  `Designation` varchar(50) NOT NULL,
  `mail_need` int(1) DEFAULT '0',
  `citizenShip` int(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `Emp_ID` (`Emp_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of emp_mstemployees
-- ----------------------------

-- ----------------------------
-- Table structure for `familyvisa_details`
-- ----------------------------
DROP TABLE IF EXISTS `familyvisa_details`;
CREATE TABLE `familyvisa_details` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `Emp_ID` varchar(20) NOT NULL,
  `Emp_Relation` varchar(20) NOT NULL,
  `Gender` int(5) NOT NULL,
  `Nationality` int(5) NOT NULL,
  `NationalityOthers` varchar(200) DEFAULT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Kana_FirstName` varchar(50) NOT NULL,
  `Kana_LastName` varchar(50) NOT NULL,
  `DOB` date NOT NULL,
  `CardNo` varchar(100) NOT NULL,
  `NoYears` int(3) NOT NULL,
  `StDate` varchar(10) NOT NULL,
  `EdDate` varchar(10) NOT NULL,
  `VisaStatus` varchar(30) DEFAULT NULL,
  `Address` int(5) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `CreatedDateTime` datetime NOT NULL,
  `UpdatedBy` varchar(50) DEFAULT NULL,
  `UpdatedDateTime` datetime DEFAULT NULL,
  `delflg` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of familyvisa_details
-- ----------------------------

-- ----------------------------
-- Table structure for `inv_basic_salary`
-- ----------------------------
DROP TABLE IF EXISTS `inv_basic_salary`;
CREATE TABLE `inv_basic_salary` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Auto Generate ID',
  `Emp_ID` varchar(30) DEFAULT NULL COMMENT 'Employee ID',
  `FirstName` varchar(50) DEFAULT NULL COMMENT 'First Name',
  `LastName` varchar(50) DEFAULT NULL COMMENT 'Last Name',
  `date` date DEFAULT NULL,
  `basic_amount` varchar(50) DEFAULT NULL,
  `increment_amount` varchar(50) DEFAULT NULL,
  `hra` varchar(50) DEFAULT NULL,
  `year_month_from` date DEFAULT NULL,
  `year_month_to` date DEFAULT NULL,
  `total_month` varchar(50) DEFAULT NULL,
  `activeFlg` int(1) DEFAULT '0',
  `mail_need` int(2) DEFAULT '0',
  `delFlg` int(1) DEFAULT '0',
  `CreatedBy` varchar(100) DEFAULT NULL,
  `CreatedDateTime` datetime DEFAULT NULL,
  `UpdatedBy` varchar(100) DEFAULT NULL,
  `UpdatedDateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of inv_basic_salary
-- ----------------------------
INSERT INTO inv_basic_salary VALUES ('1', '00113', null, null, '2020-05-28', '50000', '0', '40000', '2019-06-06', '2019-11-30', '6', '0', '0', '0', 'Kumar Sathish', '2020-05-28 05:29:46', 'Kumar Sathish', '2020-05-28 05:29:46');
INSERT INTO inv_basic_salary VALUES ('2', '089503', null, null, '2020-05-28', '50000', '0', '40000', '2019-01-01', '2019-06-30', '6', '1', '0', '0', 'Kumar Sathish', '2020-05-28 05:33:52', 'Kumar Sathish', '2020-05-28 05:33:52');
INSERT INTO inv_basic_salary VALUES ('3', 'MB0289', null, null, '2020-05-28', '50000', '0', '40000', '2020-06-01', '2020-11-30', '6', '0', '0', '0', 'Kumar Sathish', '2020-05-28 05:54:10', 'Kumar Sathish', '2020-05-28 05:54:10');
INSERT INTO inv_basic_salary VALUES ('4', '089504', null, null, '2020-05-28', '50000', '0', '40000', '2020-06-01', '2020-11-30', '6', '0', '0', '0', 'Kumar Sathish', '2020-05-28 05:54:49', 'Kumar Sathish', '2020-05-28 05:54:49');
INSERT INTO inv_basic_salary VALUES ('5', '089505', null, null, '2020-05-28', '50000', '0', '40000', '2020-01-01', '2020-05-31', '5', '1', '0', '0', 'Kumar Sathish', '2020-05-28 05:55:28', 'Kumar Sathish', '2020-05-29 04:27:25');
INSERT INTO inv_basic_salary VALUES ('6', 'AD0000', null, null, '2020-05-29', '50000', '0', '40000', '2020-06-01', '2020-11-30', '6', '1', '0', '0', 'Kumar Sathish', '2020-05-29 02:59:58', 'Kumar Sathish', '2020-05-29 02:59:58');
INSERT INTO inv_basic_salary VALUES ('7', 'AD0005', null, null, '2020-05-29', '50000', '0', '40000', '2020-06-01', '2020-11-30', '5', '0', '0', '0', 'Kumar Sathish', '2020-05-29 03:00:44', 'Kumar Sathish', '2020-05-29 03:05:07');
INSERT INTO inv_basic_salary VALUES ('8', 'geeer', null, null, '2020-05-29', '50000', '0', '40000', '2020-06-01', '2020-11-30', '6', '0', '0', '0', 'Kumar Sathish', '2020-05-29 03:02:04', 'Kumar Sathish', '2020-05-29 03:02:04');
INSERT INTO inv_basic_salary VALUES ('9', 'MB0001', null, null, '2020-05-29', '50000', '0', '40000', '2020-05-01', '2020-10-31', '6', '1', '0', '0', 'Kumar Sathish', '2020-05-29 03:49:38', 'Kumar Sathish', '2020-05-29 03:50:26');
INSERT INTO inv_basic_salary VALUES ('10', 'MB0004', null, null, '2020-05-29', '50000', '0', '50000', '2020-06-02', '2020-11-30', '6', '0', '0', '0', 'Kumar Sathish', '2020-05-29 03:51:18', 'Kumar Sathish', '2020-05-29 03:52:06');
INSERT INTO inv_basic_salary VALUES ('11', '089503', null, null, '2020-05-29', '50000', '20000', '40000', '2019-07-01', '2019-12-31', '6', '1', '0', '0', 'Kumar Sathish', '2020-05-29 04:38:03', 'Kumar Sathish', '2020-05-29 04:38:03');
INSERT INTO inv_basic_salary VALUES ('12', '089505', null, null, '2020-05-29', '50000', '0', '40000', '2020-05-01', '2020-09-30', '5', '0', '0', '0', 'Kumar Sathish', '2020-05-29 05:59:01', 'Kumar Sathish', '2020-05-29 05:59:01');
INSERT INTO inv_basic_salary VALUES ('13', '089503', null, null, '2020-06-02', '50000', '20000', '40000', '2019-06-01', '2019-11-30', '6', '1', '0', '0', 'Kumar Sathish', '2020-06-02 02:49:03', 'Kumar Sathish', '2020-06-02 02:49:03');
INSERT INTO inv_basic_salary VALUES ('14', '089503', null, null, '2020-06-02', '50000', '20000', '40000', '2019-12-01', '2020-05-31', '6', '1', '0', '0', 'Kumar Sathish', '2020-06-02 02:50:09', 'Kumar Sathish', '2020-06-02 02:50:09');
INSERT INTO inv_basic_salary VALUES ('15', '089503', null, null, '2020-06-02', '70000', '20000', '40000', '2019-12-01', '2020-05-31', '6', '1', '0', '0', 'Kumar Sathish', '2020-06-02 02:50:39', 'Kumar Sathish', '2020-06-02 02:50:39');
INSERT INTO inv_basic_salary VALUES ('16', '089503', null, null, '2020-06-02', '90000', '20000', '40000', '2020-06-02', '2020-11-30', '6', '0', '0', '0', 'Kumar Sathish', '2020-06-02 02:51:09', 'Kumar Sathish', '2020-06-02 02:51:09');
INSERT INTO inv_basic_salary VALUES ('17', 'MB0002', null, null, '2020-06-02', '50000', '0', '40000', '2020-01-01', '2020-06-30', '6', '1', '0', '0', 'Kumar Sathish', '2020-06-02 02:52:02', 'Kumar Sathish', '2020-06-02 02:52:02');
INSERT INTO inv_basic_salary VALUES ('18', 'MB0002', null, null, '2020-06-02', '70000', '0', '40000', '2020-01-01', '2020-06-30', '6', '1', '0', '0', 'Kumar Sathish', '2020-06-02 02:52:15', 'Kumar Sathish', '2020-06-02 02:52:15');
INSERT INTO inv_basic_salary VALUES ('19', 'MB0002', null, null, '2020-06-02', '70000', '20000', '50000', '2020-01-01', '2020-06-30', '6', '1', '0', '0', 'Kumar Sathish', '2020-06-02 02:52:40', 'Kumar Sathish', '2020-06-02 02:52:40');
INSERT INTO inv_basic_salary VALUES ('20', 'MB0002', null, null, '2020-06-02', '90000', '20000', '50000', '2020-06-01', '2020-11-30', '6', '1', '0', '0', 'Kumar Sathish', '2020-06-02 02:53:06', 'Kumar Sathish', '2020-06-02 02:53:06');
INSERT INTO inv_basic_salary VALUES ('21', 'MB0010', null, null, '2020-06-02', '50000', '0', '40000', '2019-06-06', '2019-11-30', '6', '1', '0', '0', 'Kumar Sathish', '2020-06-02 02:58:28', 'Kumar Sathish', '2020-06-02 02:58:28');
INSERT INTO inv_basic_salary VALUES ('22', 'MB0010', null, null, '2020-06-02', '50000', '0', '40000', '2019-12-01', '2020-05-31', '6', '1', '0', '0', 'Kumar Sathish', '2020-06-02 02:58:53', 'Kumar Sathish', '2020-06-02 02:58:53');
INSERT INTO inv_basic_salary VALUES ('23', 'MB0010', null, null, '2020-06-02', '50000', '20000', '40000', '2020-01-01', '2020-06-30', '6', '0', '0', '0', 'Kumar Sathish', '2020-06-02 02:59:30', 'Kumar Sathish', '2020-06-02 02:59:30');
INSERT INTO inv_basic_salary VALUES ('24', 'MB0011', null, null, '2020-06-02', '50000', '0', '40000', '2019-06-01', '2019-11-30', '6', '1', '0', '0', 'Kumar Sathish', '2020-06-02 03:01:26', 'Kumar Sathish', '2020-06-02 03:01:26');
INSERT INTO inv_basic_salary VALUES ('25', 'MB0011', null, null, '2020-06-02', '50000', '0', '40000', '2019-12-01', '2020-05-31', '6', '1', '0', '0', 'Kumar Sathish', '2020-06-02 03:01:44', 'Kumar Sathish', '2020-06-02 03:01:44');
INSERT INTO inv_basic_salary VALUES ('26', 'MB0011', null, null, '2020-06-02', '50000', '20000', '40000', '2020-01-01', '2020-06-30', '6', '0', '0', '0', 'Kumar Sathish', '2020-06-02 03:02:04', 'Kumar Sathish', '2020-06-02 03:02:04');
INSERT INTO inv_basic_salary VALUES ('27', 'MB0002', null, null, '2020-06-09', '95000', '20000', '50000', '2020-06-01', '2020-11-30', '6', '1', '0', '0', 'Kumar Sathish', '2020-06-09 08:51:08', 'Kumar Sathish', '2020-06-09 08:51:08');
INSERT INTO inv_basic_salary VALUES ('28', 'MB0002', null, null, '2020-06-09', '115000', '10000', '50000', '2020-05-25', '2020-10-31', '6', '1', '0', '0', 'Kumar Sathish', '2020-06-09 08:51:36', 'Kumar Sathish', '2020-06-09 08:51:36');
INSERT INTO inv_basic_salary VALUES ('29', 'AD0000', null, null, '2020-06-09', '50000', '0', '40000', '2020-05-01', '2020-05-31', '1', '1', '0', '0', 'Kumar Sathish', '2020-06-09 08:51:56', 'Kumar Sathish', '2020-06-10 01:42:51');
INSERT INTO inv_basic_salary VALUES ('30', 'MB0002', null, null, '2020-06-09', '115000', '20000', '50000', '2020-05-25', '2020-10-31', '6', '1', '0', '0', 'Kumar Sathish', '2020-06-09 08:52:20', 'Kumar Sathish', '2020-06-09 08:52:20');
INSERT INTO inv_basic_salary VALUES ('31', 'AD0000', null, null, '2020-06-10', '50000', '20000', '40000', '2020-06-01', '2020-11-30', '6', '0', '0', '0', 'Kumar Sathish', '2020-06-10 01:43:39', 'Kumar Sathish', '2020-06-10 01:43:39');
INSERT INTO inv_basic_salary VALUES ('32', 'MB0002', null, null, '2020-06-10', '115000', '20000', '50000', '2020-05-25', '2020-05-31', '1', '1', '1', '0', 'Kumar Sathish', '2020-06-10 01:54:26', 'Kumar Sathish', '2020-06-10 01:54:26');
INSERT INTO inv_basic_salary VALUES ('33', 'MB0001', null, null, '2020-07-06', '250000', '20000', '40000', '2020-01-01', '2020-12-31', '12', '0', '0', '0', 'Kumar Sathish', '2020-07-06 07:13:58', 'Kumar Sathish', '2020-07-09 01:25:12');
INSERT INTO inv_basic_salary VALUES ('34', 'MB0110', null, null, '2020-07-09', '150000', '20000', '40000', '2020-03-01', '2020-08-31', '6', '0', '1', '0', 'Kumar Sathish', '2020-07-09 02:06:32', 'Kumar Sathish', '2020-07-09 02:06:32');
INSERT INTO inv_basic_salary VALUES ('35', 'MB0002', null, null, '2020-07-13', '135000', '20000', '50000', '2020-06-01', '2020-11-30', '6', '0', '0', '0', 'Kumar Sathish', '2020-07-13 06:33:50', 'Kumar Sathish', '2020-07-13 06:33:50');
INSERT INTO inv_basic_salary VALUES ('36', 'MB0113', null, null, '2020-08-05', '50000', '0', '20000', '2020-02-01', '2020-04-30', '3', '0', '1', '0', 'Kumar Sathish', '2020-08-05 12:53:35', 'Kumar Sathish', '2020-08-05 12:53:35');

-- ----------------------------
-- Table structure for `inv_salaryplus_main`
-- ----------------------------
DROP TABLE IF EXISTS `inv_salaryplus_main`;
CREATE TABLE `inv_salaryplus_main` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Auto Generate ID',
  `Emp_ID` varchar(30) DEFAULT NULL COMMENT 'Employee ID',
  `date` date DEFAULT NULL,
  `Salary` text,
  `Deduction` text,
  `Travel` varchar(50) NOT NULL,
  `salamt` varchar(50) NOT NULL,
  `year` int(4) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `year_mon` date DEFAULT NULL,
  `remarks` text,
  `mailFlg` int(1) DEFAULT '0',
  `delFlg` int(1) DEFAULT '0',
  `CreatedBy` varchar(100) DEFAULT NULL,
  `CreatedDateTime` datetime DEFAULT NULL,
  `UpdatedBy` varchar(100) DEFAULT NULL,
  `UpdatedDateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of inv_salaryplus_main
-- ----------------------------
INSERT INTO inv_salaryplus_main VALUES ('1', 'AD0000', '2019-06-10', 'SD001$50000##SD002$40000##SD003$10000##', 'DD001$-40000##', '120000', '230000', '2020', '5', '2020-05-10', 'Testing Local Server...', '0', '0', 'Kumar Sathish', '2020-06-04 09:13:39', 'Kumar Sathish', '2020-06-11 00:54:10');
INSERT INTO inv_salaryplus_main VALUES ('2', 'AD0000', '2020-07-10', 'SD001$50000##SD002$40000##SD003$10000##SD004$10000##', 'DD001$-40000##', '120000', '70000', '2020', '6', '2020-06-10', 'Testing Local Server...', '0', '0', 'Kumar Sathish', '2020-06-04 09:14:42', 'Kumar Sathish', '2020-06-04 09:14:42');
INSERT INTO inv_salaryplus_main VALUES ('3', 'MB0002', '2020-06-10', 'SD003$300000##SD004$3000##', 'DD001$-40000##', '', '', '2020', '5', '2020-05-10', '', '0', '0', 'Kumar Sathish', '2020-06-05 07:52:20', 'Kumar Sathish', '2020-06-05 07:52:53');
INSERT INTO inv_salaryplus_main VALUES ('4', 'MB0002', '2020-06-10', 'SD003$300000##SD004$3000##', 'DD001$-40000##', '12', '', '2020', '6', '2020-06-10', '', '0', '0', 'Kumar Sathish', '2020-06-08 01:03:10', 'Kumar Sathish', '2020-06-08 01:03:10');
INSERT INTO inv_salaryplus_main VALUES ('5', 'AD0000', '2020-03-10', 'SD001$50000##SD002$40000##SD003$10000##SD004$10000##', 'DD001$-40000##', '120000', '', '2020', '7', '2020-07-10', 'Testing Local Server...', '0', '0', 'Kumar Sathish', '2020-06-08 08:31:19', 'Kumar Sathish', '2020-06-11 05:41:58');
INSERT INTO inv_salaryplus_main VALUES ('6', 'MB0067', '2020-06-10', 'SD001$50000##SD002$40000##SD003$10000##SD004$10000##', 'DD001$-40000##', '70000', '', '2020', '5', '2020-05-10', '', '0', '0', 'Kumar Sathish', '2020-06-10 09:37:23', 'Kumar Sathish', '2020-06-10 09:38:20');
INSERT INTO inv_salaryplus_main VALUES ('7', 'AD0000', '2020-05-10', 'SD001$50000##SD002$40000##SD003$10000##SD004$10000##', 'DD001$-40000##', '120000', '', '2020', '8', '2020-08-10', 'Testing Local Server...', '0', '0', 'Kumar Sathish', '2020-06-18 09:45:56', 'Kumar Sathish', '2020-06-18 09:45:56');
INSERT INTO inv_salaryplus_main VALUES ('8', 'MB0002', '2020-06-10', 'SD003$300000##SD004$3000##', 'DD001$-40000##', '12', '', '2020', '7', '2020-07-10', '', '0', '0', 'Kumar Sathish', '2020-06-18 09:48:24', 'Kumar Sathish', '2020-06-18 09:48:24');
INSERT INTO inv_salaryplus_main VALUES ('9', 'MB0280', '2019-07-10', 'SD001$50000##SD002$10000##SD003$10000##SD004$10000##', 'DD001$-40000##', '9000', '', '2020', '6', '2020-06-10', '', '0', '0', 'Kumar Sathish', '2020-07-06 06:08:45', 'Kumar Sathish', '2020-07-06 06:08:45');
INSERT INTO inv_salaryplus_main VALUES ('10', 'MB0001', '2020-07-10', 'SD001$50000##SD002$10000##SD003$10000##SD004$10000##', 'DD001$-40000##DD002$-5000##', '9100', '402020', '2020', '6', '2020-06-10', '', '0', '0', 'Kumar Sathish', '2020-07-06 10:06:22', 'Kumar Sathish', '2020-07-06 10:06:22');
INSERT INTO inv_salaryplus_main VALUES ('11', 'MB0064', '2020-07-10', 'SD001$55555##SD002$555555##', 'DD001$-55##', '55555', '', '2020', '6', '2020-06-10', '', '0', '0', 'Kumar Sathish', '2020-07-10 06:35:18', 'Kumar Sathish', '2020-07-10 06:35:18');

-- ----------------------------
-- Table structure for `inv_salaryplus_main_emp`
-- ----------------------------
DROP TABLE IF EXISTS `inv_salaryplus_main_emp`;
CREATE TABLE `inv_salaryplus_main_emp` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `Emp_Id` varchar(30) DEFAULT NULL,
  `delflg` int(1) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_by` varchar(100) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=927 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of inv_salaryplus_main_emp
-- ----------------------------
INSERT INTO inv_salaryplus_main_emp VALUES ('797', 'MB0068', '0', '2020', '5', '2020-06-04 09:10:03', 'Sathish', '2020-06-04 09:10:03', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('796', 'MB0067', '0', '2020', '5', '2020-06-04 09:10:03', 'Sathish', '2020-06-04 09:10:03', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('795', 'MB0066', '0', '2020', '5', '2020-06-04 09:10:03', 'Sathish', '2020-06-04 09:10:03', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('794', 'MB0064', '0', '2020', '5', '2020-06-04 09:10:03', 'Sathish', '2020-06-04 09:10:03', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('793', 'MB0004', '0', '2020', '5', '2020-06-04 09:10:03', 'Sathish', '2020-06-04 09:10:03', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('792', 'MB0002', '0', '2020', '5', '2020-06-04 09:10:03', 'Sathish', '2020-06-04 09:10:03', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('791', 'MB0001', '0', '2020', '5', '2020-06-04 09:10:03', 'Sathish', '2020-06-04 09:10:03', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('790', 'AD0005', '0', '2020', '5', '2020-06-04 09:10:03', 'Sathish', '2020-06-04 09:10:03', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('789', 'AD0000', '0', '2020', '5', '2020-06-04 09:10:03', 'Sathish', '2020-06-04 09:10:03', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('926', 'MB0142', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('925', 'MB0140', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('924', 'MB0139', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('923', 'MB0137', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('922', 'MB0136', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('921', 'MB0134', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('920', 'MB0133', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('919', 'MB0132', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('918', 'MB0068', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('917', 'MB0066', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('916', 'MB0065', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('915', 'MB0064', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('914', 'MB0063', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('913', 'MB0062', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('912', 'MB0002', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('911', 'MB0001', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('910', 'MB', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('909', 'AD0000', '0', '2020', '7', '2020-08-17 10:42:51', 'Sathish', '2020-08-17 10:42:51', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('837', 'MB0280', '0', '2020', '6', '2020-07-06 06:07:57', 'Sathish', '2020-07-06 06:07:57', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('823', 'AD0000', '0', '2020', '9', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('822', 'AD0005', '0', '2020', '9', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('821', 'MB0001', '0', '2020', '9', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('820', 'MB0002', '0', '2020', '9', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('819', 'MB0004', '0', '2020', '9', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('818', 'MB0064', '0', '2020', '9', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('817', 'MB0066', '0', '2020', '9', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('816', 'MB0067', '0', '2020', '9', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('815', 'MB0068', '0', '2020', '9', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('814', 'MB0110', '0', '2020', '9', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('813', 'MB0113', '0', '2020', '9', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('812', 'MB0133', '0', '2020', '9', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('811', 'MB0136', '0', '2020', '9', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('836', 'MB0136', '0', '2020', '6', '2020-07-06 06:07:57', 'Sathish', '2020-07-06 06:07:57', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('835', 'MB0133', '0', '2020', '6', '2020-07-06 06:07:57', 'Sathish', '2020-07-06 06:07:57', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('834', 'MB0113', '0', '2020', '6', '2020-07-06 06:07:57', 'Sathish', '2020-07-06 06:07:57', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('833', 'MB0110', '0', '2020', '6', '2020-07-06 06:07:57', 'Sathish', '2020-07-06 06:07:57', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('832', 'MB0068', '0', '2020', '6', '2020-07-06 06:07:57', 'Sathish', '2020-07-06 06:07:57', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('831', 'MB0067', '0', '2020', '6', '2020-07-06 06:07:57', 'Sathish', '2020-07-06 06:07:57', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('830', 'MB0066', '0', '2020', '6', '2020-07-06 06:07:57', 'Sathish', '2020-07-06 06:07:57', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('829', 'MB0064', '0', '2020', '6', '2020-07-06 06:07:57', 'Sathish', '2020-07-06 06:07:57', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('828', 'MB0004', '0', '2020', '6', '2020-07-06 06:07:57', 'Sathish', '2020-07-06 06:07:57', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('827', 'MB0002', '0', '2020', '6', '2020-07-06 06:07:57', 'Sathish', '2020-07-06 06:07:57', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('826', 'MB0001', '0', '2020', '6', '2020-07-06 06:07:57', 'Sathish', '2020-07-06 06:07:57', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('825', 'AD0005', '0', '2020', '6', '2020-07-06 06:07:57', 'Sathish', '2020-07-06 06:07:57', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('824', 'AD0000', '0', '2020', '6', '2020-07-06 06:07:57', 'Sathish', '2020-07-06 06:07:57', 'Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('592', 'AD0000', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('593', 'AD0005', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('594', 'MB0001', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('595', 'MB0002', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('596', 'MB0004', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('597', 'MB0064', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('598', 'MB0066', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('599', 'MB0067', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('600', 'MB0068', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('601', 'MB0110', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('602', 'MB0113', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('603', 'MB0133', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('604', 'MB0136', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('605', 'MB0137', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('606', 'MB0138', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('607', 'MB0139', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('608', 'MB0140', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('609', 'MB0142', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('610', 'MB0143', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('611', 'MB0144', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('612', 'MB0146', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('613', 'MB0149', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('614', 'MB0150', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('615', 'MB0151', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('616', 'MB0152', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('617', 'MB0153', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('618', 'MB0154', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('619', 'MB0157', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('620', 'MB0160', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('621', 'MB0161', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('622', 'MB0162', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('623', 'MB0164', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('624', 'MB0165', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('625', 'MB0166', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('626', 'MB0167', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('627', 'MB0168', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('628', 'MB0169', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('629', 'MB0170', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('630', 'MB0171', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('631', 'MB0172', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('632', 'MB0173', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('633', 'MB0174', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('634', 'MB0175', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('635', 'MB0176', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('636', 'MB0177', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('637', 'MB0178', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('638', 'MB0179', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('639', 'MB0180', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('640', 'MB0181', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('641', 'MB0182', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('642', 'MB0183', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('643', 'MB0184', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('644', 'MB0185', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('645', 'MB0186', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('646', 'MB0187', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('647', 'MB0188', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('648', 'MB0189', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('649', 'MB0190', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('650', 'MB0191', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('651', 'MB0192', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('652', 'MB0194', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('653', 'MB0195', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('654', 'MB0196', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('655', 'MB0197', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('656', 'MB0198', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('657', 'MB0199', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('658', 'MB0200', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('659', 'MB0201', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('660', 'MB0202', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('661', 'MB0203', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('662', 'MB0204', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('663', 'MB0205', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('664', 'MB0206', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('665', 'MB0207', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('666', 'MB0208', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('667', 'MB0209', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('668', 'MB0210', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('669', 'MB0211', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('670', 'MB0212', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('671', 'MB0213', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('672', 'MB0214', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('673', 'MB0215', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('674', 'MB0216', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('675', 'MB0217', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('676', 'MB0218', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('677', 'MB0219', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('678', 'MB0220', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('679', 'MB0221', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('680', 'MB0222', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('681', 'MB0223', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('682', 'MB0224', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('683', 'MB0225', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('684', 'MB0226', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('685', 'MB0227', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('686', 'MB0228', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('687', 'MB0229', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('688', 'MB0230', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('689', 'MB0231', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('690', 'MB0232', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('691', 'MB0233', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('692', 'MB0234', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('693', 'MB0235', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('694', 'MB0236', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('695', 'MB0238', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('696', 'MB0239', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('697', 'MB0240', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('698', 'MB0241', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('699', 'MB0242', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('700', 'MB0243', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('701', 'MB0244', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('702', 'MB0245', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('703', 'MB0246', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('704', 'MB0247', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('705', 'MB0249', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('706', 'MB0250', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('707', 'MB0251', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('708', 'MB0252', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('709', 'MB0253', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('710', 'MB0254', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('711', 'MB0255', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('712', 'MB0256', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('713', 'MB0257', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('714', 'MB0258', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('715', 'MB0260', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('716', 'MB0262', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('717', 'MB0263', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('718', 'MB0264', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('719', 'MB0265', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('720', 'MB0266', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('721', 'MB0267', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('722', 'MB0268', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('723', 'MB0269', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('724', 'MB0270', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('725', 'MB0271', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('726', 'MB0272', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('727', 'MB0273', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('728', 'MB0274', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('729', 'MB0275', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('730', 'MB0276', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('731', 'MB0277', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('732', 'MB0278', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('733', 'MB0279', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('734', 'MB0280', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('735', 'MB0281', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('736', 'MB0282', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('737', 'MB0284', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('738', 'MB0285', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('739', 'MB0286', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('740', 'MB0287', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('741', 'MB0288', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('742', 'MB0289', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('743', 'MB0290', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('744', 'MB0291', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('745', 'MB0293', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('746', 'MB0294', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('747', 'MB0295', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('748', 'MB0298', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('749', 'MB0299', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('750', 'MB0300', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('751', 'MB0301', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('752', 'MB0302', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('753', 'MB0303', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('754', 'MB0304', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('755', 'MB0305', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('756', 'MB0306', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('757', 'MB0308', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('758', 'MB0309', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('759', 'MB0310', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('760', 'MB0311', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('761', 'MB0313', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('762', 'MB0315', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('763', 'MB0316', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('764', 'MB0317', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('765', 'MB0318', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('766', 'MB0319', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('767', 'MB0320', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('768', 'MB0322', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('769', 'MB0324', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('770', 'MB0325', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('771', 'MB0326', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('772', 'MB0327', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('773', 'MB0328', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('774', 'MB0329', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('775', 'MB0330', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('776', 'MB0331', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('777', 'MB0332', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('778', 'MB0333', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('779', 'MB0334', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('780', 'MB0335', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('781', 'MB0336', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('782', 'MB0338', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('783', 'MB0339', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('784', 'MB0340', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('785', 'MB0341', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('786', 'MB0342', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('787', 'SS0078', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('788', 'SS0109', '0', '2020', '8', '2020-06-04 00:00:00', 'Kumar Sathish', '2020-06-04 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('838', 'MB0280', '0', '2020', '0', '2020-08-02 00:00:00', 'Kumar Sathish', '2020-08-02 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('839', 'MB0136', '0', '2020', '0', '2020-08-02 00:00:00', 'Kumar Sathish', '2020-08-02 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('840', 'MB0133', '0', '2020', '0', '2020-08-02 00:00:00', 'Kumar Sathish', '2020-08-02 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('841', 'MB0113', '0', '2020', '0', '2020-08-02 00:00:00', 'Kumar Sathish', '2020-08-02 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('842', 'MB0110', '0', '2020', '0', '2020-08-02 00:00:00', 'Kumar Sathish', '2020-08-02 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('843', 'MB0068', '0', '2020', '0', '2020-08-02 00:00:00', 'Kumar Sathish', '2020-08-02 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('844', 'MB0067', '0', '2020', '0', '2020-08-02 00:00:00', 'Kumar Sathish', '2020-08-02 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('845', 'MB0066', '0', '2020', '0', '2020-08-02 00:00:00', 'Kumar Sathish', '2020-08-02 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('846', 'MB0064', '0', '2020', '0', '2020-08-02 00:00:00', 'Kumar Sathish', '2020-08-02 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('847', 'MB0004', '0', '2020', '0', '2020-08-02 00:00:00', 'Kumar Sathish', '2020-08-02 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('848', 'MB0002', '0', '2020', '0', '2020-08-02 00:00:00', 'Kumar Sathish', '2020-08-02 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('849', 'MB0001', '0', '2020', '0', '2020-08-02 00:00:00', 'Kumar Sathish', '2020-08-02 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('850', 'AD0005', '0', '2020', '0', '2020-08-02 00:00:00', 'Kumar Sathish', '2020-08-02 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('851', 'AD0000', '0', '2020', '0', '2020-08-02 00:00:00', 'Kumar Sathish', '2020-08-02 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('852', 'MB0280', '0', '0', '0', '2020-08-13 00:00:00', 'Kumar Sathish', '2020-08-13 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('853', 'MB0136', '0', '0', '0', '2020-08-13 00:00:00', 'Kumar Sathish', '2020-08-13 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('854', 'MB0133', '0', '0', '0', '2020-08-13 00:00:00', 'Kumar Sathish', '2020-08-13 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('855', 'MB0113', '0', '0', '0', '2020-08-13 00:00:00', 'Kumar Sathish', '2020-08-13 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('856', 'MB0110', '0', '0', '0', '2020-08-13 00:00:00', 'Kumar Sathish', '2020-08-13 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('857', 'MB0068', '0', '0', '0', '2020-08-13 00:00:00', 'Kumar Sathish', '2020-08-13 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('858', 'MB0067', '0', '0', '0', '2020-08-13 00:00:00', 'Kumar Sathish', '2020-08-13 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('859', 'MB0066', '0', '0', '0', '2020-08-13 00:00:00', 'Kumar Sathish', '2020-08-13 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('860', 'MB0064', '0', '0', '0', '2020-08-13 00:00:00', 'Kumar Sathish', '2020-08-13 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('861', 'MB0004', '0', '0', '0', '2020-08-13 00:00:00', 'Kumar Sathish', '2020-08-13 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('862', 'MB0002', '0', '0', '0', '2020-08-13 00:00:00', 'Kumar Sathish', '2020-08-13 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('863', 'MB0001', '0', '0', '0', '2020-08-13 00:00:00', 'Kumar Sathish', '2020-08-13 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('864', 'AD0005', '0', '0', '0', '2020-08-13 00:00:00', 'Kumar Sathish', '2020-08-13 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('865', 'AD0000', '0', '0', '0', '2020-08-13 00:00:00', 'Kumar Sathish', '2020-08-13 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('866', 'MB0280', '0', '2020', '10', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('867', 'MB0136', '0', '2020', '10', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('868', 'MB0133', '0', '2020', '10', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('869', 'MB0113', '0', '2020', '10', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('870', 'MB0110', '0', '2020', '10', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('871', 'MB0068', '0', '2020', '10', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('872', 'MB0067', '0', '2020', '10', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('873', 'MB0066', '0', '2020', '10', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('874', 'MB0064', '0', '2020', '10', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('875', 'MB0004', '0', '2020', '10', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('876', 'MB0002', '0', '2020', '10', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('877', 'MB0001', '0', '2020', '10', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('878', 'AD0005', '0', '2020', '10', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('879', 'AD0000', '0', '2020', '10', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('880', 'MB0280', '0', '8', '120', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('881', 'MB0136', '0', '8', '120', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('882', 'MB0133', '0', '8', '120', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('883', 'MB0113', '0', '8', '120', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('884', 'MB0110', '0', '8', '120', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('885', 'MB0068', '0', '8', '120', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('886', 'MB0067', '0', '8', '120', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('887', 'MB0066', '0', '8', '120', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('888', 'MB0064', '0', '8', '120', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('889', 'MB0004', '0', '8', '120', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('890', 'MB0002', '0', '8', '120', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('891', 'MB0001', '0', '8', '120', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('892', 'AD0005', '0', '8', '120', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('893', 'AD0000', '0', '8', '120', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('894', 'MB0280', '0', '8', '2020', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('895', 'MB0136', '0', '8', '2020', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('896', 'MB0133', '0', '8', '2020', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('897', 'MB0113', '0', '8', '2020', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('898', 'MB0110', '0', '8', '2020', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('899', 'MB0068', '0', '8', '2020', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('900', 'MB0067', '0', '8', '2020', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('901', 'MB0066', '0', '8', '2020', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('902', 'MB0064', '0', '8', '2020', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('903', 'MB0004', '0', '8', '2020', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('904', 'MB0002', '0', '8', '2020', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('905', 'MB0001', '0', '8', '2020', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('906', 'AD0005', '0', '8', '2020', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salaryplus_main_emp VALUES ('907', 'AD0000', '0', '8', '2020', '2020-08-17 00:00:00', 'Kumar Sathish', '2020-08-17 00:00:00', 'Kumar Sathish');

-- ----------------------------
-- Table structure for `inv_salary_main`
-- ----------------------------
DROP TABLE IF EXISTS `inv_salary_main`;
CREATE TABLE `inv_salary_main` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Auto Generate ID',
  `Emp_ID` varchar(30) DEFAULT NULL COMMENT 'Employee ID',
  `date` date DEFAULT NULL,
  `Salary` text,
  `Deduction` text,
  `Basic` varchar(50) DEFAULT NULL,
  `hra` varchar(50) DEFAULT NULL,
  `train_daily` varchar(50) DEFAULT NULL,
  `others` varchar(50) DEFAULT NULL,
  `Transferred` text,
  `year` int(4) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `year_mon` date DEFAULT NULL,
  `leave_cnt` varchar(10) DEFAULT NULL,
  `remarks` text,
  `mailFlg` int(1) DEFAULT '0',
  `mailDatetime` datetime DEFAULT NULL,
  `delFlg` int(1) DEFAULT '0',
  `CreatedBy` varchar(100) DEFAULT NULL,
  `CreatedDateTime` datetime DEFAULT NULL,
  `UpdatedBy` varchar(100) DEFAULT NULL,
  `UpdatedDateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of inv_salary_main
-- ----------------------------
INSERT INTO inv_salary_main VALUES ('1', 'AD0000', '2020-05-22', 'SD001$40000##SD002$40000##SD009$10000##', 'DD001$0##DD004$-40000##', null, null, null, null, '50000', '2020', '4', '2020-04-10', null, null, '0', null, '0', 'Kumar Sathish', '2020-05-24 00:59:38', 'Kumar Sathish', '2020-05-25 04:33:36');
INSERT INTO inv_salary_main VALUES ('2', 'AD0005', '2020-05-23', 'SD001$40005##', '', '', '', '', '', '40005', '2020', '4', '2020-04-10', '5.5', '', '0', null, '0', 'Kumar Sathish', '2020-05-24 00:59:54', 'Kumar Sathish', '2020-06-11 01:01:16');
INSERT INTO inv_salary_main VALUES ('3', 'MB0064', '2020-05-23', 'SD001$70000##SD002$10000##', 'DD004$-20000##', null, null, null, null, '60000', '2020', '4', '2020-04-10', null, null, '0', null, '0', 'Kumar Sathish', '2020-05-24 01:22:30', 'Kumar Sathish', '2020-05-24 01:22:30');
INSERT INTO inv_salary_main VALUES ('4', 'MB0066', '2020-05-23', 'SD001$100000##', 'DD004$-40000##', null, null, null, null, '60000', '2020', '4', '2020-04-10', null, null, '0', null, '0', 'Kumar Sathish', '2020-05-24 01:22:56', 'Kumar Sathish', '2020-05-24 01:22:56');
INSERT INTO inv_salary_main VALUES ('6', 'MB0002', '2020-05-08', 'SD001$70000##SD002$40000##', 'DD001$-10##', '', '', '', '', '109990', '2020', '5', '2020-05-10', '', '', '0', null, '0', 'Kumar Sathish', '2020-05-24 10:24:30', 'Kumar Sathish', '2020-07-03 10:10:18');
INSERT INTO inv_salary_main VALUES ('7', 'MB0004', '2020-05-24', 'SD001$70000##SD002$40000##', 'DD003$-10000##', null, null, null, null, '100000', '2020', '5', '2020-05-10', null, null, '1', null, '0', 'Kumar Sathish', '2020-05-24 10:25:03', 'Kumar Sathish', '2020-05-24 10:25:03');
INSERT INTO inv_salary_main VALUES ('8', 'MB0064', '2020-05-08', 'SD001$12##', 'DD003$-1##', null, null, null, null, '11', '2020', '5', '2020-05-10', null, null, '0', null, '0', 'Kumar Sathish', '2020-05-24 10:39:10', 'Kumar Sathish', '2020-05-24 10:39:10');
INSERT INTO inv_salary_main VALUES ('9', 'MB0066', '2020-05-08', 'SD001$70000##SD002$40000##', 'DD004$-40000##', null, null, null, null, '70000', '2020', '5', '2020-05-10', null, null, '0', null, '0', 'Kumar Sathish', '2020-05-24 10:39:35', 'Kumar Sathish', '2020-05-24 10:39:50');
INSERT INTO inv_salary_main VALUES ('10', 'AD0000', '2020-05-24', 'SD001$70000##SD002$40000##', '', '70000', '50000', '', '', '230000', '2020', '5', '2020-05-10', '', '', '0', null, '0', 'Kumar Sathish', '2020-05-24 10:59:53', 'Kumar Sathish', '2020-06-11 00:53:39');
INSERT INTO inv_salary_main VALUES ('12', 'AD0000', '2020-05-25', 'SD001$70000##', 'DD001$-1##', null, null, null, null, '69999', '2020', '6', '2020-06-10', null, null, '1', null, '0', 'Kumar Sathish', '2020-05-25 00:41:28', 'Kumar Sathish', '2020-05-25 04:26:39');
INSERT INTO inv_salary_main VALUES ('13', 'MB0001', '2020-05-08', 'SD001$200000##SD005$25000##', 'DD001$-25000##', null, null, null, null, '200000', '2020', '3', '2020-03-10', null, 'Testing\r\nTesting......\r\nTesting', '0', null, '0', 'Kumar Sathish', '2020-05-25 02:00:02', 'Kumar Sathish', '2020-05-27 13:17:19');
INSERT INTO inv_salary_main VALUES ('14', 'MB0002', '2020-05-08', 'SD001$180000##SD006$10000##', '', null, null, null, null, '190000', '2020', '4', '2020-04-10', null, null, '0', null, '0', 'Kumar Sathish', '2020-05-25 02:00:56', 'Kumar Sathish', '2020-05-25 02:00:56');
INSERT INTO inv_salary_main VALUES ('15', 'MB0004', '2020-05-08', 'SD001$150000##SD002$10000##', '', null, null, null, null, '160000', '2020', '4', '2020-04-10', null, null, '0', null, '0', 'Kumar Sathish', '2020-05-26 09:00:43', 'Kumar Sathish', '2020-05-26 09:00:43');
INSERT INTO inv_salary_main VALUES ('17', 'MB0001', '2020-05-08', 'SD003$10000##SD005$5000##SD006$10000##SD007$9100##SD009$10000##', 'DD001$-40000##', '100000', '50000', '9100', '51000', '214200', '2020', '4', '2020-04-10', null, 'Ok Easa', '0', null, '0', 'Kumar Sathish', '2020-05-28 04:29:35', 'Kumar Sathish', '2020-06-04 04:07:21');
INSERT INTO inv_salary_main VALUES ('18', 'MB0113', '2020-05-08', '', '', '200000', '', '', '', '200000', '2020', '4', '2020-04-10', null, '', '0', null, '0', 'Kumar Sathish', '2020-05-29 02:02:40', 'Kumar Sathish', '2020-05-29 02:02:40');
INSERT INTO inv_salary_main VALUES ('19', 'MB0001', '2020-06-10', 'SD003$10000##SD005$5000##SD006$10000##SD007$9100##SD009$10000##', 'DD001$-40000##', '100000', '50000', '9100', '51000', '214200', '2020', '8', '2020-08-10', null, 'Ok Easa', '1', '2020-08-14 18:05:24', '0', 'Kumar Sathish', '2020-06-01 05:55:26', 'Kumar Sathish', '2020-06-01 05:55:26');
INSERT INTO inv_salary_main VALUES ('22', 'MB0067', '2020-06-10', 'SD006$10000##', 'DD001$-40000##', '50000', '40000', '', '', '60000', '2020', '4', '2020-04-10', null, '', '0', null, '0', 'Kumar Sathish', '2020-06-08 00:54:10', 'Kumar Sathish', '2020-06-08 00:54:10');
INSERT INTO inv_salary_main VALUES ('23', 'AD0005', '2020-06-10', 'SD006$10000##', 'DD001$-40000##', '70000', '50000', '', '', '90000', '2020', '5', '2020-05-10', '-5.55', '', '0', null, '0', 'Kumar Sathish', '2020-06-09 04:28:24', 'Kumar Sathish', '2020-06-09 08:25:21');
INSERT INTO inv_salary_main VALUES ('24', 'MB0067', '2020-06-10', 'SD006$10000##', 'DD001$-40000##', '50000', '40000', '', '', '60000', '2020', '5', '2020-05-10', '2', '', '0', null, '0', 'Kumar Sathish', '2020-06-10 09:34:59', 'Kumar Sathish', '2020-06-10 09:35:55');
INSERT INTO inv_salary_main VALUES ('26', 'MB0001', '2019-12-10', 'SD006$10000##', 'DD001$-10##', '250000', '80000', '9530', '52500', '361930', '2019', '11', '2019-12-10', '', '', '0', null, '0', 'Kumar Sathish', '2019-12-07 09:55:45', 'Kumar Sathish', '2019-12-07 09:55:45');
INSERT INTO inv_salary_main VALUES ('27', 'MB0001', '2020-06-10', '', 'DD001$-40000##', '270000', '40000', '9600', '52500', '332100', '2020', '5', '2020-05-10', '', '', '0', null, '0', 'Kumar Sathish', '2020-07-09 01:28:53', 'Kumar Sathish', '2020-07-09 01:28:53');
INSERT INTO inv_salary_main VALUES ('28', 'MB0110', '2020-06-10', '', 'DD001$-40000##', '170000', '40000', '1600', '7227', '178827', '2020', '5', '2020-05-10', '', '', '0', null, '0', 'Kumar Sathish', '2020-07-09 02:07:20', 'Kumar Sathish', '2020-07-09 02:07:20');
INSERT INTO inv_salary_main VALUES ('29', 'MB0002', '2020-07-10', '', 'DD001$-40000##', '155000', '50000', '', '', '165000', '2020', '6', '2020-06-10', '', '', '0', null, '0', 'Kumar Sathish', '2020-07-13 06:35:45', 'Kumar Sathish', '2020-07-13 06:35:45');
INSERT INTO inv_salary_main VALUES ('30', 'AD0000', '2020-08-21', '', 'DD002$-675##', '70000', '40000', '', '', '109325', '2020', '7', '2020-07-10', '', '', '0', null, '0', 'Kumar Sathish', '2020-08-17 05:34:22', 'Kumar Sathish', '2020-08-17 05:35:33');

-- ----------------------------
-- Table structure for `inv_salary_main_emp`
-- ----------------------------
DROP TABLE IF EXISTS `inv_salary_main_emp`;
CREATE TABLE `inv_salary_main_emp` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `Emp_Id` varchar(30) DEFAULT NULL,
  `delflg` int(1) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_by` varchar(100) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=853 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of inv_salary_main_emp
-- ----------------------------
INSERT INTO inv_salary_main_emp VALUES ('704', 'AD0000', '0', '2020', '8', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('703', '089505', '0', '2020', '8', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('702', '089504', '0', '2020', '8', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('701', '089503', '0', '2020', '8', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('700', '00113', '0', '2020', '8', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('699', '00113', '0', '2020', '12', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('698', '089503', '0', '2020', '12', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('697', '089504', '0', '2020', '12', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('696', '089505', '0', '2020', '12', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('695', 'AD0000', '0', '2020', '12', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('694', 'AD0000', '0', '2019', '12', '2020-05-25 00:21:23', 'Sathish', '2020-05-25 00:21:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('693', '089505', '0', '2019', '12', '2020-05-25 00:21:23', 'Sathish', '2020-05-25 00:21:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('692', '089504', '0', '2019', '12', '2020-05-25 00:21:23', 'Sathish', '2020-05-25 00:21:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('691', '089503', '0', '2019', '12', '2020-05-25 00:21:23', 'Sathish', '2020-05-25 00:21:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('690', '00113', '0', '2019', '12', '2020-05-25 00:21:23', 'Sathish', '2020-05-25 00:21:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('688', 'MB0039', '0', '2020', '1', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('687', 'MB0038', '0', '2020', '1', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('686', 'MB0033', '0', '2020', '1', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('685', 'MB0011', '0', '2020', '1', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('684', 'MB0010', '0', '2020', '1', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('683', 'MB0002', '0', '2020', '1', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('682', 'MB0001', '0', '2020', '1', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('681', 'MB', '0', '2020', '1', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('680', 'geeer', '0', '2020', '1', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('679', 'AD0000', '0', '2020', '1', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('678', '089505', '0', '2020', '1', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('677', '089504', '0', '2020', '1', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('676', '089503', '0', '2020', '1', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('675', '00113', '0', '2020', '1', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('674', '00113', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('673', '089503', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('672', '089504', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('671', '089505', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('670', 'AD0000', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('669', 'geeer', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('668', 'MB', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('667', 'MB0001', '0', '2019', '9', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('666', 'MB0002', '0', '2019', '12', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('665', 'MB0010', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('664', 'MB0011', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('663', 'MB0033', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('662', 'MB0038', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('661', 'MB0039', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('660', 'MB0039', '0', '2020', '4', '2020-05-25 00:14:11', 'Sathish', '2020-05-25 00:14:11', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('659', 'MB0038', '0', '2020', '4', '2020-05-25 00:14:11', 'Sathish', '2020-05-25 00:14:11', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('658', 'MB0033', '0', '2020', '4', '2020-05-25 00:14:11', 'Sathish', '2020-05-25 00:14:11', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('657', 'MB0011', '0', '2020', '4', '2020-05-25 00:14:11', 'Sathish', '2020-05-25 00:14:11', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('656', 'MB0010', '0', '2020', '4', '2020-05-25 00:14:11', 'Sathish', '2020-05-25 00:14:11', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('655', 'MB0002', '0', '2020', '4', '2020-05-25 00:14:11', 'Sathish', '2020-05-25 00:14:11', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('654', 'MB0001', '0', '2020', '4', '2020-05-25 00:14:11', 'Sathish', '2020-05-25 00:14:11', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('653', 'MB', '0', '2020', '4', '2020-05-25 00:14:11', 'Sathish', '2020-05-25 00:14:11', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('652', 'geeer', '0', '2020', '4', '2020-05-25 00:14:11', 'Sathish', '2020-05-25 00:14:11', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('651', 'AD0000', '0', '2020', '4', '2020-05-25 00:14:11', 'Sathish', '2020-05-25 00:14:11', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('650', '089505', '0', '2020', '4', '2020-05-25 00:14:11', 'Sathish', '2020-05-25 00:14:11', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('649', '089504', '0', '2020', '4', '2020-05-25 00:14:11', 'Sathish', '2020-05-25 00:14:11', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('648', '089503', '0', '2020', '4', '2020-05-25 00:14:11', 'Sathish', '2020-05-25 00:14:11', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('647', '00113', '0', '2020', '4', '2020-05-25 00:14:11', 'Sathish', '2020-05-25 00:14:11', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('843', 'MB0136', '0', '2019', '11', '2020-07-31 01:35:08', 'Sathish', '2020-07-31 01:35:08', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('842', 'MB0133', '0', '2019', '11', '2020-07-31 01:35:08', 'Sathish', '2020-07-31 01:35:08', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('841', 'MB0113', '0', '2019', '11', '2020-07-31 01:35:08', 'Sathish', '2020-07-31 01:35:08', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('840', 'MB0068', '0', '2019', '11', '2020-07-31 01:35:08', 'Sathish', '2020-07-31 01:35:08', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('839', 'MB0067', '0', '2019', '11', '2020-07-31 01:35:08', 'Sathish', '2020-07-31 01:35:08', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('838', 'MB0110', '0', '2019', '11', '2020-07-31 01:35:08', 'Sathish', '2020-07-31 01:35:08', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('837', 'MB0002', '0', '2019', '11', '2020-07-31 01:35:08', 'Sathish', '2020-07-31 01:35:08', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('836', 'MB0001', '0', '2019', '11', '2020-07-31 01:35:08', 'Sathish', '2020-07-31 01:35:08', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('835', 'AD0000', '0', '2019', '11', '2020-07-31 01:35:08', 'Sathish', '2020-07-31 01:35:08', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('757', 'MB0110', '0', '2019', '10', '2019-11-26 05:22:19', 'Sathish', '2019-11-26 05:22:19', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('756', 'MB0038', '0', '2019', '10', '2019-11-26 05:22:19', 'Sathish', '2019-11-26 05:22:19', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('755', 'MB0033', '0', '2019', '10', '2019-11-26 05:22:19', 'Sathish', '2019-11-26 05:22:19', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('754', 'MB0011', '0', '2019', '10', '2019-11-26 05:22:19', 'Sathish', '2019-11-26 05:22:19', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('753', 'MB0010', '0', '2019', '10', '2019-11-26 05:22:19', 'Sathish', '2019-11-26 05:22:19', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('752', 'MB0002', '0', '2019', '10', '2019-11-26 05:22:19', 'Sathish', '2019-11-26 05:22:19', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('751', 'MB0001', '0', '2019', '10', '2019-11-26 05:22:19', 'Sathish', '2019-11-26 05:22:19', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('750', 'geeer', '0', '2019', '10', '2019-11-26 05:22:19', 'Sathish', '2019-11-26 05:22:19', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('749', 'AD0000', '0', '2019', '10', '2019-11-26 05:22:19', 'Sathish', '2019-11-26 05:22:19', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('748', '089505', '0', '2019', '10', '2019-11-26 05:22:19', 'Sathish', '2019-11-26 05:22:19', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('747', '089504', '0', '2019', '10', '2019-11-26 05:22:19', 'Sathish', '2019-11-26 05:22:19', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('746', '089503', '0', '2019', '10', '2019-11-26 05:22:19', 'Sathish', '2019-11-26 05:22:19', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('745', '00113', '0', '2019', '10', '2019-11-26 05:22:19', 'Sathish', '2019-11-26 05:22:19', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('783', 'MB0038', '0', '2019', '9', '2019-10-26 05:39:41', 'Sathish', '2019-10-26 05:39:41', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('782', 'MB0033', '0', '2019', '9', '2019-10-26 05:39:41', 'Sathish', '2019-10-26 05:39:41', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('781', 'MB0011', '0', '2019', '9', '2019-10-26 05:39:41', 'Sathish', '2019-10-26 05:39:41', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('780', 'MB0010', '0', '2019', '9', '2019-10-26 05:39:41', 'Sathish', '2019-10-26 05:39:41', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('779', 'MB0002', '0', '2019', '9', '2019-10-26 05:39:41', 'Sathish', '2019-10-26 05:39:41', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('778', 'MB0001', '0', '2019', '9', '2019-10-26 05:39:41', 'Sathish', '2019-10-26 05:39:41', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('777', 'geeer', '0', '2019', '9', '2019-10-26 05:39:41', 'Sathish', '2019-10-26 05:39:41', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('776', 'AD0000', '0', '2019', '9', '2019-10-26 05:39:41', 'Sathish', '2019-10-26 05:39:41', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('775', '089505', '0', '2019', '9', '2019-10-26 05:39:41', 'Sathish', '2019-10-26 05:39:41', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('774', '089504', '0', '2019', '9', '2019-10-26 05:39:41', 'Sathish', '2019-10-26 05:39:41', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('773', '089503', '0', '2019', '9', '2019-10-26 05:39:41', 'Sathish', '2019-10-26 05:39:41', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('772', '00113', '0', '2019', '9', '2019-10-26 05:39:41', 'Sathish', '2019-10-26 05:39:41', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('834', 'MB0229', '0', '2020', '3', '2020-07-31 01:08:39', 'Sathish', '2020-07-31 01:08:39', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('833', 'SS0078', '0', '2020', '3', '2020-07-31 01:08:39', 'Sathish', '2020-07-31 01:08:39', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('832', 'MB0341', '0', '2020', '3', '2020-07-31 01:08:39', 'Sathish', '2020-07-31 01:08:39', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('831', 'SS0109', '0', '2020', '3', '2020-07-31 01:08:39', 'Sathish', '2020-07-31 01:08:39', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('830', 'MB0335', '0', '2020', '3', '2020-07-31 01:08:39', 'Sathish', '2020-07-31 01:08:39', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('829', 'MB0332', '0', '2020', '3', '2020-07-31 01:08:39', 'Sathish', '2020-07-31 01:08:39', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('350', 'AD0000', '0', '2020', '4', '2020-06-09 04:40:23', 'Sathish', '2020-06-09 04:40:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('351', 'MB0001', '0', '2020', '4', '2020-06-09 04:40:23', 'Sathish', '2020-06-09 04:40:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('352', 'MB0002', '0', '2020', '4', '2020-06-09 04:40:23', 'Sathish', '2020-06-09 04:40:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('353', 'MB0004', '0', '2020', '4', '2020-06-09 04:40:23', 'Sathish', '2020-06-09 04:40:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('354', 'MB0064', '0', '2020', '4', '2020-06-09 04:40:23', 'Sathish', '2020-06-09 04:40:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('355', 'MB0066', '0', '2020', '4', '2020-06-09 04:40:23', 'Sathish', '2020-06-09 04:40:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('356', 'MB0067', '0', '2020', '4', '2020-06-09 04:40:23', 'Sathish', '2020-06-09 04:40:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('357', 'MB0068', '0', '2020', '4', '2020-06-09 04:40:23', 'Sathish', '2020-06-09 04:40:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('358', 'MB0110', '0', '2020', '4', '2020-06-09 04:40:23', 'Sathish', '2020-06-09 04:40:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('359', 'MB0113', '0', '2020', '4', '2020-06-09 04:40:23', 'Sathish', '2020-06-09 04:40:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('826', 'MB0110', '0', '2020', '6', '2020-07-13 06:35:07', 'Sathish', '2020-07-13 06:35:07', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('825', 'MB0068', '0', '2020', '6', '2020-07-13 06:35:07', 'Sathish', '2020-07-13 06:35:07', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('824', 'MB0067', '0', '2020', '6', '2020-07-13 06:35:07', 'Sathish', '2020-07-13 06:35:07', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('823', 'MB0066', '0', '2020', '6', '2020-07-13 06:35:07', 'Sathish', '2020-07-13 06:35:07', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('822', 'MB0064', '0', '2020', '6', '2020-07-13 06:35:07', 'Sathish', '2020-07-13 06:35:07', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('821', 'MB0004', '0', '2020', '6', '2020-07-13 06:35:07', 'Sathish', '2020-07-13 06:35:07', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('820', 'MB0002', '0', '2020', '6', '2020-07-13 06:35:07', 'Sathish', '2020-07-13 06:35:07', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('819', 'MB0001', '0', '2020', '6', '2020-07-13 06:35:07', 'Sathish', '2020-07-13 06:35:07', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('818', 'AD0005', '0', '2020', '6', '2020-07-13 06:35:07', 'Sathish', '2020-07-13 06:35:07', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('817', 'AD0000', '0', '2020', '6', '2020-07-13 06:35:07', 'Sathish', '2020-07-13 06:35:07', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('219', 'AD0000', '0', '2020', '5', '2020-05-24 00:00:00', 'Kumar Sathish', '2020-05-24 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('220', 'AD0005', '0', '2020', '5', '2020-05-24 00:00:00', 'Kumar Sathish', '2020-05-24 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('221', 'MB0001', '0', '2020', '5', '2020-05-24 00:00:00', 'Kumar Sathish', '2020-05-24 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('222', 'MB0002', '0', '2020', '5', '2020-05-24 00:00:00', 'Kumar Sathish', '2020-05-24 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('223', 'MB0004', '0', '2020', '5', '2020-05-24 00:00:00', 'Kumar Sathish', '2020-05-24 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('224', 'MB0064', '0', '2020', '5', '2020-05-24 00:00:00', 'Kumar Sathish', '2020-05-24 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('225', 'MB0066', '0', '2020', '5', '2020-05-24 00:00:00', 'Kumar Sathish', '2020-05-24 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('226', 'MB0067', '0', '2020', '5', '2020-05-24 00:00:00', 'Kumar Sathish', '2020-05-24 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('227', 'MB0068', '0', '2020', '5', '2020-05-24 00:00:00', 'Kumar Sathish', '2020-05-24 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('228', 'MB0110', '0', '2020', '5', '2020-05-24 00:00:00', 'Kumar Sathish', '2020-05-24 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('360', 'MB0139', '0', '2020', '4', '2020-06-09 04:40:23', 'Sathish', '2020-06-09 04:40:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('240', 'MB0113', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('241', 'MB0110', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('242', 'MB0068', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('243', 'MB0067', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('244', 'MB0066', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('245', 'MB0064', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('246', 'MB0004', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('247', 'MB0002', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('248', 'MB0001', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('249', 'AD0005', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('250', 'AD0000', '0', '2020', '7', '2020-05-25 00:00:00', 'Kumar Sathish', '2020-05-25 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('828', 'MB0331', '0', '2020', '3', '2020-07-31 01:08:39', 'Sathish', '2020-07-31 01:08:39', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('361', 'MB0140', '0', '2020', '4', '2020-06-09 04:40:23', 'Sathish', '2020-06-09 04:40:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('362', 'MB0142', '0', '2020', '4', '2020-06-09 04:40:23', 'Sathish', '2020-06-09 04:40:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('324', 'MB0142', '0', '2020', '9', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('325', 'MB0140', '0', '2020', '9', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('326', 'MB0139', '0', '2020', '9', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('327', 'MB0113', '0', '2020', '9', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('328', 'MB0110', '0', '2020', '9', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('329', 'MB0068', '0', '2020', '9', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('330', 'MB0067', '0', '2020', '9', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('331', 'MB0066', '0', '2020', '9', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('332', 'MB0064', '0', '2020', '9', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('333', 'MB0004', '0', '2020', '9', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('334', 'MB0002', '0', '2020', '9', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('335', 'MB0001', '0', '2020', '9', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('336', 'AD0000', '0', '2020', '9', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('337', 'AD0000', '0', '2020', '8', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('338', 'MB0001', '0', '2020', '8', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('339', 'MB0002', '0', '2020', '8', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('340', 'MB0004', '0', '2020', '8', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('341', 'MB0064', '0', '2020', '8', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('342', 'MB0066', '0', '2020', '8', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('343', 'MB0067', '0', '2020', '8', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('344', 'MB0068', '0', '2020', '8', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('345', 'MB0110', '0', '2020', '8', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('346', 'MB0113', '0', '2020', '8', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('347', 'MB0139', '0', '2020', '8', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('348', 'MB0140', '0', '2020', '8', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('349', 'MB0142', '0', '2020', '8', '2020-06-01 00:00:00', 'Kumar Sathish', '2020-06-01 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('363', 'AD0005', '0', '2020', '4', '2020-06-09 04:40:23', 'Sathish', '2020-06-09 04:40:23', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('795', 'MB0038', '0', '2020', '5', '2020-06-01 00:51:17', 'Sathish', '2020-06-01 00:51:17', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('794', 'MB0033', '0', '2020', '5', '2020-06-01 00:51:17', 'Sathish', '2020-06-01 00:51:17', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('793', 'MB0011', '0', '2020', '5', '2020-06-01 00:51:17', 'Sathish', '2020-06-01 00:51:17', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('792', 'MB0132', '0', '2020', '5', '2020-06-01 00:51:17', 'Sathish', '2020-06-01 00:51:17', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('791', 'MB0002', '0', '2020', '5', '2020-06-01 00:51:17', 'Sathish', '2020-06-01 00:51:17', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('827', 'MB0001', '0', '2020', '3', '2020-07-31 01:08:39', 'Sathish', '2020-07-31 01:08:39', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('789', 'geeer', '0', '2020', '5', '2020-06-01 00:51:17', 'Sathish', '2020-06-01 00:51:17', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('788', 'AD0000', '0', '2020', '5', '2020-06-01 00:51:17', 'Sathish', '2020-06-01 00:51:17', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('787', '089505', '0', '2020', '5', '2020-06-01 00:51:17', 'Sathish', '2020-06-01 00:51:17', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('786', '089504', '0', '2020', '5', '2020-06-01 00:51:17', 'Sathish', '2020-06-01 00:51:17', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('785', '089503', '0', '2020', '5', '2020-06-01 00:51:17', 'Sathish', '2020-06-01 00:51:17', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('784', '00113', '0', '2020', '5', '2020-06-01 00:51:17', 'Sathish', '2020-06-01 00:51:17', 'Sathish');
INSERT INTO inv_salary_main_emp VALUES ('796', 'AD0000', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('797', 'AD0005', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('798', 'MB0001', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('799', 'MB0002', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('800', 'MB0004', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('801', 'MB0064', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('802', 'MB0066', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('803', 'MB0067', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('804', 'MB0068', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('805', 'MB0110', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('806', 'MB0038', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('807', 'MB0033', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('808', 'MB0011', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('809', 'MB0132', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('810', 'MB0002', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('811', 'geeer', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('812', 'AD0000', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('813', '089505', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('814', '089504', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('815', '089503', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('816', '00113', '0', '2019', '6', '2020-07-06 00:00:00', 'Kumar Sathish', '2020-07-06 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('844', 'MB0136', '0', '2020', '10', '2020-08-05 00:00:00', 'Kumar Sathish', '2020-08-05 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('845', 'MB0133', '0', '2020', '10', '2020-08-05 00:00:00', 'Kumar Sathish', '2020-08-05 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('846', 'MB0113', '0', '2020', '10', '2020-08-05 00:00:00', 'Kumar Sathish', '2020-08-05 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('847', 'MB0068', '0', '2020', '10', '2020-08-05 00:00:00', 'Kumar Sathish', '2020-08-05 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('848', 'MB0067', '0', '2020', '10', '2020-08-05 00:00:00', 'Kumar Sathish', '2020-08-05 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('849', 'MB0110', '0', '2020', '10', '2020-08-05 00:00:00', 'Kumar Sathish', '2020-08-05 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('850', 'MB0002', '0', '2020', '10', '2020-08-05 00:00:00', 'Kumar Sathish', '2020-08-05 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('851', 'MB0001', '0', '2020', '10', '2020-08-05 00:00:00', 'Kumar Sathish', '2020-08-05 00:00:00', 'Kumar Sathish');
INSERT INTO inv_salary_main_emp VALUES ('852', 'AD0000', '0', '2020', '10', '2020-08-05 00:00:00', 'Kumar Sathish', '2020-08-05 00:00:00', 'Kumar Sathish');

-- ----------------------------
-- Table structure for `mstcontract`
-- ----------------------------
DROP TABLE IF EXISTS `mstcontract`;
CREATE TABLE `mstcontract` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Emp_id` varchar(9) NOT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `Salary` varchar(7) DEFAULT NULL,
  `Travel_Expense` varchar(6) DEFAULT NULL,
  `Accommodation` varchar(6) DEFAULT NULL,
  `Total` varchar(10) DEFAULT NULL,
  `Contract_date` date DEFAULT NULL,
  `Remarks` text CHARACTER SET utf8,
  `Created_Name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `Created_Date` datetime DEFAULT NULL,
  `Update_Name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `Update_Date` datetime DEFAULT NULL,
  `Delete_flg` int(1) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mstcontract
-- ----------------------------
INSERT INTO mstcontract VALUES ('1', 'MB0001', '2020-08-02', '2021-08-01', '980890', '456456', '546546', '1,437,346', '2020-08-06', '', 'Kumar Sathish', '2020-08-11 06:56:40', null, '2020-08-11 06:56:40', '0');
INSERT INTO mstcontract VALUES ('2', 'MB0001', '2020-08-27', '2021-08-26', '980890', '456456', '546546', '1,437,346', '2020-08-06', '', 'Kumar Sathish', '2020-08-11 06:57:07', null, '2020-08-11 06:57:07', '0');
INSERT INTO mstcontract VALUES ('3', 'MB0001', '2020-08-27', '2021-08-26', '980890', '456456', '546546', '1,437,346', '2020-08-06', '', 'Kumar Sathish', '2020-08-11 06:59:09', null, '2020-08-11 06:59:09', '0');
INSERT INTO mstcontract VALUES ('4', 'MB0001', '2020-08-07', '2021-08-06', '980890', '456456', '546546', '1,437,346', '2020-08-08', '', 'Kumar Sathish', '2020-08-11 07:00:33', null, '2020-08-11 07:00:33', '0');
INSERT INTO mstcontract VALUES ('5', 'MB0001', '2020-08-07', '2021-08-06', '980890', '456456', '546546', '1,437,346', '2020-06-05', '', 'Kumar Sathish', '2020-08-11 07:01:52', null, '2020-08-11 07:01:52', '0');
INSERT INTO mstcontract VALUES ('6', 'MB0001', '2020-08-07', '2021-08-06', '980890', '456456', '546546', '1,437,346', '2020-06-05', '', 'Kumar Sathish', '2020-08-11 07:02:22', null, '2020-08-11 07:02:22', '0');
INSERT INTO mstcontract VALUES ('7', 'MB0001', '2020-08-07', '2021-08-06', '980890', '456456', '546546', '1,437,346', '2020-08-06', '', 'Kumar Sathish', '2020-08-11 07:03:51', null, '2020-08-11 07:03:51', '0');

-- ----------------------------
-- Table structure for `mstsalary`
-- ----------------------------
DROP TABLE IF EXISTS `mstsalary`;
CREATE TABLE `mstsalary` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `Salarayid` varchar(10) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `nick_name` varchar(50) DEFAULT NULL,
  `location` int(1) DEFAULT NULL,
  `delflg` int(1) DEFAULT NULL,
  `Ins_DT` date DEFAULT NULL,
  `Ins_TM` time DEFAULT NULL,
  `Up_DT` date DEFAULT NULL,
  `Up_TM` time DEFAULT NULL,
  `CreatedBy` varchar(100) DEFAULT NULL,
  `UpdatedBy` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mstsalary
-- ----------------------------
INSERT INTO mstsalary VALUES ('1', 'SD001', 'Basic1', null, '1', '0', '2020-05-05', null, '2020-05-15', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('2', 'DD001', 'House Deduction', null, '2', '0', '2020-05-05', null, '2020-05-05', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('3', 'SD002', 'HRA', null, '1', '0', '2020-05-05', null, '2020-05-05', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('4', 'SD003', 'Plain', '', '1', '0', '2020-05-14', null, '2020-08-05', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('5', 'SD004', 'Flight', null, '1', '0', '2020-05-14', null, '2020-05-14', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('6', 'SD005', 'House', null, '1', '0', '2020-05-14', null, '2020-05-14', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('7', 'SD006', 'Client', null, '1', '0', '2020-05-14', null, '2020-05-14', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('8', 'DD002', '						Rent', '						', '2', '0', '2020-05-14', null, '2020-08-05', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('9', 'DD003', 'Deduction', null, '2', '0', '2020-05-14', null, '2020-05-14', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('10', 'SD007', 'Full month work allowance', null, '1', '0', '2020-05-15', null, '2020-05-21', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('13', 'SD010', 'Flight Fare', null, '1', '0', '2020-05-21', null, '2020-05-21', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('12', 'SD009', 'Food', null, '1', '0', '2020-05-21', null, '2020-05-21', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('11', 'SD008', 'Tokyo Allowance', null, '1', '0', '2020-05-21', null, '2020-05-21', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('14', 'SD011', 'Old Balances', null, '1', '0', '2020-05-21', null, '2020-05-21', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('15', 'SD012', 'Other Expenses', null, '1', '0', '2020-05-21', null, '2020-05-21', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('16', 'SD013', 'M.D', '', '1', '0', '2020-08-05', null, '2020-08-05', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalary VALUES ('17', 'DD004', 'Food', '', '2', '0', '2020-08-05', null, '2020-08-05', null, 'Sathish Kumar', 'Sathish Kumar');

-- ----------------------------
-- Table structure for `mstsalaryplus`
-- ----------------------------
DROP TABLE IF EXISTS `mstsalaryplus`;
CREATE TABLE `mstsalaryplus` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `Salarayid` varchar(10) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `nick_name` varchar(50) DEFAULT NULL,
  `location` int(1) DEFAULT NULL,
  `delflg` int(1) DEFAULT NULL,
  `Ins_DT` date DEFAULT NULL,
  `Ins_TM` time DEFAULT NULL,
  `Up_DT` date DEFAULT NULL,
  `Up_TM` time DEFAULT NULL,
  `CreatedBy` varchar(100) DEFAULT NULL,
  `UpdatedBy` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mstsalaryplus
-- ----------------------------
INSERT INTO mstsalaryplus VALUES ('1', 'SD001', 'Basic', null, '1', '0', '2020-06-04', null, '2020-06-04', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalaryplus VALUES ('2', 'SD002', 'HRA', '', '1', '0', '2020-06-04', null, '2020-08-05', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalaryplus VALUES ('3', 'SD003', 'Client Allowance', 'CA', '1', '0', '2020-06-04', null, '2020-06-11', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalaryplus VALUES ('4', 'SD004', 'Full month Allowance', 'FMA', '1', '0', '2020-06-04', null, '2020-06-08', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalaryplus VALUES ('5', 'DD001', 'Rent', null, '2', '0', '2020-06-04', null, '2020-06-04', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalaryplus VALUES ('6', 'DD002', 'Deduction', null, '2', '0', '2020-06-04', null, '2020-06-04', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalaryplus VALUES ('7', 'SD005', 'Testing Check', 'TC', '1', '1', '2020-06-08', null, '2020-06-08', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalaryplus VALUES ('8', 'DD003', '						Testing Check', '						TC1', '2', '0', '2020-06-08', null, '2020-08-05', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalaryplus VALUES ('9', 'SD006', 'Test1', '', '1', '0', '2020-07-16', null, '2020-07-16', null, 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO mstsalaryplus VALUES ('10', 'DD004', 'hghg', '', '2', '0', '2020-07-17', null, '2020-07-17', null, 'Sathish Kumar', 'Sathish Kumar');

-- ----------------------------
-- Table structure for `olddbdetailsregistration`
-- ----------------------------
DROP TABLE IF EXISTS `olddbdetailsregistration`;
CREATE TABLE `olddbdetailsregistration` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `DBName` varchar(200) DEFAULT NULL,
  `UserName` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `Ins_DT` date DEFAULT NULL,
  `Ins_TM` time DEFAULT NULL,
  `Up_DT` date DEFAULT NULL,
  `UP_TM` time DEFAULT NULL,
  `CreatedBy` varchar(200) DEFAULT NULL,
  `UpdatedBy` varchar(200) DEFAULT NULL,
  `Delflg` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of olddbdetailsregistration
-- ----------------------------
INSERT INTO olddbdetailsregistration VALUES ('1', 'vps10081_old_ssinvdb_dev', 'vps10081_ssinvdb', 'qRbJzqGJR{4s', '2015-10-28', '02:52:49', '0000-00-00', '00:00:00', 'Kumar&nbsp;Sathish', '', '0');
INSERT INTO olddbdetailsregistration VALUES ('4', 'vps10081_mbstaffdev_1', 'vps10081_mstafdb', 'm6&kb&#~UGkX', '2015-12-15', '12:43:08', '2020-08-05', '00:00:00', 'Kumar&nbsp;Sathish', 'Sathish Kumar', '0');
INSERT INTO olddbdetailsregistration VALUES ('5', 'vps10081_house_devdb', 'vps10081_h_devdb', 'BZhhvGW9hw', '2016-04-22', '12:29:03', '0000-00-00', '00:00:00', 'Kumar&nbsp;Sathish', '', '0');
INSERT INTO olddbdetailsregistration VALUES ('6', 'mbsys_db', 'root', null, null, null, null, null, null, null, '0');

-- ----------------------------
-- Table structure for `salarycertification`
-- ----------------------------
DROP TABLE IF EXISTS `salarycertification`;
CREATE TABLE `salarycertification` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` varchar(10) DEFAULT NULL,
  `contract_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `reason` text,
  `total` varchar(100) DEFAULT NULL,
  `delflg` int(1) DEFAULT NULL,
  `createdby` varchar(100) DEFAULT NULL,
  `Ins_Dt` datetime DEFAULT NULL,
  `updatedby` varchar(100) DEFAULT NULL,
  `Upd_Dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of salarycertification
-- ----------------------------
INSERT INTO salarycertification VALUES ('1', 'MB0002', '10', null, 'test 60000', '60,000', '0', 'Sathish Kumar', '2020-07-02 08:59:35', null, null);
INSERT INTO salarycertification VALUES ('2', 'MB0002', '9', null, 'test 111', '111', '0', 'Sathish Kumar', '2020-07-02 09:00:22', null, null);
INSERT INTO salarycertification VALUES ('3', 'MB0002', '10', null, 'test 60001', '60,001', '0', 'Sathish Kumar', '2020-07-02 09:01:26', null, null);
INSERT INTO salarycertification VALUES ('4', 'MB0064', '13', null, 'test 90056', '90,056', '0', 'Sathish Kumar', '2020-07-02 09:04:38', null, null);
INSERT INTO salarycertification VALUES ('5', 'MB0001', '1', null, 'check 60,000 円', '60,000', '0', 'Sathish Kumar', '2020-07-02 09:04:40', null, null);
INSERT INTO salarycertification VALUES ('6', 'MB0001', '2', null, 'test 240000', '240,000', '0', 'Sathish Kumar', '2020-07-02 09:14:26', null, null);
INSERT INTO salarycertification VALUES ('7', 'MB0002', '10', null, 'test 60002', '60,002', '0', 'Sathish Kumar', '2020-07-02 09:15:53', null, null);
INSERT INTO salarycertification VALUES ('8', 'MB0004', '6', null, 'Apply visa for his wife', '230,002', '0', 'Sathish Kumar', '2020-07-02 11:53:52', null, null);
INSERT INTO salarycertification VALUES ('9', 'MB0004', '6', null, 'Apply visa for his wife', '230,002', '0', 'Sathish Kumar', '2020-07-02 11:53:52', null, null);
INSERT INTO salarycertification VALUES ('10', 'MB0004', '6', null, 'Apply visa for his wife', '230,002', '0', 'Sathish Kumar', '2020-07-02 11:53:54', null, null);

-- ----------------------------
-- Table structure for `salary_companydetails`
-- ----------------------------
DROP TABLE IF EXISTS `salary_companydetails`;
CREATE TABLE `salary_companydetails` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `companyId` varchar(10) NOT NULL,
  `companyName` varchar(50) NOT NULL,
  `companyAddress` varchar(300) NOT NULL,
  `companyPhoneNo` int(15) NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDateTime` datetime NOT NULL,
  `updatedBy` varchar(30) DEFAULT NULL,
  `updatedDateTime` datetime DEFAULT NULL,
  `delFlag` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`companyId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of salary_companydetails
-- ----------------------------

-- ----------------------------
-- Table structure for `salc_required_document`
-- ----------------------------
DROP TABLE IF EXISTS `salc_required_document`;
CREATE TABLE `salc_required_document` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `registered_date` date NOT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_type` int(1) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `delflg` int(1) DEFAULT '0',
  `Ins_DT` date NOT NULL,
  `Ins_TM` time NOT NULL,
  `Up_DT` date NOT NULL,
  `UP_TM` time NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `UpdatedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of salc_required_document
-- ----------------------------
INSERT INTO salc_required_document VALUES ('1', '2019-08-07', '1', '2020_力不足.xlsx', '2', '', '0', '2019-08-07', '07:18:09', '2019-08-07', '07:18:09', 'Sathish', 'Sathish');

-- ----------------------------
-- Table structure for `salc_visa_document`
-- ----------------------------
DROP TABLE IF EXISTS `salc_visa_document`;
CREATE TABLE `salc_visa_document` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `document_name` varchar(255) DEFAULT NULL,
  `delflg` int(1) DEFAULT '0',
  `Ins_DT` date NOT NULL,
  `Ins_TM` time NOT NULL,
  `Up_DT` date NOT NULL,
  `UP_TM` time NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `UpdatedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of salc_visa_document
-- ----------------------------
INSERT INTO salc_visa_document VALUES ('1', '力不足', '0', '2020-08-05', '00:00:00', '2020-08-05', '00:00:00', 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO salc_visa_document VALUES ('2', 'IOS', '0', '2020-08-05', '00:00:00', '2020-08-05', '00:00:00', 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO salc_visa_document VALUES ('3', 'IOSa', '0', '2020-08-05', '00:00:00', '2020-08-05', '00:00:00', 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO salc_visa_document VALUES ('4', 'IOSb', '0', '2020-08-05', '00:00:00', '2020-08-05', '00:00:00', 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO salc_visa_document VALUES ('5', 'IOSc', '0', '2020-08-05', '00:00:00', '2020-08-05', '00:00:00', 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO salc_visa_document VALUES ('6', 'IOSe', '0', '2020-08-05', '00:00:00', '2020-08-05', '00:00:00', 'Sathish Kumar', 'Sathish Kumar');
INSERT INTO salc_visa_document VALUES ('7', 'IOSg', '0', '2020-08-05', '00:00:00', '2020-08-05', '00:00:00', 'Sathish Kumar', 'Sathish Kumar');

-- ----------------------------
-- Table structure for `sales_details`
-- ----------------------------
DROP TABLE IF EXISTS `sales_details`;
CREATE TABLE `sales_details` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `period` int(10) NOT NULL,
  `salesAmount` varchar(30) NOT NULL,
  `createdDateTime` datetime NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `updatedDateTime` datetime DEFAULT NULL,
  `updatedBy` varchar(30) DEFAULT NULL,
  `delFlag` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sales_details
-- ----------------------------
INSERT INTO sales_details VALUES ('1', '4', '22222220000 万', '2020-07-02 11:07:23', 'Sathish', '2020-08-05 11:08:24', 'Sathish', '0');
