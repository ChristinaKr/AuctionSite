<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate item object
include_once '../models/Category.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$category = new Category($db);

// query products
$stmt = $category->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {

    // products array
    $category_arr = array();
    $category_arr["items"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $category_category = array(
            "ID" => $ID,
            "Name" => $Name,
        );

        array_push($category_arr["items"], $category_category);
    }

    echo json_encode($category_arr);
} else {
    echo json_encode(
        array("message" => "No categories found.")
    );
}
