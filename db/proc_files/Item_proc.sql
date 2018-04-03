DELIMITER $$

/**
* Returns all created items
*/
DROP PROCEDURE IF EXISTS p_Item_sel_all$$
CREATE PROCEDURE p_Item_sel_all()
  BEGIN SELECT
          Item.ID                                    AS ID,
          Item.Name                                  AS Name,
          Item.Description                           AS Description,
          Item.AuctionStart                          AS AuctionStart,
          Item.AuctionEnd                            AS AuctionEnd,
          Item.AuctionFinished                       AS AuctionFinished,
          Item.StartingPrice                         AS StartingPrice,
          Item.ReservePrice                          AS ReservePrice,
          Item.FinalPrice                            AS FinalPrice,
          Item.PhotoURL                              AS PhotoURL,
          Item.SellerID                              AS SellerID,
          Item.BuyerID                               AS BuyerID,
          Item.Views                                 AS Views,
          Item.CreatedAt                             AS CreatedAt,
          CONCAT(User.FirstName, ' ', User.LastName) AS SellerName,
          feedback.Rating                            AS SellerRating,
          ItemCategory.CategoryID                    AS CategoryID,
          bid.LargestBid                             AS LargestBid
        FROM Item
          LEFT JOIN User ON Item.SellerID = User.ID
          LEFT JOIN (SELECT
                       ToUserID,
                       AVG(Rating) AS Rating
                     FROM Feedback
                     GROUP BY ToUserID) feedback ON feedback.ToUserID = Item.SellerID
          LEFT JOIN ItemCategory ON ItemCategory.ItemID = Item.ID
          LEFT JOIN (SELECT
                       Bid.ItemID,
                       MAX(BidAmount) AS LargestBid
                     FROM Bid
                     GROUP BY Bid.ItemID) bid ON bid.ItemID = Item.ID;
  END$$

/**
* Allows to search through all created items based on their name,
* their description or their finished status and returns a list of those
* TODO: check
*/
DROP PROCEDURE IF EXISTS p_Item_search$$
CREATE PROCEDURE p_Item_search(p_Query CHAR(40), p_CategoryID INT(255))
  BEGIN SET @query = CONCAT('%', p_Query, '%');
    SET @CategoryID = p_CategoryID;
    SELECT
      Item.ID                                    AS ID,
      Item.Name                                  AS Name,
      Item.Description                           AS Description,
      Item.AuctionStart                          AS AuctionStart,
      Item.AuctionEnd                            AS AuctionEnd,
      Item.AuctionFinished                       AS AuctionFinished,
      Item.StartingPrice                         AS StartingPrice,
      Item.ReservePrice                          AS ReservePrice,
      Item.FinalPrice                            AS FinalPrice,
      Item.PhotoURL                              AS PhotoURL,
      Item.SellerID                              AS SellerID,
      Item.BuyerID                               AS BuyerID,
      Item.Views                                 AS Views,
      Item.CreatedAt                             AS CreatedAt,
      CONCAT(User.FirstName, ' ', User.LastName) AS SellerName,
      feedback.Rating                            AS SellerRating,
      ItemCategory.CategoryID                    AS CategoryID,
      bid.LargestBid                             AS LargestBid
    FROM Item
      LEFT JOIN User ON Item.SellerID = User.ID
      LEFT JOIN (SELECT
                   ToUserID,
                   AVG(Rating) AS Rating
                 FROM Feedback
                 GROUP BY ToUserID) feedback ON feedback.ToUserID = User.ID
      LEFT JOIN ItemCategory ON ItemCategory.ItemID = Item.ID
      LEFT JOIN (SELECT
                   Bid.ItemID,
                   MAX(BidAmount) AS LargestBid
                 FROM Bid
                 GROUP BY Bid.ItemID) bid ON bid.ItemID = Item.ID
    WHERE Item.Name LIKE @query OR Item.Description LIKE @query
                                   AND Item.AuctionFinished IS NOT NULL
                                   AND (@CategoryID IS NULL OR @CategoryID = ItemCategory.CategoryID);
  END$$

