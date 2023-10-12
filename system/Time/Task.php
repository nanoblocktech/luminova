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

use \DateTime;
use \DateTimeZone;
use \DateInterval;

class Task
{
    public function __construct() {
    }

    public static function createDate(string $timeDate, string $timezone = 'GMT')
    {
        return  DateTime::createFromFormat('Y-m-d H:iA', $timeDate, new DateTimeZone($timezone));
    }

    /**
     * Function responsible for corn-job deal opening.
     *
     * @param string $startDate 2023-09-25
     * @param string $startTime 17:00PM
     * @param string $timezone
     *
     * @return bool
     */
    public static function isActive(string $startDate, string $startTime, string $timezone = 'GMT'): bool
    {
        $startTime = self::createDate(self::toDateTime($startDate . ' ' . $startTime),  $timezone);
        $nowTime = new DateTime('NOW', new DateTimeZone($timezone));
        return $nowTime >= $startTime;
    }

     /**
     * Check between opening and closing time has passed
     * 
     * @param string $open 2023-09-25 08:00AM
     * @param string $close 2023-09-25 17:00PM
     * @param string $timezone
     *
     * @return bool
     */
    public static function isOpen(string $open, string $close, string $timezone = 'GMT'): bool
    {
        $openTime = self::createDate($open,  $timezone);
        $closeTime = self::createDate($close,  $timezone);
        $nowTime = new DateTime('NOW', new DateTimeZone($timezone));
        if ($closeTime <= $openTime) {
            $closeTime->add(new DateInterval('P1D'));
        }

        return ($nowTime > $openTime && $nowTime >= $closeTime);
    }
    /**
     * Function to check if a given expiry date and time has passed.
     *
     * @param string $expiryDateTime
     * @param string $timezone
     *
     * @return bool
     */
    public static function expired(string $expiryDateTime, string $timezone = 'UTC'): bool
    {
        $timezone = new DateTimeZone($timezone);
        $currentDatetime = new DateTime('NOW', $timezone);
        $expiryDatetime = new DateTime($expiryDateTime, $timezone);
        return ($expiryDatetime < $currentDatetime);
    }
    /**
     * Function to check if a campaign has expired.
     *
     * @param string $open
     * @param string $timezone
     *
     * @return bool
     */
    public static function campaignExpired(string $open, string $timezone = 'GMT'): bool
    {
        $nowTime = new DateTime('NOW', new DateTimeZone($timezone));
        $startTime = self::createDate($open,  $timezone);
        $openTime = $startTime->modify('-2 days');
        return ($nowTime >= $openTime);
    }

    /**
     * Function to check if an event has expired.
     *
     * @param string $start
     * @param string $timezone
     * @param bool $format
     *
     * @return bool
     */
    public static function hasExpired(string $start, string $timezone = 'GMT',  bool $format = false): bool
    {
        $tz = new DateTimeZone($timezone);
        if ($format) {
            [$date, $time] = explode(' ', $start);
            $startTime = new DateTime(self::format($date, $time), $tz);
        } else {
            $startTime = self::createDate($start,  $timezone);
        }
        $nowTime = new DateTime('NOW', $tz);
        return $nowTime >= $startTime;
    }

    /**
     * Function to format date and time.
     *
     * @param string $date
     * @param string $time
     *
     * @return string|false
     */
    public static function format(string $date, string $time): mixed
    {
        $time = date('h:i:sA', strtotime($time));
        $setDate = $date . ' ' . $time;
        $build = date_create($setDate);
        return $build ? date_format($build, 'M d, Y H:i:s') : $build;
    }

    /**
     * Function to convert a string to a formatted date and time.
     *
     * @param string $string
     *
     * @return string
     */
    public static function toDateTime(string $string): string
    {
        return date('Y-m-d H:iA', strtotime($string));
    }
}