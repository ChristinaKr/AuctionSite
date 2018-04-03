<?php
/**
 * Created by PhpStorm.
 * bid: lukeharries
 * Date: 14/02/2018
 * Time: 14:35
 * Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate bid object
include_once '../models/Bid.php';
include_once '../models/Item.php';
include_once '../models/User.php';

include_once '../utils/sql_functions.php';

// check that the user is logged in and set session id
//include_once '../utils/auth.php';

// validations
include_once '../utils/validation.php';

$database = new Database();
$db = $database->getConnection();

$bid = new Bid($db);

// set bid property values
$bid->ItemID = $_POST["ItemID"];
$bid->BidAmount = $_POST["BidAmount"];
$bid->UserID = $_POST["UserID"];

// check they are that user
// TODO Enable
//check_UserID($bid->UserID);

//check they are not the buyer
$database2 = new Database();
$db2 = $database2->getConnection();
$item = new Item($db2);
$item->ID = $bid->ItemID;
$item->readOne();
if ($item->SellerID == $bid->UserID) {
    die('{"message": "You cannot bid on your own item.","valid": false}');
}

// TODO: Check the auction is still live

// validations
validate_positive_int($bid->BidAmount, "BidAmount");

// check that the new bid is higher than the previous bid
$largest_bid = Bid::largest_bid($db, $bid->ItemID);

if (($largest_bid && $largest_bid >= $bid->BidAmount)) {
    die('{"message": "To bid it must be higher than all previous bids."}');
}

if (($item->StartingPrice > $bid->BidAmount)) {
    die('{"message": "To bid it must be higher than the starting bid."}');
}

// TODO: Check that auction is live
//
// send email to seller
$database3 = new Database();
$db3 = $database3->getConnection();
$seller = new User($db3);
$seller->ID = $item->SellerID;
$seller->readOne();

$seller->sendEmail($item->Name . " has a new bid!", "Dear " . $seller->FirstName . ",\n\n" . "We are happy to tell you that your "
    . $item->Name . " has a new bid for £" . ($bid->BidAmount / 100) . "\n\n" . "So far there are " . $item->Views . " views on your item!\n\n" .
    '<img src="http://52.232.32.194/' . $item->PhotoURL . '">'
);


$database4 = new Database();
$db4 = $database4->getConnection();
// alert other bidders
$stmt = p_Bid_get_bidders_email($db4, $bid->ItemID);
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        if ($ID != $bid->UserID) {
            send_email($Email, "You have been outbid!", "You have been outbid for the following item: " . $item->Name . "\n\n" .  '<img src="http://52.232.32.194/' . $item->PhotoURL . '">');

        }
    }
}

// todo: Email other watchers


//$bid->created = date('Y-m-d H:i:s');

// create the bid
if ($bid->create()) {
    echo '{';
    echo '"message": "bid was created.",';
    echo '"valid": true';
    echo '}';
} // if unable to create the bid, tell the bid
else {
    echo '{';
    echo '"message": "Unable to create bid."';
    echo '}';
}
