CREATE DATABASE `tindahan.ph`;

USE `tindahan.ph`;

CREATE TABLE users(
  user_id           INT(5)            AUTO_INCREMENT,
  fname             VARCHAR(50)       NOT NULL,
  lname             VARCHAR(50)       NOT NULL,
  password          VARCHAR(72)       NOT NULL,
  email             VARCHAR(320)      NOT NULL,
  image             VARCHAR(260)              ,
  phone             BIGINT(10)                    ,
  role              ENUM('admin', 'user', 'partner') DEFAULT 'user',
  active            ENUM('true', 'false') DEFAULT 'true',
  suspended         ENUM('true', 'false') DEFAULT 'false',
  last_login        DATETIME          DEFAULT NOW(),

  CONSTRAINT Users_PK PRIMARY KEY(user_id)
);

-- USE THESE FOR THE ADMIN USERS 
INSERT INTO `users` (`fname`, `lname`, `password`, `email`, `image`, `phone`, `role`, `active`, `suspended`, `last_login`) VALUES
('Hans Maco', 'Cruz', '$2y$10$nFa3XOdT5LKlQ2FR53l/EuRDE5VfMJcSzgQS48oh3KMrdu8VFUsuC', '18103205@usc.edu.ph', NULL, NULL, 'admin', 'true', 'false', '2021-12-01 05:01:03'),
('Roque', 'Gelacio', '$2y$10$LGOaYoqXlK7SJfw73w3S9uOrp4C2yoxNqe.OZuUQyYc.jbPlrYrAC', '20100987@usc.edu.ph', NULL, NULL, 'admin', 'true', 'false', '2021-11-30 23:23:12'),
('Hannah Ruth', 'Labana', '$2y$10$LGOaYoqXlK7SJfw73w3S9uOrp4C2yoxNqe.OZuUQyYc.jbPlrYrAC', '20102712@usc.edu.ph', NULL, NULL, 'admin', 'true', 'false', '2021-11-30 23:23:12'),
('Nicholai Julian', 'Oblina', '$2y$10$7rnCmYacPxaJrGV6eRuQJecIJGr18jXYzQqyfNZO9etWJU98bCBtO', '20102511@usc.edu.ph', NULL, NULL, 'admin', 'true', 'false', '2021-12-05 04:18:06');

