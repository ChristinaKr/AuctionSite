<?php

/**
 * Created by PhpStorm.
 * Item: lukeharries
 * Date: 14/02/2018
 * Time: 14:48
 * Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../models/Item.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare Item object
$item = new Item($db);

// set ID property of Item to be edited
$item->ID = isset($_GET['ID']) ? $_GET['ID'] : die('{"message": "Please enter an item ID."}');

// read the details of Item to be edited
$item->readOne();

// increase the total views
$item->increment_views();


// log the view for that user
try {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['ID']) && $_SESSION['ID'] != "") {
        $database2 = new Database();
        $db2 = $database2->getConnection();
        p_View($db2, $_SESSION['ID'], $item->ID);
    }
} catch (Exception $e) {
    error_log('Caught exception, unable to track view: ', $e->getMessage(), "\n");
}


if ($item->ID) {
    // create array
    $item_arr = array(
        "ID" => $item->ID,
        "Name" => $item->Name,
        "Description" => $item->Description,
        "AuctionStart" => $item->AuctionStart,
        "AuctionEnd" => $item->AuctionEnd,
        "AuctionFinished" => $item->AuctionFinished,
        "StartingPrice" => $item->StartingPrice,
        "ReservePrice" => $item->ReservePrice,
        "FinalPrice" => $item->FinalPrice,
        "PhotoURL" => $item->PhotoURL,
        "SellerID" => $item->SellerID,
        "BuyerID" => $item->BuyerID,
        "Views" => $item->Views,
        "SellerName" => $item->SellerName,
        "SellerRating" => $item->SellerRating,
        "CreatedAt" => $item->CreatedAt,
        "LargestBid" => $item->LargestBid
    );

    echo(json_encode($item_arr));
} else {
    echo '"Unable to find item"';
}
