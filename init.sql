ALTER DATABASE webshop CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  phone VARCHAR(255) NOT NULL,
  address TEXT NOT NULL,
  is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  order_number VARCHAR(255) NOT NULL UNIQUE,
  products TEXT NOT NULL,
  date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE addresses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  address TEXT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE subcategories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT,
  name VARCHAR(255) NOT NULL UNIQUE,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  net_price DECIMAL(10,2) NOT NULL,
  gross_price DECIMAL(10,2) NOT NULL,
  stock INT NOT NULL,
  category_id INT,
  sale_price DECIMAL(10,2),
  sales_count INT DEFAULT 0,
  last_sale_date DATETIME,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE product_subcategories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT,
  subcategory_id INT,
  FOREIGN KEY (product_id) REFERENCES products(id),
  FOREIGN KEY (subcategory_id) REFERENCES subcategories(id)
);

CREATE TABLE images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT,
  file_path VARCHAR(255) NOT NULL,
  image_order INT NOT NULL,
  FOREIGN KEY (product_id) REFERENCES products(id)
);


CREATE TABLE reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT,
  user_id INT,
  text TEXT NOT NULL,
  rating INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

ALTER TABLE categories CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO users (username, password, first_name, last_name, email, phone, address, is_admin)
VALUES ('admin', 'admin123', 'Admin', 'User', 'admin@example.com', '1234567890', 'Admin Address', TRUE);

INSERT INTO users (username, password, first_name, last_name, email, phone, address, is_admin)
VALUES ('user', '$2y$10$Rz09I75xrNhwT1O1kXHH..3VXNPvJ0jJQDaisevtV5k4gwl9AK9v6', 'Teszt', 'Felhasználó', 'user@example.com', '0987654321', 'User Address', FALSE);

-- Elektronika
INSERT INTO categories (name) VALUES ('Elektronika');
-- Divat
INSERT INTO categories (name) VALUES ('Divat');
-- Otthon & Kert
INSERT INTO categories (name) VALUES ('Otthon és Kert');
-- Sport & Szabadidő
INSERT INTO categories (name) VALUES ('Sport és Szabadidő');
-- Szépség & Egészség
INSERT INTO categories (name) VALUES ('Szépség és Egészség');
-- Játék & Hobbi
INSERT INTO categories (name) VALUES ('Játék és Hobbi');
-- Irodaszer & Könyv
INSERT INTO categories (name) VALUES ('Irodaszer és Könyv');
-- Autó & Motor
INSERT INTO categories (name) VALUES ('Autó és Motor');

-- Elektronika
INSERT INTO subcategories (category_id, name) VALUES (1, 'Mobiltelefonok');
INSERT INTO subcategories (category_id, name) VALUES (1, 'Laptopok');
INSERT INTO subcategories (category_id, name) VALUES (1, 'Fejhallgatók');

-- Divat
INSERT INTO subcategories (category_id, name) VALUES (2, 'Férfi Ruházat');
INSERT INTO subcategories (category_id, name) VALUES (2, 'Női Ruházat');
INSERT INTO subcategories (category_id, name) VALUES (2, 'Cipők');

-- Otthon & Kert
INSERT INTO subcategories (category_id, name) VALUES (3, 'Konyhai Gépek');
INSERT INTO subcategories (category_id, name) VALUES (3, 'Bútorok');
INSERT INTO subcategories (category_id, name) VALUES (3, 'Kerti Eszközök');

-- Sport & Szabadidő
INSERT INTO subcategories (category_id, name) VALUES (4, 'Edzőterem Felszerelés');
INSERT INTO subcategories (category_id, name) VALUES (4, 'Szabadtéri Szórakozás');
INSERT INTO subcategories (category_id, name) VALUES (4, 'Sportruházat');
INSERT INTO subcategories (category_id, name) VALUES (4, 'Sportcipők');

