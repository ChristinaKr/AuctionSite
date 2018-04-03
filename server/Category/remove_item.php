<?php
/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 07/03/2018
 * Time: 13:53
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';
include_once '../models/Category.php';

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

$Item_ID = $_POST["ItemID"];
$category->ID = $_POST["CategoryID"];

// TODO: Check that the user id is the seller of the item;

if($category->remove_item($Item_ID)){
    echo '{';
    echo '"message": "Item removed."';
    echo '}';
}
// if unable to create the user, tell the user
else{
    echo '{';
    echo '"message": "Unable to remove item."';
    echo '}';
}
