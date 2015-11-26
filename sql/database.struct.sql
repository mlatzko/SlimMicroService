-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2015 at 12:11 AM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `slim_micro_service`
--
CREATE DATABASE IF NOT EXISTS `slim_micro_service` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `slim_micro_service`;

-- --------------------------------------------------------

--
-- Table structure for table `example`
--

CREATE TABLE IF NOT EXISTS `example` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary identfier.',
  `type` varchar(55) NOT NULL COMMENT 'Type of user.',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Is user is active or not.',
  `alias` varchar(55) DEFAULT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Name of an user.',
  `email` varchar(255) NOT NULL COMMENT 'Email address of an user.',
  `age` int(3) NOT NULL COMMENT 'Age of an user.',
  `created` datetime DEFAULT NULL COMMENT 'Date entry the db entry was created by a user.',
  `modified` datetime DEFAULT NULL COMMENT 'Date entry the db entry was last modified by a user.',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
SET FOREIGN_KEY_CHECKS=1;
