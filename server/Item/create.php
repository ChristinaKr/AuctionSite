<?php
/**
 * Created by PhpStorm.
 * Item: lukeharries
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

// instantiate item object
include_once '../models/Item.php';

// check that the user is logged in and set session id
// TODO Enable
//include_once '../utils/auth.php';

// validations
include_once '../utils/validation.php';

$database = new Database();
$db = $database->getConnection();

$item = new Item($db);


// set item property values
$item->Name = $_POST["Name"];
$item->Description = $_POST["Description"];
$item->AuctionStart = $_POST["AuctionStart"];
$item->AuctionEnd = $_POST["AuctionEnd"];
$item->StartingPrice = $_POST["StartingPrice"];
$item->ReservePrice = $_POST["ReservePrice"];
$item->SellerID = $_POST["SellerID"];
$item->CategoryID = isset($_POST["CategoryID"]) ? $_POST["CategoryID"] : null;

// check they are the seller
// TODO Enable
//check_UserID($item->SellerID);

// validation
validate_datetime($item->AuctionStart, "AuctionStart");
validate_datetime($item->AuctionEnd, "AuctionEnd");
validate_auction_times($item->AuctionStart, $item->AuctionEnd, "AuctionStart needs to be smaller than AuctionEnd, and in the future");
validate_positive_int($item->StartingPrice, "StartingPrice");
validate_positive_int($item->ReservePrice, "ReservePrice");
// TODO Check is in future


// Upload the photo
// Source: https://stackoverflow.com/questions/23980733/jquery-ajax-file-upload-php
if (!isset($_FILES['file']) || 0 < $_FILES['file']['error']) {
    $item->PhotoURL = "assets/default.png";
} else {
    $fileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . "." . $fileExtension;
    if ($fileExtension != "jpg" && $fileExtension != "png" && $fileExtension != "jpeg") {
        die ('{"message": "image must be .jpg, .png or .jpeg"}');
    }

    $target_dir = "/var/www/html/";

    move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . 'assets/' . $fileName);

    // save the photo url
    $item->PhotoURL = "assets/" . $fileName;
}

// create the item
if ($item->create()) {
    echo '{';
    echo '"message": "Item was created."';
    echo '"valid": true';
    echo '}';
} // if unable to create the item, tell the item
else {
    echo '{';
    echo '"message": "Unable to create item."';
    echo '}';
}
