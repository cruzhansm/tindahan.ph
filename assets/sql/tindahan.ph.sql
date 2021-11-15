CREATE TABLE users(
  user_id           INT(6)            AUTO_INCREMENT,
  username          VARCHAR(50)       NOT NULL,
  password          VARCHAR(72)       NOT NULL,
  role              ENUM('admin', 'user', 'partner') NOT NULL,
  active            ENUM('true', 'false') NOT NULL DEFAULT 'true',
  last_login        DATETIME                  ,

  CONSTRAINT Users_PK PRIMARY KEY(user_id)
);

CREATE TABLE users_info(
  user_id           INT(6)            AUTO_INCREMENT,
  fname             VARCHAR(50)       NOT NULL,
  lname             VARCHAR(50)       NOT NULL,
  email             VARCHAR(320)      NOT NULL,

  CONSTRAINT Users_Info_PK PRIMARY KEY(user_id),
  CONSTRAINT Users_Info_FK FOREIGN KEY(user_id) REFERENCES users(user_id)
);

CREATE TABLE users_address(
  user_id           INT(6)            AUTO_INCREMENT,
  street            VARCHAR(100)                    ,
  city              VARCHAR(50)                     ,
  region            INT(2)                          ,
  zipcode           INT(4)                          ,

  CONSTRAINT Users_Address_PK PRIMARY KEY(user_id),
  CONSTRAINT Users_Address_FK FOREIGN KEY(user_id) REFERENCES users(user_id)
);