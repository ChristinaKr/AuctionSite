<?php
/**
 * Created by PhpStorm.
 * feedback: lukeharries
 * Date: 14/02/2018
 * Time: 14:35
 * Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate feedback object
include_once '../models/Feedback.php';

$database = new Database();
$db = $database->getConnection();

$feedback = new Feedback($db);

// set feedback property values
$feedback->ToUserID = $_POST["ToUserID"];
$feedback->FromUserID = $_POST["FromUserID"];
$feedback->ItemID = $_POST["ItemID"];
$feedback->Comment = $_POST["Comment"];
$feedback->Rating = $_POST["Rating"];

//$feedback->created = date('Y-m-d H:i:s');

//echo json_encode($feedback);

// TODO: Check that the user id is the buyer of the item;

// create the feedback
if($feedback->create()){
    echo '{';
    echo '"message": "Feedback was created."';
    echo '"valid": true';
    echo '}';
}

// if unable to create the feedback, tell the feedback
else{
    echo '{';
    echo '"message": "Unable to create feedback."';
    echo '}';
}
