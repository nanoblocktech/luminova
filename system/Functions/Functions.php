<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Functions;
class Functions{
	public const INT = "int";
	public const CHAR = "char";
	public const STR = "str";
	public const SALT = "salt";
	public const SID = "sid";
	public const UUI = "uui";
	public const BADGE_LINK = 1;
	public const BADGE_SPAN = 2;
	private const DEFAULT_RULES = [
		"[br/]" =>  "&#13;&#10;",
		"\r\n"      => "\n",
		"\n\r"      => "\n",
		"\r"      => "\n",
		"\n"      => "\n",
		"<br/>"    => "\n",
		"<b>"    => "**",
		"</b>"    => "**",
		"<img "    => "<data-img",
		"</img>"    => "</data-img>",
		"<script>"    => "",
		"</script>"    => "",
		"<style>"    => "",
		"</style>"    => "",
		"alert("    => "data-alert(",
		"onclick("    => "data-onclick(",
		"onload("    => "data-onload(",
		"javascript:"    => "data-javascript:",
		"<a "    => "<data-a ",
		"</a>"    => "</data-a>",
	];

	/**
	* Class constructor
	*/
	public function __construct(){
	}


	public static function toName(string $string, string $type = "name", string $symbol = ""): string{
		return preg_replace("/[^a-zA-Z0-9-_. ]+/", $symbol, $string);
	}

  	public static function isNameBanned(mixed $nameToCheck, array $bannedNames): bool {
      	foreach ($bannedNames as $banned) {
          	if (stripos($nameToCheck, $banned) !== false) {
            	return true;
          	}
      	}
      	return false;
  	}

	public static function sanitizeText(string $text): string {
		$text = preg_replace('/<([^>]+)>(.*?)<\/\1>|<([^>]+) \/>/', '<i style="color:darkred;">⚠️ Content Blocked</i>', $text); 

		// Replace website links
		$text = preg_replace('/(https?:\/\/(?:www\.)?\S+(?:\.(?:[a-z]+)))/i', '<a href="$1" target="_blank">$1</a>', $text);

		// Replace mentions, excluding email-like patterns
		$text = preg_replace('/@(\w+)(?![@.]|[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}\b)/', '<a href="@$1">@$1</a>', $text);
			
		// Replace email addresses
		$text = preg_replace('/\b([A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4})\b/', '<a href="mailto:$1" title="$1">$1</a>', $text);

		// Replace phone numbers
		$text = preg_replace('/\b((\+?\d{11,13})|(\d{11,13}))\b/', '<a href="tel:$1">$1</a>', $text);

		// Replace hashtags
		$text = preg_replace('/#(\w+)/', '<a href="#$1">#$1</a>', $text);

		$text = nl2br($text);
		return $text;
	}


	public static function filterText(string $text, bool $all = true): string {
		$text = preg_replace('/<([^>]+)>(.*?)<\/\1>|<([^>]+) \/>/', '⚠️', $text); 
		$text = ($all ? preg_replace('/<[^>]+>/', '', $text) : preg_replace('/<(?!\/?b(?=>|\s.*>))[^>]+>/', '', $text));
		$text = htmlentities($text);
		return $text;
	}

	/**
	 * Generate a random value.
	 *
	 * @param int $length The length of the random value.
	 * @param string $type The type of random value (e.g., self::INT, self::CHAR, self::STR).
	 * @param bool $upper Whether to make the value uppercase if it's a string.
	 * @return string The generated random value.
	 */
	public static function random(int $length = 10, string $type = self::INT, bool $upper = false): string {
		$char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$int = '0123456789';

		switch ($type) {
			case self::INT:
				$hash = $int;
				break;
			case self::CHAR:
				$hash = $char;
				break;
			case self::STR:
				$hash = $int . $char;
				break;
			case self::SALT:
				$hash = $int . $char . '%#*^,?+$`;"{}][|\/:=)(@!.';
				break;
			case self::SID:
			default:
				$hash = $int . $char . '-';
				break;
		}

		$strLength = strlen($hash);
		$key = '';

		for ($i = 0; $i < $length; $i++) {
			$key .= $hash[random_int(0, $strLength - 1)];
		}
		return $upper ? strtoupper($key) : $key;
	}


