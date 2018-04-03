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
include_once '../models/User.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare User object
$user = new User($db);

// get User id


// set User id to be deleted
$user->ID = $_POST["ID"];

// delete the User
if($user->delete()){
    echo '{';
        echo '"message": "User was deleted."';
    echo '}';
}

// if unable to delete the User
else{
    echo '{';
        echo '"message": "Unable to delete User."';
    echo '}';
}
