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

class SessionManager implements SessionInterface {
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
    public function setStorage(string $storage): self {
        $this->storage = $storage;
        return $this;
    }

    /**
     * Get storage key
     * @return string
    */
    public function getStorage(): string {
        return $this->storage;
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
        $_SESSION[$this->storage][$key] = $value;
        return $this;
    }

    /** 
     * get data from session
     * @param string $index key to het
     * @return mixed
    */
    public function get(string $index): mixed
    {
        return $_SESSION[$this->storage][$index]??null;
    }

    /** 
     * Get data from specified storage instance
     * @param string $index value key to get
     * @param string $storage Storage key name
     * @return mixed
    */
    public function getFrom(string $index, string $storage): mixed
    {
        return $_SESSION[$storage][$index]??null;
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
        $_SESSION[$storage][$index] = $data;
        return $this;
    }

    /** 
     * Check if session user is online from any storage instance
     * @return bool
    */
    public function online($storage = ''): bool
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
        unset($_SESSION[$storageKey]);
        return $this;
    }

    /** 
     * Remove key from current session storage by passing the key
     * @param string $index key index to unset
     * @return self
    */
    public function remove(string $index): self
    {
        unset($_SESSION[$this->storage][$index]);
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
        if (isset($_SESSION[$storageKey])) {
            return $_SESSION[$storageKey];
        }
        return [];
    }

    /** 
     * Get data as array from current session storage 
     * @param string $index optional key to get
     * @return array
    */
    public function toArray(string $index = ''): array
    {
        if( empty($index)){
            if(isset($_SESSION[$this->storage])){
                return (array) $_SESSION[$this->storage];
            }

            if(isset($_SESSION)){
                return (array) $_SESSION;
            }
        }

        if(isset($_SESSION[$this->storage][$index])){
            return (array) $_SESSION[$this->storage][$index];
        }
        return [];
    }

    /** 
     * Get data as object from current session storage
     * @param string $index optional key to get
     * @return object
    */
    public function toObject(string $index = ''): object
    {
        if( empty($index)){
            if(isset($_SESSION[$this->storage])){
                return (object) $_SESSION[$this->storage];
            }

            if(isset($_SESSION)){
                return (object) $_SESSION;
            }
        }

        if(isset($_SESSION[$this->storage][$index])){
            return (object) $_SESSION[$this->storage][$index];
        }
        return (object)[];
    }

}