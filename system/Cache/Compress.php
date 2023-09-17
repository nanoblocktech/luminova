<?php
/**
 * Compress - A simple php class to compress output buffer
 * @author      Peter Chigozie(NG) peterujah
 * @copyright   Copyright (c), 2021 Peter(NG) peterujah
 * @license     MIT public license
 */
namespace Luminova\Cache;
 class Compress{
    // Constants for content types
    /**
	* holds json content type
	* @var string JSON
	*/
	public const JSON = "application/json;";
	 
	/**
	* holds text content type
	* @var string TEXT
	*/
	public const TEXT = "text/plain;";
	 
	/**
	* holds html content type
	* @var string HTML
	*/
	public const HTML = "text/html;";

    /** 
	* Array to hold response headers
	* @var array $headers
	*/
    private $headers;

    /** 
	*  Gzip compression status
	* @var bool $gzip
	*/
    private $gzip; 

	/** 
	*  ignore User Abort
	* @var bool $ignoreUserAbort
	*/
	private $ignoreUserAbort = true;

    private $ignoreCodeblock = false;

    private $compressedContent;

	/** 
	* holds html expiry time offset 7 days
	* @var string $cacheExpiry
	*/
	private $cacheExpiry = 60 * 60 * 24 * 7;

	/** 
	* holds path to save php to html cached files
	* @var string $cacheDir
	*/
	private $cacheDir = __DIR__ . "/../ob_optimizer_caches";


    // Regular expression patterns for content stripping
    private const OPTIONS = array(
        "find" => array(
            '/\>[^\S ]+/s',          // Strip whitespace after HTML tags
            '/[^\S ]+\</s',          // Strip whitespace before HTML tags
            '/(\s)+/s',              // Strip excessive whitespace
            '/<!--(.*)-->/Uis',      // Strip HTML comments
            '/[[:blank:]]+/'         // Strip blank spaces
        ),
        "replace" => array(
            '>',
            '<',
            '\\1',
            '',
            ' '
        ),
        "line" => array(
            //'/[\n\r\t]+/'
            "\n",
            "\r",
            "\t"
        )
    );
    
 
    /**
     * Class constructor.
     * Initializes default settings for the response headers and cache control.
     */
    public function __construct() {
        $this->headers = array(
            'Content-Encoding' => '',
            'Content-Type' => 'charset=utf-8',
            'Cache-Control' => 'no-store',
            'Expires' => gmdate("D, d M Y H:i:s", time() + 60 * 60 * 30) . ' GMT',
            'Content-Length' => 0,
            'Content-Language' => 'en',
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'deny',
            'X-XSS-Protection' => '1; mode=block',
            'X-Powered-By' => 'Luminova',
            'Vary' => 'Accept-Encoding',
            'Connection' => 'close',
        );
        $this->gzip = true;
    }
    /**
     * Enable or disable Gzip compression.
     *
     * @param bool $gzip Enable Gzip compression (true) or disable it (false).
     * @return Compress Returns the class instance for method chaining.
     */
    public function useGzip(bool $gzip): Compress {
        $this->gzip = $gzip;
        return $this;
    }

    /**
     * Set the expiration offset for the Cache-Control header.
     *
     * @param int $offset Cache expiration offset in seconds.
     * @return Compress Returns the class instance for method chaining.
     */
    public function setExpires(int $offset): Compress {
        $this->headers['Expires'] = gmdate("D, d M Y H:i:s", time() + $offset) . ' GMT';
        return $this;
    }

	/**
     * Set the expiration offset for the Cache-Control header.
     *
     * @param int $expire Cache expiration offset in seconds.
     * @return Compress Returns the class instance for method chaining.
     */
    public function setHtmlExpires(int $expire): Compress {
		$this->cacheExpiry = $expire;
        return $this;
    }

    /**
     * Set the Cache-Control header.
     *
     * @param string $cacheControl Cache-Control header value.
     * @return Compress Returns the class instance for method chaining.
     */
    public function setCacheControl(string $cacheControl): Compress 
    {
        $this->headers['Cache-Control'] = $cacheControl;
        return $this;
    }

	/**
     * sets ignore user abort
     *
     * @param bool $ignore Cache-Control header value.
     * @return Compress Returns the class instance for method chaining.
     */
	public function setIgnoreUserAbort(bool $ignore): Compress 
    {
		$this->ignoreUserAbort = $ignore;
		return $this;
	}

    /**
     * sets ignore user code block
     *
     * @param bool $ignore
     * @return Compress Returns the class instance for method chaining.
     */
	public function setIgnoreCodeblock(bool $ignore): Compress 
    {
		$this->ignoreCodeblock = $ignore;
		return $this;
	}

	/**
     * sets file path
     *
     * @param string|dir|path $cacheDir path to save cache
     * @return Compress Returns the class instance for method chaining.
     */
	public function setOptimizerCachePath(string $cacheDir): Compress 
    {
        $this->cacheDir = $cacheDir;
		return $this;
    }

    public function getCompressed(): mixed {
		return $this->compressedContent;
    }

    /**
     * Compresses the buffer content and adds necessary headers to optimize the response.
     *
     * @param string|array|object $data The content to compress (can be an array or object for JSON response).
     * @param string $contentType The expected content type for the response.
     * @return string The compressed content for output.
     */
    public function compress(mixed $data, string $contentType): string {
        $content = ($contentType === self::JSON) ? json_encode($data, true) : $data;
        $minifiedContent = $this->ignoreCodeblock ? self::minifyIgnoreCodeblock($content) : self::minify($content);
        if ($this->gzip && !empty($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
            $this->headers['Content-Encoding'] = 'gzip';
            $minifiedContent = gzencode($minifiedContent, 9);
        }
        $this->headers['Content-Length'] = strlen($minifiedContent);
        $this->headers['Content-Type'] = $contentType . ' ' . $this->headers['Content-Type'];

        foreach ($this->headers as $header => $value) {
            header("$header: $value");
        }
        $this->compressedContent = $minifiedContent;
        return $minifiedContent;
    }

    /**
     * Sends the response with the specified content type and status code.
     *
     * @param string|array|object $body The content body to be sent in the response.
     * @param int $statusCode The HTTP status code to be sent in the response.
     * @param string $contentType The expected content type for the response.
     */
    private function withViewContent(mixed $body, int $statusCode, string $contentType): void 
    {
        set_time_limit(0);
        ignore_user_abort($this->ignoreUserAbort);
        ob_end_clean();
        echo $this->compress($body, $contentType);
        if ($statusCode) {
            http_response_code($statusCode);
        }
        if (ob_get_length() > 0) {
            ob_end_flush();
        }
    }

    /**
     * Minify and save output as html, and serve html on next request
     *
     * @param string|array|object $body The content body to be sent in the response.
     */
	public function withOptimizer(mixed $body): void 
    {
		$optimizer = new Luminova\Cache\Optimizer($this->cacheExpiry, $this->cacheDir);
		$cacheFile = $optimizer->getCacheLocation();
	
		if ($optimizer->isCacheValid($cacheFile)) {
			$optimizer->loadFromCache($cacheFile);
			return;
		}
	
        $minifiedContent = $this->ignoreCodeblock ? self::minifyIgnoreCodeblock($body) : self::minify($body);
		set_time_limit(0);
		ignore_user_abort($this->ignoreUserAbort);
		echo $optimizer->saveToCache($cacheFile, $minifiedContent);
		ob_end_flush();
	}

    /**
     * Send the output in HTML format.
     *
     * @param string|array|object $body The content body to be sent in the response.
     */
    public function html(mixed $body): void 
    {
        $this->withViewContent($body, 200, self::HTML);
    }

    /**
     * Send the output in text format.
     *
     * @param string|array|object $body The content body to be sent in the response.
     */
    public function text(mixed $body): void 
    {
        $this->withViewContent($body, 200, self::TEXT);
    }

    /**
     * Send the output in JSON format.
     *
     * @param string|array|object $body The content body to be sent in the response.
     */
    public function json(mixed $body): void 
    {
        $this->withViewContent($body, 200, self::JSON);
    }

    /**
     * Send the output based on the specified content type.
     *
     * @param string|array|object $body The content body to be sent in the response.
     * @param string $contentType The expected content type for the response.
     */
    public function run(mixed $body, string $contentType = self::HTML): void 
    {
        $this->withViewContent($body, 200, $contentType);
    }

    /**
     * End output buffering and send the response.
     *
     * @param string $contentType The expected content type for the response.
     */
    public function end(string $contentType = self::HTML): void 
    {
        $this->withViewContent(ob_get_contents(), 200, $contentType);
    }

    /**
     * Start output buffering and minify the content by removing unwanted tags and whitespace.
    */
    public function startMinify(): void 
    {
        if($this->ignoreCodeblock){
            ob_start(['self', 'minifyIgnoreCodeblock']);
        }else{
            ob_start(['self', 'minify']);
        }
    }
    
    /**
     * Minify the given buffer content by removing unwanted tags and whitespace.
     *
     * @param string $buffer The content output buffer to minify.
     * @return string The minified content.
     */
    public static function minify(string $buffer): string 
    {
        $minified_buffer = preg_replace(
            self::OPTIONS["find"],
            self::OPTIONS["replace"],
            str_replace(self::OPTIONS["line"], '', $buffer)
        );
        return trim(preg_replace('/\s+/', ' ', $minified_buffer));
    }

    /**
     * @deprecated This method is deprecated. Use the start() method instead.
     * Call ob_start(), ob_start(['\Peterujah\NanoBlock\Compress', 'minify']); 
     * or ob_start(['\Peterujah\NanoBlock\Compress', 'minifyIgnoreCodeblock']);
     * Start output buffering and minify the content by removing unwanted tags and whitespace.
     */
    public static function start(bool $minify = false): void 
    {
        ob_start($minify ? ['self', 'minify'] : null);
    }
    
    /**
     * Minify the given buffer content by removing unwanted tags and whitespace.
     * But ignore html <pre><code> block
     * @param string $buffer The content output buffer to minify.
     * @return string The minified content.
     */
    public static function minifyIgnoreCodeblock(string $buffer): string {
        $ignored_blocks = [];
        $buffer = preg_replace_callback(
            '/<pre><code>([\s\S]*?)<\/code><\/pre>/i',
            function ($matches) use (&$ignored_blocks) {
                $ignored_blocks[] = $matches[1];
                return '<!--OB_COMPRESS_IGNORED_BLOCK-->';
            },
            $buffer
        );
    

        $minified_buffer = preg_replace_callback(
            '/<!--OB_COMPRESS_IGNORED_BLOCK-->/',
            function () use (&$ignored_blocks) {
                $block = array_shift($ignored_blocks);
                $replacement = preg_replace('/class="language-(.*?)"/i', 'class="$1"', $block);
                return '<pre><code ' . $replacement . '>' . $block . '</code></pre>';
            },
            preg_replace(
                self::OPTIONS["find"],
                self::OPTIONS["replace"],
                $buffer
            )
        );
    
        return $minified_buffer;
    }
    
}