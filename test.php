<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require("json.php");

$sample1 = '{"one":1,"two":"two","three":true,"four":0.11,"five":25,"six":6, "seven":"my \"quoted\" string\""}';
$sample2 = '{"one":1,"two":"name"}';
$sample3 = '{}';
$sample4 = '{"a":"ok","b":"my \n\n word\"s here","c":"name"}';
$sample5 = '{"a":"","b":2}';
$sample6 = '{"a":{},"b":[],"c":""}';
$sample7 = '{}';
$sample8 = '[]';
$sample9 = '[2,3]';

function test($output, $correct) {
    $result = $output === $correct ? "PASS" : "FAIL";
    return $result." :: ".$output." :: ".$correct;
}

$results = array(
    "get_1" => test(json::get($sample1, "one"), 1),
    "get_2" => test(json::get($sample1, "two"), "two"),
    "get_3" => test(json::get($sample1, "three"), true),
    "get_4" => test(json::get($sample1, "four"), 0.11),
    "get_5" => test(json::get($sample1, "five"), 25),
    "get_6" => test(json::get($sample1, "six"), 6),
    "get_7" => test(json::get($sample1, "seven"), "my \"quoted\" string\""),
    "get_8" => test(json::get($sample4, "b"), "my \n\n word\"s here"),
    "get_9" => test(json::get($sample5, "a"), ""),
    "get_10" => test(json::get($sample6, "a"), "{}"),
    "get_11" => test(json::get($sample6, "b"), "[]"),
    "get_12" => test(json::get($sample6, "c"), ""),

    "set_1" => test(json::set($sample2, "one", 2), '{"one":2,"two":"name"}'),
    "set_2" => test(json::set($sample2, "one", "let\"s go"), '{"one":"let\"s go","two":"name"}'),
    "set_3" => test(json::set($sample2, "two", "let\"s go"), '{"one":1,"two":"let\"s go"}'),
    "set_4" => test(json::set($sample2, "two", 0.25), '{"one":1,"two":0.25}'),
    "set_5" => test(json::set($sample2, "two", true), '{"one":1,"two":true}'),
    "set_6" => test(json::set($sample3, "a", 1), '{"a":1}'),
    "set_7" => test(json::set($sample3, array("a" => 1, "b" => 2)), '{"a":1,"b":2}'),
    "set_8" => test(json::set($sample3, array("a" => "", "b" => null)), '{"a":"","b":null}'),
    "set_9" => test(json::set($sample4, "b", "cat"), '{"a":"ok","b":"cat","c":"name"}'),
    "set_10" => test(json::set($sample7, "a", "cat"), '{"a":"cat"}'),
    "set_11" => test(json::set($sample8, "a", "cat"), '[]'),
    "set_12" => test(json::set($sample2, "a", "b", true), '{"a":"b","one":1,"two":"name"}'),
    "set_13" => test(json::set($sample5, array("c" => "d", "e" => "f")), '{"a":"","b":2,"c":"d","e":"f"}'),
    "set_14" => test(json::set($sample5, array("c" => "d", "e" => "f"), true), '{"c":"d","e":"f","a":"","b":2}'),
    "set_15" => test(json::set($sample5, "new", 2), '{"a":"","b":2,"new":2}'),

    "remove_1" => test(json::remove($sample2, "one"), '{"two":"name"}'),
    "remove_2" => test(json::remove($sample2, "two"), '{"one":1}'),
    "remove_3" => test(json::remove($sample2, array("two", "one")), '{}'),
    "remove_4" => test(json::remove($sample4, "b"), '{"a":"ok","c":"name"}'),
    "remove_5" => test(json::remove($sample4, "a"), '{"b":"my \n\n word\"s here","c":"name"}'),

    "add_1" => test(json::add($sample7, "cat"), '{}'),
    "add_2" => test(json::add($sample8, "cat"), '["cat"]'),
    "add_3" => test(json::add($sample9, "4"), '[2,3,4]'),
    "add_4" => test(json::add($sample9, "dog"), '[2,3,"dog"]'),
    "add_5" => test(json::add($sample9, "1", true), '[1,2,3]'),

);

foreach ($results as $key => $value) {
    echo "[".$key."] ".$value."\n";
}

?>
