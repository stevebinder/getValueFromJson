# getJsonKey

A simple PHP function for quickly looking up the value for a given key from a raw json string. This method uses less memory and time than ```json_decode``` because the whole string does not need to be read into memory to retrieve the key. The method is more effienct when the key you want is closer to the beginning of the string.

```php
require("getJsonKey.php");

$string = "{\"huge\":\"json string...\"}";
$name = getJsonKey($string, "name");
```
