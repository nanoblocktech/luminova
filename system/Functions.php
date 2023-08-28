<?php 
/**
 * This file is part of Luminova framework.
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Luminova;
class Functions {
  public function __construct(){
      
  }

  public static function toKebabCase($string) {
    $string = str_replace([' ', ':', '.', ',','-'], '', $string);
    $kebabCase = preg_replace('/([a-z0-9])([A-Z])/', '$1-$2', $string);
    return strtolower($kebabCase);
  }

  public static function toName($string, $type = "name", $symbol = ""){
		return preg_replace("/[^a-zA-Z0-9-_. ]+/", $symbol, $string);
	}

  public static function isNameBanned($nameToCheck, $bannedNames) {
      foreach ($bannedNames as $banned) {
          if (stripos($nameToCheck, $banned) !== false) {
              return true;
          }
      }
      return false;
  }

  public static function sanitizeText($text) {
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


  public static function filterText($text, $all = true) {
    $text = preg_replace('/<([^>]+)>(.*?)<\/\1>|<([^>]+) \/>/', '⚠️', $text); 
    $text = ($all ? preg_replace('/<[^>]+>/', '', $text) : preg_replace('/<(?!\/?b(?=>|\s.*>))[^>]+>/', '', $text));
    $text = htmlentities($text);
    return $text;
  }
}