<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require("../../common/json.php");

$sample1 = '{"one":1,"two":"two","three":true,"four":0.11,"five":25,"six":6, "seven":"my \"quoted\" string\""}';
$sample2 = '{"one":1,"two":"name"}';
$sample3 = '{}';
$sample4 = '{"a":"ok","b":"my \n\n word\"s here","c":"name"}';
$sample5 = '{"a":"","b":2}';

$results = array(
    "get_1" => json::get($sample1, "one") === 1,
    "get_2" => json::get($sample1, "two") === "two",
    "get_3" => json::get($sample1, "three") === true,
    "get_4" => json::get($sample1, "four") === 0.11,
    "get_5" => json::get($sample1, "five") === 25,
    "get_6" => json::get($sample1, "six") === 6,
    "get_7" => json::get($sample1, "seven") === "my \"quoted\" string\"",
    "get_8" => json::get($sample4, "b") === "my \n\n word\"s here",
    "get_9" => json::get($sample5, "a") === "",

    "set_1" => json::set($sample2, "one", 2) === '{"one":2,"two":"name"}',
    "set_2" => json::set($sample2, "one", "let\"s go") === '{"one":"let\"s go","two":"name"}',
    "set_3" => json::set($sample2, "two", "let\"s go") === '{"one":1,"two":"let\"s go"}',
    "set_4" => json::set($sample2, "two", 0.25) === '{"one":1,"two":0.25}',
    "set_5" => json::set($sample2, "two", true) === '{"one":1,"two":true}',
    "set_6" => json::set($sample3, "a", 1) === '{"a":1}',
    "set_7" => json::set($sample3, array("a" => 1, "b" => 2)) === '{"a":1,"b":2}',
    "set_8" => json::set($sample3, array("a" => "", "b" => null)) === '{"a":"","b":null}',
    "set_9" => json::set($sample4, "b", "cat") === '{"a":"ok","b":"cat","c":"name"}',

    "remove_1" => json::remove($sample2, "one") === '{"two":"name"}',
    "remove_2" => json::remove($sample2, "two") === '{"one":1}',
    "remove_3" => json::remove($sample2, array("two", "one")) === '{}',
    "remove_4" => json::remove($sample4, "b") === '{"a":"ok","c":"name"}',
    "remove_5" => json::remove($sample4, "a") === '{"b":"my \n\n word\"s here","c":"name"}',
);

foreach ($results as $key => $value) {
    echo $key."[".($value ? "PASS" : "FAIL")."]\n";
}

?>
