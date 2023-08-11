# php-functions

Wrapped all basic reusable php function which is always useful while working on other project.
This class might also be useful to beginners

This class provides general-purpose PHP functions to process several functions, it can perform several types of manipulation of string values and other executions.

Currently, it can:

- Create a random value string, int, key, salt or letters of a given length
- Convert timestamp values into a time format for use on social media sites or forum comments
- Generate and validate a unique identifier string
- Generate Unified Public Consultation (UPC)
- Generate European Article Number (EAN) or (EAN13)
- Genrate Big Integer based on min and max
- Check if a string is a valid email address
- Check a password complexity count, using general secure password pattern
- Encrypt password string to create a hash value
- Decrypts a password hash and verifies if it matches
- Calculate a list of item's average rating point
- Formats a currency value to add decimal places
- Discount a value by percentage
- Increase a value by percentage
- Fixed or Round a number to counts
- Creates a badge from an array
- Creates a button badge from an array
- Gets the current user's IP address
- Get the list of hours
- Format the user input to protect again cross site scripting attacks
- Convert string characters to HTML entities
- Copy files and folder to a new directory
- Serve a file for download on the browser
- Truncate text
- Base64 encoded string to a parameter in a URL
- Base64 decode encoded URL encoded string
- Stripe unwanted characters from a string
- Extract domain name from subdomain demo.example.com
- Mask email address
- Mask string by position
- Deletes files and folders
- Write a new log line
- Save log and replace old content
- Find the log file



## Installation

Installation is super-easy via Composer:
```md
composer require peterujah/php-functions
```
## Usages

```php 
use \Peterujah\NanoBlock\Functions;
$func = new Functions();
```
Or extend the class and create your own new function like below.
```php
class MyFunction extends \Peterujah\NanoBlock\Functions{
  public function __construct(){
  }
  public function myFunction(){
    //do anything
  }
  public static function myStaticFunction(){
    //do anything
  }
}
```
And call initialize your custom class
```php
$func = new MyFunction();
```

## Available Static Methods

Make a random string/number
```php 
Functions::Random(10, Functions::INT);
```
Make a time ago from php timestamp, returns string
```php 
Functions::timeSocial(php_timestamp);
```
Generate a uuid string, returns string
```php 
Functions::uuid();
```

Verify a uuid string return true or false
```php 
Functions::is_uuid($uuid);
```

Verify email address is valid or not return true or false
```php 
Functions::is_email($email);
```

Create a password hash key
```php 
Functions::Encrypt($password);
```

Verify a password against hash key
```php 
Functions::Decrypt($password, $hash);
```

Check password strength
```php 
Functions::strongPassword($password, $minLength = 8,$maxLength = 16, $complexity=4);
```

Extract main domain name from subdomain
```php
Functions::removeSubdomain("subdomain.example.com"); //returns example.com
```

Calculate items average rating point
```php 
Functions::calcAverageRating($total_user_reviews, $total_rating_count);
```
Format number to money
```php 
Functions::Money($number, $fractional);
```

Discount from an (int, float, double) value by percentage
```php 
Functions::Discount(100, 10); // return 90
```

Increase interest of an (int, float, double) value by percentage
```php 
Functions::Interest(100, 10); //return 110
```

Fixed/Round a number 
```php 
Functions::Fixed(12345.728836, 2);
```

Randome number using min and max
```php 
Functions::BigInteger(12345, 728836);
```

Create a tag/badge from array
```php 
Functions::badges(
    ["php", "js", "css"], 
    $bootstrap_color_without_prefix, 
    $type_of_badge, 
    $url_prefix_for_links
);
```

Create a button tag/badge from array
```php 
Functions::buttonBadges(
    ["php", "js", "css"], 
    $bootstrap_color_without_prefix, 
    $truncate, 
    $truncate_limit, 
    $selected_button_by_value
);
```

Returns user ip address
```php 
Functions::IP();
```
List time hours, returns array
```php 
Functions::hoursRange();
```

Secure/format user input based on required data type
```php 
Functions::XSS("Rhd53883773", "int");
```

Formats Convert string characters to HTML entities
```php 
Functions::htmlentities($string, $encode);
```

Generate UPC product id
```php 
Functions::UPC($prefix = 0, $length = 12);
```

Generate EAN13 id
```php 
Functions::EAN($country = 615, $length = 13);
```

Copy files and folder to a new directory
```php 
Functions::copyFiles("path/from/file/", "path/to/file/");
```

Copy files and folder to a new directory
```php 
Functions::download(
    "path/to/download/file.zip", //string filepath to download
    "file.zip", // string file name to download
    false // bool delete file after download is complete true or false
);
```

Truncate text based on length
```php 
Functions::truncate(
    $text, //string text to truncate
    $length // int length to display
);
```

Base64 encode string for url passing
```php 
Functions::base64_url_encode($input);
```
Base64 decode encoded url encoded string
```php 
Functions::base64_url_decode($encoded_input);
```
Mask email address
```php 
Functions::maskEmail(
    $email, // string email address
    "*" // character to mask with
);
```

Mask string by position
```php 
Functions::mask(
    $string, // string to mask
    "#", // character to mask with
    $position  //string position to mask left|right|center"
)
```
Determine password strength, if it meet all basic password rules such as
1. Does password meet the the minimum and maximum length?
2. Does password contain numbers?
3. Does password contain uppercase letters?
4. Does password contain lowercase letters?
5. Does password contain special characters?

```php
Functions::strongPassword($password, $minLength, $maxLength);
```

Deletes files and folders
```php 
Functions::remove(
    "path/to/delete/file/", // path to delete files
    false // delete base file once sub files and folders has been deleted
) 
```

Write new log line file
```php 
Functions::writeLog(
    "path/to/logs/", // string path to save logs
    "info.php",  // string log file name, use .php extension to secure log file from accessible in browser
    $data, // mixed log content
    $secure, // bool set true if file is using .php extension security method 
    $serialize, // bool serialize log content
    $replace // bool replace old log content
);
```
Save log a short hand replace parameter in `Functions::writeLog`
```php 
Functions::saveLog(
    "path/to/logs/", // string path to save logs
    "info.php",  // string log file name, use .php extension to secure log file from accessible in browser
    $data, // mixed log content
    $secure, // bool set true if file is using .php extension security method 
    $serialize, // bool serialize log content
);
```

Find log file
```php 
Functions::findLog(
    "path/to/logs/info.php", //string filepath to log
    $unserialize // bool unserialize content if it was saved in serialize mode
);
```

Stripes unwanted characters from string and display text in new line in textarea
```php 
$func->stripeText(
    $string, // string text to stripe unwanted characters
    $rules, // array rules array("[br/]" =>  "&#13;&#10;","<script>"    => "oops!",)
    $textarea // bool display text inside textarea
);
```
