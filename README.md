# json.php

A simple PHP class for modifying non-complex json more efficiently than **json_decode**. The methods in this class are much faster and use less memory than **json_decode** and **json_encode** because they work using **preg_replace**. The methods are even more efficient when the keys you are operating on are closer to the beginning of the json.

# Notes
This class does not work with multi-level complex json structures because nested keys and objects will trick these methods. Also make sure you use valid json without extra spacing.

**Valid JSON**: ```{"key":"value","key":"value};```

**Invalid JSON**: ```{ "key":"value", "key":"value };```

# Usage

```php
require("json.php");

$object = '{"first":"hello","second":true,"third":"cat\"s long yarn","fourth":22}';
$array = '[1,2]';

// use these when working with objects
json::get($object, "first"); // "hello"
json::get($object, "missing"); // null
json::get($object, array("first", "second")); // array("first" => "hello", "second" => true );
json::set($object, "first", "goodbye"); // set the key or add it at the end
json::set($object, "first", "goodbye", true); // set the key or add it at the beginning 
json::set($object, array("first" => "goodbye", "second" => false)); // set multiple keys to the end
json::set($object, array("first" => "goodbye", "second" => false), true); // set multiple keys to the beginning
json::remove($object, "first"); // remove one key
json::remove($object, array("first", "second")); // remove multiple keys

// use these when working with arrays
json::add($array, 3); // [1,2,3]
json::add($array, 0); // [0,1,2]
```
