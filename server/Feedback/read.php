<?php
/**
 * Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../models/Feedback.php';

// debugger: https://github.com/fedosov/webug
//require_once('./FirePHPCore/FirePHP.class.php');
//$firephp = FirePHP::getInstance(true);
//$firephp->group(array("this" => "is", "group" => "output"));

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$feedback = new Feedback($db);

// query products
$stmt = $feedback->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {

    // products array
    $feedbacks_arr = array();
    $feedbacks_arr["records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $feedback_feedback = array(
            "ToUserID" => $ToUserID,
            "FromUserID" => $FromUserID,
            "ItemID" => $ItemID,
            "Comment" => $Comment,
            "Rating" => $Rating,
        );

        array_push($feedbacks_arr["records"], $feedback_feedback);
    }

    echo json_encode($feedbacks_arr);
} else {
    echo json_encode(
        array("message" => "No feedback found.")
    );
}
