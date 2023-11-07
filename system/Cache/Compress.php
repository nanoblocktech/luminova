<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Cache;
use Luminova\Http\Header;
class Compress {
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
    private array $headers;

    /** 
	*  Gzip compression status
	* @var bool $gzip
	*/
    private bool $gzip; 

    /** 
     * Ignore user abort
     * @var bool $ignoreUserAbort
     */
	private bool $ignoreUserAbort = true;

    /** 
     * Ignore html code block tag <code></code>
     * @var bool $ignoreCodeblock
     */
    private bool $ignoreCodeblock = false;

    /** 
	*  Compressed content
	* @var mixed $compressedContent
	*/
    private mixed $compressedContent = '';

    /** 
	*  Minified content
	* @var mixed $minifiedContent
	*/
    private mixed $minifiedContent = '';

	/** 
	*  Maximin execution time 
	* @var int $scriptExecutionLimit
	*/
    private int $scriptExecutionLimit = 60;

    /** 
	* Compression level  
	* @var int $compressionLevel
	*/
    private int $compressionLevel = 6;

    /**
     * Regular expression patterns for content stripping
     * @var array $patterns
    */
    private const PATTERNS = [
        "find" => [
            '/\>[^\S ]+/s',          // Strip whitespace after HTML tags
            '/[^\S ]+\</s',          // Strip whitespace before HTML tags
            '/\s+/', //'/(\s)+/s',   // Strip excessive whitespace
            '/<!--(.*)-->/Uis',      // Strip HTML comments
            '/[[:blank:]]+/'         // Strip blank spaces
        ],
        "replace" => [
            '>',
            '<',
            ' ',
            '',
            ' '
        ],
        "line" =>[
            "\n",
            "\r",
            "\t"
        ]
    ];
    
 
    /**
     * Class constructor.
     * Initializes default settings for the response headers and cache control.
     */
    public function __construct() {
        $this->headers = Header::getSystemHeaders();
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
     * sets ignore user abort
     *
     * @param int $limit Set script maximin execution limit
     * @return Compress Returns the class instance for method chaining.
     */
	public function setExecutionLimit(int $limit): Compress 
    {
		$this->scriptExecutionLimit = $limit;
		return $this;
	}

    /**
     * sets compression level
     *
     * @param int $level Level
     * @return Compress $this
     */
	public function setCompressionLevel(int $level): Compress 
    {
		$this->compressionLevel = min(9, $level);
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
     * Get compressed content
     * @return mixed compressed content $this->compressedContent
     */
    public function getCompressed(): mixed {
		return $this->compressedContent;
    }

    /**
     * Get minified content
     * @return string minified content $this->minifiedContent
     */
    public function getMinified(): string {
		return $this->minifiedContent;
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
        $this->minifiedContent = $this->ignoreCodeblock ? self::minifyIgnoreCodeblock($content) : self::minify($content);
        $compressedContent = '';

        $shouldCompress = false;
        if ($this->gzip && function_exists('gzencode') && !empty($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
            $shouldCompress = true;
        }
    
        if ($shouldCompress) {
            $this->headers['Content-Encoding'] = 'gzip';
            // Compress the content and store it in a variable
            $compressedContent = gzencode($this->minifiedContent, $this->compressionLevel);
            //$compressedContent = gzencode($this->minifiedContent, $this->compressionLevel, 9, FORCE_GZIP);
        } else {
            // Store the uncompressed content in a property
            $compressedContent = $this->minifiedContent;
        }
        
        $this->headers['Content-Length'] = strlen($compressedContent);
        $this->headers['Content-Type'] = $contentType . ' ' . $this->headers['Content-Type'];
        foreach ($this->headers as $header => $value) {
            header("$header: $value");
        }
        return $compressedContent;
    }

    /**
     * Sends the response with the specified content type and status code.
     *
     * @param string|array|object $body The content body to be sent in the response.
     * @param int $statusCode The HTTP status code to be sent in the response.
     * @param string $contentType The expected content type for the response.
    */
    private function withViewContent(mixed $body, int $statusCode, string $contentType): void {
        set_time_limit($this->scriptExecutionLimit);
        ignore_user_abort($this->ignoreUserAbort);
        
        // Start output buffering and use ob_gzhandler for gzip compression
        ob_start('ob_gzhandler');
    
        // Compress the content and store it in a variable
        //$this->compressedContent = $this->compress($body, $contentType);
    
        if ($statusCode) {
            http_response_code($statusCode);
        }
        // ob_end_clean();
        // Echo the stored compressed content
        echo $this->compress($body, $contentType);
    
        // If there is any content in the output buffer, end and flush it
        if (ob_get_length() > 0) {
            ob_end_flush();
        }
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
     * Minify the given content by removing unwanted tags and whitespace.
     *
     * @param string $content The content to minify.
     * @return string minified content.
     */
    public static function minify(string $content): string {
        //$patterns = self::PATTERNS;
        //$patterns["find"][] = '/\s+/'; 
        //$patterns["replace"][] = ' ';

        $content = str_replace(self::PATTERNS["line"], '', $content);
        $content = preg_replace(self::PATTERNS["find"], self::PATTERNS["replace"], $content);
        return trim($content);
    }

    /**
     * Minify the given content by removing unwanted tags and whitespace.
     * Ignore html <code></code> block
     * @param string $content The content to minify.
     * @return string minified content.
     */
    function minifyIgnoreCodeblock(string $content): string {
        $ignoredCodeBlocks = [];
        $codeBlockPattern = '/<code[^>]*>[\s\S]*?<\/code>/i';
        //$commentPattern = '/<!--\[File was cached on - (.*?) Using: (.*?)\]-->/';
        $content = preg_replace_callback($codeBlockPattern, function ($matches) use (&$ignoredCodeBlocks) {
            $ignoredCodeBlocks[] = $matches[0];
            return '###IGNORED_CODE_BLOCK###';
        }, $content);
    
        // Perform minification
        //$content = preg_replace(self::PATTERNS["find"], self::PATTERNS["replace"], $content);
        $content = self::minify($content);
    
        // After processing, restore the code blocks back to its original state
        $count = 1; // Make sure only one code block is processed
        foreach ($ignoredCodeBlocks as $codeBlock) {
            $content = str_replace('###IGNORED_CODE_BLOCK###', $codeBlock, $content, $count);
        }
    
        return $content;
    }
    
}