DELIMITER $$
/**
* Gets the ID of the admin
*/
DROP PROCEDURE IF EXISTS p_Admin_sel_user_id$$
CREATE PROCEDURE p_Admin_sel_user_id
  (p_UserID CHAR(36))
  BEGIN
    SET @UserID = p_UserID;
    SELECT *
    FROM Admin
    WHERE UserID = @UserID;
  END$$

/**
* Deletes the admin based on the user ID
*/
DROP PROCEDURE IF EXISTS p_Admin_del_id$$
CREATE PROCEDURE p_Admin_del_id(p_UserID CHAR(36))
  BEGIN
    SET @UserID = p_UserID;
    DELETE FROM Admin
    WHERE UserID = @UserID;
  END$$

/**
* Creates a new admin based on the user ID
*/
DROP PROCEDURE IF EXISTS p_Admin_ins$$
CREATE PROCEDURE p_Admin_ins(UserID CHAR(36))
  BEGIN
    SET @UserID = UserID;
    INSERT INTO Admin (UserID, CreatedAt) VALUES (@UserID, NOW());
  END$$