-- Szépség & Egészség
INSERT INTO subcategories (category_id, name) VALUES (5, 'Smink');
INSERT INTO subcategories (category_id, name) VALUES (5, 'Bőrápolás');
INSERT INTO subcategories (category_id, name) VALUES (5, 'Hajápolás');
INSERT INTO subcategories (category_id, name) VALUES (5, 'Illatszerek');
INSERT INTO subcategories (category_id, name) VALUES (5, 'Egészségügyi termékek');
INSERT INTO subcategories (category_id, name) VALUES (5, 'Kiegészítők');

-- Játék & Hobbi
INSERT INTO subcategories (category_id, name) VALUES (6, 'Játékkonzolok');
INSERT INTO subcategories (category_id, name) VALUES (6, 'Videojátékok');
INSERT INTO subcategories (category_id, name) VALUES (6, 'Társasjátékok');

-- Irodaszer & Könyv
INSERT INTO subcategories (category_id, name) VALUES (7, 'Irodaszerek');
INSERT INTO subcategories (category_id, name) VALUES (7, 'Könyvek');

-- Autó & Motor
INSERT INTO subcategories (category_id, name) VALUES (8, 'Autóalkatrészek');
INSERT INTO subcategories (category_id, name) VALUES (8, 'Motoralkatrészek');

-- Electronics - Mobile Phones
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Okostelefon 1', 'Ez egy jó okostelefon.', 100000, 127000, 10, 1);

-- Electronics - Laptops
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Laptop 1', 'Ez egy jó laptop.', 200000, 254000, 5, 1);

-- Electronics - Headphones
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Fejhallgató 1', 'Ez egy jó fejhallgató.', 15000, 19050, 20, 1);

-- Fashion - Men Clothing
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Férfi póló 1', 'Ez egy jó férfi póló.', 5000, 6350, 15, 2);

-- Fashion - Women Clothing
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Női ruha 1', 'Ez egy jó női ruha.', 10000, 12700, 8, 2);

-- Fashion - Shoes
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Cipő 1', 'Ez egy jó cipő.', 15000, 19050, 10, 2);

-- Home & Garden - Kitchen Appliances
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Konyhai eszköz 1', 'Ez egy jó konyhai eszköz.', 2500, 3175, 30, 3);

-- Home & Garden - Furniture
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Bútor 1', 'Ez egy jó bútor.', 50000, 63500, 3, 3);

-- Home & Garden - Garden Tools
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Kerti szerszám 1', 'Ez egy jó kerti szerszám.', 3000, 3810, 25, 3);

-- A többi kategória és alkategória termékei
-- (Új kategóriák esetén ne felejtsd el módosítani a 'category_id' értékét!)
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Termék 1', 'Ez egy jó termék.', 10000, 12700, 10, 4);

-- További termékek az új alkategóriákhoz
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Termék 2', 'Ez egy másik jó termék.', 20000, 25400, 5, 4);

-- Sport & Fitness - Gym Equipment
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Edzőgép 1', 'Ez egy jó edzőgép.', 30000, 38100, 5, 4);

-- Sport & Fitness - Sportswear
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Sportruházat 1', 'Ez egy jó sportruházat.', 8000, 10160, 12, 4);

-- Sport & Fitness - Running Shoes
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Futócipő 1', 'Ez egy jó futócipő.', 18000, 22860, 6, 4);

-- Books - Fiction
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Regény 1', 'Ez egy jó regény.', 3000, 3810, 20, 5);

-- Books - Non-Fiction
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Szakkönyv 1', 'Ez egy jó szakkönyv.', 4000, 5080, 10, 5);

-- Books - Children's Books
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Gyermekkönyv 1', 'Ez egy jó gyermekkönyv.', 2500, 3175, 15, 5);

-- Books - Textbooks
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Tankönyv 1', 'Ez egy jó tankönyv.', 4500, 5715, 8, 5);

-- Toys & Games - Action Figures
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Akciónfigura 1', 'Ez egy jó akciónfigura.', 3500, 4445, 10, 6);

-- Toys & Games - Board Games
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Társasjáték 1', 'Ez egy jó társasjáték.', 5000, 6350, 12, 6);

-- Toys & Games - Puzzles
INSERT INTO products (name, description, net_price, gross_price, stock, category_id)
VALUES ('Kirakós 1', 'Ez egy jó kirakós.', 2000, 2540, 20, 6);





