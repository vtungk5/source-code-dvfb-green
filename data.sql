SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE IF NOT EXISTS users (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    username varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    apikey varchar(255) NOT NULL, 
    token varchar(255) NOT NULL, 
    coin varchar(255) DEFAULT 0,    
    level varchar(255) NOT NULL, 
    status ENUM('ON', 'OFF') NOT NULL DEFAULT 'ON',
    ip varchar(255) NOT NULL,
    date timestamp NULL DEFAULT NULL,
    domain varchar(255) NOT NULL,
    PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS history (
    id int(11) NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL,
    device varchar(255) NOT NULL,
    browser varchar(255) NOT NULL,
    note text NOT NULL,
    ip varchar(255) NOT NULL,
    date timestamp NULL DEFAULT NULL,
    domain varchar(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS napthe (
    id int(11) NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL,
    tranid varchar(255) NOT NULL,
    pin varchar(255) NOT NULL,
    serial varchar(255) NOT NULL,
    telco varchar(255) NOT NULL,
    amount varchar(255) NOT NULL,
    note text NOT NULL,
    status varchar(255) NOT NULL,
    date timestamp NULL DEFAULT NULL,
    ip varchar(255) NOT NULL,
    domain varchar(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `site` (
  stt int(11) NOT NULL AUTO_INCREMENT,
  logo varchar(255) NOT NULL,
  title varchar(255) NOT NULL,
  description text NOT NULL,
  keyword text NOT NULL,
  partner_id varchar(255) NOT NULL,
  partner_key varchar(3000) NOT NULL,
  rate_ctv varchar(255) NOT NULL,
  rate_daily varchar(255) NOT NULL,
  coin_ctv varchar(255) NOT NULL,
  coin_daily varchar(255) NOT NULL,
  notify text NOT NULL,
  apikey_momo varchar(255) NOT NULL,
  name_momo varchar(255) NOT NULL,
  stk_momo varchar(255) NOT NULL,
  username_mb varchar(255) NOT NULL,
  password_mb varchar(255) NOT NULL,
  name_mb varchar(255) NOT NULL,
  stk_mb varchar(255) NOT NULL,
  apikey varchar(3000) NOT NULL,
  status enum('ON','OFF') NOT NULL DEFAULT 'ON',
  domain varchar(255) NOT NULL,
  PRIMARY KEY (stt)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `bank` (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(255) NOT NULL,
  tranid varchar(255) NOT NULL,
  amount varchar(255) NOT NULL,
  note varchar(255) NOT NULL,
  type varchar(255) NOT NULL,
  status varchar(255) NOT NULL,
  domain varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS service (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    note text NOT NULL,
    path text NOT NULL,
    nguon varchar(255) NOT NULL,
    apikey text NOT NULL,
    id_theloai varchar(255) NOT NULL,  
    id_dv varchar(255) NOT NULL,
    comment ENUM('ON', 'OFF') NOT NULL DEFAULT 'ON',
    reaction ENUM('ON', 'OFF') NOT NULL DEFAULT 'ON',
    speed ENUM('ON', 'OFF') NOT NULL DEFAULT 'ON',
    status ENUM('ON', 'OFF') NOT NULL DEFAULT 'ON',
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `sitecon` (
    id int(11) NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL,
    domain varchar(255) NOT NULL,
    apikey varchar(3000) NOT NULL,
    status ENUM('ON', 'OFF') NOT NULL DEFAULT 'ON',
    date timestamp NULL DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `server` (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    rate varchar(255) NOT NULL,
    server text NOT NULL,
    id_theloai varchar(255) NOT NULL,  
    id_dv varchar(255) NOT NULL,
    id_sv varchar(255) NOT NULL,
    note text NOT NULL,
    status ENUM('ON', 'OFF') NOT NULL DEFAULT 'ON',
    domain varchar(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `post` (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    note text NOT NULL,
    date timestamp NULL DEFAULT NULL,
    domain varchar(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `order` (
    id int(11) NOT NULL AUTO_INCREMENT,
    MGD varchar(255) ,
    username varchar(255) ,
    uid varchar(255) ,
    id_theloai varchar(255) ,  
    id_dv varchar(255) ,  
    server text ,
    speed ENUM('nhanh', 'cham')  DEFAULT 'nhanh',
    comment varchar(255) NULL DEFAULT NULL,
    reaction varchar(255) NULL DEFAULT NULL,
    amount varchar(255) ,
    money varchar(255) ,
    note text NULL DEFAULT NULL,
    start text ,
    dachay text ,
    status varchar(255) ,
    date timestamp NULL DEFAULT NULL,
    domain varchar(255) ,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS theloai (
    id int(11) NOT NULL AUTO_INCREMENT,
    logo text NOT NULL,
    name varchar(255) NOT NULL,
    path varchar(255) NOT NULL,
    id_theloai varchar(255) NOT NULL,  
    PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS lienhe (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    path varchar(255) NOT NULL,
    domain varchar(255) NOT NULL,
    PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;