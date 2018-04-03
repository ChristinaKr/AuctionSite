<?php
/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 14/02/2018
 * Time: 14:15
 * Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../models/Bid.php';

// debugger: https://github.com/fedosov/webug
//require_once('./FirePHPCore/FirePHP.class.php');
//$firephp = FirePHP::getInstance(true);
//$firephp->group(array("this" => "is", "group" => "output"));

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$bid = new Bid($db);

// query products
$stmt = $bid->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {

    // products array
    $bids_arr = array();
    $bids_arr["records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $bid_bid = array(
            "ID" => $ID,
            "ItemID" => $ItemID,
            "BidAmount" => $BidAmount,
            "UserID" => $UserID,
        );

        array_push($bids_arr["records"], $bid_bid);
    }

    echo json_encode($bids_arr);
} else {
    echo json_encode(
        array("message" => "No bids found.")
    );
}
