CREATE TABLE users(
  user_id           INT(5)            AUTO_INCREMENT,
  fname             VARCHAR(50)       NOT NULL,
  lname             VARCHAR(50)       NOT NULL,
  password          VARCHAR(72)       NOT NULL,
  email             VARCHAR(320)      NOT NULL,
  image             VARCHAR(260)      DEFAULT '/tindahan.ph/assets/mock/users/placeholder.png',
  phone             BIGINT(10)                    ,
  role              ENUM('admin', 'user', 'partner') DEFAULT 'user',
  active            ENUM('true', 'false') DEFAULT 'true',
  suspended         ENUM('true', 'false') DEFAULT 'false',
  last_login        DATETIME          DEFAULT NOW(),

  CONSTRAINT Users_PK PRIMARY KEY(user_id)
);

-- USE THESE FOR THE ADMIN USERS 
INSERT INTO users (fname, lname, password, email, image, phone, role, active, suspended, last_login) VALUES
('Hans Maco', 'Cruz', '$2y$10$nFa3XOdT5LKlQ2FR53l/EuRDE5VfMJcSzgQS48oh3KMrdu8VFUsuC', '18103205@usc.edu.ph', DEFAULT, NULL, 'admin', 'true', 'false', '2021-12-01 05:01:03'),
('Roque', 'Gelacio', '$2y$10$LGOaYoqXlK7SJfw73w3S9uOrp4C2yoxNqe.OZuUQyYc.jbPlrYrAC', '20100987@usc.edu.ph', DEFAULT, NULL, 'admin', 'true', 'false', '2021-11-30 23:23:12'),
('Hannah Ruth', 'Labana', '$2y$10$LGOaYoqXlK7SJfw73w3S9uOrp4C2yoxNqe.OZuUQyYc.jbPlrYrAC', '20102712@usc.edu.ph', DEFAULT, NULL, 'admin', 'true', 'false', '2021-11-30 23:23:12'),
('Nicholai Julian', 'Oblina', '$2y$10$7rnCmYacPxaJrGV6eRuQJecIJGr18jXYzQqyfNZO9etWJU98bCBtO', '20102511@usc.edu.ph', DEFAULT, NULL, 'admin', 'true', 'false', '2021-12-05 04:18:06'),
('Nina', 'Fowler', '$2y$10$SdKN06qTQ07K9aIGLGLupeZ2ef.zCk7XeHkaNFDWF.qk/tsm2q6vu', 'ninafowler@gmail.com', '/tindahan.ph/assets/mock/users/user001.jpg', 9667836032, 'user', 'true','false', '2021-12-12 16:18:04'),
('Dillan','Butler', '$2y$10$mtgspqhDIPnPQr8dsQRVmeb9YnEGdb.ASQ/KjvISwPlAI1bnDUITC', 'dillanButler@gmail.com','/tindahan.ph/assets/mock/users/user002.jpg', 9382109377, 'user', 'true', 'false', '2021-11-31 08:49:43'),
('Alma', 'Clarke', '$2y$10$f0.1fEX/j.IuH/26ds6HzOErn8UNWwQ.BB2Q4kkFn0b9N7OKRHPbu', 'almaccc@gmail.com', '/tindahan.ph/assets/mock/users/user003.jpg', 90038216746, 'user','true','false', '2021-12-01 13:34:27'),
('Gustavo', 'Trevino', '$2y$10$xXydseThmRxqlmGB1LA9QO5tAofz2EJNAEqhTBwhfRQIGCeT/OLs2', 'gustavo@gmail.com', '/tindahan.ph/assets/mock/users/user004.jpg', 9361846332, 'user', 'true', 'false', '2021-12-05 18:03:48'),
('Levi', 'Rowland', '$2y$10$yNiePE.YpugUtXJpnjEOLOlt3lvso2CgXHyaeooEG8Cw5yGyRjuW6', 'leviRow@gmail.com', '/tindahan.ph/assets/mock/users/user005.jpg', 9776498021, 'user', 'true', 'false', '2021-11-28 15:57:01'),
('Henry', 'Sy', '$2y$10$gN3t3dSItITEPWBBgI1FDOsgkqZfSDvQ9E7PKOpzMD9P7.0aiqLVi', 'anyTopCebu@gmail.com', '/tindahan.ph/assets/mock/users/user006.jpg', 9438502184, 'partner', 'true', 'false', '2021-12-10 21:05:59'),
('Arella', 'Bernales', '$2y$10$Bi336lERYV5uZtdV5UCOOeLQbdePd4y2ac3TKhe7NX4mhjP5SfmfW', 'WAISOph@gmail.com', '/tindahan.ph/assets/mock/users/user007.jpg', 9184776321, 'partner', 'true', 'false', '2021-12-11 14:23:43'),
('Chanel', 'Siase', '$2y$10$Dd9sFOaZnkegmzihNY8Emu7T3mxpQSvUOqg71piXRQm.ppbN7a.8C', 'kidsKingdom@gmail.com', '/tindahan.ph/assets/mock/users/user008.jpg', 9477853221, 'partner', 'true', 'false', '2021-12-09 05:25:50'),
('Melisa', 'Maranan', '$2y$10$pVGBW6ehEINuDO/3eEiENOHPruXpP7MoF/7pZTpBxAlEW6eI4gzi.', 'cebuFOAM@gmail.com', DEFAULT, 9574337744, 'partner', 'true', 'false', '2021-12-10 23:43:56'),
('Bea', 'Lim', '$2y$10$en0GzK35IdpvUzbzaoTz.egsukmuh6kCrV1bePCyTc/50cHg4CE3i', 'corals.cebu@gmail.com', DEFAULT, 9137590085, 'partner', 'true', 'false', '2021-12-12 14:12:11');

