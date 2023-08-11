<?php 
namespace Luminova\Logger;
use \Luminova\Logger\LoggerInterface;
class FileLogger implements LoggerInterface {
    private $filePath;

    public function __construct($filePath) {
        $this->filePath = $filePath;
    }

    public function log($message) {
        file_put_contents($this->filePath, $message . PHP_EOL, FILE_APPEND);
    }
}