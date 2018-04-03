<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// debugger: https://github.com/fedosov/webug
require_once('../FirePHPCore/FirePHP.class.php');

// include database and object files
include_once '../config/database.php';
include_once '../models/Item.php';

// check that the user is logged in and set session id
include_once '../utils/auth.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare Item object
$item = new Item($db);

// get ID of Item to be edited

// set Item property values
$item->ID = $_POST["ID"];
$item->Name = $_POST["Name"];
$item->Description = $_POST["Description"];
$item->AuctionStart = $_POST["AuctionStart"];
$item->AuctionEnd = $_POST["AuctionEnd"];
$item->StartingPrice = $_POST["StartingPrice"];
$item->ReservePrice = $_POST["ReservePrice"];
$item->SellerID = $_POST["SellerID"];

// Upload the photo
// Source: https://stackoverflow.com/questions/23980733/jquery-ajax-file-upload-php
if (!isset($_FILES['file']) || 0 < $_FILES['file']['error']) {
    $item->PhotoURL = "assets/default.png";
} else {
    $fileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . "." . $fileExtension;
    if ($fileExtension != ".jpg" && $fileExtension != ".png" &&  $fileExtension != ".jpeg") {
        die ('{"message": "image must be .jpg, .png or .jpeg"}');
    }
    move_uploaded_file($_FILES['file']['tmp_name'], '../assets/' . $fileName);

    // save the photo url
    $item->PhotoURL = "assets/" . $fileName;
}

// TODO: Check that the user id is the seller of the item;

// check they are the seller
check_UserID($item->SellerID);

//// update the Item
if($item->update()){
    echo '{';
        echo '"message": "Item was updated."';
    echo '}';
}
//
//// if unable to update the Item, tell the item
else{
    echo '{';
        echo '"message": "Unable to update item."';
    echo '}';
  }
