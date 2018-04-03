<?php
/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 14/02/2018
 * Time: 14:15
 * Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../models/User.php';

// debugger: https://github.com/fedosov/webug
//require_once('./FirePHPCore/FirePHP.class.php');
//$firephp = FirePHP::getInstance(true);
//$firephp->group(array("this" => "is", "group" => "output"));

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$user = new User($db);

// query products
$stmt = $user->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // products array
    $users_arr=array();
    $users_arr["records"]=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $user_item = array(
            "ID" => $ID,
            "Email" => $Email,
            "FirstName" => $FirstName,
            "LastName" => $LastName
        );

        array_push($users_arr["records"], $user_item);
    }

    echo json_encode($users_arr);
}

else{
    echo json_encode(
        array("message" => "No users found.")
    );
}
