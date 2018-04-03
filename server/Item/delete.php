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
include_once '../models/Item.php';

// TODO Enable
//include_once '../utils/auth.php';



// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare Item object
$item = new Item($db);

// get Item id

// set Item id to be deleted
$item->ID = $_POST["ID"];

// TODO Enable
//$user = new User($db);
//$user->ID = $_SESSION['ID'];

//$item->readOne()
//if (!($user->isAdmin() || $user->ID == $item->SellerID) {
//    echo '{';
//    echo '"message": "You must be an admin or the seller to delete items."';
//    echo '}';
//};

// delete the Item
if($item->delete()){
    echo '{';
        echo '"message": "Item was deleted."';
    echo '}';
}

// if unable to delete the Item
else{
    echo '{';
        echo '"message": "Unable to delete Item."';
    echo '}';
}
