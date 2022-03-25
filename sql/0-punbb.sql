-- phpMyAdmin SQL Dump
-- version 2.7.0-pl1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 01, 2006 at 01:34
-- Server version: 4.1.11
-- PHP Version: 4.4.0
--
-- Database: `spoon_punbb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bans`
--

DROP TABLE IF EXISTS `bans`;
CREATE TABLE IF NOT EXISTS `bans` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(200) default NULL,
  `ip` varchar(255) default NULL,
  `email` varchar(50) default NULL,
  `message` varchar(255) default NULL,
  `expire` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bans`
--


-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `cat_name` varchar(80) NOT NULL default 'New Category',
  `disp_position` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` VALUES (1, 'SPOON Hosting', 1);
INSERT INTO `categories` VALUES (4, 'SPOON Client Support', 3);
INSERT INTO `categories` VALUES (3, 'SPOON News', 2);

-- --------------------------------------------------------

--
-- Table structure for table `censoring`
--

DROP TABLE IF EXISTS `censoring`;
CREATE TABLE IF NOT EXISTS `censoring` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `search_for` varchar(60) NOT NULL default '',
  `replace_with` varchar(60) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `censoring`
--


-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `plan_id` int(10) NOT NULL default '0',
  `type` tinyint(1) NOT NULL default '0',
  `ordered` int(10) unsigned NOT NULL default '0',
  `domain` varchar(100) default NULL,
  `domain_reg` tinyint(1) NOT NULL default '0',
  `username` varchar(10) NOT NULL default '',
  `password` varchar(8) NOT NULL default '',
  `fname` varchar(40) NOT NULL default '',
  `lname` varchar(40) NOT NULL default '',
  `address1` varchar(100) NOT NULL default '',
  `address2` varchar(100) NOT NULL default '',
  `city` varchar(100) NOT NULL default '',
  `country` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=106 ;

--
-- Dumping data for table `clients`
--


