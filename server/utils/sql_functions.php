<?php

/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 06/03/2018
 * Time: 13:13
 *
 */

/**
 * @param $conn
 * @param $UserID
 * @return mixed
 */
function p_Admin_sel_user_id($conn, $UserID)
{
    $stmt = $conn->prepare("CALL p_Admin_sel_user_id(?)");

    $stmt->execute([$UserID]);

    return $stmt;
}


/**
 * @param $conn
 * @param $UserID
 * @return mixed
 */
function p_Admin_del_id($conn, $UserID)
{
    $stmt = $conn->prepare("CALL p_Admin_del_id(?)");

    return $stmt->execute([$UserID]);
}


/**
 * @param $conn
 * @param $UserID
 * @return mixed
 */
function p_Admin_ins($conn, $UserID)
{
    $stmt = $conn->prepare("CALL p_Admin_ins(?)");

    return $stmt->execute([$UserID]);
}

/**
 * @param $conn
 * @return mixed
 */
function p_Bid_sel_all($conn)
{
    $stmt = $conn->prepare("CALL p_Bid_sel_all()");

    $stmt->execute([]);

    return $stmt;
}


/**
 * @param $conn
 * @param $ID
 * @return mixed
 */
function p_Bid_sel_id($conn, $ID)
{
    $stmt = $conn->prepare("CALL p_Bid_sel_id(?)");

    $stmt->execute([$ID]);

    return $stmt;
}

/**
 * @param $conn
 * @param $UserID
 * @return mixed
 */
function p_Bid_sel_user($conn, $UserID)
{
    $stmt = $conn->prepare("CALL p_Bid_sel_user(?)");

    $stmt->execute([$UserID]);

    return $stmt;
}

/**
 * @param $conn
 * @param $ItemID
 * @return mixed
 */
function p_Bid_sel_item($conn, $ItemID)
{
    $stmt = $conn->prepare("CALL p_Bid_sel_item(?)");

    $stmt->execute([$ItemID]);

    return $stmt;
}

/**
 * @param $conn
 * @param $ItemID
 * @return mixed
 */
function p_Bid_get_bidders_email($conn, $ItemID)
{
    $stmt = $conn->prepare("CALL p_Bid_get_bidders_email(?)");

    $stmt->execute([$ItemID]);

    return $stmt;
}


/**
 * @param $conn
 * @param $ID
 * @return mixed
 */
function p_Bid_del_id($conn, $ID)
{
    $stmt = $conn->prepare("CALL p_Bid_del_id(?)");

    return $stmt->execute([$ID]);
}


/**
 * @param $conn
 * @param $ItemID
 * @param $UserID
 * @param $BidAmount
 * @return mixed
 */
function p_Bid_ins($conn, $ItemID, $UserID, $BidAmount)
{
    $stmt = $conn->prepare("CALL p_Bid_ins( ?, ?, ?)");

    return $stmt->execute([$ItemID, $UserID, $BidAmount]);
}

/**
 * @param $conn
 * @param $ItemID
 * @return mixed
 */
function p_Bid_sel_largest($conn, $ItemID)
{
    $stmt = $conn->prepare("CALL p_Bid_sel_largest( ?)");

    $stmt->execute([$ItemID]);

    return $stmt;
}

/**
 * @param $conn
 * @return mixed
 */
function p_Category_sel_all($conn)
{
    $stmt = $conn->prepare("CALL p_Category_sel_all()");

    $stmt->execute([]);

    return $stmt;
}


/**
 * @param $conn
 * @param $ID
 * @return mixed
 */
function p_Category_sel_id($conn, $ID)
{
    $stmt = $conn->prepare("CALL p_Category_sel_id(?)");

    $stmt->execute([$ID]);

    return $stmt;
}


/**
 * @param $conn
 * @param $Name
 * @return mixed
 */
function p_Category_ins($conn, $Name)
{
    $stmt = $conn->prepare("CALL p_Category_ins(?)");

    return $stmt->execute([$Name]);
}

