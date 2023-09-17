<?php 
namespace Luminova\Exceptions;
class PageNotFoundException extends \Exception {
    public function __construct(string $page = 'mail', int $code = 404, \Exception $previous = null) 
    {
        $message = "The page '{$page}' was not found.";
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string 
    {
        return "Error {$this->code}: {$this->message}";
    }
}