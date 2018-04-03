<?php

/**
 * Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../models/User.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// set ID property of bid to be edited
$UserID = isset($_GET['ID']) ? $_GET['ID'] : die('{"message": "please enter a User ID"}');

$user = new User($db);

$user->ID = $UserID;

// query products
$stmt = $user->items_bidded_on();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {

    // products array
    $item_arr = array();
    $item_arr["records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $item_bid = array(
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
            "Views" => $Views,
            "SellerName" => $SellerName,
            "SellerRating" => $SellerRating,
            "CreatedAt" => $CreatedAt,
            "HighestBid" => $HighestBid
        );

        array_push($item_arr["records"], $item_bid);
    }

    echo json_encode($item_arr);
} else {
    echo json_encode(
        array("message" => "No items bidded on.")
    );
}
?>
