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

class IPAddress
{
    /**
	 * Get the client's IP address.
	 *
	 * @return string The client's IP address or 'PROXY' if not found.
	*/
	public static function get(): string 
    {
		$ipHeaders = [
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR',
		];

		foreach ($ipHeaders as $header) {
			if (isset($_SERVER[$header]) && filter_var($_SERVER[$header], FILTER_VALIDATE_IP)) {
				return $_SERVER[$header];
			}
		}

		return 'PROXY';
	}

	/**
	 * Check if an IP address is valid.
	 *
	 * @param string $address The IP address to validate.
	 * @param int    $version   The IP version to validate (4 for IPv4, 6 for IPv6).
	 *
	 * @return bool True if the IP address is valid, false otherwise.
	 */
	public static function isValid(?string $address = null, int $version = 0): bool 
	{
        if($address === null){
            $address = self::get();
        }

		return match ($version) {
			4 => filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false,
			6 => filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false,
			default => filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6) !== false
		};
	}

	/**
	 * Convert an IP address to its numeric representation (IPv4 or IPv6).
	 *
	 * @param string $address The IP address to convert.
	 *
	 * @return int|string Numeric IP address or empty string on error.
	 */
	public static function toNumeric(?string $address = null): mixed
	{
        if($address === null){
            $address = self::get();
        }

		if (self::isValid($address, 4)) {
			return ip2long($address);
		} 
        
        if (self::isValid($address, 6)) {
			return inet_pton($address);
		}

		return '';
	}

	/**
	 * Convert a numeric IP address to its string representation (IPv4 or IPv6).
	 *
	 * @param int|string $numeric The numeric IP address to convert.
	 *
	 * @return string IP address in string format or empty string on error.
	 */
	public static function toAddress(int|string $numeric = null): string
	{
		$ip = ''; 
        if($numeric === null){
            $numeric = self::toNumeric();
        }

		// Check if it's binary (IPv6) or numeric (IPv4).
		if (is_numeric($numeric)) {
			// Convert numeric (IPv4) to human-readable IPv4 address.
			$ip = long2ip($numeric);
		}elseif (is_string($numeric)) {
			// Convert binary (IPv6) to human-readable IPv6 address.
			$ip = inet_ntop($numeric);
		}

		return $ip !== false ? $ip : '';
	}
}
