<?php 
namespace Luminova\Exceptions;
class PageNotFoundException extends \Exception {
    public function __construct($page = 'mail', $code = 404, \Exception $previous = null) {
        $message = "The page '{$page}' was not found.";
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return "Error {$this->code}: {$this->message}";
    }
}