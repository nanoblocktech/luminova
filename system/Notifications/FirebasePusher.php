<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

namespace Luminova\Notification;
use \Kreait\Firebase\Factory;
use \Kreait\Firebase\Messaging\CloudMessage;
use \Kreait\Firebase\Messaging\Notification;
use Luminova\Config\BaseConfig;
use Luminova\Exceptions\ErrorException;
class FirebasePusher extends BaseConfig {
    protected $factory;
    public const TO_ID = "id";
    public const TO_IDS = "ids";
    public const TO_TOPIC = "topic";
    public function __construct(string $filename = "ServiceAccount.json", string $dir = __DIR__){
        $credential_dir = parent::getRootDirectory($dir);
        $credential_dir .= "/writable/credentials/{$filename}";
        if(file_exists($credential_dir)){
            $this->factory = (new Factory)->withServiceAccount($credential_dir);
        }else{
            ErrorException::throwException("Firebase notification service account not found at [{" . parent::filterPath($credential_dir) . "}]", parent::isProduction());
        }
    }

    public function messaging(): object{
        return $this->factory->createMessaging();
    }

    private static function create(string $title, string $body): object{
        return Notification::create($title, $body);
    }

    public function sendToId(array $data): array{
        try{
            return $this->messaging()->send(
                CloudMessage::withTarget("token", $data["token"])
                ->withNotification(self::create($data["title"], $data["body"]))
                ->withData($data["data"])
            );
        }catch(Exception $e) {
            ErrorException::throwException($e->getMessage(), parent::isProduction());
        }
        return [];
    }

    public function sendToTopic(array $data): array{
        try{
            return $this->messaging()->send(
                CloudMessage::withTarget("topic", $data["topic"])
                ->withNotification(self::create($data["title"], $data["body"]))
                ->withData($data["data"])
            );
        }catch(Exception $e) {
            ErrorException::throwException($e->getMessage(), parent::isProduction());
        }
        return [];
    }


    public function cast(array $data): array{
        if(is_array($data["tokens"])){
            return $this->messaging()->sendMulticast(
                CloudMessage::new()
                ->withNotification(self::create($data["title"], $data["body"]))
                ->withData($data["data"]), 
                $data["tokens"]
            );
        }else{
            ErrorException::throwException("Method requires array of notification ids", parent::isProduction());
        }
        return [];
    }

    public function send(array $data, string $type = self::TO_ID): array {
        switch($type){
            case "topic":
                return $this->sendToTopic($data);
            case "id":
                return $this->sendToId($data);
            case "ids":
                return $this->cast($data);
            default:
                return [];
        }
    }
}