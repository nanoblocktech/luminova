<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Sessions;
use Luminova\Sessions\SessionInterface;

class CookieManager implements SessionInterface
{

    /**
     * @var string $storage
    */
    protected string $storage;

    /**
     * Session constructor.
     *
     * @param string $storage The session storage key.
    */
    public function __construct(string $storage = 'global') 
    {
        $this->storage = $storage;
    }

    /**
     * Set storage key
     *
     * @param string $storage The session storage key.
     * @return self
    */
    public function setStorage($storage){
        $this->storage = $storage;
    }

    /**
     * Add a key-value pair to the session data.
     *
     * @param string $key The key.
     * @param mixed $value The value.
     * @return self
     */
    public function add(string $key, mixed $value): self
    {
        return $this->set($key, $value);
    }

     /** 
     * Set key and value to session
     * @param string $key key to set
     * @param mixed $value value to set
     * @return self
    */
    public function set(string $key, mixed $value): self
    {
        $storage = $this->getStorageData();
        $storage[$key] = $value;
        $this->saveData($storage);
        return $this;
    }

    /** 
     * get data from session
     * @param string $index key to het
     * @return mixed
    */
    public function get(string $index): mixed
    {
        return $this->getStorageData()[$index] ?? null;
    }

    /** 
     * Get data from specified storage instance
     * @param string $index value key to get
     * @param string $storage Storage key name
     * @return mixed
    */
    public function getFrom(string $index, string $storage): mixed
    {
        return $this->getStorageData($storage)[$index] ?? null;
    }

    /** 
     * Get data from specified storage instance
     * @param string $index value key to get
     * @param mixed $data data to set
     * @param string $storage Storage key name
     * @return self
    */
    public function setTo(string $index, mixed $data, string $storage): self
    {
        $storageData = $this->getStorageData($storage);
        $storageData[$index] = $data;
        $this->saveData($storageData, $storage);
        return $this;
    }

    /** 
     * Check if session user is online from any storage instance
     * @return bool
    */
    public function online(string $storage = ''): bool
    {
        return (isset($this->getStorageData($storage)["_online"]) && $this->getStorageData($storage)["_online"] == "YES");
    }

    /** 
     * Clear all data from specific session storage by passing the storage key
     * @param string $storage storage key to unset
     * @return self
    */
    public function clear(string $storage = ''): self
    {
        $storageKey = empty($storage) ? $this->storage : $storage;
        unset($_COOKIE[$storageKey]);
        return $this;
    }

    /** 
     * Remove key from current session storage by passing the key
     * @param string $index key index to unset
     * @return self
    */
    public function remove(string $index): self
    {
        $storage = $this->getStorageData();
        unset($storage[$index]);
        $this->saveData($storage);
        return $this;
    }

    /**
     * Start an online session with an optional IP address.
     *
     * @param string $ip optional IP address.
     * @return self
     */
    public function goOnline(string $ip = ''): self
    {
        $storage = $this->getStorageData();
        $storage["_online"] = "YES";
        if ($ip !== '') {
            $storage["_online_session_id"] = $ip;
        }
        $this->saveData($storage);
        return $this;
    }

    /** 
     * Get data as array from storage 
     * @param string $storage optional storage key 
     * @return array
    */
    public function getStorageData(string $storage = ''): array
    {
        $storageKey = empty($storage) ? $this->storage : $storage;
        if (isset($_COOKIE[$storageKey])) {
            return json_decode($_COOKIE[$storageKey], true) ?? [];
        }
        return [];
    }

     /** 
     * Get data as array from current session storage 
     * @param string $index optional key to get
     * @return array
    */
    public function __toArray(string $index = ''): object
    {
        $data = $this->getStorageData();
        if(empty($index)){
            if($data !== []){
                return (array)$data;
            }
            if(isset($_COOKIE)){
                return (array) $_COOKIE;
            }
        }
        if (isset($data[$index])) {
            return (array)$data[$index];
        }
        return [];
    }

    /** 
     * Get data as object from current session storage
     * @param string $index optional key to get
     * @return object
    */
    public function __toObject(string $index = ''): object
    {
        $data = $this->getStorageData();
        if(empty($index)){
            if($data !== []){
                return (object)$data;
            }
            if(isset($_COOKIE)){
                return json_decode($_COOKIE, true);
            }
        }
        if (isset($data[$index])) {
            return (object)$data[$index];
        }
        return (object)[];
    }


    /** 
     * Save data to cookie storage
     * @param array $data data
     * @param string $storage storage key
     * @return object
    */
    protected function saveData(array $data, string $storage = ''): void
    {
        $storageKey = empty($storage) ? $this->storage : $storage;
        setcookie($storageKey, json_encode($data), time() + 365 * 24 * 60 * 60, "/");
    }
}
