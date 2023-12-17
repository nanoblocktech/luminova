<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

namespace Luminova\Http;
use Luminova\Http\Header;

class Request
{
    /**
     * @var array $get Http GET request method
     */
    private array $get;
    
    /**
     * @var array $post Http POST request method
     */
    private array $post;
    
    /**
     * @var array $put Http PUT request method
     */
    private array $put;
    
    /**
     * @var array $delete Http DELETE request method
     */
    private array $delete;
    
    /**
     * @var array $options Http OPTIONS request method
     */
    private array $options;
    
    /**
     * @var array $patch Http PATCH request method
     */
    private array $patch;
    
    /**
     * @var array $head Http HEAD request method
     */
    private array $head;
    
    /**
     * @var array $connect Http CONNECT request method
     */
    private array $connect;
    
    /**
     * @var array $trace Http TRACE request method
     */
    private array $trace;
    
    /**
     * @var array $propfind Http PROPFIND request method
     */
    private array $propfind;
    
    /**
     * @var array $mkcol Http MKCOL request method
     */
    private array $mkcol;
    
    /**
     * @var array $copy Http COPY request method
     */
    private array $copy;
    
    /**
     * @var array $move Http MOVE request method
     */
    private array $move;
    
    /**
     * @var array $lock Http LOCK request method
     */
    private array $lock;
    
    /**
     * @var array $unlock Http UNLOCK request method
     */
    private array $unlock;
    
