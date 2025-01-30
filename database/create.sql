PRAGMA foreign_keys = OFF;

-- Drop tables
DROP TABLE IF EXISTS "user";
DROP TABLE IF EXISTS "items";
DROP TABLE IF EXISTS "inquiries";
DROP TABLE IF EXISTS "wishlists";
DROP TABLE IF EXISTS "shopping_carts";
DROP TABLE IF EXISTS "admin_actions";

-- Create a users table
CREATE TABLE user (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  username TEXT UNIQUE NOT NULL,
  email TEXT UNIQUE NOT NULL,
  password TEXT NOT NULL,
  image_url TEXT DEFAULT '../img/defaultUser.png',
  is_seller BOOLEAN NOT NULL DEFAULT 0,
  is_admin BOOLEAN NOT NULL DEFAULT 0
);

-- Create an item table
CREATE TABLE items (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER NOT NULL,
  category TEXT NOT NULL,
  brand TEXT NOT NULL,
  model TEXT NOT NULL,
  size TEXT NOT NULL,
  condition TEXT NOT NULL,
  description TEXT NOT NULL,
  price REAL NOT NULL,
  image_url TEXT NOT NULL,
  is_active BOOLEAN NOT NULL DEFAULT 1,
  FOREIGN KEY (user_id) REFERENCES user (id)
);

-- Create an inquiries table 
CREATE TABLE inquiries (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER NOT NULL,
  item_id INTEGER NOT NULL,
  message TEXT NOT NULL,
  is_read BOOLEAN NOT NULL DEFAULT 0,
  FOREIGN KEY (user_id) REFERENCES user (id),
  FOREIGN KEY (item_id) REFERENCES items (id)
);

-- Create a wishlist table
CREATE TABLE wishlists (
  user_id INTEGER NOT NULL,
  item_id INTEGER NOT NULL,
  PRIMARY KEY (user_id, item_id),
  FOREIGN KEY (user_id) REFERENCES user (id),
  FOREIGN KEY (item_id) REFERENCES items (id)
);

-- Create a shopping_carts table
CREATE TABLE shopping_carts (
  user_id INTEGER NOT NULL,
  item_id INTEGER NOT NULL,
  PRIMARY KEY (user_id, item_id),
  FOREIGN KEY (user_id) REFERENCES user (id),
  FOREIGN KEY (item_id) REFERENCES items (id)
);

-- Create an admin_actions table
CREATE TABLE admin_actions (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER NOT NULL,
  action_type TEXT NOT NULL,
  action_details TEXT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user (id)
);


INSERT INTO user (name, username, email, password, image_url, is_seller, is_admin)
VALUES ('John Doe', 'johndoe', 'john.doe@example.com', 'password1', 'img/defaultUser.png', 1, 0),
       ('Jane Smith', 'janesmith', 'jane.smith@example.com', 'password2', 'img/defaultUser.png', 1, 1),
       ('Buyer1', 'buyer1', 'buyer1@example.com', 'password3', 'img/defaultUser.png', 0, 0),
       ('Buyer2', 'buyer2', 'buyer2@example.com', 'password4', 'img/defaultUser.png', 0, 0);

INSERT INTO items (user_id, category, brand, model, size, condition, description, price, image_url, is_active)
VALUES (1, 'Phone', 'Apple', 'iPhone 13', 'XL', 'New', 'Brand new iPhone 13 XL, Unlocked, never used', 1099, 'img/1.png', 1),
       (1, 'Laptop', 'Dell', 'XPS 15', '15.6''', 'Used', 'Used Dell XPS 15, like new, 16GB RAM, 512GB SSD', 1699, 'img/2.png', 1),
       (2, 'Tablet', 'Samsung', 'Galaxy Tab S7', '11''', 'New', 'Brand new Samsung Galaxy Tab S7, Wi-Fi only', 599, 'img/3.png', 1),
       (2, 'Tablet', 'Samsung', 'Galaxy Tab S7', '11''', 'New', 'Brand new Samsung Galaxy Tab S7, Wi-Fi only', 599, 'img/4.png', 0);

INSERT INTO inquiries (user_id, item_id, message, is_read)
VALUES (3, 1, 'Can you provide more details about the condition of the iPhone 13 XL?', 0);
