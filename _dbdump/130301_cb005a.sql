-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Hoszt: localhost
-- Létrehozás ideje: 2013. márc. 01. 12:36
-- Szerver verzió: 5.5.8-log
-- PHP verzió: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Adatbázis: `cb005a`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet: `cb_file`
--

CREATE TABLE IF NOT EXISTS `cb_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_size` int(11) NOT NULL,
  `file_type` varchar(20) NOT NULL,
  `date` int(11) NOT NULL,
  `comment` text NOT NULL,
  `file_ext` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tábla szerkezet: `cb_menu`
--

CREATE TABLE IF NOT EXISTS `cb_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(2) NOT NULL,
  `group` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `seo_name` varchar(63) NOT NULL,
  `type` enum('CAT','PAGE','POST','HTML','MODULE') NOT NULL,
  `value` varchar(255) NOT NULL,
  `html_blank` int(1) NOT NULL DEFAULT '0',
  `image` varchar(63) NOT NULL,
  `order` int(11) NOT NULL,
  `state` int(2) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menu_id` (`id`,`lang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- A tábla adatainak kiíratása `cb_menu`
--

INSERT INTO `cb_menu` (`id`, `lang`, `group`, `parent`, `name`, `seo_name`, `type`, `value`, `html_blank`, `image`, `order`, `state`, `text`) VALUES
(1, 'hu', 1, 0, 'Főoldal', 'fooldal', 'CAT', '1', 0, '', 1, 1, ''),
(2, 'hu', 1, 0, 'Órarend', 'orarend', 'PAGE', '12', 0, '', 3, 1, ''),
(3, 'hu', 1, 0, 'Rólunk', 'rolunk', 'PAGE', '3', 0, '', 2, 1, ''),
(4, 'hu', 1, 0, 'Kapcsolat', 'kapcsolat', 'PAGE', '14', 0, '', 5, 1, ''),
(6, 'hu', 1, 1, 'Biztosítás', 'biztositas', 'PAGE', '6', 0, '', 1, -1, ''),
(7, 'hu', 1, 1, 'Hitel', 'hitel', 'PAGE', '7', 0, '', 2, -1, ''),
(8, 'hu', 1, 1, 'Befektetés', 'befektetes', 'PAGE', '8', 0, '', 3, -1, ''),
(11, 'hu', 1, 1, 'Új menüpont', 'menü_ékezetes', 'PAGE', '9', 0, '', 0, -1, ''),
(12, 'hu', 1, 0, 'Fórum', 'forum', 'PAGE', '11', 0, '', 8, 1, ''),
(13, 'hu', 1, 0, 'Árlista', 'arlista', 'PAGE', '13', 0, '', 4, 1, ''),
(14, 'hu', 1, 0, 'Partnereink', 'partnereink', 'PAGE', '15', 0, '', 6, 1, ''),
(15, 'hu', 1, 0, 'Galéria', 'galeria', 'PAGE', '16', 0, '', 7, 1, ''),
(16, 'hu', 2, 0, 'Terembérlés', 'teremberles', 'PAGE', '18', 0, '', 1, 1, ''),
(23, 'hu', 2, 0, 'Latin tánc oktatás', 'latin_tanc_oktatas', 'PAGE', '19', 0, '', 0, 1, ''),
(24, 'hu', 2, 0, 'Standard tánc oktatás', 'standard_tanc_oktatas', 'PAGE', '20', 0, '', 3, 1, ''),
(26, 'hu', 2, 0, 'Zumba fitness', 'zumba_fitness', 'PAGE', '21', 0, '', 4, 1, ''),
(30, 'hu', 2, 0, 'Doll Star Rockets Dance Academy', 'doll_star_rockets_dance_academy', 'PAGE', '22', 0, '', 6, 1, ''),
(34, 'hu', 2, 0, 'Hastánc', 'hastanc', 'PAGE', '24', 0, '', 7, 1, ''),
(35, 'hu', 2, 0, 'West coast swing', 'west_coast_swing', 'PAGE', '25', 0, '', 8, 1, ''),
(36, 'hu', 2, 0, 'Magánórák ', 'maganorak_', 'PAGE', '', 0, '', 9, 1, ''),
(37, 'hu', 2, 0, 'Alakformálás', 'alakformalas', 'PAGE', '27', 0, '', 10, 1, ''),
(38, 'hu', 2, 0, 'Esküvői tánc oktatás', 'eskuvoi_tanc_oktatas', 'PAGE', '28', 0, '', 11, 1, ''),
(39, 'hu', 2, 0, 'Szalag Avató', 'szalag_avato', 'PAGE', '29', 0, '', 12, 1, ''),
(40, 'hu', 2, 0, 'Fellépések', 'fellepesek', 'PAGE', '30', 0, '', 13, 1, ''),
(41, 'hu', 2, 0, 'Csapatépítés', 'csapatepites', 'PAGE', '32', 0, '', 14, 1, ''),
(42, 'hu', 2, 0, 'Táncruha', 'tancruha', 'PAGE', '33', 0, '', 15, 1, '');

-- --------------------------------------------------------

--
-- Tábla szerkezet: `cb_module`
--

CREATE TABLE IF NOT EXISTS `cb_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `active` int(1) NOT NULL,
  `priority` int(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- A tábla adatainak kiíratása `cb_module`
--

INSERT INTO `cb_module` (`id`, `name`, `active`, `priority`) VALUES
(1, 'admin', 1, -1),
(2, 'account', 1, 0),
(3, 'page', 1, 10),
(4, 'post', 1, 10),
(5, 'menu', 1, 5),
(6, 'statistic', 1, 6),
(7, 'form', 1, 5),
(8, 'filemanager', 1, 20);

-- --------------------------------------------------------

--
-- Tábla szerkezet: `cb_module_details`
--

CREATE TABLE IF NOT EXISTS `cb_module_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `type` enum('USER','ADMIN') NOT NULL,
  `function` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `module_id` (`module_id`,`type`,`function`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- A tábla adatainak kiíratása `cb_module_details`
--

INSERT INTO `cb_module_details` (`id`, `module_id`, `type`, `function`) VALUES
(1, 1, 'ADMIN', 'main'),
(47, 2, 'USER', 'account_box'),
(50, 2, 'USER', 'password_change'),
(49, 2, 'USER', 'registration'),
(48, 2, 'USER', 'settings'),
(3, 2, 'ADMIN', 'create'),
(6, 2, 'ADMIN', 'delete'),
(7, 2, 'ADMIN', 'details'),
(5, 2, 'ADMIN', 'edit'),
(4, 2, 'ADMIN', 'invite'),
(2, 2, 'ADMIN', 'main'),
(9, 3, 'ADMIN', 'create'),
(13, 3, 'ADMIN', 'delete'),
(10, 3, 'ADMIN', 'edit'),
(8, 3, 'ADMIN', 'main'),
(11, 3, 'ADMIN', 'trash'),
(12, 3, 'ADMIN', 'trash_main'),
(15, 4, 'ADMIN', 'create'),
(19, 4, 'ADMIN', 'delete'),
(16, 4, 'ADMIN', 'edit'),
(21, 4, 'ADMIN', 'group_create'),
(25, 4, 'ADMIN', 'group_delete'),
(22, 4, 'ADMIN', 'group_edit'),
(20, 4, 'ADMIN', 'group_main'),
(23, 4, 'ADMIN', 'group_trash'),
(24, 4, 'ADMIN', 'group_trash_main'),
(14, 4, 'ADMIN', 'main'),
(17, 4, 'ADMIN', 'trash'),
(18, 4, 'ADMIN', 'trash_main'),
(27, 5, 'ADMIN', 'create'),
(31, 5, 'ADMIN', 'delete'),
(28, 5, 'ADMIN', 'edit'),
(33, 5, 'ADMIN', 'group_create'),
(37, 5, 'ADMIN', 'group_delete'),
(34, 5, 'ADMIN', 'group_edit'),
(32, 5, 'ADMIN', 'group_main'),
(35, 5, 'ADMIN', 'group_trash'),
(36, 5, 'ADMIN', 'group_trash_main'),
(26, 5, 'ADMIN', 'main'),
(29, 5, 'ADMIN', 'trash'),
(30, 5, 'ADMIN', 'trash_main'),
(38, 6, 'ADMIN', 'main'),
(39, 6, 'ADMIN', 'resett'),
(46, 7, 'ADMIN', 'archive'),
(41, 7, 'ADMIN', 'create'),
(45, 7, 'ADMIN', 'delete'),
(42, 7, 'ADMIN', 'edit'),
(40, 7, 'ADMIN', 'main'),
(43, 7, 'ADMIN', 'trash'),
(44, 7, 'ADMIN', 'trash_list');

-- --------------------------------------------------------

--
-- Tábla szerkezet: `cb_page`
--

CREATE TABLE IF NOT EXISTS `cb_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('PAGE','POST') NOT NULL,
  `page_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'hu',
  `state` int(2) NOT NULL DEFAULT '1',
  `version` int(11) NOT NULL,
  `cdate` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `mdate` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `meta_author` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- A tábla adatainak kiíratása `cb_page`
--

INSERT INTO `cb_page` (`id`, `type`, `page_id`, `name`, `text`, `lang`, `state`, `version`, `cdate`, `cid`, `mdate`, `mid`, `meta_author`, `meta_keywords`, `meta_description`) VALUES
(3, 'PAGE', 3, 'Rólunk', '<p>asr35</p>', 'hu', 1, 1, 1349453579, 1, 1350597671, 1, '', '', ''),
(4, 'PAGE', 4, 'Táncosok Klubja', '<div class="lc">\r\n<p>&Iacute;me az el&eacute;rhetős&eacute;geink, vagy k&uuml;ldj nek&uuml;nk e-mailt:<br /><br />{#FORM}</p>\r\n</div>', 'hu', -1, 1, 1349453579, 1, 1350658348, 1, '', '', ''),
(6, 'PAGE', 6, 'Biztosítás', 'Magán személyek: \r\n- Lakás\r\n- Casco\r\n- Kötelező felelősség biztosítás\r\n- Utas\r\n- Munkavállalói felelősség biztosítás\r\n- Élet \r\n- Egészségbiztosítás\r\n- Pénztárak\r\n\r\nCégek, szervezetek: \r\n- Vállalkozói vagyon biztosítás\r\n- Élet\r\n- Baleset\r\n- Betegség\r\n- Szolgáltatói Felelősség\r\n- Kulcsember ', 'hu', -1, 1, 1349453579, 1, 0, 0, '', '', ''),
(7, 'PAGE', 7, 'Hitel', '', 'hu', -1, 1, 1349453579, 1, 0, 0, '', '', ''),
(8, 'PAGE', 8, 'Befektetés', '<p>Befektet&eacute;si tan&aacute;csad&aacute;s :)</p>\r\n<p>&nbsp;</p>\r\n<h1><strong>NAGY BETŰŰŰŰ</strong></h1>', 'hu', -1, 1, 1349453579, 1, 1350480476, 1, '', '', ''),
(11, 'POST', 1, 'teszt hír', '<p>egyedem begyedem</p>', 'hu', 1, 0, 1350322088, 1, 1350540527, 1, '', '', ''),
(12, 'POST', 2, '2. teszt hír', '<p>a m&aacute;sodik =)</p>', 'hu', 1, 0, 1350328535, 1, 1350332611, 1, '', '', ''),
(13, 'POST', 3, 'Rólunk', '<p>asr35</p>', 'hu', 1, 0, 1350328917, 1, 1350597671, 1, '', '', ''),
(14, 'POST', 4, 'Táncosok Klubja', '<div class="lc">\r\n<p>&Iacute;me az el&eacute;rhetős&eacute;geink, vagy k&uuml;ldj nek&uuml;nk e-mailt:<br /><br />{#FORM}</p>\r\n</div>', 'hu', 1, 0, 1350335851, 1, 1350658348, 1, '', '', ''),
(15, 'PAGE', 9, 'TRY', '<p>try</p>', 'hu', -1, 0, 1350478396, 1, 1350540451, 1, '', '', ''),
(16, 'PAGE', 10, 'Elérhetőség', '<p>Ide j&ouml;n minden ami az el&eacute;rhetős&eacute;ggel kapcsolatos</p>', 'hu', -1, 0, 1350597694, 1, 1350660027, 1, '', '', ''),
(17, 'PAGE', 11, 'Fórum', '<p>a f&oacute;rum helye ..</p>', 'hu', 1, 0, 1350597904, 1, 0, 0, '', '', ''),
(18, 'PAGE', 12, 'Órarend', '<p>Term&eacute;szetesen kell majd a &nbsp;be&aacute;gyaz&aacute;s k&oacute;d ide!</p>', 'hu', 1, 0, 1350657810, 1, 1350659934, 1, '', '', ''),
(19, 'PAGE', 13, 'Árlista', '<p>&Aacute;raitok helye</p>\r\n<ul>\r\n<li>kezeli a lista elemeket<br />minden tekintetben</li>\r\n<li>Megfelelő b&aacute;rkinek</li>\r\n<li>Olcs&oacute;</li>\r\n</ul>\r\n<ol>\r\n<li>mert meg&eacute;ri</li>\r\n<li>mert m&eacute;rt ne</li>\r\n<li>mert az&eacute;rt mert :D</li>\r\n</ol>\r\n<p style="padding-left: 30px;">Beh&uacute;zni a nekezd&eacute;st eleg&aacute;ns dolog, sokan szeretik. Mostm&aacute;r erre is lesz lehetős&eacute;g.</p>\r\n<p style="padding-left: 90px;">S m&eacute;g a m&eacute;rt&eacute;ke is megszabhat&oacute;<br />Pr&oacute;b&aacute;ld majd ki!</p>', 'hu', 1, 0, 1350660279, 1, 0, 0, '', '', ''),
(20, 'PAGE', 14, 'Kapcsolat', '<p>Ide j&ouml;nnek a kapcsolati dolgok, meg esetleg az</p>\r\n<p>email k&uuml;ldő</p>\r\n<p>{#FORM}</p>', 'hu', 1, 0, 1350660326, 1, 0, 0, '', '', ''),
(21, 'PAGE', 15, 'Partnereink és Referenciáink', '<p>&Eacute;rtelem szerűen</p>', 'hu', 1, 0, 1350660380, 1, 0, 0, '', '', ''),
(22, 'PAGE', 16, 'Galéria', '<p>A t&iacute;pus&aacute;t nem besz&eacute;lt&uuml;k meg.<br /><br />Sok lehetős&eacute;g &aacute;ll rendelkez&eacute;sre.<br /><br /><br /></p>', 'hu', 1, 0, 1350660416, 1, 0, 0, '', '', ''),
(23, 'PAGE', 17, 'Kukkants be hozzánk!', '<p>M&aacute;rha ez men&uuml;pont akarna lenni... asszem az</p>', 'hu', 1, 0, 1350660466, 1, 0, 0, '', '', ''),
(24, 'PAGE', 18, 'Terembérlés', '<p>Teremb&eacute;rl&eacute;si lehetős&eacute;g</p>', 'hu', 1, 0, 1350660714, 1, 0, 0, '', '', ''),
(25, 'PAGE', 19, 'Latin tánc oktatás', '<p>Latin t&aacute;nc</p>', 'hu', 1, 0, 1350660732, 1, 0, 0, '', '', ''),
(26, 'PAGE', 20, 'Standard tánc oktatás', '<p>Gondolom, a j&oacute; &ouml;reg dolgok</p>', 'hu', 1, 0, 1350660762, 1, 0, 0, '', '', ''),
(27, 'PAGE', 21, 'Zumba fitness', '<p>Zumba fitness</p>', 'hu', 1, 0, 1350660795, 1, 0, 0, '', '', ''),
(28, 'PAGE', 22, 'Doll Star Rockets Dance Academy', '<p>Doll Star Rockets Dance Academy</p>', 'hu', 1, 0, 1350660840, 1, 0, 0, '', '', ''),
(29, 'PAGE', 23, 'Salsa', '<p>Salsa</p>', 'hu', 1, 0, 1350660860, 1, 0, 0, '', '', ''),
(30, 'PAGE', 24, 'Hastánc', '<p>Hast&aacute;nc</p>', 'hu', 1, 0, 1350660872, 1, 0, 0, '', '', ''),
(31, 'PAGE', 25, 'West coast swing', '<p><span style="color: #222222; font-family: arial, sans-serif; font-size: 13px;">West coast swing</span></p>', 'hu', 1, 0, 1350660899, 1, 0, 0, '', '', ''),
(32, 'PAGE', 26, 'Magánórák ', '<p>H&aacute;t na, ez egy &eacute;let munk&aacute;ja</p>', 'hu', 1, 0, 1350660998, 1, 0, 0, '', '', ''),
(33, 'PAGE', 27, 'Alakformálás', '<p>1 2 3 1234 :D</p>', 'hu', 1, 0, 1350661064, 1, 0, 0, '', '', ''),
(34, 'PAGE', 28, 'Esküvői tánc oktatás', '<p>DOOO IT</p>', 'hu', 1, 0, 1350661080, 1, 0, 0, '', '', ''),
(35, 'PAGE', 29, 'Szalag Avató', '<p>Szalag avat&oacute;</p>', 'hu', 1, 0, 1350661098, 1, 0, 0, '', '', ''),
(36, 'PAGE', 30, 'Fellépések', '<p>Fell&eacute;p&eacute;sek</p>', 'hu', 1, 0, 1350661142, 1, 0, 0, '', '', ''),
(37, 'PAGE', 31, 'Koreografálás', '<p>Koreograf&aacute;l&aacute;s</p>', 'hu', 1, 0, 1350661165, 1, 0, 0, '', '', ''),
(38, 'PAGE', 32, 'Csapatépítés', '<p>Csapat&eacute;p&iacute;t&eacute;s</p>', 'hu', 1, 0, 1350661182, 1, 0, 0, '', '', ''),
(39, 'PAGE', 33, 'Táncruha', '<p>Varrni varrni varrni</p>', 'hu', 1, 0, 1350661235, 1, 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- Tábla szerkezet: `cb_post_category`
--

CREATE TABLE IF NOT EXISTS `cb_post_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(63) NOT NULL,
  `text` text NOT NULL,
  `state` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- A tábla adatainak kiíratása `cb_post_category`
--

INSERT INTO `cb_post_category` (`id`, `name`, `text`, `state`) VALUES
(1, 'Hírek', '', 1),
(2, 'legend', '', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet: `cb_post_category_xref`
--

CREATE TABLE IF NOT EXISTS `cb_post_category_xref` (
  `id` int(11) NOT NULL,
  `post` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`,`post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_post_category_xref`
--

INSERT INTO `cb_post_category_xref` (`id`, `post`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 3);

-- --------------------------------------------------------

--
-- Tábla szerkezet: `cb_session`
--

CREATE TABLE IF NOT EXISTS `cb_session` (
  `session` varchar(30) NOT NULL,
  `uid` int(11) NOT NULL,
  `grouplevel` int(3) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `ip` varchar(23) NOT NULL,
  `exit` int(11) NOT NULL,
  PRIMARY KEY (`session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_session`
--

INSERT INTO `cb_session` (`session`, `uid`, `grouplevel`, `lang`, `ip`, `exit`) VALUES
('eatthu5cunqdr4k446d88b62yij6na', 0, 0, 'hu', '192.168.1.106', 1360678345),
('hszcie42ip2w62d2r7yzvmdwv3hdew', 0, 0, 'hu', '192.168.1.106', 1360150589);

-- --------------------------------------------------------

--
-- Tábla szerkezet: `cb_settings`
--

CREATE TABLE IF NOT EXISTS `cb_settings` (
  `key` varchar(32) NOT NULL,
  `value` varchar(128) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_settings`
--

INSERT INTO `cb_settings` (`key`, `value`) VALUES
('admin_themeset', 'susi'),
('def_page', '1'),
('is_seo', '1'),
('langtype', 'hu'),
('mail_charset', 'utf-8'),
('mail_from', 'gabu@aninet.eu'),
('mail_from_name', 'Core Beat test e-mail'),
('mail_sendmail_root', '/usr/bin/sendmail'),
('mail_smtp_auth', 'true'),
('mail_smtp_password', 'alriruhbbpdskxop'),
('mail_smtp_port', '465'),
('mail_smtp_secure', 'ssl'),
('mail_smtp_server', 'smtp.gmail.com'),
('mail_smtp_username', 'gabu@aninet.eu'),
('mail_type', 'smtp'),
('meta_def_auth', ''),
('meta_def_desc', ''),
('meta_def_key', ''),
('pagetitle', 'Tesztoldal'),
('regmode', 'normal'),
('sessionvalue', '600000'),
('themeset', 'core004');

-- --------------------------------------------------------

--
-- Tábla szerkezet: `cb_user`
--

CREATE TABLE IF NOT EXISTS `cb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(100) NOT NULL,
  `level` int(11) NOT NULL,
  `state` int(1) NOT NULL,
  `reg_date` int(11) NOT NULL,
  `reg_code` varchar(50) NOT NULL,
  `pass_reset_date` int(11) NOT NULL,
  `pass_reset_full_code` varchar(50) NOT NULL,
  `pass_reset_short_code` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- A tábla adatainak kiíratása `cb_user`
--

INSERT INTO `cb_user` (`id`, `username`, `password`, `email`, `level`, `state`, `reg_date`, `reg_code`, `pass_reset_date`, `pass_reset_full_code`, `pass_reset_short_code`) VALUES
(1, 'gabu', '36622ca176a6d999d3c2b41d3e002a05b4342c8902dcd98145372c2f0a0b9a0031dc1424ffe825f975a6e390887354e903c460e3e374d95a36cca2c058b96d7a', 'gabu@aninet.eu', 255, 1, 1349454217, '', 0, '', ''),
(3, 'admin', '36622ca176a6d999d3c2b41d3e002a05b4342c8902dcd98145372c2f0a0b9a0031dc1424ffe825f975a6e390887354e903c460e3e374d95a36cca2c058b96d7a', 'admin@szabadweb.hu', 255, 1, 0, '', 0, '', '');

-- --------------------------------------------------------

--
-- Tábla szerkezet: `cb_user_data`
--

CREATE TABLE IF NOT EXISTS `cb_user_data` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `telephone` varchar(24) NOT NULL,
  `address` text NOT NULL,
  `disturb` text NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_user_data`
--

INSERT INTO `cb_user_data` (`id`, `name`, `telephone`, `address`, `disturb`, `comment`) VALUES
(1, 'Érdi Gábor', '+36302779001', 'asd\r\n\r\n\r\nfaer', 'soha!', ''),
(3, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Tábla szerkezet: `cb_user_level`
--

CREATE TABLE IF NOT EXISTS `cb_user_level` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `setup` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_user_level`
--

INSERT INTO `cb_user_level` (`id`, `name`, `setup`) VALUES
(0, 'GUEST', '7fffffffffffffffffffffffffffffffffffffffffffffffff'),
(1, 'USER', 'ffffffffffffffffffffffffffffffffffffffffffffffffff'),
(200, 'ADMIN', 'ffffffffffffffffffffffffffffffffffffffffffffffffff'),
(255, 'SUPERADMIN', 'ffffffffffffffffffffffffffffffffffffffffffffffffff');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
