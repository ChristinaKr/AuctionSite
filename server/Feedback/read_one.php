<?php

/**
 * Created by PhpStorm.
 * feedback: lukeharries
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
include_once '../models/Feedback.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare feedback object
$feedback = new Feedback($db);

// set properties of feedback to be edited
$feedback->ID = isset($_GET['UserID']) ? $_GET['UserID'] : die('{"message": "UserID required."}');
$feedback->ID = isset($_GET['ItemID']) ? $_GET['ItemID'] : die('{"message": "ItemID required."}');

// read the details of feedback to be edited
$feedback->readOne();

if ($feedback->ToUserID && $feedback->ItemID) {
    // create array
    $feedback_arr = array(
        "ToUserID" => $ToUserID,
        "FromUserID" => $FromUserID,
        "ItemID" => $ItemID,
        "Comment" => $Comment,
        "Rating" => $Rating,
    );
    echo(json_encode($feedback_arr));
} else {
    echo '"Unable to find feedback"';
}
