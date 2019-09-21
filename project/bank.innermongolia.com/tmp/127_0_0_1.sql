-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2018-11-26 15:07:29
-- 服务器版本： 5.7.11
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: webadmin
--
CREATE DATABASE IF NOT EXISTS webadmin DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE webadmin;

--
-- 视图结构 statictis_login_monthday
--
DROP TABLE IF EXISTS `statictis_login_monthday`;

CREATE ALGORITHM=UNDEFINED DEFINER=root@localhost SQL SECURITY DEFINER VIEW webadmin.statictis_login_monthday  AS  select count(webadmin.optlog.id) AS `count(id)` from webadmin.optlog where (((((((unix_timestamp(now()) DIV ((30 * 24) * 3600)) * 30) * 24) * 3600) - unix_timestamp(webadmin.optlog.regTime)) < ((30 * 24) * 3600)) and (webadmin.optlog.title = '登录')) ;

-- --------------------------------------------------------

--
-- 视图结构 statictis_login_oneday
--
DROP TABLE IF EXISTS `statictis_login_oneday`;

CREATE ALGORITHM=UNDEFINED DEFINER=root@localhost SQL SECURITY DEFINER VIEW webadmin.statictis_login_oneday  AS  select count(webadmin.optlog.id) AS `count(id)` from webadmin.optlog where ((((((unix_timestamp(now()) DIV (24 * 3600)) * 24) * 3600) - unix_timestamp(webadmin.optlog.regTime)) < (24 * 3600)) and (webadmin.optlog.title = '登录')) ;

-- --------------------------------------------------------

--
-- 视图结构 statictis_login_sevenday
--
DROP TABLE IF EXISTS `statictis_login_sevenday`;

CREATE ALGORITHM=UNDEFINED DEFINER=root@localhost SQL SECURITY DEFINER VIEW webadmin.statictis_login_sevenday  AS  select count(webadmin.optlog.id) AS `count(id)` from webadmin.optlog where (((((((unix_timestamp(now()) DIV ((7 * 24) * 3600)) * 7) * 24) * 3600) - unix_timestamp(webadmin.optlog.regTime)) < ((7 * 24) * 3600)) and (webadmin.optlog.title = '登录')) ;

-- --------------------------------------------------------

--
-- 视图结构 statictis_login_yearday
--
DROP TABLE IF EXISTS `statictis_login_yearday`;

CREATE ALGORITHM=UNDEFINED DEFINER=root@localhost SQL SECURITY DEFINER VIEW webadmin.statictis_login_yearday  AS  select count(webadmin.optlog.id) AS `count(id)` from webadmin.optlog where (((((((unix_timestamp(now()) DIV ((365 * 24) * 3600)) * 365) * 24) * 3600) - unix_timestamp(webadmin.optlog.regTime)) < ((365 * 24) * 3600)) and (webadmin.optlog.title = '登录')) ;

-- --------------------------------------------------------

--
-- 视图结构 statictis_read_monthday
--
DROP TABLE IF EXISTS `statictis_read_monthday`;

CREATE ALGORITHM=UNDEFINED DEFINER=root@localhost SQL SECURITY DEFINER VIEW webadmin.statictis_read_monthday  AS  select count(webadmin.optlog.id) AS `count(id)` from webadmin.optlog where (((((((unix_timestamp(now()) DIV ((30 * 24) * 3600)) * 30) * 24) * 3600) - unix_timestamp(webadmin.optlog.regTime)) < ((30 * 24) * 3600)) and (webadmin.optlog.title = '阅读')) ;

-- --------------------------------------------------------

--
-- 视图结构 statictis_read_oneday
--
DROP TABLE IF EXISTS `statictis_read_oneday`;

CREATE ALGORITHM=UNDEFINED DEFINER=root@localhost SQL SECURITY DEFINER VIEW webadmin.statictis_read_oneday  AS  select count(webadmin.optlog.id) AS `count(id)` from webadmin.optlog where ((((((unix_timestamp(now()) DIV (24 * 3600)) * 24) * 3600) - unix_timestamp(webadmin.optlog.regTime)) < (24 * 3600)) and (webadmin.optlog.title = '阅读')) ;

-- --------------------------------------------------------

--
-- 视图结构 statictis_read_sevenday
--
DROP TABLE IF EXISTS `statictis_read_sevenday`;

CREATE ALGORITHM=UNDEFINED DEFINER=root@localhost SQL SECURITY DEFINER VIEW webadmin.statictis_read_sevenday  AS  select count(webadmin.optlog.id) AS `count(id)` from webadmin.optlog where (((((((unix_timestamp(now()) DIV ((7 * 24) * 3600)) * 7) * 24) * 3600) - unix_timestamp(webadmin.optlog.regTime)) < ((7 * 24) * 3600)) and (webadmin.optlog.title = '阅读')) ;

-- --------------------------------------------------------

--
-- 视图结构 statictis_read_yearday
--
DROP TABLE IF EXISTS `statictis_read_yearday`;

CREATE ALGORITHM=UNDEFINED DEFINER=root@localhost SQL SECURITY DEFINER VIEW webadmin.statictis_read_yearday  AS  select count(webadmin.optlog.id) AS `count(id)` from webadmin.optlog where (((((((unix_timestamp(now()) DIV ((365 * 24) * 3600)) * 365) * 24) * 3600) - unix_timestamp(webadmin.optlog.regTime)) < ((365 * 24) * 3600)) and (webadmin.optlog.title = '阅读')) ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
