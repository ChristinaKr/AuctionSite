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
include_once '../models/Bid.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// set ID property of bid to be edited
$ItemID = isset($_GET['ItemID']) ? $_GET['ItemID'] : die('{"message": "please enter an ItemID","valid": false}');

// query products
$stmt = Bid::read_items($db, $ItemID);
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {

    // products array
    $bid_arr = array();
    $bid_arr["records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $bid_bid = array(
            "ID" => $ID,
            "ItemID" => $ItemID,
            "BidAmount" => $BidAmount,
            "UserID" => $UserID,
            "CreatedAt" => $CreatedAt,
        );

        array_push($bid_arr["records"], $bid_bid);
    }

    echo json_encode($bid_arr);
} else {
    echo json_encode(
        array("message" => "No bid found for this item.")
    );
}
?>
