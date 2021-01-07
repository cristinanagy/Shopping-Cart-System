CREATE DATABASE shop;
USE shop;

CREATE TABLE IF NOT EXISTS `products` (
                                          `id` int(11) NOT NULL AUTO_INCREMENT,
                                          `name` varchar(200) NOT NULL,
                                          `desc` text NOT NULL,
                                          `price` decimal(7,2) NOT NULL,
                                          `rrp` decimal(7,2) NOT NULL DEFAULT '0.00',
                                          `quantity` int(11) NOT NULL,
                                          `img` text NOT NULL,
                                          `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                          PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

CREATE TABLE users
(
    uid INT PRIMARY KEY AUTO_INCREMENT,
    uname VARCHAR(30)UNIQUE,
    upass VARCHAR(50),
    fullname VARCHAR(100),
    uemail VARCHAR(70) UNIQUE
    );