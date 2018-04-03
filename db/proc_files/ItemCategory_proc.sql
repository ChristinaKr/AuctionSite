DELIMITER $$

/**
* Returns a list of all items with corresponding category IDs
*/
DROP PROCEDURE IF EXISTS p_ItemCategory_sel_all$$
CREATE PROCEDURE p_ItemCategory_sel_all()
  BEGIN SELECT *
        FROM ItemCategory;
  END$$

/**
* TODO: Returns an item and its category based on the item and category ID (?)
*/
DROP PROCEDURE IF EXISTS p_ItemCategory_sel_id$$
CREATE PROCEDURE p_ItemCategory_sel_id(p_ItemID CHAR(36), p_CategoryID INT(255))
  BEGIN SET @p_ItemID = p_ItemID;
    SET @p_CategoryID = p_CategoryID;
    SELECT *
    FROM ItemCategory
    WHERE ItemID = @p_ItemID AND CategoryID = @p_CategoryID;
  END$$

/**
* Deletes a category from an item based on the item and category ID
*/
DROP PROCEDURE IF EXISTS p_ItemCategory_del_id$$
CREATE PROCEDURE p_ItemCategory_del_id(p_ItemID CHAR(36), p_CategoryID INT(255))
  BEGIN
    DELETE FROM ItemCategory
    WHERE ItemID = p_ItemID AND CategoryID = p_CategoryID;
  END$$

/**
* Assigns an item to a category
*/
DROP PROCEDURE IF EXISTS p_ItemCategory_ins$$
CREATE PROCEDURE p_ItemCategory_ins(p_ItemID CHAR(36), p_CategoryID INT(255))
  BEGIN
    INSERT INTO ItemCategory (ItemID, CategoryID, CreatedAt)
    VALUES
      (p_ItemID, p_CategoryID, NOW());
  END$$
