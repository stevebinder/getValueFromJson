# getJsonKey

A simple PHP function for quickly looking up the value for a given key from a raw json string.

```php
require("getJsonKey.php");

$string = "{\"huge\":\"json string...\"}";
$name = getJsonKey($string, "name");
```
