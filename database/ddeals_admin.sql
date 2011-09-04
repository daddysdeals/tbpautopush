/*
Database - ddeals_admin
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ddeals_admin` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `ddeals_admin`;

/*Table structure for table `tbp_imports` */

DROP TABLE IF EXISTS `tbp_imports`;

CREATE TABLE `tbp_imports` (
  `import_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `database` varchar(50) NOT NULL,
  `table` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `import_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`import_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

/*Table structure for table `tbp_imports_subscribers` */

DROP TABLE IF EXISTS `tbp_imports_subscribers`;

CREATE TABLE `tbp_imports_subscribers` (
  `subscriber_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `import_id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `import_status` tinyint(4) DEFAULT '0',
  `tbp_subscriber_id` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`subscriber_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
