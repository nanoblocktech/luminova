<?php 
namespace Luminova\Exceptions;

class DatabaseException extends \Exception {
    //protected $message;
    public function __construct(string $message = 'Database error', int $code = 500, \Exception $previous = null)
    {
        //$this->message = $message;
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
