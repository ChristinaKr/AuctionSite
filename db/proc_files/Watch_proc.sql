DELIMITER $$

/**
* Returns an item from the watch list based on the user and item ID
*/
DROP PROCEDURE IF EXISTS p_Watch_sel_id$$
CREATE PROCEDURE p_Watch_sel_id(p_UserID CHAR(36), p_ItemID CHAR(36))
  BEGIN SET @p_UserID = p_UserID, @p_ItemID = p_ItemID;
    SELECT *
    FROM Watch
    WHERE UserID = @p_UserID AND ItemID = @p_ItemID;
  END$$

/**
* Deletes an item from the user's watch list based on the user and item ID
*/
DROP PROCEDURE IF EXISTS p_Watch_del_id$$
CREATE PROCEDURE p_Watch_del_id(p_UserID CHAR(36), p_ItemID CHAR(36))
  BEGIN SET @UserID = p_UserID, @ItemID = p_ItemID;
    DELETE FROM Watch
    WHERE UserID = @UserID AND ItemID = @ItemID;
  END$$

/**
* Adds an item on the user's watch list
*/
DROP PROCEDURE IF EXISTS p_Watch_ins$$
CREATE PROCEDURE p_Watch_ins(p_UserID CHAR(36), p_ItemID CHAR(36))
  BEGIN
    SET @UserID = p_UserID, @ItemID = p_ItemID;
    INSERT INTO Watch (UserID, ItemID, CreatedAt) VALUES (@UserID, @ItemID, NOW());
  END$$

/**
* Returns all items from the user's watch list based on the user's ID
*/
DROP PROCEDURE IF EXISTS p_Watch_sel_all_userid$$
CREATE PROCEDURE p_Watch_sel_all_userid(p_UserID CHAR(36))
  BEGIN SET @UserID = p_UserID;
    SELECT *
    FROM Watch
    WHERE UserID = @UserID;
  END$$

/**
* Returns all users that have a specific item on their watch lists
*/
DROP PROCEDURE IF EXISTS p_Watch_sel_all_from_item$$
CREATE PROCEDURE p_Watch_sel_all_from_item(p_ItemID CHAR(36))
  BEGIN SET @ItemID = p_ItemID;
    SELECT UserID
    FROM Watch
    WHERE ItemID = @ItemID;
  END$$