CREATE TABLE users_address(
  user_id           INT(5)            AUTO_INCREMENT,
  street            VARCHAR(150)                    ,
  city              ENUM('Cebu City', 'Mandaue City', 'Lapu-Lapu City'),
  barangay          VARCHAR(50)                     ,
  landmark          VARCHAR(20)                     ,
  zipcode           INT(4)                          ,

  CONSTRAINT Users_Address_PK PRIMARY KEY(user_id),
  CONSTRAINT Users_Address_FK FOREIGN KEY(user_id) REFERENCES users(user_id)
);

INSERT INTO users_address(user_id, street, city, barangay, zipcode) VALUES
(5, 'Blk 4, Lot 15 Eagles St.', 'Mandaue City', 'Bakilid', 6014),
(6, 'Hummingbird Street', 'Mandaue City', 'Banilad', 6014),
(7, 'Swift Street', 'Cebu City', 'Talamban', 6000),
(8, 'Blk 10, Lot 21, Cuckoo St.', 'Lapu-Lapu City', 'Babag', 6016),
(9, 'Blk 4, Lot 9, Heron Street', 'Cebu City', 'Apas', 6000),
(10, 'M.L. Quezon Street', 'Mandaue City', 'Maguikay', 6014),
(11, 'Archbishop Reyes Ave', 'Cebu City', 'Luz', 6000),
(12, 'Juan Luna Ave Ext', 'Cebu City', 'Mabolo', 6000),
(13, 'Hernan Cortes Street', 'Mandaue City', 'Tipolo', 6014),
(14, 'Gen. Maxilom Ave Osmena Street', 'Cebu City', 'Carreta', 6000);

CREATE TABLE partner_store(
  store_id                INT(5)              AUTO_INCREMENT,
  user_id                 INT(5)              NOT NULL,
  store_name              VARCHAR(100)        NOT NULL,
  store_img               VARCHAR(260)        DEFAULT '/tindahan.ph/assets/mock/partner/placeholder.png',
  store_description       VARCHAR(200)        NOT NULL,
  active                  ENUM('true', 'false') DEFAULT 'true',
  suspended               ENUM('true', 'false') DEFAULT 'false',
  CONSTRAINT Store_PK PRIMARY KEY(store_id),
  CONSTRAINT Store_User_FK FOREIGN KEY(user_id) REFERENCES users(user_id)
);

INSERT INTO partner_store(user_id, store_name, store_img, store_description, active, suspended) VALUES
(10, 'AnyTop', '/tindahan.ph/assets/mock/partner/store001.jpg', 'All kinds of household items at the best affordable prices', 'true', 'false'),
(11, 'WAISO', '/tindahan.ph/assets/mock/partner/store002.png', 'All you need is here, at the price you want, and we are everywhere', 'true', 'false'),
(12, 'Kids Kingdom', '/tindahan.ph/assets/mock/partner/store003.png', 'Toys for all ages of imagination', 'true', 'false'),
(13, 'Cebu Foam', DEFAULT, 'One-stop shop for all your foam and furniture needs', 'true', 'false'),
(14, 'Corals', DEFAULT, 'Perfect wardrobe for everyone', 'true', 'false');

