<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require("json.php");

$sample1 = '{"one":1,"two":"two","three":true,"four":0.11,"five":25,"six":6, "seven":"my \"quoted\" string\""}';
$sample2 = '{"one":1,"two":"name"}';

$results = array(
    "get_1" => json::get($sample1, "one") === 1,
    "get_2" => json::get($sample1, "two") === "two",
    "get_3" => json::get($sample1, "three") === true,
    "get_4" => json::get($sample1, "four") === 0.11,
    "get_5" => json::get($sample1, "five") === 25,
    "get_6" => json::get($sample1, "six") === 6,
    "get_7" => json::get($sample1, "seven") === "my \"quoted\" string\"",

    "set_1" => json::set($sample2, "one", 2) === '{"one":2,"two":"name"}',
    "set_2" => json::set($sample2, "one", "let\"s go") === '{"one":"let\"s go","two":"name"}',
    "set_3" => json::set($sample2, "two", "let\"s go") === '{"one":1,"two":"let\"s go"}',
    "set_4" => json::set($sample2, "two", 0.25) === '{"one":1,"two":0.25}',
    "set_5" => json::set($sample2, "two", true) === '{"one":1,"two":true}',

    "remove_1" => json::remove($sample2, "one") === '{"two":"name"}',
    "remove_2" => json::remove($sample2, "two") === '{"one":1}',
    "remove_3" => json::remove($sample2, array("two", "one")) === '{}',
);


foreach ($results as $key => $value) {
    echo $key."[".($value ? "PASS" : "FAIL")."]\n";
}

?>
