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

use \Luminova\Functions\TorDetector;

class IPAddress
{
   /**
    * @var array $cf
   */
   private static string $cf = 'HTTP_CF_CONNECTING_IP';

   /**
    * @var array $ipHeaders
   */
   private static array $ipHeaders = [
      'HTTP_CLIENT_IP',
      'HTTP_X_FORWARDED_FOR',
      'HTTP_X_FORWARDED',
      'HTTP_X_CLUSTER_CLIENT_IP',
      'HTTP_FORWARDED_FOR',
      'HTTP_FORWARDED',
      'REMOTE_ADDR',
   ];

    /**
	 * Get the client's IP address.
	 *
	 * @return string The client's IP address or '0.0.0.0' if not found.
	*/
  public static function get(): string 
   {

      if (isset($_SERVER[static::$cf])) {
         $_SERVER['REMOTE_ADDR'] = $_SERVER[static::$cf];
         $_SERVER['HTTP_CLIENT_IP'] = $_SERVER[static::$cf];
         return $_SERVER[static::$cf];
      }

      foreach (static::$ipHeaders as $header) {
         $ips = isset($_SERVER[$header]) ? $_SERVER[$header] : getenv($header);
         if ($ips !== false) {
            $list = array_map('trim', explode(',', $ips));
            foreach ($list as $ip) {
                  if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                     return $ip;
                  }
            }
         }
      }
      
      return '0.0.0.0'; 
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
  public static function toNumeric(?string $address = null): int|string
  {
      if($address === null){
         $address = self::get();
      }

      $ip = false;

      if (self::isValid($address, 4)) {
         $ip = ip2long($address);
      }elseif (self::isValid($address, 6)) {
         $ip = inet_pton($address);
      }

      if( $ip === false){
         return '';
      }

      return $ip;
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

   /**
     * Checks if the given IP address is a Tor exit node
     * 
     * @param string|null $ip
     * 
     * @return bool 
    */
   public static function isTor(string|null $ip = null): bool 
   {
      if($ip === null){
         $ip = self::get();
      }

      return TorDetector::isTorExitNode($ip);
   }
}
