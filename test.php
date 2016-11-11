<?php

require("json.php");

$sample = '{"first":"hello","second":true,"third":"cat\"s long yarn","fourth":22}';

var_dump(array(
    "get" => json::get($sample, "first"),
    "set" => json::set($sample, "first", array("mark" => "Jones")),
    "remove" => json::remove($sample, "third"),
    "add_end" => json::add($sample, "xyz", "cat"),
    "add_begin" => json::add($sample, "xyz", "dog", true),
));


?>
