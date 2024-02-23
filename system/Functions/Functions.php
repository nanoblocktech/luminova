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

use Luminova\Functions\Escaper;
use \InvalidArgumentException;
use \Countable;

class Functions
{
	public const INT = "int";
	public const CHAR = "char";
	public const STR = "str";
	public const SALT = "salt";
	public const SID = "sid";
	public const UUI = "uui";
	public const PASS = "pass";
	
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
	 * Format input to person name
	 * 
	 * @param string $input input string
	 * @param string $replacement replacement unwanted string
	 * 
	 * @return string $format
	*/
	public static function toName(string $input, string $replacement = ''): string
	{
		$format = preg_replace("/[^a-zA-Z0-9-_. ]+/", $replacement, $input);

		return $format;
	}

	/**
	 * Check if variable matches any of the array values
	 * 
	 * @param string $needle input string
	 * @param array $haystack The array to search in
	 * 
	 * @return bool true or false
	*/
	public static function matchIn(string $needle, array $haystack): bool 
	{
		foreach ($haystack as $item) {
			if (stripos($needle, $item) !== false) {
			  return true;
			}
		}
		return false;
	}

	/**
	 * Check if variable matches any of the array values
	 * 
	 * @param string $needle input string
	 * @param array $haystack The array to search in
	 * 
	 * @deprecated this method is deprecated and will be removed in future use matchIn() method instead
	 * @return bool true or false
	*/
  	public static function isNameBanned(mixed $nameToCheck, array $bannedNames): bool 
	{
      	return self::matchIn($nameToCheck, $bannedNames);
  	}

