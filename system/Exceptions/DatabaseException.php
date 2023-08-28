<?php 
namespace Luminova\Exceptions;

class DatabaseException extends \Exception {
    //protected $message;
    public function __construct($message = 'Database error', $code = 500, \Exception $previous = null) {
        //$this->message = $message;
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return "Error {$this->code}: {$this->message}";
    }

    public function getCustomMessage() {
        $messageParts = explode(':', $this->message, 2);
        return trim($messageParts[1]);
    }

    public function getErrorMessage() {
        return $this->message;
    }
}
