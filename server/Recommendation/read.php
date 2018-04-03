<?php
/**
 * Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../models/Recommendation.php';

// debugger: https://github.com/fedosov/webug
//require_once('./FirePHPCore/FirePHP.class.php');
//$firephp = FirePHP::getInstance(true);
//$firephp->group(array("this" => "is", "group" => "output"));

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$recommendation = new Recommendation($db);

// query products
$stmt = $recommendation->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {

    // products array
    $recommendations_arr = array();
    $recommendations_arr["records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $recommendation_recommendation = array(
          "UserID" => $UserID,
          "ItemID" => $ItemID,
        );

        array_push($recommendations_arr["records"], $recommendation_recommendation);
    }

    echo json_encode($recommendations_arr);
} else {
    echo json_encode(
        array("message" => "No recommendation found.")
    );
}
