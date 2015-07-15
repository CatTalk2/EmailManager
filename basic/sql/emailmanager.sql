-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-07-15 15:56:35
-- 服务器版本： 5.6.17-log
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `emailmanager`
--

-- --------------------------------------------------------

--
-- 表的结构 `check`
--

CREATE TABLE IF NOT EXISTS `check` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `email_id` int(10) NOT NULL COMMENT '邮件ID',
  `user_id` int(30) NOT NULL COMMENT '处理人员ID',
  `check_user_id` int(10) NOT NULL COMMENT '审核人员ID',
  `check_status` int(10) NOT NULL DEFAULT '0' COMMENT '审核状态：默认为0：未审核 1：审核通过 2：审核未通过',
  `check_advise` text COLLATE utf8_bin COMMENT '审核意见',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `email`
--

CREATE TABLE IF NOT EXISTS `email` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `subject` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '邮件主题',
  `sender` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '邮件发送者',
  `receiver` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '邮件接收者',
  `text` longtext COLLATE utf8_bin,
  `label` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '邮件标签',
  `handle_status` int(20) NOT NULL DEFAULT '0' COMMENT '处理状态，默认为0：未分发 1：已分发 2：被退回',
  `check_status` int(20) NOT NULL DEFAULT '0' COMMENT '审核状态：0：不需要审核 1：需要审核',
  `sendtime` timestamp NOT NULL COMMENT '邮件发送时间',
  `attachment` varchar(1000) COLLATE utf8_bin DEFAULT NULL COMMENT '附件',
  `is_back` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=101 ;

-- --------------------------------------------------------

--
-- 表的结构 `email_user_rs`
--

CREATE TABLE IF NOT EXISTS `email_user_rs` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `permission` int(10) NOT NULL DEFAULT '1' COMMENT '阅读权限：默认为1：可以处理 0：只读',
  `user_id` int(10) NOT NULL COMMENT '发件用户ID',
  `dead_time` datetime(6) DEFAULT NULL COMMENT '紧急邮件截止时间',
  `handle_status` int(10) NOT NULL COMMENT '处理状态：0：未阅读 1：已读 2：已处理 3：已回复邮件',
  `check_status` int(10) DEFAULT NULL COMMENT '审核状态：0：不需要审核 1：未审核 2：审核中 3：已通过 4：未通过',
  `check_user_id` int(10) DEFAULT NULL COMMENT '审核人员ID',
  `email_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- 表的结构 `mailsetting`
--

CREATE TABLE IF NOT EXISTS `mailsetting` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `sendhost` varchar(20) NOT NULL DEFAULT 'smtp.126.com',
  `sendport` int(5) NOT NULL DEFAULT '25',
  `user` varchar(20) NOT NULL DEFAULT 'tclrg',
  `password` varchar(20) NOT NULL DEFAULT 'Luanruitest',
  `username` varchar(50) NOT NULL DEFAULT 'tclrg@126.com',
  `receivehost` varchar(20) NOT NULL DEFAULT 'imap.126.com',
  `receiveport` int(5) NOT NULL DEFAULT '993',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `send_email`
--

CREATE TABLE IF NOT EXISTS `send_email` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `subject` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `receiver` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sender` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'tclrg@126.com',
  `text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `send_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `attachment` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `user_id` int(20) NOT NULL COMMENT '用户ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `username` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '用户名',
  `password` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '000000' COMMENT '密码',
  `permission` int(10) NOT NULL DEFAULT '3' COMMENT '权限等级：0:高级管理员权限 1：分发人员权限 2：审核人员权限 3：普通处理人员权限 默认为3',
  `name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '姓名',
  `sex` varchar(10) COLLATE utf8_bin DEFAULT NULL COMMENT '性别',
  `age` int(10) DEFAULT NULL COMMENT '年龄',
  `pmail` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '个人邮箱地址',
  `phone` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT '电话/联系方式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `permission`, `name`, `sex`, `age`, `pmail`, `phone`) VALUES
(16, 'auditor', '000000', 2, '王经理', NULL, NULL, '', NULL),
(17, 'admin', 'admin', 0, '鹳狸猿', '1', 21, 'admin@osup.com', '13141459344'),
(19, 'dealer', '000000', 3, '小田', '1', 21, '131414159344@163.com', '13141459344'),
(20, 'distributer', '000000', 1, '大D', '男', 20, 'BigD@osup.com', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
