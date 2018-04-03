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
include_once '../models/Item.php';

// debugger: https://github.com/fedosov/webug
//require_once('./FirePHPCore/FirePHP.class.php');
//$firephp = FirePHP::getInstance(true);
//$firephp->group(array("this" => "is", "group" => "output"));

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$item = new Item($db);

// query products
$stmt = $item->read();
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
            "Views" => $Views,
            "SellerName" => $SellerName,
            "SellerRating" => $SellerRating,
            "CreatedAt" => $CreatedAt,
            "CategoryID" => $CategoryID,
            "LargestBid" => $LargestBid
        );

        array_push($items_arr["records"], $item_item);
    }

    echo json_encode($items_arr);
} else {
    echo json_encode(
        array("message" => "No items found.")
    );
}