CREATE TABLE partner_applications(
  application_id          INT(5)                AUTO_INCREMENT,
  user_id                 INT(5)                NOT NULL,
  application_status      ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  store_name              VARCHAR(100)          NOT NULL,
  store_main_categ        VARCHAR(20)           NOT NULL,
  store_desc              VARCHAR(200)          NOT NULL,
  store_img               VARCHAR(260)          DEFAULT '/tindahan.ph/assets/mock/partner/placeholder.png',
  online_experience       ENUM('yes', 'no')     NOT NULL,
  online_platforms        VARCHAR(100)                  ,
  CONSTRAINT Application_PK PRIMARY KEY(application_id),
  CONSTRAINT Application_User_FK FOREIGN KEY(user_id) REFERENCES users(user_id)
);

INSERT INTO partner_applications(user_id, application_status, store_name, store_main_categ, store_desc, store_img, online_experience, online_platforms) VALUES
(10, 'approved', 'AnyTop', 'Furniture', 'All kinds of household items at the best affordable prices', '/tindahan.ph/assets/mock/partner/user010.jpg', 'no', NULL),
(11, 'approved', 'WAISO', 'Stationery', 'All you need is here, at the price you want, and we are everywhere', '/tindahan.ph/assets/mock/partner/user011.jpg', 'yes', 'Shopee'),
(12, 'approved', 'Kids Kingdom', 'Kids', 'Toys for all ages of imagination', '/tindahan.ph/assets/mock/partner/user012.jpg', 'yes', 'Shopee, Lazada'),
(13, 'approved', 'Cebu Foam', 'Furniture', 'One-stop shop for all your foam and furniture needs', DEFAULT, 'no', NULL),
(14, 'approved', 'Corals', "Women's", 'Perfet wardrobe for everyone', DEFAULT, 'yes', 'Carousell' );

CREATE TABLE listing_application(
  application_id          INT(7)                AUTO_INCREMENT,
  listing_store           INT(5)                NOT NULL,
  listing_name            VARCHAR(255)          NOT NULL,
  listing_img             VARCHAR(260)          NOT NULL,
  listing_price           DECIMAL(7, 2)         NOT NULL,
  listing_desc            VARCHAR(500)          NOT NULL,
  listing_brand           VARCHAR(20)           NOT NULL,
  listing_status          ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  CONSTRAINT Listings_Application_PK PRIMARY KEY(application_id),
  CONSTRAINT Listings_Application_FK FOREIGN KEY(listing_store) REFERENCES partner_store(store_id)
);

INSERT INTO listing_application(listing_store, listing_name, listing_img, listing_price, listing_desc, listing_brand, listing_status) VALUES
(3, 'Sesame Street Stuffed Toys', '/tindahan.ph/assets/mock/products/product001.jpg', 650.00, 'Characters from Sesame Street, comes with playable music.', 'Philips', 'approved'),
(3, 'Banana Baby Teether', '/tindahan.ph/assets/mock/products/product002.jpg', 440.00, 'Banana teether for 8mos and above. Requires adult supervision.', 'Chicco', 'approved'),
(2, 'Clear Acrylic Organizer', '/tindahan.ph/assets/mock/products/product003.jpg', 70.00, 'Organizer that can hold writing instruments.', 'WAISO', 'approved'),
(2, 'Tokyo Mini Instant Chicken Ramen', '/tindahan.ph/assets/mock/products/product004.jpg', 99.00, 'Delicious ramen after 5 minutes of low-effort cooking', 'WAISO', 'approved'),
(2, 'Cute Floral Beaded Bracelet', '/tindahan.ph/assets/mock/products/product005.jpg', 200.00, 'Beautiful handcrafted bracelet for friends and family', 'WAISO', 'approved'),
(1, 'Touch Sensor Trash Bin', '/tindahan.ph/assets/mock/products/product006.jpg', 1200.00, 'Trash bin that opens and closes through a touch sensor', 'AnyTop', 'approved'),
(1, 'Door Sticky Stopper', 'tindahan.ph/assets/mock/products/product007.jpg', 80.00, 'Door stopped to avoid floor and wall marks', 'AnyTop', 'approved'),
(1, 'BTS Welcome Doormat', 'tindahan.ph/assets/mock/products/product008.jpg', 750.00, 'Be welcomed home with seven beautiful Korean men', 'AnyTop', 'approved'),
(4, 'Solo Stool', '/tindahan.ph/assets/mock/products/product009.jpg', 1100.00, 'Stool best for the living room', 'Cebu Foam', 'approved'),
(4, 'Lifetime Outdoor Table for Big Families', 'tindahan.ph/assets/mock/products/product010.jpg', 800.00, 'Best for gatherings outdoors with friends and family.', 'Lifetime', 'approved'),
(5, 'Camilla Blouse', 'tindahan.ph/assets/mock/products/product011.jpg', 699.00, 'One size for all. For casual and semi-formal events', 'Corals', 'approved'),
(5, 'Sunshine Midi Skirt', 'tindahan.ph/assets/mock/products/product012.jpg', 749.00, 'Skirt that fits the picnic and cottage vibes', 'Corals', 'approved'),
(5, 'Kurt Polo Shirt', 'tindahan.ph/assets/mock/products/product013.jpg', 749.00, 'Closet staple for men', 'Corals', 'approved');

