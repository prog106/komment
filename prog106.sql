-- MySQL dump 10.13  Distrib 5.6.27, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: prog106
-- ------------------------------------------------------
-- Server version	5.6.27-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer` (
  `ans_srl` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `que_srl` int(10) unsigned NOT NULL COMMENT '질문 pk',
  `mem_srl` int(11) NOT NULL COMMENT '회원 pk',
  `mem_name` varchar(100) NOT NULL COMMENT '등록자 명',
  `mem_level` varchar(10) NOT NULL DEFAULT 'normal' COMMENT '회원 레벨',
  `mem_picture` varchar(255) DEFAULT NULL COMMENT '사진',
  `answer` text NOT NULL COMMENT '답글',
  `hashtag` varchar(255) DEFAULT NULL COMMENT 'hashtag',
  `likes` int(11) NOT NULL COMMENT '좋아요 수',
  `create_at` datetime NOT NULL COMMENT '생성일시',
  `update_at` datetime DEFAULT NULL COMMENT '갱신일시 - 삭제할 경우 저장',
  `status` varchar(10) NOT NULL DEFAULT 'use' COMMENT '상태,  use, delete',
  PRIMARY KEY (`ans_srl`),
  KEY `que_index` (`que_srl`),
  KEY `mem_index` (`mem_srl`),
  FULLTEXT KEY `hashtag_index` (`hashtag`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COMMENT='답변';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer`
--

