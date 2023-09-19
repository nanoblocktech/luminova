<?php 
namespace Luminova\Exceptions;

class FileNotFoundException extends \Exception {
    public function __construct(string $message = 'error', int $code = 500, \Exception $previous = null) 
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string 
    {
        return "Error {$this->code}: {$this->message}";
    }

    public function getCustomMessage(): string 
    {
        $messageParts = explode(':', $this->message, 2);
        return trim($messageParts[1]);
    }

    public function getErrorMessage(): string 
    {
        return $this->message;
    }
}
