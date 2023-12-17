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

class CookieManager implements SessionInterface {
    /**
     * @var string $storage
    */
    protected string $storage;

    /**
     * @var array $config
    */
    private array $config = [];

    /**
     * Session constructor.
     *
     * @param string $storage The session storage key.
     * @param array $config Cookie configuration
    */
    public function __construct(string $storage = 'global', array $config = []) 
    {
        $this->storage = $storage;
        $this->config = $config;
    }

    /** 
     * Set cookie options 
     * 
     * @param array $config 
     * 
     * @return void
    */
    public function setConfig(array $config): void 
    {
        $this->config = $config;
    }

    /**
     * Set storage key
     *
     * @param string $storage The session storage key.
     * 
     * @return self
    */
    public function setStorage(string $storage): self 
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * Get storage key
     * 
     * @return string
    */
    public function getStorage(): string 
    {
        return $this->storage;
    }
  
    /**
     * Add a key-value pair to the session data.
     *
     * @param string $key The key.
     * @param mixed $value The value.
     * 
     * @return self
     */
    public function add(string $key, mixed $value): self
    {
        $this->setContents($key, $value);
        return $this;
    }

    /** 
     * Set key and value to session
     * 
     * @param string $key key to set
     * @param mixed $value value to set
     * 
     * @return self
    */
    public function set(string $key, mixed $value): self
    {
        $this->setContents($key, $value);
        return $this;
    }

    /** 
     * get data from session
     * 
     * @param string $index key to get
     * 
     * @return mixed
    */
    public function get(string $index): mixed
    {
        $data = $this->getContents();
        return $data[$index]??null;
    }

    /** 
     * Get data from specified storage instance
     * 
     * @param string $index value key to get
     * @param string $storage Storage key name
     * 
     * @return mixed
    */
    public function getFrom(string $index, string $storage): mixed
    {
        $data = $this->getContents($storage);
        return $data[$index]??null;
    }

    /** 
     * Get data from specified storage instance
     * 
     * @param string $index value key to get
     * @param mixed $value data to set
     * @param string $storage Storage key name
     * 
     * @return self
    */
    public function setTo(string $index, mixed $value, string $storage): self
    {
        $data = $this->getContents($storage);
        $data[$index] = $value;
        $this->updateContents($data);
        return $this;
    }

    /** 
     * Check if session user is online from any storage instance
     * 
     * @param string $storage Optional storage key 
     * 
     * @return bool
    */
    public function online($storage = ''): bool
    {
        $data = $this->getContents($storage);
        return (isset($data["_online"]) && $data["_online"] == "YES");
    }

    /**
     * Clear all data from a specific session storage by passing the storage key.
     *
     * @param string $storage Storage key to unset.
     * 
     * @return self
    */
    public function clear(string $storage = ''): self
    {
        $storageKey = $storage === '' ? $this->storage : $storage;
        setcookie($storageKey, '', time() - $this->config['lifetime'], $this->config['path']);
        return $this;
    }

   /**
     * Remove key from the current session storage by passing the key.
     *
     * @param string $index Key index to unset.
     * 
     * @return self
    */
    public function remove(string $index): self
    {
        $data = $this->getContents();
        if (isset($_COOKIE[$this->storage], $data[$index])) {
            unset($data[$index]);
            $this->updateContents($data);
        }
        return $this;
    }

    /** 
     * Check if key exists in session
     * 
     * @param string $key
     * 
     * @return bool
    */
    public function hasKey(string $key): bool
    {
        $data = $this->getContents();
        return isset($data[$key]);
    }

     /** 
     * Check if storage key exists in session
     * 
     * @param string $storage
     * 
     * @return bool
    */
    public function hasStorage(string $storage): bool
    {
        return isset($_COOKIE[$storage]);
    }

    /** 
     * Get all stored session as array
     * 
     * @return array
    */
    public function getResult(): array
    {
        if (isset($_COOKIE)) {
            return (array) $_COOKIE;
        }
        return [];
    }

    /** 
     * Get data as array from current session storage 
     * 
     * @param string $index optional key to get
     * 
     * @return array
    */
    public function toArray(string $index = ''): array
    {
        $data = $this->getContents();
        if($index === ''){
            if($data !== []){
                return (array) $data;
            }
            if(isset($_COOKIE)){
                return (array) $_COOKIE;
            }
        }elseif (isset($data[$index])) {
            return (object) $data[$index];
        }
        return [];
    }

    /** 
     * Get data as object from current session storage
     * 
     * @param string $index optional key to get
     * 
     * @return object
    */
    public function toObject(string $index = ''): object
    {
        $data = $this->getContents();
        if($index === ''){
            if($data !== []){
                return (object) $data;
            }
            if(isset($_COOKIE)){
                return (object) $_COOKIE;
            }
        }elseif (isset($data[$index])) {
            return (object) $data[$index];
        }
        return (object)[];
    }

    /** 
     * Get data as array from storage 
     * 
     * @param string $storage optional storage key 
     * 
     * @return array
    */
    public function getContents(string $storage = ''): array
    {
        $storageKey = $storage === '' ? $this->storage : $storage;
        if (isset($_COOKIE[$storageKey])) {
            return json_decode($_COOKIE[$storageKey], true) ?? [];
        }
        return [];
    }

    /**
     * Save data to cookie storage.
     *
     * @param string $key Key
     * @param mixed $value Value
     * 
     * @return void
    */
    private function setContents(string $key, mixed $value): void
    {
        $data = $this->getContents();
        $data[$key] = $value;
        $this->updateContents($data);
    }

    /**
     * Update data to cookie storage.
     *
     * @param array $data contents
     * 
     * @return self $this
    */
    private function updateContents(array $data): self
    {
        $cookieValue = json_encode($data);
        setcookie(
            $this->storage,
            $cookieValue,
            time() + $this->config['lifetime'],
            $this->config['path'],
            $this->config['domain'],
            $this->config['secure'],
            $this->config['httponly']
        );
        
        return $this;
    }


}