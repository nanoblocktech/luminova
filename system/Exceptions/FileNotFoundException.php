<?php 
namespace Luminova\Exceptions;

class FileNotFoundException extends \Exception {
    public function __construct($message = 'error', $code = 500, \Exception $previous = null) {
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
