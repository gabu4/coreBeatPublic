-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2020. Jan 06. 12:19
-- Kiszolgáló verziója: 5.7.28-0ubuntu0.18.04.4
-- PHP verzió: 7.3.11-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Adatbázis: `develop_corebeat-20b`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_api_connections`
--

CREATE TABLE `cb_api_connections` (
  `id` int(11) NOT NULL,
  `api_key` varchar(64) NOT NULL DEFAULT '',
  `api_secret` varchar(256) NOT NULL DEFAULT '',
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `device` varchar(20) NOT NULL,
  `info` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_article`
--

CREATE TABLE `cb_article` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'hu',
  `state` int(2) NOT NULL DEFAULT '0',
  `version` int(11) NOT NULL DEFAULT '1',
  `date_create` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_mod` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `meta_author` text,
  `meta_keywords` text,
  `meta_description` text,
  `media` text,
  `template` varchar(50) DEFAULT '',
  `theme` varchar(50) DEFAULT '',
  `class` varchar(255) DEFAULT '',
  `css` varchar(255) NOT NULL DEFAULT '',
  `js` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_article`
--

INSERT INTO `cb_article` (`id`, `article_id`, `name`, `text`, `lang`, `state`, `version`, `date_create`, `date_mod`, `meta_author`, `meta_keywords`, `meta_description`, `media`, `template`, `theme`, `class`, `css`, `js`) VALUES
(1, 1, 'Főoldal', '&lt;div id=&quot;lipsum&quot;&gt;\r\n&lt;p&gt;Lorem 2 ipsum dolor sit amet, consectetur adipiscing elit. Duis maximus lacinia bibendum. Pellentesque euismod, quam ut efficitur iaculis, ex lorem aliquam enim, at tristique lectus eros id arcu. Quisque cursus sodales ligula quis eleifend. Cras et posuere dolor. Donec rutrum lacinia tempus. Donec sodales velit turpis, at pretium odio dapibus a. Mauris vitae tu&lt;img style=&quot;float: right;&quot; src=&quot;/cb-file/_magata_shiki_subete_ga_f_ni_na.jpg&quot; alt=&quot;&quot; /&gt;rpis in mi finibus congue. Morbi tempor augue et orci sagittis porttitor. Vestibulum non urna nec augue posuere commodo id vel est. Aenean turpis metus, scelerisque nec elit pretium, suscipit tempus enim. Donec dolor lectus, eleifend sit amet interdum quis, porta eget purus. Nulla ut lectus nibh. Proin mattis sem odio, in scelerisque metus tempus et. Nulla quis arcu congue ex sodales molestie.&lt;/p&gt;\r\n&lt;p&gt;Donec vitae turpis molestie, gravida turpis ut, mollis massa. Mauris ut metus eros. Ut vitae nisl erat. Suspendisse vel mattis leo, scelerisque aliquam elit. Quisque velit turpis, iaculis ac tincidunt et, rutrum a turpis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse ultrices neque enim, sit amet ultricies felis feugiat non. Aliquam malesuada, tellus tempor feugiat cursus, enim orci dapibus est, eget porta dolor augue id ligula. Sed convallis volutpat lorem, in aliquet lorem.&lt;/p&gt;\r\n&lt;p&gt;Aenean euismod bibendum condimentum. Fusce est sem, vehicula vitae ligula sed, ornare convallis diam. Ut tincidunt, erat feugiat tristique convallis, velit libero bibendum velit, eu volutpat ligula dui ac lectus. Sed egestas massa ut nunc rutrum varius. Vivamus venenatis ex nec justo hendrerit convallis. Mauris maximus nulla tristique, sollicitudin odio sed, elementum urna. Cras a neque convallis, suscipit diam in, consequat tellus.&lt;/p&gt;\r\n&lt;p&gt;Aliquam eget imperdiet dui. Ut sodales tempus justo, hendrerit elementum lorem mollis at. Aliquam dignissim non neque et interdum. Nunc feugiat fringilla magna at euismod. Quisque sit amet lorem orci. Etiam sodales hendrerit ligula at porta. Donec bibendum metus id leo maximus, nec faucibus magna ullamcorper. Nunc faucibus leo nec porttitor eleifend. Nulla in congue elit. Vestibulum nec massa augue. Maecenas ipsum tellus, tristique sit amet dapibus nec, pretium quis urna. Morbi consectetur libero eget efficitur venenatis.&lt;/p&gt;\r\n&lt;p&gt;Duis dictum ut nibh viverra convallis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque bibendum elementum sem, in porta ante pulvinar in. Nulla pulvinar, elit egestas porta cursus, quam ante varius lacus, non elementum sapien nulla a tellus. Vivamus et imperdiet turpis. In et faucibus lacus. Etiam quis blandit augue. Ut sed faucibus arcu, a malesuada turpis. Phasellus in arcu purus. Etiam commodo mi vel mi semper faucibus. Morbi blandit velit vitae dui vulputate, vel viverra nisi efficitur. Aliquam lobortis congue dapibus. Suspendisse vitae placerat dui. Vestibulum at sagittis ex. Sed nec finibus sapien, id dictum enim. Maecenas massa risus, cursus et diam quis, malesuada ullamcorper tortor.&lt;/p&gt;\r\n&lt;/div&gt;', 'hu', 1, 11, '2019-02-21 00:00:00', '2019-08-13 10:38:47', '', '', '', '{\"thumbnail\": \"\", \"headerimage\": \"\", \"youtubevideo\": \"\"}', '', NULL, '', '', ''),
(2, 2, '', '', 'hu', -1, 0, '2019-02-21 00:00:00', '2019-02-21 20:04:46', '', '', '', '{\"thumbnail\": \"\", \"headerimage\": \"\"}', '', NULL, '', '', ''),
(161, 3, '', '', 'hu', -1, 0, NULL, '2019-02-21 20:02:27', '', '', '', '{\"thumbnail\": \"\", \"headerimage\": \"\"}', '', NULL, '', '', ''),
(181, 4, 'teszt2', '', 'hu', 1, 1, '2019-02-21 20:05:12', NULL, NULL, '', '', '{\"thumbnail\": \"\", \"headerimage\": \"\", \"youtubevideo\": \"\"}', '', '', '', '', ''),
(182, 5, '', '', 'hu', -1, 1, '2019-08-13 02:44:18', '2019-08-13 03:13:21', NULL, '', '', '{\"thumbnail\":\"\",\"headerimage\":\"\",\"youtubevideo\":\"\"}', '', '', '', '', ''),
(183, 5, '', '', 'en', -1, 1, '2019-08-13 02:44:18', '2019-08-13 03:13:21', NULL, '', '', '{\"thumbnail\":\"\",\"headerimage\":\"\",\"youtubevideo\":\"\"}', '', '', '', '', ''),
(184, 6, '', '', 'hu', -1, 1, '2019-08-13 03:14:36', '2019-08-13 03:14:40', NULL, '', '', '{\"thumbnail\":\"\",\"headerimage\":\"\",\"youtubevideo\":\"\"}', '', '', '', '', ''),
(185, 6, '', '', 'en', -1, 1, '2019-08-13 03:14:36', '2019-08-13 03:14:40', NULL, '', '', '{\"thumbnail\":\"\",\"headerimage\":\"\",\"youtubevideo\":\"\"}', '', '', '', '', ''),
(186, 7, '', '', 'hu', -1, 1, '2019-08-13 03:19:46', '2019-08-13 03:29:50', NULL, '', '', '{\"thumbnail\":\"\",\"headerimage\":\"\",\"youtubevideo\":\"\"}', '', '', '', '', ''),
(187, 7, '', '', 'en', -1, 1, '2019-08-13 03:19:46', '2019-08-13 03:29:50', NULL, '', '', '{\"thumbnail\":\"\",\"headerimage\":\"\",\"youtubevideo\":\"\"}', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_article_archive`
--

CREATE TABLE `cb_article_archive` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'hu',
  `state` int(2) NOT NULL DEFAULT '0',
  `version` int(11) NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_mod` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `meta_author` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  `media` text,
  `template` varchar(50) NOT NULL DEFAULT '',
  `theme` varchar(50) NOT NULL DEFAULT '',
  `class` varchar(255) NOT NULL DEFAULT '',
  `css` varchar(255) NOT NULL DEFAULT '',
  `js` varchar(255) NOT NULL DEFAULT '',
  `category_xref` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_article_archive`
--

INSERT INTO `cb_article_archive` (`id`, `article_id`, `name`, `text`, `lang`, `state`, `version`, `date_create`, `date_mod`, `meta_author`, `meta_keywords`, `meta_description`, `media`, `template`, `theme`, `class`, `css`, `js`, `category_xref`) VALUES
(1, 1, 'Főoldal', '&lt;p&gt;teszt&lt;/p&gt;', 'hu', 1, 1, '2019-02-21 19:59:29', '2019-02-21 19:51:18', '', '', '', '{\"thumbnail\": \"\", \"headerimage\": \"\"}', '', '', '', '', '', ''),
(3, 1, 'Főoldal', '&lt;p&gt;teszt&lt;/p&gt;', 'hu', 1, 2, '2019-02-21 00:00:00', '2019-02-21 20:01:44', '', '', '', '{\"thumbnail\": \"\", \"headerimage\": \"\"}', '', '', '', '', '', ''),
(4, 4, 'teszt2', '', 'hu', 1, 0, '2019-02-21 20:05:12', NULL, '', '', '', '{\"thumbnail\": \"\", \"headerimage\": \"\", \"youtubevideo\": \"\"}', '', '', '', '', '', ''),
(5, 1, 'Főoldal', '&lt;p&gt;teszt 2&lt;/p&gt;', 'hu', 1, 3, '2019-02-21 00:00:00', '2019-02-21 20:02:23', '', '', '', '{\"thumbnail\": \"\", \"headerimage\": \"\"}', '', '', '', '', '', ''),
(6, 1, 'Főoldal', '&lt;p&gt;teszt 2&lt;/p&gt;', 'hu', 1, 4, '2019-02-21 00:00:00', '2019-02-21 20:28:31', '', '', '', '{\"thumbnail\": \"1_thumbnail_1550777311_3712086784.jpg\", \"headerimage\": \"\", \"youtubevideo\": \"\"}', '', '', '', '', '', ''),
(7, 1, 'Főoldal', '&lt;div id=&quot;lipsum&quot;&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis maximus lacinia bibendum. Pellentesque euismod, quam ut efficitur iaculis, ex lorem aliquam enim, at tristique lectus eros id arcu. Quisque cursus sodales ligula quis eleifend. Cras et posuere dolor. Donec rutrum lacinia tempus. Donec sodales velit turpis, at pretium odio dapibus a. Mauris vitae turpis in mi finibus congue. Morbi tempor augue et orci sagittis porttitor. Vestibulum non urna nec augue posuere commodo id vel est. Aenean turpis metus, scelerisque nec elit pretium, suscipit tempus enim. Donec dolor lectus, eleifend sit amet interdum quis, porta eget purus. Nulla ut lectus nibh. Proin mattis sem odio, in scelerisque metus tempus et. Nulla quis arcu congue ex sodales molestie.&lt;/p&gt;\r\n&lt;p&gt;Donec vitae turpis molestie, gravida turpis ut, mollis massa. Mauris ut metus eros. Ut vitae nisl erat. Suspendisse vel mattis leo, scelerisque aliquam elit. Quisque velit turpis, iaculis ac tincidunt et, rutrum a turpis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse ultrices neque enim, sit amet ultricies felis feugiat non. Aliquam malesuada, tellus tempor feugiat cursus, enim orci dapibus est, eget porta dolor augue id ligula. Sed convallis volutpat lorem, in aliquet lorem.&lt;/p&gt;\r\n&lt;p&gt;Aenean euismod bibendum condimentum. Fusce est sem, vehicula vitae ligula sed, ornare convallis diam. Ut tincidunt, erat feugiat tristique convallis, velit libero bibendum velit, eu volutpat ligula dui ac lectus. Sed egestas massa ut nunc rutrum varius. Vivamus venenatis ex nec justo hendrerit convallis. Mauris maximus nulla tristique, sollicitudin odio sed, elementum urna. Cras a neque convallis, suscipit diam in, consequat tellus.&lt;/p&gt;\r\n&lt;p&gt;Aliquam eget imperdiet dui. Ut sodales tempus justo, hendrerit elementum lorem mollis at. Aliquam dignissim non neque et interdum. Nunc feugiat fringilla magna at euismod. Quisque sit amet lorem orci. Etiam sodales hendrerit ligula at porta. Donec bibendum metus id leo maximus, nec faucibus magna ullamcorper. Nunc faucibus leo nec porttitor eleifend. Nulla in congue elit. Vestibulum nec massa augue. Maecenas ipsum tellus, tristique sit amet dapibus nec, pretium quis urna. Morbi consectetur libero eget efficitur venenatis.&lt;/p&gt;\r\n&lt;p&gt;Duis dictum ut nibh viverra convallis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque bibendum elementum sem, in porta ante pulvinar in. Nulla pulvinar, elit egestas porta cursus, quam ante varius lacus, non elementum sapien nulla a tellus. Vivamus et imperdiet turpis. In et faucibus lacus. Etiam quis blandit augue. Ut sed faucibus arcu, a malesuada turpis. Phasellus in arcu purus. Etiam commodo mi vel mi semper faucibus. Morbi blandit velit vitae dui vulputate, vel viverra nisi efficitur. Aliquam lobortis congue dapibus. Suspendisse vitae placerat dui. Vestibulum at sagittis ex. Sed nec finibus sapien, id dictum enim. Maecenas massa risus, cursus et diam quis, malesuada ullamcorper tortor.&lt;/p&gt;\r\n&lt;/div&gt;', 'hu', 1, 5, '2019-02-21 00:00:00', '2019-02-25 23:23:08', '', '', '', '{\"thumbnail\": \"1_thumbnail_1550777311_3712086784.jpg\", \"headerimage\": \"\", \"youtubevideo\": \"\"}', '', '', '', '', '', ''),
(8, 1, 'Főoldal', '&lt;div id=&quot;lipsum&quot;&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis maximus lacinia bibendum. Pellentesque euismod, quam ut efficitur iaculis, ex lorem aliquam enim, at tristique lectus eros id arcu. Quisque cursus sodales ligula quis eleifend. Cras et posuere dolor. Donec rutrum lacinia tempus. Donec sodales velit turpis, at pretium odio dapibus a. Mauris vitae turpis in mi finibus congue. Morbi tempor augue et orci sagittis porttitor. Vestibulum non urna nec augue posuere commodo id vel est. Aenean turpis metus, scelerisque nec elit pretium, suscipit tempus enim. Donec dolor lectus, eleifend sit amet interdum quis, porta eget purus. Nulla ut lectus nibh. Proin mattis sem odio, in scelerisque metus tempus et. Nulla quis arcu congue ex sodales molestie.&lt;/p&gt;\r\n&lt;p&gt;Donec vitae turpis molestie, gravida turpis ut, mollis massa. Mauris ut metus eros. Ut vitae nisl erat. Suspendisse vel mattis leo, scelerisque aliquam elit. Quisque velit turpis, iaculis ac tincidunt et, rutrum a turpis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse ultrices neque enim, sit amet ultricies felis feugiat non. Aliquam malesuada, tellus tempor feugiat cursus, enim orci dapibus est, eget porta dolor augue id ligula. Sed convallis volutpat lorem, in aliquet lorem.&lt;/p&gt;\r\n&lt;p&gt;Aenean euismod bibendum condimentum. Fusce est sem, vehicula vitae ligula sed, ornare convallis diam. Ut tincidunt, erat feugiat tristique convallis, velit libero bibendum velit, eu volutpat ligula dui ac lectus. Sed egestas massa ut nunc rutrum varius. Vivamus venenatis ex nec justo hendrerit convallis. Mauris maximus nulla tristique, sollicitudin odio sed, elementum urna. Cras a neque convallis, suscipit diam in, consequat tellus.&lt;/p&gt;\r\n&lt;p&gt;Aliquam eget imperdiet dui. Ut sodales tempus justo, hendrerit elementum lorem mollis at. Aliquam dignissim non neque et interdum. Nunc feugiat fringilla magna at euismod. Quisque sit amet lorem orci. Etiam sodales hendrerit ligula at porta. Donec bibendum metus id leo maximus, nec faucibus magna ullamcorper. Nunc faucibus leo nec porttitor eleifend. Nulla in congue elit. Vestibulum nec massa augue. Maecenas ipsum tellus, tristique sit amet dapibus nec, pretium quis urna. Morbi consectetur libero eget efficitur venenatis.&lt;/p&gt;\r\n&lt;p&gt;Duis dictum ut nibh viverra convallis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque bibendum elementum sem, in porta ante pulvinar in. Nulla pulvinar, elit egestas porta cursus, quam ante varius lacus, non elementum sapien nulla a tellus. Vivamus et imperdiet turpis. In et faucibus lacus. Etiam quis blandit augue. Ut sed faucibus arcu, a malesuada turpis. Phasellus in arcu purus. Etiam commodo mi vel mi semper faucibus. Morbi blandit velit vitae dui vulputate, vel viverra nisi efficitur. Aliquam lobortis congue dapibus. Suspendisse vitae placerat dui. Vestibulum at sagittis ex. Sed nec finibus sapien, id dictum enim. Maecenas massa risus, cursus et diam quis, malesuada ullamcorper tortor.&lt;/p&gt;\r\n&lt;/div&gt;', 'hu', 1, 6, '2019-02-21 00:00:00', '2019-02-26 00:18:06', '', '', '', '{\"thumbnail\": \"1_thumbnail_1551136685_808937399.jpg\", \"headerimage\": \"\", \"youtubevideo\": \"\"}', '', '', '', '', '', ''),
(9, 1, 'Főoldal', '&lt;div id=&quot;lipsum&quot;&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis maximus lacinia bibendum. Pellentesque euismod, quam ut efficitur iaculis, ex lorem aliquam enim, at tristique lectus eros id arcu. Quisque cursus sodales ligula quis eleifend. Cras et posuere dolor. Donec rutrum lacinia tempus. Donec sodales velit turpis, at pretium odio dapibus a. Mauris vitae tu&lt;img style=&quot;float: right;&quot; src=&quot;/cb-file/_magata_shiki_subete_ga_f_ni_na.jpg&quot; alt=&quot;&quot; /&gt;rpis in mi finibus congue. Morbi tempor augue et orci sagittis porttitor. Vestibulum non urna nec augue posuere commodo id vel est. Aenean turpis metus, scelerisque nec elit pretium, suscipit tempus enim. Donec dolor lectus, eleifend sit amet interdum quis, porta eget purus. Nulla ut lectus nibh. Proin mattis sem odio, in scelerisque metus tempus et. Nulla quis arcu congue ex sodales molestie.&lt;/p&gt;\r\n&lt;p&gt;Donec vitae turpis molestie, gravida turpis ut, mollis massa. Mauris ut metus eros. Ut vitae nisl erat. Suspendisse vel mattis leo, scelerisque aliquam elit. Quisque velit turpis, iaculis ac tincidunt et, rutrum a turpis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse ultrices neque enim, sit amet ultricies felis feugiat non. Aliquam malesuada, tellus tempor feugiat cursus, enim orci dapibus est, eget porta dolor augue id ligula. Sed convallis volutpat lorem, in aliquet lorem.&lt;/p&gt;\r\n&lt;p&gt;Aenean euismod bibendum condimentum. Fusce est sem, vehicula vitae ligula sed, ornare convallis diam. Ut tincidunt, erat feugiat tristique convallis, velit libero bibendum velit, eu volutpat ligula dui ac lectus. Sed egestas massa ut nunc rutrum varius. Vivamus venenatis ex nec justo hendrerit convallis. Mauris maximus nulla tristique, sollicitudin odio sed, elementum urna. Cras a neque convallis, suscipit diam in, consequat tellus.&lt;/p&gt;\r\n&lt;p&gt;Aliquam eget imperdiet dui. Ut sodales tempus justo, hendrerit elementum lorem mollis at. Aliquam dignissim non neque et interdum. Nunc feugiat fringilla magna at euismod. Quisque sit amet lorem orci. Etiam sodales hendrerit ligula at porta. Donec bibendum metus id leo maximus, nec faucibus magna ullamcorper. Nunc faucibus leo nec porttitor eleifend. Nulla in congue elit. Vestibulum nec massa augue. Maecenas ipsum tellus, tristique sit amet dapibus nec, pretium quis urna. Morbi consectetur libero eget efficitur venenatis.&lt;/p&gt;\r\n&lt;p&gt;Duis dictum ut nibh viverra convallis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque bibendum elementum sem, in porta ante pulvinar in. Nulla pulvinar, elit egestas porta cursus, quam ante varius lacus, non elementum sapien nulla a tellus. Vivamus et imperdiet turpis. In et faucibus lacus. Etiam quis blandit augue. Ut sed faucibus arcu, a malesuada turpis. Phasellus in arcu purus. Etiam commodo mi vel mi semper faucibus. Morbi blandit velit vitae dui vulputate, vel viverra nisi efficitur. Aliquam lobortis congue dapibus. Suspendisse vitae placerat dui. Vestibulum at sagittis ex. Sed nec finibus sapien, id dictum enim. Maecenas massa risus, cursus et diam quis, malesuada ullamcorper tortor.&lt;/p&gt;\r\n&lt;/div&gt;', 'hu', 1, 7, '2019-02-21 00:00:00', '2019-02-26 00:29:05', '', '', '', '{\"thumbnail\": \"1_thumbnail_1551136685_808937399.jpg\", \"headerimage\": \"\", \"youtubevideo\": \"\"}', '', '', '', '', '', ''),
(10, 1, 'Főoldal', '&lt;div id=&quot;lipsum&quot;&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis maximus lacinia bibendum. Pellentesque euismod, quam ut efficitur iaculis, ex lorem aliquam enim, at tristique lectus eros id arcu. Quisque cursus sodales ligula quis eleifend. Cras et posuere dolor. Donec rutrum lacinia tempus. Donec sodales velit turpis, at pretium odio dapibus a. Mauris vitae tu&lt;img style=&quot;float: right;&quot; src=&quot;/cb-file/_magata_shiki_subete_ga_f_ni_na.jpg&quot; alt=&quot;&quot; /&gt;rpis in mi finibus congue. Morbi tempor augue et orci sagittis porttitor. Vestibulum non urna nec augue posuere commodo id vel est. Aenean turpis metus, scelerisque nec elit pretium, suscipit tempus enim. Donec dolor lectus, eleifend sit amet interdum quis, porta eget purus. Nulla ut lectus nibh. Proin mattis sem odio, in scelerisque metus tempus et. Nulla quis arcu congue ex sodales molestie.&lt;/p&gt;\r\n&lt;p&gt;Donec vitae turpis molestie, gravida turpis ut, mollis massa. Mauris ut metus eros. Ut vitae nisl erat. Suspendisse vel mattis leo, scelerisque aliquam elit. Quisque velit turpis, iaculis ac tincidunt et, rutrum a turpis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse ultrices neque enim, sit amet ultricies felis feugiat non. Aliquam malesuada, tellus tempor feugiat cursus, enim orci dapibus est, eget porta dolor augue id ligula. Sed convallis volutpat lorem, in aliquet lorem.&lt;/p&gt;\r\n&lt;p&gt;Aenean euismod bibendum condimentum. Fusce est sem, vehicula vitae ligula sed, ornare convallis diam. Ut tincidunt, erat feugiat tristique convallis, velit libero bibendum velit, eu volutpat ligula dui ac lectus. Sed egestas massa ut nunc rutrum varius. Vivamus venenatis ex nec justo hendrerit convallis. Mauris maximus nulla tristique, sollicitudin odio sed, elementum urna. Cras a neque convallis, suscipit diam in, consequat tellus.&lt;/p&gt;\r\n&lt;p&gt;Aliquam eget imperdiet dui. Ut sodales tempus justo, hendrerit elementum lorem mollis at. Aliquam dignissim non neque et interdum. Nunc feugiat fringilla magna at euismod. Quisque sit amet lorem orci. Etiam sodales hendrerit ligula at porta. Donec bibendum metus id leo maximus, nec faucibus magna ullamcorper. Nunc faucibus leo nec porttitor eleifend. Nulla in congue elit. Vestibulum nec massa augue. Maecenas ipsum tellus, tristique sit amet dapibus nec, pretium quis urna. Morbi consectetur libero eget efficitur venenatis.&lt;/p&gt;\r\n&lt;p&gt;Duis dictum ut nibh viverra convallis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque bibendum elementum sem, in porta ante pulvinar in. Nulla pulvinar, elit egestas porta cursus, quam ante varius lacus, non elementum sapien nulla a tellus. Vivamus et imperdiet turpis. In et faucibus lacus. Etiam quis blandit augue. Ut sed faucibus arcu, a malesuada turpis. Phasellus in arcu purus. Etiam commodo mi vel mi semper faucibus. Morbi blandit velit vitae dui vulputate, vel viverra nisi efficitur. Aliquam lobortis congue dapibus. Suspendisse vitae placerat dui. Vestibulum at sagittis ex. Sed nec finibus sapien, id dictum enim. Maecenas massa risus, cursus et diam quis, malesuada ullamcorper tortor.&lt;/p&gt;\r\n&lt;/div&gt;', 'hu', 1, 8, '2019-02-21 00:00:00', '2019-02-26 00:31:30', '', '', '', '{\"thumbnail\": \"\", \"headerimage\": \"\", \"youtubevideo\": \"\"}', '', '', '', '', '', ''),
(11, 5, '', '', 'en', 1, 0, '2019-08-13 02:44:18', NULL, '', '', '', '{\"thumbnail\":\"\",\"headerimage\":\"\",\"youtubevideo\":\"\"}', '', '', '', '', '', ''),
(12, 5, '', '', 'hu', 1, 0, '2019-08-13 02:44:18', NULL, '', '', '', '{\"thumbnail\":\"\",\"headerimage\":\"\",\"youtubevideo\":\"\"}', '', '', '', '', '', ''),
(13, 6, '', '', 'en', 1, 0, '2019-08-13 03:14:36', NULL, '', '', '', '{\"thumbnail\":\"\",\"headerimage\":\"\",\"youtubevideo\":\"\"}', '', '', '', '', '', ''),
(14, 6, '', '', 'hu', 1, 0, '2019-08-13 03:14:36', NULL, '', '', '', '{\"thumbnail\":\"\",\"headerimage\":\"\",\"youtubevideo\":\"\"}', '', '', '', '', '', ''),
(15, 7, '', '', 'en', 1, 0, '2019-08-13 03:19:46', NULL, '', '', '', '{\"thumbnail\":\"\",\"headerimage\":\"\",\"youtubevideo\":\"\"}', '', '', '', '', '', ''),
(16, 7, '', '', 'hu', 1, 0, '2019-08-13 03:19:46', NULL, '', '', '', '{\"thumbnail\":\"\",\"headerimage\":\"\",\"youtubevideo\":\"\"}', '', '', '', '', '', ''),
(17, 1, 'Főoldal', '&lt;div id=&quot;lipsum&quot;&gt;\r\n&lt;p&gt;Lorem 2 ipsum dolor sit amet, consectetur adipiscing elit. Duis maximus lacinia bibendum. Pellentesque euismod, quam ut efficitur iaculis, ex lorem aliquam enim, at tristique lectus eros id arcu. Quisque cursus sodales ligula quis eleifend. Cras et posuere dolor. Donec rutrum lacinia tempus. Donec sodales velit turpis, at pretium odio dapibus a. Mauris vitae tu&lt;img style=&quot;float: right;&quot; src=&quot;/cb-file/_magata_shiki_subete_ga_f_ni_na.jpg&quot; alt=&quot;&quot; /&gt;rpis in mi finibus congue. Morbi tempor augue et orci sagittis porttitor. Vestibulum non urna nec augue posuere commodo id vel est. Aenean turpis metus, scelerisque nec elit pretium, suscipit tempus enim. Donec dolor lectus, eleifend sit amet interdum quis, porta eget purus. Nulla ut lectus nibh. Proin mattis sem odio, in scelerisque metus tempus et. Nulla quis arcu congue ex sodales molestie.&lt;/p&gt;\r\n&lt;p&gt;Donec vitae turpis molestie, gravida turpis ut, mollis massa. Mauris ut metus eros. Ut vitae nisl erat. Suspendisse vel mattis leo, scelerisque aliquam elit. Quisque velit turpis, iaculis ac tincidunt et, rutrum a turpis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse ultrices neque enim, sit amet ultricies felis feugiat non. Aliquam malesuada, tellus tempor feugiat cursus, enim orci dapibus est, eget porta dolor augue id ligula. Sed convallis volutpat lorem, in aliquet lorem.&lt;/p&gt;\r\n&lt;p&gt;Aenean euismod bibendum condimentum. Fusce est sem, vehicula vitae ligula sed, ornare convallis diam. Ut tincidunt, erat feugiat tristique convallis, velit libero bibendum velit, eu volutpat ligula dui ac lectus. Sed egestas massa ut nunc rutrum varius. Vivamus venenatis ex nec justo hendrerit convallis. Mauris maximus nulla tristique, sollicitudin odio sed, elementum urna. Cras a neque convallis, suscipit diam in, consequat tellus.&lt;/p&gt;\r\n&lt;p&gt;Aliquam eget imperdiet dui. Ut sodales tempus justo, hendrerit elementum lorem mollis at. Aliquam dignissim non neque et interdum. Nunc feugiat fringilla magna at euismod. Quisque sit amet lorem orci. Etiam sodales hendrerit ligula at porta. Donec bibendum metus id leo maximus, nec faucibus magna ullamcorper. Nunc faucibus leo nec porttitor eleifend. Nulla in congue elit. Vestibulum nec massa augue. Maecenas ipsum tellus, tristique sit amet dapibus nec, pretium quis urna. Morbi consectetur libero eget efficitur venenatis.&lt;/p&gt;\r\n&lt;p&gt;Duis dictum ut nibh viverra convallis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque bibendum elementum sem, in porta ante pulvinar in. Nulla pulvinar, elit egestas porta cursus, quam ante varius lacus, non elementum sapien nulla a tellus. Vivamus et imperdiet turpis. In et faucibus lacus. Etiam quis blandit augue. Ut sed faucibus arcu, a malesuada turpis. Phasellus in arcu purus. Etiam commodo mi vel mi semper faucibus. Morbi blandit velit vitae dui vulputate, vel viverra nisi efficitur. Aliquam lobortis congue dapibus. Suspendisse vitae placerat dui. Vestibulum at sagittis ex. Sed nec finibus sapien, id dictum enim. Maecenas massa risus, cursus et diam quis, malesuada ullamcorper tortor.&lt;/p&gt;\r\n&lt;/div&gt;', 'hu', 1, 9, '2019-02-21 00:00:00', '2019-08-12 20:39:24', '', '', '', '{\"thumbnail\": \"\", \"headerimage\": \"\", \"youtubevideo\": \"\"}', '', '', '', '', '', ''),
(18, 1, 'Főoldal', '&lt;div id=&quot;lipsum&quot;&gt;\r\n&lt;p&gt;Lorem 2 ipsum dolor sit amet, consectetur adipiscing elit. Duis maximus lacinia bibendum. Pellentesque euismod, quam ut efficitur iaculis, ex lorem aliquam enim, at tristique lectus eros id arcu. Quisque cursus sodales ligula quis eleifend. Cras et posuere dolor. Donec rutrum lacinia tempus. Donec sodales velit turpis, at pretium odio dapibus a. Mauris vitae tu&lt;img style=&quot;float: right;&quot; src=&quot;/cb-file/_magata_shiki_subete_ga_f_ni_na.jpg&quot; alt=&quot;&quot; /&gt;rpis in mi finibus congue. Morbi tempor augue et orci sagittis porttitor. Vestibulum non urna nec augue posuere commodo id vel est. Aenean turpis metus, scelerisque nec elit pretium, suscipit tempus enim. Donec dolor lectus, eleifend sit amet interdum quis, porta eget purus. Nulla ut lectus nibh. Proin mattis sem odio, in scelerisque metus tempus et. Nulla quis arcu congue ex sodales molestie.&lt;/p&gt;\r\n&lt;p&gt;Donec vitae turpis molestie, gravida turpis ut, mollis massa. Mauris ut metus eros. Ut vitae nisl erat. Suspendisse vel mattis leo, scelerisque aliquam elit. Quisque velit turpis, iaculis ac tincidunt et, rutrum a turpis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse ultrices neque enim, sit amet ultricies felis feugiat non. Aliquam malesuada, tellus tempor feugiat cursus, enim orci dapibus est, eget porta dolor augue id ligula. Sed convallis volutpat lorem, in aliquet lorem.&lt;/p&gt;\r\n&lt;p&gt;Aenean euismod bibendum condimentum. Fusce est sem, vehicula vitae ligula sed, ornare convallis diam. Ut tincidunt, erat feugiat tristique convallis, velit libero bibendum velit, eu volutpat ligula dui ac lectus. Sed egestas massa ut nunc rutrum varius. Vivamus venenatis ex nec justo hendrerit convallis. Mauris maximus nulla tristique, sollicitudin odio sed, elementum urna. Cras a neque convallis, suscipit diam in, consequat tellus.&lt;/p&gt;\r\n&lt;p&gt;Aliquam eget imperdiet dui. Ut sodales tempus justo, hendrerit elementum lorem mollis at. Aliquam dignissim non neque et interdum. Nunc feugiat fringilla magna at euismod. Quisque sit amet lorem orci. Etiam sodales hendrerit ligula at porta. Donec bibendum metus id leo maximus, nec faucibus magna ullamcorper. Nunc faucibus leo nec porttitor eleifend. Nulla in congue elit. Vestibulum nec massa augue. Maecenas ipsum tellus, tristique sit amet dapibus nec, pretium quis urna. Morbi consectetur libero eget efficitur venenatis.&lt;/p&gt;\r\n&lt;p&gt;Duis dictum ut nibh viverra convallis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque bibendum elementum sem, in porta ante pulvinar in. Nulla pulvinar, elit egestas porta cursus, quam ante varius lacus, non elementum sapien nulla a tellus. Vivamus et imperdiet turpis. In et faucibus lacus. Etiam quis blandit augue. Ut sed faucibus arcu, a malesuada turpis. Phasellus in arcu purus. Etiam commodo mi vel mi semper faucibus. Morbi blandit velit vitae dui vulputate, vel viverra nisi efficitur. Aliquam lobortis congue dapibus. Suspendisse vitae placerat dui. Vestibulum at sagittis ex. Sed nec finibus sapien, id dictum enim. Maecenas massa risus, cursus et diam quis, malesuada ullamcorper tortor.&lt;/p&gt;\r\n&lt;/div&gt;', 'hu', 1, 10, '2019-02-21 00:00:00', '2019-08-13 04:58:57', '', '', '', '{\"thumbnail\": \"\", \"headerimage\": \"\", \"youtubevideo\": \"\"}', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_article_category`
--

CREATE TABLE `cb_article_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'hu',
  `parent` int(11) NOT NULL DEFAULT '0',
  `name` varchar(63) NOT NULL,
  `text` text NOT NULL,
  `image` varchar(50) NOT NULL,
  `state` int(2) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_article_category`
--

INSERT INTO `cb_article_category` (`id`, `cat_id`, `lang`, `parent`, `name`, `text`, `image`, `state`, `order`) VALUES
(1, 1, 'hu', 0, 'Hírek', '', '', 1, 0),
(2, 1, 'en', 0, 'News', '', '', 1, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_article_category_xref`
--

CREATE TABLE `cb_article_category_xref` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_article_preview`
--

CREATE TABLE `cb_article_preview` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'hu',
  `state` int(2) NOT NULL DEFAULT '0',
  `media` json DEFAULT NULL,
  `template` varchar(50) NOT NULL DEFAULT '',
  `theme` varchar(50) NOT NULL DEFAULT '',
  `class` varchar(255) NOT NULL DEFAULT '',
  `css` varchar(255) NOT NULL DEFAULT '',
  `js` varchar(255) NOT NULL DEFAULT '',
  `category_xref` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_catalog`
--

CREATE TABLE `cb_catalog` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `catalog_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(128) NOT NULL DEFAULT '',
  `name` varchar(256) NOT NULL,
  `shorttext` mediumtext NOT NULL,
  `text` longtext NOT NULL,
  `lang` varchar(2) NOT NULL,
  `state` int(2) NOT NULL DEFAULT '0',
  `cre_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mod_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `meta_author` text,
  `meta_keywords` text,
  `meta_description` text,
  `media` json DEFAULT NULL,
  `template` varchar(50) NOT NULL DEFAULT '',
  `class` varchar(50) NOT NULL DEFAULT '',
  `short_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_catalog_category`
--

CREATE TABLE `cb_catalog_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'hu',
  `parent` int(11) NOT NULL DEFAULT '0',
  `name` varchar(63) NOT NULL,
  `text` text NOT NULL,
  `image` varchar(50) NOT NULL,
  `state` int(2) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_catalog_category`
--

INSERT INTO `cb_catalog_category` (`id`, `category_id`, `lang`, `parent`, `name`, `text`, `image`, `state`, `order`) VALUES
(1, 1, 'hu', 0, 'Férfi', '', '', 1, 0),
(2, 2, 'hu', 0, 'Női', '', '', 1, 0),
(3, 3, 'hu', 0, 'Sincerity', '', 'sincerity_header.jpg', 1, 0),
(4, 4, 'hu', 0, 'Très Chic', '', 'tes_chic_header.jpg', 1, 0),
(5, 5, 'hu', 0, 'Lilly', '', 'lilly_header.jpg', 1, 0),
(6, 6, 'hu', 0, 'blue by enzoani', '', 'bluebyenzoani_header.jpg', 1, 0),
(7, 7, 'hu', 0, 'Benjamin Roberts', '', '', 1, 0),
(8, 8, 'hu', 0, 'Manzetti', '', 'manzetti_header.jpg', 1, 0),
(9, 9, 'hu', 0, 'Esküvőkre', '', '', 1, 0),
(10, 10, 'hu', 0, 'Kiegészítők', '', '', 1, 0),
(11, 11, 'hu', 0, 'Dekor', '', '', 1, 0),
(12, 12, 'hu', 0, 'Szalagavató', '', '', 1, 0),
(13, 13, 'hu', 4, 'Pure', '', 'tes_chic_header.jpg', 1, 0),
(14, 14, 'hu', 4, 'Elizabeth Grace', '', 'tes_chic_header.jpg', 1, 0),
(15, 15, 'hu', 4, 'Très Chic', '', 'tes_chic_header.jpg', 1, 0),
(16, 16, 'hu', 4, 'Jessie K', '', 'tes_chic_header.jpg', 1, 0),
(17, 17, 'hu', 4, 'Miss Emily', '', 'tes_chic_header.jpg', 1, 0),
(18, 18, 'hu', 5, 'Lilly', '', 'lilly_header.jpg', 1, 0),
(19, 19, 'hu', 5, 'Diamonds', '', 'lilly_header.jpg', 1, 0),
(20, 20, 'hu', 5, 'Passion', '', 'lilly_header.jpg', 1, 0),
(21, 21, 'hu', 5, 'Purewhite', '', 'lilly_header.jpg', 1, 0),
(22, 22, 'hu', 0, 'Bianco', '', '', 1, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_catalog_category_xref`
--

CREATE TABLE `cb_catalog_category_xref` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `catalog_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_contact_forms`
--

CREATE TABLE `cb_contact_forms` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `field` json NOT NULL,
  `target_email` varchar(256) NOT NULL,
  `target_subject` varchar(256) NOT NULL,
  `send_text` varchar(256) NOT NULL,
  `form_class` varchar(256) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_contact_forms`
--

INSERT INTO `cb_contact_forms` (`id`, `name`, `field`, `target_email`, `target_subject`, `send_text`, `form_class`, `state`) VALUES
(1, 'Contact us', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', 'Submit', '', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_contact_maps`
--

CREATE TABLE `cb_contact_maps` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `settings` text NOT NULL COMMENT 'json',
  `text` mediumtext NOT NULL COMMENT 'html'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_contact_posts`
--

CREATE TABLE `cb_contact_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `form_field` json NOT NULL,
  `form_target_email` varchar(256) NOT NULL,
  `form_target_subject` varchar(256) NOT NULL,
  `msgData` json NOT NULL,
  `replyed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_contact_posts`
--

INSERT INTO `cb_contact_posts` (`id`, `form_id`, `date_time`, `form_field`, `form_target_email`, `form_target_subject`, `msgData`, `replyed`) VALUES
(1, 1, '2018-10-25 20:49:31', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"\", \"1_2_2_410854626_tqhadekk\": \"a@a.h\", \"1_0_4_3087843298_kuhz7gpk\": \"\"}', 0),
(2, 1, '2018-10-25 20:54:51', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"\", \"1_2_2_410854626_tqhadekk\": \"a@a.h\", \"1_0_4_3087843298_kuhz7gpk\": \"\"}', 0),
(3, 1, '2018-10-25 20:58:45', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"\", \"1_2_2_410854626_tqhadekk\": \"a@a.h\", \"1_0_4_3087843298_kuhz7gpk\": \"\"}', 0),
(4, 1, '2018-10-25 21:02:58', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"\", \"1_2_2_410854626_tqhadekk\": \"a@a.h\", \"1_0_4_3087843298_kuhz7gpk\": \"\"}', 0),
(5, 1, '2018-10-25 21:18:54', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"asd\", \"1_2_2_410854626_tqhadekk\": \"a@a.h\", \"1_0_4_3087843298_kuhz7gpk\": \"dsad\"}', 0),
(6, 1, '2018-10-25 21:19:19', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"424\", \"1_2_2_410854626_tqhadekk\": \"a@a.h\", \"1_0_4_3087843298_kuhz7gpk\": \"dsad\"}', 0),
(7, 1, '2018-10-25 21:20:06', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"sdfs\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"2323\"}', 0),
(8, 1, '2018-10-25 21:20:39', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"23\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"asdd\"}', 0),
(9, 1, '2018-10-25 21:21:16', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"2332\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"asda\"}', 0),
(10, 1, '2018-10-25 21:21:32', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"424\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"asdasd\"}', 0),
(11, 1, '2018-10-25 21:22:10', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"21313\", \"1_2_2_410854626_tqhadekk\": \"a@a.h\", \"1_0_4_3087843298_kuhz7gpk\": \"2323\"}', 0),
(12, 1, '2018-10-25 21:26:17', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"asd\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"fdaf\"}', 0),
(13, 1, '2018-10-25 21:28:10', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"131\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"23\"}', 0),
(14, 1, '2018-10-25 21:34:49', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"asd\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"asddas\"}', 0),
(15, 1, '2018-10-25 21:35:15', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"ad\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"ffde\"}', 0),
(16, 1, '2018-10-25 21:37:40', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"232\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"12\"}', 0),
(17, 1, '2018-10-25 21:38:28', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"3131\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"1221\"}', 0),
(18, 1, '2018-10-26 00:28:27', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"232\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"dsa\"}', 0),
(19, 1, '2019-01-28 20:13:56', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"asd\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"teszut\"}', 0),
(20, 1, '2019-02-18 13:48:02', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"teszt\", \"recaptcha_response\": \"\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"capcha teszt\"}', 0),
(21, 1, '2019-02-18 13:49:30', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"teszt\", \"recaptcha_response\": \"\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"capcha teszt\"}', 0),
(22, 1, '2019-02-18 13:56:51', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"teszt2\", \"recaptcha_response\": \"\", \"1_2_2_410854626_tqhadekk\": \"erdi.gabor@webed.hu\", \"1_0_4_3087843298_kuhz7gpk\": \"tesztes\\r\\n23245\"}', 0),
(23, 1, '2019-02-18 14:16:23', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"teszt44\", \"recaptcha_response\": \"\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"t\"}', 0),
(24, 1, '2019-02-18 14:30:59', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"sendContactForm\": {\"1\": \"1\"}, \"1_0_1_4262580536_\": \"te\", \"recaptcha_response\": \"\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"222\"}', 0),
(25, 1, '2019-02-18 14:43:09', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"token\": \"03AOLTBLQqmmS60BeWSjzvuZs33tzPx64ZIlV5Xndd0AqWulDPpx3dcHu55w4LKJ-lUMwXOIdBv1hpMRgx1cMaP8OAGSJP5iMI5PtPo-umTIgl3xgGZN8bt2XK8ZXXHW1q5GkTjQ08INt7-NbaSNPpj7TEfb-w-cnsRdSXoL82gA8PnjwVO4MyLD8MLFte63l5vMgqpbSbRQ68r3m1lPh1GPJKQf9zAG1dMXpCUmwQsrn7Au2hwLzdbarv22JneBTv60c3f9C5LESI55hXB5Lfx4X_LC0kXzsQ2hAtp4lMTsHmI1H2ts8TPoWOd1HNCAmt80NRUdlnGsz5vwVfa-avGO60hocRR26LTYhEa11B_KpawKI_OYufhoemE7rcA9mGpASVf_h-IWaNtG9DHGguD_3rnYnrxTEOFg\", \"action\": \"create_comment\", \"form_id\": \"1\", \"1_0_1_4262580536_\": \"tesztttr\", \"recaptcha_response\": \"\", \"sendContactForm__1\": \"1\", \"1_2_2_410854626_tqhadekk\": \"nanao10@webed.hu\", \"1_0_4_3087843298_kuhz7gpk\": \"asdfrw\"}', 0),
(26, 1, '2019-02-18 14:43:47', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"1_0_1_4262580536_\": \"taasd\", \"recaptcha_response\": \"\", \"sendContactForm__1\": \"1\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"sendContactFormButton__1\": \"1\", \"1_0_4_3087843298_kuhz7gpk\": \"firefox teszt\"}', 0),
(27, 1, '2019-02-18 15:06:34', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"1_0_1_4262580536_\": \"asd\", \"recaptcha_response\": \"\", \"sendContactForm__1\": \"1\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"sendContactFormButton__1\": \"1\", \"1_0_4_3087843298_kuhz7gpk\": \"sadd\"}', 0),
(28, 1, '2019-02-18 15:18:29', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"token\": \"03AOLTBLRo0jwEQjDNb4oj-F0u1pYuEG6lX189Tk8VbJNg9EUFTnYM3TG6XO4ooK24SnrBn1byBDmwqxTqNVGKiOuM5vlpuiII35Q2NpR3svx76Emve9g1ANtzOQlcBU6dCSi6yArvOg2H30g_a-Uh_dnNS9vfVvk15oadmn1b0HRsOpWG8lpPYuXV4al-rvFNyRBxPOv8AD8v-CDyJz-naLaRGtNrPO7HCuhR-ZQDZN695Ur0j8zGu6KAj202IKgfeJSIjOezb08Tqm4RATLPZrscIFOcaxO9ASq96-14pH0bLC2J0GSsF38CFWkIT6y78XGZMQcRgFaUIE7_hmUtJIXx8KlpGiiXUQ\", \"action\": \"create_comment\", \"form_id\": \"1\", \"1_0_1_4262580536_\": \"Aaa\", \"recaptcha_response\": \"\", \"sendContactForm__1\": \"1\", \"1_2_2_410854626_tqhadekk\": \"ain@aninet.eu\", \"1_0_4_3087843298_kuhz7gpk\": \"aaa\"}', 0),
(29, 1, '2019-02-18 15:19:58', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"1_0_1_4262580536_\": \"teszt\", \"recaptcha_response\": \"\", \"sendContactForm__1\": \"1\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"sendContactFormButton__1\": \"1\", \"1_0_4_3087843298_kuhz7gpk\": \"astd\"}', 0),
(30, 1, '2019-02-18 15:20:54', '[{\"info\": \"\", \"name\": \"1_0_1_4262580536_\", \"type\": \"1\", \"class\": \"\", \"title\": \"Name\", \"required\": \"1\"}, {\"info\": \"\", \"name\": \"1_2_2_410854626_tqhadekk\", \"type\": \"2\", \"class\": \"\", \"title\": \"Email\", \"formcopy\": \"1\", \"required\": \"1\", \"replyemail\": \"1\"}, {\"info\": \"\", \"name\": \"1_0_4_3087843298_kuhz7gpk\", \"type\": \"4\", \"class\": \"\", \"title\": \"Message\", \"required\": \"1\"}]', 'nanao@aninet.eu', 'Message from the website', '{\"form_id\": \"1\", \"1_0_1_4262580536_\": \"zrz\", \"recaptcha_response\": \"\", \"sendContactForm__1\": \"1\", \"1_2_2_410854626_tqhadekk\": \"nanao10@aninet.eu\", \"sendContactFormButton__1\": \"1\", \"1_0_4_3087843298_kuhz7gpk\": \"teszttt\"}', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_content`
--

CREATE TABLE `cb_content` (
  `id` int(11) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `seo_name` varchar(63) NOT NULL,
  `name_prefix` varchar(15) NOT NULL DEFAULT '',
  `type` int(11) NOT NULL,
  `value` varchar(511) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_content`
--

INSERT INTO `cb_content` (`id`, `lang`, `name`, `seo_name`, `name_prefix`, `type`, `value`) VALUES
(1, 'hu', 'Home', 'home', '', 1, '{\"blank\":0}'),
(2, 'hu', 'Page 2', 'page-2', '', 1, '{\"blank\":0}'),
(3, 'hu', 'Page 4', 'page-4', '', 1, '{\"blank\":0}'),
(4, 'hu', 'Page 5', 'page-5', '', 1, '{\"blank\":0}');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_content_seo`
--

CREATE TABLE `cb_content_seo` (
  `id` int(11) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `seo_name` varchar(63) NOT NULL,
  `name_prefix` varchar(15) NOT NULL,
  `type` int(11) NOT NULL,
  `value` varchar(511) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_content_seo`
--

INSERT INTO `cb_content_seo` (`id`, `lang`, `name`, `seo_name`, `name_prefix`, `type`, `value`) VALUES
(1, 'hu', 'Belépés', 'belepes', '', 6, ''),
(2, 'hu', 'Kilépés', 'kilepes', '', 7, ''),
(3, 'hu', 'Felhasználói beállítások', 'beallitasok', '', 9, ''),
(4, 'hu', 'Regisztráció', 'regisztracio', '', 8, ''),
(5, 'hu', 'Elfelejtett jelszó', 'elfelejtett-jelszo', '', 5, ''),
(6, 'hu', 'Kosár', 'kosar', '', 11, ''),
(7, 'hu', 'Megrendelés', 'megrendeles', '', 12, ''),
(8, 'en', 'Login', 'login', '', 6, ''),
(9, 'en', 'Logout', 'logout', '', 7, ''),
(10, 'en', 'User settings', 'settings', '', 9, ''),
(11, 'en', 'Registration', 'registration', '', 8, ''),
(12, 'en', 'Forgott password', 'forgott-password', '', 5, ''),
(13, 'en', 'Cart', 'cart', '', 11, ''),
(14, 'en', 'Order', 'order', '', 12, ''),
(15, 'hu', 'Főmenü', 'fomenu', '', 15, ''),
(16, 'en', 'Main menu', 'mainmenu', '', 15, '');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_content_type`
--

CREATE TABLE `cb_content_type` (
  `id` int(11) NOT NULL,
  `module` varchar(20) NOT NULL,
  `type` varchar(50) NOT NULL,
  `in_menu` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_content_type`
--

INSERT INTO `cb_content_type` (`id`, `module`, `type`, `in_menu`) VALUES
(1, 'article', 'article', 1),
(2, 'article', 'article_category', 1),
(3, 'menu', 'html', 1),
(4, 'article', 'paralax', 0),
(5, 'account', 'forgott_password', 1),
(6, 'account', 'login', 1),
(7, 'account', 'logout', 1),
(8, 'account', 'registration', 1),
(9, 'account', 'settings', 1),
(10, 'product', 'list', 0),
(11, 'product', 'cart', 0),
(12, 'product', 'order', 0),
(14, 'product', 'product', 0),
(15, 'gentium', 'main', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_currency_list`
--

CREATE TABLE `cb_currency_list` (
  `id` varchar(3) NOT NULL,
  `symbol` varchar(10) CHARACTER SET utf32 NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_currency_list`
--

INSERT INTO `cb_currency_list` (`id`, `symbol`, `name`) VALUES
('aed', '', 'UAE Dirham'),
('afn', '؋', 'Afghan Afghani'),
('all', 'Lek', 'Albanian Lek'),
('amd', '', 'Armenian Dram'),
('ang', 'ƒ', 'Netherlands Antillean Gulden'),
('aoa', '', 'Angolan Kwanza'),
('ars', '$', 'Argentine Peso'),
('aud', '$', 'Australian Dollar'),
('awg', 'ƒ', 'Aruban Florin'),
('azn', 'ман', 'Azerbaijani Manat'),
('bam', 'KM', 'Bosnia And Herzegovina Konvertibilna Marka'),
('bbd', '$', 'Barbadian Dollar'),
('bdt', '', 'Bangladeshi Taka'),
('bgn', 'лв', 'Bulgarian Lev'),
('bhd', '', 'Bahraini Dinar'),
('bif', '', 'Burundi Franc'),
('bnd', '$', 'Brunei Dollar'),
('bob', '$b', 'Bolivian Boliviano'),
('brl', 'R$', 'Brazilian Real'),
('bsd', '$', 'Bahamian Dollar'),
('btc', 'BTC', 'Bitcoin'),
('btn', '', 'Bhutanese Ngultrum'),
('bwp', 'P', 'Botswana Pula'),
('byn', 'p.', 'New Belarusian Ruble'),
('byr', 'p.', 'Belarusian Ruble'),
('bzd', 'BZ$', 'Belize Dollar'),
('cad', '$', 'Canadian Dollar'),
('cdf', '', 'Congolese Franc'),
('chf', 'Fr.', 'Swiss Franc'),
('clp', '$', 'Chilean Peso'),
('cny', '¥', 'Chinese Yuan'),
('cop', '$', 'Colombian Peso'),
('crc', '₡', 'Costa Rican Colon'),
('cup', '$', 'Cuban Peso'),
('cve', '', 'Cape Verdean Escudo'),
('czk', 'Kč', 'Czech Koruna'),
('djf', '', 'Djiboutian Franc'),
('dkk', 'kr', 'Danish Krone'),
('dop', 'RD$', 'Dominican Peso'),
('dzd', '', 'Algerian Dinar'),
('egp', '£', 'Egyptian Pound'),
('ern', '', 'Eritrean Nakfa'),
('etb', '', 'Ethiopian Birr'),
('eur', '€', 'Euro'),
('fjd', '$', 'Fijian Dollar'),
('fkp', '£', 'Falkland Islands Pound'),
('gbp', '£', 'British Pound'),
('gel', '', 'Georgian Lari'),
('ghs', '', 'Ghanaian Cedi'),
('gip', '£', 'Gibraltar Pound'),
('gmd', '', 'Gambian Dalasi'),
('gnf', '', 'Guinean Franc'),
('gtq', 'Q', 'Guatemalan Quetzal'),
('gyd', '$', 'Guyanese Dollar'),
('hkd', '$', 'Hong Kong Dollar'),
('hnl', 'L', 'Honduran Lempira'),
('hrk', 'kn', 'Croatian Kuna'),
('htg', '', 'Haitian Gourde'),
('huf', 'Ft', 'Hungarian Forint'),
('idr', 'Rp', 'Indonesian Rupiah'),
('ils', '₪', 'Israeli New Sheqel'),
('inr', '₹', 'Indian Rupee'),
('iqd', '', 'Iraqi Dinar'),
('irr', '﷼', 'Iranian Rial'),
('isk', 'kr', 'Icelandic Króna'),
('jmd', 'J$', 'Jamaican Dollar'),
('jod', '', 'Jordanian Dinar'),
('jpy', '¥', 'Japanese Yen'),
('kes', 'KSh', 'Kenyan Shilling'),
('kgs', 'лв', 'Kyrgyzstani Som'),
('khr', '៛', 'Cambodian Riel'),
('kmf', '', 'Comorian Franc'),
('kpw', '₩', 'North Korean Won'),
('krw', '₩', 'South Korean Won'),
('kwd', '', 'Kuwaiti Dinar'),
('kyd', '$', 'Cayman Islands Dollar'),
('kzt', 'лв', 'Kazakhstani Tenge'),
('lak', '₭', 'Lao Kip'),
('lbp', '£', 'Lebanese Lira'),
('lkr', '₨', 'Sri Lankan Rupee'),
('lrd', '$', 'Liberian Dollar'),
('lsl', '', 'Lesotho Loti'),
('lvl', 'Ls', 'Latvian Lats'),
('lyd', '', 'Libyan Dinar'),
('mad', '', 'Moroccan Dirham'),
('mdl', '', 'Moldovan Leu'),
('mga', '', 'Malagasy Ariary'),
('mkd', 'ден', 'Macedonian Denar'),
('mmk', '', 'Myanma Kyat'),
('mnt', '₮', 'Mongolian Tugrik'),
('mop', '', 'Macanese Pataca'),
('mro', '', 'Mauritanian Ouguiya'),
('mur', '₨', 'Mauritian Rupee'),
('mvr', '', 'Maldivian Rufiyaa'),
('mwk', '', 'Malawian Kwacha'),
('mxn', '$', 'Mexican Peso'),
('myr', 'RM', 'Malaysian Ringgit'),
('mzn', '', 'Mozambican Metical'),
('nad', '$', 'Namibian Dollar'),
('ngn', '₦', 'Nigerian Naira'),
('nio', 'C$', 'Nicaraguan Cordoba'),
('nok', 'kr', 'Norwegian Krone'),
('npr', '₨', 'Nepalese Rupee'),
('nzd', '$', 'New Zealand Dollar'),
('omr', '﷼', 'Omani Rial'),
('pab', 'B/.', 'Panamanian Balboa'),
('pen', 'S/.', 'Peruvian Nuevo Sol'),
('pgk', '', 'Papua New Guinean Kina'),
('php', '₱', 'Philippine Peso'),
('pkr', '₨', 'Pakistani Rupee'),
('pln', 'zł', 'Polish Zloty'),
('pyg', 'Gs', 'Paraguayan Guarani'),
('qar', '﷼', 'Qatari Riyal'),
('ron', 'lei', 'Romanian Leu'),
('rsd', 'Дин.', 'Serbian Dinar'),
('rub', 'руб', 'Russian Ruble'),
('rwf', '', 'Rwandan Franc'),
('sar', '﷼', 'Saudi Riyal'),
('sbd', '$', 'Solomon Islands Dollar'),
('scr', '₨', 'Seychellois Rupee'),
('sdg', '', 'Sudanese Pound'),
('sek', 'kr', 'Swedish Krona'),
('sgd', '$', 'Singapore Dollar'),
('shp', '£', 'Saint Helena Pound'),
('sll', '', 'Sierra Leonean Leone'),
('sos', 'S', 'Somali Shilling'),
('srd', '$', 'Surinamese Dollar'),
('std', '', 'Sao Tome And Principe Dobra'),
('syp', '£', 'Syrian Pound'),
('szl', '', 'Swazi Lilangeni'),
('thb', '฿', 'Thai Baht'),
('tjs', '', 'Tajikistani Somoni'),
('tmt', '', 'Turkmenistan Manat'),
('tnd', '', 'Tunisian Dinar'),
('top', '', 'Paanga'),
('try', '', 'Turkish New Lira'),
('ttd', 'TT$', 'Trinidad and Tobago Dollar'),
('twd', 'NT$', 'New Taiwan Dollar'),
('tzs', 'TSh', 'Tanzanian Shilling'),
('uah', '₴', 'Ukrainian Hryvnia'),
('ugx', 'USh', 'Ugandan Shilling'),
('usd', '$', 'United States Dollar'),
('uyu', '$U', 'Uruguayan Peso'),
('uzs', 'лв', 'Uzbekistani Som'),
('vef', '', 'Venezuelan Bolivar'),
('vnd', '₫', 'Vietnamese Dong'),
('vuv', '', 'Vanuatu Vatu'),
('wst', '', 'Samoan Tala'),
('xaf', '', 'Central African CFA Franc'),
('xcd', '$', 'East Caribbean Dollar'),
('xdr', '', 'Special Drawing Rights'),
('xof', '', 'West African CFA Franc'),
('xpf', '', 'CFP Franc'),
('yer', '﷼', 'Yemeni Rial'),
('zar', 'R', 'South African Rand'),
('zmw', '', 'Zambian Kwacha');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_currency_value`
--

CREATE TABLE `cb_currency_value` (
  `base` varchar(3) NOT NULL,
  `vto` varchar(3) NOT NULL,
  `value` float(30,10) UNSIGNED NOT NULL DEFAULT '0.0000000000',
  `refresh_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_currency_value`
--

INSERT INTO `cb_currency_value` (`base`, `vto`, `value`, `refresh_date`) VALUES
('eur', 'usd', 1.1279929876, '2019-02-13 20:15:39'),
('usd', 'usd', 1.0000000000, '2019-02-13 20:11:43');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_file`
--

CREATE TABLE `cb_file` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_size` int(11) NOT NULL,
  `file_type` varchar(20) NOT NULL,
  `date` int(11) NOT NULL,
  `comment` text NOT NULL,
  `file_ext` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_gallery`
--

CREATE TABLE `cb_gallery` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `md5` varchar(32) NOT NULL,
  `title` text NOT NULL,
  `filename` varchar(255) NOT NULL,
  `cre_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order` int(11) NOT NULL DEFAULT '0',
  `del` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_gallery`
--

INSERT INTO `cb_gallery` (`id`, `cat_id`, `md5`, `title`, `filename`, `cre_date`, `order`, `del`) VALUES
(1, 1, '8297f5e4ce97fafe8e0667a4407da092', '', 'ca4f77c271fc3e28ac439df57a410968_1565635852.jpg', '2019-08-12 18:50:52', 2, 0),
(2, 1, '23e1e0536126f98e1ee3e18f621e4c1f', 'kép aláírással', 'c6a36ce545bad4672d207b78f9202101_1565635852.png', '2019-08-12 18:50:53', 3, 0),
(3, 1, '9266d161d12fd664a52b9da143aff23e', '', '02a40fa23e0ecda44594185d7de21296_1565635853.png', '2019-08-12 18:50:54', 4, 0),
(10, 1, '304a8e7379f20b8253043b00ca0068ce', '', '3560c4eae664b7085fbaa6ff5302ffdc_1565635950.png', '2019-08-12 18:52:31', 5, 0),
(12, 1, 'f930c0ff7624c8ab253dfc8a94c4d789', '', '2d0d354198a4ebe1fccf6ed2bd39892f_1565639466.png', '2019-08-12 19:51:06', 6, 0),
(18, 1, 'a064fbe5a4284877ae199ac8ea1387ca', '', '4e508a04c518edbcba1fb1347b0c1526_1565639999.png', '2019-08-12 19:59:59', 7, 0),
(19, 1, 'c8c334dc59ccfe1beb55f9f35736c946', '', '8fe814479d3d8abc90a0cf5696a377a8_1565640051.png', '2019-08-12 20:00:51', 1, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_gallery_category`
--

CREATE TABLE `cb_gallery_category` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(63) NOT NULL,
  `dir` varchar(63) NOT NULL,
  `class` varchar(127) NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_gallery_category`
--

INSERT INTO `cb_gallery_category` (`id`, `name`, `dir`, `class`, `state`) VALUES
(1, 'Galéria', 'galeria', '', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_invite`
--

CREATE TABLE `cb_invite` (
  `id` bigint(20) NOT NULL,
  `rel` varchar(64) NOT NULL DEFAULT '',
  `rel_id` varchar(64) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expire` datetime NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_language`
--

CREATE TABLE `cb_language` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'en',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(30) DEFAULT NULL,
  `constant` varchar(128) DEFAULT NULL,
  `text` text,
  `tag` varchar(30) DEFAULT NULL COMMENT 'just info, for taging',
  `debugger_predicted` tinyint(1) NOT NULL DEFAULT '0',
  `translate_need` tinyint(1) NOT NULL DEFAULT '0',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_language`
--

INSERT INTO `cb_language` (`id`, `lang`, `is_admin`, `module`, `constant`, `text`, `tag`, `debugger_predicted`, `translate_need`, `deprecated`, `date_create`) VALUES
(1, 'hu', 1, 'catalog', 'import_tname', 'Lista feltöltés', 'import', 0, 0, 0, '2018-11-08 13:10:52'),
(2, 'hu', 1, 'catalog', 'import_mname', 'Lista feltöltés', 'import', 0, 0, 0, '2018-11-08 13:10:52'),
(4, 'hu', 1, 'admin', 'menutitle_mname', 'Navigáció', NULL, 0, 0, 0, '2018-11-08 15:28:20'),
(5, 'hu', 1, 'catalog', 'category_list_tname', 'Kategóriák', 'category', 0, 0, 0, '2018-11-08 15:34:35'),
(6, 'hu', 1, 'catalog', 'category_list_mname', 'Kategóriák', 'category', 0, 0, 0, '2018-11-08 15:34:35'),
(7, 'hu', 1, 'catalog', 'export_tname', 'Lista letöltés', 'export', 0, 0, 0, '2018-11-08 13:10:52'),
(8, 'hu', 1, 'catalog', 'export_mname', 'Lista letöltés', 'export', 0, 0, 0, '2018-11-08 13:10:52'),
(9, 'hu', 1, 'catalog', 'csv_list_upload_title', 'CSV Lista feltöltés', 'import', 0, 0, 0, '2018-11-15 01:29:52'),
(10, 'hu', 1, 'catalog', 'csv_list_upload_helpblock', 'Katalógus lista kiválasztása és feltöltése. <br /><a href=\"#\" target=\"cb_newPage\">Minta fájl letöltése</a>', 'import', 0, 0, 0, '2018-11-15 01:29:52'),
(12, 'hu', 1, 'catalog', 'csv_list_upload_lastimport', 'Utolsó importálás: ', 'import', 0, 0, 0, '2018-11-15 01:29:52'),
(13, 'hu', 1, 'catalog', 'csv_list_upload_neveruploaded', 'Nem volt még feltöltött fájl!', 'import', 0, 0, 0, '2018-11-15 01:29:52'),
(14, 'hu', 1, 'mediamanager', 'main_tname', 'Médiakezelő', 'mediamanager', 0, 0, 0, '2018-11-16 00:00:00'),
(15, 'hu', 1, 'mediamanager', 'main_mname', 'Médiakezelő', 'mediamanager', 0, 0, 0, '2018-11-16 00:00:00'),
(16, 'hu', 1, 'mediamanager', 'filemanager_tname', 'Fájlkezelő', 'filemanager', 0, 0, 0, '2018-11-16 00:00:00'),
(17, 'hu', 1, 'mediamanager', 'filemanager_mname', 'Fájlkezelő', 'filemanager', 0, 0, 0, '2018-11-16 00:00:00'),
(18, 'en', 0, 'sys', 'memory_debug_text', 'Memory debug, peak memory usage', '', 0, 0, 0, '2018-11-20 09:22:00'),
(19, 'hu', 0, 'sys', 'memory_debug_text', 'Memória hibakereső, pillanatnyi memória használat', '', 0, 0, 0, '2018-11-20 09:22:00'),
(20, 'hu', 1, 'catalog', 'catalog_without_image_tname', 'Kép nélküli termékek', '', 0, 0, 0, '2018-11-15 01:29:52'),
(21, 'hu', 1, 'catalog', 'catalog_without_image_mname', 'Kép nélküli termékek', '', 0, 0, 0, '2018-11-15 01:29:52'),
(33, 'en', 0, 'sys', 'back_button', '< Back', '', 0, 0, 0, '2018-11-20 09:22:00'),
(41, 'en', 0, 'sys', 'date_today', 'Today', '', 0, 0, 0, '2018-12-06 16:22:00'),
(42, 'en', 0, 'sys', 'date_yesterday', 'yesterday', '', 0, 0, 0, '2018-12-06 16:22:00'),
(43, 'en', 0, 'sys', 'date_weak_ago', 'weak ago', '', 0, 0, 0, '2018-12-06 16:22:00'),
(44, 'en', 0, 'sys', 'date_weaks_ago', 'weaks ago', '', 0, 0, 0, '2018-12-06 16:22:00'),
(45, 'en', 0, 'sys', 'date_month_ago', 'month ago', '', 0, 0, 0, '2018-12-06 16:22:00'),
(46, 'en', 0, 'sys', 'date_months_ago', 'months ago', '', 0, 0, 0, '2018-12-06 16:22:00'),
(47, 'en', 0, 'sys', 'date_year_ago', 'year ago', '', 0, 0, 0, '2018-12-06 16:22:00'),
(48, 'en', 0, 'sys', 'date_years_ago', 'years ago', '', 0, 0, 0, '2018-12-06 16:22:00'),
(49, 'hu', 0, 'sys', 'date_today', 'ma', '', 0, 0, 0, '2018-12-06 16:22:00'),
(50, 'hu', 0, 'sys', 'date_yesterday', 'tegnap', '', 0, 0, 0, '2018-12-06 16:22:00'),
(51, 'hu', 0, 'sys', 'date_weak_ago', 'hete', '', 0, 0, 0, '2018-12-06 16:22:00'),
(52, 'hu', 0, 'sys', 'date_weaks_ago', 'hete', '', 0, 0, 0, '2018-12-06 16:22:00'),
(53, 'hu', 0, 'sys', 'date_month_ago', 'hónapja', '', 0, 0, 0, '2018-12-06 16:22:00'),
(54, 'hu', 0, 'sys', 'date_months_ago', 'hónapja', '', 0, 0, 0, '2018-12-06 16:22:00'),
(55, 'hu', 0, 'sys', 'date_year_ago', 'éve', '', 0, 0, 0, '2018-12-06 16:22:00'),
(56, 'hu', 0, 'sys', 'date_years_ago', 'éve', '', 0, 0, 0, '2018-12-06 16:22:00'),
(70, 'en', 1, 'admin', 'main_tname', 'Admin area', '', 0, 0, 0, '2018-12-12 06:32:00'),
(71, 'hu', 1, 'admin', 'main_tname', 'Admin felület', '', 0, 0, 0, '2018-12-12 06:32:00'),
(72, 'en', 1, 'sys', 'menutitle_mname', 'Navigation', '', 0, 0, 0, '2018-12-12 06:32:00'),
(73, 'en', 1, 'sys', 'mainpage_tname', 'Mainpage', '', 0, 0, 0, '2018-12-12 06:32:00'),
(74, 'en', 1, 'admin', 'settings_mname', 'System Settings', '', 0, 0, 0, '2018-12-12 06:32:00'),
(75, 'en', 1, 'admin', 'settings_tname', 'System Settings', '', 0, 0, 0, '2018-12-12 06:32:00'),
(76, 'en', 1, 'admin', 'main_mname', 'Mainpage', '', 0, 0, 0, '2018-12-12 06:32:00'),
(77, 'en', 1, 'article', 'main_tname', 'Manage article', '', 0, 0, 0, '2018-12-12 06:32:00'),
(78, 'en', 1, 'article', 'main_mname', 'Manage article', '', 0, 0, 0, '2018-12-12 06:32:00'),
(79, 'en', 1, 'article', 'group_main_mname', 'Categories', '', 0, 0, 0, '2018-12-12 06:32:00'),
(80, 'en', 1, 'article', 'group_main_tname', 'Category list', '', 0, 0, 0, '2018-12-12 06:32:00'),
(81, 'en', 1, 'article', 'create_tname', 'New article', '', 0, 0, 0, '2018-12-12 06:32:00'),
(82, 'en', 1, 'article', 'edit_tname', 'Edit article', '', 0, 0, 0, '2018-12-12 06:32:00'),
(83, 'en', 1, 'article', 'group_edit_tname', 'Edit category', '', 0, 0, 0, '2018-12-12 06:32:00'),
(84, 'en', 1, 'article', 'group_create_tname', 'Create category', '', 0, 0, 0, '2018-12-12 06:32:00'),
(85, 'en', 1, 'menu', 'main_tname', 'Menu manager', '', 0, 0, 0, '2018-12-12 06:32:00'),
(86, 'en', 1, 'menu', 'main_mname', 'Menu manager', '', 0, 0, 0, '2018-12-12 06:32:00'),
(87, 'en', 1, 'menu', 'group_main_tname', 'Category list', '', 0, 0, 0, '2018-12-12 06:32:00'),
(88, 'en', 1, 'menu', 'group_main_mname', 'Categories', '', 0, 0, 0, '2018-12-12 06:32:00'),
(89, 'en', 1, 'menu', 'list_tname', 'Menu element list', '', 0, 0, 0, '2018-12-12 06:32:00'),
(90, 'en', 1, 'menu', 'create_tname', 'Menu element create', '', 0, 0, 0, '2018-12-12 06:32:00'),
(91, 'en', 1, 'menu', 'menu_edit_tname', 'Menu element edit', '', 0, 0, 0, '2018-12-12 06:32:00'),
(92, 'en', 1, 'menu', 'group_create_tname', 'Menu group create', '', 0, 0, 0, '2018-12-12 06:32:00'),
(93, 'en', 1, 'menu', 'group_edit_tname', 'Menu group edit', '', 0, 0, 0, '2018-12-12 06:32:00'),
(108, 'en', 1, 'gallery', 'main_tname', 'Gallery', '', 0, 0, 0, '2018-12-12 06:32:00'),
(109, 'en', 1, 'gallery', 'main_mname', 'Gallery', '', 0, 0, 0, '2018-12-12 06:32:00'),
(110, 'en', 1, 'filemanager', 'main_tname', 'Filemanager', '', 0, 0, 0, '2018-12-12 06:32:00'),
(111, 'en', 1, 'filemanager', 'main_mname', 'Filemanager', '', 0, 0, 0, '2018-12-12 06:32:00'),
(112, 'en', 1, 'contact', 'main_tname', 'Contact', '', 0, 0, 0, '2018-12-12 06:32:00'),
(113, 'en', 1, 'contact', 'main_mname', 'Contact', '', 0, 0, 0, '2018-12-12 06:32:00'),
(114, 'en', 1, 'contact', 'forms_tname', 'Forms', '', 0, 0, 0, '2018-12-12 06:32:00'),
(115, 'en', 1, 'contact', 'forms_mname', 'Forms', '', 0, 0, 0, '2018-12-12 06:32:00'),
(128, 'en', 0, 'account', 'message_no_new_message', 'Sorry, no new message...', '', 0, 0, 0, '2019-01-03 12:06:00'),
(129, 'en', 0, 'account', 'message_title', 'Messages', '', 0, 0, 0, '2019-01-03 12:06:00'),
(132, 'hu', 0, 'account', 'title_usersetup', 'Felhasználó beállítások', '', 0, 0, 0, '2019-01-03 12:06:00'),
(133, 'en', 0, 'account', 'title_usersetup', 'User settings', '', 0, 0, 0, '2019-01-03 12:06:00'),
(134, 'en', 1, 'account', 'title_usercreate', 'User create/modify', '', 0, 0, 0, '2019-01-03 12:06:00'),
(135, 'hu', 1, 'account', 'title_usercreate', 'Felhasználó létrehozás/módosítás', '', 0, 0, 0, '2019-01-03 12:06:00'),
(136, 'en', 0, 'account', 'menu_admin_menu', 'Admin area', '', 0, 0, 0, '2019-01-04 13:30:00'),
(137, 'hu', 0, 'account', 'menu_admin_menu', 'Adminisztrátor terület', '', 0, 0, 0, '2019-01-04 13:30:00'),
(138, 'en', 0, 'account', 'menu_change_settings', 'Profile datas change', '', 0, 0, 0, '2019-01-04 13:30:00'),
(139, 'hu', 0, 'account', 'menu_change_settings', 'Profil adatok módosítása', '', 0, 0, 0, '2019-01-04 13:30:00'),
(140, 'en', 0, 'account', 'menu_change_password', 'Change password', '', 0, 0, 0, '2019-01-04 13:30:00'),
(141, 'hu', 0, 'account', 'menu_change_password', 'Jelszó módosítása', '', 0, 0, 0, '2019-01-04 13:30:00'),
(142, 'en', 0, 'account', 'menu_change_image', 'Profile image change', '', 0, 0, 0, '2019-01-04 13:30:00'),
(143, 'hu', 0, 'account', 'menu_change_image', 'Felhasználó kép módosítás', '', 0, 0, 0, '2019-01-04 13:30:00'),
(144, 'en', 0, 'account', 'menu_logout', 'Logout', '', 0, 0, 0, '2019-01-04 13:30:00'),
(145, 'hu', 0, 'account', 'menu_logout', 'Kijelentkezés', '', 0, 0, 0, '2019-01-04 13:30:00'),
(146, 'en', 0, 'mail2', 'support', 'Support', '', 0, 0, 0, '2019-01-06 13:27:00'),
(147, 'hu', 0, 'mail2', 'support', 'Támogatás', '', 0, 0, 0, '2019-01-06 13:27:00'),
(148, 'en', 0, 'account', 'title_invitation_email', 'Invitation', 'invitation_email', 0, 0, 0, '2019-01-06 13:43:00'),
(149, 'hu', 0, 'account', 'title_invitation_email', 'Meghívás', 'invitation_email', 0, 0, 0, '2019-01-06 13:43:00'),
(150, 'en', 0, 'account', 'invitation_email_dear', 'Dear email owner!', 'invitation_email', 0, 0, 0, '2019-01-06 13:43:00'),
(151, 'hu', 0, 'account', 'invitation_email_dear', 'Tisztelt email tulajdonos!', 'invitation_email', 0, 0, 0, '2019-01-06 13:43:00'),
(152, 'en', 0, 'account', 'invitation_email_pretext', 'Someone invite you for our site.', 'invitation_email', 0, 0, 0, '2019-01-06 13:43:00'),
(153, 'hu', 0, 'account', 'invitation_email_pretext', 'Valaki meghívta önt az oldalunkra.', 'invitation_email', 0, 0, 0, '2019-01-06 13:43:00'),
(154, 'en', 0, 'account', 'invitation_email_link', 'For the registration click here.', 'invitation_email', 0, 0, 0, '2019-01-06 13:43:00'),
(155, 'hu', 0, 'account', 'invitation_email_link', 'A regisztrációhoz kattintson ide.', 'invitation_email', 0, 0, 0, '2019-01-06 13:43:00'),
(156, 'hu', 0, 'account', 'invitation_email_afttext', 'Ön bármikor regisztrálhat amikor csak akar!', 'invitation_email', 0, 0, 0, '2019-01-06 13:43:00'),
(157, 'en', 0, 'account', 'invitation_email_afttext', 'You can register whenever you want!', 'invitation_email', 0, 0, 0, '2019-01-06 13:43:00'),
(158, 'en', 0, 'mail2', 'go_to_website', 'Go to website >', '', 0, 0, 0, '2019-01-06 13:27:00'),
(159, 'hu', 0, 'mail2', 'go_to_website', 'A weboldal megtekintése >', '', 0, 0, 0, '2019-01-06 13:27:00'),
(160, 'en', 0, 'account', 'invitation_email_sent_error', 'Can\'t sent the mail!', 'invitation_email', 0, 0, 0, '2019-01-06 13:43:00'),
(162, 'hu', 0, 'account', 'invitation_email_sent_error', 'Az email elküldése sikertelen!', 'invitation_email', 0, 0, 0, '2019-01-06 13:43:00'),
(163, 'en', 0, 'account', 'invitation_email_sent_success', 'Mail sent!', 'invitation_email', 0, 0, 0, '2019-01-06 13:43:00'),
(164, 'hu', 0, 'account', 'invitation_email_sent_success', 'Az email elküldve!', 'invitation_email', 0, 0, 0, '2019-01-06 13:43:00'),
(165, 'en', 0, 'account', 'password_recovery_email_dear', 'Dear', 'recovery_email', 0, 0, 0, '2019-01-06 18:30:00'),
(166, 'hu', 0, 'account', 'password_recovery_email_dear', 'Kedves', 'recovery_email', 0, 0, 0, '2019-01-06 18:30:00'),
(286, 'en', 1, 'account', 'permission_field_name', 'Name', '', 0, 0, 0, '2019-02-14 14:46:00'),
(287, 'hu', 1, 'account', 'permission_field_name', 'Név', '', 0, 0, 0, '2019-02-14 14:46:00'),
(288, 'en', 1, 'account', 'permission_tabmenu_user', 'Website permissions', '', 0, 0, 0, '2019-02-14 14:46:00'),
(289, 'hu', 1, 'account', 'permission_tabmenu_user', 'Weboldal jogosultságok', '', 0, 0, 0, '2019-02-14 14:46:00'),
(290, 'hu', 1, 'account', 'permission_tabmenu_admin', 'Admin jogosultságok', '', 0, 0, 0, '2019-02-14 14:46:00'),
(291, 'en', 1, 'account', 'permission_tabmenu_admin', 'Admin permissions', '', 0, 0, 0, '2019-02-14 14:46:00'),
(292, 'en', 1, 'account', 'main_tname', 'Manage Users', '', 0, 0, 0, '2019-02-14 15:36:00'),
(293, 'hu', 1, 'account', 'main_tname', 'Felhasználó kezelő', '', 0, 0, 0, '2019-02-14 15:36:00'),
(294, 'hu', 1, 'account', 'details_tname', 'Részletek', '', 0, 0, 0, '2019-02-14 15:36:00'),
(295, 'en', 1, 'account', 'details_tname', 'Details', '', 0, 0, 0, '2019-02-14 15:36:00'),
(296, 'en', 1, 'account', 'create_tname', 'New', '', 0, 0, 0, '2019-02-14 15:36:00'),
(297, 'hu', 1, 'account', 'create_tname', 'Új', '', 0, 0, 0, '2019-02-14 15:36:00'),
(298, 'hu', 1, 'account', 'edit_tname', 'Szerkesztés', '', 0, 0, 0, '2019-02-14 15:36:00'),
(299, 'en', 1, 'account', 'edit_tname', 'Edit', '', 0, 0, 0, '2019-02-14 15:36:00'),
(300, 'en', 1, 'account', 'delete_tname', 'Delete', '', 0, 0, 0, '2019-02-14 15:36:00'),
(301, 'hu', 1, 'account', 'delete_tname', 'Törlés', '', 0, 0, 0, '2019-02-14 15:36:00'),
(302, 'hu', 1, 'account', 'main_mname', 'Felhasználó kezelő', '', 0, 0, 0, '2019-02-14 15:36:00'),
(303, 'en', 1, 'account', 'main_mname', 'Manage Users', '', 0, 0, 0, '2019-02-14 15:36:00'),
(304, 'en', 1, 'account', 'username_error', 'E-mail must be filled!', '', 0, 0, 0, '2019-02-14 15:36:00'),
(305, 'hu', 1, 'account', 'username_error', 'E-mail nem lehet üres!', '', 0, 0, 0, '2019-02-14 15:36:00'),
(306, 'hu', 1, 'account', 'userpassw_error', 'Jelszó nem lehet üres!', '', 0, 0, 0, '2019-02-14 15:36:00'),
(307, 'en', 1, 'account', 'userpassw_error', 'Password must be filled!', '', 0, 0, 0, '2019-02-14 15:36:00'),
(308, 'en', 1, 'account', 'account_valid_error', 'Wrong e-mail or password!', '', 0, 0, 0, '2019-02-14 15:36:00'),
(309, 'hu', 1, 'account', 'account_valid_error', 'Hibás e-mail cím vagy jelszó!', '', 0, 0, 0, '2019-02-14 15:36:00'),
(310, 'hu', 1, 'account', 'account_login_success', 'Sikeresen beléptél a rendszerbe :)', '', 0, 0, 0, '2019-02-14 15:36:00'),
(311, 'en', 1, 'account', 'account_login_success', 'You logged in successfully! :)', '', 0, 0, 0, '2019-02-14 15:36:00'),
(312, 'en', 1, 'account', 'account_logout_success', 'You logged out successfully!', '', 0, 0, 0, '2019-02-14 15:36:00'),
(313, 'hu', 1, 'account', 'account_logout_success', 'Sikeres kijelentkezés!', '', 0, 0, 0, '2019-02-14 15:36:00'),
(371, 'en', 0, 'contact', 'form_row_subject', 'Subject', 'form', 0, 0, 0, '2019-02-18 13:05:00'),
(372, 'hu', 0, 'contact', 'form_row_subject', 'Téma', 'form', 0, 0, 0, '2019-02-18 13:05:00'),
(373, 'hu', 0, 'contact', 'form_error_required_pre', 'A(z)', 'form', 0, 0, 0, '2019-02-18 13:05:00'),
(374, 'en', 0, 'contact', 'form_error_required_pre', 'The', 'form', 0, 0, 0, '2019-02-18 13:05:00'),
(375, 'en', 0, 'contact', 'form_error_required_after', 'must be filled!', 'form', 0, 0, 0, '2019-02-18 13:05:00'),
(376, 'hu', 0, 'contact', 'form_error_required_after', 'mező nem lehet üres!', 'form', 0, 0, 0, '2019-02-18 13:05:00'),
(377, 'hu', 0, 'contact', 'form_error_email_not_valid', 'mezőben nem érvényes a megadott e-mail cím!', 'form', 0, 0, 0, '2019-02-18 13:05:00'),
(378, 'en', 0, 'contact', 'form_error_email_not_valid', 'is not valid!', 'form', 0, 0, 0, '2019-02-18 13:05:00'),
(379, 'en', 0, 'contact', 'form_error_some_error_in_fields', 'There was some error while filling the form!', 'form', 0, 0, 0, '2019-02-18 13:05:00'),
(380, 'hu', 0, 'contact', 'form_error_some_error_in_fields', 'Az űrlap kitöltése közben egy vagy több hiba keletkezett!', 'form', 0, 0, 0, '2019-02-18 13:05:00'),
(381, 'hu', 0, 'contact', 'form_mail_send_error', 'Hiba, e-mail nincs elküldve!', 'form', 0, 0, 0, '2019-02-18 13:05:00'),
(382, 'en', 0, 'contact', 'form_mail_send_error', 'Error, mail not sent!', 'form', 0, 0, 0, '2019-02-18 13:05:00'),
(383, 'en', 0, 'contact', 'form_mail_send_success', 'Mail sent,<br />thank you!', 'form', 0, 0, 0, '2019-02-18 13:05:00'),
(384, 'hu', 0, 'contact', 'form_mail_send_success', 'Üzenete elküldve,<br />köszönjük!', 'form', 0, 0, 0, '2019-02-18 13:05:00'),
(385, 'hu', 0, 'sys', 'back_button', 'Vissza', '', 0, 0, 0, '2019-02-18 15:27:00'),
(386, 'hu', 1, 'sys', 'mainpage_tname', 'Főoldal', '', 0, 0, 0, '2019-02-18 15:28:00'),
(387, 'hu', 1, 'sys', 'menutitle_mname', 'Menü', '', 0, 0, 0, '2019-02-18 15:29:00'),
(388, 'en', 0, 'sys', 'date_days_ago', 'days ago', '', 0, 0, 0, '2019-02-18 15:31:00'),
(389, 'hu', 0, 'sys', 'date_days_ago', 'napja', '', 0, 0, 0, '2019-02-18 15:31:00'),
(391, 'en', 0, 'account', 'password_recovery_email_new_pass_get_pretext', 'Someone want to reset your password on our site.', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(392, 'hu', 0, 'account', 'password_recovery_email_new_pass_get_pretext', 'A fenti oldalon valaki egy jelszó helyreállítást kezdeményezett az email címeddel.', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(393, 'hu', 0, 'account', 'password_recovery_email_new_pass_get_link', 'Jelszó helyreállításhoz bökjön ide.', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(394, 'en', 0, 'account', 'password_recovery_email_new_pass_get_link', 'To reset your password click here.', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(395, 'en', 0, 'account', 'password_recovery_email_new_pass_get_afttext', 'This link will live for one hour, if it wasn\'t you, please check your other passwords!', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(396, 'hu', 0, 'account', 'password_recovery_email_new_pass_get_afttext', 'A fenti link egy órán keresztül érvényes!<br />Amennyiben nem te kezdeményezted a helyreállítást, úgy kérlek tekintsd ezt az emailt tárgytalannak!', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(397, 'hu', 0, 'account', 'password_recovery_email_new_pass_get_footer', '', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(398, 'en', 0, 'account', 'password_recovery_email_new_pass_get_footer', '', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(399, 'en', 0, 'account', 'password_recovery_email_title', 'Password recovery', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(400, 'hu', 0, 'account', 'password_recovery_email_title', 'jelszó helyreállítás', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(401, 'hu', 0, 'account', 'password_recovery_email_mail_send_success', 'Az email elküldése sikeres!', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(402, 'en', 0, 'account', 'password_recovery_email_mail_send_success', 'Mail sent!', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(403, 'en', 0, 'account', 'password_recovery_email_mail_send_error', 'Can\'t sent the mail!', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(404, 'hu', 0, 'account', 'password_recovery_email_mail_send_error', 'Az email elküldése sikertelen!', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(405, 'hu', 0, 'account', 'password_recovery_email_send_success_title', 'A helyreállítási email elküldve!', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(406, 'en', 0, 'account', 'password_recovery_email_send_success_title', 'Recovery mail sent!', 'recovery_email', 0, 0, 0, '2019-02-19 02:39:00'),
(446, 'hu', 1, 'admin', 'settings_tabmenu_general', 'Általános', 'settings_page', 0, 0, 0, '2019-02-23 21:50:00'),
(447, 'hu', 1, 'admin', 'settings_tabmenu_security', 'Biztonság', 'settings_page', 0, 0, 0, '2019-02-23 21:50:00'),
(448, 'hu', 1, 'admin', 'settings_tabmenu_user', 'Felhasználók', 'settings_page', 0, 0, 0, '2019-02-23 21:50:00'),
(449, 'hu', 1, 'admin', 'settings_tabmenu_email', 'E-mail', 'settings_page', 0, 0, 0, '2019-02-23 21:50:00'),
(450, 'hu', 1, 'admin', 'settings_tabmenu_seo', 'SEO', 'settings_page', 0, 0, 0, '2019-02-23 21:50:00'),
(451, 'hu', 1, 'admin', 'settings_tabmenu_theme', 'Megjelenés', 'settings_page', 0, 0, 0, '2019-02-23 21:50:00'),
(452, 'hu', 1, 'admin', 'settings_tabmenu_content', 'Tartalom', 'settings_page', 0, 0, 0, '2019-02-23 21:50:00'),
(453, 'hu', 1, 'admin', 'settings_tabmenu_gallery', 'Galéria', 'settings_page', 0, 0, 0, '2019-02-23 21:50:00'),
(454, 'hu', 1, 'admin', 'settings_tabmenu_product', 'Webáruház', 'settings_page', 0, 0, 0, '2019-02-23 21:50:00'),
(455, 'hu', 1, 'admin', 'settings_tabmenu_catalog', 'Katalógus', 'settings_page', 0, 0, 0, '2019-02-23 21:50:00'),
(456, 'hu', 1, 'admin', 'settings_tabmenu_other', 'Egyéb', 'settings_page', 0, 0, 0, '2019-02-23 21:50:00'),
(457, 'hu', 1, 'admin', 'settings_tabmenu_currency', 'Pénznem/Valuta', 'settings_page', 0, 0, 0, '2019-02-23 21:50:00'),
(459, 'hu', 1, 'admin', 'settings_tabmenu_media', 'Médiakezelő', 'settings_page', 0, 0, 0, '2019-02-23 21:50:00'),
(460, 'hu', 1, 'admin', 'settings_row_sitetitle', 'Oldal cím', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(461, 'hu', 1, 'admin', 'settings_row_sitetitle2', 'Oldal alcím (ha használatban van)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(462, 'hu', 1, 'admin', 'settings_row_langtype', 'Az oldal által kezelt nyelvek<br /><small>több nyelv felvitele | jellel elválasztva</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(464, 'hu', 1, 'admin', 'settings_row_langtype_user_default', 'Alapértelmezett külső oldal nyelv', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(465, 'hu', 1, 'admin', 'settings_row_langtype_admin_default', 'Alapértelmeztett admin oldal nyelv', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(466, 'hu', 1, 'admin', 'settings_row_debug', 'Weboldal hibakeresési mód?', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(467, 'hu', 1, 'admin', 'settings_row_def_page', 'Alapértelmezett nyitó statikus oldal (menüpont #ID)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(468, 'hu', 1, 'admin', 'settings_row_error404_load_mainpage', 'Hiányzó tartalom esetén (404es oldal) helyett a rendszer a főoldalt mutassa?', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(469, 'hu', 1, 'admin', 'settings_row_sessionddostime', 'DDOS támadás védelem, idő<br /><small>időlimit a \"támadási kísérletek\" között (másodperc)</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(470, 'hu', 1, 'admin', 'settings_row_sessionddoscount', 'DDOS támadás védelem, db<br /><small>mennyiség limit a \"támadási kísérletek\" között (db szám)</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(471, 'hu', 1, 'admin', 'settings_row_sessionvalue', 'Bejelentkezve maradási idő, <i>másodpercben</i> <small>(session value)</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(472, 'hu', 1, 'admin', 'settings_row_sessionstayloginvalue', 'Bejelentkezve maradási idő \"belépve marad\" checkbox bejelölése esetén, <i>másodpercben</i> <small>(cookie time)</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(473, 'hu', 1, 'admin', 'settings_row_account_local_register', 'Oldal regisztráció mód', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(474, 'hu', 1, 'admin', 'settings_row_registration_term_id', 'Regisztrációs feltételek (Bejegyzés ID)<br /><small>Ha van megadva ID, akkor regisztrációkor a feltétel elfogadása kötelező!<br />Ha nincs megadva ID, akkor nem jelenik meg a regisztrációs formon az erre vonatkozó checkbox!</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(475, 'hu', 1, 'admin', 'settings_row_mail_charset', 'Email karakter kódtábla (ajánlott: utf-8)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(476, 'hu', 1, 'admin', 'settings_row_mail_from', 'Levélfejlécben szereplő alapértelmezett küldő email cím', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(477, 'hu', 1, 'admin', 'settings_row_mail_from_name', 'Levélfejlécben szereplő alapértelmezett küldő név', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(478, 'hu', 1, 'admin', 'settings_row_mail_type', 'Levél küldés típusa', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(479, 'hu', 1, 'admin', 'settings_row_mail_sendmail_root', 'Sendmail ROOT útvonal (sokesetben: \"/usr/bin/sendmail\")', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(480, 'hu', 1, 'admin', 'settings_row_mail_smtp_auth', 'SMTP küldéshez a bejelentkezés kötelező?', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(481, 'hu', 1, 'admin', 'settings_row_mail_smtp_username', 'SMTP felhasználónév', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(482, 'hu', 1, 'admin', 'settings_row_mail_smtp_password', 'SMTP jelszó', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(483, 'hu', 1, 'admin', 'settings_row_mail_smtp_server', 'SMTP szerver', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(484, 'hu', 1, 'admin', 'settings_row_mail_smtp_port', 'SMTP port<br />\n<small>leggyakoribb: 25</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(485, 'hu', 1, 'admin', 'settings_row_mail_smtp_secure', 'SMTP titkosítás mód (ha van)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(486, 'hu', 1, 'admin', 'settings_row_is_seo', 'SEO URL címek használata?', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(487, 'hu', 1, 'admin', 'settings_row_meta_def_auth', 'Alap META tulajdonos', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(488, 'hu', 1, 'admin', 'settings_row_meta_def_desc', 'Alap META leírás', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(489, 'hu', 1, 'admin', 'settings_row_meta_def_key', 'Alap META keresőszavak', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(490, 'hu', 1, 'admin', 'settings_row_google_analytics_code', 'Google Analytics kód<br /><small>Ha elvan helyezve akkor az oldal kódjában elhelyeződik a Google Analytics kód, ami az oldal forgalmának mérésére és elemzésére használható.</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(491, 'hu', 1, 'admin', 'settings_row_seo_link_image', 'Alapértelmezett weboldalkép, ami akkor jelenik meg ha a weboldalt megosztják valamilyen hálózaton (pl. fb, viber, stb..)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(492, 'hu', 1, 'admin', 'settings_row_themeset', 'Oldal megjelenés sablon', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(493, 'hu', 1, 'admin', 'settings_row_admin_themeset', 'Admin oldal megjelenés sablon', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(494, 'hu', 1, 'admin', 'settings_row_pagetitle_style', 'Weboldal böngészőfejléc elrendezés/formátum', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(495, 'hu', 1, 'admin', 'settings_row_article_headerimg_height', 'Tartalom egyedi fejléckép magasság (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(496, 'hu', 1, 'admin', 'settings_row_article_headerimg_width', 'Tartalom egyedi fejléckép szélesség (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(497, 'hu', 1, 'admin', 'settings_row_article_thumbnail_normal_height', 'Tartalom bélyegkép magasság, normál (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(498, 'hu', 1, 'admin', 'settings_row_article_thumbnail_normal_width', 'Tartalom bélyegkép szélesség, normál (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(499, 'hu', 1, 'admin', 'settings_row_article_thumbnail_small_height', 'Tartalom bélyegkép magasság, kicsi (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(500, 'hu', 1, 'admin', 'settings_row_article_thumbnail_small_width', 'Tartalom bélyegkép szélesség, kicsi (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(550, 'hu', 1, 'admin', 'settings_row_gallery_thumbnail_height', 'Galéria bélyegkép magasság (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(551, 'hu', 1, 'admin', 'settings_row_gallery_thumbnail_width', 'Galéria bélyegkép szélesség (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(552, 'hu', 1, 'admin', 'settings_row_product_headerimg_width', 'Termék egyedi fejléckép szélesség (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(553, 'hu', 1, 'admin', 'settings_row_product_headerimg_height', 'Termék egyedi fejléckép magasság (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(554, 'hu', 1, 'admin', 'settings_row_product_thumbnail_normal_height', 'Termék bélyegkép magasság, normál (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(555, 'hu', 1, 'admin', 'settings_row_product_thumbnail_normal_width', 'Termék bélyegkép szélesség, normál (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(556, 'hu', 1, 'admin', 'settings_row_product_thumbnail_small_height', 'Termék bélyegkép magasság, kicsi (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(557, 'hu', 1, 'admin', 'settings_row_product_thumbnail_small_width', 'Termék bélyegkép szélesség, kicsi (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(558, 'hu', 1, 'admin', 'settings_row_catalog_headerimg_width', 'Katalógus termék egyedi fejléckép magasság (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(559, 'hu', 1, 'admin', 'settings_row_catalog_headerimg_height', 'Katalógus termék egyedi fejléckép szélesség (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(560, 'hu', 1, 'admin', 'settings_row_catalog_thumbnail_normal_height', 'Katalógus termék bélyegkép magasság, normál (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(561, 'hu', 1, 'admin', 'settings_row_catalog_thumbnail_normal_width', 'Katalógus termék bélyegkép szélesség, normál (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(562, 'hu', 1, 'admin', 'settings_row_catalog_thumbnail_small_height', 'Katalógus termék bélyegkép magasság, kicsi (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(563, 'hu', 1, 'admin', 'settings_row_catalog_thumbnail_small_width', 'Katalógus termék bélyegkép szélesség, kicsi (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(564, 'hu', 1, 'admin', 'settings_masked_debug_false', 'Hibakeresés és kiírás kikapcsolva', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(565, 'hu', 1, 'admin', 'settings_masked_debug_true', 'Hibakeresés és kiírás engedélyezve', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(566, 'hu', 1, 'admin', 'settings_masked_account_local_register_none', 'A regisztráció kikapcsolva', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(567, 'hu', 1, 'admin', 'settings_masked_account_local_register_normal', 'A felhasználó egyszerűen regisztrálhat az oldalra', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(572, 'hu', 1, 'admin', 'settings_masked_mail_smtp_secure_none', 'nincs titkosítás', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(573, 'hu', 1, 'admin', 'settings_masked_pagetitle_1', '[weboldalcím] - [tartalomcím]', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(574, 'hu', 1, 'admin', 'settings_masked_pagetitle_2', '[tartalomcím] - [weboldalcím]', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(575, 'hu', 1, 'admin', 'settings_masked_pagetitle_3', '[tartalomcím]', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(576, 'hu', 1, 'admin', 'settings_masked_pagetitle_4', '[weboldalcím]', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(577, 'hu', 1, 'admin', 'settings_row_debug_memory', 'Weboldal memóriahasználat kiírása láblécbe<br /><small>Normál használat mellett nem ajánlott</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(578, 'hu', 1, 'admin', 'settings_row_savelog', 'Weboldal használati statisztika mentése adatbázisba<br /><small>Részletes adatrögzítés, nagy adatbázis tárigénnyel rendelkezhet</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(579, 'hu', 1, 'admin', 'settings_row_maintenance', 'Weboldal karbantartási mód bekapcsolása<br /><small>Csak bejelentkezett admin felhasználó tudja elérni a külső oldal tartalmát!</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(580, 'hu', 1, 'admin', 'settings_row_google_recapcha3_key', 'Google ReCapcha3 kulcs (key)<br /><small>amennyiben a kulcs (key) és titkos kulcs (secret) mezői kitöltésre kerülnek, és érvényesek az adatok, úgy az oldal használni fogja a ReCapcha3 védelmet a <b>bejelentkezéskor</b>, <b>Regisztrációkor</b> és <b>Form</b> mezőknél</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(581, 'hu', 1, 'admin', 'settings_row_google_recapcha3_secret', 'Google ReCapcha3 titkos kulcs (secret)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(582, 'hu', 1, 'admin', 'settings_row_fb_enable', 'Facebook bejelentkezés az oldalra<br /><small>api_code és api_secret kitöltése kötelező a működéshez</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(583, 'hu', 1, 'admin', 'settings_row_fb_api_code', 'Facebook api_code', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(584, 'hu', 1, 'admin', 'settings_row_fb_api_secret', 'Facebook api_secret', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(585, 'hu', 1, 'admin', 'settings_row_gp_enable', 'Google bejelentkezés az oldalra<br /><small>api_code és api_secret kitöltése kötelező a működéshez</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(586, 'hu', 1, 'admin', 'settings_row_gp_api_code', 'Google api_code', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(587, 'hu', 1, 'admin', 'settings_row_gp_api_secret', 'Google api_secret', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(588, 'hu', 1, 'admin', 'settings_row_mail_sablon', 'Rendszer e-mail üzenetek sablona<br /><small>alapértelmeztett: default</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(589, 'hu', 1, 'admin', 'settings_row_currency_base', 'Rendszer alapértelmezett pénznem<br /><small>Pl. webáruházban, katalógusban (HUF, USD, EUR)</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(590, 'hu', 1, 'admin', 'settings_row_currency_refreshtime', 'Rendszer pénznem váltóérték frissítés<br /><small>akkor hasznos ha többféle pénznemet kezel az oldal</small>', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(591, 'hu', 1, 'admin', 'settings_row_media_image_max_width', 'Médiakezelő maximális kép szélesség (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(592, 'hu', 1, 'admin', 'settings_row_media_image_max_height', 'Médiakezelő maximális kép magasság (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(593, 'hu', 1, 'admin', 'settings_row_media_thumbnail_normal_height', 'Médiakezelő bélyegkép magasság, normál (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(594, 'hu', 1, 'admin', 'settings_row_media_thumbnail_normal_width', 'Médiakezelő bélyegkép szélesség, normál (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(595, 'hu', 1, 'admin', 'settings_row_media_thumbnail_small_height', 'Médiakezelő bélyegkép magasság, kicsi (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(596, 'hu', 1, 'admin', 'settings_row_media_thumbnail_small_width', 'Médiakezelő bélyegkép szélesség, kicsi (pixelben)', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(597, 'hu', 1, 'admin', 'settings_mname', 'Rendszer beállítások', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(599, 'hu', 1, 'admin', 'settings_tname', 'Rendszer beállítások', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(600, 'hu', 1, 'admin', 'support_tname', 'Támogatás', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(601, 'hu', 1, 'admin', 'main_mname', 'Főoldal', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(603, 'hu', 1, 'admin', 'support_mname', 'Támogatás', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(604, 'hu', 1, 'admin', 'settings_message_save_success', 'Sikeres mentés', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(605, 'hu', 1, 'admin', 'settings_message_save_error_in_db', 'Belső hiba!<br />Sikertelen mentés :(', 'settings_page', 0, 0, 0, '2019-02-23 23:31:00'),
(606, 'hu', 0, 'admin', 'dashboard_text', 'Vezérlőpult', 'settings_page', 0, 0, 0, '2019-02-24 20:08:00'),
(607, 'hu', 0, 'admin', 'profile_text', 'Adatlapom szerkesztése', 'settings_page', 0, 0, 0, '2019-02-24 20:08:00'),
(608, 'hu', 0, 'admin', 'logout_text', 'Kijelentkezés', 'settings_page', 0, 0, 0, '2019-02-24 20:08:00'),
(609, 'hu', 1, 'admin', 'settings_row_admin_themeset_color', 'Admin oldal megjelenési sablon színvilág', 'settings_page', 0, 0, 0, '2019-02-24 21:40:00'),
(610, 'hu', 0, 'admin', 'website_maintenance_text', 'Figyelem! A karbantartási mód be van kapcsolva!', '', 0, 0, 0, '2019-02-24 22:50:00'),
(611, 'hu', 1, 'admin', 'settings_row_php_set_time_limit', 'PHP Execute time limit<br /><small>másodpercben</small>', 'settings_page', 0, 0, 0, '2019-02-25 00:20:00'),
(612, 'hu', 0, 'sys', 'error_error404_title', '404 hiba - a keresett lap nem található...', '', 0, 0, 0, '2019-02-25 02:03:00'),
(613, 'hu', 0, 'sys', 'error_error404_title2', '404 hiba, a keresett lap nem található!', '', 0, 0, 0, '2019-02-25 02:03:00'),
(614, 'hu', 0, 'sys', 'error_error404_text', 'Az ön által keresett oldal nem létezik, vagy az elérése megváltozott.', '', 0, 0, 0, '2019-02-25 02:03:00'),
(615, 'en', 0, 'sys', 'error_error404_text', 'The page you try to reach, is not available, or changed.', '', 0, 0, 0, '2019-02-25 02:03:00'),
(616, 'en', 0, 'sys', 'error_error404_title2', '404 error!', '', 0, 0, 0, '2019-02-25 02:03:00'),
(617, 'en', 0, 'sys', 'error_error404_title', '404 error - page not found...', '', 0, 0, 0, '2019-02-25 02:03:00'),
(619, 'en', 0, 'sys', 'error_error403_title2', '403 error, you can\'t access to this page!', '', 0, 0, 0, '2019-02-25 02:03:00'),
(620, 'en', 0, 'sys', 'error_error403_text', 'You don\'t have permission.', '', 0, 0, 0, '2019-02-25 02:03:00'),
(621, 'hu', 0, 'sys', 'error_error403_text', 'Ön egy olyan területre próbált belépni, amihez nincs hozzáférése.', '', 0, 0, 0, '2019-02-25 02:03:00'),
(622, 'hu', 0, 'sys', 'error_error403_title2', '403 hiba, a kért oldalhoz a hozzáférés tiltott!', '', 0, 0, 0, '2019-02-25 02:03:00'),
(623, 'hu', 0, 'sys', 'error_error403_title', '403 hiba - illetéktelen hozzáférés', '', 0, 0, 0, '2019-02-25 02:03:00'),
(624, 'en', 0, 'sys', 'error_error403_title', '403 error - Permission denied.', '', 0, 0, 0, '2019-02-25 02:03:00'),
(625, 'hu', 0, 'sys', 'error_error429_text', 'Kérem próbálja újra később!', '', 0, 0, 0, '2019-02-25 02:03:00'),
(626, 'hu', 0, 'sys', 'error_error429_title2', '429 hiba, túl sok egyidőben kezdeményezett kapcsolat!', '', 0, 0, 0, '2019-02-25 02:03:00'),
(627, 'hu', 0, 'sys', 'error_error429_title', '429 hiba - túl sok kapcsolat', '', 0, 0, 0, '2019-02-25 02:03:00'),
(628, 'en', 0, 'sys', 'error_error429_title', '429 error - too many connections', '', 0, 0, 0, '2019-02-25 02:03:00'),
(629, 'en', 0, 'sys', 'error_error429_title2', '429 errors, too many initiated connections!', '', 0, 0, 0, '2019-02-25 02:03:00'),
(630, 'en', 0, 'sys', 'error_error429_text', 'Please try again later!', '', 0, 0, 0, '2019-02-25 02:03:00'),
(631, 'hu', 1, 'admin', 'settings_row_admin_headerbar', 'Admin menedzsment fejléc<br><small>Bootstrap4-et igényel, néhány templatevel ütközhet!</small>', 'settings_page', 0, 0, 0, '2019-03-04 16:06:00'),
(632, 'hu', 1, 'admin', 'update_mname', 'Verzió frissítés', '', 0, 0, 0, '2019-03-14 01:02:00'),
(633, 'hu', 1, 'admin', 'update_tname', 'Verzió frissítés', '', 0, 0, 0, '2019-03-14 01:02:00'),
(678, 'hu', 1, 'api', 'main_tname', 'API', 'api', 0, 0, 0, '2019-05-03 09:05:00'),
(679, 'hu', 1, 'api', 'main_mname', 'API', 'api', 0, 0, 0, '2019-05-03 09:05:00'),
(680, 'hu', 1, 'admin', 'settings_row_error403_user_login', 'Nem megfelelő jogosultság esetén, ha belépéssel jogosultság szerezhető a tartalomhoz akkor, mutassa a bejelentkező/regisztrációs formot!', 'settings_page', 0, 0, 0, '2019-05-03 19:34:00'),
(681, 'hu', 1, 'admin', 'settings_row_login_fb_enable', 'Facebook bejelentkezés', 'settings_page', 0, 0, 0, '2019-05-03 19:35:00'),
(682, 'hu', 1, 'admin', 'settings_row_login_fb_api_code', 'Facebook API kód (api_code)', 'settings_page', 0, 0, 0, '2019-05-03 19:35:00'),
(683, 'hu', 1, 'admin', 'settings_row_login_fb_api_secret', 'Facebook API titkos kulcs (api_secret)', 'settings_page', 0, 0, 0, '2019-05-03 19:35:00'),
(684, 'hu', 1, 'admin', 'settings_row_login_gp_api_secret', 'Google API titkos kulcs (api_secret)', 'settings_page', 0, 0, 0, '2019-05-03 19:35:00'),
(685, 'hu', 1, 'admin', 'settings_row_login_gp_api_code', 'Google API kód (api_code)', 'settings_page', 0, 0, 0, '2019-05-03 19:35:00'),
(686, 'hu', 1, 'admin', 'settings_row_login_gp_enable', 'Google bejelentkezés', 'settings_page', 0, 0, 0, '2019-05-03 19:35:00'),
(687, 'hu', 1, 'admin', 'settings_row_catalog_image_max_width', 'Katalógus termék kép maximális szélesség (pixelben)', 'settings_page', 0, 0, 0, '2019-05-03 19:40:00'),
(688, 'hu', 1, 'admin', 'settings_row_catalog_image_max_height', 'Katalógus termék kép maximális magasság (pixelben)', 'settings_page', 0, 0, 0, '2019-05-03 19:40:00'),
(689, 'hu', 1, 'admin', 'settings_row_account_api_url', 'API url', 'settings_page', 0, 0, 0, '2019-05-03 19:55:00'),
(690, 'hu', 1, 'admin', 'settings_row_account_api_key', 'API kulcs (api_key)', 'settings_page', 0, 0, 0, '2019-05-03 19:55:00'),
(691, 'hu', 1, 'admin', 'settings_row_account_api_secret', 'API titkos kulcs (api_secret)', 'settings_page', 0, 0, 0, '2019-05-03 19:55:00'),
(692, 'hu', 1, 'admin', 'settings_row_account_login_type', 'Szerver felhasználókezelés<br><small>(nem ajánlott kikapcsolni ha nincs aktiválva más bejelentkezési mód!)</small>', 'settings_page', 0, 0, 0, '2019-05-06 02:11:00'),
(693, 'hu', 1, 'admin', 'settings_row_account_local_activation', 'Felhasználó aktiválás (lokális)', 'settings_page', 0, 0, 0, '2019-05-06 02:11:00'),
(694, 'hu', 1, 'admin', 'settings_masked_no_activation', 'Nem kell aktiválni', 'settings_page', 0, 0, 0, '2019-05-06 02:13:00'),
(695, 'hu', 1, 'admin', 'settings_masked_email_activation', 'Email aktiválás', 'settings_page', 0, 0, 0, '2019-05-06 02:13:00'),
(696, 'hu', 1, 'admin', 'settings_masked_admin_activation', 'Admin aktiválás', 'settings_page', 0, 0, 0, '2019-05-06 02:13:00'),
(697, 'hu', 1, 'admin', 'settings_masked_true', 'Igen', 'settings_page', 0, 0, 0, '2019-05-06 02:13:00'),
(698, 'hu', 1, 'admin', 'settings_masked_false', 'Nem', 'settings_page', 0, 0, 0, '2019-05-06 02:13:00'),
(699, 'hu', 1, 'admin', 'settings_row_account_local_invite', 'Felhasználó meghívás', 'settings_page', 0, 0, 0, '2019-05-06 02:39:00'),
(700, 'hu', 1, 'admin', 'settings_masked_account_local_invite_none', 'Nincs meghívó rendszer', 'settings_page', 0, 0, 0, '2019-05-06 02:41:00'),
(701, 'hu', 1, 'admin', 'settings_masked_account_local_invite_user', 'A felhasználók meghívhatnak másokat', 'settings_page', 0, 0, 0, '2019-05-06 02:41:00'),
(702, 'hu', 1, 'admin', 'settings_masked_account_local_invite_admin', 'Csak admin hívhat meg másokat', 'settings_page', 0, 0, 0, '2019-05-06 02:41:00'),
(703, 'hu', 0, 'api', 'login_facebook_button', 'Belépés Facebookal', '', 0, 0, 0, '2019-05-06 20:31:00'),
(704, 'en', 0, 'api', 'login_facebook_button', 'Login with Facebook', '', 0, 0, 0, '2019-05-06 20:31:00'),
(705, 'hu', 1, 'admin', 'settings_row_login_gp_api_name', 'Alkalmazás név', 'settings_page', 0, 0, 0, '2019-05-07 13:18:00'),
(706, 'hu', 0, 'api', 'login_google_button', 'Belépés Google fiókkal', '', 0, 0, 0, '2019-05-07 13:28:00'),
(707, 'en', 0, 'api', 'login_google_button', 'Sign in with Google', '', 0, 0, 0, '2019-05-07 13:28:00'),
(708, 'hu', 1, 'menu', 'menupoint_account_title', 'Felhasználó elemek', 'menu', 0, 0, 0, '2019-05-08 15:02:00'),
(709, 'hu', 1, 'menu', 'menupoint_account_forgott_password_name', 'Elfelejtett jelszó', 'menu', 0, 0, 0, '2019-05-08 15:02:00'),
(710, 'hu', 1, 'menu', 'menupoint_account_forgott_password_edit_title', 'Elfelejtett jelszó menüpont', 'menu', 0, 0, 0, '2019-05-08 15:02:00'),
(711, 'hu', 1, 'menu', 'menupoint_account_login_name', 'Bejelentkezés', 'menu', 0, 0, 0, '2019-05-08 15:02:00'),
(712, 'hu', 1, 'menu', 'menupoint_account_login_edit_title', 'Bejelentkezés menüpont', 'menu', 0, 0, 0, '2019-05-08 15:02:00'),
(713, 'hu', 1, 'menu', 'menupoint_account_logout_name', 'Kijelentkezés', 'menu', 0, 0, 0, '2019-05-08 15:02:00'),
(714, 'hu', 1, 'menu', 'menupoint_account_logout_edit_title', 'Kijelentkezés menüpont', 'menu', 0, 0, 0, '2019-05-08 15:02:00'),
(715, 'hu', 1, 'menu', 'menupoint_account_registration_name', 'Regisztráció', 'menu', 0, 0, 0, '2019-05-08 15:02:00'),
(716, 'hu', 1, 'menu', 'menupoint_account_registration_edit_title', 'Regisztráció menüpont', 'menu', 0, 0, 0, '2019-05-08 15:02:00'),
(717, 'hu', 1, 'menu', 'menupoint_account_settings_name', 'Beállítások', 'menu', 0, 0, 0, '2019-05-08 15:02:00'),
(718, 'hu', 1, 'menu', 'menupoint_account_settings_edit_title', 'Beállítások menüpont', 'menu', 0, 0, 0, '2019-05-08 15:02:00'),
(719, 'hu', 1, 'menu', 'menupoint_article_article_edit_title', 'Bejegyzés menüpont', 'menu', 0, 0, 0, '2019-05-08 15:02:00'),
(720, 'hu', 1, 'menu', 'menupoint_article_article_category_edit_title', 'Bejegyzés kategória (hír rendezés) menüpont', 'menu', 0, 0, 0, '2019-05-08 15:02:00'),
(721, 'hu', 1, 'menu', 'menupoint_menu_html_edit_title', 'Külső oldal menüpont', 'menu', 0, 0, 0, '2019-05-08 15:02:00'),
(722, 'en', 1, 'admin', 'settings_row_sitetitle', 'Site title', 'settings_page', 0, 0, 0, '2019-05-09 03:15:00'),
(723, 'hu', 1, 'admin', 'settings_masked_account_local_register_invitation', 'Csak meghívásra', 'settings_page', 0, 0, 0, '2019-05-10 13:18:00'),
(724, 'hu', 1, 'admin', 'settings_masked_account_login_none', 'Kikapcsolva (nem ajánlott!)', 'settings_page', 0, 0, 0, '2019-05-11 02:08:00'),
(725, 'hu', 1, 'admin', 'settings_masked_account_login_local', 'Helyi', 'settings_page', 0, 0, 0, '2019-05-11 02:08:00'),
(726, 'hu', 1, 'admin', 'settings_masked_account_login_api', 'API (távoli szerver)', 'settings_page', 0, 0, 0, '2019-05-11 02:08:00'),
(727, 'hu', 1, 'admin', 'settings_header_row_user_local', '', 'settings_page', 0, 0, 0, '2019-05-11 02:15:00'),
(728, 'hu', 1, 'admin', 'settings_header_row_user_api', '<h4>Api adatok</h4>', 'settings_page', 0, 0, 0, '2019-05-11 02:15:00'),
(729, 'hu', 0, 'account', 'button_login', 'Belépés', '', 0, 0, 0, '2019-05-16 13:47:00'),
(738, 'en', 0, 'account', 'button_login', 'Log in', '', 0, 0, 0, '2019-05-16 13:47:00'),
(739, 'en', 0, 'account', 'error_username_empty', 'Username must be filled!', '', 0, 0, 0, '2019-05-16 13:47:00'),
(740, 'hu', 0, 'account', 'error_username_empty', 'E-mail cím nem lehet üres!', '', 0, 0, 0, '2019-05-16 13:47:00'),
(741, 'hu', 0, 'account', 'error_userpassword_empty', 'Jelszó nem lehet üres!', '', 0, 0, 0, '2019-05-16 13:47:00'),
(742, 'en', 0, 'account', 'error_userpassword_empty', 'Password must be filled!', '', 0, 0, 0, '2019-05-16 13:47:00'),
(743, 'en', 0, 'account', 'error_login_invalid', 'Wrong username or password!', '', 0, 0, 0, '2019-05-16 13:47:00'),
(744, 'hu', 0, 'account', 'error_login_invalid', 'Hibás e-mail vagy jelszó!', '', 0, 0, 0, '2019-05-16 13:47:00'),
(745, 'hu', 0, 'account', 'success_login', 'Sikeres bejelentkezés', '', 0, 0, 0, '2019-05-16 13:47:00'),
(746, 'en', 0, 'account', 'success_login', 'You log in successfully', '', 0, 0, 0, '2019-05-16 13:47:00'),
(747, 'en', 0, 'account', 'success_logout', 'Log in was unsuccessful!', '', 0, 0, 0, '2019-05-16 13:47:00'),
(748, 'hu', 0, 'account', 'success_logout', 'Sikeres kijelentkezés!', '', 0, 0, 0, '2019-05-16 13:47:00'),
(749, 'hu', 0, 'account', 'error_logout', 'Sikertelen kijelentkezés!', '', 0, 0, 0, '2019-05-16 13:47:00'),
(750, 'en', 0, 'account', 'error_logout', 'unsuccessful log out!', '', 0, 0, 0, '2019-05-16 13:47:00'),
(751, 'en', 0, 'account', 'button_login_api', 'Login with API', '', 0, 0, 0, '2019-05-16 13:47:00'),
(752, 'hu', 0, 'account', 'button_login_api', 'Belépés API-n keresztül', '', 0, 0, 0, '2019-05-16 13:47:00'),
(753, 'hu', 0, 'account', 'username', 'E-mail', '', 0, 0, 0, '2019-05-19 18:54:00'),
(754, 'en', 0, 'account', 'username', 'E-mail', '', 0, 0, 0, '2019-05-19 18:54:00'),
(755, 'en', 0, 'account', 'welcome', 'Welcome To Login', '', 0, 0, 0, '2019-05-19 18:54:00'),
(756, 'hu', 0, 'account', 'welcome', 'Kérem jelentkezzen be', '', 0, 0, 0, '2019-05-19 18:54:00'),
(757, 'hu', 1, 'language', 'main_tname', 'Nyelv', '', 0, 0, 0, '2019-05-30 14:03:29'),
(759, 'hu', 1, 'language', 'main_mname', 'Nyelv', '', 0, 0, 0, '2019-05-30 14:03:37'),
(760, 'hu', 1, 'language', 'list_mname', 'Lista', '', 0, 0, 0, '2019-05-30 14:03:37'),
(761, 'hu', 1, 'language', 'missing_mname', 'Hiányzó fordítások', '', 0, 0, 0, '2019-05-30 14:03:37'),
(762, 'hu', 1, 'language', 'predict_mname', 'Hiányzó nyelvi fájl', '', 0, 0, 0, '2019-05-30 14:03:37'),
(845, 'hu', 1, 'language', 'predict_tname', 'Hiányzó nyelvi fájl', '', 0, 0, 0, '2019-05-30 14:28:24'),
(848, 'hu', 1, 'language', 'list_tname', 'Lista', '', 0, 0, 0, '2019-05-30 14:28:30'),
(852, 'hu', 1, 'language', 'missing_tname', 'Hiányzó fordítások', '', 0, 0, 0, '2019-05-30 14:31:19'),
(853, 'hu', 1, 'language', 'deprecated_mname', 'Visszavonás alatti szövegek', '', 1, 0, 0, '2019-05-30 17:56:28'),
(854, 'hu', 1, 'language', 'deprecated_tname', 'Visszavonás alatti szövegek', '', 1, 0, 0, '2019-05-30 17:56:32'),
(855, 'hu', 1, 'language', 'new', 'Új szöveg felvitele', '', 1, 0, 0, '2019-05-30 17:56:41'),
(856, 'hu', 1, 'language', 'new_tname', 'Új szöveg felvitele', '', 1, 0, 0, '2019-05-30 17:59:12'),
(857, 'hu', 1, 'language', 'list_main_id', '#ID', '', 0, 0, 0, '2019-05-30 18:28:59'),
(858, 'hu', 1, 'language', 'list_main_module', 'module', '', 0, 0, 0, '2019-05-30 18:28:59'),
(859, 'hu', 1, 'language', 'list_main_constant', 'constant', '', 0, 0, 0, '2019-05-30 18:28:59'),
(860, 'hu', 1, 'language', 'list_main_text', 'text', '', 0, 0, 0, '2019-05-30 18:28:59'),
(861, 'hu', 1, 'language', 'list_main_admin', 'admin?', '', 0, 0, 0, '2019-05-30 18:28:59'),
(862, 'hu', 1, 'language', 'list_main_translate_need', 'fordítandó?', '', 0, 0, 0, '2019-05-30 18:28:59'),
(863, 'hu', 1, 'language', 'list_main_filter_text', 'Szűrés', '', 1, 0, 0, '2019-05-31 12:24:35'),
(864, 'hu', 1, 'language', 'list_main_filter_language', 'Nyelv', '', 1, 0, 0, '2019-05-31 16:53:39'),
(865, 'hu', 1, 'language', 'list_main_filter_language_all', '-- Mind --', '', 0, 0, 0, '2019-05-31 16:53:39'),
(866, 'hu', 1, 'language', 'list_main_filter_module', 'Modul', '', 0, 0, 0, '2019-05-31 17:02:14'),
(867, 'hu', 1, 'language', 'list_main_filter_module_all', '-- Mind --', '', 0, 0, 0, '2019-05-31 17:02:14'),
(868, 'hu', 1, 'language', 'list_main_filter_admin', 'Admin?', '', 0, 0, 0, '2019-05-31 17:07:27'),
(869, 'hu', 1, 'language', 'list_main_filter_admin_all', '-- Mind --', '', 0, 0, 0, '2019-05-31 17:07:27'),
(870, 'hu', 1, 'language', 'list_main_filter_admin_none', 'Nem', '', 0, 0, 0, '2019-05-31 17:07:27'),
(871, 'hu', 1, 'language', 'list_main_filter_admin_yes', 'Igen', '', 0, 0, 0, '2019-05-31 17:07:27'),
(872, 'hu', 1, 'language', 'list_main_filter_debugger', 'Debugger általi találat?', '', 0, 0, 0, '2019-05-31 17:12:16'),
(873, 'hu', 1, 'language', 'list_main_filter_debugger_all', '-- Mind --', '', 0, 0, 0, '2019-05-31 17:12:16'),
(874, 'hu', 1, 'language', 'list_main_filter_debugger_none', 'Nem', '', 0, 0, 0, '2019-05-31 17:12:16'),
(875, 'hu', 1, 'language', 'list_main_filter_debugger_yes', 'Igen', '', 0, 0, 0, '2019-05-31 17:12:16'),
(876, 'hu', 1, 'language', 'list_main_filter_translate', 'Fordítandó?', '', 0, 0, 0, '2019-05-31 17:12:16'),
(877, 'hu', 1, 'language', 'list_main_filter_translate_all', '-- Mind --', '', 0, 0, 0, '2019-05-31 17:12:16'),
(878, 'hu', 1, 'language', 'list_main_filter_translate_none', 'Nem', '', 0, 0, 0, '2019-05-31 17:12:16');
INSERT INTO `cb_language` (`id`, `lang`, `is_admin`, `module`, `constant`, `text`, `tag`, `debugger_predicted`, `translate_need`, `deprecated`, `date_create`) VALUES
(879, 'hu', 1, 'language', 'list_main_filter_translate_yes', 'Igen', '', 0, 0, 0, '2019-05-31 17:12:16'),
(880, 'hu', 1, 'language', 'list_main_language', 'Nyelv', '', 0, 0, 0, '2019-06-03 15:37:58'),
(881, 'hu', 1, 'language', 'list_empty', 'Sajnálom a keresési feltételeknek nincs megfelelő elem :(', '', 0, 0, 0, '2019-06-03 17:03:25'),
(882, 'hu', 1, 'language', 'edit_tname', 'Szöveg szerkesztése', '', 0, 0, 0, '2019-06-03 18:10:42'),
(883, 'hu', 1, 'language', 'save', 'Mentés', '', 0, 0, 0, '2019-06-03 18:51:34'),
(884, 'hu', 1, 'language', 'save_and_new', 'Mentés és új', '', 0, 0, 0, '2019-06-03 18:51:34'),
(885, 'hu', 1, 'language', 'save_and_next', 'Mentés és következő fordítandó', '', 0, 0, 0, '2019-06-03 18:51:34'),
(886, 'hu', 1, 'language', 'save_and_exit', 'Mentés és kilépés', '', 0, 0, 0, '2019-06-03 18:51:34'),
(887, 'hu', 1, 'language', 'delete', 'Szöveg törlése', '', 0, 0, 0, '2019-06-03 19:00:17'),
(888, 'hu', 1, 'language', 'edit_selector_language', 'Nyelv', '', 0, 0, 0, '2019-06-03 19:22:47'),
(889, 'hu', 1, 'language', 'edit_selector_language_please_select', '-- Kérem válasszon --', '', 0, 0, 0, '2019-06-03 19:22:47'),
(890, 'hu', 1, 'language', 'edit_selector_admin', 'Admin?', '', 0, 0, 0, '2019-06-03 19:22:47'),
(891, 'hu', 1, 'language', 'edit_selector_admin_please_select', '-- Kérem válasszon --', '', 0, 0, 0, '2019-06-03 19:22:47'),
(892, 'hu', 1, 'language', 'edit_selector_admin_none', 'Nem', '', 0, 0, 0, '2019-06-03 19:22:47'),
(893, 'hu', 1, 'language', 'edit_selector_admin_yes', 'Igen', '', 0, 0, 0, '2019-06-03 19:22:47'),
(894, 'hu', 1, 'language', 'edit_selector_module', 'Modul', '', 0, 0, 0, '2019-06-03 19:22:47'),
(895, 'hu', 1, 'language', 'edit_selector_module_please_select', '-- Kérem válasszon --', '', 0, 0, 0, '2019-06-03 19:22:47'),
(896, 'hu', 1, 'language', 'edit_selector_constant', 'Változó', '', 0, 0, 0, '2019-06-03 19:22:47'),
(897, 'hu', 1, 'language', 'edit_selector_text', 'Szöveg', '', 0, 0, 0, '2019-06-03 19:22:47'),
(902, 'hu', 1, 'language', 'edit_selector_translate', 'Fordítandó szöveg?', '', 0, 0, 0, '2019-06-03 19:22:47'),
(903, 'hu', 1, 'language', 'edit_selector_translate_please_select', '-- Kérem válasszon --', '', 0, 0, 0, '2019-06-03 19:22:47'),
(904, 'hu', 1, 'language', 'edit_selector_translate_none', 'Nem', '', 0, 0, 0, '2019-06-03 19:22:47'),
(905, 'hu', 1, 'language', 'edit_selector_translate_yes', 'Igen', '', 0, 0, 0, '2019-06-03 19:22:47'),
(906, 'hu', 1, 'language', 'message_save_success', 'Sikeres mentés', '', 0, 0, 0, '2019-06-05 02:51:34'),
(907, 'hu', 1, 'language', 'edit_selector_debugger', 'Debugger általi találat?', '', 0, 0, 0, '2019-06-05 03:09:14'),
(908, 'hu', 1, 'language', 'edit_selector_debugger_please_select', '-- Kérem válasszon --', '', 0, 0, 0, '2019-06-05 03:09:14'),
(909, 'hu', 1, 'language', 'edit_selector_debugger_none', 'Nem', '', 0, 0, 0, '2019-06-05 03:09:14'),
(910, 'hu', 1, 'language', 'edit_selector_debugger_yes', 'Igen', '', 0, 0, 0, '2019-06-05 03:09:14'),
(912, 'hu', 1, 'language', 'jump', 'Ugrás a következő fordítandóra', '', 0, 0, 0, '2019-06-05 03:22:54'),
(913, 'hu', 1, 'language', 'edit_selector_otherlanguage', 'Más nyelvek fordítása', '', 0, 0, 0, '2019-06-10 13:56:47'),
(914, 'en', 1, 'account', 'fist_login_redirect', 'First login redirect', '', 0, 0, 0, '2019-06-26 00:00:00'),
(915, 'hu', 1, 'account', 'fist_login_redirect', 'Első bejelentkezés átirányítás', '', 0, 0, 0, '2019-06-26 00:00:00'),
(916, 'hu', 1, 'admin', 'settings_row_registration_form', 'Regisztrációs form (sablon méret)', 'settings_page', 0, 0, 0, '2019-06-27 01:20:00'),
(917, 'hu', 1, 'admin', 'settings_masked_account_register_form_normal', 'Normál form (részletes adatmegadás)', 'settings_page', 0, 0, 0, '2019-06-27 01:21:00'),
(918, 'hu', 1, 'admin', 'settings_masked_account_register_form_mini', 'Minimális form (csak email és jelszó)', 'settings_page', 0, 0, 0, '2019-06-27 01:21:00'),
(919, 'hu', 0, 'account', 'password', 'Jelszó', '', 0, 0, 0, '2019-06-11 20:19:08'),
(920, 'hu', 0, 'account', 'remember_me', 'Felhasználó megjegyzése', '', 0, 0, 0, '2019-06-11 20:19:08'),
(921, 'hu', 0, 'account', 'button_registration', 'Regisztráció', '', 0, 0, 0, '2019-06-12 01:10:35'),
(922, 'hu', 0, 'account', 'button_forgotpassword', 'Elfelejtett jelszó', '', 0, 0, 0, '2019-06-11 20:19:08'),
(1236, 'la', 0, 'module', 'constant', 'text', 'tag', 0, 0, 0, '0000-00-00 00:00:00'),
(1605, 'hu', 1, 'menu', 'menupoint_trading_exchange_edit_title', 'Trading exchange menüpont szerkesztés', '', 0, 0, 0, '2019-06-07 13:14:00'),
(1670, 'en', 0, 'account', 'registration_title', 'Register', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1671, 'en', 0, 'account', 'firstname', 'First name', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1672, 'en', 0, 'account', 'firstname_title', 'First name', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1673, 'en', 0, 'account', 'firstname_example', '', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1674, 'en', 0, 'account', 'firstname_helptext', '', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1675, 'en', 0, 'account', 'lastname', 'Last name', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1676, 'en', 0, 'account', 'lastname_title', 'Last name', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1677, 'en', 0, 'account', 'lastname_example', '', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1678, 'en', 0, 'account', 'lastname_helptext', '', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1679, 'en', 0, 'account', 'displayname', 'Display name', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1680, 'en', 0, 'account', 'displayname_title', 'Display name', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1681, 'en', 0, 'account', 'displayname_example', '', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1682, 'en', 0, 'account', 'displayname_helptext', '', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1683, 'en', 0, 'account', 'email', 'E-mail', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1684, 'en', 0, 'account', 'email_title', 'E-mail', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1685, 'en', 0, 'account', 'email_example', 'Your email', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1686, 'en', 0, 'account', 'email_helptext', 'The address must be valid, this will be the address where the activation mail will be send.', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1687, 'en', 0, 'account', 'emailreply', 'E-mail address repeat', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1688, 'en', 0, 'account', 'emailreply_title', 'E-mail address repeat', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1689, 'en', 0, 'account', 'emailreply_example', 'Your email', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1690, 'en', 0, 'account', 'emailreply_helptext', 'Please type your address again', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1691, 'en', 0, 'account', 'password', 'Password', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1692, 'en', 0, 'account', 'password_title', 'Password', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1693, 'en', 0, 'account', 'password_example', 'minimum 8 character', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1694, 'en', 0, 'account', 'password_helptext', '', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1695, 'en', 0, 'account', 'passwordreply', 'Confirm Password', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1696, 'en', 0, 'account', 'passworreplyd_title', 'Confirm Password', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1697, 'en', 0, 'account', 'passwordreply_example', 'minimum 8 character', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1698, 'en', 0, 'account', 'passwordreply_helptext', '', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1699, 'en', 0, 'account', 'userregistration_button', 'SignUp', '', 0, 0, 0, '2019-06-11 20:13:26'),
(1700, 'en', 0, 'account', 'button_forgotpassword', 'Recover Password', '', 0, 0, 0, '2019-06-11 20:17:58'),
(1703, 'en', 0, 'account', 'button_registration', 'Registration', '', 0, 0, 0, '2019-06-11 20:19:08'),
(1705, 'hu', 0, 'account', 'registration_title', 'Regisztráció', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1706, 'hu', 0, 'account', 'firstname', 'Utónév', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1707, 'hu', 0, 'account', 'firstname_title', 'Utónév', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1708, 'hu', 0, 'account', 'firstname_example', '', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1709, 'hu', 0, 'account', 'firstname_helptext', '', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1710, 'hu', 0, 'account', 'lastname', 'Vezetéknév', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1711, 'hu', 0, 'account', 'lastname_title', 'Vezetéknév', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1712, 'hu', 0, 'account', 'lastname_example', '', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1713, 'hu', 0, 'account', 'lastname_helptext', '', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1714, 'hu', 0, 'account', 'displayname', 'Megjelenő név', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1715, 'hu', 0, 'account', 'displayname_title', 'Megjelenő név', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1716, 'hu', 0, 'account', 'displayname_example', '', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1717, 'hu', 0, 'account', 'displayname_helptext', '', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1718, 'hu', 0, 'account', 'email', 'E-mail cím', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1719, 'hu', 0, 'account', 'email_title', 'E-mail cím', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1720, 'hu', 0, 'account', 'email_example', 'example@mail.com', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1721, 'hu', 0, 'account', 'email_helptext', 'A címnek valódinak kell lennie, egyben ez lesz a felhasználónév, és bejelentkezéskor is az e-mail címet kell használni', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1722, 'hu', 0, 'account', 'emailreply', 'E-mail cím ellenőrzés', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1723, 'hu', 0, 'account', 'emailreply_title', 'E-mail cím ellenőrzés', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1724, 'hu', 0, 'account', 'emailreply_example', 'example@mail.com', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1725, 'hu', 0, 'account', 'emailreply_helptext', 'Az e-mail cím helyességének ellenőrzése céljából, kérjük írja be mégegyszer a címét', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1726, 'hu', 0, 'account', 'password_title', 'Jelszó', '', 0, 0, 0, '2019-06-11 20:19:17'),
(1727, 'hu', 0, 'account', 'password_example', 'minimum 8 betű és szám', '', 0, 0, 0, '2019-06-11 20:19:18'),
(1728, 'hu', 0, 'account', 'password_helptext', '', '', 0, 0, 0, '2019-06-11 20:19:18'),
(1729, 'hu', 0, 'account', 'passwordreply', 'Jelszó ellenőrzés', '', 0, 0, 0, '2019-06-11 20:19:18'),
(1730, 'hu', 0, 'account', 'passworreplyd_title', 'Jelszó ellenőrzés', '', 0, 0, 0, '2019-06-11 20:19:18'),
(1731, 'hu', 0, 'account', 'passwordreply_example', 'minimum 8 betű és szám', '', 0, 0, 0, '2019-06-11 20:19:18'),
(1732, 'hu', 0, 'account', 'passwordreply_helptext', '', '', 0, 0, 0, '2019-06-11 20:19:18'),
(1733, 'hu', 0, 'account', 'userregistration_button', 'Regisztrálok', '', 0, 0, 0, '2019-06-11 20:19:18'),
(1734, 'en', 0, 'account', 'require_checkbox_helptext', '', '', 0, 0, 0, '2019-06-12 00:27:18'),
(1735, 'hu', 0, 'account', 'require_checkbox_helptext', '', '', 0, 0, 0, '2019-06-12 00:27:34'),
(1736, 'en', 0, 'account', 'require_checkbox', 'I agree to the terms of services', '', 0, 0, 0, '2019-06-12 00:29:19'),
(1737, 'en', 0, 'account', 'require_checkbox_i_reading', 'Read Terms and Conditions', '', 0, 0, 0, '2019-06-12 00:29:19'),
(1738, 'hu', 0, 'account', 'require_checkbox', 'A felhasználói feltételeket elfogadom', '', 0, 0, 0, '2019-06-12 00:29:27'),
(1739, 'hu', 0, 'account', 'require_checkbox_i_reading', 'A felhasználói feltételek elolvasása', '', 0, 0, 0, '2019-06-12 00:29:27'),
(1741, 'en', 0, 'account', 'registration_error_email_empty', 'The email address is empty, please fill it', '', 0, 0, 0, '2019-06-12 01:29:13'),
(1742, 'en', 0, 'account', 'registration_error_password_empty', 'The password is empty, please fill it', '', 0, 0, 0, '2019-06-12 01:29:13'),
(1743, 'en', 0, 'account', 'registration_error_passwordreply_empty', 'The confirm password is empty, please fill it', '', 0, 0, 0, '2019-06-12 01:29:13'),
(1744, 'en', 0, 'account', 'registration_error_accreqcheckbox_notchecked', 'The Terms and Conditions is need to accept for the contiue', '', 0, 0, 0, '2019-06-12 01:29:13'),
(1745, 'hu', 0, 'account', 'registration_error_email_empty', 'Az E-mail cím megadása kötelező', '', 0, 0, 0, '2019-06-12 01:29:34'),
(1746, 'hu', 0, 'account', 'registration_error_password_empty', 'A jelszó nem lehet üres', '', 0, 0, 0, '2019-06-12 01:29:34'),
(1747, 'hu', 0, 'account', 'registration_error_passwordreply_empty', 'A jelszó megerősítés nem lehet üres', '', 0, 0, 0, '2019-06-12 01:29:34'),
(1748, 'hu', 0, 'account', 'registration_error_accreqcheckbox_notchecked', 'A felhasználási feltételek elfogadása kötelező', '', 0, 0, 0, '2019-06-12 01:29:34'),
(1749, 'en', 0, 'account', 'registration_error_email_notvaild', 'The email address is not vaild', '', 0, 0, 0, '2019-06-12 01:36:32'),
(1750, 'hu', 0, 'account', 'registration_error_email_notvaild', 'A megadott E-mail cím érvénytelen', '', 0, 0, 0, '2019-06-12 01:36:50'),
(1751, 'en', 0, 'account', 'registration_error_passwordreply_passwordnotsame', 'The email repeat is not same', '', 0, 0, 0, '2019-06-12 01:38:45'),
(1752, 'hu', 0, 'account', 'registration_error_passwordreply_passwordnotsame', 'A jelszavak nem egyeznek', '', 0, 0, 0, '2019-06-12 01:39:02'),
(1753, 'en', 0, 'account', 'login_modal_button_text', 'Login', '', 0, 0, 0, '2019-06-19 18:04:04'),
(1756, 'hu', 0, 'account', 'login_modal_button_text', 'Bejelentkezés', '', 0, 0, 0, '2019-06-27 01:17:56'),
(1760, 'en', 0, 'account', 'registration_error_email_alreadyused', 'The email is already used', '', 0, 0, 0, '2019-07-01 09:27:09'),
(1761, 'hu', 0, 'account', 'registration_error_email_alreadyused', 'Az email cím már foglalt', '', 0, 0, 0, '2019-07-01 09:29:02'),
(1762, 'en', 0, 'account', 'registration_error_password_to_weak', 'To weak password!', '', 0, 0, 0, '2019-07-01 14:02:36'),
(1763, 'hu', 0, 'account', 'registration_error_password_to_weak', 'A jelszó túl gyenge!', '', 0, 0, 0, '2019-07-01 14:04:22'),
(1764, 'en', 0, 'account', 'password_show', 'Show password', '', 0, 0, 0, '2019-07-02 09:22:37'),
(1765, 'en', 0, 'account', 'password_hide', 'Hide password', '', 0, 0, 0, '2019-07-02 09:22:37'),
(1766, 'hu', 0, 'account', 'password_show', 'Jelszó mutatása', '', 0, 0, 0, '2019-07-02 10:13:48'),
(1767, 'hu', 0, 'account', 'password_hide', 'Jelszó elrejtése', '', 0, 0, 0, '2019-07-02 10:13:48'),
(1768, 'en', 0, 'account', 'password_example2', 'Your password', '', 0, 0, 0, '2019-07-02 10:16:54'),
(1769, 'hu', 1, 'language', 'delete_tname', 'Nyelvi szöveg törlése', '', 0, 0, 0, '2019-07-02 10:17:27'),
(1770, 'hu', 0, 'account', 'password_example2', 'Az Ön jelszava', '', 0, 0, 0, '2019-07-02 10:19:43'),
(1771, 'en', 0, 'account', 'usersettings_userdata_title', 'Profile settings', '', 0, 0, 0, '2019-07-02 13:05:56'),
(1772, 'en', 0, 'account', 'usersettings_userdata_back_button', '< Back', '', 0, 0, 0, '2019-07-02 13:05:56'),
(1773, 'en', 0, 'account', 'display_name', 'Display name', '', 0, 0, 0, '2019-07-02 13:05:56'),
(1774, 'en', 0, 'account', 'display_name_title', 'Display name', '', 0, 0, 0, '2019-07-02 13:05:56'),
(1775, 'en', 0, 'account', 'display_name_example', 'John Doe', '', 0, 0, 0, '2019-07-02 13:05:56'),
(1776, 'en', 0, 'account', 'display_name_helptext', '', '', 0, 0, 0, '2019-07-02 13:05:56'),
(1777, 'en', 0, 'account', 'mobile', 'Mobile number', '', 0, 0, 0, '2019-07-02 13:05:56'),
(1778, 'en', 0, 'account', 'mobile_title', 'Mobile number', '', 0, 0, 0, '2019-07-02 13:05:56'),
(1779, 'en', 0, 'account', 'mobile_example', '', '', 0, 0, 0, '2019-07-02 13:05:56'),
(1780, 'en', 0, 'account', 'mobile_helptext', '', '', 0, 0, 0, '2019-07-02 13:05:56'),
(1781, 'en', 0, 'account', 'usersettings_userdata_save_button', 'Save profile data', '', 0, 0, 0, '2019-07-02 13:05:56'),
(1782, 'en', 0, 'account', 'usersettings_password_title', 'Change Password', '', 0, 0, 0, '2019-07-02 13:06:06'),
(1783, 'en', 0, 'account', 'usersettings_password_back_button', '< Back', '', 0, 0, 0, '2019-07-02 13:06:06'),
(1784, 'en', 0, 'account', 'original_password', 'Current password', '', 0, 0, 0, '2019-07-02 13:06:06'),
(1785, 'en', 0, 'account', 'original_password_title', 'Current password', '', 0, 0, 0, '2019-07-02 13:06:06'),
(1786, 'en', 0, 'account', 'original_password_helptext', 'Please add the current password', '', 0, 0, 0, '2019-07-02 13:06:06'),
(1787, 'en', 0, 'account', 'new_password', 'New Password', '', 0, 0, 0, '2019-07-02 13:06:06'),
(1788, 'en', 0, 'account', 'new_password_title', 'New Password', '', 0, 0, 0, '2019-07-02 13:06:06'),
(1789, 'en', 0, 'account', 'new_password_helptext', 'Type the new password here', '', 0, 0, 0, '2019-07-02 13:06:06'),
(1790, 'en', 0, 'account', 'new_password_reply', 'Check the new password', '', 0, 0, 0, '2019-07-02 13:06:06'),
(1791, 'en', 0, 'account', 'new_password_reply_title', 'Check the new password', '', 0, 0, 0, '2019-07-02 13:06:06'),
(1792, 'en', 0, 'account', 'new_password_reply_helptext', 'Type in the new password', '', 0, 0, 0, '2019-07-02 13:06:06'),
(1793, 'en', 0, 'account', 'usersettings_password_save_button', 'Set the new password', '', 0, 0, 0, '2019-07-02 13:06:06'),
(1794, 'en', 0, 'account', 'menu_change_email', 'Change e-mail address', '', 0, 0, 0, '2019-07-02 13:11:42'),
(1795, 'hu', 0, 'account', 'usersettings_userdata_title', 'Profil adatok módosítása', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1796, 'hu', 0, 'account', 'usersettings_userdata_back_button', '< Vissza', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1797, 'hu', 0, 'account', 'display_name', 'Megjelenő név', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1798, 'hu', 0, 'account', 'display_name_title', 'Megjelenő név', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1799, 'hu', 0, 'account', 'display_name_example', 'pl. Kiss Jakab', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1800, 'hu', 0, 'account', 'display_name_helptext', '', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1801, 'hu', 0, 'account', 'mobile', 'Mobiltelefonszám', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1802, 'hu', 0, 'account', 'mobile_title', 'Mobiltelefonszám', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1803, 'hu', 0, 'account', 'mobile_example', '36301234567', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1804, 'hu', 0, 'account', 'mobile_helptext', '', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1805, 'hu', 0, 'account', 'usersettings_userdata_save_button', 'Mentés', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1806, 'hu', 0, 'account', 'usersettings_password_title', 'Profil jelszó módosítása', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1807, 'hu', 0, 'account', 'usersettings_password_back_button', '< Vissza', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1808, 'hu', 0, 'account', 'original_password', 'Eredeti jelszó', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1809, 'hu', 0, 'account', 'original_password_title', 'Eredeti jelszó', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1810, 'hu', 0, 'account', 'original_password_helptext', 'Kérem adja meg az aktuális jelszavát', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1811, 'hu', 0, 'account', 'new_password', 'Új jelszó', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1812, 'hu', 0, 'account', 'new_password_title', 'Új jelszó', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1813, 'hu', 0, 'account', 'new_password_helptext', 'Ide írhatja az új jelszót', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1814, 'hu', 0, 'account', 'new_password_reply', 'Új jelszó ellenőrzés', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1815, 'hu', 0, 'account', 'new_password_reply_title', 'Új jelszó ellenőrzés', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1816, 'hu', 0, 'account', 'new_password_reply_helptext', 'Kérem írja be újra az új jelszót', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1817, 'hu', 0, 'account', 'usersettings_password_save_button', 'Új jelszó mentése', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1818, 'hu', 0, 'account', 'menu_change_email', 'E-mail cím módosítása', '', 0, 0, 0, '2019-07-02 13:12:53'),
(1819, 'hu', 1, 'menu', 'menupoint_trading_account_edit_title', 'Menüpont - Trading Account  felület', '', 0, 0, 0, '2019-07-16 03:19:22'),
(1820, 'en', 0, 'account', 'forgotpassword_title', 'Forgot Password', '', 0, 0, 0, '2019-07-16 13:47:31'),
(1821, 'en', 0, 'account', 'username_title', 'Username', '', 0, 0, 0, '2019-07-16 13:47:31'),
(1822, 'en', 0, 'account', 'username_example', '', '', 0, 0, 0, '2019-07-16 13:47:31'),
(1823, 'en', 0, 'account', 'forgotpassword_helptext', '', '', 0, 0, 0, '2019-07-16 13:47:31'),
(1824, 'en', 0, 'account', 'forgotpassword_button', 'Send', '', 0, 0, 0, '2019-07-16 13:47:31'),
(1825, 'hu', 0, 'account', 'forgotpassword_title', 'Elfelejtett jelszó', '', 0, 0, 0, '2019-07-21 16:23:03'),
(1826, 'hu', 0, 'account', 'username_title', 'Felhasználónév', '', 0, 0, 0, '2019-07-21 16:23:03'),
(1827, 'hu', 0, 'account', 'username_example', '', '', 0, 0, 0, '2019-07-21 16:23:03'),
(1828, 'hu', 0, 'account', 'forgotpassword_helptext', '', '', 0, 0, 0, '2019-07-21 16:23:03'),
(1829, 'hu', 0, 'account', 'forgotpassword_button', 'Beküldés', '', 0, 0, 0, '2019-07-21 16:23:03'),
(1830, 'hu', 0, 'account', 'logout_button', 'Kilépés', '', 1, 0, 0, '2019-08-11 18:26:53'),
(1832, 'hu', 0, 'account', 'profil', 'Profil', '', 1, 0, 0, '2019-08-11 22:32:00'),
(1833, 'hu', 0, 'account', 'logout', 'Kilépés', '', 1, 0, 0, '2019-08-11 22:32:00'),
(1834, 'hu', 1, 'gallery', 'main_id', '#ID', '', 1, 0, 0, '2019-08-12 21:25:54'),
(1835, 'hu', 1, 'gallery', 'main_menuname', 'Név', '', 1, 0, 0, '2019-08-12 21:25:54'),
(1836, 'hu', 1, 'gallery', 'main_menudir', 'Mappa', '', 1, 0, 0, '2019-08-12 21:25:54'),
(1837, 'hu', 1, 'gallery', 'main_state', 'Állapot', '', 1, 0, 0, '2019-08-12 21:25:54'),
(1838, 'hu', 1, 'gallery', 'gallery_title', 'Galéria', '', 1, 0, 0, '2019-08-12 21:25:59'),
(1839, 'hu', 1, 'gallery', 'image_upload', 'Feltöltés', '', 1, 0, 0, '2019-08-12 21:25:59'),
(1840, 'hu', 1, 'gallery', 'size_small', 'Mini', '', 1, 0, 0, '2019-08-12 21:25:59'),
(1841, 'hu', 1, 'gallery', 'size_large', 'Nagy', '', 1, 0, 0, '2019-08-12 21:25:59'),
(1842, 'hu', 1, 'gallery', 'image_editing', 'Kép szerkesztése', '', 1, 0, 0, '2019-08-12 21:26:49'),
(1843, 'hu', 1, 'gallery', 'image_edit_tname', 'Kép szerkesztése', '', 1, 0, 0, '2019-08-12 21:26:49'),
(1844, 'hu', 1, 'gallery', 'image_title_placeholder', 'Képaláírás...', '', 1, 0, 0, '2019-08-12 21:56:21'),
(1845, 'hu', 1, 'gallery', 'image_edit', 'Kép szerkesztése', '', 1, 0, 0, '2019-08-12 21:56:21'),
(1846, 'hu', 1, 'gallery', 'image_delete', 'Kép törlése', '', 1, 0, 0, '2019-08-12 21:56:21'),
(1847, 'hu', 1, 'gallery', 'main_tname', 'Galéria', '', 1, 0, 0, '2019-08-12 22:03:45'),
(1848, 'hu', 1, 'gallery', 'main_mname', 'Galéria', '', 1, 0, 0, '2019-08-12 22:03:45'),
(1849, 'hu', 1, 'gallery', 'list_tname', 'Galéria képlista', '', 1, 0, 0, '2019-08-12 22:05:20'),
(1850, 'hu', 1, 'gallery', 'file_uploaded', 'Sikeres fájl feltöltés', '', 1, 0, 0, '2019-08-12 22:09:53'),
(1851, 'hu', 1, 'gallery', 'save_success', 'Sikeres galéria mentés', '', 1, 0, 0, '2019-08-12 22:10:07'),
(1852, 'hu', 1, 'gallery', 'no_uploaded_file', 'A fájlok feltöltése sikertelen', NULL, 0, 0, 0, '2019-08-12 22:34:27'),
(1853, 'hu', 1, 'gallery', 'list_not_exist_gallery', 'Nem létező képgaléria!', NULL, 0, 0, 0, '2019-08-12 22:35:23'),
(1854, 'hu', 1, 'gallery', 'image_edit_not_exist_image', 'Nem létező kép!', NULL, 0, 0, 0, '2019-08-12 22:36:06'),
(1855, 'hu', 1, 'gallery', 'call_empty', 'Jelenleg nincs létrehozott galéria mappa :(', NULL, 0, 0, 0, '2019-08-12 22:37:49'),
(1856, 'hu', 1, 'language', 'message_delete_success', 'Sikeres nyelvi szöveg törlés', '', 1, 0, 0, '2019-08-12 22:53:29'),
(1857, 'hu', 1, 'article', 'call_main_title', 'Bejegyzések', '', 1, 0, 0, '2019-08-13 02:18:59'),
(1858, 'hu', 1, 'article', 'call_empty', 'Jelenleg nincs létrehozott bejegyzés :-(', '', 1, 0, 0, '2019-08-13 02:26:38'),
(1859, 'hu', 1, 'article', 'call_main_category_select_text_title', 'Kategória szűrés: ', '', 1, 0, 0, '2019-08-13 02:35:52'),
(1860, 'hu', 1, 'article', 'call_main_category_select_text_all', '- mind -', '', 1, 0, 0, '2019-08-13 02:35:52'),
(1861, 'hu', 1, 'article', 'call_main_category_select_text_nocategory', '- kategória nélküliek -', '', 1, 0, 0, '2019-08-13 02:35:52'),
(1862, 'hu', 1, 'article', 'call_main_id', 'ID', '', 1, 0, 0, '2019-08-13 02:39:49'),
(1863, 'hu', 1, 'article', 'call_main_articlename', 'Bejegyzés név', '', 1, 0, 0, '2019-08-13 02:39:49'),
(1864, 'hu', 1, 'article', 'call_main_cdate', 'Készítési idő', '', 1, 0, 0, '2019-08-13 02:39:49'),
(1865, 'hu', 1, 'article', 'call_main_mdate', 'Módosítási idő', '', 1, 0, 0, '2019-08-13 02:39:49'),
(1866, 'hu', 1, 'article', 'call_main_active', 'Aktív', '', 1, 0, 0, '2019-08-13 02:39:49'),
(1867, 'hu', 1, 'article', 'call_main_articlename_empty', '<-- Bejegyzés név nincs megadva -->', '', 1, 0, 0, '2019-08-13 02:44:20'),
(1868, 'hu', 1, 'article', 'call_deletesure', 'Biztos, hogy a lomtárba mozgatod a kiválasztott bejegyzést?<br><br>(a tartalom nem lesz elérhető senki számára)', '', 1, 0, 0, '2019-08-13 03:06:17'),
(1869, 'hu', 1, 'article', 'message_success_move_to_trash', 'Bejegyzés sikeresen áthelyezve a lomtárba', '', 1, 0, 0, '2019-08-13 03:14:40'),
(1870, 'hu', 1, 'article', 'call_group_main_title', 'Kategóriák', '', 1, 0, 0, '2019-08-13 03:58:05'),
(1871, 'hu', 1, 'article', 'group_main_id', 'ID', '', 1, 0, 0, '2019-08-13 03:58:05'),
(1872, 'hu', 1, 'article', 'group_main_categoryname', 'Kategória neve', '', 1, 0, 0, '2019-08-13 03:58:05'),
(1873, 'hu', 1, 'article', 'group_main_contentnumber', 'Bejegyzés szám', '', 1, 0, 0, '2019-08-13 03:58:05'),
(1874, 'hu', 1, 'article', 'group_main_active', 'Aktív?', '', 1, 0, 0, '2019-08-13 03:58:05'),
(1875, 'hu', 1, 'article', 'group_deletesure', 'Biztos, hogy törölni akarod a kiválasztott kategóriát?<br><br>(nem fogod tudni visszaállítani)', '', 1, 0, 0, '2019-08-13 03:58:05'),
(1876, 'hu', 1, 'article', 'edit_main_title', 'Bejegyzés szerkesztés', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1877, 'hu', 1, 'article', 'edit_name', 'Bejegyzés neve', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1878, 'hu', 1, 'article', 'edit_state', 'Állapot', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1879, 'hu', 1, 'article', 'edit_state_active', 'Aktív', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1880, 'hu', 1, 'article', 'edit_state_inactive', 'Inaktív', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1881, 'hu', 1, 'article', 'edit_tabmenu_content', 'Tartalom', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1882, 'hu', 1, 'article', 'edit_tabmenu_category', 'Kategória', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1883, 'hu', 1, 'article', 'edit_tabmenu_image', 'Bejegyzés kép', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1884, 'hu', 1, 'article', 'edit_tabmenu_meta', 'META', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1885, 'hu', 1, 'article', 'edit_tabmenu_other', 'Egyéb', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1886, 'hu', 1, 'article', 'meta_edit_metakey', 'Kereső kulcsok', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1887, 'hu', 1, 'article', 'meta_edit_metadesc', 'Kereső leírás', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1888, 'hu', 1, 'article', 'other_tab_template', 'Egyedi template stílus', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1889, 'hu', 1, 'article', 'other_tab_class', 'Egyedi CSS osztály', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1890, 'hu', 1, 'article', 'other_tab_css', 'Saját CSS fájl beltöltés <small> (vesszővel elválasztva több fájl is megadható)</small>', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1891, 'hu', 1, 'article', 'other_tab_js', 'Saját Javascript fájl betöltés <small> (vesszővel elválasztva több fájl is megadható)</small>', '', 1, 0, 0, '2019-08-13 04:27:38'),
(1892, 'hu', 1, 'article', 'edit_no_category_select_text', '- kategória nélkül -', '', 1, 0, 0, '2019-08-13 04:58:54'),
(1893, 'hu', 1, 'article', 'edit_image_tab_thumbnail_title', 'Bejegyzés kiskép', '', 1, 0, 0, '2019-08-13 04:58:54'),
(1894, 'hu', 1, 'article', 'edit_image_tab_thumbnail_error', '<div id=\"thumbnail-message-error\" class=\"alert alert-danger\" role=\"alert\"><span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span> Nem engedélyezett formátum! <b>Megjegyzés:</b> Csak jpeg, jpg, png és gif képek engedélyezettek! </div>', '', 1, 0, 0, '2019-08-13 04:58:54'),
(1895, 'hu', 1, 'article', 'edit_image_tab_thumbnail_delete', 'Feltöltött kiskép törlése', '', 1, 0, 0, '2019-08-13 04:58:54'),
(1896, 'hu', 1, 'article', 'edit_image_tab_headerimg_title', 'Egyedi oldal fejléckép', '', 1, 0, 0, '2019-08-13 04:58:54'),
(1897, 'hu', 1, 'article', 'edit_image_tab_headerimg_error', '<div id=\"headerimage-message-error\" class=\"alert alert-danger\" role=\"alert\"><span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span> Nem engedélyezett formátum! <b>Megjegyzés:</b> Csak jpeg, jpg, png és gif képek engedélyezettek! </div>', '', 1, 0, 0, '2019-08-13 04:58:54'),
(1898, 'hu', 1, 'article', 'edit_image_tab_headerimg_delete', 'Feltöltött fejléckép törlése', '', 1, 0, 0, '2019-08-13 04:58:54'),
(1899, 'hu', 1, 'article', 'edit_image_tab_youtube_title', 'Youtube video ID', '', 1, 0, 0, '2019-08-13 04:58:54'),
(1900, 'hu', 1, 'article', 'main_mname', 'Bejegyzés kezelő', '', 1, 0, 0, '2019-08-13 14:30:22'),
(1901, 'hu', 1, 'article', 'group_main_mname', 'Kategóriák', '', 1, 0, 0, '2019-08-13 14:30:22'),
(1902, 'hu', 1, 'article', 'main_tname', 'Bejegyzés kezelő', '', 1, 0, 0, '2019-08-13 14:30:22'),
(1903, 'hu', 1, 'article', 'group_main_tname', 'Kategória lista', '', 1, 0, 0, '2019-08-13 14:30:24'),
(1904, 'hu', 1, 'article', 'group_edit_tname', 'Új kategória', '', 1, 0, 0, '2019-08-13 14:30:27'),
(1905, 'hu', 1, 'article', 'edit_tname', 'Bejegyzés szerkesztés', '', 1, 0, 0, '2019-08-13 14:30:30'),
(1906, 'hu', 1, 'mediamanager', 'media_list_mname', 'Média fájlok', '', 1, 0, 0, '2019-08-13 21:13:32'),
(1907, 'hu', 1, 'mediamanager', 'media_list_tname', 'Média fájlok', '', 1, 0, 0, '2019-08-13 21:20:09'),
(1908, 'hu', 1, 'mediamanager', 'list_empty', 'Jelenleg nincs feltöltött fájl a rendszerben :-(', '', 1, 0, 0, '2019-08-13 23:08:44'),
(1909, 'hu', 1, 'mediamanager', 'new_media_file_upload', 'Új média fájl feltöltése', '', 1, 0, 0, '2019-08-13 23:21:23'),
(1910, 'hu', 1, 'mediamanager', 'media_add_tname', '[LANG_ADMIN_MEDIAMANAGER_MEDIA_ADD_TNAME]', '', 1, 4, 0, '2019-08-13 23:29:00'),
(1911, 'hu', 1, 'article', 'edit_image_tab_thumbnail_upload', '[LANG_ADMIN_ARTICLE_EDIT_IMAGE_TAB_THUMBNAIL_UPLOAD]', '', 1, 4, 0, '2019-08-14 00:14:28'),
(1912, 'hu', 1, 'article', 'edit_image_tab_bigthumbnail_title', '[LANG_ADMIN_ARTICLE_EDIT_IMAGE_TAB_BIGTHUMBNAIL_TITLE]', '', 1, 4, 0, '2019-08-14 00:14:28'),
(1913, 'hu', 1, 'article', 'edit_image_tab_bigthumbnail_upload', '[LANG_ADMIN_ARTICLE_EDIT_IMAGE_TAB_BIGTHUMBNAIL_UPLOAD]', '', 1, 4, 0, '2019-08-14 00:14:28'),
(1914, 'hu', 1, 'article', 'edit_image_tab_bigthumbnail_delete', '[LANG_ADMIN_ARTICLE_EDIT_IMAGE_TAB_BIGTHUMBNAIL_DELETE]', '', 1, 4, 0, '2019-08-14 00:14:28'),
(1915, 'hu', 1, 'article', 'edit_image_tab_headerimg_upload', '[LANG_ADMIN_ARTICLE_EDIT_IMAGE_TAB_HEADERIMG_UPLOAD]', '', 1, 3, 0, '2019-08-14 00:14:28'),
(1916, 'hu', 1, 'sys', 'go_to_website', 'Weboldal megtekintése', '', 1, 0, 0, '2019-08-14 04:04:10'),
(1918, 'hu', 1, 'admin', 'settings_save', 'Mentés', '', 1, 0, 0, '2019-10-10 02:54:05'),
(1919, 'hu', 1, 'article', 'save', 'Mentés', '', 1, 0, 0, '2019-10-10 16:35:19'),
(1920, 'hu', 1, 'article', 'save_and_exit', 'Mentés és kilépés', '', 1, 0, 0, '2019-10-10 16:35:19'),
(1921, 'hu', 1, 'article', 'save_and_new', 'Mentés és új', '', 1, 0, 0, '2019-10-10 16:35:19'),
(1922, 'hu', 1, 'article', 'save_as_copy', 'Mentés másolatként', '', 1, 0, 0, '2019-10-10 16:35:19'),
(1923, 'hu', 1, 'article', 'preview', 'Előnézet', '', 1, 0, 0, '2019-10-10 16:35:19'),
(1924, 'hu', 1, 'article', 'create_new', 'Új bejegyzés', '', 1, 0, 0, '2019-10-10 16:35:22'),
(1925, 'hu', 1, 'article', 'create_new_category', 'Új bejegyzés kategória', '', 1, 0, 0, '2019-10-10 23:19:42'),
(1926, 'hu', 1, 'account', 'save', 'Mentés', '', 1, 0, 0, '2019-10-11 00:06:01'),
(1927, 'hu', 1, 'account', 'save_and_exit', 'Mentés és kilépés', '', 1, 0, 0, '2019-10-11 00:06:01'),
(1928, 'hu', 1, 'article', 'create_tname', 'Új bejegyzés', '', 1, 0, 0, '2019-10-11 01:19:06'),
(1929, 'hu', 1, 'account', 'new_user', 'Új felhasználó', '', 1, 0, 0, '2019-10-11 01:22:06'),
(1930, 'hu', 1, 'account', 'permission_main_header_id', 'ID', '', 1, 0, 0, '2019-10-11 01:31:45'),
(1931, 'hu', 1, 'account', 'permission_main_header_name', 'Név', '', 1, 0, 0, '2019-10-11 01:31:45'),
(1932, 'hu', 1, 'account', 'permission_main_header_isadmin', 'Admin?', '', 1, 0, 0, '2019-10-11 01:31:45'),
(1933, 'hu', 1, 'account', 'image_please_select', '-- Kérem válasszon --', '', 1, 0, 0, '2019-10-13 04:09:17'),
(1934, 'hu', 1, 'account', 'image_upload', 'Kép feltöltése', '', 1, 0, 0, '2019-10-13 04:09:17'),
(1935, 'hu', 1, 'account', 'user_image', 'Profilkép', '', 1, 0, 0, '2019-10-14 14:02:57'),
(1937, 'hu', 1, 'account', 'user_usercantedit', 'A felhasználó nem szerkesztheti!', '', 1, 0, 0, '2019-10-18 01:40:33'),
(1938, 'hu', 1, 'account', 'user_password_strength', 'Jelszó nehézség', '', 1, 0, 0, '2019-10-19 21:28:21'),
(1939, 'hu', 1, 'account', 'user_admin_theme_style', 'Admin felület színvilág', '', 1, 0, 0, '2019-10-20 01:58:38'),
(1941, 'hu', 1, 'account', 'user_the_password_to_weak', 'Túl gyenge jelszó!', '', 1, 0, 0, '2019-10-21 22:41:36'),
(1942, 'hu', 1, 'account', 'new_user_invite', 'Felhasználó meghívás', '', 1, 0, 0, '2019-10-23 11:08:41'),
(1943, 'hu', 0, 'sys', 'first_page', 'Első oldal', '', 1, 0, 0, '2019-10-23 15:46:48'),
(1944, 'hu', 0, 'sys', 'last_page', 'Utolsó oldal', '', 1, 0, 0, '2019-10-23 15:46:48'),
(1945, 'hu', 1, 'account', 'accountinvite_tname', 'Felhasználó meghívás', '', 1, 0, 0, '2019-10-23 16:01:40'),
(1946, 'hu', 1, 'account', 'title_userdetails', 'Felhasználói adatok', '', 1, 0, 0, '2019-10-30 00:05:19'),
(1947, 'hu', 1, 'account', 'title_userstatistic', 'Felhasználó statisztikák', '', 1, 0, 0, '2019-10-30 00:27:02'),
(1949, 'hu', 1, 'account', 'user_loginlast', 'Felhasználó utoljára belépve', '', 1, 0, 0, '2019-10-30 00:27:02'),
(1950, 'hu', 1, 'account', 'user_loginhistory', 'Felhasználó belépések', '', 1, 0, 0, '2019-10-30 00:27:02'),
(1951, 'hu', 1, 'account', 'user_usercantsee', 'A felhasználó nem látja!', '', 1, 0, 0, '2019-10-30 00:57:24'),
(1952, 'hu', 1, 'account', 'user_admincantedit', 'Admin nem módosíthatja', '', 1, 0, 0, '2019-10-30 01:02:14'),
(1953, 'hu', 1, 'account', 'user_registrationdate', 'Regisztráció ideje', '', 1, 0, 0, '2019-10-30 01:09:11'),
(1954, 'hu', 1, 'account', 'user_never_loged_in', 'Még sose lépett be', '', 1, 0, 0, '2019-10-30 01:31:13'),
(1955, 'hu', 1, 'account', 'user_logincount', 'Felhasználó belépés szám', '', 1, 0, 0, '2019-10-30 01:36:56'),
(1956, 'hu', 1, 'account', 'edit', 'Szerkesztés', '', 1, 0, 0, '2019-10-30 01:58:39'),
(1958, 'hu', 1, 'admin', 'settings_masked_savelog_detailed', 'Részletes', NULL, 0, 0, 0, '2019-10-30 13:55:32'),
(1959, 'hu', 1, 'admin', 'settings_masked_savelog_login', 'Bejelentkezés', NULL, 0, 0, 0, '2019-10-30 13:58:51'),
(1960, 'hu', 1, 'account', 'currently_logged_in', 'Bejelentkezve', '', 1, 0, 0, '2019-11-01 23:34:19'),
(1961, 'hu', 1, 'account', 'main_list_search_text', 'Keresés...', '', 1, 0, 0, '2019-11-02 00:02:23'),
(1962, 'hu', 1, 'account', 'user_state', 'Állapot', '', 1, 0, 0, '2019-11-02 00:05:49'),
(1963, 'hu', 1, 'account', 'user_state_all', '-- Mind --', '', 1, 0, 0, '2019-11-02 00:05:49'),
(1964, 'hu', 1, 'account', 'edit_state', 'Állapot', NULL, 0, 0, 0, '2019-11-02 00:08:50'),
(1965, 'hu', 1, 'account', 'edit_state_inactive', 'Inaktív', NULL, 0, 0, 0, '2019-11-02 00:09:15'),
(1966, 'hu', 1, 'account', 'edit_state_active', 'Aktív', NULL, 0, 0, 0, '2019-11-02 00:09:26'),
(1967, 'hu', 1, 'account', 'edit_state_not_actived', 'Nem megerősített felhasználó', NULL, 0, 0, 0, '2019-11-02 00:10:00'),
(1968, 'hu', 1, 'account', 'permission_mname', 'Jogosultságok', NULL, 0, 0, 0, '2019-11-02 00:11:01'),
(1969, 'hu', 1, 'account', 'permission_tname', 'Jogosultságok', NULL, 0, 0, 0, '2019-11-02 00:11:13'),
(1970, 'hu', 1, 'account', 'permission_edit_tname', 'Jogosultságok szekresztése', NULL, 0, 0, 0, '2019-11-02 00:11:30'),
(1971, 'hu', 1, 'account', 'user_header_id', 'ID', NULL, 0, 0, 0, '2019-11-02 00:11:49'),
(1972, 'hu', 1, 'account', 'user_header_name_email', 'Név/E-mail', NULL, 0, 0, 0, '2019-11-02 00:12:04'),
(1973, 'hu', 1, 'account', 'user_header_state', 'Aktív', NULL, 0, 0, 0, '2019-11-02 00:12:14'),
(1974, 'hu', 1, 'account', 'user_header_level', 'Szint', NULL, 0, 0, 0, '2019-11-02 00:12:25'),
(1975, 'hu', 1, 'account', 'message_save_error_in_db', 'Hiba történt a profil mentése során!', NULL, 0, 0, 0, '2019-11-02 00:13:29'),
(1976, 'hu', 1, 'account', 'message_save_success', 'A profil mentése sikeres!', NULL, 0, 0, 0, '2019-11-02 00:13:42'),
(1977, 'hu', 1, 'account', 'message_error_id_not_exist', 'A profil ID nem létezik!', NULL, 0, 0, 0, '2019-11-02 00:14:01'),
(1978, 'hu', 1, 'account', 'permission_message_save_success', 'A jogosultság mentése sikeres!', NULL, 0, 0, 0, '2019-11-02 00:14:43'),
(1979, 'hu', 1, 'account', 'permission_message_save_error_in_db', 'Hiba történt a jogosultság mentése során!', NULL, 0, 0, 0, '2019-11-02 00:15:09'),
(1980, 'hu', 1, 'account', 'permission_message_error_id_not_exist', 'A jogosultság ID nem létezik!', NULL, 0, 0, 0, '2019-11-02 00:15:30'),
(1981, 'hu', 1, 'account', 'user_username', 'E-mail (felhasználónév)', '', 1, 0, 0, '2019-11-02 00:18:00'),
(1982, 'hu', 1, 'account', 'user_password', 'Jelszó', '', 1, 0, 0, '2019-11-02 00:18:00'),
(1983, 'hu', 1, 'account', 'user_userlevel', 'Felhasználó szint', '', 1, 0, 0, '2019-11-02 00:18:00'),
(1984, 'hu', 1, 'account', 'user_first_name', 'Utónév', '', 1, 0, 0, '2019-11-02 00:18:00'),
(1985, 'hu', 1, 'account', 'user_last_name', 'Vezetéknév', '', 1, 0, 0, '2019-11-02 00:18:00'),
(1986, 'hu', 1, 'account', 'user_display_name', 'Megjelenő név', '', 1, 0, 0, '2019-11-02 00:18:00'),
(1987, 'hu', 1, 'account', 'user_empty_or_invalid_email', 'Üres vagy érvénytelen e-mail cím!', NULL, 0, 0, 0, '2019-11-02 00:21:21'),
(1988, 'hu', 1, 'account', 'user_email_is_already_used', 'Az email cím már használatban van!', NULL, 0, 0, 0, '2019-11-02 00:21:45'),
(1989, 'hu', 1, 'account', 'user_the_password_must_filled', 'A jelszó nem lehet üres!', NULL, 0, 0, 0, '2019-11-02 00:22:05'),
(1990, 'hu', 1, 'account', 'user_state_active', 'Aktív', '', 1, 0, 0, '2019-11-02 00:22:42'),
(1991, 'hu', 1, 'account', 'user_state_inactive', 'Inaktív', '', 1, 0, 0, '2019-11-02 00:22:42'),
(1992, 'hu', 1, 'account', 'user_state_not_actived', 'Nem megerősített', '', 1, 0, 0, '2019-11-02 00:24:30'),
(1993, 'hu', 0, 'account', 'password_strength', 'Jelszó nehézség', '', 1, 0, 0, '2019-11-02 12:08:30'),
(1994, 'hu', 0, 'account', 'password_strength_helptext', 'A jelszó nehézségnek el kell érnie legalább a <strong>közepes</strong> szintet, hogy a regisztráció megtörténhessen. A szint növeléshez lehet használni, kis- és nagybetűt, speciális karaktert, vagy növelni a jelszó hosszát (nincs kötelező elem).', '', 1, 0, 0, '2019-11-02 12:08:30'),
(1995, 'hu', 0, 'account', 'pwstrength_weak', '- <i>Gyenge</i>', '', 1, 0, 0, '2019-11-02 18:14:30'),
(1996, 'hu', 0, 'account', 'pwstrength_medium', '- <i>Közepes</i>', '', 1, 0, 0, '2019-11-02 18:14:34'),
(1997, 'hu', 0, 'account', 'pwstrength_strong', '- <i>Erős</i>', '', 1, 0, 0, '2019-11-02 18:15:04'),
(1998, 'hu', 0, 'account', 'first_login_redirect', 'Első bejelentkezés, átirányítás az adatlapra...', '', 1, 0, 0, '2019-11-08 21:17:43'),
(1999, 'hu', 1, 'account', 'theme_system_select', 'Rendszer kinézetének alkalmazása', '', 1, 0, 0, '2019-12-21 22:06:52');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_media`
--

CREATE TABLE `cb_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'document',
  `file_dir` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_original_name` varchar(255) NOT NULL,
  `md5` varchar(32) NOT NULL,
  `name` text NOT NULL,
  `description` text,
  `settings` text NOT NULL,
  `date_upload` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `del` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_media_xref`
--

CREATE TABLE `cb_media_xref` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `media_id` bigint(20) UNSIGNED NOT NULL,
  `referer` varchar(20) NOT NULL DEFAULT '',
  `referer_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_menu`
--

CREATE TABLE `cb_menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `category` int(3) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `parent` int(11) NOT NULL,
  `image` varchar(63) NOT NULL DEFAULT '',
  `order` int(11) NOT NULL,
  `state` int(2) NOT NULL,
  `text` text,
  `class` varchar(127) NOT NULL DEFAULT '',
  `target` varchar(20) NOT NULL DEFAULT '',
  `default_load` tinyint(4) NOT NULL DEFAULT '0',
  `level` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_menu`
--

INSERT INTO `cb_menu` (`id`, `content_id`, `category`, `lang`, `parent`, `image`, `order`, `state`, `text`, `class`, `target`, `default_load`, `level`) VALUES
(1, 1, 1, 'hu', 0, '', 110, 1, '', '', '', 1, ''),
(2, 2, 1, 'hu', 0, '', 210, 1, '', '', '', 0, ''),
(3, 3, 2, 'hu', 0, '', 310, 1, '', '', '', 0, ''),
(4, 4, 1, 'hu', 0, '', 310, 1, '', '', '', 0, ''),
(5, 1, 2, 'hu', 0, '', 110, 1, '', '', '', 0, ''),
(6, 2, 2, 'hu', 0, '', 210, 1, '', '', '', 0, ''),
(7, 4, 2, 'hu', 0, '', 410, 1, '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_menu_category`
--

CREATE TABLE `cb_menu_category` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(63) NOT NULL,
  `class` varchar(127) NOT NULL,
  `collapse` int(1) NOT NULL DEFAULT '1',
  `state` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_menu_category`
--

INSERT INTO `cb_menu_category` (`id`, `name`, `class`, `collapse`, `state`) VALUES
(1, 'Menu 1', '', 1, 1),
(2, 'Menu 2', '', 1, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_message`
--

CREATE TABLE `cb_message` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(128) NOT NULL,
  `device` varchar(20) NOT NULL DEFAULT '',
  `title` varchar(128) DEFAULT NULL,
  `message` text NOT NULL,
  `type` varchar(10) DEFAULT 'success',
  `style` varchar(128) NOT NULL,
  `time` int(11) NOT NULL,
  `valid_time` datetime DEFAULT NULL,
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `multishow` tinyint(1) NOT NULL DEFAULT '0',
  `delivered` tinyint(1) NOT NULL DEFAULT '0',
  `archive` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_message`
--

INSERT INTO `cb_message` (`id`, `user_id`, `session_id`, `device`, `title`, `message`, `type`, `style`, `time`, `valid_time`, `date_time`, `multishow`, `delivered`, `archive`) VALUES
(1, 1, 'aqbyxiez5nuxbq82she4updbnar7bsr8irj62cay6f5at8puy23yknqf8exrnhbnccswr5qcj5tnegkc6zupmmwturfpcd3uhgv6qev6sasibft3gcqju4ebgby658tv', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-10 03:07:54', '2019-08-10 03:06:54', 0, 0, 1),
(2, 1, 'aqbyxiez5nuxbq82she4updbnar7bsr8irj62cay6f5at8puy23yknqf8exrnhbnccswr5qcj5tnegkc6zupmmwturfpcd3uhgv6qev6sasibft3gcqju4ebgby658tv', '', '', '[LANG_ADMIN_ACCOUNT_MESSAGE_PERMISSION_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-10 03:08:06', '2019-08-10 03:07:06', 0, 0, 1),
(3, 1, 'aqbyxiez5nuxbq82she4updbnar7bsr8irj62cay6f5at8puy23yknqf8exrnhbnccswr5qcj5tnegkc6zupmmwturfpcd3uhgv6qev6sasibft3gcqju4ebgby658tv', '', '', '[LANG_ADMIN_ACCOUNT_MESSAGE_PERMISSION_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-10 03:23:13', '2019-08-10 03:22:13', 0, 0, 1),
(4, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-11 18:13:12', '2019-08-11 18:12:12', 0, 0, 1),
(5, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-08-11 18:13:16', '2019-08-11 18:12:16', 0, 0, 1),
(6, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-11 18:13:26', '2019-08-11 18:12:26', 0, 0, 1),
(7, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-08-11 18:25:44', '2019-08-11 18:24:44', 0, 0, 1),
(8, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-11 18:25:52', '2019-08-11 18:24:52', 0, 0, 1),
(9, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-08-11 18:26:28', '2019-08-11 18:25:28', 0, 0, 1),
(10, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-11 18:26:40', '2019-08-11 18:25:40', 0, 0, 1),
(11, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-11 19:34:03', '2019-08-11 19:33:03', 0, 0, 1),
(12, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-11 19:34:13', '2019-08-11 19:33:13', 0, 0, 1),
(13, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-11 20:43:05', '2019-08-11 20:42:05', 0, 0, 1),
(14, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-11 20:43:30', '2019-08-11 20:42:30', 0, 0, 1),
(15, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-11 21:09:30', '2019-08-11 21:08:30', 0, 0, 1),
(16, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-11 21:29:01', '2019-08-11 21:28:01', 0, 0, 1),
(17, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-11 21:31:58', '2019-08-11 21:30:58', 0, 0, 1),
(18, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-11 21:34:39', '2019-08-11 21:33:39', 0, 0, 1),
(19, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-11 21:35:13', '2019-08-11 21:34:13', 0, 0, 1),
(20, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-11 21:37:49', '2019-08-11 21:36:49', 0, 0, 1),
(21, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-11 21:51:33', '2019-08-11 21:50:33', 0, 0, 1),
(22, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-08-11 21:51:44', '2019-08-11 21:50:44', 0, 0, 1),
(23, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 21:52:57', '2019-08-11 21:51:57', 0, 0, 1),
(24, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-11 21:53:07', '2019-08-11 21:52:07', 0, 0, 1),
(25, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-08-11 21:55:06', '2019-08-11 21:54:06', 0, 1, 1),
(26, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 21:55:54', '2019-08-11 21:54:54', 0, 1, 1),
(27, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 21:57:53', '2019-08-11 21:56:53', 0, 1, 1),
(28, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 21:57:57', '2019-08-11 21:56:57', 0, 1, 1),
(29, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:06:14', '2019-08-11 22:05:14', 0, 1, 1),
(30, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:06:21', '2019-08-11 22:05:21', 0, 1, 1),
(31, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:07:44', '2019-08-11 22:06:44', 0, 1, 1),
(32, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:09:01', '2019-08-11 22:08:01', 0, 1, 1),
(33, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:09:16', '2019-08-11 22:08:16', 0, 1, 1),
(34, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-11 22:13:02', '2019-08-11 22:12:02', 0, 1, 1),
(35, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-08-11 22:13:07', '2019-08-11 22:12:07', 0, 1, 1),
(36, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:13:43', '2019-08-11 22:12:43', 0, 1, 1),
(37, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:13:53', '2019-08-11 22:12:53', 0, 1, 1),
(38, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:14:02', '2019-08-11 22:13:02', 0, 1, 1),
(39, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:14:08', '2019-08-11 22:13:08', 0, 1, 1),
(40, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:15:26', '2019-08-11 22:14:26', 0, 1, 1),
(41, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:15:48', '2019-08-11 22:14:48', 0, 1, 1),
(42, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:21:24', '2019-08-11 22:20:24', 0, 1, 1),
(43, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:21:29', '2019-08-11 22:20:29', 0, 1, 1),
(44, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:21:31', '2019-08-11 22:20:31', 0, 1, 1),
(45, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-11 22:21:33', '2019-08-11 22:20:33', 0, 1, 1),
(46, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-08-11 22:22:29', '2019-08-11 22:21:29', 0, 1, 1),
(47, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-11 22:22:57', '2019-08-11 22:21:57', 0, 1, 1),
(48, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-08-11 22:34:13', '2019-08-11 22:33:13', 0, 0, 1),
(49, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-11 22:36:14', '2019-08-11 22:35:14', 0, 0, 1),
(50, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-08-11 22:36:16', '2019-08-11 22:35:16', 0, 0, 1),
(51, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:37:39', '2019-08-11 22:36:39', 0, 0, 1),
(52, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:37:41', '2019-08-11 22:36:41', 0, 0, 1),
(53, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:37:45', '2019-08-11 22:36:45', 0, 0, 1),
(54, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:40:51', '2019-08-11 22:39:51', 0, 0, 1),
(55, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:40:52', '2019-08-11 22:39:52', 0, 0, 1),
(56, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:42:03', '2019-08-11 22:41:03', 0, 0, 1),
(57, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:43:50', '2019-08-11 22:42:50', 0, 0, 1),
(58, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:44:18', '2019-08-11 22:43:18', 0, 0, 1),
(59, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:46:56', '2019-08-11 22:45:56', 0, 1, 1),
(60, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:47:01', '2019-08-11 22:46:01', 0, 1, 1),
(61, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:47:10', '2019-08-11 22:46:10', 0, 1, 1),
(62, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-11 22:47:20', '2019-08-11 22:46:20', 0, 1, 1),
(63, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-08-11 22:47:31', '2019-08-11 22:46:31', 0, 1, 1),
(64, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:47:36', '2019-08-11 22:46:36', 0, 1, 1),
(65, 1, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-11 22:47:54', '2019-08-11 22:46:54', 0, 1, 1),
(66, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-08-11 22:48:05', '2019-08-11 22:47:05', 0, 1, 1),
(67, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:48:07', '2019-08-11 22:47:07', 0, 1, 1),
(68, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:48:10', '2019-08-11 22:47:11', 0, 1, 1),
(69, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:48:12', '2019-08-11 22:47:12', 0, 1, 1),
(70, 0, 'x3uk5cvnb4dghphdc7nj3fpzux8afiprr28xvzy766bzdbb5h5d7x8pvfheuqmzdyg3patc6sdacq34bzhx7am8ypfh3jia5tv3rqdah8xresm5bpaghbybxrsy8fpwy', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-11 22:48:12', '2019-08-11 22:47:12', 0, 1, 1),
(71, 0, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-08-12 20:21:14', '2019-08-12 20:20:14', 0, 1, 1),
(72, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-12 20:21:20', '2019-08-12 20:20:20', 0, 1, 1),
(73, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[ADMIN_TEXT_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 20:52:46', '2019-08-12 20:51:46', 0, 1, 1),
(74, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:33:11', '2019-08-12 21:32:11', 0, 1, 1),
(75, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:35:21', '2019-08-12 21:34:21', 0, 1, 1),
(76, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:35:32', '2019-08-12 21:34:32', 0, 1, 1),
(77, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:36:11', '2019-08-12 21:35:11', 0, 1, 1),
(78, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:36:28', '2019-08-12 21:35:28', 0, 1, 1),
(79, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:36:38', '2019-08-12 21:35:38', 0, 1, 1),
(80, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:36:49', '2019-08-12 21:35:49', 0, 1, 1),
(81, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:46:49', '2019-08-12 21:45:49', 0, 1, 1),
(82, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:46:59', '2019-08-12 21:45:59', 0, 1, 1),
(83, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:47:05', '2019-08-12 21:46:05', 0, 1, 1),
(84, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:47:07', '2019-08-12 21:46:07', 0, 1, 1),
(85, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:47:19', '2019-08-12 21:46:19', 0, 1, 1),
(86, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:47:21', '2019-08-12 21:46:21', 0, 1, 1),
(87, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:48:13', '2019-08-12 21:47:13', 0, 1, 1),
(88, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:48:26', '2019-08-12 21:47:26', 0, 1, 1),
(89, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:48:35', '2019-08-12 21:47:35', 0, 1, 1),
(90, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:49:28', '2019-08-12 21:48:28', 0, 1, 1),
(91, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 21:49:49', '2019-08-12 21:48:49', 0, 1, 1),
(92, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 21:51:22', '2019-08-12 21:50:22', 0, 1, 1),
(93, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 21:51:27', '2019-08-12 21:50:27', 0, 1, 1),
(94, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 21:52:06', '2019-08-12 21:51:06', 0, 1, 1),
(95, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 21:52:11', '2019-08-12 21:51:11', 0, 1, 1),
(96, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 21:52:13', '2019-08-12 21:51:13', 0, 1, 1),
(97, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 21:52:13', '2019-08-12 21:51:13', 0, 1, 1),
(98, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 21:52:14', '2019-08-12 21:51:14', 0, 1, 1),
(99, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 21:52:14', '2019-08-12 21:51:14', 0, 1, 1),
(100, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 21:52:14', '2019-08-12 21:51:14', 0, 1, 1),
(101, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 21:52:14', '2019-08-12 21:51:14', 0, 1, 1),
(102, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 21:52:37', '2019-08-12 21:51:37', 0, 1, 1),
(103, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:00:47', '2019-08-12 21:59:47', 0, 1, 1),
(104, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 22:00:59', '2019-08-12 21:59:59', 0, 1, 1),
(105, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 22:01:51', '2019-08-12 22:00:51', 0, 1, 1),
(106, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:02:32', '2019-08-12 22:01:32', 0, 1, 1),
(107, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:03:52', '2019-08-12 22:02:52', 0, 1, 1),
(108, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:04:03', '2019-08-12 22:03:03', 0, 1, 1),
(109, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:04:15', '2019-08-12 22:03:15', 0, 1, 1),
(110, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:05:08', '2019-08-12 22:04:08', 0, 1, 1),
(111, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:05:13', '2019-08-12 22:04:13', 0, 1, 1),
(112, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:06:35', '2019-08-12 22:05:35', 0, 1, 1),
(113, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:07:08', '2019-08-12 22:06:08', 0, 1, 1),
(114, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 22:10:53', '2019-08-12 22:09:53', 0, 1, 1),
(115, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 22:10:56', '2019-08-12 22:09:56', 0, 1, 1),
(116, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_FILE_UPLOADED]', 'success', 'save', 5000, '2019-08-12 22:11:01', '2019-08-12 22:10:01', 0, 1, 1),
(117, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:11:06', '2019-08-12 22:10:06', 0, 1, 1),
(118, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:11:33', '2019-08-12 22:10:33', 0, 1, 1),
(119, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:11:43', '2019-08-12 22:10:43', 0, 1, 1),
(120, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:36:23', '2019-08-12 22:35:23', 0, 1, 1),
(121, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:36:38', '2019-08-12 22:35:38', 0, 1, 1),
(122, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:37:06', '2019-08-12 22:36:06', 0, 1, 1),
(123, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:38:49', '2019-08-12 22:37:49', 0, 1, 1),
(124, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_DELETE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:54:27', '2019-08-12 22:53:27', 0, 1, 1),
(125, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-12 22:55:07', '2019-08-12 22:54:07', 0, 1, 1),
(126, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 01:41:02', '2019-08-13 01:40:02', 0, 1, 1),
(127, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 01:49:59', '2019-08-13 01:48:59', 0, 1, 1),
(128, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 01:51:16', '2019-08-13 01:50:16', 0, 1, 1),
(129, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 01:51:36', '2019-08-13 01:50:36', 0, 1, 1),
(130, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 01:52:19', '2019-08-13 01:51:19', 0, 1, 1),
(131, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 01:52:28', '2019-08-13 01:51:28', 0, 1, 1),
(132, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 01:54:13', '2019-08-13 01:53:13', 0, 1, 1),
(133, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 01:54:22', '2019-08-13 01:53:22', 0, 1, 1),
(134, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 01:54:33', '2019-08-13 01:53:33', 0, 1, 1),
(135, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 01:56:32', '2019-08-13 01:55:32', 0, 1, 1),
(136, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 01:56:40', '2019-08-13 01:55:40', 0, 1, 1),
(137, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 01:56:42', '2019-08-13 01:55:42', 0, 1, 1),
(138, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 01:56:43', '2019-08-13 01:55:43', 0, 1, 1),
(139, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 01:59:55', '2019-08-13 01:58:55', 0, 1, 1),
(140, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 01:59:58', '2019-08-13 01:58:58', 0, 1, 1),
(141, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:00:00', '2019-08-13 01:59:00', 0, 1, 1),
(142, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:00:03', '2019-08-13 01:59:03', 0, 1, 1),
(143, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:00:05', '2019-08-13 01:59:05', 0, 1, 1),
(144, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:00:08', '2019-08-13 01:59:08', 0, 1, 1),
(145, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_GALLERY_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:00:12', '2019-08-13 01:59:12', 0, 1, 1),
(146, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:42:17', '2019-08-13 02:41:17', 0, 1, 1),
(147, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:43:07', '2019-08-13 02:42:07', 0, 1, 1),
(148, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:43:32', '2019-08-13 02:42:32', 0, 1, 1),
(149, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:43:44', '2019-08-13 02:42:44', 0, 1, 1),
(150, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:43:58', '2019-08-13 02:42:58', 0, 1, 1),
(151, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:44:15', '2019-08-13 02:43:15', 0, 1, 1),
(152, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:44:23', '2019-08-13 02:43:23', 0, 1, 1),
(153, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:44:34', '2019-08-13 02:43:34', 0, 1, 1),
(154, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:44:41', '2019-08-13 02:43:41', 0, 1, 1),
(155, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:44:49', '2019-08-13 02:43:49', 0, 1, 1),
(156, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[ADMIN_MESSAGE_ARTICLE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:45:18', '2019-08-13 02:44:18', 0, 1, 1),
(157, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 02:45:59', '2019-08-13 02:44:59', 0, 1, 1),
(158, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_ARTICE_MESSAGE_SUCCESS_MOVE_TO_TRASH]', 'success', 'delete', 5000, '2019-08-13 03:07:24', '2019-08-13 03:06:24', 0, 1, 1),
(159, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 03:12:05', '2019-08-13 03:11:05', 0, 1, 1),
(160, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_ARTICE_MESSAGE_SUCCESS_MOVE_TO_TRASH]', 'success', 'delete', 5000, '2019-08-13 03:14:21', '2019-08-13 03:13:21', 0, 1, 1),
(161, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[ADMIN_MESSAGE_ARTICLE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 03:15:36', '2019-08-13 03:14:36', 0, 1, 1),
(162, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_ARTICLE_MESSAGE_SUCCESS_MOVE_TO_TRASH]', 'success', 'delete', 5000, '2019-08-13 03:15:40', '2019-08-13 03:14:40', 0, 1, 1),
(163, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 03:16:19', '2019-08-13 03:15:19', 0, 1, 1),
(164, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 03:17:09', '2019-08-13 03:16:09', 0, 1, 1),
(165, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 03:20:19', '2019-08-13 03:19:19', 0, 1, 1),
(166, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 03:20:38', '2019-08-13 03:19:38', 0, 1, 1),
(167, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[ADMIN_MESSAGE_ARTICLE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 03:20:46', '2019-08-13 03:19:46', 0, 1, 1),
(168, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 03:25:24', '2019-08-13 03:24:24', 0, 1, 1),
(169, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_ARTICLE_MESSAGE_SUCCESS_MOVE_TO_TRASH]', 'success', 'delete', 5000, '2019-08-13 03:25:38', '2019-08-13 03:24:38', 0, 1, 1),
(170, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_ARTICLE_MESSAGE_SUCCESS_MOVE_TO_TRASH]', 'success', 'delete', 5000, '2019-08-13 03:30:50', '2019-08-13 03:29:51', 0, 1, 1),
(171, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', 'Sikeres mentés', 'success', 'save', 5000, '2019-08-13 03:46:29', '2019-08-13 03:45:29', 0, 1, 1),
(172, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:01:18', '2019-08-13 04:00:18', 0, 1, 1),
(173, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:01:24', '2019-08-13 04:00:24', 0, 1, 1),
(174, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:01:44', '2019-08-13 04:00:44', 0, 1, 1),
(175, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:01:55', '2019-08-13 04:00:55', 0, 1, 1),
(176, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:02:03', '2019-08-13 04:01:03', 0, 1, 1),
(177, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:03:11', '2019-08-13 04:02:11', 0, 1, 1),
(178, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:46:51', '2019-08-13 04:45:51', 0, 1, 1),
(179, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:47:22', '2019-08-13 04:46:22', 0, 1, 1),
(180, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:47:39', '2019-08-13 04:46:39', 0, 1, 1),
(181, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:47:46', '2019-08-13 04:46:46', 0, 1, 1),
(182, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:47:52', '2019-08-13 04:46:52', 0, 1, 1);
INSERT INTO `cb_message` (`id`, `user_id`, `session_id`, `device`, `title`, `message`, `type`, `style`, `time`, `valid_time`, `date_time`, `multishow`, `delivered`, `archive`) VALUES
(183, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:48:01', '2019-08-13 04:47:01', 0, 1, 1),
(184, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:48:07', '2019-08-13 04:47:07', 0, 1, 1),
(185, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:48:15', '2019-08-13 04:47:15', 0, 1, 1),
(186, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:48:24', '2019-08-13 04:47:24', 0, 1, 1),
(187, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:48:30', '2019-08-13 04:47:30', 0, 1, 1),
(188, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:49:07', '2019-08-13 04:48:07', 0, 1, 1),
(189, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:49:16', '2019-08-13 04:48:16', 0, 1, 1),
(190, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:49:25', '2019-08-13 04:48:25', 0, 1, 1),
(191, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:49:35', '2019-08-13 04:48:35', 0, 1, 1),
(192, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:50:05', '2019-08-13 04:49:05', 0, 1, 1),
(193, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:50:33', '2019-08-13 04:49:33', 0, 1, 1),
(194, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 04:50:46', '2019-08-13 04:49:46', 0, 1, 1),
(195, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 05:05:22', '2019-08-13 05:04:22', 0, 1, 1),
(196, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 05:05:34', '2019-08-13 05:04:34', 0, 1, 1),
(197, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 05:05:49', '2019-08-13 05:04:49', 0, 1, 1),
(198, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 05:05:51', '2019-08-13 05:04:51', 0, 1, 1),
(199, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 05:06:02', '2019-08-13 05:05:02', 0, 1, 1),
(200, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 05:06:11', '2019-08-13 05:05:11', 0, 1, 1),
(201, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 05:06:26', '2019-08-13 05:05:26', 0, 1, 1),
(202, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 05:06:35', '2019-08-13 05:05:35', 0, 1, 1),
(203, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 05:06:43', '2019-08-13 05:05:43', 0, 1, 1),
(204, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 14:32:36', '2019-08-13 14:31:36', 0, 1, 1),
(205, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 14:32:45', '2019-08-13 14:31:45', 0, 1, 1),
(206, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 14:32:54', '2019-08-13 14:31:54', 0, 1, 1),
(207, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 14:33:06', '2019-08-13 14:32:06', 0, 1, 1),
(208, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 14:33:19', '2019-08-13 14:32:19', 0, 1, 1),
(209, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 14:33:33', '2019-08-13 14:32:33', 0, 1, 1),
(210, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 14:47:48', '2019-08-13 14:46:48', 0, 1, 1),
(211, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_ACCOUNT_MESSAGE_PERMISSION_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 21:14:28', '2019-08-13 21:13:28', 0, 1, 1),
(212, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 21:21:28', '2019-08-13 21:20:28', 0, 1, 1),
(213, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 21:21:36', '2019-08-13 21:20:36', 0, 1, 1),
(214, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 23:22:46', '2019-08-13 23:21:46', 0, 1, 1),
(215, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-13 23:24:03', '2019-08-13 23:23:03', 0, 1, 1),
(216, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-14 02:28:15', '2019-08-14 02:27:15', 0, 1, 1),
(217, 0, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-08-14 03:47:52', '2019-08-14 03:46:52', 0, 1, 1),
(218, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-14 03:47:57', '2019-08-14 03:46:57', 0, 1, 1),
(219, 0, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-08-14 03:53:54', '2019-08-14 03:52:54', 0, 1, 1),
(220, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-14 03:54:02', '2019-08-14 03:53:02', 0, 1, 1),
(221, 1, 'tbyfnbifwwzdtwnye5ms7xbryhm83gnmq4axsij5qnrd52jxwyb2utjp2u88mvuppk8ge75arxx3t6cacj5rd467m2cr7b3ftnmufgwmzu676eyefcqamn3ekpb4czqg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-08-14 04:32:24', '2019-08-14 04:31:24', 0, 1, 1),
(222, 1, 'qvevyh6jkvx32esadurtv3m5aa5jtd6xjk2su5qgadkaqawcxuduihj47rg6y5m6puk3zhpn2x74yrttp3ywpvb4acpvjjtmjf73qhtqyvvcn3w3dpwsc4k3mepq5mys', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-26 06:41:18', '2019-08-26 06:40:18', 0, 1, 1),
(223, 1, 'ypufadk8prad3bdw6xa7ahfhabc6u2ecyufffj3wzaqpxscsxfjj26v2wepmw83yhmib6zvwxzaigr2j6f7umpwhqikyzihb8vqypksiasbmkszgm46hvvgxdcwzi86m', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-08-31 23:59:50', '2019-08-31 23:58:50', 0, 1, 1),
(224, 1, 'qfxczrzzvmbxuf2kbtkzwfi5mnbssa3e7f7mebk3essjmqkxueb6egaisgcpxdzzs7wbu7q33emebjc8t3dvs7igaz3zvc2q5pcavjhmak8vnsuv8ifq462hivbj7piv', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-09 22:45:53', '2019-10-09 22:44:53', 0, 1, 1),
(225, 0, 'jd3incebd3sepxpxq4p7v3xdxc5k7q26mdxtvuzskn3rxbrc6hywuwptcd2ex8vizdn4dzuaeccauurm8nj7zvh7zfdjdnauhpibf2a5j6prn4qf5s6xccgp4dm5c3ky', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-10-09 23:54:31', '2019-10-09 23:53:31', 0, 1, 1),
(226, 0, 'jd3incebd3sepxpxq4p7v3xdxc5k7q26mdxtvuzskn3rxbrc6hywuwptcd2ex8vizdn4dzuaeccauurm8nj7zvh7zfdjdnauhpibf2a5j6prn4qf5s6xccgp4dm5c3ky', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-10-09 23:54:34', '2019-10-09 23:53:34', 0, 1, 1),
(227, 0, 'jd3incebd3sepxpxq4p7v3xdxc5k7q26mdxtvuzskn3rxbrc6hywuwptcd2ex8vizdn4dzuaeccauurm8nj7zvh7zfdjdnauhpibf2a5j6prn4qf5s6xccgp4dm5c3ky', '', '', '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', 'info', 'account_username_empty', 5000, '2019-10-09 23:54:40', '2019-10-09 23:53:40', 0, 1, 1),
(228, 1, 'jd3incebd3sepxpxq4p7v3xdxc5k7q26mdxtvuzskn3rxbrc6hywuwptcd2ex8vizdn4dzuaeccauurm8nj7zvh7zfdjdnauhpibf2a5j6prn4qf5s6xccgp4dm5c3ky', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-10 00:02:07', '2019-10-10 00:01:07', 0, 1, 1),
(229, 1, 'en4bv2duphdinydu7u2c7hsep38ztdvspz4htvr4na2fcxkzenuqzu4shqeuzuk755c7mdif7y5user3ifmp66f7q4asqyj6ewetwgv3qu36sqv2ryxaybzpfwr2pszt', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-10 02:29:27', '2019-10-10 02:28:27', 0, 1, 1),
(230, 1, 'en4bv2duphdinydu7u2c7hsep38ztdvspz4htvr4na2fcxkzenuqzu4shqeuzuk755c7mdif7y5user3ifmp66f7q4asqyj6ewetwgv3qu36sqv2ryxaybzpfwr2pszt', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-10 02:52:40', '2019-10-10 02:51:40', 0, 1, 1),
(231, 1, 'en4bv2duphdinydu7u2c7hsep38ztdvspz4htvr4na2fcxkzenuqzu4shqeuzuk755c7mdif7y5user3ifmp66f7q4asqyj6ewetwgv3qu36sqv2ryxaybzpfwr2pszt', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-10 02:52:44', '2019-10-10 02:51:44', 0, 1, 1),
(232, 1, 'en4bv2duphdinydu7u2c7hsep38ztdvspz4htvr4na2fcxkzenuqzu4shqeuzuk755c7mdif7y5user3ifmp66f7q4asqyj6ewetwgv3qu36sqv2ryxaybzpfwr2pszt', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-10 02:55:22', '2019-10-10 02:54:22', 0, 1, 1),
(233, 1, '75ngjnq2zu5chyiwpa8ukns7utytiiri6pdjbg6hra3f42q86f2xcdy6m4nc3dj4a873cii6xprsdrpdxf6xhdttk2py6cuu8hin7tkjb668xyz63sn7rhis2imfkynm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-10 14:00:14', '2019-10-10 13:59:14', 0, 1, 1),
(234, 0, '75ngjnq2zu5chyiwpa8ukns7utytiiri6pdjbg6hra3f42q86f2xcdy6m4nc3dj4a873cii6xprsdrpdxf6xhdttk2py6cuu8hin7tkjb668xyz63sn7rhis2imfkynm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-10 14:00:27', '2019-10-10 13:59:27', 0, 1, 1),
(235, 1, '75ngjnq2zu5chyiwpa8ukns7utytiiri6pdjbg6hra3f42q86f2xcdy6m4nc3dj4a873cii6xprsdrpdxf6xhdttk2py6cuu8hin7tkjb668xyz63sn7rhis2imfkynm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-10 14:19:36', '2019-10-10 14:18:36', 0, 1, 1),
(236, 0, '75ngjnq2zu5chyiwpa8ukns7utytiiri6pdjbg6hra3f42q86f2xcdy6m4nc3dj4a873cii6xprsdrpdxf6xhdttk2py6cuu8hin7tkjb668xyz63sn7rhis2imfkynm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-10 14:19:43', '2019-10-10 14:18:43', 0, 1, 1),
(237, 1, '75ngjnq2zu5chyiwpa8ukns7utytiiri6pdjbg6hra3f42q86f2xcdy6m4nc3dj4a873cii6xprsdrpdxf6xhdttk2py6cuu8hin7tkjb668xyz63sn7rhis2imfkynm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-10 15:50:21', '2019-10-10 15:49:21', 0, 1, 1),
(238, 0, '75ngjnq2zu5chyiwpa8ukns7utytiiri6pdjbg6hra3f42q86f2xcdy6m4nc3dj4a873cii6xprsdrpdxf6xhdttk2py6cuu8hin7tkjb668xyz63sn7rhis2imfkynm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-11 00:08:37', '2019-10-11 00:07:37', 0, 1, 1),
(239, 1, '75ngjnq2zu5chyiwpa8ukns7utytiiri6pdjbg6hra3f42q86f2xcdy6m4nc3dj4a873cii6xprsdrpdxf6xhdttk2py6cuu8hin7tkjb668xyz63sn7rhis2imfkynm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-11 00:08:43', '2019-10-11 00:07:43', 0, 1, 1),
(240, 0, '75ngjnq2zu5chyiwpa8ukns7utytiiri6pdjbg6hra3f42q86f2xcdy6m4nc3dj4a873cii6xprsdrpdxf6xhdttk2py6cuu8hin7tkjb668xyz63sn7rhis2imfkynm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-11 00:08:45', '2019-10-11 00:07:45', 0, 1, 1),
(241, 1, '75ngjnq2zu5chyiwpa8ukns7utytiiri6pdjbg6hra3f42q86f2xcdy6m4nc3dj4a873cii6xprsdrpdxf6xhdttk2py6cuu8hin7tkjb668xyz63sn7rhis2imfkynm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-11 00:08:53', '2019-10-11 00:07:53', 0, 1, 1),
(242, 1, '75ngjnq2zu5chyiwpa8ukns7utytiiri6pdjbg6hra3f42q86f2xcdy6m4nc3dj4a873cii6xprsdrpdxf6xhdttk2py6cuu8hin7tkjb668xyz63sn7rhis2imfkynm', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 01:33:11', '2019-10-11 01:32:11', 0, 1, 1),
(243, 1, '75ngjnq2zu5chyiwpa8ukns7utytiiri6pdjbg6hra3f42q86f2xcdy6m4nc3dj4a873cii6xprsdrpdxf6xhdttk2py6cuu8hin7tkjb668xyz63sn7rhis2imfkynm', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 01:33:18', '2019-10-11 01:32:18', 0, 1, 1),
(244, 1, '75ngjnq2zu5chyiwpa8ukns7utytiiri6pdjbg6hra3f42q86f2xcdy6m4nc3dj4a873cii6xprsdrpdxf6xhdttk2py6cuu8hin7tkjb668xyz63sn7rhis2imfkynm', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 01:33:27', '2019-10-11 01:32:27', 0, 1, 1),
(245, 1, '75ngjnq2zu5chyiwpa8ukns7utytiiri6pdjbg6hra3f42q86f2xcdy6m4nc3dj4a873cii6xprsdrpdxf6xhdttk2py6cuu8hin7tkjb668xyz63sn7rhis2imfkynm', '', '', '[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 01:56:40', '2019-10-11 01:55:40', 0, 1, 1),
(246, 1, '75ngjnq2zu5chyiwpa8ukns7utytiiri6pdjbg6hra3f42q86f2xcdy6m4nc3dj4a873cii6xprsdrpdxf6xhdttk2py6cuu8hin7tkjb668xyz63sn7rhis2imfkynm', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 01:58:46', '2019-10-11 01:57:46', 0, 1, 1),
(247, 1, '75ngjnq2zu5chyiwpa8ukns7utytiiri6pdjbg6hra3f42q86f2xcdy6m4nc3dj4a873cii6xprsdrpdxf6xhdttk2py6cuu8hin7tkjb668xyz63sn7rhis2imfkynm', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 01:59:00', '2019-10-11 01:58:00', 0, 1, 1),
(248, 1, 'riqqtyuqfbwuvq3ih2g7j5myftpfgs3xp8hs5erw84k4v7cwxd4wjekxqzd6r78ydkf6kzyew4r22uj6bsfaqdr3p8dai5hdbhmz6wbfn3x7g8wsberayjibe5ae7gdk', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-11 15:19:03', '2019-10-11 15:18:03', 0, 1, 1),
(249, 0, 'riqqtyuqfbwuvq3ih2g7j5myftpfgs3xp8hs5erw84k4v7cwxd4wjekxqzd6r78ydkf6kzyew4r22uj6bsfaqdr3p8dai5hdbhmz6wbfn3x7g8wsberayjibe5ae7gdk', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-11 15:21:04', '2019-10-11 15:20:04', 0, 1, 1),
(250, 1, 'riqqtyuqfbwuvq3ih2g7j5myftpfgs3xp8hs5erw84k4v7cwxd4wjekxqzd6r78ydkf6kzyew4r22uj6bsfaqdr3p8dai5hdbhmz6wbfn3x7g8wsberayjibe5ae7gdk', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-11 15:21:34', '2019-10-11 15:20:34', 0, 1, 1),
(251, 1, 'riqqtyuqfbwuvq3ih2g7j5myftpfgs3xp8hs5erw84k4v7cwxd4wjekxqzd6r78ydkf6kzyew4r22uj6bsfaqdr3p8dai5hdbhmz6wbfn3x7g8wsberayjibe5ae7gdk', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 15:25:50', '2019-10-11 15:24:50', 0, 1, 1),
(252, 1, 'riqqtyuqfbwuvq3ih2g7j5myftpfgs3xp8hs5erw84k4v7cwxd4wjekxqzd6r78ydkf6kzyew4r22uj6bsfaqdr3p8dai5hdbhmz6wbfn3x7g8wsberayjibe5ae7gdk', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 15:26:28', '2019-10-11 15:25:28', 0, 1, 1),
(253, 1, 'riqqtyuqfbwuvq3ih2g7j5myftpfgs3xp8hs5erw84k4v7cwxd4wjekxqzd6r78ydkf6kzyew4r22uj6bsfaqdr3p8dai5hdbhmz6wbfn3x7g8wsberayjibe5ae7gdk', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 15:26:35', '2019-10-11 15:25:35', 0, 1, 1),
(254, 1, 'riqqtyuqfbwuvq3ih2g7j5myftpfgs3xp8hs5erw84k4v7cwxd4wjekxqzd6r78ydkf6kzyew4r22uj6bsfaqdr3p8dai5hdbhmz6wbfn3x7g8wsberayjibe5ae7gdk', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 15:26:42', '2019-10-11 15:25:42', 0, 1, 1),
(255, 1, 'riqqtyuqfbwuvq3ih2g7j5myftpfgs3xp8hs5erw84k4v7cwxd4wjekxqzd6r78ydkf6kzyew4r22uj6bsfaqdr3p8dai5hdbhmz6wbfn3x7g8wsberayjibe5ae7gdk', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 15:26:49', '2019-10-11 15:25:49', 0, 1, 1),
(256, 1, 'riqqtyuqfbwuvq3ih2g7j5myftpfgs3xp8hs5erw84k4v7cwxd4wjekxqzd6r78ydkf6kzyew4r22uj6bsfaqdr3p8dai5hdbhmz6wbfn3x7g8wsberayjibe5ae7gdk', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 15:26:58', '2019-10-11 15:25:58', 0, 1, 1),
(257, 1, 'riqqtyuqfbwuvq3ih2g7j5myftpfgs3xp8hs5erw84k4v7cwxd4wjekxqzd6r78ydkf6kzyew4r22uj6bsfaqdr3p8dai5hdbhmz6wbfn3x7g8wsberayjibe5ae7gdk', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 15:27:07', '2019-10-11 15:26:07', 0, 1, 1),
(258, 1, 'riqqtyuqfbwuvq3ih2g7j5myftpfgs3xp8hs5erw84k4v7cwxd4wjekxqzd6r78ydkf6kzyew4r22uj6bsfaqdr3p8dai5hdbhmz6wbfn3x7g8wsberayjibe5ae7gdk', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 15:27:17', '2019-10-11 15:26:17', 0, 1, 1),
(259, 1, 'riqqtyuqfbwuvq3ih2g7j5myftpfgs3xp8hs5erw84k4v7cwxd4wjekxqzd6r78ydkf6kzyew4r22uj6bsfaqdr3p8dai5hdbhmz6wbfn3x7g8wsberayjibe5ae7gdk', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 15:27:32', '2019-10-11 15:26:32', 0, 1, 1),
(260, 1, 'riqqtyuqfbwuvq3ih2g7j5myftpfgs3xp8hs5erw84k4v7cwxd4wjekxqzd6r78ydkf6kzyew4r22uj6bsfaqdr3p8dai5hdbhmz6wbfn3x7g8wsberayjibe5ae7gdk', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 15:27:39', '2019-10-11 15:26:39', 0, 1, 1),
(261, 1, 'riqqtyuqfbwuvq3ih2g7j5myftpfgs3xp8hs5erw84k4v7cwxd4wjekxqzd6r78ydkf6kzyew4r22uj6bsfaqdr3p8dai5hdbhmz6wbfn3x7g8wsberayjibe5ae7gdk', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 15:27:46', '2019-10-11 15:26:46', 0, 1, 1),
(262, 1, 'riqqtyuqfbwuvq3ih2g7j5myftpfgs3xp8hs5erw84k4v7cwxd4wjekxqzd6r78ydkf6kzyew4r22uj6bsfaqdr3p8dai5hdbhmz6wbfn3x7g8wsberayjibe5ae7gdk', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-11 15:28:14', '2019-10-11 15:27:14', 0, 1, 1),
(263, 1, 'wdtj6nm26vjztyk6a26sw5vv5uig6zhr4nshtw5i2xzvms6s3f68x7jq2rmwv2sfw8dfbjx3qds6uhyiisdsvii8xfh857hqkb5i738sv4jjmwqe5zvvq6nqcv2n3ncf', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-12 00:40:13', '2019-10-12 00:39:13', 0, 0, 1),
(264, 1, '2aaic7wvi5djq4yyd7h6hh7mjmmy6t5ywb7vtzmwum4zwgt2rm68pwxwb6jue48yemnx6a6m3xepjvrvw3heav3mmfeakcdfjztf6we75qgxs2kcjyqaj6pyvsts2xf2', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-13 00:14:48', '2019-10-13 00:13:48', 0, 1, 1),
(265, 0, '2aaic7wvi5djq4yyd7h6hh7mjmmy6t5ywb7vtzmwum4zwgt2rm68pwxwb6jue48yemnx6a6m3xepjvrvw3heav3mmfeakcdfjztf6we75qgxs2kcjyqaj6pyvsts2xf2', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-13 00:14:53', '2019-10-13 00:13:53', 0, 1, 1),
(266, 1, '2aaic7wvi5djq4yyd7h6hh7mjmmy6t5ywb7vtzmwum4zwgt2rm68pwxwb6jue48yemnx6a6m3xepjvrvw3heav3mmfeakcdfjztf6we75qgxs2kcjyqaj6pyvsts2xf2', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-13 00:14:57', '2019-10-13 00:13:57', 0, 1, 1),
(267, 1, '2aaic7wvi5djq4yyd7h6hh7mjmmy6t5ywb7vtzmwum4zwgt2rm68pwxwb6jue48yemnx6a6m3xepjvrvw3heav3mmfeakcdfjztf6we75qgxs2kcjyqaj6pyvsts2xf2', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-13 04:11:02', '2019-10-13 04:10:02', 0, 1, 1),
(268, 1, '2aaic7wvi5djq4yyd7h6hh7mjmmy6t5ywb7vtzmwum4zwgt2rm68pwxwb6jue48yemnx6a6m3xepjvrvw3heav3mmfeakcdfjztf6we75qgxs2kcjyqaj6pyvsts2xf2', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-13 04:11:16', '2019-10-13 04:10:16', 0, 1, 1),
(269, 1, '2aaic7wvi5djq4yyd7h6hh7mjmmy6t5ywb7vtzmwum4zwgt2rm68pwxwb6jue48yemnx6a6m3xepjvrvw3heav3mmfeakcdfjztf6we75qgxs2kcjyqaj6pyvsts2xf2', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-13 04:11:52', '2019-10-13 04:10:52', 0, 1, 1),
(270, 1, '2aaic7wvi5djq4yyd7h6hh7mjmmy6t5ywb7vtzmwum4zwgt2rm68pwxwb6jue48yemnx6a6m3xepjvrvw3heav3mmfeakcdfjztf6we75qgxs2kcjyqaj6pyvsts2xf2', '', '', 'ADMIN_MESSAGE_ACCOUNT_SAVE_SUCCESS', 'success', 'save', 5000, '2019-10-13 04:31:06', '2019-10-13 04:30:06', 0, 1, 1),
(271, 1, '2aaic7wvi5djq4yyd7h6hh7mjmmy6t5ywb7vtzmwum4zwgt2rm68pwxwb6jue48yemnx6a6m3xepjvrvw3heav3mmfeakcdfjztf6we75qgxs2kcjyqaj6pyvsts2xf2', '', '', 'ADMIN_MESSAGE_ACCOUNT_SAVE_SUCCESS', 'success', 'save', 5000, '2019-10-13 04:47:29', '2019-10-13 04:46:29', 0, 1, 1),
(272, 0, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ACCOUNT_ERROR_LOGIN_INVALID]', 'info', 'account_login', 5000, '2019-10-14 13:20:10', '2019-10-14 13:19:10', 0, 1, 1),
(273, 0, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ACCOUNT_ERROR_LOGIN_INVALID]', 'info', 'account_login', 5000, '2019-10-14 13:20:18', '2019-10-14 13:19:18', 0, 1, 1),
(274, 0, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ACCOUNT_ERROR_LOGIN_INVALID]', 'info', 'account_login', 5000, '2019-10-14 13:20:23', '2019-10-14 13:19:23', 0, 1, 1),
(275, 0, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ACCOUNT_ERROR_LOGIN_INVALID]', 'info', 'account_login', 5000, '2019-10-14 13:20:38', '2019-10-14 13:19:38', 0, 1, 1),
(276, 1, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-14 13:21:06', '2019-10-14 13:20:06', 0, 1, 1),
(277, 0, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-14 14:17:27', '2019-10-14 14:16:27', 0, 1, 1),
(278, 1, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-14 14:19:46', '2019-10-14 14:18:46', 0, 1, 1),
(279, 1, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-16 16:15:54', '2019-10-16 16:14:54', 0, 1, 1),
(280, 1, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-16 16:16:03', '2019-10-16 16:15:03', 0, 1, 1),
(281, 1, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-16 16:16:12', '2019-10-16 16:15:12', 0, 1, 1),
(282, 1, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-16 16:16:27', '2019-10-16 16:15:27', 0, 1, 1),
(283, 1, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-16 16:16:40', '2019-10-16 16:15:40', 0, 1, 1),
(284, 0, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-18 01:24:08', '2019-10-18 01:23:08', 0, 1, 1),
(285, 1, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-18 01:24:13', '2019-10-18 01:23:13', 0, 1, 1),
(286, 0, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-18 01:24:18', '2019-10-18 01:23:18', 0, 1, 1),
(287, 1, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-18 01:26:17', '2019-10-18 01:25:17', 0, 1, 1),
(288, 1, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', 'ADMIN_MESSAGE_ACCOUNT_SAVE_SUCCESS', 'success', 'save', 5000, '2019-10-18 01:43:43', '2019-10-18 01:42:43', 0, 1, 1),
(289, 1, 'zheajpvxaha6src4v8rjn6rfcpyyshtzwdecpaxk6ux23pkwevmfuktsipmaveq2xmxjjyitwv8eqzetxqpdsbuusvzb6778re5x3ptqpian7uqfxehdisb6n7n4ha2e', '', '', 'ADMIN_MESSAGE_ACCOUNT_SAVE_SUCCESS', 'success', 'save', 5000, '2019-10-18 01:46:26', '2019-10-18 01:45:26', 0, 1, 1),
(290, 1, 'qxrp7np25izjpuynr28xkzkedi2n5efvsfjzyfd7vviasevrrd5bs2r8abedhabeqzfythjbmi36ffmtb8dgi5vm4ywxfq5pn2mvmyc5n78iu2cnai6fpa45jkwpbuhp', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-18 20:17:53', '2019-10-18 20:16:53', 0, 1, 1),
(291, 1, 'rmyj66gh566e2b36my6fbhtycsuvp4cgf33pxjiar6fw8pmiztbmvdxpsgnj8f4i4n7k6upk8x5azdwe423fjasdxy76t8caurvxy3yx33dqmmbezysvups7rjbx5pja', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-19 09:17:14', '2019-10-19 09:16:14', 0, 1, 1),
(292, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-19 14:00:23', '2019-10-19 13:59:23', 0, 1, 1),
(293, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-19 14:02:59', '2019-10-19 14:01:59', 0, 1, 1),
(294, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-19 14:03:18', '2019-10-19 14:02:18', 0, 1, 1),
(295, 0, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-19 14:25:21', '2019-10-19 14:24:21', 0, 1, 1),
(296, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-19 14:25:28', '2019-10-19 14:24:28', 0, 1, 1),
(297, 0, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-19 14:25:38', '2019-10-19 14:24:38', 0, 1, 1),
(298, 0, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ACCOUNT_ERROR_USERPASSWORD_EMPTY]', 'info', 'account_password_empty', 5000, '2019-10-19 14:25:44', '2019-10-19 14:24:44', 0, 1, 1),
(299, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-19 14:25:47', '2019-10-19 14:24:47', 0, 1, 1),
(300, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-19 14:26:43', '2019-10-19 14:25:43', 0, 1, 1),
(301, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-19 14:27:58', '2019-10-19 14:26:58', 0, 1, 1),
(302, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-19 14:57:58', '2019-10-19 14:56:58', 0, 1, 1),
(303, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-19 14:58:11', '2019-10-19 14:57:11', 0, 1, 1),
(304, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-19 15:00:03', '2019-10-19 14:59:03', 0, 1, 1),
(305, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-19 15:00:44', '2019-10-19 14:59:44', 0, 1, 1),
(306, 0, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-19 16:05:13', '2019-10-19 16:04:13', 0, 1, 1),
(307, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-19 16:05:18', '2019-10-19 16:04:18', 0, 1, 1),
(308, 0, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-19 16:08:26', '2019-10-19 16:07:26', 0, 1, 1),
(309, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-19 16:53:14', '2019-10-19 16:52:14', 0, 1, 1),
(310, 0, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-20 01:57:11', '2019-10-20 01:56:11', 0, 1, 1),
(311, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-20 01:57:22', '2019-10-20 01:56:22', 0, 1, 1),
(312, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-20 02:00:03', '2019-10-20 01:59:03', 0, 1, 1),
(313, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-20 02:00:56', '2019-10-20 01:59:56', 0, 1, 1),
(314, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-20 02:14:08', '2019-10-20 02:13:08', 0, 1, 1),
(315, 0, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-20 02:43:34', '2019-10-20 02:42:34', 0, 1, 1),
(316, 1, 'pq23jixb57j4e8xacvzryyfrxifiekpmbuekifnkrrtzyjyjysu8e3axeixtabtfucjrs667t5crazw2sxf6i8rs2uf22qh8cxzzpn22urktimd3jnvzjbmppxagj8pg', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-20 02:43:37', '2019-10-20 02:42:37', 0, 1, 1),
(317, 1, 'xzin6bax5n3dzmhfdqb5iagcq7myyjzcx66d8m5v2dnh58jb2syg8snjdx2abz8r8nqkvidcj7e2vdhu45yksa3a4w7skgukmjvcaevyc2cduwtaus5nqb7e3cydjgud', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-20 13:11:56', '2019-10-20 13:10:56', 0, 1, 1),
(318, 1, 'rv8wbnkvhqqe8bkp35n6hdkgqwpdqjnv23ie2tgz2mfurbva5u7axvp8sit4w2tfbnnx4iz3qw2gb47m5k53wdqqgt6j8f6xqi4vpsp4mb3mk5cmnrp3gnx4mh4xadzt', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-20 18:12:21', '2019-10-20 18:11:22', 0, 1, 1),
(319, 0, 'rv8wbnkvhqqe8bkp35n6hdkgqwpdqjnv23ie2tgz2mfurbva5u7axvp8sit4w2tfbnnx4iz3qw2gb47m5k53wdqqgt6j8f6xqi4vpsp4mb3mk5cmnrp3gnx4mh4xadzt', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-20 18:13:06', '2019-10-20 18:12:06', 0, 1, 1),
(320, 1, 'rv8wbnkvhqqe8bkp35n6hdkgqwpdqjnv23ie2tgz2mfurbva5u7axvp8sit4w2tfbnnx4iz3qw2gb47m5k53wdqqgt6j8f6xqi4vpsp4mb3mk5cmnrp3gnx4mh4xadzt', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-20 18:13:26', '2019-10-20 18:12:26', 0, 1, 1),
(321, 1, 'zerimrgibjy5si4uu8prdwvh3fk3u62qa6gtdf2c537wiqz76kux6igdniqttixrgkubfv3hfg8ki33z6chk75yfeww3dfpbxc57bksu2exc7mq8h2wbhudzb6q65yvx', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-21 15:02:03', '2019-10-21 15:01:03', 0, 1, 1),
(322, 1, '3ha2tpqkwsjs3jbuhq5gcxgkub6szaxmwwrx7vuhugjqhek3hgu775qpva4tzxr2fzskd33rxmqdrq243bvrknzwbwx4jj7phq7eeqgchqkwj88h853iz7t4b6s5fxii', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-21 15:38:04', '2019-10-21 15:37:04', 0, 1, 1),
(323, 1, 'f3bmc8r5dd7s64fg7a8hwuap7dq8z4e843kjxfp8xig4hjbcdh825qne8ix58xwv2ddc6kggbnzumzb2h6b5cyi7nnwrrf4bt4gc2ybt657hdmqp4c2viiejx3pkx8t7', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-21 15:50:12', '2019-10-21 15:49:12', 0, 1, 1),
(324, 1, '36nsv3aiue5izwm2ei25eqrrz6r8syknv7rgcd2au3cmdccvcaegfh6bgt5qq2fdy5zrd3ytkd8v684fzbsu4az4skzwf7y4nacjndmu86d5srsa3fewcerddzi788na', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-21 15:51:41', '2019-10-21 15:50:41', 0, 1, 1),
(325, 1, 's8r6icyzz3zxrbwx5iyxcpuiddftsnygfnhajf2cs5gi7acnvp2q6njdb27vh4wkb3t6ph72j2bwh34x27fq6fer3pc7j36juqqfcbp4k3xtmc5x6jqn3erzcpa7jbi8', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-21 15:55:51', '2019-10-21 15:54:51', 0, 1, 1),
(326, 1, '6fypwqn8qyth3me4v6e6vifj5vbc85xcqjxk45xmqdfeuwuuwnt4cew36iuhckggpuv8vjxnuz4h5ztktgvub3jc4hyhgj55j63ccksftbbv37x52xkpitrvbmftyb4m', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-21 15:58:10', '2019-10-21 15:57:10', 0, 1, 1),
(327, 1, 'ug4vq2f4yzy3qtgwwsdmucfj4hxdgsndz5aguxaf7qwgmbc2fhtcy66jpgtpytfqine84mifex26e33v3yqsffn7xpzbc5qhy7iapnxkdg33e6qv7psi6wt4xdy7yewj', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-21 15:59:09', '2019-10-21 15:58:09', 0, 1, 1),
(328, 1, 'kwbamgm574566dyznretdyi3jmg3mutyhtugxx3jkukhirtn6jaqayhtkzjixy4grriaytjvfgmx4dtqadafnimsfeuqhhpacff7csxrdsrwnut24vwmxf6cksqskxrf', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-21 16:01:10', '2019-10-21 16:00:10', 0, 1, 1),
(329, 1, 'kwbamgm574566dyznretdyi3jmg3mutyhtugxx3jkukhirtn6jaqayhtkzjixy4grriaytjvfgmx4dtqadafnimsfeuqhhpacff7csxrdsrwnut24vwmxf6cksqskxrf', '', '', '[LANG_ADMIN_ACCOUNT_USER_THE_PASSWORD_TO_WEAK]', 'info', '', 5000, '2019-10-21 22:42:35', '2019-10-21 22:41:35', 0, 1, 1),
(330, 1, 'kwbamgm574566dyznretdyi3jmg3mutyhtugxx3jkukhirtn6jaqayhtkzjixy4grriaytjvfgmx4dtqadafnimsfeuqhhpacff7csxrdsrwnut24vwmxf6cksqskxrf', '', '', '[LANG_ADMIN_ACCOUNT_USER_THE_PASSWORD_TO_WEAK]', 'info', '', 5000, '2019-10-21 22:53:15', '2019-10-21 22:52:15', 0, 1, 1),
(331, 1, 'kwbamgm574566dyznretdyi3jmg3mutyhtugxx3jkukhirtn6jaqayhtkzjixy4grriaytjvfgmx4dtqadafnimsfeuqhhpacff7csxrdsrwnut24vwmxf6cksqskxrf', '', '', '[LANG_ADMIN_ACCOUNT_USER_THE_PASSWORD_TO_WEAK]', 'info', '', 5000, '2019-10-21 22:53:34', '2019-10-21 22:52:34', 0, 1, 1),
(332, 1, 'kwbamgm574566dyznretdyi3jmg3mutyhtugxx3jkukhirtn6jaqayhtkzjixy4grriaytjvfgmx4dtqadafnimsfeuqhhpacff7csxrdsrwnut24vwmxf6cksqskxrf', '', '', '[LANG_ADMIN_ACCOUNT_USER_THE_PASSWORD_TO_WEAK]', 'info', '', 5000, '2019-10-21 22:54:58', '2019-10-21 22:53:58', 0, 1, 1),
(333, 1, 'kwbamgm574566dyznretdyi3jmg3mutyhtugxx3jkukhirtn6jaqayhtkzjixy4grriaytjvfgmx4dtqadafnimsfeuqhhpacff7csxrdsrwnut24vwmxf6cksqskxrf', '', '', '[LANG_ADMIN_ACCOUNT_USER_THE_PASSWORD_TO_WEAK]', 'info', '', 5000, '2019-10-21 22:55:53', '2019-10-21 22:54:53', 0, 1, 1),
(334, 1, 'kwbamgm574566dyznretdyi3jmg3mutyhtugxx3jkukhirtn6jaqayhtkzjixy4grriaytjvfgmx4dtqadafnimsfeuqhhpacff7csxrdsrwnut24vwmxf6cksqskxrf', '', '', '[LANG_ADMIN_ACCOUNT_USER_THE_PASSWORD_TO_WEAK]', 'info', '', 5000, '2019-10-21 22:55:56', '2019-10-21 22:54:56', 0, 1, 1),
(335, 1, 'bnriemet75pgk2vxgzrgi5qemej3p8w82ywbz4qqrcrdda8iycecbe7sam4u3j8iw8tkic4m55gna57x4h8zygwpira8umbvhh67v28fvwt7hmtk8gqvztexynv27r7e', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-23 11:06:33', '2019-10-23 11:05:33', 0, 1, 1),
(336, 1, 'bnriemet75pgk2vxgzrgi5qemej3p8w82ywbz4qqrcrdda8iycecbe7sam4u3j8iw8tkic4m55gna57x4h8zygwpira8umbvhh67v28fvwt7hmtk8gqvztexynv27r7e', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-23 16:00:10', '2019-10-23 15:59:10', 0, 1, 1),
(337, 1, 'bnriemet75pgk2vxgzrgi5qemej3p8w82ywbz4qqrcrdda8iycecbe7sam4u3j8iw8tkic4m55gna57x4h8zygwpira8umbvhh67v28fvwt7hmtk8gqvztexynv27r7e', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-23 16:00:32', '2019-10-23 15:59:32', 0, 1, 1),
(338, 1, 'bnriemet75pgk2vxgzrgi5qemej3p8w82ywbz4qqrcrdda8iycecbe7sam4u3j8iw8tkic4m55gna57x4h8zygwpira8umbvhh67v28fvwt7hmtk8gqvztexynv27r7e', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-23 16:00:42', '2019-10-23 15:59:42', 0, 1, 1),
(339, 1, 'bnriemet75pgk2vxgzrgi5qemej3p8w82ywbz4qqrcrdda8iycecbe7sam4u3j8iw8tkic4m55gna57x4h8zygwpira8umbvhh67v28fvwt7hmtk8gqvztexynv27r7e', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-23 16:00:50', '2019-10-23 15:59:50', 0, 1, 1),
(340, 1, 'bnriemet75pgk2vxgzrgi5qemej3p8w82ywbz4qqrcrdda8iycecbe7sam4u3j8iw8tkic4m55gna57x4h8zygwpira8umbvhh67v28fvwt7hmtk8gqvztexynv27r7e', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_DELETE_SUCCESS]', 'success', 'save', 5000, '2019-10-23 16:01:47', '2019-10-23 16:00:47', 0, 1, 1),
(341, 1, 'euxczcujnjnayy5jy5sehq42mpjn35pnjkgpc3fdtxubjk5pkr472t252yujanktymdufgb7mrpss77tsfyzz5rgfnzumzizc3xjmshizy2bivznwfqjjvi2wm4w5q7h', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-28 16:01:39', '2019-10-28 16:00:39', 0, 1, 1),
(342, 1, 'euxczcujnjnayy5jy5sehq42mpjn35pnjkgpc3fdtxubjk5pkr472t252yujanktymdufgb7mrpss77tsfyzz5rgfnzumzizc3xjmshizy2bivznwfqjjvi2wm4w5q7h', '', '', '[LANG_ADMIN_ACCOUNT_USER_THE_PASSWORD_MUST_FILLED]', 'info', '', 5000, '2019-10-28 16:12:50', '2019-10-28 16:11:50', 0, 1, 1),
(343, 1, 'euxczcujnjnayy5jy5sehq42mpjn35pnjkgpc3fdtxubjk5pkr472t252yujanktymdufgb7mrpss77tsfyzz5rgfnzumzizc3xjmshizy2bivznwfqjjvi2wm4w5q7h', '', '', '[LANG_ADMIN_ACCOUNT_USER_THE_PASSWORD_MUST_FILLED]', 'info', '', 5000, '2019-10-28 16:13:12', '2019-10-28 16:12:12', 0, 1, 1),
(344, 1, 'euxczcujnjnayy5jy5sehq42mpjn35pnjkgpc3fdtxubjk5pkr472t252yujanktymdufgb7mrpss77tsfyzz5rgfnzumzizc3xjmshizy2bivznwfqjjvi2wm4w5q7h', '', '', '[LANG_ADMIN_ACCOUNT_USER_THE_PASSWORD_MUST_FILLED]', 'info', '', 5000, '2019-10-28 16:15:03', '2019-10-28 16:14:03', 0, 1, 1),
(345, 1, 'euxczcujnjnayy5jy5sehq42mpjn35pnjkgpc3fdtxubjk5pkr472t252yujanktymdufgb7mrpss77tsfyzz5rgfnzumzizc3xjmshizy2bivznwfqjjvi2wm4w5q7h', '', '', '[LANG_ADMIN_ACCOUNT_USER_THE_PASSWORD_MUST_FILLED]', 'info', '', 5000, '2019-10-28 16:15:30', '2019-10-28 16:14:30', 0, 1, 1),
(346, 1, '7357zm7ntd6gub7shwetwxu5iuqbngx2pm6t7paaqfhv4et7izqb264fq3p5hf3k2jguqznsucpicwppabspnkkeq6gipdddpzfwuc2j3y8rpmmgpbbvkpcu6rbgxpj2', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-29 14:09:53', '2019-10-29 14:08:53', 0, 1, 1),
(347, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-29 21:24:54', '2019-10-29 21:23:54', 0, 1, 1),
(348, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 00:29:57', '2019-10-30 00:28:57', 0, 1, 1),
(349, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 00:30:32', '2019-10-30 00:29:32', 0, 1, 1),
(350, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 00:30:59', '2019-10-30 00:29:59', 0, 1, 1),
(351, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 00:31:17', '2019-10-30 00:30:17', 0, 1, 1),
(352, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 00:31:33', '2019-10-30 00:30:33', 0, 1, 1),
(353, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 00:31:51', '2019-10-30 00:30:51', 0, 1, 1),
(354, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 00:34:05', '2019-10-30 00:33:05', 0, 1, 1),
(355, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 00:34:41', '2019-10-30 00:33:41', 0, 1, 1),
(356, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 00:58:59', '2019-10-30 00:57:59', 0, 1, 1),
(357, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 01:04:01', '2019-10-30 01:03:01', 0, 1, 1),
(358, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 01:11:05', '2019-10-30 01:10:05', 0, 1, 1),
(359, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 01:11:25', '2019-10-30 01:10:25', 0, 1, 1),
(360, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_DELETE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 01:28:58', '2019-10-30 01:27:58', 0, 1, 1),
(361, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 01:33:00', '2019-10-30 01:32:00', 0, 1, 1),
(362, 0, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-30 01:33:14', '2019-10-30 01:32:14', 0, 1, 1),
(363, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-30 01:33:16', '2019-10-30 01:32:16', 0, 1, 1),
(364, 0, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-30 01:39:42', '2019-10-30 01:38:42', 0, 1, 1);
INSERT INTO `cb_message` (`id`, `user_id`, `session_id`, `device`, `title`, `message`, `type`, `style`, `time`, `valid_time`, `date_time`, `multishow`, `delivered`, `archive`) VALUES
(365, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-30 01:39:45', '2019-10-30 01:38:45', 0, 1, 1),
(366, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 01:40:44', '2019-10-30 01:39:44', 0, 1, 1),
(367, 0, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-30 01:40:57', '2019-10-30 01:39:57', 0, 1, 1),
(368, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-30 01:41:00', '2019-10-30 01:40:00', 0, 1, 1),
(369, 0, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-30 01:41:13', '2019-10-30 01:40:13', 0, 1, 1),
(370, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-30 01:41:16', '2019-10-30 01:40:16', 0, 1, 1),
(371, 0, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-30 01:42:00', '2019-10-30 01:41:00', 0, 1, 1),
(372, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-30 01:42:11', '2019-10-30 01:41:11', 0, 1, 1),
(373, 0, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-30 01:42:23', '2019-10-30 01:41:23', 0, 1, 1),
(374, 0, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-30 01:43:15', '2019-10-30 01:42:15', 0, 1, 1),
(375, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-30 01:44:30', '2019-10-30 01:43:30', 0, 1, 1),
(376, 0, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-10-30 01:44:36', '2019-10-30 01:43:36', 0, 1, 1),
(377, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-30 01:44:38', '2019-10-30 01:43:38', 0, 1, 1),
(378, 1, 'jzehqhtwsj7zrqmifi7gi2xck8j7pqvsfv4ypqakuqkeigur6kajvhjsgudkapta7cn32nqj4mnvkd2qzuia28py3srrxyfqi6snmefn6syp6dik3n5g3ybjg5piyqum', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 02:00:58', '2019-10-30 01:59:58', 0, 1, 1),
(379, 1, 'iemr5vwkyscqfejckehjq88etp3afy8wdvittngz2mvpynite6jetevmj64mfpsreeggv8rn6zhx6zjivjngu5vf3a24vcaz83cb2t5rse84aymr4rk8prxzqzspd2qc', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-30 13:28:01', '2019-10-30 13:27:01', 0, 1, 1),
(380, 1, 'iemr5vwkyscqfejckehjq88etp3afy8wdvittngz2mvpynite6jetevmj64mfpsreeggv8rn6zhx6zjivjngu5vf3a24vcaz83cb2t5rse84aymr4rk8prxzqzspd2qc', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 13:56:32', '2019-10-30 13:55:32', 0, 1, 1),
(381, 1, 'iemr5vwkyscqfejckehjq88etp3afy8wdvittngz2mvpynite6jetevmj64mfpsreeggv8rn6zhx6zjivjngu5vf3a24vcaz83cb2t5rse84aymr4rk8prxzqzspd2qc', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 13:56:55', '2019-10-30 13:55:55', 0, 1, 1),
(382, 1, 'iemr5vwkyscqfejckehjq88etp3afy8wdvittngz2mvpynite6jetevmj64mfpsreeggv8rn6zhx6zjivjngu5vf3a24vcaz83cb2t5rse84aymr4rk8prxzqzspd2qc', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 13:59:02', '2019-10-30 13:58:02', 0, 1, 1),
(383, 1, 'iemr5vwkyscqfejckehjq88etp3afy8wdvittngz2mvpynite6jetevmj64mfpsreeggv8rn6zhx6zjivjngu5vf3a24vcaz83cb2t5rse84aymr4rk8prxzqzspd2qc', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 13:59:51', '2019-10-30 13:58:51', 0, 1, 1),
(384, 1, 'iemr5vwkyscqfejckehjq88etp3afy8wdvittngz2mvpynite6jetevmj64mfpsreeggv8rn6zhx6zjivjngu5vf3a24vcaz83cb2t5rse84aymr4rk8prxzqzspd2qc', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 14:00:10', '2019-10-30 13:59:10', 0, 1, 1),
(385, 1, 'iemr5vwkyscqfejckehjq88etp3afy8wdvittngz2mvpynite6jetevmj64mfpsreeggv8rn6zhx6zjivjngu5vf3a24vcaz83cb2t5rse84aymr4rk8prxzqzspd2qc', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-10-30 14:00:14', '2019-10-30 13:59:14', 0, 1, 1),
(386, 1, 'h5fm2cy6iw6bfwssemihyg2rimcxbjsj26cdqdewe43txfvns26tyd6fiu6t4bvnu5medkkzxj7f7rtnezkdnmpf2xctysvhqs7y8xszmpha3emve7rutjx4ti7gfn8v', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-10-31 21:56:16', '2019-10-31 21:55:16', 0, 1, 1),
(387, 0, 'h5fm2cy6iw6bfwssemihyg2rimcxbjsj26cdqdewe43txfvns26tyd6fiu6t4bvnu5medkkzxj7f7rtnezkdnmpf2xctysvhqs7y8xszmpha3emve7rutjx4ti7gfn8v', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-01 02:20:03', '2019-11-01 02:19:03', 0, 1, 1),
(388, 1, 'h5fm2cy6iw6bfwssemihyg2rimcxbjsj26cdqdewe43txfvns26tyd6fiu6t4bvnu5medkkzxj7f7rtnezkdnmpf2xctysvhqs7y8xszmpha3emve7rutjx4ti7gfn8v', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-01 02:26:26', '2019-11-01 02:25:26', 0, 1, 1),
(389, 1, 'h5fm2cy6iw6bfwssemihyg2rimcxbjsj26cdqdewe43txfvns26tyd6fiu6t4bvnu5medkkzxj7f7rtnezkdnmpf2xctysvhqs7y8xszmpha3emve7rutjx4ti7gfn8v', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-01 02:29:09', '2019-11-01 02:28:09', 0, 1, 1),
(390, 1, 'h5fm2cy6iw6bfwssemihyg2rimcxbjsj26cdqdewe43txfvns26tyd6fiu6t4bvnu5medkkzxj7f7rtnezkdnmpf2xctysvhqs7y8xszmpha3emve7rutjx4ti7gfn8v', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-01 02:31:19', '2019-11-01 02:30:19', 0, 1, 1),
(391, 1, 'h5fm2cy6iw6bfwssemihyg2rimcxbjsj26cdqdewe43txfvns26tyd6fiu6t4bvnu5medkkzxj7f7rtnezkdnmpf2xctysvhqs7y8xszmpha3emve7rutjx4ti7gfn8v', '', '', '[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-01 02:39:04', '2019-11-01 02:38:04', 0, 1, 1),
(392, 0, 'h5fm2cy6iw6bfwssemihyg2rimcxbjsj26cdqdewe43txfvns26tyd6fiu6t4bvnu5medkkzxj7f7rtnezkdnmpf2xctysvhqs7y8xszmpha3emve7rutjx4ti7gfn8v', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-01 02:39:37', '2019-11-01 02:38:37', 0, 1, 1),
(393, 0, 'h5fm2cy6iw6bfwssemihyg2rimcxbjsj26cdqdewe43txfvns26tyd6fiu6t4bvnu5medkkzxj7f7rtnezkdnmpf2xctysvhqs7y8xszmpha3emve7rutjx4ti7gfn8v', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-01 02:39:45', '2019-11-01 02:38:45', 0, 1, 1),
(394, 1, 'h5fm2cy6iw6bfwssemihyg2rimcxbjsj26cdqdewe43txfvns26tyd6fiu6t4bvnu5medkkzxj7f7rtnezkdnmpf2xctysvhqs7y8xszmpha3emve7rutjx4ti7gfn8v', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-01 02:39:47', '2019-11-01 02:38:47', 0, 1, 1),
(395, 0, 'h5fm2cy6iw6bfwssemihyg2rimcxbjsj26cdqdewe43txfvns26tyd6fiu6t4bvnu5medkkzxj7f7rtnezkdnmpf2xctysvhqs7y8xszmpha3emve7rutjx4ti7gfn8v', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-01 02:39:55', '2019-11-01 02:38:55', 0, 1, 1),
(396, 1, 'h5fm2cy6iw6bfwssemihyg2rimcxbjsj26cdqdewe43txfvns26tyd6fiu6t4bvnu5medkkzxj7f7rtnezkdnmpf2xctysvhqs7y8xszmpha3emve7rutjx4ti7gfn8v', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-01 02:40:01', '2019-11-01 02:39:01', 0, 1, 1),
(397, 1, 'h5fm2cy6iw6bfwssemihyg2rimcxbjsj26cdqdewe43txfvns26tyd6fiu6t4bvnu5medkkzxj7f7rtnezkdnmpf2xctysvhqs7y8xszmpha3emve7rutjx4ti7gfn8v', '', '', '[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-01 02:40:19', '2019-11-01 02:39:19', 0, 1, 1),
(398, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-01 23:25:36', '2019-11-01 23:24:36', 0, 1, 1),
(399, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-01 23:36:17', '2019-11-01 23:35:17', 0, 1, 1),
(400, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:09:50', '2019-11-02 00:08:50', 0, 1, 1),
(401, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:10:15', '2019-11-02 00:09:15', 0, 1, 1),
(402, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:10:26', '2019-11-02 00:09:26', 0, 1, 1),
(403, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:11:00', '2019-11-02 00:10:00', 0, 1, 1),
(404, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:12:01', '2019-11-02 00:11:01', 0, 1, 1),
(405, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:12:13', '2019-11-02 00:11:13', 0, 1, 1),
(406, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:12:30', '2019-11-02 00:11:30', 0, 1, 1),
(407, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:12:49', '2019-11-02 00:11:49', 0, 1, 1),
(408, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:13:04', '2019-11-02 00:12:04', 0, 1, 1),
(409, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:13:14', '2019-11-02 00:12:14', 0, 1, 1),
(410, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:13:25', '2019-11-02 00:12:25', 0, 1, 1),
(411, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:14:29', '2019-11-02 00:13:29', 0, 1, 1),
(412, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:14:42', '2019-11-02 00:13:42', 0, 1, 1),
(413, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:15:01', '2019-11-02 00:14:01', 0, 1, 1),
(414, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:15:43', '2019-11-02 00:14:43', 0, 1, 1),
(415, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:16:09', '2019-11-02 00:15:09', 0, 1, 1),
(416, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:16:30', '2019-11-02 00:15:30', 0, 1, 1),
(417, 0, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-02 00:17:57', '2019-11-02 00:16:57', 0, 1, 1),
(418, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-02 00:18:52', '2019-11-02 00:17:52', 0, 1, 1),
(419, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:19:35', '2019-11-02 00:18:35', 0, 1, 1),
(420, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:20:04', '2019-11-02 00:19:04', 0, 1, 1),
(421, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:20:14', '2019-11-02 00:19:14', 0, 1, 1),
(422, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:20:27', '2019-11-02 00:19:27', 0, 1, 1),
(423, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:20:44', '2019-11-02 00:19:44', 0, 1, 1),
(424, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:20:50', '2019-11-02 00:19:50', 0, 1, 1),
(425, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:21:01', '2019-11-02 00:20:01', 0, 1, 1),
(426, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:21:12', '2019-11-02 00:20:12', 0, 1, 1),
(427, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:21:18', '2019-11-02 00:20:19', 0, 1, 1),
(428, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:22:21', '2019-11-02 00:21:21', 0, 1, 1),
(429, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:22:45', '2019-11-02 00:21:45', 0, 1, 1),
(430, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:23:05', '2019-11-02 00:22:05', 0, 1, 1),
(431, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:24:20', '2019-11-02 00:23:20', 0, 1, 1),
(432, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:25:56', '2019-11-02 00:24:56', 0, 1, 1),
(433, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:26:03', '2019-11-02 00:25:03', 0, 1, 1),
(434, 1, 'db4afmfmur6jgjqxgq4siq4maktbg66hgesiwjj2gi3uceyx5cy2ne63prrigzbegerx46yqcub6jj6mxfqq8mbbve25t6uvwv8d83pg5icd5ke3n6tzrk6qhdmmicr6', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 00:26:27', '2019-11-02 00:25:27', 0, 1, 1),
(435, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-02 11:17:21', '2019-11-02 11:16:21', 0, 1, 1),
(436, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_DELETE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 11:40:53', '2019-11-02 11:39:53', 0, 1, 1),
(437, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-02 11:42:17', '2019-11-02 11:41:17', 0, 1, 1),
(438, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-02 11:56:44', '2019-11-02 11:55:44', 0, 1, 1),
(439, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-02 11:56:47', '2019-11-02 11:55:47', 0, 1, 1),
(440, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-02 12:01:03', '2019-11-02 12:00:03', 0, 1, 1),
(441, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-02 12:01:48', '2019-11-02 12:00:48', 0, 1, 1),
(442, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-02 12:11:25', '2019-11-02 12:10:25', 0, 1, 1),
(443, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 12:11:59', '2019-11-02 12:10:59', 0, 1, 1),
(444, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 12:13:28', '2019-11-02 12:12:28', 0, 1, 1),
(445, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 12:13:34', '2019-11-02 12:12:34', 0, 1, 1),
(446, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 12:13:37', '2019-11-02 12:12:37', 0, 1, 1),
(447, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-02 12:13:50', '2019-11-02 12:12:50', 0, 1, 1),
(448, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-02 18:12:50', '2019-11-02 18:11:50', 0, 1, 1),
(449, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-02 18:15:25', '2019-11-02 18:14:25', 0, 1, 1),
(450, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-02 18:15:51', '2019-11-02 18:14:51', 0, 1, 1),
(451, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-02 18:16:00', '2019-11-02 18:15:00', 0, 1, 1),
(452, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-02 18:18:39', '2019-11-02 18:17:39', 0, 1, 1),
(453, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 18:19:11', '2019-11-02 18:18:11', 0, 1, 1),
(454, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 18:19:18', '2019-11-02 18:18:18', 0, 1, 1),
(455, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 18:19:24', '2019-11-02 18:18:24', 0, 1, 1),
(456, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-02 18:19:46', '2019-11-02 18:18:46', 0, 1, 1),
(457, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-02 18:19:54', '2019-11-02 18:18:54', 0, 1, 1),
(458, 1, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-02 18:21:07', '2019-11-02 18:20:07', 0, 1, 1),
(459, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-02 18:21:50', '2019-11-02 18:20:50', 0, 1, 1),
(460, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'info', 'account_registration_error', 5000, '2019-11-02 22:43:47', '2019-11-02 22:42:47', 0, 1, 1),
(461, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'info', 'account_registration_error', 5000, '2019-11-02 22:43:55', '2019-11-02 22:42:55', 0, 1, 1),
(462, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'info', 'danger', 5000, '2019-11-02 22:45:14', '2019-11-02 22:44:14', 0, 1, 1),
(463, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'info', 'danger', 5000, '2019-11-02 22:45:16', '2019-11-02 22:44:16', 0, 1, 1),
(464, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'danger', 'danger', 5000, '2019-11-02 22:45:50', '2019-11-02 22:44:50', 0, 1, 1),
(465, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'danger', 'danger', 5000, '2019-11-02 22:45:53', '2019-11-02 22:44:53', 0, 1, 1),
(466, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'info', 'danger', 5000, '2019-11-02 22:46:20', '2019-11-02 22:45:20', 0, 1, 1),
(467, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'danger', 'danger', 5000, '2019-11-02 22:46:24', '2019-11-02 22:45:24', 0, 1, 1),
(468, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'danger', 'danger', 5000, '2019-11-02 22:46:27', '2019-11-02 22:45:27', 0, 1, 1),
(469, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'danger', 'danger', 5000, '2019-11-02 22:46:30', '2019-11-02 22:45:30', 0, 1, 1),
(470, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'info', 'danger', 5000, '2019-11-02 22:46:39', '2019-11-02 22:45:39', 0, 1, 1),
(471, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'info', 'danger', 5000, '2019-11-02 22:46:57', '2019-11-02 22:45:57', 0, 1, 1),
(472, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_PASSWORD_TO_WEAK]', 'danger', 'danger', 5000, '2019-11-02 22:49:14', '2019-11-02 22:48:14', 0, 1, 1),
(473, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'danger', 'danger', 5000, '2019-11-02 22:49:14', '2019-11-02 22:48:14', 0, 1, 1),
(474, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'danger', 'danger', 5000, '2019-11-02 22:49:22', '2019-11-02 22:48:22', 0, 1, 1),
(475, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'danger', 'danger', 5000, '2019-11-02 22:52:20', '2019-11-02 22:51:20', 0, 1, 1),
(476, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'danger', 'danger', 5000, '2019-11-02 22:54:18', '2019-11-02 22:53:18', 0, 1, 1),
(477, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]', 'danger', 'danger', 5000, '2019-11-02 22:54:21', '2019-11-02 22:53:21', 0, 1, 1),
(478, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_EMAIL_ALREADYUSED]', 'danger', 'danger', 5000, '2019-11-02 22:56:43', '2019-11-02 22:55:43', 0, 1, 1),
(479, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_EMAIL_ALREADYUSED]', 'danger', 'danger', 5000, '2019-11-02 22:57:05', '2019-11-02 22:56:05', 0, 1, 1),
(480, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_PASSWORD_TO_WEAK]', 'danger', 'danger', 5000, '2019-11-02 22:57:55', '2019-11-02 22:56:55', 0, 1, 1),
(481, 0, 'f6xhu2xrbjjutgi4h5f7f6kxtjjbapteybib2hdc3qab5bz4zqtajx4uhqmpxw2g65nfuwtfkmzyeh35v85rgnpnfpzf2pd7uq3mh4y3n4kq5pewertjhewkrg3ufwek', '', '', '[LANG_ACCOUNT_REGISTRATION_ERROR_PASSWORD_TO_WEAK]', 'danger', 'danger', 5000, '2019-11-02 23:00:14', '2019-11-02 22:59:14', 0, 1, 1),
(482, 1, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[LANG_ACCOUNT_FIRST_LOGIN_REDIRECT]', 'warning', 'first_login', 5000, '2019-11-08 21:03:02', '2019-11-08 21:02:02', 0, 0, 1),
(483, 1, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-08 21:18:03', '2019-11-08 21:17:03', 0, 1, 1),
(484, 0, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-08 21:18:10', '2019-11-08 21:17:10', 0, 1, 1),
(485, 1, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-08 21:18:12', '2019-11-08 21:17:12', 0, 1, 1),
(486, 0, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-08 21:18:15', '2019-11-08 21:17:15', 0, 1, 1),
(487, 1, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[LANG_ACCOUNT_FIRST_LOGIN_REDIRECT]', 'warning', 'first_login', 5000, '2019-11-08 21:18:23', '2019-11-08 21:17:23', 0, 1, 1),
(488, 1, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[ACCOUNT_TEXT_SETTINGS_USERDATA_SAVE_SUCCESS]', 'success', 'settings_userdata', 5000, '2019-11-08 21:18:43', '2019-11-08 21:17:43', 0, 1, 1),
(489, 1, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[LANG_ACCOUNT_FIRST_LOGIN_REDIRECT]', 'warning', 'first_login', 5000, '2019-11-08 21:22:10', '2019-11-08 21:21:10', 0, 1, 1),
(490, 1, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[LANG_ACCOUNT_FIRST_LOGIN_REDIRECT]', 'warning', 'first_login', 5000, '2019-11-08 21:22:13', '2019-11-08 21:21:13', 0, 1, 1),
(491, 1, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[LANG_ACCOUNT_FIRST_LOGIN_REDIRECT]', 'warning', 'first_login', 5000, '2019-11-08 21:22:14', '2019-11-08 21:21:14', 0, 1, 1),
(492, 1, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[LANG_ACCOUNT_FIRST_LOGIN_REDIRECT]', 'warning', 'first_login', 5000, '2019-11-08 21:22:15', '2019-11-08 21:21:15', 0, 1, 1),
(493, 1, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[LANG_ACCOUNT_FIRST_LOGIN_REDIRECT]', 'warning', 'first_login', 5000, '2019-11-08 21:22:15', '2019-11-08 21:21:15', 0, 1, 1),
(494, 1, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[LANG_ACCOUNT_FIRST_LOGIN_REDIRECT]', 'warning', 'first_login', 5000, '2019-11-08 21:22:16', '2019-11-08 21:21:16', 0, 1, 1),
(495, 1, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[ACCOUNT_TEXT_SETTINGS_USERDATA_SAVE_SUCCESS]', 'success', 'settings_userdata', 5000, '2019-11-08 21:22:19', '2019-11-08 21:21:19', 0, 1, 1),
(496, 1, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[LANG_ACCOUNT_FIRST_LOGIN_REDIRECT]', 'warning', 'first_login', 5000, '2019-11-08 21:26:24', '2019-11-08 21:25:24', 0, 1, 1),
(497, 1, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[LANG_ACCOUNT_FIRST_LOGIN_REDIRECT]', 'warning', 'first_login', 5000, '2019-11-08 21:26:27', '2019-11-08 21:25:27', 0, 1, 1),
(498, 1, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[ACCOUNT_TEXT_SETTINGS_USERDATA_SAVE_SUCCESS]', 'success', 'settings_userdata', 5000, '2019-11-08 21:26:31', '2019-11-08 21:25:31', 0, 1, 1),
(499, 0, 'wx3nc7x84xp668cf7uyxjm488nn38iuu8fpga5ppeq2kc8bzt6c8n4j2kdiktahx68528fzu7ykdhqdz55dk362hj4enjpjhuky2y7pw33bbmkbbukquybpcwappd3zn', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-08 21:26:40', '2019-11-08 21:25:40', 0, 1, 1),
(500, 1, 'xhd4zcpyzteawpx8es7wztafynchpjcn4ycujmccry3a8dzygup7fegu8d5q7tapehgd68vyxpa2hf26bby6vu8wesfeznam5q2b35vrzyuukc2k6uqcd8hs4hyrc2c3', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-20 13:47:12', '2019-11-20 13:46:12', 0, 1, 1),
(501, 1, 'xhd4zcpyzteawpx8es7wztafynchpjcn4ycujmccry3a8dzygup7fegu8d5q7tapehgd68vyxpa2hf26bby6vu8wesfeznam5q2b35vrzyuukc2k6uqcd8hs4hyrc2c3', '', '', '[LANG_ADMIN_ACCOUNT_USER_EMAIL_IS_ALREADY_USED]', 'danger', 'danger', 5000, '2019-11-20 16:15:45', '2019-11-20 16:14:45', 0, 1, 1),
(502, 1, 'xhd4zcpyzteawpx8es7wztafynchpjcn4ycujmccry3a8dzygup7fegu8d5q7tapehgd68vyxpa2hf26bby6vu8wesfeznam5q2b35vrzyuukc2k6uqcd8hs4hyrc2c3', '', '', '[LANG_ADMIN_ACCOUNT_USER_EMAIL_IS_ALREADY_USED]', 'danger', 'danger', 5000, '2019-11-20 16:16:14', '2019-11-20 16:15:14', 0, 1, 1),
(503, 1, 'xhd4zcpyzteawpx8es7wztafynchpjcn4ycujmccry3a8dzygup7fegu8d5q7tapehgd68vyxpa2hf26bby6vu8wesfeznam5q2b35vrzyuukc2k6uqcd8hs4hyrc2c3', '', '', '[LANG_ADMIN_ACCOUNT_USER_EMAIL_IS_ALREADY_USED]', 'danger', 'danger', 5000, '2019-11-20 16:21:04', '2019-11-20 16:20:04', 0, 1, 1),
(504, 1, 'xhd4zcpyzteawpx8es7wztafynchpjcn4ycujmccry3a8dzygup7fegu8d5q7tapehgd68vyxpa2hf26bby6vu8wesfeznam5q2b35vrzyuukc2k6uqcd8hs4hyrc2c3', '', '', '[LANG_ADMIN_ACCOUNT_USER_EMAIL_IS_ALREADY_USED]', 'danger', 'danger', 5000, '2019-11-20 16:21:24', '2019-11-20 16:20:24', 0, 1, 1),
(505, 0, 'xhd4zcpyzteawpx8es7wztafynchpjcn4ycujmccry3a8dzygup7fegu8d5q7tapehgd68vyxpa2hf26bby6vu8wesfeznam5q2b35vrzyuukc2k6uqcd8hs4hyrc2c3', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-20 16:26:39', '2019-11-20 16:25:39', 0, 1, 1),
(506, 1, 'xhd4zcpyzteawpx8es7wztafynchpjcn4ycujmccry3a8dzygup7fegu8d5q7tapehgd68vyxpa2hf26bby6vu8wesfeznam5q2b35vrzyuukc2k6uqcd8hs4hyrc2c3', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-20 16:27:56', '2019-11-20 16:26:56', 0, 1, 1),
(507, 1, 'xhd4zcpyzteawpx8es7wztafynchpjcn4ycujmccry3a8dzygup7fegu8d5q7tapehgd68vyxpa2hf26bby6vu8wesfeznam5q2b35vrzyuukc2k6uqcd8hs4hyrc2c3', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-20 16:28:04', '2019-11-20 16:27:04', 0, 1, 1),
(508, 0, 'xhd4zcpyzteawpx8es7wztafynchpjcn4ycujmccry3a8dzygup7fegu8d5q7tapehgd68vyxpa2hf26bby6vu8wesfeznam5q2b35vrzyuukc2k6uqcd8hs4hyrc2c3', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-20 16:28:06', '2019-11-20 16:27:06', 0, 1, 1),
(509, 1, 'xhd4zcpyzteawpx8es7wztafynchpjcn4ycujmccry3a8dzygup7fegu8d5q7tapehgd68vyxpa2hf26bby6vu8wesfeznam5q2b35vrzyuukc2k6uqcd8hs4hyrc2c3', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-20 16:28:25', '2019-11-20 16:27:25', 0, 1, 1),
(510, 1, 'xhd4zcpyzteawpx8es7wztafynchpjcn4ycujmccry3a8dzygup7fegu8d5q7tapehgd68vyxpa2hf26bby6vu8wesfeznam5q2b35vrzyuukc2k6uqcd8hs4hyrc2c3', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-11-20 16:28:36', '2019-11-20 16:27:36', 0, 1, 1),
(511, 0, 'xhd4zcpyzteawpx8es7wztafynchpjcn4ycujmccry3a8dzygup7fegu8d5q7tapehgd68vyxpa2hf26bby6vu8wesfeznam5q2b35vrzyuukc2k6uqcd8hs4hyrc2c3', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-11-20 16:28:43', '2019-11-20 16:27:43', 0, 1, 1),
(512, 1, 'nngmcxsgb73aptjb7paza5kxzmrgqshakytd8qiwjwpejqi8y5va386aez8wdp72tzxb28h2bt83p3eb4ntia3p8repmg7vr4atezfddy53j8pgfxw8fbcqudurnztfi', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-23 22:45:45', '2019-11-23 13:44:45', 0, 1, 1),
(513, 0, 'ypgvck5utdm3vcmjswt4wn2peuwzmmbp4h6uzkc7gprgvmixjagxe3vj8sdryzcbvk5zbznga82x278bx7xvmr68bv7misjmsuybfn3n2mc5ezckaxwz4nis4286hutk', '', '', '[LANG_ACCOUNT_ERROR_LOGIN_INVALID]', 'danger', 'account_login', 5000, '2019-11-26 22:04:37', '2019-11-26 13:03:37', 0, 1, 1),
(514, 0, 'ypgvck5utdm3vcmjswt4wn2peuwzmmbp4h6uzkc7gprgvmixjagxe3vj8sdryzcbvk5zbznga82x278bx7xvmr68bv7misjmsuybfn3n2mc5ezckaxwz4nis4286hutk', '', '', '[LANG_ACCOUNT_ERROR_LOGIN_INVALID]', 'danger', 'account_login', 5000, '2019-11-26 22:14:49', '2019-11-26 13:13:49', 0, 1, 1),
(515, 1, 'rsv245w2ajtuhafpsy8a7g28wcij6at3p7sbzi5j2r4hhi7evadc2r2wsxuhngkx4gkwhznxbh7gep55zxbrcpnajrcrh2hafti7eqx2c7ncwdkgbesu3pzfvr5pevpj', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-11-27 15:53:03', '2019-11-27 15:52:03', 0, 1, 1),
(516, 1, 'btx5swas42wepi7wm2e3jz2k36v6qc8pke47prbdv4ahqiihcwxjdec7pgvayy8w7yjqpagjwn348myxfcne4jeghurufz354drkinxkrn6kt5c6iaqsaqjauawrn54w', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-12-14 14:00:54', '2019-12-14 13:59:54', 0, 1, 1),
(517, 1, 'btx5swas42wepi7wm2e3jz2k36v6qc8pke47prbdv4ahqiihcwxjdec7pgvayy8w7yjqpagjwn348myxfcne4jeghurufz354drkinxkrn6kt5c6iaqsaqjauawrn54w', '', '', '[ADMIN_MESSAGE_MENUPOINT_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-14 14:01:56', '2019-12-14 14:00:56', 0, 1, 1),
(518, 1, 'btx5swas42wepi7wm2e3jz2k36v6qc8pke47prbdv4ahqiihcwxjdec7pgvayy8w7yjqpagjwn348myxfcne4jeghurufz354drkinxkrn6kt5c6iaqsaqjauawrn54w', '', '', '[ADMIN_MESSAGE_MENUPOINT_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-14 14:02:12', '2019-12-14 14:01:12', 0, 1, 1),
(519, 1, 'btx5swas42wepi7wm2e3jz2k36v6qc8pke47prbdv4ahqiihcwxjdec7pgvayy8w7yjqpagjwn348myxfcne4jeghurufz354drkinxkrn6kt5c6iaqsaqjauawrn54w', '', '', '[ADMIN_MESSAGE_MENUPOINT_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-14 14:02:19', '2019-12-14 14:01:19', 0, 1, 1),
(520, 1, 'btx5swas42wepi7wm2e3jz2k36v6qc8pke47prbdv4ahqiihcwxjdec7pgvayy8w7yjqpagjwn348myxfcne4jeghurufz354drkinxkrn6kt5c6iaqsaqjauawrn54w', '', '', '[ADMIN_MESSAGE_MENUPOINT_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-14 14:02:47', '2019-12-14 14:01:47', 0, 1, 1),
(521, 1, 'btx5swas42wepi7wm2e3jz2k36v6qc8pke47prbdv4ahqiihcwxjdec7pgvayy8w7yjqpagjwn348myxfcne4jeghurufz354drkinxkrn6kt5c6iaqsaqjauawrn54w', '', '', '[ADMIN_MESSAGE_MENUPOINT_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-14 14:03:00', '2019-12-14 14:02:00', 0, 1, 1),
(522, 1, 'z7jfqczg3cyhxwkz2b4vkrfvwy6q3y8pgzapazzycgviyafairiayd88ppcwdemwbbc4phcuqybip5in8jstfs3v3fv68sbxrsk3hf64nf77v8bmxbtp4pxcir7uabw4', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-12-20 11:19:55', '2019-12-20 11:18:55', 0, 1, 1),
(523, 1, 'qwzsxub4e5722uz7qg86e75dtxcfn3jcv2hukp67yqvuy4a3nf2j67aw3yda2wx5dvvcpcr5i4gsm2dg5kbc3avhu3twkn2gc43agfwj3buqtkwi5vv6mfnznxuzvizd', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-12-21 21:23:45', '2019-12-21 21:22:45', 0, 1, 1),
(524, 0, 'qwzsxub4e5722uz7qg86e75dtxcfn3jcv2hukp67yqvuy4a3nf2j67aw3yda2wx5dvvcpcr5i4gsm2dg5kbc3avhu3twkn2gc43agfwj3buqtkwi5vv6mfnznxuzvizd', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-12-21 21:41:27', '2019-12-21 21:40:27', 0, 1, 1),
(525, 1, 'qwzsxub4e5722uz7qg86e75dtxcfn3jcv2hukp67yqvuy4a3nf2j67aw3yda2wx5dvvcpcr5i4gsm2dg5kbc3avhu3twkn2gc43agfwj3buqtkwi5vv6mfnznxuzvizd', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-12-21 21:41:51', '2019-12-21 21:40:51', 0, 1, 1),
(526, 1, 'qwzsxub4e5722uz7qg86e75dtxcfn3jcv2hukp67yqvuy4a3nf2j67aw3yda2wx5dvvcpcr5i4gsm2dg5kbc3avhu3twkn2gc43agfwj3buqtkwi5vv6mfnznxuzvizd', '', '', '[LANG_ADMIN_ACCOUNT_USER_THE_PASSWORD_TO_WEAK]', 'danger', 'danger', 5000, '2019-12-21 22:08:19', '2019-12-21 22:07:19', 0, 1, 1),
(527, 1, 'qwzsxub4e5722uz7qg86e75dtxcfn3jcv2hukp67yqvuy4a3nf2j67aw3yda2wx5dvvcpcr5i4gsm2dg5kbc3avhu3twkn2gc43agfwj3buqtkwi5vv6mfnznxuzvizd', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-21 22:23:01', '2019-12-21 22:22:01', 0, 1, 1),
(528, 1, 'qwzsxub4e5722uz7qg86e75dtxcfn3jcv2hukp67yqvuy4a3nf2j67aw3yda2wx5dvvcpcr5i4gsm2dg5kbc3avhu3twkn2gc43agfwj3buqtkwi5vv6mfnznxuzvizd', '', '', '[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-21 22:24:05', '2019-12-21 22:23:05', 0, 1, 1),
(529, 0, 'qc2nrnx7atnjxiprehbhevdk37iz6d7k4iwbqjymh228edbsg3rcdxjpmvgj7zepc5zgtufxt2isre3kwbiz8rqd68fbrxzpwbnc8fqwb2srw5gh64pi4ieqgp2uptdt', '', '', '[LANG_ACCOUNT_ERROR_LOGIN_INVALID]', 'danger', 'account_login', 5000, '2019-12-22 12:47:10', '2019-12-22 12:46:10', 0, 1, 1),
(530, 0, 'qc2nrnx7atnjxiprehbhevdk37iz6d7k4iwbqjymh228edbsg3rcdxjpmvgj7zepc5zgtufxt2isre3kwbiz8rqd68fbrxzpwbnc8fqwb2srw5gh64pi4ieqgp2uptdt', '', '', '[LANG_ACCOUNT_ERROR_LOGIN_INVALID]', 'danger', 'account_login', 5000, '2019-12-22 12:47:14', '2019-12-22 12:46:14', 0, 1, 1),
(531, 0, 'qc2nrnx7atnjxiprehbhevdk37iz6d7k4iwbqjymh228edbsg3rcdxjpmvgj7zepc5zgtufxt2isre3kwbiz8rqd68fbrxzpwbnc8fqwb2srw5gh64pi4ieqgp2uptdt', '', '', '[LANG_ACCOUNT_ERROR_LOGIN_INVALID]', 'danger', 'account_login', 5000, '2019-12-22 12:47:19', '2019-12-22 12:46:19', 0, 1, 1),
(532, 1, 'qc2nrnx7atnjxiprehbhevdk37iz6d7k4iwbqjymh228edbsg3rcdxjpmvgj7zepc5zgtufxt2isre3kwbiz8rqd68fbrxzpwbnc8fqwb2srw5gh64pi4ieqgp2uptdt', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-12-22 12:47:50', '2019-12-22 12:46:50', 0, 1, 1),
(533, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-12-22 16:17:37', '2019-12-22 16:16:37', 0, 1, 1),
(534, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 16:21:53', '2019-12-22 16:20:53', 0, 1, 1),
(535, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 16:21:57', '2019-12-22 16:20:57', 0, 1, 1),
(536, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 16:21:58', '2019-12-22 16:20:58', 0, 1, 1),
(537, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 16:22:07', '2019-12-22 16:21:07', 0, 1, 1),
(538, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 16:22:40', '2019-12-22 16:21:40', 0, 1, 1),
(539, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 16:22:46', '2019-12-22 16:21:46', 0, 1, 1),
(540, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 16:39:05', '2019-12-22 16:38:05', 0, 1, 1),
(541, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 19:31:57', '2019-12-22 19:30:57', 0, 1, 1),
(542, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 19:32:10', '2019-12-22 19:31:10', 0, 1, 1),
(543, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 19:32:52', '2019-12-22 19:31:52', 0, 1, 1),
(544, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 19:32:58', '2019-12-22 19:31:58', 0, 1, 1);
INSERT INTO `cb_message` (`id`, `user_id`, `session_id`, `device`, `title`, `message`, `type`, `style`, `time`, `valid_time`, `date_time`, `multishow`, `delivered`, `archive`) VALUES
(545, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 19:36:37', '2019-12-22 19:35:37', 0, 1, 1),
(546, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 19:46:04', '2019-12-22 19:45:04', 0, 1, 1),
(547, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 19:46:14', '2019-12-22 19:45:14', 0, 1, 1),
(548, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 19:46:20', '2019-12-22 19:45:20', 0, 1, 1),
(549, 0, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-12-22 19:47:12', '2019-12-22 19:46:12', 0, 1, 1),
(550, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-12-22 19:47:18', '2019-12-22 19:46:18', 0, 1, 1),
(551, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 19:49:05', '2019-12-22 19:48:05', 0, 1, 1),
(552, 0, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-12-22 20:13:19', '2019-12-22 20:12:19', 0, 1, 1),
(553, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-12-22 20:14:46', '2019-12-22 20:13:46', 0, 1, 1),
(554, 0, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-12-22 20:15:03', '2019-12-22 20:14:03', 0, 1, 1),
(555, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-12-22 20:24:20', '2019-12-22 20:23:20', 0, 1, 1),
(556, 0, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-12-22 20:25:13', '2019-12-22 20:24:13', 0, 1, 1),
(557, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-12-22 20:25:17', '2019-12-22 20:24:17', 0, 1, 1),
(558, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2019-12-22 20:25:25', '2019-12-22 20:24:25', 0, 1, 1),
(559, 0, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2019-12-22 20:39:57', '2019-12-22 20:38:57', 0, 1, 1),
(560, 1, 'ux6hrscnrgxpvs8tyufedzmi47ksp6yf5spjyv8kgdj5epq7q5nihehtik5aqpii73evghqqqkxx8h67ydk5ish2adcbwded5fk7a7gp7de63phqeq38bur7ttsrnk3j', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2019-12-22 20:51:02', '2019-12-22 20:50:02', 0, 1, 1),
(561, 1, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2020-01-06 12:06:17', '2020-01-06 12:05:17', 0, 1, 1),
(562, 0, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2020-01-06 12:06:59', '2020-01-06 12:05:59', 0, 1, 1),
(563, 1, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2020-01-06 12:07:04', '2020-01-06 12:06:04', 0, 1, 1),
(564, 1, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2020-01-06 12:07:14', '2020-01-06 12:06:14', 0, 1, 1),
(565, 0, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2020-01-06 12:07:17', '2020-01-06 12:06:17', 0, 1, 1),
(566, 1, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2020-01-06 12:07:21', '2020-01-06 12:06:21', 0, 1, 1),
(567, 1, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2020-01-06 12:07:40', '2020-01-06 12:06:40', 0, 1, 1),
(568, 0, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2020-01-06 12:07:42', '2020-01-06 12:06:42', 0, 1, 1),
(569, 1, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2020-01-06 12:07:49', '2020-01-06 12:06:49', 0, 1, 1),
(570, 1, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2020-01-06 12:07:58', '2020-01-06 12:06:58', 0, 1, 1),
(571, 0, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2020-01-06 12:08:04', '2020-01-06 12:07:04', 0, 1, 1),
(572, 1, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2020-01-06 12:08:08', '2020-01-06 12:07:08', 0, 1, 1),
(573, 1, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ADMIN_ACCOUNT_USER_THE_PASSWORD_TO_WEAK]', 'danger', 'danger', 5000, '2020-01-06 12:11:13', '2020-01-06 12:10:13', 0, 1, 1),
(574, 1, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]', 'success', 'save', 5000, '2020-01-06 12:13:53', '2020-01-06 12:12:53', 0, 1, 1),
(575, 0, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGOUT]', 'success', 'account_logout', 5000, '2020-01-06 12:14:06', '2020-01-06 12:13:06', 0, 1, 1),
(576, 1, 'e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', '', '', '[LANG_ACCOUNT_SUCCESS_LOGIN]', 'success', 'account_login', 5000, '2020-01-06 12:14:09', '2020-01-06 12:13:09', 0, 1, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_message_out`
--

CREATE TABLE `cb_message_out` (
  `id` bigint(20) NOT NULL,
  `message_id` bigint(20) NOT NULL,
  `random_id` varchar(10) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_module`
--

CREATE TABLE `cb_module` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_name` varchar(30) NOT NULL,
  `type` enum('USER','ADMIN') NOT NULL,
  `function` varchar(50) NOT NULL,
  `mainpage` tinyint(1) NOT NULL DEFAULT '0',
  `mainpageparent` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `mainmenu` tinyint(1) NOT NULL DEFAULT '0',
  `mainmenuparent` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `fa-icon` varchar(64) NOT NULL DEFAULT '',
  `order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_module`
--

INSERT INTO `cb_module` (`id`, `module_name`, `type`, `function`, `mainpage`, `mainpageparent`, `mainmenu`, `mainmenuparent`, `fa-icon`, `order`) VALUES
(1, 'admin', 'USER', 'main', 0, 0, 0, 0, '', 0),
(2, 'account', 'ADMIN', 'main', 1, 0, 1, 0, 'fas fa-user', 0),
(3, 'account', 'ADMIN', 'create', 0, 0, 0, 2, 'fas fa-user-plus', 0),
(4, 'account', 'ADMIN', 'edit', 0, 0, 0, 2, 'fas fa-user-edit', 0),
(5, 'account', 'ADMIN', 'delete', 0, 0, 0, 2, '', 0),
(6, 'account', 'ADMIN', 'details', 0, 0, 0, 2, 'fas fa-address-card', 0),
(7, 'account', 'ADMIN', 'invite', 0, 0, 0, 2, 'far fa-envelope', 0),
(8, 'account', 'USER', 'main', 0, 0, 0, 0, '', 0),
(9, 'account', 'USER', 'account_box', 0, 0, 0, 0, '', 0),
(10, 'account', 'USER', 'registration', 0, 0, 0, 0, '', 0),
(11, 'account', 'USER', 'password_change', 0, 0, 0, 0, '', 0),
(12, 'account', 'USER', 'settings', 0, 0, 0, 0, '', 0),
(21, 'article', 'ADMIN', 'create', 0, 0, 0, 30, '', 0),
(22, 'article', 'ADMIN', 'delete', 0, 0, 0, 0, '', 0),
(23, 'article', 'ADMIN', 'edit', 0, 0, 0, 30, 'fas fa-edit', 0),
(24, 'article', 'ADMIN', 'group_create', 0, 0, 0, 0, '', 0),
(25, 'article', 'ADMIN', 'group_delete', 0, 0, 0, 0, '', 0),
(26, 'article', 'ADMIN', 'group_edit', 0, 0, 0, 0, '', 0),
(27, 'article', 'ADMIN', 'group_main', 0, 0, 2, 30, 'fa fa-th-large', 0),
(28, 'article', 'ADMIN', 'group_trash', 0, 0, 0, 0, '', 0),
(29, 'article', 'ADMIN', 'group_trash_main', 0, 0, 0, 0, '', 0),
(30, 'article', 'ADMIN', 'main', 1, 0, 1, 0, 'far fa-newspaper', 0),
(31, 'article', 'ADMIN', 'trash', 0, 0, 0, 0, '', 0),
(32, 'article', 'ADMIN', 'trash_main', 0, 0, 0, 0, '', 0),
(33, 'article', 'USER', 'main', 0, 0, 0, 0, '', 0),
(34, 'article', 'USER', 'article_category', 0, 0, 0, 0, '', 0),
(35, 'article', 'USER', 'article', 0, 0, 0, 0, '', 0),
(36, 'menu', 'ADMIN', 'main', 1, 0, 1, 0, 'fa fa-bars', 0),
(37, 'menu', 'ADMIN', 'create', 0, 0, 0, 0, '', 0),
(38, 'menu', 'ADMIN', 'delete', 0, 0, 0, 0, '', 0),
(39, 'menu', 'ADMIN', 'edit', 0, 0, 0, 0, '', 0),
(40, 'menu', 'ADMIN', 'group_create', 0, 0, 0, 0, '', 0),
(41, 'menu', 'ADMIN', 'group_delete', 0, 0, 0, 0, '', 0),
(42, 'menu', 'ADMIN', 'group_edit', 0, 0, 0, 0, '', 0),
(43, 'menu', 'ADMIN', 'group_main', 0, 0, 2, 36, 'fa fa-th-large', 0),
(44, 'menu', 'ADMIN', 'group_trash', 0, 0, 0, 0, '', 0),
(45, 'menu', 'ADMIN', 'group_trash_main', 0, 0, 0, 0, '', 0),
(46, 'menu', 'ADMIN', 'trash', 0, 0, 0, 0, '', 0),
(47, 'menu', 'ADMIN', 'trash_main', 0, 0, 0, 0, '', 0),
(48, 'menu', 'USER', 'main', 0, 0, 0, 0, '', 0),
(49, 'menu', 'USER', 'menu', 0, 0, 0, 0, '', 0),
(52, 'mediamanager', 'ADMIN', 'main', 1, 0, 1, 0, 'fa fa-server', 0),
(69, 'admin', 'ADMIN', 'main', 0, 0, 1, 0, 'fa fa-tachometer-alt', -1),
(71, 'admin', 'ADMIN', 'menu', 0, 0, 0, 0, '', 0),
(78, 'admin', 'ADMIN', 'adminmodulemenu', 0, 0, 0, 0, '', 0),
(79, 'admin', 'ADMIN', 'havesidemenu', 0, 0, 0, 0, '', 0),
(80, 'admin', 'ADMIN', 'settings', 1, 0, 1, 0, 'fa fa-cog', 100000),
(81, 'admin', 'ADMIN', 'breadcrumb', 0, 0, 0, 0, '', 0),
(82, 'admin', 'ADMIN', 'adminmainpage', 0, 0, 0, 0, '', 0),
(83, 'admin', 'ADMIN', 'submenu', 0, 0, 0, 0, '', 0),
(84, 'account', 'USER', 'forgott_password', 0, 0, 0, 0, '', 0),
(85, 'admin', 'ADMIN', 'formmenu', 0, 0, 0, 0, '', 0),
(86, 'admin', 'ADMIN', 'infopanel', 0, 0, 0, 0, '', 0),
(87, 'admin', 'ADMIN', 'accountbox', 0, 0, 0, 0, '', 0),
(88, 'menu', 'ADMIN', 'list', 0, 0, 0, 0, '', 0),
(121, 'account', 'USER', 'login', 0, 0, 0, 0, '', 0),
(122, 'admin', 'ADMIN', 'seonamegenerate', 0, 0, 0, 0, '', 0),
(124, 'gallery', 'USER', 'main', 0, 0, 0, 0, '', 0),
(125, 'gallery', 'ADMIN', 'main', 1, 0, 1, 0, 'fa fa-image', 0),
(137, 'menu', 'USER', 'html', 0, 0, 0, 0, '', 0),
(138, 'contact', 'USER', 'main', 0, 0, 0, 0, '', 0),
(142, 'gallery', 'ADMIN', 'list', 0, 0, 0, 0, '', 0),
(155, 'contact', 'ADMIN', 'main', 1, 0, 1, 0, 'fa fa-envelope', 0),
(156, 'contact', 'ADMIN', 'forms', 2, 155, 2, 155, 'fa fa-edit', 0),
(157, 'contact', 'ADMIN', 'posts', 2, 155, 2, 155, 'fa fa-comment', 0),
(158, 'contact', 'ADMIN', 'maps', 2, 155, 2, 155, 'fa fa-map', 0),
(159, 'contact', 'ADMIN', 'forms_create', 0, 0, 0, 0, '', 0),
(160, 'contact', 'ADMIN', 'forms_edit', 0, 0, 0, 0, '', 0),
(161, 'contact', 'ADMIN', 'forms_delete', 0, 0, 0, 0, '', 0),
(166, 'slide', 'USER', 'main', 0, 0, 0, 0, '', 0),
(170, 'account', 'ADMIN', 'permission', 0, 0, 2, 80, 'fa fa-user-secret', 100),
(171, 'account', 'ADMIN', 'permission_create', 0, 0, 0, 170, '', 0),
(172, 'account', 'ADMIN', 'permission_edit', 0, 0, 0, 170, '', 0),
(173, 'account', 'ADMIN', 'permission_delete', 0, 0, 0, 170, '', 0),
(178, 'article', 'ADMIN', 'content_thumbnail_upload_access', 0, 0, 0, 0, '', 0),
(179, 'article', 'ADMIN', 'content_headerimage_upload_access', 0, 0, 0, 0, '', 0),
(180, 'contact', 'USER', 'form', 0, 0, 0, 0, '', 0),
(181, 'contact', 'USER', 'map', 0, 0, 0, 0, '', 0),
(194, 'admin', 'ADMIN', 'update', 2, 293, 2, 293, 'fa fa-cloud-download', 100),
(195, 'admin', 'ADMIN', 'update_check', 0, 0, 0, 0, '', 0),
(201, 'account', 'USER', 'logout', 0, 0, 0, 0, '', 0),
(266, 'currency', 'USER', 'main', 0, 0, 0, 0, '', 0),
(267, 'currency', 'USER', 'show', 0, 0, 0, 0, '', 0),
(268, 'currency', 'USER', 'convert', 0, 0, 0, 0, '', 0),
(269, 'currency', 'USER', 'refreshcurrencylist', 0, 0, 0, 0, '', 0),
(270, 'currency', 'USER', 'getcurrencylist', 0, 0, 0, 0, '', 0),
(277, 'account', 'USER', 'message', 0, 0, 0, 0, '', 0),
(278, 'account', 'USER', 'send_message', 0, 0, 0, 0, '', 0),
(279, 'account', 'USER', 'read_message', 0, 0, 0, 0, '', 0),
(280, 'account', 'USER', 'message_notification', 0, 0, 0, 0, '', 0),
(281, 'account', 'USER', 'message_notification_check', 0, 0, 0, 0, '', 0),
(284, 'mail2', 'USER', 'main', 0, 0, 0, 0, '', 0),
(286, 'mail2', 'USER', 'message_send', 0, 0, 0, 0, '', 0),
(292, 'admin', 'ADMIN', 'getseonamefromid', 0, 0, 0, 0, '', 0),
(293, 'admin', 'ADMIN', 'support', 1, 0, 1, 0, 'fa fa-life-ring', 800000),
(294, 'account', 'USER', 'login_gp', 0, 0, 0, 0, '', 0),
(295, 'account', 'USER', 'login_fb', 0, 0, 0, 0, '', 0),
(296, 'article', 'ADMIN', 'content_youtubevideo_upload_access', 0, 0, 0, 0, '', 0),
(297, 'article', 'ADMIN', 'create_preview', 0, 0, 0, 0, '', 0),
(298, 'article', 'USER', 'article_preview', 0, 0, 0, 0, '', 0),
(300, 'gallery', 'ADMIN', 'image_edit', 0, 0, 0, 0, '', 0),
(301, 'gallery', 'USER', 'list', 0, 0, 0, 0, '', 0),
(302, 'team', 'USER', 'main', 0, 0, 0, 0, '', 0),
(303, 'team', 'USER', 'list', 0, 0, 0, 0, '', 0),
(304, 'team', 'USER', 'works', 0, 0, 0, 0, '', 0),
(305, 'team', 'ADMIN', 'main', 1, 0, 1, 0, 'fa fa-users', 8000),
(306, 'team', 'ADMIN', 'create', 0, 0, 0, 0, '', 0),
(307, 'team', 'ADMIN', 'edit', 0, 0, 0, 0, '', 0),
(308, 'team', 'ADMIN', 'trash', 0, 0, 0, 0, '', 0),
(309, 'language', 'USER', 'main', 0, 0, 0, 0, '', 0),
(310, 'language', 'USER', 'selector', 0, 0, 0, 0, '', 0),
(311, 'product', 'USER', 'main', 0, 0, 0, 0, '', 0),
(312, 'product', 'USER', 'list', 0, 0, 0, 0, '', 0),
(313, 'product', 'USER', 'list_random', 0, 0, 0, 0, '', 0),
(314, 'product', 'USER', 'product', 0, 0, 0, 0, '', 0),
(315, 'product', 'ADMIN', 'main', 1, 0, 1, 0, 'fa fa-cube', 2000),
(316, 'product', 'ADMIN', 'list', 2, 315, 2, 315, 'fa fa-th-list', 0),
(317, 'product', 'ADMIN', 'product_create', 0, 0, 0, 0, '', 0),
(318, 'product', 'ADMIN', 'product_edit', 0, 0, 0, 0, '', 0),
(319, 'product', 'ADMIN', 'product_delete', 0, 0, 0, 0, '', 0),
(320, 'product', 'ADMIN', 'content_youtubevideo_upload_access', 0, 0, 0, 0, '', 0),
(321, 'product', 'ADMIN', 'content_productimage_upload_access', 0, 0, 0, 0, '', 0),
(322, 'catalog', 'ADMIN', 'content_catalogimage_upload_access', 0, 0, 0, 0, '', 0),
(323, 'catalog', 'ADMIN', 'content_youtubevideo_upload_access', 0, 0, 0, 0, '', 0),
(324, 'catalog', 'ADMIN', 'catalog_delete', 0, 0, 0, 0, '', 0),
(325, 'catalog', 'ADMIN', 'catalog_edit', 0, 0, 0, 0, '', 0),
(326, 'catalog', 'ADMIN', 'catalog_create', 0, 0, 0, 0, '', 0),
(327, 'catalog', 'ADMIN', 'list', 2, 328, 2, 328, 'fa fa-th-list', 0),
(328, 'catalog', 'ADMIN', 'main', 1, 0, 1, 0, 'fa fa-book', 3000),
(329, 'catalog', 'USER', 'catalog', 0, 0, 0, 0, '', 0),
(331, 'catalog', 'USER', 'list', 0, 0, 0, 0, '', 0),
(332, 'catalog', 'USER', 'main', 0, 0, 0, 0, '', 0),
(333, 'catalog', 'ADMIN', 'content_headerimage_upload_access', 0, 0, 0, 0, '', 0),
(334, 'catalog', 'ADMIN', 'content_thumbnail_upload_access', 0, 0, 0, 0, '', 0),
(335, 'product', 'ADMIN', 'content_headerimage_upload_access', 0, 0, 0, 0, '', 0),
(336, 'product', 'ADMIN', 'content_thumbnail_upload_access', 0, 0, 0, 0, '', 0),
(337, 'catalog', 'ADMIN', 'content_media_selector', 0, 0, 0, 0, '', 0),
(338, 'catalog', 'ADMIN', 'content_media_upload', 0, 0, 0, 0, '', 0),
(339, 'catalog', 'ADMIN', 'content_media_delete', 0, 0, 0, 0, '', 0),
(340, 'catalog', 'ADMIN', 'import', 2, 328, 2, 328, 'fa fa-upload', 0),
(341, 'catalog', 'ADMIN', 'category_list', 2, 328, 2, 328, 'fa fa-tags', 0),
(342, 'catalog', 'ADMIN', 'category_create', 0, 0, 0, 0, '', 0),
(343, 'catalog', 'ADMIN', 'category_delete', 0, 0, 0, 0, '', 0),
(344, 'catalog', 'ADMIN', 'export', 2, 328, 2, 328, 'fa fa-download', 0),
(345, 'mediamanager', 'ADMIN', 'filemanager', 2, 52, 2, 52, 'fa fa-list-alt', 400),
(346, 'mediamanager', 'ADMIN', 'media_add', 0, 0, 0, 0, '', 0),
(347, 'mediamanager', 'ADMIN', 'media_remove', 0, 0, 0, 0, '', 0),
(348, 'mediamanager', 'ADMIN', 'media_modify', 0, 0, 0, 0, '', 0),
(349, 'mediamanager', 'ADMIN', 'media_list', 2, 52, 2, 52, 'fa fa-th', 200),
(350, 'mediamanager', 'USER', 'main', 0, 0, 0, 0, '', 0),
(351, 'catalog', 'ADMIN', 'catalog_without_image', 2, 328, 2, 328, 'fa fa-exclamation-triangle', 0),
(352, 'admin', 'ADMIN', 'settings_level_1', 0, 0, 0, 0, '', 0),
(353, 'admin', 'ADMIN', 'settings_level_2', 0, 0, 0, 0, '', 0),
(354, 'admin', 'ADMIN', 'settings_article', 0, 0, 0, 0, '', 0),
(355, 'admin', 'ADMIN', 'settings_catalog', 0, 0, 0, 0, '', 0),
(356, 'admin', 'ADMIN', 'settings_currency', 0, 0, 0, 0, '', 0),
(357, 'admin', 'ADMIN', 'settings_gallery', 0, 0, 0, 0, '', 0),
(358, 'admin', 'ADMIN', 'settings_google_analytics', 0, 0, 0, 0, '', 0),
(359, 'admin', 'ADMIN', 'settings_recapcha', 0, 0, 0, 0, '', 0),
(360, 'admin', 'ADMIN', 'settings_social_login_facebook', 0, 0, 0, 0, '', 0),
(361, 'admin', 'ADMIN', 'settings_social_login_google', 0, 0, 0, 0, '', 0),
(362, 'admin', 'ADMIN', 'settings_mail', 0, 0, 0, 0, '', 0),
(363, 'admin', 'ADMIN', 'settings_product', 0, 0, 0, 0, '', 0),
(364, 'admin', 'USER', 'headerbar', 0, 0, 0, 0, '', 0),
(366, 'admin', 'ADMIN', 'settings_media', 0, 0, 0, 0, '', 0),
(367, 'admin', 'ADMIN', 'settings_account_api', 0, 0, 0, 0, '', 0),
(368, 'api', 'ADMIN', 'main', 1, 80, 1, 80, 'fa fa-plug', 100),
(369, 'account', 'USER', 'login_api', 0, 0, 0, 0, '', 0),
(385, 'api', 'USER', 'main', 0, 0, 0, 0, '', 0),
(386, 'api', 'USER', 'token', 0, 0, 0, 0, '', 0),
(387, 'api', 'USER', 'token_update', 0, 0, 0, 0, '', 0),
(388, 'account', 'USER', 'data', 0, 0, 0, 0, '', 0),
(394, 'language', 'ADMIN', 'main', 1, 80, 1, 80, 'fa fa-language', 2000),
(395, 'language', 'ADMIN', 'list', 2, 394, 2, 394, 'fa fa-list', 100),
(396, 'language', 'ADMIN', 'missing', 2, 394, 2, 394, 'fa fa-search', 200),
(397, 'language', 'ADMIN', 'predict', 2, 394, 2, 394, 'fa fa-question', 300),
(398, 'language', 'ADMIN', 'new', 0, 395, 0, 395, '', 0),
(399, 'language', 'ADMIN', 'edit', 0, 395, 0, 395, '', 0),
(400, 'language', 'ADMIN', 'delete', 0, 395, 0, 395, '', 0),
(401, 'language', 'ADMIN', 'deprecated', 2, 394, 2, 394, 'fa fa-exclamation', 400),
(407, 'message', 'USER', 'main', 0, 0, 0, 0, '', 0),
(409, 'mediamanager', 'ADMIN', 'media_details', 0, 0, 0, 0, '', 0),
(410, 'mediamanager', 'ADMIN', 'media_ajaxview', 0, 0, 0, 0, '', 0),
(411, 'account', 'ADMIN', 'details_pageviewhistory', 0, 0, 0, 6, '', 0),
(412, 'account', 'ADMIN', 'details_loginhistory', 0, 0, 0, 6, '', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_product_cart`
--

CREATE TABLE `cb_product_cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session` varchar(128) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `mod_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_product_category`
--

CREATE TABLE `cb_product_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'hu',
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(63) NOT NULL,
  `text` text NOT NULL,
  `image` varchar(50) NOT NULL,
  `state` int(2) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_product_category`
--

INSERT INTO `cb_product_category` (`id`, `cat_id`, `lang`, `parent`, `name`, `text`, `image`, `state`, `order`) VALUES
(1, 1, 'hu', 0, 'Kategória 1', '', '', 1, 0),
(2, 2, 'hu', 0, 'Kategória 2', '', '', 1, 0),
(3, 3, 'hu', 0, 'Kategória 3', '', '', 1, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_product_category_xref`
--

CREATE TABLE `cb_product_category_xref` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_product_order`
--

CREATE TABLE `cb_product_order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_name` varchar(256) NOT NULL,
  `order_zipcode` varchar(10) NOT NULL,
  `order_city` varchar(64) NOT NULL,
  `order_street` varchar(256) NOT NULL,
  `order_placenumber` varchar(256) NOT NULL,
  `order_other` varchar(512) NOT NULL,
  `phone` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `message` text NOT NULL,
  `state` int(1) NOT NULL,
  `order_date` int(11) NOT NULL,
  `mod_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_product_order_product`
--

CREATE TABLE `cb_product_order_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(128) NOT NULL,
  `nev` varchar(256) NOT NULL,
  `termekkod` varchar(128) NOT NULL,
  `cikkszam` varchar(128) NOT NULL,
  `raktarkeszlet` int(11) NOT NULL,
  `raktarpozicio` varchar(128) NOT NULL,
  `listaar` float(15,2) NOT NULL,
  `last_updatetime` int(11) NOT NULL,
  `rendeltmennyiseg` int(11) NOT NULL,
  `kiajanlottar` int(11) NOT NULL,
  `kiajanlottmennyiseg` int(11) NOT NULL,
  `order_updatetime` int(11) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_product_product`
--

CREATE TABLE `cb_product_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(128) NOT NULL,
  `name` varchar(256) NOT NULL,
  `shorttext` mediumtext NOT NULL,
  `text` longtext NOT NULL,
  `lang` varchar(2) NOT NULL,
  `state` int(2) NOT NULL DEFAULT '0',
  `cre_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mod_date` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `meta_author` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  `media` text NOT NULL,
  `template` varchar(50) NOT NULL,
  `class` varchar(50) NOT NULL,
  `content_id` int(11) NOT NULL,
  `short_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_session`
--

CREATE TABLE `cb_session` (
  `session` varchar(128) NOT NULL,
  `uid` int(11) NOT NULL,
  `grouplevel` int(3) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `last_page` varchar(512) DEFAULT NULL,
  `longlive` int(1) NOT NULL DEFAULT '0',
  `sessionrowtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sessionend` datetime NOT NULL,
  `dos` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_session`
--

INSERT INTO `cb_session` (`session`, `uid`, `grouplevel`, `lang`, `ip`, `last_page`, `longlive`, `sessionrowtime`, `sessionend`, `dos`) VALUES
('e4wb37d22fe4czczshs5grshvzp7wdw8rcwx2x6ufv8ckphtqr5a82esjiz3pnimuhabyzq3r8f7md7vdjfphe87i2vrjj2v4ivkkk6xreksvdnumbrqjmc3uv44zezm', 1, 255, 'hu', '80.99.175.27', 'http://corebeat-20.webed.hu/?ticketsystem=1&t=1579011869979', 0, '2020-01-06 12:13:09', '2020-01-07 12:19:15', 0),
('tzuj7jxh5w5p7fjbuemjuutnvcy7mxsm8uz5vn8utksfzjvbgibmw8bz7n4z4wvpic475fnw4bhzft7s85hdmxqnt7fgyppvdsyqkwnvz4jceh4kquczmwedyyifp827', 0, 0, 'hu', '80.99.175.27', 'http://corebeat-20-public.webed.hu/?ticketsystem=1&t=1579011799631', 0, '2020-01-06 12:18:05', '2020-01-07 12:18:05', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_session_token`
--

CREATE TABLE `cb_session_token` (
  `token` varchar(128) NOT NULL,
  `session` varchar(128) NOT NULL,
  `device` varchar(20) NOT NULL,
  `tokenrowtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tokenend` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_settings`
--

CREATE TABLE `cb_settings` (
  `key` varchar(32) NOT NULL,
  `value` varchar(512) NOT NULL,
  `auto_load` tinyint(1) NOT NULL DEFAULT '0',
  `edit_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_settings`
--

INSERT INTO `cb_settings` (`key`, `value`, `auto_load`, `edit_level`) VALUES
('account_api_key', '', 1, 'settings_account_api'),
('account_api_secret', '', 1, 'settings_account_api'),
('account_api_url', '', 1, 'settings_account_api'),
('account_local_activation', 'none', 1, 'settings_level_2'),
('account_local_invite', 'none', 1, 'settings_level_2'),
('account_local_register', 'normal', 1, 'settings_level_2'),
('account_login_type', 'local', 1, 'settings_level_2'),
('admin_headerbar', 'true', 1, 'settings_level_2'),
('admin_themeset', 'booty4', 1, 'settings_level_2'),
('admin_themeset_color', 'black', 1, 'settings_level_1'),
('api_token_live', '3600', 1, 'settings_level_2'),
('article_headerimg_height', '1080', 1, 'settings_article'),
('article_headerimg_width', '1920', 1, 'settings_article'),
('article_thumbnail_normal_height', '1024', 1, 'settings_article'),
('article_thumbnail_normal_width', '1024', 1, 'settings_article'),
('article_thumbnail_small_height', '1024', 1, 'settings_article'),
('article_thumbnail_small_width', '480', 1, 'settings_article'),
('catalog_headerimg_height', '1080', 1, 'settings_catalog'),
('catalog_headerimg_width', '1920', 1, 'settings_catalog'),
('catalog_image_max_height', '2048', 1, 'settings_catalog'),
('catalog_image_max_width', '2048', 1, 'settings_catalog'),
('catalog_thumbnail_normal_height', '1024', 1, 'settings_catalog'),
('catalog_thumbnail_normal_width', '1024', 1, 'settings_catalog'),
('catalog_thumbnail_small_height', '480', 1, 'settings_catalog'),
('catalog_thumbnail_small_width', '480', 1, 'settings_catalog'),
('currency_base', 'HUF', 1, 'settings_currency'),
('currency_refreshtime', '3500', 1, 'settings_currency'),
('debug', 'true', 1, 'settings_level_2'),
('debug_memory', 'false', 1, 'settings_level_2'),
('def_page', '1', 1, 'settings_level_1'),
('error403_user_login', 'true', 1, 'settings_level_1'),
('error404_load_mainpage', 'true', 1, 'settings_level_1'),
('gallery_thumbnail_height', '600', 1, 'settings_gallery'),
('gallery_thumbnail_width', '600', 1, 'settings_gallery'),
('google_analytics_code', '', 1, 'settings_google_analytics'),
('google_recapcha3_key', '', 1, 'settings_recapcha'),
('google_recapcha3_secret', '', 1, 'settings_recapcha'),
('is_seo', 'true', 1, 'settings_level_1'),
('langtype', 'hu|en', 1, 'settings_level_2'),
('langtype_admin_default', 'hu', 1, 'settings_level_2'),
('langtype_user_default', 'hu', 1, 'settings_level_2'),
('login_fb_api_code', '', 1, 'settings_social_login_facebook'),
('login_fb_api_secret', '', 1, 'settings_social_login_facebook'),
('login_fb_enable', 'false', 1, 'settings_social_login_facebook'),
('login_gp_api_ap_name', '', 1, 'settings_social_login_google'),
('login_gp_api_code', '', 1, 'settings_social_login_google'),
('login_gp_api_secret', '', 1, 'settings_social_login_google'),
('login_gp_enable', 'false', 1, 'settings_social_login_google'),
('mail_charset', 'utf-8', 1, 'settings_mail'),
('mail_from', 'info@webed.hu', 1, 'settings_mail'),
('mail_from_name', 'CoreBeat', 1, 'settings_mail'),
('mail_sablon', 'default', 1, 'settings_mail'),
('mail_sendmail_root', '/usr/bin/sendmail', 1, 'settings_mail'),
('mail_smtp_auth', 'true', 1, 'settings_mail'),
('mail_smtp_password', '', 1, 'settings_mail'),
('mail_smtp_port', '465', 1, 'settings_mail'),
('mail_smtp_secure', 'ssl', 1, 'settings_mail'),
('mail_smtp_server', '', 1, 'settings_mail'),
('mail_smtp_username', '', 1, 'settings_mail'),
('mail_type', 'mail', 1, 'settings_mail'),
('mail_xoauth2_client_id', '', 1, 'settings_mail'),
('mail_xoauth2_client_secret', '', 1, 'settings_mail'),
('mail_xoauth2_refresh_token', '', 1, 'settings_mail'),
('mail_xoauth2_user_email', '', 1, 'settings_mail'),
('maintenance', 'false', 1, 'settings_level_1'),
('media_image_max_height', '2048', 1, 'settings_media'),
('media_image_max_width', '2048', 1, 'settings_media'),
('media_thumbnail_normal_height', '1024', 1, 'settings_media'),
('media_thumbnail_normal_width', '1024', 1, 'settings_media'),
('media_thumbnail_small_height', '480', 1, 'settings_media'),
('media_thumbnail_small_width', '480', 1, 'settings_media'),
('message_position', 'bottom-right', 1, 'settings_level_1'),
('message_refresh_time', '5000', 1, 'settings_level_1'),
('message_remove_time', '2592000', 1, 'settings_level_1'),
('message_show_time', '5000', 1, 'settings_level_1'),
('meta_def_auth', '', 1, 'settings_level_1'),
('meta_def_desc', '', 1, 'settings_level_1'),
('meta_def_key', '', 1, 'settings_level_1'),
('number_format', 'hu_HU', 1, 'settings_level_2'),
('pagetitle_style', '1', 1, 'settings_level_1'),
('php_set_time_limit', '60', 1, 'settings_level_2'),
('product_headerimg_height', '1080', 1, 'settings_product'),
('product_headerimg_width', '1920', 1, 'settings_product'),
('product_thumbnail_normal_height', '1024', 1, 'settings_product'),
('product_thumbnail_normal_width', '1024', 1, 'settings_product'),
('product_thumbnail_small_height', '1024', 1, 'settings_product'),
('product_thumbnail_small_width', '480', 1, 'settings_product'),
('registration_form', 'normal', 1, 'settings_level_2'),
('registration_term_id', '6', 1, 'settings_level_1'),
('savelog', 'detailed', 1, 'settings_level_2'),
('seo_link_image', '', 1, 'settings_level_2'),
('sessionddoscount', '1000', 1, 'settings_level_2'),
('sessionddostime', '60', 1, 'settings_level_2'),
('sessionstayloginvalue', '2592000', 1, 'settings_level_2'),
('sessionvalue', '86400', 1, 'settings_level_2'),
('sitetitle', 'CoreDevil', 1, 'settings_level_1'),
('sitetitle2', '', 1, 'settings_level_1'),
('themeset', 'simple_x2', 1, 'settings_level_2');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_settings_cache`
--

CREATE TABLE `cb_settings_cache` (
  `key` varchar(32) NOT NULL,
  `value` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_settings_cache`
--

INSERT INTO `cb_settings_cache` (`key`, `value`) VALUES
('cb_update_process', 'false'),
('cb_update_process_file', 'false'),
('cb_update_process_sql', 'false');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_system_log`
--

CREATE TABLE `cb_system_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `grouplevel` int(3) NOT NULL DEFAULT '0',
  `lang` varchar(2) NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `session` varchar(128) DEFAULT NULL,
  `page` varchar(512) DEFAULT NULL,
  `module` varchar(30) DEFAULT NULL,
  `function` varchar(50) DEFAULT NULL,
  `data` longtext,
  `mpost` json DEFAULT NULL,
  `mget` json DEFAULT NULL,
  `is_admin` int(1) NOT NULL DEFAULT '0',
  `is_ajax` tinyint(1) NOT NULL DEFAULT '0',
  `is_api` int(1) NOT NULL DEFAULT '0',
  `redirect` varchar(512) DEFAULT NULL,
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_team`
--

CREATE TABLE `cb_team` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `text` longtext NOT NULL,
  `titulus` varchar(512) NOT NULL,
  `munkai` varchar(512) NOT NULL,
  `foglalas` varchar(512) NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'hu',
  `state` int(2) NOT NULL DEFAULT '0',
  `media` text NOT NULL,
  `class` varchar(512) DEFAULT '',
  `short_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_user`
--

CREATE TABLE `cb_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(128) NOT NULL,
  `level` int(11) NOT NULL,
  `state` int(1) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'local',
  `image` varchar(20) NOT NULL DEFAULT 'gravatar',
  `first_login` tinyint(1) NOT NULL DEFAULT '0',
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reg_code` varchar(64) DEFAULT '',
  `last_login` datetime DEFAULT NULL,
  `login_count` int(11) NOT NULL DEFAULT '0',
  `pass_reset_date` datetime DEFAULT NULL,
  `pass_reset_code` varchar(64) NOT NULL DEFAULT '',
  `code` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_user`
--

INSERT INTO `cb_user` (`id`, `email`, `password`, `level`, `state`, `type`, `image`, `first_login`, `reg_date`, `reg_code`, `last_login`, `login_count`, `pass_reset_date`, `pass_reset_code`, `code`) VALUES
(1, 'erdi.gabor@webed.hu', '91ce4d7f223693d38464ba5eb83b790db6efbcc32e87774ccbe09f09a42217a66b3ca8cb23190b0177ac169d6821c0f6a8cbd10d51a7921537c2ee350b346909', 255, 1, 'local', 'gravatar', 0, '2019-05-30 12:41:01', 'hpzuiy5xqiqg78cbe8g7vqh5uycsr76isamzvdgt73fuqbxjeshhkumvx32p4tu5', '2020-01-06 12:13:09', 86, NULL, '', '96f92e61b4a68ee40386992ead5421b73d8625817c6b1f12882fe5ed5f1650b6'),
(2, 'nanao10@aninet.eu', '4c5ce3349851a6090c4865457ea57dfcafcd1278768bec07698c38836026c6b2e89370d7ec4714c70ae8a86cb5f8efe03d602165a3bf1fb4c51588a0bdbb80e2', 1, 1, 'local', 'gravatar', 0, '2019-10-21 22:55:04', 'bpdjd5mwqkatye4ssqm3z8ecpfy67ckr4h8dv5stsacihtvpvkqha2u7kyi8m7b6', NULL, 0, NULL, '', '414c31d54929edf078093697f20a0b4321680b8d2b388335ae3d115d79430ca2'),
(3, 'archgiel@gmail.com', '0144a9aa58a1b2e66df7f7c1abf853046548a730639acc5645889653bf4a61dce0eabbc9f8cd6771b0dea481d43d87ad8b521f3783425ef7e88cfa98cdea999e', 1, 1, 'local', 'gravatar', 1, '2019-10-23 15:50:47', 'de6rp8vw7mf2wu8g3wb2j8rgj3vgh42gf6b77d5pac8ci6ymqb2gsir8qyn3ypwk', NULL, 0, NULL, '', '18df26fcafbb9d3cc9cda4325443ae27afa68caf68fac59aed0950069973495c'),
(5, 'nanao11@aninet.eu', '931c9bc324c64daebf8722ff8ad5ba611ec3036ec1973c619fd98e36a89568233e08f065531357ed1cbb80301ed15dd4c2f52e8c97566262e207b00e4d8c6bf7', 200, 1, 'local', 'gravatar', 1, '2019-10-28 16:09:47', 'hyqbng5pjfu8kbyvdbc2qvmtc8a6th68egz5ukushmrzz5ecw6qv3hmra6zji2ea', NULL, 0, NULL, '', 'ac56d6ac0559c17781a9693f39f14cb0cd36685dbf095c0abdfbdabc1497c191'),
(13, 'nanao12@aninet.eu', '511d736e44b96ff2ab3949117a7927cd21da6d6b53b8b3f0679b4999ea019048c8c550cc4057b30b44520d43c8c67f0f5550ec7516d87fbbaf963574331d1986', 1, 1, 'local', 'gravatar', 1, '2019-11-02 22:59:32', 'e485bh5avsb7gax4dppjbqt55dz7gjsaaw6e7mgw3qnhrxd6updikbsnxt7rua8k', NULL, 0, NULL, '', 'cy7k2'),
(14, 'admin@corebeat.hu', '91ce4d7f223693d38464ba5eb83b790db6efbcc32e87774ccbe09f09a42217a66b3ca8cb23190b0177ac169d6821c0f6a8cbd10d51a7921537c2ee350b346909', 255, 1, 'local', 'gravatar', 1, '2020-01-06 12:10:53', 'yppt588dqh83q46gnuge8epchy45eujvzxefj5vuiiv8m2d83bqhq4cs62pjh34n', NULL, 0, NULL, '', '0437e3f52c475a88d1e843907ee6c7e4fdc40ad0030d17a5a3869442644befde');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_user_data`
--

CREATE TABLE `cb_user_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `data_key` varchar(255) DEFAULT NULL,
  `data_value` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_user_data`
--

INSERT INTO `cb_user_data` (`id`, `user_id`, `data_key`, `data_value`) VALUES
(1, 1, 'first_name', 'Ruby'),
(2, 1, 'last_name', 'Rose'),
(3, 1, 'display_name', 'Ruby Rose'),
(28, 1, 'admin_theme_style', ''),
(29, 2, 'first_name', 'Gábor'),
(30, 2, 'last_name', 'Érdi'),
(31, 2, 'display_name', 'asd'),
(32, 2, 'admin_theme_style', ''),
(53, 3, 'first_name', ''),
(54, 3, 'last_name', ''),
(55, 3, 'display_name', ''),
(56, 3, 'admin_theme_style', ''),
(57, 5, 'first_name', ''),
(58, 5, 'last_name', ''),
(59, 5, 'display_name', ''),
(60, 5, 'admin_theme_style', ''),
(117, 14, 'first_name', 'Admin'),
(118, 14, 'last_name', 'Admin'),
(119, 14, 'display_name', 'Teszt Admin'),
(120, 14, 'admin_theme_style', '');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_user_data_fields`
--

CREATE TABLE `cb_user_data_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data_key` varchar(255) DEFAULT NULL,
  `admin_can_mod` tinyint(1) NOT NULL DEFAULT '1',
  `user_can_mod` tinyint(1) NOT NULL DEFAULT '1',
  `user_can_see` tinyint(1) NOT NULL DEFAULT '1',
  `default_value` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_user_data_fields`
--

INSERT INTO `cb_user_data_fields` (`id`, `data_key`, `admin_can_mod`, `user_can_mod`, `user_can_see`, `default_value`) VALUES
(1, 'first_name', 1, 1, 1, NULL),
(2, 'last_name', 1, 1, 1, NULL),
(3, 'display_name', 1, 1, 1, NULL),
(4, 'admin_theme_style', 1, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_user_level`
--

CREATE TABLE `cb_user_level` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `setup` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `cb_user_level`
--

INSERT INTO `cb_user_level` (`id`, `name`, `setup`) VALUES
(0, 'GUEST', '01f00000e001800000001000000000b000c00000040018000080000000000000007c0014000703c000f0000000000000000002'),
(1, 'USER', '01f00000e001800000001000000000b000c00000040018000080000000000000007c0f94000703c000f0000000000000000002'),
(200, 'ADMIN', 'fff00fffffff90000a07ff00000000d800c40033847878000080000000000000007c0f94199703c000b000f9001000000000020'),
(255, 'SUPERADMIN', 'fff00fffffff90000a07ff00000000d800c4003f847878006080000000000000007c0f941fd00000000000f9fff78000107f82f');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_user_message`
--

CREATE TABLE `cb_user_message` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `from_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(128) NOT NULL,
  `message` text NOT NULL,
  `readed` tinyint(1) NOT NULL DEFAULT '0',
  `archive` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cb_user_sdk`
--

CREATE TABLE `cb_user_sdk` (
  `id` int(11) NOT NULL,
  `provider` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `data` longtext COLLATE utf8_unicode_ci,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `cb_api_connections`
--
ALTER TABLE `cb_api_connections`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cb_article`
--
ALTER TABLE `cb_article`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_id_1` (`article_id`,`lang`);

--
-- A tábla indexei `cb_article_archive`
--
ALTER TABLE `cb_article_archive`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_id` (`article_id`,`lang`,`version`);

--
-- A tábla indexei `cb_article_category`
--
ALTER TABLE `cb_article_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cat_id` (`cat_id`,`lang`);

--
-- A tábla indexei `cb_article_category_xref`
--
ALTER TABLE `cb_article_category_xref`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cat_id` (`cat_id`,`article_id`);

--
-- A tábla indexei `cb_article_preview`
--
ALTER TABLE `cb_article_preview`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_id_1` (`article_id`,`lang`);

--
-- A tábla indexei `cb_catalog`
--
ALTER TABLE `cb_catalog`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `catalog_id` (`catalog_id`,`lang`) USING BTREE,
  ADD KEY `keresonev` (`name`(255));

--
-- A tábla indexei `cb_catalog_category`
--
ALTER TABLE `cb_catalog_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cat_id` (`category_id`,`lang`);

--
-- A tábla indexei `cb_catalog_category_xref`
--
ALTER TABLE `cb_catalog_category_xref`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cat_id` (`category_id`,`catalog_id`);

--
-- A tábla indexei `cb_contact_forms`
--
ALTER TABLE `cb_contact_forms`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cb_contact_maps`
--
ALTER TABLE `cb_contact_maps`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cb_contact_posts`
--
ALTER TABLE `cb_contact_posts`
  ADD UNIQUE KEY `id` (`id`);

--
-- A tábla indexei `cb_content`
--
ALTER TABLE `cb_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`lang`,`seo_name`);

--
-- A tábla indexei `cb_content_seo`
--
ALTER TABLE `cb_content_seo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`lang`,`seo_name`);

--
-- A tábla indexei `cb_content_type`
--
ALTER TABLE `cb_content_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `module` (`module`,`type`);

--
-- A tábla indexei `cb_currency_list`
--
ALTER TABLE `cb_currency_list`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cb_currency_value`
--
ALTER TABLE `cb_currency_value`
  ADD PRIMARY KEY (`base`,`vto`),
  ADD KEY `refresh_date` (`refresh_date`);

--
-- A tábla indexei `cb_file`
--
ALTER TABLE `cb_file`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cb_gallery`
--
ALTER TABLE `cb_gallery`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cat_id` (`cat_id`,`md5`) USING BTREE;

--
-- A tábla indexei `cb_gallery_category`
--
ALTER TABLE `cb_gallery_category`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cb_invite`
--
ALTER TABLE `cb_invite`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- A tábla indexei `cb_language`
--
ALTER TABLE `cb_language`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rowget` (`lang`,`is_admin`,`module`,`constant`) USING BTREE,
  ADD KEY `predict` (`debugger_predicted`),
  ADD KEY `translate_need` (`translate_need`),
  ADD KEY `deprecated` (`deprecated`);

--
-- A tábla indexei `cb_media`
--
ALTER TABLE `cb_media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file_name` (`file_original_name`,`md5`);

--
-- A tábla indexei `cb_media_xref`
--
ALTER TABLE `cb_media_xref`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_id` (`media_id`,`referer`,`referer_id`) USING BTREE;

--
-- A tábla indexei `cb_menu`
--
ALTER TABLE `cb_menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_id` (`id`,`content_id`);

--
-- A tábla indexei `cb_menu_category`
--
ALTER TABLE `cb_menu_category`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cb_message`
--
ALTER TABLE `cb_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`session_id`);

--
-- A tábla indexei `cb_message_out`
--
ALTER TABLE `cb_message_out`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `message_id` (`message_id`,`random_id`);

--
-- A tábla indexei `cb_module`
--
ALTER TABLE `cb_module`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`module_name`,`type`,`function`);

--
-- A tábla indexei `cb_product_cart`
--
ALTER TABLE `cb_product_cart`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cb_product_category`
--
ALTER TABLE `cb_product_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cat_id` (`cat_id`,`lang`);

--
-- A tábla indexei `cb_product_category_xref`
--
ALTER TABLE `cb_product_category_xref`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cat_id` (`cat_id`,`product_id`);

--
-- A tábla indexei `cb_product_order`
--
ALTER TABLE `cb_product_order`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cb_product_order_product`
--
ALTER TABLE `cb_product_order_product`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cb_product_product`
--
ALTER TABLE `cb_product_product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`,`sku`,`lang`),
  ADD KEY `name` (`name`);

--
-- A tábla indexei `cb_session`
--
ALTER TABLE `cb_session`
  ADD PRIMARY KEY (`session`);

--
-- A tábla indexei `cb_session_token`
--
ALTER TABLE `cb_session_token`
  ADD PRIMARY KEY (`token`);

--
-- A tábla indexei `cb_settings`
--
ALTER TABLE `cb_settings`
  ADD PRIMARY KEY (`key`);

--
-- A tábla indexei `cb_settings_cache`
--
ALTER TABLE `cb_settings_cache`
  ADD PRIMARY KEY (`key`);

--
-- A tábla indexei `cb_system_log`
--
ALTER TABLE `cb_system_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `date_time` (`date_time`),
  ADD KEY `module` (`module`,`function`);

--
-- A tábla indexei `cb_team`
--
ALTER TABLE `cb_team`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_id_1` (`team_id`,`lang`) USING BTREE;

--
-- A tábla indexei `cb_user`
--
ALTER TABLE `cb_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `code` (`code`);

--
-- A tábla indexei `cb_user_data`
--
ALTER TABLE `cb_user_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`,`data_key`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `data_key` (`data_key`);

--
-- A tábla indexei `cb_user_data_fields`
--
ALTER TABLE `cb_user_data_fields`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cb_user_level`
--
ALTER TABLE `cb_user_level`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cb_user_message`
--
ALTER TABLE `cb_user_message`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cb_user_sdk`
--
ALTER TABLE `cb_user_sdk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `oauth_uid` (`provider`,`uid`) USING BTREE,
  ADD UNIQUE KEY `oauth_provider` (`provider`,`user_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `cb_api_connections`
--
ALTER TABLE `cb_api_connections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_article`
--
ALTER TABLE `cb_article`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT a táblához `cb_article_archive`
--
ALTER TABLE `cb_article_archive`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT a táblához `cb_article_category`
--
ALTER TABLE `cb_article_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `cb_article_category_xref`
--
ALTER TABLE `cb_article_category_xref`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_article_preview`
--
ALTER TABLE `cb_article_preview`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_catalog`
--
ALTER TABLE `cb_catalog`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_catalog_category`
--
ALTER TABLE `cb_catalog_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT a táblához `cb_catalog_category_xref`
--
ALTER TABLE `cb_catalog_category_xref`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_contact_forms`
--
ALTER TABLE `cb_contact_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `cb_contact_maps`
--
ALTER TABLE `cb_contact_maps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_contact_posts`
--
ALTER TABLE `cb_contact_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT a táblához `cb_content`
--
ALTER TABLE `cb_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `cb_content_seo`
--
ALTER TABLE `cb_content_seo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT a táblához `cb_content_type`
--
ALTER TABLE `cb_content_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT a táblához `cb_file`
--
ALTER TABLE `cb_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_gallery`
--
ALTER TABLE `cb_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT a táblához `cb_gallery_category`
--
ALTER TABLE `cb_gallery_category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `cb_invite`
--
ALTER TABLE `cb_invite`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_language`
--
ALTER TABLE `cb_language`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2000;

--
-- AUTO_INCREMENT a táblához `cb_media`
--
ALTER TABLE `cb_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_media_xref`
--
ALTER TABLE `cb_media_xref`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_menu`
--
ALTER TABLE `cb_menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT a táblához `cb_menu_category`
--
ALTER TABLE `cb_menu_category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `cb_message`
--
ALTER TABLE `cb_message`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=577;

--
-- AUTO_INCREMENT a táblához `cb_message_out`
--
ALTER TABLE `cb_message_out`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_module`
--
ALTER TABLE `cb_module`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=413;

--
-- AUTO_INCREMENT a táblához `cb_product_cart`
--
ALTER TABLE `cb_product_cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_product_category`
--
ALTER TABLE `cb_product_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `cb_product_category_xref`
--
ALTER TABLE `cb_product_category_xref`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_product_order`
--
ALTER TABLE `cb_product_order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_product_order_product`
--
ALTER TABLE `cb_product_order_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_product_product`
--
ALTER TABLE `cb_product_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_system_log`
--
ALTER TABLE `cb_system_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6270;

--
-- AUTO_INCREMENT a táblához `cb_team`
--
ALTER TABLE `cb_team`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_user`
--
ALTER TABLE `cb_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT a táblához `cb_user_data`
--
ALTER TABLE `cb_user_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT a táblához `cb_user_data_fields`
--
ALTER TABLE `cb_user_data_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `cb_user_message`
--
ALTER TABLE `cb_user_message`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cb_user_sdk`
--
ALTER TABLE `cb_user_sdk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
