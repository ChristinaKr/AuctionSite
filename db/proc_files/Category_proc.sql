DELIMITER $$

/**
* Lists all categories created
*/
DROP PROCEDURE IF EXISTS p_Category_sel_all$$
CREATE PROCEDURE p_Category_sel_all()
  BEGIN SELECT *
        FROM Category;
  END$$

/**
* Returns a certain category based on its ID
*/
DROP PROCEDURE IF EXISTS p_Category_sel_id$$
CREATE PROCEDURE p_Category_sel_id(p_ID INT(255))
  BEGIN SET @p_ID = p_ID;
    SELECT *
    FROM Category
    WHERE ID = @p_ID;
  END$$

/**
* Creates a new category
*/
DROP PROCEDURE IF EXISTS p_Category_ins$$
CREATE PROCEDURE p_Category_ins(Name VARCHAR(255))
  BEGIN SET @Name = Name;
    INSERT INTO Category (Name, CreatedAt) VALUES (@Name, NOW());
  END$$

/**
* Returns all information of items that are in a certain category
*/
DROP PROCEDURE IF EXISTS p_Category_sel_items$$
CREATE PROCEDURE p_Category_sel_items(p_ID INT(255))
  BEGIN SET @p_ID = p_ID;
    SELECT Item.*, CONCAT(User.FirstName, " ", User.LastName) AS SellerName, feedback.Rating AS SellerRating
    FROM Category
      LEFT JOIN ItemCategory ON Category.ID = ItemCategory.CategoryID
      LEFT JOIN Item ON ItemCategory.ItemID = Item.ID
      LEFT JOIN User ON User.ID = Item.SellerID
      LEFT JOIN (SELECT
                   ToUserID,
                   AVG(Rating) AS Rating
                 FROM Feedback
                 GROUP BY ToUserID) feedback
        ON feedback.ToUserID = Item.SellerID
    WHERE Category.ID = @p_ID;
  END$$
