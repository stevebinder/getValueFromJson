# json.php

A simple PHP Class for modifying a json string without having to use **json_decode**, modifying the structure, then using **json_encode**. These methods uses less memory and time than decoding and reencoding because the whole string does not need to be read into memory to operate on it. The methods are more efficient when the given keys are closer to the beginning of the json string.

```php
require("json.php");

$sample = '{"first":"hello","second":true,"third":"cat\"s long yarn","fourth":22}';

var_dump(array(
    "get" => json::get($sample, "first"),
    "set" => json::set($sample, "first", array("mark" => "Jones")),
    "remove" => json::remove($sample, "third"),
    "add_end" => json::add($sample, "xyz", "cat"),
    "add_begin" => json::add($sample, "xyz", "dog", true),
));
```