	/**
	 * Format text before display or saving 
	 * By matching links, email, phone, hashtags and mentions with a link representation
	 * And replace multiple new lines
	 * 
	 * @param string $text
	 * @param string $target link target action
	 * @param string $blocked Replace blocked word with
	 * 
	 * @return string $text
	*/
	public static function sanitizeText(string $text, ?string $target = null, ?string $blocked = null): string 
	{
		$blockedContent = $blocked || '<i style="color:darkred;">⚠️ Content Blocked</i>';

		$targetTo = ($target !== null ? "target='{$target}'" : '');

		$text = preg_replace('/<([^>]+)>(.*?)<\/\1>|<([^>]+) \/>/', $blockedContent, $text); 

		// Replace website links
		$text = preg_replace('/(https?:\/\/(?:www\.)?\S+(?:\.(?:[a-z]+)))/i', '<a href="$1" ' . $targetTo . '>$1</a>', $text);

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

	/**
	 * Filter and sanitize text before saving to database 
	 * 
	 * @param string $text
	 * @param bool $all
	 * 
	 * @return string $text
	*/
	public static function filterText(string $text, bool $all = true): string 
	{
		$pattern = ($all ? '/<[^>]+>/' : '/<(?!\/?b(?=>|\s.*>))[^>]+>/');
		$text = preg_replace('/<([^>]+)>(.*?)<\/\1>|<([^>]+) \/>/', '⚠️', $text); 
		$text = preg_replace($pattern, '', $text) ;
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
	public static function random(int $length = 10, string $type = self::INT, bool $upper = false): string 
	{
		$char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$int = '0123456789';
	
		$hash = match ($type) {
			self::CHAR => $char,
			self::STR => $int . $char,
			self::SALT => $int . $char . '%#*^,?+$`;"{}][|\/:=)(@!.',
			self::PASS => $int . $char . '%#^_-@!',
			self::SID => $int . $char . '-',
			default => $int
		};
	
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
	 * Generate product EAN13 id
	 * 
	 * @param int $country start prefix country code
	 * @param int $length maximum length
	 * 
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
	 * 
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

	public static function timeSocial(string|int $time): string 
	{
		$elapsed = time() - strtotime((string) $time);
		return match (true) {
			$elapsed <= 60 => "just now",
			$elapsed <= 3600 => sprintf('%d minute%s ago', round($elapsed / 60), (round($elapsed / 60) == 1) ? '' : 's'),
			$elapsed <= 86400 => sprintf('%d hour%s ago', round($elapsed / 3600), (round($elapsed / 3600) == 1) ? '' : 's'),
			$elapsed <= 604800 => sprintf('%d day%s ago', round($elapsed / 86400), (round($elapsed / 86400) == 1) ? '' : 's'),
			$elapsed <= 2419200 => sprintf('%d week%s ago', round($elapsed / 604800), (round($elapsed / 604800) == 1) ? '' : 's'),
			$elapsed <= 29030400 => sprintf('%d month%s ago', round($elapsed / 2419200), (round($elapsed / 2419200) == 1) ? '' : 's'),
			default => sprintf('%d year%s ago', round($elapsed / 29030400), (round($elapsed / 29030400) == 1) ? '' : 's'),
		};
	}

	/**
	 * Check if a certain amount of minutes has passed since the given timestamp.
	 *
	 * @param int|string $timestamp Either a Unix timestamp or a string representing a date/time.
	 * @param int $minutes The number of minutes to check against.
	 *
	 * @return bool True if the specified minutes have passed, false otherwise.
	 */
	public static function timeHasPassed($timestamp, int $minutes): bool 
	{
		if (is_numeric($timestamp)) {
			$timestamp = (int) $timestamp;
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
	 * Check if values are empty
	 * 
	 * @param mixed ...$values arguments
	 * 
	 * @return bool
	 */
	public static function isEmpty(mixed ...$values): bool 
	{
		foreach ($values as $value) {

			if ($value === null || $value === []) {
				return true;
			}

			if (is_string($value)) {
				return trim($value) === '';
			}

			if (is_object($value) && $value instanceof Countable) {
				return count($value) === 0;
			}

			if (empty($value)) {
				return true;
			}
		}

		return false;
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
	 * 
	 * @param string $email email address to validate
	 * 
	 * @return bool true or false
	 */
	public static function is_email(string $email): bool
	{
		if(filter_var($email, FILTER_VALIDATE_EMAIL) !== false){
			return true;
		}

		if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)){
			return true;
		}

		return false;
	}


	/** 
	* Checks if string is a valid phone number
	*
	* @param mixed $phone phone address to validate
	*
	* @return bool true or false
	*/
	public static function is_phone(string|int $phone): bool 
	{
		// Remove any non-digit characters
		$phone = preg_replace('/\D/', '', $phone);
	
		// Check if the phone number is numeric and has a valid length
		if (is_numeric($phone) && (strlen($phone) >= 10 && strlen($phone) <= 15)) {
			return true;
		}

		return false;
	}

	/**
	 * Checks if string is a valid email address or phone number
	 * 
	 * @param string $input email address or phone number to validate
	 * 
	 * @deprecated this method is deprecated and will be removed in future 
	 * @return bool true or false
	 */
	public static function is_email_or_phone(string $input): bool
	{
		if (self::is_email($input) || self::is_phone($input)) {
			return true;
		}
		
		return false;
	}

	/** 
	* Checks if string is a valid phone number
	*
	* @param mixed $phone phone address to validate
	*
	* @deprecated this method is deprecated and will be removed in future use is_phone() instead
	* @return bool true or false
	*/
	public static function isPhoneNumber(mixed $phone): bool 
	{
		return self::is_phone($phone);
	}

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
	*
	* @param string $password password string
	* @param int $cost 
	*
	* @return string 
	*/
	public static function hashPassword(string $password, int $cost = 12): string 
	{
		return password_hash($password, PASSWORD_BCRYPT, [
			'cost' => $cost
		]);
	}
	
	/** 
	* Verify a password hash and verify if it match
	*
	* @param string $password password string
	* @param string $hash password hash
	*
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
	 * 
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
	 * 
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

	/**
	 * Format a number with optional rounding.
	 *
	 * @param float|int|string $number The number you want to format.
	 * @param int|null $decimalPlaces The number of decimal places (null for no rounding).
	 * 
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
	 * 
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
	 * 
	 * @return float The total amount after adding interest.
	 */
	public static function addInterest(mixed $total, int $rate = 0): float 
	{
		$total = is_numeric($total) ? (float) $total : 0.0;
		return $total * (1 + ($rate / 100));
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
	 * 
	 * @return array An array of dates within the specified month.
	 */
	public static function daysInMonth(int $month = 0, int $year = 0, string $dateFormat = "d-M-Y"): array 
	{
		if($month === 0){
			$month = date('M');
		}

		if($year === 0){
			$year = date('Y');
		}

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
		$patterns = [
			'int' => "/[^0-9]+/",
			'digit' => "/[^-0-9.]+/",
			'key' => "/[^a-zA-Z0-9_-]/",
			'pass' => "/[^a-zA-Z0-9-@!*_]/",
			'username' => "/[^a-zA-Z0-9-_.]+/",
			'email' => "/[^a-zA-Z0-9-@.]+/",
			'url' => "/[^a-zA-Z0-9?&+=.:\/ -]+/",
			'money' => "/[^0-9.-]+/",
			'double' => "/[^0-9.]+/",
			'float' => "/[^0-9.]+/",
			'az' => "/[^a-zA-Z]+/",
			'tel' => "/[^0-9-+]+/",
			'text' => "/[^a-zA-Z0-9-_.,!}{;: ?@#%&]+/",
			'name' => "/[^a-zA-Z., ]+/",
			'timezone' => "/[^a-zA-Z0-9-\/,_:+ ]+/",
			'time' => "/[^a-zA-Z0-9-: ]+/",
			'date' => "/[^a-zA-Z0-9-:\/,_ ]+/",
			'escape' => null, 
			'default' => "/[^a-zA-Z0-9-@.,]+/",
		];
		
		$pattern = $patterns[$type] ?? $patterns['default'];

		if ($pattern === null) {
			return self::escape($string, 'html', 'UTF-8');
		}

		return preg_replace($pattern, $symbol, $string);
	}

	/**
	 * Convert string characters to HTML entities with optional encoding.
	 *
	 * @param string $str The input string to be converted.
	 * @param string $encode Encoding
	 * 
	 * @return string The formatted string with HTML entities.
	 */
	public static function toHtmlentities(string $str, string $encode = 'UTF-8'): string
	{
		return self::escape($str, 'html', $encode);
	}

	 /**
     * Escapes a string or array of strings based on the specified context.
     *
     * @param string|array $input The string or array of strings to be escaped.
     * @param string $context The context in which the escaping should be performed. Defaults to 'html'.
     *                        Possible values: 'html', 'js', 'css', 'url', 'attr', 'raw'.
     * @param string|null $encoding The character encoding to use. Defaults to null.
     * @return mixed The escaped string or array of strings.
     * @throws InvalidArgumentException When an invalid escape context is provided.
     * @throws Exception;
     * @throws RuntimeException;
     */
    public static function escape(string|array $input, string $context = 'html', ?string $encoding = null): mixed
    {
        if (is_array($input)) {
            // Recursively escape each element in the array
            array_walk_recursive($data, function (&$value) use ($context, $encoding) {
                $value = self::escape($value, $context, $encoding);
            });
        } elseif (is_string($input)) {
            $context = strtolower($context);
            if ($context === 'raw') {
                return $input;
            }

            if (!in_array($context, ['html', 'js', 'css', 'url', 'attr'], true)) {
                throw new InvalidArgumentException('Invalid escape context provided.');
            }

            // Determine the escape method based on the context
            $method = $context === 'attr' ? 'escapeHtmlAttr' : 'escape' . ucfirst($context);

            // Instantiate the Escaper object only if necessary
            static $escaper;
            if (!$escaper || ($encoding && $escaper->getEncoding() !== $encoding)) {
                $escaper = new Escaper($encoding);
            }

            // Perform escaping
            $input = $escaper->{$method}($input);
        }

        return $input;
    }

	/**
	 * Remove subdomains from a URL.
	 * 
	 * @param string $url The input URL from which subdomains should be removed.
	 * 
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
		$domain = '';

		if (strpos($url, '.') !== false) {
			$parts = explode('.', $url, 4);

			if (count($parts) >= 3) {
				$domain = ($parts[1] !== 'www') ? $parts[1] : $parts[2];
			}
		}

		return $domain;
	}

	/**
	 * Convert a string to kebab case.
	 *
	 * @param string $string The input string to convert.
	 * 
	 * @return string The kebab-cased string.
	 */
	public static function toKebabCase(string $string): string
	{
		$string = str_replace([' ', ':', '.', ',', '-'], '', $string);
		$kebabCase = preg_replace('/([a-z0-9])([A-Z])/', '$1-$2', $string);

		return strtolower($kebabCase);
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
}
