<?php 
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
	private const DS = DIRECTORY_SEPARATOR;
	private const DEFAULT_RULES = array(
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
	);

	/**
	* Class constructor
	*/
	public function __construct(){
	}
	/** 
	 * Create a random value
	 * @param int $length length
	 * @param string $type the random value type
	 * @param bool $upper make value upper case if string
	 * @return mixed 
	*/
	public static function Random($length = 10, $type = self::INT, $upper = false){
		if($type==self::UUI){
			return self::uuid();
		}
		$char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$int = '0123456789';
		switch($type) {
			case self::INT:
				$hash = $int;
			break;
			case self::CHAR: 
				$hash = $char;
			break;
			case self::STR: 
				$hash = $int.$char;
			break;
			case self::SALT: 
				$hash = $int.$char . '%#*^,?+$`;"{}][|\/:=)(@!.';
			break;
			case self::SID: default: 
				$hash = $int.$char . '-';
			break;
		}
		$strLength = strlen($hash);
		$key = '';
		for ($i = 0; $i < $length; $i++) {
			$key .= $hash[rand(0, $strLength - 1)];
		}
		return $upper ? strtoupper($key) : $key;
	}

	/** 
	 * Create a random integer based on minimum and maximum
	 * @param int $min number
	 * @param int $max number
	 * @return int 
	*/
	public static function BigInteger($min, $max) {
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
	public static function EAN($country = 615, $length = 13){
		return self::UPC($country, $length);
	}

	/** 
	 * Gernerate product UPC id
	 * @param int $prefix start prefix number
	 * @param int $length maximum length
	 * @return int 
	*/
	public static function UPC($prefix = 0, $length = 12){
		$length -= ( strlen($prefix) + 1 );
		$code = $prefix . str_pad(self::Random($length), $length, '0');
		$weightFlag = true;
		$sum = 0;
		for ($i = strlen($code) - 1; $i >= 0; $i--) {
			$sum += (int)$code[$i] * ($weightFlag ? 3 : 1);
			$weightFlag = !$weightFlag;
		}
		$code .= (10 - ($sum % 10)) % 10;
		return $code;
	}
	
	/** 
	 * Determine password strength, if it meet all rules
	 * @param string $password password to check
	 * @param int $minLength minimum allowed password length
	 * @param int $maxLength maximum allowed password length
	 * @param int $complexity maximum complexity pass count
	 * @return boolean 
	*/
	public static function strongPassword($password, $minLength = 8,$maxLength = 16, $complexity=4) {
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

	    return ($passed >= ($complexity > 4 ? 4 :  $ComplexityCount));
	}

	/** 
	 * Converts php timestamps to social media time format
	 * @param int|string $time time stamp
	 * @return string time in ago
	*/
	public static function timeSocial($time){
		$time_elapsed   = (time() - strtotime($time));
		$seconds    = $time_elapsed;
		$minutes    = round($time_elapsed / 60 );
		$hours      = round($time_elapsed / 3600);
		$days       = round($time_elapsed / 86400 );
		$weeks      = round($time_elapsed / 604800);
		$months     = round($time_elapsed / 2600640 );
		$years      = round($time_elapsed / 31207680 );

		if($seconds <= 60){ 
			return "just now";
		}else if($minutes <=60){
			if($minutes==1){ 
				return "one minute ago";
			}else{ 
				return $minutes." minutes ago";
			}
		}else if($hours <=24){
			if($hours==1){ 
				return "an hour ago";
			}else{ 
				return $hours." hours ago"; 
			}
		}else if($days <= 7){
			if($days==1){ 
				return "yesterday";
			}else{ 
				return $days." days ago";
			}
		}else if($weeks <= 4.3){ 
			if($weeks==1){ 
				return "a week ago";
			}else{ 
				return $weeks." weeks ago";
			}
		}else if($months <=12){ 
			if($months==1){ 
				return "a month ago";
			}else{ 
				return $months." months ago";
			}
		}else{ 
			if($years==1){ 
				return "one year ago";
			}else{ 
				return $years." years ago";
			}
		}
	}

	public static function daysSuffix($day) {
		$i = (int) $day;
		$j = $i % 10;
		$k = $i % 100;
		if ($j == 1 && $k != 11) {
			return $i . "st";
		}
		if ($j == 2 && $k != 12) {
			return $i . "nd";
		}
		if ($j == 3 && $k != 13) {
			return $i . "rd";
		}
		return $i . "th";
	}
	
	/** 
	* Generates uuid string
	* @return string uuid
	*/
	public static function uuid() {
		return sprintf(
			'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand( 0, 0xffff ),
			mt_rand( 0, 0xffff ),
			mt_rand( 0, 0xffff ),
			mt_rand( 0, 0x0fff ) | 0x4000,
			mt_rand( 0, 0x3fff ) | 0x8000,
			mt_rand( 0, 0xffff ),
			mt_rand( 0, 0xffff ),
			mt_rand( 0, 0xffff )
		);
	}
	

	/** 
	* Checks a valid uuid
	* @param string $uuid 
	* @return bool true or false
	*/
	public static function is_uuid( $uuid ) {
		if ( ! is_string( $uuid ) ) {
			return false;
		}
		$regex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/';
		return (bool) preg_match( $regex, $uuid );
	}

	/** 
	* Checks if string is a valid email address
	* @param string|email $email email address to validate
	* @return bool true or false
	*/
	public static function is_email($email){
		if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email) or filter_var($email, FILTER_SANITIZE_EMAIL) !== false){
			return true;
		}else if(filter_var($email, FILTER_VALIDATE_INT) !== FALSE){
			return true;
		}
		return false;
	}

	/** 
	* Encrypt password string to create a hash value
	* @param string $password password string
	* @return int 
	*/
	public static function Encrypt($password){
		$options = array(
			'cost' => 12
		);
		return password_hash($password, PASSWORD_BCRYPT, $options);
	}
	
	/** 
	* Decrypts a password hash and verify if it match
	* @param string $password password string
	* @param string $hash password hash
	* @return bool true or false
	*/
	public static function Decrypt($password, $hash){
		return (password_verify($password, $hash) ? true : false);
	}

	/** 
	* Calculate items average rating point
	* @param int $reviews total number of reviews
	* @param float $rating total number of ratings on product
	* @param int $index i forgot why i has to use this index
	* @param bool $round fixed/round to 2
	* @return float average
	*/
	public static function calcAverageRating($reviews=0, $rating=0, $index=1, $round=false){
		$rating = ($reviews*$rating)/($rating+$index+($reviews*$reviews));
		return  $round ? round($rating, 2) : $rating;
	}

	/** 
	 * Formats currency to add decimal places
	 * @param mixed $number amount you want to format
	 * @param bool $fractional format fraction number
	 * @return string formatted money format string
	*/
	public static function Money($number, $fractional=true) {
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
	}

	/** 
	 * Fixed/Round a number d
	 * @param mixed $number amount you want to format
	 * @param bool $round decimal places
	 * @return mixed formatted number 
	*/
	public static function Fixed($number, $round){
		return number_format((float)$number, $round, '.', '');
	}
	
	/** 
	 * Discount from amount
	 * @param mixed $total amount you want to discount
	 * @param int $rate discount rate
	 * @return float discounted amount 
	*/
	public static function Discount($total, $rate = 0){
		return ($total * ((100-$rate) / 100));
	}

	/** 
	 * Add Interest to amount
	 * @param mixed $total amount you want to add extra interest
	 * @param int $rate interest rate
	 * @return float increased interest amount 
	*/
	public static function Interest($total, $rate = 0){
		return ($total * ((100+$rate) / 100));
	}

	/** 
	* Creates a badge from array
	* @param array $tags list of tags [a, b, c] or [key => a, key => b, key => c]
	* @param string $color background color of the badge
	* @param int $type badge type
	* @param string $urlPrefix url to append to link if badge type is self::BADGE_LINK
	* @return html|string html span/link elements
	*/
	public static function badges($tags, $color="secondary", $type = self::BADGE_SPAN, $urlPrefix = "") {
		$badge = "";
		if (!empty($tags)) {
			$tagArray = explode(',', $tags);
			foreach($tagArray as $tg){
				if(!empty($tg)){
					if($type == self::BADGE_LINK){
						$badge .= "<a class='btn rounded-pill link-tag px-3 py-1 mx-1 my-1 btn-{$color}' href='{$urlPrefix}?tag={$tg}' aria-label='Tag {$tg}'>{$tg}</a>";
					}else{
						$badge .= "<span class='badge bg-{$color}' aria-label='Tag {$tg}'>{$tg}</span> ";
					}
				}
			}
		}
		return $badge;
	}

	/** 
	 * Creates a button badge from array
	 * @param array $tags list of tags [a, b, c] or [key => a, key => b, key => c]
	 * @param string $color background color of the badge
	 * @param bool $truncate truncate badge buttons on limit
	 * @param int $limit truncate badge buttons limit
	 * @param string $selected active button the badge value
	 * @return html|string html span/button elements
	*/
	public static function buttonBadges($tags, $color="secondary", $truncate = false, $limit = 3, $selected = null) {
		$badge = "";
		$lines = 3;
		if (!empty($tags)) {
			$tagArray = (is_array($tags) ? $tags : explode(',', $tags));
			$line = 0;
			foreach($tagArray as $tg){
				if(!empty($tg)){
					$badge .= "<button class='btn rounded-pill text-uppercase px-3 py-1 mx-1 my-1 ".($selected == $tg ? 'btn-success btn-disabled': (empty($selected) && $line==0 ? 'btn-success btn-tag': (empty($selected) ? 'btn-tag btn-' . $color:'btn-' . $color)))."' type='button' data-tag='{$tg}' aria-label='Tag {$tg}'>{$tg}</button>";
					$line++;
					if ($truncate && $line == $limit) { 
						$badge .= "<span class='more-categories d-none'>";
					}
				}
			}
			if($truncate){
				$badge .= "</span>";
				$badge .= "<button class='btn rounded-pill btn-more-tag text-uppercase px-3 py-1 mx-1 my-1 btn-" . $color . "' type='button' data-state='show'>&#8226;&#8226;&#8226;</button>";
			}
		}
		return $badge;
	}

	/** 
	 * Gets ip address
	 * @return mixed ip address
	*/
	public static function IP() {
		$ip = 'PROXY';
		if (isset($_SERVER['HTTP_CLIENT_IP'])){
	    		$ip = $_SERVER['HTTP_CLIENT_IP'];
		}else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else if(isset($_SERVER['HTTP_X_FORWARDED'])){
			$ip = $_SERVER['HTTP_X_FORWARDED'];
		}else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_FORWARDED_FOR'];
		}else if(isset($_SERVER['HTTP_FORWARDED'])){
	    		$ip = $_SERVER['HTTP_FORWARDED'];
		}else if(isset($_SERVER['REMOTE_ADDR'])){
	    		$ip = $_SERVER['REMOTE_ADDR'];
		}

		if(!filter_var($ip, FILTER_VALIDATE_IP)){
			$ip = 'UNKNOWN';
		}else if($ip == '::1'){
			$ip = '127.0.0.1';
		}

		return $ip;
	}

	/** 
	 * gets list of hours
	 * @return array time hours
	*/
	public static function hoursRange() {
		$formatter = function ($time) {
			return date('g:iA', $time);
		};
		$halfHourSteps = range(0, 47*1800, 1800);
		return array_map($formatter, $halfHourSteps);
	}

	public static function daysInMonth($month, $year, $format="d-M-Y") {
		$num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$dates_month = array();
		for ($i = 1; $i <= $num; $i++) {
			$mktime = mktime(0, 0, 0, $month, $i, $year);
			$date = date($format, $mktime);
			$dates_month[$date] = $date;
		}
		return $dates_month;
	}

	/** 
	 * Formats user input to protect again cross site scripting attacks
	 * @param string $type the expected data type
	 * @param string $string string to format
	 * @return mixed formatted data
	*/
	public static function XSS($string, $type = "name", $symbol = ""){
		switch ($type){
			case 'int': $cleanStings = preg_replace("/[^0-9]+/", $symbol, $string); break;
			case 'key': $cleanStings = preg_replace("/[^a-zA-Z0-9_-]/", $symbol, $string);  break; 
			case 'pass': $cleanStings = preg_replace("/[^a-zA-Z0-9-@!*_]/", $symbol, $string);  break; 
			case 'username': $cleanStings = preg_replace("/[^a-zA-Z0-9-_.]+/", $symbol, $string);  break;
			case 'email': $cleanStings = preg_replace("/[^a-zA-Z0-9-@.-_]+/", $symbol, $string);  break;
			case 'url': $cleanStings = preg_replace("/[^a-zA-Z0-9?&-+=.:'\/ ]+/", $symbol, $string);  break;
			case 'money': $cleanStings = preg_replace("/[^0-9.-]+/", $symbol, $string); break;
			case 'double': case 'float': $cleanStings = preg_replace("/[^0-9.]+/", $symbol, $string); break;
			case 'az': $cleanStings = preg_replace("/[^a-zA-Z]+/", $symbol, $string);  break;
			case 'tel': $cleanStings = preg_replace("/[^0-9-+]+/", $symbol, $string); break;
			case 'name': $cleanStings = preg_replace("/[^a-zA-Z., ]+/", $symbol, $string);  break;
			case 'timezone': $cleanStings = preg_replace("/[^a-zA-Z0-9-\/,_:+ ]+/", $symbol, $string);  break;
			case 'time': $cleanStings = preg_replace("/[^a-zA-Z0-9-: ]+/", $symbol, $string);  break;
			case 'date': $cleanStings = preg_replace("/[^a-zA-Z0-9-:\/,_ ]+/", $symbol, $string);  break;
			default: $cleanStings = preg_replace("/[^a-zA-Z0-9-@.,]+/", $symbol, $string);  break;
		}
		return $cleanStings;
	}

	/** 
	 * Formats Convert string characters to HTML entities
	 * @param string $str string
	 * @param bool $enc encode
	 * @return string formatted string
	*/
	public static function htmlentities($str, $enc = true){
		//return $enc ? htmlentities($str, ENT_QUOTES, "UTF-8") : htmlentities($str);
		return htmlentities($str);
	}
	
	public static function removeSubdomain($url){
		  $host = strtolower(trim($url));
		  $count = substr_count($host, '.');
		  if($count === 2){
		    if(strlen(explode('.', $host)[1]) > 3) $host = explode('.', $host, 2)[1];
		  } else if($count > 2){
		    $host = self::removeSubdomain(explode('.', $host, 2)[1]);
		  }
		  return $host;
	}

	public static function removeDomain($url){
		$subdomain = "";
		if(strpos($url, ".") !== false && $list = explode(".", $url, 4)) {
			if(count($list) >= 3){
				$subdomain = (($list[0] != "www") ? $list[0] :  $list[1]);
			}
		}
		return $subdomain;
	}

	public static function toKebabCase($string) {
		$string = str_replace([' ', ':', '.', ',','-'], '', $string);
		$kebabCase = preg_replace('/([a-z0-9])([A-Z])/', '$1-$2', $string);
		return strtolower($kebabCase);
	}

	/** 
	 * Copy files and folder to a new directory
	 * @param string $origin string
	 * @param string $dest destination folder
	 * @return bool once function is called
	*/
	public static function copyFiles($origin, $dest){
		$dir = opendir($origin);
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				if ( is_dir($origin . self::DS . $file) ) {
					self::copyFiles($origin . self::DS . $file, $dest . self::DS. $file);
				}else {
					copy($origin . self::DS . $file, $dest . self::DS . $file);
				}
			}
		}
		closedir($dir);
		return true;
	}

	/** 
	 * Download file on browser
	 * @param string $file full file path to download 
	 * @param string $name filename as showed in path
	 * @param bool $delete delete file once download is complete
	*/
	public static function download($file, $name, $delete = false){
		if(file_exists($file)){
			header('Content-Type: ' . (mime_content_type($file)??'application-x/force-download'));
			header('Content-Description: File Transfer');
			header("Content-Transfer-Encoding: binary");
			header('Connection: Keep-Alive');
			header('Expires: 0');
			header("Expires: ".gmdate("D, d M Y H:i:s", mktime(date("H")+2, date("i"), date("s"), date("m"), date("d"), date("Y")))." GMT");
			header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
			if(FALSE === strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE ')){
				header("Cache-Control: no-cache, must-revalidate");
			}
			header("Cache-Control: no-cache, no-store, must-revalidate, private");
			header('Cache-Control: private', false);
			header('Pragma: public'); 
			header("Content-Length: " . filesize($file));
			header("Content-Disposition: attachment; filename=\"".$name."\"");
			readfile($file);
			if($delete){
				unlink($file);
			}
			exit();
		}
	}

	/** 
	 * Truncate text
	 * @param string $text the string to truncate
	 * @param int $length the length to display
	 * @return string truncated string
	*/
	public static function truncate($text, $length = 10){
		$return = htmlspecialchars($text, ENT_QUOTES, "UTF-8");
		if(strlen($text) > $length){
			return substr($return, 0, $length) . "...";
		}
		return $return;
	}

	/** 
	 * Base64 encode string for url passing
	 * @param string $input string to encode
	 * @return string base64 encoded string
	*/
	public static function base64_url_encode($input) {
		return strtr(base64_encode($input), '+/=', '._-');
	}
    
	/** 
	 * Base64 decode encoded url encoded string
	 * @param string $input encoded string to decode
	 * @return string base64 decoded string
	*/
	public static function base64_url_decode($input) {
		return base64_decode(strtr($input, '._-', '+/='));
	}

	/** 
	 * Stripes unwanted characters from string
	 * @param string $string string clean
	 * @param array $rules array of rules to replace
	 * @param bool $textarea strictly remove all markdown if displaying on webpage else if inside a textarea format with new line
	 * @return string clean text
	*/
	public static function stripeText($string, $rules = array(), $textarea = true){
		$dict = (empty($rules) ? self::DEFAULT_RULES : $rules);
		$string = htmlspecialchars_decode($string);
		$string = str_replace(array_keys($dict), array_values($dict), $string);
		if(!$textarea){
			$string = preg_replace('/(http|https|ftp|ftps|tel)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', '', $string);
			$string = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?).*$)@', '', $string);
			$string = preg_replace('|https?://www\.[a-z\.0-9]+|i', '', $string);
			$string = preg_replace('|https?://[a-z\.0-9]+|i', '', $string);
			$string = preg_replace('|www\.[a-z\.0-9]+|i', '', $string);
			$string = preg_replace('~[a-z]+://\S+~', '', $string);
			$string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
		}else{
			$string = str_replace("\n", "&#13;&#10;", $string);
		}
		return $string;
	}

	/** 
	 * Mask email address
	 * @param string $email email address to mask
	 * @param string $with mask character
	 * @return string|null string masked email address or null
	*/

	public static function maskEmail($email, $with = "*") {
		if(!empty($email)){
			$em   = explode("@",$email);
			$name = implode('@', array_slice($em, 0, count($em)-1));
			$len  = floor(strlen($name)/2);
			return substr($name,0, $len) . str_repeat($with, $len) . "@" . end($em);
		}
		return null;
	}

	/** 
	 * Mask string by position
	 * @param string $string string to mask
	 * @param string $with mask character
	 * @param string $position the position of the string to mask
	 * @return string masked string
	*/
	public static function mask($string, $with = "*", $position = "center"){
		if (empty($string)) {
			return null;
		}
		$length = strlen($string);
		$visibleCount = (int) round($length / 4);
		$hiddenCount = $length - ($visibleCount * 2);

		if($position == "left"){
			return str_repeat($with, $visibleCount) . substr($string, $visibleCount, $hiddenCount) . substr($string, ($visibleCount * -1), $visibleCount);
		}else if($position == "right"){
			return  substr($string, 0, ($visibleCount * -1)) . str_repeat($with, $visibleCount);
		}
		return substr($string, 0, $visibleCount) . str_repeat($with, $hiddenCount) . substr($string, ($visibleCount * -1), $visibleCount);
	}

	/** 
	 * Deletes files and folders
	 * @param string $dir directory to delete files
	 * @param string $base remove base directory once done
	 * @return bool return true once function is called
	*/
	public static function remove($dir, $base = false) {
		if (!file_exists($dir)) {
			return false;
		}
		if (substr($dir, strlen($dir) - 1, 1) != self::DS) {
			$dir .= self::DS;
		}
		$files = glob($dir . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::remove($file, true);
			} else {
				@unlink($file);
			}
		}
		if($base){
			@rmdir($dir);
		}
		return true;
	}


	/** 
	 * Write new log line
	 * @param string $filepath log filepath 
	 * @param string $filename log filename
	 * @param string $data log content
	 * @param bool $secure secure log content if file type is .php
	 * @param bool $serialize serialize log content
	 * @param bool $replace by default it will write new data in a new line if replace is false
	*/
	public static function writeLog($filepath, $filename, $data, $secure = true, $serialize = false, $replace = false){
		if($serialize){
		    $data = serialize($data);
		}
		if($replace && file_exists($filepath . $filename)){
			unlink($filepath . $filename);
		}

		if(!$replace && file_exists($filepath . $filename)){
			$file_handle = fopen($filepath . $filename, "a+");
			fwrite($file_handle, "\n" . $data);
			fclose($file_handle);
		}else{
			if(!is_dir($filepath)){
				mkdir($filepath, 0777, true);
				chmod($filepath, 0755); 
			}
			if($secure && pathinfo($filename, PATHINFO_EXTENSION) == "php"){
				$data = '<?php header("Content-type: text/plain"); die("Access denied");?>' . PHP_EOL . $data;
			}
			$fp = fopen($filepath . $filename, 'w');
			fwrite($fp, $data);
			fclose($fp);
		}
	}

	/** 
	* Save log and replace old content
	* @param string $filepath log filepath 
	* @param string $filename log filename
	* @param string $data log content
	* @param bool $secure secure log content if file type is .php
	* @param bool $serialize serialize log content
	*/
	public static function saveLog($filepath, $filename, $data, $secure = true, $serialize = false){
		self::writeLog($filepath, $filename, $data, $secure, $serialize, false);
	}

	/** 
	 * Find log file
	 * @param string $filepath log filepath 
	 * @param bool $unserialize unserialize if the log content was serialized
	 * @return string return lo content
	*/
	public static function findLog($filepath, $unserialize = false){
		$data = null;
		if(file_exists($filepath)){
		    $file = @file_get_contents($filepath);
			if (!empty($file)) {
				$data = self::unlockLog($file);
				if($unserialize){
					$data = unserialize($data);
					if ($data === false) {
						unlink($filepath);
					}
				}
			}
		}
		return $data;
	}

	/** 
	 * Remove security on php log file
	 * @param string $str log content 
	 * @return string return unsecure lo content
	*/
	private static function unlockLog($str) {
		$position = strpos($str, "\n");

		if ($position === false)
		    return $str;

		return substr($str, $position + 1);
	}

}
