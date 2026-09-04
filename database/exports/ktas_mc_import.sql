-- Clean import for shared hosting (ktas_mc)
-- Import this file INTO database ktas_mc in phpMyAdmin
-- (select ktas_mc first, then Import — do NOT create design_services_db)
-- Generated from local design_services_db

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: 127.0.0.1    Database: design_services_db
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('designpro-cache-page_settings','a:25:{s:9:\"site_name\";s:9:\"DesignPro\";s:7:\"tagline\";s:32:\"We design. We build. We deliver.\";s:16:\"site_description\";s:111:\"DesignPro is a full-service design and development agency crafting beautiful, high-performing digital products.\";s:4:\"logo\";s:0:\"\";s:7:\"favicon\";s:0:\"\";s:5:\"email\";s:27:\"hello@designpro.example.com\";s:5:\"phone\";s:17:\"+1 (555) 012-3456\";s:7:\"address\";s:56:\"123 Innovation Drive, Suite 400, San Francisco, CA 94107\";s:9:\"map_embed\";s:267:\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0193276899328!2d-122.41941648467913!3d37.77492977975965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085809c6c8f4459%3A0xb10ed6d9b5050fa5!2sTwitter%20HQ!5e0!3m2!1sen!2sus!4v1581234567890!5m2!1sen!2sus\";s:8:\"facebook\";s:30:\"https://facebook.com/designpro\";s:9:\"instagram\";s:31:\"https://instagram.com/designpro\";s:8:\"linkedin\";s:38:\"https://linkedin.com/company/designpro\";s:7:\"twitter\";s:29:\"https://twitter.com/designpro\";s:6:\"github\";s:28:\"https://github.com/designpro\";s:10:\"meta_title\";s:61:\"Mediacreative — Design & Web Application Development Agency\";s:16:\"meta_description\";s:153:\"We craft beautiful websites and powerful web applications. UI/UX design, web development, mobile apps, and e-commerce solutions for ambitious businesses.\";s:8:\"keywords\";s:87:\"web design, UI UX design, web development, mobile apps, e-commerce, Laravel development\";s:8:\"og_image\";s:0:\"\";s:12:\"hero_heading\";s:54:\"We Design & Build Digital Products That Make an Impact\";s:15:\"hero_subheading\";s:152:\"DesignPro is a full-service agency specializing in UI/UX design, web application development, and digital solutions that help ambitious businesses grow.\";s:10:\"hero_image\";s:0:\"\";s:8:\"cta_text\";s:18:\"Start Your Project\";s:8:\"cta_link\";s:8:\"/contact\";s:9:\"copyright\";s:43:\"© 2026 Mediacreative. All rights reserved.\";s:11:\"quick_links\";s:102:\"{\"Services\":\"/services\",\"Portfolio\":\"/portfolio\",\"About\":\"/about\",\"Blog\":\"/blog\",\"Contact\":\"/contact\"}\";}',1788504621);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` (`id`, `name`, `logo`, `website`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,'TechNova',NULL,'https://technova.io',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(2,'GreenLeaf',NULL,'https://greenleaf.com',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(3,'Acme Corp',NULL,'https://acmecorp.com',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(4,'Northwind',NULL,'https://northwind.com',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(5,'Cloud9',NULL,'https://cloud9.tech',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(6,'Visionary',NULL,'https://visionary.co',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(7,'DataFlow',NULL,'https://dataflow.dev',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(8,'BrightPath',NULL,'https://brightpath.org',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `service_id` bigint(20) unsigned DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','replied') NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_messages_service_id_foreign` (`service_id`),
  KEY `contact_messages_status_created_at_index` (`status`,`created_at`),
  CONSTRAINT `contact_messages_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `subject`, `service_id`, `message`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,'Jane Cooper','jane.cooper@example.com','+1 (555) 111-2222','Website redesign inquiry',2,'Hi there! We\'re looking to redesign our corporate website. We need something modern, faster, and more conversion-focused. Could you share your process and timeline?','read','2026-09-03 19:22:56','2026-09-03 21:36:06',NULL),(2,'Robert Chen','robert.chen@example.com','+1 (555) 333-4444','SaaS platform development',3,'I have a SaaS idea and need help building a minimum viable product. Looking for a dev team that can also help with UI/UX design. What would an MVP cost?','new','2026-09-02 19:22:56','2026-09-03 19:22:56',NULL),(3,'Michael Torres','michael.torres@example.com','+1 (555) 555-6666','Mobile app consultation',4,'We need a cross-platform mobile app for our delivery service. We\'d like to understand your experience with React Native and what kind of app you\'ve shipped.','read','2026-09-01 19:22:56','2026-09-03 19:22:56',NULL),(4,'Sarah Mitchell','sarah.mitchell@example.com','+1 (555) 777-8888','E-commerce store migration',5,'We currently run on Shopify but want to migrate to a custom solution for more control. Our store has about 2,000 products. Can you help?','read','2026-08-31 19:22:56','2026-09-03 19:22:56',NULL),(5,'David Johnson','david.johnson@example.com','+1 (555) 999-0000','UI/UX audit request',1,'Could you perform a usability audit of our current web app? We have high bounce rates and want to understand where users are dropping off.','replied','2026-08-30 19:22:56','2026-09-03 19:22:56',NULL),(6,'Laura Bennett','laura.bennett@example.com','+1 (555) 222-3333','Ongoing maintenance package',6,'We need ongoing support for our Laravel application. What does your monthly maintenance package include?','new','2026-08-29 19:22:56','2026-09-03 19:22:56',NULL),(7,'John Miller','john.miller@example.com','+1 (555) 444-5555','Startup website',2,'We\'re launching a startup and need a great landing page + brochure site. We want something that makes us look bigger and more credible.','new','2026-08-28 19:22:56','2026-09-03 19:22:56',NULL),(8,'Grace Park','grace.park@example.com','+1 (555) 666-7777','Admin dashboard development',3,'We need an internal admin panel to manage our data. Would be used by about 50 internal users. Looking for a timeline and rough estimate.','read','2026-08-27 19:22:56','2026-09-03 19:22:56',NULL),(9,'Kevin Nguyen','kevin.nguyen@example.com','+1 (555) 888-9999','iOS app for fitness brand',4,'Hello! We have a fitness brand and need an iOS app to complement our wearable devices. Looking for a partner who can handle design and development.','new','2026-08-26 19:22:56','2026-09-03 19:22:56',NULL),(10,'Anna Rodriguez','anna.rodriguez@example.com','+1 (555) 000-1111','Portfolio site for design work',2,'Hi, I\'m a freelance designer and need a portfolio website to showcase my work. Looking for something very visual and unique.','replied','2026-08-25 19:22:56','2026-09-03 19:22:56',NULL);
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_09_04_100001_create_services_table',1),(5,'2026_09_04_100002_create_clients_table',1),(6,'2026_09_04_100003_create_projects_table',1),(7,'2026_09_04_100004_create_testimonials_table',1),(8,'2026_09_04_100005_create_team_members_table',1),(9,'2026_09_04_100006_create_contact_messages_table',1),(10,'2026_09_04_100007_create_page_settings_table',1),(11,'2026_09_04_100008_create_pages_table',1),(12,'2026_09_04_100009_create_posts_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_settings`
--

