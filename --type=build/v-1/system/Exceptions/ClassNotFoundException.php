<?php 
namespace Luminova\Exceptions;
class ClassNotFoundException extends \Exception {
    public function __construct(string $class = 'class', int $code = 404, \Exception $previous = null) {
        $message = sprintf(
            'Invalid class name (%s) was not found.',
            gettype($class)
        );
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string {
        return "Error {$this->code}: {$this->message}";
    }
}