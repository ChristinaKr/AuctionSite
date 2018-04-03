<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// debugger: https://github.com/fedosov/webug
require_once('../FirePHPCore/FirePHP.class.php');

// include database and object files
include_once '../config/database.php';
include_once '../models/User.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare User object
$user = new User($db);

// get ID of User to be edited


// set ID property of User to be edited
$user->ID = $_POST["ID"];

// set User property values
$user->Email = $_POST["Email"];
$user->FirstName = $_POST["FirstName"];
$user->LastName = $_POST["LastName"];

// TODO: Check that the user id is the userID;

//
//// update the User
if($user->update()){
    echo '{';
        echo '"message": "User was updated."';
    echo '}';
}
//
//// if unable to update the User, tell the user
else{
    echo '{';
        echo '"message": "Unable to update user."';
    echo '}';
  }
