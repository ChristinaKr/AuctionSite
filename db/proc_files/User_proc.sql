DELIMITER $$

/**
* Returns a list of all registered users
*/
DROP PROCEDURE IF EXISTS p_User_sel_all$$
CREATE PROCEDURE p_User_sel_all()
  BEGIN SELECT *
        FROM User;
  END$$

/**
* Returns all information of a user based on his ID
*/
DROP PROCEDURE IF EXISTS p_User_sel_id$$
CREATE PROCEDURE p_User_sel_id(IN p_ID CHAR(36))
  BEGIN SET @p_ID = p_ID;
    SELECT
      ID,
      FirstName,
      LastName,
      Email
    FROM User
    WHERE ID = @p_ID;
  END$$

/**
* Deletes a user based on his ID
*/
DROP PROCEDURE IF EXISTS p_User_del_id$$
CREATE PROCEDURE p_User_del_id(p_ID CHAR(36))
  BEGIN SET @p_ID = p_ID;
    DELETE FROM User
    WHERE ID = @p_ID;
  END$$

/**
* Creates a new user
*/
DROP PROCEDURE IF EXISTS p_User_ins$$
CREATE PROCEDURE p_User_ins(p_FirstName VARCHAR(255),
                            p_LastName  VARCHAR(255),
                            p_Email     VARCHAR(255),
                            p_Password  VARCHAR(255)
)
  BEGIN
    INSERT INTO User (ID, FirstName, LastName, Email, Password, CreatedAt)
    VALUES (UUID(), p_FirstName, p_LastName, p_Email, p_Password, NOW());
  END$$

/**
* Updates a user's information based on his ID
*/
DROP PROCEDURE IF EXISTS p_User_upd$$
CREATE PROCEDURE p_User_upd(p_ID        CHAR(36),
                            p_FirstName VARCHAR(255),
                            p_LastName  VARCHAR(255),
                            p_Email     VARCHAR(255))
  BEGIN
    UPDATE User
    SET FirstName = p_FirstName,
      LastName    = p_LastName,
      Email       = p_Email
    WHERE ID = p_ID;
  END$$

/**
* Returns a user based on his password and email
*/
DROP PROCEDURE IF EXISTS p_User_login$$
CREATE PROCEDURE p_User_login(p_Email VARCHAR(255), p_PasswordHash VARCHAR(255))
  BEGIN SET @p_PasswordHash = p_PasswordHash;
    SET @p_Email = p_Email;
    SELECT *
    FROM User
    WHERE Password = @p_PasswordHash AND Email = @p_Email;
  END$$
