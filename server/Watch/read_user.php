<?php
/**
 * Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../models/Watch.php';

// debugger: https://github.com/fedosov/webug
//require_once('./FirePHPCore/FirePHP.class.php');
//$firephp = FirePHP::getInstance(true);
//$firephp->group(array("this" => "is", "group" => "output"));

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// set ID property of watch to be edited
$UserID = isset($_GET['UserID']) ? $_GET['UserID'] : die('{"message":"UserID is required"}');

// query products
$stmt = Watch::readOneUser($db, $UserID);
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {

    // products array
    $watchs_arr = array();
    $watchs_arr["records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $watch_watch = array(
            "UserID" => $UserID,
            "ItemID" => $ItemID,
        );

        array_push($watchs_arr["records"], $watch_watch);
    }

    echo json_encode($watchs_arr);
} else {
    echo json_encode(
        array("message" => "No watch-items found for this user.")
    );
}
