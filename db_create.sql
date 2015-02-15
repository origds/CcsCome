CREATE TABLE `0910336_restaurant` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    `latitude` double(10,6) NOT NULL,
    `longitude` double(10,6) NOT NULL,
    `website` varchar(100) NOT NULL,
    `logo_path` varchar(100) DEFAULT NULL,
    `avg_score` float(2,1) DEFAULT '0.0',
    `total_score` int(11) DEFAULT '0',
    `total_users` int(11) DEFAULT '0',
    `description` varchar(100) DEFAULT NULL,
    `phone` varchar(15) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `0910336_dish` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `picture` varchar(100) DEFAULT NULL,
    `restaurant_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_restaurant_id` (`restaurant_id`),
    CONSTRAINT `fk_restaurant_id` FOREIGN KEY (`restaurant_id`) REFERENCES `0910336_restaurant` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