	/** 
	 * Create a random integer based on minimum and maximum
	 * @param int $min number
	 * @param int $max number
	 * @return string 
	*/
	public static function bigInteger(int $min, int $max): string 
	{
		$difference   = bcadd(bcsub($max,$min),1);
		$rand_percent = bcdiv(mt_rand(), mt_getrandmax(), 8);
		return bcadd($min, bcmul($difference, $rand_percent, 8), 0);
	}
	
	/** 
	 * Gernerate product EAN13 id
	 * @param int $country start prefix country code
	 * @param int $length maximum length
	 * @return int 
	*/
	public static function EAN(int $country = 615, int $length = 13): int 
	{
		return self::UPC($country, $length);
	}

	/**
	 * Generate a product UPC ID.
	 *
	 * @param int $prefix Start prefix number.
	 * @param int $length Maximum length.
	 * @return string The generated UPC ID.
	 */
	public static function UPC(int $prefix = 0, int $length = 12): string 
	{
		$length -= strlen((string)$prefix) + 1;
		$randomPart = self::random($length);
		
		$code = $prefix . str_pad($randomPart, $length, '0', STR_PAD_LEFT);
		
		$sum = 0;
		$weightFlag = true;
		
		for ($i = strlen($code) - 1; $i >= 0; $i--) {
			$digit = (int)$code[$i];
			$sum += $weightFlag ? $digit * 3 : $digit;
			$weightFlag = !$weightFlag;
		}
		
		$checksumDigit = (10 - ($sum % 10)) % 10;
		
		return $code . $checksumDigit;
	}

	/**
	 * Converts a PHP timestamp to a social media-style time format (e.g., "2 hours ago").
	 *
	 * @param string|int $time The timestamp to convert.
	 * @return string Time in a human-readable format.
	 */
	public static function timeSocial(string $time): string 
	{
		$time_elapsed = time() - strtotime($time);
		switch (true) {
			case $time_elapsed <= 60:
				return "just now";
			case $time_elapsed <= 3600:
				$minutes = round($time_elapsed / 60);
				return $minutes . (($minutes == 1) ? " minute" : " minutes") . " ago";
			case $time_elapsed <= 86400:
				$hours = round($time_elapsed / 3600);
				return $hours . (($hours == 1) ? " hour" : " hours") . " ago";
			case $time_elapsed <= 604800:
				$days = round($time_elapsed / 86400);
				return $days . (($days == 1) ? " day" : " days") . " ago";
			case $time_elapsed <= 2419200:
				$weeks = round($time_elapsed / 604800);
				return $weeks . (($weeks == 1) ? " week" : " weeks") . " ago";
			case $time_elapsed <= 29030400:
				$months = round($time_elapsed / 2419200);
				return $months . (($months == 1) ? " month" : " months") . " ago";
			default:
				$years = round($time_elapsed / 29030400);
				return $years . (($years == 1) ? " year" : " years") . " ago";
		}
	}

	/**
	 * Check if timestamp has passed certain minutes
	 *
	 * @param mixed|string|int $timestamp stored timestamp
	 * @param int $minutes expiry minutes
	 * @return bool 
	 */
	public static function timeHasPassed(mixed $timestamp, int $minutes): bool {
		if (is_numeric($timestamp)) {
			$timestamp = (int)$timestamp;
		} else {
			$timestamp = strtotime($timestamp);
			if ($timestamp === false) {
				return false;
			}
		}
	
		$timeDifference = time() - $timestamp;
		$minutesDifference = $timeDifference / 60;
		return $minutesDifference >= $minutes;
	}
	

	/**
	 * Get the suffix for a given day (e.g., 1st, 2nd, 3rd, 4th).
	 *
	 * @param int $day The day for which to determine the suffix.
	 * @return string The day with its appropriate suffix.
	 */
	public static function daysSuffix(int $day): string 
	{
		$j = $day % 10;
		$k = $day % 100;

		if ($j == 1 && $k != 11) {
			return $day . "st";
		}
		if ($j == 2 && $k != 12) {
			return $day . "nd";
		}
		if ($j == 3 && $k != 13) {
			return $day . "rd";
		}

		return $day . "th";
	}

	
	/** 
	* Generates uuid string version 4
	* @return string uuid
	*/

	public static function uuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
	
	/** 
	* Checks a valid uuid version 4
	* @param string $uuid 
	* @return bool true or false
	*/
	public static function is_uuid( string $uuid ): bool 
	{
		$pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';
    	return (bool) preg_match($pattern, $uuid);
	}

