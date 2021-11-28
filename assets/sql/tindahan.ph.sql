CREATE TABLE users(
  user_id           INT(5)            AUTO_INCREMENT,
  username          VARCHAR(50)       NOT NULL,
  password          VARCHAR(72)       NOT NULL,
  role              ENUM('admin', 'user', 'partner') NOT NULL,
  active            ENUM('true', 'false') NOT NULL DEFAULT 'true',
  user_img          VARCHAR(255)              ,
  last_login        DATETIME                  ,

  CONSTRAINT Users_PK PRIMARY KEY(user_id)
);

CREATE TABLE users_info(
  user_id           INT(5)            AUTO_INCREMENT,
  fname             VARCHAR(50)       NOT NULL,
  lname             VARCHAR(50)       NOT NULL,
  email             VARCHAR(320)      NOT NULL,

  CONSTRAINT Users_Info_PK PRIMARY KEY(user_id),
  CONSTRAINT Users_Info_FK FOREIGN KEY(user_id) REFERENCES users(user_id)
);

CREATE TABLE users_address(
  user_id           INT(5)            AUTO_INCREMENT,
  street            VARCHAR(100)                    ,
  city              VARCHAR(50)                     ,
  region            INT(2)                          ,
  zipcode           INT(4)                          ,

  CONSTRAINT Users_Address_PK PRIMARY KEY(user_id),
  CONSTRAINT Users_Address_FK FOREIGN KEY(user_id) REFERENCES users(user_id)
);

CREATE TABLE partner_store(
  store_id          INT(5)            AUTO_INCREMENT,
  partner_id        INT(5)            NOT NULL,
  inventory_id      INT(5)            NOT NULL,
  store_name        VARCHAR(100)      NOT NULL,
  store_rating      DECIMAL(2, 1)     DEFAULT 0.0,
  store_followers   INT(5)            DEFAULT 0,
  store_img         VARCHAR()                  ,

  CONSTRAINT Partner_Store_PK PRIMARY KEY(store_id),
  CONSTRAINT Partner_Store_User_FK FOREIGN KEY(partner_id) REFERENCES users(user_id)
);

CREATE TABLE product(
  product_id        INT(5)            AUTO_INCREMENT,
  category_id       INT(2)            NOT NULL,
  review_list_id    INT(5)                    ,

-- if instead of variation_id, we use product_id as variation PK
-- we can consider placing the variation in the inventory as well
-- iff we consider the bottom route
  variation_id      INT(2)            NOT NULL,            
  
  product_name      VARCHAR(255)      NOT NULL,
  product_img       VARCHAR(255)      NOT NULL,
  product_price     DECIMAL(7, 2)     NOT NULL,
  product_desc      TEXT(1000)        NOT NULL,

  -- in here or in inventory ???
  product_quantity  INT(4)            NOT NULL,
  product_status    ENUM("Out of Stock", "Available")

  CONSTRAINT Product_PK PRIMARY KEY(product_id)
);

CREATE TABLE product_category(
  category_id       INT(2)            AUTO_INCREMENT,
  category_name     VARCHAR(30)       NOT NULL,

  CONSTRAINT Product_Category_PK PRIMARY KEY(category_id)
);

CREATE TABLE product_review(
  review_id         INT(6)            AUTO_INCREMENT,
  reviewer_id       INT(5)            NOT NULL,
  product_rating    DECIMAL(2, 1)     NOT NULL,
  review_date       TIMESTAMP         DEFAULT CURRENT_TIMESTAMP,
  review_msg        VARCHAR(250)      ,

  CONSTRAINT Product_Review_PK PRIMARY KEY(review_id),
  CONSTRAINT Product_Review_FK FOREIGN KEY(reviewer_id) REFERENCES users(user_id)
);

CREATE TABLE product_review_list(
  product_id        INT(5)            NOT NULL,
  -- REVIEW NORMALIZATION RULES WHETHER TO USE PRODUCT_ID HERE OR NOT
  review_id         INT(6)            NOT NULL,

  CONSTRAINT Review_List_PK PRIMARY KEY(product_id),
  CONSTRAINT Review_List_Product_FK FOREIGN KEY(product_id) REFERENCES product(product_id),
  CONSTRAINT Review_List_Review_FK FOREIGN KEY(review_id) REFERENCES product_review(review_id)
);

CREATE TABLE product_variation(
  product_id        INT(5)            NOT NULL,
  variation         VARCHAR(100)      NOT NULL,
  price             DECIMAL(7, 2)     NOT NULL,
  quantity          INT(4)            NOT NULL,

  CONSTRAINT Product_Variation_PK PRIMARY KEY(product_id),
  CONSTRAINT Product_Variation_FK FOREIGN KEY(product_id) REFERENCES product(product_id)
);

ALTER TABLE product
ADD CONSTRAINT Product_FK FOREIGN KEY(category_id) REFERENCES product_category(category_id); 
