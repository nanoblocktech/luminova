<?php 
namespace Luminova\Exceptions;
class InvalidArgumentException extends \Exception {
    public function __construct(string $message = 'error', int $code = 404, \Exception $previous = null) 
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string 
    {
        return "Error {$this->code}: {$this->message}";
    }
}