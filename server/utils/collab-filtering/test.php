<?php

require '/var/www/html/api/utils/collab-filtering/OpenSlopeOne.php';
$openslopeone = new OpenSlopeOne();

// $openslopeone->initSlopeOneTable();
 $openslopeone->initSlopeOneTable('MySQL');

///**
//var_dump($openslopeone->getRecommendedItemsById(345));

var_dump($openslopeone->getRecommendedItemsByUser("a97d5d57-270c-11e8-a26f-000d3a384631"));

//var_dump($openslopeone->getRecommendedItemsByUser(30002));
//**/
?>
