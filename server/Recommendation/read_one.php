<?php

/**
 * Created by PhpStorm.
 * recommendation: lukeharries
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
include_once '../models/Recommendation.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare recommendation object
$recommendation = new Recommendation($db);

// set properties of recommendation to be edited
$recommendation->UserID = isset($_GET['UserID']) ? $_GET['UserID'] : die('{"message": "Please enter a UserID."}');
$recommendation->ItemID = isset($_GET['ItemID']) ? $_GET['ItemID'] : die('{"message": "Please enter an ItemID."}');

// read the details of recommendation to be edited
$recommendation->readOne();

if ($recommendation->UserID && $recommendation->ItemID) {
    // create array
    $recommendation_arr = array(
        "UserID" => $recommendation->UserID,
        "ItemID" => $recommendation->ItemID,
    );

    echo(json_encode($recommendation_arr));
} else {
    echo '"Unable to find recommendation"';
}