CREATE TABLE product_category(
  category_id     INT(1)              AUTO_INCREMENT,
  category_name   VARCHAR(30)         NOT NULL,
  category_img    VARCHAR(260)        NOT NULL,
  CONSTRAINT Product_Category_PK PRIMARY KEY(category_id)
);
 
INSERT INTO product_category(category_name, category_img) VALUES
("Food", "../../assets/images/categories/category-food.jpg"),
("Cosmetics", "../../assets/images/categories/category-cosmetics.jpg"),
("Furniture", "../../assets/images/categories/category-furniture.jpg"),
("Women's","../../assets/images/categories/category-womens.jpg"),
("Men's","../../assets/images/categories/category-mens.jpg"),
("Accessories","../../assets/images/categories/category-accessories.jpg"),
("Electronics","../../assets/images/categories/category-electronics.jpg"),
("Kids","../../assets/images/categories/category-kids.jpg"),
("Stationery","../../assets/images/categories/category-stationery.jpg");

CREATE TABLE listing_categories(
  listing_category_id     INT(7)                AUTO_INCREMENT,
  application_id          INT(7)                NOT NULL,
  category_id             INT(1)                NOT NULL,
  CONSTRAINT Listing_Category_PK PRIMARY KEY(listing_category_id),
  CONSTRAINT Listing_Application_FK FOREIGN KEY(application_id) REFERENCES listing_application(application_id),
  CONSTRAINT Listing_Category_FK FOREIGN KEY(category_id) REFERENCES product_category(category_id)
);

INSERT INTO listing_categories(application_id, category_id) VALUES
(1, 8),
(2, 8),
(3, 9),
(4, 1),
(5, 6),
(6, 7),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 4),
(12, 4),
(13, 5);

CREATE TABLE listing_variations(
  listing_variation_id    INT(7)                AUTO_INCREMENT,
  application_id          INT(7)                NOT NULL,
  variation               VARCHAR(100)          NOT NULL,
  price                   DECIMAL(7, 2)         NOT NULL,
  quantity                INT(5)                NOT NULL,
  CONSTRAINT Listing_Variation_PK PRIMARY KEY(listing_variation_id),
  CONSTRAINT Listing_Variation_FK FOREIGN KEY(application_id) REFERENCES listing_application(application_id)  
);

INSERT INTO listing_variations(application_id, variation, price, quantity) VALUES
(1, 'Elmo', 650.00, 20),
(1, 'Cookie Monster', 700.00, 20),
(1, 'Big Bird', 650.00, 18),
(2, 'Peelable Banana', 400.00, 30),
(2, 'Un-Peelable Banana', 440.00, 30),
(3, 'Small', 70.00, 50),
(3, 'Medium', 70.00, 50),
(3, 'Large', 700.00, 50),
(5, 'Yellow Flowers', 200.00, 10),
(5, 'Pink Flowers', 200.00, 10),
(5, 'Purple Flowers', 200.00, 10),
(6, 'Aluminum', 1200.00, 20),
(6, 'Wooden Laminate', 1200.00, 20),
(6, 'Plain White', 1200.00, 20),
(8, 'Maknae Line', 750.00, 5),
(8, 'Hyung Line', 750.00, 5),
(8, 'OT7', 750.00, 3),
(11, 'Small', 699.00, 3),
(11, 'Medium', 699.99, 5),
(11, 'Large', 699.00, 2),
(12, 'Small', 749.00, 10),
(12, 'Medium', 749.00, 5),
(12, 'Large', 749.00, 10),
(13, 'Small', 749.00, 2),
(13, 'Medium', 749.00, 5),
(13, 'Large', 749.00, 10);

