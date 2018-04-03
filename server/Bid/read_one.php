<?php

/**
 * Created by PhpStorm.
 * bid: lukeharries
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
include_once '../models/Bid.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare bid object
$bid = new Bid($db);

// set ID property of bid to be edited
$bid->ID = isset($_GET['ID']) ? $_GET['ID'] : die('{"message": "Please enter a bid ID"}');

// read the details of bid to be edited
$bid->readOne();

if ($bid->ID) {
    // create array
    $bid_arr = array(
        "ID" => $bid->ID,
        "ItemID" => $bid->ItemID,
        "BidAmount" => $bid->BidAmount,
        "UserID" => $bid->UserID,
    );

    echo(json_encode($bid_arr));
} else {
    echo '"Unable to find bid"';
}
