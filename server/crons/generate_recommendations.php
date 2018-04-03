<?php
/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 16/03/2018
 * Time: 02:25
 */

//require '/var/www/html/api/utils/collab-filtering/OpenSlopeOne.php';
require '/Users/lukeharries/dev/sites/EbayClone/server/utils/collab-filtering/OpenSlopeOne.php';
$openslopeone = new OpenSlopeOne();

// generate 5 recommendations

$database = new Database();
$db = $database->getConnection();

// initialize object
$user = new User($db);

// query products
$stmt = $user->read();
$num = $stmt->rowCount();

if ($num > 0) {

    // products array
    $users_arr = array();
    $users_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        print_r($openslopeone->getRecommendedItemsByUser($row["ID"], 5));

    }

} else {
    echo json_encode(
        array("message" => "No users found.")
    );
}