LOCK TABLES `answer` WRITE;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
INSERT INTO `answer` VALUES (1,1,7,'','manager',NULL,'2123',NULL,0,'2015-12-13 23:10:57',NULL,'use'),(6,2,7,'','manager',NULL,'12312',NULL,0,'2015-12-13 23:15:14',NULL,'use'),(8,2,7,'','manager',NULL,'12312',NULL,0,'2015-12-13 23:19:53',NULL,'use'),(9,2,7,'','manager',NULL,'12321',NULL,0,'2015-12-13 23:20:24',NULL,'use'),(10,2,7,'','manager',NULL,'123eeee',NULL,0,'2015-12-13 23:21:04',NULL,'use'),(11,2,7,'','manager',NULL,'123eeee',NULL,0,'2015-12-13 23:21:07',NULL,'use'),(12,2,7,'','manager',NULL,'43',NULL,0,'2015-12-13 23:21:13',NULL,'use'),(13,2,7,'','manager',NULL,'응답했다',NULL,0,'2015-12-13 23:22:31',NULL,'use'),(14,2,7,'','manager',NULL,'히히히',NULL,0,'2015-12-13 23:27:46',NULL,'use'),(15,30,7,'','manager',NULL,'나왔다 오바',NULL,1,'2015-12-13 23:29:29',NULL,'use'),(16,30,7,'','manager',NULL,'답해라 오빠',NULL,3,'2015-12-13 23:29:51','2015-12-17 00:28:20','delete'),(17,30,3,'이수권','normal',NULL,'야호',NULL,3,'2015-12-13 23:30:34','2015-12-16 19:16:15','delete'),(18,29,3,'이수권','normal',NULL,'아뇨... 없어요',NULL,1,'2015-12-14 00:46:20',NULL,'use'),(19,28,3,'이수권','normal',NULL,'보내줘보고 말해라',NULL,1,'2015-12-14 00:46:41',NULL,'use'),(20,28,3,'이수권','normal',NULL,'친구아이가',NULL,1,'2015-12-14 00:46:56',NULL,'use'),(21,30,3,'이수권','normal',NULL,'잘된다',NULL,0,'2015-12-14 00:53:50',NULL,'use'),(22,30,3,'이수권','normal',NULL,'zzzz',NULL,0,'2015-12-15 01:04:22','2015-12-16 19:17:55','delete'),(23,30,3,'이수권','normal',NULL,'adf',NULL,0,'2015-12-15 01:04:32','2015-12-16 19:18:19','delete'),(24,30,3,'이수권','normal',NULL,'aaa',NULL,0,'2015-12-15 23:30:34','2015-12-16 19:18:45','delete'),(25,30,3,'이수권','normal',NULL,'1asdffad',NULL,0,'2015-12-15 23:32:41','2015-12-16 19:20:20','delete'),(26,30,3,'이수권','normal',NULL,'1asdffad',NULL,0,'2015-12-15 23:32:42','2015-12-16 19:20:35','delete'),(27,30,3,'이수권','normal',NULL,'123',NULL,0,'2015-12-15 23:33:59',NULL,'use'),(28,30,3,'이수권','normal',NULL,'123',NULL,2,'2015-12-15 23:34:01','2015-12-16 19:15:57','delete'),(29,30,3,'이수권','normal',NULL,'adfafd',NULL,0,'2015-12-15 23:35:00','2015-12-16 19:20:41','delete'),(30,30,3,'이수권','normal',NULL,'메이데이',NULL,0,'2015-12-15 23:36:57',NULL,'use'),(31,30,3,'이수권','normal',NULL,'가나다라마바사아자차카타파하가나다라마바사아자차카타파하가나다라마바사아자차카타파하',NULL,2,'2015-12-15 23:53:02',NULL,'use'),(32,29,8,'','manager',NULL,'별로 없네요. ',NULL,2,'2015-12-16 00:07:44',NULL,'use'),(33,29,3,'이수권','normal',NULL,'사이트 어떤가요?',NULL,2,'2015-12-16 01:21:31','2015-12-30 15:57:35','delete'),(34,29,3,'이수권','normal',NULL,'ㅋㅋㅋㅋㅋ',NULL,1,'2015-12-16 01:23:02','2015-12-30 15:53:52','delete'),(35,29,3,'이수권','normal',NULL,'삭제 기능이 없네요. 어떻게 할까요',NULL,2,'2015-12-16 01:23:44',NULL,'use'),(36,30,10,'','normal',NULL,'응답',NULL,2,'2015-12-16 14:01:36',NULL,'use'),(37,30,10,'','manager',NULL,'ㅓㅓ어언너',NULL,0,'2015-12-16 14:11:35',NULL,'use'),(38,30,3,'','normal',NULL,'지우기',NULL,0,'2015-12-16 19:20:52','2015-12-16 19:20:56','delete'),(39,30,10,'','manager',NULL,'ㅎㅎ',NULL,0,'2015-12-16 19:46:07',NULL,'use'),(40,28,7,'','manager',NULL,'가고싶다',NULL,2,'2015-12-17 23:06:31',NULL,'use'),(41,45,7,'','manager',NULL,'잘되네요',NULL,0,'2015-12-18 15:11:44',NULL,'use'),(42,45,3,'','normal',NULL,'굿굿',NULL,0,'2015-12-18 15:13:42',NULL,'use'),(43,29,7,'','manager',NULL,'오후 반차',NULL,2,'2015-12-18 15:18:20',NULL,'use'),(44,55,7,'','manager',NULL,'한개네요. ㅠㅠ',NULL,0,'2015-12-20 01:13:01',NULL,'use'),(45,55,8,'','manager',NULL,'ㅇㅇ',NULL,0,'2015-12-20 03:01:25',NULL,'use'),(46,51,8,'','manager',NULL,'올 거 같음',NULL,0,'2015-12-20 23:24:05',NULL,'use'),(47,52,8,'','manager',NULL,'2016년에도 파이팅',NULL,0,'2015-12-21 14:27:14',NULL,'use'),(48,29,14,'','normal',NULL,'모임많아요 ㅠㅠ',NULL,1,'2015-12-24 19:50:17',NULL,'use'),(49,51,14,'','normal',NULL,'안온대용 ㅎㅎㅎ',NULL,0,'2015-12-24 19:52:40',NULL,'use'),(50,55,14,'','normal',NULL,'ㅠㅠ',NULL,0,'2015-12-24 19:52:50',NULL,'use'),(51,60,3,'','normal',NULL,'Good',NULL,0,'2015-12-25 00:27:54',NULL,'use'),(52,64,3,'','normal',NULL,'메리 크리스마스~',NULL,0,'2015-12-25 00:41:04',NULL,'use'),(53,64,8,'','manager',NULL,'메리 크리스마스 어제',NULL,0,'2015-12-26 05:02:17',NULL,'use'),(54,64,3,'이수권','normal',NULL,'즐거운 성탄절은 내년에다시',NULL,0,'2015-12-28 18:04:14',NULL,'use'),(55,51,3,'이수권','normal',NULL,'밤에 옴',NULL,0,'2015-12-28 18:05:48',NULL,'use'),(56,37,3,'이수권','normal',NULL,'Good!!',NULL,0,'2015-12-29 11:52:42',NULL,'use'),(57,55,3,'이수권','normal',NULL,'#한개 임','한개',0,'2015-12-30 12:50:06',NULL,'use'),(58,69,3,'이수권','normal',NULL,'#해시 잘됨','해시',0,'2015-12-30 14:39:55',NULL,'use'),(59,29,7,'지율이수권','manager','http://mud-kage.kakao.co.kr/14/dn/btqcxrrJ5Mi/LOp8GmpoKSobTzLo0KzTzK/o.jpg','#해시 잘될까요?','해시',0,'2015-12-30 18:50:17',NULL,'use'),(60,29,3,'','normal','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.9.50.50/p50x50/1379218_655568767816835_1688760699_n.jpg?oh=609dabd4332e4415868ad92347b3e3d5&oe=571FF961','#태그 넣어봄','태그',0,'2015-12-30 19:50:31',NULL,'use'),(61,71,3,'','normal','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.9.50.50/p50x50/1379218_655568767816835_1688760699_n.jpg?oh=609dabd4332e4415868ad92347b3e3d5&oe=571FF961','새해 복 많이 받으세요~ #새해 #2016','새해 2016',0,'2015-12-31 22:31:18',NULL,'use'),(62,73,3,'','normal','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.9.50.50/p50x50/1379218_655568767816835_1688760699_n.jpg?oh=609dabd4332e4415868ad92347b3e3d5&oe=571FF961','2015년에 너무 수고했고, 2016년에도 화이팅하자! #화이팅','화이팅',0,'2016-01-03 01:12:20',NULL,'use'),(63,72,3,'','normal','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.9.50.50/p50x50/1379218_655568767816835_1688760699_n.jpg?oh=609dabd4332e4415868ad92347b3e3d5&oe=571FF961','가족 모두 무탈했으면 좋겠어요!',NULL,0,'2016-01-03 01:15:26',NULL,'use'),(64,72,3,'','normal','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.9.50.50/p50x50/1379218_655568767816835_1688760699_n.jpg?oh=609dabd4332e4415868ad92347b3e3d5&oe=571FF961','로또 1등좀 되었으면 ㅋㅋ',NULL,0,'2016-01-03 01:17:00',NULL,'use');
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_for_sign`
--

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `like_srl` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `que_srl` int(10) unsigned NOT NULL COMMENT '질문 PK',
  `mem_srl` int(11) NOT NULL COMMENT '회원 PK',
  `likes` varchar(10) DEFAULT 'like' COMMENT 'like, dontlike ',
  `create_at` datetime NOT NULL COMMENT '생성일시',
  `update_at` datetime DEFAULT NULL COMMENT '최종 갱신일시',
  `status` varchar(10) NOT NULL DEFAULT 'use' COMMENT 'use delete',
  PRIMARY KEY (`like_srl`),
  KEY `que_index` (`que_srl`),
  KEY `mem_index` (`mem_srl`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='좋아요';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (25,30,3,'like','2015-12-15 01:01:21','2015-12-16 14:09:54','use'),(26,29,3,'dontlike','2015-12-15 01:01:25','2015-12-30 16:23:45','use'),(27,28,3,'dontlike','2015-12-15 01:01:26','2015-12-15 01:57:41','use'),(28,29,8,'dontlike','2015-12-16 00:07:07','2015-12-16 00:07:11','use'),(29,30,8,'like','2015-12-16 13:49:34','2015-12-21 14:26:45','use'),(30,30,10,'like','2015-12-16 14:00:51','2015-12-16 14:10:49','use'),(31,29,10,'like','2015-12-16 14:10:50',NULL,'use'),(32,28,10,'like','2015-12-16 14:10:50',NULL,'use'),(33,30,7,'like','2015-12-17 00:28:38','2015-12-18 15:00:26','use'),(34,45,7,'dontlike','2015-12-17 17:34:43','2015-12-17 17:34:45','use'),(35,45,3,'dontlike','2015-12-17 17:53:25','2015-12-18 15:13:56','use'),(36,28,7,'like','2015-12-17 23:06:39','2015-12-18 15:31:28','use'),(37,44,7,'dontlike','2015-12-18 15:00:24','2015-12-18 15:00:25','use'),(38,55,8,'like','2015-12-20 03:01:10','2015-12-21 14:26:46','use'),(39,51,8,'like','2015-12-21 14:26:47',NULL,'use'),(40,30,12,'dontlike','2015-12-21 21:43:30','2015-12-21 21:43:31','use'),(41,28,12,'like','2015-12-21 21:43:33','2015-12-21 21:43:35','use'),(42,29,12,'dontlike','2015-12-21 23:34:03','2015-12-21 23:34:09','use'),(43,51,12,'like','2015-12-23 01:07:37',NULL,'use'),(44,55,12,'like','2015-12-23 01:07:41',NULL,'use'),(45,60,3,'like','2015-12-24 18:07:58',NULL,'use'),(46,52,3,'like','2015-12-24 19:18:23',NULL,'use'),(47,29,14,'like','2015-12-24 19:50:35',NULL,'use'),(48,64,3,'like','2015-12-25 00:41:07','2015-12-30 15:50:16','use'),(49,37,3,'like','2015-12-29 11:52:59',NULL,'use'),(50,67,3,'like','2015-12-30 16:00:49','2015-12-30 16:01:09','use'),(51,71,3,'like','2015-12-31 23:21:00',NULL,'use'),(52,73,3,'like','2016-01-03 01:12:31',NULL,'use');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes_answer`
