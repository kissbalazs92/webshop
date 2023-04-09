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

-- Kategóriák táblája
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL UNIQUE
);

-- Alkategóriák táblája
CREATE TABLE subcategories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT,
  name VARCHAR(255) NOT NULL UNIQUE,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Termékek táblája
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  net_price DECIMAL(10,2) NOT NULL,
  gross_price DECIMAL(10,2) NOT NULL,
  stock INT NOT NULL,
  rating DECIMAL(3,2),
  sale_price DECIMAL(10,2),
  category_id INT,
  subcategory_id INT,
  FOREIGN KEY (category_id) REFERENCES categories(id),
  FOREIGN KEY (subcategory_id) REFERENCES subcategories(id)
);

-- Képek táblája
CREATE TABLE images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT,
  file_path VARCHAR(255) NOT NULL,
  FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Vélemények táblája
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

INSERT INTO users (username, password, first_name, last_name, email, phone, address, is_admin)
VALUES ('admin', '$2y$10$cOaxVmuHmc0Ajl7XkqVGe.4kEpj.CX65jb1jhaTlYpyMGlxeXebJS', 'Admin', 'User', 'admin@example.com', '1234567890', 'Admin Address', TRUE);