	function uuidToKey(string $uuid): string {
		return hash('sha256', $uuid);
	}

	/** 
	* Checks if string is a valid email address
	* @param string|email $email email address to validate
	* @return bool true or false
	*/
	public static function is_email(string $email): bool 
	{
		if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email) or filter_var($email, FILTER_SANITIZE_EMAIL) !== false){
			return true;
		}else if(filter_var($email, FILTER_VALIDATE_INT) !== FALSE){
			return true;
		}
		return false;
	}

	/** 
	* Checks if string is a valid phone number
	* @param mixed $phoneNumber phone address to validate
	* @return bool true or false
	*/
	public static function is_phone(mixed $phoneNumber): bool 
	{
		$phoneNumber = preg_replace("/[^0-9]/", "", $phoneNumber);
        if (strlen($phoneNumber) >= 11) {
            return true; 
        }
		return false;
	}

	/** 
	* Checks if string is a valid ip address
	* @param string $ipAddress to validate
	* @return bool true or false
	*/
	public static function is_ip(string $ipAddress, int $version = 0): bool 
	{
		if ($version == 4 && filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
			return true;
		} elseif ($version == 6 && filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
			return true;
		}elseif ($version == 0 && filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6)) {
			return true;
		}
		return false;
	}

	/**
	 * Check if an IP address is valid.
	 *
	 * @param string $ipAddress The IP address to validate.
	 * @param int    $version   The IP version to validate (4 for IPv4, 6 for IPv6).
	 *
	 * @return bool True if the IP address is valid, false otherwise.
	 */
	public static function isValidIpAddress(string $ipAddress, int $version): bool 
	{
		switch ($version) {
			case 4:
				return filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;

			case 6:
				return filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;

			default:
				return filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6) !== false;
		}
	}

	/**
	 * Convert an IP address to its numeric representation (IPv4 or IPv6).
	 *
	 * @param string $ipAddress The IP address to convert.
	 *
	 * @return int|string Numeric IP address or empty string on error.
	 */
	public static function ipAddressToNumeric(string $ipAddress)
	{
		if (self::isValidIpAddress($ipAddress, 4)) {
			return ip2long($ipAddress);
		} elseif (self::isValidIpAddress($ipAddress, 6)) {
			return inet_pton($ipAddress);
		}

		return '';
	}

	/**
	 * Convert a numeric IP address to its string representation (IPv4 or IPv6).
	 *
	 * @param int|string $ipAddress The numeric IP address to convert.
	 *
	 * @return string IP address in string format or empty string on error.
	 */
	public static function numericToIpAddress($numericIp)
	{
		// Check if it's binary (IPv6) or numeric (IPv4).
		if (is_string($numericIp)) {
			// Convert binary (IPv6) to human-readable IPv6 address.
			return inet_ntop($numericIp);
		} elseif (is_numeric($numericIp)) {
			// Convert numeric (IPv4) to human-readable IPv4 address.
			return long2ip($numericIp);
		}
		return '';
	}

	/*	public static function numericToIpAddress($ipAddress) 
	{
		if (is_numeric($ipAddress)) {
			if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
				return long2ip($ipAddress);
			} elseif (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
				return inet_ntop($ipAddress);
			}
		}

		return '';
	}*/

	/** 
	 * Determine password strength, if it meet all rules
	 * @param string $password password to check
	 * @param int $minLength minimum allowed password length
	 * @param int $maxLength maximum allowed password length
	 * @param int $complexity maximum complexity pass count
	 * @return boolean 
	*/
	public static function strongPassword(string $password, int $minLength = 8, int $maxLength = 16, int $complexity=4): bool 
	{
	    $passed = 0;
	    if (strlen($password) < $minLength) {
			return false;
	    }
	    // Does string contain numbers?
	    if(preg_match("/\d/", $password) > 0) {
			$passed++;
	    }
		// Does string contain big letters?
	    if(preg_match("/[A-Z]/", $password) > 0) {
			$passed++;
	    }
		// Does string contain small letters?
	    if(preg_match("/[a-z]/", $password) > 0) {
			$passed++;
	    }
	    // Does string contain special characters?
	    if(preg_match("/[^a-zA-Z\d]/", $password) > 0) {
			$passed++;
	    }
		return ($passed >= ($complexity > 4 ? 4 : $complexity));
	}

	/** 
	* Hash password string to create a hash value
	* @param string $password password string
	* @return int 
	*/
	public static function hashPassword(string $password, int $cost = 12): string 
	{
		return password_hash($password, PASSWORD_BCRYPT, [
			'cost' => $cost
		]);
	}
	
	/** 
	* Verify a password hash and verify if it match
	* @param string $password password string
	* @param string $hash password hash
	* @return bool true or false
	*/
	public static function verifyPassword(string $password, string $hash): bool 
	{
		return password_verify($password, $hash);
	}

	/**
	 * Calculate the average rating based on the number of reviews and total rating points.
	 *
	 * @param int $totalReviews Total number of reviews.
	 * @param float $totalRating Total sum of rating points.
	 * @param int $index i forgot why i has to use this index
	 * @param bool $round Whether to round the average to 2 decimal places.
	 * @return float The average rating.
	 */
	public static function averageRating(int $totalReviews = 0, float $totalRating = 0, bool $round = false): float 
	{
		if ($totalReviews === 0) {
			return 0.0; 
		}

		$average = $totalRating / $totalReviews;
		//$average = ($totalReviews * $totalRating) / ($totalRating + $index + ($totalReviews * $totalReviews));
		return $round ? round($average, 2) : $average;
	}

	/**
	 * Formats currency with decimal places and comma separation.
	 *
	 * @param mixed $number Amount you want to format.
	 * @param bool $fractional Whether to format fractional numbers.
	 * @return string Formatted currency string.
	 */
	public static function money(mixed $number, bool $fractional = true): string 
	{
		if (!is_numeric($number)) {
			return $number;
		}
		$decimalPlaces = ($fractional) ? 2 : 0;
		return number_format((float) $number, $decimalPlaces, '.', ',');
	}

	/*public static function money(mixed $number, bool $fractional=true): string 
	{
		if ($fractional) {
			$number = sprintf('%.2f', $number);
		}
		while (true) {
			$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
			if ($replaced != $number) {
				$number = $replaced;
			} else {
				break;
			}
		}
		return $number;
	}*/


	/**
	 * Format a number with optional rounding.
	 *
	 * @param float|int|string $number The number you want to format.
	 * @param int|null $decimalPlaces The number of decimal places (null for no rounding).
	 * @return string The formatted number.
	 */
	public static function fixed($number, ?int $decimalPlaces = null): string 
	{
		$number = is_numeric($number) ? (float) $number : 0.0;
		
		if ($decimalPlaces !== null) {
			return number_format($number, $decimalPlaces, '.', '');
		}
		
		return (string) $number;
	}

	/**
	 * Calculate the discounted amount.
	 *
	 * @param mixed|float|int|string $total The total amount you want to discount.
	 * @param int $rate The discount rate (percentage) as an integer.
	 * @return float The discounted amount.
	 */
	public static function discount(mixed $total, int $rate = 0): float 
	{
		$total = is_numeric($total) ? (float) $total : 0.0;
		return $total * ((100 - $rate) / 100);
	}

	/**
	 * Calculate the total amount after adding interest.
	 *
	 * @param mixed|float|int|string $total The amount to which interest will be added.
	 * @param int $rate The interest rate as a percentage (float).
	 * @return float The total amount after adding interest.
	 */
	public static function addInterest(mixed $total, int $rate = 0): float 
	{
		$total = is_numeric($total) ? (float) $total : 0.0;
		return $total * (1 + ($rate / 100));
	}



	/**
	 * Creates badges from an array of tags.
	 *
	 * @param array $tags List of tags [a, b, c] or [key => a, key => b, key => c].
	 * @param string $class CSS class for styling.
	 * @param int $type Badge type (self::BADGE_SPAN or self::BADGE_LINK).
	 * @param string $urlPrefix URL prefix to append if badge type is self::BADGE_LINK.
	 * @return string HTML span/link elements.
	 */
	public static function badges(array $tags, string $class = "", int $type = self::BADGE_SPAN, string $urlPrefix = ""): string 
	{
		$badge = "";

		if (!empty($tags)) {
			$tagArray = explode(',', $tags);
			foreach ($tagArray as $tg) {
				if (!empty($tg)) {
					$tagContent = "<span class='{$class}' aria-label='Tag {$tg}'>{$tg}</span>";
					
					if ($type === self::BADGE_LINK) {
						$tagContent = "<a class='{$class}' href='{$urlPrefix}?tag={$tg}' aria-label='Tag {$tg}'>{$tg}</a>";
					}

					$badge .= $tagContent . " ";
				}
			}
		}

		return $badge;
	}


	/**
	 * Creates button badges from an array of tags.
	 *
	 * @param array $tags List of tags [a, b, c] or [key => a, key => b, key => c].
	 * @param string $class CSS class for styling.
	 * @param bool $truncate Whether to truncate badges if they exceed the limit.
	 * @param int $limit Maximum number of badges to display before truncating.
	 * @param string|null $selected The active badge value.
	 * @return string HTML span/button elements.
	 */
	public static function buttonBadges(array $tags, string $class = "", bool $truncate = false, int $limit = 3, ?string $selected = null): string 
	{
		$badge = "";
		$lines = 3;

		if (!empty($tags)) {
			$tagArray = (is_array($tags) ? $tags : explode(',', $tags));
			$line = 0;

			foreach ($tagArray as $tg) {
				if (!empty($tg)) {
					$isActive = ($selected === $tg || ($line === 0 && $selected === null)) ? 'active' : '';
					$badge .= "<button class='{$class} {$isActive}' type='button' data-tag='{$tg}' aria-label='Tag {$tg}'>{$tg}</button>";
					$line++;

					if ($truncate && $line === $limit) {
						$badge .= "<span class='more-badges' style='display:none;'>";
					}
				}
			}

			if ($truncate) {
				$badge .= "</span>";
				$badge .= "<button class='{$class}' type='button' data-state='show'>&#8226;&#8226;&#8226;</button>";
			}
		}

		return $badge;
	}


	/**
	 * Get the client's IP address.
	 *
	 * @return string The client's IP address or 'PROXY' if not found.
	 */
	public static function IP(): string {
		$headersToCheck = [
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR',
		];

		foreach ($headersToCheck as $header) {
			if (isset($_SERVER[$header]) && filter_var($_SERVER[$header], FILTER_VALIDATE_IP)) {
				return $_SERVER[$header];
			}
		}
		return 'PROXY';
	}

	/**
	 * Get a list of time hours in 12-hour format with 30-minute intervals.
	 *
	 * @return array An array of time hours.
	 */
	public static function hoursRange(): array 
	{
		$formatTime = function ($timestamp) {
			return date('g:iA', $timestamp);
		};

		$halfHourSteps = range(0, 47 * 1800, 1800);
		$timeHours = array_map($formatTime, $halfHourSteps);

		return $timeHours;
	}


	/**
	 * Get an array of dates for each day in a specific month.
	 *
	 * @param int $month The month (1-12).
	 * @param int $year The year.
	 * @param string $dateFormat The format for the returned dates (default is "d-M-Y").
	 * @return array An array of dates within the specified month.
	 */
	public static function daysInMonth(int $month, int $year, string $dateFormat = "d-M-Y"): array 
	{
		$numDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$datesOfMonth = [];

		for ($day = 1; $day <= $numDaysInMonth; $day++) {
			$timestamp = mktime(0, 0, 0, $month, $day, $year);
			$formattedDate = date($dateFormat, $timestamp);
			$datesOfMonth[] = $formattedDate;
		}

		return $datesOfMonth;
	}


	/**
	 * Sanitize user input to protect against cross-site scripting attacks.
	 *
	 * @param string $string The input string to be sanitized.
	 * @param string $type   The expected data type (e.g., 'int', 'email').
	 * @param string $symbol The symbol to replace disallowed characters with (optional).
	 *
	 * @return string The sanitized string.
	 */
	public static function sanitizeInput(string $string, string $type = "name", string $symbol = ""): string
	{
		switch ($type) {
			case 'int':
				return preg_replace("/[^0-9]+/", $symbol, $string);
			case 'digit':
				return preg_replace("/[^-0-9.]+/", $symbol, $string);
			case 'key':
				return preg_replace("/[^a-zA-Z0-9_-]/", $symbol, $string);
			case 'pass':
				return preg_replace("/[^a-zA-Z0-9-@!*_]/", $symbol, $string);
			case 'username':
				return preg_replace("/[^a-zA-Z0-9-_.]+/", $symbol, $string);
			case 'email':
				return preg_replace("/[^a-zA-Z0-9-@.-_]+/", $symbol, $string);
			case 'url':
				return preg_replace("/[^a-zA-Z0-9?&-+=.:'\/ ]+/", $symbol, $string);
			case 'money':
				return preg_replace("/[^0-9.-]+/", $symbol, $string);
			case 'double':
			case 'float':
				return preg_replace("/[^0-9.]+/", $symbol, $string);
			case 'az':
				return preg_replace("/[^a-zA-Z]+/", $symbol, $string);
			case 'tel':
				return preg_replace("/[^0-9-+]+/", $symbol, $string);
			case 'name':
				return preg_replace("/[^a-zA-Z., ]+/", $symbol, $string);
			case 'timezone':
				return preg_replace("/[^a-zA-Z0-9-\/,_:+ ]+/", $symbol, $string);
			case 'time':
				return preg_replace("/[^a-zA-Z0-9-: ]+/", $symbol, $string);
			case 'date':
				return preg_replace("/[^a-zA-Z0-9-:\/,_ ]+/", $symbol, $string);
			default:
				return preg_replace("/[^a-zA-Z0-9-@.,]+/", $symbol, $string);
		}
		return '';
	}


	/**
	 * Convert string characters to HTML entities with optional encoding.
	 *
	 * @param string $str The input string to be converted.
	 * @param bool $enc Whether to encode quotes as well (default is true).
	 * @return string The formatted string with HTML entities.
	 */
	public static function toHtmlentities(string $str, bool $enc = true): string
	{
		return $enc ? htmlentities($str, ENT_QUOTES, "UTF-8") : htmlentities($str);
	}

	/**
	 * Remove subdomains from a URL.
	 * @param string $url The input URL from which subdomains should be removed.
	 * @return string The main domain extracted from the URL.
	 */
	public static function removeSubdomain(string $url): string
	{
		$host = strtolower(trim($url));
		$count = substr_count($host, '.');

		if ($count === 2) {
			if (strlen(explode('.', $host)[1]) > 3) {
				$host = explode('.', $host, 2)[1];
			}
		} elseif ($count > 2) {
			$host = self::removeSubdomain(explode('.', $host, 2)[1]);
		}

		return $host;
	}


	/**
	 * Remove main domain from a URL.
	 *
	 * @param string $url The input URL from which the domain should be extracted.
	 * @return string The extracted domain or an empty string if no domain is found.
	 */
	public static function removeMainDomain(string $url): string
	{
		$domain = "";

		if (strpos($url, ".") !== false) {
			$parts = explode(".", $url, 4);

			if (count($parts) >= 3) {
				$domain = ($parts[1] !== "www") ? $parts[1] : $parts[2];
			}
		}

		return $domain;
	}

	/**
	 * Convert a string to kebab case.
	 *
	 * @param string $string The input string to convert.
	 * @return string The kebab-cased string.
	 */
	public static function toKebabCase(string $string): string
	{
		$string = str_replace([' ', ':', '.', ',', '-'], '', $string);
		$kebabCase = preg_replace('/([a-z0-9])([A-Z])/', '$1-$2', $string);
		return strtolower($kebabCase);
	}

	/**
	 * Copy files and folders from the source directory to the destination directory.
	 *
	 * @param string $origin The source directory.
	 * @param string $dest The destination directory.
	 *
	 * @return bool True if the copy operation is successful, false otherwise.
	 */
	public static function copyFiles(string $origin, string $dest): bool
	{
		if (!file_exists($dest)) {
			mkdir($dest, 0777, true);
		}

		$dir = opendir($origin);

		if (!$dir) {
			return false;
		}

		while (false !== ($file = readdir($dir))) {
			if (($file != '.') && ($file != '..')) {
				$srcFile = $origin . DIRECTORY_SEPARATOR . $file;
				$destFile = $dest . DIRECTORY_SEPARATOR . $file;

				if (is_dir($srcFile)) {
					self::copyFiles($srcFile, $destFile);
				} else {
					copy($srcFile, $destFile);
				}
			}
		}
		closedir($dir);
		return true;
	}

	/**
	 * Download a file to the user's browser.
	 *
	 * @param string $file The full file path to download.
	 * @param string $name The filename as it will be shown in the download.
	 * @param bool $delete Whether to delete the file after download (default: false).
	 */
	public static function download(string $file, string $name = null, bool $delete = false): void
	{
		if (file_exists($file)) {
			$filename = ($name??basename($file));
			header('Content-Type: ' . (mime_content_type($file) ?? 'application/octet-stream'));
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: ' . filesize($file));
			header('Cache-Control: no-store, no-cache, must-revalidate');
			header('Cache-Control: post-check=0, pre-check=0', false);
			header('Pragma: no-cache');
			readfile($file);
			if ($delete) {
				unlink($file);
			}

			exit();
		}
	}

	/**
	 * Truncate a text string and add an ellipsis if it exceeds a specified length.
	 *
	 * This function truncates the input text to the specified length and adds an ellipsis
	 * at the end if the text is longer than the specified length.
	 *
	 * @param string $text The string to truncate.
	 * @param int $length The length to display before truncating.
	 * @param int $encoding Text encoding type
	 * @return string The truncated string.
	 */
	public static function truncate(string $text, int $length = 10, string $encoding = 'UTF-8'): string
	{
		$escapedText = htmlspecialchars($text, ENT_QUOTES, $encoding);

		// Check if the text length exceeds the specified length
		if (mb_strlen($escapedText, $encoding) > $length) {
			// Truncate the text and add an ellipsis
			return mb_substr($escapedText, 0, $length, $encoding) . '...';
		}

		// Return the original text if it doesn't need truncation
		return $escapedText;
	}

	/** 
	 * Base64 encode string for URL passing
	 * @param string $input String to encode
	 * @return string Base64 encoded string
	 */
	public static function base64_url_encode(string $input): string 
	{
		return str_replace(['+', '/', '='], ['.', '_', '-'], base64_encode($input));
	}

	/** 
	 * Base64 decode URL-encoded string
	 * @param string $input Encoded string to decode
	 * @return string Base64 decoded string
	 */
	public static function base64_url_decode(string $input): string
	{
		return base64_decode(str_replace(['.', '_', '-'], ['+', '/', '='], $input));
	}

	/**
	 * Strip unwanted characters from a string.
	 *
	 * @param string $string The input string to clean.
	 * @param array $rules An array of rules to replace.
	 * @param bool $textarea If true, strictly remove all markdown if displaying on a webpage, else format with new lines inside a textarea.
	 * @return string The cleaned text.
	 */
	public static function stripText(string $string, array $rules = [], bool $textarea = true): string {
		$dict = (empty($rules) ? self::DEFAULT_RULES : $rules);
		$string = htmlspecialchars_decode($string);
		$string = str_replace(array_keys($dict), array_values($dict), $string);
		
		if (!$textarea) {
			$string = preg_replace('/(http|https|ftp|ftps|tel)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', '', $string);
			$string = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?).*$)@', '', $string);
			$string = preg_replace('|https?://www\.[a-z\.0-9]+|i', '', $string);
			$string = preg_replace('|https?://[a-z\.0-9]+|i', '', $string);
			$string = preg_replace('|www\.[a-z\.0-9]+|i', '', $string);
			$string = preg_replace('~[a-z]+://\S+~', '', $string);
			$string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
		} else {
			$string = str_replace("\n", "&#13;&#10;", $string);
		}

		return $string;
	}


	/**
	 * Mask email address.
	 *
	 * @param string $email Email address to mask.
	 * @param string $with  Mask character (default is "*").
	 * @return string Masked email address or null.
	 */
	public static function maskEmail(string $email, string $with = "*"): string 
	{
		if (!empty($email)) {
			$parts = explode("@", $email);
			$name = implode('@', array_slice($parts, 0, -1));
			$length = floor(strlen($name) / 2);
			return substr($name, 0, $length) . str_repeat($with, $length) . "@" . end($parts);
		}
		return '';
	}

	/**
	 * Mask string by position.
	 *
	 * @param string $string    String to mask.
	 * @param string $with      Mask character (default is "*").
	 * @param string $position  The position of the string to mask ("center", "left", or "right").
	 * @return string           Masked string.
	 */
	public static function mask(string $string, string $with = "*", string $position = "center"): string {
		if (empty($string)) {
			return '';
		}

		$length = strlen($string);
		$visibleCount = (int) round($length / 4);
		$hiddenCount = $length - ($visibleCount * 2);

		if ($position === "left") {
			return str_repeat($with, $visibleCount) . substr($string, $visibleCount, $hiddenCount) . substr($string, ($visibleCount * -1), $visibleCount);
		} elseif ($position === "right") {
			return substr($string, 0, ($visibleCount * -1)) . str_repeat($with, $visibleCount);
		}

		return substr($string, 0, $visibleCount) . str_repeat($with, $hiddenCount) . substr($string, ($visibleCount * -1), $visibleCount);
	}

	/**
	 * Deletes files and folders.
	 *
	 * @param string $dir   Directory to delete files.
	 * @param bool   $base  Remove the base directory once done (default is false).
	 * @return bool         Returns true once the function is called.
	 */
	public static function remove(string $dir, bool $base = false): bool 
	{
		if (!file_exists($dir)) {
			return false;
		}

		if (substr($dir, -1) !== DIRECTORY_SEPARATOR) {
			$dir .= DIRECTORY_SEPARATOR;
		}

		$files = glob($dir . '*', GLOB_MARK);

		foreach ($files as $file) {
			if (is_dir($file)) {
				self::remove($file, true);
			} else {
				@unlink($file);
			}
		}

		if ($base) {
			@rmdir($dir);
		}
		return true;
	}

	/**
	 * Write a new log line.
	 *
	 * @param string $filepath   Log file path.
	 * @param string $filename   Log file name.
	 * @param string $data       Log content.
	 * @param bool   $secure     Secure log content if the file type is .php (default is true).
	 * @param bool   $serialize  Serialize log content (default is false).
	 * @param bool   $replace    Replace the existing log file if it exists (default is false).
	 */
	public static function writeLog(
		string $filepath,
		string $filename,
		string $data,
		bool $secure = true,
		bool $serialize = false,
		bool $replace = false
	): void {
		if ($serialize) {
			$data = serialize($data);
		}

		if ($replace && file_exists($filepath . $filename)) {
			unlink($filepath . $filename);
		}

		if (!$replace && file_exists($filepath . $filename)) {
			$file_handle = fopen($filepath . $filename, "a+");
			fwrite($file_handle, PHP_EOL . $data);
			fclose($file_handle);
		} else {
			if (!is_dir($filepath)) {
				mkdir($filepath, 0777, true);
				chmod($filepath, 0755);
			}

			if ($secure && pathinfo($filename, PATHINFO_EXTENSION) === "php") {
				$data = '<?php header("Content-type: text/plain"); die("Access denied"); ?>' . PHP_EOL . $data;
			}

			$fp = fopen($filepath . $filename, 'w');
			fwrite($fp, $data);
			fclose($fp);
		}
	}

	/**
	 * Save a log and replace old content.
	 *
	 * @param string $filepath   Log file path.
	 * @param string $filename   Log file name.
	 * @param string $data       Log content.
	 * @param bool   $secure     Secure log content if the file type is .php (default is true).
	 * @param bool   $serialize  Serialize log content (default is false).
	 */
	public static function saveLog(
		string $filepath,
		string $filename,
		string $data,
		bool $secure = true,
		bool $serialize = false
	): void {
		self::writeLog($filepath, $filename, $data, $secure, $serialize, false);
	}


	/**
	 * Find a log file.
	 *
	 * @param string $filepath    Log file path.
	 * @param bool   $unserialize Unserialize the log content if it was serialized (default is false).
	 * @return mixed|null Log content or null if the file doesn't exist or couldn't be read.
	 */
	public static function findLog(string $filepath, bool $unserialize = false): mixed {
		$data = null;

		if (file_exists($filepath)) {
			$file = @file_get_contents($filepath);

			if ($file !== false && !empty($file)) {
				$data = self::unlockLog($file);

				if ($unserialize) {
					$unsterilizedData = unserialize($data);

					if ($unsterilizedData !== false) {
						$data = $unsterilizedData;
					} else {
						unlink($filepath);
						$data = null;
					}
				}
			}
		}

		return $data;
	}

	/**
	 * Remove security from a PHP log file content.
	 *
	 * @param string $str Log content.
	 * @return string Unsecured log content.
	 */
	private static function unlockLog(string $str): string {
		$position = strpos($str, "\n");

		if ($position === false) {
			return $str;
		}

		return substr($str, $position + 1);
	}
}
