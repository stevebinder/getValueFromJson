<?php

require("getValueFromJson.php");

// let's start with something big
$generator = array();
for ($i = 0; $i < 1000000; ++$i) {
    $generator["_".$i] = $i;
}
$hugeJsonString = json_encode($generator);

// first we use the slow method
$aStart = microtime();
json_encode($hugeJsonString);
$aTime = microtime() - $aStart;

// now we do the fast method
$bStart = microtime();
getValueFromJson($hugeJsonString, "my_key");
$bTime = microtime() - $bStart;

echo "[".$aTime."ms][".$bTime."ms][".round(1/($bTime/$aTime))." times faster]";

?>
