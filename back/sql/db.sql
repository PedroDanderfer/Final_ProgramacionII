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
    banned tinyint(1),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)ENGINE=INNODB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS products;
CREATE TABLE IF NOT EXISTS products (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    title varchar(100) NOT NULL,
    description text(1000),
    price int NOT NULL DEFAULT 0,
    discount int DEFAULT NULL,
    stock int NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)ENGINE=INNODB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS products_photos;
CREATE TABLE IF NOT EXISTS products_photos (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    image varchar(255) NOT NULL,
    products_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (products_id)
    REFERENCES products (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)ENGINE=INNODB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS categories;
CREATE TABLE IF NOT EXISTS categories (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    name varchar(30) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)ENGINE=INNODB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS products_has_categories;
CREATE TABLE IF NOT EXISTS products_has_categories (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    products_id INT UNSIGNED NOT NULL,
    categories_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (products_id)
    REFERENCES products (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    FOREIGN KEY (categories_id)
    REFERENCES categories (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)ENGINE=INNODB DEFAULT CHARSET=utf8;

INSERT INTO users (dni, name, surname, email, role, password) 
VALUES ('00000000', 'Admin', 'Admin', 'admin@admin.com', 'admin', '$2y$10$blZgwFNBDfDjgo4o5CE9YOXQibNPvnSa.7E0rBtDaNsFGxz.qKYC6'), 
('15224879', 'Jorge', 'Perez', 'jorge.perez@gmail.com', 'user', '$2y$10$blZgwFNBDfDjgo4o5CE9YOXQibNPvnSa.7E0rBtDaNsFGxz.qKYC6'), 
('33544879', 'Marta', 'Peralta', 'martita1212@hotmail.com', 'user', '$2y$10$blZgwFNBDfDjgo4o5CE9YOXQibNPvnSa.7E0rBtDaNsFGxz.qKYC6');

INSERT INTO categories (id, name) 
VALUES (1, 'Pantalones'), (2,'Remeras'), (3, 'Zapatillas'), (4, 'Gorras');

INSERT INTO products (id, title, description, price, discount, stock) 
VALUES (1, 'Pantalon jean', 'Pantalon jean. 100% algodon. Disponibilidad de colores y talles', 350, 300, 9);

INSERT INTO products (id, title, description, price, discount, stock) 
VALUES (2, 'Bermuda Short', 'Bermuda short unisex. Estilo deportivo, excelente para entrenar. Disponibilidad de colores y talles', 250, 0, 12);

INSERT INTO products (id, title, description, price, discount, stock) 
VALUES (3, 'Traje de baño', 'Traje de baño unisex. Varios estilos: deportivo, playero. Disponibilidad de colores y talles', 400, 350, 7);

INSERT INTO products_photos (image, products_id) 
VALUES ('pantalon-jean-negro', 1);
INSERT INTO products_photos (image, products_id) 
VALUES ('pantalon-jean-mujer', 1);
INSERT INTO products_photos (image, products_id) 
VALUES ('pantalon-jean-hombre', 1);
INSERT INTO products_photos (image, products_id) 
VALUES ('short-hombre', 2);
INSERT INTO products_photos (image, products_id) 
VALUES ('short-mujer', 2);
INSERT INTO products_photos (image, products_id) 
VALUES ('short-negro', 2);
INSERT INTO products_photos (image, products_id) 
VALUES ('malla-hombre', 3);
INSERT INTO products_photos (image, products_id) 
VALUES ('malla-mujer', 3);
INSERT INTO products_photos (image, products_id) 
VALUES ('malla-mujer-deportivo', 3);

INSERT INTO products_has_categories (products_id, categories_id) 
VALUES (1, 1);
INSERT INTO products_has_categories (products_id, categories_id) 
VALUES (2, 1);
INSERT INTO products_has_categories (products_id, categories_id) 
VALUES (3, 1);

/*Administrador1!*/