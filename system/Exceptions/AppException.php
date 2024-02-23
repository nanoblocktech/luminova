<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Exceptions;
use \Exception;
use Luminova\Base\BaseConfig;
use Luminova\Logger\Logger;

class AppException extends Exception
{
    /**
     * Constructor for AppException.
     *
     * @param string     $message   The exception message (default: 'Database error').
     * @param int        $code      The exception code (default: 500).
     * @param Exception $previous  The previous exception if applicable (default: null).
     */
    public function __construct(string $message = 'Database error', int $code = 500, Exception $previous = null)
    {
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];
        $message .= " Time: " . date('Y-m-d H:i:s');
        $message .= isset($caller['file']) ? " file: " .  BaseConfig::filterPath($caller['file']) : '';
        $message .= isset($caller['line']) ? " on line: " . $caller['line'] : '';
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get a string representation of the exception.
     *
     * @return string A formatted error message.
     */
    public function __toString(): string
    {
        return "Error {$this->code}: {$this->message}";
    }

    /**
     * Handle the exception based on the production environment.
     * 
     * @throws $this Exception
     */
    public function handle(): void
    {
        if (BaseConfig::isProduction()) {
            $this->logException();
        } else {
            throw $this;
        }
    }

    /**
     * Logs an exception
     *
     * 
     * @return void
     */
    public function logException(): void
    {
        $message = "Exception: {$this->getMessage()}";

        (new Logger())->log('exception', $message);
    }

    /**
     * Create and handle a Exception.
     *
     * @param string $message he exception message.
     * @param bool|null $production Indicates whether it's a production environment (default: false).
     * @param int $code The exception code (default: 500).
     * 
     * @return void 
     * @throws $this Exception
     */
    public static function throwException(string $message, ?bool $production = null, int $code = 500): void
    {
        $throw = new self($message, $code);
        $throw->handle();
    }
    
     /**
     * Creates a syntax-highlighted version of a PHP file.
     *
     * @return bool|string
     */
    public static function highlightFile(string $file, int $lineNumber, int $lines = 15)
    {
        if ($file === '' || ! is_readable($file)) {
            return false;
        }

        // Set our highlight colors:
       self::highlightColor();

        try {
            $source = file_get_contents($file);
        } catch (\Throwable $e) {
            return false;
        }

        $source = str_replace(["\r\n", "\r"], "\n", $source);
        $source = explode("\n", highlight_string($source, true));

        if (PHP_VERSION_ID < 80300) {
            $source = str_replace('<br />', "\n", $source[1]);
            $source = explode("\n", str_replace("\r\n", "\n", $source));
        } else {
            // We have to remove these tags since we're preparing the result
            // ourselves and these tags are added manually at the end.
            $source = str_replace(['<pre><code>', '</code></pre>'], '', $source);
        }

        // Get just the part to show
        $start = max($lineNumber - (int) round($lines / 2), 0);

        // Get just the lines we need to display, while keeping line numbers...
        $source = array_splice($source, $start, $lines, true);

        // Used to format the line number in the source
        $format = '% ' . strlen((string) ($start + $lines)) . 'd';

        $out = '';
        // Because the highlighting may have an uneven number
        // of open and close span tags on one line, we need
        // to ensure we can close them all to get the lines
        // showing correctly.
        $spans = 0;

        foreach ($source as $n => $row) {
            $spans += substr_count($row, '<span') - substr_count($row, '</span');
            $row = str_replace(["\r", "\n"], ['', ''], $row);

            if (($n + $start + 1) === $lineNumber) {
                preg_match_all('#<[^>]+>#', $row, $tags);

                $out .= sprintf(
                    "<span class='line highlight'><span class='number'>{$format}</span> %s\n</span>%s",
                    $n + $start + 1,
                    strip_tags($row),
                    implode('', $tags[0])
                );
            } else {
                $out .= sprintf('<span class="line"><span class="number">' . $format . '</span> %s', $n + $start + 1, $row) . "\n";
                // We're closing only one span tag we added manually line before,
                // so we have to increment $spans count to close this tag later.
                $spans++;
            }
        }

        if ($spans > 0) {
            $out .= str_repeat('</span>', $spans);
        }

        return '<pre><code>' . $out . '</code></pre>';
    }

    private static function highlightColor()
    {
        if (function_exists('ini_set')) {
            ini_set('highlight.comment', '#767a7e; font-style: italic');
            ini_set('highlight.default', '#c7c7c7');
            ini_set('highlight.html', '#06B');
            ini_set('highlight.keyword', '#f1ce61;');
            ini_set('highlight.string', '#869d6a');
        }
    }

}