function p_Category_sel_items($conn, $ID)
{
    $stmt = $conn->prepare("CALL p_Category_sel_items(?)");

    $stmt->execute([$ID]);

    return $stmt;
}

/**
 * @param $conn
 * @return mixed
 */
function p_Feedback_sel_all($conn)
{
    $stmt = $conn->prepare("CALL p_Feedback_sel_all()");

    $stmt->execute([]);

    return $stmt;
}


/**
 * @param $conn
 * @param $ID
 * @return mixed
 */
function p_Feedback_sel($conn, $p_FromUserID, $p_ItemID)
{
    $stmt = $conn->prepare("CALL p_Feedback_sel(?, ?)");

    $stmt->execute([$p_FromUserID, $p_ItemID]);

    return $stmt;
}

/**
 * @param $conn
 * @param $UserID
 * @return mixed
 */
function p_Feedback_sel_user($conn, $UserID)
{
    $stmt = $conn->prepare("CALL p_Feedback_sel_user(?)");

    $stmt->execute([$UserID]);

    return $stmt;
}


/**
 * @param $conn
 * @param $ID
 * @return mixed
 */
function p_Feedback_del_id($conn, $ID)
{
    $stmt = $conn->prepare("CALL p_Feedback_del_id(?)");

    return $stmt->execute([$ID]);
}


/**
 * @param $conn
 * @param $ToUserID
 * @param $FromUserID
 * @param $ItemID
 * @param $Comment
 * @param $Rating
 * @return mixed
 */
function p_Feedback_ins($conn, $ToUserID, $FromUserID, $ItemID, $Rating)
{
    $stmt = $conn->prepare("CALL p_Feedback_ins(?, ?, ?, ?)");

    return $stmt->execute([$ToUserID, $FromUserID, $ItemID, $Rating]);
}


/**
 * @param $conn
 * @return mixed
 */
function p_Item_sel_all($conn)
{
    $stmt = $conn->prepare("CALL p_Item_sel_all()");

    $stmt->execute([]);

    return $stmt;
}

/**
 * @param $conn
 * @param $Search
 * @return mixed
 */
function p_Item_search($conn, $Search, $CategoryID)
{
    $stmt = $conn->prepare("CALL p_Item_search(?, ?)");

    $stmt->execute([$Search, $CategoryID]);

    return $stmt;
}


/**
 * @param $conn
 * @param $ID
 * @return mixed
 */
function p_Item_sel_id($conn, $ID)
{
    $stmt = $conn->prepare("CALL p_Item_sel_id(?)");

    $stmt->execute([$ID]);

    return $stmt;
}

function p_Items_bidded_on($conn, $UserID)
{
    $stmt = $conn->prepare("CALL p_Items_bidded_on(?)");

    $stmt->execute([$UserID]);

    return $stmt;
}


/**
 * @param $conn
 * @param $ID
 * @return mixed
 */
function p_Item_del_id($conn, $ID)
{
    $stmt = $conn->prepare("CALL p_Item_del_id(?)");

    return $stmt->execute([$ID]);
}


/**
 * @param $conn
 * @param $Name
 * @param $Description
 * @param $AuctionStart
 * @param $AuctionEnd
 * @param $StartingPrice
 * @param $ReservePrice
 * @param $PhotoURL
 * @param $SellerID
 * @param $CategoryID
 * @return mixed
 * @internal param $FinalPrice
 */
function p_Item_ins($conn, $Name, $Description, $AuctionStart, $AuctionEnd, $StartingPrice, $ReservePrice, $PhotoURL, $SellerID, $CategoryID)
{
    $stmt = $conn->prepare("CALL p_Item_ins(?, ?, ?, ?, ?, ?, ?, ?, ?)");

    return $stmt->execute([$Name, $Description, $AuctionStart, $AuctionEnd, $StartingPrice, $ReservePrice, $PhotoURL, $SellerID, $CategoryID]);
}

