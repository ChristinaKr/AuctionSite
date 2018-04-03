DELIMITER $$

/**
* Returns all feedback given
*/
DROP PROCEDURE IF EXISTS p_Feedback_sel_all$$
CREATE PROCEDURE p_Feedback_sel_all()
  BEGIN SELECT *
        FROM Feedback;
  END$$

/**
* Returns a specific feedback based on who its from and the item
*/
DROP PROCEDURE IF EXISTS p_Feedback_sel$$
CREATE PROCEDURE p_Feedback_sel(p_FromUserID CHAR(36), p_ItemID CHAR(36))
  BEGIN SET @FromUserID = p_FromUserID;
    SET @ItemID = p_ItemID;
    SELECT *
    FROM Feedback
    WHERE ItemID  = @ItemID AND FromUserID = @FromUserID;
  END$$

/**
* Deletes a feedback based on its ID
*/
DROP PROCEDURE IF EXISTS p_Feedback_del_id$$
CREATE PROCEDURE p_Feedback_del_id(p_ID CHAR(36))
  BEGIN SET @ID = p_ID;
    DELETE FROM Feedback
    WHERE ID = @ID;
  END$$

/**
* Creates a new feedback entry
*/
DROP PROCEDURE IF EXISTS p_Feedback_ins$$
CREATE PROCEDURE p_Feedback_ins(ToUserID CHAR(36), FromUserID CHAR(36), ItemID CHAR(36), Rating TINYINT(4))
  BEGIN SET @ToUserID = ToUserID;
    SET @FromUserID = FromUserID;
    SET @ItemID = ItemID;
    SET @Rating = Rating;
    INSERT INTO Feedback (ToUserID, FromUserID, ItemID, Rating, CreatedAt)
    VALUES (@ToUserID, @FromUserID, @ItemID, @Rating, NOW());
  END$$

/**
* Calculate the average rating of the user
*/
DROP PROCEDURE IF EXISTS p_Feedback_calc_user$$
CREATE PROCEDURE p_Feedback_calc_user()
  BEGIN
    SELECT ToUserID, AVG(Rating) AS Rating
    FROM Feedback
    GROUP BY ToUserID;
  END$$