CREATE TABLE products(
  product_id              INT(5)              AUTO_INCREMENT,
  product_store           INT(5)              NOT NULL, 
  product_name            VARCHAR(255)        NOT NULL,
  product_img             VARCHAR(260)        NOT NULL,
  product_price           DECIMAL(7, 2)       NOT NULL,
  product_desc            VARCHAR(500)        NOT NULL,
  product_rating          DECIMAL(2,1)        NOT NULL DEFAULT 0.0,
  product_quantity        INT(5)              NOT NULL,
  product_brand           VARCHAR(20)         NOT NULL,
  active                  ENUM('true', 'false') DEFAULT 'true',
  suspended               ENUM('true', 'false') DEFAULT 'false',
  CONSTRAINT Product_PK PRIMARY KEY(product_id),
  CONSTRAINT Product_FK FOREIGN KEY(product_store) REFERENCES partner_store(store_id)
);

INSERT INTO products (product_store, product_name, product_img, product_price, product_desc, product_quantity, product_brand, active, suspended) VALUES
(3, 'Sesame Street Stuffed Toys', '/tindahan.ph/assets/mock/products/product001.jpg', 650.00, 'Characters from Sesame Street, comes with playable music.', 58, 'Philips', 'true', 'false'),
(3, 'Banana Baby Teether', '/tindahan.ph/assets/mock/products/product002.jpg', 440.00, 'Baana teether for 8mos and above. Requires adult supervision', 60, 'Chicco', 'true', 'false'),
(2, 'Clear Acrylic Organizer', '/tindahan.ph/assets/mock/products/product003.jpg', 70.00, 'Organizer that can hold writing instruments.', 150, 'WAISO', 'true', 'false'),
(2, 'Tokyo Mini Instant Chicken Ramen', '/tindahan.ph/assets/mock/products/product004.jpg', 99.00, 'Delicious ramen after 5 minutes of low-effort cooking', 50, 'WAISO', 'true', 'false'),
(2, 'Cute Floral Beaded Bracelet', '/tindahan.ph/assets/mock/products/product005.jpg', 200.00, 'Beautiful handcrafted bracelet for friends and family', 30, 'WAISO', 'true', 'false'),
(1, 'Touch Sensor Trash Bin', '/tindahan.ph/assets/mock/products/product006.jpg', 1200.00, 'Trash bin that opens and closes through a touch sensor', 60, 'AnyTop', 'true', 'false'),
(1, 'Door Sticky Stopper', '/tindahan.ph/assets/mock/products/product007.jpg', 80.00, 'Door stopped to avoid floor and wall marks', 100, 'AnyTop', 'true', 'false'),
(1, 'BTS Welcome Doormat', '/tindahan.ph/assets/mock/products/product008.jpg', 750.00, 'Be welcomed home with seven beautiful Korean men', 13, 'AnyTop', 'true', 'false'),
(4, 'Solo Stool', '/tindahan.ph/assets/mock/products/product009.jpg', 1100.00, 'Stool best for the living room', 10, 'Cebu Foam', 'true', 'false'),
(4, 'Lifetime Outdoor Table for Big Families', '/tindahan.ph/assets/mock/products/product010.jpg', 800.00, 'Best for gatherings outdoors with friends and family.', 50, 'Lifetime', 'true', 'false'),
(5, 'Camilla Blouse', '/tindahan.ph/assets/mock/products/product011.jpg', 699.00, 'One size for all. For casual and semi-formal events', 10, 'Corals', 'true', 'false'),
(5, 'Sunshine Midi Skirt', '/tindahan.ph/assets/mock/products/product012.jpg', 749.00, 'Skirt that fits the picnic and cottage vibes', 25, 'Corals', 'true', 'false'),
(5, 'Kurt Polo Shirt', '/tindahan.ph/assets/mock/products/product013.jpg', 749.00, 'Closet staple for men', 17, 'Corals', 'true', 'false');

