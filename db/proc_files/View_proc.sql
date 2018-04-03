DELIMITER $$
/**
* Views an item
*/
DROP PROCEDURE IF EXISTS p_View$$
CREATE PROCEDURE p_View(p_UserID VARCHAR(255),
                        p_ItemID VARCHAR(255))
  BEGIN SET @UserID = p_UserID;
    SET @ItemID = p_ItemID;
    START TRANSACTION;
    IF NOT EXISTS(SELECT *
                  FROM View
                  WHERE UserID = @UserID AND ItemID = @ItemID)
    THEN
      INSERT INTO View (UserID, ItemID, Count, CreatedAt) VALUES (@UserID, @ItemID, 0, NOW());
    END IF;

    UPDATE View
    SET Count = Count + 1
    WHERE UserID = @UserID AND ItemID = @ItemID;

    COMMIT;

  END$$

DROP PROCEDURE IF EXISTS p_View_init_filtering$$
CREATE PROCEDURE p_View_init_filtering()
  BEGIN
    DELETE FROM oso_user_ratings;
    INSERT INTO oso_user_ratings (user_id, item_id, rating)
      SELECT
        View.UserID,
        View.ItemID,
        View.Count / maxView.MaxView
      FROM View
        LEFT JOIN (SELECT
                     View.UserID,
                     MAX(Count) AS MaxView
                   FROM View
                   GROUP BY View.UserID) maxView ON View.UserID = maxView.UserId;

    COMMIT;

  END$$