<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Time;

use \DateTimeImmutable;
use \DateTimeZone;
use \Locale;
use \DateTime;

class Time extends DateTimeImmutable
{
    /**
     * @var DateTimeZone
     */
    protected ?DateTimeZone $timezone = null;

    /**
     * @var ?string
     */
    protected ?string $locale;

    /**
     *
     * @var string $socialPattern relative time keywords pattern
     */
    protected static string $socialPattern = '/this|next|last|tomorrow|yesterday|midnight|today|[+-]|first|last|ago/i';

    /**
     * Time constructor.
     *
     * @param ?string $time
     * @param DateTimeZone|string|null $timezone
     * @param ?string $local 
     *
     * @throws Exception
     */
    public function __construct(?string $time = null, DateTimeZone|string|null $timezone = null, ?string $locale = null)
    {
        $this->locale = $locale;

        if($this->locale === null && class_exists('\Locale')){
            $this->locale =  Locale::getDefault();
        }

        $this->locale ??= '';
        $time ??= '';
        $timezone ??= date_default_timezone_get();

        $this->timezone = $timezone instanceof DateTimeZone ? $timezone : new DateTimeZone($timezone);

        if ($time !== '' && static::hasSocialKeywords($time)) {
            $instance = new DateTime('now', $this->timezone);
            $instance->modify($time);
            $time = $instance->format('Y-m-d H:i:s');
        }

        parent::__construct($time, $this->timezone);
    }

    /**
     * Returns current Time instance with the timezone set.
     *
     * @param DateTimeZone|string|null $timezone
     * @param ?string $local 
     *
     * @return self
     *
     * @throws Exception
     */
    public static function now(DateTimeZone|string|null $timezone = null, ?string $locale = null): self
    {
        return new self(null, $timezone, $locale);
    }

     /**
     * Returns a new Time instance while parsing a datetime string.
     *
     * Example:
     *  $time = Time::parse('first day of December 2008');
     *
     * @param string $datetime 
     * @param DateTimeZone|string|null $timezone
     * @param ?string $local 
     *
     * @return self
     *
     * @throws Exception
     */
    public static function parse(string $datetime, DateTimeZone|string|null $timezone = null, ?string $locale = null): self
    {
        return new self($datetime, $timezone, $locale);
    }

    /**
     * Return a new time with the time set to midnight.
     *
     * @param DateTimeZone|string|null $timezone
     * @param ?string $local 
     *
     * @return self
     *
     * @throws Exception
     */
    public static function today(DateTimeZone|string|null $timezone = null, ?string $locale = null): self
    {
        return new self(date('Y-m-d 00:00:00'), $timezone, $locale);
    }

    /**
     * Returns an instance set to midnight yesterday morning.
     *
     * @param DateTimeZone|string|null $timezone
     * @param ?string $local 
     *
     * @return self
     *
     * @throws Exception
     */
    public static function yesterday(DateTimeZone|string|null $timezone = null, ?string $locale = null): self
    {
        return new self(date('Y-m-d 00:00:00', strtotime('-1 day')), $timezone, $locale);
    }

    /**
     * Returns an instance set to midnight tomorrow morning.
     *
     * @param DateTimeZone|string|null $timezone
     * @param ?string $local 
     *
     * @return self
     *
     * @throws Exception
     */
    public static function tomorrow(DateTimeZone|string|null $timezone = null, ?string $locale = null)
    {
        return new self(date('Y-m-d 00:00:00', strtotime('+1 day')), $timezone, $locale);
    }

     /**
     * Used to check time string to determine if it has relative time keywords
     * 
     * @param string $time 
     */
    protected static function hasSocialKeywords(string $time): bool
    {
        if (preg_match('/\d{4}-\d{1,2}-\d{1,2}/', $time) !== 1) {
            return preg_match(static::$socialPattern, $time) > 0;
        }

        return false;
    }
}