    /**
     * @var array $body Http request body
     */
    private array $body;


    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->put = $this->parseRequestBody('PUT');
        $this->delete = $this->parseRequestBody('DELETE');
        $this->options = $this->parseRequestBody('OPTIONS');
        $this->patch = $this->parseRequestBody('PATCH');
        $this->head = $this->parseRequestBody('HEAD');
        $this->connect = $this->parseRequestBody('CONNECT');
        $this->trace = $this->parseRequestBody('TRACE');
        $this->propfind = $this->parseRequestBody('PROPFIND');
        $this->mkcol = $this->parseRequestBody('MKCOL');
        $this->copy = $this->parseRequestBody('COPY');
        $this->move = $this->parseRequestBody('MOVE');
        $this->lock = $this->parseRequestBody('LOCK');
        $this->unlock = $this->parseRequestBody('UNLOCK');
        $this->body = $this->parseRequestBody();
    }

    /**
     * Get a value from the GET request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->get[$key] ?? $default;
    }

    /**
     * Get a value from the POST request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getPost(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }

    /**
     * Get a value from the PUT request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getPut(string $key, mixed $default = null): mixed
    {
        return $this->put[$key] ?? $default;
    }

    /**
     * Get a value from the DELETE request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getDelete(string $key, mixed $default = null): mixed
    {
        return $this->delete[$key] ?? $default;
    }

    /**
     * Get a value from the OPTIONS request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getOption(string $key, mixed $default = null): mixed
    {
        return $this->options[$key] ?? $default;
    }

    /**
     * Get a value from the PATCH request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getPatch(string $key, mixed $default = null): mixed
    {
        return $this->patch[$key] ?? $default;
    }

    /**
     * Get a value from the HEAD request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getHead(string $key, mixed $default = null): mixed
    {
        return $this->head[$key] ?? $default;
    }

    /**
     * Get a value from the CONNECT request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getConnect(string $key, mixed $default = null): mixed
    {
        return $this->connect[$key] ?? $default;
    }

    /**
     * Get a value from the TRACE request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getTrace(string $key, mixed $default = null): mixed
    {
        return $this->trace[$key] ?? $default;
    }

    /**
     * Get a value from the PROPFIND request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getPropfind(string $key, mixed $default = null): mixed
    {
        return $this->propfind[$key] ?? $default;
    }

    /**
     * Get a value from the MKCOL request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getMkcol(string $key, mixed $default = null): mixed
    {
        return $this->mkcol[$key] ?? $default;
    }

    /**
     * Get a value from the COPY request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getCopy(string $key, mixed $default = null): mixed
    {
        return $this->copy[$key] ?? $default;
    }

    /**
     * Get a value from the MOVE request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getMove(string $key, mixed $default = null): mixed
    {
        return $this->move[$key] ?? $default;
    }

    /**
     * Get a value from the LOCK request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getLock(string $key,mixed  $default = null): mixed
    {
        return $this->lock[$key] ?? $default;
    }

    /**
     * Get a value from the UNLOCK request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getUnlock(string $key, mixed $default = null): mixed
    {
        return $this->unlock[$key] ?? $default;
    }

    /**
     * Get the request body as an array.
     *
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * Get the request body as an object.
     *
     * @return object
     */
    public function getBodyAsObject(): object
    {
        return (object) $this->body;
    }

    /**
     * Get the uploaded file information.
     * @param string $name file name
     * @return object|null
    */
    public function getFile(string $name): ?object
    {
        if (isset($_FILES[$name])) {
            return $this->parseFiles($_FILES[$name]);
        }
        return null;
    }

    /**
     * Get the uploaded files information.
     *
     * @return object|null
    */
    public function getFiles(): ?object
    {
        $files = [];
        foreach ($_FILES as $index => $fileInfo) {
            $files[] = $this->parseFiles($fileInfo, $index);
        }
        if( $files  == []){
            return null;
        }
        return (object) $files;
    }

    /**
     * Get the uploaded files information.
     * @param array $fileInfo file array information
     * @param int $index file index
     * @return object
    */
    private function parseFiles(array $fileInfo, int $index = 0): object{
        if(empty($fileInfo)){
            return (object)[];
        }

        $extension = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);
        $mime = mime_content_type($fileInfo['tmp_name']);
        if($extension === ''){
            [$format, $extension] = explode('/', $mime);
            $fileInfo['name'] = uniqid('file_') . '.' . $extension;
        }
        
        return (object)[
            'index' => $index,
            'name' => $fileInfo['name'] ?? null,
            'type' => $fileInfo['type'] ?? null,
            'format' => $format ?? null,
            'size' => $fileInfo['size']??0,
            'mime' => $mime ?? null,
            'extension' => strtolower( $extension ?? '' ),
            'temp' => $fileInfo['tmp_name'] ?? null,
            'error' => $fileInfo['error'] ?? null,
        ];
    }

     /**
     * Get the request method 
     *
     * @return string The Request method
     */
    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']??'');
    }

     /**
     * Get the request content type
     *
     * @return string The Request content type
     */
    public function getContentType(): string
    {
        return $_SERVER['CONTENT_TYPE'] ?? '';
    }

    /**
     * Parse the request body based on the request method.
     *
     * @param string|null $method
     * @return array
     */
    private function parseRequestBody(?string $method = null): array
    {
        $body = [];

        if ($method === null || $this->getMethod() === $method) {
            $input = file_get_contents('php://input');
            $type = $this->getContentType();
            if ($type !== '' && strpos($type, 'multipart/form-data') !== false) {

                $body = array_merge($_FILES, $_POST);
               
                if ($input !== false) {
                    parse_str($input, $fields);
                    $body = array_merge($body, $fields);
                }
            } else {
                if ($input !== false) {
                    parse_str($input, $body);
                }
            }
        }

        return $body;
    }

    public function getAuthorization(): string
    {
		return Header::getAuthorization();
	}
	
	/**
	 * get access token from header
     * 
     * @return string|null
	*/
	public function getAuthBearer(): ?string 
    {
		$auth = Header::getAuthorization();
		if (!empty($auth)) {
			if (preg_match('/Bearer\s(\S+)/', $auth, $matches)) {
				return $matches[1];
			}
		}
		return null;
	}

     /**
     * Is CLI?
     *
     * Test to see if a request was made from the command line.
     *
     * @return bool
    */
    public function isCommandLine(): bool
    {
        return defined('STDIN') ||
            (empty($_SERVER['REMOTE_ADDR']) && !isset($_SERVER['HTTP_USER_AGENT']) && count($_SERVER['argv']) > 0) ||
            php_sapi_name() === 'cli' ||
            array_key_exists('SHELL', $_ENV) ||
            !array_key_exists('REQUEST_METHOD', $_SERVER);
    }

    /**
     * Check if the current connection is secure
    */
    public function isSecure(): bool
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    }

    /**
     * Test to see if a request contains the HTTP_X_REQUESTED_WITH header.
    */
    public function isAJAX(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    // Get the URI
    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    // Get the user agent as an array
    public function getUserAgent(): array
    {
        return get_browser(null, true);
    }

    // Get the user agent as a string
    public function getAgentString(): string
    {
        $userAgent = $this->getUserAgent();
        return $userAgent['browser'] . ' on ' . $userAgent['platform'];
    }

    public function hasHeader(string $headerName): bool
    {
        return array_key_exists($headerName, $_SERVER);
    }

    public function header(string $headerName): ?Header
    {
        if ($this->hasHeader($headerName)) {
            return new Header($_SERVER[$headerName]);
        }
        return null;
    }
}