/**
 * @param $conn
 * @param $ID
 * @param $Name
 * @param $Description
 * @param $AuctionStart
 * @param $AuctionEnd
 * @param $AuctionFinished
 * @param $StartingPrice
 * @param $ReservePrice
 * @param $FinalPrice
 * @param $PhotoURL
 * @param $SellerID
 * @return mixed
 */
function p_Item_upd($conn, $ID, $Name, $Description, $AuctionStart, $AuctionEnd, $AuctionFinished, $StartingPrice, $ReservePrice, $FinalPrice, $PhotoURL, $SellerID)
{
    $stmt = $conn->prepare("CALL p_Item_upd(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    return $stmt->execute([$ID, $Name, $Description, $AuctionStart, $AuctionEnd, $AuctionFinished, $StartingPrice, $ReservePrice, $FinalPrice, $PhotoURL, $SellerID]);
}

function p_Item_upl_image($conn, $ID, $PhotoURL)
{
    $stmt = $conn->prepare("CALL p_Item_upl_image(?, ?)");

    return $stmt->execute([$ID, $PhotoURL]);
}

function p_Item_incr_views($conn, $ID)
{
    $stmt = $conn->prepare("CALL p_Item_incr_views(?)");

    return $stmt->execute([$ID]);
}

function p_Item_end_auctions($conn)
{
    $stmt = $conn->prepare("CALL p_Item_end_auctions()");
    $stmt->execute();
    return $stmt;
}

function p_Item_seller_id($conn, $SellerID)
{
    $stmt = $conn->prepare("CALL p_Item_seller_id(?)");
    $stmt->execute([$SellerID]);
    return $stmt;
}

/**
 * @param $conn
 * @return mixed
 */
function p_ItemCategory_sel_all($conn)
{
    $stmt = $conn->prepare("CALL p_ItemCategory_sel_all()");

    $stmt->execute([]);

    return $stmt;
}


/**
 * @param $conn
 * @param $ItemID
 * @param $CategoryID
 * @return mixed
 */
function p_ItemCategory_sel_id($conn, $ItemID, $CategoryID)
{
    $stmt = $conn->prepare("CALL p_ItemCategory_sel_id(?, ?)");

    $stmt->execute([$ItemID, $CategoryID]);

    return $stmt;
}


/**
 * @param $conn
 * @param $ItemID
 * @param $CategoryID
 * @return mixed
 */
function p_ItemCategory_del_id($conn, $ItemID, $CategoryID)
{
    $stmt = $conn->prepare("CALL p_ItemCategory_del_id(?, ?)");

    return $stmt->execute([$ItemID, $CategoryID]);
}


/**
 * @param $conn
 * @param $ItemID
 * @param $CategoryID
 * @return mixed
 */
function p_ItemCategory_ins($conn, $ItemID, $CategoryID)
{
    $stmt = $conn->prepare("CALL p_ItemCategory_ins(?, ?)");

    return $stmt->execute([$ItemID, $CategoryID]);
}


/**
 * @param $conn
 * @return mixed
 */
function p_Recommendation_sel_all($conn)
{
    $stmt = $conn->prepare("CALL p_Recommendation_sel_all()");

    $stmt->execute([]);

    return $stmt;
}


/**
 * @param $conn
 * @param $UserID
 * @param $ItemID
 * @return mixed
 */
function p_Recommendation_sel_id($conn, $UserID, $ItemID)
{
    $stmt = $conn->prepare("CALL p_Recommendation_sel_id(?, ?)");

    $stmt->execute([$UserID, $ItemID]);

    return $stmt;
}


/**
 * @param $conn
 * @param $UserID
 * @param $ItemID
 * @return mixed
 */
function p_Recommendation_del_id($conn, $UserID, $ItemID)
{
    $stmt = $conn->prepare("CALL p_Recommendation_del_id(?, ?)");

    return $stmt->execute([$UserID, $ItemID]);
}


/**
 * @param $conn
 * @param $UserID
 * @param $ItemID
 * @return mixed
 */
function p_Recommendation_ins($conn, $UserID, $ItemID)
{
    $stmt = $conn->prepare("CALL p_Recommendation_ins( ?, ?)");

    return $stmt->execute([$UserID, $ItemID]);
}


/**
 * @param $conn
 * @return mixed
 */
function p_User_sel_all($conn)
{
    $stmt = $conn->prepare("CALL p_User_sel_all()");

    $stmt->execute();

    return $stmt;
}


/**
 * @param $conn
 * @param $ID
 * @return mixed
 */
function p_User_sel_id($conn, $ID)
{
    $stmt = $conn->prepare("CALL p_User_sel_id(?)");

    $stmt->execute([$ID]);

    return $stmt;
}


/**
 * @param $conn
 * @param $ID
 * @return mixed
 */
function p_User_del_id($conn, $ID)
{
    $stmt = $conn->prepare("CALL p_User_del_id(?)");

    return $stmt->execute([$ID]);
}


/**
 * @param $conn
 * @param $FirstName
 * @param $LastName
 * @param $Email
 * @param $PasswordHash
 * @return mixed
 */
function p_User_ins($conn, $FirstName, $LastName, $Email, $PasswordHash)
{
    $stmt = $conn->prepare("CALL p_User_ins(?, ?, ?, ?)");


    return $stmt->execute([$FirstName, $LastName, $Email, $PasswordHash]);
}


/**
 * @param $conn
 * @param $ID
 * @param $FirstName
 * @param $LastName
 * @param $Email
 * @return mixed
 */
function p_User_upd($conn, $ID, $FirstName, $LastName, $Email)
{
    $stmt = $conn->prepare("CALL p_User_upd(?, ?, ?, ?)");

    return $stmt->execute([$ID, $FirstName, $LastName, $Email]);
}

/**
 * @param $conn
 * @param $ID
 * @param $FirstName
 * @param $LastName
 * @param $Email
 * @return mixed
 */
function p_User_login($conn, $Email, $PasswordHash)
{
    $stmt = $conn->prepare("CALL p_User_login(?, ?)");

    $stmt->execute([$Email, $PasswordHash]);

    return $stmt;
}


/**
 * @param $conn
 * @param $UserID
 * @param $ItemID
 * @return mixed
 */
function p_Watch_sel_id($conn, $UserID, $ItemID)
{
    $stmt = $conn->prepare("CALL p_Watch_sel_id(?, ?)");

    $stmt->execute([$UserID, $ItemID]);

    return $stmt;
}

/**
 * @param $conn
 * @param $UserID
 * @return mixed
 */
function p_Watch_sel_all_userid($conn, $UserID)
{
    $stmt = $conn->prepare("CALL p_Watch_sel_all_userid(?)");

    $stmt->execute([$UserID]);

    return $stmt;
}

/**
 * @param $conn
 * @param $UserID
 * @return mixed
 */
function p_Watch_sel_all_from_item($conn, $UserID)
{
    $stmt = $conn->prepare("CALL p_Watch_sel_all_from_item(?)");

    $stmt->execute([$UserID]);

    return $stmt;
}


/**
 * @param $conn
 * @param $UserID
 * @param $ItemID
 * @return mixed
 */
function p_Watch_del_id($conn, $UserID, $ItemID)
{
    $stmt = $conn->prepare("CALL p_Watch_del_id(?, ?)");

    return $stmt->execute([$UserID, $ItemID]);
}

/**
 * @param $conn
 * @param $UserID
 * @param $ItemID
 * @return mixed
 */
function p_Watch_ins($conn, $UserID, $ItemID)
{
    $stmt = $conn->prepare("CALL p_Watch_ins(?, ?)");

    return $stmt->execute([$UserID, $ItemID]);
}

function p_View($conn, $UserID, $ItemID)
{
    $stmt = $conn->prepare("CALL p_View(?, ?)");

    return $stmt->execute([$UserID, $ItemID]);
}