--

DROP TABLE IF EXISTS `likes_answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes_answer` (
  `like_ans_srl` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `ans_srl` int(10) unsigned NOT NULL COMMENT '질문 PK',
  `mem_srl` int(11) NOT NULL COMMENT '회원 PK',
  `likes` varchar(10) DEFAULT 'like' COMMENT 'like, dontlike ',
  `create_at` datetime NOT NULL COMMENT '생성일시',
  `update_at` datetime DEFAULT NULL COMMENT '최종 갱신일시',
  `status` varchar(10) NOT NULL DEFAULT 'use' COMMENT 'use delete',
  PRIMARY KEY (`like_ans_srl`),
  KEY `ans_index` (`ans_srl`),
  KEY `mem_index` (`mem_srl`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='댓글 좋아요';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes_answer`
--

LOCK TABLES `likes_answer` WRITE;
/*!40000 ALTER TABLE `likes_answer` DISABLE KEYS */;
INSERT INTO `likes_answer` VALUES (1,16,3,'like','2015-12-16 00:32:26','2015-12-16 14:09:48','use'),(2,15,3,'dontlike','2015-12-16 01:07:18','2015-12-16 01:08:32','use'),(3,17,3,'like','2015-12-16 01:08:35','2015-12-16 14:09:48','use'),(4,31,3,'like','2015-12-16 01:08:41','2015-12-16 14:09:47','use'),(5,28,3,'like','2015-12-16 01:08:42','2015-12-16 14:09:47','use'),(6,18,3,'dontlike','2015-12-16 01:22:07','2015-12-16 01:22:07','use'),(7,32,3,'like','2015-12-16 01:22:09','2015-12-30 15:52:34','use'),(8,33,3,'like','2015-12-16 01:22:12','2015-12-16 01:22:12','use'),(9,35,3,'like','2015-12-16 01:23:47',NULL,'use'),(10,28,8,'like','2015-12-16 09:39:03',NULL,'use'),(11,17,8,'like','2015-12-16 09:39:04',NULL,'use'),(12,16,8,'like','2015-12-16 09:39:05','2015-12-16 13:49:04','use'),(13,31,8,'like','2015-12-16 09:39:07','2015-12-17 09:56:43','use'),(14,15,8,'like','2015-12-16 09:39:07',NULL,'use'),(15,16,10,'like','2015-12-16 14:10:55',NULL,'use'),(16,17,10,'like','2015-12-16 14:10:55','2015-12-16 14:10:57','use'),(17,28,10,'dontlike','2015-12-16 14:10:58','2015-12-16 14:11:00','use'),(18,36,10,'like','2015-12-16 14:11:04',NULL,'use'),(19,36,8,'like','2015-12-17 09:56:44',NULL,'use'),(20,19,7,'dontlike','2015-12-17 23:06:43','2015-12-17 23:06:52','use'),(21,20,7,'dontlike','2015-12-17 23:06:44','2015-12-17 23:06:45','use'),(22,40,7,'like','2015-12-17 23:06:46',NULL,'use'),(23,41,3,'dontlike','2015-12-18 15:13:52','2015-12-18 15:13:57','use'),(24,42,3,'dontlike','2015-12-18 15:13:54','2015-12-18 15:13:59','use'),(25,40,12,'like','2015-12-21 21:43:38','2015-12-21 23:34:37','use'),(26,19,12,'like','2015-12-21 21:43:43',NULL,'use'),(27,20,12,'like','2015-12-21 23:34:35',NULL,'use'),(28,43,14,'like','2015-12-24 19:50:29',NULL,'use'),(29,34,14,'like','2015-12-24 19:50:30',NULL,'use'),(30,18,14,'like','2015-12-24 19:50:31',NULL,'use'),(31,35,14,'like','2015-12-24 19:50:32',NULL,'use'),(32,33,14,'like','2015-12-24 19:50:33',NULL,'use'),(33,32,14,'like','2015-12-24 19:50:34',NULL,'use'),(34,53,3,'dontlike','2015-12-29 13:19:57','2015-12-30 15:52:39','use'),(35,43,3,'like','2015-12-30 15:52:52','2015-12-30 15:53:18','use'),(36,48,3,'like','2015-12-30 15:53:23','2015-12-30 15:53:27','use');
/*!40000 ALTER TABLE `likes_answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `mem_srl` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mem_type` varchar(10) NOT NULL DEFAULT 'facebook' COMMENT '가입 타입',
  `efs_srl` varchar(50) NOT NULL COMMENT 'email_for_sign 코드, Facebook id, kakao id',
  `mem_email1` varchar(255) NOT NULL COMMENT '이메일 @ 앞자리 - 암호화 저장 : md5',
  `mem_email2` varchar(100) NOT NULL COMMENT '이메일 @ 뒷자리',
  `mem_email` varchar(255) NOT NULL COMMENT '이메일 전체 암호화 : encrypt',
  `mem_name` varchar(100) NOT NULL COMMENT '이름',
  `mem_pwd` varchar(255) NOT NULL COMMENT '비밀번호',
  `mem_picture` varchar(255) DEFAULT NULL COMMENT '사진, 필수는 아님. 절대 경로 들어가야됨',
  `create_datetime` datetime NOT NULL COMMENT '가입일시',
  `status` varchar(10) NOT NULL DEFAULT 'normal' COMMENT '정상회원 : normal, 보류회원 : hold, 탈퇴회원 : out, 매니저 : manager',
  PRIMARY KEY (`mem_srl`),
  UNIQUE KEY `efs_type_unique` (`mem_type`,`efs_srl`),
  UNIQUE KEY `mem_unique` (`mem_email1`,`mem_email2`),
  UNIQUE KEY `name_unique` (`mem_name`),
  KEY `mem_index` (`mem_email1`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='회원정보';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (3,'facebook','1073522632688111','facebook1073522632688111','facebook','5747aaafe9da5bbc6f8ef24b8a87ed6d1c4d34cb448d51ca942e7076de3b0ab7236e461c1975f2cc4598100ba9d84e86da086cacfafe7b0faa81546ac40a1ba9t4SmcGTHaKpHhKOC6a5I91NiDyBaMj6kP2gsJm4fET10d0CkHrVz0pW+BcQ2KFkr','이수권','facebook','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.9.50.50/p50x50/1379218_655568767816835_1688760699_n.jpg?oh=609dabd4332e4415868ad92347b3e3d5&oe=571FF961','2015-12-09 19:26:36','normal'),(7,'kakao','73565999','kakao73565999','kakao','09bf347da0767d0f9daa205003d20733f18c025ff03418118a724285e057147bbba3b667af331674ce655246fa0e9e1e1f1206d886f8b6d32e598ab0bc524c79kJanlzJpVulSRluBZ33ydyhzho1dRKG97Ei0A9SFbJ4=','지율이수권','kakao','http://mud-kage.kakao.co.kr/14/dn/btqcxrrJ5Mi/LOp8GmpoKSobTzLo0KzTzK/o.jpg','2015-12-09 22:34:02','manager'),(8,'kakao','73909926','kakao73909926','kakao','64ef4a91cc1c37f6dfeb2388a9d6868747b66b7effd71ea48740218f0ccc79425f3840b715bbe509a0b4fa26f243fb66b6d5338e5ed4e115df0a2bd5b6ca8b6fKWp4wO1le7fgNdvbzlJdag7JdU52JJjeYODwtiTFhCg=','Sohyon Ju','kakao','http://mud-kage.kakao.co.kr/14/dn/btqcyAovat8/2iLcaYk8QEFr2J6PC6FDPk/o.jpg','2015-12-10 21:42:24','manager'),(9,'kakao','75293970','kakao75293970','kakao','0d1b6d6b21be1905d11b4baeffb5d2e7e22f0478e9f43983e8edbfd78f139949298d99721d1e0405109db13bcdac25ff4acb2155a60617c594660d8e7f9cdfa626grJgS7kfu+bNhDD6RgOqB1OBqbfjzIoiow/tz8sAw=','김혜령','kakao',NULL,'2015-12-15 12:20:48','normal'),(10,'facebook','575347839280143','facebook575347839280143','facebook','62c5ab9b3f9e7d354e69fa00686205c8273ee16eb838c631053a459ec023ae2d8929b5bce30fb93ac6d55b4b4c3a0194ff373e26328d93dd4deca8eaa958b85b/03fhraZFzhy3N8Ct25Rj9gjnERXuLZPZdrUHE3HFkQy64ssOihS2OBx116twc0u','이강훈','facebook','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.2.50.50/p50x50/10468549_346824118799184_4976298505881516827_n.jpg?oh=204d66c1cc629f37d8856cb02740f793&oe=5712C851','2015-12-16 13:31:23','manager'),(11,'facebook','922562857831113','facebook922562857831113','facebook','4e3c111d09a305581b6d7ce046ba6cc3f6ed68f8259905edb0decec3358eb56c16bf856914d69c412b1991e1ec9ed59803057d71eb7d17b1fd143b6773b6eab1EcuFlj+QFkuDQdq4nkI9jvKYAIegKA8rY1wA3aRGezcx4GvxyITk+aacZ5AHbH2a','Hye Ryung Kim','facebook',NULL,'2015-12-16 16:05:26','normal'),(12,'facebook','10201165100646844','facebook10201165100646844','facebook','8272d4a8c97ab3f867b22ec7429b92eb9fbe22511d4385005cdfb6d36a4a93ebd380d4180e5b4bf90c9b89d67ed8505b2c0764ef24985a03b0d6de8276c0fb13MErtjKJTIPewQZYm3TrypBPNDCoPUYtVw8hnD2WsnvDml6nmW9WfKzwQtOunKmCU','작은나무','facebook','https://scontent.xx.fbcdn.net/hprofile-xpa1/v/t1.0-1/c28.28.345.345/s50x50/252200_2621077343424_332918214_n.jpg?oh=5b32a239b587b66ec35805d92605720a&oe=56D5AC78','2015-12-17 09:55:47','normal'),(14,'facebook','991843884208799','facebook991843884208799','facebook','57fffdf1bcf11683cde0ba74eed855dc58176014f61928fde910055fe79d64738a7f74987fc87a77a23e0fb14471074423f877b8e0af4067ceb9f89f18754737SZIwrnD0mdKIsC0dQceZ2lw+osTjDrZ8cZxNPlg33wQuhKzQBq+VFxDaVJ9KYS/V','Serendip','facebook','https://scontent.xx.fbcdn.net/hprofile-xpa1/v/t1.0-1/p50x50/12294725_978970495496138_2003703318621350603_n.jpg?oh=796b5eb43718260c2287ccee25eb7c32&oe=5713AD34','2015-12-24 19:49:49','normal'),(15,'kakao','77426996','kakao77426996','kakao','cbb90f84bca041ed97ae29800f1b203b8efb307ff2bd4979eee5a72a786a913a66b238f69dfd2b4c7350a9694f3390c6e475c5df78bdc36199daaf5aefb8844aLyLPR2YGezKCG9CCVhClg2J10fpmoHrebWI5gDT81ln+BcPnF5FFdOCJBpTr3iYW','김예준','kakao','http://mud-kage.kakao.co.kr/14/dn/btqcByRO4Uf/x44rLmJUb1iB41l7hYkKW0/o.jpg','2015-12-24 19:54:07','normal');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `que_srl` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `mem_srl` int(10) unsigned NOT NULL COMMENT '회원 PK',
  `mem_name` varchar(100) NOT NULL COMMENT '등록 당시 회원 이름',
  `mem_level` varchar(10) NOT NULL DEFAULT 'normal' COMMENT '등록자 당시 레벨',
  `mem_picture` varchar(255) DEFAULT NULL COMMENT '등록 당시 사진',
  `question` text NOT NULL COMMENT '질문',
  `hashtag` varchar(255) DEFAULT NULL,
  `respond` int(11) NOT NULL DEFAULT '0' COMMENT '댓글 수',
  `likes` int(11) NOT NULL DEFAULT '0' COMMENT '좋아요 수',
  `start` date NOT NULL COMMENT '질문 노출 시작일',
  `main_start` datetime DEFAULT NULL COMMENT '메인 노출 시작일시',
  `main_end` datetime DEFAULT NULL COMMENT '메인 노출 종료 일시',
  `create_at` datetime NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'use' COMMENT 'use / delete',
  PRIMARY KEY (`que_srl`),
  KEY `mem_index` (`mem_srl`),
  KEY `level_index` (`mem_level`),
  FULLTEXT KEY `hash_index` (`hashtag`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (1,7,'지율이수권','normal',NULL,'123',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 18:36:09','use'),(2,7,'지율이수권','normal',NULL,'123123',NULL,7,0,'0000-00-00',NULL,NULL,'2015-12-08 18:37:01','use'),(3,7,'지율이수권','normal',NULL,'123',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 18:44:31','use'),(4,7,'지율이수권','normal',NULL,'123',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 18:44:34','use'),(5,7,'지율이수권','normal',NULL,'123',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 18:45:20','use'),(6,7,'지율이수권','normal',NULL,'fasfd',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 18:58:54','use'),(7,7,'지율이수권','normal',NULL,'13213',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 19:01:35','use'),(8,7,'지율이수권','normal',NULL,'13213',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 19:01:42','use'),(9,7,'지율이수권','normal',NULL,'13213',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 19:01:47','use'),(10,7,'지율이수권','normal',NULL,'agagsd',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 19:02:08','use'),(11,7,'지율이수권','normal',NULL,'123213',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 19:03:20','use'),(12,7,'지율이수권','normal',NULL,'123213',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 19:03:21','use'),(13,7,'지율이수권','normal',NULL,'123213',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 19:03:46','use'),(14,7,'지율이수권','normal',NULL,'12321313231232121',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 19:04:32','use'),(15,7,'지율이수권','normal',NULL,'444',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 19:06:43','use'),(16,7,'지율이수권','normal',NULL,'444',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 19:06:53','use'),(17,7,'지율이수권','normal',NULL,'궁금해요',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 22:16:48','use'),(18,7,'지율이수권','normal',NULL,'ㅋㅋㅋ',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 22:16:58','use'),(19,7,'지율이수권','normal',NULL,'궁금한게 있어요 알려주세요',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 22:17:34','use'),(20,7,'지율이수권','normal',NULL,'질문은 여기에만 올려주세요. 오늘 뭘 먹을까요??',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-08 23:30:05','use'),(21,7,'지율이수권','normal',NULL,'뭐해요?',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-09 19:36:33','use'),(22,7,'지율이수권','normal',NULL,'나는 전생에 나라를 구했을까요? 아니면 다른걸 구했을까요?',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-09 23:17:12','use'),(23,7,'지율이수권','normal',NULL,'내가 오늘 로또에 당첨된다면 몇등??\r\n1등?\r\n2등?\r\n꽝??',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-09 23:22:09','use'),(24,7,'지율이수권','normal',NULL,'한글과 english 와 !@#$%#%^#&*(((){}:\"\">?<,./.\\|\\``~ 특수문자',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-09 23:23:58','use'),(25,7,'지율이수권','normal',NULL,'ㅁㅇㄹㅁㄴㅇㄹㄴㅁㄹㅁㄴㄹㅁㄴㄹㄴㅇㄹㄴㄹㄴㄹㅇㄹㄴㅇㄹㄴㄹㄴㅇㄹㄴㅇㄹㅇㄴㄹㄴㄹㄹㄴㄹㄴㅇㄹㄴㄹㄴㄹㄴㅇㄹㄹㅇㄴㄹㅇ',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-09 23:24:49','use'),(26,7,'지율이수권','normal',NULL,'이번주 로또 번호좀 알려주세요\r\n\r\n\r\n',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-09 23:29:47','use'),(27,3,'이수권','normal',NULL,'1년후에 난 무엇을 하고 있을까요?',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-10 00:19:55','delete'),(28,8,'Sohyon Ju','manager',NULL,'니가 가라 하와이',NULL,7,21,'0000-00-00','2015-12-10 00:00:00','2015-12-31 23:59:59','2015-12-10 21:42:46','use'),(29,7,'지율이수권','manager',NULL,'연말 모임은 많나요??',NULL,41,70,'0000-00-00','2015-12-10 00:00:00','2015-12-31 23:59:59','2015-12-10 22:56:38','use'),(30,7,'지율이수권','manager',NULL,'나와라 오바',NULL,10,9,'0000-00-00','2015-12-11 11:00:00','2015-12-31 23:59:59','2015-12-10 22:57:36','use'),(31,7,'지율이수권','manager',NULL,'이거 올려봄',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-11 00:17:40','use'),(32,8,'Sohyon Ju','manager',NULL,'수권님 뭐해요?',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-15 10:29:15','use'),(33,10,'이강훈','manager',NULL,'ㅋㅋㅋ',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-16 14:09:25','use'),(34,10,'이강훈','manager',NULL,'ㅇㅇㅇ',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-16 14:09:58','use'),(35,10,'이강훈','manager',NULL,'게시판테러',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-16 14:10:13','use'),(36,10,'이강훈','manager',NULL,'  ',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-16 14:11:59','use'),(37,10,'이강훈','manager',NULL,'⊂_ヽ\r\n　 ＼＼ Λ＿Λ \r\n　　 ＼( ‘ㅅ\' )\r\n　　　 >　⌒ヽ\r\n　　　/ 　 へ＼\r\n　　 /　　/　＼＼ \r\n　　 ﾚ　ノ　　 ヽ_つ\r\n　　/　/\r\n　 /　/|\r\n　(　(ヽ\r\n　|　|、＼\r\n　| 丿 ＼ ⌒)\r\n　| |　　) /\r\n`ノ )　　Lﾉ ⊂_ヽ',NULL,1,1,'0000-00-00',NULL,NULL,'2015-12-16 14:13:59','use'),(38,7,'지율이수권','manager',NULL,'  ',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-17 01:08:06','use'),(39,7,'지율이수권','manager',NULL,'a',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-17 01:10:02','use'),(40,7,'지율이수권','manager',NULL,'게시판 테러 차단함 ㅋㅋㅋ\r\n줄바꿈 안먹나?',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-17 01:10:26','use'),(41,7,'지율이수권','manager',NULL,'123123',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-17 16:36:34','use'),(42,7,'지율이수권','manager',NULL,'궁금해요',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-17 16:45:18','use'),(43,7,'지율이수권','manager',NULL,'aaa',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-17 16:48:41','use'),(44,7,'지율이수권','manager',NULL,'1231',NULL,0,0,'0000-00-00','2015-12-17 00:00:00','2015-12-18 23:59:59','2015-12-17 16:49:44','use'),(45,7,'지율이수권','manager',NULL,'메인 노출 될까요?',NULL,2,0,'2015-12-18','2015-12-17 00:00:00','2015-12-19 23:59:59','2015-12-17 16:52:01','delete'),(46,7,'지율이수권','manager',NULL,'오늘은 오후 반차',NULL,0,0,'2015-12-18','2015-12-18 00:00:00','2015-12-18 23:59:59','2015-12-18 16:33:43','use'),(47,7,'지율이수권','manager',NULL,'구글캠퍼스에 무선인터넷 놓아줄수 없나요?',NULL,0,0,'2015-12-18','2015-12-18 00:00:00','2015-12-18 23:59:59','2015-12-18 17:24:13','use'),(48,7,'지율이수권','manager','http://mud-kage.kakao.co.kr/14/dn/btqcxrrJ5Mi/LOp8GmpoKSobTzLo0KzTzK/o.jpg','구글캠퍼스에 무선인터넷 놓아줄수 없나요?',NULL,0,0,'2015-12-18','2015-12-18 00:00:00','2015-12-18 23:59:59','2015-12-18 17:25:03','use'),(49,7,'지율이수권','manager','http://mud-kage.kakao.co.kr/14/dn/btqcxrrJ5Mi/LOp8GmpoKSobTzLo0KzTzK/o.jpg','두번 올라갔다.',NULL,0,0,'2015-12-18',NULL,NULL,'2015-12-18 17:26:19','use'),(50,7,'지율이수권','manager','http://mud-kage.kakao.co.kr/14/dn/btqcxrrJ5Mi/LOp8GmpoKSobTzLo0KzTzK/o.jpg','이름이 안올라갔다',NULL,0,0,'2015-12-18',NULL,NULL,'2015-12-18 17:28:18','use'),(51,7,'지율이수권','manager','http://mud-kage.kakao.co.kr/14/dn/btqcxrrJ5Mi/LOp8GmpoKSobTzLo0KzTzK/o.jpg','이번 크리스마스에는 눈이 올까요??',NULL,3,2,'2015-12-21','2015-12-21 00:00:00','2015-12-26 00:00:00','2015-12-19 23:04:44','use'),(52,7,'지율이수권','manager','http://mud-kage.kakao.co.kr/14/dn/btqcxrrJ5Mi/LOp8GmpoKSobTzLo0KzTzK/o.jpg','2015년을 열심히 보낸 나에게 칭찬해 보아요!!',NULL,1,1,'2015-12-19','2015-12-19 00:00:00','2016-01-01 23:59:59','2015-12-19 23:05:57','use'),(53,3,'이수권','normal','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.9.50.50/p50x50/1379218_655568767816835_1688760699_n.jpg?oh=609dabd4332e4415868ad92347b3e3d5&oe=571FF961','무한도전!!',NULL,0,0,'2015-12-20',NULL,NULL,'2015-12-20 00:45:00','use'),(54,3,'이수권','normal','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.9.50.50/p50x50/1379218_655568767816835_1688760699_n.jpg?oh=609dabd4332e4415868ad92347b3e3d5&oe=571FF961','일요일은 짜파게티 요리사!',NULL,0,0,'2015-12-20',NULL,NULL,'2015-12-20 00:46:59','use'),(55,7,'지율이수권','manager','http://mud-kage.kakao.co.kr/14/dn/btqcxrrJ5Mi/LOp8GmpoKSobTzLo0KzTzK/o.jpg','관리자도 하루 한개 입니까??',NULL,4,2,'2015-12-20','2015-12-20 00:00:00','2015-12-31 23:59:59','2015-12-20 01:12:33','use'),(56,12,'Sohyon Ju','normal','https://scontent.xx.fbcdn.net/hprofile-xpa1/v/t1.0-1/c28.28.345.345/s50x50/252200_2621077343424_332918214_n.jpg?oh=5b32a239b587b66ec35805d92605720a&oe=56D5AC78','수고했어요. :)',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-21 19:40:38','use'),(57,12,'Sohyon Ju','normal','https://scontent.xx.fbcdn.net/hprofile-xpa1/v/t1.0-1/c28.28.345.345/s50x50/252200_2621077343424_332918214_n.jpg?oh=5b32a239b587b66ec35805d92605720a&oe=56D5AC78','ㅎㅎ','abc 해 달',0,0,'0000-00-00',NULL,NULL,'2015-12-21 21:45:08','use'),(58,3,'이수권','normal','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.9.50.50/p50x50/1379218_655568767816835_1688760699_n.jpg?oh=609dabd4332e4415868ad92347b3e3d5&oe=571FF961','&lt;iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/kfvxmEuC7bU\" frameborder=\"0\" allowfullscreen&gt;&lt;/iframe>','ab 해시 달',0,0,'0000-00-00',NULL,NULL,'2015-12-21 22:47:05','use'),(59,12,'Sohyon Ju','normal','https://scontent.xx.fbcdn.net/hprofile-xpa1/v/t1.0-1/c28.28.345.345/s50x50/252200_2621077343424_332918214_n.jpg?oh=5b32a239b587b66ec35805d92605720a&oe=56D5AC78','연인 가족을 위한 크리스마스 선물로 어떤 것을 준비하셨나요?',NULL,0,0,'0000-00-00',NULL,NULL,'2015-12-22 12:03:01','use'),(60,8,'Sohyon Ju','manager','http://mud-kage.kakao.co.kr/14/dn/btqcyAovat8/2iLcaYk8QEFr2J6PC6FDPk/o.jpg','질문을 올려 놓으면 하루 이후 등록된 메일로 답변내용과 링크 전달\r\n나와 취향이 비슷한 사람들로부터 답변을 받는 서비스','해시_태그 달아봄 a abcde abcd',1,1,'2015-12-23','2015-12-23 00:00:00','2015-12-24 00:00:00','2015-12-23 14:29:30','use'),(61,3,'이수권','normal','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.9.50.50/p50x50/1379218_655568767816835_1688760699_n.jpg?oh=609dabd4332e4415868ad92347b3e3d5&oe=571FF961','메리 크리스마스!','해시_태그 달아봄 a',0,0,'0000-00-00',NULL,NULL,'2015-12-24 01:39:25','use'),(62,3,'이수권','normal','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.9.50.50/p50x50/1379218_655568767816835_1688760699_n.jpg?oh=609dabd4332e4415868ad92347b3e3d5&oe=571FF961','싼타 할아버지는 어디에 계실까요?','해시_태그 달아봄 ab',0,0,'0000-00-00',NULL,NULL,'2015-12-24 19:19:45','use'),(63,3,'이수권','normal','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.9.50.50/p50x50/1379218_655568767816835_1688760699_n.jpg?oh=609dabd4332e4415868ad92347b3e3d5&oe=571FF961','하루 한개기 풀렸다','해시_태그 달아봄 abcde',0,0,'0000-00-00',NULL,NULL,'2015-12-24 19:20:30','use'),(64,14,'Serendip','normal','https://scontent.xx.fbcdn.net/hprofile-xpa1/v/t1.0-1/p50x50/12294725_978970495496138_2003703318621350603_n.jpg?oh=796b5eb43718260c2287ccee25eb7c32&oe=5713AD34','메리 크리스마스!!!','해시_태그 달아봄 abcd',3,1,'0000-00-00',NULL,NULL,'2015-12-24 19:51:03','use'),(65,3,'이수권','normal','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.9.50.50/p50x50/1379218_655568767816835_1688760699_n.jpg?oh=609dabd4332e4415868ad92347b3e3d5&oe=571FF961','즐거운 연휴 보내세요~','해시_태그 달 abc',0,0,'0000-00-00',NULL,NULL,'2015-12-24 23:42:30','use'),(66,3,'이수권','normal','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.9.50.50/p50x50/1379218_655568767816835_1688760699_n.jpg?oh=609dabd4332e4415868ad92347b3e3d5&oe=571FF961','한개 올리기 버그 수정!','해시_태그 달아 abc',0,0,'2015-12-24',NULL,NULL,'2015-12-24 23:45:02','use'),(67,12,'작은나무','normal','https://scontent.xx.fbcdn.net/hprofile-xpa1/v/t1.0-1/c28.28.345.345/s50x50/252200_2621077343424_332918214_n.jpg?oh=5b32a239b587b66ec35805d92605720a&oe=56D5AC78','중국인 상담사분 왈\r\n\"정말 아쉬우었어요. 다만 여러번 통화했더니 고객님의. 성질이 정말 좋으세요.\" 라고 하시네요. 정말로 제가 영어만 능숙했다면 벌어질 일이 아니었는데, 중국 상담사분이랑 메신저로 사소한 얘기까지 나누고 참 좋아요.','해시 달아봄 abc',0,1,'2015-12-25',NULL,NULL,'2015-12-25 13:45:25','use'),(68,7,'지율이수권','manager','http://mud-kage.kakao.co.kr/14/dn/btqcxrrJ5Mi/LOp8GmpoKSobTzLo0KzTzK/o.jpg','날짜 방식 수정!','해 달아봄 abc',0,0,'2015-12-27','2015-12-28 00:00:00','2015-12-29 23:59:59','2015-12-26 00:44:19','use'),(69,3,'이수권','normal','https://scontent.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c0.9.50.50/p50x50/1379218_655568767816835_1688760699_n.jpg?oh=609dabd4332e4415868ad92347b3e3d5&oe=571FF961','#해시_태그 #달아봄 잘될까용??','해시_태그 달아봄 abc',1,0,'2015-12-30',NULL,NULL,'2015-12-30 00:21:25','use'),(70,7,'지율이수권','manager','http://mud-kage.kakao.co.kr/14/dn/btqcxrrJ5Mi/LOp8GmpoKSobTzLo0KzTzK/o.jpg','#a #ab #해 #해시 이걸 저장','ab 해 해시',0,0,'2015-12-31',NULL,NULL,'2015-12-30 16:10:43','use'),(71,12,'작은나무','normal','https://scontent.xx.fbcdn.net/hprofile-xpa1/v/t1.0-1/c28.28.345.345/s50x50/252200_2621077343424_332918214_n.jpg?oh=5b32a239b587b66ec35805d92605720a&oe=56D5AC78','새해 복 많이 받으세요\r\n\r\n#새해 #덕담','새해 덕담',1,1,'2015-12-31',NULL,NULL,'2015-12-31 18:54:43','use'),(72,7,'지율이수권','manager','http://mud-kage.kakao.co.kr/14/dn/btqcxrrJ5Mi/LOp8GmpoKSobTzLo0KzTzK/o.jpg','2016년 새해 소망은 무엇인가요? #2016년 #새해소망','2016년 새해소망',2,0,'2016-01-02','2016-01-01 00:00:00','2016-01-31 23:59:59','2016-01-01 00:43:31','use'),(73,7,'지율이수권','manager','http://mud-kage.kakao.co.kr/14/dn/btqcxrrJ5Mi/LOp8GmpoKSobTzLo0KzTzK/o.jpg','나에게 새해 덕담 한마디 해보아요! #새해 #덕담 #2016','새해 덕담 2016',1,1,'2016-01-02','2016-01-01 00:00:00','2016-01-31 23:59:59','2016-01-02 00:48:49','use');
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-04 18:54:36