/**
* Returns a specific item based on its ID
*/
DROP PROCEDURE IF EXISTS p_Item_sel_id$$
CREATE PROCEDURE p_Item_sel_id(p_ID CHAR(36))
  BEGIN SET @p_ID = p_ID;
    SELECT
      Item.ID                                    AS ID,
      Item.Name                                  AS Name,
      Item.Description                           AS Description,
      Item.AuctionStart                          AS AuctionStart,
      Item.AuctionEnd                            AS AuctionEnd,
      Item.AuctionFinished                       AS AuctionFinished,
      Item.StartingPrice                         AS StartingPrice,
      Item.ReservePrice                          AS ReservePrice,
      Item.FinalPrice                            AS FinalPrice,
      Item.PhotoURL                              AS PhotoURL,
      Item.SellerID                              AS SellerID,
      Item.BuyerID                               AS BuyerID,
      Item.Views                                 AS Views,
      Item.CreatedAt                             AS CreatedAt,
      CONCAT(User.FirstName, ' ', User.LastName) AS SellerName,
      feedback.Rating                            AS SellerRating,
      ItemCategory.CategoryID                    AS CategoryID,
      bid.LargestBid                             AS LargestBid
    FROM Item
      LEFT JOIN User ON Item.SellerID = User.ID
      LEFT JOIN (SELECT
                   ToUserID,
                   AVG(Rating) AS Rating
                 FROM Feedback
                 GROUP BY ToUserID) feedback ON feedback.ToUserID = User.ID
      LEFT JOIN ItemCategory ON ItemCategory.ItemID = Item.ID
      LEFT JOIN (SELECT
                   Bid.ItemID,
                   MAX(BidAmount) AS LargestBid
                 FROM Bid
                 GROUP BY Bid.ItemID) bid ON bid.ItemID = Item.ID
    WHERE Item.ID = @p_ID;
  END$$

/**
* Deletes an item based on its ID
*/
DROP PROCEDURE IF EXISTS p_Item_del_id$$
CREATE PROCEDURE p_Item_del_id(p_ID CHAR(36))
  BEGIN SET @ID = p_ID;
    START TRANSACTION;
    DELETE FROM Bid WHERE ItemID = @ID;
    DELETE FROM View WHERE ItemID = @ID;
    DELETE FROM ItemCategory WHERE ItemID = @ID;
    DELETE FROM Feedback WHERE ItemID = @ID;
    DELETE FROM Item WHERE ID = @ID;
    COMMIT;
  END$$

/**
* Creates a new item // TODO: Add more detail
*/
DROP PROCEDURE IF EXISTS p_Item_ins$$
CREATE PROCEDURE p_Item_ins(Name         VARCHAR(255), Description TEXT,
                            AuctionStart DATETIME, AuctionEnd DATETIME, StartingPrice INT(13),
                            ReservePrice INT(13), PhotoURL VARCHAR(255),
                            SellerID     CHAR(36), CategoryID CHAR(36))
  BEGIN
    SET @Name = Name;
    SET @Description = Description;
    SET @AuctionStart = AuctionStart;
    SET @AuctionEnd = AuctionEnd;
    SET @StartingPrice = StartingPrice;
    SET @ReservePrice = ReservePrice;
    SET @PhotoURL = PhotoURL;
    SET @SellerID = SellerID;
    SET @CategoryID = CategoryID;
    SET @UUID = UUID();
    INSERT INTO Item (ID, Name, Description, AuctionStart, AuctionEnd, StartingPrice, ReservePrice, PhotoURL, SellerID, CreatedAt)
    VALUES
      (@UUID, @Name, @Description, @AuctionStart, @AuctionEnd, @StartingPrice, @ReservePrice, @PhotoURL, @SellerID,
       NOW());
    IF (CategoryID IS NOT NULL)
    THEN
      CALL p_ItemCategory_ins(@UUID, @CategoryID);
    END IF;
  END$$

/**
* Updates the values of an item based on its ID
*/
DROP PROCEDURE IF EXISTS p_Item_upd$$
CREATE PROCEDURE p_Item_upd(p_ID           CHAR(36), p_Name VARCHAR(255), p_Description TEXT, p_AuctionStart DATETIME,
                            p_AuctionEnd   DATETIME, p_AuctionFinished DATETIME, p_StartingPrice INT(13),
                            p_ReservePrice INT(13), p_FinalPrice INT(13), p_PhotoURL VARCHAR(255),
                            p_SellerID     CHAR(36))
  BEGIN SET @p_ID = p_ID;
    UPDATE Item
    SET ID         = p_ID, Name = p_Name, Description = p_Description, AuctionStart = p_AuctionStart,
      AuctionEnd   = p_AuctionEnd, AuctionFinished = p_AuctionFinished, StartingPrice = p_StartingPrice,
      ReservePrice = p_ReservePrice, FinalPrice = p_FinalPrice, PhotoURL = p_PhotoURL, SellerID = p_SellerID
    WHERE ID = @p_ID;
  END$$

/**
* Increments the view counter of an item by 1
*/
DROP PROCEDURE IF EXISTS p_Item_incr_views$$
CREATE PROCEDURE p_Item_incr_views(p_ID CHAR(36))
  BEGIN SET @p_ID = p_ID;
    UPDATE Item
    SET Views = Views + 1
    WHERE ID = @p_ID;
  END$$

/**
* Returns all items a user sells based on his ID
*/
DROP PROCEDURE IF EXISTS p_Item_seller_id$$
CREATE PROCEDURE p_Item_seller_id(p_SellerID CHAR(36))
  BEGIN SET @SellerID = p_SellerID;
    SELECT *
    FROM Item
    WHERE SellerID = @SellerID;
  END$$

