<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require("../../common/json.php");

$sample = '{"first":"hello","second":true,"third":"cat\"s long yarn","fourth":22,"fifth":"value"}';

var_dump(array(
    "get" => json::get($sample, "first"),
    "set" => json::set($sample, "third", "supe\"fish"),
    "remove_third" => json::remove($sample, "third"),
    "remove_fourth" => json::remove($sample, "fourth"),
    "remove_fifth" => json::remove($sample, "fifth"),
    "add_end" => json::add($sample, "xyz", "cat"),
    "add_begin" => json::add($sample, "xyz", "dog", true),
));


$sample = '{"third":"33"}';

var_dump(array(
    "get" => json::get($sample, "first"),
    "set" => json::set($sample, "third", 33),
    "remove_third" => json::remove($sample, "third"),
    "add_end" => json::add($sample, "xyz", "cat"),
    "add_begin" => json::add($sample, "xyz", "dog", true),
));


$sample = '{"first":"hello","second":true,"third":"cat\"s long yarn","fourth":22,"fifth":"value"}';

var_dump(array(
    "get" => json::get($sample, array("first", "second")),
    "set" => json::set($sample, array("first" => "111", "second" => "222")),
    "remove" => json::remove($sample, array("first", "second")),
    "add_end" => json::add($sample, array("a"=>1, "b"=>2)),
    "add_begin" => json::add($sample, array("a"=>1, "b"=>2), true),
));

?>
