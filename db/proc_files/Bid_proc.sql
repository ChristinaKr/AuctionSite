DELIMITER $$

/**
* Returns information about all bids
*/
DROP PROCEDURE IF EXISTS p_Bid_sel_all$$
CREATE PROCEDURE p_Bid_sel_all()
  BEGIN SELECT *
        FROM Bid;
  END$$

/**
* Returns all information about the largest bid
*/
DROP PROCEDURE IF EXISTS p_Bid_sel_largest$$
CREATE PROCEDURE p_Bid_sel_largest(p_ItemID INT(11))
  BEGIN SET @ItemID = p_ItemID;
    SELECT *
    FROM Bid
    WHERE ItemID = @ItemID
    ORDER BY Bid.BidAmount DESC
    LIMIT 1;
  END$$

/**
* Returns the information on one bid based on its ID
*/
DROP PROCEDURE IF EXISTS p_Bid_sel_id$$
CREATE PROCEDURE p_Bid_sel_id(p_ID INT(11))
  BEGIN SET @p_ID = p_ID;
    SELECT *
    FROM Bid
    WHERE ID = @p_ID;
  END$$

/**
* Returns all bids from one specific user based on the user ID
*/
DROP PROCEDURE IF EXISTS p_Bid_sel_user$$
CREATE PROCEDURE p_Bid_sel_user(p_UserID CHAR(36))
  BEGIN SET @UserID = p_UserID;
    SELECT *
    FROM Bid
    WHERE UserID = @UserID;
  END$$

/**
* Returns all bids for a specific item based on the item ID
*/
  DROP PROCEDURE IF EXISTS p_Bid_sel_item$$
  CREATE PROCEDURE p_Bid_sel_item(p_ItemID CHAR(36))
    BEGIN SET @ItemID = p_ItemID;
      SELECT *
      FROM Bid
      WHERE ItemID = @ItemID;
    END$$

/**
* Deletes a bid based on its ID
*/
DROP PROCEDURE IF EXISTS p_Bid_del_id$$
CREATE PROCEDURE p_Bid_del_id(p_ID INT(11))
  BEGIN SET @p_ID = p_ID;
    DELETE FROM Bid
    WHERE ID = @p_ID;
  END$$

/**
* Creates a bid
*/
DROP PROCEDURE IF EXISTS p_Bid_ins$$
CREATE PROCEDURE p_Bid_ins(ItemID CHAR(36), UserID CHAR(36), BidAmount INT(13))
  BEGIN
    SET @ItemID = ItemID;
    SET @UserID = UserID;
    SET @BidAmount = BidAmount;
    INSERT INTO Bid (ID, ItemID, UserID, BidAmount, CreatedAt)
    VALUES (UUID(), @ItemID, @UserID, @BidAmount, NOW());
  END$$

/**
* Get the distinct emails for those who have bid on the item
*/
DROP PROCEDURE IF EXISTS p_Bid_get_bidders_email$$
CREATE PROCEDURE p_Bid_get_bidders_email(ItemID CHAR(36))
  BEGIN
    SET @ItemID = ItemID;
    SELECT User.ID, User.Email FROM Bid
    LEFT JOIN User ON User.ID = Bid.UserID
      WHERE Bid.ItemID = @ItemID
    GROUP BY User.ID;
  END$$
