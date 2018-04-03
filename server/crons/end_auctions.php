<?php
/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 10/03/2018
 * Time: 18:11
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object file
include_once '../config/database.php';
include_once '../models/Item.php';
include_once '../models/User.php';
include_once '../utils/sql_functions.php';

//// get database connection
$database = new Database();
$db = $database->getConnection();


// check admin key, so only the cron job can call end auctions
if (getenv("ADMIN_SECRET_KEY") != $_POST["ADMIN_SECRET_KEY"]) {
// TODO: Die
}

# send emails
$stmt = p_Item_end_auctions($db);

// products array
$items_arr = array();
$items_arr["records"] = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    extract($row);

    $item_item = array(
        "ID" => $ID,
        "Name" => $Name,
        "SellerID" => $SellerID,
        "HighestBid" => $HighestBid,
        "BuyerID" => $BuyerID,
    );




    if ($BuyerID != null) {
        // item sold!
        $database2 = new Database();
        $db2 = $database2->getConnection();
        $seller = new User($db2);
        $seller->ID = $row["SellerID"];
        $seller->readOne();


        $database3 = new Database();
        $db3 = $database3->getConnection();
        $buyer = new User($db3);
        $buyer->ID = $BuyerID;
        $buyer->readOne();

        $seller->sendEmail($Name . " has been sold!", "Dear " . $seller->FirstName . ",\n\n" . "We are happy to tell you that your "
            . $Name . " has been sold to " . $buyer->FirstName . " " . $buyer->LastName . " for £" . ($HighestBid / 100) .
            ". Please email them to deal with payment and delivery: " . $buyer->Email
        );

        $buyer->sendEmail("You have successfully bidded for " . $Name, "Dear " . $buyer->FirstName . ",\n\n" . "We are happy to tell you that you have successfully bidded for "
            . $Name . " from " . $seller->FirstName . " " . $seller->LastName . " for £" . ($HighestBid / 100) .
            ". Please email them to deal with payment and delivery: " . $seller->Email
        );



    } else {
        $database2 = new Database();
        $db2 = $database2->getConnection();
        $seller = new User($db2);
        $seller->ID = $row["SellerID"];
        $seller->readOne();

        $sellerEmail = $seller->Email;

        $seller->sendEmail($Name . " auction has finished!", "Dear " . $seller->FirstName . ",\n\n" . "Your auction has finished but no bids were above the reserved price. Please relist your item to try again."
        );
    }


    array_push($items_arr["records"], $item_item);
}

echo json_encode($items_arr);