CREATE TABLE product_category_list(
  product_category_id      INT(7)              AUTO_INCREMENT,
  product_id               INT(5)              NOT NULL,
  category_id              INT(1)              NOT NULL,
  CONSTRAINT Category_List_PK PRIMARY KEY(product_category_id),
  CONSTRAINT Category_List_FK FOREIGN KEY(product_id) REFERENCES products(product_id),
  CONSTRAINT Category_Item_FK FOREIGN KEY(category_id) REFERENCES product_category(category_id)
);

INSERT INTO product_category_list(product_id, category_id) VALUES
(1, 8),
(2, 8),
(3, 9),
(4, 1),
(5, 6),
(6, 7),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 4),
(12, 4),
(13, 5);

CREATE TABLE product_review(
    review_id           INT(7)              AUTO_INCREMENT,
    product_id          INT(7)              NOT NULL,
    user_id             INT(5)              NOT NULL,
    rating              INT(1)              NOT NULL,
    timestamp           DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    review_msg          VARCHAR(250)                ,
    CONSTRAINT Product_Review_PK PRIMARY KEY(review_id),
    CONSTRAINT User_Review_FK FOREIGN KEY(user_id) REFERENCES users(user_id),
    CONSTRAINT Review_Product_FK FOREIGN KEY(product_id) REFERENCES products(product_id)
);

CREATE TABLE uploaded_img(
  uploaded_img_id           INT(7)              AUTO_INCREMENT,
  img_path                  VARCHAR(260)        NOT NULL,
  CONSTRAINT Uploaded_Img_PK PRIMARY KEY(uploaded_img_id)
);

CREATE TABLE image_collection(
  collection_id             INT(7)              AUTO_INCREMENT,
  uploaded                  DATETIME            NOT NULL,             
  uploaded_img_id           INT(7)              NOT NULL,
  CONSTRAINT Image_Collection_PK PRIMARY KEY(collection_id),
  CONSTRAINT Image_Collection_FK FOREIGN KEY(uploaded_img_id) REFERENCES uploaded_img(uploaded_img_id)
);

CREATE TABLE product_variation(
  variation_id      INT(7)            AUTO_INCREMENT,
  product_id        INT(5)            NOT NULL,
  variation         VARCHAR(100)      NOT NULL,
  price             DECIMAL(7, 2)     NOT NULL,
  quantity          INT(5)            NOT NULL,
  CONSTRAINT Product_Variation_PK PRIMARY KEY(variation_id),
  CONSTRAINT Product_Variation_FK FOREIGN KEY(product_id) REFERENCES products(product_id)
);

INSERT INTO product_variation(product_id, variation, price, quantity) VALUES
(1, 'Elmo', 650.00, 20),
(1, 'Cookie Monster', 700.00, 20),
(1, 'Big Bird', 650.00, 18),
(2, 'Peelable Banana', 400.00, 30),
(2, 'Un-Peelable Banana', 440.00, 30),
(3, 'Small', 70.00, 50),
(3, 'Medium', 70.00, 50),
(3, 'Large', 70.00, 50),
(5, 'Yellow Flowers', 200.00, 10),
(5, 'Pink Flowers', 200.00, 10),
(5, 'Purple Flowers', 200.00, 10),
(6, 'Aluminum', 1200.00, 20),
(6, 'Wooden Laminate', 1200.00, 20),
(6, 'Plain White', 1200.00, 20),
(8, 'Maknae Line', 750.00, 5),
(8, 'Hyung Line', 750.00, 5),
(8, 'OT7', 750.00, 3),
(11, 'Small', 699.00, 3),
(11, 'Medium', 699.99, 5),
(11, 'Large', 699.00, 2),
(12, 'Small', 749.00, 10),
(12, 'Medium', 749.00, 5),
(12, 'Large', 749.00, 10),
(13, 'Small', 749.00, 2),
(13, 'Medium', 749.00, 5),
(13, 'Large', 749.00, 10);

