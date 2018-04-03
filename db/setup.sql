SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS User;
CREATE TABLE User (
  ID        CHAR(36)            NOT NULL PRIMARY KEY,
  FirstName VARCHAR(255)        NOT NULL,
  LastName  VARCHAR(255)        NOT NULL,
  Email     VARCHAR(255) UNIQUE NOT NULL,
  Password  VARCHAR(255)        NOT NULL,
  CreatedAt DATETIME            NOT NULL
);


DROP TABLE IF EXISTS Category;
CREATE TABLE Category (
  ID        INT(255)     NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Name      VARCHAR(255) NOT NULL,
  CreatedAt DATETIME     NOT NULL
);

DROP TABLE IF EXISTS Item;
CREATE TABLE Item (
  ID              CHAR(36)     NOT NULL PRIMARY KEY,
  Name            VARCHAR(255) NOT NULL,
  Description     TEXT,
  AuctionStart    DATETIME     NOT NULL,
  AuctionEnd      DATETIME     NOT NULL,
  AuctionFinished DATETIME,
  StartingPrice   INT(13)      NOT NULL,
  ReservePrice    INT(13)      NOT NULL,
  FinalPrice      INT(13),
  PhotoURL        VARCHAR(255),
  SellerID        CHAR(36)     NOT NULL,
  BuyerID         CHAR(36), # TODO: this is new add to the tables in report
  Views           INT(255) DEFAULT 0,
  CreatedAt       DATETIME     NOT NULL,
  FOREIGN KEY (SellerID) REFERENCES User (ID), # TODO: this is new add to the tables in report
  FOREIGN KEY (BuyerID) REFERENCES User (ID)
);

DROP TABLE IF EXISTS Recommendation;
CREATE TABLE Recommendation (
  ID        CHAR(36) NOT NULL UNIQUE,
  UserID    CHAR(36) NOT NULL,
  ItemID    CHAR(36) NOT NULL,
  PRIMARY KEY (UserID, ItemID),
  CreatedAt DATETIME NOT NULL,
  FOREIGN KEY (UserID) REFERENCES User (ID),
  FOREIGN KEY (ItemID) REFERENCES Item (ID)
);

DROP TABLE IF EXISTS Watch;
CREATE TABLE Watch (
  UserID    CHAR(36) NOT NULL,
  ItemID    CHAR(36) NOT NULL,
  CreatedAt DATETIME NOT NULL,
  FOREIGN KEY (UserID) REFERENCES User (ID),
  FOREIGN KEY (ItemID) REFERENCES Item (ID)
);

DROP TABLE IF EXISTS Feedback;
CREATE TABLE Feedback (
  ID         CHAR(36) NOT NULL PRIMARY KEY,
  ToUserID   CHAR(36) NOT NULL,
  FromUserID CHAR(36) NOT NULL,
  ItemID     CHAR(36) NOT NULL,
  Rating     TINYINT,
  CreatedAt  DATETIME NOT NULL,
  FOREIGN KEY (ToUserID) REFERENCES User (ID),
  FOREIGN KEY (FromUserID) REFERENCES User (ID),
  FOREIGN KEY (ItemID) REFERENCES Item (ID)
);

DROP TABLE IF EXISTS Bid;
CREATE TABLE Bid (
  ID        CHAR(36) NOT NULL PRIMARY KEY,
  ItemID    CHAR(36) NOT NULL,
  UserID    CHAR(36) NOT NULL,
  BidAmount INT(13)  NOT NULL,
  CreatedAt DATETIME NOT NULL,
  FOREIGN KEY (UserID) REFERENCES User (ID),
  FOREIGN KEY (ItemID) REFERENCES Item (ID)
);

DROP TABLE IF EXISTS Admin;
CREATE TABLE Admin (
  UserID    CHAR(36) NOT NULL PRIMARY KEY,
  CreatedAt DATETIME NOT NULL,
  FOREIGN KEY (UserID) REFERENCES User (ID)
);

DROP TABLE IF EXISTS ItemCategory;
CREATE TABLE ItemCategory (
  ItemID     CHAR(36) NOT NULL,
  CategoryID CHAR(36) NOT NULL,
  CreatedAt  DATETIME NOT NULL,
  PRIMARY KEY (ItemID, CategoryID)
);

DROP TABLE IF EXISTS View;
CREATE TABLE View (
  UserID    CHAR(36) NOT NULL,
  ItemID    CHAR(36) NOT NULL,
  Count     INT(11)  NOT NULL,
  CreatedAt DATETIME NOT NULL,
  FOREIGN KEY (UserID) REFERENCES User (ID),
  FOREIGN KEY (ItemID) REFERENCES Item (ID)
);

# collab filtering
# Source: https://stackoverflow.com/questions/2440826/collaborative-filtering-in-mysql
DROP TABLE IF EXISTS oso_user_ratings;
CREATE TABLE IF NOT EXISTS oso_user_ratings (
  `user_id` CHAR(36)        NOT NULL,
  `item_id` CHAR(36)        NOT NULL,
  `rating`  DECIMAL(14, 4) NOT NULL DEFAULT '0.0000'
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS oso_slope_one;
CREATE TABLE IF NOT EXISTS oso_slope_one (
  `item_id1` CHAR(36)        NOT NULL,
  `item_id2` CHAR(36)        NOT NULL,
  `times`    INT(11)        NOT NULL,
  `rating`   DECIMAL(14, 4) NOT NULL
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