DROP TABLE IF EXISTS `page_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_settings_key_unique` (`key`),
  KEY `page_settings_group_index` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_settings`
--

LOCK TABLES `page_settings` WRITE;
/*!40000 ALTER TABLE `page_settings` DISABLE KEYS */;
INSERT INTO `page_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES (1,'site_name','DesignPro','general','2026-09-03 19:22:56','2026-09-03 19:22:56'),(2,'tagline','We design. We build. We deliver.','general','2026-09-03 19:22:56','2026-09-03 19:22:56'),(3,'site_description','DesignPro is a full-service design and development agency crafting beautiful, high-performing digital products.','general','2026-09-03 19:22:56','2026-09-03 19:22:56'),(4,'logo','','general','2026-09-03 19:22:56','2026-09-03 19:22:56'),(5,'favicon','','general','2026-09-03 19:22:56','2026-09-03 19:22:56'),(6,'email','hello@designpro.example.com','contact','2026-09-03 19:22:56','2026-09-03 19:22:56'),(7,'phone','+1 (555) 012-3456','contact','2026-09-03 19:22:56','2026-09-03 19:22:56'),(8,'address','123 Innovation Drive, Suite 400, San Francisco, CA 94107','contact','2026-09-03 19:22:56','2026-09-03 19:22:56'),(9,'map_embed','https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0193276899328!2d-122.41941648467913!3d37.77492977975965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085809c6c8f4459%3A0xb10ed6d9b5050fa5!2sTwitter%20HQ!5e0!3m2!1sen!2sus!4v1581234567890!5m2!1sen!2sus','contact','2026-09-03 19:22:56','2026-09-03 19:22:56'),(10,'facebook','https://facebook.com/designpro','social','2026-09-03 19:22:56','2026-09-03 19:22:56'),(11,'instagram','https://instagram.com/designpro','social','2026-09-03 19:22:56','2026-09-03 19:22:56'),(12,'linkedin','https://linkedin.com/company/designpro','social','2026-09-03 19:22:56','2026-09-03 19:22:56'),(13,'twitter','https://twitter.com/designpro','social','2026-09-03 19:22:56','2026-09-03 19:22:56'),(14,'github','https://github.com/designpro','social','2026-09-03 19:22:56','2026-09-03 19:22:56'),(15,'meta_title','Mediacreative — Design & Web Application Development Agency','seo','2026-09-03 19:22:56','2026-09-03 21:50:21'),(16,'meta_description','We craft beautiful websites and powerful web applications. UI/UX design, web development, mobile apps, and e-commerce solutions for ambitious businesses.','seo','2026-09-03 19:22:56','2026-09-03 19:22:56'),(17,'keywords','web design, UI UX design, web development, mobile apps, e-commerce, Laravel development','seo','2026-09-03 19:22:56','2026-09-03 19:22:56'),(18,'og_image','','seo','2026-09-03 19:22:56','2026-09-03 19:22:56'),(19,'hero_heading','We Design & Build Digital Products That Make an Impact','home','2026-09-03 19:22:56','2026-09-03 19:22:56'),(20,'hero_subheading','DesignPro is a full-service agency specializing in UI/UX design, web application development, and digital solutions that help ambitious businesses grow.','home','2026-09-03 19:22:56','2026-09-03 19:22:56'),(21,'hero_image','','home','2026-09-03 19:22:56','2026-09-03 19:22:56'),(22,'cta_text','Start Your Project','home','2026-09-03 19:22:56','2026-09-03 19:22:56'),(23,'cta_link','/contact','home','2026-09-03 19:22:56','2026-09-03 19:22:56'),(24,'copyright','© 2026 Mediacreative. All rights reserved.','footer','2026-09-03 19:22:56','2026-09-03 21:40:01'),(25,'quick_links','{\"Services\":\"/services\",\"Portfolio\":\"/portfolio\",\"About\":\"/about\",\"Blog\":\"/blog\",\"Contact\":\"/contact\"}','footer','2026-09-03 19:22:56','2026-09-03 19:22:56');
/*!40000 ALTER TABLE `page_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,'About Us','about-us','<h2>Our Story</h2><p>Founded in 2015, DesignPro has grown from a two-person design studio into a full-service digital agency. We\'ve helped over 200 businesses launch, grow, and transform with great design and robust engineering.</p><h2>Our Approach</h2><p>We believe great digital products are the result of deep understanding, disciplined process, and relentless iteration. Every project starts with research and ends with measurable results.</p>','About DesignPro | Our Story & Team','Learn about DesignPro\'s journey, our team of designers and developers, and the process we follow to deliver exceptional digital products.',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(2,'Careers','careers','<h2>Join Our Team</h2><p>We\'re always looking for talented designers, developers, and project managers who are passionate about their craft. If that sounds like you, we\'d love to hear from you.</p><h3>Why Work With Us?</h3><ul><li>Remote-friendly culture</li><li>Competitive compensation</li><li>Real growth opportunities</li><li>Work on diverse interesting projects</li></ul>','Careers at DesignPro','Explore career opportunities at DesignPro, a growing digital design and development agency.',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(3,'Privacy Policy','privacy-policy','<h2>Privacy Policy</h2><p>This Privacy Policy describes how DesignPro collects, uses, and shares information in connection with our website and services.</p><h3>Information We Collect</h3><p>When you contact us through our website, we collect the information you provide, including your name, email address, and any message content.</p><h3>How We Use Information</h3><p>We use the information you provide to respond to your inquiries and, if you opt in, to send you updates about our services.</p>','Privacy Policy | DesignPro','Read DesignPro\'s privacy policy to understand how we collect and use your information.',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(4,'Terms of Service','terms-of-service','<h2>Terms of Service</h2><p>These Terms of Service govern your use of the DesignPro website and services. By using our services, you agree to these terms.</p><h3>Services</h3><p>We provide design, development, and consulting services as agreed upon in individual project scopes and contracts.</p>','Terms of Service | DesignPro','Review the terms and conditions governing the use of DesignPro\'s services.',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `excerpt` text DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_user_id_foreign` (`user_id`),
  KEY `posts_is_published_published_at_index` (`is_published`,`published_at`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `title`, `slug`, `cover_image`, `content`, `excerpt`, `is_published`, `published_at`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,'Top 10 Web Design Trends for 2026','top-10-web-design-trends-for-2026',NULL,'<p>The web design landscape is constantly evolving. As we move through 2026, several exciting trends are reshaping how we think about digital experiences.</p><h2>1. AI-Powered Personalization</h2><p>Websites are becoming smarter, adapting their content and layout to individual users in real-time. AI-driven design tools help us create experiences that feel personally tailored.</p><h2>2. Immersive 3D Elements</h2><p>With WebGL becoming more accessible, 3D design elements are no longer just for gaming sites. Subtle 3D touches can make a website feel more premium and engaging.</p><h2>3. Dark Mode by Default</h2><p>More users than ever prefer dark mode. Designing with both modes in mind from the start ensures a consistent brand experience.</p><h2>4. Voice User Interfaces</h2><p>Voice search and voice assistants are changing how users interact with websites. Designing for voice-first scenarios is becoming essential.</p><h2>Conclusion</h2><p>Great web design is about understanding your users and creating frictionless experiences. These trends are tools — the real magic happens when you pair them with a deep understanding of your audience.</p>','Explore the latest web design trends shaping digital experiences in 2026 — from AI personalization to immersive 3D elements.',1,'2026-08-14 19:22:56',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(2,'Laravel vs. Other PHP Frameworks: A 2026 Perspective','laravel-vs-other-php-frameworks-a-2026-perspective',NULL,'<p>PHP continues to power a significant portion of the web, and Laravel remains the most popular PHP framework. But how does it compare to the alternatives in 2026?</p><h2>Why Laravel Stands Out</h2><p>Laravel\'s elegant syntax, powerful ORM (Eloquent), and rich ecosystem — including Forge, Vapor, and Nova — make it an efficient choice for developers.</p><h2>The Alternatives</h2><p>Symfony offers robust architecture for enterprise projects. CodeIgniter is lightweight but limited. CakePHP provides a structured but less modern approach.</p><h2>Our Verdict</h2><p>For most web application projects, Laravel offers the best balance of developer experience, performance, and scalability. Its large community also means you\'ll rarely get stuck without answers.</p>','A detailed comparison of Laravel against other PHP frameworks, and why we choose it for most client projects.',1,'2026-08-16 19:22:56',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(3,'The Complete Guide to Mobile App UX','the-complete-guide-to-mobile-app-ux',NULL,'<p>Creating great mobile app experiences requires a different mindset than web design. Here\'s what we\'ve learned from building dozens of successful apps.</p><h2>Start With User Research</h2><p>Before you write a line of code, understand who your users are, what they need, and where the friction points exist. Personas and journey mapping are essential.</p><h2>Design for Thumbs</h2><p>Most users hold their phone in one hand and navigate with their thumb. Place key actions within the thumb\'s natural reach zone.</p><h2>Keep It Simple</h2><p>Mobile screens are small. Every element must earn its place. Prioritize content ruthlessly and use progressive disclosure to keep the interface clean.</p><h2>Test, Test, Test</h2><p>Usability testing with real users should happen at every stage — from paper prototypes to beta builds. Iteration is the key to mobile UX success.</p>','Learn the principles of mobile app UX design that make apps feel intuitive and delightful to use.',1,'2026-08-20 19:22:56',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(4,'How to Choose the Right Tech Stack for Your Startup','how-to-choose-the-right-tech-stack-for-your-startup',NULL,'<p>Choosing the right technology stack is one of the most important decisions you\'ll make as a founder. Get it wrong and you\'ll face costly rewrites. Get it right and you\'ll scale smoothly.</p><h2>Consider Your Domain</h2><p>Is your product content-heavy, transaction-heavy, or community-driven? Different domains favor different technologies.</p><h2>Think About Your Team</h2><p>The best tech stack is one your team actually knows. Hiring for a niche stack is harder and more expensive than building with something your team already masters.</p><h2>Prioritize Longevity</h2><p>Choose technologies with strong communities and long-term roadmaps. You don\'t want to build on a framework that\'s about to be deprecated.</p><h2>Our Recommendation</h2><p>For most startups, we recommend a pragmatic approach: Laravel (or Django) for the backend, a modern JS framework for the frontend, and PostgreSQL for data. It covers most use cases well.</p>','A practical framework for choosing a tech stack that your team can build with and scale without pain.',1,'2026-08-24 19:22:56',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(5,'Why Every Business Needs a Design System','why-every-business-needs-a-design-system',NULL,'<p>A design system is more than just a collection of colors and components. It\'s a single source of truth that keeps your product consistent across every touchpoint.</p><h2>What Is a Design System?</h2><p>It\'s a complete set of standards, components, and guidelines that define how your product looks and behaves. Think of it as a shared language between designers and developers.</p><h2>The Business Case</h2><p>Design systems reduce development time, ensure accessibility compliance, and create a more cohesive brand experience. Our clients report 30-40% faster feature development after implementing one.</p><h2>Getting Started</h2><p>Start small: document your color palette, typography, and a handful of core components. Build from there as your product evolves.</p>','How a well-maintained design system accelerates development and keeps your product consistent.',1,'2026-08-28 19:22:56',1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `client` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `gallery_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery_images`)),
  `description` text NOT NULL,
  `technologies` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`technologies`)),
  `url` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `services` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`services`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projects_slug_unique` (`slug`),
  KEY `projects_is_featured_status_category_index` (`is_featured`,`status`,`category`),
  KEY `projects_category_index` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`id`, `title`, `slug`, `category`, `client`, `thumbnail`, `gallery_images`, `description`, `technologies`, `url`, `is_featured`, `status`, `services`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,'Nexus CRM Platform','nexus-crm-platform','Web App','TechNova',NULL,NULL,'A comprehensive customer relationship management platform built for modern sales teams. Features include pipeline tracking, email automation, analytics dashboards, and team collaboration tools.','[\"Laravel\",\"Vue.js\",\"MySQL\",\"Redis\"]','https://nexus-crm.example.com',1,'published','[]','2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(2,'Bloom E-commerce Store','bloom-e-commerce-store','E-commerce','GreenLeaf',NULL,NULL,'A fully-featured online store for a skincare brand, with custom product configurators, subscription management, and seamless multi-currency checkout.','[\"Laravel\",\"Alpine.js\",\"Stripe\",\"PostgreSQL\"]','https://bloom.example.com',1,'published','[]','2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(3,'Pulse Fitness App','pulse-fitness-app','Mobile','Acme Corp',NULL,NULL,'A cross-platform fitness tracking app with workout plans, nutrition logging, wearable integration, and social features to keep users motivated.','[\"React Native\",\"Node.js\",\"MongoDB\"]','https://pulse.example.com',1,'published','[]','2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(4,'FinEdge Banking Dashboard','finedge-banking-dashboard','Web App','Northwind',NULL,NULL,'A secure financial dashboard with real-time transaction monitoring, fraud detection alerts, and comprehensive reporting for enterprise banking clients.','[\"React\",\"TypeScript\",\"Spring Boot\",\"PostgreSQL\"]','https://finedge.example.com',1,'published','[]','2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(5,'Insight Analytics Suite','insight-analytics-suite','Web App','DataFlow',NULL,NULL,'A powerful data analytics platform with drag-and-drop report builders, real-time dashboards, and AI-powered insights for business intelligence teams.','[\"Vue.js\",\"Laravel\",\"ClickHouse\",\"D3.js\"]','https://insight.example.com',0,'published','[]','2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(6,'TravelMate Booking Portal','travelmate-booking-portal','Website','Luxelite Tours',NULL,NULL,'A modern travel booking website with flight and hotel comparison, interactive maps, user reviews, and a loyalty rewards program.','[\"Laravel\",\"Tailwind CSS\",\"Redis\",\"Maps API\"]','https://travelmate.example.com',1,'published','[]','2026-09-03 19:22:56','2026-09-03 20:52:40',NULL),(7,'HealthCare App Redesign','healthcare-app-redesign','UI/UX','BrightPath',NULL,NULL,'Complete UX/UI redesign of a healthcare app, improving patient onboarding, appointment scheduling, and medication tracking while meeting strict accessibility standards.','[\"Figma\",\"Design Systems\",\"Usability Testing\"]',NULL,0,'published','[]','2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(8,'RetailPro POS System','retailpro-pos-system','Web App','Acme Corp',NULL,NULL,'A cloud-based point-of-sale system with inventory tracking, staff management, and multi-location support for growing retail businesses.','[\"Laravel\",\"Livewire\",\"MySQL\",\"Kubernetes\"]','https://retailpro.example.com',0,'published','[]','2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(9,'EduLearn e-Learning Platform','edulearn-e-learning-platform','Website','Visionary',NULL,NULL,'An interactive learning management system with video courses, quizzes, progress tracking, and community forums for students worldwide.','[\"Laravel\",\"Vue.js\",\"FFmpeg\",\"AWS S3\"]','https://edulearn.example.com',0,'published','[]','2026-09-03 19:22:56','2026-09-03 19:22:56',NULL);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `price_from` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_unique` (`slug`),
  KEY `services_is_active_sort_order_index` (`is_active`,`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` (`id`, `title`, `slug`, `description`, `icon`, `image`, `features`, `price_from`, `is_active`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,'UI/UX Design','uiux-design','We craft intuitive, user-centered interfaces that turn complex problems into delightful experiences. From wireframes to high-fidelity prototypes, our design process is driven by research, testing, and deep empathy for your users.','palette',NULL,'[\"User Research & Personas\",\"Wireframing & Prototyping\",\"Interaction Design\",\"Design Systems\",\"Usability Testing\",\"UI Animation\"]',1200.00,1,1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(2,'Web Design','web-design','Beautiful, responsive websites that reflect your brand and convert visitors into customers. Our designs are modern, accessible, and built to perform on every device.','monitor',NULL,'[\"Responsive Design\",\"Landing Page Design\",\"Corporate Websites\",\"Brand Identity Integration\",\"SEO-Friendly Layouts\",\"CMS-Ready Templates\"]',800.00,1,2,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(3,'Web Application Development','web-application-development','We build powerful, scalable web applications using modern technologies like Laravel, React, and Vue. From SaaS platforms to complex business tools, we deliver robust solutions tailored to your needs.','code',NULL,'[\"Custom Web Applications\",\"SaaS Platform Development\",\"RESTful API Design & Integration\",\"Admin Panels & Dashboards\",\"Payment Integration\",\"Performance Optimization\"]',5000.00,1,3,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(4,'Mobile App Development','mobile-app-development','From concept to App Store, we develop native and cross-platform mobile apps that deliver seamless experiences. iOS, Android, or both — we build apps your users will love.','smartphone',NULL,'[\"iOS & Android Development\",\"React Native \\/ Flutter\",\"Mobile UI\\/UX Design\",\"Push Notifications\",\"Offline Capabilities\",\"App Store Publishing\"]',8000.00,1,4,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(5,'E-commerce Solutions','e-commerce-solutions','We build conversion-focused online stores with seamless checkout, inventory management, and payment processing. Whether you are launching or scaling, we have the expertise.','shopping-cart',NULL,'[\"Store Setup & Configuration\",\"Payment Gateway Integration\",\"Order & Inventory Management\",\"Product Catalog Design\",\"Shipping Integration\",\"Analytics & Reporting\"]',3000.00,1,5,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(6,'Maintenance & Support','maintenance-support','Keep your digital products running smoothly with our ongoing maintenance, security updates, and dedicated support. We ensure your applications stay fast, secure, and up-to-date.','lifebuoy',NULL,'[\"Security & Performance Monitoring\",\"Bug Fixes & Hotfixes\",\"Feature Enhancements\",\"Backup & Disaster Recovery\",\"24\\/7 Support Availability\",\"Monthly Reports\"]',500.00,1,6,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL);
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('39AFRvaQKVYYui1Bl6W2arCk5T5sbyC3DDZjFIvQ',1,'127.0.0.1','Symfony','YTo0OntzOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NjoiX3Rva2VuIjtzOjQwOiJ2RzNWd096azZxVEdVSThzQ2QycGZlSjJkUVNvaDdmQXlBTXBwOW1DIjtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MjoiaHR0cDovL2xvY2FsaG9zdC9hZG1pbi90ZXN0aW1vbmlhbHMvMS9lZGl0IjtzOjU6InJvdXRlIjtzOjIzOiJhZG1pbi50ZXN0aW1vbmlhbHMuZWRpdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1788500166),('ajP4u91ZusIJNuWEjlJjF2CNb6ejLU8ksfhrfxqY',1,'127.0.0.1','Symfony','YTo0OntzOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NjoiX3Rva2VuIjtzOjQwOiJZY09IVVFEd0pxNk9VaXBpN1hrR1d4QlBEMEYyN2d4dE1vVEp0bkwwIjtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozNDoiaHR0cDovL2xvY2FsaG9zdC9hZG1pbi90ZWFtLzEvZWRpdCI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4udGVhbS5lZGl0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1788497989),('FmIDDkY3BGYTzzUfWKd4HcVk2EWxPKCl6aicBbh1',1,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNFAxbVZPWWhZdEYwUXV6QnlXUDlwNFRBaGkyd2lQMEhscjV1bjhUYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hYm91dCI7czo1OiJyb3V0ZSI7czo1OiJhYm91dCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1788501605),('Mtoi3GkWRJ6x22ePPhqcfzgkRiqhBww20xioMRqu',NULL,'127.0.0.1','curl/7.53.1','YToyOntzOjY6Il90b2tlbiI7czo0MDoiSTZCdXBPU003SmNnYVF3dUthc2t1bmhqcXVGUjFzdkpxYk5KN09QaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1788495763),('THC6rJlcywQLrnyMRyTq3qfNMJoDUtRtpQ2L5FBt',1,'127.0.0.1','Symfony','YTo0OntzOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NjoiX3Rva2VuIjtzOjQwOiJ5Nm5uTHI0dFoxUVdNMXpEZjU0YmtzMzhoalE2dVRNUnNpU1BaTHE5IjtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozNzoiaHR0cDovL2xvY2FsaG9zdC9hZG1pbi9jbGllbnRzLzMvZWRpdCI7czo1OiJyb3V0ZSI7czoxODoiYWRtaW4uY2xpZW50cy5lZGl0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1788498312),('tpkjjomgD0a46ehmLHZiSejHyS0lgn7rfrd8E709',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.135.0 Chrome/148.0.7778.280 Electron/42.8.1 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYzZIVjZWME1DZ3pHRnZvWkc0emwzRmhPV20xcThrQUpwMUhEVVZScyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1788495094),('WYFV6IMqWX2mdWytq19rrVnzlVD8s0BLOn7YTSZw',1,'127.0.0.1','Symfony','YTo0OntzOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NjoiX3Rva2VuIjtzOjQwOiJ2UEkxa3VpbWpKSnkwVlo0SXk5aG5ETm1GNjRhbGg3cE9SYnBQbm5BIjtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozODoiaHR0cDovL2xvY2FsaG9zdC9hZG1pbi9wcm9qZWN0cy82L2VkaXQiO3M6NToicm91dGUiO3M6MTk6ImFkbWluLnByb2plY3RzLmVkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1788497717);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_members`
--

LOCK TABLES `team_members` WRITE;
/*!40000 ALTER TABLE `team_members` DISABLE KEYS */;
INSERT INTO `team_members` (`id`, `name`, `position`, `photo`, `bio`, `social_links`, `sort_order`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,'Alex Morgan','Founder & Creative Director',NULL,'Alex founded the agency with a vision to bridge the gap between stunning design and robust engineering. With 15+ years in the industry, Alex leads our creative vision.','{\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/alexmorgan\",\"twitter\":\"https:\\/\\/twitter.com\\/alexmorgan\"}',1,1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(2,'Jordan Lee','Lead Full-Stack Developer',NULL,'Jordan is a veteran developer specializing in Laravel and modern JavaScript frameworks. He has delivered 50+ production applications and leads our engineering team.','{\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/jordanlee\",\"github\":\"https:\\/\\/github.com\\/jordanlee\"}',2,1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(3,'Priya Sharma','Senior UI/UX Designer',NULL,'Priya brings a user-first approach to every project. Her design systems have powered products used by millions. She specializes in complex enterprise applications.','{\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/priyasharma\",\"twitter\":\"https:\\/\\/twitter.com\\/priyadesigns\"}',3,1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(4,'Tom Williams','Project Manager',NULL,'Tom keeps our projects on track with his meticulous planning and clear communication. He ensures every deliverable exceeds client expectations.','{\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/tomwilliams\"}',4,1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL);
/*!40000 ALTER TABLE `team_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_name` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL DEFAULT 5,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` (`id`, `client_name`, `role`, `company`, `avatar`, `content`, `rating`, `is_active`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,'Sarah Chen','CEO','TechNova',NULL,'The team at this agency exceeded all our expectations. They delivered our CRM platform on time and on budget, and the quality of work is outstanding. Highly recommended!',5,1,1,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(2,'Michael Rodriguez','Marketing Director','GreenLeaf',NULL,'Our e-commerce site has never performed better. Conversion rates are up 40% since launch. The design is beautiful and the team was a pleasure to work with.',5,1,2,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(3,'Emily Davidson','Product Manager','Northwind',NULL,'From the initial wireframes to the final release, the communication was flawless. They truly understood our needs and delivered a banking dashboard our clients love.',5,1,3,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(4,'James O\'Brien','Founder','Cloud9',NULL,'Professional, creative, and technically brilliant. They built our travel platform from scratch and now we serve thousands of customers a month. Worth every penny.',5,1,4,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(5,'Maria Gonzalez','Operations Lead','BrightPath',NULL,'The redesign of our healthcare app was handled with incredible care. They respected accessibility requirements and our users have given it rave reviews.',4,1,5,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL),(6,'David Kim','CTO','DataFlow',NULL,'A rare agency that manages both design and development with equal skill. Their analytics platform handles millions of data points without breaking a sweat.',5,1,6,'2026-09-03 19:22:56','2026-09-03 19:22:56',NULL);
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','editor') NOT NULL DEFAULT 'editor',
  `avatar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `avatar`, `is_active`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES (1,'Super Admin','admin@example.com','2026-09-03 19:22:56','$2y$12$o/qiWMRYnkbKli4rz4cs2.V3anpmpBgJO4skbCXh4Oqp0CFTwgaFu','admin',NULL,1,NULL,NULL,'2026-09-03 19:22:56','2026-09-03 19:22:56'),(2,'Content Editor','editor@example.com','2026-09-03 19:22:56','$2y$12$WrDWp5bKEoRJ6a7Dv8AU0uDJXdMPfVu3UkY.DVfT4wj27dO/vYQrC','editor',NULL,1,NULL,NULL,'2026-09-03 19:22:56','2026-09-03 19:22:56');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-04 14:29:14

SET FOREIGN_KEY_CHECKS = 1;
