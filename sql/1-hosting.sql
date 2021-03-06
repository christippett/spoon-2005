-- SELECT * FROM news ORDER BY timestamp DESC LIMIT 10
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  title text,
  body text,
  timestamp datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
  id int AUTO_INCREMENT,
  user_id int,
  domain varchar(255),
  `desc` text,
  total decimal(15,2) DEFAULT 0.00,
  issued int,
  due int,
  closed int,
  active int DEFAULT 1,
  fname varchar(255),
  lname varchar(255),
  address1 varchar(255),
  address2 varchar(255),
  city varchar(255),
  country varchar(255) DEFAULT "NZ",
  PRIMARY KEY (`id`)
);


DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  id int AUTO_INCREMENT,
  user_id int,
  `type` int DEFAULT '0',
  domain varchar(255),
  PRIMARY KEY (`id`)
);


DROP TABLE IF EXISTS `recurrings`;
CREATE TABLE `recurrings` (
  id int AUTO_INCREMENT,
  user_id int,
  account_id int,
  domain varchar(255),
  `type` int DEFAULT '1',
  active int DEFAULT '1',
  PRIMARY KEY (`id`)
);
