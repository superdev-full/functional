--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'Assignment',
  `description` text NOT NULL DEFAULT '',
  `topic` varchar(255) NOT NULL DEFAULT 'Topic',
  `emergency` varchar(255) NOT NULL DEFAULT '',
  `attachment` VARCHAR(255)  NULL,
  `created_at` DATETIME NOT NULL,
  `status` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
