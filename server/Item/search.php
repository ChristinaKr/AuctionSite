<?php
/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 07/03/2018
 * Time: 17:22
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../models/Item.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$item = new Item($db);

$query = isset($_GET['q']) ? $_GET['q'] : die('{"message": "Please enter a query q."}');
$CategoryID = isset($_GET['CategoryID']) ? $_GET['CategoryID'] : null;

// query products
$stmt = $item->search($query, $CategoryID);
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {

    // products array
    $items_arr = array();
    $items_arr["records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $tempitem = new Item($db);
        $tempitem->ID = $ID;

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
            "BuyerID" => $BuyerID,
            "SellerName" => $SellerName,
            "SellerRating" => $SellerRating,
            "CategoryID" => $CategoryID,
            "LargestBid" => $LargestBid,


        );

        array_push($items_arr["records"], $item_item);
    }

    echo json_encode($items_arr);
} else {
    echo json_encode(
        array("message" => "No items found.")
    );
}