-- --------------------------------------------------------

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `conf_name` varchar(255) NOT NULL default '',
  `conf_value` text,
  PRIMARY KEY  (`conf_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` VALUES ('o_cur_version', '1.2.10');
INSERT INTO `config` VALUES ('o_board_title', 'SPOON Hosting');
INSERT INTO `config` VALUES ('o_board_desc', 'New Zealand web hosting');
INSERT INTO `config` VALUES ('o_server_timezone', '12');
INSERT INTO `config` VALUES ('o_time_format', 'H:i:s');
INSERT INTO `config` VALUES ('o_date_format', 'd-m-Y');
INSERT INTO `config` VALUES ('o_timeout_visit', '600');
INSERT INTO `config` VALUES ('o_timeout_online', '300');
INSERT INTO `config` VALUES ('o_redirect_delay', '1');
INSERT INTO `config` VALUES ('o_show_version', '0');
INSERT INTO `config` VALUES ('o_show_user_info', '0');
INSERT INTO `config` VALUES ('o_show_post_count', '0');
INSERT INTO `config` VALUES ('o_smilies', '1');
INSERT INTO `config` VALUES ('o_smilies_sig', '1');
INSERT INTO `config` VALUES ('o_make_links', '1');
INSERT INTO `config` VALUES ('o_default_lang', 'English');
INSERT INTO `config` VALUES ('o_default_style', 'Spoon');
INSERT INTO `config` VALUES ('o_default_user_group', '4');
INSERT INTO `config` VALUES ('o_topic_review', '15');
INSERT INTO `config` VALUES ('o_disp_topics_default', '30');
INSERT INTO `config` VALUES ('o_disp_posts_default', '25');
INSERT INTO `config` VALUES ('o_indent_num_spaces', '4');
INSERT INTO `config` VALUES ('o_quickpost', '1');
INSERT INTO `config` VALUES ('o_users_online', '1');
INSERT INTO `config` VALUES ('o_censoring', '0');
INSERT INTO `config` VALUES ('o_ranks', '1');
INSERT INTO `config` VALUES ('o_show_dot', '0');
INSERT INTO `config` VALUES ('o_quickjump', '1');
INSERT INTO `config` VALUES ('o_gzip', '0');
INSERT INTO `config` VALUES ('o_additional_navlinks', '');
INSERT INTO `config` VALUES ('o_report_method', '0');
INSERT INTO `config` VALUES ('o_regs_report', '0');
INSERT INTO `config` VALUES ('o_mailing_list', 'c.tippett@gmail.com');
INSERT INTO `config` VALUES ('o_avatars', '0');
INSERT INTO `config` VALUES ('o_avatars_dir', 'img/avatars');
INSERT INTO `config` VALUES ('o_avatars_width', '60');
INSERT INTO `config` VALUES ('o_avatars_height', '60');
INSERT INTO `config` VALUES ('o_avatars_size', '10240');
INSERT INTO `config` VALUES ('o_search_all_forums', '1');
INSERT INTO `config` VALUES ('o_base_url', 'http://www.spoon.net.nz');
INSERT INTO `config` VALUES ('o_admin_email', 'spoon@spoon.net.nz');
INSERT INTO `config` VALUES ('o_webmaster_email', 'forums@spoon.net.nz');
INSERT INTO `config` VALUES ('o_subscriptions', '0');
INSERT INTO `config` VALUES ('o_smtp_host', NULL);
INSERT INTO `config` VALUES ('o_smtp_user', NULL);
INSERT INTO `config` VALUES ('o_smtp_pass', NULL);
INSERT INTO `config` VALUES ('o_regs_allow', '1');
INSERT INTO `config` VALUES ('o_regs_verify', '0');
INSERT INTO `config` VALUES ('o_announcement', '0');
INSERT INTO `config` VALUES ('o_announcement_message', 'Enter your announcement here.');
INSERT INTO `config` VALUES ('o_rules', '0');
INSERT INTO `config` VALUES ('o_rules_message', 'Enter your rules here.');
INSERT INTO `config` VALUES ('o_maintenance', '0');
INSERT INTO `config` VALUES ('o_maintenance_message', 'uh oh...');
INSERT INTO `config` VALUES ('p_mod_edit_users', '0');
INSERT INTO `config` VALUES ('p_mod_rename_users', '0');
INSERT INTO `config` VALUES ('p_mod_change_passwords', '0');
INSERT INTO `config` VALUES ('p_mod_ban_users', '0');
INSERT INTO `config` VALUES ('p_message_bbcode', '1');
INSERT INTO `config` VALUES ('p_message_img_tag', '1');
INSERT INTO `config` VALUES ('p_message_all_caps', '1');
INSERT INTO `config` VALUES ('p_subject_all_caps', '1');
INSERT INTO `config` VALUES ('p_sig_all_caps', '0');
INSERT INTO `config` VALUES ('p_sig_bbcode', '1');
INSERT INTO `config` VALUES ('p_sig_img_tag', '0');
INSERT INTO `config` VALUES ('p_sig_length', '400');
INSERT INTO `config` VALUES ('p_sig_lines', '4');
INSERT INTO `config` VALUES ('p_allow_banned_email', '0');
INSERT INTO `config` VALUES ('p_allow_dupe_email', '0');
INSERT INTO `config` VALUES ('p_force_guest_email', '1');

-- --------------------------------------------------------

--
-- Table structure for table `forum_perms`
--

DROP TABLE IF EXISTS `forum_perms`;
CREATE TABLE IF NOT EXISTS `forum_perms` (
  `group_id` int(10) NOT NULL default '0',
  `forum_id` int(10) NOT NULL default '0',
  `read_forum` tinyint(1) NOT NULL default '1',
  `post_replies` tinyint(1) NOT NULL default '1',
  `post_topics` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`group_id`,`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum_perms`
--

INSERT INTO `forum_perms` VALUES (2, 4, 1, 0, 0);
INSERT INTO `forum_perms` VALUES (4, 4, 1, 0, 0);
INSERT INTO `forum_perms` VALUES (4, 5, 1, 1, 0);
INSERT INTO `forum_perms` VALUES (3, 2, 1, 1, 1);
INSERT INTO `forum_perms` VALUES (5, 4, 1, 0, 0);
INSERT INTO `forum_perms` VALUES (5, 5, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

DROP TABLE IF EXISTS `forums`;
CREATE TABLE IF NOT EXISTS `forums` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `forum_name` varchar(80) NOT NULL default 'New forum',
  `forum_desc` text,
  `redirect_url` varchar(100) default NULL,
  `moderators` text,
  `num_topics` mediumint(8) unsigned NOT NULL default '0',
  `num_posts` mediumint(8) unsigned NOT NULL default '0',
  `last_post` int(10) unsigned default NULL,
  `last_post_id` int(10) unsigned default NULL,
  `last_poster` varchar(200) default NULL,
  `sort_by` tinyint(1) NOT NULL default '0',
  `disp_position` int(10) NOT NULL default '0',
  `cat_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `forums`
--

INSERT INTO `forums` VALUES (2, 'Pre-sales Questions', 'Got a question? Here''s the place to ask.', NULL, NULL, 0, 0, NULL, NULL, NULL, 0, 3, 1);
INSERT INTO `forums` VALUES (4, 'About SPOON', 'Find out more about SPOON Hosting.', NULL, NULL, 2, 2, 1135061861, 13, 'spoon', 0, 2, 1);
INSERT INTO `forums` VALUES (5, 'SPOON News', 'On-going updates of what''s happening at SPOON.', NULL, NULL, 2, 2, 1135692811, 15, 'spoon', 0, 3, 3);
INSERT INTO `forums` VALUES (6, 'SPOON Support', 'Need assistance? You can post here for help.', NULL, NULL, 0, 0, NULL, NULL, NULL, 0, 1, 4);
INSERT INTO `forums` VALUES (8, 'Bugs and Suggestions', 'Report any bugs or suggestions here.', NULL, NULL, 0, 0, NULL, NULL, NULL, 0, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `g_id` int(10) unsigned NOT NULL auto_increment,
  `g_title` varchar(50) NOT NULL default '',
  `g_user_title` varchar(50) default NULL,
  `g_read_board` tinyint(1) NOT NULL default '1',
  `g_post_replies` tinyint(1) NOT NULL default '1',
  `g_post_topics` tinyint(1) NOT NULL default '1',
  `g_post_polls` tinyint(1) NOT NULL default '1',
  `g_edit_posts` tinyint(1) NOT NULL default '1',
  `g_delete_posts` tinyint(1) NOT NULL default '1',
  `g_delete_topics` tinyint(1) NOT NULL default '1',
  `g_set_title` tinyint(1) NOT NULL default '1',
  `g_search` tinyint(1) NOT NULL default '1',
  `g_search_users` tinyint(1) NOT NULL default '1',
  `g_edit_subjects_interval` smallint(6) NOT NULL default '300',
  `g_post_flood` smallint(6) NOT NULL default '30',
  `g_search_flood` smallint(6) NOT NULL default '30',
  PRIMARY KEY  (`g_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` VALUES (1, 'Administrators', 'Administrator', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0);
INSERT INTO `groups` VALUES (2, 'Moderators', 'Moderator', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0);
INSERT INTO `groups` VALUES (3, 'Guest', NULL, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0);
INSERT INTO `groups` VALUES (4, 'Members', NULL, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 300, 60, 30);
INSERT INTO `groups` VALUES (5, 'SPOON', NULL, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 300, 60, 30);

-- --------------------------------------------------------

--
-- Table structure for table `online`
--

DROP TABLE IF EXISTS `online`;
CREATE TABLE IF NOT EXISTS `online` (
  `user_id` int(10) unsigned NOT NULL default '1',
  `ident` varchar(200) NOT NULL default '',
  `logged` int(10) unsigned NOT NULL default '0',
  `idle` tinyint(1) NOT NULL default '0',
  KEY `online_user_id_idx` (`user_id`)
) ENGINE=HEAP DEFAULT CHARSET=latin1;

--
-- Dumping data for table `online`
--

INSERT INTO `online` VALUES (2, 'spoon', 1136032204, 0);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
CREATE TABLE IF NOT EXISTS `plans` (
  `id` int(10) NOT NULL default '0',
  `plan_name` varchar(40) NOT NULL default '',
  `price` decimal(10,2) NOT NULL default '0.00',
  `diskspace` int(10) NOT NULL default '0',
  `bandwidth` int(10) NOT NULL default '0',
  `domains` int(10) NOT NULL default '0',
  `domains_sub` int(10) NOT NULL default '0',
  `email_act` int(10) NOT NULL default '0',
  `mysql_db` int(10) NOT NULL default '0',
  `price_img` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plans`
--
INSERT INTO `plans` VALUES (0, 'SPOON Free', 0.0, 10, 500, 1, 0, 1, 0, NULL);
INSERT INTO `plans` VALUES (1, 'Plan 01', 12.95, 500, 2500, 1, 100, 100, 1, '/images/plan_1.gif');
INSERT INTO `plans` VALUES (2, 'Plan 02', 25.95, 2000, 10000, 1, 100, 100, 1, '/images/plan_2.gif');
INSERT INTO `plans` VALUES (3, 'Plan 03', 39.95, 5000, 25000, 1, 100, 100, 1, '/images/plan_3.gif');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `poster` varchar(200) NOT NULL default '',
  `poster_id` int(10) unsigned NOT NULL default '1',
  `poster_ip` varchar(15) default NULL,
  `poster_email` varchar(50) default NULL,
  `message` text NOT NULL,
  `hide_smilies` tinyint(1) NOT NULL default '0',
  `posted` int(10) unsigned NOT NULL default '0',
  `edited` int(10) unsigned default NULL,
  `edited_by` varchar(200) default NULL,
  `topic_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `posts_topic_id_idx` (`topic_id`),
  KEY `posts_multi_idx` (`poster_id`,`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` VALUES (12, 'spoon', 2, '222.154.99.83', NULL, '[b]The Beginning[/b]\nA few years ago I started playing around with web design. I eventually learnt of PHP and MySQL, and how I could deliver dynamic content to people from a website. The only catch was, I needed a host that could support both PHP and MySQL in order for it to work.\n\nIt was then that I started looking for a host. Since I lived in New Zealand, I figured I''d try and find a New Zealand host.\n\nI found that there were plenty of [i]New Zealand[/i] hosts, but none of them appeared to have servers [i]in[/i] N.Z.\n\nI started researching into web hosting. Specifically, why local hosts were so hard to find.\n\n[b]Bandwidth[/b]\nBandwidth is expensive. In New Zealand, there is one link heading out of the country, that one link is shared by all of N.Z.\n\nStarting a web host in N.Z. and targetting international clients would be economically naive. New Zealand just doesn''t have the necessary bandwidth to remain competitve.\n\nHowever, targetting local clients is entirely different.\n\nNational bandwidth is a lot cheaper than international. Local peering networks such as the [url=http://en.wikipedia.org/wiki/Auckland_Peering_Exchange]Auckland Peering Exchange[/url] also make it easier to transfer data around N.Z.\n\nAs long as your hosting local clients, who serve local clients, web hosting in New Zealand doesn''t have to be expensive.\n\n[b]SPOON Hosting[/b]\nWith a bit of Lunix knowledge under my belt and the help of a few talented individuals, I put together a server that would not only satisfy my needs, but other''s as well.\n\nSPOON Hosting offers New Zealand web hosting, for New Zealanders.', 0, 1135057734, NULL, NULL, 9);
INSERT INTO `posts` VALUES (13, 'spoon', 2, '222.154.99.83', NULL, '[b]Hardware[/b]\n* Intel Celeron-D 2.66 GHz\n* 512 MB RAM\n* Running CentOS 4.2 (http://centos.org)\n\n[b]Network[/b]\n* 10 MBit National\n* 1 MBit International\n\nSPOON Hosting is targed towards New Zealanders, as such, we feel international capability is not a priority. Reducing our international bandwidth capacity allows us to offer cheaper hosting.', 0, 1135061861, NULL, NULL, 10);
INSERT INTO `posts` VALUES (14, 'spoon', 2, '222.154.99.83', NULL, 'A few days ago I reinstalled CentOS on this machine. I was told that Ubuntu was a nice alternative as a server O.S. (essentially a more up-to-date release of Debian), however support for Direct Admin wasn''t definite, so I went with CentOS.\n\nAfter an initial problem with a router blocking ports to the server, everything is now working smooth.\n\nThe server''s uptime is being monitored by siteuptime.com:\nhttp://www.siteuptime.com/statistics.php?Id=28294&&UserId=13614', 0, 1135064052, NULL, NULL, 11);
INSERT INTO `posts` VALUES (15, 'spoon', 2, '222.154.102.106', NULL, 'Today the previous owner of spoon.net.nz gave me ownership of his (expired) domain. Thanks to Buzz from [url=http://www.gpforums.co.nz]GPForums[/url] for transferring the domain.\n\nI also installed [url=http://hotsanic.sourceforge.net/]HotSaNIC[/url] today, which shows some interesting stats of the server. The stats are viewable at http://210.54.62.122/stats/', 0, 1135692811, NULL, NULL, 12);

-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

DROP TABLE IF EXISTS `ranks`;
CREATE TABLE IF NOT EXISTS `ranks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `rank` varchar(50) NOT NULL default '',
  `min_posts` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ranks`
--

INSERT INTO `ranks` VALUES (1, 'New member', 0);
INSERT INTO `ranks` VALUES (2, 'Member', 10);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `post_id` int(10) unsigned NOT NULL default '0',
  `topic_id` int(10) unsigned NOT NULL default '0',
  `forum_id` int(10) unsigned NOT NULL default '0',
  `reported_by` int(10) unsigned NOT NULL default '0',
  `created` int(10) unsigned NOT NULL default '0',
  `message` text NOT NULL,
  `zapped` int(10) unsigned default NULL,
  `zapped_by` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `reports_zapped_idx` (`zapped`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `reports`
--


-- --------------------------------------------------------

--
-- Table structure for table `search_cache`
--

DROP TABLE IF EXISTS `search_cache`;
CREATE TABLE IF NOT EXISTS `search_cache` (
  `id` int(10) unsigned NOT NULL default '0',
  `ident` varchar(200) NOT NULL default '',
  `search_data` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `search_cache_ident_idx` (`ident`(8))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `search_cache`
--

INSERT INTO `search_cache` VALUES (1294071141, 'spoon', 'a:5:{s:14:"search_results";s:1:"2";s:8:"num_hits";i:1;s:7:"sort_by";i:0;s:8:"sort_dir";s:4:"DESC";s:7:"show_as";s:6:"topics";}');
INSERT INTO `search_cache` VALUES (1473459097, 'spoon', 'a:5:{s:14:"search_results";s:1:"2";s:8:"num_hits";i:1;s:7:"sort_by";i:0;s:8:"sort_dir";s:4:"DESC";s:7:"show_as";s:6:"topics";}');
INSERT INTO `search_cache` VALUES (1694247369, 'spoon', 'a:5:{s:14:"search_results";s:13:"9,10,11,12,13";s:8:"num_hits";i:5;s:7:"sort_by";i:4;s:8:"sort_dir";s:4:"DESC";s:7:"show_as";s:6:"topics";}');
INSERT INTO `search_cache` VALUES (91920667, 'spoon', 'a:5:{s:14:"search_results";s:7:"9,10,13";s:8:"num_hits";i:3;s:7:"sort_by";i:0;s:8:"sort_dir";s:4:"DESC";s:7:"show_as";s:6:"topics";}');
INSERT INTO `search_cache` VALUES (718881578, 'spoon', 'a:5:{s:14:"search_results";s:10:"9,10,11,12";s:8:"num_hits";i:4;s:7:"sort_by";i:0;s:8:"sort_dir";s:4:"DESC";s:7:"show_as";s:6:"topics";}');

-- --------------------------------------------------------

--
-- Table structure for table `search_matches`
--

DROP TABLE IF EXISTS `search_matches`;
CREATE TABLE IF NOT EXISTS `search_matches` (
  `post_id` int(10) unsigned NOT NULL default '0',
  `word_id` mediumint(8) unsigned NOT NULL default '0',
  `subject_match` tinyint(1) NOT NULL default '0',
  KEY `search_matches_word_id_idx` (`word_id`),
  KEY `search_matches_post_id_idx` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `search_matches`
--

INSERT INTO `search_matches` VALUES (12, 19, 0);
INSERT INTO `search_matches` VALUES (12, 192, 0);
INSERT INTO `search_matches` VALUES (12, 17, 0);
INSERT INTO `search_matches` VALUES (12, 16, 0);
INSERT INTO `search_matches` VALUES (12, 15, 0);
INSERT INTO `search_matches` VALUES (12, 14, 0);
INSERT INTO `search_matches` VALUES (12, 10, 0);
INSERT INTO `search_matches` VALUES (12, 11, 0);
INSERT INTO `search_matches` VALUES (12, 194, 0);
INSERT INTO `search_matches` VALUES (12, 12, 0);
INSERT INTO `search_matches` VALUES (12, 196, 0);
INSERT INTO `search_matches` VALUES (12, 185, 0);
INSERT INTO `search_matches` VALUES (12, 187, 0);
INSERT INTO `search_matches` VALUES (12, 23, 0);
INSERT INTO `search_matches` VALUES (12, 24, 0);
INSERT INTO `search_matches` VALUES (12, 25, 0);
INSERT INTO `search_matches` VALUES (12, 186, 0);
INSERT INTO `search_matches` VALUES (12, 188, 0);
INSERT INTO `search_matches` VALUES (12, 28, 0);
INSERT INTO `search_matches` VALUES (12, 29, 0);
INSERT INTO `search_matches` VALUES (12, 30, 0);
INSERT INTO `search_matches` VALUES (12, 31, 0);
INSERT INTO `search_matches` VALUES (12, 191, 0);
INSERT INTO `search_matches` VALUES (12, 33, 0);
INSERT INTO `search_matches` VALUES (12, 193, 0);
INSERT INTO `search_matches` VALUES (12, 35, 0);
INSERT INTO `search_matches` VALUES (12, 36, 0);
INSERT INTO `search_matches` VALUES (12, 37, 0);
INSERT INTO `search_matches` VALUES (12, 38, 0);
INSERT INTO `search_matches` VALUES (12, 39, 0);
INSERT INTO `search_matches` VALUES (12, 40, 0);
INSERT INTO `search_matches` VALUES (12, 197, 0);
INSERT INTO `search_matches` VALUES (12, 42, 0);
INSERT INTO `search_matches` VALUES (12, 43, 0);
INSERT INTO `search_matches` VALUES (12, 44, 0);
INSERT INTO `search_matches` VALUES (12, 45, 0);
INSERT INTO `search_matches` VALUES (12, 46, 0);
INSERT INTO `search_matches` VALUES (12, 47, 0);
INSERT INTO `search_matches` VALUES (12, 48, 0);
INSERT INTO `search_matches` VALUES (12, 49, 0);
INSERT INTO `search_matches` VALUES (12, 50, 0);
INSERT INTO `search_matches` VALUES (12, 51, 0);
INSERT INTO `search_matches` VALUES (12, 52, 0);
INSERT INTO `search_matches` VALUES (12, 53, 0);
INSERT INTO `search_matches` VALUES (12, 54, 0);
INSERT INTO `search_matches` VALUES (12, 55, 0);
INSERT INTO `search_matches` VALUES (12, 56, 0);
INSERT INTO `search_matches` VALUES (12, 57, 0);
INSERT INTO `search_matches` VALUES (12, 58, 0);
INSERT INTO `search_matches` VALUES (12, 59, 0);
INSERT INTO `search_matches` VALUES (12, 60, 0);
INSERT INTO `search_matches` VALUES (12, 61, 0);
INSERT INTO `search_matches` VALUES (12, 62, 0);
INSERT INTO `search_matches` VALUES (12, 63, 0);
INSERT INTO `search_matches` VALUES (12, 64, 0);
INSERT INTO `search_matches` VALUES (12, 65, 0);
INSERT INTO `search_matches` VALUES (12, 66, 0);
INSERT INTO `search_matches` VALUES (12, 198, 0);
INSERT INTO `search_matches` VALUES (12, 68, 0);
INSERT INTO `search_matches` VALUES (12, 69, 0);
INSERT INTO `search_matches` VALUES (12, 70, 0);
INSERT INTO `search_matches` VALUES (12, 71, 0);
INSERT INTO `search_matches` VALUES (12, 72, 0);
INSERT INTO `search_matches` VALUES (12, 163, 0);
INSERT INTO `search_matches` VALUES (12, 74, 0);
INSERT INTO `search_matches` VALUES (12, 120, 0);
INSERT INTO `search_matches` VALUES (12, 76, 0);
INSERT INTO `search_matches` VALUES (12, 77, 0);
INSERT INTO `search_matches` VALUES (12, 156, 0);
INSERT INTO `search_matches` VALUES (12, 79, 0);
INSERT INTO `search_matches` VALUES (12, 80, 0);
INSERT INTO `search_matches` VALUES (12, 81, 0);
INSERT INTO `search_matches` VALUES (12, 82, 0);
INSERT INTO `search_matches` VALUES (12, 83, 0);
INSERT INTO `search_matches` VALUES (12, 84, 0);
INSERT INTO `search_matches` VALUES (12, 85, 0);
INSERT INTO `search_matches` VALUES (12, 86, 0);
INSERT INTO `search_matches` VALUES (12, 87, 0);
INSERT INTO `search_matches` VALUES (12, 88, 0);
INSERT INTO `search_matches` VALUES (12, 89, 0);
INSERT INTO `search_matches` VALUES (12, 90, 0);
INSERT INTO `search_matches` VALUES (12, 91, 0);
INSERT INTO `search_matches` VALUES (12, 92, 0);
INSERT INTO `search_matches` VALUES (12, 76, 1);
INSERT INTO `search_matches` VALUES (12, 201, 0);
INSERT INTO `search_matches` VALUES (13, 58, 0);
INSERT INTO `search_matches` VALUES (13, 65, 0);
INSERT INTO `search_matches` VALUES (13, 93, 0);
INSERT INTO `search_matches` VALUES (13, 94, 0);
INSERT INTO `search_matches` VALUES (13, 95, 0);
INSERT INTO `search_matches` VALUES (13, 96, 0);
INSERT INTO `search_matches` VALUES (13, 97, 0);
INSERT INTO `search_matches` VALUES (13, 98, 0);
INSERT INTO `search_matches` VALUES (13, 99, 0);
INSERT INTO `search_matches` VALUES (12, 67, 0);
INSERT INTO `search_matches` VALUES (14, 105, 0);
INSERT INTO `search_matches` VALUES (13, 102, 0);
INSERT INTO `search_matches` VALUES (13, 103, 0);
INSERT INTO `search_matches` VALUES (14, 104, 0);
INSERT INTO `search_matches` VALUES (14, 102, 0);
INSERT INTO `search_matches` VALUES (14, 86, 0);
INSERT INTO `search_matches` VALUES (13, 107, 0);
INSERT INTO `search_matches` VALUES (13, 108, 0);
INSERT INTO `search_matches` VALUES (13, 19, 1);
INSERT INTO `search_matches` VALUES (13, 109, 1);
INSERT INTO `search_matches` VALUES (13, 107, 1);
INSERT INTO `search_matches` VALUES (13, 86, 1);
INSERT INTO `search_matches` VALUES (13, 35, 0);
INSERT INTO `search_matches` VALUES (13, 157, 0);
INSERT INTO `search_matches` VALUES (13, 50, 0);
INSERT INTO `search_matches` VALUES (13, 92, 0);
INSERT INTO `search_matches` VALUES (13, 76, 0);
INSERT INTO `search_matches` VALUES (14, 42, 0);
INSERT INTO `search_matches` VALUES (13, 123, 0);
INSERT INTO `search_matches` VALUES (14, 33, 0);
INSERT INTO `search_matches` VALUES (13, 113, 0);
INSERT INTO `search_matches` VALUES (13, 114, 0);
INSERT INTO `search_matches` VALUES (13, 115, 0);
INSERT INTO `search_matches` VALUES (14, 11, 0);
INSERT INTO `search_matches` VALUES (13, 70, 0);
INSERT INTO `search_matches` VALUES (13, 163, 0);
INSERT INTO `search_matches` VALUES (13, 160, 0);
INSERT INTO `search_matches` VALUES (13, 158, 0);
INSERT INTO `search_matches` VALUES (13, 161, 0);
INSERT INTO `search_matches` VALUES (13, 45, 0);
INSERT INTO `search_matches` VALUES (14, 128, 0);
INSERT INTO `search_matches` VALUES (14, 129, 0);
INSERT INTO `search_matches` VALUES (14, 130, 0);
INSERT INTO `search_matches` VALUES (14, 131, 0);
INSERT INTO `search_matches` VALUES (14, 132, 0);
INSERT INTO `search_matches` VALUES (14, 133, 0);
INSERT INTO `search_matches` VALUES (14, 134, 0);
INSERT INTO `search_matches` VALUES (14, 135, 0);
INSERT INTO `search_matches` VALUES (14, 136, 0);
INSERT INTO `search_matches` VALUES (14, 137, 0);
INSERT INTO `search_matches` VALUES (14, 138, 0);
INSERT INTO `search_matches` VALUES (14, 139, 0);
INSERT INTO `search_matches` VALUES (14, 140, 0);
INSERT INTO `search_matches` VALUES (14, 141, 0);
INSERT INTO `search_matches` VALUES (14, 155, 0);
INSERT INTO `search_matches` VALUES (14, 143, 0);
INSERT INTO `search_matches` VALUES (14, 144, 0);
INSERT INTO `search_matches` VALUES (14, 145, 0);
INSERT INTO `search_matches` VALUES (14, 146, 0);
INSERT INTO `search_matches` VALUES (14, 147, 0);
INSERT INTO `search_matches` VALUES (14, 148, 0);
INSERT INTO `search_matches` VALUES (14, 149, 0);
INSERT INTO `search_matches` VALUES (14, 150, 0);
INSERT INTO `search_matches` VALUES (14, 151, 0);
INSERT INTO `search_matches` VALUES (14, 152, 0);
INSERT INTO `search_matches` VALUES (14, 153, 0);
INSERT INTO `search_matches` VALUES (14, 154, 0);
INSERT INTO `search_matches` VALUES (14, 129, 1);
INSERT INTO `search_matches` VALUES (14, 86, 1);
INSERT INTO `search_matches` VALUES (13, 23, 0);
INSERT INTO `search_matches` VALUES (13, 162, 0);
INSERT INTO `search_matches` VALUES (13, 159, 0);
INSERT INTO `search_matches` VALUES (12, 189, 0);
INSERT INTO `search_matches` VALUES (15, 86, 0);
INSERT INTO `search_matches` VALUES (15, 164, 0);
INSERT INTO `search_matches` VALUES (15, 165, 0);
INSERT INTO `search_matches` VALUES (15, 166, 0);
INSERT INTO `search_matches` VALUES (15, 167, 0);
INSERT INTO `search_matches` VALUES (15, 168, 0);
INSERT INTO `search_matches` VALUES (15, 169, 0);
INSERT INTO `search_matches` VALUES (15, 170, 0);
INSERT INTO `search_matches` VALUES (15, 171, 0);
INSERT INTO `search_matches` VALUES (15, 183, 0);
INSERT INTO `search_matches` VALUES (15, 182, 0);
INSERT INTO `search_matches` VALUES (15, 181, 0);
INSERT INTO `search_matches` VALUES (15, 175, 0);
INSERT INTO `search_matches` VALUES (15, 176, 0);
INSERT INTO `search_matches` VALUES (15, 177, 0);
INSERT INTO `search_matches` VALUES (15, 178, 0);
INSERT INTO `search_matches` VALUES (15, 179, 0);
INSERT INTO `search_matches` VALUES (15, 180, 0);
INSERT INTO `search_matches` VALUES (15, 171, 1);
INSERT INTO `search_matches` VALUES (15, 174, 1);
INSERT INTO `search_matches` VALUES (15, 167, 1);
INSERT INTO `search_matches` VALUES (12, 184, 0);
INSERT INTO `search_matches` VALUES (12, 112, 0);
INSERT INTO `search_matches` VALUES (12, 190, 0);
INSERT INTO `search_matches` VALUES (12, 195, 0);
INSERT INTO `search_matches` VALUES (12, 140, 0);
INSERT INTO `search_matches` VALUES (12, 200, 0);

-- --------------------------------------------------------

--
-- Table structure for table `search_words`
--

DROP TABLE IF EXISTS `search_words`;
CREATE TABLE IF NOT EXISTS `search_words` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `word` varchar(20) character set latin1 collate latin1_bin NOT NULL default '',
  PRIMARY KEY  (`word`),
  KEY `search_words_id_idx` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=218 ;

--
-- Dumping data for table `search_words`
--

INSERT INTO `search_words` VALUES (1, 0x74657374);
INSERT INTO `search_words` VALUES (11, 0x666577);
INSERT INTO `search_words` VALUES (3, 0x3232323232);
INSERT INTO `search_words` VALUES (4, 0x7465737432);
INSERT INTO `search_words` VALUES (10, 0x626567696e6e696e67);
INSERT INTO `search_words` VALUES (12, 0x7965617273);
INSERT INTO `search_words` VALUES (13, 0x68656176696c79);
INSERT INTO `search_words` VALUES (14, 0x776562);
INSERT INTO `search_words` VALUES (15, 0x64657369676e);
INSERT INTO `search_words` VALUES (16, 0x747279);
INSERT INTO `search_words` VALUES (17, 0x646966666572656e74);
INSERT INTO `search_words` VALUES (18, 0x7374796c6573);
INSERT INTO `search_words` VALUES (19, 0x616e64);
INSERT INTO `search_words` VALUES (20, 0x746563686e6971756573);
INSERT INTO `search_words` VALUES (21, 0x736565696e67);
INSERT INTO `search_words` VALUES (22, 0x656666656374697665);
INSERT INTO `search_words` VALUES (23, 0x6e6f74);
INSERT INTO `search_words` VALUES (24, 0x6576656e7475616c6c79);
INSERT INTO `search_words` VALUES (25, 0x706870);
INSERT INTO `search_words` VALUES (26, 0x636f64696e67);
INSERT INTO `search_words` VALUES (27, 0x7573696e67);
INSERT INTO `search_words` VALUES (28, 0x6d7973716c);
INSERT INTO `search_words` VALUES (29, 0x73746172746564);
INSERT INTO `search_words` VALUES (30, 0x6c6f6f6b696e67);
INSERT INTO `search_words` VALUES (31, 0x686f7374);
INSERT INTO `search_words` VALUES (32, 0x6f666665726564);
INSERT INTO `search_words` VALUES (33, 0x737570706f7274);
INSERT INTO `search_words` VALUES (34, 0x6c6976696e67);
INSERT INTO `search_words` VALUES (35, 0x6e6577);
INSERT INTO `search_words` VALUES (36, 0x7a65616c616e64);
INSERT INTO `search_words` VALUES (37, 0x66696775726564);
INSERT INTO `search_words` VALUES (38, 0x666f756e64);
INSERT INTO `search_words` VALUES (39, 0x706c656e7479);
INSERT INTO `search_words` VALUES (40, 0x686f737473);
INSERT INTO `search_words` VALUES (41, 0x7365656d6564);
INSERT INTO `search_words` VALUES (42, 0x73657276657273);
INSERT INTO `search_words` VALUES (43, 0x6e2e7a);
INSERT INTO `search_words` VALUES (44, 0x7265736561726368696e67);
INSERT INTO `search_words` VALUES (45, 0x686f7374696e67);
INSERT INTO `search_words` VALUES (46, 0x7370656369666963616c6c79);
INSERT INTO `search_words` VALUES (47, 0x6c6f63616c);
INSERT INTO `search_words` VALUES (48, 0x68617264);
INSERT INTO `search_words` VALUES (49, 0x66696e64);
INSERT INTO `search_words` VALUES (50, 0x62616e647769647468);
INSERT INTO `search_words` VALUES (51, 0x657870656e73697665);
INSERT INTO `search_words` VALUES (52, 0x6c696e6b);
INSERT INTO `search_words` VALUES (53, 0x68656164696e67);
INSERT INTO `search_words` VALUES (54, 0x636f756e747279);
INSERT INTO `search_words` VALUES (55, 0x736861726564);
INSERT INTO `search_words` VALUES (56, 0x7374617274696e67);
INSERT INTO `search_words` VALUES (57, 0x74617267657474696e67);
INSERT INTO `search_words` VALUES (58, 0x696e7465726e6174696f6e616c);
INSERT INTO `search_words` VALUES (59, 0x636c69656e7473);
INSERT INTO `search_words` VALUES (60, 0x6e61697665);
INSERT INTO `search_words` VALUES (61, 0x6e6563657373617279);
INSERT INTO `search_words` VALUES (62, 0x72656d61696e);
INSERT INTO `search_words` VALUES (63, 0x636f6d70657469747665);
INSERT INTO `search_words` VALUES (64, 0x656e746972656c79);
INSERT INTO `search_words` VALUES (65, 0x6e6174696f6e616c);
INSERT INTO `search_words` VALUES (66, 0x6c6f74);
INSERT INTO `search_words` VALUES (67, 0x656173696572);
INSERT INTO `search_words` VALUES (68, 0x70656572696e67);
INSERT INTO `search_words` VALUES (69, 0x6e6574776f726b73);
INSERT INTO `search_words` VALUES (70, 0x73756368);
INSERT INTO `search_words` VALUES (71, 0x6175636b6c616e64);
INSERT INTO `search_words` VALUES (72, 0x65786368616e6765);
INSERT INTO `search_words` VALUES (73, 0x6368656170);
INSERT INTO `search_words` VALUES (74, 0x6c6f6e67);
INSERT INTO `search_words` VALUES (75, 0x73657276696e67);
INSERT INTO `search_words` VALUES (76, 0x73706f6f6e);
INSERT INTO `search_words` VALUES (77, 0x626974);
INSERT INTO `search_words` VALUES (78, 0x756e6978);
INSERT INTO `search_words` VALUES (79, 0x6b6e6f776c65646765);
INSERT INTO `search_words` VALUES (80, 0x62656c74);
INSERT INTO `search_words` VALUES (81, 0x68656c70);
INSERT INTO `search_words` VALUES (82, 0x74616c656e746564);
INSERT INTO `search_words` VALUES (83, 0x696e646976696475616c73);
INSERT INTO `search_words` VALUES (84, 0x707574);
INSERT INTO `search_words` VALUES (85, 0x746f676574686572);
INSERT INTO `search_words` VALUES (86, 0x736572766572);
INSERT INTO `search_words` VALUES (87, 0x73617469736679);
INSERT INTO `search_words` VALUES (88, 0x6e65656473);
INSERT INTO `search_words` VALUES (89, 0x6f7468657273);
INSERT INTO `search_words` VALUES (90, 0x77656c6c);
INSERT INTO `search_words` VALUES (91, 0x6f6666657273);
INSERT INTO `search_words` VALUES (92, 0x7a65616c616e64657273);
INSERT INTO `search_words` VALUES (93, 0x6861726477617265);
INSERT INTO `search_words` VALUES (94, 0x696e74656c);
INSERT INTO `search_words` VALUES (95, 0x63656c65726f6e2d64);
INSERT INTO `search_words` VALUES (96, 0x322e3636);
INSERT INTO `search_words` VALUES (97, 0x67687a);
INSERT INTO `search_words` VALUES (98, 0x353132);
INSERT INTO `search_words` VALUES (99, 0x72616d);
INSERT INTO `search_words` VALUES (100, 0x6472697665);
INSERT INTO `search_words` VALUES (101, 0x736f667477617265);
INSERT INTO `search_words` VALUES (102, 0x63656e746f73);
INSERT INTO `search_words` VALUES (103, 0x342e32);
INSERT INTO `search_words` VALUES (104, 0x646972656374);
INSERT INTO `search_words` VALUES (105, 0x61646d696e);
INSERT INTO `search_words` VALUES (106, 0x696e7374616c6c6174726f6e);
INSERT INTO `search_words` VALUES (107, 0x6e6574776f726b);
INSERT INTO `search_words` VALUES (108, 0x6d626974);
INSERT INTO `search_words` VALUES (109, 0x696e666f726d6174696f6e);
INSERT INTO `search_words` VALUES (110, 0x66756c6c);
INSERT INTO `search_words` VALUES (112, 0x73696e6365);
INSERT INTO `search_words` VALUES (113, 0x746172676564);
INSERT INTO `search_words` VALUES (114, 0x746f7761726473);
INSERT INTO `search_words` VALUES (115, 0x7072696f72697479);
INSERT INTO `search_words` VALUES (116, 0x65717561746573);
INSERT INTO `search_words` VALUES (117, 0x6d6279746573);
INSERT INTO `search_words` VALUES (118, 0x617070726f78696d6174656c79);
INSERT INTO `search_words` VALUES (119, 0x393030);
INSERT INTO `search_words` VALUES (120, 0x64617461);
INSERT INTO `search_words` VALUES (121, 0x7472616e73666572726564);
INSERT INTO `search_words` VALUES (122, 0x6d6f6e7468);
INSERT INTO `search_words` VALUES (123, 0x72756e6e696e67);
INSERT INTO `search_words` VALUES (124, 0x72656475636564);
INSERT INTO `search_words` VALUES (125, 0x726561736f6e);
INSERT INTO `search_words` VALUES (126, 0x707269636573);
INSERT INTO `search_words` VALUES (127, 0x6c6f77);
INSERT INTO `search_words` VALUES (128, 0x64617973);
INSERT INTO `search_words` VALUES (129, 0x7265696e7374616c6c6564);
INSERT INTO `search_words` VALUES (130, 0x6d616368696e65);
INSERT INTO `search_words` VALUES (131, 0x746f6c64);
INSERT INTO `search_words` VALUES (132, 0x7562756e7475);
INSERT INTO `search_words` VALUES (133, 0x6e696365);
INSERT INTO `search_words` VALUES (134, 0x616c7465726e6174697665);
INSERT INTO `search_words` VALUES (135, 0x6f2e73);
INSERT INTO `search_words` VALUES (136, 0x657373656e7469616c6c79);
INSERT INTO `search_words` VALUES (137, 0x75702d746f2d64617465);
INSERT INTO `search_words` VALUES (138, 0x72656c65617365);
INSERT INTO `search_words` VALUES (139, 0x64656269616e);
INSERT INTO `search_words` VALUES (140, 0x686f7765766572);
INSERT INTO `search_words` VALUES (141, 0x7761736e74);
INSERT INTO `search_words` VALUES (142, 0x636f6e6669726d6564);
INSERT INTO `search_words` VALUES (143, 0x77656e74);
INSERT INTO `search_words` VALUES (144, 0x696e697469616c);
INSERT INTO `search_words` VALUES (145, 0x70726f626c656d);
INSERT INTO `search_words` VALUES (146, 0x726f75746572);
INSERT INTO `search_words` VALUES (147, 0x626c6f636b696e67);
INSERT INTO `search_words` VALUES (148, 0x706f727473);
INSERT INTO `search_words` VALUES (149, 0x65766572797468696e67);
INSERT INTO `search_words` VALUES (150, 0x776f726b696e67);
INSERT INTO `search_words` VALUES (151, 0x736d6f6f7468);
INSERT INTO `search_words` VALUES (152, 0x757074696d65);
INSERT INTO `search_words` VALUES (153, 0x6d6f6e69746f726564);
INSERT INTO `search_words` VALUES (154, 0x73697465757074696d652e636f6d);
INSERT INTO `search_words` VALUES (155, 0x646566696e697465);
INSERT INTO `search_words` VALUES (156, 0x6c756e6978);
INSERT INTO `search_words` VALUES (157, 0x6665656c);
INSERT INTO `search_words` VALUES (158, 0x6361706162696c697479);
INSERT INTO `search_words` VALUES (159, 0x7265647563696e67);
INSERT INTO `search_words` VALUES (160, 0x6361706163697479);
INSERT INTO `search_words` VALUES (161, 0x616c6c6f7773);
INSERT INTO `search_words` VALUES (162, 0x6f66666572);
INSERT INTO `search_words` VALUES (163, 0x63686561706572);
INSERT INTO `search_words` VALUES (164, 0x746f646179);
INSERT INTO `search_words` VALUES (165, 0x70726576696f7573);
INSERT INTO `search_words` VALUES (166, 0x6f776e6572);
INSERT INTO `search_words` VALUES (167, 0x73706f6f6e2e6e65742e6e7a);
INSERT INTO `search_words` VALUES (168, 0x67617665);
INSERT INTO `search_words` VALUES (169, 0x6f776e657273686970);
INSERT INTO `search_words` VALUES (170, 0x65787069726564);
INSERT INTO `search_words` VALUES (171, 0x646f6d61696e);
INSERT INTO `search_words` VALUES (172, 0x6f776e);
INSERT INTO `search_words` VALUES (173, 0x6f6666696369616c);
INSERT INTO `search_words` VALUES (174, 0x6e616d65);
INSERT INTO `search_words` VALUES (175, 0x696e7374616c6c6564);
INSERT INTO `search_words` VALUES (176, 0x686f7473616e6963);
INSERT INTO `search_words` VALUES (177, 0x73686f7773);
INSERT INTO `search_words` VALUES (178, 0x696e746572657374696e67);
INSERT INTO `search_words` VALUES (179, 0x7374617473);
INSERT INTO `search_words` VALUES (180, 0x7669657761626c65);
INSERT INTO `search_words` VALUES (181, 0x62757a7a);
INSERT INTO `search_words` VALUES (182, 0x6770666f72756d73);
INSERT INTO `search_words` VALUES (183, 0x7472616e7366657272696e67);
INSERT INTO `search_words` VALUES (184, 0x706c6179696e67);
INSERT INTO `search_words` VALUES (185, 0x6c6561726e74);
INSERT INTO `search_words` VALUES (186, 0x64656c69766572);
INSERT INTO `search_words` VALUES (187, 0x64796e616d6963);
INSERT INTO `search_words` VALUES (188, 0x636f6e74656e74);
INSERT INTO `search_words` VALUES (189, 0x70656f706c65);
INSERT INTO `search_words` VALUES (190, 0x77656273697465);
INSERT INTO `search_words` VALUES (191, 0x6361746368);
INSERT INTO `search_words` VALUES (192, 0x6e6565646564);
INSERT INTO `search_words` VALUES (193, 0x626f7468);
INSERT INTO `search_words` VALUES (194, 0x6f72646572);
INSERT INTO `search_words` VALUES (195, 0x776f726b);
INSERT INTO `search_words` VALUES (196, 0x6c69766564);
INSERT INTO `search_words` VALUES (197, 0x6170706561726564);
INSERT INTO `search_words` VALUES (198, 0x65636f6e6f6d6963616c6c79);
INSERT INTO `search_words` VALUES (199, 0x616c6c6f77);
INSERT INTO `search_words` VALUES (200, 0x7365727665);
INSERT INTO `search_words` VALUES (201, 0x7472616e73666572);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `topic_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriptions`
--


-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `poster` varchar(200) NOT NULL default '',
  `subject` varchar(255) NOT NULL default '',
  `posted` int(10) unsigned NOT NULL default '0',
  `last_post` int(10) unsigned NOT NULL default '0',
  `last_post_id` int(10) unsigned NOT NULL default '0',
  `last_poster` varchar(200) default NULL,
  `num_views` mediumint(8) unsigned NOT NULL default '0',
  `num_replies` mediumint(8) unsigned NOT NULL default '0',
  `closed` tinyint(1) NOT NULL default '0',
  `sticky` tinyint(1) NOT NULL default '0',
  `moved_to` int(10) unsigned default NULL,
  `forum_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `topics_forum_id_idx` (`forum_id`),
  KEY `topics_moved_to_idx` (`moved_to`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` VALUES (12, 'spoon', 'Domain Name: spoon.net.nz', 1135692811, 1135692811, 15, 'spoon', 6, 0, 0, 0, NULL, 5);
INSERT INTO `topics` VALUES (11, 'spoon', 'Server Reinstalled', 1135064052, 1135064052, 14, 'spoon', 8, 0, 0, 0, NULL, 5);
INSERT INTO `topics` VALUES (9, 'spoon', 'About SPOON', 1135057734, 1135057734, 12, 'spoon', 44, 0, 0, 1, NULL, 4);
INSERT INTO `topics` VALUES (10, 'spoon', 'Server and Network Information', 1135061861, 1135061861, 13, 'spoon', 20, 0, 0, 0, NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `group_id` int(10) unsigned NOT NULL default '4',
  `username` varchar(200) NOT NULL default '',
  `password` varchar(40) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `title` varchar(50) default NULL,
  `realname` varchar(40) default NULL,
  `url` varchar(100) default NULL,
  `jabber` varchar(75) default NULL,
  `icq` varchar(12) default NULL,
  `msn` varchar(50) default NULL,
  `aim` varchar(30) default NULL,
  `yahoo` varchar(30) default NULL,
  `location` varchar(30) default NULL,
  `use_avatar` tinyint(1) NOT NULL default '0',
  `signature` text,
  `disp_topics` tinyint(3) unsigned default NULL,
  `disp_posts` tinyint(3) unsigned default NULL,
  `email_setting` tinyint(1) NOT NULL default '1',
  `save_pass` tinyint(1) NOT NULL default '1',
  `notify_with_post` tinyint(1) NOT NULL default '0',
  `show_smilies` tinyint(1) NOT NULL default '1',
  `show_img` tinyint(1) NOT NULL default '1',
  `show_img_sig` tinyint(1) NOT NULL default '1',
  `show_avatars` tinyint(1) NOT NULL default '1',
  `show_sig` tinyint(1) NOT NULL default '1',
  `timezone` float NOT NULL default '0',
  `language` varchar(25) NOT NULL default 'English',
  `style` varchar(25) NOT NULL default 'Oxygen',
  `num_posts` int(10) unsigned NOT NULL default '0',
  `last_post` int(10) unsigned default NULL,
  `registered` int(10) unsigned NOT NULL default '0',
  `registration_ip` varchar(15) NOT NULL default '0.0.0.0',
  `last_visit` int(10) unsigned NOT NULL default '0',
  `admin_note` varchar(30) default NULL,
  `activate_string` varchar(50) default NULL,
  `activate_key` varchar(8) default NULL,
  `hosting` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `users_registered_idx` (`registered`),
  KEY `users_username_idx` (`username`(8))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES (1, 3, 'Guest', 'Guest', 'Guest', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 1, 0, 1, 1, 1, 1, 1, 0, 'English', 'Oxygen', 0, NULL, 0, '0.0.0.0', 0, NULL, NULL, NULL, 0);
INSERT INTO `users` VALUES (2, 1, 'spoon', '5f61f0c04a09068bd829e4eac366cf871e989793', 'c.tippett@gmail.com', NULL, 'Chris Tippett', NULL, NULL, NULL, NULL, NULL, NULL, 'Auckland, NZ', 0, NULL, NULL, NULL, 1, 1, 0, 1, 1, 1, 0, 1, 12, 'English', 'Spoon', 5, 1135821909, 1135001108, '127.0.0.1', 1136028592, NULL, NULL, NULL, 1);
INSERT INTO `users` VALUES (22, 4, 'chris', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'chris@draikon.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 1, 0, 1, 1, 1, 1, 1, 12, 'English', 'Spoon', 0, NULL, 1135928747, '222.154.106.205', 1136012777, NULL, NULL, NULL, 0);