CREATE TABLE cart_items(
  cart_item_id            INT(7)              AUTO_INCREMENT,
  user_id                 INT(5)              NOT NULL,
  product_id              INT(5)              NOT NULL,
  variation_id            INT(7)              NOT NULL,
  quantity                INT(3)              NOT NULL,
  status                  ENUM('cart', 'ordered', 'removed') DEFAULT 'cart',
  CONSTRAINT Cart_PK PRIMARY KEY(cart_item_id),
  CONSTRAINT Cart_User_FK FOREIGN KEY(user_id) REFERENCES users(user_id),
  CONSTRAINT Cart_Product_FK FOREIGN KEY(product_id) REFERENCES products(product_id),
  CONSTRAINT Cart_Variation_FK FOREIGN KEY(variation_id) REFERENCES product_variation(variation_id)
);

CREATE TABLE orders(
  order_id                INT(7)              AUTO_INCREMENT,
  user_id                 INT(5)              NOT NULL,
  order_date_placed       DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
  order_recipient         VARCHAR(255)        NOT NULL,
  order_recipient_contact BIGINT(10)          NOT NULL,
  order_recipient_address VARCHAR(360)        NOT NULL,                        
  order_date_shipped      DATETIME                    ,
  order_date_fulfilled    DATETIME                    ,
  order_total_price       DECIMAL(7, 2)       NOT NULL,
  order_status            ENUM('processing', 'shipped', 'transit', 'delivered', 'cancelled') DEFAULT 'processing',
  CONSTRAINT Orders_PK PRIMARY KEY(order_id),
  CONSTRAINT Orders_FK FOREIGN KEY(user_id) REFERENCES users(user_id)
);

CREATE TABLE order_status(
  order_status            VARCHAR(20)         NOT NULL,
  order_status_msg        VARCHAR(100)                ,
  CONSTRAINT Order_Status_PK PRIMARY KEY(order_status)
);

INSERT INTO order_status(order_status, order_status_msg)
VALUES
('processing', 'Your order is being prepared.'),
('shipped', 'Your order has arrived in our sort center.'),
('transit', 'Your order is on the way. Be on the lookout for our courier.'),
('delivered', 'Your order has been delivered. Please leave a review for us to improve our services.'),
('cancelled', 'You cancelled your order.');

CREATE TABLE order_details(
  order_product_id        INT(7)              AUTO_INCREMENT,
  cart_item_id            INT(7)              NOT NULL,
  order_id                INT(7)              NOT NULL,           
  order_quantity          INT(3)              NOT NULL,
  order_price             DECIMAL(7, 2)       NOT NULL,
  review_id               INT(7)                      ,
  CONSTRAINT Order_Details_PK PRIMARY KEY(order_product_id),
  CONSTRAINT Order_Cart_FK FOREIGN KEY(cart_item_id) REFERENCES cart_items(cart_item_id),
  CONSTRAINT Order_FK FOREIGN KEY(order_id) REFERENCES orders(order_id),
  CONSTRAINT Order_Review_FK FOREIGN KEY(review_id) REFERENCES product_review(review_id)
);

CREATE TABLE vouchers(
  voucher_id              INT(5)              AUTO_INCREMENT,
  voucher_code            VARCHAR(15)         NOT NULL,
  voucher_type            ENUM('direct', 'percent') NOT NULL,
  voucher_discount        DECIMAL(6, 2)       NOT NULL,
  voucher_start           DATETIME            NOT NULL,
  voucher_end             DATETIME            NOT NULL,
  CONSTRAINT Vouchers_PK PRIMARY KEY(voucher_id)
);

INSERT INTO vouchers(voucher_code, voucher_type, voucher_discount, voucher_start, voucher_end)
VALUES
('FIRSTPURCHASE', 'direct', 100, NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY)),
('TINDAHANFRIENDS', 'percent', 10, NOW(), DATE_ADD(NOW(), INTERVAL 3 DAY)),
('HAPPYHOLIDAYS', 'direct', 300, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH));


CREATE TABLE invoice(
  invoice_id              INT(7)              AUTO_INCREMENT,
  order_id                INT(7)              NOT NULL,
  payment_method          ENUM('cod', 'card')         ,
  date_of_payment         DATETIME            DEFAULT NOW(),
  amount_to_pay           DECIMAL(7, 2)       NOT NULL,
  amount_paid             DECIMAL(7, 2)               ,
  CONSTRAINT Invoice_PK PRIMARY KEY(invoice_id),
  CONSTRAINT Invoice_FK FOREIGN KEY(order_id) REFERENCES orders(order_id)
);