/**
* Returns all items that a user has bid on. TODO: More detail
*/
DROP PROCEDURE IF EXISTS p_Items_bidded_on$$
CREATE PROCEDURE p_Items_bidded_on(p_UserID CHAR(36))
  BEGIN SET @UserID = p_UserID;
    SELECT
      Item.ID              AS ID,
      Item.Name            AS Name,
      Item.Description     AS Description,
      Item.AuctionStart    AS AuctionStart,
      Item.AuctionEnd      AS AuctionEnd,
      Item.AuctionFinished AS AuctionFinished,
      Item.StartingPrice   AS StartingPrice,
      Item.ReservePrice    AS ReservePrice,
      Item.FinalPrice      AS FinalPrice,
      Item.PhotoURL        AS PhotoURL,
      Item.SellerID        AS SellerID,
      Item.BuyerID         AS BuyerID,
      Item.Views           AS Views,
      seller.Name          AS SellerName,
      feedback.Rating      AS SellerFeedback,
      bid.BidAmount        AS HighestBid,
      bid.CreatedAt        AS CreatedAt

    FROM Item

      INNER JOIN (SELECT
                    Bid.ItemID,
                    MAX(BidAmount) AS HighestBid
                  FROM Bid
                  WHERE Bid.UserID = @UserID
                  GROUP BY Bid.ItemID) AS maxBid
        ON Item.ID = maxBid.ItemID

      INNER JOIN (SELECT Bid.*
                  FROM Bid
                  WHERE Bid.UserID = @UserID) bid ON bid.BidAmount = maxBid.HighestBid


      # Get the sellers name
      LEFT JOIN (SELECT
                   User.ID,
                   CONCAT(User.FirstName, ' ', User.LastName) AS Name
                 FROM User) seller
        ON seller.ID = Item.SellerID
      # Get the Sellers rating
      LEFT JOIN (SELECT
                   ToUserID,
                   AVG(Rating) AS Rating
                 FROM Feedback
                 GROUP BY ToUserID) feedback
        ON feedback.ToUserID = Item.SellerID;
  END$$

/**
* Ends an auction once its ending time has passed, checks whether the highest
* bid is above the reserve price and updates the bid to show its final price
* and highest bidder. If the highest bid is below the reserve price, the item is
* not sold.
* TODO: check this!
*/
DROP PROCEDURE IF EXISTS p_Item_end_auctions$$
CREATE PROCEDURE p_Item_end_auctions()
  BEGIN
    SET autocommit = 0;


    CREATE TEMPORARY TABLE EndingAuctions (
      ID         CHAR(36),
      Name       VARCHAR(255),
      PhotoURL   VARCHAR(255),
      SellerID   CHAR(36),
      SellerName VARCHAR(255),
      HighestBid INT(13),
      BuyerID    CHAR(36),
      AuctionFinished DATETIME
    );

    START TRANSACTION;

    INSERT INTO EndingAuctions SELECT
                                 item.ID                                    AS ID,
                                 item.Name                                  AS Name,
                                 item.PhotoURL                              AS PhotoURL,
                                 item.SellerID                              AS SellerID,
                                 CONCAT(User.FirstName, ' ', User.LastName) AS SellerName,
                                 item.AuctionFinished,
                                 CASE
                                 WHEN bid.highestBid > item.ReservePrice
                                   THEN bid.highestBid
                                 ELSE NULL END                              AS 'HighestBid',
                                 CASE WHEN bid.highestBid > item.ReservePrice
                                   THEN bid.UserID
                                 ELSE NULL END                              AS 'BuyerID'
                               FROM Item AS item
                                 LEFT JOIN (
                                             SELECT
                                               MAX(Bid.BidAmount) AS highestBid,
                                               Bid.UserID,
                                               Bid.ItemID
                                             FROM Bid
                                             GROUP BY Bid.ItemID
                                           ) bid
                                   ON bid.ItemID = item.ID
                                 LEFT JOIN User ON item.SellerID = User.ID
                               WHERE
                                 item.AuctionFinished IS NULL
                                 AND item.AuctionEnd < now();

    UPDATE Item
      INNER JOIN EndingAuctions
        ON Item.ID = EndingAuctions.ID
    SET
      Item.AuctionFinished = now(),

      Item.FinalPrice      = EndingAuctions.HighestBid,

      Item.BuyerID         = EndingAuctions.BuyerID;

    # Return the finished auctions
    SELECT *
    FROM EndingAuctions;
    COMMIT;
  END$$

/**
* Adds an image to an item
*/
DROP PROCEDURE IF EXISTS p_Item_upl_image$$
CREATE PROCEDURE p_Item_upl_image(p_ID CHAR(36), p_PhotoURL VARCHAR(255))
  BEGIN SET @p_ID = p_ID, @p_PhotoURL = p_PhotoURL;
    UPDATE Item
    SET PhotoURL = @p_PhotoURL
    WHERE ID = @p_ID;
  END$$
