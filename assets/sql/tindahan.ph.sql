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
('Hannah Ruth', 'Labana', '$2y$10$LGOaYoqXlK7SJfw73w3S9uOrp4C2yoxNqe.OZuUQyYc.jbPlrYrAC', '20102712@usc.edu.ph', NULL, NULL, 'admin', 'true', 'false', '2021-11-30 23:23:12');
('Nicholai', 'Oblina', '$2y$10$7rnCmYacPxaJrGV6eRuQJecIJGr18jXYzQqyfNZO9etWJU98bCBtO', '20102511@usc.edu.ph', NULL, NULL, 'admin', 'true', 'false', '2021-12-05 04:18:06');

-- USE THIS TO UPDATE THE AUTO_INCREMENT OF USERS, IF AUTO_INCREMENT FAILS
ALTER TABLE `users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

CREATE TABLE users_address(
  user_id           INT(5)            AUTO_INCREMENT,
  street            VARCHAR(150)                    ,
  city              VARCHAR(50)                     ,
  barangay          VARCHAR(50)                     ,
  region            VARCHAR(20)                     ,
  zipcode           INT(4)                          ,

  CONSTRAINT Users_Address_PK PRIMARY KEY(user_id),
  CONSTRAINT Users_Address_FK FOREIGN KEY(user_id) REFERENCES users(user_id)
);  

CREATE TABLE partner_store(
  store_id                INT(5)              AUTO_INCREMENT,
  user_id                 INT(5)              NOT NULL,
  store_name              VARCHAR(100)        NOT NULL,
  store_followers         INT(5)              DEFAULT 0,
  store_img               VARCHAR(260)        DEFAULT '/tindahan.ph/assets/partner/default-partner.jpg',
  store_rating            DECIMAL(2, 1)       DEFAULT 0.0,
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

-- CREATE TABLE products(
--   product_id              INT(5)              AUTO_INCREMENT,
--   product_name            VARCHAR(255)        NOT NULL,
--   product_img             VARCHAR(260)        NOT NULL,
--   product_price           DECIMAL(7, 2)       NOT NULL,
--   product_desc            VARCHAR(500)        NOT NULL,
--   CONSTRAINT Product_PK PRIMARY KEY(product_id)
-- );


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


-- CREATE TABLE product_category_list(
--   product_id                INT(5)              NOT NULL,
--   category_id               INT(2)              NOT NULL,
--   CONSTRAINT Category_List_PK PRIMARY KEY(product_id),
--   CONSTRAINT Category_List_FK PRIMARY KEY(product_id) REFERENCES products(product_id);
-- );

-- CREATE TABLE product_category(
--     product_category_id     INT(2)              AUTO_INCREMENT,
--     product_category_name   VARCHAR(30)         NOT NULL,
--     CONSTRAINT Product_Category_PK PRIMARY KEY(product_category_id)
-- );

-- ALTER TABLE product_category_list
-- ADD CONSTRAINT Category_List_FK FOREIGN KEY(category_id) REFERENCES product_category(product_category_id);

-- CREATE TABLE uploaded_img(
--   uploaded_img_id           INT(7)              AUTO_INCREMENT,
--   img_path                  VARCHAR(260)        NOT NULL,
--   CONSTRAINT Uploaded_Img_PK PRIMARY KEY(uploaded_img_id)
-- );

-- CREATE TABLE image_collection(
--   img_collection_id         INT(7)              AUTO_INCREMENT,
--   uploaded_img_id           INT(7)              NOT NULL,
--   CONSTRAINT Image_Collection_PK PRIMARY KEY(img_collection_id),
--   CONSTRAINT Image_Collection_FK FOREIGN KEY(uploaded_img_id) REFERENCES uploaded_img(uploaded_img_id)
-- );

-- CREATE TABLE product_review(
--     review_id           INT(7)              AUTO_INCREMENT,
--     user_id             INT(5)              NOT NULL,
--     img_collection_id   INT(7)                      ,
--     rating              INT(1)              NOT NULL,
--     timestamp           DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
--     review_msg          VARCHAR(250)                ,
--     CONSTRAINT Product_Review_PK PRIMARY KEY(review_id),
--     CONSTRAINT User_Review_FK FOREIGN KEY(user_id) REFERENCES USERS(user_id),
--     CONSTRAINT Review_Images_FK FOREIGN KEY(img_collection_id) REFERENCES image_collection(img_collection_id)
-- );

-- CREATE TABLE review_list(
--     product_id              INT(5)              NOT NULL,
--     product_review_id       INT(7)              NOT NULL,
--     CONSTRAINT Review_List_PK PRIMARY KEY(product_id),
--     CONSTRAINT Review_List_FK PRIMARY KEY(product_id) REFERENCES product(product_id),
--     CONSTRAINT Review_List_Product_FK FOREIGN KEY(product_review_id) REFERENCES product_review(review_id)
-- );

-- CREATE TABLE product_variation(
--     variation_id       INT(5)            NOT NULL,
--     variation         VARCHAR(100)      NOT NULL,
--     price             DECIMAL(7, 2)     NOT NULL,

--     CONSTRAINT Product_Variation_PK PRIMARY KEY(variation_id),
-- );

-- CREATE TABLE product_variation_list(
--   product_id          INT(5)            NOT NULL,
--   variation_id        INT(7)            NOT NULL,
--   CONSTRAINT Variation_List_PK PRIMARY KEY(product_id),
--   CONSTRAINT Variation_List_FK PRIMARY KEY(product_id) REFERENCES products(product_id),
--   CONSTRAINT Variation_FK FOREIGN KEY(variation_id) REFERENCES product_variation(variation_id)
-- );

-- CREATE TABLE PAYMENT(
--     payment_id              INT(10)             AUTO_INCREMENT,
--     invoice_id              INT(10)             NOT NULL,
--     user_id                 INT(5)              NOT NULL,
--     payment_method_id       INT(1)              NOT NULL,
--     payment_sum_total       DECIMAL(7, 2)       NOT NULL,
--     payment_status          ENUM('pending', 'cancelled', 'paid'),
--     payment_date            DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
--     CONSTRAINT Payment_PK PRIMARY KEY(payment_id),
--     CONSTRAINT User_Address_FK FOREIGN KEY(user_id) REFERENCES USER_ADDRESS(user_id)
-- );

-- CREATE TABLE PAYMENT_METHOD(
--     payment_method_id       INT(1)              AUTO_INCREMENT,
--     payment_type            VARCHAR(20)         NOT NULL,
--     CONSTRAINT Payment_Method_PK PRIMARY KEY(payment_method_id)
-- );

-- CREATE TABLE INVOICE(
--     invoice_id              INT(10)             AUTO_INCREMENT,
--     order_id                INT(10)             NOT NULL,
--     invoice_voucher         VARCHAR(10)                 ,
--     invoice_submit_date     DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
--     CONSTRAINT Invoice_PK PRIMARY KEY(invoice_id)
-- );

-- CREATE TABLE ORDERS(
--     order_id                INT(10)             AUTO_INCREMENT,
--     product_id              INT(5)              NOT NULL,
--     order_status            INT(1)              NOT NULL,
--     product_quantity        INT(3)              NOT NULL,
--     order_date_placed       DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
--     order_date_fulfilled    DATETIME                    ,
--     order_delivery_fee      DECIMAL(5, 2)       NOT NULL,
--     CONSTRAINT Order_PK PRIMARY KEY(order_id, product_id),
--     CONSTRAINT Product_Order_FK FOREIGN KEY(product_id) REFERENCES PRODUCT(product_id)
--     CONSTRAINT Order_Status_FK FOREIGN KEY(order_status) REFERENCES PRODUCT(status_id)
-- );

-- CREATE TABLE ORDER_STATUS(
--   status_id                 INT(1)              AUTO_INCREMENT,
--   status                    VARCHAR(10)         NOT NULL,
--   CONSTRAINT Order_Status_PK PRIMARY KEY(status_id)
-- );

-- ALTER TABLE INVOICE
-- ADD CONSTRAINT Order_Invoice_FK FOREIGN KEY(order_id) REFERENCES ORDERS(order_id);

-- CREATE TABLE CART(
--     cart_id                 INT(5)              AUTO_INCREMENT,
--     cart_contents_id        INT(5)              NOT NULL
--     CONSTRAINT Cart_PK PRIMARY KEY(cart_id),
-- );

-- CREATE TABLE CART_CONTENTS(
--   cart_contents_id          INT(5)              AUTO_INCREMENT,
--   product_id
-- );

-- CREATE TABLE USER_LOGS(
--     transaction_id          INT(10)             AUTO_INCREMENT,
--     user_id                 INT(5)              NOT NULL,
--     transaction_type        VARCHAR(20)         NOT NULL,
--     transaction_timestamp   DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
--     CONSTRAINT Transaction_PK PRIMARY KEY(transaction_id),
--     CONSTRAINT User_Logs_FK FOREIGN KEY(user_id) REFERENCES USERS(user_id)
-- );