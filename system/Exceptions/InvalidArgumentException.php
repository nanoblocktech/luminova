<?php 
namespace Luminova\Exceptions;
class InvalidArgumentException extends \Exception {
    public function __construct($message = 'error', $code = 404, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return "Error {$this->code}: {$this->message}";
    }
}