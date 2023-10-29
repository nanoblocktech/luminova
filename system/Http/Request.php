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

        return (object)[
            'index' => $index,
            'name' => $fileInfo['name']??null,
            'type' => $fileInfo['type']??null,
            'size' => $fileInfo['size']??0,
            'mime' => mime_content_type($fileInfo['tmp_name']),
            'extension' => strtolower(pathinfo($fileInfo['name'], PATHINFO_EXTENSION)),
            'temp' => $fileInfo['tmp_name']??null,
            'error' => $fileInfo['error']??null,
        ];
    }

     /**
     * Get the request method 
     *
     * @return string The Request method
     */
    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }


    /**
     * Parse the request body based on the request method.
     *
     * @param string|null $method
     * @return array
     */
    private function parseRequestBody(string $method = null): array
    {
        $body = [];
        if ($method === null || $_SERVER['REQUEST_METHOD'] === $method) {
            $input = file_get_contents('php://input');
            if ($input !== false) {
                parse_str($input, $body);
            }
        }
        return $body;
    }

    public function getAuthorization(): string{
		$headers = null;
		if (isset($_SERVER['Authorization'])) {
			$headers = trim($_SERVER["Authorization"]);
		}else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} else if (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$requestHeaders = array_combine(
			  array_map('ucwords', array_keys($requestHeaders)),
			  array_values($requestHeaders)
			);
			if (isset($requestHeaders['Authorization'])) {
				$headers = trim($requestHeaders['Authorization']);
			}
		}
		return $headers;
	}
	
	 /**
	 * get access token from header
	 * */
	public function getAuthBearer(): ?string {
		$authHeader = $this->getAuthorization();
		if (!empty($authHeader)) {
			if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
				return $matches[1];
			}
		}
		return null;
	}
}
