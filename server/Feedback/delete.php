<?php
// Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// include database and object file
include_once '../config/database.php';
include_once '../models/Feedback.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare Feedback object
$feedback = new Feedback($db);

// get Feedback id


// set Feedback to be deleted
$feedback->ID =  isset($_GET['ID']) ? $_GET['ID'] : die('{"message": "ID required."}');

// TODO: Check that the user id is the buyer of the item;

// delete the Feedback
if($feedback->delete()){
    echo '{';
        echo '"message": "Feedback was deleted."';
    echo '}';
}

// if unable to delete the Feedback
else{
    echo '{';
        echo '"message": "Unable to delete feedback."';
    echo '}';
}
