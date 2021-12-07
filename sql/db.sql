DROP DATABASE IF EXISTS ecommerce;
CREATE DATABASE IF NOT EXISTS ecommerce;

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    dni varchar(9) NOT NULL UNIQUE,
    name varchar(100) NOT NULL,
    surname varchar(100) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    role varchar(5) NOT NULL DEFAULT 'user',
    password varchar(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)ENGINE=INNODB DEFAULT CHARSET=utf8;

