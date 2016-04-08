
--
-- Table structure for table `posman_search_terms`
--

DROP TABLE IF EXISTS `posman_search_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posman_search_terms` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `terms` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `results` text COLLATE latin1_general_ci,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `terms` (`terms`)
) ENGINE=MyISAM AUTO_INCREMENT=694 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `posman_urls`
--

DROP TABLE IF EXISTS `posman_urls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posman_urls` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) COLLATE latin1_general_ci DEFAULT NULL,
  `page_rank` int(11) DEFAULT NULL,
  `keyword_count` int(11) DEFAULT NULL,
  `backlink_count` int(11) DEFAULT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `url` (`url`)
) ENGINE=MyISAM AUTO_INCREMENT=606 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `posman_users`
--

DROP TABLE IF EXISTS `posman_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posman_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `last_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `uuid` varchar(36) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `posman_users_search`
--

DROP TABLE IF EXISTS `posman_users_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posman_users_search` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `position_name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `search_terms` text COLLATE latin1_general_ci,
  `your_domains` text COLLATE latin1_general_ci,
  `competitor_domains` text COLLATE latin1_general_ci,
  `email_notifications` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `position_name` (`position_name`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
