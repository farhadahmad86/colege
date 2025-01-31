-- MySQL dump 10.19  Distrib 10.3.32-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: digitalmunshi_jm_pos
-- ------------------------------------------------------
-- Server version	10.3.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `circles`
--

DROP TABLE IF EXISTS `circles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `circles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) unsigned DEFAULT NULL,
  `region_id` bigint(20) unsigned DEFAULT NULL,
  `zone_id` bigint(20) unsigned DEFAULT NULL,
  `city_id` bigint(20) unsigned DEFAULT NULL,
  `grid_id` bigint(20) unsigned DEFAULT NULL,
  `franchise_area_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_croatian_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_croatian_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8_croatian_ci DEFAULT NULL,
  `usedBy` int(10) unsigned NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8_croatian_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `circles`
--

LOCK TABLES `circles` WRITE;
/*!40000 ALTER TABLE `circles` DISABLE KEYS */;
/*!40000 ALTER TABLE `circles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) unsigned DEFAULT NULL,
  `region_id` bigint(20) unsigned DEFAULT NULL,
  `zone_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_croatian_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_croatian_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8_croatian_ci DEFAULT NULL,
  `usedBy` int(10) unsigned NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8_croatian_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,110131,1,1,'377','',NULL,0,'Active',1,NULL,NULL,'2021-11-10 07:25:02','2021-11-10 07:25:02');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_croatian_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_croatian_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8_croatian_ci DEFAULT NULL,
  `usedBy` int(10) unsigned NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8_croatian_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `desktop_login_log`
--

DROP TABLE IF EXISTS `desktop_login_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `desktop_login_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_user_id` int(11) NOT NULL,
  `log_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `log_ip` varchar(500) COLLATE utf8_croatian_ci DEFAULT NULL,
  `log_os_name` varchar(1000) COLLATE utf8_croatian_ci DEFAULT NULL,
  `log_action` varchar(500) COLLATE utf8_croatian_ci NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `desktop_login_log`
--

LOCK TABLES `desktop_login_log` WRITE;
/*!40000 ALTER TABLE `desktop_login_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `desktop_login_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `desktop_security_key_info`
--

DROP TABLE IF EXISTS `desktop_security_key_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `desktop_security_key_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` varchar(500) COLLATE utf8_croatian_ci NOT NULL,
  `h_id` varchar(500) COLLATE utf8_croatian_ci NOT NULL,
  `OSName` varchar(500) COLLATE utf8_croatian_ci NOT NULL,
  `webIP` varchar(100) COLLATE utf8_croatian_ci NOT NULL,
  `exe_name` varchar(250) COLLATE utf8_croatian_ci NOT NULL,
  `key_year` varchar(20) COLLATE utf8_croatian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `desktop_security_key_info`
--

LOCK TABLES `desktop_security_key_info` WRITE;
/*!40000 ALTER TABLE `desktop_security_key_info` DISABLE KEYS */;
INSERT INTO `desktop_security_key_info` VALUES (1,'BFEBFBFF0001067A','1SHLDJQW0A5315      ','Microsoft Windows 7 Ultimate','2400:adc7:902:a700:6014:2516:c97c:d8ff','ParkTicket.exe','2021');
/*!40000 ALTER TABLE `desktop_security_key_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `desktop_sync_reports`
--

DROP TABLE IF EXISTS `desktop_sync_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `desktop_sync_reports` (
  `dsr_id` int(11) NOT NULL AUTO_INCREMENT,
  `dsr_user_id` int(11) NOT NULL,
  `dsr_day_end_id` int(11) NOT NULL,
  `dsr_day_end_date` date NOT NULL,
  `dsr_report_url` varchar(1000) COLLATE utf8_croatian_ci NOT NULL,
  `dsr_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`dsr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `desktop_sync_reports`
--

LOCK TABLES `desktop_sync_reports` WRITE;
/*!40000 ALTER TABLE `desktop_sync_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `desktop_sync_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financial_advertisement`
--

DROP TABLE IF EXISTS `financial_advertisement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financial_advertisement` (
  `adv_id` int(11) NOT NULL AUTO_INCREMENT,
  `adv_title` varchar(250) NOT NULL,
  `adv_remarks` varchar(500) DEFAULT 'NULL',
  `adv_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `adv_createdby` int(11) DEFAULT NULL,
  `adv_day_end_id` int(11) DEFAULT NULL,
  `adv_day_end_date` date DEFAULT NULL,
  `adv_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `adv_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `adv_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `adv_delete_status` int(11) DEFAULT 0,
  `adv_deleted_by` int(11) DEFAULT NULL,
  `adv_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`adv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financial_advertisement`
--

LOCK TABLES `financial_advertisement` WRITE;
/*!40000 ALTER TABLE `financial_advertisement` DISABLE KEYS */;
/*!40000 ALTER TABLE `financial_advertisement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_account_group`
--

DROP TABLE IF EXISTS `financials_account_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_account_group` (
  `ag_id` int(11) NOT NULL AUTO_INCREMENT,
  `ag_title` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_croatian_ci NOT NULL,
  `ag_remarks` varchar(1000) COLLATE utf8_croatian_ci NOT NULL,
  `ag_day_end_date` date NOT NULL,
  `ag_day_end_id` int(11) NOT NULL,
  `ag_created_by` int(11) NOT NULL,
  `ag_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `ag_ip_adrs` varchar(255) COLLATE utf8_croatian_ci NOT NULL DEFAULT '',
  `ag_brwsr_info` varchar(4000) CHARACTER SET utf8mb4 COLLATE utf8mb4_croatian_ci NOT NULL DEFAULT '',
  `ag_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `ag_delete_status` int(11) DEFAULT 0,
  `ag_deleted_by` int(11) DEFAULT NULL,
  `ag_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`ag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_account_group`
--

LOCK TABLES `financials_account_group` WRITE;
/*!40000 ALTER TABLE `financials_account_group` DISABLE KEYS */;
INSERT INTO `financials_account_group` VALUES (1,'Initial Accounts','System generated (Default/Required) accounts. By default all accounts fall in this group, you can change group of each account according to your need.','0000-00-00',0,0,'2021-10-29 06:56:22','','','2021-10-29 11:56:22',0,NULL,0);
/*!40000 ALTER TABLE `financials_account_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_account_opening_closing_balance`
--

DROP TABLE IF EXISTS `financials_account_opening_closing_balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_account_opening_closing_balance` (
  `aoc_id` int(11) NOT NULL AUTO_INCREMENT,
  `aoc_account_uid` int(11) NOT NULL,
  `aoc_account_name` varchar(500) COLLATE utf8_croatian_ci DEFAULT NULL,
  `aoc_op_type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_croatian_ci NOT NULL DEFAULT '',
  `aoc_op_balance` decimal(50,2) NOT NULL DEFAULT 0.00,
  `aoc_inwards` decimal(50,2) NOT NULL DEFAULT 0.00,
  `aoc_outwards` decimal(50,2) NOT NULL DEFAULT 0.00,
  `aoc_balance` decimal(50,2) NOT NULL,
  `aoc_type` varchar(50) COLLATE utf8_croatian_ci NOT NULL,
  `aoc_closing_type` varchar(10) COLLATE utf8_croatian_ci NOT NULL,
  `aoc_day_end_id` int(11) NOT NULL,
  `aoc_day_end_date` date NOT NULL,
  `aoc_created_date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `aoc_ip_adrs` varchar(255) COLLATE utf8_croatian_ci NOT NULL DEFAULT '',
  `aoc_brwsr_info` varchar(4000) COLLATE utf8_croatian_ci NOT NULL DEFAULT '',
  `aoc_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`aoc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_account_opening_closing_balance`
--

LOCK TABLES `financials_account_opening_closing_balance` WRITE;
/*!40000 ALTER TABLE `financials_account_opening_closing_balance` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_account_opening_closing_balance` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`digitalmunshi`@`localhost`*/ /*!50003 TRIGGER `update_account_closing_balance` AFTER INSERT ON `financials_account_opening_closing_balance` FOR EACH ROW IF (NEW.aoc_closing_type = "DAILY") THEN
			UPDATE financials_accounts SET 
				account_today_opening_type = NEW.aoc_type,
				account_today_opening = NEW.aoc_balance,
				account_today_debit = 0,
				account_today_credit = 0
			WHERE account_uid = NEW.aoc_account_uid;
	ELSEIF (NEW.aoc_closing_type = "MONTHLY") THEN
			UPDATE financials_accounts SET 
				account_monthly_opening_type = NEW.aoc_type,
				account_monthly_opening = NEW.aoc_balance,
				account_monthly_debit = 0,
				account_monthly_credit = 0
			WHERE account_uid = NEW.aoc_account_uid;
	END IF */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `financials_accounts`
--

DROP TABLE IF EXISTS `financials_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_accounts` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_parent_code` int(11) NOT NULL,
  `account_uid` int(11) NOT NULL,
  `account_name` text COLLATE utf8_croatian_ci NOT NULL,
  `account_urdu_name` varchar(1000) COLLATE utf8_croatian_ci DEFAULT NULL,
  `account_print_name` text COLLATE utf8_croatian_ci DEFAULT NULL,
  `account_cnic` varchar(15) COLLATE utf8_croatian_ci DEFAULT NULL,
  `account_address` varchar(300) COLLATE utf8_croatian_ci DEFAULT NULL,
  `account_proprietor` varchar(100) COLLATE utf8_croatian_ci DEFAULT NULL,
  `account_company_code` varchar(100) COLLATE utf8_croatian_ci DEFAULT NULL,
  `account_mobile_no` varchar(50) COLLATE utf8_croatian_ci DEFAULT NULL,
  `account_whatsapp` varchar(50) COLLATE utf8_croatian_ci DEFAULT NULL,
  `account_phone` varchar(50) COLLATE utf8_croatian_ci DEFAULT NULL,
  `account_email` varchar(250) COLLATE utf8_croatian_ci DEFAULT NULL,
  `account_gst` varchar(20) COLLATE utf8_croatian_ci DEFAULT NULL,
  `account_ntn` varchar(10) COLLATE utf8_croatian_ci DEFAULT NULL,
  `account_type` int(11) DEFAULT 0,
  `account_credit_limit` decimal(50,2) NOT NULL DEFAULT 0.00,
  `account_credit_limit_status` tinyint(4) NOT NULL DEFAULT 0,
  `account_discount_type` tinyint(4) DEFAULT 0,
  `account_page_no` varchar(500) COLLATE utf8_croatian_ci DEFAULT NULL,
  `account_today_opening_type` varchar(10) COLLATE utf8_croatian_ci DEFAULT '',
  `account_today_opening` decimal(50,2) DEFAULT 0.00,
  `account_today_debit` decimal(50,2) DEFAULT 0.00,
  `account_today_credit` decimal(50,2) DEFAULT 0.00,
  `account_monthly_opening_type` varchar(10) COLLATE utf8_croatian_ci DEFAULT '',
  `account_monthly_opening` decimal(50,2) DEFAULT 0.00,
  `account_monthly_debit` decimal(50,2) DEFAULT 0.00,
  `account_monthly_credit` decimal(50,2) DEFAULT 0.00,
  `account_balance` decimal(50,2) DEFAULT 0.00,
  `account_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `account_region_id` int(11) DEFAULT 0,
  `account_area` int(11) DEFAULT 0,
  `account_sector_id` int(11) DEFAULT 0,
  `account_town_id` int(11) DEFAULT 0,
  `account_department_id` int(11) DEFAULT NULL,
  `account_createdby` int(11) DEFAULT NULL,
  `account_day_end_id` int(11) DEFAULT NULL,
  `account_day_end_date` date DEFAULT NULL,
  `account_remarks` varchar(500) COLLATE utf8_croatian_ci DEFAULT '',
  `account_group_id` int(11) DEFAULT 1,
  `account_employee_id` int(11) DEFAULT 0,
  `account_link_uid` int(11) DEFAULT 0,
  `account_sale_person` int(11) DEFAULT 0,
  `account_ip_adrs` varchar(255) COLLATE utf8_croatian_ci DEFAULT '',
  `account_brwsr_info` varchar(4000) COLLATE utf8_croatian_ci DEFAULT '',
  `account_update_datetime` datetime DEFAULT current_timestamp(),
  `account_delete_status` int(11) DEFAULT 0,
  `account_deleted_by` int(11) DEFAULT NULL,
  `account_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `account_uid` (`account_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_accounts`
--

LOCK TABLES `financials_accounts` WRITE;
/*!40000 ALTER TABLE `financials_accounts` DISABLE KEYS */;
INSERT INTO `financials_accounts` VALUES (1,11010,110101,'Cash',NULL,'Cash',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'DR',15230.00,92162.00,152.00,'',0.00,92162.00,152.00,92010.00,'2021-10-29 06:56:32',0,0,0,0,NULL,0,NULL,NULL,'System main cash account',1,0,0,0,'','','2021-10-29 11:56:32',0,NULL,0),(2,11011,110111,'Stock',NULL,'Stock',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'DR',51361098.00,52319476.00,2092421.20,'',0.00,52319476.00,2092421.20,50227054.80,'2021-10-29 06:56:32',0,0,0,0,NULL,0,NULL,NULL,'Stock amount calculated from products purchase price multiply to quantity.',1,0,0,0,'','','2021-10-29 11:56:32',0,NULL,0),(3,11015,110151,'Input Tax',NULL,'Input Tax',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:32',0,0,0,0,NULL,0,NULL,NULL,'Sales tax at the time of purchase invoice.',1,0,0,0,'','','2021-10-29 11:56:32',0,NULL,0),(4,11016,110161,'Walk In Customer',NULL,'Walk In Customer',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,1732460.00,60120.00,'',0.00,1732460.00,60120.00,1672340.00,'2021-10-29 06:56:32',0,0,0,0,NULL,0,NULL,NULL,'Walk in Customer account used at the time of counter sale.',1,0,0,0,'','','2021-10-29 11:56:32',0,NULL,0),(5,11210,112101,'Suspense',NULL,'Suspense',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:33',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:33',0,NULL,0),(6,21011,210111,'FBR Output Tax(Tax Payable)',NULL,'FBR Output Tax(Tax Payable)',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:33',0,0,0,0,NULL,0,NULL,NULL,'Sales tax at the time of sale invoice.',1,0,0,0,'','','2021-10-29 11:56:33',0,NULL,0),(7,21011,210112,'Province Output Tax(Tax Payable)',NULL,'Province Output Tax(Tax Payable)',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:33',0,0,0,0,NULL,0,NULL,NULL,'Service tax at the time of service invoice.',1,0,0,0,'','','2021-10-29 11:56:33',0,NULL,0),(8,21110,211101,'Suspense',NULL,'Suspense',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:33',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:33',0,NULL,0),(9,21012,210121,'Purchaser',NULL,'Purchaser',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:33',0,0,0,0,NULL,0,NULL,NULL,'Default purchaser account used at the time of purchase invoice.',1,0,0,0,'','','2021-10-29 11:56:33',0,NULL,0),(10,31010,310101,'Sales',NULL,'Sales',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,1736240.00,'',0.00,0.00,1736240.00,-1736240.00,'2021-10-29 06:56:33',0,0,0,0,NULL,0,NULL,NULL,'Sales account used at the time of sale invoice.',1,0,0,0,'','','2021-10-29 11:56:33',0,NULL,0),(11,31010,310102,'Sales Return',NULL,'Sales Return',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:33',0,0,0,0,NULL,0,NULL,NULL,'Sales account used at the time of sale return invoice.',1,0,0,0,'','','2021-10-29 11:56:33',0,NULL,0),(12,31110,311101,'Services',NULL,'Services',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:34',0,0,0,0,NULL,0,NULL,NULL,'Service account used at the time of service invoice.',1,0,0,0,'','','2021-10-29 11:56:34',0,NULL,0),(13,31111,311111,'Sale Margin',NULL,'Sale Margin',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:34',0,0,0,0,NULL,0,NULL,NULL,'Sale margin account used at the time of non tax sale invoice.',1,0,0,0,'','','2021-10-29 11:56:34',0,NULL,0),(14,41010,410101,'Product Loss & Recover',NULL,'Product Loss & Recover',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,214454.00,308108.00,'',0.00,214454.00,308108.00,-93654.00,'2021-10-29 06:56:34',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:34',0,NULL,0),(15,41011,410111,'Bonus Allocation-Deallocation',NULL,'Bonus Allocation-Deallocation',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,50.00,0.00,'',0.00,50.00,0.00,50.00,'2021-10-29 06:56:34',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:34',0,NULL,0),(16,41110,411101,'Purchase',NULL,'Purchase',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,486670.00,0.00,'',0.00,486670.00,0.00,486670.00,'2021-10-29 06:56:34',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:34',0,NULL,0),(17,41110,411102,'Purchase Return',NULL,'Purchase Return',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,72672.00,'',0.00,0.00,72672.00,-72672.00,'2021-10-29 06:56:34',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:34',0,NULL,0),(18,41112,411121,'Claim Issue',NULL,'Claim Issue',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,163600.00,'',0.00,0.00,163600.00,-163600.00,'2021-10-29 06:56:34',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:34',0,NULL,0),(19,41112,411122,'Claim Received',NULL,'Claim Received',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,163600.00,0.00,'',0.00,163600.00,0.00,163600.00,'2021-10-29 06:56:34',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:34',0,NULL,0),(20,41411,414111,'Round off Discount',NULL,'Round off Discount',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:34',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:34',0,NULL,0),(21,41511,415111,'Product Discount',NULL,'Product Discount',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:34',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:34',0,NULL,0),(22,41511,415112,'Retailer Discount',NULL,'Retailer Discount',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:34',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:34',0,NULL,0),(23,41511,415113,'Whole Seller Discount',NULL,'Whole Seller Discount',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:35',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:35',0,NULL,0),(24,41511,415114,'Loyality Card Discount',NULL,'Loyality Card Discount',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:36',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:36',0,NULL,0),(25,41510,415101,'Cash Discount',NULL,'Cash Discount',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:36',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:36',0,NULL,0),(26,41510,415102,'Service Discount',NULL,'Service Discount',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:36',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:36',0,NULL,0),(27,51210,512101,'Undistributed Profit & Loss',NULL,'Undistributed Profit & Loss',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:37',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:37',0,NULL,0),(28,11013,110131,'Client One',NULL,'Client One',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,1381.00,64509.00,'',0.00,1381.00,64509.00,-63128.00,'2021-10-29 06:56:37',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:37',0,NULL,0),(29,21010,210101,'Supplier One',NULL,'Supplier One',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'CR',0.00,72000.00,472000.00,'',0.00,72000.00,472000.00,-400000.00,'2021-10-29 06:56:37',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:37',0,NULL,0),(30,11012,110121,'Meezan',NULL,'Meezan',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,65740.00,6823.00,'',0.00,65740.00,6823.00,58917.00,'2021-10-29 06:56:37',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:37',0,NULL,0),(31,41113,411131,'Product Recover & Loss',NULL,'Product Recover & Loss',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,308208.00,214454.00,'',0.00,308208.00,214454.00,93754.00,'2021-10-29 06:56:37',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:37',0,NULL,0),(32,41511,415115,'Trade Offer Account',NULL,'Trade Offer Account',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:38',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:38',0,NULL,0),(33,41012,410121,'Product Stock Consumed',NULL,'Product Stock Consumed',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,2.00,0.00,'',0.00,2.00,0.00,2.00,'2021-10-29 06:56:38',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:38',0,NULL,0),(34,41113,411132,'Product Stock Produced',NULL,'Product Stock Produced',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:38',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:38',0,NULL,0),(35,41113,411133,'Production Stock Adjustment',NULL,'Production Stock Adjustment',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:38',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:38',0,NULL,0),(36,11017,110171,'Client One Claims',NULL,'Client One Claims',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,160000.00,163600.00,'',0.00,160000.00,163600.00,-3600.00,'2021-10-29 06:56:38',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:38',0,NULL,0),(37,11017,110172,'Supplier One Claims',NULL,'Supplier One Claims',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,3600.00,0.00,'',0.00,3600.00,0.00,3600.00,'2021-10-29 06:56:38',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:38',0,NULL,0),(38,41310,413101,'Meezan Credit Card Service Charges',NULL,'Meezan Credit Card Service Charges',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:38',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:38',0,NULL,0),(39,11018,110181,'Meezan Credit Card Machine',NULL,'Meezan Credit Card Machine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 06:56:38',0,0,0,0,NULL,0,NULL,NULL,'',1,0,0,0,'','','2021-10-29 11:56:38',0,NULL,0),(40,41412,414121,'Exp - Ahmad Hasan',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 08:05:46',0,0,0,0,2,1,0,'2021-10-29','',1,2,110141,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:05:46',0,NULL,0),(41,11014,110141,'Adv - Ahmad Hasan',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 08:05:46',0,0,0,0,2,1,0,'2021-10-29','',1,2,414121,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:05:46',0,NULL,0),(42,11010,110102,'Independant - SALEMAN - CASH',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,50.00,252.00,'',0.00,50.00,252.00,-202.00,'2021-10-29 08:07:26',0,0,0,0,3,1,0,'2021-10-29','',1,3,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:07:26',0,NULL,0),(43,11013,110132,'ABD 436','','',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0.00,0,1,NULL,'DR',63000.00,67493.00,264.00,'',0.00,67493.00,264.00,67229.00,'2021-10-29 08:24:39',1,1,1,1,NULL,1,0,'2021-10-29','',1,0,0,3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:43:30',0,NULL,0),(44,21010,210102,'Xyz 889','','',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0.00,1,1,NULL,'CR',900000.00,0.00,900000.00,'',0.00,0.00,900000.00,-900000.00,'2021-10-29 08:27:23',1,1,1,1,NULL,1,0,'2021-10-29','',1,0,0,4,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-29 15:41:47',0,NULL,0),(45,11110,111101,'Air Conditioner Gree 1.5 Ton Invertor','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 08:28:53',0,0,0,0,NULL,1,0,'2021-10-29','',1,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:28:53',0,NULL,0),(46,11110,111102,'Acc. Dep. Air Conditioner Gree 1.5 Ton Invertor','Acc. Dep. ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 08:28:53',0,0,0,0,NULL,1,0,'2021-10-29','',1,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:28:53',0,NULL,0),(47,41410,414101,'Dep. Air Conditioner Gree 1.5 Ton Invertor','Dep. ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 08:28:53',0,0,0,0,NULL,1,0,'2021-10-29','',1,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:28:53',0,NULL,0),(48,51010,510101,'Capital - Ahmad Hasan','Capital - ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'CR',50000000.00,0.00,50000000.00,'',0.00,0.00,50000000.00,-50000000.00,'2021-10-29 08:30:41',0,0,0,0,NULL,1,0,'2021-10-29','',1,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:30:41',0,NULL,0),(49,51010,510102,'Profit & Loss - Ahmad Hasan','Profit & Loss - ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'CR',600000.00,0.00,600000.00,'',0.00,0.00,600000.00,-600000.00,'2021-10-29 08:30:41',0,0,0,0,NULL,1,0,'2021-10-29','',1,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:30:41',0,NULL,0),(50,51010,510103,'Drawing - Ahmad Hasan','Drawing - ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'DR',60672.00,60672.00,0.00,'',0.00,60672.00,0.00,60672.00,'2021-10-29 08:30:41',0,0,0,0,NULL,1,0,'2021-10-29','',1,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:30:41',0,NULL,0),(51,51010,510104,'Reserve - Ahmad Hasan','Reserve - ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-29 08:30:42',0,0,0,0,NULL,1,0,'2021-10-29','',1,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:30:42',0,NULL,0),(52,11010,110103,'Shoaib - SALEMAN - CASH',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,26846.00,'',0.00,0.00,26846.00,-26846.00,'2021-10-29 10:40:55',0,0,0,0,3,1,1,'2021-09-29','',1,4,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-29 15:40:55',0,NULL,0),(53,51011,510111,'Capital - Shoaib','Capital - ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-30 06:41:59',0,0,0,0,NULL,1,1,'2021-09-29','',1,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 11:41:59',0,NULL,0),(54,51011,510112,'Profit & Loss - Shoaib','Profit & Loss - ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-30 06:41:59',0,0,0,0,NULL,1,1,'2021-09-29','',1,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 11:41:59',0,NULL,0),(55,51011,510113,'Drawing - Shoaib','Drawing - ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-30 06:41:59',0,0,0,0,NULL,1,1,'2021-09-29','',1,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 11:41:59',0,NULL,0),(56,51011,510114,'Reserve - Shoaib','Reserve - ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-10-30 06:41:59',0,0,0,0,NULL,1,1,'2021-09-29','',1,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 11:41:59',0,NULL,0),(57,41310,413102,'Fsdfsaf Service Charges',' Service Charges',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-11-10 11:42:03',0,0,0,0,NULL,1,1,'2021-09-29','',1,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 16:42:03',0,NULL,0),(58,11018,110182,'Fsdfsaf Credit Card Machine',' Credit Card Machine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0.00,0,0,NULL,'',0.00,0.00,0.00,'',0.00,0.00,0.00,0.00,'2021-11-10 11:42:03',0,0,0,0,NULL,1,1,'2021-09-29','',1,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 16:42:03',0,NULL,0);
/*!40000 ALTER TABLE `financials_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_advance_salary`
--

DROP TABLE IF EXISTS `financials_advance_salary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_advance_salary` (
  `as_id` int(11) NOT NULL AUTO_INCREMENT,
  `as_emp_advance_salary_account` int(11) NOT NULL,
  `as_from_pay_account` int(11) NOT NULL,
  `as_amount` decimal(50,2) NOT NULL,
  `as_remarks` varchar(1000) DEFAULT NULL,
  `as_detail_remarks` text CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `as_month` varchar(255) DEFAULT NULL,
  `as_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `as_created_by` int(11) NOT NULL,
  `as_day_end_id` int(11) NOT NULL,
  `as_day_end_date` date NOT NULL,
  `as_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `as_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `as_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`as_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_advance_salary`
--

LOCK TABLES `financials_advance_salary` WRITE;
/*!40000 ALTER TABLE `financials_advance_salary` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_advance_salary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_advance_salary_items`
--

DROP TABLE IF EXISTS `financials_advance_salary_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_advance_salary_items` (
  `asi_id` int(11) NOT NULL AUTO_INCREMENT,
  `asi_as_id` int(11) DEFAULT NULL,
  `asi_department_id` int(11) DEFAULT NULL,
  `asi_department_name` varchar(255) DEFAULT NULL,
  `asi_emp_advance_salary_account` int(11) DEFAULT NULL,
  `asi_emp_advance_salary_account_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `asi_amount` decimal(50,2) DEFAULT NULL,
  `asi_remarks` varchar(4000) DEFAULT NULL,
  `asi_month_year` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`asi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_advance_salary_items`
--

LOCK TABLES `financials_advance_salary_items` WRITE;
/*!40000 ALTER TABLE `financials_advance_salary_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_advance_salary_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_approval_journal_voucher`
--

DROP TABLE IF EXISTS `financials_approval_journal_voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_approval_journal_voucher` (
  `ajv_id` int(11) NOT NULL AUTO_INCREMENT,
  `ajv_session` varchar(450) DEFAULT NULL,
  `ajv_project_id` int(11) DEFAULT NULL,
  `ajv_order_list_id` int(11) DEFAULT NULL,
  `ajv_business_name` varchar(450) DEFAULT NULL,
  `ajv_total_dr` double NOT NULL,
  `ajv_total_cr` double NOT NULL,
  `ajv_created_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `ajv_remarks` varchar(450) DEFAULT NULL,
  `ajv_day_end_id` int(11) DEFAULT NULL,
  `ajv_day_end_date` date DEFAULT NULL,
  `ajv_createdby` int(11) DEFAULT NULL,
  `ajv_detail_remarks` varchar(1000) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `ajv_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `ajv_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `ajv_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `ajv_status` varchar(225) DEFAULT '',
  `ajv_voucher_type` varchar(50) DEFAULT NULL,
  `ajv_consume_amount` decimal(50,2) DEFAULT NULL,
  PRIMARY KEY (`ajv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_approval_journal_voucher`
--

LOCK TABLES `financials_approval_journal_voucher` WRITE;
/*!40000 ALTER TABLE `financials_approval_journal_voucher` DISABLE KEYS */;
INSERT INTO `financials_approval_journal_voucher` VALUES (1,NULL,NULL,NULL,NULL,1000,1000,'2021-11-03 12:15:06','',1,'2021-09-29',1,'\n                                                                Cash\n                                                            , Dr@1,000.00&oS;\n                                                                Shoaib - SALEMAN - CASH\n                                                            , Cr@1,000.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 17:15:06','Confirmed','simple_show',0.00),(2,NULL,NULL,NULL,NULL,500,500,'2021-11-03 12:16:53','',1,'2021-09-29',1,'\n                                                                Meezan\n                                                            , Dr@500.00&oS;\n                                                                Shoaib - SALEMAN - CASH\n                                                            , Cr@500.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 17:16:53','Confirmed','simple_show',0.00),(3,NULL,NULL,NULL,NULL,1,1,'2021-11-04 12:25:20','',1,'2021-09-29',1,'\n                                                                Client One\n                                                            , Cr@1.00&oS;\n                                                                ABD 436\n                                                            , Dr@1.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:25:20','Confirmed','simple_show',0.00);
/*!40000 ALTER TABLE `financials_approval_journal_voucher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_approval_journal_voucher_items`
--

DROP TABLE IF EXISTS `financials_approval_journal_voucher_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_approval_journal_voucher_items` (
  `ajvi_id` int(11) NOT NULL AUTO_INCREMENT,
  `ajvi_journal_voucher_id` int(11) NOT NULL,
  `ajvi_account_id` int(11) NOT NULL,
  `ajvi_account_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `ajvi_pr_id` int(11) DEFAULT NULL,
  `ajvi_amount` double NOT NULL,
  `ajvi_type` varchar(50) NOT NULL,
  `ajvi_remarks` varchar(500) DEFAULT NULL,
  `ajvi_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `ajvi_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `ajvi_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ajvi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_approval_journal_voucher_items`
--

LOCK TABLES `financials_approval_journal_voucher_items` WRITE;
/*!40000 ALTER TABLE `financials_approval_journal_voucher_items` DISABLE KEYS */;
INSERT INTO `financials_approval_journal_voucher_items` VALUES (1,1,110101,'\n                                                                Cash\n                                                            ',1,1000,'Dr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 17:15:06'),(2,1,110103,'\n                                                                Shoaib - SALEMAN - CASH\n                                                            ',1,1000,'Cr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 17:15:06'),(3,2,110121,'\n                                                                Meezan\n                                                            ',1,500,'Dr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 17:16:53'),(4,2,110103,'\n                                                                Shoaib - SALEMAN - CASH\n                                                            ',1,500,'Cr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 17:16:53'),(5,3,110131,'\n                                                                Client One\n                                                            ',3,1,'Cr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:25:20'),(6,3,110132,'\n                                                                ABD 436\n                                                            ',2,1,'Dr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:25:20');
/*!40000 ALTER TABLE `financials_approval_journal_voucher_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_areas`
--

DROP TABLE IF EXISTS `financials_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_areas` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_title` varchar(250) NOT NULL,
  `area_remarks` varchar(500) DEFAULT NULL,
  `area_reg_id` int(11) NOT NULL,
  `area_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `area_createdby` int(11) DEFAULT NULL,
  `area_day_end_id` int(11) DEFAULT NULL,
  `area_day_end_date` date DEFAULT NULL,
  `area_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `area_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `area_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `area_delete_status` int(11) DEFAULT 0,
  `area_deleted_by` int(11) DEFAULT NULL,
  `area_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_areas`
--

LOCK TABLES `financials_areas` WRITE;
/*!40000 ALTER TABLE `financials_areas` DISABLE KEYS */;
INSERT INTO `financials_areas` VALUES (1,'Initial Area','',1,'2021-10-29 08:22:29',1,0,'2021-10-29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:22:29',0,NULL,0);
/*!40000 ALTER TABLE `financials_areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_audit_inventory`
--

DROP TABLE IF EXISTS `financials_audit_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_audit_inventory` (
  `new_id` int(11) NOT NULL AUTO_INCREMENT,
  `new_pro_code` varchar(500) NOT NULL,
  `new_pro_name` varchar(1000) DEFAULT 'NULL',
  `new_stock` int(11) NOT NULL,
  `new_date_time` timestamp NULL DEFAULT current_timestamp(),
  `new_ip_adrs` varchar(255) NOT NULL DEFAULT '''''',
  `new_brwsr_info` varchar(4000) NOT NULL DEFAULT '''''',
  `new_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `new_user_id` int(11) DEFAULT NULL,
  `new_user_name` varchar(1000) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `new_warehouse_name` varchar(1000) DEFAULT NULL,
  `new_day_end_id` int(11) DEFAULT NULL,
  `new_day_end_date` datetime DEFAULT NULL,
  `new_curr_qty_warehouse` int(11) DEFAULT NULL,
  `new_total_inventory` int(11) DEFAULT NULL,
  `new_batch_id` int(11) NOT NULL DEFAULT 0,
  `new_insert_type` int(11) NOT NULL,
  `new_audit_id` int(11) NOT NULL DEFAULT 0,
  `new_audit_name` varchar(1000) NOT NULL,
  PRIMARY KEY (`new_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_audit_inventory`
--

LOCK TABLES `financials_audit_inventory` WRITE;
/*!40000 ALTER TABLE `financials_audit_inventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_audit_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_author`
--

DROP TABLE IF EXISTS `financials_author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_author` (
  `aut_id` int(11) NOT NULL AUTO_INCREMENT,
  `aut_title` varchar(250) NOT NULL,
  `aut_remarks` varchar(500) DEFAULT 'NULL',
  `aut_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `aut_createdby` int(11) DEFAULT NULL,
  `aut_day_end_id` int(11) DEFAULT NULL,
  `aut_day_end_date` date DEFAULT NULL,
  `aut_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `aut_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `aut_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `aut_delete_status` int(11) DEFAULT 0,
  `aut_deleted_by` int(11) DEFAULT NULL,
  `aut_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`aut_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_author`
--

LOCK TABLES `financials_author` WRITE;
/*!40000 ALTER TABLE `financials_author` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_balance_sheet`
--

DROP TABLE IF EXISTS `financials_balance_sheet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_balance_sheet` (
  `bs_id` int(11) NOT NULL AUTO_INCREMENT,
  `bs_closing_type` varchar(50) NOT NULL,
  `bs_parent_uid` int(11) NOT NULL,
  `bs_account_uid` int(11) NOT NULL,
  `bs_account_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `bs_level` tinyint(4) NOT NULL,
  `bs_type` varchar(10) NOT NULL,
  `bs_amount` decimal(50,2) NOT NULL,
  `bs_day_end_id` int(11) NOT NULL,
  `bs_day_end_date` date NOT NULL,
  `bs_current_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `bs_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `bs_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `bs_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`bs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_balance_sheet`
--

LOCK TABLES `financials_balance_sheet` WRITE;
/*!40000 ALTER TABLE `financials_balance_sheet` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_balance_sheet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_balances`
--

DROP TABLE IF EXISTS `financials_balances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_balances` (
  `bal_id` int(11) NOT NULL AUTO_INCREMENT,
  `bal_account_id` int(11) NOT NULL,
  `bal_transaction_type` varchar(250) NOT NULL,
  `bal_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT '',
  `bal_dr` decimal(50,2) NOT NULL,
  `bal_cr` decimal(50,2) NOT NULL,
  `bal_total` decimal(50,2) NOT NULL,
  `bal_transaction_id` int(11) NOT NULL,
  `bal_pr_id` int(11) DEFAULT NULL,
  `bal_datetime` timestamp NULL DEFAULT current_timestamp(),
  `bal_user_id` int(11) DEFAULT 0,
  `bal_day_end_id` int(11) DEFAULT NULL,
  `bal_day_end_date` date DEFAULT NULL,
  `bal_detail_remarks` text CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT '',
  `bal_voucher_number` varchar(500) DEFAULT '',
  `bal_ip_adrs` varchar(255) DEFAULT '',
  `bal_brwsr_info` varchar(4000) DEFAULT '',
  `bal_update_datetime` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`bal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_balances`
--

LOCK TABLES `financials_balances` WRITE;
/*!40000 ALTER TABLE `financials_balances` DISABLE KEYS */;
INSERT INTO `financials_balances` VALUES (1,414121,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:05:46',1,0,'2021-10-29','OPENING_BALANCE','','','','2021-10-29 13:05:46'),(8,414101,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:28:53',1,0,'2021-10-29','OPENING_BALANCE','','','','2021-10-29 13:28:53'),(13,110101,'OPENING_BALANCE','OPENING_BALANCE',15230.00,0.00,15230.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(14,110102,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(15,110111,'OPENING_BALANCE','OPENING_BALANCE',51361098.00,0.00,51361098.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(16,110121,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(17,110131,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(18,110132,'OPENING_BALANCE','OPENING_BALANCE',63000.00,0.00,63000.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(19,110141,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(20,110151,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(21,110161,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(22,110171,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(23,110172,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(24,110181,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(25,111101,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(26,111102,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(27,112101,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(28,210101,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(29,210102,'OPENING_BALANCE','OPENING_BALANCE',0.00,900000.00,-900000.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(30,210111,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(31,210112,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(32,210121,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(33,211101,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(34,510101,'OPENING_BALANCE','OPENING_BALANCE',0.00,50000000.00,-50000000.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(35,510102,'OPENING_BALANCE','OPENING_BALANCE',0.00,600000.00,-600000.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(36,510103,'OPENING_BALANCE','OPENING_BALANCE',60672.00,0.00,60672.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(37,510104,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(38,512101,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 08:34:14',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(39,110103,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-29 10:40:55',1,1,'2021-09-29','OPENING_BALANCE','','','','2021-10-29 15:40:55'),(40,510111,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-30 06:41:59',1,1,'2021-09-29','OPENING_BALANCE','','','','2021-10-30 11:41:59'),(41,510112,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-30 06:41:59',1,1,'2021-09-29','OPENING_BALANCE','','','','2021-10-30 11:41:59'),(42,510113,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-30 06:41:59',1,1,'2021-09-29','OPENING_BALANCE','','','','2021-10-30 11:41:59'),(43,510114,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,1,'2021-10-30 06:41:59',1,1,'2021-09-29','OPENING_BALANCE','','','','2021-10-30 11:41:59'),(44,110101,'BANK_PAYMENT_VOUCHER','',120.00,0.00,15350.00,1,1,'2021-11-03 09:42:23',1,1,'2021-09-29','Meezan to \n                                                                Cash\n                                                            , @120.00&oS;','BPV-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:42:23'),(45,110121,'BANK_PAYMENT_VOUCHER','',0.00,120.00,-120.00,1,1,'2021-11-03 09:42:23',1,1,'2021-09-29','Meezan to \n                                                                Cash\n                                                            , @120.00&oS;','BPV-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:42:23'),(46,110131,'POST_DATED_CHEQUE_ISSUED','',120.00,0.00,120.00,2,1,'2021-11-03 09:43:53',1,1,'2021-09-29','Cheque of Dated: 11-11-2021 , Amount: 120 , ','PDCI-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:43:53'),(47,110121,'POST_DATED_CHEQUE_ISSUED','',0.00,120.00,-240.00,2,1,'2021-11-03 09:43:53',1,1,'2021-09-29','Cheque of Dated: 11-11-2021 , Amount: 120 , ','PDCI-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:43:53'),(48,110121,'JOURNAL_VOUCHER','',130.00,0.00,-110.00,3,1,'2021-11-03 09:44:51',1,1,'2021-09-29','\n                                                                Meezan\n                                                            , Dr@130.00&oS;\n                                                                Meezan\n                                                            , Cr@130.00&oS;','JV-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:44:51'),(49,110121,'JOURNAL_VOUCHER','',0.00,130.00,-240.00,4,1,'2021-11-03 09:44:51',1,1,'2021-09-29','\n                                                                Meezan\n                                                            , Dr@130.00&oS;\n                                                                Meezan\n                                                            , Cr@130.00&oS;','JV-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:44:51'),(50,110101,'JOURNAL_VOUCHER','',100.00,0.00,15450.00,5,1,'2021-11-03 09:45:29',1,1,'2021-09-29','\n                                                                Cash\n                                                            , Dr@100.00&oS;\n                                                                Independant - SALEMAN - CASH\n                                                            , Cr@100.00&oS;','JV-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:45:29'),(51,110102,'JOURNAL_VOUCHER','',0.00,100.00,-100.00,6,1,'2021-11-03 09:45:29',1,1,'2021-09-29','\n                                                                Cash\n                                                            , Dr@100.00&oS;\n                                                                Independant - SALEMAN - CASH\n                                                            , Cr@100.00&oS;','JV-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:45:29'),(52,110103,'CASH_RECEIPT_VOUCHER','Dfasdf asdfsd',0.00,3000.00,-3000.00,7,1,'2021-11-03 09:50:48',1,1,'2021-09-29','Cash to Shoaib - SALEMAN - CASH, @3,000.00&oS;','CRV-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:50:48'),(53,110101,'CASH_RECEIPT_VOUCHER','Dfasdf asdfsd',3000.00,0.00,18450.00,7,1,'2021-11-03 09:50:48',1,1,'2021-09-29','Cash to Shoaib - SALEMAN - CASH, @3,000.00&oS;','CRV-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:50:48'),(54,110103,'CASH_RECEIPT_VOUCHER','Dfasdf asdfsd',0.00,12222.00,-15222.00,8,1,'2021-11-03 09:50:48',1,1,'2021-09-29','Cash to Shoaib - SALEMAN - CASH, @12,222.00&oS;','CRV-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:50:48'),(55,110101,'CASH_RECEIPT_VOUCHER','Dfasdf asdfsd',12222.00,0.00,30672.00,8,1,'2021-11-03 09:50:48',1,1,'2021-09-29','Cash to Shoaib - SALEMAN - CASH, @12,222.00&oS;','CRV-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:50:48'),(56,110121,'CASH_PAYMENT_VOUCHER','Asdfdsaf',10000.00,0.00,9760.00,9,1,'2021-11-03 09:51:22',1,1,'2021-09-29','Shoaib - SALEMAN - CASH to \n                                                                Meezan\n                                                            , @10,000.00&oS;','CPV-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:51:22'),(57,110103,'CASH_PAYMENT_VOUCHER','Asdfdsaf',0.00,10000.00,-25222.00,9,1,'2021-11-03 09:51:22',1,1,'2021-09-29','Shoaib - SALEMAN - CASH to \n                                                                Meezan\n                                                            , @10,000.00&oS;','CPV-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:51:22'),(58,110131,'BANK_RECEIPT_VOUCHER','Sdafasdf',0.00,50000.00,-49880.00,10,1,'2021-11-03 09:51:55',1,1,'2021-09-29','Meezan to \n                                                                Client One\n                                                            , @50,000.00&oS;','BRV-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:51:55'),(59,110121,'BANK_RECEIPT_VOUCHER','Sdafasdf',50000.00,0.00,59760.00,10,1,'2021-11-03 09:51:55',1,1,'2021-09-29','Meezan to \n                                                                Client One\n                                                            , @50,000.00&oS;','BRV-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:51:55'),(60,110121,'BANK_PAYMENT_VOUCHER','Asdfdsa f',5000.00,0.00,64760.00,11,1,'2021-11-03 09:52:15',1,1,'2021-09-29','Meezan to \n                                                                Meezan\n                                                            , @5,000.00&oS;','BPV-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:52:15'),(61,110121,'BANK_PAYMENT_VOUCHER','Asdfdsa f',0.00,5000.00,59760.00,11,1,'2021-11-03 09:52:15',1,1,'2021-09-29','Meezan to \n                                                                Meezan\n                                                            , @5,000.00&oS;','BPV-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:52:15'),(62,110111,'PURCHASE_INVOICE','',108.00,0.00,51361206.00,12,1,'2021-11-03 10:00:53',1,1,'2021-09-29','Lays Rs. 5, 1@54.00 = 54.00&oS;Lays Rs. 5, 1@54.00 = 54.00&oS;','PI-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 15:00:53'),(63,411101,'PURCHASE_INVOICE','',108.00,0.00,108.00,13,1,'2021-11-03 10:00:53',1,1,'2021-09-29','Lays Rs. 5, 1@54.00 = 54.00&oS;Lays Rs. 5, 1@54.00 = 54.00&oS;','PI-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 15:00:53'),(64,110132,'PURCHASE_INVOICE','',0.00,108.00,62892.00,14,1,'2021-11-03 10:00:53',1,1,'2021-09-29','Lays Rs. 5, 1@54.00 = 54.00&oS;Lays Rs. 5, 1@54.00 = 54.00&oS;','PI-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 15:00:53'),(65,110101,'JOURNAL_VOUCHER','',120.00,0.00,30792.00,15,1,'2021-11-03 11:02:17',1,1,'2021-09-29','\n                                                                Cash\n                                                            , Dr@120.00&oS;\n                                                                Shoaib - SALEMAN - CASH\n                                                            , Cr@120.00&oS;','JV-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:02:17'),(66,110103,'JOURNAL_VOUCHER','',0.00,120.00,-25342.00,16,1,'2021-11-03 11:02:17',1,1,'2021-09-29','\n                                                                Cash\n                                                            , Dr@120.00&oS;\n                                                                Shoaib - SALEMAN - CASH\n                                                            , Cr@120.00&oS;','JV-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:02:17'),(67,110132,'JOURNAL_VOUCHER_REFERENCE','',100.00,0.00,62992.00,17,1,'2021-11-03 11:36:37',1,1,'2021-09-29','\n                                                                ABD 436\n                                                            , Dr@100.00&oS;\n                                                                ABD 436\n                                                            , Cr@100.00&oS;','JVR-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:36:37'),(68,110132,'JOURNAL_VOUCHER_REFERENCE','',0.00,100.00,62892.00,18,1,'2021-11-03 11:36:37',1,1,'2021-09-29','\n                                                                ABD 436\n                                                            , Dr@100.00&oS;\n                                                                ABD 436\n                                                            , Cr@100.00&oS;','JVR-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:36:37'),(69,411131,'EXPENSE_PAYMENT_VOUCHER','',100.00,0.00,100.00,19,1,'2021-11-03 11:57:36',1,1,'2021-09-29','Meezan to \n                                                                Product Recover & Loss\n                                                            , @100.00&oS;','EPV-6','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:57:36'),(70,110121,'EXPENSE_PAYMENT_VOUCHER','',0.00,100.00,59660.00,19,1,'2021-11-03 11:57:36',1,1,'2021-09-29','Meezan to \n                                                                Product Recover & Loss\n                                                            , @100.00&oS;','EPV-6','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:57:36'),(71,410111,'EXPENSE_PAYMENT_VOUCHER','',50.00,0.00,50.00,20,1,'2021-11-03 11:57:36',1,1,'2021-09-29','Meezan to \n                                                                Bonus Allocation-Deallocation\n                                                            , @50.00&oS;','EPV-6','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:57:36'),(72,110121,'EXPENSE_PAYMENT_VOUCHER','',0.00,50.00,59610.00,20,1,'2021-11-03 11:57:36',1,1,'2021-09-29','Meezan to \n                                                                Bonus Allocation-Deallocation\n                                                            , @50.00&oS;','EPV-6','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:57:36'),(77,110111,'SALE_INVOICE','',0.00,54.00,51361152.00,26,1,'2021-11-03 13:11:06',1,1,'2021-09-29','Lays Rs. 5, 1@60.00 = 60.00&oS;','SI-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:11:06'),(78,310101,'SALE_INVOICE','',0.00,60.00,-60.00,27,1,'2021-11-03 13:11:06',1,1,'2021-09-29','Lays Rs. 5, 1@60.00 = 60.00&oS;','SI-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:11:06'),(79,110131,'SALE_INVOICE','',60.00,0.00,-49820.00,28,1,'2021-11-03 13:11:06',1,1,'2021-09-29','Lays Rs. 5, 1@60.00 = 60.00&oS;','SI-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:11:06'),(80,110102,'CASH_RECEIPT_VOUCHER','',0.00,150.00,-250.00,29,1,'2021-11-03 13:14:15',1,1,'2021-09-29','Cash to Independant - SALEMAN - CASH, @150.00&oS;','CRV-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:14:15'),(81,110101,'CASH_RECEIPT_VOUCHER','',150.00,0.00,30942.00,29,1,'2021-11-03 13:14:15',1,1,'2021-09-29','Cash to Independant - SALEMAN - CASH, @150.00&oS;','CRV-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:14:15'),(82,110102,'CASH_PAYMENT_VOUCHER','',50.00,0.00,-200.00,30,1,'2021-11-03 13:14:34',1,1,'2021-09-29','Cash to \n                                                                Independant - SALEMAN - CASH\n                                                            , @50.00&oS;','CPV-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:14:34'),(83,110101,'CASH_PAYMENT_VOUCHER','',0.00,50.00,30892.00,30,1,'2021-11-03 13:14:34',1,1,'2021-09-29','Cash to \n                                                                Independant - SALEMAN - CASH\n                                                            , @50.00&oS;','CPV-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:14:34'),(84,110101,'BANK_RECEIPT_VOUCHER','',0.00,102.00,30790.00,31,1,'2021-11-03 13:27:03',1,1,'2021-09-29','Meezan to \n                                                                Cash\n                                                            , @102.00&oS;','BRV-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:27:03'),(85,110121,'BANK_RECEIPT_VOUCHER','',102.00,0.00,59712.00,31,1,'2021-11-03 13:27:03',1,1,'2021-09-29','Meezan to \n                                                                Cash\n                                                            , @102.00&oS;','BRV-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:27:03'),(86,110101,'BANK_PAYMENT_VOUCHER','',100.00,0.00,30890.00,32,1,'2021-11-03 13:27:21',1,1,'2021-09-29','Meezan to \n                                                                Cash\n                                                            , @100.00&oS;','BPV-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:27:21'),(87,110121,'BANK_PAYMENT_VOUCHER','',0.00,100.00,59612.00,32,1,'2021-11-03 13:27:21',1,1,'2021-09-29','Meezan to \n                                                                Cash\n                                                            , @100.00&oS;','BPV-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:27:21'),(88,110102,'BANK_RECEIPT_VOUCHER','',0.00,2.00,-202.00,33,1,'2021-11-03 13:28:12',1,1,'2021-09-29','Meezan to \n                                                                Independant - SALEMAN - CASH\n                                                            , @2.00&oS;','BRV-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:28:12'),(89,110121,'BANK_RECEIPT_VOUCHER','',2.00,0.00,59614.00,33,1,'2021-11-03 13:28:12',1,1,'2021-09-29','Meezan to \n                                                                Independant - SALEMAN - CASH\n                                                            , @2.00&oS;','BRV-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:28:12'),(90,110103,'BANK_RECEIPT_VOUCHER','',0.00,2.00,-25344.00,34,3,'2021-11-03 13:30:07',1,1,'2021-09-29','Meezan to \n                                                                Shoaib - SALEMAN - CASH\n                                                            , @2.00&oS;','BRV-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:30:07'),(91,110121,'BANK_RECEIPT_VOUCHER','',2.00,0.00,59616.00,34,3,'2021-11-03 13:30:07',1,1,'2021-09-29','Meezan to \n                                                                Shoaib - SALEMAN - CASH\n                                                            , @2.00&oS;','BRV-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:30:07'),(96,410121,'EXPENSE_PAYMENT_VOUCHER','',2.00,0.00,2.00,40,2,'2021-11-04 09:32:43',1,1,'2021-09-29','Shoaib - SALEMAN - CASH to \n                                                                Product Stock Consumed\n                                                            , @2.00&oS;','EPV-8','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:32:43'),(97,110103,'EXPENSE_PAYMENT_VOUCHER','',0.00,2.00,-25346.00,40,2,'2021-11-04 09:32:43',1,1,'2021-09-29','Shoaib - SALEMAN - CASH to \n                                                                Product Stock Consumed\n                                                            , @2.00&oS;','EPV-8','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:32:43'),(104,110121,'JOURNAL_VOUCHER','',500.00,0.00,60116.00,47,1,'2021-11-04 09:59:07',1,1,'2021-09-29','\n                                                                Meezan\n                                                            , Dr@500.00&oS;\n                                                                Shoaib - SALEMAN - CASH\n                                                            , Cr@500.00&oS;','JV-13','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:59:07'),(105,110103,'JOURNAL_VOUCHER','',0.00,500.00,-25846.00,48,1,'2021-11-04 09:59:07',1,1,'2021-09-29','\n                                                                Meezan\n                                                            , Dr@500.00&oS;\n                                                                Shoaib - SALEMAN - CASH\n                                                            , Cr@500.00&oS;','JV-13','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:59:07'),(106,110101,'JOURNAL_VOUCHER','',1000.00,0.00,31890.00,49,1,'2021-11-04 09:59:33',1,1,'2021-09-29','\n                                                                Cash\n                                                            , Dr@1,000.00&oS;\n                                                                Shoaib - SALEMAN - CASH\n                                                            , Cr@1,000.00&oS;','JV-14','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:59:33'),(107,110103,'JOURNAL_VOUCHER','',0.00,1000.00,-26846.00,50,1,'2021-11-04 09:59:33',1,1,'2021-09-29','\n                                                                Cash\n                                                            , Dr@1,000.00&oS;\n                                                                Shoaib - SALEMAN - CASH\n                                                            , Cr@1,000.00&oS;','JV-14','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:59:33'),(108,110131,'POST_DATED_CHEQUE_ISSUED','',1200.00,0.00,-48620.00,51,NULL,'2021-11-04 11:44:41',1,1,'2021-09-29','Cheque of Dated: 04-11-2021 , Amount: 1200 , ','PDCI-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 16:44:41'),(109,110121,'POST_DATED_CHEQUE_ISSUED','',0.00,1200.00,58916.00,51,NULL,'2021-11-04 11:44:41',1,1,'2021-09-29','Cheque of Dated: 04-11-2021 , Amount: 1200 , ','PDCI-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 16:44:41'),(110,110131,'POST_DATED_CHEQUE_ISSUED','',1.00,0.00,-48619.00,52,3,'2021-11-04 11:52:27',1,1,'2021-09-29','Cheque of Dated: 04-11-2021 , Amount: 1 , ','PDCI-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 16:52:27'),(111,110121,'POST_DATED_CHEQUE_ISSUED','',0.00,1.00,58915.00,52,3,'2021-11-04 11:52:27',1,1,'2021-09-29','Cheque of Dated: 04-11-2021 , Amount: 1 , ','PDCI-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 16:52:27'),(112,110121,'POST_DATED_CHEQUE_RECEIVED','',2.00,0.00,58917.00,53,2,'2021-11-04 12:21:35',1,1,'2021-09-29','Cheque of Dated: 04-11-2021 , Amount: 2 , ','PDCR-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:21:35'),(113,110132,'POST_DATED_CHEQUE_RECEIVED','',0.00,2.00,62890.00,53,2,'2021-11-04 12:21:35',1,1,'2021-09-29','Cheque of Dated: 04-11-2021 , Amount: 2 , ','PDCR-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:21:35'),(114,110121,'JOURNAL_VOUCHER','',0.00,2.00,58915.00,54,2,'2021-11-04 12:23:30',1,1,'2021-09-29','\n                                                                Meezan\n                                                            , Cr@2.00&oS;\n                                                                Meezan\n                                                            , Dr@2.00&oS;','JV-15','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:23:30'),(115,110121,'JOURNAL_VOUCHER','',2.00,0.00,58917.00,55,1,'2021-11-04 12:23:30',1,1,'2021-09-29','\n                                                                Meezan\n                                                            , Cr@2.00&oS;\n                                                                Meezan\n                                                            , Dr@2.00&oS;','JV-15','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:23:30'),(116,110131,'JOURNAL_VOUCHER','',0.00,1.00,-48620.00,56,3,'2021-11-04 12:25:32',1,1,'2021-09-29','\n                                                                Client One\n                                                            , Cr@1.00&oS;\n                                                                ABD 436\n                                                            , Dr@1.00&oS;','JV-16','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:25:32'),(117,110132,'JOURNAL_VOUCHER','',1.00,0.00,62891.00,57,2,'2021-11-04 12:25:32',1,1,'2021-09-29','\n                                                                Client One\n                                                            , Cr@1.00&oS;\n                                                                ABD 436\n                                                            , Dr@1.00&oS;','JV-16','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:25:32'),(118,410101,'PRODUCT_RECOVER','Recover',0.00,108.00,-108.00,58,2,'2021-11-04 13:39:21',1,1,'2021-09-29','Lays Rs. 5, 2@54.00 = 108&oS;','PRV-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:39:21'),(119,110111,'PRODUCT_RECOVER','Recover',108.00,0.00,51361260.00,58,2,'2021-11-04 13:39:21',1,1,'2021-09-29','Lays Rs. 5, 2@54.00 = 108&oS;','PRV-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:39:21'),(120,411131,'PRODUCT_RECOVER_SR','Recover',108.00,0.00,208.00,59,2,'2021-11-04 13:39:21',1,1,'2021-09-29','Lays Rs. 5, 2@54.00 = 108&oS;','PRV-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:39:21'),(121,410101,'PRODUCT_LOSS','Lose',54.00,0.00,-54.00,60,3,'2021-11-04 13:40:05',1,1,'2021-09-29','Lays Rs. 5, 1@54.00 = 54&oS;','PLV-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:05'),(122,110111,'PRODUCT_LOSS','Lose',0.00,54.00,51361206.00,60,3,'2021-11-04 13:40:05',1,1,'2021-09-29','Lays Rs. 5, 1@54.00 = 54&oS;','PLV-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:05'),(123,411131,'PRODUCT_LOSS_SI','Lose',0.00,54.00,154.00,61,3,'2021-11-04 13:40:05',1,1,'2021-09-29','Lays Rs. 5, 1@54.00 = 54&oS;','PLV-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:05'),(124,410101,'TRADE_PRODUCT_LOSS','Loss',128000.00,0.00,127946.00,62,2,'2021-11-04 13:40:43',1,1,'2021-09-29','Suger, 40.000@3200.00 = 128000&oS;','TPLV-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:43'),(125,110111,'TRADE_PRODUCT_LOSS','Loss',0.00,128000.00,51233206.00,62,2,'2021-11-04 13:40:43',1,1,'2021-09-29','Suger, 40.000@3200.00 = 128000&oS;','TPLV-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:43'),(126,411131,'PRODUCT_LOSS_SI','Loss',0.00,128000.00,-127846.00,63,2,'2021-11-04 13:40:43',1,1,'2021-09-29','Suger, 40.000@3200.00 = 128000&oS;','TPLV-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:43'),(127,410101,'PRODUCT_RECOVER','Rec',0.00,128000.00,-54.00,67,2,'2021-11-04 13:58:08',1,1,'2021-09-29','Suger, 40.000@3200.00 = 128000&oS;','TPRV-10','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:58:08'),(128,110111,'PRODUCT_RECOVER','Rec',128000.00,0.00,51361206.00,67,2,'2021-11-04 13:58:08',1,1,'2021-09-29','Suger, 40.000@3200.00 = 128000&oS;','TPRV-10','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:58:08'),(129,411131,'TRADE_PRODUCT_RECOVER_SR','Rec',128000.00,0.00,154.00,68,2,'2021-11-04 13:58:08',1,1,'2021-09-29','Suger, 40.000@3200.00 = 128000&oS;','TPRV-5','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:58:08'),(130,110111,'SALE_INVOICE','',0.00,128000.00,51233206.00,69,2,'2021-11-05 08:21:12',1,1,'2021-09-29','Suger, 40.000@3,600.00 = 144,000.00&oS;','TSOSI-5','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:21:12'),(131,310101,'SALE_INVOICE','',0.00,144000.00,-144060.00,70,2,'2021-11-05 08:21:12',1,1,'2021-09-29','Suger, 40.000@3,600.00 = 144,000.00&oS;','TSOSI-5','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:21:12'),(132,110161,'SALE_INVOICE','',144000.00,0.00,144000.00,71,2,'2021-11-05 08:21:12',1,1,'2021-09-29','Suger, 40.000@3,600.00 = 144,000.00&oS;','TSOSI-5','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:21:12'),(133,110101,'CASH_RECEIPT_VOUCHER','TSOSI-5',0.00,0.00,31890.00,72,2,'2021-11-05 08:21:12',1,1,'2021-09-29','Walk In Customer, @0\n','CRV-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:21:12'),(134,110161,'CASH_RECEIPT_VOUCHER','TSOSI-5',0.00,0.00,144000.00,72,2,'2021-11-05 08:21:12',1,1,'2021-09-29','Walk In Customer, @0\n','CRV-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:21:12'),(135,110111,'PURCHASE_INVOICE','',54.00,0.00,51233260.00,73,1,'2021-11-06 07:12:26',1,1,'2021-09-29','Lays Rs. 5, 1@54.00 = 54.00&oS;','PI-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:12:26'),(136,411101,'PURCHASE_INVOICE','',54.00,0.00,162.00,74,1,'2021-11-06 07:12:26',1,1,'2021-09-29','Lays Rs. 5, 1@54.00 = 54.00&oS;','PI-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:12:26'),(137,110132,'PURCHASE_INVOICE','',0.00,54.00,62837.00,75,1,'2021-11-06 07:12:26',1,1,'2021-09-29','Lays Rs. 5, 1@54.00 = 54.00&oS;','PI-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:12:26'),(138,110111,'PURCHASE_RETURN_INVOICE','',0.00,54.00,51233206.00,76,1,'2021-11-06 07:12:56',1,1,'2021-09-29','Lays Rs. 5, 1.000@54.00 = 54.00&oS;','PRI-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:12:56'),(139,411102,'PURCHASE_RETURN_INVOICE','',0.00,54.00,-54.00,77,1,'2021-11-06 07:12:56',1,1,'2021-09-29','Lays Rs. 5, 1.000@54.00 = 54.00&oS;','PRI-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:12:56'),(140,110132,'PURCHASE_RETURN_INVOICE','',54.00,0.00,62891.00,78,1,'2021-11-06 07:12:56',1,1,'2021-09-29','Lays Rs. 5, 1.000@54.00 = 54.00&oS;','PRI-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:12:56'),(141,110111,'PURCHASE_RETURN_INVOICE','',0.00,108.00,51233098.00,79,1,'2021-11-06 07:24:07',1,1,'2021-09-29','Lays Rs. 5, 1.000@54.00 = 54.00&oS;Lays Rs. 5, 1.000@54.00 = 54.00&oS;','PRI-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:24:07'),(142,411102,'PURCHASE_RETURN_INVOICE','',0.00,108.00,-162.00,80,1,'2021-11-06 07:24:08',1,1,'2021-09-29','Lays Rs. 5, 1.000@54.00 = 54.00&oS;Lays Rs. 5, 1.000@54.00 = 54.00&oS;','PRI-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:24:08'),(143,110132,'PURCHASE_RETURN_INVOICE','',108.00,0.00,62999.00,81,1,'2021-11-06 07:24:08',1,1,'2021-09-29','Lays Rs. 5, 1.000@54.00 = 54.00&oS;Lays Rs. 5, 1.000@54.00 = 54.00&oS;','PRI-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:24:08'),(144,110111,'PURCHASE_RETURN_INVOICE','',0.00,510.00,51232588.00,82,2,'2021-11-06 07:29:15',1,1,'2021-09-29','Pepsi 1500 ML, 1@510.00 = 510.00&oS;','PRI-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:29:15'),(145,411102,'PURCHASE_RETURN_INVOICE','',0.00,510.00,-672.00,83,2,'2021-11-06 07:29:15',1,1,'2021-09-29','Pepsi 1500 ML, 1@510.00 = 510.00&oS;','PRI-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:29:15'),(146,110132,'PURCHASE_RETURN_INVOICE','',510.00,0.00,63509.00,84,2,'2021-11-06 07:29:15',1,1,'2021-09-29','Pepsi 1500 ML, 1@510.00 = 510.00&oS;','PRI-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:29:15'),(147,110111,'PURCHASE_INVOICE','',72000.00,0.00,51304588.00,86,1,'2021-11-06 09:27:45',1,1,'2021-09-29','Daal Chawal, 20@3,600.00 = 72,000.00&oS;','PI-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:27:45'),(148,411101,'PURCHASE_INVOICE','',72000.00,0.00,72162.00,87,1,'2021-11-06 09:27:45',1,1,'2021-09-29','Daal Chawal, 20@3,600.00 = 72,000.00&oS;','PI-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:27:45'),(149,210101,'PURCHASE_INVOICE','',0.00,72000.00,-72000.00,88,1,'2021-11-06 09:27:45',1,1,'2021-09-29','Daal Chawal, 20@3,600.00 = 72,000.00&oS;','PI-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:27:45'),(150,110111,'PURCHASE_INVOICE','',14508.00,0.00,51319096.00,89,1,'2021-11-06 09:29:41',1,1,'2021-09-29','Lays Rs. 5, 2@54.00 = 108.00&oS;Daal Chawal, 2@3,600.00 = 7,200.00&oS;Daal Chawal, 2@3,600.00 = 7,200.00&oS;','PI-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:29:41'),(151,411101,'PURCHASE_INVOICE','',14508.00,0.00,86670.00,90,1,'2021-11-06 09:29:41',1,1,'2021-09-29','Lays Rs. 5, 2@54.00 = 108.00&oS;Daal Chawal, 2@3,600.00 = 7,200.00&oS;Daal Chawal, 2@3,600.00 = 7,200.00&oS;','PI-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:29:41'),(152,110131,'PURCHASE_INVOICE','',0.00,14508.00,-63128.00,91,1,'2021-11-06 09:29:41',1,1,'2021-09-29','Lays Rs. 5, 2@54.00 = 108.00&oS;Daal Chawal, 2@3,600.00 = 7,200.00&oS;Daal Chawal, 2@3,600.00 = 7,200.00&oS;','PI-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:29:41'),(153,410101,'PRODUCT_LOSS','Ghy',86400.00,0.00,86346.00,92,1,'2021-11-06 09:33:27',1,1,'2021-09-29','Daal Chawal, 24@3600.00 = 86400&oS;','PLV-11','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:33:27'),(154,110111,'PRODUCT_LOSS','Ghy',0.00,86400.00,51232696.00,92,1,'2021-11-06 09:33:27',1,1,'2021-09-29','Daal Chawal, 24@3600.00 = 86400&oS;','PLV-11','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:33:27'),(155,411131,'PRODUCT_LOSS_SI','Ghy',0.00,86400.00,-86246.00,93,1,'2021-11-06 09:33:27',1,1,'2021-09-29','Daal Chawal, 24@3600.00 = 86400&oS;','PLV-6','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:33:27'),(156,410101,'PRODUCT_RECOVER','Kju',0.00,180000.00,-93654.00,94,1,'2021-11-06 09:35:55',1,1,'2021-09-29','Daal Chawal, 50@3600.00 = 180000&oS;','PRV-12','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:35:55'),(157,110111,'PRODUCT_RECOVER','Kju',180000.00,0.00,51412696.00,94,1,'2021-11-06 09:35:55',1,1,'2021-09-29','Daal Chawal, 50@3600.00 = 180000&oS;','PRV-12','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:35:55'),(158,411131,'PRODUCT_RECOVER_SR','Kju',180000.00,0.00,93754.00,95,1,'2021-11-06 09:35:55',1,1,'2021-09-29','Daal Chawal, 50@3600.00 = 180000&oS;','PRV-6','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:35:55'),(159,110111,'PURCHASE_RETURN_INVOICE','',0.00,72000.00,51340696.00,96,1,'2021-11-06 09:37:15',1,1,'2021-09-29','Daal Chawal, 20.000@3,600.00 = 72,000.00&oS;','PRI-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:37:15'),(160,411102,'PURCHASE_RETURN_INVOICE','',0.00,72000.00,-72672.00,97,1,'2021-11-06 09:37:15',1,1,'2021-09-29','Daal Chawal, 20.000@3,600.00 = 72,000.00&oS;','PRI-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:37:15'),(161,210101,'PURCHASE_RETURN_INVOICE','',72000.00,0.00,0.00,98,1,'2021-11-06 09:37:15',1,1,'2021-09-29','Daal Chawal, 20.000@3,600.00 = 72,000.00&oS;','PRI-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:37:15'),(162,110111,'SALE_INVOICE','',0.00,54108.00,51286588.00,99,1,'2021-11-06 09:39:07',1,1,'2021-09-29','Lays Rs. 5, 1@60.00 = 60.00&oS;Daal Chawal, 10@4,000.00 = 40,000.00&oS;Lays Rs. 5, 1@60.00 = 60.00&oS;Daal Chawal, 5@4,000.00 = 20,000.00&oS;','SI-7','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:39:07'),(163,310101,'SALE_INVOICE','',0.00,60120.00,-204180.00,100,1,'2021-11-06 09:39:07',1,1,'2021-09-29','Lays Rs. 5, 1@60.00 = 60.00&oS;Daal Chawal, 10@4,000.00 = 40,000.00&oS;Lays Rs. 5, 1@60.00 = 60.00&oS;Daal Chawal, 5@4,000.00 = 20,000.00&oS;','SI-7','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:39:07'),(164,110161,'SALE_INVOICE','',60120.00,0.00,204120.00,101,1,'2021-11-06 09:39:07',1,1,'2021-09-29','Lays Rs. 5, 1@60.00 = 60.00&oS;Daal Chawal, 10@4,000.00 = 40,000.00&oS;Lays Rs. 5, 1@60.00 = 60.00&oS;Daal Chawal, 5@4,000.00 = 20,000.00&oS;','SI-7','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:39:07'),(165,110101,'CASH_RECEIPT_VOUCHER','SI-7',60120.00,0.00,92010.00,102,1,'2021-11-06 09:39:08',1,1,'2021-09-29','Walk In Customer, @60120\n','CRV-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:39:08'),(166,110161,'CASH_RECEIPT_VOUCHER','SI-7',0.00,60120.00,144000.00,102,1,'2021-11-06 09:39:08',1,1,'2021-09-29','Walk In Customer, @60120\n','CRV-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:39:08'),(167,110111,'CLAIM_ISSUE','Sdfsdf',0.00,3600.00,51282988.00,103,2,'2021-11-06 09:47:29',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:47:29'),(168,411121,'CLAIM_ISSUE','Sdfsdf',0.00,3600.00,-3600.00,104,2,'2021-11-06 09:47:29',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:47:29'),(169,110172,'CLAIM_ISSUE','Sdfsdf',3600.00,0.00,3600.00,105,2,'2021-11-06 09:47:29',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:47:29'),(170,110111,'CLAIM_RECEIVED','Dfsdf',3600.00,0.00,51286588.00,106,2,'2021-11-06 10:11:52',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:11:52'),(171,411122,'CLAIM_RECEIVED','Dfsdf',3600.00,0.00,3600.00,107,2,'2021-11-06 10:11:52',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:11:52'),(172,110171,'CLAIM_RECEIVED','Dfsdf',0.00,3600.00,-3600.00,108,2,'2021-11-06 10:11:52',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:11:52'),(173,110111,'CLAIM_RECEIVED','Fsfdf',160000.00,0.00,51446588.00,109,3,'2021-11-06 10:12:21',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:12:21'),(174,411122,'CLAIM_RECEIVED','Fsfdf',160000.00,0.00,163600.00,110,3,'2021-11-06 10:12:21',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:12:21'),(175,110171,'CLAIM_RECEIVED','Fsfdf',0.00,160000.00,-163600.00,111,3,'2021-11-06 10:12:21',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:12:21'),(176,110111,'CLAIM_ISSUE','Fdsfds',0.00,160000.00,51286588.00,112,2,'2021-11-06 10:13:47',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:13:47'),(177,411121,'CLAIM_ISSUE','Fdsfds',0.00,160000.00,-163600.00,113,2,'2021-11-06 10:13:47',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:13:47'),(178,110171,'CLAIM_ISSUE','Fdsfds',160000.00,0.00,-3600.00,114,2,'2021-11-06 10:13:47',1,1,'2021-09-29','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:13:47'),(179,110111,'SALE_INVOICE','',0.00,3254.00,51283334.00,115,1,'2021-11-08 10:30:55',1,1,'2021-09-29','Lays Rs. 5, 1@60.00 = 60.00&oS;Suger, 1@3,600.00 = 3,600.00&oS;','SI-8','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:30:55'),(180,310101,'SALE_INVOICE','',0.00,3660.00,-207840.00,116,1,'2021-11-08 10:30:55',1,1,'2021-09-29','Lays Rs. 5, 1@60.00 = 60.00&oS;Suger, 1@3,600.00 = 3,600.00&oS;','SI-8','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:30:55'),(181,110161,'SALE_INVOICE','',3660.00,0.00,147660.00,117,1,'2021-11-08 10:30:55',1,1,'2021-09-29','Lays Rs. 5, 1@60.00 = 60.00&oS;Suger, 1@3,600.00 = 3,600.00&oS;','SI-8','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:30:55'),(182,110111,'SALE_INVOICE','',0.00,3254.00,51280080.00,118,1,'2021-11-08 10:31:14',1,1,'2021-09-29',', 1@3,600.00 = 3,600.00&oS;, 1@60.00 = 60.00&oS;','SI-9','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:31:14'),(183,310101,'SALE_INVOICE','',0.00,3660.00,-211500.00,119,1,'2021-11-08 10:31:14',1,1,'2021-09-29',', 1@3,600.00 = 3,600.00&oS;, 1@60.00 = 60.00&oS;','SI-9','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:31:14'),(184,110132,'SALE_INVOICE','',3660.00,0.00,67169.00,120,1,'2021-11-08 10:31:14',1,1,'2021-09-29',', 1@3,600.00 = 3,600.00&oS;, 1@60.00 = 60.00&oS;','SI-9','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:31:14'),(185,110111,'SALE_INVOICE','',0.00,54.00,51280026.00,121,1,'2021-11-08 10:48:08',1,1,'2021-09-29','Lays Rs. 5, 1@60.00 = 60.00&oS;','SI-10','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:48:08'),(186,310101,'SALE_INVOICE','',0.00,60.00,-211560.00,122,1,'2021-11-08 10:48:08',1,1,'2021-09-29','Lays Rs. 5, 1@60.00 = 60.00&oS;','SI-10','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:48:08'),(187,110132,'SALE_INVOICE','',60.00,0.00,67229.00,123,1,'2021-11-08 10:48:08',1,1,'2021-09-29','Lays Rs. 5, 1@60.00 = 60.00&oS;','SI-10','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:48:08'),(188,110111,'SALE_INVOICE','',0.00,168615.20,51111410.80,124,1,'2021-11-09 06:28:34',1,1,'2021-09-29','Daal Chawal, QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSI-11','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 11:28:34'),(189,310101,'SALE_INVOICE','',0.00,160000.00,-371560.00,125,1,'2021-11-09 06:28:34',1,1,'2021-09-29','Daal Chawal, QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSI-11','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 11:28:34'),(190,110161,'SALE_INVOICE','',160000.00,0.00,307660.00,126,1,'2021-11-09 06:28:34',1,1,'2021-09-29','Daal Chawal, QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSI-11','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 11:28:34'),(191,110111,'PURCHASE_INVOICE','',400000.00,0.00,51511410.80,127,1,'2021-11-09 11:57:01',1,1,'2021-09-29','Daal Chawal, 100@4,000.00 = 400,000.00&oS;','PI-5','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 16:57:01'),(192,411101,'PURCHASE_INVOICE','',400000.00,0.00,486670.00,128,1,'2021-11-09 11:57:01',1,1,'2021-09-29','Daal Chawal, 100@4,000.00 = 400,000.00&oS;','PI-5','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 16:57:01'),(193,210101,'PURCHASE_INVOICE','',0.00,400000.00,-400000.00,129,1,'2021-11-09 11:57:01',1,1,'2021-09-29','Daal Chawal, 100@4,000.00 = 400,000.00&oS;','PI-5','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 16:57:01'),(194,110111,'SALE_SALE_TAX_INVOICE','',0.00,288000.00,51223410.80,130,1,'2021-11-10 06:34:02',1,1,'2021-09-29',', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSTSI-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 11:34:02'),(195,310101,'SALE_SALE_TAX_INVOICE','',0.00,304000.00,-675560.00,131,1,'2021-11-10 06:34:02',1,1,'2021-09-29',', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSTSI-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 11:34:02'),(196,110161,'SALE_SALE_TAX_INVOICE','',304000.00,0.00,611660.00,132,1,'2021-11-10 06:34:02',1,1,'2021-09-29',', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSTSI-1','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 11:34:02'),(197,110111,'SALE_SALE_TAX_INVOICE','',0.00,160000.00,51063410.80,133,1,'2021-11-10 07:07:08',1,1,'2021-09-29',', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSTSI-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:07:08'),(198,310101,'SALE_SALE_TAX_INVOICE','',0.00,160000.00,-835560.00,134,1,'2021-11-10 07:07:08',1,1,'2021-09-29',', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSTSI-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:07:08'),(199,110161,'SALE_SALE_TAX_INVOICE','',160000.00,0.00,771660.00,135,1,'2021-11-10 07:07:08',1,1,'2021-09-29',', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSTSI-2','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:07:08'),(200,110111,'SALE_SALE_TAX_INVOICE','',0.00,288000.00,50775410.80,136,1,'2021-11-10 07:14:16',1,1,'2021-09-29',', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSTSI-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:16'),(201,310101,'SALE_SALE_TAX_INVOICE','',0.00,304000.00,-1139560.00,137,1,'2021-11-10 07:14:16',1,1,'2021-09-29',', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSTSI-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:16'),(202,110161,'SALE_SALE_TAX_INVOICE','',304000.00,0.00,1075660.00,138,1,'2021-11-10 07:14:16',1,1,'2021-09-29',', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSTSI-3','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:16'),(203,110111,'SALE_SALE_TAX_INVOICE','',0.00,288000.00,50487410.80,139,1,'2021-11-10 07:14:48',1,1,'2021-09-29',', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSTSI-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:48'),(204,310101,'SALE_SALE_TAX_INVOICE','',0.00,304000.00,-1443560.00,140,1,'2021-11-10 07:14:48',1,1,'2021-09-29',', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSTSI-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:48'),(205,110161,'SALE_SALE_TAX_INVOICE','',304000.00,0.00,1379660.00,141,1,'2021-11-10 07:14:48',1,1,'2021-09-29',', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSTSI-4','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:48'),(206,110111,'SALE_SALE_TAX_INVOICE','',0.00,128648.00,50358762.80,142,1,'2021-11-10 07:16:16',1,1,'2021-09-29',', QTY 12.000@60.00 = 720.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSTSI-5','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:16:16'),(207,310101,'SALE_SALE_TAX_INVOICE','',0.00,144720.00,-1588280.00,143,1,'2021-11-10 07:16:16',1,1,'2021-09-29',', QTY 12.000@60.00 = 720.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSTSI-5','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:16:16'),(208,110161,'SALE_SALE_TAX_INVOICE','',144720.00,0.00,1524380.00,144,1,'2021-11-10 07:16:16',1,1,'2021-09-29',', QTY 12.000@60.00 = 720.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSTSI-5','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:16:16'),(209,110111,'SALE_INVOICE','',0.00,648.00,50358114.80,145,1,'2021-11-10 11:35:19',1,1,'2021-09-29','Lays Rs. 5, QTY 12.000@60.00 = 720.00, Pack QTY = 1, Loose QTY = 0&oS;','TSI-12','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 16:35:19'),(210,310101,'SALE_INVOICE','',0.00,720.00,-1589000.00,146,1,'2021-11-10 11:35:19',1,1,'2021-09-29','Lays Rs. 5, QTY 12.000@60.00 = 720.00, Pack QTY = 1, Loose QTY = 0&oS;','TSI-12','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 16:35:19'),(211,110161,'SALE_INVOICE','',720.00,0.00,1525100.00,147,1,'2021-11-10 11:35:19',1,1,'2021-09-29','Lays Rs. 5, QTY 12.000@60.00 = 720.00, Pack QTY = 1, Loose QTY = 0&oS;','TSI-12','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 16:35:19'),(212,413102,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,NULL,'2021-11-10 11:42:03',1,1,'2021-09-29','OPENING_BALANCE','','','','2021-11-10 16:42:03'),(213,110182,'OPENING_BALANCE','OPENING_BALANCE',0.00,0.00,0.00,0,NULL,'2021-11-10 11:42:03',1,1,'2021-09-29','OPENING_BALANCE','','','','2021-11-10 16:42:03'),(214,110111,'SALE_INVOICE','',0.00,131060.00,50227054.80,148,1,'2021-11-10 12:24:35',1,1,'2021-09-29',', QTY 6.000@540.00 = 3,240.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSI-13','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 17:24:35'),(215,310101,'SALE_INVOICE','',0.00,147240.00,-1736240.00,149,1,'2021-11-10 12:24:35',1,1,'2021-09-29',', QTY 6.000@540.00 = 3,240.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSI-13','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 17:24:35'),(216,110161,'SALE_INVOICE','',147240.00,0.00,1672340.00,150,1,'2021-11-10 12:24:35',1,1,'2021-09-29',', QTY 6.000@540.00 = 3,240.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;','TSI-13','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 17:24:35');
/*!40000 ALTER TABLE `financials_balances` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`digitalmunshi`@`localhost`*/ /*!50003 TRIGGER `update_account_debit_credit` AFTER INSERT ON `financials_balances` FOR EACH ROW UPDATE financials_accounts SET 
	account_today_debit = (account_today_debit + NEW.bal_dr), 
	account_today_credit = (account_today_credit + NEW.bal_cr), 
	account_monthly_debit = (account_monthly_debit + NEW.bal_dr), 
	account_monthly_credit = (account_monthly_credit + NEW.bal_cr), 
	account_balance = NEW.bal_total 
WHERE account_uid = NEW.bal_account_id */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `financials_bank_payment_voucher`
--

DROP TABLE IF EXISTS `financials_bank_payment_voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_bank_payment_voucher` (
  `bp_id` int(11) NOT NULL AUTO_INCREMENT,
  `bp_account_id` int(11) NOT NULL,
  `bp_total_amount` decimal(50,2) NOT NULL,
  `bp_remarks` varchar(450) DEFAULT NULL,
  `bp_created_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `bp_day_end_id` int(11) DEFAULT NULL,
  `bp_day_end_date` date DEFAULT NULL,
  `bp_createdby` int(11) DEFAULT NULL,
  `bp_detail_remarks` varchar(1000) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `bp_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `bp_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  PRIMARY KEY (`bp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_bank_payment_voucher`
--

LOCK TABLES `financials_bank_payment_voucher` WRITE;
/*!40000 ALTER TABLE `financials_bank_payment_voucher` DISABLE KEYS */;
INSERT INTO `financials_bank_payment_voucher` VALUES (1,110121,120.00,NULL,'2021-11-03 09:42:23',1,'2021-09-29',1,'\n                                                                Cash\n                                                            , @120.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69'),(2,110121,5000.00,'asdfdsa f','2021-11-03 09:52:15',1,'2021-09-29',1,'\n                                                                Meezan\n                                                            , @5,000.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69'),(3,110121,100.00,NULL,'2021-11-03 13:27:21',1,'2021-09-29',1,'\n                                                                Cash\n                                                            , @100.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69');
/*!40000 ALTER TABLE `financials_bank_payment_voucher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_bank_payment_voucher_items`
--

DROP TABLE IF EXISTS `financials_bank_payment_voucher_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_bank_payment_voucher_items` (
  `bpi_id` int(11) NOT NULL AUTO_INCREMENT,
  `bpi_voucher_id` int(11) NOT NULL,
  `bpi_account_id` int(11) NOT NULL,
  `bpi_account_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `bpi_pr_id` int(11) DEFAULT NULL,
  `bpi_amount` double NOT NULL,
  `bpi_remarks` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`bpi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_bank_payment_voucher_items`
--

LOCK TABLES `financials_bank_payment_voucher_items` WRITE;
/*!40000 ALTER TABLE `financials_bank_payment_voucher_items` DISABLE KEYS */;
INSERT INTO `financials_bank_payment_voucher_items` VALUES (1,1,110101,'\n                                                                Cash\n                                                            ',1,120,''),(2,2,110121,'\n                                                                Meezan\n                                                            ',1,5000,'Alsdkfkl;hs'),(3,3,110101,'\n                                                                Cash\n                                                            ',1,100,'');
/*!40000 ALTER TABLE `financials_bank_payment_voucher_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_bank_receipt_voucher`
--

DROP TABLE IF EXISTS `financials_bank_receipt_voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_bank_receipt_voucher` (
  `br_id` int(11) NOT NULL AUTO_INCREMENT,
  `br_account_id` int(11) NOT NULL,
  `br_bank_amount` decimal(50,2) NOT NULL,
  `br_total_amount` decimal(50,2) NOT NULL,
  `br_remarks` varchar(450) DEFAULT NULL,
  `br_created_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `br_day_end_id` int(11) DEFAULT NULL,
  `br_day_end_date` date DEFAULT NULL,
  `br_createdby` int(11) DEFAULT NULL,
  `br_detail_remarks` varchar(1000) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `br_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `br_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  PRIMARY KEY (`br_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_bank_receipt_voucher`
--

LOCK TABLES `financials_bank_receipt_voucher` WRITE;
/*!40000 ALTER TABLE `financials_bank_receipt_voucher` DISABLE KEYS */;
INSERT INTO `financials_bank_receipt_voucher` VALUES (1,110121,50000.00,50000.00,'sdafasdf','2021-11-03 09:51:55',1,'2021-09-29',1,'\n                                                                Client One\n                                                            , @50,000.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69'),(2,110121,102.00,102.00,NULL,'2021-11-03 13:27:02',1,'2021-09-29',1,'\n                                                                Cash\n                                                            , @102.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69'),(3,110121,2.00,2.00,NULL,'2021-11-03 13:28:11',1,'2021-09-29',1,'\n                                                                Independant - SALEMAN - CASH\n                                                            , @2.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69'),(4,110121,2.00,2.00,NULL,'2021-11-03 13:30:07',1,'2021-09-29',1,'\n                                                                Shoaib - SALEMAN - CASH\n                                                            , @2.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69');
/*!40000 ALTER TABLE `financials_bank_receipt_voucher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_bank_receipt_voucher_items`
--

DROP TABLE IF EXISTS `financials_bank_receipt_voucher_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_bank_receipt_voucher_items` (
  `bri_id` int(11) NOT NULL AUTO_INCREMENT,
  `bri_voucher_id` int(11) NOT NULL,
  `bri_account_id` int(11) NOT NULL,
  `bri_account_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `bri_pr_id` int(11) DEFAULT NULL,
  `bri_type` varchar(5) DEFAULT 'CR',
  `bri_amount` decimal(50,2) NOT NULL,
  `bri_remarks` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`bri_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_bank_receipt_voucher_items`
--

LOCK TABLES `financials_bank_receipt_voucher_items` WRITE;
/*!40000 ALTER TABLE `financials_bank_receipt_voucher_items` DISABLE KEYS */;
INSERT INTO `financials_bank_receipt_voucher_items` VALUES (1,1,110131,'\n                                                                Client One\n                                                            ',1,'CR',50000.00,'Sagfsga'),(2,2,110101,'\n                                                                Cash\n                                                            ',1,'CR',102.00,''),(3,3,110102,'\n                                                                Independant - SALEMAN - CASH\n                                                            ',1,'CR',2.00,''),(4,4,110103,'\n                                                                Shoaib - SALEMAN - CASH\n                                                            ',3,'CR',2.00,'');
/*!40000 ALTER TABLE `financials_bank_receipt_voucher_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_brands`
--

DROP TABLE IF EXISTS `financials_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_brands` (
  `br_id` int(11) NOT NULL AUTO_INCREMENT,
  `br_title` varchar(500) NOT NULL,
  `br_remarks` varchar(1000) NOT NULL DEFAULT '',
  `br_created_by` int(11) NOT NULL DEFAULT 0,
  `br_day_end_id` int(11) NOT NULL,
  `br_day_end_date` date DEFAULT NULL,
  `br_datetime` timestamp NULL DEFAULT current_timestamp(),
  `br_ip_adr` varchar(255) DEFAULT NULL,
  `br_brwsr_info` varchar(4000) DEFAULT NULL,
  `br_update_datetime` timestamp NULL DEFAULT NULL,
  `br_delete_status` tinyint(4) DEFAULT 0,
  `br_deleted_by` int(11) DEFAULT NULL,
  `br_disabled` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`br_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_brands`
--

LOCK TABLES `financials_brands` WRITE;
/*!40000 ALTER TABLE `financials_brands` DISABLE KEYS */;
INSERT INTO `financials_brands` VALUES (1,'Pepsi','',1,1,'2021-09-29','2021-11-10 07:27:55','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 07:27:55',0,NULL,0);
/*!40000 ALTER TABLE `financials_brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_budgeted_raw_stock`
--

DROP TABLE IF EXISTS `financials_budgeted_raw_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_budgeted_raw_stock` (
  `brs_id` int(11) NOT NULL AUTO_INCREMENT,
  `brs_odr_id` int(11) NOT NULL,
  `brs_pro_code` varchar(500) NOT NULL,
  `brs_pro_name` varchar(1000) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `brs_pro_remarks` text DEFAULT NULL,
  `brs_uom` varchar(1000) NOT NULL,
  `brs_recipe_consumption` decimal(50,2) NOT NULL,
  `brs_required_production_qty` decimal(50,2) NOT NULL,
  `brs_in_hand_stock` decimal(50,2) NOT NULL,
  PRIMARY KEY (`brs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_budgeted_raw_stock`
--

LOCK TABLES `financials_budgeted_raw_stock` WRITE;
/*!40000 ALTER TABLE `financials_budgeted_raw_stock` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_budgeted_raw_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_capital_register`
--

DROP TABLE IF EXISTS `financials_capital_register`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_capital_register` (
  `cr_id` int(11) NOT NULL AUTO_INCREMENT,
  `cr_parent_account_uid` int(11) NOT NULL,
  `cr_capital_account_uid` int(11) NOT NULL,
  `cr_profit_loss_account_uid` int(11) NOT NULL,
  `cr_drawing_account_uid` int(11) NOT NULL,
  `cr_reserve_account_uid` int(11) NOT NULL,
  `cr_user_id` int(11) NOT NULL,
  `cr_partner_nature` tinyint(4) NOT NULL,
  `cr_initial_capital` int(11) NOT NULL,
  `cr_system_ratio` double(10,5) NOT NULL,
  `cr_is_custom_profit` tinyint(4) DEFAULT 0,
  `cr_is_custom_loss` tinyint(4) DEFAULT 0,
  `cr_fixed_profit_per` decimal(10,2) DEFAULT NULL,
  `cr_fixed_loss_per` decimal(10,2) DEFAULT NULL,
  `cr_custom_profit_ratio` double(10,5) DEFAULT NULL,
  `cr_custom_loss_ratio` double(10,5) DEFAULT NULL,
  `cr_ramaning_profit_per` double(10,2) DEFAULT NULL,
  `cr_remaning_loss_per` double(10,2) DEFAULT NULL,
  `cr_remaning_profit_division` tinyint(4) DEFAULT 1,
  `cr_remaning_loss_division` tinyint(4) DEFAULT 1,
  `cr_created_by` int(11) NOT NULL,
  `cr_day_end_id` int(11) NOT NULL,
  `cr_day_end_date` date DEFAULT NULL,
  `cr_remarks` varchar(1000) DEFAULT NULL,
  `cr_relation_with_director` varchar(500) DEFAULT NULL,
  `cr_current_date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `cr_ip_adrs` varchar(255) DEFAULT NULL,
  `cr_brwsr_info` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`cr_id`),
  UNIQUE KEY `cr_capital_account_uid` (`cr_capital_account_uid`),
  UNIQUE KEY `cr_profit_loss_account_uid` (`cr_profit_loss_account_uid`),
  UNIQUE KEY `cr_drawing_account_uid` (`cr_drawing_account_uid`),
  UNIQUE KEY `cr_reserve_account_uid` (`cr_reserve_account_uid`),
  UNIQUE KEY `cr_user_id` (`cr_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_capital_register`
--

LOCK TABLES `financials_capital_register` WRITE;
/*!40000 ALTER TABLE `financials_capital_register` DISABLE KEYS */;
INSERT INTO `financials_capital_register` VALUES (1,51010,510101,510102,510103,510104,2,1,1000000,100.00000,0,0,0.00,0.00,100.00000,100.00000,0.00,0.00,0,0,1,0,'2021-10-29','','CFO','2021-10-29 08:30:42',NULL,NULL),(2,51011,510111,510112,510113,510114,4,1,500,0.00000,0,0,0.00,0.00,0.00000,0.00000,0.00,0.00,0,0,1,1,'2021-09-29','','','2021-10-30 06:41:59',NULL,NULL);
/*!40000 ALTER TABLE `financials_capital_register` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_cash_payment_voucher`
--

DROP TABLE IF EXISTS `financials_cash_payment_voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_cash_payment_voucher` (
  `cp_id` int(11) NOT NULL AUTO_INCREMENT,
  `cp_account_id` int(11) NOT NULL,
  `cp_total_amount` decimal(50,2) NOT NULL,
  `cp_remarks` varchar(450) DEFAULT NULL,
  `cp_created_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `cp_day_end_id` int(11) DEFAULT NULL,
  `cp_day_end_date` date DEFAULT NULL,
  `cp_createdby` int(11) DEFAULT NULL,
  `cp_detail_remarks` varchar(1000) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `cp_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `cp_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  PRIMARY KEY (`cp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_cash_payment_voucher`
--

LOCK TABLES `financials_cash_payment_voucher` WRITE;
/*!40000 ALTER TABLE `financials_cash_payment_voucher` DISABLE KEYS */;
INSERT INTO `financials_cash_payment_voucher` VALUES (1,110103,10000.00,'asdfdsaf','2021-11-03 09:51:22',1,'2021-09-29',1,'\n                                                                Meezan\n                                                            , @10,000.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69'),(2,110101,50.00,NULL,'2021-11-03 13:14:34',1,'2021-09-29',1,'\n                                                                Independant - SALEMAN - CASH\n                                                            , @50.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69');
/*!40000 ALTER TABLE `financials_cash_payment_voucher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_cash_payment_voucher_items`
--

DROP TABLE IF EXISTS `financials_cash_payment_voucher_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_cash_payment_voucher_items` (
  `cpi_id` int(11) NOT NULL AUTO_INCREMENT,
  `cpi_voucher_id` int(11) NOT NULL,
  `cpi_account_id` int(11) NOT NULL,
  `cpi_account_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `cpi_pr_id` int(11) DEFAULT NULL,
  `cpi_amount` double NOT NULL,
  `cpi_remarks` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`cpi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_cash_payment_voucher_items`
--

LOCK TABLES `financials_cash_payment_voucher_items` WRITE;
/*!40000 ALTER TABLE `financials_cash_payment_voucher_items` DISABLE KEYS */;
INSERT INTO `financials_cash_payment_voucher_items` VALUES (1,1,110121,'\n                                                                Meezan\n                                                            ',1,10000,'Asdfds'),(2,2,110102,'\n                                                                Independant - SALEMAN - CASH\n                                                            ',1,50,'');
/*!40000 ALTER TABLE `financials_cash_payment_voucher_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_cash_receipt_voucher`
--

DROP TABLE IF EXISTS `financials_cash_receipt_voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_cash_receipt_voucher` (
  `cr_id` int(11) NOT NULL AUTO_INCREMENT,
  `cr_account_id` int(11) NOT NULL,
  `cr_total_amount` decimal(50,2) NOT NULL,
  `cr_remarks` varchar(450) DEFAULT NULL,
  `cr_created_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `cr_day_end_id` int(11) DEFAULT NULL,
  `cr_day_end_date` date DEFAULT NULL,
  `cr_createdby` int(11) DEFAULT NULL,
  `cr_detail_remarks` varchar(1000) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `cr_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `cr_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  PRIMARY KEY (`cr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_cash_receipt_voucher`
--

LOCK TABLES `financials_cash_receipt_voucher` WRITE;
/*!40000 ALTER TABLE `financials_cash_receipt_voucher` DISABLE KEYS */;
INSERT INTO `financials_cash_receipt_voucher` VALUES (1,110101,15222.00,'dfasdf asdfsd','2021-11-03 09:50:48',1,'2021-09-29',1,'Shoaib - SALEMAN - CASH, @3,000.00&oS;Shoaib - SALEMAN - CASH, @12,222.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69'),(2,110101,150.00,NULL,'2021-11-03 13:14:15',1,'2021-09-29',1,'Independant - SALEMAN - CASH, @150.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69'),(3,110101,0.00,'TSOSI-5','2021-11-05 08:21:12',1,'2021-09-29',1,'Walk In Customer, @0\n','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69'),(4,110101,60120.00,'SI-7','2021-11-06 09:39:07',1,'2021-09-29',1,'Walk In Customer, @60120\n','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69');
/*!40000 ALTER TABLE `financials_cash_receipt_voucher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_cash_receipt_voucher_items`
--

DROP TABLE IF EXISTS `financials_cash_receipt_voucher_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_cash_receipt_voucher_items` (
  `cri_id` int(11) NOT NULL AUTO_INCREMENT,
  `cri_voucher_id` int(11) NOT NULL,
  `cri_account_id` int(11) NOT NULL,
  `cri_account_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `cri_pr_id` int(11) DEFAULT NULL,
  `cri_amount` decimal(50,2) NOT NULL,
  `cri_remarks` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`cri_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_cash_receipt_voucher_items`
--

LOCK TABLES `financials_cash_receipt_voucher_items` WRITE;
/*!40000 ALTER TABLE `financials_cash_receipt_voucher_items` DISABLE KEYS */;
INSERT INTO `financials_cash_receipt_voucher_items` VALUES (1,1,110103,'Shoaib - SALEMAN - CASH',1,3000.00,'Ghgdfhghg'),(2,1,110103,'Shoaib - SALEMAN - CASH',1,12222.00,'Adfasdf'),(3,2,110102,'Independant - SALEMAN - CASH',1,150.00,''),(4,3,110161,'Walk In Customer',NULL,0.00,''),(5,4,110161,'Walk In Customer',NULL,60120.00,'');
/*!40000 ALTER TABLE `financials_cash_receipt_voucher_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_cash_transfer`
--

DROP TABLE IF EXISTS `financials_cash_transfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_cash_transfer` (
  `ct_id` int(11) NOT NULL AUTO_INCREMENT,
  `ct_send_by` int(11) NOT NULL,
  `ct_amount` double NOT NULL,
  `ct_receive_by` int(11) NOT NULL,
  `ct_send_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `ct_receive_datetime` timestamp NULL DEFAULT NULL,
  `ct_dayend_id` int(11) NOT NULL,
  `ct_dayend_date` date NOT NULL,
  `ct_status` varchar(50) NOT NULL,
  `ct_reason` varchar(500) DEFAULT NULL,
  `ct_remarks` varchar(500) DEFAULT NULL,
  `ct_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `ct_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `ct_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ct_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_cash_transfer`
--

LOCK TABLES `financials_cash_transfer` WRITE;
/*!40000 ALTER TABLE `financials_cash_transfer` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_cash_transfer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_categories`
--

DROP TABLE IF EXISTS `financials_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(250) NOT NULL,
  `cat_remarks` varchar(500) DEFAULT NULL,
  `cat_group_id` int(11) NOT NULL,
  `cat_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `cat_createdby` int(11) DEFAULT NULL,
  `cat_day_end_id` int(11) DEFAULT NULL,
  `cat_day_end_date` date DEFAULT NULL,
  `cat_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `cat_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `cat_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `cat_use_group_fields` tinyint(4) DEFAULT 0,
  `cat_tax` decimal(50,2) DEFAULT 0.00,
  `cat_retailer_discount` decimal(50,2) DEFAULT 0.00,
  `cat_whole_seller_discount` decimal(50,2) DEFAULT 0.00,
  `cat_loyalty_card_discount` decimal(50,2) DEFAULT 0.00,
  `cat_delete_status` int(11) DEFAULT 0,
  `cat_deleted_by` int(11) DEFAULT NULL,
  `cat_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_categories`
--

LOCK TABLES `financials_categories` WRITE;
/*!40000 ALTER TABLE `financials_categories` DISABLE KEYS */;
INSERT INTO `financials_categories` VALUES (1,'Initial Category','',1,'2021-10-29 08:08:28',1,0,'2021-10-29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:08:28',0,0.00,0.00,0.00,0.00,0,NULL,0);
/*!40000 ALTER TABLE `financials_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_city`
--

DROP TABLE IF EXISTS `financials_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(500) NOT NULL,
  `city_prov` varchar(100) NOT NULL,
  `city_flag` varchar(1) NOT NULL DEFAULT 'F',
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=377 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_city`
--

LOCK TABLES `financials_city` WRITE;
/*!40000 ALTER TABLE `financials_city` DISABLE KEYS */;
INSERT INTO `financials_city` VALUES (1,'Bagh','Azad Kashmir','F'),(2,'Bhimber','Azad Kashmir','F'),(3,'khuiratta','Azad Kashmir','F'),(4,'Kotli','Azad Kashmir','F'),(5,'Mangla','Azad Kashmir','F'),(6,'Mirpur','Azad Kashmir','F'),(7,'Muzaffarabad','Azad Kashmir','F'),(8,'Plandri','Azad Kashmir','F'),(9,'Rawalakot','Azad Kashmir','F'),(10,'Punch','Azad Kashmir','T'),(11,'Amir Chah','Balochistan','F'),(12,'Bazdar','Balochistan','F'),(13,'Bela','Balochistan','F'),(14,'Bellpat','Balochistan','F'),(15,'Bagh','Balochistan','F'),(16,'Burj','Balochistan','F'),(17,'Chagai','Balochistan','F'),(18,'Chah Sandan','Balochistan','F'),(19,'Chakku','Balochistan','F'),(20,'Chaman','Balochistan','F'),(21,'Chhatr','Balochistan','F'),(22,'Dalbandin','Balochistan','F'),(23,'Dera Bugti','Balochistan','F'),(24,'Dhana Sar','Balochistan','F'),(25,'Diwana','Balochistan','F'),(26,'Duki','Balochistan','F'),(27,'Dushi','Balochistan','F'),(28,'Duzab','Balochistan','F'),(29,'Gajar','Balochistan','F'),(30,'Gandava','Balochistan','F'),(31,'Garhi Khairo','Balochistan','F'),(32,'Garruck','Balochistan','F'),(33,'Ghazluna','Balochistan','F'),(34,'Girdan','Balochistan','F'),(35,'Gulistan','Balochistan','F'),(36,'Gwadar','Balochistan','F'),(37,'Gwash','Balochistan','F'),(38,'Hab Chauki','Balochistan','F'),(39,'Hameedabad','Balochistan','F'),(40,'Harnai','Balochistan','F'),(41,'Hinglaj','Balochistan','F'),(42,'Hoshab','Balochistan','F'),(43,'Ispikan','Balochistan','F'),(44,'Jhal','Balochistan','F'),(45,'Jhal Jhao','Balochistan','F'),(46,'Jhatpat','Balochistan','F'),(47,'Jiwani','Balochistan','F'),(48,'Kalandi','Balochistan','F'),(49,'Kalat','Balochistan','F'),(50,'Kamararod','Balochistan','F'),(51,'Kanak','Balochistan','F'),(52,'Kandi','Balochistan','T'),(53,'Kanpur','Balochistan','F'),(54,'Kapip','Balochistan','F'),(55,'Kappar','Balochistan','F'),(56,'Karodi','Balochistan','F'),(57,'Katuri','Balochistan','F'),(58,'Kharan','Balochistan','F'),(59,'Khuzdar','Balochistan','F'),(60,'Kikki','Balochistan','F'),(61,'Kohan','Balochistan','F'),(62,'Kohlu','Balochistan','F'),(63,'Korak','Balochistan','F'),(64,'Lahri','Balochistan','F'),(65,'Lasbela','Balochistan','F'),(66,'Liari','Balochistan','F'),(67,'Loralai','Balochistan','F'),(68,'Mach','Balochistan','F'),(69,'Mand','Balochistan','T'),(70,'Manguchar','Balochistan','F'),(71,'Mashki Chah','Balochistan','F'),(72,'Maslti','Balochistan','F'),(73,'Mastung','Balochistan','F'),(74,'Mekhtar','Balochistan','F'),(75,'Merui','Balochistan','F'),(76,'Mianez','Balochistan','F'),(77,'Murgha Kibzai','Balochistan','F'),(78,'Musa Khel Bazar','Balochistan','F'),(79,'Nagha Kalat','Balochistan','F'),(80,'Nal','Balochistan','F'),(81,'Naseerabad','Balochistan','F'),(82,'Nauroz Kalat','Balochistan','F'),(83,'Nur Gamma','Balochistan','F'),(84,'Nushki','Balochistan','F'),(85,'Nuttal','Balochistan','F'),(86,'Ormara','Balochistan','F'),(87,'Palantuk','Balochistan','F'),(88,'Panjgur','Balochistan','F'),(89,'Pasni','Balochistan','F'),(90,'Piharak','Balochistan','F'),(91,'Pishin','Balochistan','F'),(92,'Qamruddin Karez','Balochistan','F'),(93,'Qila Abdullah','Balochistan','F'),(94,'Qila Ladgasht','Balochistan','F'),(95,'Qila Safed','Balochistan','F'),(96,'Qila Saifullah','Balochistan','F'),(97,'Quetta','Balochistan','F'),(98,'Rakhni','Balochistan','F'),(99,'Robat Thana','Balochistan','F'),(100,'Rodkhan','Balochistan','F'),(101,'Saindak','Balochistan','F'),(102,'Sanjawi','Balochistan','F'),(103,'Saruna','Balochistan','F'),(104,'Shabaz Kalat','Balochistan','F'),(105,'Shahpur','Balochistan','F'),(106,'Sharam Jogizai','Balochistan','F'),(107,'Shingar','Balochistan','F'),(108,'Shorap','Balochistan','F'),(109,'Sibi','Balochistan','F'),(110,'Sonmiani','Balochistan','F'),(111,'Spezand','Balochistan','F'),(112,'Spintangi','Balochistan','F'),(113,'Sui','Balochistan','F'),(114,'Suntsar','Balochistan','F'),(115,'Surab','Balochistan','F'),(116,'Thalo','Balochistan','F'),(117,'Tump','Balochistan','F'),(118,'Turbat','Balochistan','F'),(119,'Umarao','Balochistan','F'),(120,'pirMahal','Balochistan','F'),(121,'Uthal','Balochistan','F'),(122,'Vitakri','Balochistan','F'),(123,'Wadh','Balochistan','F'),(124,'Washap','Balochistan','F'),(125,'Wasjuk','Balochistan','F'),(126,'Yakmach','Balochistan','F'),(127,'Zhob','Balochistan','F'),(128,'Astor','Gilgit Baltistan','F'),(129,'Baramula','Gilgit Baltistan','F'),(130,'Hunza','Gilgit Baltistan','F'),(131,'Gilgit','Gilgit Baltistan','F'),(132,'Nagar','Gilgit Baltistan','F'),(133,'Skardu','Gilgit Baltistan','T'),(134,'Shangrila','Gilgit Baltistan','F'),(135,'Shandur','Gilgit Baltistan','F'),(136,'Bajaur','Federally Administered Tribal Areas','F'),(137,'Hangu','Federally Administered Tribal Areas','F'),(138,'Malakand','Federally Administered Tribal Areas','F'),(139,'Miram Shah','Federally Administered Tribal Areas','F'),(140,'Mohmand','Federally Administered Tribal Areas','F'),(141,'Khyber','Federally Administered Tribal Areas','F'),(142,'Kurram','Federally Administered Tribal Areas','F'),(143,'North Waziristan','Federally Administered Tribal Areas','F'),(144,'South Waziristan','Federally Administered Tribal Areas','F'),(145,'Wana','Federally Administered Tribal Areas','F'),(146,'Abbottabad','Khyber Pakhtunkhwa','F'),(147,'Ayubia','Khyber Pakhtunkhwa','F'),(148,'Adezai','Khyber Pakhtunkhwa','F'),(149,'Banda Daud Shah','Khyber Pakhtunkhwa','F'),(150,'Bannu','Khyber Pakhtunkhwa','F'),(151,'Batagram','Khyber Pakhtunkhwa','F'),(152,'Birote','Khyber Pakhtunkhwa','F'),(153,'Buner','Khyber Pakhtunkhwa','F'),(154,'Chakdara','Khyber Pakhtunkhwa','F'),(155,'Charsadda','Khyber Pakhtunkhwa','F'),(156,'Chitral','Khyber Pakhtunkhwa','F'),(157,'Dargai','Khyber Pakhtunkhwa','F'),(158,'Darya Khan','Khyber Pakhtunkhwa','F'),(159,'Dera Ismail Khan','Khyber Pakhtunkhwa','F'),(160,'Drasan','Khyber Pakhtunkhwa','F'),(161,'Drosh','Khyber Pakhtunkhwa','F'),(162,'Hangu','Khyber Pakhtunkhwa','F'),(163,'Haripur','Khyber Pakhtunkhwa','F'),(164,'Kalam','Khyber Pakhtunkhwa','F'),(165,'Karak','Khyber Pakhtunkhwa','F'),(166,'Khanaspur','Khyber Pakhtunkhwa','F'),(167,'Kohat','Khyber Pakhtunkhwa','F'),(168,'Kohistan','Khyber Pakhtunkhwa','F'),(169,'Lakki Marwat','Khyber Pakhtunkhwa','F'),(170,'Latamber','Khyber Pakhtunkhwa','F'),(171,'Lower Dir','Khyber Pakhtunkhwa','F'),(172,'Madyan','Khyber Pakhtunkhwa','F'),(173,'Malakand','Khyber Pakhtunkhwa','F'),(174,'Mansehra','Khyber Pakhtunkhwa','F'),(175,'Mardan','Khyber Pakhtunkhwa','F'),(176,'Mastuj','Khyber Pakhtunkhwa','F'),(177,'Mongora','Khyber Pakhtunkhwa','F'),(178,'Nowshera','Khyber Pakhtunkhwa','F'),(179,'Paharpur','Khyber Pakhtunkhwa','F'),(180,'Peshawar','Khyber Pakhtunkhwa','F'),(181,'Saidu Sharif','Khyber Pakhtunkhwa','F'),(182,'Shangla','Khyber Pakhtunkhwa','F'),(183,'Sakesar','Khyber Pakhtunkhwa','F'),(184,'Swabi','Khyber Pakhtunkhwa','F'),(185,'Swat','Khyber Pakhtunkhwa','F'),(186,'Tangi','Khyber Pakhtunkhwa','F'),(187,'Tank','Khyber Pakhtunkhwa','F'),(188,'Thall','Khyber Pakhtunkhwa','F'),(189,'Tordher','Khyber Pakhtunkhwa','F'),(190,'Upper Dir','Khyber Pakhtunkhwa','F'),(191,'Ahmedpur East','Punjab','F'),(192,'Ahmed Nager Chatha','Punjab','F'),(193,'Ali Pur','Punjab','T'),(194,'Arifwala','Punjab','F'),(195,'Attock','Punjab','F'),(196,'Basti Malook','Punjab','F'),(197,'Bhagalchur','Punjab','F'),(198,'Bhalwal','Punjab','F'),(199,'Bahawalnagar','Punjab','F'),(200,'Bahawalpur','Punjab','F'),(201,'Bhaipheru','Punjab','F'),(202,'Bhakkar','Punjab','F'),(203,'Burewala','Punjab','F'),(204,'Chailianwala','Punjab','F'),(205,'Chakwal','Punjab','F'),(206,'Chichawatni','Punjab','F'),(207,'Chiniot','Punjab','F'),(208,'Chowk Azam','Punjab','F'),(209,'Chowk Sarwar Shaheed','Punjab','F'),(210,'Daska','Punjab','F'),(211,'Darya Khan','Punjab','F'),(212,'Dera Ghazi Khan','Punjab','F'),(213,'Derawar Fort','Punjab','F'),(214,'Dhaular','Punjab','F'),(215,'Dina City','Punjab','F'),(216,'Dinga','Punjab','F'),(217,'Dipalpur','Punjab','F'),(218,'Faisalabad','Punjab','F'),(219,'Fateh Jang','Punjab','F'),(220,'Gadar','Punjab','F'),(221,'Ghakhar Mandi','Punjab','F'),(222,'Gujranwala','Punjab','F'),(223,'Gujrat','Punjab','F'),(224,'Gujar Khan','Punjab','F'),(225,'Hafizabad','Punjab','F'),(226,'Haroonabad','Punjab','F'),(227,'Hasilpur','Punjab','F'),(228,'Haveli Lakha','Punjab','F'),(229,'Jampur','Punjab','F'),(230,'Jhang','Punjab','F'),(231,'Jhelum','Punjab','F'),(232,'Kalabagh','Punjab','F'),(233,'Karor Lal Esan','Punjab','F'),(234,'Kasur','Punjab','F'),(235,'Kamalia','Punjab','F'),(236,'Kamokey','Punjab','T'),(237,'Khanewal','Punjab','F'),(238,'Khanpur','Punjab','F'),(239,'Kharian','Punjab','F'),(240,'Khushab','Punjab','F'),(241,'Kot Addu','Punjab','F'),(242,'Jahania','Punjab','F'),(243,'Jalla Araain','Punjab','F'),(244,'Jauharabad','Punjab','F'),(245,'Laar','Punjab','F'),(246,'Lahore','Punjab','F'),(247,'Lalamusa','Punjab','F'),(248,'Layyah','Punjab','F'),(249,'Lodhran','Punjab','F'),(250,'Mamoori','Punjab','F'),(251,'Mandi Bahauddin','Punjab','F'),(252,'Makhdoom Aali','Punjab','F'),(253,'Mandi Warburton','Punjab','F'),(254,'Mailsi','Punjab','F'),(255,'Mian Channu','Punjab','T'),(256,'Minawala','Punjab','F'),(257,'Mianwali','Punjab','F'),(258,'Multan','Punjab','F'),(259,'Murree','Punjab','F'),(260,'Muridke','Punjab','F'),(261,'Muzaffargarh','Punjab','F'),(262,'Narowal','Punjab','F'),(263,'Okara','Punjab','F'),(264,'Renala Khurd','Punjab','F'),(265,'Rajan Pur','Punjab','F'),(266,'Pak Pattan','Punjab','F'),(267,'Panjgur','Punjab','F'),(268,'Pattoki','Punjab','F'),(269,'Pirmahal','Punjab','F'),(270,'Qila Didar Singh','Punjab','F'),(271,'Rabwah','Punjab','F'),(272,'Raiwind','Punjab','F'),(273,'Rajan Pur','Punjab','F'),(274,'Rahim Yar Khan','Punjab','F'),(275,'Rawalpindi','Punjab','F'),(276,'Rohri','Punjab','F'),(277,'Sadiqabad','Punjab','F'),(278,'Safdar Abad','Punjab','F'),(279,'Sahiwal','Punjab','F'),(280,'Sangla Hill','Punjab','F'),(281,'Samberial','Punjab','F'),(282,'Sarai Alamgir','Punjab','F'),(283,'Sargodha','Punjab','F'),(284,'Shakargarh','Punjab','F'),(285,'Shafqat Shaheed Chowk','Punjab','F'),(286,'Sheikhupura','Punjab','F'),(287,'Sialkot','Punjab','F'),(288,'Sohawa','Punjab','F'),(289,'Sooianwala','Punjab','F'),(290,'Sundar','Punjab','T'),(291,'Talagang','Punjab','F'),(292,'Tarbela','Punjab','F'),(293,'Takhtbai','Punjab','F'),(294,'Taxila','Punjab','F'),(295,'Toba Tek Singh','Punjab','F'),(296,'Vehari','Punjab','F'),(297,'Wah Cantonment','Punjab','F'),(298,'Wazirabad','Punjab','F'),(299,'Ali Bandar','Sindh','F'),(300,'Baden','Sindh','F'),(301,'Chachro','Sindh','F'),(302,'Dadu','Sindh','F'),(303,'Digri','Sindh','F'),(304,'Diplo','Sindh','F'),(305,'Dokri','Sindh','F'),(306,'Gadra','Sindh','F'),(307,'Ghanian','Sindh','F'),(308,'Ghauspur','Sindh','T'),(309,'Ghotki','Sindh','F'),(310,'Hala','Sindh','F'),(311,'Hyderabad','Sindh','F'),(312,'Islamkot','Sindh','F'),(313,'Jacobabad','Sindh','F'),(314,'Jamesabad','Sindh','F'),(315,'Jamshoro','Sindh','F'),(316,'Janghar','Sindh','F'),(317,'Jati','Sindh','F'),(318,'Jhudo','Sindh','F'),(319,'Jungshahi','Sindh','F'),(320,'Kandiaro','Sindh','F'),(321,'Karachi','Sindh','F'),(322,'Kashmor','Sindh','T'),(323,'Keti Bandar','Sindh','F'),(324,'Khairpur','Sindh','F'),(325,'Khora','Sindh','F'),(326,'Klupro','Sindh','F'),(327,'Khokhropur','Sindh','F'),(328,'Korangi','Sindh','F'),(329,'Kotri','Sindh','F'),(330,'Kot Sarae','Sindh','F'),(331,'Larkana','Sindh','F'),(332,'Lund','Sindh','F'),(333,'Mathi','Sindh','F'),(334,'Matiari','Sindh','F'),(335,'Mehar','Sindh','F'),(336,'Mirpur Batoro','Sindh','F'),(337,'Mirpur Khas','Sindh','F'),(338,'Mirpur Sakro','Sindh','F'),(339,'Mithi','Sindh','F'),(340,'Mithani','Sindh','F'),(341,'Moro','Sindh','F'),(342,'Nagar Parkar','Sindh','F'),(343,'Naushara','Sindh','F'),(344,'Naudero','Sindh','F'),(345,'Noushero Feroz','Sindh','F'),(346,'Nawabshah','Sindh','F'),(347,'Nazimabad','Sindh','F'),(348,'Naokot','Sindh','F'),(349,'Pendoo','Sindh','F'),(350,'Pokran','Sindh','F'),(351,'Qambar','Sindh','F'),(352,'Qazi Ahmad','Sindh','F'),(353,'Ranipur','Sindh','F'),(354,'Ratodero','Sindh','F'),(355,'Rohri','Sindh','F'),(356,'Saidu Sharif','Sindh','F'),(357,'Sakrand','Sindh','F'),(358,'Sanghar','Sindh','F'),(359,'Shadadkhot','Sindh','F'),(360,'Shahbandar','Sindh','F'),(361,'Shahdadpur','Sindh','F'),(362,'Shahpur Chakar','Sindh','F'),(363,'Shikarpur','Sindh','F'),(364,'Sujawal','Sindh','F'),(365,'Sukkur','Sindh','F'),(366,'Tando Adam','Sindh','F'),(367,'Tando Allahyar','Sindh','F'),(368,'Tando Bago','Sindh','F'),(369,'Tar Ahamd Rind','Sindh','F'),(370,'Thatta','Sindh','F'),(371,'Tujal','Sindh','F'),(372,'Umarkot','Sindh','F'),(373,'Veirwaro','Sindh','F'),(374,'Warah','Sindh','F'),(375,'Islamabad','Punjab','F'),(376,'Donga Bonga','Punjab','F');
/*!40000 ALTER TABLE `financials_city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_class`
--

DROP TABLE IF EXISTS `financials_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_class` (
  `cla_id` int(11) NOT NULL AUTO_INCREMENT,
  `cla_title` varchar(250) NOT NULL,
  `cla_remarks` varchar(500) DEFAULT 'NULL',
  `cla_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `cla_createdby` int(11) DEFAULT NULL,
  `cla_day_end_id` int(11) DEFAULT NULL,
  `cla_day_end_date` date DEFAULT NULL,
  `cla_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `cla_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `cla_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `cla_delete_status` int(11) DEFAULT 0,
  `cla_deleted_by` int(11) DEFAULT NULL,
  `cla_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cla_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_class`
--

LOCK TABLES `financials_class` WRITE;
/*!40000 ALTER TABLE `financials_class` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_coa_heads`
--

DROP TABLE IF EXISTS `financials_coa_heads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_coa_heads` (
  `coa_id` int(11) NOT NULL AUTO_INCREMENT,
  `coa_code` int(11) NOT NULL,
  `coa_head_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `coa_parent` int(11) NOT NULL,
  `coa_level` int(11) NOT NULL,
  `coa_datetime` timestamp NULL DEFAULT current_timestamp(),
  `coa_remarks` varchar(500) DEFAULT NULL,
  `coa_system_generated` int(11) DEFAULT 0,
  `coa_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `coa_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `coa_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `coa_delete_status` int(11) DEFAULT 0,
  `coa_deleted_by` int(11) DEFAULT NULL,
  `coa_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`coa_id`),
  UNIQUE KEY `coa_code` (`coa_code`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_coa_heads`
--

LOCK TABLES `financials_coa_heads` WRITE;
/*!40000 ALTER TABLE `financials_coa_heads` DISABLE KEYS */;
INSERT INTO `financials_coa_heads` VALUES (1,1,'ASSETS',0,1,'2021-10-29 06:56:26',NULL,1,'','','2021-10-29 11:56:26',0,NULL,0),(2,2,'LIABILITIES',0,1,'2021-10-29 06:56:26',NULL,1,'','','2021-10-29 11:56:26',0,NULL,0),(3,3,'REVENUE',0,1,'2021-10-29 06:56:26',NULL,1,'','','2021-10-29 11:56:26',0,NULL,0),(4,4,'EXPENSES',0,1,'2021-10-29 06:56:26',NULL,1,'','','2021-10-29 11:56:26',0,NULL,0),(5,5,'EQUITY',0,1,'2021-10-29 06:56:26',NULL,1,'','','2021-10-29 11:56:26',0,NULL,0),(6,110,'Current Asset',1,2,'2021-10-29 06:56:26',NULL,1,'','','2021-10-29 11:56:26',0,NULL,0),(7,111,'Fixed Asset',1,2,'2021-10-29 06:56:26',NULL,1,'','','2021-10-29 11:56:26',0,NULL,0),(8,112,'Other Assets',1,2,'2021-10-29 06:56:26',NULL,1,'','','2021-10-29 11:56:26',0,NULL,0),(9,11010,'Cash',110,3,'2021-10-29 06:56:26',NULL,1,'','','2021-10-29 11:56:26',0,NULL,0),(10,11011,'Stock',110,3,'2021-10-29 06:56:26',NULL,1,'','','2021-10-29 11:56:26',0,NULL,0),(11,11012,'Bank',110,3,'2021-10-29 06:56:27',NULL,1,'','','2021-10-29 11:56:27',0,NULL,0),(12,11013,'Account Receivables',110,3,'2021-10-29 06:56:27',NULL,1,'','','2021-10-29 11:56:27',0,NULL,0),(13,11014,'Prepaid Expenses',110,3,'2021-10-29 06:56:27',NULL,1,'','','2021-10-29 11:56:27',0,NULL,0),(14,11015,'Tax Receivables',110,3,'2021-10-29 06:56:27',NULL,1,'','','2021-10-29 11:56:27',0,NULL,0),(15,11016,'Walk In Customer',110,3,'2021-10-29 06:56:27',NULL,1,'','','2021-10-29 11:56:27',0,NULL,0),(16,11017,'Party Claims',110,3,'2021-10-29 06:56:27',NULL,1,'','','2021-10-29 11:56:27',0,NULL,0),(17,11018,'Credit Card Machine',110,3,'2021-10-29 06:56:27',NULL,1,'','','2021-10-29 11:56:27',0,NULL,0),(18,11210,'Suspenses',112,3,'2021-10-29 06:56:27',NULL,1,'','','2021-10-29 11:56:27',0,NULL,0),(19,210,'Current Liability',2,2,'2021-10-29 06:56:27',NULL,1,'','','2021-10-29 11:56:27',0,NULL,0),(20,211,'Other Liability',2,2,'2021-10-29 06:56:27',NULL,1,'','','2021-10-29 11:56:27',0,NULL,0),(21,21010,'Account Payables',210,3,'2021-10-29 06:56:28',NULL,1,'','','2021-10-29 11:56:28',0,NULL,0),(22,21011,'Taxes Payables',210,3,'2021-10-29 06:56:28',NULL,1,'','','2021-10-29 11:56:28',0,NULL,0),(23,21012,'Purchaser',210,3,'2021-10-29 06:56:28',NULL,1,'','','2021-10-29 11:56:28',0,NULL,0),(24,21110,'Suspenses',211,3,'2021-10-29 06:56:28',NULL,1,'','','2021-10-29 11:56:28',0,NULL,0),(25,310,'Income From Sales',3,2,'2021-10-29 06:56:28',NULL,1,'','','2021-10-29 11:56:28',0,NULL,0),(26,311,'Other Incomes',3,2,'2021-10-29 06:56:28',NULL,1,'','','2021-10-29 11:56:28',0,NULL,0),(27,31010,'Sales Revenue',310,3,'2021-10-29 06:56:28',NULL,1,'','','2021-10-29 11:56:28',0,NULL,0),(28,31110,'Services Revenue',311,3,'2021-10-29 06:56:28',NULL,1,'','','2021-10-29 11:56:28',0,NULL,0),(29,31111,'Margins',311,3,'2021-10-29 06:56:28',NULL,1,'','','2021-10-29 11:56:28',0,NULL,0),(30,31112,'Amortization',311,3,'2021-10-29 06:56:28',NULL,1,'','','2021-10-29 11:56:28',0,NULL,0),(31,410,'Stock Expenses',4,2,'2021-10-29 06:56:29',NULL,1,'','','2021-10-29 11:56:29',0,NULL,0),(32,411,'CGS Expenses',4,2,'2021-10-29 06:56:29',NULL,1,'','','2021-10-29 11:56:29',0,NULL,0),(33,412,'Salaries Expenses',4,2,'2021-10-29 06:56:29',NULL,1,'','','2021-10-29 11:56:29',0,NULL,0),(34,413,'Service Charges',4,2,'2021-10-29 06:56:29',NULL,1,'','','2021-10-29 11:56:29',0,NULL,0),(35,414,'Operating Expenses',4,2,'2021-10-29 06:56:29',NULL,1,'','','2021-10-29 11:56:29',0,NULL,0),(36,415,'Sales Discounts',4,2,'2021-10-29 06:56:29',NULL,1,'','','2021-10-29 11:56:29',0,NULL,0),(37,41010,'Loss & Recover',410,3,'2021-10-29 06:56:29',NULL,1,'','','2021-10-29 11:56:29',0,NULL,0),(38,41011,'Bonus Expenses',410,3,'2021-10-29 06:56:29',NULL,1,'','','2021-10-29 11:56:29',0,NULL,0),(39,41110,'Purchases',411,3,'2021-10-29 06:56:29',NULL,1,'','','2021-10-29 11:56:29',0,NULL,0),(40,41111,'Depreciation',411,3,'2021-10-29 06:56:29',NULL,1,'','','2021-10-29 11:56:29',0,NULL,0),(41,41112,'Claims',411,3,'2021-10-29 06:56:30',NULL,1,'','','2021-10-29 11:56:30',0,NULL,0),(42,41310,'Bank Service Charges',413,3,'2021-10-29 06:56:30',NULL,1,'','','2021-10-29 11:56:30',0,NULL,0),(43,41410,'Depreciation',414,3,'2021-10-29 06:56:31',NULL,1,'','','2021-10-29 11:56:31',0,NULL,0),(44,41411,'Discounts',414,3,'2021-10-29 06:56:31',NULL,1,'','','2021-10-29 11:56:31',0,NULL,0),(45,41510,'Discounts',415,3,'2021-10-29 06:56:31',NULL,1,'','','2021-10-29 11:56:31',0,NULL,0),(46,41511,'Trade Discounts',415,3,'2021-10-29 06:56:31',NULL,1,'','','2021-10-29 11:56:31',0,NULL,0),(47,510,'Owner\'s Equity',5,2,'2021-10-29 06:56:31',NULL,1,'','','2021-10-29 11:56:31',0,NULL,0),(48,511,'Investoer\'s Equity',5,2,'2021-10-29 06:56:31',NULL,1,'','','2021-10-29 11:56:31',0,NULL,0),(49,512,'Other Equity',5,2,'2021-10-29 06:56:31',NULL,1,'','','2021-10-29 11:56:31',0,NULL,0),(50,51210,'Undistributed Equity',512,3,'2021-10-29 06:56:31',NULL,1,'','','2021-10-29 11:56:31',0,NULL,0),(51,41412,'Salaries Exp (NEW In OE)',414,3,'2021-10-29 06:56:31',NULL,1,'','','2021-10-29 11:56:31',0,NULL,0),(52,11019,'Staff Loan',110,3,'2021-10-29 06:56:32',NULL,1,'','','2021-10-29 11:56:32',0,NULL,0),(53,41113,'Stock Adjustment',411,3,'2021-10-29 06:56:32',NULL,1,'','','2021-10-29 11:56:32',0,NULL,0),(54,41012,'Consumed & Produced',410,3,'2021-10-29 06:56:32',NULL,1,'','','2021-10-29 11:56:32',0,NULL,0),(55,11110,'Office Equipment',111,3,'2021-10-29 08:27:53','',0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:27:53',0,NULL,0),(56,51010,'Ahmad Hasan',510,3,'2021-10-29 08:30:41','',0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:30:41',0,NULL,0),(57,51011,'Shoaib',510,3,'2021-10-30 06:41:59','',0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 11:41:59',0,NULL,0);
/*!40000 ALTER TABLE `financials_coa_heads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_company_delivery`
--

DROP TABLE IF EXISTS `financials_company_delivery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_company_delivery` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_delivery_option_id` int(11) NOT NULL,
  `cd_employee_id` int(11) NOT NULL,
  `cd_remarks` text DEFAULT NULL,
  `cd_stock_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_company_delivery`
--

LOCK TABLES `financials_company_delivery` WRITE;
/*!40000 ALTER TABLE `financials_company_delivery` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_company_delivery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_company_info`
--

DROP TABLE IF EXISTS `financials_company_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_company_info` (
  `ci_id` int(11) NOT NULL AUTO_INCREMENT,
  `ci_name` varchar(100) NOT NULL,
  `ci_address` text NOT NULL,
  `ci_email` varchar(100) NOT NULL,
  `ci_ptcl_number` varchar(45) DEFAULT NULL,
  `ci_mobile_numer` varchar(45) DEFAULT NULL,
  `ci_whatsapp_number` varchar(45) DEFAULT NULL,
  `ci_fax_number` varchar(45) DEFAULT NULL,
  `ci_logo` varchar(1000) DEFAULT NULL,
  `info_bx` varchar(30) DEFAULT 'min',
  `ci_ip_adrs` varchar(255) DEFAULT '',
  `ci_brwsr_info` varchar(4000) DEFAULT '',
  `ci_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `ci_facebook` text DEFAULT NULL,
  `ci_twitter` text DEFAULT NULL,
  `ci_youtube` text DEFAULT NULL,
  `ci_google` text DEFAULT NULL,
  `ci_instagram` text DEFAULT NULL,
  `warning` varchar(500) NOT NULL,
  PRIMARY KEY (`ci_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_company_info`
--

LOCK TABLES `financials_company_info` WRITE;
/*!40000 ALTER TABLE `financials_company_info` DISABLE KEYS */;
INSERT INTO `financials_company_info` VALUES (1,'Softagics','Multan','support@digitalmunshi.com',NULL,NULL,NULL,NULL,'http://www.pos.jadeedmunshi.com/storage/app//company_logo/50428.png','min','','','2021-10-29 11:56:22',NULL,NULL,NULL,NULL,NULL,'*Please Execute day end before April 2021');
/*!40000 ALTER TABLE `financials_company_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_consumed_stock`
--

DROP TABLE IF EXISTS `financials_consumed_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_consumed_stock` (
  `cs_id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_psa_id` int(11) DEFAULT NULL,
  `cs_pro_code` varchar(1000) DEFAULT NULL,
  `cs_pro_title` varchar(1000) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `cs_warehouse_id` int(11) DEFAULT NULL,
  `cs_warehouse_name` varchar(500) DEFAULT NULL,
  `cs_remarks` varchar(1000) DEFAULT NULL,
  `cs_quantity` decimal(50,3) DEFAULT NULL,
  `cs_rate` decimal(50,2) DEFAULT NULL,
  `cs_amount` decimal(50,2) DEFAULT NULL,
  `cs_uom` varchar(255) DEFAULT NULL,
  `cs_scale_size` int(11) DEFAULT NULL,
  `cs_status` varchar(50) DEFAULT 'Consumed',
  PRIMARY KEY (`cs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_consumed_stock`
--

LOCK TABLES `financials_consumed_stock` WRITE;
/*!40000 ALTER TABLE `financials_consumed_stock` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_consumed_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_convert_quantity`
--

DROP TABLE IF EXISTS `financials_convert_quantity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_convert_quantity` (
  `cq_id` int(11) NOT NULL AUTO_INCREMENT,
  `cq_pro_code` varchar(500) NOT NULL,
  `cq_warehouse` int(11) DEFAULT NULL,
  `cq_pro_title` varchar(500) NOT NULL,
  `cq_scale_size` tinyint(4) DEFAULT NULL,
  `cq_quantity` decimal(50,3) NOT NULL,
  `cq_remarks` varchar(1000) NOT NULL,
  `cq_convert_quantity` tinyint(4) NOT NULL,
  `cq_convert_unit` tinyint(4) NOT NULL,
  `cq_user_id` int(11) NOT NULL,
  `cq_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `cq_day_end_id` int(11) NOT NULL,
  `cq_day_end_date` date NOT NULL,
  PRIMARY KEY (`cq_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_convert_quantity`
--

LOCK TABLES `financials_convert_quantity` WRITE;
/*!40000 ALTER TABLE `financials_convert_quantity` DISABLE KEYS */;
INSERT INTO `financials_convert_quantity` VALUES (1,'300',1,'Lays Rs. 5',12,1.000,'fdjhfjh',1,1,1,'2021-11-06 08:55:41',1,'2021-09-29'),(2,'400',1,'Daal Chawal',40,41.000,'dcghgchcjh',1,3,1,'2021-11-09 11:58:04',1,'2021-09-29'),(3,'400',1,'Daal Chawal',40,82.000,'jh',1,3,1,'2021-11-09 11:58:43',1,'2021-09-29');
/*!40000 ALTER TABLE `financials_convert_quantity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_country`
--

DROP TABLE IF EXISTS `financials_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_country` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_country`
--

LOCK TABLES `financials_country` WRITE;
/*!40000 ALTER TABLE `financials_country` DISABLE KEYS */;
INSERT INTO `financials_country` VALUES (1,'Afghanistan'),(2,'Albania'),(3,'Algeria'),(4,'American Samoa'),(5,'Andorra'),(6,'Angola'),(7,'Anguilla'),(8,'Antigua & Barbuda'),(9,'Argentina'),(10,'Armenia'),(11,'Aruba'),(12,'Australia'),(13,'Austria'),(14,'Azerbaijan'),(15,'Bahamas'),(16,'Bahrain'),(17,'Bangladesh'),(18,'Barbados'),(19,'Belarus'),(20,'Belgium'),(21,'Belize'),(22,'Benin'),(23,'Bermuda'),(24,'Bhutan'),(25,'Bolivia'),(26,'Bonaire'),(27,'Bosnia & Herzegovina'),(28,'Botswana'),(29,'Brazil'),(30,'British Indian Ocean Ter'),(31,'Brunei'),(32,'Bulgaria'),(33,'Burkina Faso'),(34,'Burundi'),(35,'Cambodia'),(36,'Cameroon'),(37,'Canada'),(38,'Canary Islands'),(39,'Cape Verde'),(40,'Cayman Islands'),(41,'Central African Republic'),(42,'Chad'),(43,'Channel Islands'),(44,'Chile'),(45,'China'),(46,'Christmas Island'),(47,'Cocos Island'),(48,'Colombia'),(49,'Comoros'),(50,'Congo'),(51,'Cook Islands'),(52,'Costa Rica'),(53,'Cote DIvoire'),(54,'Croatia'),(55,'Cuba'),(56,'Curacao'),(57,'Cyprus'),(58,'Czech Republic'),(59,'Denmark'),(60,'Djibouti'),(61,'Dominica'),(62,'Dominican Republic'),(63,'East Timor'),(64,'Ecuador'),(65,'Egypt'),(66,'El Salvador'),(67,'Equatorial Guinea'),(68,'Eritrea'),(69,'Estonia'),(70,'Ethiopia'),(71,'Falkland Islands'),(72,'Faroe Islands'),(73,'Fiji'),(74,'Finland'),(75,'France'),(76,'French Guiana'),(77,'French Polynesia'),(78,'French Southern Ter'),(79,'Gabon'),(80,'Gambia'),(81,'Georgia'),(82,'Germany'),(83,'Ghana'),(84,'Gibraltar'),(85,'Great Britain'),(86,'Greece'),(87,'Greenland'),(88,'Grenada'),(89,'Guadeloupe'),(90,'Guam'),(91,'Guatemala'),(92,'Guinea'),(93,'Guyana'),(94,'Haiti'),(95,'Hawaii'),(96,'Honduras'),(97,'Hong Kong'),(98,'Hungary'),(99,'Iceland'),(100,'Indonesia'),(101,'India'),(102,'Iran'),(103,'Iraq'),(104,'Ireland'),(105,'Isle of Man'),(106,'Israel'),(107,'Italy'),(108,'Jamaica'),(109,'Japan'),(110,'Jordan'),(111,'Kazakhstan'),(112,'Kenya'),(113,'Kiribati'),(114,'Korea North'),(115,'Korea South'),(116,'Kuwait'),(117,'Kyrgyzstan'),(118,'Laos'),(119,'Latvia'),(120,'Lebanon'),(121,'Lesotho'),(122,'Liberia'),(123,'Libya'),(124,'Liechtenstein'),(125,'Lithuania'),(126,'Luxembourg'),(127,'Macau'),(128,'Macedonia'),(129,'Madagascar'),(130,'Malaysia'),(131,'Malawi'),(132,'Maldives'),(133,'Mali'),(134,'Malta'),(135,'Marshall Islands'),(136,'Martinique'),(137,'Mauritania'),(138,'Mauritius'),(139,'Mayotte'),(140,'Mexico'),(141,'Midway Islands'),(142,'Moldova'),(143,'Monaco'),(144,'Mongolia'),(145,'Montserrat'),(146,'Morocco'),(147,'Mozambique'),(148,'Myanmar'),(149,'Nambia'),(150,'Nauru'),(151,'Nepal'),(152,'Netherlands Antilles'),(153,'Netherlands (Holland'),(154,'Nevis'),(155,'New Caledonia'),(156,'New Zealand'),(157,'Nicaragua'),(158,'Niger'),(159,'Nigeria'),(160,'Niue'),(161,'Norfolk Island'),(162,'Norway'),(163,'Oman'),(164,'Pakistan'),(165,'Palau Island'),(166,'Palestine'),(167,'Panama'),(168,'Papua New Guine'),(169,'Paraguay'),(170,'Peru'),(171,'Philippines'),(172,'Pitcairn Island'),(173,'Poland'),(174,'Portugal'),(175,'Puerto Rico'),(176,'Qatar'),(177,'Republic of Montenegro'),(178,'Republic of Serbia'),(179,'Reunion'),(180,'Romania'),(181,'Russia'),(182,'Rwanda'),(183,'St Barthelemy'),(184,'St Eustatius'),(185,'St Helena'),(186,'St Kitts-Nevis'),(187,'St Lucia'),(188,'St Maarten'),(189,'St Pierre & Miquelon'),(190,'St Vincent & Grenadines'),(191,'Saipan'),(192,'Samoa'),(193,'Samoa American'),(194,'San Marino'),(195,'Sao Tome & Principe'),(196,'Saudi Arabia'),(197,'Senegal'),(198,'Seychelles'),(199,'Sierra Leone'),(200,'Singapore'),(201,'Slovakia'),(202,'Slovenia'),(203,'Solomon Islands'),(204,'Somalia'),(205,'South Africa'),(206,'Spain'),(207,'Sri Lanka'),(208,'Sudan'),(209,'Suriname'),(210,'Swaziland'),(211,'Sweden'),(212,'Sweden'),(213,'Syria'),(214,'Tahiti'),(215,'Taiwan'),(216,'Tajikistan'),(217,'Tanzania'),(218,'Thailand'),(219,'Togo'),(220,'Tokelau'),(221,'Tonga'),(222,'Trinidad & Tobago'),(223,'Tunisia'),(224,'Turkey'),(225,'Turkmenistan'),(226,'Turks & Caicos Is'),(227,'Tuvalu'),(228,'Uganda'),(229,'United Kingdom'),(230,'Ukraine'),(231,'United Arab Emirates'),(232,'United States of America'),(233,'Uruguay'),(234,'Uzbekistan'),(235,'Vanuatu'),(236,'Vatican City State'),(237,'Venezuela'),(238,'Vietnam'),(239,'Virgin Islands (Brit)'),(240,'Virgin Islands (USA)'),(241,'Wake Island'),(242,'Wallis & Futana Is'),(243,'Yemen'),(244,'Zaire'),(245,'Zambia'),(246,'Zimbabwe');
/*!40000 ALTER TABLE `financials_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_courier_company`
--

DROP TABLE IF EXISTS `financials_courier_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_courier_company` (
  `cc_id` int(11) NOT NULL AUTO_INCREMENT,
  `cc_name` varchar(1000) NOT NULL,
  `cc_remarks` varchar(2000) NOT NULL DEFAULT '',
  `cc_user_id` int(11) NOT NULL,
  `cc_day_end_id` int(11) NOT NULL,
  `cc_day_end_date` date NOT NULL,
  `cc_ip_adrs` varchar(100) DEFAULT NULL,
  `cc_brwsr_info` varchar(4000) NOT NULL,
  `cc_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `cc_update_datetime` timestamp NULL DEFAULT current_timestamp(),
  `cc_delete_status` tinyint(4) DEFAULT 0,
  `cc_deleted_by` int(11) DEFAULT NULL,
  `cc_disabled` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_courier_company`
--

LOCK TABLES `financials_courier_company` WRITE;
/*!40000 ALTER TABLE `financials_courier_company` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_courier_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_courier_company_branches`
--

DROP TABLE IF EXISTS `financials_courier_company_branches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_courier_company_branches` (
  `ccb_id` int(11) NOT NULL AUTO_INCREMENT,
  `ccb_courier_id` int(11) NOT NULL,
  `ccb_branch_name` varchar(500) NOT NULL,
  `ccb_type` tinyint(4) NOT NULL,
  `ccb_city_id` int(11) NOT NULL,
  `ccb_address` varchar(1000) NOT NULL,
  `ccb_contact_num1` varchar(500) NOT NULL,
  `ccb_contact_num2` varchar(500) NOT NULL,
  PRIMARY KEY (`ccb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_courier_company_branches`
--

LOCK TABLES `financials_courier_company_branches` WRITE;
/*!40000 ALTER TABLE `financials_courier_company_branches` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_courier_company_branches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_courier_service`
--

DROP TABLE IF EXISTS `financials_courier_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_courier_service` (
  `cs_id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_courier_name` varchar(500) DEFAULT NULL,
  `cs_courier_id` int(11) DEFAULT NULL,
  `cs_slip` varchar(1000) DEFAULT NULL,
  `cs_slip_date` date DEFAULT NULL,
  `cs_booking_city` int(11) DEFAULT NULL,
  `cs_destination_city` int(11) DEFAULT NULL,
  `cs_remarks` text DEFAULT NULL,
  `cs_delivery_option_id` int(11) NOT NULL,
  `cs_stock_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_courier_service`
--

LOCK TABLES `financials_courier_service` WRITE;
/*!40000 ALTER TABLE `financials_courier_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_courier_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_credit_card_machine`
--

DROP TABLE IF EXISTS `financials_credit_card_machine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_credit_card_machine` (
  `ccm_id` int(11) NOT NULL AUTO_INCREMENT,
  `ccm_title` varchar(500) NOT NULL,
  `ccm_percentage` float NOT NULL,
  `ccm_merchant_id` varchar(1000) NOT NULL,
  `ccm_remarks` varchar(1000) DEFAULT NULL,
  `ccm_bank_code` int(11) NOT NULL,
  `ccm_credit_card_account_code` int(11) NOT NULL,
  `ccm_service_account_code` int(11) DEFAULT NULL,
  `ccm_created_by` int(11) NOT NULL,
  `ccm_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `ccm_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `ccm_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `ccm_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `ccm_delete_status` int(11) DEFAULT 0,
  `ccm_deleted_by` int(11) DEFAULT NULL,
  `ccm_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`ccm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_credit_card_machine`
--

LOCK TABLES `financials_credit_card_machine` WRITE;
/*!40000 ALTER TABLE `financials_credit_card_machine` DISABLE KEYS */;
INSERT INTO `financials_credit_card_machine` VALUES (1,'Fsdfsaf',2,'12','',110121,110182,413102,1,'2021-11-10 11:42:03','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 16:42:03',0,NULL,0);
/*!40000 ALTER TABLE `financials_credit_card_machine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_credit_card_machine_settlement`
--

DROP TABLE IF EXISTS `financials_credit_card_machine_settlement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_credit_card_machine_settlement` (
  `ccms_id` int(11) NOT NULL AUTO_INCREMENT,
  `ccms_cc_machine_id` int(11) NOT NULL,
  `ccms_date` date NOT NULL,
  `ccms_time` time NOT NULL,
  `ccms_batch_number` int(11) NOT NULL,
  `ccms_amount` decimal(50,2) NOT NULL,
  `ccms_remarks` varchar(4000) NOT NULL DEFAULT '',
  `ccms_user_id` int(11) NOT NULL,
  `ccms_day_end_id` int(11) NOT NULL,
  `ccms_day_end_date` date NOT NULL,
  `ccms_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `ccms_ip_adrs` varchar(100) NOT NULL,
  `ccms_brwsr_info` varchar(4000) NOT NULL,
  PRIMARY KEY (`ccms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_credit_card_machine_settlement`
--

LOCK TABLES `financials_credit_card_machine_settlement` WRITE;
/*!40000 ALTER TABLE `financials_credit_card_machine_settlement` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_credit_card_machine_settlement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_currency`
--

DROP TABLE IF EXISTS `financials_currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_currency` (
  `cur_id` int(11) NOT NULL AUTO_INCREMENT,
  `cur_title` varchar(250) NOT NULL,
  `cur_remarks` varchar(500) DEFAULT 'NULL',
  `cur_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `cur_createdby` int(11) DEFAULT NULL,
  `cur_day_end_id` int(11) DEFAULT NULL,
  `cur_day_end_date` date DEFAULT NULL,
  `cur_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `cur_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `cur_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `cur_delete_status` int(11) DEFAULT 0,
  `cur_deleted_by` int(11) DEFAULT NULL,
  `cur_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_currency`
--

LOCK TABLES `financials_currency` WRITE;
/*!40000 ALTER TABLE `financials_currency` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_database_backup`
--

DROP TABLE IF EXISTS `financials_database_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_database_backup` (
  `dbb_id` int(11) NOT NULL AUTO_INCREMENT,
  `dbb_file` text NOT NULL,
  `dbb_file_name` text NOT NULL,
  `dbb_prefix` text NOT NULL,
  `dbb_encrypted` text NOT NULL,
  `dbb_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `dbb_created_by` int(11) NOT NULL,
  `dbb_ip_adrs` varchar(255) DEFAULT NULL,
  `dbb_brwsr_info` varchar(4000) DEFAULT NULL,
  `dbb_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`dbb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_database_backup`
--

LOCK TABLES `financials_database_backup` WRITE;
/*!40000 ALTER TABLE `financials_database_backup` DISABLE KEYS */;
INSERT INTO `financials_database_backup` VALUES (1,'/media/home3/digitalmunshi/public_html/jadeedmunshi.com/pos/storage/dumps/backup-file-2021-11-10-18:34:32.sql','backup-file-2021-11-10-18:34:32.sql','','0','2021-11-10 13:34:35',1,NULL,NULL,'2021-11-10 18:34:35');
/*!40000 ALTER TABLE `financials_database_backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_day_end`
--

DROP TABLE IF EXISTS `financials_day_end`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_day_end` (
  `de_id` int(11) NOT NULL AUTO_INCREMENT,
  `de_status` varchar(50) DEFAULT 'LOCKED',
  `de_datetime_status` varchar(50) NOT NULL DEFAULT 'OPEN',
  `de_month_status` varchar(50) DEFAULT '',
  `de_datetime` date NOT NULL,
  `de_first_day_of_month` tinyint(4) DEFAULT 0,
  `de_last_day_of_month` tinyint(4) DEFAULT 0,
  `de_current_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `de_createdby` varchar(45) DEFAULT NULL,
  `de_report_url` varchar(1000) DEFAULT '',
  `de_month_end_report_url` varchar(1000) DEFAULT '',
  `de_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `de_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `de_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`de_id`),
  UNIQUE KEY `de_datetime` (`de_datetime`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_day_end`
--

LOCK TABLES `financials_day_end` WRITE;
/*!40000 ALTER TABLE `financials_day_end` DISABLE KEYS */;
INSERT INTO `financials_day_end` VALUES (1,'UN_LOCKED','OPEN','','2021-09-29',1,0,'2021-10-29 08:34:14','1','','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14');
/*!40000 ALTER TABLE `financials_day_end` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_day_end_config`
--

DROP TABLE IF EXISTS `financials_day_end_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_day_end_config` (
  `dec_id` int(11) NOT NULL AUTO_INCREMENT,
  `dec_cash_check` tinyint(4) NOT NULL DEFAULT 0,
  `dec_bank_check` tinyint(4) NOT NULL DEFAULT 0,
  `dec_product_check` tinyint(4) NOT NULL DEFAULT 0,
  `dec_warehouse_check` tinyint(4) NOT NULL DEFAULT 0,
  `dec_create_trial` tinyint(4) NOT NULL DEFAULT 0,
  `dec_create_closing_stock` tinyint(4) NOT NULL DEFAULT 0,
  `dec_create_cash_bank_closing` tinyint(4) NOT NULL DEFAULT 0,
  `dec_create_pnl` tinyint(4) NOT NULL DEFAULT 0,
  `dec_create_balance_sheet` tinyint(4) NOT NULL DEFAULT 0,
  `dec_create_pnl_distribution` tinyint(4) NOT NULL DEFAULT 0,
  `dec_user_id` int(11) NOT NULL,
  `dec_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `dec_updated_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`dec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_day_end_config`
--

LOCK TABLES `financials_day_end_config` WRITE;
/*!40000 ALTER TABLE `financials_day_end_config` DISABLE KEYS */;
INSERT INTO `financials_day_end_config` VALUES (1,1,1,1,1,2,2,2,2,2,2,1,'2021-10-29 08:30:55','2021-10-29 06:56:22');
/*!40000 ALTER TABLE `financials_day_end_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_delivery_challan`
--

DROP TABLE IF EXISTS `financials_delivery_challan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_delivery_challan` (
  `dc_id` int(11) NOT NULL AUTO_INCREMENT,
  `dc_party_code` int(11) NOT NULL,
  `dc_party_name` varchar(250) NOT NULL,
  `dc_pr_id` int(11) DEFAULT NULL,
  `dc_customer_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `dc_remarks` varchar(500) DEFAULT NULL,
  `dc_total_items` int(11) DEFAULT NULL,
  `dc_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `dc_day_end_id` int(11) DEFAULT NULL,
  `dc_day_end_date` date DEFAULT NULL,
  `dc_createdby` int(11) DEFAULT NULL,
  `dc_detail_remarks` text CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `dc_sale_person` int(11) DEFAULT 0,
  `dc_invoice_transcation_type` int(11) DEFAULT 1,
  `dc_sale_invoice_id` varchar(255) DEFAULT NULL,
  `dc_ip_adrs` varchar(255) NOT NULL,
  `dc_brwsr_info` varchar(4000) NOT NULL,
  `dc_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`dc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_delivery_challan`
--

LOCK TABLES `financials_delivery_challan` WRITE;
/*!40000 ALTER TABLE `financials_delivery_challan` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_delivery_challan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_delivery_challan_items`
--

DROP TABLE IF EXISTS `financials_delivery_challan_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_delivery_challan_items` (
  `dci_id` int(11) NOT NULL AUTO_INCREMENT,
  `dci_invoice_id` int(11) NOT NULL,
  `dci_product_code` varchar(500) NOT NULL,
  `dci_product_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `dci_remarks` varchar(500) NOT NULL,
  `dci_qty` decimal(50,3) NOT NULL DEFAULT 0.000,
  `dci_due_qty` decimal(50,3) DEFAULT NULL,
  `dci_uom` varchar(500) DEFAULT '',
  `dci_scale_size` tinyint(4) DEFAULT NULL,
  `dci_bonus_qty` decimal(50,3) DEFAULT 0.000,
  `dci_warehouse_id` int(11) NOT NULL DEFAULT 0,
  `dci_status` int(11) NOT NULL DEFAULT 0,
  `dci_created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`dci_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_delivery_challan_items`
--

LOCK TABLES `financials_delivery_challan_items` WRITE;
/*!40000 ALTER TABLE `financials_delivery_challan_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_delivery_challan_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_delivery_option`
--

DROP TABLE IF EXISTS `financials_delivery_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_delivery_option` (
  `do_id` int(11) NOT NULL AUTO_INCREMENT,
  `do_invoice_type` varchar(500) NOT NULL,
  `do_invoice_no` int(11) DEFAULT NULL,
  `do_party_code` int(11) NOT NULL,
  `do_party_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `do_date` date NOT NULL,
  `do_order_no` varchar(500) DEFAULT NULL,
  `do_delivery_order_no` varchar(500) DEFAULT NULL,
  `do_gate_pass` varchar(500) DEFAULT NULL,
  `do_collection_datetime` datetime NOT NULL,
  `do_remarks` text DEFAULT NULL,
  `do_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `do_createdby` int(11) NOT NULL,
  `do_day_end_id` int(11) NOT NULL,
  `do_day_end_date` datetime NOT NULL,
  `do_ip_adrs` varchar(500) NOT NULL,
  `do_brwsr_info` varchar(1000) NOT NULL,
  `do_type` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`do_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_delivery_option`
--

LOCK TABLES `financials_delivery_option` WRITE;
/*!40000 ALTER TABLE `financials_delivery_option` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_delivery_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_delivery_order`
--

DROP TABLE IF EXISTS `financials_delivery_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_delivery_order` (
  `do_id` int(11) NOT NULL AUTO_INCREMENT,
  `do_party_code` int(11) NOT NULL,
  `do_party_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `do_pr_id` int(11) DEFAULT NULL,
  `do_customer_name` varchar(250) DEFAULT NULL,
  `do_remarks` varchar(500) DEFAULT NULL,
  `do_total_items` int(11) DEFAULT NULL,
  `do_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `do_day_end_id` int(11) DEFAULT NULL,
  `do_day_end_date` date DEFAULT NULL,
  `do_createdby` int(11) DEFAULT NULL,
  `do_detail_remarks` text CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `do_sale_person` int(11) DEFAULT 0,
  `do_invoice_transcation_type` int(11) DEFAULT 1,
  `do_dc_id` varchar(150) DEFAULT NULL,
  `do_email` varchar(500) DEFAULT NULL,
  `do_whatsapp` varchar(150) DEFAULT NULL,
  `do_ip_adrs` varchar(255) NOT NULL,
  `do_brwsr_info` varchar(4000) NOT NULL,
  `do_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `do_status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`do_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_delivery_order`
--

LOCK TABLES `financials_delivery_order` WRITE;
/*!40000 ALTER TABLE `financials_delivery_order` DISABLE KEYS */;
INSERT INTO `financials_delivery_order` VALUES (1,110132,'ABD 436',NULL,'','',1,'2021-11-05 11:55:27',1,'2021-09-29',1,'Pepsi 1500 ML, 1&oS;',0,1,NULL,NULL,NULL,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 16:55:27',0),(2,210102,'Xyz 889',2,'','',6,'2021-11-05 11:55:48',1,'2021-09-29',1,'Pepsi 1500 ML, Total QTY = 6.000, Pack QTY = 1, Loose QTY = 0&oS;',0,1,NULL,NULL,NULL,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 16:55:48',0),(3,110132,'ABD 436',2,'','',1,'2021-11-05 12:15:35',1,'2021-09-29',1,'Lays Rs. 5, 1&oS;',0,1,NULL,NULL,NULL,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 17:15:35',0);
/*!40000 ALTER TABLE `financials_delivery_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_delivery_order_items`
--

DROP TABLE IF EXISTS `financials_delivery_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_delivery_order_items` (
  `doi_id` int(11) NOT NULL AUTO_INCREMENT,
  `doi_invoice_id` int(11) NOT NULL,
  `doi_product_code` varchar(500) NOT NULL,
  `doi_product_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `doi_remarks` varchar(500) NOT NULL,
  `doi_qty` decimal(50,3) NOT NULL DEFAULT 0.000,
  `doi_due_qty` decimal(50,3) DEFAULT NULL,
  `doi_uom` varchar(500) DEFAULT '',
  `doi_scale_size` tinyint(4) DEFAULT NULL,
  `doi_bonus_qty` decimal(50,3) DEFAULT 0.000,
  `doi_rate` decimal(50,2) DEFAULT NULL,
  `doi_amount` decimal(50,2) DEFAULT NULL,
  `doi_warehouse_id` int(11) NOT NULL DEFAULT 0,
  `doi_status` varchar(255) DEFAULT NULL,
  `doi_created_at` timestamp NULL DEFAULT current_timestamp(),
  `doi_pro_ser_status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`doi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_delivery_order_items`
--

LOCK TABLES `financials_delivery_order_items` WRITE;
/*!40000 ALTER TABLE `financials_delivery_order_items` DISABLE KEYS */;
INSERT INTO `financials_delivery_order_items` VALUES (1,1,'200','Pepsi 1500 ML','',1.000,1.000,'Pet',6,0.000,510.00,510.00,1,NULL,'2021-11-05 11:55:27',0),(2,2,'200','Pepsi 1500 ML','',6.000,6.000,'Pet',6,0.000,510.00,3060.00,1,NULL,'2021-11-05 11:55:48',0),(3,3,'300','Lays Rs. 5','',1.000,1.000,'Carton',12,0.000,54.00,54.00,1,NULL,'2021-11-05 12:15:35',0);
/*!40000 ALTER TABLE `financials_delivery_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_delivery_order_qty_hold_log`
--

DROP TABLE IF EXISTS `financials_delivery_order_qty_hold_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_delivery_order_qty_hold_log` (
  `doqh_id` int(11) NOT NULL AUTO_INCREMENT,
  `doqh_do_id` int(11) DEFAULT NULL,
  `doqh_warehouse_id` int(11) DEFAULT NULL,
  `doqh_product_code` varchar(255) DEFAULT NULL,
  `doqh_total_qty` decimal(50,3) DEFAULT NULL,
  `doqh_sale_qty` decimal(50,3) DEFAULT 0.000,
  `doqh_balance_qty` decimal(50,3) DEFAULT 0.000,
  `doqh_sale_invoice_id` int(11) DEFAULT NULL,
  `doqh_sale_tax_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`doqh_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_delivery_order_qty_hold_log`
--

LOCK TABLES `financials_delivery_order_qty_hold_log` WRITE;
/*!40000 ALTER TABLE `financials_delivery_order_qty_hold_log` DISABLE KEYS */;
INSERT INTO `financials_delivery_order_qty_hold_log` VALUES (1,1,1,'200',1.000,0.000,1.000,NULL,NULL),(2,2,1,'200',6.000,0.000,6.000,NULL,NULL),(3,3,1,'300',1.000,0.000,1.000,NULL,NULL);
/*!40000 ALTER TABLE `financials_delivery_order_qty_hold_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_dep_expense_voucher`
--

DROP TABLE IF EXISTS `financials_dep_expense_voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_dep_expense_voucher` (
  `dev_id` int(11) NOT NULL AUTO_INCREMENT,
  `dev_exp_uid` int(11) NOT NULL,
  `dev_acc_dep_uid` int(11) NOT NULL,
  `dev_remarks` varchar(1000) DEFAULT NULL,
  `dev_day_end_id` int(11) NOT NULL,
  `dev_day_end_date` date NOT NULL,
  `dev_user_id` int(11) NOT NULL,
  `dev_current_date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`dev_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_dep_expense_voucher`
--

LOCK TABLES `financials_dep_expense_voucher` WRITE;
/*!40000 ALTER TABLE `financials_dep_expense_voucher` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_dep_expense_voucher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_departments`
--

DROP TABLE IF EXISTS `financials_departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_departments` (
  `dep_id` int(11) NOT NULL AUTO_INCREMENT,
  `dep_account_code` int(11) DEFAULT NULL,
  `dep_title` varchar(250) NOT NULL,
  `dep_remarks` varchar(500) DEFAULT NULL,
  `dep_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `dep_createdby` int(11) DEFAULT NULL,
  `dep_day_end_id` int(11) DEFAULT NULL,
  `dep_day_end_date` date DEFAULT NULL,
  `dep_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `dep_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `dep_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `dep_delete_status` int(11) DEFAULT 0,
  `dep_deleted_by` int(11) DEFAULT NULL,
  `dep_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`dep_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_departments`
--

LOCK TABLES `financials_departments` WRITE;
/*!40000 ALTER TABLE `financials_departments` DISABLE KEYS */;
INSERT INTO `financials_departments` VALUES (1,NULL,'Initial Department',NULL,'2021-10-29 06:56:22',0,0,'2021-10-29','','','2021-10-29 11:56:22',0,NULL,0),(2,NULL,'Accounts','','2021-10-29 07:56:13',1,0,'2021-10-29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-29 12:56:13',0,NULL,0),(3,NULL,'Operations','','2021-10-29 07:56:23',1,0,'2021-10-29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-29 12:56:23',0,NULL,0);
/*!40000 ALTER TABLE `financials_departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_dip_reading`
--

DROP TABLE IF EXISTS `financials_dip_reading`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_dip_reading` (
  `dip_id` int(11) NOT NULL AUTO_INCREMENT,
  `dip_employee_id` int(11) DEFAULT NULL,
  `dip_reading_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `dip_reading` double DEFAULT NULL,
  `dip_tank_id` int(11) DEFAULT NULL,
  `dip_in_litre` double DEFAULT NULL,
  `dip_remarks` text DEFAULT NULL,
  `dip_createdby` int(11) NOT NULL,
  `dip_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dip_day_end_id` int(11) NOT NULL,
  `dip_day_end_date` date NOT NULL,
  `dip_pre_reading_datetime` timestamp NULL DEFAULT NULL,
  `dip_pre_reading` double DEFAULT NULL,
  `dip_pre_in_litre` double DEFAULT NULL,
  `dip_difference_in_mm` double DEFAULT NULL,
  `dip_difference_in_litre` double DEFAULT NULL,
  `dip_ip_adrs` varchar(255) DEFAULT NULL,
  `dip_brwsr_info` varchar(4000) DEFAULT NULL,
  `dip_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`dip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_dip_reading`
--

LOCK TABLES `financials_dip_reading` WRITE;
/*!40000 ALTER TABLE `financials_dip_reading` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_dip_reading` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_entry_log`
--

DROP TABLE IF EXISTS `financials_entry_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_entry_log` (
  `el_id` int(11) NOT NULL AUTO_INCREMENT,
  `el_remarks` text NOT NULL,
  `el_user_id` int(11) NOT NULL,
  `el_ip` varchar(100) NOT NULL,
  `el_browser` varchar(1000) NOT NULL,
  `el_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`el_id`)
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_entry_log`
--

LOCK TABLES `financials_entry_log` WRITE;
/*!40000 ALTER TABLE `financials_entry_log` DISABLE KEYS */;
INSERT INTO `financials_entry_log` VALUES (1,'User_id: 1 With Name: Super Admin Create Region With Id: 2 And Name: Accounts',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-29 07:56:13'),(2,'User_id: 1 With Name: Super Admin Create Region With Id: 3 And Name: Operations',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-29 07:56:24'),(3,'User_id: 1 With Name: Super Admin Create Modular Group With Id: 1 And Name: Accounts',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:04:45'),(4,'User_id: 1 With Name: Super Admin Create Employee With Id: 2 And Name: Ahmad Hasan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:05:46'),(5,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 414121 And Name: Exp - Ahmad Hasan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:05:46'),(6,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 414121 And Name: Exp - Ahmad Hasan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:05:46'),(7,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 110141 And Name: Adv - Ahmad Hasan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:05:46'),(8,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 110141 And Name: Adv - Ahmad Hasan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:05:46'),(9,'User_id: 1 With Name: Super Admin Create Employee Salary Info With Id: 2 And Name: Ahmad Hasan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:05:46'),(10,'User_id: 1 With Name: Super Admin Create Employee With Id: 3 And Name: Independant',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:07:25'),(11,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 110102 And Name: Independant - SALEMAN - CASH',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:07:26'),(12,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 110102 And Name: Independant - SALEMAN - CASH',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:07:26'),(13,'User_id: 1 With Name: Super Admin Create Region With Id: 2 And Name: Multan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-29 08:07:40'),(14,'User_id: 1 With Name: Super Admin Create Category With Id: 1 And Name: Initial Category',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:08:28'),(15,'User_id: 1 With Name: Super Admin Create Unit With Id: 1 And Name: Gattu',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:09:30'),(16,'User_id: 1 With Name: Super Admin Create Unit With Id: 2 And Name: Carton',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:09:52'),(17,'User_id: 1 With Name: Super Admin Create Unit With Id: 3 And Name: Pet',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:10:12'),(18,'User_id: 1 With Name: Super Admin Update Product Group With Id: 2 And Name: Lll',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-29 08:14:31'),(19,'User_id: 1 With Name: Super Admin Update Product Group With Id: 2 And Name: Fixed Raw Material',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-29 08:14:58'),(20,'User_id: 1 With Name: Super Admin Create Product With Code: 100 And Name: Suger',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:16:11'),(21,'User_id: 1 With Name: Super Admin Create Product With Code: 200 And Name: Pepsi 1500 ML',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:17:04'),(22,'User_id: 1 With Name: Super Admin Update Product With Code: 200 And Name: Pepsi 1500 ML And Also Their Childs',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:18:11'),(23,'User_id: 1 With Name: Super Admin Create Product With Code: 300 And Name: Lays Rs. 5',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:19:36'),(24,'User_id: 1 With Name: Super Admin Create Area With Id: 1 And Name: N/A',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:22:30'),(25,'User_id: 1 With Name: Super Admin Create Sector With Id: 1 And Name: N/A',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:22:45'),(26,'User_id: 1 With Name: Super Admin Create Town With Id: 1 And Name: N/A',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:23:04'),(27,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 110132 And Name: ABD 436',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:24:40'),(28,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 110132 And Name: ABD 436',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:24:40'),(29,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 210102 And Name: Xyz 889',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:27:23'),(30,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 210102 And Name: Xyz 889',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:27:23'),(31,'User_id: 1 With Name: Super Admin Create Parent Account With Unique Id: 11110 And Name: Office Equipment',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:27:53'),(32,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 111101 And Name: Air Conditioner Gree 1.5 Ton Invertor',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:28:53'),(33,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 111101 And Name: Air Conditioner Gree 1.5 Ton Invertor',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:28:53'),(34,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 111102 And Name: Acc. Dep. Air Conditioner Gree 1.5 Ton Invertor',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:28:53'),(35,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 111102 And Name: Acc. Dep. Air Conditioner Gree 1.5 Ton Invertor',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:28:53'),(36,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 414101 And Name: Dep. Air Conditioner Gree 1.5 Ton Invertor',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:28:53'),(37,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 414101 And Name: Dep. Air Conditioner Gree 1.5 Ton Invertor',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:28:53'),(38,'User_id: 1 With Name: Super Admin Create Fixed Asset With Unique Id: 1 And Name: Air Conditioner Gree 1.5 Ton Invertor',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:28:53'),(39,'User_id: 1 With Name: Super Admin Create Parent Account With Unique Id: 51010 And Name: Ahmad Hasan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:30:41'),(40,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 510101 And Name: Capital - Ahmad Hasan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:30:41'),(41,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 510101 And Name: Capital - Ahmad Hasan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:30:41'),(42,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 510102 And Name: Profit & Loss - Ahmad Hasan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:30:41'),(43,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 510102 And Name: Profit & Loss - Ahmad Hasan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:30:41'),(44,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 510103 And Name: Drawing - Ahmad Hasan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:30:41'),(45,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 510103 And Name: Drawing - Ahmad Hasan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:30:41'),(46,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 510104 And Name: Reserve - Ahmad Hasan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:30:42'),(47,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 510104 And Name: Reserve - Ahmad Hasan',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:30:42'),(48,'User_id: 1 With Name: Super Admin Create Capital Registration With Unique Id:  And Name: ',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:30:42'),(49,'User_id: 1 With Name: Super Admin Update Product Rate of Code: 300 And Name: Lays Rs. 5',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:32:31'),(50,'User_id: 1 With Name: Super Admin Update Product Rate of Code: 200 And Name: Pepsi 1500 ML',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:32:32'),(51,'User_id: 1 With Name: Super Admin Update Product Rate of Code: 100 And Name: Suger',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:32:32'),(52,'User_id: 1 With Name: Super Admin Create Opening Trial Balances',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:05'),(53,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 110101 and Account Name: Cash with Opening Balance: 15230.00',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(54,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 110102 and Account Name: Independant - SALEMAN - CASH with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(55,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 110111 and Account Name: Stock with Opening Balance: 51361098.00',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(56,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 110121 and Account Name: Meezan with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(57,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 110131 and Account Name: Client One with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(58,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 110132 and Account Name: ABD 436 with Opening Balance: 63000.00',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(59,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 110141 and Account Name: Adv - Ahmad Hasan with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(60,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 110151 and Account Name: Input Tax with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(61,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 110161 and Account Name: Walk In Customer with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(62,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 110171 and Account Name: Client One Claims with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(63,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 110172 and Account Name: Supplier One Claims with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(64,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 110181 and Account Name: Meezan Credit Card Machine with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(65,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 111101 and Account Name: Air Conditioner Gree 1.5 Ton Invertor with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(66,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 111102 and Account Name: Acc. Dep. Air Conditioner Gree 1.5 Ton Invertor with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(67,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 112101 and Account Name: Suspense with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(68,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 210101 and Account Name: Supplier One with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(69,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 210102 and Account Name: Xyz 889 with Opening Balance: -900000',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(70,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 210111 and Account Name: FBR Output Tax(Tax Payable) with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(71,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 210112 and Account Name: Province Output Tax(Tax Payable) with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(72,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 210121 and Account Name: Purchaser with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(73,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 211101 and Account Name: Suspense with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(74,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 510101 and Account Name: Capital - Ahmad Hasan with Opening Balance: -50000000',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(75,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 510102 and Account Name: Profit & Loss - Ahmad Hasan with Opening Balance: -600000',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(76,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 510103 and Account Name: Drawing - Ahmad Hasan with Opening Balance: 60672.00',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(77,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 510104 and Account Name: Reserve - Ahmad Hasan with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(78,'User_id: 1 With Name: Super Admin Enter Opening Balances of Account id: 512101 and Account Name: Undistributed Profit & Loss with Opening Balance: -0',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:34:14'),(79,'User_id: 2 With Name: Ahmad Hasan Change Their Password',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:39:57'),(80,'User_id: 2 With Name: Ahmad Hasan Update Modular Group With Id: 1 And Name: Accounts',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:41:24'),(81,'User_id: 2 With Name: Ahmad Hasan Update Modular Group With Id: 1 And Name: Accounts',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:41:50'),(82,'User_id: 2 With Name: Ahmad Hasan Update Account With Unique Id: 110132 And Name: ABD 436',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 08:43:33'),(83,'User_id: 1 With Name: Super Admin Create Employee With Id: 4 And Name: Shoaib',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-29 10:40:55'),(84,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 110103 And Name: Shoaib - SALEMAN - CASH',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-29 10:40:55'),(85,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 110103 And Name: Shoaib - SALEMAN - CASH',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-29 10:40:55'),(86,'User_id: 1 With Name: Super Admin Update Account With Unique Id: 210102 And Name: Xyz 889',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-29 10:41:47'),(87,'User_id: 1 With Name: Super Admin Create Parent Account With Unique Id: 51011 And Name: Shoaib',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 06:41:59'),(88,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 510111 And Name: Capital - Shoaib',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 06:41:59'),(89,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 510111 And Name: Capital - Shoaib',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 06:41:59'),(90,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 510112 And Name: Profit & Loss - Shoaib',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 06:41:59'),(91,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 510112 And Name: Profit & Loss - Shoaib',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 06:41:59'),(92,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 510113 And Name: Drawing - Shoaib',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 06:41:59'),(93,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 510113 And Name: Drawing - Shoaib',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 06:41:59'),(94,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 510114 And Name: Reserve - Shoaib',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 06:41:59'),(95,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 510114 And Name: Reserve - Shoaib',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 06:41:59'),(96,'User_id: 1 With Name: Super Admin Create Capital Registration With Unique Id:  And Name: ',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 06:41:59'),(97,'User_id: 1 With Name: Super Admin Create Project Reference With Id: 1 And Name: Universal Project',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 07:21:34'),(98,'User_id: 1 With Name: Super Admin Create BANK_PAYMENT_VOUCHER With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 09:42:23'),(99,'User_id: 1 With Name: Super Admin Create Post Dated Cheque Issue With Id: 1 In Pending State',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 09:43:32'),(100,'User_id: 1 With Name: Super Admin Approve Post Dated Cheque Issue With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 09:43:53'),(101,'User_id: 1 With Name: Super Admin Create Journal Voucher With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 09:44:51'),(102,'User_id: 1 With Name: Super Admin Create Journal Voucher With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 09:45:29'),(103,'User_id: 1 With Name: Super Admin Create CASH_RECEIPT_VOUCHER With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 09:50:48'),(104,'User_id: 1 With Name: Super Admin Create CASH_PAYMENT_VOUCHER With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 09:51:22'),(105,'User_id: 1 With Name: Super Admin Create BANK_RECEIPT_VOUCHER With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 09:51:55'),(106,'User_id: 1 With Name: Super Admin Create BANK_PAYMENT_VOUCHER With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 09:52:15'),(107,'User_id: 1 With Name: Super Admin Create PURCHASE_INVOICE With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 10:00:53'),(108,'User_id: 1 With Name: Super Admin Create Journal Voucher With Id: 3',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 11:02:17'),(109,'User_id: 1 With Name: Super Admin Create Journal Voucher With Id: ',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 11:36:37'),(110,'User_id: 1 With Name: Super Admin Create EXPENSE_PAYMENT_VOUCHER With Id: ',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 11:57:36'),(111,'User_id: 1 With Name: Super Admin Create Approval Journal Voucher With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 12:15:06'),(112,'User_id: 1 With Name: Super Admin \"Approved\"\"  Approval Journal Voucher With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 12:15:36'),(113,'User_id: 1 With Name: Super Admin Create Approval Journal Voucher With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 12:16:53'),(116,'User_id: 1 With Name: Super Admin Create SALE_INVOICE With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 13:11:06'),(117,'User_id: 1 With Name: Super Admin Create CASH_RECEIPT_VOUCHER With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 13:14:15'),(118,'User_id: 1 With Name: Super Admin Create CASH_PAYMENT_VOUCHER With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 13:14:34'),(119,'User_id: 1 With Name: Super Admin Create BANK_RECEIPT_VOUCHER With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 13:27:03'),(120,'User_id: 1 With Name: Super Admin Create BANK_PAYMENT_VOUCHER With Id: 3',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 13:27:21'),(121,'User_id: 1 With Name: Super Admin Create Project Reference With Id: 2 And Name: Post',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 13:27:45'),(122,'User_id: 1 With Name: Super Admin Create Project Reference With Id: 3 And Name: Abc Ref Post',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 13:27:54'),(123,'User_id: 1 With Name: Super Admin Create BANK_RECEIPT_VOUCHER With Id: 3',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 13:28:12'),(124,'User_id: 1 With Name: Super Admin Create BANK_RECEIPT_VOUCHER With Id: 4',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 13:30:07'),(127,'User_id: 1 With Name: Super Admin Create EXPENSE_PAYMENT_VOUCHER With Id: ',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 09:32:43'),(129,'User_id: 1 With Name: Super Admin \"Approved\"\"  Approval Journal Voucher With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 09:48:07'),(132,'User_id: 1 With Name: Super Admin Create Journal Voucher With Id: 13',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 09:59:07'),(133,'User_id: 1 With Name: Super Admin Create Journal Voucher With Id: 14',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 09:59:33'),(134,'User_id: 1 With Name: Super Admin Create Post Dated Cheque Issue With Id: 2 In Pending State',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 11:44:18'),(135,'User_id: 1 With Name: Super Admin Approve Post Dated Cheque Issue With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 11:44:41'),(136,'User_id: 1 With Name: Super Admin Create Post Dated Cheque Issue With Id: 3 In Pending State',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 11:52:21'),(137,'User_id: 1 With Name: Super Admin Approve Post Dated Cheque Issue With Id: 3',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 11:52:27'),(138,'User_id: 1 With Name: Super Admin Create Post Dated Cheque Received With Id: 4 In Pending State',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 12:21:28'),(139,'User_id: 1 With Name: Super Admin Approve Post Dated Cheque Received With Id: 4',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 12:21:35'),(140,'User_id: 1 With Name: Super Admin Create Journal Voucher With Id: 15',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 12:23:30'),(141,'User_id: 1 With Name: Super Admin Create Approval Journal Voucher With Id: 3',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 12:25:20'),(142,'User_id: 1 With Name: Super Admin Create Journal Voucher With Id: 16',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 12:25:32'),(143,'User_id: 1 With Name: Super Admin Create PRODUCT_RECOVER With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 13:39:21'),(144,'User_id: 1 With Name: Super Admin Create PRODUCT_LOSS With Id: 3',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 13:40:05'),(145,'User_id: 1 With Name: Super Admin Create TRADE_PRODUCT_LOSS With Id: 4',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 13:40:43'),(146,'User_id: 1 With Name: Super Admin Create PRODUCT_RECOVER With Id: 10',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 13:58:08'),(147,'User_id: 1 With Name: Super Admin Create SALE_ORDER_INVOICE With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 08:07:35'),(148,'User_id: 1 With Name: Super Admin Create TRADE_SALE_ORDER_INVOICE With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 08:09:18'),(149,'User_id: 1 With Name: Super Admin Create SALE_ORDER_INVOICE With Id: 3',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 08:15:17'),(150,'User_id: 1 With Name: Super Admin Create SALE_INVOICE With Id: 5',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 08:21:12'),(151,'User_id: 1 With Name: Super Admin Create DELIVERY_ORDER With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 11:55:27'),(152,'User_id: 1 With Name: Super Admin Create DELIVERY_ORDER With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 11:55:48'),(153,'User_id: 1 With Name: Super Admin Create DELIVERY_ORDER With Id: 3',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 12:15:35'),(154,'User_id: 1 With Name: Super Admin Create GOODS_RECEIPT_NOTE With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:22:38'),(155,'User_id: 1 With Name: Super Admin Create GOODS_RECEIPT_NOTE With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:23:35'),(156,'User_id: 1 With Name: Super Admin Create GOODS_RECEIPT_NOTE With Id: 3',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:24:05'),(157,'User_id: 1 With Name: Super Admin Create GOODS_RECEIPT_NOTE With Id: 4',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:27:49'),(158,'User_id: 1 With Name: Super Admin Create PURCHASE_INVOICE With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 07:12:26'),(159,'User_id: 1 With Name: Super Admin Create PURCHASE_RETURN_INVOICE With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 07:12:56'),(160,'User_id: 1 With Name: Super Admin Create PURCHASE_RETURN_INVOICE With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 07:24:08'),(161,'User_id: 1 With Name: Super Admin Create PURCHASE_RETURN_INVOICE With Id: 3',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 07:29:15'),(162,'User_id: 1 With Name: Super Admin Create Transfer Stock Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 08:55:00'),(163,'User_id: 1 With Name: Super Admin Create Convert Quantity With Id: 1 And Name: Lays Rs. 5',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 08:55:41'),(164,'User_id: 1 With Name: Super Admin Create Product With Code: 400 And Name: Daal Chawal',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 09:25:27'),(165,'User_id: 1 With Name: Super Admin Create PURCHASE_INVOICE With Id: 3',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 09:27:45'),(166,'User_id: 1 With Name: Super Admin Create PURCHASE_INVOICE With Id: 4',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 09:29:41'),(167,'User_id: 1 With Name: Super Admin Create PRODUCT_LOSS With Id: 11',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 09:33:27'),(168,'User_id: 1 With Name: Super Admin Create PRODUCT_RECOVER With Id: 12',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 09:35:55'),(169,'User_id: 1 With Name: Super Admin Create PURCHASE_RETURN_INVOICE With Id: 4',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 09:37:15'),(170,'User_id: 1 With Name: Super Admin Create SALE_INVOICE With Id: 7',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 09:39:07'),(171,'User_id: 1 With Name: Super Admin Create Claim Receive With SM_Id: 49 And Name: CLAIM ISSUE',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 09:47:29'),(172,'User_id: 1 With Name: Super Admin Create Claim Receive With SM_Id: 50 And Name: CLAIM RECEIVED',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 10:11:52'),(173,'User_id: 1 With Name: Super Admin Create Claim Receive With SM_Id: 51 And Name: CLAIM RECEIVED',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 10:12:21'),(174,'User_id: 1 With Name: Super Admin Create Claim Receive With SM_Id: 52 And Name: CLAIM ISSUE',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 10:13:47'),(175,'User_id: 1 With Name: Super Admin Create SALE_INVOICE With Id: 8',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 10:30:55'),(176,'User_id: 1 With Name: Super Admin Create SALE_INVOICE With Id: 9',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 10:31:14'),(177,'User_id: 1 With Name: Super Admin Create SALE_INVOICE With Id: 10',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 10:48:08'),(178,'User_id: 1 With Name: Super Admin Create SALE_INVOICE With Id: 11',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 06:28:34'),(179,'User_id: 1 With Name: Super Admin Create Transfer Stock Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 08:25:41'),(180,'User_id: 1 With Name: Super Admin Create Transfer Stock Id: 3',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 10:52:58'),(181,'User_id: 1 With Name: Super Admin Unlocked Day End',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 11:56:05'),(182,'User_id: 1 With Name: Super Admin Create PURCHASE_INVOICE With Id: 5',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 11:57:01'),(183,'User_id: 1 With Name: Super Admin Create Convert Quantity With Id: 2 And Name: Daal Chawal',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 11:58:04'),(184,'User_id: 1 With Name: Super Admin Create Convert Quantity With Id: 3 And Name: Daal Chawal',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 11:58:43'),(185,'User_id: 1 With Name: Super Admin Create SALE_SALE_TAX_INVOICE With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 06:34:02'),(186,'User_id: 1 With Name: Super Admin Create SALE_SALE_TAX_INVOICE With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 07:07:08'),(187,'User_id: 1 With Name: Super Admin Create SALE_SALE_TAX_INVOICE With Id: 3',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 07:14:16'),(188,'User_id: 1 With Name: Super Admin Create SALE_SALE_TAX_INVOICE With Id: 4',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 07:14:48'),(189,'User_id: 1 With Name: Super Admin Create SALE_SALE_TAX_INVOICE With Id: 5',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 07:16:16'),(190,'User_id: 1 With Name: Super Admin Create Brand With Id: 1 And Name: Pepsi',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 07:27:55'),(191,'User_id: 1 With Name: Super Admin Create Service With Id: 1 And Name: Shop Survey',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 07:28:20'),(192,'User_id: 1 With Name: Super Admin Create PURCHASE_ORDER With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 07:29:37'),(193,'User_id: 1 With Name: Super Admin Create SERVICE_ORDER With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 07:29:37'),(194,'User_id: 1 With Name: Super Admin Update Area With Id: 1 And Name: Initial Area',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 09:32:43'),(195,'User_id: 1 With Name: Super Admin Update Sector With Id: 1 And Name: Initial Sector',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 09:33:20'),(196,'User_id: 1 With Name: Super Admin Update Town With Id: 1 And Name: Initial Town',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 11:22:56'),(197,'User_id: 1 With Name: Super Admin Create SALE_INVOICE With Id: 12',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 11:35:19'),(198,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 413102 And Name: Fsdfsaf Service Charges',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 11:42:03'),(199,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 413102 And Name: Fsdfsaf Service Charges',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 11:42:03'),(200,'User_id: 1 With Name: Super Admin Opening Balance of Account With Unique Id: 110182 And Name: Fsdfsaf Credit Card Machine',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 11:42:03'),(201,'User_id: 1 With Name: Super Admin Create Account With Unique Id: 110182 And Name: Fsdfsaf Credit Card Machine',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 11:42:03'),(202,'User_id: 1 With Name: Super Admin Create Credit Card Machine With Id: 1 And Name: Fsdfsaf',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 11:42:03'),(203,'User_id: 1 With Name: Super Admin Create Product Type With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:11:52'),(204,'User_id: 1 With Name: Super Admin Create Product Type With Id: 2',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:12:01'),(205,'User_id: 1 With Name: Super Admin Create PRODUCT_ORDER With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:12:52'),(206,'User_id: 1 With Name: Super Admin Create SERVICE_ORDER With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:12:52'),(207,'User_id: 1 With Name: Super Admin Create SURVEY WORKING AREA With Id: 1',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:37'),(208,'User_id: 1 With Name: Super Admin Create SALE_INVOICE With Id: 13',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:24:35'),(209,'User_id: 1 With Name: Super Admin Update Employee With Id: 4 And Name: Shoaib',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 13:12:46');
/*!40000 ALTER TABLE `financials_entry_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_expense_payment_voucher`
--

DROP TABLE IF EXISTS `financials_expense_payment_voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_expense_payment_voucher` (
  `ep_id` int(11) NOT NULL AUTO_INCREMENT,
  `ep_account_id` int(11) NOT NULL,
  `ep_total_amount` decimal(50,2) NOT NULL,
  `ep_remarks` varchar(450) DEFAULT NULL,
  `ep_created_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `ep_day_end_id` int(11) DEFAULT NULL,
  `ep_day_end_date` date DEFAULT NULL,
  `ep_createdby` int(11) DEFAULT NULL,
  `ep_detail_remarks` varchar(1000) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `ep_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `ep_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  PRIMARY KEY (`ep_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_expense_payment_voucher`
--

LOCK TABLES `financials_expense_payment_voucher` WRITE;
/*!40000 ALTER TABLE `financials_expense_payment_voucher` DISABLE KEYS */;
INSERT INTO `financials_expense_payment_voucher` VALUES (6,110121,150.00,NULL,'2021-11-03 11:57:36',1,'2021-09-29',1,'\n                                                                Product Recover & Loss\n                                                            , @100.00&oS;\n                                                                Bonus Allocation-Deallocation\n                                                            , @50.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69'),(8,110103,2.00,NULL,'2021-11-04 09:32:43',1,'2021-09-29',1,'\n                                                                Product Stock Consumed\n                                                            , @2.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69');
/*!40000 ALTER TABLE `financials_expense_payment_voucher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_expense_payment_voucher_items`
--

DROP TABLE IF EXISTS `financials_expense_payment_voucher_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_expense_payment_voucher_items` (
  `epi_id` int(11) NOT NULL AUTO_INCREMENT,
  `epi_voucher_id` int(11) NOT NULL,
  `epi_account_id` int(11) NOT NULL,
  `epi_account_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `epi_pr_id` int(11) DEFAULT NULL,
  `epi_amount` double NOT NULL,
  `epi_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`epi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_expense_payment_voucher_items`
--

LOCK TABLES `financials_expense_payment_voucher_items` WRITE;
/*!40000 ALTER TABLE `financials_expense_payment_voucher_items` DISABLE KEYS */;
INSERT INTO `financials_expense_payment_voucher_items` VALUES (1,6,411131,'\n                                                                Product Recover & Loss\n                                                            ',1,100,''),(2,6,410111,'\n                                                                Bonus Allocation-Deallocation\n                                                            ',1,50,''),(4,8,410121,'\n                                                                Product Stock Consumed\n                                                            ',2,2,'');
/*!40000 ALTER TABLE `financials_expense_payment_voucher_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_fixed_asset`
--

DROP TABLE IF EXISTS `financials_fixed_asset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_fixed_asset` (
  `fa_id` int(11) NOT NULL AUTO_INCREMENT,
  `fa_parent_account_uid` int(11) NOT NULL,
  `fa_link_account_uids` varchar(50) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `fa_group_id` int(11) NOT NULL,
  `fa_account_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `fa_price` decimal(50,2) NOT NULL,
  `fa_residual_value` decimal(50,2) NOT NULL,
  `fa_useful_life_year` int(11) NOT NULL,
  `fa_useful_life_month` int(11) DEFAULT 0,
  `fa_useful_life_day` int(11) DEFAULT 0,
  `fa_dep_percentage_year` decimal(50,6) NOT NULL,
  `fa_dep_percentage_month` decimal(50,6) NOT NULL DEFAULT 0.000000,
  `fa_dep_percentage_day` decimal(50,6) NOT NULL DEFAULT 0.000000,
  `fa_dep_period` tinyint(4) NOT NULL,
  `fa_dep_entries` int(11) DEFAULT 0,
  `fa_book_value` decimal(50,2) DEFAULT 0.00,
  `fa_register_number` varchar(250) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT '',
  `fa_supplier_details` text CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT '',
  `fa_guarantee_period` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT '',
  `fa_specification` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT '',
  `fa_capacity` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT '',
  `fa_size` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT '',
  `fa_method` tinyint(4) NOT NULL DEFAULT 1,
  `fa_acquisition_date` date NOT NULL DEFAULT current_timestamp(),
  `fa_remarks` varchar(1000) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT '',
  `fa_dep_amo` tinyint(4) NOT NULL DEFAULT 1,
  `fa_posting` tinyint(4) NOT NULL DEFAULT 1,
  `fa_user_id` int(11) NOT NULL,
  `fa_date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `fa_day_end_id` int(11) NOT NULL,
  `fa_day_end_date` date NOT NULL,
  `fa_ip_adrs` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `fa_brwsr_info` varchar(4000) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`fa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_fixed_asset`
--

LOCK TABLES `financials_fixed_asset` WRITE;
/*!40000 ALTER TABLE `financials_fixed_asset` DISABLE KEYS */;
INSERT INTO `financials_fixed_asset` VALUES (1,11110,'111101,111102,414101',1,'Air Conditioner Gree 1.5 Ton Invertor',105300.00,300.00,4,48,1460,25.000000,2.083333,0.068493,2,0,105300.00,NULL,NULL,NULL,NULL,NULL,NULL,1,'2021-09-30','',1,1,1,'2021-10-29 08:28:53',0,'2021-10-29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69');
/*!40000 ALTER TABLE `financials_fixed_asset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_generate_salary_slip_voucher`
--

DROP TABLE IF EXISTS `financials_generate_salary_slip_voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_generate_salary_slip_voucher` (
  `gss_id` int(11) NOT NULL AUTO_INCREMENT,
  `gss_month` varchar(255) DEFAULT NULL,
  `gss_remarks` varchar(1000) DEFAULT NULL,
  `gss_detail_remarks` text DEFAULT NULL,
  `gss_department_id` int(11) DEFAULT NULL,
  `gss_total_amount` decimal(50,2) DEFAULT NULL,
  `gss_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `gss_day_end_id` int(11) NOT NULL,
  `gss_day_end_date` date NOT NULL,
  `gss_current_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `gss_created_by` int(11) NOT NULL,
  `gss_ip_adrs` varchar(255) DEFAULT NULL,
  `gss_brwsr_info` varchar(4000) DEFAULT NULL,
  `gss_update_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`gss_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_generate_salary_slip_voucher`
--

LOCK TABLES `financials_generate_salary_slip_voucher` WRITE;
/*!40000 ALTER TABLE `financials_generate_salary_slip_voucher` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_generate_salary_slip_voucher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_generate_salary_slip_voucher_items`
--

DROP TABLE IF EXISTS `financials_generate_salary_slip_voucher_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_generate_salary_slip_voucher_items` (
  `gssi_id` int(11) NOT NULL AUTO_INCREMENT,
  `gssi_gss_id` int(11) DEFAULT NULL,
  `gssi_employee_id` int(11) DEFAULT NULL,
  `gssi_department_id` int(11) DEFAULT NULL,
  `gssi_department_name` varchar(500) DEFAULT NULL,
  `gssi_account_id` int(11) DEFAULT NULL,
  `gssi_account_name` varchar(500) DEFAULT NULL,
  `gssi_advance_account_id` int(11) DEFAULT NULL,
  `gssi_month_days` int(11) DEFAULT NULL,
  `gssi_attend_days` int(11) DEFAULT NULL,
  `gssi_salary_period_type` int(11) DEFAULT NULL,
  `gssi_basic_salary` decimal(50,2) DEFAULT NULL,
  `gssi_gross_salary` decimal(50,2) DEFAULT NULL,
  `gssi_allowances` decimal(50,2) DEFAULT NULL,
  `gssi_deductions` decimal(50,2) DEFAULT NULL,
  `gssi_over_time_days` decimal(50,2) DEFAULT NULL,
  `gssi_over_time_amount` decimal(50,2) DEFAULT NULL,
  `gssi_advance_salary` decimal(50,2) DEFAULT NULL,
  `gssi_net_salary` decimal(50,2) DEFAULT NULL,
  `gssi_loan_installment_amount` decimal(50,2) NOT NULL DEFAULT 0.00,
  `gssi_month_year` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`gssi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_generate_salary_slip_voucher_items`
--

LOCK TABLES `financials_generate_salary_slip_voucher_items` WRITE;
/*!40000 ALTER TABLE `financials_generate_salary_slip_voucher_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_generate_salary_slip_voucher_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_genre`
--

DROP TABLE IF EXISTS `financials_genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_genre` (
  `gen_id` int(11) NOT NULL AUTO_INCREMENT,
  `gen_title` varchar(250) NOT NULL,
  `gen_remarks` varchar(500) DEFAULT 'NULL',
  `gen_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `gen_createdby` int(11) DEFAULT NULL,
  `gen_day_end_id` int(11) DEFAULT NULL,
  `gen_day_end_date` date DEFAULT NULL,
  `gen_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `gen_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `gen_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `gen_delete_status` int(11) DEFAULT 0,
  `gen_deleted_by` int(11) DEFAULT NULL,
  `gen_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`gen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_genre`
--

LOCK TABLES `financials_genre` WRITE;
/*!40000 ALTER TABLE `financials_genre` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_goods_receipt_note`
--

DROP TABLE IF EXISTS `financials_goods_receipt_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_goods_receipt_note` (
  `grn_id` int(11) NOT NULL AUTO_INCREMENT,
  `grn_party_code` int(11) NOT NULL,
  `grn_party_name` varchar(250) NOT NULL,
  `grn_pr_id` int(11) DEFAULT NULL,
  `grn_customer_name` varchar(250) DEFAULT NULL,
  `grn_remarks` varchar(500) DEFAULT NULL,
  `grn_total_items` int(11) DEFAULT NULL,
  `grn_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `grn_day_end_id` int(11) DEFAULT NULL,
  `grn_day_end_date` date DEFAULT NULL,
  `grn_createdby` int(11) DEFAULT NULL,
  `grn_detail_remarks` text DEFAULT NULL,
  `grn_sale_person` int(11) DEFAULT 0,
  `grn_invoice_transcation_type` int(11) DEFAULT 1,
  `grn_dc_id` varchar(150) DEFAULT NULL,
  `grn_email` varchar(500) DEFAULT NULL,
  `grn_whatsapp` varchar(150) DEFAULT NULL,
  `grn_ip_adrs` varchar(255) NOT NULL,
  `grn_brwsr_info` varchar(4000) NOT NULL,
  `grn_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`grn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_goods_receipt_note`
--

LOCK TABLES `financials_goods_receipt_note` WRITE;
/*!40000 ALTER TABLE `financials_goods_receipt_note` DISABLE KEYS */;
INSERT INTO `financials_goods_receipt_note` VALUES (1,110132,'ABD 436',2,'','',1,'2021-11-05 13:22:37',1,'2021-09-29',1,'Suger, 1&oS;',0,1,NULL,NULL,NULL,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 18:22:37'),(2,210101,'Supplier One',NULL,'','',40,'2021-11-05 13:23:33',1,'2021-09-29',1,'Suger, Total QTY = 40.000, Pack QTY = 1, Loose QTY = 0&oS;',0,1,NULL,NULL,NULL,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 18:23:33'),(3,110132,'ABD 436',NULL,'','',40,'2021-11-05 13:24:04',1,'2021-09-29',1,'Suger, Total QTY = 40.000, Pack QTY = 1, Loose QTY = 0&oS;',0,1,NULL,NULL,NULL,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 18:24:04'),(4,210101,'Supplier One',2,'','',40,'2021-11-05 13:27:48',1,'2021-09-29',1,'Suger, Total QTY = 40.000, Pack QTY = 1, Loose QTY = 0&oS;',0,1,NULL,NULL,NULL,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 18:27:48');
/*!40000 ALTER TABLE `financials_goods_receipt_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_goods_receipt_note_items`
--

DROP TABLE IF EXISTS `financials_goods_receipt_note_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_goods_receipt_note_items` (
  `grni_id` int(11) NOT NULL AUTO_INCREMENT,
  `grni_invoice_id` int(11) NOT NULL,
  `grni_product_code` varchar(500) NOT NULL,
  `grni_product_name` varchar(250) NOT NULL,
  `grni_remarks` varchar(500) NOT NULL,
  `grni_qty` decimal(50,3) NOT NULL DEFAULT 0.000,
  `grni_due_qty` decimal(50,3) DEFAULT NULL,
  `grni_uom` varchar(500) DEFAULT '',
  `grni_scale_size` tinyint(4) DEFAULT NULL,
  `grni_bonus_qty` decimal(50,3) DEFAULT NULL,
  `grni_rate` decimal(50,2) DEFAULT NULL,
  `grni_amount` decimal(50,2) DEFAULT NULL,
  `grni_warehouse_id` int(11) NOT NULL DEFAULT 0,
  `grni_status` varchar(255) DEFAULT NULL,
  `grni_created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`grni_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_goods_receipt_note_items`
--

LOCK TABLES `financials_goods_receipt_note_items` WRITE;
/*!40000 ALTER TABLE `financials_goods_receipt_note_items` DISABLE KEYS */;
INSERT INTO `financials_goods_receipt_note_items` VALUES (1,1,'100','Suger','',1.000,1.000,'Gattu',40,0.000,NULL,NULL,1,NULL,'2021-11-05 13:22:38'),(2,2,'100','Suger','',40.000,40.000,'Gattu',40,0.000,NULL,NULL,1,NULL,'2021-11-05 13:23:34'),(3,3,'100','Suger','',40.000,40.000,'Gattu',40,0.000,NULL,NULL,1,NULL,'2021-11-05 13:24:05'),(4,4,'100','Suger','',40.000,40.000,'Gattu',40,0.000,NULL,NULL,1,NULL,'2021-11-05 13:27:49');
/*!40000 ALTER TABLE `financials_goods_receipt_note_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_grn_log`
--

DROP TABLE IF EXISTS `financials_grn_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_grn_log` (
  `grnl_id` int(11) NOT NULL AUTO_INCREMENT,
  `grnl_grn_id` int(11) DEFAULT NULL,
  `grnl_warehouse_id` int(11) DEFAULT NULL,
  `grnl_product_code` varchar(255) DEFAULT NULL,
  `grnl_total_qty` decimal(50,3) DEFAULT NULL,
  `grnl_purchase_qty` decimal(50,3) DEFAULT 0.000,
  `grnl_balance_qty` decimal(50,3) DEFAULT 0.000,
  `grnl_purchase_id` int(11) DEFAULT NULL,
  `grnl_purchase_tax_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`grnl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_grn_log`
--

LOCK TABLES `financials_grn_log` WRITE;
/*!40000 ALTER TABLE `financials_grn_log` DISABLE KEYS */;
INSERT INTO `financials_grn_log` VALUES (1,1,1,'100',1.000,0.000,1.000,NULL,NULL),(2,2,1,'100',40.000,0.000,40.000,NULL,NULL),(3,3,1,'100',40.000,0.000,40.000,NULL,NULL),(4,4,1,'100',40.000,0.000,40.000,NULL,NULL);
/*!40000 ALTER TABLE `financials_grn_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_groups`
--

DROP TABLE IF EXISTS `financials_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_groups` (
  `grp_id` int(11) NOT NULL AUTO_INCREMENT,
  `grp_title` varchar(250) NOT NULL,
  `grp_remarks` varchar(500) DEFAULT NULL,
  `grp_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `grp_createdby` int(11) DEFAULT NULL,
  `grp_day_end_id` int(11) DEFAULT NULL,
  `grp_day_end_date` date DEFAULT NULL,
  `grp_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `grp_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `grp_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `grp_tax` decimal(50,2) DEFAULT 0.00,
  `grp_retailer_discount` decimal(50,2) DEFAULT 0.00,
  `grp_whole_seller_discount` decimal(50,2) DEFAULT 0.00,
  `grp_loyalty_card_discount` decimal(50,2) DEFAULT 0.00,
  `grp_delete_status` int(11) DEFAULT 0,
  `grp_deleted_by` int(11) DEFAULT NULL,
  `grp_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`grp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_groups`
--

LOCK TABLES `financials_groups` WRITE;
/*!40000 ALTER TABLE `financials_groups` DISABLE KEYS */;
INSERT INTO `financials_groups` VALUES (1,'Initial Group',NULL,'2021-10-29 06:56:22',0,0,'2021-10-29','','','2021-10-29 11:56:22',0.00,0.00,0.00,0.00,0,NULL,0),(2,'Fixed Raw Material','','2021-10-29 06:56:22',1,0,'2021-10-29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-29 13:14:57',0.00,0.00,0.00,0.00,0,NULL,0);
/*!40000 ALTER TABLE `financials_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_illustrated`
--

DROP TABLE IF EXISTS `financials_illustrated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_illustrated` (
  `ill_id` int(11) NOT NULL AUTO_INCREMENT,
  `ill_title` varchar(250) NOT NULL,
  `ill_remarks` varchar(500) DEFAULT 'NULL',
  `ill_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `ill_createdby` int(11) DEFAULT NULL,
  `ill_day_end_id` int(11) DEFAULT NULL,
  `ill_day_end_date` date DEFAULT NULL,
  `ill_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `ill_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `ill_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `ill_delete_status` int(11) DEFAULT 0,
  `ill_deleted_by` int(11) DEFAULT NULL,
  `ill_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_illustrated`
--

LOCK TABLES `financials_illustrated` WRITE;
/*!40000 ALTER TABLE `financials_illustrated` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_illustrated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_imprint`
--

DROP TABLE IF EXISTS `financials_imprint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_imprint` (
  `imp_id` int(11) NOT NULL AUTO_INCREMENT,
  `imp_title` varchar(250) NOT NULL,
  `imp_remarks` varchar(500) DEFAULT 'NULL',
  `imp_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `imp_createdby` int(11) DEFAULT NULL,
  `imp_day_end_id` int(11) DEFAULT NULL,
  `imp_day_end_date` date DEFAULT NULL,
  `imp_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `imp_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `imp_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `imp_delete_status` int(11) DEFAULT 0,
  `imp_deleted_by` int(11) DEFAULT NULL,
  `imp_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`imp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_imprint`
--

LOCK TABLES `financials_imprint` WRITE;
/*!40000 ALTER TABLE `financials_imprint` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_imprint` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_income_statement`
--

DROP TABLE IF EXISTS `financials_income_statement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_income_statement` (
  `is_id` int(11) NOT NULL AUTO_INCREMENT,
  `is_closing_type` varchar(50) NOT NULL,
  `is_parent_uid` int(11) NOT NULL,
  `is_account_uid` int(11) NOT NULL,
  `is_account_name` varchar(500) NOT NULL,
  `is_level` tinyint(4) NOT NULL,
  `is_type` varchar(10) NOT NULL,
  `is_amount1` decimal(50,2) DEFAULT NULL,
  `is_amount2` decimal(50,2) DEFAULT NULL,
  `is_amount3` decimal(50,2) DEFAULT NULL,
  `is_day_end_id` int(11) NOT NULL,
  `is_day_end_date` date NOT NULL,
  `is_current_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `is_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `is_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`is_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_income_statement`
--

LOCK TABLES `financials_income_statement` WRITE;
/*!40000 ALTER TABLE `financials_income_statement` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_income_statement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_info_bx`
--

DROP TABLE IF EXISTS `financials_info_bx`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_info_bx` (
  `ib_id` int(11) NOT NULL AUTO_INCREMENT,
  `ib_url` varchar(255) DEFAULT NULL,
  `ib_vd_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  `ib_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `ib_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `ib_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ib_id`),
  UNIQUE KEY `ib_id` (`ib_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_info_bx`
--

LOCK TABLES `financials_info_bx` WRITE;
/*!40000 ALTER TABLE `financials_info_bx` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_info_bx` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_info_bx_child`
--

DROP TABLE IF EXISTS `financials_info_bx_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_info_bx_child` (
  `ibc_id` int(11) NOT NULL AUTO_INCREMENT,
  `ib_id` int(11) DEFAULT NULL,
  `ibc_ques` varchar(255) DEFAULT NULL,
  `ibc_ans` varchar(2000) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  `ibc_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `ibc_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `ibc_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ibc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_info_bx_child`
--

LOCK TABLES `financials_info_bx_child` WRITE;
/*!40000 ALTER TABLE `financials_info_bx_child` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_info_bx_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_journal_voucher`
--

DROP TABLE IF EXISTS `financials_journal_voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_journal_voucher` (
  `jv_id` int(11) NOT NULL AUTO_INCREMENT,
  `jv_session` varchar(450) DEFAULT NULL,
  `jv_project_id` int(11) DEFAULT NULL,
  `jv_order_list_id` int(11) DEFAULT NULL,
  `jv_business_name` varchar(450) DEFAULT NULL,
  `jv_total_dr` double NOT NULL,
  `jv_total_cr` double NOT NULL,
  `jv_created_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `jv_remarks` varchar(450) DEFAULT NULL,
  `jv_day_end_id` int(11) DEFAULT NULL,
  `jv_day_end_date` date DEFAULT NULL,
  `jv_createdby` int(11) DEFAULT NULL,
  `jv_detail_remarks` varchar(1000) DEFAULT NULL,
  `jv_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `jv_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `jv_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`jv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_journal_voucher`
--

LOCK TABLES `financials_journal_voucher` WRITE;
/*!40000 ALTER TABLE `financials_journal_voucher` DISABLE KEYS */;
INSERT INTO `financials_journal_voucher` VALUES (1,NULL,NULL,NULL,NULL,130,130,'2021-11-03 09:44:51','',1,'2021-09-29',1,'\n                                                                Meezan\n                                                            , Dr@130.00&oS;\n                                                                Meezan\n                                                            , Cr@130.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:44:51'),(2,NULL,NULL,NULL,NULL,100,100,'2021-11-03 09:45:29','',1,'2021-09-29',1,'\n                                                                Cash\n                                                            , Dr@100.00&oS;\n                                                                Independant - SALEMAN - CASH\n                                                            , Cr@100.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:45:29'),(3,NULL,NULL,NULL,NULL,120,120,'2021-11-03 11:02:16','',1,'2021-09-29',1,'\n                                                                Cash\n                                                            , Dr@120.00&oS;\n                                                                Shoaib - SALEMAN - CASH\n                                                            , Cr@120.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:02:16'),(13,NULL,NULL,NULL,NULL,500,500,'2021-11-04 09:59:01','',1,'2021-09-29',1,'\n                                                                Meezan\n                                                            , Dr@500.00&oS;\n                                                                Shoaib - SALEMAN - CASH\n                                                            , Cr@500.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:59:01'),(14,NULL,NULL,NULL,NULL,1000,1000,'2021-11-04 09:59:33','',1,'2021-09-29',1,'\n                                                                Cash\n                                                            , Dr@1,000.00&oS;\n                                                                Shoaib - SALEMAN - CASH\n                                                            , Cr@1,000.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:59:33'),(15,NULL,NULL,NULL,NULL,2,2,'2021-11-04 12:23:30','',1,'2021-09-29',1,'\n                                                                Meezan\n                                                            , Cr@2.00&oS;\n                                                                Meezan\n                                                            , Dr@2.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:23:30'),(16,NULL,NULL,NULL,NULL,1,1,'2021-11-04 12:25:32','',1,'2021-09-29',1,'\n                                                                Client One\n                                                            , Cr@1.00&oS;\n                                                                ABD 436\n                                                            , Dr@1.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:25:32');
/*!40000 ALTER TABLE `financials_journal_voucher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_journal_voucher_items`
--

DROP TABLE IF EXISTS `financials_journal_voucher_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_journal_voucher_items` (
  `jvi_id` int(11) NOT NULL AUTO_INCREMENT,
  `jvi_journal_voucher_id` int(11) NOT NULL,
  `jvi_account_id` int(11) NOT NULL,
  `jvi_account_name` varchar(500) NOT NULL,
  `jvi_pr_id` int(11) DEFAULT NULL,
  `jvi_amount` double NOT NULL,
  `jvi_type` varchar(50) NOT NULL,
  `jvi_remarks` varchar(500) DEFAULT NULL,
  `jvi_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `jvi_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `jvi_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`jvi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_journal_voucher_items`
--

LOCK TABLES `financials_journal_voucher_items` WRITE;
/*!40000 ALTER TABLE `financials_journal_voucher_items` DISABLE KEYS */;
INSERT INTO `financials_journal_voucher_items` VALUES (1,1,110121,'\n                                                                Meezan\n                                                            ',NULL,130,'Dr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:44:51'),(2,1,110121,'\n                                                                Meezan\n                                                            ',NULL,130,'Cr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:44:51'),(3,2,110101,'\n                                                                Cash\n                                                            ',NULL,100,'Dr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:45:29'),(4,2,110102,'\n                                                                Independant - SALEMAN - CASH\n                                                            ',NULL,100,'Cr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:45:29'),(5,3,110101,'\n                                                                Cash\n                                                            ',1,120,'Dr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:02:16'),(6,3,110103,'\n                                                                Shoaib - SALEMAN - CASH\n                                                            ',1,120,'Cr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:02:16'),(21,13,110121,'\n                                                                Meezan\n                                                            ',1,500,'Dr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:59:01'),(22,13,110103,'\n                                                                Shoaib - SALEMAN - CASH\n                                                            ',1,500,'Cr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:59:01'),(23,14,110101,'\n                                                                Cash\n                                                            ',1,1000,'Dr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:59:33'),(24,14,110103,'\n                                                                Shoaib - SALEMAN - CASH\n                                                            ',1,1000,'Cr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:59:33'),(25,15,110121,'\n                                                                Meezan\n                                                            ',2,2,'Cr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:23:30'),(26,15,110121,'\n                                                                Meezan\n                                                            ',1,2,'Dr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:23:30'),(27,16,110131,'\n                                                                Client One\n                                                            ',3,1,'Cr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:25:32'),(28,16,110132,'\n                                                                ABD 436\n                                                            ',2,1,'Dr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:25:32');
/*!40000 ALTER TABLE `financials_journal_voucher_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_journal_voucher_reference`
--

DROP TABLE IF EXISTS `financials_journal_voucher_reference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_journal_voucher_reference` (
  `jvr_id` int(11) NOT NULL AUTO_INCREMENT,
  `jvr_session` varchar(450) DEFAULT NULL,
  `jvr_business_name` varchar(450) DEFAULT NULL,
  `jvr_total_dr` double NOT NULL,
  `jvr_total_cr` double NOT NULL,
  `jvr_created_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `jvr_remarks` varchar(450) DEFAULT NULL,
  `jvr_day_end_id` int(11) DEFAULT NULL,
  `jvr_day_end_date` date DEFAULT NULL,
  `jvr_createdby` int(11) DEFAULT NULL,
  `jvr_detail_remarks` varchar(1000) DEFAULT NULL,
  `jvr_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `jvr_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `jvr_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`jvr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_journal_voucher_reference`
--

LOCK TABLES `financials_journal_voucher_reference` WRITE;
/*!40000 ALTER TABLE `financials_journal_voucher_reference` DISABLE KEYS */;
INSERT INTO `financials_journal_voucher_reference` VALUES (1,NULL,NULL,100,100,'2021-11-03 11:36:37','',1,'2021-09-29',1,'\n                                                                ABD 436\n                                                            , Dr@100.00&oS;\n                                                                ABD 436\n                                                            , Cr@100.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:36:37');
/*!40000 ALTER TABLE `financials_journal_voucher_reference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_journal_voucher_reference_items`
--

DROP TABLE IF EXISTS `financials_journal_voucher_reference_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_journal_voucher_reference_items` (
  `jvri_id` int(11) NOT NULL AUTO_INCREMENT,
  `jvri_journal_voucher_id` int(11) NOT NULL,
  `jvri_account_id` int(11) NOT NULL,
  `jvri_account_name` varchar(500) NOT NULL,
  `jvri_pr_id` int(11) DEFAULT NULL,
  `jvri_amount` double NOT NULL,
  `jvri_type` varchar(50) NOT NULL,
  `jvri_remarks` varchar(500) DEFAULT NULL,
  `jvri_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `jvri_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `jvri_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`jvri_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_journal_voucher_reference_items`
--

LOCK TABLES `financials_journal_voucher_reference_items` WRITE;
/*!40000 ALTER TABLE `financials_journal_voucher_reference_items` DISABLE KEYS */;
INSERT INTO `financials_journal_voucher_reference_items` VALUES (1,1,110132,'\n                                                                ABD 436\n                                                            ',1,100,'Dr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:36:37'),(2,1,110132,'\n                                                                ABD 436\n                                                            ',1,100,'Cr','','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:36:37');
/*!40000 ALTER TABLE `financials_journal_voucher_reference_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_language`
--

DROP TABLE IF EXISTS `financials_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_language` (
  `lan_id` int(11) NOT NULL AUTO_INCREMENT,
  `lan_title` varchar(250) NOT NULL,
  `lan_remarks` varchar(500) DEFAULT 'NULL',
  `lan_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `lan_createdby` int(11) DEFAULT NULL,
  `lan_day_end_id` int(11) DEFAULT NULL,
  `lan_day_end_date` date DEFAULT NULL,
  `lan_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `lan_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `lan_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `lan_delete_status` int(11) DEFAULT 0,
  `lan_deleted_by` int(11) DEFAULT NULL,
  `lan_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`lan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_language`
--

LOCK TABLES `financials_language` WRITE;
/*!40000 ALTER TABLE `financials_language` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_loan`
--

DROP TABLE IF EXISTS `financials_loan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_loan` (
  `loan_id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_department_id` int(11) DEFAULT NULL,
  `loan_account_id` int(11) DEFAULT NULL,
  `loan_total_amount` decimal(50,3) DEFAULT NULL,
  `loan_total_instalment` int(11) DEFAULT NULL,
  `loan_instalment_amount` decimal(50,3) DEFAULT NULL,
  `loan_first_payment_month` date DEFAULT NULL,
  `loan_last_payment_month` date DEFAULT NULL,
  `loan_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `loan_createdby` int(11) NOT NULL,
  `loan_day_end_id` int(11) NOT NULL,
  `loan_day_end_date` date NOT NULL,
  `loan_ip_adrs` varchar(255) NOT NULL,
  `loan_brwsr_info` varchar(4000) NOT NULL,
  `loan_update_datetime` datetime NOT NULL,
  PRIMARY KEY (`loan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_loan`
--

LOCK TABLES `financials_loan` WRITE;
/*!40000 ALTER TABLE `financials_loan` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_loan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_log`
--

DROP TABLE IF EXISTS `financials_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_code` int(11) DEFAULT NULL,
  `log_type` varchar(225) DEFAULT NULL,
  `log_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `log_created_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `log_createdby` int(11) DEFAULT NULL,
  `log_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `log_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_log`
--

LOCK TABLES `financials_log` WRITE;
/*!40000 ALTER TABLE `financials_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_main_units`
--

DROP TABLE IF EXISTS `financials_main_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_main_units` (
  `mu_id` int(11) NOT NULL AUTO_INCREMENT,
  `mu_title` varchar(500) NOT NULL,
  `mu_remarks` varchar(500) DEFAULT NULL,
  `mu_created_by` int(11) DEFAULT NULL,
  `mu_day_end_id` int(11) DEFAULT NULL,
  `mu_day_end_date` date DEFAULT NULL,
  `mu_datetime` timestamp NULL DEFAULT current_timestamp(),
  `mu_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `mu_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `mu_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `mu_delete_status` int(11) DEFAULT 0,
  `mu_deleted_by` int(11) DEFAULT NULL,
  `mu_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`mu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_main_units`
--

LOCK TABLES `financials_main_units` WRITE;
/*!40000 ALTER TABLE `financials_main_units` DISABLE KEYS */;
INSERT INTO `financials_main_units` VALUES (1,'Number',NULL,0,0,'2021-10-29','2021-10-29 06:56:23','','','2021-10-29 11:56:23',0,NULL,0),(2,'Weight',NULL,0,0,'2021-10-29','2021-10-29 06:56:23','','','2021-10-29 11:56:23',0,NULL,0),(3,'Measurement',NULL,0,0,'2021-10-29','2021-10-29 06:56:23','','','2021-10-29 11:56:23',0,NULL,0);
/*!40000 ALTER TABLE `financials_main_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_modular_config_defination`
--

DROP TABLE IF EXISTS `financials_modular_config_defination`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_modular_config_defination` (
  `mcd_id` int(11) NOT NULL AUTO_INCREMENT,
  `mcd_code` int(11) DEFAULT NULL,
  `mcd_title` varchar(1000) DEFAULT NULL,
  `mcd_parent_code` int(11) DEFAULT NULL,
  `mcd_level` varchar(1) DEFAULT NULL,
  `mcd_web_route` varchar(1000) DEFAULT NULL,
  `mcd_before_config` int(1) DEFAULT NULL,
  `mcd_after_config` int(1) DEFAULT NULL,
  `mcd_menu_arrangement` int(11) DEFAULT NULL,
  PRIMARY KEY (`mcd_id`),
  UNIQUE KEY `mcd_code` (`mcd_code`)
) ENGINE=InnoDB AUTO_INCREMENT=443 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_modular_config_defination`
--

LOCK TABLES `financials_modular_config_defination` WRITE;
/*!40000 ALTER TABLE `financials_modular_config_defination` DISABLE KEYS */;
INSERT INTO `financials_modular_config_defination` VALUES (1,1,'Invoices',0,'1','',0,1,1),(2,2,'Vouchers',0,'1','',0,1,2),(3,3,'Stock Movement',0,'1','',0,1,3),(4,4,'Manufacturing',0,'1','',0,1,4),(5,5,'Supply Chain',0,'1','',0,1,5),(6,6,'HR Module',0,'1','',0,1,6),(7,7,'Financials',0,'1','',0,1,7),(8,8,'Audit',0,'1','',0,0,8),(9,9,'Report',0,'1','',0,0,9),(10,10,'Back Up',0,'1','',0,0,10),(11,11,'Registration',0,'1','',1,1,11),(12,12,'KPI / Monitoring',0,'1','',0,0,12),(13,110,'Purchase',1,'2','',0,1,13),(14,111,'Sales',1,'2','',0,1,14),(15,210,'Cash',2,'2','',0,1,15),(17,212,'Bank',2,'2','',0,1,17),(18,213,'Journal Voucher',2,'2','',0,1,18),(19,214,'Employee',2,'2','',0,1,19),(20,311,'Internal Stock Transfer',3,'2','',0,1,20),(21,312,'Loss & Recover',3,'2','',0,1,21),(22,313,'Convert Quantity ',3,'2','',0,1,22),(23,314,'Calims',3,'2','',0,1,23),(24,410,'Product',4,'2','',0,1,24),(25,510,'Sale Order',5,'2','',0,1,25),(26,610,'Employee',6,'2','',0,1,26),(27,611,'Time management',6,'2','',0,0,27),(28,612,'CV Pool',6,'2','',0,0,28),(29,710,'Ledgers',7,'2','',0,1,29),(30,711,'Day Closing',7,'2','',0,1,30),(31,712,'Financial Presentations',7,'2','',0,0,31),(32,810,'Back Burner',8,'2','',0,0,32),(33,910,'Aging',9,'2','',0,1,33),(34,911,'Purchase Trends',9,'2','',0,0,34),(35,912,'Sales Trends',9,'2','',0,0,35),(36,913,'Expance Trends',9,'2','',0,0,36),(37,1010,'Backup',10,'2','',0,1,37),(38,1110,'Party Registration',11,'2','',1,1,38),(39,1111,'Account Registration',11,'2','',1,1,39),(40,1112,'General Registration',11,'2','',1,1,40),(41,1113,'Product Registration',11,'2','',1,1,41),(42,11010,'Purchase',110,'3','purchase_invoice',0,1,42),(43,11011,'Purchase List',110,'3','purchase_invoice_list',0,1,43),(44,11012,'Purchase (Tax) List',110,'3','sale_tax_purchase_invoice_list',0,1,44),(45,11013,'Purchase Return',110,'3','purchase_return_invoice',0,1,45),(46,11014,'Purchase Return List',110,'3','purchase_return_invoice_list',0,1,46),(47,11015,'Purchase (Tax) List',110,'3','sale_tax_purchase_return_invoice_list',0,1,47),(48,11110,'Sale Invoice',111,'3','sale_invoice',0,1,48),(49,11111,'Sale List',111,'3','sale_invoice_list',0,1,49),(50,11112,'Sale (Tax) List',111,'3','sale_tax_sale_invoice_list',0,1,50),(51,11115,'Sale Return',111,'3','sale_return_invoice',0,1,51),(52,11116,'Sale Return List',111,'3','sale_return_invoice_list',0,1,52),(53,11117,'Sale (Tax) List',111,'3','sale_tax_sale_return_invoice_list',0,1,53),(54,21010,'Cash Receipt Voucher',210,'3','cash_receipt_voucher',0,1,54),(55,21011,'Cash Receipt Voucher List',210,'3','cash_receipt_voucher_list',0,1,55),(56,21012,'Cash Payment Voucher',210,'3','cash_payment_voucher',0,1,56),(57,21013,'Cash Payment Voucher List',210,'3','cash_payment_voucher_list',0,1,57),(58,21110,'Cash Transfer Voucher',211,'3','',0,0,58),(59,21111,'Cash Received Voucher',211,'3','',0,0,59),(60,21112,'Cash Payment Voucher',211,'3','',0,0,60),(61,21210,'Bank Receipt Voucher',212,'3','bank_receipt_voucher',0,1,61),(62,21211,'Bank Receipt Voucher List',212,'3','bank_receipt_voucher_list',0,1,62),(63,21212,'Bank Payment Voucer',212,'3','bank_payment_voucher',0,1,63),(64,21213,'Bank Payment Voucer List',212,'3','bank_payment_voucher_list',0,1,64),(65,21214,'Post Dated Cheque Issuance',212,'3','add_post_dated_cheque_issue',0,1,65),(66,21215,'Cheque Issuance Pending Lsit',212,'3','post_dated_cheque_issue_list',0,1,66),(67,21216,'Cheque Issuance Confirmed List',212,'3','approve_post_dated_cheque_issue_list',0,1,67),(68,21217,'Cheque Issuance Rejected List',212,'3','reject_post_dated_cheque_issue_list',0,1,68),(69,21218,'Post Dated Cheque Receive',212,'3','add_post_dated_cheque_received',0,1,69),(70,21219,'Cheque Receive Pending List',212,'3','post_dated_cheque_received_list',0,1,70),(71,21220,'Cheque Receive Confirmed List',212,'3','approve_post_dated_cheque_received_list',0,1,71),(72,21221,'Cheque Receive Rejected List',212,'3','reject_post_dated_cheque_received_list',0,1,72),(73,21310,'Journal Voucher',213,'3','journal_voucher',0,1,73),(74,21311,'Journal Voucher List',213,'3','journal_voucher_list',0,1,74),(75,21312,'Parties Reference Voucher',213,'3','journal_voucher_reference',0,1,75),(76,61010,'Advance Salary voucher',610,'3','add_new_advance_salary',0,1,76),(77,61011,'Advance Salary voucher List',610,'3','advance_salary_list',0,1,77),(78,61012,'Generate salary slip',610,'3','generate_salary_slip_voucher',0,1,78),(79,61013,'Generate salary slip List',610,'3','generate_salary_slip_voucher_list',0,1,79),(80,31110,'Warehouse Transfer',311,'3','add_transfer_product_stock',0,1,80),(81,31111,'Warehouse Transfer List',311,'3','transfer_product_stock_list',0,1,81),(82,31210,'Product Lost',312,'3','product_loss',0,1,82),(83,31211,'Product Lost List',312,'3','product_loss_list',0,1,83),(84,31212,'Product Recover',312,'3','product_recover',0,1,84),(85,31213,'Product Recover List',312,'3','product_recover_list',0,1,85),(86,31310,'Create Convert Quantity',313,'3','convert_quantity',0,1,86),(87,31311,'Convert Quantity List',313,'3','convert_quantity_list',0,1,87),(88,31410,'Genrate Claim Stock',314,'3','convert_quantity',0,0,88),(89,31411,'',314,'3','',0,0,89),(90,31412,'Calim Issuance to Vender',314,'3','add_claim_stock_issue_to_party',0,1,90),(91,31413,'Calim Issuance to Vender List',314,'2','',0,0,91),(92,31414,'Calim Receive from Vender',314,'3','add_claim_stock_receive',0,1,92),(93,31415,'Calim Receive from Vender List',314,'3','',0,0,93),(94,41010,'Receipe',410,'3','product_recipe',0,1,94),(95,41011,'Receipe List',410,'','product_recipe_list',0,1,95),(96,41012,'Workorder Create',410,'3','work_order.create',0,1,96),(97,41013,'Stock Issue for processing',410,'3','',0,0,97),(98,41014,'Workorder List',410,'3','work_order.index',0,1,98),(99,41015,'Start Process',410,'3','',0,0,99),(100,41016,'Complete Process',410,'3','',0,0,100),(101,51010,'Sales Order',510,'3','sale_order',0,1,101),(102,51011,'List',510,'3','sale_order_list',0,1,102),(103,51012,'Confirmation',510,'3','',0,0,103),(104,61014,'Salary Payment Voucher',610,'3','new_salary_payment_voucher',0,1,104),(105,61015,'Salary Payment Voucher List',610,'3','salary_payment_list',0,1,105),(106,61110,'Time managemnt',611,'3','',0,0,106),(107,61210,'CV Pool',612,'3','',0,0,107),(108,71010,'Parties Ledger',710,'3','parties_account_ledger',0,1,108),(109,71011,'Account Ledger',710,'3','chart_of_account_ledger',0,1,109),(110,71110,'Day Closing Execution',711,'3','start_day_end',0,1,110),(111,71210,'Trial Balance',712,'3','trial_balance',0,0,111),(112,71211,'Income Statement',712,'3','income_statement',0,0,112),(113,71212,'Balance Sheet',712,'3','balance_sheet',0,0,113),(114,71213,'Cash Flow',712,'3','',0,0,114),(115,71214,'Change to Owner Equity',712,'3','',0,0,115),(116,91010,'Party Aging (Lager)',910,'3','',0,0,116),(117,91011,'Party Aging (Invoice)',910,'3','',0,0,117),(118,91012,'Product Aging',910,'3','',0,0,118),(119,91110,'Product Trend (Purchase)',911,'3','',0,0,119),(120,91111,'Party Wise Trend (Purchase)',911,'3','',0,0,120),(121,91210,'Product Trend (Sales)',912,'3','',0,0,121),(122,91211,'Salesman Trend (Sales)',912,'3','',0,0,122),(123,91212,'Region Wise Sales',912,'3','',0,0,123),(124,91213,'Timeline Sales (Days/ Month)',912,'3','',0,0,124),(125,91214,'Timeline Sales (Hour)',912,'3','',0,0,125),(126,91310,'Head Wise Expense Trends',913,'3','',0,0,126),(127,91311,'Expense % Income Wise',913,'3','',0,0,127),(128,111010,'Region',1110,'3','add_region',1,1,128),(129,111011,'Region List',1110,'3','region_list',1,1,129),(130,111012,'Area',1110,'3','add_area',1,1,130),(131,111013,'Area List',1110,'3','area_list',1,1,131),(132,111014,'Sector',1110,'3','add_sector',1,1,132),(134,111016,'Town',1110,'3','add_town',1,1,134),(135,111017,'Town List',1110,'3','town_list',1,1,135),(136,111018,'Client',1110,'3','receivables_account_registration',1,1,136),(137,111019,'Client List',1110,'3','account_receivable_payable_simple_list',1,1,137),(138,111020,'Supplier',1110,'3','payables_account_registration',1,1,138),(139,111021,'Supplier List',1110,'3','account_receivable_payable_simple_list',1,1,139),(140,111110,'Bank Account',1111,'3','bank_account_registration',1,1,140),(141,111111,'Bank Account List',1111,'3','bank_account_list',1,1,141),(142,111112,'Salary Account',1111,'3','salary_account_registration',1,1,142),(143,111113,'Salary Account List',1111,'3','salary_account_list',1,1,143),(144,111114,'Expense Account',1111,'3','expense_account_registration',1,1,144),(145,111115,'Expense Account List',1111,'3','expense_account_list',1,1,145),(146,111116,'Chart of Account Tree',1111,'3','first_level_chart_of_account',1,1,146),(147,111117,'Group Account',1111,'3','add_second_level_chart_of_account',1,1,147),(148,111118,'Group Account List',1111,'3','second_level_chart_of_account_list',1,1,148),(149,111119,'Parent Account',1111,'3','add_third_level_chart_of_account',1,1,149),(150,111120,'Parent Account List',1111,'3','third_level_chart_of_account_list',1,1,150),(151,111121,'Account Reporting Group',1111,'3','add_account_group',1,1,151),(152,111122,'Account Reporting Group List',1111,'3','account_group_list',1,1,152),(153,111123,'Entry Account',1111,'3','account_registration',1,1,153),(154,111124,'Entry Account List',1111,'3','account_list',1,1,154),(155,111125,'Asset Registration',1111,'3','fixed_asset',1,1,155),(156,111126,'Asset Registration List',1111,'3','fixed_asset_list',1,1,156),(157,111127,'Capital Registration',1111,'3','capital_registration',1,1,157),(158,111128,'Capital Registration List',1111,'3','capital_registration_list',1,1,158),(159,111210,'Cash Transfer',1112,'3','cash_transfer',0,1,159),(160,111211,'Cash Transfer Pending List',1112,'3','pending_cash_transfer_list',0,1,160),(161,111212,'Cash Transfer Approve List',1112,'3','approve_cash_transfer_list',0,1,161),(162,111213,'Cash Transfer Reject List',1112,'3','reject_cash_transfer_list',0,1,162),(163,111214,'Credit Card Machine',1112,'3','add_credit_card_machine',1,1,163),(164,111215,'Credit Card Machine List',1112,'3','credit_card_machine_list',1,1,164),(165,111216,'Warehouse',1112,'3','add_warehouse',1,1,165),(166,111217,'Warehouse List',1112,'3','warehouse_list',1,1,166),(167,111218,'Employee',1112,'3','add_employee',1,1,167),(168,111219,'Employee List',1112,'3','employee_list',1,1,168),(169,111310,'Product Reporting Group',1113,'3','product_group',1,1,169),(170,111311,'Product Reporting Group List',1113,'3','product_group_list',1,1,170),(171,111312,'Main Unit',1113,'3','add_main_unit',1,1,171),(172,111313,'Main Unit List',1113,'3','main_unit_list',1,1,172),(173,111314,'Unit',1113,'3','add_unit',1,1,173),(174,111315,'Unit List',1113,'3','unit_list',1,1,174),(175,111316,'Group',1113,'3','add_group',1,1,175),(176,111317,'Group List',1113,'3','group_list',1,1,176),(177,111318,'Category',1113,'3','add_category',1,1,177),(178,111319,'Category List',1113,'3','category_list',1,1,178),(179,111320,'Brand',1113,'3','add_brand',1,1,179),(180,111321,'Brand List',1113,'3','brand_list',1,1,180),(181,111322,'Product',1113,'3','add_product',1,1,181),(182,111323,'Product List',1113,'3','product_list',1,1,182),(183,111325,'Services',1113,'3','add_services',1,1,183),(184,111326,'Services List',1113,'3','services_list',1,1,184),(185,111327,'Product Clubbing',1113,'3','product_clubbing',1,1,185),(186,111328,'Product Clubbing List',1113,'3','product_clubbing_list',1,1,186),(187,111329,'Product Packages',1113,'3','product_packages',1,1,187),(188,111330,'Product Packages List',1113,'3','product_packages_list',1,1,188),(189,11113,'Service Invoice List',111,'3','services_invoice_list',0,1,189),(190,11114,'Service Invoice (Tax) List',111,'3','service_tax_invoice_list',0,1,190),(191,71111,'Day End Reports',711,'3','day_end_reports',0,1,191),(192,111015,'Sector List',1110,'3','sector_list',1,1,192),(193,21222,'Credit Card Machine Settlement',212,'3','credit_card_machine_settlement',0,1,193),(194,111220,'Modular Group',1112,'3','add_modular_group',1,1,194),(195,111221,'Modular Group List',1112,'3','modular_group_list',1,1,195),(198,13,'Product Additional Details',0,'1',NULL,1,1,198),(199,1310,'Book Details',13,'2',NULL,1,1,199),(200,131010,'Publisher',1310,'3','add_publisher',1,1,200),(201,131011,'Publisher List',1310,'3','publisher_list',1,1,201),(202,131012,'Topic',1310,'3','add_topic',1,1,202),(203,131013,'Topic List',1310,'3','topic_list',1,1,203),(204,131014,'Class',1310,'3','add_class',1,1,204),(205,131015,'Class List',1310,'3','class_list',1,1,205),(206,131016,'Currency',1310,'3','add_currency',1,1,206),(207,131017,'Currency List',1310,'3','currency_list',1,1,207),(208,131018,'Language',1310,'3','add_language',1,1,208),(209,131019,'Language List',1310,'3','language_list',1,1,209),(210,1310110,'Imprint',1310,'3','add_imPrint',1,1,210),(211,1310111,'Imprint List',1310,'3','imPrint_list',1,1,211),(212,1310112,'Illustrated',1310,'3','add_illustrated',1,1,212),(213,1310113,'Illustrated List',1310,'3','illustrated_list',1,1,213),(214,1310114,'Author',1310,'3','add_author',1,1,214),(215,1310115,'Author List',1310,'3','author_list',1,1,215),(216,1310116,'Genre',1310,'3','add_genre',1,1,216),(217,1310117,'Genre List',1310,'3','genre_list',1,1,217),(218,1310118,'Product Details',1310,'3','add_product_details',1,1,218),(219,1310119,'Product Detail List',1310,'3','product_details_list',1,1,219),(222,14,'Pump',0,'1',NULL,0,1,222),(223,1410,'Pump Menu',14,'2',NULL,0,1,223),(224,141010,'Tank List',1410,'3','tank_list',1,1,224),(225,141011,'Nozzle',1410,'3','add_nozzle',1,1,225),(226,141012,'Nozzle List',1410,'3','nozzle_list',1,1,226),(227,141013,'Dip Reading',1410,'3','add_dip_reading',1,1,227),(228,141014,'Dip Reading List',1410,'3','dip_reading_list',1,1,228),(229,141015,'Nozzle Reading',1410,'3','add_nozzle_reading',1,1,229),(230,141016,'Tank Receiving',1410,'3','add_tank_receiving',1,1,230),(231,141017,'Tank Receiving List',1410,'3','tank_receiving_list',1,1,231),(232,141018,'Sale Invoice',1410,'3','pso_sale_invoice',1,1,232),(233,141019,'Sale Invoice List',1410,'3','pso_sale_invoice_list',1,1,233),(234,1410110,'Unit Testing',1410,'3','unit_testing',1,1,234),(235,1410111,'Unit Testing List',1410,'3','unit_testing_list',1,1,235),(236,1410112,'Meter Replacement',1410,'3','meter_replacement',1,1,236),(237,1410113,'Meter Replacement List',1410,'3','meter_replacement_list',1,1,237),(241,215,'Expense',2,'2',NULL,0,1,NULL),(242,21510,'Expense Payment Voucher',215,'3','expense_payment_voucher',0,1,NULL),(243,21511,'Expense Payment Voucher List',215,'3','expense_payment_voucher_list',0,1,NULL),(244,111331,'Product Ledger Stock Wise List',1113,'3','product_ledger_stock_wise',1,1,NULL),(245,1410114,'Tank',1410,'3','add_tank',1,1,NULL),(246,15,'FineAd',0,'1',NULL,0,1,NULL),(247,1510,'FineAd Menu',15,'2',NULL,0,1,NULL),(248,151010,'Company',1510,'3','regions.create',0,0,NULL),(249,151011,'Company List',1510,'3','regions.create',0,0,NULL),(250,151012,'Zone',1510,'3','regions.create',1,1,NULL),(253,151013,'Zone List',1510,'3','regions.list',1,1,NULL),(254,151014,'Region',1510,'3','zones.create',1,1,NULL),(255,151015,'Region List',1510,'3','zones.list',1,1,NULL),(256,151016,'City',1510,'3','cities.create',1,1,NULL),(257,151017,'City List',1510,'3','cities.index',1,1,NULL),(258,151018,'Grid',1510,'3','grids.create',1,1,NULL),(259,151019,'Grid List',1510,'3','grids.list',1,1,NULL),(260,151020,'Franchise',1510,'3','franchise-area.create',1,1,NULL),(261,151021,'Franchise List',1510,'3','franchise-area.list',1,1,NULL),(262,151022,'Circle',1510,'3','circles.create',0,0,NULL),(263,151023,'Circle List',1510,'3','circles.index',0,0,NULL),(264,111332,'Product Wise Ledger',1113,'3','product_wise_ledger',1,1,NULL),(266,111333,'Product Ledger Amount Wise',1113,'3','product_ledger_amount_wise',1,1,NULL),(267,71012,'Customer Aging Report',710,'3','customer_aging_report',0,1,NULL),(268,71013,'Supplier Aging Report',710,'3','supplier_aging_report',0,1,NULL),(270,111324,'Product Price List',1113,'3','product_price_update',1,1,NULL),(271,1511,'Project Purchase',15,'2',NULL,0,1,NULL),(272,151101,'Purchase Order',1511,'3','purchase_order',1,1,NULL),(273,151104,'Product Measurement Configuration',1511,'3','product_measurement_config',1,1,NULL),(274,151106,'Order List Item',1511,'3','order_list',1,1,NULL),(275,151108,'Survey Working Area\r\n',1511,'3','survey_work_area',1,1,NULL),(276,151202,'Survey Pending List',1512,'3','survey_pending_list',1,1,NULL),(277,151204,'Survey Reject List',1512,'3','survey_reject_list',1,1,NULL),(278,151205,'Designer Working Area',1512,'3','designer_list',1,1,NULL),(279,151024,'Surveyor User',1510,'3','surveyor.create',1,1,NULL),(280,151102,'Purchase Order List',1511,'3','purchase_order_list',1,1,NULL),(281,111222,'Department Create',1112,'3','departments.create',1,1,NULL),(282,111223,'Department List',1112,'3','departments.index',1,1,NULL),(283,21223,'Bank Journal Voucher',212,'3','journal_voucher_bank',1,1,NULL),(284,151026,'Assign Surveyor Username',1510,'3','assign_username',1,1,NULL),(285,151027,'Assign Surveyor Username List',1510,'3','assign_username_list',1,1,NULL),(286,151025,'Surveyor User List',1510,'3','surveyor.index',1,1,NULL),(287,151105,'Product Measurement Configuration List',1511,'3','product_measurement_config_list',1,1,NULL),(288,151107,'Order Items List',1511,'3','order_items_list',1,1,NULL),(289,151109,'Surveyor Working Area List',1511,'3','survey_work_area_list',1,1,NULL),(290,151203,'Survey Approved List',1512,'3','survey_approve_list',1,1,NULL),(291,151110,'Surveyor Working Area List',1511,'3','survey_working_area_list',0,0,NULL),(292,151206,'Designer Pending List',1512,'3','designer_pending_list',1,1,NULL),(293,216,'Approval Journal Voucher',2,'2',NULL,NULL,1,NULL),(294,21610,'Approval Journal Voucher',216,'3','approval_journal_voucher',1,1,NULL),(295,21611,'Approval Journal Voucher List',216,'3','approval_journal_voucher_list',1,1,NULL),(296,21612,'Approval Journal Voucher All List',216,'3','approval_journal_voucher_all_list',1,1,NULL),(297,21613,'Approval Journal Voucher Approved List',216,'3','approval_journal_voucher_approved_list',1,1,NULL),(298,21614,'Approval Journal Voucher Rejected List',216,'3','approval_journal_voucher_rejected_list',1,1,NULL),(299,21615,'Approval Journal Voucher Bank',216,'3','approval_journal_voucher_bank',1,1,NULL),(300,21616,'Approval Journal Voucher Reference',216,'3','approval_journal_voucher_reference',1,1,NULL),(301,511,'Delivery Order',5,'2',NULL,0,1,NULL),(302,51110,'Delivery Order',511,'3','delivery_order',1,1,NULL),(303,51111,'Delivery Order List',511,'3','delivery_order_invoice_list',1,1,NULL),(304,51112,'Delivery Order Sale Invoice',511,'3','delivery_order_sale_invoice',1,1,NULL),(305,512,'Delivery Challan',5,'2',NULL,0,1,NULL),(306,51210,'Delivery Challan',512,'1','delivery_challan',1,1,NULL),(307,51211,'Delivery Challan List',512,'3','delivery_challan_list',1,1,NULL),(308,151201,'Survey List',1512,'3','survey_list',0,0,NULL),(309,71014,'Daily Activity Report',710,'3','today_report_list',1,1,NULL),(310,310,'Supply Chain',0,'1',NULL,0,0,NULL),(311,21313,'Journal Voucher Reference List',213,'3','journal_voucher_reference_list',1,1,NULL),(312,513,'Goods Receipt Note',5,'2',NULL,0,1,NULL),(313,51310,'Goods Receipt Note',513,'3','goods_receipt_note',1,1,NULL),(314,51311,'Goods Receipt Note List',513,'3','goods_receipt_note_list',1,1,NULL),(315,51312,'Goods Receipt Note Purchase Invoice',513,'3','grn_purchase_invoice',1,1,NULL),(316,713,'Database Backup',7,'2',NULL,0,1,NULL),(317,71310,'Database Backup',713,'3','db_backup',1,1,NULL),(318,61016,'Loan',610,'3','add_loan',1,1,NULL),(319,61017,'Loan List',610,'3','loan_list',1,1,NULL),(322,112,'Trade Purchase',1,'2',NULL,0,1,NULL),(323,113,'Trade Sale',1,'2',NULL,0,1,NULL),(324,11310,'Sale Invoice',113,'3','trade_sale_invoice',1,1,NULL),(325,11311,'Sale Invoice List',113,'3','trade_sale_invoice_list',1,1,NULL),(328,11312,'Sale Tax Invoice',113,'3','trade_sale_tax_invoice',1,1,NULL),(329,11313,'Sale Tax Invoice List',113,'3','trade_sale_tax_sale_invoice_list',1,1,NULL),(330,11314,'Sale Return Invoice',113,'3','trade_sale_return_invoice',1,1,NULL),(331,11315,'Sale Return Invoice List',113,'3','trade_sale_return_invoice_list',1,1,NULL),(332,11316,'Sale Tax Return Invoice',113,'3','trade_sale_tax_return_invoice',1,1,NULL),(333,11317,'Sale Tax Return Invoice List',113,'3','trade_sale_tax_sale_return_invoice_list',1,1,NULL),(334,11210,'Purchase Invoice',112,'3','trade_purchase_invoice',1,1,NULL),(335,11211,'purchase Invoice List',112,'3','trade_purchase_invoice_list',1,1,NULL),(336,11212,'Purchase Tax Invoice',112,'3','trade_purchase_tax_invoice',1,1,NULL),(337,11213,'purchase tax Invoice List',112,'3','trade_sale_tax_purchase_invoice_list',1,1,NULL),(338,11214,'Purchase Return Invoice',112,'3','trade_purchase_return_invoice',1,1,NULL),(339,11215,'purchase Return Invoice List',112,'3','trade_purchase_return_invoice_list',1,1,NULL),(340,11216,'Purchase Tax Return Invoice',112,'3','trade_purchase_tax_return_invoice',1,1,NULL),(341,11217,'purchase Tax Return Invoice List',112,'3','trade_sale_tax_purchase_return_invoice_list',1,1,NULL),(342,151028,'Board Type',1510,'3','add_board_type',0,0,NULL),(343,151029,'Board Type List',1510,'3','board_type_list',1,1,NULL),(344,151030,'Board Material ',1510,'3','add_board_material',0,0,NULL),(345,151031,'Board Material List',1510,'3','board_material_list',0,0,NULL),(346,151032,'Assign Board Material',1510,'3','assign_board_material',1,1,NULL),(347,151033,'Assign Board Material List',1510,'3','assign_board_material_list',1,1,NULL),(348,151301,'Pipe Width Calibration ',1513,'3','add_width_calibration',1,1,NULL),(349,151302,'Pipe Width Calibration List',1513,'3','width_calibration_list',1,1,NULL),(350,151303,'Pipe Length Calibration',1513,'3','add_length_calibration',1,1,NULL),(351,151304,'Pipe Length Calibration List',1513,'3','length_calibration_list',1,1,NULL),(352,151305,'Angle Calibration ',1513,'3','add_angle_calibration',1,1,NULL),(353,151306,'Angle Calibration List',1513,'3','angle_calibration_list',1,1,NULL),(354,151207,'Designer Approved List',1512,'3','designer_approved_list',1,1,NULL),(355,151208,'Designer Rejected List',1512,'3','designer_rejected_list',1,1,NULL),(356,514,'Trade Delivery Order',5,'2',NULL,0,1,NULL),(357,515,'Trade Delivery Challan',5,'2',NULL,0,1,NULL),(358,516,'Trade Goods Receipt Note',5,'2',NULL,0,1,NULL),(359,51410,'Trade Delivery Order',514,'3','trade_delivery_order',1,1,NULL),(360,51412,'Trade Delivery Sale Invoice',514,'3','trade_delivery_order_sale_invoice',1,1,NULL),(361,51413,'Trade Delivery Order Sale Tax Invoice',514,'3','trade_delivery_order_sale_tax_invoice',1,1,NULL),(362,51510,'Trade Delivery Challan',515,'3','trade_delivery_challan',1,1,NULL),(366,51610,'Trade Goods Receipt Note',516,'3','trade_goods_receipt_note',1,1,NULL),(367,51612,'Trade Goods Receipt Note Purchase Invoice',516,'2','trade_grn_purchase_invoice',1,1,NULL),(368,51613,'Trade Goods Receipt Note Purchase Tax Invoice',516,'2','trade_grn_purchase_tax_invoice',1,1,NULL),(369,51511,'Delivery Challan List',515,'3','trade_delivery_challan_list',1,1,NULL),(370,51411,'Delivery Order List',514,'3','trade_delivery_order_invoice_list',1,1,NULL),(371,51611,'Goods Receipt Note List',516,'3','trade_goods_receipt_note_list',1,1,NULL),(372,61018,'Month Wise Salary List',610,'3','month_wise_salary_detail_list',1,1,NULL),(373,315,'Trade Internal Stock Transfer',3,'2',NULL,0,1,NULL),(374,31511,'Warehouse Transfer',315,'3','add_trade_transfer_product_stock',1,1,NULL),(375,31512,'Warehouse Transfer List',315,'3','trade_transfer_product_stock_list',1,1,NULL),(376,316,'Trade Loss & Recover',3,'2',NULL,0,1,NULL),(377,31611,'Product Lost',316,'3','trade_product_loss',1,1,NULL),(378,31612,'Product Lost List',316,'3','trade_product_loss_list',1,1,NULL),(379,31613,'Product Recover',316,'3','trade_product_recover',1,1,NULL),(380,31614,'Product Recover List',316,'3','trade_product_recover_list',1,1,NULL),(381,317,'Trade Convert Quantity',3,'2',NULL,0,1,NULL),(382,31711,'Create Convert Quantity',317,'3','trade_convert_quantity',1,1,NULL),(383,31712,'Convert Quantity List',317,'3','trade_convert_quantity_list',1,1,NULL),(386,318,'Trade Claims',3,'2',NULL,0,1,NULL),(387,31810,'Trade Claim Issuance to Vender',318,'3','add_trade_claim_stock_issue_to_party',1,1,NULL),(388,31811,'Trade Trade Claim Issuance to Vender List',318,'3','trade_claim_stock_issue_to_party_list',1,1,NULL),(389,31812,'Trade Claim Receive from Vender',318,'3','add_trade_claim_stock_receive',1,1,NULL),(390,31813,'Trade Claim Receive from Vender List',318,'3','trade_claim_stock_receive_list',1,1,NULL),(393,111334,'Trade Product Packages',1113,'3','trade_product_packages',1,1,NULL),(394,111335,'Trade Product Packages List',1113,'3','trade_product_packages_list',1,1,NULL),(395,151401,'Create Batch',1514,'3','create_batch',1,1,NULL),(396,1517,'Trade Sale Order',5,'2','',1,1,NULL),(397,151710,'Trade Sale Order',1517,'3','trade_sale_order',1,1,NULL),(398,151711,'Trade Sale Order List',1517,'3','sale_order_list',1,1,NULL),(399,151712,'Trade Sale Order Delivery Order',1517,'3','trade_so_to_do_invoice',1,1,NULL),(400,151713,'Trade Sale Order Sale Invoice',1517,'3','trade_sale_order_sale_invoice',1,1,NULL),(401,151714,'Trade Sale Order Delivery Order Sale Invoice',1517,'3','trade_sale_order_delivery_order_sale_invoice',1,1,NULL),(402,1512,'Approvals',15,'2',NULL,1,1,NULL),(404,1513,'Calibrations',15,'2',NULL,1,1,NULL),(405,151402,'Batch List',1514,'3','batch_list',1,1,NULL),(406,151403,'Update Batch',1514,'3','edit_batch',1,1,NULL),(407,151404,'Batch Recipe ',1514,'3','product_batch_recipe',1,1,NULL),(408,151405,'Batch Recipe List',1514,'3','product_batch_recipe_list',1,1,NULL),(409,151406,'Batch Work Order',1514,'3','batch_work_order.create',1,1,NULL),(410,1518,'Inward',5,'2',NULL,1,1,NULL),(411,1519,'Outward',5,'2',NULL,1,1,NULL),(412,151810,'Stock Inward',1518,'3','stock_inward',1,1,NULL),(413,151811,'Stock Inward List',1518,'3','stock_inward_list',1,1,NULL),(414,151910,'Stock Outward',1519,'3','stock_outward',1,1,NULL),(415,151911,'Stock Outward List',1519,'3','stock_outward_list',1,1,NULL),(416,217,'Approval Journal Voucher Project List',2,'2',NULL,1,1,NULL),(417,21710,'Approval Journal Voucher Project List',217,'3','approval_journal_voucher_project_list',1,1,NULL),(418,21711,'Approval Journal Voucher All Project List',217,'3','approval_journal_voucher_all_project_list',1,1,NULL),(419,21712,'Approval Journal Voucher Approved Project List',217,'3','approval_journal_voucher_approved_project_list',1,1,NULL),(420,21713,'Journal Voucher Rejected Project List',217,'3','approval_journal_voucher_rejected_project_list',1,1,NULL),(421,151103,'Edit Purchase Order',1511,'3','edit_purchase_order',1,1,NULL),(422,111224,'City',1112,'3','add_city',1,1,NULL),(423,111225,'City List',1112,'3','city_list',1,1,NULL),(424,151407,'Batch Work Order List',1514,'3','batch_work_order.index',1,1,NULL),(425,151408,'Third Party Work Order',1514,'3','third_party_work_order.create',1,1,NULL),(426,151409,'Third Party Work Order List',1514,'3','third_party_work_order.index',1,1,NULL),(427,1514,'Manufacturing',15,'2',NULL,1,1,NULL),(428,41017,'Production Stock Adjustment',410,'3','production_stock_adjustment',1,1,NULL),(429,16,'Reports',0,'1',NULL,0,1,NULL),(430,1610,'Reports',16,'2',NULL,0,1,NULL),(431,161010,'Client & Supplier Reports',1610,'3','account_receivable_payable_list',0,1,NULL),(432,151209,'Execution List',1512,'3','execution_list',1,1,NULL),(433,17,'System Configuration',0,'1',NULL,0,1,NULL),(434,1710,'Configuration',17,'2',NULL,0,1,NULL),(435,171010,'Day End Configuration',1710,'3','day_end_config',0,1,NULL),(436,171011,'Invoice Configuration',1710,'3','report_config',0,1,NULL),(437,161011,'Product Margin Reports',1610,'3','product_margin_report',1,1,NULL),(438,18,'Softagic',0,'1',NULL,NULL,1,NULL),(439,1810,'Software Package',18,'2',NULL,NULL,1,NULL),(440,181010,'Software Package',1810,'3','software_package',1,1,NULL),(441,111226,'Posting Reference',1112,'3','add_posting_reference',1,1,NULL),(442,111227,'Posting Reference List',1112,'3','posting_reference_list',1,1,NULL);
/*!40000 ALTER TABLE `financials_modular_config_defination` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_modular_groups`
--

DROP TABLE IF EXISTS `financials_modular_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_modular_groups` (
  `mg_id` int(11) NOT NULL AUTO_INCREMENT,
  `mg_title` varchar(500) NOT NULL,
  `mg_remarks` varchar(1000) DEFAULT NULL,
  `mg_first_level_config` text DEFAULT NULL,
  `mg_second_level_config` text DEFAULT NULL,
  `mg_config` text NOT NULL,
  `mg_created_by` int(11) NOT NULL,
  `mg_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mg_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `mg_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `mg_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `mg_delete_status` int(11) DEFAULT 0,
  `mg_deleted_by` int(11) DEFAULT NULL,
  `mg_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`mg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_modular_groups`
--

LOCK TABLES `financials_modular_groups` WRITE;
/*!40000 ALTER TABLE `financials_modular_groups` DISABLE KEYS */;
INSERT INTO `financials_modular_groups` VALUES (1,'Accounts','','1,2,3,4,5,6,7,11,15,16,18','110,111,112,113,217,311,312,313,314,315,316,317,318,410,1517,1518,1519,610,710,711,713,1110,1111,1112,1113,1512,1513,1514,1610,1810','11010,11011,11012,11013,11014,11015,11110,11111,11112,11113,11114,11115,11116,11117,11210,11211,11212,11213,11214,11215,11216,11217,11310,11311,11312,11313,11314,11315,11316,11317,21710,21711,21712,21713,31110,31111,31210,31211,31212,31213,31310,31311,31412,31414,31511,31512,31611,31612,31613,31614,31711,31712,31810,31811,31812,31813,41010,41011,41012,41014,41017,151710,151711,151712,151713,151714,151810,151811,151910,151911,61010,61011,61012,61013,61014,61015,61016,61017,61018,71010,71011,71012,71013,71014,71110,71111,71310,111010,111011,111012,111013,111014,111015,111016,111017,111018,111019,111020,111021,111110,111111,111112,111113,111114,111115,111116,111117,111118,111119,111120,111121,111122,111123,111124,111125,111126,111127,111128,111214,111215,111216,111217,111218,111219,111220,111221,111222,111223,111224,111225,111310,111311,111312,111313,111314,111315,111316,111317,111318,111319,111320,111321,111322,111323,111324,111325,111326,111327,111328,111329,111330,111331,111332,111333,111334,111335,151201,151202,151203,151204,151205,151206,151207,151208,151209,151301,151302,151303,151304,151305,151306,151401,151402,151403,151404,151405,151406,151407,151408,151409,161010,161011,181010',2,'2021-10-29 08:41:50','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:41:50',0,NULL,0);
/*!40000 ALTER TABLE `financials_modular_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_nozzle`
--

DROP TABLE IF EXISTS `financials_nozzle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_nozzle` (
  `noz_id` int(11) NOT NULL AUTO_INCREMENT,
  `noz_name` varchar(500) NOT NULL,
  `noz_remarks` text NOT NULL,
  `noz_tank_id` int(11) NOT NULL,
  `noz_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `noz_createdby` int(11) NOT NULL,
  `noz_day_end_id` int(11) DEFAULT NULL,
  `noz_day_end_date` date DEFAULT NULL,
  `noz_ip_adrs` varchar(255) DEFAULT NULL,
  `noz_brwsr_info` varchar(4000) DEFAULT NULL,
  `noz_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`noz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_nozzle`
--

LOCK TABLES `financials_nozzle` WRITE;
/*!40000 ALTER TABLE `financials_nozzle` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_nozzle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_nozzle_reading`
--

DROP TABLE IF EXISTS `financials_nozzle_reading`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_nozzle_reading` (
  `nr_id` int(11) NOT NULL AUTO_INCREMENT,
  `nr_employee_id` int(11) DEFAULT NULL,
  `nr_reading_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nr_nozzle_id` int(11) DEFAULT NULL,
  `nr_system_reading` double DEFAULT 0,
  `nr_reading` double DEFAULT NULL,
  `nr_remarks` text DEFAULT NULL,
  `nr_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nr_createdby` int(11) DEFAULT NULL,
  `nr_day_end_id` int(11) DEFAULT NULL,
  `nr_day_end_date` date DEFAULT NULL,
  `nr_pre_reading_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nr_pre_reading` double DEFAULT NULL,
  `nr_difference` double DEFAULT NULL,
  `nr_status` int(11) DEFAULT 0,
  `nr_ip_adrs` varchar(255) DEFAULT NULL,
  `nr_brwsr_info` varchar(4000) DEFAULT NULL,
  `nr_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`nr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_nozzle_reading`
--

LOCK TABLES `financials_nozzle_reading` WRITE;
/*!40000 ALTER TABLE `financials_nozzle_reading` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_nozzle_reading` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_opening_trial_balance`
--

DROP TABLE IF EXISTS `financials_opening_trial_balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_opening_trial_balance` (
  `tb_id` int(11) NOT NULL AUTO_INCREMENT,
  `tb_account_id` int(11) NOT NULL,
  `tb_account_name` varchar(500) NOT NULL,
  `tb_total_debit` decimal(50,2) NOT NULL,
  `tb_total_credit` decimal(50,2) NOT NULL,
  `tb_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `tb_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `tb_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `tb_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`tb_id`),
  UNIQUE KEY `tb_account_id` (`tb_account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_opening_trial_balance`
--

LOCK TABLES `financials_opening_trial_balance` WRITE;
/*!40000 ALTER TABLE `financials_opening_trial_balance` DISABLE KEYS */;
INSERT INTO `financials_opening_trial_balance` VALUES (2,110101,'Cash',15230.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(3,110102,'Independant - SALEMAN - CASH',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(4,110111,'Stock',51361098.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(5,110121,'Meezan',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(6,110131,'Client One',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(7,110132,'ABD 436',63000.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(8,110141,'Adv - Ahmad Hasan',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(9,110151,'Input Tax',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(10,110161,'Walk In Customer',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(11,110171,'Client One Claims',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(12,110172,'Supplier One Claims',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(13,110181,'Meezan Credit Card Machine',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(14,111101,'Air Conditioner Gree 1.5 Ton Invertor',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(15,111102,'Acc. Dep. Air Conditioner Gree 1.5 Ton Invertor',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(16,112101,'Suspense',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(17,210101,'Supplier One',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(18,210102,'Xyz 889',0.00,900000.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(19,210111,'FBR Output Tax(Tax Payable)',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(20,210112,'Province Output Tax(Tax Payable)',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(21,210121,'Purchaser',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(22,211101,'Suspense',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(23,510101,'Capital - Ahmad Hasan',0.00,50000000.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(24,510102,'Profit & Loss - Ahmad Hasan',0.00,600000.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(25,510103,'Drawing - Ahmad Hasan',60672.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(26,510104,'Reserve - Ahmad Hasan',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05'),(27,512101,'Undistributed Profit & Loss',0.00,0.00,'2021-10-29 08:34:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:05');
/*!40000 ALTER TABLE `financials_opening_trial_balance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_package`
--

DROP TABLE IF EXISTS `financials_package`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_package` (
  `pak_id` int(11) NOT NULL AUTO_INCREMENT,
  `pak_name` varchar(50) NOT NULL DEFAULT 'Basic',
  `pak_total_user` int(11) NOT NULL DEFAULT 1,
  `pak_user_id` int(11) NOT NULL,
  `pak_datetime` timestamp NULL DEFAULT NULL,
  `pak_update_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `pak_ip_adrs` varchar(255) NOT NULL,
  `pak_brwsr_info` varchar(4000) NOT NULL,
  PRIMARY KEY (`pak_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_package`
--

LOCK TABLES `financials_package` WRITE;
/*!40000 ALTER TABLE `financials_package` DISABLE KEYS */;
INSERT INTO `financials_package` VALUES (1,'Basic',2,1,NULL,'2021-11-10 13:27:45','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69');
/*!40000 ALTER TABLE `financials_package` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_party_claims`
--

DROP TABLE IF EXISTS `financials_party_claims`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_party_claims` (
  `pc_id` int(11) NOT NULL AUTO_INCREMENT,
  `pc_type` varchar(50) NOT NULL,
  `pc_party_claim_account` int(11) NOT NULL,
  `pc_pr_id` int(11) DEFAULT NULL,
  `pc_purchase_invoice_num` int(11) DEFAULT NULL,
  `pc_sale_return_invoice_num` int(11) DEFAULT NULL,
  `pc_claim_issue_voucher_num` int(11) DEFAULT NULL,
  `pc_remarks` varchar(2500) NOT NULL,
  `pc_detail_remarks` varchar(4000) DEFAULT '',
  `pc_total_amount` decimal(50,2) NOT NULL,
  `pc_user_id` int(11) NOT NULL,
  `pc_day_end_id` int(11) NOT NULL,
  `pc_day_end_date` date NOT NULL,
  `pc_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `pc_ip_adrs` varchar(100) DEFAULT NULL,
  `pc_brwsr_info` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`pc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_party_claims`
--

LOCK TABLES `financials_party_claims` WRITE;
/*!40000 ALTER TABLE `financials_party_claims` DISABLE KEYS */;
INSERT INTO `financials_party_claims` VALUES (2,'CLAIM ISSUE',110172,2,NULL,NULL,NULL,'sdfsdf','Daal Chawal, 1@3,600.00\n',3600.00,1,1,'2021-09-29','2021-11-06 09:47:29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69'),(3,'CLAIM RECEIVED',110171,2,NULL,NULL,NULL,'dfsdf','Daal Chawal, 1@3,600.00\n',3600.00,1,1,'2021-09-29','2021-11-06 10:11:52','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69'),(4,'CLAIM RECEIVED',110171,3,NULL,NULL,NULL,'fsfdf','Daal Chawal, 40.000@160,000.00\n',160000.00,1,1,'2021-09-29','2021-11-06 10:12:20','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69'),(5,'CLAIM ISSUE',110171,2,NULL,NULL,NULL,'fdsfds','Daal Chawal, 40.000@160,000.00\n',160000.00,1,1,'2021-09-29','2021-11-06 10:13:46','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69');
/*!40000 ALTER TABLE `financials_party_claims` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_party_claims_items`
--

DROP TABLE IF EXISTS `financials_party_claims_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_party_claims_items` (
  `pci_id` int(11) NOT NULL AUTO_INCREMENT,
  `pci_pc_id` int(11) NOT NULL,
  `pci_product_code` varchar(500) NOT NULL,
  `pci_product_name` varchar(1500) NOT NULL,
  `pci_remarks` varchar(2500) DEFAULT NULL,
  `pci_warehouse_id` int(11) NOT NULL DEFAULT 0,
  `pci_warehouse_name` varchar(500) NOT NULL DEFAULT '',
  `pci_qty` decimal(50,3) NOT NULL,
  `pci_scale_size` int(11) DEFAULT NULL,
  `pci_uom` varchar(255) DEFAULT NULL,
  `pci_rate` decimal(50,2) NOT NULL,
  `pci_amount` decimal(50,2) NOT NULL,
  PRIMARY KEY (`pci_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_party_claims_items`
--

LOCK TABLES `financials_party_claims_items` WRITE;
/*!40000 ALTER TABLE `financials_party_claims_items` DISABLE KEYS */;
INSERT INTO `financials_party_claims_items` VALUES (2,2,'400','Daal Chawal','',1,'Main Store',1.000,40,'Gattu',3600.00,3600.00),(3,3,'400','Daal Chawal','',1,'Main Store',1.000,40,'Gattu',3600.00,3600.00),(4,4,'400','Daal Chawal',NULL,1,'Main Store',40.000,40,'Gattu',4000.00,160000.00),(5,5,'400','Daal Chawal',NULL,1,'Main Store',40.000,40,'Gattu',4000.00,160000.00);
/*!40000 ALTER TABLE `financials_party_claims_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_post_dated_cheques`
--

DROP TABLE IF EXISTS `financials_post_dated_cheques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_post_dated_cheques` (
  `pdc_id` int(11) NOT NULL AUTO_INCREMENT,
  `pdc_type` varchar(50) NOT NULL,
  `pdc_status` varchar(45) NOT NULL,
  `pdc_party_code` int(11) NOT NULL,
  `pdc_account_code` int(11) NOT NULL,
  `pdc_pr_id` int(11) DEFAULT NULL,
  `pdc_amount` double NOT NULL,
  `pdc_remarks` varchar(1000) DEFAULT NULL,
  `pdc_cheque_date` date NOT NULL,
  `pdc_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `pdc_created_by` int(11) NOT NULL,
  `pdc_reason` varchar(1000) DEFAULT NULL,
  `pdc_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `pdc_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `pdc_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`pdc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_post_dated_cheques`
--

LOCK TABLES `financials_post_dated_cheques` WRITE;
/*!40000 ALTER TABLE `financials_post_dated_cheques` DISABLE KEYS */;
INSERT INTO `financials_post_dated_cheques` VALUES (1,'ISSUED','CONFIRMED',110131,110121,NULL,120,'','2021-11-11','2021-11-03 09:43:32',1,NULL,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:43:32'),(2,'ISSUED','CONFIRMED',110131,110121,1,1200,'','2021-11-04','2021-11-04 11:44:17',1,NULL,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 16:44:17'),(3,'ISSUED','CONFIRMED',110131,110121,3,1,'','2021-11-04','2021-11-04 11:52:21',1,NULL,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 16:52:21'),(4,'RECEIVED','CONFIRMED',110132,110121,2,2,'','2021-11-04','2021-11-04 12:21:28',1,NULL,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:21:28');
/*!40000 ALTER TABLE `financials_post_dated_cheques` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_posting_reference`
--

DROP TABLE IF EXISTS `financials_posting_reference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_posting_reference` (
  `pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `pr_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `pr_remarks` varchar(1000) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `pr_datetime` timestamp NULL DEFAULT current_timestamp(),
  `pr_createdby` int(11) DEFAULT NULL,
  `pr_day_end_id` int(11) DEFAULT NULL,
  `pr_day_end_date` date DEFAULT NULL,
  `pr_ip_adrs` varchar(255) DEFAULT NULL,
  `pr_brwsr_info` varchar(4000) DEFAULT NULL,
  `pr_update_datetime` datetime DEFAULT current_timestamp(),
  `pr_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`pr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_posting_reference`
--

LOCK TABLES `financials_posting_reference` WRITE;
/*!40000 ALTER TABLE `financials_posting_reference` DISABLE KEYS */;
INSERT INTO `financials_posting_reference` VALUES (1,'Universal Posting','','2021-10-30 07:21:34',1,1,'2021-09-29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-30 12:21:34',0),(2,'Post','','2021-11-03 13:27:45',1,1,'2021-09-29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:27:45',0),(3,'Abc Ref Post','','2021-11-03 13:27:54',1,1,'2021-09-29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:27:54',0);
/*!40000 ALTER TABLE `financials_posting_reference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_primary_finished_goods`
--

DROP TABLE IF EXISTS `financials_primary_finished_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_primary_finished_goods` (
  `pfg_id` int(11) NOT NULL AUTO_INCREMENT,
  `pfg_odr_id` int(11) NOT NULL,
  `pfg_pro_code` varchar(500) NOT NULL,
  `pfg_pro_name` varchar(1000) NOT NULL,
  `pfg_pro_remarks` text DEFAULT NULL,
  `pfg_uom` varchar(1000) NOT NULL,
  `pfg_recipe_production_qty` decimal(50,2) NOT NULL,
  `pfg_stock_before_production` decimal(50,2) NOT NULL,
  `pfg_stock_after_production` decimal(50,2) NOT NULL,
  PRIMARY KEY (`pfg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_primary_finished_goods`
--

LOCK TABLES `financials_primary_finished_goods` WRITE;
/*!40000 ALTER TABLE `financials_primary_finished_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_primary_finished_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_produced_stock`
--

DROP TABLE IF EXISTS `financials_produced_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_produced_stock` (
  `ps_id` int(11) NOT NULL AUTO_INCREMENT,
  `ps_psa_id` int(11) DEFAULT NULL,
  `ps_pro_code` varchar(1000) DEFAULT NULL,
  `ps_pro_title` varchar(1000) DEFAULT NULL,
  `ps_warehouse_id` int(11) DEFAULT NULL,
  `ps_warehouse_name` varchar(500) DEFAULT NULL,
  `ps_remarks` varchar(1000) DEFAULT NULL,
  `ps_quantity` decimal(50,3) DEFAULT NULL,
  `ps_rate` decimal(50,2) DEFAULT NULL,
  `ps_amount` decimal(50,2) DEFAULT NULL,
  `ps_uom` varchar(500) DEFAULT NULL,
  `ps_scale_size` int(11) DEFAULT NULL,
  `ps_status` text DEFAULT 'Produced',
  PRIMARY KEY (`ps_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_produced_stock`
--

LOCK TABLES `financials_produced_stock` WRITE;
/*!40000 ALTER TABLE `financials_produced_stock` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_produced_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_product_costing`
--

DROP TABLE IF EXISTS `financials_product_costing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_product_costing` (
  `pc_id` int(11) NOT NULL AUTO_INCREMENT,
  `pc_pro_id` varchar(500) NOT NULL,
  `pc_pro_cost` double NOT NULL,
  `pc_pro_quantity` int(11) NOT NULL,
  `pc_day_end_id` int(11) NOT NULL,
  `pc_day_end_date` date NOT NULL,
  `pc_created_date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`pc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_product_costing`
--

LOCK TABLES `financials_product_costing` WRITE;
/*!40000 ALTER TABLE `financials_product_costing` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_product_costing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_product_detail`
--

DROP TABLE IF EXISTS `financials_product_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_product_detail` (
  `pd_id` int(11) NOT NULL AUTO_INCREMENT,
  `pd_pro_code` varchar(1000) NOT NULL,
  `pd_pro_name` varchar(1000) NOT NULL,
  `pd_publisher` int(11) DEFAULT NULL,
  `pd_author_ids` varchar(4000) DEFAULT '',
  `pd_topic` int(11) DEFAULT NULL,
  `pd_class` int(11) DEFAULT NULL,
  `pd_currency` int(11) DEFAULT NULL,
  `pd_language` int(11) DEFAULT NULL,
  `pd_imprint` int(11) DEFAULT NULL,
  `pd_illustrated` int(11) DEFAULT NULL,
  `pd_genre_ids` varchar(4000) DEFAULT '',
  `pd_remarks` text DEFAULT NULL,
  `pd_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pd_createdby` int(11) NOT NULL,
  `pd_day_end_id` int(11) NOT NULL,
  `pd_day_end_date` datetime NOT NULL,
  `pd_ip_adrs` varchar(255) NOT NULL,
  `pd_brwsr_info` varchar(4000) NOT NULL,
  `pd_update_datetime` timestamp NULL DEFAULT NULL,
  `pd_delete_status` int(11) DEFAULT 0,
  `pd_deleted_by` int(11) DEFAULT NULL,
  `pd_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`pd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_product_detail`
--

LOCK TABLES `financials_product_detail` WRITE;
/*!40000 ALTER TABLE `financials_product_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_product_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_product_group`
--

DROP TABLE IF EXISTS `financials_product_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_product_group` (
  `pg_id` int(11) NOT NULL AUTO_INCREMENT,
  `pg_title` varchar(1000) NOT NULL,
  `pg_remarks` varchar(1000) NOT NULL,
  `pg_day_end_date` date DEFAULT NULL,
  `pg_day_end_id` int(11) DEFAULT NULL,
  `pg_created_by` int(11) NOT NULL,
  `pg_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `pg_ip_adrs` varchar(255) NOT NULL DEFAULT '''''',
  `pg_brwsr_info` varchar(4000) NOT NULL DEFAULT '''''',
  `pg_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `pg_delete_status` int(11) DEFAULT 0,
  `pg_deleted_by` int(11) DEFAULT NULL,
  `pg_disabled` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`pg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_product_group`
--

LOCK TABLES `financials_product_group` WRITE;
/*!40000 ALTER TABLE `financials_product_group` DISABLE KEYS */;
INSERT INTO `financials_product_group` VALUES (1,'Managerial Group','','2021-10-29',0,0,'2021-10-29 06:56:23','\'\'','\'\'','2021-10-29 11:56:23',0,NULL,0),(2,'Sales Group','','2021-10-29',0,0,'2021-10-29 06:56:23','\'\'','\'\'','2021-10-29 11:56:23',0,NULL,0),(3,'Purchase Group','','2021-10-29',0,0,'2021-10-29 06:56:23','\'\'','\'\'','2021-10-29 11:56:23',0,NULL,0),(4,'Accounts Group','','2021-10-29',0,0,'2021-10-29 06:56:23','\'\'','\'\'','2021-10-29 11:56:23',0,NULL,0),(5,'Cashier Group','','2021-10-29',0,0,'2021-10-29 06:56:23','\'\'','\'\'','2021-10-29 11:56:23',0,NULL,0);
/*!40000 ALTER TABLE `financials_product_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_product_loss_recover`
--

DROP TABLE IF EXISTS `financials_product_loss_recover`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_product_loss_recover` (
  `plr_id` int(11) NOT NULL AUTO_INCREMENT,
  `plr_account_uid` int(11) NOT NULL,
  `plr_account_name` varchar(500) DEFAULT NULL,
  `plr_pr_id` int(11) DEFAULT NULL,
  `plr_pro_total_item` int(11) NOT NULL,
  `plr_pro_total_amount` double NOT NULL DEFAULT 0,
  `plr_remarks` varchar(500) DEFAULT '',
  `plr_user_id` int(11) NOT NULL,
  `plr_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `plr_status` varchar(100) NOT NULL,
  `plr_day_end_id` int(11) DEFAULT NULL,
  `plr_day_end_date` date DEFAULT NULL,
  `plr_detail_remarks` varchar(1000) DEFAULT NULL,
  `plr_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `plr_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `plr_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`plr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_product_loss_recover`
--

LOCK TABLES `financials_product_loss_recover` WRITE;
/*!40000 ALTER TABLE `financials_product_loss_recover` DISABLE KEYS */;
INSERT INTO `financials_product_loss_recover` VALUES (2,410101,'Product Loss & Recover',2,1,108,'Recover',1,'2021-11-04 13:39:21','RECOVER',1,'2021-09-29','Lays Rs. 5, 2@54.00 = 108&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:39:21'),(3,410101,'Product Loss & Recover',3,1,54,'Lose',1,'2021-11-04 13:40:05','LOSS',1,'2021-09-29','Lays Rs. 5, 1@54.00 = 54&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:05'),(4,410101,'Product Loss & Recover',2,40,128000,'Loss',1,'2021-11-04 13:40:43','LOSS',1,'2021-09-29','Suger, 40.000@3200.00 = 128000&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:43'),(10,410101,'Product Loss & Recover',2,40,128000,'Rec',1,'2021-11-04 13:58:08','RECOVER',1,'2021-09-29','Suger, 40.000@3200.00 = 128000&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:58:08'),(11,410101,'Product Loss & Recover',1,1,86400,'Ghy',1,'2021-11-06 09:33:27','LOSS',1,'2021-09-29','Daal Chawal, 24@3600.00 = 86400&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:33:27'),(12,410101,'Product Loss & Recover',1,1,180000,'Kju',1,'2021-11-06 09:35:54','RECOVER',1,'2021-09-29','Daal Chawal, 50@3600.00 = 180000&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:35:54');
/*!40000 ALTER TABLE `financials_product_loss_recover` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_product_loss_recover_items`
--

DROP TABLE IF EXISTS `financials_product_loss_recover_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_product_loss_recover_items` (
  `plri_id` int(11) NOT NULL AUTO_INCREMENT,
  `plri_plr_id` int(11) NOT NULL,
  `plri_warehouse_id` int(11) DEFAULT 0,
  `plri_pro_id` varchar(500) NOT NULL,
  `plri_pro_name` varchar(500) DEFAULT NULL,
  `plri_pro_purchase_price` double NOT NULL,
  `plri_scale_size` tinyint(4) DEFAULT NULL,
  `plri_pro_qty` decimal(50,3) NOT NULL DEFAULT 0.000,
  `plri_pro_total_amount` double NOT NULL,
  `plri_remarks` varchar(500) NOT NULL,
  `plri_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `plri_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `plri_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`plri_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_product_loss_recover_items`
--

LOCK TABLES `financials_product_loss_recover_items` WRITE;
/*!40000 ALTER TABLE `financials_product_loss_recover_items` DISABLE KEYS */;
INSERT INTO `financials_product_loss_recover_items` VALUES (2,2,1,'300','Lays Rs. 5',54,NULL,2.000,108,'','','','2021-11-04 18:39:21'),(3,3,1,'300','Lays Rs. 5',54,NULL,1.000,54,'','','','2021-11-04 18:40:05'),(4,4,1,'100','Suger',3200,40,40.000,128000,'','','','2021-11-04 18:40:43'),(10,10,1,'100','Suger',3200,40,40.000,128000,'','','','2021-11-04 18:58:08'),(11,11,1,'400','Daal Chawal',3600,NULL,24.000,86400,'','','','2021-11-06 14:33:27'),(12,12,1,'400','Daal Chawal',3600,NULL,50.000,180000,'','','','2021-11-06 14:35:54');
/*!40000 ALTER TABLE `financials_product_loss_recover_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_product_manufacture`
--

DROP TABLE IF EXISTS `financials_product_manufacture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_product_manufacture` (
  `pm_id` int(11) NOT NULL AUTO_INCREMENT,
  `pm_account_code` varchar(1000) DEFAULT NULL,
  `pm_account_name` varchar(1000) DEFAULT NULL,
  `pm_pro_code` varchar(1000) DEFAULT NULL,
  `pm_pro_name` varchar(1000) DEFAULT NULL,
  `pm_qty` decimal(50,3) NOT NULL DEFAULT 0.000,
  `pm_remarks` text DEFAULT NULL,
  `pm_total_items` int(11) DEFAULT NULL,
  `pm_total_pro_amount` decimal(50,2) NOT NULL,
  `pm_total_expense_accounts` int(11) DEFAULT 0,
  `pm_total_expense_amount` decimal(50,2) NOT NULL,
  `pm_grand_total` decimal(50,2) NOT NULL,
  `pm_status` varchar(1000) NOT NULL,
  `pm_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pm_complete_datetime` date DEFAULT NULL,
  `pm_day_end_id` int(11) NOT NULL,
  `pm_day_end_date` datetime NOT NULL,
  `pm_createdby` int(11) NOT NULL,
  `pm_ip_adrs` varchar(100) NOT NULL,
  `pm_brwsr_info` varchar(1000) NOT NULL,
  `pm_update_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pm_reject_reason` text DEFAULT NULL,
  PRIMARY KEY (`pm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_product_manufacture`
--

LOCK TABLES `financials_product_manufacture` WRITE;
/*!40000 ALTER TABLE `financials_product_manufacture` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_product_manufacture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_product_manufacture_expense`
--

DROP TABLE IF EXISTS `financials_product_manufacture_expense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_product_manufacture_expense` (
  `pme_id` int(11) NOT NULL AUTO_INCREMENT,
  `pme_product_manufacture_id` int(11) NOT NULL,
  `pme_account_code` varchar(100) NOT NULL,
  `pme_account_name` varchar(1000) NOT NULL,
  `pme_amount` decimal(50,2) NOT NULL,
  PRIMARY KEY (`pme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_product_manufacture_expense`
--

LOCK TABLES `financials_product_manufacture_expense` WRITE;
/*!40000 ALTER TABLE `financials_product_manufacture_expense` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_product_manufacture_expense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_product_manufacture_items`
--

DROP TABLE IF EXISTS `financials_product_manufacture_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_product_manufacture_items` (
  `pmi_id` int(11) NOT NULL AUTO_INCREMENT,
  `pmi_product_manufacture_id` int(11) NOT NULL,
  `pmi_product_code` varchar(100) NOT NULL,
  `pmi_product_name` varchar(1000) NOT NULL,
  `pmi_qty` decimal(50,3) NOT NULL,
  `pmi_rate` decimal(50,2) NOT NULL,
  `pmi_amount` decimal(50,2) NOT NULL,
  PRIMARY KEY (`pmi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_product_manufacture_items`
--

LOCK TABLES `financials_product_manufacture_items` WRITE;
/*!40000 ALTER TABLE `financials_product_manufacture_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_product_manufacture_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_product_packages`
--

DROP TABLE IF EXISTS `financials_product_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_product_packages` (
  `pp_id` int(11) NOT NULL AUTO_INCREMENT,
  `pp_name` varchar(250) NOT NULL,
  `pp_remarks` varchar(500) DEFAULT 'NULL',
  `pp_total_items` decimal(50,2) DEFAULT NULL,
  `pp_total_price` decimal(50,2) NOT NULL,
  `pp_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `pp_day_end_id` int(11) DEFAULT NULL,
  `pp_day_end_date` date DEFAULT NULL,
  `pp_createdby` int(11) DEFAULT NULL,
  `pp_ip_adrs` varchar(255) NOT NULL DEFAULT '''''',
  `pp_brwsr_info` varchar(4000) NOT NULL DEFAULT '''''',
  `pp_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `pp_delete_status` int(11) DEFAULT 0,
  `pp_deleted_by` int(11) DEFAULT NULL,
  `pp_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`pp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_product_packages`
--

LOCK TABLES `financials_product_packages` WRITE;
/*!40000 ALTER TABLE `financials_product_packages` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_product_packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_product_packages_items`
--

DROP TABLE IF EXISTS `financials_product_packages_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_product_packages_items` (
  `ppi_id` int(11) NOT NULL AUTO_INCREMENT,
  `ppi_pro_pack_id` int(11) NOT NULL,
  `ppi_product_code` varchar(500) NOT NULL,
  `ppi_product_name` varchar(250) NOT NULL,
  `ppi_remarks` varchar(500) NOT NULL,
  `ppi_qty` decimal(50,3) NOT NULL,
  `ppi_scale_size` int(11) DEFAULT NULL,
  `ppi_uom` varchar(255) DEFAULT NULL,
  `ppi_rate` decimal(50,2) NOT NULL,
  `ppi_amount` decimal(50,2) NOT NULL,
  `ppi_ip_adrs` varchar(255) NOT NULL DEFAULT '''''',
  `ppi_brwsr_info` varchar(4000) NOT NULL DEFAULT '''''',
  `ppi_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ppi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_product_packages_items`
--

LOCK TABLES `financials_product_packages_items` WRITE;
/*!40000 ALTER TABLE `financials_product_packages_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_product_packages_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_product_recipe`
--

DROP TABLE IF EXISTS `financials_product_recipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_product_recipe` (
  `pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `pr_name` varchar(1000) DEFAULT 'NULL',
  `pr_remarks` text DEFAULT NULL,
  `pr_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `pr_day_end_id` int(11) DEFAULT NULL,
  `pr_day_end_date` datetime DEFAULT NULL,
  `pr_createdby` int(11) DEFAULT NULL,
  `pr_ip_adrs` varchar(100) DEFAULT '''NULL''',
  `pr_brwsr_info` varchar(1000) DEFAULT '''NULL''',
  `pr_update_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pr_delete_status` int(11) DEFAULT 0,
  `pr_deleted_by` int(11) DEFAULT NULL,
  `pr_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`pr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_product_recipe`
--

LOCK TABLES `financials_product_recipe` WRITE;
/*!40000 ALTER TABLE `financials_product_recipe` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_product_recipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_product_recipe_items`
--

DROP TABLE IF EXISTS `financials_product_recipe_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_product_recipe_items` (
  `pri_id` int(11) NOT NULL AUTO_INCREMENT,
  `pri_product_recipe_id` int(11) NOT NULL,
  `pri_product_code` varchar(500) NOT NULL,
  `pri_product_name` varchar(250) NOT NULL,
  `pri_remarks` varchar(250) DEFAULT NULL,
  `pri_qty` decimal(50,3) NOT NULL,
  `pri_uom` varchar(1000) DEFAULT '',
  `pri_rate` decimal(50,2) NOT NULL,
  `pri_amount` decimal(50,2) NOT NULL,
  `pri_status` varchar(33) DEFAULT NULL,
  PRIMARY KEY (`pri_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_product_recipe_items`
--

LOCK TABLES `financials_product_recipe_items` WRITE;
/*!40000 ALTER TABLE `financials_product_recipe_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_product_recipe_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_product_transfer_history`
--

DROP TABLE IF EXISTS `financials_product_transfer_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_product_transfer_history` (
  `pth_id` int(11) NOT NULL AUTO_INCREMENT,
  `pth_product_code` varchar(500) NOT NULL,
  `pth_scale_size` tinyint(4) DEFAULT NULL,
  `pth_stock` decimal(50,3) NOT NULL,
  `pth_warehouse_to` int(11) NOT NULL,
  `pth_warehouse_from` int(11) NOT NULL,
  `pth_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `pth_user_id` int(11) NOT NULL,
  `pth_remarks` varchar(500) DEFAULT NULL,
  `pth_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `pth_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `pth_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `pth_day_end_id` int(11) DEFAULT NULL,
  `pth_day_end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`pth_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_product_transfer_history`
--

LOCK TABLES `financials_product_transfer_history` WRITE;
/*!40000 ALTER TABLE `financials_product_transfer_history` DISABLE KEYS */;
INSERT INTO `financials_product_transfer_history` VALUES (1,'300',12,5.000,3,1,'2021-11-06 08:55:00',1,'','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 13:55:00',1,'2021-09-29 00:00:00'),(2,'300',12,1.000,3,1,'2021-11-09 08:25:41',1,'','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 13:25:41',1,'2021-09-29 00:00:00'),(3,'200',6,1.000,2,1,'2021-11-09 10:52:57',1,'','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 15:52:56',1,'2021-09-29 00:00:00');
/*!40000 ALTER TABLE `financials_product_transfer_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_product_type`
--

DROP TABLE IF EXISTS `financials_product_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_product_type` (
  `pt_id` int(11) NOT NULL AUTO_INCREMENT,
  `pt_title` varchar(255) DEFAULT NULL,
  `pt_description` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`pt_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_product_type`
--

LOCK TABLES `financials_product_type` WRITE;
/*!40000 ALTER TABLE `financials_product_type` DISABLE KEYS */;
INSERT INTO `financials_product_type` VALUES (1,'Saleable Goods / Finish Goods','Sale Invoice , Sale Return Invoice , Loss Voucer , Recvoer Voucher , Transfer Voucher , DO , DC , SO , Production Finish Goods  , Gate Outward'),(2,'Purchase Able Goods / Raw Material','Purchase Invoice, Purchase Return Invoice Loss Voucer   Recvoer Voucher, Transfer Voucher, GRN, Gate Inward, Production Raw Material'),(3,'Trading Goods','Sale Invoice , Sale Return Invoice , Loss Voucer , Recvoer Voucher , Transfer Voucher , DO , DC , SO , Production Finish Goods  , Gate Outward\n\n\nPurchase Invoice , Purchase Return Invoice, Loss Voucer,  Recvoer Voucher, Transfer Voucher, GRN, Gate Inward, Production Raw Material '),(4,'By-Products','Sale Invoice , Sale Return Invoice , Transfer Voucher , DO , DC , SO , Production By-Products  , Gate Outward');
/*!40000 ALTER TABLE `financials_product_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_production`
--

DROP TABLE IF EXISTS `financials_production`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_production` (
  `prod_id` int(25) NOT NULL AUTO_INCREMENT,
  `prod_name` varchar(255) DEFAULT NULL,
  `prod_remarks` varchar(255) DEFAULT NULL,
  `prod_datetime` timestamp NULL DEFAULT NULL,
  `prod_day_end_id` int(11) DEFAULT NULL,
  `prod_day_end_date` datetime DEFAULT NULL,
  `prod_createdby` int(11) DEFAULT NULL,
  `prod_ip_adrs` varchar(100) DEFAULT NULL,
  `prod_brwsr_info` varchar(1000) DEFAULT NULL,
  `prod_update_datetime` timestamp NULL DEFAULT NULL,
  `prod_delete_status` int(11) DEFAULT NULL,
  `prod_deleted_by` int(11) DEFAULT NULL,
  `prod_disabled` int(11) DEFAULT NULL,
  `prod_detail_remarks` text NOT NULL,
  PRIMARY KEY (`prod_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_production`
--

LOCK TABLES `financials_production` WRITE;
/*!40000 ALTER TABLE `financials_production` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_production` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_production_items`
--

DROP TABLE IF EXISTS `financials_production_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_production_items` (
  `prodi_id` int(11) NOT NULL AUTO_INCREMENT,
  `prodi_prod_id` int(25) DEFAULT NULL,
  `prodi_product_code` varchar(255) DEFAULT NULL,
  `prodi_product_name` varchar(255) DEFAULT NULL,
  `prodi_remarks` varchar(255) DEFAULT NULL,
  `prodi_qty` decimal(50,3) DEFAULT NULL,
  `prodi_uom` varchar(255) DEFAULT NULL,
  `prodi_rate` decimal(50,3) DEFAULT NULL,
  `prodi_amount` decimal(50,3) DEFAULT NULL,
  `prodi_status` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`prodi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_production_items`
--

LOCK TABLES `financials_production_items` WRITE;
/*!40000 ALTER TABLE `financials_production_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_production_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_production_over_head`
--

DROP TABLE IF EXISTS `financials_production_over_head`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_production_over_head` (
  `poh_id` int(11) NOT NULL AUTO_INCREMENT,
  `poh_odr_id` int(11) NOT NULL,
  `poh_warehouse` varchar(1000) NOT NULL,
  `poh_department` int(11) NOT NULL,
  `poh_parties_clients` int(11) NOT NULL,
  `poh_supervisor` int(11) NOT NULL,
  `poh_remarks` text DEFAULT NULL,
  PRIMARY KEY (`poh_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_production_over_head`
--

LOCK TABLES `financials_production_over_head` WRITE;
/*!40000 ALTER TABLE `financials_production_over_head` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_production_over_head` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_production_over_head_items`
--

DROP TABLE IF EXISTS `financials_production_over_head_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_production_over_head_items` (
  `pohi_id` int(11) NOT NULL AUTO_INCREMENT,
  `pohi_poh_id` int(11) NOT NULL,
  `pohi_ser_code` int(11) NOT NULL,
  `pohi_ser_name` varchar(1000) NOT NULL,
  `pohi_ser_remarks` text DEFAULT NULL,
  `pohi_expense_account` int(11) NOT NULL,
  `pohi_rate` decimal(50,2) NOT NULL,
  `pohi_qty` decimal(50,2) NOT NULL,
  `pohi_uom` varchar(1000) NOT NULL,
  `pohi_amount` decimal(50,2) NOT NULL,
  PRIMARY KEY (`pohi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_production_over_head_items`
--

LOCK TABLES `financials_production_over_head_items` WRITE;
/*!40000 ALTER TABLE `financials_production_over_head_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_production_over_head_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_production_stock_adjustment`
--

DROP TABLE IF EXISTS `financials_production_stock_adjustment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_production_stock_adjustment` (
  `psa_id` int(11) NOT NULL AUTO_INCREMENT,
  `psa_account_uid` int(11) DEFAULT NULL,
  `psa_account_name` varchar(500) DEFAULT NULL,
  `psa_remarks` varchar(500) DEFAULT NULL,
  `psa_detail_remarks` varchar(2000) DEFAULT NULL,
  `psa_consumed_total_amount` decimal(50,2) DEFAULT NULL,
  `psa_produced_total_amount` decimal(50,2) DEFAULT NULL,
  `psa_user_id` int(11) NOT NULL,
  `psa_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `psa_day_end_id` int(11) DEFAULT NULL,
  `psa_day_end_date` date DEFAULT NULL,
  `psa_ip_adrs` varchar(255) DEFAULT NULL,
  `psa_brwsr_info` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`psa_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_production_stock_adjustment`
--

LOCK TABLES `financials_production_stock_adjustment` WRITE;
/*!40000 ALTER TABLE `financials_production_stock_adjustment` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_production_stock_adjustment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_products`
--

DROP TABLE IF EXISTS `financials_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_products` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_status` varchar(100) COLLATE utf8_croatian_ci NOT NULL DEFAULT 'ACTIVE',
  `pro_brand_id` int(11) DEFAULT 0,
  `pro_group_id` int(11) NOT NULL,
  `pro_category_id` int(11) NOT NULL,
  `pro_reporting_group_id` int(11) DEFAULT NULL,
  `pro_main_unit_id` int(11) DEFAULT 0,
  `pro_unit_id` int(11) DEFAULT 0,
  `pro_code` varchar(500) COLLATE utf8_croatian_ci NOT NULL DEFAULT '',
  `pro_p_code` varchar(500) COLLATE utf8_croatian_ci NOT NULL,
  `pro_alternative_code` varchar(500) COLLATE utf8_croatian_ci NOT NULL DEFAULT '',
  `pro_ISBN` varchar(500) COLLATE utf8_croatian_ci NOT NULL DEFAULT '',
  `pro_title` varchar(250) COLLATE utf8_croatian_ci NOT NULL,
  `pro_urdu_title` varchar(1000) COLLATE utf8_croatian_ci DEFAULT NULL,
  `pro_purchase_price` decimal(50,3) NOT NULL,
  `pro_sale_price` decimal(50,3) DEFAULT NULL,
  `pro_average_rate` decimal(50,3) DEFAULT 0.000,
  `pro_bottom_price` decimal(50,3) DEFAULT 0.000,
  `pro_last_purchase_rate` decimal(50,3) NOT NULL DEFAULT 0.000,
  `pro_min_quantity_alert` int(11) DEFAULT 0,
  `pro_allow_decimal` tinyint(4) DEFAULT 0,
  `pro_remarks` varchar(500) COLLATE utf8_croatian_ci DEFAULT NULL,
  `pro_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `pro_min_quantity` decimal(50,3) DEFAULT 0.000,
  `pro_expiry_date` timestamp NULL DEFAULT NULL,
  `pro_clubbing_codes` text COLLATE utf8_croatian_ci NOT NULL DEFAULT '',
  `pro_createdby` int(11) DEFAULT NULL,
  `pro_day_end_id` int(11) DEFAULT NULL,
  `pro_day_end_date` date DEFAULT NULL,
  `pro_type` int(11) DEFAULT 1,
  `pro_product_type_id` int(11) DEFAULT NULL,
  `pro_ip_adrs` varchar(255) COLLATE utf8_croatian_ci NOT NULL DEFAULT '',
  `pro_brwsr_info` varchar(4000) COLLATE utf8_croatian_ci NOT NULL DEFAULT '',
  `pro_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `pro_flag` tinyint(4) DEFAULT 0,
  `pro_qty_for_sale` decimal(50,3) NOT NULL DEFAULT 0.000,
  `pro_bonus_qty` decimal(50,3) NOT NULL DEFAULT 0.000,
  `pro_hold_qty` decimal(50,3) NOT NULL DEFAULT 0.000,
  `pro_claim_qty` decimal(50,3) NOT NULL DEFAULT 0.000,
  `pro_qty_wo_bonus` decimal(50,3) NOT NULL DEFAULT 0.000,
  `pro_quantity` decimal(50,3) DEFAULT 0.000,
  `pro_use_cat_fields` tinyint(4) DEFAULT 0,
  `pro_tax` decimal(50,2) DEFAULT 0.00,
  `pro_retailer_discount` decimal(50,2) DEFAULT 0.00,
  `pro_whole_seller_discount` decimal(50,2) DEFAULT 0.00,
  `pro_loyalty_card_discount` decimal(50,2) DEFAULT 0.00,
  `pro_hold_qty_per` decimal(50,2) DEFAULT 0.00,
  `pro_delete_status` int(11) DEFAULT 0,
  `pro_deleted_by` int(11) DEFAULT NULL,
  `pro_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`pro_id`),
  UNIQUE KEY `pro_p_code` (`pro_p_code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_products`
--

LOCK TABLES `financials_products` WRITE;
/*!40000 ALTER TABLE `financials_products` DISABLE KEYS */;
INSERT INTO `financials_products` VALUES (1,'ACTIVE',NULL,1,1,3,2,1,'100','100','','','Suger','',3200.000,3600.000,3200.000,0.000,3200.000,0,NULL,'','2021-10-29 08:16:11',0.000,NULL,'',1,0,'2021-10-29',1,2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:32:32',0,15793.000,0.000,121.000,0.000,15914.000,15914.000,0,0.00,0.00,0.00,0.00,0.00,0,NULL,0),(2,'ACTIVE',NULL,1,1,3,1,3,'200','200','','','Pepsi 1500 ML','',510.000,540.000,510.000,0.000,510.000,NULL,NULL,'','2021-10-29 08:17:04',0.000,'0000-00-00 00:00:00','',1,0,'2021-10-29',1,1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:32:32',0,80.000,0.000,8.000,0.000,88.000,88.000,0,0.00,0.00,0.00,0.00,0.00,0,NULL,0),(3,'ACTIVE',NULL,1,1,4,1,2,'300','300','','','Lays Rs. 5','',54.000,60.000,54.000,0.000,54.000,0,NULL,'','2021-10-29 08:19:35',0.000,NULL,'',1,0,'2021-10-29',1,3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:32:31',0,-16.000,0.000,1.000,0.000,-15.000,-15.000,0,0.00,0.00,0.00,0.00,0.00,0,NULL,0),(4,'ACTIVE',NULL,1,1,4,2,1,'400','400','','','Daal Chawal','',3600.000,4000.000,4000.000,0.000,4000.000,0,NULL,'','2021-11-06 09:25:27',0.000,NULL,'',1,1,'2021-09-29',1,3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:25:27',0,38.000,0.000,0.000,-164.000,-126.000,-126.000,0,0.00,0.00,0.00,0.00,0.00,0,NULL,0);
/*!40000 ALTER TABLE `financials_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_publisher`
--

DROP TABLE IF EXISTS `financials_publisher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_publisher` (
  `pub_id` int(11) NOT NULL AUTO_INCREMENT,
  `pub_title` varchar(250) NOT NULL,
  `pub_remarks` varchar(500) DEFAULT 'NULL',
  `pub_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `pub_createdby` int(11) DEFAULT NULL,
  `pub_day_end_id` int(11) DEFAULT NULL,
  `pub_day_end_date` date DEFAULT NULL,
  `pub_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `pub_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `pub_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `pub_delete_status` int(11) DEFAULT 0,
  `pub_deleted_by` int(11) DEFAULT NULL,
  `pub_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`pub_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_publisher`
--

LOCK TABLES `financials_publisher` WRITE;
/*!40000 ALTER TABLE `financials_publisher` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_publisher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_purchase_invoice`
--

DROP TABLE IF EXISTS `financials_purchase_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_purchase_invoice` (
  `pi_id` int(11) NOT NULL AUTO_INCREMENT,
  `pi_party_code` int(11) NOT NULL,
  `pi_party_name` varchar(250) NOT NULL,
  `pi_pr_id` int(11) DEFAULT NULL,
  `pi_customer_name` varchar(250) DEFAULT NULL,
  `pi_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `pi_total_items` int(11) DEFAULT NULL,
  `pi_total_price` decimal(50,2) NOT NULL,
  `pi_product_disc` decimal(50,2) DEFAULT 0.00,
  `pi_round_off_disc` decimal(50,2) DEFAULT NULL,
  `pi_cash_disc_per` decimal(50,2) DEFAULT 0.00,
  `pi_cash_disc_amount` decimal(50,2) DEFAULT 0.00,
  `pi_total_discount` decimal(50,2) DEFAULT 0.00,
  `pi_inclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `pi_exclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `pi_total_sales_tax` decimal(50,2) DEFAULT 0.00,
  `pi_grand_total` decimal(50,2) NOT NULL DEFAULT 0.00,
  `pi_cash_paid` decimal(50,2) DEFAULT 0.00,
  `pi_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `pi_day_end_id` int(11) DEFAULT NULL,
  `pi_day_end_date` date DEFAULT NULL,
  `pi_createdby` int(11) DEFAULT NULL,
  `pi_detail_remarks` text DEFAULT NULL,
  `pi_ip_adrs` varchar(255) NOT NULL,
  `pi_brwsr_info` varchar(4000) NOT NULL,
  `pi_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`pi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_purchase_invoice`
--

LOCK TABLES `financials_purchase_invoice` WRITE;
/*!40000 ALTER TABLE `financials_purchase_invoice` DISABLE KEYS */;
INSERT INTO `financials_purchase_invoice` VALUES (1,110132,'ABD 436',1,'','',2,108.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,108.00,NULL,'2021-11-03 10:00:52',1,'2021-09-29',1,'Lays Rs. 5, 1@54.00 = 54.00&oS;Lays Rs. 5, 1@54.00 = 54.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 15:00:52'),(2,110132,'ABD 436',1,'','',1,54.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,54.00,NULL,'2021-11-06 07:12:25',1,'2021-09-29',1,'Lays Rs. 5, 1@54.00 = 54.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:12:25'),(3,210101,'Supplier One',1,'','',20,72000.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,72000.00,NULL,'2021-11-06 09:27:45',1,'2021-09-29',1,'Daal Chawal, 20@3,600.00 = 72,000.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:27:45'),(4,110131,'Client One',1,'','',6,14508.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,14508.00,NULL,'2021-11-06 09:29:33',1,'2021-09-29',1,'Lays Rs. 5, 2@54.00 = 108.00&oS;Daal Chawal, 2@3,600.00 = 7,200.00&oS;Daal Chawal, 2@3,600.00 = 7,200.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:29:33'),(5,210101,'Supplier One',1,'','',100,400000.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,400000.00,NULL,'2021-11-09 11:57:01',1,'2021-09-29',1,'Daal Chawal, 100@4,000.00 = 400,000.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 16:57:01');
/*!40000 ALTER TABLE `financials_purchase_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_purchase_invoice_items`
--

DROP TABLE IF EXISTS `financials_purchase_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_purchase_invoice_items` (
  `pii_id` int(11) NOT NULL AUTO_INCREMENT,
  `pii_purchase_invoice_id` int(11) NOT NULL,
  `pii_product_code` varchar(500) NOT NULL,
  `pii_product_name` varchar(250) NOT NULL,
  `pii_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `pii_qty` decimal(50,3) NOT NULL,
  `pii_uom` varchar(500) DEFAULT '',
  `pii_scale_size` tinyint(4) DEFAULT NULL,
  `pii_rate` decimal(50,2) NOT NULL,
  `pii_bonus_qty` decimal(50,3) DEFAULT 0.000,
  `pii_discount_per` decimal(50,2) DEFAULT 0.00,
  `pii_discount_amount` decimal(50,2) DEFAULT 0.00,
  `pii_after_dis_rate` decimal(50,2) DEFAULT NULL,
  `pii_net_rate` decimal(50,2) DEFAULT 0.00,
  `pii_saletax_per` decimal(50,2) DEFAULT NULL,
  `pii_saletax_inclusive` tinyint(1) DEFAULT 0,
  `pii_saletax_amount` decimal(50,2) DEFAULT 0.00,
  `pii_amount` decimal(50,2) NOT NULL,
  `pii_warehouse_id` int(11) DEFAULT NULL,
  `pii_created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`pii_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_purchase_invoice_items`
--

LOCK TABLES `financials_purchase_invoice_items` WRITE;
/*!40000 ALTER TABLE `financials_purchase_invoice_items` DISABLE KEYS */;
INSERT INTO `financials_purchase_invoice_items` VALUES (1,1,'300','Lays Rs. 5',NULL,1.000,'Carton',12,54.00,0.000,0.00,0.00,54.00,54.00,0.00,0,0.00,54.00,1,'2021-11-03 10:00:52'),(2,1,'300','Lays Rs. 5',NULL,1.000,'Carton',12,54.00,0.000,0.00,0.00,54.00,54.00,0.00,0,0.00,54.00,1,'2021-11-03 10:00:52'),(3,2,'300','Lays Rs. 5',NULL,1.000,'Carton',12,54.00,0.000,0.00,0.00,54.00,54.00,0.00,0,0.00,54.00,1,'2021-11-06 07:12:25'),(4,3,'400','Daal Chawal',NULL,20.000,'Gattu',40,3600.00,0.000,0.00,0.00,3600.00,3600.00,0.00,0,0.00,72000.00,1,'2021-11-06 09:27:45'),(5,4,'300','Lays Rs. 5',NULL,2.000,'Carton',12,54.00,0.000,0.00,0.00,54.00,54.00,0.00,0,0.00,108.00,1,'2021-11-06 09:29:36'),(6,4,'400','Daal Chawal',NULL,2.000,'Gattu',40,3600.00,0.000,0.00,0.00,3600.00,3600.00,0.00,0,0.00,7200.00,1,'2021-11-06 09:29:36'),(7,4,'400','Daal Chawal',NULL,2.000,'Gattu',40,3600.00,0.000,0.00,0.00,3600.00,3600.00,0.00,0,0.00,7200.00,1,'2021-11-06 09:29:36'),(8,5,'400','Daal Chawal',NULL,100.000,'Gattu',40,4000.00,0.000,0.00,0.00,4000.00,4000.00,0.00,0,0.00,400000.00,1,'2021-11-09 11:57:01');
/*!40000 ALTER TABLE `financials_purchase_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_purchase_return_invoice`
--

DROP TABLE IF EXISTS `financials_purchase_return_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_purchase_return_invoice` (
  `pri_id` int(11) NOT NULL AUTO_INCREMENT,
  `pri_invoice_number` int(11) DEFAULT NULL,
  `pri_party_code` int(11) NOT NULL,
  `pri_party_name` varchar(250) NOT NULL,
  `pri_pr_id` int(11) DEFAULT NULL,
  `pri_customer_name` varchar(250) DEFAULT NULL,
  `pri_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `pri_total_items` int(11) DEFAULT NULL,
  `pri_total_price` decimal(50,2) NOT NULL,
  `pri_product_disc` decimal(50,2) DEFAULT 0.00,
  `pri_round_off_disc` decimal(50,2) DEFAULT NULL,
  `pri_cash_disc_per` decimal(50,2) DEFAULT 0.00,
  `pri_cash_disc_amount` decimal(50,2) DEFAULT 0.00,
  `pri_total_discount` decimal(50,2) DEFAULT 0.00,
  `pri_inclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `pri_exclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `pri_total_sales_tax` decimal(50,2) DEFAULT 0.00,
  `pri_grand_total` decimal(50,2) NOT NULL DEFAULT 0.00,
  `pri_cash_paid` decimal(50,2) DEFAULT 0.00,
  `pri_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `pri_day_end_id` int(11) DEFAULT NULL,
  `pri_day_end_date` date DEFAULT NULL,
  `pri_createdby` int(11) DEFAULT NULL,
  `pri_detail_remarks` text DEFAULT NULL,
  `pri_ip_adrs` varchar(255) NOT NULL,
  `pri_brwsr_info` varchar(4000) NOT NULL,
  `pri_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`pri_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_purchase_return_invoice`
--

LOCK TABLES `financials_purchase_return_invoice` WRITE;
/*!40000 ALTER TABLE `financials_purchase_return_invoice` DISABLE KEYS */;
INSERT INTO `financials_purchase_return_invoice` VALUES (1,NULL,110132,'ABD 436',1,'','',1,54.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,54.00,NULL,'2021-11-06 07:12:55',1,'2021-09-29',1,'Lays Rs. 5, 1.000@54.00 = 54.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:12:55'),(2,NULL,110132,'ABD 436',1,'','',2,108.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,108.00,NULL,'2021-11-06 07:24:07',1,'2021-09-29',1,'Lays Rs. 5, 1.000@54.00 = 54.00&oS;Lays Rs. 5, 1.000@54.00 = 54.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:24:07'),(3,NULL,110132,'ABD 436',2,'','',1,510.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,510.00,NULL,'2021-11-06 07:29:15',1,'2021-09-29',1,'Pepsi 1500 ML, 1@510.00 = 510.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:29:15'),(4,NULL,210101,'Supplier One',1,'','',20,72000.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,72000.00,NULL,'2021-11-06 09:37:15',1,'2021-09-29',1,'Daal Chawal, 20.000@3,600.00 = 72,000.00&oS;','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:37:15');
/*!40000 ALTER TABLE `financials_purchase_return_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_purchase_return_invoice_items`
--

DROP TABLE IF EXISTS `financials_purchase_return_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_purchase_return_invoice_items` (
  `prii_id` int(11) NOT NULL AUTO_INCREMENT,
  `prii_purchase_invoice_id` int(11) NOT NULL,
  `prii_product_code` varchar(500) NOT NULL,
  `prii_product_name` varchar(250) NOT NULL,
  `prii_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `prii_qty` decimal(50,3) NOT NULL,
  `prii_uom` varchar(500) DEFAULT '',
  `prii_scale_size` tinyint(4) DEFAULT NULL,
  `prii_rate` decimal(50,2) NOT NULL,
  `prii_bonus_qty` decimal(50,3) DEFAULT 0.000,
  `prii_discount_per` decimal(50,2) DEFAULT 0.00,
  `prii_discount_amount` decimal(50,2) DEFAULT 0.00,
  `prii_after_dis_rate` decimal(50,2) DEFAULT NULL,
  `prii_net_rate` decimal(50,2) DEFAULT 0.00,
  `prii_saletax_per` decimal(50,2) DEFAULT NULL,
  `prii_saletax_inclusive` tinyint(1) DEFAULT 0,
  `prii_saletax_amount` decimal(50,2) DEFAULT 0.00,
  `prii_amount` decimal(50,2) NOT NULL,
  `prii_warehouse_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`prii_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_purchase_return_invoice_items`
--

LOCK TABLES `financials_purchase_return_invoice_items` WRITE;
/*!40000 ALTER TABLE `financials_purchase_return_invoice_items` DISABLE KEYS */;
INSERT INTO `financials_purchase_return_invoice_items` VALUES (1,1,'300','Lays Rs. 5',NULL,1.000,'Carton',12,54.00,0.000,0.00,0.00,54.00,54.00,0.00,0,0.00,54.00,1),(2,2,'300','Lays Rs. 5',NULL,1.000,'Carton',12,54.00,0.000,0.00,0.00,54.00,54.00,0.00,0,0.00,54.00,1),(3,2,'300','Lays Rs. 5',NULL,1.000,'Carton',12,54.00,0.000,0.00,0.00,54.00,54.00,0.00,0,0.00,54.00,1),(4,3,'200','Pepsi 1500 ML',NULL,1.000,'Pet',6,510.00,0.000,0.00,0.00,510.00,510.00,0.00,0,0.00,510.00,1),(5,4,'400','Daal Chawal',NULL,20.000,'Gattu',40,3600.00,0.000,0.00,0.00,3600.00,3600.00,0.00,0,0.00,72000.00,1);
/*!40000 ALTER TABLE `financials_purchase_return_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_purchase_return_saletax_invoice`
--

DROP TABLE IF EXISTS `financials_purchase_return_saletax_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_purchase_return_saletax_invoice` (
  `prsi_id` int(11) NOT NULL AUTO_INCREMENT,
  `prsi_invoice_number` int(11) DEFAULT NULL,
  `prsi_party_code` int(11) NOT NULL,
  `prsi_party_name` varchar(250) NOT NULL,
  `prsi_pr_id` int(11) DEFAULT NULL,
  `prsi_customer_name` varchar(250) DEFAULT NULL,
  `prsi_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `prsi_total_items` int(11) DEFAULT NULL,
  `prsi_total_price` decimal(50,2) NOT NULL,
  `prsi_product_disc` decimal(50,2) DEFAULT 0.00,
  `prsi_round_off_disc` decimal(50,2) DEFAULT NULL,
  `prsi_cash_disc_per` decimal(50,2) DEFAULT 0.00,
  `prsi_cash_disc_amount` decimal(50,2) DEFAULT 0.00,
  `prsi_total_discount` decimal(50,2) DEFAULT 0.00,
  `prsi_inclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `prsi_exclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `prsi_total_sales_tax` decimal(50,2) DEFAULT 0.00,
  `prsi_grand_total` decimal(50,2) NOT NULL DEFAULT 0.00,
  `prsi_cash_paid` decimal(50,2) DEFAULT 0.00,
  `prsi_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `prsi_day_end_id` int(11) DEFAULT NULL,
  `prsi_day_end_date` date DEFAULT NULL,
  `prsi_createdby` int(11) DEFAULT NULL,
  `prsi_detail_remarks` text DEFAULT NULL,
  `prsi_ip_adrs` varchar(255) NOT NULL,
  `prsi_brwsr_info` varchar(4000) NOT NULL,
  `prsi_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`prsi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_purchase_return_saletax_invoice`
--

LOCK TABLES `financials_purchase_return_saletax_invoice` WRITE;
/*!40000 ALTER TABLE `financials_purchase_return_saletax_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_purchase_return_saletax_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_purchase_return_saletax_invoice_items`
--

DROP TABLE IF EXISTS `financials_purchase_return_saletax_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_purchase_return_saletax_invoice_items` (
  `prsii_id` int(11) NOT NULL AUTO_INCREMENT,
  `prsii_purchase_invoice_id` int(11) NOT NULL,
  `prsii_product_code` varchar(500) NOT NULL,
  `prsii_product_name` varchar(250) NOT NULL,
  `prsii_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `prsii_qty` decimal(50,3) NOT NULL,
  `prsii_uom` varchar(500) DEFAULT '',
  `prsii_scale_size` tinyint(4) DEFAULT NULL,
  `prsii_rate` decimal(50,2) NOT NULL,
  `prsii_bonus_qty` decimal(50,3) DEFAULT 0.000,
  `prsii_discount_per` decimal(50,2) DEFAULT 0.00,
  `prsii_discount_amount` decimal(50,2) DEFAULT 0.00,
  `prsii_after_dis_rate` decimal(50,2) DEFAULT NULL,
  `prsii_net_rate` decimal(50,2) DEFAULT 0.00,
  `prsii_saletax_per` decimal(50,2) DEFAULT NULL,
  `prsii_saletax_inclusive` tinyint(1) DEFAULT 0,
  `prsii_saletax_amount` decimal(50,2) DEFAULT 0.00,
  `prsii_amount` decimal(50,2) NOT NULL,
  `prsii_warehouse_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`prsii_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_purchase_return_saletax_invoice_items`
--

LOCK TABLES `financials_purchase_return_saletax_invoice_items` WRITE;
/*!40000 ALTER TABLE `financials_purchase_return_saletax_invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_purchase_return_saletax_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_purchase_saletax_invoice`
--

DROP TABLE IF EXISTS `financials_purchase_saletax_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_purchase_saletax_invoice` (
  `psi_id` int(11) NOT NULL AUTO_INCREMENT,
  `psi_party_code` int(11) NOT NULL,
  `psi_party_name` varchar(250) NOT NULL,
  `psi_pr_id` int(11) DEFAULT NULL,
  `psi_customer_name` varchar(250) DEFAULT NULL,
  `psi_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `psi_total_items` int(11) DEFAULT NULL,
  `psi_total_price` decimal(50,2) NOT NULL,
  `psi_product_disc` decimal(50,2) DEFAULT 0.00,
  `psi_round_off_disc` decimal(50,2) DEFAULT NULL,
  `psi_cash_disc_per` decimal(50,2) DEFAULT 0.00,
  `psi_cash_disc_amount` decimal(50,2) DEFAULT 0.00,
  `psi_total_discount` decimal(50,2) DEFAULT 0.00,
  `psi_inclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `psi_exclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `psi_total_sales_tax` decimal(50,2) DEFAULT 0.00,
  `psi_grand_total` decimal(50,2) NOT NULL DEFAULT 0.00,
  `psi_cash_paid` decimal(50,2) DEFAULT 0.00,
  `psi_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `psi_day_end_id` int(11) DEFAULT NULL,
  `psi_day_end_date` date DEFAULT NULL,
  `psi_createdby` int(11) DEFAULT NULL,
  `psi_detail_remarks` text DEFAULT NULL,
  `psi_ip_adrs` varchar(255) NOT NULL,
  `psi_brwsr_info` varchar(4000) NOT NULL,
  `psi_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`psi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_purchase_saletax_invoice`
--

LOCK TABLES `financials_purchase_saletax_invoice` WRITE;
/*!40000 ALTER TABLE `financials_purchase_saletax_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_purchase_saletax_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_purchase_saletax_invoice_items`
--

DROP TABLE IF EXISTS `financials_purchase_saletax_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_purchase_saletax_invoice_items` (
  `psii_id` int(11) NOT NULL AUTO_INCREMENT,
  `psii_purchase_invoice_id` int(11) NOT NULL,
  `psii_product_code` varchar(500) NOT NULL,
  `psii_product_name` varchar(250) NOT NULL,
  `psii_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `psii_qty` decimal(50,3) NOT NULL,
  `psii_uom` varchar(500) DEFAULT '',
  `psii_scale_size` tinyint(4) DEFAULT NULL,
  `psii_rate` decimal(50,2) NOT NULL,
  `psii_bonus_qty` decimal(50,3) DEFAULT 0.000,
  `psii_discount_per` decimal(50,2) DEFAULT 0.00,
  `psii_discount_amount` decimal(50,2) DEFAULT 0.00,
  `psii_after_dis_rate` decimal(50,2) DEFAULT NULL,
  `psii_net_rate` decimal(50,2) DEFAULT 0.00,
  `psii_saletax_per` decimal(50,2) DEFAULT NULL,
  `psii_saletax_inclusive` tinyint(1) DEFAULT 0,
  `psii_saletax_amount` decimal(50,2) DEFAULT 0.00,
  `psii_amount` decimal(50,2) NOT NULL,
  `psii_warehouse_id` int(11) DEFAULT NULL,
  `psii_created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`psii_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_purchase_saletax_invoice_items`
--

LOCK TABLES `financials_purchase_saletax_invoice_items` WRITE;
/*!40000 ALTER TABLE `financials_purchase_saletax_invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_purchase_saletax_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_raw_stock_costing`
--

DROP TABLE IF EXISTS `financials_raw_stock_costing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_raw_stock_costing` (
  `rsc_id` int(11) NOT NULL AUTO_INCREMENT,
  `rsc_odr_id` int(11) NOT NULL,
  `rsc_pro_code` varchar(500) NOT NULL,
  `rsc_pro_name` varchar(1000) NOT NULL,
  `rsc_pro_remarks` text DEFAULT NULL,
  `rsc_uom` varchar(500) NOT NULL,
  `rsc_qty` decimal(50,2) NOT NULL,
  `rsc_rate` decimal(50,2) NOT NULL,
  `rsc_total` decimal(50,2) NOT NULL,
  PRIMARY KEY (`rsc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_raw_stock_costing`
--

LOCK TABLES `financials_raw_stock_costing` WRITE;
/*!40000 ALTER TABLE `financials_raw_stock_costing` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_raw_stock_costing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_region`
--

DROP TABLE IF EXISTS `financials_region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_region` (
  `reg_id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_title` varchar(250) COLLATE utf8_croatian_ci NOT NULL,
  `reg_remarks` varchar(500) COLLATE utf8_croatian_ci DEFAULT NULL,
  `reg_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `reg_createdby` int(11) DEFAULT NULL,
  `reg_day_end_id` int(11) DEFAULT NULL,
  `reg_day_end_date` date DEFAULT NULL,
  `reg_ip_adrs` varchar(255) COLLATE utf8_croatian_ci NOT NULL DEFAULT '',
  `reg_brwsr_info` varchar(4000) COLLATE utf8_croatian_ci NOT NULL DEFAULT '',
  `reg_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `reg_delete_status` int(11) DEFAULT 0,
  `reg_deleted_by` int(11) DEFAULT NULL,
  `reg_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`reg_id`),
  UNIQUE KEY `reg_title` (`reg_title`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_region`
--

LOCK TABLES `financials_region` WRITE;
/*!40000 ALTER TABLE `financials_region` DISABLE KEYS */;
INSERT INTO `financials_region` VALUES (1,'Initial Region',NULL,'2021-10-29 06:56:23',0,0,'2021-10-29','','','2021-10-29 11:56:23',0,NULL,0),(2,'Multan','','2021-10-29 08:07:40',1,0,'2021-10-29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.54','2021-10-29 13:07:40',0,NULL,0);
/*!40000 ALTER TABLE `financials_region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_report_config`
--

DROP TABLE IF EXISTS `financials_report_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_report_config` (
  `rc_id` int(11) NOT NULL AUTO_INCREMENT,
  `rc_invoice` int(11) NOT NULL DEFAULT 0,
  `rc_invoice_party` int(11) NOT NULL DEFAULT 0,
  `rc_detail_remarks` int(11) NOT NULL DEFAULT 0,
  `rc_user_id` int(11) NOT NULL,
  `rc_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `rc_updated_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`rc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_report_config`
--

LOCK TABLES `financials_report_config` WRITE;
/*!40000 ALTER TABLE `financials_report_config` DISABLE KEYS */;
INSERT INTO `financials_report_config` VALUES (1,0,0,2,1,'2021-10-29 11:56:23','2021-11-08 10:38:41');
/*!40000 ALTER TABLE `financials_report_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_salary_ad_items`
--

DROP TABLE IF EXISTS `financials_salary_ad_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_salary_ad_items` (
  `sadi_id` int(11) NOT NULL AUTO_INCREMENT,
  `sadi_account_uid` int(11) NOT NULL,
  `sadi_account_name` varchar(1000) NOT NULL,
  `sadi_remarks` varchar(1000) DEFAULT NULL,
  `sadi_allowance_deduction` tinyint(4) NOT NULL,
  `sadi_taxable` tinyint(4) DEFAULT NULL,
  `sadi_amount` decimal(50,2) NOT NULL,
  `sadi_absent_deduction` tinyint(4) DEFAULT NULL,
  `sadi_salary_info_id` int(11) NOT NULL,
  `sadi_user_id` int(11) NOT NULL,
  PRIMARY KEY (`sadi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_salary_ad_items`
--

LOCK TABLES `financials_salary_ad_items` WRITE;
/*!40000 ALTER TABLE `financials_salary_ad_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_salary_ad_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_salary_info`
--

DROP TABLE IF EXISTS `financials_salary_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_salary_info` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `si_basic_salary` decimal(50,2) NOT NULL,
  `si_basic_salary_period` tinyint(4) DEFAULT 0,
  `si_working_hours_per_day` decimal(50,2) NOT NULL,
  `si_off_days` varchar(1000) NOT NULL,
  `si_user_id` int(11) NOT NULL,
  `si_advance_salary_account_uid` int(11) NOT NULL DEFAULT 0,
  `si_expense_salary_account_uid` int(11) NOT NULL DEFAULT 0,
  `si_loan_account_uid` int(11) DEFAULT NULL,
  `si_day_end_id` int(11) NOT NULL,
  `si_day_end_date` date NOT NULL,
  `si_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `si_update_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`si_id`),
  UNIQUE KEY `si_advance_salary_account_uid` (`si_advance_salary_account_uid`),
  UNIQUE KEY `si_expense_salary_account_uid` (`si_expense_salary_account_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_salary_info`
--

LOCK TABLES `financials_salary_info` WRITE;
/*!40000 ALTER TABLE `financials_salary_info` DISABLE KEYS */;
INSERT INTO `financials_salary_info` VALUES (1,95000.00,3,8.00,'7',2,110141,414121,0,0,'2021-10-29','2021-10-29 08:05:46','2021-10-29 08:05:46');
/*!40000 ALTER TABLE `financials_salary_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_salary_payment`
--

DROP TABLE IF EXISTS `financials_salary_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_salary_payment` (
  `sp_id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_payment_account` int(11) DEFAULT NULL,
  `sp_remarks` varchar(1000) DEFAULT NULL,
  `sp_detail_remarks` varchar(5000) DEFAULT NULL,
  `sp_total_amount` decimal(50,2) DEFAULT NULL,
  `sp_created_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sp_day_end_id` int(11) DEFAULT NULL,
  `sp_day_end_date` date DEFAULT NULL,
  `sp_createdby` int(11) DEFAULT NULL,
  `sp_ip_adrs` varchar(255) NOT NULL,
  `sp_brwsr_info` varchar(4000) NOT NULL,
  `sp_update_datetime` datetime NOT NULL,
  PRIMARY KEY (`sp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_salary_payment`
--

LOCK TABLES `financials_salary_payment` WRITE;
/*!40000 ALTER TABLE `financials_salary_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_salary_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_salary_payment_items`
--

DROP TABLE IF EXISTS `financials_salary_payment_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_salary_payment_items` (
  `spi_id` int(11) NOT NULL AUTO_INCREMENT,
  `spi_sp_id` int(11) DEFAULT NULL,
  `spi_department_id` int(11) DEFAULT NULL,
  `spi_department_name` varchar(500) DEFAULT NULL,
  `spi_account_id` int(11) DEFAULT NULL,
  `spi_account_name` varchar(1000) DEFAULT NULL,
  `spi_net_salary` decimal(50,2) DEFAULT NULL,
  `spi_payable_amount` decimal(50,2) DEFAULT NULL,
  `spi_paid_amount` decimal(50,2) DEFAULT NULL,
  `spi_month_year` varchar(255) DEFAULT NULL,
  `spi_employee_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`spi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_salary_payment_items`
--

LOCK TABLES `financials_salary_payment_items` WRITE;
/*!40000 ALTER TABLE `financials_salary_payment_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_salary_payment_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_salary_payment_voucher`
--

DROP TABLE IF EXISTS `financials_salary_payment_voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_salary_payment_voucher` (
  `sp_id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_session` varchar(450) DEFAULT NULL,
  `sp_business_name` varchar(450) DEFAULT NULL,
  `sp_account_id` int(11) NOT NULL,
  `sp_total_amount` decimal(50,2) NOT NULL,
  `sp_remarks` varchar(450) DEFAULT NULL,
  `sp_created_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `sp_day_end_id` int(11) DEFAULT NULL,
  `sp_day_end_date` date DEFAULT NULL,
  `sp_createdby` int(11) DEFAULT NULL,
  `sp_detail_remarks` varchar(1000) DEFAULT NULL,
  `sp_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `sp_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `sp_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`sp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_salary_payment_voucher`
--

LOCK TABLES `financials_salary_payment_voucher` WRITE;
/*!40000 ALTER TABLE `financials_salary_payment_voucher` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_salary_payment_voucher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_salary_payment_voucher_items`
--

DROP TABLE IF EXISTS `financials_salary_payment_voucher_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_salary_payment_voucher_items` (
  `spi_id` int(11) NOT NULL AUTO_INCREMENT,
  `spi_salary_payment_voucher_id` int(11) NOT NULL,
  `spi_account_id` int(11) NOT NULL,
  `spi_account_name` varchar(500) NOT NULL,
  `spi_amount` decimal(50,2) NOT NULL,
  `spi_remarks` varchar(500) DEFAULT NULL,
  `spi_deduct_amount` decimal(50,2) DEFAULT 0.00,
  `spi_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `spi_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `spi_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`spi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_salary_payment_voucher_items`
--

LOCK TABLES `financials_salary_payment_voucher_items` WRITE;
/*!40000 ALTER TABLE `financials_salary_payment_voucher_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_salary_payment_voucher_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_salary_slip_voucher`
--

DROP TABLE IF EXISTS `financials_salary_slip_voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_salary_slip_voucher` (
  `ss_id` int(11) NOT NULL AUTO_INCREMENT,
  `ss_user_id` int(11) NOT NULL,
  `ss_basic_salary` decimal(50,2) NOT NULL,
  `ss_basic_salary_per` tinyint(4) NOT NULL,
  `ss_working_hours_per_day` tinyint(4) NOT NULL,
  `ss_off_days` varchar(1000) NOT NULL,
  `ss_payment_period` tinyint(4) NOT NULL,
  `ss_working_days_per_month` tinyint(4) NOT NULL,
  `ss_daily_date` date NOT NULL,
  `ss_weekly_date_from` date NOT NULL,
  `ss_weekly_date_to` date NOT NULL,
  `ss_attended_days` tinyint(4) NOT NULL,
  `ss_attended_hours` tinyint(4) NOT NULL,
  `ss_calculate_attended` tinyint(4) NOT NULL,
  `ss_remarks` varchar(1000) NOT NULL,
  `ss_gross_salary` decimal(50,2) NOT NULL,
  `ss_total_allowances` decimal(50,2) NOT NULL,
  `ss_total_deduction` decimal(50,2) NOT NULL,
  `ss_net_salary` decimal(50,2) NOT NULL,
  `ss_day_end_id` int(11) NOT NULL,
  `ss_day_end_date` date NOT NULL,
  `ss_current_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `ss_created_by` int(11) NOT NULL,
  `ss_ip_adrs` varchar(255) NOT NULL,
  `ss_brwsr_info` varchar(4000) NOT NULL,
  `ss_update_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ss_detail_remarks` text DEFAULT NULL,
  PRIMARY KEY (`ss_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_salary_slip_voucher`
--

LOCK TABLES `financials_salary_slip_voucher` WRITE;
/*!40000 ALTER TABLE `financials_salary_slip_voucher` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_salary_slip_voucher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_salary_slip_voucher_items`
--

DROP TABLE IF EXISTS `financials_salary_slip_voucher_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_salary_slip_voucher_items` (
  `ssi_id` int(11) NOT NULL AUTO_INCREMENT,
  `ssi_voucher_id` int(11) NOT NULL,
  `ssi_account_id` int(11) NOT NULL,
  `ssi_account_name` varchar(1000) NOT NULL,
  `ssi_allow_deduc` tinytext NOT NULL,
  `ssi_amount` decimal(50,2) NOT NULL,
  `ssi_remarks` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`ssi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_salary_slip_voucher_items`
--

LOCK TABLES `financials_salary_slip_voucher_items` WRITE;
/*!40000 ALTER TABLE `financials_salary_slip_voucher_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_salary_slip_voucher_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_sale_invoice`
--

DROP TABLE IF EXISTS `financials_sale_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_sale_invoice` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `si_party_code` int(11) NOT NULL,
  `si_party_name` varchar(250) NOT NULL,
  `si_pr_id` int(11) DEFAULT NULL,
  `si_customer_name` varchar(250) DEFAULT NULL,
  `si_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `si_total_items` int(11) DEFAULT NULL,
  `si_total_price` decimal(50,2) NOT NULL,
  `si_product_disc` decimal(50,2) DEFAULT 0.00,
  `si_round_off_disc` decimal(50,2) DEFAULT 0.00,
  `si_cash_disc_per` decimal(50,2) DEFAULT 0.00,
  `si_cash_disc_amount` decimal(50,2) DEFAULT 0.00,
  `si_total_discount` decimal(50,2) DEFAULT 0.00,
  `si_inclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `si_exclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `si_total_sales_tax` decimal(50,2) DEFAULT 0.00,
  `si_grand_total` decimal(50,2) NOT NULL DEFAULT 0.00,
  `si_cash_received` decimal(50,2) DEFAULT 0.00,
  `si_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `si_day_end_id` int(11) DEFAULT NULL,
  `si_day_end_date` date DEFAULT NULL,
  `si_createdby` int(11) DEFAULT NULL,
  `si_detail_remarks` text CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `si_sale_person` int(11) DEFAULT 0,
  `si_invoice_transcation_type` int(11) DEFAULT 1,
  `si_invoice_machine_id` int(11) DEFAULT 0,
  `si_invoice_machine_name` varchar(500) DEFAULT NULL,
  `si_service_charges_percentage` decimal(50,2) DEFAULT NULL,
  `si_phone_number` varchar(150) DEFAULT NULL,
  `si_credit_card_reference_number` varchar(50) DEFAULT NULL,
  `si_email` varchar(500) DEFAULT NULL,
  `si_whatsapp` varchar(150) DEFAULT NULL,
  `si_service_invoice_id` int(11) DEFAULT 0,
  `si_local_invoice_id` int(11) DEFAULT 0,
  `si_local_service_invoice_id` int(11) DEFAULT 0,
  `si_ip_adrs` varchar(255) NOT NULL,
  `si_brwsr_info` varchar(4000) NOT NULL,
  `si_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `si_cash_received_from_customer` decimal(50,2) DEFAULT 0.00,
  `si_return_amount` decimal(50,2) DEFAULT 0.00,
  `si_discount_type` int(11) DEFAULT 1,
  `si_invoice_profit` decimal(50,2) DEFAULT 0.00,
  PRIMARY KEY (`si_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_sale_invoice`
--

LOCK TABLES `financials_sale_invoice` WRITE;
/*!40000 ALTER TABLE `financials_sale_invoice` DISABLE KEYS */;
INSERT INTO `financials_sale_invoice` VALUES (2,110131,'Client One',1,'','',1,60.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,60.00,0.00,'2021-11-03 13:11:06',1,'2021-09-29',1,'Lays Rs. 5, 1@60.00 = 60.00&oS;',3,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:11:06',60.00,NULL,1,0.00),(3,410101,'Product Loss & Recover',3,'','PLV-3',1,54.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,54.00,0.00,'2021-11-04 13:40:05',1,'2021-09-29',1,'Lays Rs. 5, 1@54.00 = 54&oS;',0,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:05',0.00,0.00,1,0.00),(4,410101,'Product Loss & Recover',2,'','TPLV-4',40,128000.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,128000.00,0.00,'2021-11-04 13:40:43',1,'2021-09-29',1,'Suger, 40.000@3200.00 = 128000&oS;',0,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:43',0.00,0.00,1,0.00),(5,110161,'Walk In Customer',2,'','',1,144000.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,144000.00,0.00,'2021-11-05 08:21:12',1,'2021-09-29',1,'Suger, 40.000@3,600.00 = 144,000.00&oS;',0,1,NULL,NULL,NULL,NULL,NULL,NULL,'SO-2,',0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:21:12',144000.00,NULL,1,0.00),(6,410101,'Product Loss & Recover',1,'','PLV-11',1,86400.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,86400.00,0.00,'2021-11-06 09:33:27',1,'2021-09-29',1,'Daal Chawal, 24@3600.00 = 86400&oS;',0,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:33:27',0.00,0.00,1,0.00),(7,110161,'Walk In Customer',1,'','',4,60120.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,60120.00,60120.00,'2021-11-06 09:39:07',1,'2021-09-29',1,'Lays Rs. 5, 1@60.00 = 60.00&oS;Daal Chawal, 10@4,000.00 = 40,000.00&oS;Lays Rs. 5, 1@60.00 = 60.00&oS;Daal Chawal, 5@4,000.00 = 20,000.00&oS;',3,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:39:07',0.00,60120.00,1,0.00),(8,110161,'Walk In Customer',1,'','',2,3660.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,3660.00,0.00,'2021-11-08 10:30:55',1,'2021-09-29',1,'Lays Rs. 5, 1@60.00 = 60.00&oS;Suger, 1@3,600.00 = 3,600.00&oS;',3,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:30:55',3660.00,NULL,1,0.00),(9,110132,'ABD 436',1,'','',2,3660.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,3660.00,0.00,'2021-11-08 10:31:14',1,'2021-09-29',1,', 1@3,600.00 = 3,600.00&oS;, 1@60.00 = 60.00&oS;',3,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:31:14',3660.00,NULL,1,0.00),(10,110132,'ABD 436',1,'','',1,60.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,60.00,0.00,'2021-11-08 10:48:07',1,'2021-09-29',1,'Lays Rs. 5, 1@60.00 = 60.00&oS;',3,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:48:07',60.00,NULL,1,0.00),(11,110161,'Walk In Customer',1,'','',1,160000.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,160000.00,0.00,'2021-11-09 06:28:33',1,'2021-09-29',1,'Daal Chawal, QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;',0,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 11:28:33',160000.00,NULL,1,0.00),(12,110161,'Walk In Customer',1,'','',1,720.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,720.00,0.00,'2021-11-10 11:35:19',1,'2021-09-29',1,'Lays Rs. 5, QTY 12.000@60.00 = 720.00, Pack QTY = 1, Loose QTY = 0&oS;',3,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 16:35:19',720.00,NULL,1,0.00),(13,110161,'Walk In Customer',1,'','',2,147240.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,147240.00,0.00,'2021-11-10 12:24:35',1,'2021-09-29',1,', QTY 6.000@540.00 = 3,240.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;',0,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 17:24:35',147240.00,NULL,1,0.00);
/*!40000 ALTER TABLE `financials_sale_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_sale_invoice_items`
--

DROP TABLE IF EXISTS `financials_sale_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_sale_invoice_items` (
  `sii_id` int(11) NOT NULL AUTO_INCREMENT,
  `sii_invoice_id` int(11) NOT NULL,
  `sii_product_code` varchar(500) NOT NULL,
  `sii_product_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_croatian_ci NOT NULL,
  `sii_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `sii_qty` decimal(50,3) NOT NULL DEFAULT 0.000,
  `sii_uom` varchar(500) DEFAULT '',
  `sii_scale_size` tinyint(4) DEFAULT NULL,
  `sii_bonus_qty` decimal(50,3) DEFAULT 0.000,
  `sii_rate` decimal(50,2) NOT NULL,
  `sii_discount_per` decimal(50,2) DEFAULT 0.00,
  `sii_discount_amount` decimal(50,2) DEFAULT 0.00,
  `sii_after_dis_rate` decimal(50,2) DEFAULT 0.00,
  `sii_net_rate` decimal(50,2) DEFAULT 0.00,
  `sii_saletax_per` decimal(50,2) DEFAULT 0.00,
  `sii_saletax_inclusive` tinyint(1) DEFAULT 0,
  `sii_saletax_amount` decimal(50,2) DEFAULT 0.00,
  `sii_warehouse_id` int(11) NOT NULL DEFAULT 0,
  `sii_amount` decimal(50,2) NOT NULL,
  `sii_product_profit` decimal(50,2) DEFAULT 0.00,
  `sii_created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`sii_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_sale_invoice_items`
--

LOCK TABLES `financials_sale_invoice_items` WRITE;
/*!40000 ALTER TABLE `financials_sale_invoice_items` DISABLE KEYS */;
INSERT INTO `financials_sale_invoice_items` VALUES (3,2,'300','Lays Rs. 5','',1.000,'Carton',12,0.000,60.00,0.00,0.00,60.00,60.00,0.00,0,0.00,1,60.00,0.00,'2021-11-03 13:11:06'),(4,3,'300','Lays Rs. 5','',1.000,'',NULL,0.000,54.00,0.00,0.00,54.00,54.00,0.00,0,0.00,0,54.00,0.00,'2021-11-04 13:40:05'),(5,4,'100','Suger','',40.000,'',40,0.000,3200.00,0.00,0.00,3200.00,3200.00,0.00,0,0.00,0,128000.00,0.00,'2021-11-04 13:40:43'),(6,5,'100','Suger','',40.000,'Gattu',40,0.000,3600.00,0.00,0.00,3600.00,3600.00,0.00,0,0.00,1,144000.00,0.00,'2021-11-05 08:21:12'),(7,6,'400','Daal Chawal','',24.000,'',NULL,0.000,3600.00,0.00,0.00,3600.00,3600.00,0.00,0,0.00,0,86400.00,0.00,'2021-11-06 09:33:27'),(8,7,'300','Lays Rs. 5','',1.000,'Carton',12,0.000,60.00,0.00,0.00,60.00,60.00,0.00,0,0.00,1,60.00,0.00,'2021-11-06 09:39:07'),(9,7,'400','Daal Chawal','',10.000,'Gattu',40,0.000,4000.00,0.00,0.00,4000.00,4000.00,0.00,0,0.00,1,40000.00,0.00,'2021-11-06 09:39:07'),(10,7,'300','Lays Rs. 5','',1.000,'Carton',12,0.000,60.00,0.00,0.00,60.00,60.00,0.00,0,0.00,1,60.00,0.00,'2021-11-06 09:39:07'),(11,7,'400','Daal Chawal','',5.000,'Gattu',40,0.000,4000.00,0.00,0.00,4000.00,4000.00,0.00,0,0.00,1,20000.00,0.00,'2021-11-06 09:39:07'),(12,8,'300','Lays Rs. 5','',1.000,'Carton',12,0.000,60.00,0.00,0.00,60.00,60.00,0.00,0,0.00,1,60.00,0.00,'2021-11-08 10:30:55'),(13,8,'100','Suger','',1.000,'Gattu',40,0.000,3600.00,0.00,0.00,3600.00,3600.00,0.00,0,0.00,1,3600.00,0.00,'2021-11-08 10:30:55'),(14,9,'100','Suger','',1.000,'Gattu',40,0.000,3600.00,0.00,0.00,3600.00,3600.00,0.00,0,0.00,1,3600.00,0.00,'2021-11-08 10:31:14'),(15,9,'300','Lays Rs. 5','',1.000,'Carton',12,0.000,60.00,0.00,0.00,60.00,60.00,0.00,0,0.00,1,60.00,0.00,'2021-11-08 10:31:14'),(16,10,'300','Lays Rs. 5','',1.000,'Carton',12,0.000,60.00,0.00,0.00,60.00,60.00,0.00,0,0.00,1,60.00,0.00,'2021-11-08 10:48:08'),(17,11,'400','Daal Chawal','',40.000,'Gattu',40,0.000,4000.00,0.00,0.00,4000.00,4000.00,0.00,0,0.00,1,160000.00,0.00,'2021-11-09 06:28:34'),(18,12,'300','Lays Rs. 5','',12.000,'Carton',12,0.000,60.00,0.00,0.00,60.00,60.00,0.00,0,0.00,1,720.00,0.00,'2021-11-10 11:35:19'),(19,13,'200','Pepsi 1500 ML','',6.000,'Pet',6,0.000,540.00,0.00,0.00,540.00,540.00,0.00,0,0.00,1,3240.00,0.00,'2021-11-10 12:24:35'),(20,13,'100','Suger','',40.000,'Gattu',40,0.000,3600.00,0.00,0.00,3600.00,3600.00,0.00,0,0.00,1,144000.00,0.00,'2021-11-10 12:24:35');
/*!40000 ALTER TABLE `financials_sale_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_sale_order`
--

DROP TABLE IF EXISTS `financials_sale_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_sale_order` (
  `so_id` int(11) NOT NULL AUTO_INCREMENT,
  `so_party_code` int(11) NOT NULL,
  `so_party_name` varchar(250) NOT NULL,
  `so_pr_id` int(11) DEFAULT NULL,
  `so_customer_name` varchar(250) DEFAULT 'NULL',
  `so_remarks` varchar(500) DEFAULT 'NULL',
  `so_total_items` int(11) DEFAULT 0,
  `so_total_price` decimal(50,2) NOT NULL,
  `so_product_disc` decimal(50,2) DEFAULT 0.00,
  `so_round_off_disc` decimal(50,2) DEFAULT 0.00,
  `so_cash_disc_per` decimal(50,2) DEFAULT 0.00,
  `so_cash_disc_amount` decimal(50,2) DEFAULT 0.00,
  `so_total_discount` decimal(50,2) DEFAULT 0.00,
  `so_inclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `so_exclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `so_total_sales_tax` decimal(50,2) DEFAULT 0.00,
  `so_grand_total` decimal(50,2) NOT NULL DEFAULT 0.00,
  `so_detail_remarks` text DEFAULT 'NULL',
  `so_invoice_transcation_type` int(11) DEFAULT 1,
  `so_discount_type` int(11) DEFAULT 1,
  `so_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `so_ip_adrs` varchar(255) NOT NULL,
  `so_brwsr_info` varchar(4000) NOT NULL,
  `so_day_end_id` int(11) DEFAULT 0,
  `so_day_end_date` date DEFAULT NULL,
  `so_createdby` int(11) DEFAULT 0,
  PRIMARY KEY (`so_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_sale_order`
--

LOCK TABLES `financials_sale_order` WRITE;
/*!40000 ALTER TABLE `financials_sale_order` DISABLE KEYS */;
INSERT INTO `financials_sale_order` VALUES (1,110132,'ABD 436',1,'','',1,60.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,60.00,'Lays Rs. 5, 1@60.00 = 60.00\n',1,1,'2021-11-05 08:07:35','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69',1,'2021-09-29',1),(2,110161,'Walk In Customer',2,'','',40,144000.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,144000.00,'Suger, 40@3,600.00 = 144,000.00\n',1,1,'2021-11-05 08:09:18','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69',1,'2021-09-29',1),(3,110131,'Client One',3,'','',1,540.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,540.00,'Pepsi 1500 ML, 1@540.00 = 540.00\n',1,1,'2021-11-05 08:15:17','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69',1,'2021-09-29',1);
/*!40000 ALTER TABLE `financials_sale_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_sale_order_items`
--

DROP TABLE IF EXISTS `financials_sale_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_sale_order_items` (
  `soi_id` int(11) NOT NULL AUTO_INCREMENT,
  `soi_invoice_id` int(11) NOT NULL,
  `soi_product_code` varchar(500) NOT NULL,
  `soi_product_name` varchar(250) NOT NULL,
  `soi_remarks` varchar(500) NOT NULL,
  `soi_qty` decimal(50,3) NOT NULL,
  `soi_due_qty` decimal(50,3) DEFAULT NULL,
  `soi_uom` varchar(500) DEFAULT NULL,
  `soi_scale_size` int(11) NOT NULL DEFAULT 1,
  `soi_bonus_qty` decimal(50,3) DEFAULT 0.000,
  `soi_rate` decimal(50,2) NOT NULL,
  `soi_discount_per` decimal(50,2) DEFAULT 0.00,
  `soi_discount_amount` decimal(50,2) DEFAULT 0.00,
  `soi_after_dis_rate` decimal(50,2) DEFAULT 0.00,
  `soi_net_rate` decimal(50,2) DEFAULT 0.00,
  `soi_saletax_per` decimal(50,2) DEFAULT 0.00,
  `soi_saletax_inclusive` tinyint(1) DEFAULT 0,
  `soi_saletax_amount` decimal(50,2) DEFAULT 0.00,
  `soi_amount` decimal(50,2) NOT NULL,
  `soi_pro_ser_status` int(11) DEFAULT 0,
  `soi_warehouse_id` int(11) DEFAULT NULL,
  `soi_status` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`soi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_sale_order_items`
--

LOCK TABLES `financials_sale_order_items` WRITE;
/*!40000 ALTER TABLE `financials_sale_order_items` DISABLE KEYS */;
INSERT INTO `financials_sale_order_items` VALUES (1,1,'300','Lays Rs. 5','',1.000,1.000,'Carton',12,0.000,60.00,0.00,0.00,60.00,60.00,0.00,0,0.00,60.00,0,1,NULL),(2,2,'100','Suger','',40.000,0.000,'Gattu',40,0.000,3600.00,0.00,0.00,3600.00,3600.00,0.00,0,0.00,144000.00,0,1,'SI-5'),(3,3,'200','Pepsi 1500 ML','',1.000,1.000,'Pet',6,0.000,540.00,0.00,0.00,540.00,540.00,0.00,0,0.00,540.00,0,1,NULL);
/*!40000 ALTER TABLE `financials_sale_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_sale_order_qty_hold_log`
--

DROP TABLE IF EXISTS `financials_sale_order_qty_hold_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_sale_order_qty_hold_log` (
  `soqh_id` int(11) NOT NULL AUTO_INCREMENT,
  `soqh_so_id` int(11) DEFAULT NULL,
  `soqh_warehouse_id` int(11) DEFAULT NULL,
  `soqh_product_code` varchar(500) DEFAULT NULL,
  `soqh_total_qty` decimal(50,3) DEFAULT NULL,
  `soqh_sale_qty` decimal(50,3) NOT NULL DEFAULT 0.000,
  `soqh_balance_qty` decimal(50,3) NOT NULL DEFAULT 0.000,
  `soqh_sale_invoice_id` int(11) DEFAULT NULL,
  `soqh_sale_tax_id` int(11) DEFAULT NULL,
  `soqh_do_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`soqh_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_sale_order_qty_hold_log`
--

LOCK TABLES `financials_sale_order_qty_hold_log` WRITE;
/*!40000 ALTER TABLE `financials_sale_order_qty_hold_log` DISABLE KEYS */;
INSERT INTO `financials_sale_order_qty_hold_log` VALUES (1,1,1,'300',1.000,0.000,1.000,NULL,NULL,NULL),(2,2,1,'100',40.000,0.000,40.000,NULL,NULL,NULL),(3,3,1,'200',1.000,0.000,1.000,NULL,NULL,NULL),(4,2,1,'100',NULL,40.000,0.000,5,0,NULL);
/*!40000 ALTER TABLE `financials_sale_order_qty_hold_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_sale_return_invoice`
--

DROP TABLE IF EXISTS `financials_sale_return_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_sale_return_invoice` (
  `sri_id` int(11) NOT NULL AUTO_INCREMENT,
  `sri_sale_invoice_number` int(11) DEFAULT NULL,
  `sri_party_code` int(11) NOT NULL,
  `sri_party_name` varchar(250) NOT NULL,
  `sri_pr_id` int(11) DEFAULT NULL,
  `sri_customer_name` varchar(250) DEFAULT NULL,
  `sri_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `sri_total_items` int(11) DEFAULT NULL,
  `sri_total_price` decimal(50,2) NOT NULL,
  `sri_product_disc` decimal(50,2) DEFAULT 0.00,
  `sri_round_off_disc` decimal(50,2) DEFAULT 0.00,
  `sri_cash_disc_per` decimal(50,2) DEFAULT 0.00,
  `sri_cash_disc_amount` decimal(50,2) DEFAULT 0.00,
  `sri_total_discount` decimal(50,2) DEFAULT 0.00,
  `sri_inclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `sri_exclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `sri_total_sales_tax` decimal(50,2) DEFAULT 0.00,
  `sri_grand_total` decimal(50,2) NOT NULL DEFAULT 0.00,
  `sri_cash_received` decimal(50,2) DEFAULT 0.00,
  `sri_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `sri_day_end_id` int(11) DEFAULT NULL,
  `sri_day_end_date` date DEFAULT NULL,
  `sri_createdby` int(11) DEFAULT NULL,
  `sri_detail_remarks` text DEFAULT NULL,
  `sri_sale_person` int(11) DEFAULT 0,
  `sri_invoice_transcation_type` int(11) DEFAULT 1,
  `sri_invoice_machine_id` int(11) DEFAULT 0,
  `sri_invoice_machine_name` varchar(500) DEFAULT NULL,
  `sri_service_charges_percentage` decimal(50,2) DEFAULT NULL,
  `sri_phone_number` varchar(150) DEFAULT NULL,
  `sri_credit_card_reference_number` varchar(50) DEFAULT NULL,
  `sri_email` varchar(500) DEFAULT NULL,
  `sri_whatsapp` varchar(150) DEFAULT NULL,
  `sri_service_invoice_id` int(11) DEFAULT 0,
  `sri_local_invoice_id` int(11) DEFAULT 0,
  `sri_local_service_invoice_id` int(11) DEFAULT 0,
  `sri_ip_adrs` varchar(255) NOT NULL,
  `sri_brwsr_info` varchar(4000) NOT NULL,
  `sri_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `sri_cash_received_from_customer` decimal(50,2) DEFAULT 0.00,
  `sri_return_amount` decimal(50,2) DEFAULT 0.00,
  `sri_discount_type` int(11) DEFAULT 1,
  `sri_invoice_profit` decimal(50,2) DEFAULT 0.00,
  PRIMARY KEY (`sri_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_sale_return_invoice`
--

LOCK TABLES `financials_sale_return_invoice` WRITE;
/*!40000 ALTER TABLE `financials_sale_return_invoice` DISABLE KEYS */;
INSERT INTO `financials_sale_return_invoice` VALUES (1,NULL,410101,'Product Loss & Recover',2,'','PRV-2',1,108.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,108.00,0.00,'2021-11-04 13:39:21',1,'2021-09-29',1,'Lays Rs. 5, 2@54.00 = 108&oS;',0,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:39:21',0.00,0.00,1,0.00),(5,NULL,410101,'Product Loss & Recover',2,'','TPRV-10',40,128000.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,128000.00,0.00,'2021-11-04 13:58:08',1,'2021-09-29',1,'Suger, 40.000@3200.00 = 128000&oS;',0,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:58:08',0.00,0.00,1,0.00),(6,NULL,410101,'Product Loss & Recover',1,'','PRV-12',1,180000.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,180000.00,0.00,'2021-11-06 09:35:55',1,'2021-09-29',1,'Daal Chawal, 50@3600.00 = 180000&oS;',0,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:35:55',0.00,0.00,1,0.00);
/*!40000 ALTER TABLE `financials_sale_return_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_sale_return_invoice_items`
--

DROP TABLE IF EXISTS `financials_sale_return_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_sale_return_invoice_items` (
  `srii_id` int(11) NOT NULL AUTO_INCREMENT,
  `srii_invoice_id` int(11) NOT NULL,
  `srii_product_code` varchar(500) NOT NULL,
  `srii_product_name` varchar(250) NOT NULL,
  `srii_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `srii_qty` decimal(50,3) NOT NULL,
  `srii_uom` varchar(500) DEFAULT '',
  `srii_scale_size` tinyint(4) DEFAULT NULL,
  `srii_bonus_qty` decimal(50,3) DEFAULT 0.000,
  `srii_rate` decimal(50,2) NOT NULL,
  `srii_discount_per` decimal(50,2) DEFAULT 0.00,
  `srii_discount_amount` decimal(50,2) DEFAULT 0.00,
  `srii_after_dis_rate` decimal(50,2) DEFAULT 0.00,
  `srii_net_rate` decimal(50,2) DEFAULT 0.00,
  `srii_saletax_per` decimal(50,2) DEFAULT 0.00,
  `srii_saletax_inclusive` tinyint(1) DEFAULT 0,
  `srii_saletax_amount` decimal(50,2) DEFAULT 0.00,
  `srii_warehouse_id` int(11) NOT NULL DEFAULT 0,
  `srii_amount` decimal(50,2) NOT NULL,
  `srii_product_profit` decimal(50,2) DEFAULT 0.00,
  PRIMARY KEY (`srii_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_sale_return_invoice_items`
--

LOCK TABLES `financials_sale_return_invoice_items` WRITE;
/*!40000 ALTER TABLE `financials_sale_return_invoice_items` DISABLE KEYS */;
INSERT INTO `financials_sale_return_invoice_items` VALUES (1,1,'300','Lays Rs. 5','',2.000,'',NULL,0.000,54.00,0.00,0.00,54.00,54.00,0.00,0,0.00,0,108.00,0.00),(5,5,'100','Suger','',40.000,'',40,0.000,3200.00,0.00,0.00,3200.00,3200.00,0.00,0,0.00,0,128000.00,0.00),(6,6,'400','Daal Chawal','',50.000,'',NULL,0.000,3600.00,0.00,0.00,3600.00,3600.00,0.00,0,0.00,0,180000.00,0.00);
/*!40000 ALTER TABLE `financials_sale_return_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_sale_return_saletax_invoice`
--

DROP TABLE IF EXISTS `financials_sale_return_saletax_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_sale_return_saletax_invoice` (
  `srsi_id` int(11) NOT NULL AUTO_INCREMENT,
  `srsi_sale_invoice_number` int(11) DEFAULT NULL,
  `srsi_party_code` int(11) NOT NULL,
  `srsi_party_name` varchar(250) NOT NULL,
  `srsi_pr_id` int(11) DEFAULT NULL,
  `srsi_customer_name` varchar(250) DEFAULT NULL,
  `srsi_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `srsi_total_items` int(11) DEFAULT NULL,
  `srsi_total_price` decimal(50,2) NOT NULL,
  `srsi_product_disc` decimal(50,2) DEFAULT 0.00,
  `srsi_round_off_disc` decimal(50,2) DEFAULT 0.00,
  `srsi_cash_disc_per` decimal(50,2) DEFAULT 0.00,
  `srsi_cash_disc_amount` decimal(50,2) DEFAULT 0.00,
  `srsi_total_discount` decimal(50,2) DEFAULT 0.00,
  `srsi_inclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `srsi_exclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `srsi_total_sales_tax` decimal(50,2) DEFAULT 0.00,
  `srsi_grand_total` decimal(50,2) NOT NULL DEFAULT 0.00,
  `srsi_cash_received` decimal(50,2) DEFAULT 0.00,
  `srsi_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `srsi_day_end_id` int(11) DEFAULT NULL,
  `srsi_day_end_date` date DEFAULT NULL,
  `srsi_createdby` int(11) DEFAULT NULL,
  `srsi_detail_remarks` text DEFAULT NULL,
  `srsi_sale_person` int(11) DEFAULT 0,
  `srsi_invoice_transcation_type` int(11) DEFAULT 1,
  `srsi_invoice_machine_id` int(11) DEFAULT 0,
  `srsi_invoice_machine_name` varchar(500) DEFAULT NULL,
  `srsi_service_charges_percentage` decimal(50,2) DEFAULT NULL,
  `srsi_phone_number` varchar(150) DEFAULT NULL,
  `srsi_credit_card_reference_number` varchar(50) DEFAULT NULL,
  `srsi_email` varchar(500) DEFAULT NULL,
  `srsi_whatsapp` varchar(150) DEFAULT NULL,
  `srsi_service_invoice_id` int(11) DEFAULT 0,
  `srsi_local_invoice_id` int(11) DEFAULT 0,
  `srsi_local_service_invoice_id` int(11) DEFAULT 0,
  `srsi_ip_adrs` varchar(255) NOT NULL,
  `srsi_brwsr_info` varchar(4000) NOT NULL,
  `srsi_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `srsi_cash_received_from_customer` decimal(50,2) DEFAULT 0.00,
  `srsi_return_amount` decimal(50,2) DEFAULT 0.00,
  `srsi_discount_type` int(11) DEFAULT 1,
  `srsi_invoice_profit` decimal(50,2) DEFAULT 0.00,
  PRIMARY KEY (`srsi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_sale_return_saletax_invoice`
--

LOCK TABLES `financials_sale_return_saletax_invoice` WRITE;
/*!40000 ALTER TABLE `financials_sale_return_saletax_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_sale_return_saletax_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_sale_return_saletax_invoice_items`
--

DROP TABLE IF EXISTS `financials_sale_return_saletax_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_sale_return_saletax_invoice_items` (
  `srsii_id` int(11) NOT NULL AUTO_INCREMENT,
  `srsii_invoice_id` int(11) NOT NULL,
  `srsii_product_code` varchar(500) NOT NULL,
  `srsii_product_name` varchar(250) NOT NULL,
  `srsii_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `srsii_qty` decimal(50,3) NOT NULL,
  `srsii_uom` varchar(500) DEFAULT '',
  `srsii_scale_size` tinyint(4) DEFAULT NULL,
  `srsii_bonus_qty` decimal(50,3) DEFAULT 0.000,
  `srsii_rate` decimal(50,2) NOT NULL,
  `srsii_discount_per` decimal(50,2) DEFAULT 0.00,
  `srsii_discount_amount` decimal(50,2) DEFAULT 0.00,
  `srsii_after_dis_rate` decimal(50,2) DEFAULT 0.00,
  `srsii_net_rate` decimal(50,2) DEFAULT 0.00,
  `srsii_saletax_per` decimal(50,2) DEFAULT 0.00,
  `srsii_saletax_inclusive` tinyint(1) DEFAULT 0,
  `srsii_saletax_amount` decimal(50,2) DEFAULT 0.00,
  `srsii_warehouse_id` int(11) NOT NULL DEFAULT 0,
  `srsii_amount` decimal(50,2) NOT NULL,
  `srsii_product_profit` decimal(50,2) DEFAULT 0.00,
  PRIMARY KEY (`srsii_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_sale_return_saletax_invoice_items`
--

LOCK TABLES `financials_sale_return_saletax_invoice_items` WRITE;
/*!40000 ALTER TABLE `financials_sale_return_saletax_invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_sale_return_saletax_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_sale_saletax_invoice`
--

DROP TABLE IF EXISTS `financials_sale_saletax_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_sale_saletax_invoice` (
  `ssi_id` int(11) NOT NULL AUTO_INCREMENT,
  `ssi_party_code` int(11) NOT NULL,
  `ssi_party_name` varchar(250) NOT NULL,
  `ssi_pr_id` int(11) DEFAULT NULL,
  `ssi_customer_name` varchar(250) DEFAULT NULL,
  `ssi_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `ssi_total_items` int(11) DEFAULT NULL,
  `ssi_total_price` decimal(50,2) NOT NULL,
  `ssi_product_disc` decimal(50,2) DEFAULT 0.00,
  `ssi_round_off_disc` decimal(50,2) DEFAULT 0.00,
  `ssi_cash_disc_per` decimal(50,2) DEFAULT 0.00,
  `ssi_cash_disc_amount` decimal(50,2) DEFAULT 0.00,
  `ssi_total_discount` decimal(50,2) DEFAULT 0.00,
  `ssi_inclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `ssi_exclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `ssi_total_sales_tax` decimal(50,2) DEFAULT 0.00,
  `ssi_grand_total` decimal(50,2) NOT NULL DEFAULT 0.00,
  `ssi_cash_received` decimal(50,2) DEFAULT 0.00,
  `ssi_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `ssi_day_end_id` int(11) DEFAULT NULL,
  `ssi_day_end_date` date DEFAULT NULL,
  `ssi_createdby` int(11) DEFAULT NULL,
  `ssi_detail_remarks` text DEFAULT NULL,
  `ssi_sale_person` int(11) DEFAULT 0,
  `ssi_invoice_transcation_type` int(11) DEFAULT 1,
  `ssi_invoice_machine_id` int(11) DEFAULT 0,
  `ssi_invoice_machine_name` varchar(500) DEFAULT NULL,
  `ssi_service_charges_percentage` decimal(50,2) DEFAULT NULL,
  `ssi_phone_number` varchar(150) DEFAULT NULL,
  `ssi_credit_card_reference_number` varchar(50) DEFAULT NULL,
  `ssi_email` varchar(500) DEFAULT NULL,
  `ssi_whatsapp` varchar(150) DEFAULT NULL,
  `ssi_service_invoice_id` int(11) DEFAULT 0,
  `ssi_local_invoice_id` int(11) DEFAULT 0,
  `ssi_local_service_invoice_id` int(11) DEFAULT 0,
  `ssi_ip_adrs` varchar(255) NOT NULL,
  `ssi_brwsr_info` varchar(4000) NOT NULL,
  `ssi_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `ssi_cash_received_from_customer` decimal(50,2) DEFAULT 0.00,
  `ssi_return_amount` decimal(50,2) DEFAULT 0.00,
  `ssi_discount_type` int(11) DEFAULT 1,
  `ssi_invoice_profit` decimal(50,2) DEFAULT 0.00,
  PRIMARY KEY (`ssi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_sale_saletax_invoice`
--

LOCK TABLES `financials_sale_saletax_invoice` WRITE;
/*!40000 ALTER TABLE `financials_sale_saletax_invoice` DISABLE KEYS */;
INSERT INTO `financials_sale_saletax_invoice` VALUES (1,110161,'Walk In Customer',1,'','',2,304000.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,304000.00,0.00,'2021-11-10 06:34:01',1,'2021-09-29',1,', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;',0,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 11:34:01',304000.00,0.00,1,0.00),(2,110161,'Walk In Customer',1,'','',1,160000.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,160000.00,0.00,'2021-11-10 07:07:08',1,'2021-09-29',1,', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;',0,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:07:08',160000.00,NULL,1,0.00),(3,110161,'Walk In Customer',1,'','',2,304000.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,304000.00,0.00,'2021-11-10 07:14:16',1,'2021-09-29',1,', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;',0,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:16',304000.00,NULL,1,0.00),(4,110161,'Walk In Customer',1,'','',2,304000.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,304000.00,0.00,'2021-11-10 07:14:48',1,'2021-09-29',1,', QTY 40.000@4,000.00 = 160,000.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;',0,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:48',304000.00,NULL,1,0.00),(5,110161,'Walk In Customer',1,'','',2,144720.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,144720.00,0.00,'2021-11-10 07:16:16',1,'2021-09-29',1,', QTY 12.000@60.00 = 720.00, Pack QTY = 1, Loose QTY = 0&oS;, QTY 40.000@3,600.00 = 144,000.00, Pack QTY = 1, Loose QTY = 0&oS;',0,1,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:16:16',144720.00,NULL,1,0.00);
/*!40000 ALTER TABLE `financials_sale_saletax_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_sale_saletax_invoice_items`
--

DROP TABLE IF EXISTS `financials_sale_saletax_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_sale_saletax_invoice_items` (
  `ssii_id` int(11) NOT NULL AUTO_INCREMENT,
  `ssii_invoice_id` int(11) NOT NULL,
  `ssii_product_code` varchar(500) NOT NULL,
  `ssii_product_name` varchar(250) NOT NULL,
  `ssii_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `ssii_qty` decimal(50,3) NOT NULL,
  `ssii_uom` varchar(500) DEFAULT '',
  `ssii_scale_size` tinyint(4) DEFAULT NULL,
  `ssii_bonus_qty` decimal(50,3) DEFAULT 0.000,
  `ssii_rate` decimal(50,2) NOT NULL,
  `ssii_discount_per` decimal(50,2) DEFAULT 0.00,
  `ssii_discount_amount` decimal(50,2) DEFAULT 0.00,
  `ssii_after_dis_rate` decimal(50,2) DEFAULT 0.00,
  `ssii_net_rate` decimal(50,2) DEFAULT 0.00,
  `ssii_saletax_per` decimal(50,2) DEFAULT 0.00,
  `ssii_saletax_inclusive` tinyint(1) DEFAULT 0,
  `ssii_saletax_amount` decimal(50,2) DEFAULT 0.00,
  `ssii_warehouse_id` int(11) NOT NULL DEFAULT 0,
  `ssii_amount` decimal(50,2) NOT NULL,
  `ssii_product_profit` decimal(50,2) DEFAULT 0.00,
  `ssii_created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ssii_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_sale_saletax_invoice_items`
--

LOCK TABLES `financials_sale_saletax_invoice_items` WRITE;
/*!40000 ALTER TABLE `financials_sale_saletax_invoice_items` DISABLE KEYS */;
INSERT INTO `financials_sale_saletax_invoice_items` VALUES (1,1,'400','Daal Chawal','',40.000,'Gattu',40,0.000,4000.00,0.00,0.00,4000.00,4000.00,0.00,0,0.00,1,160000.00,0.00,'2021-11-10 06:34:01'),(2,1,'100','Suger','',40.000,'Gattu',40,0.000,3600.00,0.00,0.00,3600.00,3600.00,0.00,0,0.00,1,144000.00,0.00,'2021-11-10 06:34:01'),(3,2,'400','Daal Chawal','',40.000,'Gattu',40,0.000,4000.00,0.00,0.00,4000.00,4000.00,0.00,0,0.00,1,160000.00,0.00,'2021-11-10 07:07:08'),(4,3,'400','Daal Chawal','',40.000,'Gattu',40,0.000,4000.00,0.00,0.00,4000.00,4000.00,0.00,0,0.00,1,160000.00,0.00,'2021-11-10 07:14:16'),(5,3,'100','Suger','',40.000,'Gattu',40,0.000,3600.00,0.00,0.00,3600.00,3600.00,0.00,0,0.00,1,144000.00,0.00,'2021-11-10 07:14:16'),(6,4,'400','Daal Chawal','',40.000,'Gattu',40,0.000,4000.00,0.00,0.00,4000.00,4000.00,0.00,0,0.00,1,160000.00,0.00,'2021-11-10 07:14:48'),(7,4,'100','Suger','',40.000,'Gattu',40,0.000,3600.00,0.00,0.00,3600.00,3600.00,0.00,0,0.00,1,144000.00,0.00,'2021-11-10 07:14:48'),(8,5,'300','Lays Rs. 5','',12.000,'Carton',12,0.000,60.00,0.00,0.00,60.00,60.00,0.00,0,0.00,1,720.00,0.00,'2021-11-10 07:16:16'),(9,5,'100','Suger','',40.000,'Gattu',40,0.000,3600.00,0.00,0.00,3600.00,3600.00,0.00,0,0.00,1,144000.00,0.00,'2021-11-10 07:16:16');
/*!40000 ALTER TABLE `financials_sale_saletax_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_secondary_finished_good`
--

DROP TABLE IF EXISTS `financials_secondary_finished_good`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_secondary_finished_good` (
  `sfg_id` int(11) NOT NULL AUTO_INCREMENT,
  `sfg_odr_id` int(11) NOT NULL,
  `sfg_pro_code` varchar(500) NOT NULL,
  `sfg_pro_name` varchar(1000) NOT NULL,
  `sfg_pro_remarks` text DEFAULT NULL,
  `sfg_recipe_production_qty` decimal(50,0) NOT NULL,
  `sfg_reqd_production_qty` decimal(50,0) DEFAULT NULL,
  `sfg_stock_before_production` decimal(50,2) NOT NULL,
  `sfg_stock_after_production` decimal(50,2) NOT NULL,
  `sfg_uom` varchar(1000) NOT NULL,
  PRIMARY KEY (`sfg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_secondary_finished_good`
--

LOCK TABLES `financials_secondary_finished_good` WRITE;
/*!40000 ALTER TABLE `financials_secondary_finished_good` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_secondary_finished_good` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_sectors`
--

DROP TABLE IF EXISTS `financials_sectors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_sectors` (
  `sec_id` int(11) NOT NULL AUTO_INCREMENT,
  `sec_title` varchar(250) NOT NULL,
  `sec_remarks` varchar(500) DEFAULT NULL,
  `sec_area_id` int(11) NOT NULL,
  `sec_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `sec_createdby` int(11) DEFAULT NULL,
  `sec_day_end_id` int(11) DEFAULT NULL,
  `sec_day_end_date` date DEFAULT NULL,
  `sec_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `sec_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `sec_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `sec_delete_status` int(11) DEFAULT 0,
  `sec_deleted_by` int(11) DEFAULT NULL,
  `sec_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`sec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_sectors`
--

LOCK TABLES `financials_sectors` WRITE;
/*!40000 ALTER TABLE `financials_sectors` DISABLE KEYS */;
INSERT INTO `financials_sectors` VALUES (1,'Initial Sector','',1,'2021-10-29 08:22:45',1,0,'2021-10-29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:22:45',0,NULL,0);
/*!40000 ALTER TABLE `financials_sectors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_self_collection`
--

DROP TABLE IF EXISTS `financials_self_collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_self_collection` (
  `sc_id` int(11) NOT NULL AUTO_INCREMENT,
  `sc_name` varchar(1000) NOT NULL,
  `sc_cnic` varchar(50) DEFAULT NULL,
  `sc_mobile` varchar(50) DEFAULT NULL,
  `sc_remarks` text DEFAULT NULL,
  `sc_delivery_option_id` int(11) NOT NULL,
  `sc_stock_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_self_collection`
--

LOCK TABLES `financials_self_collection` WRITE;
/*!40000 ALTER TABLE `financials_self_collection` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_self_collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_service_invoice`
--

DROP TABLE IF EXISTS `financials_service_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_service_invoice` (
  `sei_id` int(11) NOT NULL AUTO_INCREMENT,
  `sei_party_code` int(11) NOT NULL,
  `sei_party_name` varchar(250) NOT NULL,
  `sei_customer_name` varchar(250) DEFAULT NULL,
  `sei_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `sei_total_items` int(11) DEFAULT NULL,
  `sei_total_price` decimal(50,2) NOT NULL,
  `sei_product_disc` decimal(50,2) DEFAULT 0.00,
  `sei_round_off_disc` decimal(50,2) DEFAULT 0.00,
  `sei_cash_disc_per` decimal(50,2) DEFAULT 0.00,
  `sei_cash_disc_amount` decimal(50,2) DEFAULT 0.00,
  `sei_total_discount` decimal(50,2) DEFAULT 0.00,
  `sei_inclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `sei_exclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `sei_total_sales_tax` decimal(50,2) DEFAULT 0.00,
  `sei_grand_total` decimal(50,2) NOT NULL DEFAULT 0.00,
  `sei_cash_received` decimal(50,2) DEFAULT 0.00,
  `sei_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `sei_day_end_id` int(11) DEFAULT NULL,
  `sei_day_end_date` date DEFAULT NULL,
  `sei_createdby` int(11) DEFAULT NULL,
  `sei_detail_remarks` text DEFAULT NULL,
  `sei_sale_person` int(11) DEFAULT 0,
  `sei_invoice_transcation_type` int(11) DEFAULT 1,
  `sei_invoice_machine_id` int(11) DEFAULT 0,
  `sei_invoice_machine_name` varchar(500) DEFAULT NULL,
  `sei_service_charges_percentage` decimal(50,2) DEFAULT NULL,
  `sei_phone_number` varchar(150) DEFAULT NULL,
  `sei_credit_card_reference_number` varchar(50) DEFAULT NULL,
  `sei_email` varchar(500) DEFAULT NULL,
  `sei_whatsapp` varchar(150) DEFAULT NULL,
  `sei_sale_invoice_id` int(11) DEFAULT 0,
  `sei_local_invoice_id` int(11) DEFAULT 0,
  `sei_local_service_invoice_id` int(11) DEFAULT 0,
  `sei_ip_adrs` varchar(255) NOT NULL,
  `sei_brwsr_info` varchar(4000) NOT NULL,
  `sei_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `sei_cash_received_from_customer` decimal(50,2) DEFAULT 0.00,
  `sei_return_amount` decimal(50,2) DEFAULT 0.00,
  `sei_discount_type` int(11) DEFAULT 1,
  `sei_invoice_profit` decimal(50,2) DEFAULT 0.00,
  `sei_expense` varchar(255) DEFAULT NULL,
  `sei_trade_disc_percentage` decimal(50,2) DEFAULT NULL,
  `sei_trade_disc` decimal(50,2) DEFAULT NULL,
  `sei_sales_tax` decimal(50,2) DEFAULT NULL,
  `sei_cash_paid` decimal(50,2) DEFAULT NULL,
  PRIMARY KEY (`sei_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_service_invoice`
--

LOCK TABLES `financials_service_invoice` WRITE;
/*!40000 ALTER TABLE `financials_service_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_service_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_service_invoice_items`
--

DROP TABLE IF EXISTS `financials_service_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_service_invoice_items` (
  `seii_id` int(11) NOT NULL AUTO_INCREMENT,
  `seii_invoice_id` int(11) NOT NULL,
  `seii_service_code` int(11) NOT NULL,
  `seii_service_name` varchar(250) NOT NULL,
  `seii_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `seii_qty` decimal(50,3) NOT NULL,
  `seii_rate` decimal(50,2) NOT NULL,
  `seii_discount_per` decimal(50,2) DEFAULT 0.00,
  `seii_discount_amount` decimal(50,2) DEFAULT 0.00,
  `seii_after_dis_rate` decimal(50,2) DEFAULT 0.00,
  `seii_net_rate` decimal(50,2) DEFAULT 0.00,
  `seii_saletax_per` decimal(50,2) DEFAULT 0.00,
  `seii_saletax_inclusive` tinyint(1) DEFAULT 0,
  `seii_saletax_amount` decimal(50,2) DEFAULT 0.00,
  `seii_amount` decimal(50,2) NOT NULL,
  `seii_discount` decimal(50,2) DEFAULT NULL,
  `seii_saletax` decimal(50,2) DEFAULT NULL,
  `seii_scale_size` int(11) NOT NULL DEFAULT 1,
  `seii_service_invoice_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`seii_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_service_invoice_items`
--

LOCK TABLES `financials_service_invoice_items` WRITE;
/*!40000 ALTER TABLE `financials_service_invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_service_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_service_saletax_invoice`
--

DROP TABLE IF EXISTS `financials_service_saletax_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_service_saletax_invoice` (
  `sesi_id` int(11) NOT NULL AUTO_INCREMENT,
  `sesi_party_code` int(11) NOT NULL,
  `sesi_party_name` varchar(250) NOT NULL,
  `sesi_customer_name` varchar(250) DEFAULT NULL,
  `sesi_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `sesi_total_items` int(11) DEFAULT NULL,
  `sesi_total_price` decimal(50,2) NOT NULL,
  `sesi_product_disc` decimal(50,2) DEFAULT 0.00,
  `sesi_round_off_disc` decimal(50,2) DEFAULT 0.00,
  `sesi_cash_disc_per` decimal(50,2) DEFAULT 0.00,
  `sesi_cash_disc_amount` decimal(50,2) DEFAULT 0.00,
  `sesi_total_discount` decimal(50,2) DEFAULT 0.00,
  `sesi_inclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `sesi_exclusive_sales_tax` decimal(50,2) DEFAULT 0.00,
  `sesi_total_sales_tax` decimal(50,2) DEFAULT 0.00,
  `sesi_grand_total` decimal(50,2) NOT NULL DEFAULT 0.00,
  `sesi_cash_received` decimal(50,2) DEFAULT 0.00,
  `sesi_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `sesi_day_end_id` int(11) DEFAULT NULL,
  `sesi_day_end_date` date DEFAULT NULL,
  `sesi_createdby` int(11) DEFAULT NULL,
  `sesi_detail_remarks` text DEFAULT NULL,
  `sesi_sale_person` int(11) DEFAULT 0,
  `sesi_invoice_transcation_type` int(11) DEFAULT 1,
  `sesi_invoice_machine_id` int(11) DEFAULT 0,
  `sesi_invoice_machine_name` varchar(500) DEFAULT NULL,
  `sesi_service_charges_percentage` decimal(50,2) DEFAULT NULL,
  `sesi_phone_number` varchar(150) DEFAULT NULL,
  `sesi_credit_card_reference_number` varchar(50) DEFAULT NULL,
  `sesi_email` varchar(500) DEFAULT NULL,
  `sesi_whatsapp` varchar(150) DEFAULT NULL,
  `sesi_local_invoice_id` int(11) DEFAULT 0,
  `sesi_local_service_invoice_id` int(11) DEFAULT 0,
  `sesi_ip_adrs` varchar(255) NOT NULL,
  `sesi_brwsr_info` varchar(4000) NOT NULL,
  `sesi_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `sesi_cash_received_from_customer` decimal(50,2) DEFAULT 0.00,
  `sesi_return_amount` decimal(50,2) DEFAULT 0.00,
  `sesi_discount_type` int(11) DEFAULT 1,
  `sesi_invoice_profit` decimal(50,2) DEFAULT 0.00,
  `sesi_sale_invoice_id` int(11) DEFAULT 0,
  `sesi_expense` varchar(255) DEFAULT NULL,
  `sesi_trade_disc_percentage` decimal(50,2) DEFAULT NULL,
  `sesi_trade_disc` decimal(50,2) DEFAULT NULL,
  `sesi_sales_tax` decimal(50,2) DEFAULT NULL,
  `sesi_cash_paid` decimal(50,2) DEFAULT NULL,
  PRIMARY KEY (`sesi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_service_saletax_invoice`
--

LOCK TABLES `financials_service_saletax_invoice` WRITE;
/*!40000 ALTER TABLE `financials_service_saletax_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_service_saletax_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_service_saletax_invoice_items`
--

DROP TABLE IF EXISTS `financials_service_saletax_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_service_saletax_invoice_items` (
  `sesii_id` int(11) NOT NULL AUTO_INCREMENT,
  `sesii_invoice_id` int(11) NOT NULL,
  `sesii_service_code` int(11) NOT NULL,
  `sesii_service_name` varchar(250) NOT NULL,
  `sesii_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `sesii_qty` decimal(50,3) NOT NULL,
  `sesii_rate` decimal(50,2) NOT NULL,
  `sesii_scale_size` int(11) NOT NULL DEFAULT 1,
  `sesii_discount_per` decimal(50,2) DEFAULT 0.00,
  `sesii_discount_amount` decimal(50,2) DEFAULT 0.00,
  `sesii_after_dis_rate` decimal(50,2) DEFAULT 0.00,
  `sesii_net_rate` decimal(50,2) DEFAULT 0.00,
  `sesii_saletax_per` decimal(50,2) DEFAULT 0.00,
  `sesii_saletax_inclusive` tinyint(1) DEFAULT 0,
  `sesii_saletax_amount` decimal(50,2) DEFAULT 0.00,
  `sesii_amount` decimal(50,2) NOT NULL,
  `sesii_discount` decimal(50,2) DEFAULT NULL,
  `sesii_saletax` decimal(50,2) DEFAULT NULL,
  `sesii_service_invoice_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`sesii_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_service_saletax_invoice_items`
--

LOCK TABLES `financials_service_saletax_invoice_items` WRITE;
/*!40000 ALTER TABLE `financials_service_saletax_invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_service_saletax_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_services`
--

DROP TABLE IF EXISTS `financials_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_services` (
  `ser_id` int(11) NOT NULL AUTO_INCREMENT,
  `ser_title` varchar(500) DEFAULT NULL,
  `ser_remarks` varchar(1000) DEFAULT NULL,
  `ser_created_by` int(11) DEFAULT NULL,
  `ser_datetime` timestamp NULL DEFAULT NULL,
  `ser_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `ser_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `ser_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `ser_delete_status` int(11) DEFAULT 0,
  `ser_deleted_by` int(11) DEFAULT NULL,
  `ser_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`ser_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_services`
--

LOCK TABLES `financials_services` WRITE;
/*!40000 ALTER TABLE `financials_services` DISABLE KEYS */;
INSERT INTO `financials_services` VALUES (1,'Shop Survey','',1,'2021-11-10 07:28:20','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:28:20',0,NULL,0);
/*!40000 ALTER TABLE `financials_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_si_dc_extension`
--

DROP TABLE IF EXISTS `financials_si_dc_extension`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_si_dc_extension` (
  `sde_id` int(11) NOT NULL AUTO_INCREMENT,
  `sde_sale_id` varchar(255) DEFAULT NULL,
  `sde_dc_id` varchar(255) DEFAULT NULL,
  `sde_sale_tax_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sde_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_si_dc_extension`
--

LOCK TABLES `financials_si_dc_extension` WRITE;
/*!40000 ALTER TABLE `financials_si_dc_extension` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_si_dc_extension` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_stock_inward`
--

DROP TABLE IF EXISTS `financials_stock_inward`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_stock_inward` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `si_party_code` int(11) DEFAULT NULL,
  `si_party_name` varchar(500) DEFAULT NULL,
  `si_purchase_order_id` int(11) DEFAULT NULL,
  `si_builty_no` int(11) DEFAULT NULL,
  `si_builty_qty` decimal(50,3) DEFAULT NULL,
  `si_receiving_datetime` timestamp NULL DEFAULT current_timestamp(),
  `si_remarks` text DEFAULT NULL,
  `si_datetime` timestamp NULL DEFAULT current_timestamp(),
  `si_createdby` int(11) NOT NULL,
  `si_day_end_id` int(11) NOT NULL,
  `si_day_end_date` datetime NOT NULL,
  `si_ip_adrs` varchar(500) NOT NULL,
  `si_brwsr_info` varchar(1000) NOT NULL,
  `si_type` varchar(500) NOT NULL,
  PRIMARY KEY (`si_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_stock_inward`
--

LOCK TABLES `financials_stock_inward` WRITE;
/*!40000 ALTER TABLE `financials_stock_inward` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_stock_inward` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_stock_movement`
--

DROP TABLE IF EXISTS `financials_stock_movement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_stock_movement` (
  `sm_id` int(11) NOT NULL AUTO_INCREMENT,
  `sm_type` varchar(100) NOT NULL,
  `sm_product_code` varchar(100) NOT NULL,
  `sm_product_name` varchar(500) NOT NULL,
  `sm_in_qty` decimal(50,3) DEFAULT NULL,
  `sm_in_bonus` decimal(50,3) DEFAULT NULL,
  `sm_in_rate` decimal(50,2) DEFAULT NULL,
  `sm_in_total` decimal(50,2) DEFAULT NULL,
  `sm_out_qty` decimal(50,3) DEFAULT NULL,
  `sm_out_bonus` decimal(50,3) DEFAULT NULL,
  `sm_out_rate` decimal(50,2) DEFAULT NULL,
  `sm_out_total` decimal(50,2) DEFAULT NULL,
  `sm_internal_hold` decimal(50,3) DEFAULT NULL,
  `sm_internal_bonus` decimal(50,3) DEFAULT NULL,
  `sm_internal_claim` decimal(50,3) DEFAULT NULL,
  `sm_bal_qty_for_sale` decimal(50,3) NOT NULL DEFAULT 0.000,
  `sm_bal_bonus_inward` decimal(50,3) NOT NULL DEFAULT 0.000,
  `sm_bal_bonus_outward` decimal(50,3) NOT NULL DEFAULT 0.000,
  `sm_bal_bonus_qty` decimal(50,3) NOT NULL DEFAULT 0.000,
  `sm_bal_hold` decimal(50,3) NOT NULL DEFAULT 0.000,
  `sm_bal_total_hold` decimal(50,3) NOT NULL DEFAULT 0.000,
  `sm_bal_claims` decimal(50,3) NOT NULL DEFAULT 0.000,
  `sm_bal_total_qty_wo_bonus` decimal(50,3) NOT NULL DEFAULT 0.000,
  `sm_bal_total_qty` decimal(50,3) NOT NULL DEFAULT 0.000,
  `sm_bal_rate` decimal(50,2) NOT NULL DEFAULT 0.00,
  `sm_bal_total` decimal(50,2) NOT NULL DEFAULT 0.00,
  `sm_warehouse_id` int(11) DEFAULT NULL,
  `sm_day_end_id` int(11) NOT NULL,
  `sm_day_end_date` date NOT NULL,
  `sm_voucher_code` varchar(50) DEFAULT NULL,
  `sm_remarks` varchar(4000) DEFAULT NULL,
  `sm_user_id` int(11) NOT NULL,
  `sm_date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`sm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_stock_movement`
--

LOCK TABLES `financials_stock_movement` WRITE;
/*!40000 ALTER TABLE `financials_stock_movement` DISABLE KEYS */;
INSERT INTO `financials_stock_movement` VALUES (4,'OPENING_BALANCE','100','Suger',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,16035.000,0.000,0.000,0.000,0.000,0.000,0.000,16035.000,16035.000,3200.00,51312000.00,NULL,1,'2021-09-29',NULL,'',1,'2021-10-29 08:34:14'),(5,'OPENING_BALANCE','200','Pepsi 1500 ML',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,95.000,0.000,0.000,0.000,0.000,0.000,0.000,95.000,95.000,510.00,48450.00,NULL,1,'2021-09-29',NULL,'',1,'2021-10-29 08:34:14'),(6,'OPENING_BALANCE','300','Lays Rs. 5',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,12.000,0.000,0.000,0.000,0.000,0.000,0.000,12.000,12.000,54.00,648.00,NULL,1,'2021-09-29',NULL,'',1,'2021-10-29 08:34:14'),(7,'PURCHASE','300','Lays Rs. 5',1.000,0.000,54.00,54.00,NULL,NULL,NULL,0.00,NULL,NULL,NULL,13.000,0.000,0.000,0.000,0.000,0.000,0.000,13.000,13.000,54.00,702.00,1,1,'2021-09-29','PI-1','PURCHASE',1,'2021-11-03 10:00:52'),(8,'PURCHASE','300','Lays Rs. 5',1.000,0.000,54.00,54.00,NULL,NULL,NULL,0.00,NULL,NULL,NULL,14.000,0.000,0.000,0.000,0.000,0.000,0.000,14.000,14.000,54.00,756.00,1,1,'2021-09-29','PI-1','PURCHASE',1,'2021-11-03 10:00:52'),(11,'SALE','300','Lays Rs. 5',NULL,NULL,NULL,0.00,1.000,0.000,54.00,54.00,NULL,NULL,NULL,13.000,0.000,0.000,0.000,0.000,0.000,0.000,13.000,13.000,54.00,702.00,1,1,'2021-09-29','SI-2','SALE',1,'2021-11-03 13:11:06'),(12,'PRODUCT RECOVER','300','Lays Rs. 5',2.000,0.000,54.00,108.00,NULL,NULL,NULL,0.00,NULL,NULL,NULL,15.000,0.000,0.000,0.000,0.000,0.000,0.000,15.000,15.000,54.00,810.00,1,1,'2021-09-29','PRV-1','PRODUCT_RECOVER',1,'2021-11-04 13:39:21'),(13,'PRODUCT LOSS','300','Lays Rs. 5',NULL,NULL,NULL,0.00,1.000,0.000,54.00,54.00,NULL,NULL,NULL,14.000,0.000,0.000,0.000,0.000,0.000,0.000,14.000,14.000,54.00,756.00,1,1,'2021-09-29','PLV-3','PRODUCT_LOSS',1,'2021-11-04 13:40:05'),(14,'PRODUCT LOSS','100','Suger',NULL,NULL,NULL,0.00,40.000,0.000,3200.00,128000.00,NULL,NULL,NULL,15995.000,0.000,0.000,0.000,0.000,0.000,0.000,15995.000,15995.000,3200.00,51184000.00,1,1,'2021-09-29','TPLV-4','PRODUCT_LOSS',1,'2021-11-04 13:40:43'),(18,'PRODUCT RECOVER','100','Suger',40.000,0.000,3200.00,128000.00,NULL,NULL,NULL,0.00,NULL,NULL,NULL,16035.000,0.000,0.000,0.000,0.000,0.000,0.000,16035.000,16035.000,3200.00,51312000.00,1,1,'2021-09-29','TPRV-5','PRODUCT_RECOVER',1,'2021-11-04 13:58:08'),(19,'SALE-ORDER','300','Lays Rs. 5',NULL,NULL,NULL,0.00,NULL,NULL,NULL,0.00,1.000,0.000,NULL,13.000,0.000,0.000,0.000,1.000,1.000,0.000,13.000,13.000,54.00,702.00,1,1,'2021-09-29','SO-1','SALE-ORDER',1,'2021-11-05 08:07:35'),(20,'SALE-ORDER','100','Suger',NULL,NULL,NULL,0.00,NULL,NULL,NULL,0.00,40.000,0.000,NULL,15995.000,0.000,0.000,0.000,40.000,40.000,0.000,15995.000,15995.000,3200.00,51184000.00,1,1,'2021-09-29','TSO-2','SALE-ORDER',1,'2021-11-05 08:09:18'),(21,'SALE-ORDER','200','Pepsi 1500 ML',NULL,NULL,NULL,0.00,NULL,NULL,NULL,0.00,1.000,0.000,NULL,94.000,0.000,0.000,0.000,1.000,1.000,0.000,94.000,94.000,510.00,47940.00,1,1,'2021-09-29','SO-3','SALE-ORDER',1,'2021-11-05 08:15:17'),(22,'SALE-ORDER-SALE-INVOICE','100','Suger',NULL,NULL,NULL,0.00,40.000,0.000,3200.00,128000.00,NULL,NULL,NULL,15995.000,0.000,0.000,0.000,-40.000,0.000,0.000,15995.000,15995.000,3200.00,51184000.00,1,1,'2021-09-29','TSOSI-5','SALE-ORDER-SALE-INVOICE',1,'2021-11-05 08:21:12'),(23,'DELIVERY-ORDER','200','Pepsi 1500 ML',NULL,NULL,NULL,0.00,NULL,NULL,NULL,0.00,1.000,0.000,NULL,93.000,0.000,0.000,0.000,1.000,2.000,0.000,93.000,93.000,510.00,47430.00,1,1,'2021-09-29','DO-1','DELIVERY-ORDER',1,'2021-11-05 11:55:27'),(24,'DELIVERY-ORDER','200','Pepsi 1500 ML',NULL,NULL,NULL,0.00,NULL,NULL,NULL,0.00,6.000,0.000,NULL,87.000,0.000,0.000,0.000,6.000,8.000,0.000,87.000,87.000,510.00,44370.00,1,1,'2021-09-29','TDO-2','DELIVERY-ORDER',1,'2021-11-05 11:55:48'),(25,'DELIVERY-ORDER','300','Lays Rs. 5',NULL,NULL,NULL,0.00,NULL,NULL,NULL,0.00,1.000,0.000,NULL,12.000,0.000,0.000,0.000,1.000,2.000,0.000,12.000,12.000,54.00,648.00,1,1,'2021-09-29','DO-3','DELIVERY-ORDER',1,'2021-11-05 12:15:35'),(26,'GOODS-RECEIPT-NOTE','100','Suger',NULL,NULL,NULL,0.00,NULL,NULL,NULL,0.00,1.000,0.000,NULL,15995.000,0.000,0.000,0.000,1.000,1.000,0.000,15996.000,15996.000,3200.00,51187200.00,1,1,'2021-09-29','GRN-1','GOODS-RECEIPT-NOTE',1,'2021-11-05 13:22:38'),(27,'GOODS-RECEIPT-NOTE','100','Suger',NULL,NULL,NULL,0.00,NULL,NULL,NULL,0.00,40.000,0.000,NULL,15995.000,0.000,0.000,0.000,40.000,41.000,0.000,16036.000,16036.000,3200.00,51315200.00,1,1,'2021-09-29','GRN-2','GOODS-RECEIPT-NOTE',1,'2021-11-05 13:23:35'),(28,'GOODS-RECEIPT-NOTE','100','Suger',NULL,NULL,NULL,0.00,NULL,NULL,NULL,0.00,40.000,0.000,NULL,15995.000,0.000,0.000,0.000,40.000,81.000,0.000,16076.000,16076.000,3200.00,51443200.00,1,1,'2021-09-29','GRN-3','GOODS-RECEIPT-NOTE',1,'2021-11-05 13:24:05'),(29,'GOODS-RECEIPT-NOTE','100','Suger',NULL,NULL,NULL,0.00,NULL,NULL,NULL,0.00,40.000,0.000,NULL,15995.000,0.000,0.000,0.000,40.000,121.000,0.000,16116.000,16116.000,3200.00,51571200.00,1,1,'2021-09-29','GRN-4','GOODS-RECEIPT-NOTE',1,'2021-11-05 13:27:49'),(30,'PURCHASE','300','Lays Rs. 5',1.000,0.000,54.00,54.00,NULL,NULL,NULL,0.00,NULL,NULL,NULL,13.000,0.000,0.000,0.000,0.000,2.000,0.000,15.000,15.000,54.00,810.00,1,1,'2021-09-29','PI-2','PURCHASE',1,'2021-11-06 07:12:26'),(31,'PURCHASE RETURN','300','Lays Rs. 5',NULL,NULL,NULL,0.00,1.000,0.000,54.00,54.00,NULL,NULL,NULL,12.000,0.000,0.000,0.000,0.000,2.000,0.000,14.000,14.000,54.00,756.00,1,1,'2021-09-29','PRI-1','PURCHASE_RETURN',1,'2021-11-06 07:12:56'),(32,'PURCHASE RETURN','300','Lays Rs. 5',NULL,NULL,NULL,0.00,1.000,0.000,54.00,54.00,NULL,NULL,NULL,11.000,0.000,0.000,0.000,0.000,2.000,0.000,13.000,13.000,54.00,702.00,1,1,'2021-09-29','PRI-2','PURCHASE_RETURN',1,'2021-11-06 07:24:07'),(33,'PURCHASE RETURN','300','Lays Rs. 5',NULL,NULL,NULL,0.00,1.000,0.000,54.00,54.00,NULL,NULL,NULL,10.000,0.000,0.000,0.000,0.000,2.000,0.000,12.000,12.000,54.00,648.00,1,1,'2021-09-29','PRI-2','PURCHASE_RETURN',1,'2021-11-06 07:24:07'),(34,'PURCHASE RETURN','200','Pepsi 1500 ML',NULL,NULL,NULL,0.00,1.000,0.000,510.00,510.00,NULL,NULL,NULL,86.000,0.000,0.000,0.000,0.000,8.000,0.000,94.000,94.000,510.00,47940.00,1,1,'2021-09-29','PRI-3','PURCHASE_RETURN',1,'2021-11-06 07:29:15'),(35,'TRANSFER FROM HOLD','300','Lays Rs. 5',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,-1.000,NULL,NULL,11.000,0.000,0.000,0.000,-1.000,1.000,0.000,12.000,12.000,54.00,648.00,1,1,'2021-09-29','','',1,'2021-11-06 08:55:41'),(37,'OPENING_BALANCE','400','Daal Chawal',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.000,0.000,0.000,0.000,0.000,0.000,0.000,0.000,0.000,3600.00,0.00,NULL,1,'2021-09-29',NULL,'',1,'2021-11-06 09:25:27'),(38,'PURCHASE','400','Daal Chawal',20.000,0.000,3600.00,72000.00,NULL,NULL,NULL,0.00,NULL,NULL,NULL,20.000,0.000,0.000,0.000,0.000,0.000,0.000,20.000,20.000,3600.00,72000.00,1,1,'2021-09-29','PI-3','PURCHASE',1,'2021-11-06 09:27:45'),(39,'PURCHASE','300','Lays Rs. 5',2.000,0.000,54.00,108.00,NULL,NULL,NULL,0.00,NULL,NULL,NULL,13.000,0.000,0.000,0.000,0.000,1.000,0.000,14.000,14.000,54.00,756.00,1,1,'2021-09-29','PI-4','PURCHASE',1,'2021-11-06 09:29:41'),(40,'PURCHASE','400','Daal Chawal',2.000,0.000,3600.00,7200.00,NULL,NULL,NULL,0.00,NULL,NULL,NULL,22.000,0.000,0.000,0.000,0.000,0.000,0.000,22.000,22.000,3600.00,79200.00,1,1,'2021-09-29','PI-4','PURCHASE',1,'2021-11-06 09:29:41'),(41,'PURCHASE','400','Daal Chawal',2.000,0.000,3600.00,7200.00,NULL,NULL,NULL,0.00,NULL,NULL,NULL,24.000,0.000,0.000,0.000,0.000,0.000,0.000,24.000,24.000,3600.00,86400.00,1,1,'2021-09-29','PI-4','PURCHASE',1,'2021-11-06 09:29:41'),(42,'PRODUCT LOSS','400','Daal Chawal',NULL,NULL,NULL,0.00,24.000,0.000,3600.00,86400.00,NULL,NULL,NULL,0.000,0.000,0.000,0.000,0.000,0.000,0.000,0.000,0.000,3600.00,0.00,1,1,'2021-09-29','PLV-6','PRODUCT_LOSS',1,'2021-11-06 09:33:27'),(43,'PRODUCT RECOVER','400','Daal Chawal',50.000,0.000,3600.00,180000.00,NULL,NULL,NULL,0.00,NULL,NULL,NULL,50.000,0.000,0.000,0.000,0.000,0.000,0.000,50.000,50.000,3600.00,180000.00,1,1,'2021-09-29','PRV-6','PRODUCT_RECOVER',1,'2021-11-06 09:35:55'),(44,'PURCHASE RETURN','400','Daal Chawal',NULL,NULL,NULL,0.00,20.000,0.000,3600.00,72000.00,NULL,NULL,NULL,30.000,0.000,0.000,0.000,0.000,0.000,0.000,30.000,30.000,3600.00,108000.00,1,1,'2021-09-29','PRI-4','PURCHASE_RETURN',1,'2021-11-06 09:37:15'),(45,'SALE','300','Lays Rs. 5',NULL,NULL,NULL,0.00,1.000,0.000,54.00,54.00,NULL,NULL,NULL,12.000,0.000,0.000,0.000,0.000,1.000,0.000,13.000,13.000,54.00,702.00,1,1,'2021-09-29','SI-7','SALE',1,'2021-11-06 09:39:07'),(46,'SALE','400','Daal Chawal',NULL,NULL,NULL,0.00,10.000,0.000,3600.00,36000.00,NULL,NULL,NULL,20.000,0.000,0.000,0.000,0.000,0.000,0.000,20.000,20.000,3600.00,72000.00,1,1,'2021-09-29','SI-7','SALE',1,'2021-11-06 09:39:07'),(47,'SALE','300','Lays Rs. 5',NULL,NULL,NULL,0.00,1.000,0.000,54.00,54.00,NULL,NULL,NULL,11.000,0.000,0.000,0.000,0.000,1.000,0.000,12.000,12.000,54.00,648.00,1,1,'2021-09-29','SI-7','SALE',1,'2021-11-06 09:39:07'),(48,'SALE','400','Daal Chawal',NULL,NULL,NULL,0.00,5.000,0.000,3600.00,18000.00,NULL,NULL,NULL,15.000,0.000,0.000,0.000,0.000,0.000,0.000,15.000,15.000,3600.00,54000.00,1,1,'2021-09-29','SI-7','SALE',1,'2021-11-06 09:39:07'),(49,'CLAIM ISSUE','400','Daal Chawal',NULL,NULL,NULL,NULL,1.000,NULL,3600.00,3600.00,NULL,NULL,-1.000,15.000,0.000,0.000,0.000,0.000,0.000,-1.000,14.000,14.000,3600.00,50400.00,1,1,'2021-09-29','','',1,'2021-11-06 09:47:29'),(50,'CLAIM RECEIVED','400','Daal Chawal',1.000,NULL,3600.00,3600.00,NULL,NULL,NULL,NULL,NULL,NULL,1.000,15.000,0.000,0.000,0.000,0.000,0.000,0.000,15.000,15.000,3600.00,54000.00,NULL,1,'2021-09-29','','',1,'2021-11-06 10:11:52'),(51,'CLAIM RECEIVED','400','Daal Chawal',40.000,NULL,4000.00,160000.00,NULL,NULL,NULL,NULL,NULL,NULL,40.000,15.000,0.000,0.000,0.000,0.000,0.000,40.000,55.000,55.000,3890.91,214000.00,NULL,1,'2021-09-29','','',1,'2021-11-06 10:12:21'),(52,'CLAIM ISSUE','400','Daal Chawal',NULL,NULL,NULL,NULL,40.000,NULL,4000.00,160000.00,NULL,NULL,-40.000,15.000,0.000,0.000,0.000,0.000,0.000,-41.000,-26.000,-26.000,4215.38,-109600.00,1,1,'2021-09-29','','',1,'2021-11-06 10:13:46'),(53,'SALE','300','Lays Rs. 5',NULL,NULL,NULL,0.00,1.000,0.000,54.00,54.00,NULL,NULL,NULL,10.000,0.000,0.000,0.000,0.000,1.000,0.000,11.000,11.000,54.00,594.00,1,1,'2021-09-29','SI-8','SALE',1,'2021-11-08 10:30:55'),(54,'SALE','100','Suger',NULL,NULL,NULL,0.00,1.000,0.000,3200.00,3200.00,NULL,NULL,NULL,15994.000,0.000,0.000,0.000,0.000,121.000,0.000,16115.000,16115.000,3200.00,51568000.00,1,1,'2021-09-29','SI-8','SALE',1,'2021-11-08 10:30:55'),(55,'SALE','100','Suger',NULL,NULL,NULL,0.00,1.000,0.000,3200.00,3200.00,NULL,NULL,NULL,15993.000,0.000,0.000,0.000,0.000,121.000,0.000,16114.000,16114.000,3200.00,51564800.00,1,1,'2021-09-29','SI-9','SALE',1,'2021-11-08 10:31:14'),(56,'SALE','300','Lays Rs. 5',NULL,NULL,NULL,0.00,1.000,0.000,54.00,54.00,NULL,NULL,NULL,9.000,0.000,0.000,0.000,0.000,1.000,0.000,10.000,10.000,54.00,540.00,1,1,'2021-09-29','SI-9','SALE',1,'2021-11-08 10:31:14'),(57,'SALE','300','Lays Rs. 5',NULL,NULL,NULL,0.00,1.000,0.000,54.00,54.00,NULL,NULL,NULL,8.000,0.000,0.000,0.000,0.000,1.000,0.000,9.000,9.000,54.00,486.00,1,1,'2021-09-29','SI-10','SALE',1,'2021-11-08 10:48:08'),(58,'SALE','400','Daal Chawal',NULL,NULL,NULL,0.00,40.000,0.000,4215.38,168615.20,NULL,NULL,NULL,-25.000,0.000,0.000,0.000,0.000,0.000,-41.000,-66.000,-66.000,4215.38,0.00,1,1,'2021-09-29','TSI-11','SALE',1,'2021-11-09 06:28:34'),(59,'PURCHASE','400','Daal Chawal',100.000,0.000,4000.00,400000.00,NULL,NULL,NULL,0.00,NULL,NULL,NULL,75.000,0.000,0.000,0.000,0.000,0.000,-41.000,34.000,34.000,4000.00,136000.00,1,1,'2021-09-29','PI-5','PURCHASE',1,'2021-11-09 11:57:01'),(60,'TRANSFER FROM CLAIM','400','Daal Chawal',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,-41.000,116.000,0.000,0.000,0.000,0.000,0.000,-82.000,34.000,34.000,4000.00,136000.00,1,1,'2021-09-29','','',1,'2021-11-09 11:58:04'),(61,'TRANSFER FROM CLAIM','400','Daal Chawal',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,-82.000,198.000,0.000,0.000,0.000,0.000,0.000,-164.000,34.000,34.000,4000.00,136000.00,1,1,'2021-09-29','','',1,'2021-11-09 11:58:43'),(62,'SALE','400','Daal Chawal',NULL,NULL,NULL,0.00,40.000,0.000,4000.00,160000.00,NULL,NULL,NULL,158.000,0.000,0.000,0.000,0.000,0.000,-164.000,-6.000,-6.000,4000.00,0.00,1,1,'2021-09-29','TSTSI-1','SALE',1,'2021-11-10 06:34:01'),(63,'SALE','100','Suger',NULL,NULL,NULL,0.00,40.000,0.000,3200.00,128000.00,NULL,NULL,NULL,15953.000,0.000,0.000,0.000,0.000,121.000,0.000,16074.000,16074.000,3200.00,51436800.00,1,1,'2021-09-29','TSTSI-1','SALE',1,'2021-11-10 06:34:02'),(64,'SALE','400','Daal Chawal',NULL,NULL,NULL,0.00,40.000,0.000,4000.00,160000.00,NULL,NULL,NULL,118.000,0.000,0.000,0.000,0.000,0.000,-164.000,-46.000,-46.000,4000.00,0.00,1,1,'2021-09-29','TSTSI-2','SALE',1,'2021-11-10 07:07:08'),(65,'SALE','400','Daal Chawal',NULL,NULL,NULL,0.00,40.000,0.000,4000.00,160000.00,NULL,NULL,NULL,78.000,0.000,0.000,0.000,0.000,0.000,-164.000,-86.000,-86.000,4000.00,0.00,1,1,'2021-09-29','TSTSI-3','SALE',1,'2021-11-10 07:14:16'),(66,'SALE','100','Suger',NULL,NULL,NULL,0.00,40.000,0.000,3200.00,128000.00,NULL,NULL,NULL,15913.000,0.000,0.000,0.000,0.000,121.000,0.000,16034.000,16034.000,3200.00,51308800.00,1,1,'2021-09-29','TSTSI-3','SALE',1,'2021-11-10 07:14:16'),(67,'SALE','400','Daal Chawal',NULL,NULL,NULL,0.00,40.000,0.000,4000.00,160000.00,NULL,NULL,NULL,38.000,0.000,0.000,0.000,0.000,0.000,-164.000,-126.000,-126.000,4000.00,0.00,1,1,'2021-09-29','TSTSI-4','SALE',1,'2021-11-10 07:14:48'),(68,'SALE','100','Suger',NULL,NULL,NULL,0.00,40.000,0.000,3200.00,128000.00,NULL,NULL,NULL,15873.000,0.000,0.000,0.000,0.000,121.000,0.000,15994.000,15994.000,3200.00,51180800.00,1,1,'2021-09-29','TSTSI-4','SALE',1,'2021-11-10 07:14:48'),(69,'SALE','300','Lays Rs. 5',NULL,NULL,NULL,0.00,12.000,0.000,54.00,648.00,NULL,NULL,NULL,-4.000,0.000,0.000,0.000,0.000,1.000,0.000,-3.000,-3.000,54.00,0.00,1,1,'2021-09-29','TSTSI-5','SALE',1,'2021-11-10 07:16:16'),(70,'SALE','100','Suger',NULL,NULL,NULL,0.00,40.000,0.000,3200.00,128000.00,NULL,NULL,NULL,15833.000,0.000,0.000,0.000,0.000,121.000,0.000,15954.000,15954.000,3200.00,51052800.00,1,1,'2021-09-29','TSTSI-5','SALE',1,'2021-11-10 07:16:16'),(71,'SALE','300','Lays Rs. 5',NULL,NULL,NULL,0.00,12.000,0.000,54.00,648.00,NULL,NULL,NULL,-16.000,0.000,0.000,0.000,0.000,1.000,0.000,-15.000,-15.000,54.00,0.00,1,1,'2021-09-29','TSI-12','SALE',1,'2021-11-10 11:35:19'),(72,'SALE','200','Pepsi 1500 ML',NULL,NULL,NULL,0.00,6.000,0.000,510.00,3060.00,NULL,NULL,NULL,80.000,0.000,0.000,0.000,0.000,8.000,0.000,88.000,88.000,510.00,44880.00,1,1,'2021-09-29','TSI-13','SALE',1,'2021-11-10 12:24:35'),(73,'SALE','100','Suger',NULL,NULL,NULL,0.00,40.000,0.000,3200.00,128000.00,NULL,NULL,NULL,15793.000,0.000,0.000,0.000,0.000,121.000,0.000,15914.000,15914.000,3200.00,50924800.00,1,1,'2021-09-29','TSI-13','SALE',1,'2021-11-10 12:24:35');
/*!40000 ALTER TABLE `financials_stock_movement` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`digitalmunshi`@`localhost`*/ /*!50003 TRIGGER `update_product_qty_rate` AFTER INSERT ON `financials_stock_movement` FOR EACH ROW IF (NEW.sm_type = 'PURCHASE' OR NEW.sm_type = 'CLAIM RECEIVED' OR NEW.sm_type = 'COMPLETE') THEN
    UPDATE financials_products SET
    pro_average_rate = NEW.sm_bal_rate,
    pro_qty_for_sale = NEW.sm_bal_qty_for_sale,
    pro_bonus_qty = NEW.sm_bal_bonus_qty,
    pro_hold_qty = NEW.sm_bal_total_hold,
    pro_claim_qty = NEW.sm_bal_claims,
    pro_qty_wo_bonus = NEW.sm_bal_total_qty_wo_bonus,
    pro_quantity = NEW.sm_bal_total_qty,
    pro_last_purchase_rate = NEW.sm_in_rate
    WHERE pro_p_code = NEW.sm_product_code;
ELSE
    UPDATE financials_products SET
    pro_average_rate = NEW.sm_bal_rate,
    pro_qty_for_sale = NEW.sm_bal_qty_for_sale,
    pro_bonus_qty = NEW.sm_bal_bonus_qty,
    pro_hold_qty = NEW.sm_bal_total_hold,
    pro_claim_qty = NEW.sm_bal_claims,
    pro_qty_wo_bonus = NEW.sm_bal_total_qty_wo_bonus,
    pro_quantity = NEW.sm_bal_total_qty
    WHERE pro_p_code = NEW.sm_product_code;
END IF */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `financials_stock_movement_child`
--

DROP TABLE IF EXISTS `financials_stock_movement_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_stock_movement_child` (
  `smc_id` int(11) NOT NULL AUTO_INCREMENT,
  `smc_sm_id` int(11) DEFAULT NULL,
  `smc_party_code` int(11) DEFAULT NULL,
  `smc_party_name` varchar(250) DEFAULT NULL,
  `smc_invoice_type` varchar(250) DEFAULT NULL,
  `smc_invoice_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`smc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_stock_movement_child`
--

LOCK TABLES `financials_stock_movement_child` WRITE;
/*!40000 ALTER TABLE `financials_stock_movement_child` DISABLE KEYS */;
INSERT INTO `financials_stock_movement_child` VALUES (1,8,110132,'ABD 436','PURCHASE',1),(2,8,110132,'ABD 436','PURCHASE',1),(3,9,110161,'Walk In Customer','SALE',1),(4,10,110161,'Walk In Customer','SALE',1),(5,11,110131,'Client One','SALE',2),(6,19,110132,'ABD 436','SALE_ORDER',1),(7,20,110161,'Walk In Customer','SALE_ORDER',2),(8,21,110131,'Client One','SALE_ORDER',3),(9,22,110161,'Walk In Customer','SALE-ORDER-SALE-INVOICE',5),(10,23,110132,'ABD 436','DELIVERY_ORDER',1),(11,24,210102,'Xyz 889','DELIVERY_ORDER',2),(12,25,110132,'ABD 436','DELIVERY_ORDER',3),(13,30,110132,'ABD 436','PURCHASE',2),(14,38,210101,'Supplier One','PURCHASE',3),(15,39,110131,'Client One','PURCHASE',4),(16,41,110131,'Client One','PURCHASE',4),(17,41,110131,'Client One','PURCHASE',4),(18,47,110161,'Walk In Customer','SALE',7),(19,48,110161,'Walk In Customer','SALE',7),(20,47,110161,'Walk In Customer','SALE',7),(21,48,110161,'Walk In Customer','SALE',7),(22,53,110161,'Walk In Customer','SALE',8),(23,54,110161,'Walk In Customer','SALE',8),(24,55,110132,'ABD 436','SALE',9),(25,56,110132,'ABD 436','SALE',9),(26,57,110132,'ABD 436','SALE',10),(27,58,110161,'Walk In Customer','SALE',11),(28,59,210101,'Supplier One','PURCHASE',5),(29,62,110161,'Walk In Customer','SALE',1),(30,63,110161,'Walk In Customer','SALE',1),(31,64,110161,'Walk In Customer','SALE',2),(32,65,110161,'Walk In Customer','SALE',3),(33,66,110161,'Walk In Customer','SALE',3),(34,67,110161,'Walk In Customer','SALE',4),(35,68,110161,'Walk In Customer','SALE',4),(36,69,110161,'Walk In Customer','SALE',5),(37,70,110161,'Walk In Customer','SALE',5),(38,71,110161,'Walk In Customer','SALE',12),(39,72,110161,'Walk In Customer','SALE',13),(40,73,110161,'Walk In Customer','SALE',13);
/*!40000 ALTER TABLE `financials_stock_movement_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_stock_outward`
--

DROP TABLE IF EXISTS `financials_stock_outward`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_stock_outward` (
  `so_id` int(11) NOT NULL AUTO_INCREMENT,
  `so_party_code` int(11) DEFAULT NULL,
  `so_party_name` varchar(500) DEFAULT NULL,
  `so_invoice_no` int(11) DEFAULT NULL,
  `so_invoice_type` varchar(500) DEFAULT NULL,
  `so_builty_qty` decimal(50,3) DEFAULT NULL,
  `so_sending_datetime` timestamp NULL DEFAULT current_timestamp(),
  `so_remarks` text DEFAULT NULL,
  `so_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `so_createdby` int(11) NOT NULL,
  `so_day_end_id` int(11) NOT NULL,
  `so_day_end_date` datetime NOT NULL,
  `so_ip_adrs` varchar(500) NOT NULL,
  `so_brwsr_info` varchar(1000) NOT NULL,
  `so_type` varchar(500) NOT NULL,
  PRIMARY KEY (`so_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_stock_outward`
--

LOCK TABLES `financials_stock_outward` WRITE;
/*!40000 ALTER TABLE `financials_stock_outward` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_stock_outward` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_stock_taking`
--

DROP TABLE IF EXISTS `financials_stock_taking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_stock_taking` (
  `st_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_warehouse_id` int(11) DEFAULT NULL,
  `st_product_code` varchar(255) DEFAULT NULL,
  `st_product_name` varchar(255) DEFAULT NULL,
  `st_physical_qty` decimal(50,3) DEFAULT NULL,
  `st_bonus_qty` decimal(50,3) DEFAULT NULL,
  `st_current_stock` decimal(50,3) DEFAULT NULL,
  `st_warehouse_stock` decimal(50,3) DEFAULT NULL,
  `st_posting_date_time` datetime DEFAULT current_timestamp(),
  `st_datetime` datetime DEFAULT current_timestamp(),
  `st_createdby` int(11) DEFAULT NULL,
  `st_day_end_id` int(11) DEFAULT NULL,
  `st_day_end_date` date DEFAULT NULL,
  `st_ip_adrs` varchar(255) DEFAULT NULL,
  `st_brwsr_info` varchar(4000) DEFAULT NULL,
  `st_update_datetime` datetime DEFAULT current_timestamp(),
  `st_delete_status` int(11) DEFAULT NULL,
  `st_deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_stock_taking`
--

LOCK TABLES `financials_stock_taking` WRITE;
/*!40000 ALTER TABLE `financials_stock_taking` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_stock_taking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_system_config`
--

DROP TABLE IF EXISTS `financials_system_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_system_config` (
  `sc_id` int(11) NOT NULL AUTO_INCREMENT,
  `sc_profile_update` tinyint(4) NOT NULL DEFAULT 0,
  `sc_company_info_update` tinyint(4) NOT NULL DEFAULT 0,
  `sc_products_added` tinyint(1) NOT NULL DEFAULT 0,
  `sc_admin_capital_added` tinyint(1) NOT NULL DEFAULT 0,
  `sc_opening_trial_complete` tinyint(1) NOT NULL DEFAULT 0,
  `sc_first_date` date DEFAULT curdate(),
  `sc_first_date_added` tinyint(1) NOT NULL DEFAULT 0,
  `sc_bank_payment_voucher_number` int(11) NOT NULL DEFAULT 0,
  `sc_bank_receipt_voucher_number` int(11) NOT NULL DEFAULT 0,
  `sc_cash_payment_voucher_number` int(11) NOT NULL DEFAULT 0,
  `sc_cash_receipt_voucher_numer` int(11) NOT NULL DEFAULT 0,
  `sc_expense_payment_voucher_number` int(11) NOT NULL DEFAULT 0,
  `sc_journal_voucher_number` int(11) NOT NULL DEFAULT 0,
  `sc_purchase_invoice_number` int(11) NOT NULL DEFAULT 0,
  `sc_purchase_return_invoice_number` int(11) NOT NULL DEFAULT 0,
  `sc_purchase_st_invoice_number` int(11) NOT NULL DEFAULT 0,
  `sc_purchase_return_st_invoice_number` int(11) NOT NULL DEFAULT 0,
  `sc_salary_payment_voucher_number` int(11) NOT NULL DEFAULT 0,
  `sc_salary_slip_voucher_number` int(11) NOT NULL DEFAULT 0,
  `sc_advance_salary_voucher_number` int(11) NOT NULL DEFAULT 0,
  `sc_sale_invoice_number` int(11) NOT NULL DEFAULT 0,
  `sc_sale_return_invoice_number` int(11) NOT NULL DEFAULT 0,
  `sc_sale_tax_invoice_number` int(11) NOT NULL DEFAULT 0,
  `sc_sale_tax_return_invoice_number` int(11) NOT NULL DEFAULT 0,
  `sc_service_invoice_number` int(11) NOT NULL DEFAULT 0,
  `sc_service_tax_invoice_number` int(11) NOT NULL DEFAULT 0,
  `sc_all_done` tinyint(1) NOT NULL DEFAULT 0,
  `sc_welcome_wizard` text DEFAULT 'company_info:0;;;reporting_group:-1;;;product_reporting_group:-1;;;add_modular_group:-1;;;warehouse:-1;;;organization_department:-1;;;parent_account_1:-1;;;salary_account:-1;;;employee:-1;;;group:-1;;;category:-1;;;main_unit:-1;;;unit:-1;;;product:-1;;;product_clubbing:-1;;;product_packages:-1;;;product_recipe:-1;;;service:-1;;;bank_account:-1;;;credit_card_machine:-1;;;region:-1;;;area:-1;;;sector:-1;;;client_registration:-1;;;supplier_registration:-1;;;group_account:-1;;;parent_account:-1;;;entry_account:-1;;;fixed_account:-1;;;expense_account:-1;;;asset_parent_account:-1;;;expense_group_account:-1;;;asset_registration:-1;;;second_head:-1;;;capital_registration:-1;;;system_date:-1;;;opening_stock:-1;;;opening_party_balance:-1;;;opening_trail:-1;;;opening_invoice_n_voucher_sequence:-1;;;total_completed:0;;;total_active:1;;;total_disabled:0;;;wizard_completed:0;;;required_completed:0;;;total_required:26',
  PRIMARY KEY (`sc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_system_config`
--

LOCK TABLES `financials_system_config` WRITE;
/*!40000 ALTER TABLE `financials_system_config` DISABLE KEYS */;
INSERT INTO `financials_system_config` VALUES (1,0,0,0,1,0,'2021-09-29',1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,'company_info:1;;;reporting_group:1;;;product_reporting_group:1;;;add_modular_group:1;;;warehouse:1;;;organization_department:-1;;;admin_profile:1;;;parent_account_1:0;;;salary_account:-1;;;employee:1;;;group:1;;;category:1;;;main_unit:1;;;unit:1;;;brand:1;;;product:1;;;product_clubbing:0;;;product_packages:0;;;product_recipe:0;;;service:1;;;bank_account:1;;;credit_card_machine:1;;;region:1;;;area:1;;;sector:1;;;town:1;;;client_registration:1;;;supplier_registration:1;;;group_account:1;;;parent_account:1;;;entry_account:1;;;fixed_account:1;;;expense_account:1;;;asset_parent_account:1;;;expense_group_account:1;;;asset_registration:1;;;second_head:1;;;capital_registration:1;;;day_end_config:1;;;system_date:0;;;opening_stock:1;;;opening_party_balance:1;;;opening_trail:0;;;opening_invoice_n_voucher_sequence:-1;;;department:1;;;report_config:1;;;total_completed:37;;;total_active:6;;;total_disabled:3;;;wizard_completed:0;;;required_completed:4;;;total_required:4');
/*!40000 ALTER TABLE `financials_system_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_table`
--

DROP TABLE IF EXISTS `financials_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_table` (
  `tb_id` int(11) NOT NULL AUTO_INCREMENT,
  `tb_title` varchar(250) NOT NULL,
  `tb_remarks` varchar(500) DEFAULT 'NULL',
  `tb_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `tb_createdby` int(11) DEFAULT NULL,
  `tb_day_end_id` int(11) DEFAULT NULL,
  `tb_day_end_date` date DEFAULT current_timestamp(),
  `tb_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `tb_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `tb_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `tb_delete_status` int(11) DEFAULT 0,
  `tb_deleted_by` int(11) DEFAULT NULL,
  `tb_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`tb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_table`
--

LOCK TABLES `financials_table` WRITE;
/*!40000 ALTER TABLE `financials_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_tank`
--

DROP TABLE IF EXISTS `financials_tank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_tank` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
  `t_name` varchar(500) NOT NULL,
  `t_capacity` int(11) NOT NULL,
  `t_liters` double DEFAULT 0,
  `t_product_code` varchar(500) DEFAULT NULL,
  `t_datetime` timestamp NULL DEFAULT NULL,
  `t_createdby` int(11) DEFAULT NULL,
  `t_day_end_id` int(11) DEFAULT NULL,
  `t_day_end_date` date DEFAULT NULL,
  `t_ip_adrs` varchar(255) DEFAULT NULL,
  `t_brwsr_info` varchar(4000) DEFAULT NULL,
  `t_update_datetime` datetime DEFAULT NULL,
  `t_remarks` text DEFAULT NULL,
  PRIMARY KEY (`t_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_tank`
--

LOCK TABLES `financials_tank` WRITE;
/*!40000 ALTER TABLE `financials_tank` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_tank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_tank_calibration`
--

DROP TABLE IF EXISTS `financials_tank_calibration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_tank_calibration` (
  `tc_id` int(11) NOT NULL AUTO_INCREMENT,
  `tc_dip` int(11) NOT NULL,
  `tc_volume` int(11) NOT NULL,
  `tc_capacity` int(11) NOT NULL,
  `tc_tank_id` varchar(500) NOT NULL,
  PRIMARY KEY (`tc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_tank_calibration`
--

LOCK TABLES `financials_tank_calibration` WRITE;
/*!40000 ALTER TABLE `financials_tank_calibration` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_tank_calibration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_tank_receiving`
--

DROP TABLE IF EXISTS `financials_tank_receiving`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_tank_receiving` (
  `tr_id` int(11) NOT NULL AUTO_INCREMENT,
  `tr_customer_code` varchar(500) DEFAULT NULL,
  `tr_name` varchar(500) DEFAULT NULL,
  `tr_address` text DEFAULT NULL,
  `tr_stax_reg_no` double DEFAULT NULL,
  `tr_contract_no` mediumtext DEFAULT NULL,
  `tr_indent_no` varchar(500) DEFAULT NULL,
  `tr_shipping_point` varchar(500) DEFAULT NULL,
  `tr_dest_code` varchar(500) DEFAULT NULL,
  `tr_shippment_type` varchar(500) DEFAULT NULL,
  `tr_cc_no` varchar(500) DEFAULT NULL,
  `tr_cc_name` varchar(500) DEFAULT NULL,
  `tr_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tr_invoice_no` int(11) DEFAULT NULL,
  `tr_delivery_no` int(11) DEFAULT NULL,
  `tr_vehicle_code` int(11) DEFAULT NULL,
  `tr_fleet_group` varchar(500) DEFAULT NULL,
  `tr_tl_reg_no` varchar(100) DEFAULT NULL,
  `tr_ll_ack_no` int(11) DEFAULT NULL,
  `tr_calibration_no` int(11) DEFAULT NULL,
  `tr_calibration_exp` date DEFAULT NULL,
  `tr_token_no` int(11) DEFAULT NULL,
  `tr_freight_po_no` varchar(500) DEFAULT NULL,
  `tr_lc_no` varchar(500) DEFAULT NULL,
  `tr_rr_date` date DEFAULT NULL,
  `tr_rr_number` int(11) DEFAULT NULL,
  `tr_rr_invoice_no` int(11) DEFAULT NULL,
  `tr_weight` varchar(500) DEFAULT NULL,
  `tr_prepared_by` varchar(500) DEFAULT NULL,
  `tr_approved_by` varchar(500) DEFAULT NULL,
  `tr_released_by` varchar(500) DEFAULT NULL,
  `tr_driver_name` varchar(500) DEFAULT NULL,
  `tr_driver_cnic` varchar(500) DEFAULT NULL,
  `tr_buyer_name` varchar(500) DEFAULT NULL,
  `tr_dated` date DEFAULT NULL,
  `tr_value_exclusive_gst` double DEFAULT NULL,
  `tr_gst` double DEFAULT NULL,
  `tr_inclusive_gst` double DEFAULT NULL,
  `tr_bank` varchar(500) DEFAULT NULL,
  `tr_inst_type` varchar(500) DEFAULT NULL,
  `tr_inst_no` varchar(500) DEFAULT NULL,
  `tr_amount` varchar(500) DEFAULT NULL,
  `tr_miscellaneous_info` text DEFAULT NULL,
  `tr_total_invoice` double DEFAULT NULL,
  `tr_datetime` timestamp NULL DEFAULT NULL,
  `tr_day_end_id` int(11) DEFAULT NULL,
  `tr_day_end_date` date DEFAULT NULL,
  `tr_created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`tr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_tank_receiving`
--

LOCK TABLES `financials_tank_receiving` WRITE;
/*!40000 ALTER TABLE `financials_tank_receiving` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_tank_receiving` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_tank_receiving_chamber`
--

DROP TABLE IF EXISTS `financials_tank_receiving_chamber`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_tank_receiving_chamber` (
  `trc_id` int(11) NOT NULL AUTO_INCREMENT,
  `trc_tank_receving_id` int(11) DEFAULT NULL,
  `trc_ref_dip` varchar(500) DEFAULT NULL,
  `pro_dip` varchar(500) DEFAULT NULL,
  `trc_seal_no` varchar(500) DEFAULT NULL,
  `trc_short_dip` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`trc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_tank_receiving_chamber`
--

LOCK TABLES `financials_tank_receiving_chamber` WRITE;
/*!40000 ALTER TABLE `financials_tank_receiving_chamber` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_tank_receiving_chamber` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_tank_receiving_items`
--

DROP TABLE IF EXISTS `financials_tank_receiving_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_tank_receiving_items` (
  `tri_id` int(11) NOT NULL AUTO_INCREMENT,
  `tri_tank_receiving_id` int(11) DEFAULT NULL,
  `tri_pro_code` varchar(500) DEFAULT NULL,
  `tri_description` varchar(1000) DEFAULT NULL,
  `tri_temp_den` varchar(500) DEFAULT NULL,
  `tri_sloc` varchar(500) DEFAULT NULL,
  `tri_batch_unit` varchar(500) DEFAULT NULL,
  `tri_qty` varchar(500) DEFAULT NULL,
  `tri_rate` varchar(500) DEFAULT NULL,
  `tri_price` varchar(500) DEFAULT NULL,
  `tri_tank` int(11) DEFAULT NULL,
  PRIMARY KEY (`tri_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_tank_receiving_items`
--

LOCK TABLES `financials_tank_receiving_items` WRITE;
/*!40000 ALTER TABLE `financials_tank_receiving_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_tank_receiving_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_third_party`
--

DROP TABLE IF EXISTS `financials_third_party`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_third_party` (
  `tp_id` int(11) NOT NULL AUTO_INCREMENT,
  `tp_vehicle_no` varchar(1000) NOT NULL,
  `tp_vehicle_type` varchar(1000) NOT NULL,
  `tp_driver_name` varchar(1000) NOT NULL,
  `tp_mobile` varchar(500) NOT NULL,
  `tp_remarks` text DEFAULT NULL,
  `tp_delivery_option_id` int(11) NOT NULL,
  `tp_stock_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_third_party`
--

LOCK TABLES `financials_third_party` WRITE;
/*!40000 ALTER TABLE `financials_third_party` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_third_party` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_topic`
--

DROP TABLE IF EXISTS `financials_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_topic` (
  `top_id` int(11) NOT NULL AUTO_INCREMENT,
  `top_title` varchar(250) NOT NULL,
  `top_remarks` varchar(500) DEFAULT 'NULL',
  `top_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `top_createdby` int(11) DEFAULT NULL,
  `top_day_end_id` int(11) DEFAULT NULL,
  `top_day_end_date` date DEFAULT NULL,
  `top_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `top_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `top_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `top_delete_status` int(11) DEFAULT 0,
  `top_deleted_by` int(11) DEFAULT NULL,
  `top_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`top_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_topic`
--

LOCK TABLES `financials_topic` WRITE;
/*!40000 ALTER TABLE `financials_topic` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_towns`
--

DROP TABLE IF EXISTS `financials_towns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_towns` (
  `town_id` int(11) NOT NULL AUTO_INCREMENT,
  `town_title` varchar(250) NOT NULL,
  `town_remarks` varchar(500) DEFAULT 'NULL',
  `town_sector_id` int(11) NOT NULL,
  `town_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `town_createdby` int(11) DEFAULT NULL,
  `town_day_end_id` int(11) DEFAULT NULL,
  `town_day_end_date` date DEFAULT NULL,
  `town_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `town_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `town_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `town_delete_status` int(11) DEFAULT 0,
  `town_deleted_by` int(11) DEFAULT NULL,
  `town_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`town_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_towns`
--

LOCK TABLES `financials_towns` WRITE;
/*!40000 ALTER TABLE `financials_towns` DISABLE KEYS */;
INSERT INTO `financials_towns` VALUES (1,'Initial Town','',1,'2021-10-29 08:23:03',1,0,'2021-10-29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:23:03',0,NULL,0);
/*!40000 ALTER TABLE `financials_towns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_transactions`
--

DROP TABLE IF EXISTS `financials_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_transactions` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_type` int(11) NOT NULL,
  `trans_dr` int(11) NOT NULL,
  `trans_cr` int(11) NOT NULL,
  `trans_amount` decimal(50,2) NOT NULL,
  `trans_notes` varchar(300) NOT NULL,
  `trans_datetime` timestamp NULL DEFAULT current_timestamp(),
  `trans_entry_id` int(11) NOT NULL DEFAULT 0,
  `trans_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `trans_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `trans_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_transactions`
--

LOCK TABLES `financials_transactions` WRITE;
/*!40000 ALTER TABLE `financials_transactions` DISABLE KEYS */;
INSERT INTO `financials_transactions` VALUES (1,9,110101,110121,120.00,'BANK_PAYMENT_VOUCHER','2021-11-03 09:42:23',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:42:23'),(2,15,110131,110121,120.00,'POST_DATED_CHEQUE_ISSUED','2021-11-03 09:43:53',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:43:53'),(3,5,110121,0,130.00,'JOURNAL_VOUCHER','2021-11-03 09:44:51',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:44:51'),(4,5,0,110121,130.00,'JOURNAL VOUCHER','2021-11-03 09:44:51',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:44:51'),(5,5,110101,0,100.00,'JOURNAL_VOUCHER','2021-11-03 09:45:29',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:45:29'),(6,5,0,110102,100.00,'JOURNAL VOUCHER','2021-11-03 09:45:29',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:45:29'),(7,6,110101,110103,3000.00,'CASH_RECEIPT_VOUCHER','2021-11-03 09:50:48',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:50:48'),(8,6,110101,110103,12222.00,'CASH_RECEIPT_VOUCHER','2021-11-03 09:50:48',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:50:48'),(9,7,110121,110103,10000.00,'CASH_PAYMENT_VOUCHER','2021-11-03 09:51:22',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:51:22'),(10,8,110121,110131,50000.00,'BANK_RECEIPT_VOUCHER','2021-11-03 09:51:55',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:51:55'),(11,9,110121,110121,5000.00,'BANK_PAYMENT_VOUCHER','2021-11-03 09:52:15',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 14:52:15'),(12,1,110111,0,108.00,'PURCHASE_INVOICE','2021-11-03 10:00:53',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 15:00:53'),(13,1,411101,0,108.00,'PURCHASE_INVOICE','2021-11-03 10:00:53',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 15:00:53'),(14,1,0,110132,108.00,'PURCHASE_INVOICE','2021-11-03 10:00:53',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 15:00:53'),(15,5,110101,0,120.00,'JOURNAL_VOUCHER','2021-11-03 11:02:16',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:02:16'),(16,5,0,110103,120.00,'JOURNAL VOUCHER','2021-11-03 11:02:17',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:02:17'),(17,5,110132,0,100.00,'JOURNAL_VOUCHER_REFERENCE','2021-11-03 11:36:37',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:36:37'),(18,5,0,110132,100.00,'JOURNAL VOUCHER REFERENCE','2021-11-03 11:36:37',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:36:37'),(19,13,411131,110121,100.00,'EXPENSE_PAYMENT_VOUCHER','2021-11-03 11:57:36',6,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:57:36'),(20,13,410111,110121,50.00,'EXPENSE_PAYMENT_VOUCHER','2021-11-03 11:57:36',6,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 16:57:36'),(26,3,0,110111,54.00,'SALE_INVOICE','2021-11-03 13:11:06',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:11:06'),(27,3,0,310101,60.00,'SALE_INVOICE','2021-11-03 13:11:06',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:11:06'),(28,3,110131,0,60.00,'SALE_INVOICE','2021-11-03 13:11:06',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:11:06'),(29,6,110101,110102,150.00,'CASH_RECEIPT_VOUCHER','2021-11-03 13:14:15',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:14:15'),(30,7,110102,110101,50.00,'CASH_PAYMENT_VOUCHER','2021-11-03 13:14:34',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:14:34'),(31,8,110121,110101,102.00,'BANK_RECEIPT_VOUCHER','2021-11-03 13:27:02',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:27:02'),(32,9,110101,110121,100.00,'BANK_PAYMENT_VOUCHER','2021-11-03 13:27:21',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:27:21'),(33,8,110121,110102,2.00,'BANK_RECEIPT_VOUCHER','2021-11-03 13:28:11',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:28:11'),(34,8,110121,110103,2.00,'BANK_RECEIPT_VOUCHER','2021-11-03 13:30:07',4,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 18:30:07'),(40,13,410121,110103,2.00,'EXPENSE_PAYMENT_VOUCHER','2021-11-04 09:32:43',8,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:32:43'),(47,5,110121,0,500.00,'JOURNAL_VOUCHER','2021-11-04 09:59:01',13,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:59:01'),(48,5,0,110103,500.00,'JOURNAL VOUCHER','2021-11-04 09:59:07',13,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:59:07'),(49,5,110101,0,1000.00,'JOURNAL_VOUCHER','2021-11-04 09:59:33',14,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:59:33'),(50,5,0,110103,1000.00,'JOURNAL VOUCHER','2021-11-04 09:59:33',14,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 14:59:33'),(51,15,110131,110121,1200.00,'POST_DATED_CHEQUE_ISSUED','2021-11-04 11:44:41',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 16:44:41'),(52,15,110131,110121,1.00,'POST_DATED_CHEQUE_ISSUED','2021-11-04 11:52:27',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 16:52:27'),(53,15,110121,110132,2.00,'POST_DATED_CHEQUE_RECEIVED','2021-11-04 12:21:35',4,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:21:35'),(54,5,0,110121,2.00,'JOURNAL VOUCHER','2021-11-04 12:23:30',15,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:23:30'),(55,5,110121,0,2.00,'JOURNAL_VOUCHER','2021-11-04 12:23:30',15,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:23:30'),(56,5,0,110131,1.00,'JOURNAL VOUCHER','2021-11-04 12:25:32',16,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:25:32'),(57,5,110132,0,1.00,'JOURNAL_VOUCHER','2021-11-04 12:25:32',16,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 17:25:32'),(58,11,110111,410101,108.00,'PRODUCT_RECOVER','2021-11-04 13:39:21',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:39:21'),(59,3,411131,0,108.00,'PRODUCT_RECOVER_SR','2021-11-04 13:39:21',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:39:21'),(60,10,410101,110111,54.00,'PRODUCT_LOSS','2021-11-04 13:40:05',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:05'),(61,3,0,411131,54.00,'PRODUCT_LOSS_SI','2021-11-04 13:40:05',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:05'),(62,10,410101,110111,128000.00,'TRADE_PRODUCT_LOSS','2021-11-04 13:40:43',4,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:43'),(63,3,0,411131,128000.00,'PRODUCT_LOSS_SI','2021-11-04 13:40:43',4,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:43'),(67,11,110111,410101,128000.00,'PRODUCT_RECOVER','2021-11-04 13:58:08',10,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:58:08'),(68,3,411131,0,128000.00,'TRADE_PRODUCT_RECOVER_SR','2021-11-04 13:58:08',5,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:58:08'),(69,3,0,110111,128000.00,'SALE_INVOICE','2021-11-05 08:21:12',5,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:21:12'),(70,3,0,310101,144000.00,'SALE_INVOICE','2021-11-05 08:21:12',5,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:21:12'),(71,3,110161,0,144000.00,'SALE_INVOICE','2021-11-05 08:21:12',5,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:21:12'),(72,6,110101,110161,0.00,'CASH_RECEIPT_VOUCHER','2021-11-05 08:21:12',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:21:12'),(73,1,110111,0,54.00,'PURCHASE_INVOICE','2021-11-06 07:12:26',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:12:26'),(74,1,411101,0,54.00,'PURCHASE_INVOICE','2021-11-06 07:12:26',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:12:26'),(75,1,0,110132,54.00,'PURCHASE_INVOICE','2021-11-06 07:12:26',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:12:26'),(76,2,0,110111,54.00,'PURCHASE_RETURN_INVOICE','2021-11-06 07:12:56',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:12:56'),(77,2,0,411102,54.00,'PURCHASE_RETURN_INVOICE','2021-11-06 07:12:56',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:12:56'),(78,2,110132,0,54.00,'PURCHASE_RETURN_INVOICE','2021-11-06 07:12:56',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:12:56'),(79,2,0,110111,108.00,'PURCHASE_RETURN_INVOICE','2021-11-06 07:24:07',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:24:07'),(80,2,0,411102,108.00,'PURCHASE_RETURN_INVOICE','2021-11-06 07:24:07',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:24:07'),(81,2,110132,0,108.00,'PURCHASE_RETURN_INVOICE','2021-11-06 07:24:08',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:24:08'),(82,2,0,110111,510.00,'PURCHASE_RETURN_INVOICE','2021-11-06 07:29:15',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:29:15'),(83,2,0,411102,510.00,'PURCHASE_RETURN_INVOICE','2021-11-06 07:29:15',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:29:15'),(84,2,110132,0,510.00,'PURCHASE_RETURN_INVOICE','2021-11-06 07:29:15',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:29:15'),(86,1,110111,0,72000.00,'PURCHASE_INVOICE','2021-11-06 09:27:45',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:27:45'),(87,1,411101,0,72000.00,'PURCHASE_INVOICE','2021-11-06 09:27:45',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:27:45'),(88,1,0,210101,72000.00,'PURCHASE_INVOICE','2021-11-06 09:27:45',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:27:45'),(89,1,110111,0,14508.00,'PURCHASE_INVOICE','2021-11-06 09:29:41',4,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:29:41'),(90,1,411101,0,14508.00,'PURCHASE_INVOICE','2021-11-06 09:29:41',4,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:29:41'),(91,1,0,110131,14508.00,'PURCHASE_INVOICE','2021-11-06 09:29:41',4,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:29:41'),(92,10,410101,110111,86400.00,'PRODUCT_LOSS','2021-11-06 09:33:27',11,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:33:27'),(93,3,0,411131,86400.00,'PRODUCT_LOSS_SI','2021-11-06 09:33:27',6,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:33:27'),(94,11,110111,410101,180000.00,'PRODUCT_RECOVER','2021-11-06 09:35:55',12,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:35:55'),(95,3,411131,0,180000.00,'PRODUCT_RECOVER_SR','2021-11-06 09:35:55',6,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:35:55'),(96,2,0,110111,72000.00,'PURCHASE_RETURN_INVOICE','2021-11-06 09:37:15',4,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:37:15'),(97,2,0,411102,72000.00,'PURCHASE_RETURN_INVOICE','2021-11-06 09:37:15',4,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:37:15'),(98,2,210101,0,72000.00,'PURCHASE_RETURN_INVOICE','2021-11-06 09:37:15',4,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:37:15'),(99,3,0,110111,54108.00,'SALE_INVOICE','2021-11-06 09:39:07',7,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:39:07'),(100,3,0,310101,60120.00,'SALE_INVOICE','2021-11-06 09:39:07',7,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:39:07'),(101,3,110161,0,60120.00,'SALE_INVOICE','2021-11-06 09:39:07',7,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:39:07'),(102,6,110101,110161,60120.00,'CASH_RECEIPT_VOUCHER','2021-11-06 09:39:08',4,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:39:08'),(103,0,0,110111,3600.00,'','2021-11-06 09:47:29',0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:47:29'),(104,0,0,411121,3600.00,'','2021-11-06 09:47:29',0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:47:29'),(105,0,110172,0,3600.00,'','2021-11-06 09:47:29',0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:47:29'),(106,0,110111,0,3600.00,'','2021-11-06 10:11:52',0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:11:52'),(107,0,411122,0,3600.00,'','2021-11-06 10:11:52',0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:11:52'),(108,0,0,110171,3600.00,'','2021-11-06 10:11:52',0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:11:52'),(109,0,110111,0,160000.00,'','2021-11-06 10:12:21',0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:12:21'),(110,0,411122,0,160000.00,'','2021-11-06 10:12:21',0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:12:21'),(111,0,0,110171,160000.00,'','2021-11-06 10:12:21',0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:12:21'),(112,0,0,110111,160000.00,'','2021-11-06 10:13:47',0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:13:47'),(113,0,0,411121,160000.00,'','2021-11-06 10:13:47',0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:13:47'),(114,0,110171,0,160000.00,'','2021-11-06 10:13:47',0,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:13:47'),(115,3,0,110111,3254.00,'SALE_INVOICE','2021-11-08 10:30:55',8,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:30:55'),(116,3,0,310101,3660.00,'SALE_INVOICE','2021-11-08 10:30:55',8,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:30:55'),(117,3,110161,0,3660.00,'SALE_INVOICE','2021-11-08 10:30:55',8,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:30:55'),(118,3,0,110111,3254.00,'SALE_INVOICE','2021-11-08 10:31:14',9,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:31:14'),(119,3,0,310101,3660.00,'SALE_INVOICE','2021-11-08 10:31:14',9,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:31:14'),(120,3,110132,0,3660.00,'SALE_INVOICE','2021-11-08 10:31:14',9,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:31:14'),(121,3,0,110111,54.00,'SALE_INVOICE','2021-11-08 10:48:08',10,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:48:08'),(122,3,0,310101,60.00,'SALE_INVOICE','2021-11-08 10:48:08',10,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:48:08'),(123,3,110132,0,60.00,'SALE_INVOICE','2021-11-08 10:48:08',10,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-08 15:48:08'),(124,3,0,110111,168615.20,'SALE_INVOICE','2021-11-09 06:28:34',11,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 11:28:34'),(125,3,0,310101,160000.00,'SALE_INVOICE','2021-11-09 06:28:34',11,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 11:28:34'),(126,3,110161,0,160000.00,'SALE_INVOICE','2021-11-09 06:28:34',11,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 11:28:34'),(127,1,110111,0,400000.00,'PURCHASE_INVOICE','2021-11-09 11:57:01',5,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 16:57:01'),(128,1,411101,0,400000.00,'PURCHASE_INVOICE','2021-11-09 11:57:01',5,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 16:57:01'),(129,1,0,210101,400000.00,'PURCHASE_INVOICE','2021-11-09 11:57:01',5,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 16:57:01'),(130,22,0,110111,288000.00,'SALE_SALE_TAX_INVOICE','2021-11-10 06:34:02',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 11:34:02'),(131,22,0,310101,304000.00,'SALE_SALE_TAX_INVOICE','2021-11-10 06:34:02',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 11:34:02'),(132,22,110161,0,304000.00,'SALE_SALE_TAX_INVOICE','2021-11-10 06:34:02',1,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 11:34:02'),(133,22,0,110111,160000.00,'SALE_SALE_TAX_INVOICE','2021-11-10 07:07:08',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:07:08'),(134,22,0,310101,160000.00,'SALE_SALE_TAX_INVOICE','2021-11-10 07:07:08',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:07:08'),(135,22,110161,0,160000.00,'SALE_SALE_TAX_INVOICE','2021-11-10 07:07:08',2,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:07:08'),(136,22,0,110111,288000.00,'SALE_SALE_TAX_INVOICE','2021-11-10 07:14:16',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:16'),(137,22,0,310101,304000.00,'SALE_SALE_TAX_INVOICE','2021-11-10 07:14:16',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:16'),(138,22,110161,0,304000.00,'SALE_SALE_TAX_INVOICE','2021-11-10 07:14:16',3,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:16'),(139,22,0,110111,288000.00,'SALE_SALE_TAX_INVOICE','2021-11-10 07:14:48',4,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:48'),(140,22,0,310101,304000.00,'SALE_SALE_TAX_INVOICE','2021-11-10 07:14:48',4,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:48'),(141,22,110161,0,304000.00,'SALE_SALE_TAX_INVOICE','2021-11-10 07:14:48',4,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:48'),(142,22,0,110111,128648.00,'SALE_SALE_TAX_INVOICE','2021-11-10 07:16:16',5,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:16:16'),(143,22,0,310101,144720.00,'SALE_SALE_TAX_INVOICE','2021-11-10 07:16:16',5,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:16:16'),(144,22,110161,0,144720.00,'SALE_SALE_TAX_INVOICE','2021-11-10 07:16:16',5,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:16:16'),(145,3,0,110111,648.00,'SALE_INVOICE','2021-11-10 11:35:19',12,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 16:35:19'),(146,3,0,310101,720.00,'SALE_INVOICE','2021-11-10 11:35:19',12,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 16:35:19'),(147,3,110161,0,720.00,'SALE_INVOICE','2021-11-10 11:35:19',12,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 16:35:19'),(148,3,0,110111,131060.00,'SALE_INVOICE','2021-11-10 12:24:35',13,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 17:24:35'),(149,3,0,310101,147240.00,'SALE_INVOICE','2021-11-10 12:24:35',13,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 17:24:35'),(150,3,110161,0,147240.00,'SALE_INVOICE','2021-11-10 12:24:35',13,'124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 17:24:35');
/*!40000 ALTER TABLE `financials_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_trial_balance`
--

DROP TABLE IF EXISTS `financials_trial_balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_trial_balance` (
  `tb_id` int(11) NOT NULL AUTO_INCREMENT,
  `tb_type` varchar(50) NOT NULL,
  `tb_parent_uid` int(11) NOT NULL,
  `tb_account_uid` int(11) NOT NULL,
  `tb_account_name` varchar(500) NOT NULL,
  `tb_account_level` tinyint(4) NOT NULL,
  `tb_total_debit` decimal(50,2) DEFAULT NULL,
  `tb_total_credit` decimal(50,2) DEFAULT NULL,
  `tb_day_end_id` int(11) NOT NULL,
  `tb_day_end_date` date NOT NULL,
  `tb_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `tb_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `tb_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `tb_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`tb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_trial_balance`
--

LOCK TABLES `financials_trial_balance` WRITE;
/*!40000 ALTER TABLE `financials_trial_balance` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_trial_balance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_units`
--

DROP TABLE IF EXISTS `financials_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_units` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_title` varchar(250) NOT NULL,
  `unit_allow_decimal` tinyint(4) NOT NULL DEFAULT 0,
  `unit_remarks` varchar(500) DEFAULT NULL,
  `unit_scale_size` tinyint(4) NOT NULL DEFAULT 1,
  `unit_symbol` varchar(100) DEFAULT '',
  `unit_main_unit_id` int(11) NOT NULL,
  `unit_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `unit_createdby` int(11) DEFAULT NULL,
  `unit_day_end_id` int(11) DEFAULT NULL,
  `unit_day_end_date` date DEFAULT NULL,
  `unit_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `unit_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `unit_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `unit_delete_status` int(11) DEFAULT 0,
  `unit_deleted_by` int(11) DEFAULT NULL,
  `unit_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_units`
--

LOCK TABLES `financials_units` WRITE;
/*!40000 ALTER TABLE `financials_units` DISABLE KEYS */;
INSERT INTO `financials_units` VALUES (1,'Gattu',1,'',40,NULL,2,'2021-10-29 08:09:28',1,0,'2021-10-29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:09:28',0,NULL,0),(2,'Carton',0,'',12,NULL,1,'2021-10-29 08:09:49',1,0,'2021-10-29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:09:49',0,NULL,0),(3,'Pet',1,'',6,NULL,1,'2021-10-29 08:10:12',1,0,'2021-10-29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:10:12',0,NULL,0);
/*!40000 ALTER TABLE `financials_units` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`digitalmunshi`@`localhost`*/ /*!50003 TRIGGER `update_product_allow_decimal` AFTER UPDATE ON `financials_units` FOR EACH ROW UPDATE financials_products 
SET pro_allow_decimal = NEW.unit_allow_decimal
WHERE pro_unit_id = OLD.unit_id */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `financials_user_role`
--

DROP TABLE IF EXISTS `financials_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_user_role` (
  `user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role_title` varchar(500) NOT NULL,
  PRIMARY KEY (`user_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_user_role`
--

LOCK TABLES `financials_user_role` WRITE;
/*!40000 ALTER TABLE `financials_user_role` DISABLE KEYS */;
INSERT INTO `financials_user_role` VALUES (1,'Other Employee'),(2,'Cashier'),(3,'Teller'),(4,'Sale Person'),(5,'Purchaser');
/*!40000 ALTER TABLE `financials_user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_users`
--

DROP TABLE IF EXISTS `financials_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_employee_code` varchar(100) DEFAULT '',
  `user_designation` varchar(500) DEFAULT '',
  `user_name` varchar(500) NOT NULL,
  `user_father_name` varchar(500) DEFAULT NULL,
  `user_username` varchar(500) DEFAULT NULL,
  `user_password` varchar(500) DEFAULT NULL,
  `user_email` varchar(500) DEFAULT NULL,
  `user_mobile` varchar(500) NOT NULL,
  `user_emergency_contact` varchar(100) DEFAULT '',
  `user_cnic` varchar(500) DEFAULT '',
  `user_commission_per` decimal(50,2) DEFAULT 0.00,
  `user_target_amount` double DEFAULT 0,
  `user_address` varchar(1000) NOT NULL,
  `user_address_2` varchar(4000) DEFAULT '',
  `user_profilepic` varchar(500) NOT NULL,
  `user_folder` varchar(500) NOT NULL,
  `user_createdby` varchar(45) NOT NULL,
  `user_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_login_status` varchar(50) NOT NULL DEFAULT 'DISABLE',
  `user_religion` tinyint(4) DEFAULT 0,
  `user_d_o_j` date DEFAULT NULL,
  `user_account_reporting_group_ids` text DEFAULT NULL,
  `user_product_reporting_group_ids` text DEFAULT NULL,
  `user_modular_group_id` int(11) DEFAULT NULL,
  `user_role_id` int(11) DEFAULT 1,
  `user_level` int(11) DEFAULT NULL,
  `user_reset_password` varchar(500) DEFAULT NULL,
  `user_nationality` int(11) DEFAULT 0,
  `user_family_code` varchar(500) DEFAULT '',
  `user_marital_status` tinyint(4) DEFAULT 0,
  `user_city` int(11) DEFAULT 0,
  `user_blood_group` varchar(10) DEFAULT '',
  `user_salary_person` tinyint(4) DEFAULT 0,
  `user_loan_person` int(11) NOT NULL DEFAULT 0,
  `user_have_credentials` tinyint(4) DEFAULT 0,
  `user_teller_cash_account_uid` int(11) NOT NULL DEFAULT 0,
  `user_teller_wic_account_uid` int(11) NOT NULL DEFAULT 0,
  `user_purchaser_cash_account_uid` int(11) NOT NULL DEFAULT 0,
  `user_purchaser_wic_account_uid` int(11) NOT NULL DEFAULT 0,
  `user_day_end_id` int(11) DEFAULT NULL,
  `user_day_end_date` date DEFAULT NULL,
  `user_delete_status` tinyint(4) DEFAULT 0,
  `user_deleted_by` int(11) DEFAULT 0,
  `user_web_status` varchar(50) DEFAULT 'offline',
  `user_desktop_status` varchar(50) DEFAULT 'offline',
  `user_disabled` int(11) DEFAULT 0,
  `user_android_status` varchar(50) DEFAULT 'offline',
  `user_ios_status` varchar(50) DEFAULT 'offline',
  `user_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `user_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `user_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `user_fcm_token` text DEFAULT '',
  `user_send_day_end_report` tinyint(4) DEFAULT 0,
  `user_send_month_end_report` tinyint(4) DEFAULT 0,
  `user_send_sync_report` tinyint(4) DEFAULT 0,
  `user_department_id` int(11) DEFAULT NULL,
  `session_id` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_employee_code` (`user_employee_code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_users`
--

LOCK TABLES `financials_users` WRITE;
/*!40000 ALTER TABLE `financials_users` DISABLE KEYS */;
INSERT INTO `financials_users` VALUES (1,'SAAA-0001','Super Admin','Super Admin','admin','admin','$2y$10$aoKQwqzFY/InqE.BmqjXUe0ZQUqmdgkcOmMu772zfIzqZkw5/rhOa','support@digitalmunshi.com','03118798654',NULL,NULL,0.00,0,'','','','','0','2020-09-02 05:18:38','ENABLE',1,NULL,NULL,NULL,NULL,1,100,NULL,NULL,NULL,1,NULL,NULL,1,0,1,0,0,0,0,NULL,NULL,0,0,'offline','online',0,'offline','offline','124.29.212.138','Desktop Device \nChrome browser | Version:- 91.0.4472.124','2021-07-06 18:40:20','',1,1,1,NULL,'kTRYqK3ot0qQD4IgIoSHv2e5s0zaXPPWXQuChGUP'),(2,'AHHH-0002','Financial & Business Consultant','Ahmad Hasan','Muhammad Bashir Nasir','Ahmad','$2y$10$dFH9iHF1ImW4Xs94kQAZkucXz7FB.JXOvTwL1kjo746xygrv7tehy','account@csp.com.pk','0321-4564561',NULL,NULL,0.00,0,'','','http://www.pos.jadeedmunshi.com//public/src/default_profile.png','75f960e57aa812070688925','1','2021-10-29 08:05:46','ENABLE',1,'0000-00-00','1','4,5,1,3,2',1,1,30,NULL,164,NULL,1,NULL,NULL,1,0,1,0,0,0,0,0,'2021-10-29',0,0,'offline','offline',0,'offline','offline','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:05:46','',0,0,0,2,'a2L47UJ8DhsGtRXBqR2ggAbX8I1YJZoeVRcH2FMk'),(3,'IIII-0003','Sale Man','Independant','Indep',NULL,NULL,NULL,'0321-7897897',NULL,NULL,0.00,0,'','','http://www.pos.jadeedmunshi.com//public/src/default_profile.png','614984fdceeb21413009465','1','2021-10-29 08:07:25','DISABLE',1,'0000-00-00',NULL,NULL,NULL,4,10,NULL,164,NULL,1,NULL,NULL,0,0,0,110102,0,0,0,0,'2021-10-29',0,0,'offline','offline',0,'offline','offline','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:07:25','',0,0,0,3,NULL),(4,'SSSS-0004','Sale Man','Shoaib','Ghulam Hussain','nabeel','$2y$10$eAx2xiAF6lwRkUWoejs4OOK2LYAFQWmPbKf1koHW/qwbER/6aL/Ku','nabeel.py@gmail.com','03001234567',NULL,NULL,0.00,0,'','','http://www.pos.jadeedmunshi.com//public/src/default_profile.png','41fa7cd65af301372925795','1','2021-10-29 10:40:55','ENABLE',1,'0000-00-00','1','4,5,1,3,2',1,4,10,NULL,164,NULL,1,NULL,NULL,0,0,1,110103,0,0,0,1,'2021-09-29',0,0,'offline','offline',0,'offline','offline','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 18:12:46','',0,0,0,3,'aNxr6Ah7hKsApOjYIfaJG1iHjaC7HWkPP5uJ7mmG');
/*!40000 ALTER TABLE `financials_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_warehouse`
--

DROP TABLE IF EXISTS `financials_warehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_warehouse` (
  `wh_id` int(11) NOT NULL AUTO_INCREMENT,
  `wh_title` varchar(500) NOT NULL,
  `wh_address` varchar(1000) NOT NULL DEFAULT '',
  `wh_remarks` varchar(500) DEFAULT '',
  `wh_created_by` int(11) NOT NULL,
  `wh_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `wh_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `wh_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `wh_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `wh_delete_status` int(11) DEFAULT 0,
  `wh_deleted_by` int(11) DEFAULT NULL,
  `wh_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`wh_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_warehouse`
--

LOCK TABLES `financials_warehouse` WRITE;
/*!40000 ALTER TABLE `financials_warehouse` DISABLE KEYS */;
INSERT INTO `financials_warehouse` VALUES (1,'Main Store','','',0,'2021-10-29 06:56:25','','','2021-10-29 11:56:25',0,NULL,0),(2,'Sale Return Warehouse','','',0,'2021-10-29 06:56:25','','','2021-10-29 11:56:25',0,NULL,0),(3,'Claim Warehouse','','',0,'2021-10-29 06:56:25','','','2021-10-29 11:56:25',0,NULL,0),(4,'Work In Progress Warehouse','','',0,'2021-10-29 06:56:25','','','2021-10-29 11:56:25',0,NULL,0);
/*!40000 ALTER TABLE `financials_warehouse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_warehouse_stock`
--

DROP TABLE IF EXISTS `financials_warehouse_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_warehouse_stock` (
  `whs_id` int(11) NOT NULL AUTO_INCREMENT,
  `whs_product_code` varchar(500) NOT NULL,
  `whs_stock` decimal(50,3) NOT NULL DEFAULT 0.000,
  `whs_warehouse_id` int(11) NOT NULL,
  `whs_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `whs_ip_adrs` varchar(255) NOT NULL DEFAULT '',
  `whs_brwsr_info` varchar(4000) NOT NULL DEFAULT '',
  `whs_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`whs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_warehouse_stock`
--

LOCK TABLES `financials_warehouse_stock` WRITE;
/*!40000 ALTER TABLE `financials_warehouse_stock` DISABLE KEYS */;
INSERT INTO `financials_warehouse_stock` VALUES (1,'300',0.000,1,'2021-10-29 08:32:31','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 16:35:19'),(2,'200',89.000,1,'2021-10-29 08:32:32','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 17:24:35'),(3,'100',15995.000,1,'2021-10-29 08:32:32','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 17:24:35'),(4,'100',16035.000,1,'2021-10-29 08:34:14','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(5,'200',95.000,1,'2021-10-29 08:34:14','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(6,'300',12.000,1,'2021-10-29 08:34:14','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:34:14'),(7,'300',6.000,3,'2021-11-06 08:55:00','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 13:25:41'),(8,'400',-85.000,1,'2021-11-06 09:27:45','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:48'),(9,'200',1.000,2,'2021-11-09 10:52:57','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 15:52:57');
/*!40000 ALTER TABLE `financials_warehouse_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_warehouse_stock_summary`
--

DROP TABLE IF EXISTS `financials_warehouse_stock_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_warehouse_stock_summary` (
  `whss_id` int(11) NOT NULL AUTO_INCREMENT,
  `whss_type` varchar(1000) DEFAULT NULL,
  `whss_warehouse_id` int(11) DEFAULT NULL,
  `whss_product_code` varchar(500) DEFAULT NULL,
  `whss_product_name` varchar(500) DEFAULT NULL,
  `whss_qty_in` decimal(50,3) NOT NULL DEFAULT 0.000,
  `whss_qty_out` decimal(50,3) NOT NULL DEFAULT 0.000,
  `whss_total_hold` decimal(50,3) NOT NULL DEFAULT 0.000,
  `whss_total_bonus` decimal(50,3) NOT NULL DEFAULT 0.000,
  `whss_total_claim` decimal(50,3) NOT NULL DEFAULT 0.000,
  `whss_total_for_sale` decimal(50,3) NOT NULL DEFAULT 0.000,
  `whss_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `whss_ip_adrs` varchar(255) NOT NULL,
  `whss_brwsr_info` varchar(4000) NOT NULL,
  `whss_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`whss_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_warehouse_stock_summary`
--

LOCK TABLES `financials_warehouse_stock_summary` WRITE;
/*!40000 ALTER TABLE `financials_warehouse_stock_summary` DISABLE KEYS */;
INSERT INTO `financials_warehouse_stock_summary` VALUES (1,'OPENING STOCK',1,'300','Lays Rs. 5',12.000,0.000,0.000,0.000,0.000,12.000,'2021-10-29 13:32:31','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:32:31'),(2,'OPENING STOCK',1,'200','Pepsi 1500 ML',95.000,0.000,0.000,0.000,0.000,95.000,'2021-10-29 13:32:32','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:32:32'),(3,'OPENING STOCK',1,'100','Suger',16035.000,0.000,0.000,0.000,0.000,16035.000,'2021-10-29 13:32:32','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-10-29 13:32:32'),(4,'PURCHASE',1,'300','Lays Rs. 5',2.000,0.000,1.000,0.000,-1.000,6.000,'2021-11-03 15:00:52','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:29:41'),(5,'PURCHASE',1,'300','Lays Rs. 5',1.000,0.000,0.000,0.000,0.000,13.000,'2021-11-03 15:00:52','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-03 15:00:52'),(6,'SALE',1,'300','Lays Rs. 5',0.000,12.000,1.000,0.000,-1.000,-24.000,'2021-11-03 18:07:19','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 16:35:19'),(7,'SALE',1,'100','Suger',0.000,40.000,121.000,0.000,0.000,15912.000,'2021-11-03 18:07:19','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 17:24:35'),(8,'PRODUCT RECOVER',1,'300','Lays Rs. 5',2.000,0.000,0.000,0.000,0.000,13.000,'2021-11-04 18:39:21','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:39:21'),(9,'PRODUCT LOSS',1,'300','Lays Rs. 5',0.000,1.000,0.000,0.000,0.000,12.000,'2021-11-04 18:40:05','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:05'),(10,'PRODUCT LOSS',1,'100','Suger',0.000,40.000,0.000,0.000,0.000,15994.000,'2021-11-04 18:40:43','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:40:43'),(11,'PRODUCT RECOVER',1,'100','Suger',40.000,0.000,0.000,0.000,0.000,16154.000,'2021-11-04 18:48:29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-04 18:58:08'),(12,'SALE-ORDER',1,'300','Lays Rs. 5',0.000,1.000,1.000,0.000,0.000,11.000,'2021-11-05 13:07:35','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:07:35'),(13,'SALE-ORDER',1,'100','Suger',0.000,40.000,40.000,0.000,0.000,16114.000,'2021-11-05 13:09:18','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:09:18'),(14,'SALE-ORDER',1,'200','Pepsi 1500 ML',0.000,1.000,1.000,0.000,0.000,94.000,'2021-11-05 13:15:17','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:15:17'),(15,'SALE-ORDER-SALE',1,'100','Suger',0.000,40.000,0.000,0.000,0.000,16114.000,'2021-11-05 13:21:12','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 13:21:12'),(16,'DELIVERY-ORDER',1,'200','Pepsi 1500 ML',0.000,6.000,8.000,0.000,0.000,87.000,'2021-11-05 16:55:27','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 16:55:48'),(17,'DELIVERY-ORDER',1,'300','Lays Rs. 5',0.000,1.000,2.000,0.000,0.000,10.000,'2021-11-05 17:15:35','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 17:15:35'),(18,'GOODS-RECEIPT-NOTE',1,'100','Suger',40.000,0.000,121.000,0.000,0.000,16114.000,'2021-11-05 18:22:38','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-05 18:27:49'),(19,'PURCHASE RETURN',1,'300','Lays Rs. 5',0.000,1.000,2.000,0.000,0.000,8.000,'2021-11-06 12:12:56','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:24:07'),(20,'PURCHASE RETURN',1,'200','Pepsi 1500 ML',0.000,1.000,8.000,0.000,0.000,86.000,'2021-11-06 12:29:15','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 12:29:15'),(21,'PRODUCT TRANSFER IN',3,'300','Lays Rs. 5',1.000,0.000,0.000,0.000,0.000,6.000,'2021-11-06 13:55:00','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 13:25:41'),(22,'PRODUCT TRANSFER OUT',1,'300','Lays Rs. 5',0.000,1.000,1.000,0.000,-1.000,0.000,'2021-11-06 13:55:00','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 13:25:41'),(23,'TRANSFER FROM HOLD',1,'300','Lays Rs. 5',1.000,0.000,1.000,0.000,0.000,4.000,'2021-11-06 13:55:41','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 13:55:41'),(24,'CLAIM ISSUE',1,'300','Lays Rs. 5',0.000,1.000,1.000,0.000,-1.000,4.000,'2021-11-06 13:56:22','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 13:56:22'),(25,'PURCHASE',1,'400','Daal Chawal',100.000,0.000,0.000,0.000,0.000,80.000,'2021-11-06 14:27:45','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 16:57:01'),(26,'PRODUCT LOSS',1,'400','Daal Chawal',0.000,24.000,0.000,0.000,0.000,0.000,'2021-11-06 14:33:27','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:33:27'),(27,'PRODUCT RECOVER',1,'400','Daal Chawal',50.000,0.000,0.000,0.000,0.000,50.000,'2021-11-06 14:35:55','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:35:55'),(28,'PURCHASE RETURN',1,'400','Daal Chawal',0.000,20.000,0.000,0.000,0.000,30.000,'2021-11-06 14:37:15','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:37:15'),(29,'SALE',1,'400','Daal Chawal',0.000,40.000,0.000,0.000,0.000,-20.000,'2021-11-06 14:39:07','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 11:28:34'),(30,'SALE',1,'400','Daal Chawal',0.000,5.000,0.000,0.000,0.000,25.000,'2021-11-06 14:39:07','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 14:39:07'),(31,'CLAIM ISSUE',1,'400','Daal Chawal',0.000,40.000,0.000,0.000,0.000,20.000,'2021-11-06 14:47:29','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:13:46'),(32,'CLAIM RECEIVED',1,'400','Daal Chawal',40.000,0.000,0.000,0.000,40.000,20.000,'2021-11-06 15:11:52','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-06 15:12:21'),(33,'PRODUCT TRANSFER IN',2,'200','Pepsi 1500 ML',1.000,0.000,0.000,0.000,0.000,1.000,'2021-11-09 15:52:58','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 15:52:58'),(34,'PRODUCT TRANSFER OUT',1,'200','Pepsi 1500 ML',0.000,1.000,8.000,0.000,0.000,85.000,'2021-11-09 15:52:58','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 15:52:58'),(35,'TRANSFER FROM CLAIM',1,'400','Daal Chawal',82.000,0.000,0.000,0.000,-123.000,203.000,'2021-11-09 16:58:04','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-09 16:58:43'),(36,'SALE TAX',1,'400','Daal Chawal',0.000,40.000,0.000,0.000,-123.000,43.000,'2021-11-10 11:34:01','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:14:48'),(37,'SALE TAX',1,'100','Suger',0.000,40.000,121.000,0.000,0.000,15952.000,'2021-11-10 11:34:01','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:16:16'),(38,'SALE TAX',1,'300','Lays Rs. 5',0.000,12.000,1.000,0.000,-1.000,-12.000,'2021-11-10 12:16:16','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 12:16:16'),(39,'SALE',1,'200','Pepsi 1500 ML',0.000,6.000,8.000,0.000,0.000,79.000,'2021-11-10 17:24:35','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69','2021-11-10 17:24:35');
/*!40000 ALTER TABLE `financials_warehouse_stock_summary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financials_work_order`
--

DROP TABLE IF EXISTS `financials_work_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financials_work_order` (
  `odr_id` int(11) NOT NULL AUTO_INCREMENT,
  `odr_recipe_id` varchar(255) DEFAULT NULL,
  `odr_recipe_name` varchar(500) NOT NULL,
  `odr_qty` decimal(50,0) NOT NULL,
  `odr_uom` varchar(500) NOT NULL,
  `odr_estimated_start_time` datetime NOT NULL,
  `odr_estimated_end_time` datetime NOT NULL,
  `odr_warehouse_select` varchar(255) DEFAULT '',
  `odr_production_overhead_total` decimal(50,0) DEFAULT 0,
  `odr_production_raw_stock_costing_total` decimal(50,0) NOT NULL,
  `odr_total_amount` decimal(50,0) NOT NULL,
  `odr_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `odr_day_end_id` int(11) NOT NULL,
  `odr_day_end_date` date NOT NULL,
  `odr_createdby` int(11) NOT NULL,
  `odr_ip_adrs` varchar(500) NOT NULL,
  `odr_brwsr_info` varchar(4000) NOT NULL,
  `odr_update_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `odr_delete_status` int(11) NOT NULL,
  `odr_deleted_by` int(11) NOT NULL,
  `odr_disabled` int(11) NOT NULL,
  `odr_product_rate_type` varchar(100) NOT NULL,
  `odr_project_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`odr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financials_work_order`
--

LOCK TABLES `financials_work_order` WRITE;
/*!40000 ALTER TABLE `financials_work_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `financials_work_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_angle_inch_soter_calibration`
--

DROP TABLE IF EXISTS `finead_angle_inch_soter_calibration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_angle_inch_soter_calibration` (
  `aisc_id` int(11) NOT NULL AUTO_INCREMENT,
  `aisc_board_type_id` int(11) NOT NULL,
  `aisc_width_from` decimal(50,2) DEFAULT NULL,
  `aisc_width_to` decimal(50,2) DEFAULT NULL,
  `aisc_angle_support` decimal(50,2) DEFAULT NULL,
  `aisc_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `aisc_createdby` int(11) NOT NULL,
  `aisc_day_end_id` int(11) DEFAULT NULL,
  `aisc_day_end_date` date DEFAULT NULL,
  `aisc_ip_adrs` varchar(255) DEFAULT NULL,
  `aisc_brwsr_info` varchar(4000) DEFAULT NULL,
  `aisc_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`aisc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_angle_inch_soter_calibration`
--

LOCK TABLES `finead_angle_inch_soter_calibration` WRITE;
/*!40000 ALTER TABLE `finead_angle_inch_soter_calibration` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_angle_inch_soter_calibration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_assign_board_material`
--

DROP TABLE IF EXISTS `finead_assign_board_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_assign_board_material` (
  `abm_id` int(11) NOT NULL AUTO_INCREMENT,
  `abm_product_code` varchar(500) DEFAULT NULL,
  `abm_board_type` int(11) DEFAULT NULL,
  `abm_datetime` timestamp NULL DEFAULT current_timestamp(),
  `abm_createdby` int(11) DEFAULT NULL,
  `abm_day_end_id` int(11) DEFAULT NULL,
  `abm_day_end_date` date DEFAULT NULL,
  `abm_ip_adrs` varchar(255) DEFAULT NULL,
  `abm_brwsr_info` varchar(4000) DEFAULT NULL,
  `abm_update_datetime` datetime DEFAULT NULL,
  `abm_delete_status` int(11) NOT NULL DEFAULT 0,
  `abm_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`abm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_assign_board_material`
--

LOCK TABLES `finead_assign_board_material` WRITE;
/*!40000 ALTER TABLE `finead_assign_board_material` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_assign_board_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_assign_board_material_items`
--

DROP TABLE IF EXISTS `finead_assign_board_material_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_assign_board_material_items` (
  `abmi_id` int(11) NOT NULL AUTO_INCREMENT,
  `abmi_abm_id` int(11) NOT NULL,
  `abmi_board_material_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`abmi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_assign_board_material_items`
--

LOCK TABLES `finead_assign_board_material_items` WRITE;
/*!40000 ALTER TABLE `finead_assign_board_material_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_assign_board_material_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_assign_username`
--

DROP TABLE IF EXISTS `finead_assign_username`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_assign_username` (
  `au_id` int(11) NOT NULL AUTO_INCREMENT,
  `au_username_id` varchar(255) DEFAULT NULL,
  `au_surveyor_type` varchar(255) DEFAULT NULL,
  `au_surveyor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`au_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_assign_username`
--

LOCK TABLES `finead_assign_username` WRITE;
/*!40000 ALTER TABLE `finead_assign_username` DISABLE KEYS */;
INSERT INTO `finead_assign_username` VALUES (1,'1','vendor',210101);
/*!40000 ALTER TABLE `finead_assign_username` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_batch`
--

DROP TABLE IF EXISTS `finead_batch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_batch` (
  `bat_id` int(11) NOT NULL AUTO_INCREMENT,
  `bat_name` varchar(500) DEFAULT NULL,
  `bat_order_list_id` int(11) DEFAULT NULL,
  `bat_product_id` varchar(500) DEFAULT NULL,
  `bat_total_item` int(11) DEFAULT NULL,
  `bat_length_feet` int(11) DEFAULT NULL,
  `bat_length_inch` int(11) DEFAULT NULL,
  `bat_total_length` decimal(50,2) DEFAULT NULL,
  `bat_height_feet` int(11) DEFAULT NULL,
  `bat_height_inch` int(11) DEFAULT NULL,
  `bat_total_height` decimal(10,2) DEFAULT NULL,
  `bat_width_feet` int(11) DEFAULT NULL,
  `bat_width_inch` int(11) DEFAULT NULL,
  `bat_total_width` decimal(50,2) DEFAULT NULL,
  `bat_total_depth` decimal(50,2) DEFAULT NULL,
  `bat_tapa_gauge` int(11) DEFAULT NULL,
  `bat_back_sheet_gauge` int(11) DEFAULT NULL,
  `bat_day_end_id` int(11) DEFAULT NULL,
  `bat_day_end_date` date DEFAULT NULL,
  `bat_user_id` int(11) DEFAULT NULL,
  `bat_datetime` timestamp NULL DEFAULT current_timestamp(),
  `bat_ip_adrs` varchar(255) DEFAULT NULL,
  `bat_brwsr_info` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`bat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_batch`
--

LOCK TABLES `finead_batch` WRITE;
/*!40000 ALTER TABLE `finead_batch` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_batch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_board_material`
--

DROP TABLE IF EXISTS `finead_board_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_board_material` (
  `bm_id` int(11) NOT NULL AUTO_INCREMENT,
  `bm_title` varchar(500) DEFAULT NULL,
  `bm_remarks` varchar(1000) DEFAULT NULL,
  `bm_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `bm_createdby` int(11) DEFAULT NULL,
  `bm_day_end_id` int(11) DEFAULT NULL,
  `bm_day_end_date` date DEFAULT NULL,
  `bm_ip_adrs` varchar(255) DEFAULT NULL,
  `bm_brwsr_info` varchar(4000) DEFAULT NULL,
  `bm_update_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `bm_delete_status` int(11) NOT NULL DEFAULT 0,
  `bm_deleted_by` int(11) DEFAULT NULL,
  `bm_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`bm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_board_material`
--

LOCK TABLES `finead_board_material` WRITE;
/*!40000 ALTER TABLE `finead_board_material` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_board_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_board_type`
--

DROP TABLE IF EXISTS `finead_board_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_board_type` (
  `bt_id` int(11) NOT NULL AUTO_INCREMENT,
  `bt_title` varchar(255) DEFAULT NULL,
  `bt_remarks` varchar(500) DEFAULT NULL,
  `bt_datetime` timestamp NULL DEFAULT current_timestamp(),
  `bt_createdby` int(11) DEFAULT NULL,
  `bt_day_end_id` int(11) DEFAULT NULL,
  `bt_day_end_date` date DEFAULT NULL,
  `bt_ip_adrs` varchar(255) DEFAULT NULL,
  `bt_brwsr_info` varchar(4000) DEFAULT NULL,
  `bt_update_datetime` datetime DEFAULT NULL,
  `bt_delete_status` int(11) NOT NULL DEFAULT 0,
  `bt_deleted_by` int(11) DEFAULT NULL,
  `bt_disabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`bt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_board_type`
--

LOCK TABLES `finead_board_type` WRITE;
/*!40000 ALTER TABLE `finead_board_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_board_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_budget_planning`
--

DROP TABLE IF EXISTS `finead_budget_planning`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_budget_planning` (
  `fbp_id` int(11) NOT NULL AUTO_INCREMENT,
  `fbp_order_list_id` int(11) DEFAULT NULL,
  `fbp_budget_name` varchar(1000) DEFAULT NULL,
  `fbp_zone_id` int(11) DEFAULT NULL,
  `fbp_region_id` int(11) DEFAULT NULL,
  `fbp_product_code` varchar(500) DEFAULT NULL,
  `fbp_product_name` varchar(1000) DEFAULT NULL,
  `fbp_qty` decimal(50,3) DEFAULT NULL,
  `fbp_rate` decimal(50,2) DEFAULT NULL,
  `fbp_material_rate` decimal(50,2) DEFAULT NULL,
  `fbp_expense_rate` decimal(50,2) DEFAULT NULL,
  `fbp_amount` decimal(50,2) DEFAULT NULL,
  `fbp_material_amount` decimal(50,2) DEFAULT NULL,
  `fbp_expense_amount` decimal(50,2) DEFAULT NULL,
  `fbp_material_pec` decimal(50,2) DEFAULT NULL,
  `fbp_expense_pec` decimal(50,2) DEFAULT NULL,
  `fbp_datetime` datetime NOT NULL,
  `fbp_createdby` int(11) DEFAULT NULL,
  `fbp_day_end_id` int(11) DEFAULT NULL,
  `fbp_day_end_date` date DEFAULT NULL,
  `fbp_ip_adrs` varchar(255) DEFAULT NULL,
  `fbp_brwsr_info` varchar(4000) DEFAULT NULL,
  `fbp_update_datetime` datetime NOT NULL,
  `fbp_delete_status` int(11) DEFAULT NULL,
  `fbp_deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`fbp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_budget_planning`
--

LOCK TABLES `finead_budget_planning` WRITE;
/*!40000 ALTER TABLE `finead_budget_planning` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_budget_planning` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_budgeted_raw_stock`
--

DROP TABLE IF EXISTS `finead_budgeted_raw_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_budgeted_raw_stock` (
  `brs_id` int(11) NOT NULL AUTO_INCREMENT,
  `brs_odr_id` int(11) NOT NULL,
  `brs_pro_code` varchar(500) NOT NULL,
  `brs_pro_name` varchar(1000) NOT NULL,
  `brs_pro_remarks` text DEFAULT 'NULL',
  `brs_uom` varchar(1000) NOT NULL,
  `brs_recipe_consumption` decimal(50,2) NOT NULL,
  `brs_required_production_qty` decimal(50,2) NOT NULL,
  `brs_in_hand_stock` decimal(50,2) NOT NULL,
  PRIMARY KEY (`brs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_budgeted_raw_stock`
--

LOCK TABLES `finead_budgeted_raw_stock` WRITE;
/*!40000 ALTER TABLE `finead_budgeted_raw_stock` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_budgeted_raw_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_calculate_qty`
--

DROP TABLE IF EXISTS `finead_calculate_qty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_calculate_qty` (
  `fcq_id` int(11) NOT NULL AUTO_INCREMENT,
  `fcq_project_id` int(11) DEFAULT NULL,
  `fcq_pro_code` varchar(1000) DEFAULT NULL,
  `fcq_qty` decimal(50,3) DEFAULT NULL,
  `fcq_form_id` int(11) DEFAULT NULL,
  `fcq_form_name` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`fcq_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_calculate_qty`
--

LOCK TABLES `finead_calculate_qty` WRITE;
/*!40000 ALTER TABLE `finead_calculate_qty` DISABLE KEYS */;
INSERT INTO `finead_calculate_qty` VALUES (1,1,'200',6.000,1,'Order list products'),(2,1,'400',6.000,1,'Order list products'),(3,1,'1',12.000,1,'Order list services');
/*!40000 ALTER TABLE `finead_calculate_qty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_calculate_zone_qty`
--

DROP TABLE IF EXISTS `finead_calculate_zone_qty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_calculate_zone_qty` (
  `fcqz_id` int(11) NOT NULL AUTO_INCREMENT,
  `fcqz_project_id` int(11) DEFAULT NULL,
  `fcqz_item_id` int(11) DEFAULT NULL,
  `fcqz_region_id` int(11) DEFAULT NULL,
  `fcqz_pro_code` varchar(1000) DEFAULT NULL,
  `fcqz_qty` decimal(50,3) DEFAULT NULL,
  `fcqz_form_id` int(11) DEFAULT NULL,
  `fcqz_form_name` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`fcqz_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_calculate_zone_qty`
--

LOCK TABLES `finead_calculate_zone_qty` WRITE;
/*!40000 ALTER TABLE `finead_calculate_zone_qty` DISABLE KEYS */;
INSERT INTO `finead_calculate_zone_qty` VALUES (1,1,1,1,'1',6.000,1,'Work Area / project_id treat as order_list_id'),(2,1,2,1,'1',6.000,1,'Work Area / project_id treat as order_list_id');
/*!40000 ALTER TABLE `finead_calculate_zone_qty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_calculation`
--

DROP TABLE IF EXISTS `finead_calculation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_calculation` (
  `cal_id` int(11) NOT NULL AUTO_INCREMENT,
  `cal_project_id` int(11) DEFAULT NULL,
  `cal_invoice_id` int(11) DEFAULT NULL,
  `cal_amount` decimal(50,2) DEFAULT NULL,
  `cal_expense_amount` decimal(50,3) DEFAULT NULL,
  `cal_invoice_name` varchar(200) DEFAULT NULL,
  `cal_additional_amount` decimal(50,2) DEFAULT NULL,
  `cal_additional_consume` decimal(50,2) DEFAULT 0.00,
  `cal_consume_type` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`cal_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_calculation`
--

LOCK TABLES `finead_calculation` WRITE;
/*!40000 ALTER TABLE `finead_calculation` DISABLE KEYS */;
INSERT INTO `finead_calculation` VALUES (1,1,1,36660.00,NULL,'Order List',NULL,0.00,NULL);
/*!40000 ALTER TABLE `finead_calculation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_calculation_zone_wise`
--

DROP TABLE IF EXISTS `finead_calculation_zone_wise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_calculation_zone_wise` (
  `calz_id` int(11) NOT NULL AUTO_INCREMENT,
  `calz_project_id` int(11) DEFAULT NULL,
  `calz_zone_id` int(11) DEFAULT NULL,
  `calz_region_id` int(11) DEFAULT NULL,
  `calz_finish_pro_code` varchar(500) DEFAULT NULL,
  `calz_invoice_id` int(11) DEFAULT NULL,
  `calz_amount` decimal(50,3) DEFAULT NULL,
  `calz_invoice_name` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`calz_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_calculation_zone_wise`
--

LOCK TABLES `finead_calculation_zone_wise` WRITE;
/*!40000 ALTER TABLE `finead_calculation_zone_wise` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_calculation_zone_wise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_city`
--

DROP TABLE IF EXISTS `finead_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `city_prov` varchar(100) NOT NULL,
  `city_flag` varchar(1) NOT NULL DEFAULT 'F',
  `remarks` varchar(500) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT 1,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=379 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_city`
--

LOCK TABLES `finead_city` WRITE;
/*!40000 ALTER TABLE `finead_city` DISABLE KEYS */;
INSERT INTO `finead_city` VALUES (1,'Baghh','Azad Kashmir','F',NULL,'Active',1,1,NULL,NULL,NULL),(2,'Bhimber','Azad Kashmir','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(3,'khuiratta','Azad Kashmir','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(4,'Kotli','Azad Kashmir','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(5,'Mangla','Azad Kashmir','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(6,'Mirpur','Azad Kashmir','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(7,'Muzaffarabad','Azad Kashmir','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(8,'Plandri','Azad Kashmir','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(9,'Rawalakot','Azad Kashmir','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(10,'Punch','Azad Kashmir','T',NULL,'Active',1,NULL,NULL,NULL,NULL),(11,'Amir Chah','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(12,'Bazdar','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(13,'Bela','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(14,'Bellpat','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(15,'Bagh','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(16,'Burj','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(17,'Chagai','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(18,'Chah Sandan','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(19,'Chakku','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(20,'Chaman','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(21,'Chhatr','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(22,'Dalbandin','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(23,'Dera Bugti','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(24,'Dhana Sar','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(25,'Diwana','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(26,'Duki','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(27,'Dushi','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(28,'Duzab','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(29,'Gajar','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(30,'Gandava','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(31,'Garhi Khairo','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(32,'Garruck','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(33,'Ghazluna','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(34,'Girdan','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(35,'Gulistan','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(36,'Gwadar','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(37,'Gwash','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(38,'Hab Chauki','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(39,'Hameedabad','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(40,'Harnai','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(41,'Hinglaj','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(42,'Hoshab','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(43,'Ispikan','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(44,'Jhal','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(45,'Jhal Jhao','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(46,'Jhatpat','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(47,'Jiwani','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(48,'Kalandi','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(49,'Kalat','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(50,'Kamararod','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(51,'Kanak','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(52,'Kandi','Balochistan','T',NULL,'Active',1,NULL,NULL,NULL,NULL),(53,'Kanpur','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(54,'Kapip','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(55,'Kappar','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(56,'Karodi','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(57,'Katuri','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(58,'Kharan','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(59,'Khuzdar','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(60,'Kikki','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(61,'Kohan','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(62,'Kohlu','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(63,'Korak','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(64,'Lahri','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(65,'Lasbela','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(66,'Liari','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(67,'Loralai','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(68,'Mach','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(69,'Mand','Balochistan','T',NULL,'Active',1,NULL,NULL,NULL,NULL),(70,'Manguchar','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(71,'Mashki Chah','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(72,'Maslti','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(73,'Mastung','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(74,'Mekhtar','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(75,'Merui','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(76,'Mianez','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(77,'Murgha Kibzai','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(78,'Musa Khel Bazar','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(79,'Nagha Kalat','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(80,'Nal','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(81,'Naseerabad','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(82,'Nauroz Kalat','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(83,'Nur Gamma','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(84,'Nushki','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(85,'Nuttal','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(86,'Ormara','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(87,'Palantuk','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(88,'Panjgur','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(89,'Pasni','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(90,'Piharak','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(91,'Pishin','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(92,'Qamruddin Karez','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(93,'Qila Abdullah','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(94,'Qila Ladgasht','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(95,'Qila Safed','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(96,'Qila Saifullah','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(97,'Quetta','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(98,'Rakhni','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(99,'Robat Thana','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(100,'Rodkhan','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(101,'Saindak','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(102,'Sanjawi','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(103,'Saruna','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(104,'Shabaz Kalat','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(105,'Shahpur','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(106,'Sharam Jogizai','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(107,'Shingar','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(108,'Shorap','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(109,'Sibi','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(110,'Sonmiani','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(111,'Spezand','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(112,'Spintangi','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(113,'Sui','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(114,'Suntsar','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(115,'Surab','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(116,'Thalo','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(117,'Tump','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(118,'Turbat','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(119,'Umarao','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(120,'pirMahal','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(121,'Uthal','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(122,'Vitakri','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(123,'Wadh','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(124,'Washap','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(125,'Wasjuk','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(126,'Yakmach','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(127,'Zhob','Balochistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(128,'Astor','Gilgit Baltistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(129,'Baramula','Gilgit Baltistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(130,'Hunza','Gilgit Baltistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(131,'Gilgit','Gilgit Baltistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(132,'Nagar','Gilgit Baltistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(133,'Skardu','Gilgit Baltistan','T',NULL,'Active',1,NULL,NULL,NULL,NULL),(134,'Shangrila','Gilgit Baltistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(135,'Shandur','Gilgit Baltistan','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(136,'Bajaur','Federally Administered Tribal Areas','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(137,'Hangu','Federally Administered Tribal Areas','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(138,'Malakand','Federally Administered Tribal Areas','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(139,'Miram Shah','Federally Administered Tribal Areas','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(140,'Mohmand','Federally Administered Tribal Areas','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(141,'Khyber','Federally Administered Tribal Areas','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(142,'Kurram','Federally Administered Tribal Areas','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(143,'North Waziristan','Federally Administered Tribal Areas','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(144,'South Waziristan','Federally Administered Tribal Areas','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(145,'Wana','Federally Administered Tribal Areas','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(146,'Abbottabad','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(147,'Ayubia','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(148,'Adezai','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(149,'Banda Daud Shah','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(150,'Bannu','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(151,'Batagram','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(152,'Birote','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(153,'Buner','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(154,'Chakdara','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(155,'Charsadda','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(156,'Chitral','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(157,'Dargai','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(158,'Darya Khan','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(159,'Dera Ismail Khan','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(160,'Drasan','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(161,'Drosh','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(162,'Hangu','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(163,'Haripur','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(164,'Kalam','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(165,'Karak','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(166,'Khanaspur','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(167,'Kohat','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(168,'Kohistan','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(169,'Lakki Marwat','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(170,'Latamber','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(171,'Lower Dir','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(172,'Madyan','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(173,'Malakand','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(174,'Mansehra','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(175,'Mardan','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(176,'Mastuj','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(177,'Mongora','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(178,'Nowshera','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(179,'Paharpur','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(180,'Peshawar','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(181,'Saidu Sharif','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(182,'Shangla','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(183,'Sakesar','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(184,'Swabi','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(185,'Swat','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(186,'Tangi','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(187,'Tank','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(188,'Thall','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(189,'Tordher','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(190,'Upper Dir','Khyber Pakhtunkhwa','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(191,'Ahmedpur East','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(192,'Ahmed Nager Chatha','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(193,'Ali Pur','Punjab','T',NULL,'Active',1,NULL,NULL,NULL,NULL),(194,'Arifwala','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(195,'Attock','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(196,'Basti Malook','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(197,'Bhagalchur','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(198,'Bhalwal','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(199,'Bahawalnagar','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(200,'Bahawalpur','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(201,'Bhaipheru','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(202,'Bhakkar','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(203,'Burewala','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(204,'Chailianwala','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(205,'Chakwal','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(206,'Chichawatni','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(207,'Chiniot','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(208,'Chowk Azam','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(209,'Chowk Sarwar Shaheed','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(210,'Daska','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(211,'Darya Khan','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(212,'Dera Ghazi Khan','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(213,'Derawar Fort','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(214,'Dhaular','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(215,'Dina City','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(216,'Dinga','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(217,'Dipalpur','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(218,'Faisalabad','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(219,'Fateh Jang','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(220,'Gadar','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(221,'Ghakhar Mandi','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(222,'Gujranwala','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(223,'Gujrat','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(224,'Gujar Khan','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(225,'Hafizabad','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(226,'Haroonabad','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(227,'Hasilpur','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(228,'Haveli Lakha','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(229,'Jampur','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(230,'Jhang','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(231,'Jhelum','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(232,'Kalabagh','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(233,'Karor Lal Esan','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(234,'Kasur','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(235,'Kamalia','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(236,'Kamokey','Punjab','T',NULL,'Active',1,NULL,NULL,NULL,NULL),(237,'Khanewal','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(238,'Khanpur','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(239,'Kharian','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(240,'Khushab','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(241,'Kot Addu','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(242,'Jahania','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(243,'Jalla Araain','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(244,'Jauharabad','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(245,'Laar','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(246,'Lahore','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(247,'Lalamusa','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(248,'Layyah','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(249,'Lodhran','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(250,'Mamoori','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(251,'Mandi Bahauddin','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(252,'Makhdoom Aali','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(253,'Mandi Warburton','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(254,'Mailsi','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(255,'Mian Channu','Punjab','T',NULL,'Active',1,NULL,NULL,NULL,NULL),(256,'Minawala','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(257,'Mianwali','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(258,'Multan','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(259,'Murree','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(260,'Muridke','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(261,'Muzaffargarh','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(262,'Narowal','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(263,'Okara','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(264,'Renala Khurd','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(265,'Rajan Pur','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(266,'Pak Pattan','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(267,'Panjgur','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(268,'Pattoki','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(269,'Pirmahal','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(270,'Qila Didar Singh','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(271,'Rabwah','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(272,'Raiwind','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(273,'Rajan Pur','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(274,'Rahim Yar Khan','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(275,'Rawalpindi','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(276,'Rohri','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(277,'Sadiqabad','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(278,'Safdar Abad','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(279,'Sahiwal','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(280,'Sangla Hill','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(281,'Samberial','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(282,'Sarai Alamgir','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(283,'Sargodha','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(284,'Shakargarh','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(285,'Shafqat Shaheed Chowk','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(286,'Sheikhupura','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(287,'Sialkot','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(288,'Sohawa','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(289,'Sooianwala','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(290,'Sundar','Punjab','T',NULL,'Active',1,NULL,NULL,NULL,NULL),(291,'Talagang','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(292,'Tarbela','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(293,'Takhtbai','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(294,'Taxila','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(295,'Toba Tek Singh','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(296,'Vehari','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(297,'Wah Cantonment','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(298,'Wazirabad','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(299,'Ali Bandar','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(300,'Baden','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(301,'Chachro','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(302,'Dadu','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(303,'Digri','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(304,'Diplo','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(305,'Dokri','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(306,'Gadra','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(307,'Ghanian','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(308,'Ghauspur','Sindh','T',NULL,'Active',1,NULL,NULL,NULL,NULL),(309,'Ghotki','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(310,'Hala','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(311,'Hyderabad','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(312,'Islamkot','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(313,'Jacobabad','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(314,'Jamesabad','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(315,'Jamshoro','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(316,'Janghar','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(317,'Jati','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(318,'Jhudo','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(319,'Jungshahi','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(320,'Kandiaro','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(321,'Karachi','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(322,'Kashmor','Sindh','T',NULL,'Active',1,NULL,NULL,NULL,NULL),(323,'Keti Bandar','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(324,'Khairpur','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(325,'Khora','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(326,'Klupro','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(327,'Khokhropur','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(328,'Korangi','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(329,'Kotri','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(330,'Kot Sarae','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(331,'Larkana','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(332,'Lund','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(333,'Mathi','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(334,'Matiari','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(335,'Mehar','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(336,'Mirpur Batoro','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(337,'Mirpur Khas','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(338,'Mirpur Sakro','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(339,'Mithi','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(340,'Mithani','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(341,'Moro','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(342,'Nagar Parkar','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(343,'Naushara','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(344,'Naudero','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(345,'Noushero Feroz','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(346,'Nawabshah','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(347,'Nazimabad','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(348,'Naokot','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(349,'Pendoo','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(350,'Pokran','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(351,'Qambar','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(352,'Qazi Ahmad','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(353,'Ranipur','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(354,'Ratodero','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(355,'Rohri','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(356,'Saidu Sharif','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(357,'Sakrand','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(358,'Sanghar','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(359,'Shadadkhot','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(360,'Shahbandar','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(361,'Shahdadpur','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(362,'Shahpur Chakar','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(363,'Shikarpur','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(364,'Sujawal','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(365,'Sukkur','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(366,'Tando Adam','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(367,'Tando Allahyar','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(368,'Tando Bago','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(369,'Tar Ahamd Rind','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(370,'Thatta','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(371,'Tujal','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(372,'Umarkot','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(373,'Veirwaro','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(374,'Warah','Sindh','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(375,'Islamabad','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(377,'Multan','','F',NULL,'Active',1,NULL,NULL,NULL,NULL),(378,'Pasrur','Punjab','F',NULL,'Active',1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `finead_city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_designer_work_area`
--

DROP TABLE IF EXISTS `finead_designer_work_area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_designer_work_area` (
  `dwa_id` int(255) NOT NULL AUTO_INCREMENT,
  `dwa_company_id` int(11) DEFAULT NULL,
  `dwa_project_id` int(255) NOT NULL,
  `dwa_remarks` varchar(4000) NOT NULL,
  `dwa_day_end_id` int(11) NOT NULL,
  `dwa_day_end_date` date NOT NULL,
  `dwa_user_id` int(11) NOT NULL,
  `dwa_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dwa_ip_adrs` varchar(255) NOT NULL,
  `dwa_brwsr_info` varchar(4000) NOT NULL,
  `dwa_delete_status` tinyint(4) NOT NULL DEFAULT 0,
  `dwa_deleted_by` int(11) NOT NULL,
  `dwa_disabled` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`dwa_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_designer_work_area`
--

LOCK TABLES `finead_designer_work_area` WRITE;
/*!40000 ALTER TABLE `finead_designer_work_area` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_designer_work_area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_designer_work_area_item`
--

DROP TABLE IF EXISTS `finead_designer_work_area_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_designer_work_area_item` (
  `dwai_id` int(255) NOT NULL AUTO_INCREMENT,
  `dwai_dwa_id` int(255) DEFAULT NULL,
  `dwai_company_id` int(255) DEFAULT NULL,
  `dwai_region_id` int(255) DEFAULT NULL,
  `dwai_zone_id` int(255) DEFAULT NULL,
  `dwai_city_id` int(255) DEFAULT NULL,
  `dwai_grid_id` int(255) DEFAULT NULL,
  `dwai_franchise_id` int(255) DEFAULT NULL,
  `dwai_designer_id` int(255) DEFAULT NULL,
  `dwai_supervisor_id` int(255) DEFAULT NULL,
  `dwai_start_date` date DEFAULT NULL,
  `dwai_end_date` date DEFAULT NULL,
  PRIMARY KEY (`dwai_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_designer_work_area_item`
--

LOCK TABLES `finead_designer_work_area_item` WRITE;
/*!40000 ALTER TABLE `finead_designer_work_area_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_designer_work_area_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_expense_budget`
--

DROP TABLE IF EXISTS `finead_expense_budget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_expense_budget` (
  `eb_id` int(11) NOT NULL AUTO_INCREMENT,
  `eb_company_id` int(11) DEFAULT NULL,
  `eb_project_id` int(11) DEFAULT NULL,
  `eb_zone_id` int(11) DEFAULT NULL,
  `eb_region_id` int(11) DEFAULT NULL,
  `eb_product_code` varchar(500) DEFAULT NULL,
  `eb_remarks` varchar(4000) DEFAULT NULL,
  `eb_grand_total` decimal(50,2) DEFAULT NULL,
  `eb_total_items` int(11) DEFAULT NULL,
  `eb_detail_remarks` varchar(5000) DEFAULT NULL,
  `eb_day_end_id` int(11) DEFAULT NULL,
  `eb_day_end_date` date DEFAULT NULL,
  `eb_user_id` int(11) DEFAULT NULL,
  `eb_datetime` timestamp NULL DEFAULT NULL,
  `eb_ip_adrs` varchar(100) DEFAULT NULL,
  `eb_brwsr_info` varchar(4000) DEFAULT NULL,
  `eb_delete_status` tinyint(4) NOT NULL DEFAULT 0,
  `eb_deleted_by` int(11) DEFAULT NULL,
  `eb_disabled` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`eb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_expense_budget`
--

LOCK TABLES `finead_expense_budget` WRITE;
/*!40000 ALTER TABLE `finead_expense_budget` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_expense_budget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_expense_budget_items`
--

DROP TABLE IF EXISTS `finead_expense_budget_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_expense_budget_items` (
  `ebi_id` int(11) NOT NULL AUTO_INCREMENT,
  `ebi_eb_id` int(11) DEFAULT NULL,
  `ebi_service_id` int(11) DEFAULT NULL,
  `ebi_expense_uid` int(11) DEFAULT NULL,
  `ebi_expense_name` varchar(500) DEFAULT NULL,
  `ebi_party_uids` varchar(4000) DEFAULT NULL,
  `ebi_party_name` varchar(500) DEFAULT NULL,
  `ebi_remarks` varchar(4000) DEFAULT NULL,
  `ebi_limit_per` decimal(50,2) DEFAULT NULL,
  `ebi_limit_amount` decimal(50,2) DEFAULT NULL,
  `ebi_disabled` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ebi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_expense_budget_items`
--

LOCK TABLES `finead_expense_budget_items` WRITE;
/*!40000 ALTER TABLE `finead_expense_budget_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_expense_budget_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_material_budget`
--

DROP TABLE IF EXISTS `finead_material_budget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_material_budget` (
  `mb_id` int(11) NOT NULL AUTO_INCREMENT,
  `mb_company_id` int(11) DEFAULT NULL,
  `mb_project_id` int(11) DEFAULT NULL,
  `mb_region_id` int(11) DEFAULT NULL,
  `mb_finish_pro_code` varchar(500) DEFAULT NULL,
  `mb_produce_qty` decimal(50,3) DEFAULT NULL,
  `mb_remarks` varchar(4000) DEFAULT NULL,
  `mb_detail_remarks` text DEFAULT NULL,
  `mb_grand_total` decimal(50,2) DEFAULT NULL,
  `mb_total_items` int(11) DEFAULT NULL,
  `mb_day_end_id` int(11) DEFAULT NULL,
  `mb_day_end_date` date DEFAULT NULL,
  `mb_user_id` int(11) DEFAULT NULL,
  `mb_datetime` timestamp NULL DEFAULT NULL,
  `mb_ip_adrs` varchar(100) DEFAULT NULL,
  `mb_brwsr_info` varchar(4000) DEFAULT NULL,
  `mb_delete_status` tinyint(4) NOT NULL DEFAULT 0,
  `mb_deleted_by` int(11) DEFAULT NULL,
  `mb_disabled` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_material_budget`
--

LOCK TABLES `finead_material_budget` WRITE;
/*!40000 ALTER TABLE `finead_material_budget` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_material_budget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_material_budget_items`
--

DROP TABLE IF EXISTS `finead_material_budget_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_material_budget_items` (
  `mbi_id` int(11) NOT NULL AUTO_INCREMENT,
  `mbi_mb_id` int(11) DEFAULT NULL,
  `mbi_pro_code` varchar(500) DEFAULT NULL,
  `mbi_pro_name` varchar(1500) DEFAULT NULL,
  `mbi_remarks` varchar(4000) DEFAULT NULL,
  `mbi_uom` varchar(500) DEFAULT NULL,
  `mbi_quantity` decimal(50,3) DEFAULT NULL,
  `mbi_rate` decimal(50,2) DEFAULT NULL,
  `mbi_amount` decimal(50,2) DEFAULT NULL,
  PRIMARY KEY (`mbi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_material_budget_items`
--

LOCK TABLES `finead_material_budget_items` WRITE;
/*!40000 ALTER TABLE `finead_material_budget_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_material_budget_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_order_list`
--

DROP TABLE IF EXISTS `finead_order_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_order_list` (
  `ol_id` int(11) NOT NULL AUTO_INCREMENT,
  `ol_order_title` varchar(1000) DEFAULT NULL,
  `ol_company_id` int(11) DEFAULT NULL,
  `ol_project_id` int(11) DEFAULT NULL,
  `ol_remarks` varchar(4000) DEFAULT NULL,
  `ol_total_items` int(11) DEFAULT NULL,
  `ol_grand_total` decimal(50,2) DEFAULT NULL,
  `ol_detail_remarks` varchar(5000) DEFAULT NULL,
  `ol_day_end_id` int(11) DEFAULT NULL,
  `ol_day_end_date` date DEFAULT NULL,
  `ol_user_id` int(11) DEFAULT NULL,
  `ol_datetime` timestamp NULL DEFAULT NULL,
  `ol_ip_adrs` varchar(100) DEFAULT NULL,
  `ol_brwsr_info` varchar(4000) DEFAULT NULL,
  `ol_delete_status` tinyint(4) NOT NULL DEFAULT 0,
  `ol_deleted_by` int(11) DEFAULT NULL,
  `ol_disabled` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ol_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_order_list`
--

LOCK TABLES `finead_order_list` WRITE;
/*!40000 ALTER TABLE `finead_order_list` DISABLE KEYS */;
INSERT INTO `finead_order_list` VALUES (1,'Client One-jazz-center 1',110131,1,'',3,36660.00,'Pepsi 1500 ML, 6@510.00 = 3,060.00\nDaal Chawal, 6@3,600.00 = 21,600.00\n\nShop Survey, 12@1,000.00 = 12,000.00\n',1,'2021-09-29',1,'2021-11-10 12:12:52','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69',0,NULL,0);
/*!40000 ALTER TABLE `finead_order_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_order_list_calculation`
--

DROP TABLE IF EXISTS `finead_order_list_calculation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_order_list_calculation` (
  `olcal_id` int(11) NOT NULL AUTO_INCREMENT,
  `olcal_order_list_id` int(11) DEFAULT NULL,
  `olcal_voucher_id` int(11) DEFAULT NULL,
  `olcal_voucher_name` varchar(500) DEFAULT NULL,
  `olcal_amount` int(11) DEFAULT NULL,
  `olcal_status` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`olcal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_order_list_calculation`
--

LOCK TABLES `finead_order_list_calculation` WRITE;
/*!40000 ALTER TABLE `finead_order_list_calculation` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_order_list_calculation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_order_product`
--

DROP TABLE IF EXISTS `finead_order_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_order_product` (
  `op_id` int(11) NOT NULL AUTO_INCREMENT,
  `op_ol_id` int(11) DEFAULT NULL,
  `op_project_id` int(11) DEFAULT NULL,
  `op_remarks` varchar(5000) DEFAULT NULL,
  `op_total_items` int(11) DEFAULT NULL,
  `op_grand_total` decimal(50,2) DEFAULT NULL,
  `op_detail_remarks` text DEFAULT NULL,
  `op_day_end_id` int(11) DEFAULT NULL,
  `op_day_end_date` date DEFAULT NULL,
  `op_user_id` int(11) DEFAULT NULL,
  `op_datetime` timestamp NULL DEFAULT NULL,
  `op_ip_adrs` varchar(100) DEFAULT NULL,
  `op_brwsr_info` varchar(4000) DEFAULT NULL,
  `op_delete_status` tinyint(4) DEFAULT NULL,
  `op_deleted_by` int(11) DEFAULT NULL,
  `op_disabled` varchar(4) DEFAULT NULL,
  `op_os_id` int(11) DEFAULT 0,
  PRIMARY KEY (`op_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_order_product`
--

LOCK TABLES `finead_order_product` WRITE;
/*!40000 ALTER TABLE `finead_order_product` DISABLE KEYS */;
INSERT INTO `finead_order_product` VALUES (1,1,1,NULL,2,24660.00,'Pepsi 1500 ML, 6@510.00 = 3,060.00\nDaal Chawal, 6@3,600.00 = 21,600.00\n',1,'2021-09-29',1,'2021-11-10 12:12:52','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69',NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `finead_order_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_order_product_items`
--

DROP TABLE IF EXISTS `finead_order_product_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_order_product_items` (
  `opi_id` int(11) NOT NULL AUTO_INCREMENT,
  `opi_op_id` int(11) DEFAULT NULL,
  `opi_company_id` int(11) DEFAULT NULL,
  `opi_zone_id` int(11) DEFAULT NULL,
  `opi_region_id` int(11) DEFAULT NULL,
  `opi_type` varchar(50) DEFAULT NULL,
  `opi_pro_code` varchar(1000) DEFAULT NULL,
  `opi_pro_title` varchar(4000) DEFAULT NULL,
  `opi_remarks` varchar(5000) DEFAULT NULL,
  `opi_qty` decimal(50,3) DEFAULT NULL,
  `opi_rate` decimal(50,2) DEFAULT NULL,
  `opi_uom` varchar(1000) DEFAULT NULL,
  `opi_amount` decimal(50,2) DEFAULT NULL,
  `opi_start_date` date DEFAULT NULL,
  `opi_end_date` date DEFAULT NULL,
  `opi_status` varchar(255) DEFAULT 'product',
  `opi_status_type` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`opi_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_order_product_items`
--

LOCK TABLES `finead_order_product_items` WRITE;
/*!40000 ALTER TABLE `finead_order_product_items` DISABLE KEYS */;
INSERT INTO `finead_order_product_items` VALUES (1,1,110131,1,1,'products','200','Pepsi 1500 ML','',6.000,510.00,'Pet',3060.00,'2021-11-10','2021-11-30','product',0),(2,1,110131,1,1,'products','400','Daal Chawal','',6.000,3600.00,'Gattu',21600.00,'2021-11-10','2021-11-30','product',0);
/*!40000 ALTER TABLE `finead_order_product_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_order_service`
--

DROP TABLE IF EXISTS `finead_order_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_order_service` (
  `os_id` int(11) NOT NULL AUTO_INCREMENT,
  `os_ol_id` int(11) DEFAULT NULL,
  `os_project_id` int(11) DEFAULT NULL,
  `os_remarks` varchar(5000) DEFAULT NULL,
  `os_total_items` int(11) DEFAULT NULL,
  `os_grand_total` decimal(50,2) DEFAULT NULL,
  `os_detail_remarks` text DEFAULT NULL,
  `os_day_end_id` int(11) DEFAULT NULL,
  `os_day_end_date` date DEFAULT NULL,
  `os_user_id` int(11) DEFAULT NULL,
  `os_datetime` timestamp NULL DEFAULT NULL,
  `os_ip_adrs` varchar(100) DEFAULT NULL,
  `os_brwsr_info` varchar(4000) DEFAULT NULL,
  `os_delete_status` tinyint(4) NOT NULL DEFAULT 0,
  `os_deleted_by` int(11) DEFAULT NULL,
  `os_disabled` tinyint(4) NOT NULL DEFAULT 0,
  `os_op_id` int(11) DEFAULT 0,
  PRIMARY KEY (`os_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_order_service`
--

LOCK TABLES `finead_order_service` WRITE;
/*!40000 ALTER TABLE `finead_order_service` DISABLE KEYS */;
INSERT INTO `finead_order_service` VALUES (1,1,1,NULL,1,12000.00,'Shop Survey, 12@1,000.00 = 12,000.00\n',1,'2021-09-29',1,'2021-11-10 12:12:52','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69',0,NULL,0,1);
/*!40000 ALTER TABLE `finead_order_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_order_service_items`
--

DROP TABLE IF EXISTS `finead_order_service_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_order_service_items` (
  `osi_id` int(11) NOT NULL AUTO_INCREMENT,
  `osi_os_id` int(11) DEFAULT NULL,
  `osi_company_id` int(11) DEFAULT NULL,
  `osi_zone_id` int(11) DEFAULT NULL,
  `osi_region_id` int(11) DEFAULT NULL,
  `osi_type` varchar(50) DEFAULT NULL,
  `osi_service_code` int(25) DEFAULT NULL,
  `osi_service_name` varchar(1000) DEFAULT NULL,
  `osi_remarks` varchar(4000) DEFAULT NULL,
  `osi_qty` decimal(50,3) DEFAULT NULL,
  `osi_rate` decimal(50,2) DEFAULT NULL,
  `osi_uom` varchar(255) DEFAULT NULL,
  `osi_amount` decimal(50,2) DEFAULT NULL,
  `osi_start_date` date DEFAULT NULL,
  `osi_end_date` date DEFAULT NULL,
  `osi_status` varchar(255) NOT NULL DEFAULT 'service',
  `osi_status_type` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`osi_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_order_service_items`
--

LOCK TABLES `finead_order_service_items` WRITE;
/*!40000 ALTER TABLE `finead_order_service_items` DISABLE KEYS */;
INSERT INTO `finead_order_service_items` VALUES (1,1,110131,1,1,'services',1,'Shop Survey','',12.000,1000.00,'',12000.00,'2021-11-10','2021-11-30','service',0);
/*!40000 ALTER TABLE `finead_order_service_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_pip_length_calibration`
--

DROP TABLE IF EXISTS `finead_pip_length_calibration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_pip_length_calibration` (
  `plc_id` int(11) NOT NULL AUTO_INCREMENT,
  `plc_board_type_id` int(11) NOT NULL,
  `plc_length_from` decimal(50,2) DEFAULT NULL,
  `plc_length_to` decimal(50,2) DEFAULT NULL,
  `plc_pipe_center_support` decimal(50,2) DEFAULT NULL,
  `plc_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `plc_createdby` int(11) NOT NULL,
  `plc_day_end_id` int(11) DEFAULT NULL,
  `plc_day_end_date` date DEFAULT NULL,
  `plc_ip_adrs` varchar(255) DEFAULT NULL,
  `plc_brwsr_info` varchar(4000) DEFAULT NULL,
  `plc_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`plc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_pip_length_calibration`
--

LOCK TABLES `finead_pip_length_calibration` WRITE;
/*!40000 ALTER TABLE `finead_pip_length_calibration` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_pip_length_calibration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_pip_width_calibration`
--

DROP TABLE IF EXISTS `finead_pip_width_calibration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_pip_width_calibration` (
  `pwc_id` int(11) NOT NULL AUTO_INCREMENT,
  `pwc_board_type_id` int(11) NOT NULL,
  `pwc_width_from` decimal(50,2) DEFAULT NULL,
  `pwc_width_to` decimal(50,2) DEFAULT NULL,
  `pwc_pipe_center_support` decimal(50,2) DEFAULT NULL,
  `pwc_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `pwc_createdby` int(11) NOT NULL,
  `pwc_day_end_id` int(11) DEFAULT NULL,
  `pwc_day_end_date` date DEFAULT NULL,
  `pwc_ip_adrs` varchar(255) DEFAULT NULL,
  `pwc_brwsr_info` varchar(4000) DEFAULT NULL,
  `pwc_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`pwc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_pip_width_calibration`
--

LOCK TABLES `finead_pip_width_calibration` WRITE;
/*!40000 ALTER TABLE `finead_pip_width_calibration` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_pip_width_calibration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_primary_finished_goods`
--

DROP TABLE IF EXISTS `finead_primary_finished_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_primary_finished_goods` (
  `pfg_id` int(11) NOT NULL AUTO_INCREMENT,
  `pfg_odr_id` int(11) NOT NULL,
  `pfg_pro_code` varchar(500) NOT NULL,
  `pfg_pro_name` varchar(1000) NOT NULL,
  `pfg_pro_remarks` text DEFAULT 'NULL',
  `pfg_uom` varchar(1000) NOT NULL,
  `pfg_recipe_production_qty` decimal(50,2) NOT NULL,
  `pfg_stock_before_production` decimal(50,2) NOT NULL,
  `pfg_stock_after_production` decimal(50,2) NOT NULL,
  PRIMARY KEY (`pfg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_primary_finished_goods`
--

LOCK TABLES `finead_primary_finished_goods` WRITE;
/*!40000 ALTER TABLE `finead_primary_finished_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_primary_finished_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_product_batch_recipe`
--

DROP TABLE IF EXISTS `finead_product_batch_recipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_product_batch_recipe` (
  `pbr_id` int(11) NOT NULL AUTO_INCREMENT,
  `pbr_name` varchar(1000) DEFAULT NULL,
  `pbr_batch_id` int(11) DEFAULT NULL,
  `pbr_order_list_id` int(11) DEFAULT NULL,
  `pbr_remarks` text DEFAULT NULL,
  `pbr_total_height` decimal(50,2) DEFAULT NULL,
  `pbr_total_length` decimal(50,2) DEFAULT NULL,
  `pbr_total_depth` decimal(50,2) DEFAULT NULL,
  `pbr_total_items` int(11) DEFAULT NULL,
  `pbr_datetime` timestamp NULL DEFAULT current_timestamp(),
  `pbr_day_end_id` int(11) DEFAULT NULL,
  `pbr_day_end_date` datetime DEFAULT NULL,
  `pbr_createdby` int(11) DEFAULT NULL,
  `pbr_ip_adrs` varchar(100) DEFAULT NULL,
  `pbr_brwsr_info` varchar(1000) DEFAULT NULL,
  `pbr_update_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pbr_delete_status` int(11) DEFAULT 0,
  `pbr_deleted_by` int(11) DEFAULT NULL,
  `pbr_disabled` int(11) DEFAULT 0,
  PRIMARY KEY (`pbr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_product_batch_recipe`
--

LOCK TABLES `finead_product_batch_recipe` WRITE;
/*!40000 ALTER TABLE `finead_product_batch_recipe` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_product_batch_recipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_product_batch_recipe_items`
--

DROP TABLE IF EXISTS `finead_product_batch_recipe_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_product_batch_recipe_items` (
  `pbri_id` int(11) NOT NULL AUTO_INCREMENT,
  `pbri_product_recipe_id` int(11) NOT NULL,
  `pbri_product_code` varchar(500) NOT NULL,
  `pbri_product_name` varchar(250) NOT NULL,
  `pbri_remarks` varchar(250) DEFAULT NULL,
  `pbri_qty` decimal(50,3) NOT NULL,
  `pbri_uom` varchar(1000) DEFAULT NULL,
  `pbri_scale_size` int(11) DEFAULT NULL,
  `pbri_rate` decimal(50,2) NOT NULL,
  `pbri_amount` decimal(50,2) NOT NULL,
  `pbri_status` varchar(33) DEFAULT NULL,
  PRIMARY KEY (`pbri_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_product_batch_recipe_items`
--

LOCK TABLES `finead_product_batch_recipe_items` WRITE;
/*!40000 ALTER TABLE `finead_product_batch_recipe_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_product_batch_recipe_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_product_measurement_config`
--

DROP TABLE IF EXISTS `finead_product_measurement_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_product_measurement_config` (
  `pmc_id` int(11) NOT NULL AUTO_INCREMENT,
  `pmc_company_id` int(11) DEFAULT NULL,
  `pmc_project_id` int(11) DEFAULT NULL,
  `pmc_pro_code` varchar(255) DEFAULT NULL,
  `pmc_before_decimal` varchar(11) DEFAULT NULL,
  `pmc_after_decimal` varchar(11) DEFAULT NULL,
  `pmc_uom_after_cal` varchar(11) DEFAULT NULL,
  `pmc_remarks` varchar(2000) DEFAULT '',
  `pmc_day_end_id` int(11) NOT NULL,
  `pmc_day_end_date` date NOT NULL,
  `pmc_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `pmc_user_id` int(11) NOT NULL,
  `pmc_update_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `pmc_ip_adrs` varchar(100) DEFAULT '',
  `pmc_brwsr_info` varchar(4000) DEFAULT '',
  `pmc_deleted_status` tinyint(4) DEFAULT 0,
  `pmc_deleted_by` int(11) DEFAULT NULL,
  `pmc_disabled` tinyint(4) DEFAULT 0,
  `pmc_depth` int(11) DEFAULT 0,
  `pmc_tapa_gauge` decimal(50,2) DEFAULT 0.00,
  `pmc_back_sheet_gauge` decimal(50,2) DEFAULT 0.00,
  `pmc_adv_type` tinyint(4) DEFAULT 0,
  `pmc_pre_survey` int(11) DEFAULT 0,
  `pmc_post_survey` int(11) DEFAULT 0,
  PRIMARY KEY (`pmc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_product_measurement_config`
--

LOCK TABLES `finead_product_measurement_config` WRITE;
/*!40000 ALTER TABLE `finead_product_measurement_config` DISABLE KEYS */;
INSERT INTO `finead_product_measurement_config` VALUES (1,110131,1,'200','Feet','Inches','SQFT','',1,'2021-09-29','2021-11-10 12:11:52',1,'2021-11-10 12:11:52','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69',0,NULL,0,5,5.00,5.00,1,1,1),(2,110131,1,'400','each','each','each','',1,'2021-09-29','2021-11-10 12:12:01',1,'2021-11-10 12:12:01','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69',0,NULL,0,0,0.00,0.00,2,1,1);
/*!40000 ALTER TABLE `finead_product_measurement_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_production_over_head`
--

DROP TABLE IF EXISTS `finead_production_over_head`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_production_over_head` (
  `poh_id` int(11) NOT NULL AUTO_INCREMENT,
  `poh_odr_id` int(11) NOT NULL,
  `poh_warehouse` varchar(1000) NOT NULL,
  `poh_department` int(11) NOT NULL,
  `poh_parties_clients` int(11) NOT NULL,
  `poh_supervisor` int(11) NOT NULL,
  `poh_remarks` text DEFAULT 'NULL',
  PRIMARY KEY (`poh_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_production_over_head`
--

LOCK TABLES `finead_production_over_head` WRITE;
/*!40000 ALTER TABLE `finead_production_over_head` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_production_over_head` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_production_over_head_items`
--

DROP TABLE IF EXISTS `finead_production_over_head_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_production_over_head_items` (
  `pohi_id` int(11) NOT NULL AUTO_INCREMENT,
  `pohi_poh_id` int(11) NOT NULL,
  `pohi_ser_code` int(11) NOT NULL,
  `pohi_ser_name` varchar(1000) NOT NULL,
  `pohi_ser_remarks` text DEFAULT 'NULL',
  `pohi_expense_account` int(11) NOT NULL,
  `pohi_rate` decimal(50,2) NOT NULL,
  `pohi_qty` decimal(50,2) NOT NULL,
  `pohi_uom` varchar(1000) NOT NULL,
  `pohi_amount` decimal(50,2) NOT NULL,
  PRIMARY KEY (`pohi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_production_over_head_items`
--

LOCK TABLES `finead_production_over_head_items` WRITE;
/*!40000 ALTER TABLE `finead_production_over_head_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_production_over_head_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_projects`
--

DROP TABLE IF EXISTS `finead_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_projects` (
  `proj_id` int(11) NOT NULL AUTO_INCREMENT,
  `proj_project_name` varchar(500) DEFAULT NULL,
  `proj_party_uid` int(11) DEFAULT NULL,
  `proj_party_reference` varchar(1000) DEFAULT NULL,
  `proj_remarks` text DEFAULT NULL,
  `proj_start_date` date DEFAULT NULL,
  `proj_end_date` date DEFAULT NULL,
  `proj_grand_total` decimal(50,2) DEFAULT NULL,
  `proj_material_amount` decimal(50,2) DEFAULT NULL,
  `proj_expense_amount` decimal(50,2) DEFAULT NULL,
  `proj_reserve_amount` decimal(50,2) DEFAULT NULL,
  `proj_detail_remarks` varchar(5000) DEFAULT NULL,
  `proj_day_end_id` int(11) DEFAULT NULL,
  `proj_day_end_date` date DEFAULT NULL,
  `proj_user_id` int(11) DEFAULT NULL,
  `proj_datetime` timestamp NULL DEFAULT NULL,
  `proj_ip_adrs` varchar(100) DEFAULT NULL,
  `proj_brwsr_info` varchar(4000) DEFAULT NULL,
  `proj_delete_status` tinyint(4) DEFAULT 0,
  `proj_deleted_by` int(11) DEFAULT NULL,
  `proj_disabled` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`proj_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_projects`
--

LOCK TABLES `finead_projects` WRITE;
/*!40000 ALTER TABLE `finead_projects` DISABLE KEYS */;
INSERT INTO `finead_projects` VALUES (1,'jazz',110131,'','Fdasfasd','2021-11-11','2021-11-24',78480.00,78480.00,NULL,NULL,'Daal Chawal, 12@4,000.00 = 48,000.00\nPepsi 1500 ML, 12@540.00 = 6,480.00\n\nShop Survey, 24@1,000.00 = 24,000.00\n',1,'2021-09-29',1,'2021-11-10 07:29:37','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69',0,NULL,0);
/*!40000 ALTER TABLE `finead_projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_purchase_order`
--

DROP TABLE IF EXISTS `finead_purchase_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_purchase_order` (
  `po_id` int(11) NOT NULL AUTO_INCREMENT,
  `po_project_id` int(11) DEFAULT NULL,
  `po_poi_total_items` int(11) DEFAULT NULL,
  `po_poi_sub_total` decimal(50,2) DEFAULT NULL,
  `po_poi_total_tax` decimal(50,2) DEFAULT NULL,
  `po_grand_total` decimal(50,2) DEFAULT NULL,
  `po_total_payment` decimal(50,2) DEFAULT NULL,
  `po_detail_remarks` varchar(5000) DEFAULT NULL,
  `po_service_order_id` int(11) DEFAULT 0,
  `po_day_end_id` int(11) DEFAULT NULL,
  `po_day_end_date` date DEFAULT NULL,
  `po_user_id` int(11) DEFAULT NULL,
  `po_datetime` timestamp NULL DEFAULT NULL,
  `po_ip_adrs` varchar(100) DEFAULT NULL,
  `po_brwsr_info` varchar(4000) DEFAULT NULL,
  `po_delete_status` tinyint(4) NOT NULL DEFAULT 0,
  `po_deleted_by` int(11) DEFAULT NULL,
  `po_disabled` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`po_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_purchase_order`
--

LOCK TABLES `finead_purchase_order` WRITE;
/*!40000 ALTER TABLE `finead_purchase_order` DISABLE KEYS */;
INSERT INTO `finead_purchase_order` VALUES (1,1,2,54480.00,0.00,54480.00,78480.00,'Daal Chawal, 12@4,000.00 = 48,000.00\nPepsi 1500 ML, 12@540.00 = 6,480.00\n',1,1,'2021-09-29',1,'2021-11-10 07:29:37','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69',0,NULL,0);
/*!40000 ALTER TABLE `finead_purchase_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_purchase_order_items`
--

DROP TABLE IF EXISTS `finead_purchase_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_purchase_order_items` (
  `poi_id` int(11) NOT NULL AUTO_INCREMENT,
  `poi_po_id` int(11) DEFAULT NULL,
  `poi_pro_code` varchar(500) DEFAULT NULL,
  `poi_pro_title` varchar(1500) DEFAULT NULL,
  `poi_pro_remarks` varchar(4000) DEFAULT NULL,
  `poi_pro_qty` decimal(50,3) DEFAULT NULL,
  `poi_pro_uom` varchar(500) DEFAULT NULL,
  `poi_pro_rate` decimal(50,2) DEFAULT NULL,
  `poi_pro_dis_per` decimal(50,2) DEFAULT NULL,
  `poi_after_dis_rate` decimal(50,2) DEFAULT NULL,
  `poi_pro_dis_amount` decimal(50,2) DEFAULT NULL,
  `poi_pro_tax_per` decimal(50,2) DEFAULT NULL,
  `poi_net_rate` decimal(50,2) NOT NULL,
  `poi_pro_tax_amount` decimal(50,2) DEFAULT NULL,
  `poi_inclusive` tinyint(4) DEFAULT NULL,
  `poi_amount` decimal(50,2) DEFAULT NULL,
  `poi_sale_ser_type` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`poi_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_purchase_order_items`
--

LOCK TABLES `finead_purchase_order_items` WRITE;
/*!40000 ALTER TABLE `finead_purchase_order_items` DISABLE KEYS */;
INSERT INTO `finead_purchase_order_items` VALUES (1,1,'400','Daal Chawal','',12.000,'Gattu',4000.00,0.00,4000.00,0.00,0.00,4000.00,0.00,0,48000.00,0),(2,1,'200','Pepsi 1500 ML','',12.000,'Pet',540.00,0.00,540.00,0.00,0.00,540.00,0.00,0,6480.00,0);
/*!40000 ALTER TABLE `finead_purchase_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_purchase_order_service`
--

DROP TABLE IF EXISTS `finead_purchase_order_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_purchase_order_service` (
  `sei_id` int(11) NOT NULL AUTO_INCREMENT,
  `sei_project_id` int(11) DEFAULT NULL,
  `sei_poi_total_items` int(11) DEFAULT NULL,
  `sei_poi_sub_total` decimal(50,2) DEFAULT NULL,
  `sei_poi_total_tax` decimal(50,2) DEFAULT NULL,
  `sei_grand_total` decimal(50,2) DEFAULT NULL,
  `sei_total_payment` decimal(50,2) DEFAULT NULL,
  `sei_detail_remarks` varchar(5000) DEFAULT NULL,
  `sei_day_end_id` int(11) DEFAULT NULL,
  `sei_day_end_date` date DEFAULT NULL,
  `sei_user_id` int(11) DEFAULT NULL,
  `sei_datetime` timestamp NULL DEFAULT NULL,
  `sei_ip_adrs` varchar(100) DEFAULT NULL,
  `sei_brwsr_info` varchar(4000) DEFAULT NULL,
  `sei_delete_status` tinyint(4) NOT NULL DEFAULT 0,
  `sei_deleted_by` int(11) DEFAULT NULL,
  `sei_disabled` tinyint(4) DEFAULT 0,
  `sei_purchase_order_id` int(11) DEFAULT 0,
  PRIMARY KEY (`sei_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_purchase_order_service`
--

LOCK TABLES `finead_purchase_order_service` WRITE;
/*!40000 ALTER TABLE `finead_purchase_order_service` DISABLE KEYS */;
INSERT INTO `finead_purchase_order_service` VALUES (1,1,1,24000.00,0.00,24000.00,78480.00,'Shop Survey, 24@1,000.00 = 24,000.00\n',1,'2021-09-29',1,'2021-11-10 07:29:37','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69',0,NULL,0,1);
/*!40000 ALTER TABLE `finead_purchase_order_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_purchase_order_service_items`
--

DROP TABLE IF EXISTS `finead_purchase_order_service_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_purchase_order_service_items` (
  `seii_id` int(11) NOT NULL AUTO_INCREMENT,
  `seii_sei_id` int(11) DEFAULT NULL,
  `seii_service_code` varchar(250) DEFAULT NULL,
  `seii_service_name` varchar(250) DEFAULT NULL,
  `seii_remarks` varchar(500) DEFAULT NULL,
  `seii_qty` decimal(50,3) DEFAULT NULL,
  `seii_uom` varchar(50) DEFAULT NULL,
  `seii_rate` decimal(50,2) DEFAULT NULL,
  `seii_discount_per` decimal(50,2) DEFAULT 0.00,
  `seii_discount_amount` decimal(50,2) DEFAULT 0.00,
  `seii_after_dis_rate` decimal(50,2) DEFAULT 0.00,
  `seii_net_rate` decimal(50,2) DEFAULT 0.00,
  `seii_saletax_per` decimal(50,2) DEFAULT 0.00,
  `seii_saletax_inclusive` tinyint(1) NOT NULL DEFAULT 0,
  `seii_saletax_amount` decimal(50,2) DEFAULT 0.00,
  `seii_amount` decimal(50,2) DEFAULT NULL,
  `seii_sale_ser_type` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`seii_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_purchase_order_service_items`
--

LOCK TABLES `finead_purchase_order_service_items` WRITE;
/*!40000 ALTER TABLE `finead_purchase_order_service_items` DISABLE KEYS */;
INSERT INTO `finead_purchase_order_service_items` VALUES (1,1,'1','Shop Survey','',24.000,NULL,1000.00,0.00,0.00,1000.00,1000.00,0.00,0,0.00,24000.00,1);
/*!40000 ALTER TABLE `finead_purchase_order_service_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_raw_stock_costing`
--

DROP TABLE IF EXISTS `finead_raw_stock_costing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_raw_stock_costing` (
  `rsc_id` int(11) NOT NULL AUTO_INCREMENT,
  `rsc_odr_id` int(11) NOT NULL,
  `rsc_pro_code` varchar(500) NOT NULL,
  `rsc_pro_name` varchar(1000) NOT NULL,
  `rsc_pro_remarks` text DEFAULT 'NULL',
  `rsc_uom` varchar(500) NOT NULL,
  `rsc_qty` decimal(50,2) NOT NULL,
  `rsc_rate` decimal(50,2) NOT NULL,
  `rsc_total` decimal(50,2) NOT NULL,
  PRIMARY KEY (`rsc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_raw_stock_costing`
--

LOCK TABLES `finead_raw_stock_costing` WRITE;
/*!40000 ALTER TABLE `finead_raw_stock_costing` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_raw_stock_costing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_secondary_finished_good`
--

DROP TABLE IF EXISTS `finead_secondary_finished_good`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_secondary_finished_good` (
  `sfg_id` int(11) NOT NULL AUTO_INCREMENT,
  `sfg_odr_id` int(11) NOT NULL,
  `sfg_pro_code` varchar(500) NOT NULL,
  `sfg_pro_name` varchar(1000) NOT NULL,
  `sfg_pro_remarks` text DEFAULT 'NULL',
  `sfg_recipe_production_qty` decimal(50,0) NOT NULL,
  `sfg_reqd_production_qty` decimal(50,0) DEFAULT NULL,
  `sfg_stock_before_production` decimal(50,2) NOT NULL,
  `sfg_stock_after_production` decimal(50,2) NOT NULL,
  `sfg_uom` varchar(1000) NOT NULL,
  PRIMARY KEY (`sfg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_secondary_finished_good`
--

LOCK TABLES `finead_secondary_finished_good` WRITE;
/*!40000 ALTER TABLE `finead_secondary_finished_good` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_secondary_finished_good` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_survey_images`
--

DROP TABLE IF EXISTS `finead_survey_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_survey_images` (
  `sri_id` int(11) NOT NULL AUTO_INCREMENT,
  `sri_sr_id` int(11) DEFAULT NULL,
  `sri_pro_code` varchar(500) DEFAULT NULL,
  `sri_pro_name` varchar(500) DEFAULT NULL,
  `sri_total_sqft` decimal(50,2) DEFAULT 0.00,
  `sri_depth` int(11) DEFAULT NULL,
  `sri_tapa_gauge` int(11) DEFAULT NULL,
  `sri_back_sheet_gauge` int(11) DEFAULT NULL,
  `sri_pre_survey` int(11) DEFAULT NULL,
  `sri_post_survey` int(11) DEFAULT NULL,
  `sri_front_left_right_height_feet` int(11) DEFAULT NULL,
  `sri_front_left_right_height_Inch` int(11) DEFAULT NULL,
  `sri_pmc_adv_type` int(11) DEFAULT NULL,
  `sri_widthFeet` double DEFAULT NULL,
  `sri_widthInch` double DEFAULT NULL,
  `sri_total_width` decimal(50,2) DEFAULT NULL,
  `sri_lengthFeet` double DEFAULT NULL,
  `sri_lengthInch` double DEFAULT NULL,
  `sri_total_length` decimal(50,2) DEFAULT NULL,
  `sri_height` decimal(50,2) DEFAULT NULL,
  `sri_quantity` int(11) DEFAULT NULL,
  `sri_latitude` varchar(500) DEFAULT NULL,
  `sri_longitude` varchar(500) DEFAULT NULL,
  `sri_dmsLatitude` varchar(500) DEFAULT NULL,
  `sri_dmsLongitude` varchar(500) DEFAULT NULL,
  `sri_address` text DEFAULT NULL,
  `sri_before_image` varchar(5000) DEFAULT NULL,
  `sri_after_image` varchar(5000) DEFAULT NULL,
  `sri_designer_image` varchar(500) DEFAULT NULL,
  `sri_executed_image` varchar(500) DEFAULT NULL,
  `sri_area` double DEFAULT NULL,
  `sri_image_type` varchar(255) DEFAULT NULL,
  `sri_before` varchar(255) DEFAULT NULL,
  `sri_after` varchar(255) DEFAULT NULL,
  `sri_output_uom` varchar(500) DEFAULT NULL,
  `sri_survey_status` varchar(50) DEFAULT NULL,
  `sri_designer_status` varchar(50) DEFAULT NULL,
  `sri_executed_status` varchar(50) DEFAULT NULL,
  `sri_batch_no` int(11) DEFAULT NULL,
  `sri_designer_id` int(11) DEFAULT NULL,
  `sri_shop_story` varchar(500) DEFAULT NULL,
  `sri_angle_side` varchar(50) DEFAULT '0',
  `sri_double_side` varchar(50) DEFAULT '1',
  PRIMARY KEY (`sri_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_survey_images`
--

LOCK TABLES `finead_survey_images` WRITE;
/*!40000 ALTER TABLE `finead_survey_images` DISABLE KEYS */;
INSERT INTO `finead_survey_images` VALUES (1,1,'400',NULL,0.00,0,0,0,1,1,0,0,2,0,0,0.00,0,0,0.00,0.00,1,'30.2002945','71.4479778','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.200228709.png',NULL,NULL,NULL,0,'QTB',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,1,'200',NULL,0.00,5,5,5,1,1,2,2,1,0,0,0.00,2,2,2.17,2.17,1,'30.2002945','71.4479778','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.5059108.png',NULL,NULL,NULL,4.694444444444444,'LEFT',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,'r','1',NULL),(3,1,'200',NULL,0.00,5,5,5,1,1,2,2,1,0,0,0.00,2,2,2.17,2.17,1,'30.2002945','71.4479778','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.847641934.png',NULL,NULL,NULL,4.694444444444444,'FRONT',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,'r','1',NULL),(4,1,'200',NULL,0.00,5,5,5,1,1,2,2,1,0,0,0.00,2,2,2.17,2.17,1,'30.2002945','71.4479778','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.958930347.png',NULL,NULL,NULL,4.694444444444444,'RIGHT',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,'r','1',NULL),(5,1,'400',NULL,0.00,0,0,0,1,1,0,0,2,0,0,0.00,0,0,0.00,0.00,1,'30.2002945','71.4479778','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.2102187724.png',NULL,NULL,NULL,0,'QTB',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,2,'400',NULL,0.00,0,0,0,1,1,0,0,2,0,0,0.00,0,0,0.00,0.00,1,'30.2002945','71.4479778','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.1522721626.png',NULL,NULL,NULL,0,'QTB',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,3,'400',NULL,0.00,0,0,0,1,1,0,0,2,0,0,0.00,0,0,0.00,0.00,1,'30.2002945','71.4479778','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.1584901631.png',NULL,NULL,NULL,0,'QTB',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,4,'400',NULL,0.00,0,0,0,1,1,0,0,2,0,0,0.00,0,0,0.00,0.00,1,'30.2002945','71.4479778','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.61326743.png',NULL,NULL,NULL,0,'QTB',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,5,'400',NULL,0.00,0,0,0,1,1,0,0,2,0,0,0.00,0,0,0.00,0.00,1,'30.2002945','71.4479778','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.414570439.png',NULL,NULL,NULL,0,'QTB',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,6,'400',NULL,0.00,0,0,0,1,1,0,0,2,0,0,0.00,0,0,0.00,0.00,1,'30.2002945','71.4479778','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.833763899.png',NULL,NULL,NULL,0,'QTB',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,7,'400',NULL,0.00,0,0,0,1,1,0,0,2,0,0,0.00,0,0,0.00,0.00,1,'30.2003085','71.4479579','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.59334193.png',NULL,NULL,NULL,0,'QTB',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,8,'400',NULL,0.00,0,0,0,1,1,0,0,2,0,0,0.00,0,0,0.00,0.00,1,'30.2003085','71.4479579','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.1736998926.png',NULL,NULL,NULL,0,'QTB',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,9,'400',NULL,0.00,0,0,0,1,1,0,0,2,0,0,0.00,0,0,0.00,0.00,1,'30.2003085','71.4479579','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.118585363.png',NULL,NULL,NULL,0,'QTB',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,10,'400',NULL,0.00,0,0,0,1,1,0,0,2,0,0,0.00,0,0,0.00,0.00,1,'30.2003085','71.4479579','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.1491259303.png',NULL,NULL,NULL,0,'QTB',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,11,'400',NULL,0.00,0,0,0,1,1,0,0,2,0,0,0.00,0,0,0.00,0.00,1,'30.2003085','71.4479579','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.1705624711.png',NULL,NULL,NULL,0,'QTB',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,12,'400',NULL,0.00,0,0,0,1,1,0,0,2,0,0,0.00,0,0,0.00,0.00,1,'30.2003085','71.4479579','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.1308239005.png',NULL,NULL,NULL,0,'QTB',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(17,13,'400',NULL,0.00,0,0,0,1,1,0,0,2,0,0,0.00,0,0,0.00,0.00,1,'30.2003085','71.4479579','30?12\'1\" N','71?26\'53\" E','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','http://www.pos.jadeedmunshi.com/storage/app/public/before_image//Before_Image.1574775590.png',NULL,NULL,NULL,0,'QTB',NULL,NULL,'SQFT','Pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `finead_survey_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_survey_work_area`
--

DROP TABLE IF EXISTS `finead_survey_work_area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_survey_work_area` (
  `swa_id` int(255) NOT NULL AUTO_INCREMENT,
  `swa_company_id` int(11) DEFAULT NULL,
  `swa_project_id` int(255) DEFAULT NULL,
  `swa_remarks` varchar(4000) DEFAULT NULL,
  `swa_day_end_id` int(11) NOT NULL,
  `swa_day_end_date` date NOT NULL,
  `swa_user_id` int(11) NOT NULL,
  `swa_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `swa_ip_adrs` varchar(255) DEFAULT NULL,
  `swa_brwsr_info` varchar(4000) DEFAULT NULL,
  `swa_delete_status` tinyint(4) NOT NULL DEFAULT 0,
  `swa_deleted_by` int(11) DEFAULT NULL,
  `swa_disabled` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`swa_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_survey_work_area`
--

LOCK TABLES `finead_survey_work_area` WRITE;
/*!40000 ALTER TABLE `finead_survey_work_area` DISABLE KEYS */;
INSERT INTO `finead_survey_work_area` VALUES (1,1,NULL,'',1,'2021-09-29',1,'2021-11-10 12:14:37','124.29.212.138','Desktop Device \nChrome browser | Version:- 95.0.4638.69',0,NULL,0);
/*!40000 ALTER TABLE `finead_survey_work_area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_survey_work_area_item`
--

DROP TABLE IF EXISTS `finead_survey_work_area_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_survey_work_area_item` (
  `swai_id` int(255) NOT NULL AUTO_INCREMENT,
  `swai_swa_id` int(255) DEFAULT NULL,
  `swai_company_id` int(255) DEFAULT NULL,
  `swai_region_id` int(255) DEFAULT NULL,
  `swai_zone_id` int(255) DEFAULT NULL,
  `swai_city_id` int(255) DEFAULT NULL,
  `swai_grid_id` int(255) DEFAULT NULL,
  `swai_franchise_id` int(255) DEFAULT NULL,
  `swai_surveyor_username` int(255) DEFAULT NULL,
  `swai_supervisor_id` int(255) DEFAULT NULL,
  `swai_start_date` date DEFAULT NULL,
  `swai_end_date` date DEFAULT NULL,
  `swai_surveyor_type` varchar(200) DEFAULT NULL,
  `swai_surveyor_id` int(11) DEFAULT NULL,
  `swai_pro_code` varchar(500) DEFAULT NULL,
  `swai_pro_name` varchar(500) DEFAULT NULL,
  `swai_service_id` int(11) DEFAULT NULL,
  `swai_service_name` varchar(500) DEFAULT NULL,
  `swai_qty` decimal(50,3) DEFAULT NULL,
  `swai_rate` decimal(50,2) DEFAULT NULL,
  `swai_amount` decimal(50,2) DEFAULT NULL,
  `swai_username_id` int(11) DEFAULT NULL,
  `swai_valid_for_days` int(11) DEFAULT NULL,
  PRIMARY KEY (`swai_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_survey_work_area_item`
--

LOCK TABLES `finead_survey_work_area_item` WRITE;
/*!40000 ALTER TABLE `finead_survey_work_area_item` DISABLE KEYS */;
INSERT INTO `finead_survey_work_area_item` VALUES (1,1,1,1,NULL,377,1,1,NULL,2,'2021-11-10','2021-11-18','vendor',210101,'200','Pepsi 1500 ML',1,'Shop Survey',6.000,1000.00,6000.00,1,10),(2,1,1,1,NULL,377,1,1,NULL,2,'2021-11-10','2021-11-18','vendor',210101,'400','Daal Chawal',1,'Shop Survey',6.000,1000.00,6000.00,1,10);
/*!40000 ALTER TABLE `finead_survey_work_area_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_surveyor_logs`
--

DROP TABLE IF EXISTS `finead_surveyor_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_surveyor_logs` (
  `srv_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `srv_log_srv_id` int(11) DEFAULT NULL,
  `srv_log_type` varchar(255) DEFAULT NULL,
  `srv_log_time` datetime DEFAULT NULL,
  `srv_log_issue_by` varchar(255) DEFAULT NULL,
  `srv_log_supervisor_name` varchar(255) DEFAULT NULL,
  `srv_log_work_start_time` datetime DEFAULT NULL,
  `srv_log_work_end_time` datetime DEFAULT NULL,
  `srv_log_created_by` varchar(255) DEFAULT NULL,
  `srv_log_created_at` datetime DEFAULT current_timestamp(),
  `srv_log_updated_at` datetime DEFAULT NULL,
  `srv_log_brwsr_info` varchar(255) DEFAULT NULL,
  `srv_log_ip_adrs` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`srv_log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_surveyor_logs`
--

LOCK TABLES `finead_surveyor_logs` WRITE;
/*!40000 ALTER TABLE `finead_surveyor_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_surveyor_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_surveyor_users`
--

DROP TABLE IF EXISTS `finead_surveyor_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_surveyor_users` (
  `srv_id` int(11) NOT NULL AUTO_INCREMENT,
  `srv_name` varchar(255) DEFAULT NULL,
  `srv_password` varchar(500) DEFAULT NULL,
  `srv_password_orignal` varchar(500) DEFAULT NULL,
  `srv_disabled` int(11) DEFAULT 0,
  `srv_login_status` int(11) DEFAULT 0,
  `srv_assign_status` varchar(10) DEFAULT 'unassign',
  `srv_created_by` varchar(255) DEFAULT NULL,
  `srv_created_at` datetime DEFAULT current_timestamp(),
  `srv_updated_at` datetime DEFAULT NULL,
  `srv_brwsr_info` varchar(255) DEFAULT NULL,
  `srv_ip_adrs` varchar(255) DEFAULT NULL,
  `srv_android_status` varchar(50) NOT NULL DEFAULT 'offline',
  `srv_ios_status` varchar(50) NOT NULL DEFAULT 'offline',
  `srv_delete_status` int(11) NOT NULL DEFAULT 1,
  `srv_profilepic` varchar(500) NOT NULL,
  PRIMARY KEY (`srv_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_surveyor_users`
--

LOCK TABLES `finead_surveyor_users` WRITE;
/*!40000 ALTER TABLE `finead_surveyor_users` DISABLE KEYS */;
INSERT INTO `finead_surveyor_users` VALUES (1,'ali','$2y$10$JCsEolpXZZX7JaEKX2UqYezEngwTMgqGOdJ9IrWT2f6e3vFgdP4qa','12345678',1,0,'assign','1','2021-11-10 17:11:19',NULL,NULL,NULL,'offline','offline',1,'');
/*!40000 ALTER TABLE `finead_surveyor_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_surveys`
--

DROP TABLE IF EXISTS `finead_surveys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_surveys` (
  `sr_id` int(11) NOT NULL AUTO_INCREMENT,
  `sr_order_list_id` int(11) DEFAULT NULL,
  `sr_franchise_id` int(11) DEFAULT NULL,
  `sr_shop_code` varchar(500) DEFAULT NULL,
  `sr_shop_name` varchar(1000) DEFAULT NULL,
  `sr_alternate_shop_name` varchar(500) DEFAULT NULL,
  `sr_shop_keeper_name` varchar(500) DEFAULT NULL,
  `sr_address` text DEFAULT NULL,
  `sr_address2` text DEFAULT NULL,
  `sr_contact` varchar(20) DEFAULT NULL,
  `sr_contact2` varchar(20) DEFAULT NULL,
  `sr_shop_sqft` decimal(50,2) DEFAULT 0.00,
  `sr_front_left_right_height_feet` int(11) DEFAULT NULL,
  `sr_front_left_right_height_Inch` int(11) DEFAULT NULL,
  `sr_front_left_right_quantity` int(11) DEFAULT NULL,
  `sr_front_left_right_type` varchar(50) DEFAULT NULL,
  `sr_status` varchar(50) DEFAULT '0',
  `sr_day_end_id` int(11) DEFAULT NULL,
  `sr_day_end_date` date DEFAULT NULL,
  `sr_user_id` int(11) DEFAULT NULL,
  `sr_datetime` timestamp NULL DEFAULT NULL,
  `sr_ip_adrs` varchar(100) DEFAULT NULL,
  `sr_brwsr_info` varchar(4000) DEFAULT NULL,
  `sr_delete_status` tinyint(4) DEFAULT NULL,
  `sr_deleted_by` int(11) NOT NULL,
  `sr_disabled` tinyint(4) NOT NULL,
  `sr_created_by` int(11) DEFAULT NULL,
  `sr_created_at` datetime DEFAULT NULL,
  `sr_updated_by` int(11) DEFAULT NULL,
  `sr_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`sr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_surveys`
--

LOCK TABLES `finead_surveys` WRITE;
/*!40000 ALTER TABLE `finead_surveys` DISABLE KEYS */;
INSERT INTO `finead_surveys` VALUES (1,1,1,'gdhhd','Ali K/S multan','no name','Shop name','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan','bbd','03212121212',NULL,0.00,NULL,NULL,NULL,NULL,'0',1,'2021-09-29',NULL,NULL,NULL,NULL,NULL,0,0,1,'2021-11-10 17:43:57',NULL,NULL),(2,1,1,'shdh','gshhdd','sgdhd','dvdh','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan',NULL,'03212121215',NULL,0.00,NULL,NULL,NULL,NULL,'0',1,'2021-09-29',NULL,NULL,NULL,NULL,NULL,0,0,1,'2021-11-10 17:50:29',NULL,NULL),(3,1,1,'shdh','hdhdhd','vshd','dhdh','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan',NULL,'03212121215',NULL,0.00,NULL,NULL,NULL,NULL,'0',1,'2021-09-29',NULL,NULL,NULL,NULL,NULL,0,0,1,'2021-11-10 17:52:40',NULL,NULL),(4,1,1,'vxbdh','gshdhhd','dhhdhd','dbhdhd','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan',NULL,'03212121215',NULL,0.00,NULL,NULL,NULL,NULL,'0',1,'2021-09-29',NULL,NULL,NULL,NULL,NULL,0,0,1,'2021-11-10 17:54:50',NULL,NULL),(5,1,1,'shhd','hdhhdhd','hshdg','dgdghd','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan',NULL,'03212121215',NULL,0.00,NULL,NULL,NULL,NULL,'0',1,'2021-09-29',NULL,NULL,NULL,NULL,NULL,0,0,1,'2021-11-10 17:59:42',NULL,NULL),(6,1,1,'gsggsg','ahhhd','ggsgs','fggggtd','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan',NULL,'03212125875',NULL,0.00,NULL,NULL,NULL,NULL,'0',1,'2021-09-29',NULL,NULL,NULL,NULL,NULL,0,0,1,'2021-11-10 18:06:23',NULL,NULL),(7,1,1,'sggsg','vshhdhd','sggs','svghshd','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan',NULL,'03212121845',NULL,0.00,NULL,NULL,NULL,NULL,'0',1,'2021-09-29',NULL,NULL,NULL,NULL,NULL,0,0,1,'2021-11-10 18:26:36',NULL,NULL),(8,1,1,'sggsg','vshhdhd','sggs','svghshd','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan',NULL,'03212121845',NULL,0.00,NULL,NULL,NULL,NULL,'0',1,'2021-09-29',NULL,NULL,NULL,NULL,NULL,0,0,1,'2021-11-10 18:27:39',NULL,NULL),(9,1,1,'sggsg','vshhdhd','sggs','svghshd','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan',NULL,'03212121845',NULL,0.00,NULL,NULL,NULL,NULL,'0',1,'2021-09-29',NULL,NULL,NULL,NULL,NULL,0,0,1,'2021-11-10 18:28:03',NULL,NULL),(10,1,1,'sggsg','vshhdhd','sggs','svghshd','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan',NULL,'03212121845',NULL,0.00,NULL,NULL,NULL,NULL,'0',1,'2021-09-29',NULL,NULL,NULL,NULL,NULL,0,0,1,'2021-11-10 18:28:47',NULL,NULL),(11,1,1,'sggsg','vshhdhd','sggs','svghshd','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan',NULL,'03212121845',NULL,0.00,NULL,NULL,NULL,NULL,'0',1,'2021-09-29',NULL,NULL,NULL,NULL,NULL,0,0,1,'2021-11-10 18:30:40',NULL,NULL),(12,1,1,'sggsg','vshhdhd','sggs','svghshd','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan',NULL,'03212121845',NULL,0.00,NULL,NULL,NULL,NULL,'0',1,'2021-09-29',NULL,NULL,NULL,NULL,NULL,0,0,1,'2021-11-10 18:30:49',NULL,NULL),(13,1,1,'sggsg','vshhdhd','sggs','svghshd','6C2X+52V, Lalazar Colony Multan, Punjab, Pakistan',NULL,'03212121845',NULL,0.00,NULL,NULL,NULL,NULL,'0',1,'2021-09-29',NULL,NULL,NULL,NULL,NULL,0,0,1,'2021-11-10 18:31:41',NULL,NULL);
/*!40000 ALTER TABLE `finead_surveys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_third_party_budgeted_raw_stock`
--

DROP TABLE IF EXISTS `finead_third_party_budgeted_raw_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_third_party_budgeted_raw_stock` (
  `btprs_id` int(11) NOT NULL AUTO_INCREMENT,
  `btprs_odr_id` int(11) DEFAULT NULL,
  `btprs_pro_code` varchar(500) DEFAULT NULL,
  `btprs_pro_name` varchar(500) DEFAULT NULL,
  `btprs_required_production_qty` decimal(50,3) DEFAULT NULL,
  `btprs_height` decimal(50,3) DEFAULT NULL,
  `btprs_length` decimal(50,3) DEFAULT NULL,
  PRIMARY KEY (`btprs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_third_party_budgeted_raw_stock`
--

LOCK TABLES `finead_third_party_budgeted_raw_stock` WRITE;
/*!40000 ALTER TABLE `finead_third_party_budgeted_raw_stock` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_third_party_budgeted_raw_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_third_party_production_over_head`
--

DROP TABLE IF EXISTS `finead_third_party_production_over_head`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_third_party_production_over_head` (
  `poh_id` int(11) NOT NULL AUTO_INCREMENT,
  `poh_odr_id` int(11) NOT NULL,
  `poh_warehouse` varchar(1000) NOT NULL,
  `poh_department` int(11) DEFAULT NULL,
  `poh_parties_clients` int(11) DEFAULT NULL,
  `poh_supervisor` int(11) NOT NULL,
  `poh_remarks` text DEFAULT 'NULL',
  PRIMARY KEY (`poh_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_third_party_production_over_head`
--

LOCK TABLES `finead_third_party_production_over_head` WRITE;
/*!40000 ALTER TABLE `finead_third_party_production_over_head` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_third_party_production_over_head` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_third_party_production_over_head_items`
--

DROP TABLE IF EXISTS `finead_third_party_production_over_head_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_third_party_production_over_head_items` (
  `pohi_id` int(11) NOT NULL AUTO_INCREMENT,
  `pohi_poh_id` int(11) NOT NULL,
  `pohi_ser_code` int(11) NOT NULL,
  `pohi_ser_name` varchar(1000) NOT NULL,
  `pohi_ser_remarks` text DEFAULT 'NULL',
  `pohi_expense_account` int(11) NOT NULL,
  `pohi_rate` decimal(50,2) NOT NULL,
  `pohi_qty` decimal(50,2) NOT NULL,
  `pohi_uom` varchar(1000) NOT NULL,
  `pohi_amount` decimal(50,2) NOT NULL,
  PRIMARY KEY (`pohi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_third_party_production_over_head_items`
--

LOCK TABLES `finead_third_party_production_over_head_items` WRITE;
/*!40000 ALTER TABLE `finead_third_party_production_over_head_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_third_party_production_over_head_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_third_party_work_order`
--

DROP TABLE IF EXISTS `finead_third_party_work_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_third_party_work_order` (
  `odr_id` int(11) NOT NULL AUTO_INCREMENT,
  `odr_batch_id` varchar(255) DEFAULT NULL,
  `odr_batch_name` varchar(500) DEFAULT NULL,
  `odr_qty` decimal(50,0) DEFAULT NULL,
  `odr_uom` varchar(500) DEFAULT NULL,
  `odr_estimated_start_time` datetime NOT NULL,
  `odr_estimated_end_time` datetime NOT NULL,
  `odr_warehouse_select` varchar(255) DEFAULT NULL,
  `odr_production_overhead_total` decimal(50,0) DEFAULT 0,
  `odr_production_raw_stock_costing_total` decimal(50,0) DEFAULT NULL,
  `odr_total_amount` decimal(50,0) DEFAULT NULL,
  `odr_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `odr_day_end_id` int(11) NOT NULL,
  `odr_day_end_date` date NOT NULL,
  `odr_createdby` int(11) NOT NULL,
  `odr_ip_adrs` varchar(500) NOT NULL,
  `odr_brwsr_info` varchar(4000) NOT NULL,
  `odr_update_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `odr_delete_status` int(11) NOT NULL,
  `odr_deleted_by` int(11) NOT NULL,
  `odr_disabled` int(11) NOT NULL,
  `odr_product_rate_type` varchar(100) DEFAULT NULL,
  `order_project_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`odr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_third_party_work_order`
--

LOCK TABLES `finead_third_party_work_order` WRITE;
/*!40000 ALTER TABLE `finead_third_party_work_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_third_party_work_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finead_work_order`
--

DROP TABLE IF EXISTS `finead_work_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finead_work_order` (
  `odr_id` int(11) NOT NULL AUTO_INCREMENT,
  `odr_recipe_id` varchar(255) DEFAULT NULL,
  `odr_recipe_name` varchar(500) NOT NULL,
  `odr_qty` decimal(50,0) DEFAULT NULL,
  `odr_uom` varchar(500) DEFAULT NULL,
  `odr_estimated_start_time` datetime NOT NULL,
  `odr_estimated_end_time` datetime NOT NULL,
  `odr_warehouse_select` varchar(255) DEFAULT NULL,
  `odr_production_overhead_total` decimal(50,0) DEFAULT 0,
  `odr_production_raw_stock_costing_total` decimal(50,0) DEFAULT NULL,
  `odr_total_amount` decimal(50,0) DEFAULT NULL,
  `odr_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `odr_day_end_id` int(11) NOT NULL,
  `odr_day_end_date` date NOT NULL,
  `odr_createdby` int(11) NOT NULL,
  `odr_ip_adrs` varchar(500) NOT NULL,
  `odr_brwsr_info` varchar(4000) NOT NULL,
  `odr_update_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `odr_delete_status` int(11) NOT NULL,
  `odr_deleted_by` int(11) NOT NULL,
  `odr_disabled` int(11) NOT NULL,
  `odr_product_rate_type` varchar(100) DEFAULT NULL,
  `order_project_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`odr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finead_work_order`
--

LOCK TABLES `finead_work_order` WRITE;
/*!40000 ALTER TABLE `finead_work_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `finead_work_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `franchise_areas`
--

DROP TABLE IF EXISTS `franchise_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `franchise_areas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) unsigned DEFAULT NULL,
  `region_id` bigint(20) unsigned DEFAULT NULL,
  `zone_id` bigint(20) unsigned DEFAULT NULL,
  `city_id` bigint(20) unsigned DEFAULT NULL,
  `grid_id` bigint(20) unsigned DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bdoName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bdoContact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `moName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `moContact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usedBy` int(10) unsigned NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `franchise_areas`
--

LOCK TABLES `franchise_areas` WRITE;
/*!40000 ALTER TABLE `franchise_areas` DISABLE KEYS */;
INSERT INTO `franchise_areas` VALUES (1,110131,1,1,377,1,'123','f1','f1',NULL,NULL,NULL,NULL,NULL,0,'Active',1,NULL,NULL,'2021-11-10 07:26:18','2021-11-10 07:26:18');
/*!40000 ALTER TABLE `franchise_areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grids`
--

DROP TABLE IF EXISTS `grids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grids` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) unsigned DEFAULT NULL,
  `region_id` bigint(20) unsigned DEFAULT NULL,
  `zone_id` bigint(20) unsigned DEFAULT NULL,
  `city_id` bigint(20) unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `manager` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usedBy` int(10) unsigned NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grids`
--

LOCK TABLES `grids` WRITE;
/*!40000 ALTER TABLE `grids` DISABLE KEYS */;
INSERT INTO `grids` VALUES (1,110131,1,1,377,'g1','g1',NULL,NULL,NULL,1,'Active',1,NULL,NULL,'2021-11-10 07:25:27','2021-11-10 07:26:18');
/*!40000 ALTER TABLE `grids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pso_gain_loss`
--

DROP TABLE IF EXISTS `pso_gain_loss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pso_gain_loss` (
  `pgl_id` int(11) NOT NULL AUTO_INCREMENT,
  `pgl_product_code` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `pgl_product_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `pgl_opening_inventory` double NOT NULL,
  `pgl_purchase` double NOT NULL,
  `pgl_sale` double NOT NULL,
  `pgl_ending_inventory` double NOT NULL,
  `pgl_tank_inventory` double NOT NULL,
  `pgl_gain_loss` double NOT NULL,
  `pgl_day_end_id` int(11) NOT NULL,
  `pgl_day_end_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pgl_created_by` int(11) NOT NULL,
  PRIMARY KEY (`pgl_id`),
  UNIQUE KEY `pso_gain_loss_pgl_id_uindex` (`pgl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pso_gain_loss`
--

LOCK TABLES `pso_gain_loss` WRITE;
/*!40000 ALTER TABLE `pso_gain_loss` DISABLE KEYS */;
/*!40000 ALTER TABLE `pso_gain_loss` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regions`
--

DROP TABLE IF EXISTS `regions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `usedBy` int(10) unsigned NOT NULL DEFAULT 0,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regions`
--

LOCK TABLES `regions` WRITE;
/*!40000 ALTER TABLE `regions` DISABLE KEYS */;
INSERT INTO `regions` VALUES (1,110131,'center','center',NULL,4,'Active',1,NULL,NULL,'2021-11-10 07:24:15','2021-11-10 07:26:18');
/*!40000 ALTER TABLE `regions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zones`
--

DROP TABLE IF EXISTS `zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) unsigned DEFAULT NULL,
  `region_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL DEFAULT '1',
  `zonal_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `zonal_contact` varchar(15) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `usedBy` int(10) unsigned NOT NULL DEFAULT 0,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zones`
--

LOCK TABLES `zones` WRITE;
/*!40000 ALTER TABLE `zones` DISABLE KEYS */;
INSERT INTO `zones` VALUES (1,110131,1,'c1',NULL,NULL,'c1',NULL,3,'Active',1,NULL,NULL,'2021-11-10 07:24:35','2021-11-10 07:26:18');
/*!40000 ALTER TABLE `zones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-10 18:35:13
