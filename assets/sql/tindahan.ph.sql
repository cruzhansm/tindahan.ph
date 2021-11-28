CREATE DATABASE `tindahan.ph`;

USE `tindahan.ph`;

CREATE TABLE users(
  user_id           INT(5)            AUTO_INCREMENT,
  username          VARCHAR(50)       NOT NULL,
  fname             VARCHAR(50)       NOT NULL,
  password          VARCHAR(72)       NOT NULL,
  lname             VARCHAR(50)       NOT NULL,
  email             VARCHAR(320)      NOT NULL,
  phone             INT(9)            NOT NULL,
  role              ENUM('admin', 'user', 'partner') NOT NULL,
  active            ENUM('true', 'false') NOT NULL DEFAULT 'true',
  last_login        DATETIME                  ,

  CONSTRAINT Users_PK PRIMARY KEY(user_id)
);

CREATE TABLE users_address(
  user_id           INT(5)            AUTO_INCREMENT,
  street            VARCHAR(150)                    ,
  city              VARCHAR(50)                     ,
  barangay          VARHCAR(50)                     ,
  region            VARCHAR(20)                     ,
  zipcode           INT(4)                          ,

  CONSTRAINT Users_Address_PK PRIMARY KEY(user_id),
  CONSTRAINT Users_Address_FK FOREIGN KEY(user_id) REFERENCES users(user_id)
);  

-- CREATE TABLE PARTNER_STORE(
--     store_id                INT(5)              AUTO_INCREMENT,
--     user_id                 INT(5)              NOT NULL,
--     store_inventory_id      INT(5)              NOT NULL,
--     store_name              VARCHAR(100)        NOT NULL,
--     store_followers         INT(5)              DEFAULT 0,
--     store_img               VARCHAR(260)                ,
--     store_rating            DECIMAL(2, 1)       DEFAULT 0.0,
--     store_description       VARCHAR(300)                ,
--     CONSTRAINT Pn_Store_PK PRIMARY KEY(pn_store_id),
--     CONSTRAINT User_Store_FK FOREIGN KEY(user_id) REFERENCES USERS(user_id)
-- );

-- CREATE TABLE PRODUCT(
--     product_id              INT(5)              AUTO_INCREMENT,
--     product_category_id     INT(2)              NOT NULL,
--     review_list_id          INT(5)                      ,
--     variation_id            INT(5)                      ,
--     product_name            VARCHAR(255)        NOT NULL,
--     product_img             VARCHAR(260)        NOT NULL,
--     product_price           DECIMAL(7, 2)       NOT NULL,
--     product_desc            VARCHAR(500)        NOT NULL,
--     CONSTRAINT Product_PK PRIMARY KEY(product_id)
-- );

-- CREATE TABLE product_variation(
--     variation_id      INT(5)            AUTO_INCREMENT
--     product_id        INT(5)            NOT NULL,
--     variation         VARCHAR(100)      NOT NULL,
--     price             DECIMAL(7, 2)     NOT NULL,
--     quantity          INT(4)            NOT NULL,

--     CONSTRAINT Product_Variation_PK PRIMARY KEY(variation_id, product_id),
--     CONSTRAINT Product_Variation_FK FOREIGN KEY(product_id) REFERENCES product(product_id)
-- );

-- CREATE TABLE PRODUCT_CATEGORY(
--     product_category_id     INT(2)              AUTO_INCREMENT,
--     product_category_name   VARCHAR(30)         NOT NULL,
--     CONSTRAINT Product_Category_PK PRIMARY KEY(product_category_id)
-- );

-- CREATE TABLE PRODUCT_REVIEW(
--     review_id       INT(7)              AUTO_INCREMENT,
--     user_id         INT(5)              NOT NULL,
--     rating          INT(1)              NOT NULL,
--     review_date     DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
--     review_msg      VARCHAR(250)                ,
--     CONSTRAINT Product_Review_PK PRIMARY KEY(review_id),
--     CONSTRAINT User_Review_FK FOREIGN KEY(user_id) REFERENCES USERS(user_id)
-- );

-- CREATE TABLE PRODUCT_REVIEW_IMAGES(
--   review_id         INT(7)              NOT NULL,
--   review_img_id             INT(1)              AUTO_INCREMENT,
--   review_img_path           VARCHAR(260)        NOT NULL,
--   CONSTRAINT Review_Images_PK PRIMARY KEY(review_id, review_img_id),
--   CONSTRAINT Review_Images_FK FOREIGN KEY(review_id)
-- );

-- CREATE TABLE STORE_INVENTORY(
--     store_inventory_id      INT(5)              AUTO_INCREMENT,
--     product_id              INT(5)              NOT NULL,
--     last_updated            DATETIME            NOT NULL ON UPDATE CURRENT_TIMESTAMP,
--     product_stock_count     INT(5)              NOT NULL,
--     CONSTRAINT Store_Inventory_PK PRIMARY KEY(store_inventory_id, product_id),
--     CONSTRAINT Product_Inventory_FK FOREIGN KEY(product_id) REFERENCES PRODUCT(product_id)
-- );

-- CREATE TABLE REVIEW_LIST(
--     review_list_id          INT(7)              AUTO_INCREMENT,
--     product_review_id       INT(7)              NOT NULL,
--     CONSTRAINT Review_List_PK PRIMARY KEY(review_list_id),
--     CONSTRAINT Product_Review_FK FOREIGN KEY(product_review_id) REFERENCES PRODUCT_REVIEW(product_review_id)
-- );

-- ALTER TABLE PARTNER_STORE
-- ADD CONSTRAINT Store_Inventory_FK FOREIGN KEY(store_inventory_id) REFERENCES STORE_INVENTORY(store_inventory_id);

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