<?php

require("json.php");

$json = array();
$max = 999999;
for ($i = 0; $i < $max; ++$i) {
    $json[$i] = $i;
}
$json = json_encode($json);

$t1 = microtime(true);
$decoded = json_decode($json);
$item = $decoded[$max - 1];
$c1 = microtime(true) - $t1;

$t2 = microtime(true);
$item = json::get($json, $max - 1);
$c2 = microtime(true) - $t2;

echo $c2 / $c1;

?>
