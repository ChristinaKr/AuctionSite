<?php
/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 07/03/2018
 * Time: 12:39
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate item object
include_once '../models/Category.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$category = new Category($db);

// set ID property of Item to be edited
$category->ID = isset($_GET['ID']) ? $_GET['ID'] : die('{"message": "Please enter a category id."}');

// query products
$stmt = $category->read_items();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {

    // products array
    $items_arr = array();
    $items_arr["items"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $item_item = array(
            "ID" => $ID,
            "Name" => $Name,
            "Description" => $Description,
            "AuctionStart" => $AuctionStart,
            "AuctionEnd" => $AuctionEnd,
            "AuctionFinished" => $AuctionFinished,
            "StartingPrice" => $StartingPrice,
            "ReservePrice" => $ReservePrice,
            "FinalPrice" => $FinalPrice,
            "PhotoURL" => $PhotoURL,
            "SellerID" => $SellerID,
            "SellerName" => $SellerName,
            "SellerRating" => $SellerRating
        );

        array_push($items_arr["items"], $item_item);
    }

    echo json_encode($items_arr);
} else {
    echo json_encode(
        array("message" => "No items found.")
    );
}