-- USE THIS TO UPDATE THE AUTO_INCREMENT OF USERS, IF AUTO_INCREMENT FAILS
ALTER TABLE `users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

CREATE TABLE users_address(
  user_id           INT(5)            AUTO_INCREMENT,
  street            VARCHAR(150)                    ,
  city              VARCHAR(50)                     ,
  barangay          VARCHAR(50)                     ,
landmark            VARCHAR(20)                     ,
  zipcode           INT(4)                          ,

  CONSTRAINT Users_Address_PK PRIMARY KEY(user_id),
  CONSTRAINT Users_Address_FK FOREIGN KEY(user_id) REFERENCES users(user_id)
);  

CREATE TABLE partner_store(
  store_id                INT(5)              AUTO_INCREMENT,
  user_id                 INT(5)              NOT NULL,
  store_name              VARCHAR(100)        NOT NULL,
  store_img               VARCHAR(260)        DEFAULT '/tindahan.ph/assets/partner/default-partner.jpg',
  store_description       VARCHAR(200)        NOT NULL,
  active                  ENUM('true', 'false') DEFAULT 'true',
  suspended               ENUM('true', 'false') DEFAULT 'false',
  CONSTRAINT Store_PK PRIMARY KEY(store_id),
  CONSTRAINT Store_User_FK FOREIGN KEY(user_id) REFERENCES users(user_id)
);

CREATE TABLE partner_applications(
  application_id          INT(5)                AUTO_INCREMENT,
  user_id                 INT(5)                NOT NULL,
  application_status      ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  store_name              VARCHAR(100)          NOT NULL,
  store_main_categ        VARCHAR(20)           NOT NULL,
  store_desc              VARCHAR(200)          NOT NULL,
  store_img               VARCHAR(260)          DEFAULT '/tindahan.ph/assets/partner/default-partner.jpg',
  online_experience       ENUM('yes', 'no')     NOT NULL,
  online_platforms        VARCHAR(100)                  ,
  CONSTRAINT Application_PK PRIMARY KEY(application_id),
  CONSTRAINT Application_User_FK FOREIGN KEY(user_id) REFERENCES users(user_id)
);

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

CREATE TABLE listing_categories(
  listing_category_id     INT(7)                AUTO_INCREMENT,
  application_id          INT(7)                NOT NULL,
  category_id             INT(1)                NOT NULL,
  CONSTRAINT Listing_Category_PK PRIMARY KEY(listing_category_id),
  CONSTRAINT Listing_Application_FK FOREIGN KEY(application_id) REFERENCES listing_application(application_id),
  CONSTRAINT Listing_Category_FK FOREIGN KEY(category_id) REFERENCES product_category(category_id)
);

CREATE TABLE listing_variations(
  listing_variation_id    INT(7)                AUTO_INCREMENT,
  application_id          INT(7)                NOT NULL,
  variation               VARCHAR(100)          NOT NULL,
  price                   DECIMAL(7, 2)         NOT NULL,
  quantity                INT(5)                NOT NULL,
  CONSTRAINT Listing_Variation_PK PRIMARY KEY(listing_variation_id),
  CONSTRAINT Listing_Variation_FK FOREIGN KEY(application_id) REFERENCES listing_application(application_id)  
);

CREATE TABLE product_category(
  category_id     INT(1)              AUTO_INCREMENT,
  category_name   VARCHAR(30)         NOT NULL,
  category_img    VARCHAR(260)        NOT NULL,
  CONSTRAINT Product_Category_PK PRIMARY KEY(category_id)
);

-- CATEGORY ENTRIES
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

CREATE TABLE product_category_list(
  product_category_id      INT(7)              AUTO_INCREMENT,
  product_id               INT(5)              NOT NULL,
  category_id              INT(1)              NOT NULL,
  CONSTRAINT Category_List_PK PRIMARY KEY(product_category_id),
  CONSTRAINT Category_List_FK FOREIGN KEY(product_id) REFERENCES products(product_id),
  CONSTRAINT Category_Item_FK FOREIGN KEY(category_id) REFERENCES product_category(category_id)
);

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

-- CREATE TABLE support_inbox(
--   ticket_id         INT(7)            AUTO_INCREMENT,
--   user_id           INT(5)            NOT NULL,
--   ticket_type       ENUM('report', 'bug', 'feedback'),
--   ticket_title      VARCHAR(50)       NOT NULL,
--   ticket_message    VARCHAR(500)      NOT NULL,
--   CONSTRAINT Support_Inbox_PK PRIMARY KEY(ticket_id),
--   CONSTRAINT Support_Inbox_Fk FOREIGN KEY(user_id) REFERENCES users(user_id)
-- );

-- CREATE TABLE user_reports(
--   report_id         INT(7)            AUTO_INCREMENT,
--   ticket_id         INT(7)            NOT NULL,
--   report_status     ENUM('approved', 'rejected', 'appealed')
--   CONSTRAINT User_Reports_PK PRIMARY KEY(report_id),
--   CONSTRAINT User_Reports_FK FOREIGN KEY(ticket_id) REFERENCES support_inbox(ticket_id)
-- );

-- CREATE TABLE user_suspensions(
--   suspension_id     INT(7)            AUTO_INCREMENT,
--   img_collection_id INT(7)            NOT NULL
--   report_id         INT(7)            NOT NULL,
--   start_date        DATETIME          NOT NULL,
--   end_date          DATETIME          NOT NULL,
--   message           VARCHAR(500)      NOT NULL,
--   CONSTRAINT User_Suspensions_PK PRIMARY KEY(suspension_id),
--   CONSTRAINT Suspensions_Img_FK FOREIGN KEY(img_collection_id) REFERENCES image_collection(img_collection_id),
--   CONSTRAINT Suspensions_Report_FK FOREIGN KEY(report_id) REFERENCES user_reports(report_id),
-- );

-- CREATE TABLE USER_LOGS(
--     transaction_id          INT(10)             AUTO_INCREMENT,
--     user_id                 INT(5)              NOT NULL,
--     transaction_type        VARCHAR(20)         NOT NULL,
--     transaction_timestamp   DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
--     CONSTRAINT Transaction_PK PRIMARY KEY(transaction_id),
--     CONSTRAINT User_Logs_FK FOREIGN KEY(user_id) REFERENCES USERS(user_id)
-- );


