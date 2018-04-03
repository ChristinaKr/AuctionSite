DELIMITER $$

/**
* Returns a list of all recommended items and users they are recommended to
*/
DROP PROCEDURE IF EXISTS p_Recommendation_sel_all$$
CREATE PROCEDURE p_Recommendation_sel_all()
  BEGIN SELECT *
        FROM Recommendation;
  END$$

/**
* TODO: Returns IDs of recommended items for a user based on viewed items (?)
*/
DROP PROCEDURE IF EXISTS p_Recommendation_sel_id$$
CREATE PROCEDURE p_Recommendation_sel_id(p_UserID CHAR(36), p_ItemID CHAR(36))
  BEGIN SET @p_UserID = p_UserID;
    SET @p_ItemID = p_ItemID;
    SELECT *
    FROM Recommendation
    WHERE UserID = @p_UserID AND ItemID = @p_ItemID;
  END$$

/**
* Deletes item recommendation based on the ID of the user and the item
*/
DROP PROCEDURE IF EXISTS p_Recommendation_del_id$$
CREATE PROCEDURE p_Recommendation_del_id(p_UserID CHAR(36), p_ItemID CHAR(36))
  BEGIN SET @p_UserID = p_UserID;
    SET @p_ItemID = p_ItemID;
    DELETE FROM Recommendation
    WHERE UserID = @p_UserID AND ItemID = @p_ItemID;
  END$$

/**
* Creates an item recommendation for a user
*/
DROP PROCEDURE IF EXISTS p_Recommendation_ins$$
CREATE PROCEDURE p_Recommendation_ins(IN p_UserID CHAR(36),
                                      IN p_ItemID CHAR(36))
  BEGIN
    INSERT INTO Recommendation (UserID,
                                ItemID, CreatedAt)
    VALUES
      (p_UserID,
       p_ItemID, NOW());
  END$$