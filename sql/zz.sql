-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 05 月 11 日 16:20
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `zz`
--

-- --------------------------------------------------------

--
-- 表的结构 `ch_admin`
--

CREATE TABLE IF NOT EXISTS `ch_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(256) NOT NULL,
  `password_reset_token` varchar(256) DEFAULT NULL,
  `email` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `vip_level` int(11) NOT NULL,
  `email_validate_token` varchar(256) NOT NULL,
  `avatar` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ch_admin`
--

INSERT INTO `ch_admin` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `vip_level`, `email_validate_token`, `avatar`) VALUES
(1, 'admin', 'y7HD9lwK0-qnL0HiTYiniF2Ji6LYTqfy', '$2y$13$nz502PQ7RON38W8fj.GOoOwmI1Fuwr70p2X74vlP5ICpZ3fDW9ucu', NULL, 'admin@admin.com', 10, 1492530794, 1492530794, 0, '', ''),
(2, 'post', 'V0O07XPQmmac7vwjq-Cxi7b9zPdIfsB9', '$2y$13$9Y8lXQ90/c2m.K6cnKEL..VfWd3bgZ8Lzl4qUs5RrIVReJ.l2ZWzC', NULL, 'post@admin.com', 10, 1493825482, 1493825511, 0, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `ch_auth_assignment`
--

CREATE TABLE IF NOT EXISTS `ch_auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ch_auth_assignment`
--

INSERT INTO `ch_auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('网站编辑', '2', 1493825614),
('超级管理员', '1', 1493813505);

-- --------------------------------------------------------

--
-- 表的结构 `ch_auth_item`
--

CREATE TABLE IF NOT EXISTS `ch_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ch_auth_item`
--

INSERT INTO `ch_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('/*', 2, NULL, NULL, NULL, 1494144464, 1494144464),
('/admin/*', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/admin/assignment/*', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/assignment/assign', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/assignment/index', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/assignment/revoke', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/assignment/view', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/default/*', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/default/index', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/menu/*', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/menu/create', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/menu/delete', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/menu/index', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/menu/update', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/menu/view', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/permission/*', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/permission/assign', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/permission/create', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/permission/delete', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/permission/index', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/permission/remove', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/permission/update', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/permission/view', 2, NULL, NULL, NULL, 1492531109, 1492531109),
('/admin/role/*', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/role/assign', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/role/create', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/role/delete', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/role/index', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/role/remove', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/role/update', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/role/view', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/route/*', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/route/assign', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/route/create', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/route/index', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/route/refresh', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/route/remove', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/rule/*', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/rule/create', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/rule/delete', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/rule/index', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/rule/update', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/rule/view', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/user/*', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/admin/user/activate', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/admin/user/change-password', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/admin/user/delete', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/user/index', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/user/login', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/user/logout', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/user/request-password-reset', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/admin/user/reset-password', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/admin/user/signup', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/admin/user/view', 2, NULL, NULL, NULL, 1492531110, 1492531110),
('/adminuser/*', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/adminuser/create', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/adminuser/delete', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/adminuser/index', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/adminuser/resetpwd', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/adminuser/update', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/adminuser/view', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/base/base/*', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/config/*', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/config/create', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/config/delete', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/config/index', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/config/update', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/config/view', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/debug/*', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/debug/default/*', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/debug/default/db-explain', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/debug/default/download-mail', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/debug/default/index', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/debug/default/toolbar', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/debug/default/view', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/gii/*', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/gii/default/*', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/gii/default/action', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/gii/default/diff', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/gii/default/index', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/gii/default/preview', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/gii/default/view', 2, NULL, NULL, NULL, 1492531111, 1492531111),
('/site/*', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/site/error', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/site/index', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/site/login', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/site/logout', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/system/*', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/system/error', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/system/index', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/user/*', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/user/active', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/user/create', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/user/delete', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/user/index', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/user/update', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('/user/view', 2, NULL, NULL, NULL, 1492531112, 1492531112),
('网站编辑', 1, NULL, NULL, NULL, 1493825533, 1493825533),
('超级管理员', 1, NULL, NULL, NULL, 1492531255, 1493818636);

-- --------------------------------------------------------

--
-- 表的结构 `ch_auth_item_child`
--

CREATE TABLE IF NOT EXISTS `ch_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ch_auth_item_child`
--

INSERT INTO `ch_auth_item_child` (`parent`, `child`) VALUES
('超级管理员', '/admin/*'),
('超级管理员', '/admin/assignment/*'),
('超级管理员', '/admin/assignment/assign'),
('超级管理员', '/admin/assignment/index'),
('超级管理员', '/admin/assignment/revoke'),
('超级管理员', '/admin/assignment/view'),
('超级管理员', '/admin/default/*'),
('超级管理员', '/admin/default/index'),
('超级管理员', '/admin/menu/*'),
('超级管理员', '/admin/menu/create'),
('超级管理员', '/admin/menu/delete'),
('超级管理员', '/admin/menu/index'),
('超级管理员', '/admin/menu/update'),
('超级管理员', '/admin/menu/view'),
('超级管理员', '/admin/permission/*'),
('超级管理员', '/admin/permission/assign'),
('超级管理员', '/admin/permission/create'),
('超级管理员', '/admin/permission/delete'),
('超级管理员', '/admin/permission/index'),
('超级管理员', '/admin/permission/remove'),
('超级管理员', '/admin/permission/update'),
('超级管理员', '/admin/permission/view'),
('超级管理员', '/admin/role/*'),
('超级管理员', '/admin/role/assign'),
('超级管理员', '/admin/role/create'),
('超级管理员', '/admin/role/delete'),
('超级管理员', '/admin/role/index'),
('超级管理员', '/admin/role/remove'),
('超级管理员', '/admin/role/update'),
('超级管理员', '/admin/role/view'),
('超级管理员', '/admin/route/*'),
('超级管理员', '/admin/route/assign'),
('超级管理员', '/admin/route/create'),
('超级管理员', '/admin/route/index'),
('超级管理员', '/admin/route/refresh'),
('超级管理员', '/admin/route/remove'),
('超级管理员', '/admin/rule/*'),
('超级管理员', '/admin/rule/create'),
('超级管理员', '/admin/rule/delete'),
('超级管理员', '/admin/rule/index'),
('超级管理员', '/admin/rule/update'),
('超级管理员', '/admin/rule/view'),
('超级管理员', '/admin/user/*'),
('超级管理员', '/admin/user/activate'),
('超级管理员', '/admin/user/change-password'),
('超级管理员', '/admin/user/delete'),
('超级管理员', '/admin/user/index'),
('超级管理员', '/admin/user/login'),
('超级管理员', '/admin/user/logout'),
('超级管理员', '/admin/user/request-password-reset'),
('超级管理员', '/admin/user/reset-password'),
('超级管理员', '/admin/user/signup'),
('超级管理员', '/admin/user/view'),
('超级管理员', '/adminuser/*'),
('超级管理员', '/adminuser/create'),
('超级管理员', '/adminuser/delete'),
('超级管理员', '/adminuser/index'),
('超级管理员', '/adminuser/resetpwd'),
('超级管理员', '/adminuser/update'),
('超级管理员', '/adminuser/view'),
('超级管理员', '/base/base/*'),
('超级管理员', '/config/*'),
('超级管理员', '/config/create'),
('超级管理员', '/config/delete'),
('超级管理员', '/config/index'),
('超级管理员', '/config/update'),
('超级管理员', '/config/view'),
('超级管理员', '/debug/*'),
('超级管理员', '/debug/default/*'),
('超级管理员', '/debug/default/db-explain'),
('超级管理员', '/debug/default/download-mail'),
('超级管理员', '/debug/default/index'),
('超级管理员', '/debug/default/toolbar'),
('超级管理员', '/debug/default/view'),
('超级管理员', '/gii/*'),
('超级管理员', '/gii/default/*'),
('超级管理员', '/gii/default/action'),
('超级管理员', '/gii/default/diff'),
('超级管理员', '/gii/default/index'),
('超级管理员', '/gii/default/preview'),
('超级管理员', '/gii/default/view'),
('网站编辑', '/site/*'),
('超级管理员', '/site/*'),
('网站编辑', '/site/error'),
('超级管理员', '/site/error'),
('网站编辑', '/site/index'),
('超级管理员', '/site/index'),
('网站编辑', '/site/login'),
('超级管理员', '/site/login'),
('网站编辑', '/site/logout'),
('超级管理员', '/site/logout'),
('超级管理员', '/system/*'),
('超级管理员', '/system/error'),
('超级管理员', '/system/index'),
('超级管理员', '/user/*'),
('超级管理员', '/user/active'),
('超级管理员', '/user/create'),
('超级管理员', '/user/delete'),
('超级管理员', '/user/index'),
('超级管理员', '/user/update'),
('超级管理员', '/user/view');

-- --------------------------------------------------------

--
-- 表的结构 `ch_auth_rule`
--

CREATE TABLE IF NOT EXISTS `ch_auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ch_config`
--

CREATE TABLE IF NOT EXISTS `ch_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  `value` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ch_config`
--

INSERT INTO `ch_config` (`id`, `name`, `value`) VALUES
(1, 'site_info', '{"site_url":"213","site_record":"","site_name":"","site_logo":"2e727dd6e296326a7ea4b67aed54c1ad.jpeg","site_title":"","site_desc":"","site_keyword":"","site_contact":"","site_phone":"","site_address":"","site_qq_1":"","site_qq_2":"","site_qq_3":""}'),
(2, 'smtp_info', '{"smtp_server":"smtp.163.com","smtp_port":"25","smtp_user":"13437202913@163.com","smtp_pass":"1393960037@qq.com"}');

-- --------------------------------------------------------

--
-- 表的结构 `ch_menu`
--

CREATE TABLE IF NOT EXISTS `ch_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `ch_menu`
--

INSERT INTO `ch_menu` (`id`, `name`, `parent`, `route`, `order`, `data`) VALUES
(1, '权限管理', NULL, NULL, 2, 0x7b2269636f6e223a22636f6773227d),
(2, '菜单管理', 1, '/admin/menu/index', NULL, NULL),
(3, '角色管理', 1, '/admin/role/index', NULL, NULL),
(4, '管理员', 1, '/adminuser/index', NULL, NULL),
(5, '路由管理', 1, '/admin/route/index', NULL, NULL),
(6, '会员管理', NULL, NULL, 3, 0x7b2269636f6e223a22757365722d6f227d),
(7, '会员列表', 6, '/user/index', NULL, NULL),
(8, '网站设置', 9, '/config/index', NULL, NULL),
(9, '系统设置', NULL, NULL, 1, 0x7b2269636f6e223a22636f67227d);

-- --------------------------------------------------------

--
-- 表的结构 `ch_user`
--

CREATE TABLE IF NOT EXISTS `ch_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(256) NOT NULL,
  `password_reset_token` varchar(256) DEFAULT NULL,
  `email` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `vip_level` int(11) NOT NULL,
  `email_validate_token` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ch_user`
--

INSERT INTO `ch_user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `vip_level`, `email_validate_token`, `avatar`) VALUES
(1, 'user', 'y7HD9lwK0-qnL0HiTYiniF2Ji6LYTqfy', '$2y$13$nz502PQ7RON38W8fj.GOoOwmI1Fuwr70p2X74vlP5ICpZ3fDW9ucu', NULL, 'user@user.com', 0, 1492530794, 1493825809, 0, '', '');

--
-- 限制导出的表
--

--
-- 限制表 `ch_auth_assignment`
--
ALTER TABLE `ch_auth_assignment`
  ADD CONSTRAINT `ch_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `ch_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `ch_auth_item`
--
ALTER TABLE `ch_auth_item`
  ADD CONSTRAINT `ch_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `ch_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `ch_auth_item_child`
--
ALTER TABLE `ch_auth_item_child`
  ADD CONSTRAINT `ch_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ch_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ch_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `ch_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `ch_menu`
--
ALTER TABLE `ch_menu`
  ADD CONSTRAINT `ch_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ch_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
