<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Cache;
use \Luminova\Cache\FileCacheItem;
use \Luminova\Exceptions\ErrorException;
use \Generator;
class FileSystemCache {
     /**
     * Cache expiry time 7 days
     * @var int TTL_7DAYS constant
     */
    public const TTL_7DAYS = 7 * 24 * 60 * 60;

     /**
     * Cache expiry time 24 hours
     * @var int TTL_24HR constant
     */
    public const TTL_24HR = 24 * 60 * 60;

     /**
     * Cache expiry time 30 minutes 
     * @var int TTL_30MIN constant
     */
    public const TTL_30MIN = 30 * 60;
    /**
     * Hold the cache extension type PHP
     * @var string PHP constant
     */
    public const PHP = ".catch.php";

     /**
     * Hold the cache extension type JSON
     * @var string JSON constant
     */
    public const JSON = ".json";

     /**
     * Hold the cache extension TEXT
     * @var string TEXT constant
     */
    public const TEXT = ".txt";

     /**
     * Hold the cache file hash
     * @var string $cacheFilenameHashed
     */
    private string $cacheFilenameHashed = '';
    /**
     * Hold the cache directory path
     * @var string $cacheLocation
     */
    protected string $cacheLocation = '';

    /**
     * Hold the cache security status option
     * @var bool $cacheSecurity
     */
    protected bool $cacheSecurity = true;

    /**
     * Hold the cache file extension type
     * @var string $cacheFileExtension
     */
    protected string $cacheFileExtension;

    /**
     * Hold the cache debug status option
     * @var bool $isDebugging
     */
    protected bool $isDebugging = false;

    /**
     * Hold the cache state mode 
     * @var bool $isCacheEnabled
     */
    protected bool $isCacheEnabled = true;
    
    /**
     * Hold the cache details array 
     * @var array $cacheArray
     */
    protected array $cacheArray = [];

    /**
     * Hold the cache expiry delete option
     * @var bool $canDeleteExpired
     */
    private bool $canDeleteExpired = true;

    /**
     * Hold the cache base64 enabling option
     * @var bool $encodeInBase64
     */
    private bool $encodeInBase64 = true;

    /**
     * Hold the cache expiry time
     * @var int $cacheTime
     */
    private int $cacheTime = 60;

     /**
     * Lock cache from deletion
     * @var bool $cacheLock
     */
    private bool $cacheLock = false;

    /**
     * Hold the static cache instance Singleton
     * @var static $instance
     */
    private static $instance = null;


     /**
     * Constructor.
     * @param string $filename cache filename to hash
     * @param string $filepath cache directory.
     */
    public function __construct(string $filename = '', string $filepath = ''){
        $this->setExtension(self::JSON);
        if( $filename !== '' && $filepath !== ''){
            $this->setFilename($filename);
            $this->setCacheLocation($filepath);
            $this->create();
        }
	}

    /**
     * Get static Singleton Class.
     * @param string $filename cache filename to hash
     * @param string $filepath cache directory.
     */
    public static function getInstance(string $filename = '', string $filepath = ''): static 
    {
        if (static::$instance === null) {
            static::$instance = new static($filename, $filepath);
        }
        return static::$instance;
    }

    /**
     * Set the new cache directory path
     * @param string $path cache directory must end with 
     * @return FileSystemCache $this
     */
    public function setCacheLocation(string $path): self {
        $path = rtrim($path, DIRECTORY_SEPARATOR);
        $path .= DIRECTORY_SEPARATOR;
        $this->cacheLocation = $path;
        return $this;
    }

     /**
     * Sets the new cache file name.
     * @param string $name cache filename hash value
     * @return FileSystemCache $this
     */
    public function setFilename(string $name): self {
        $this->cacheFilenameHashed = self::hashFilename($name);
        return $this;
    }

     /**
     * Generate hash name for cache 
     * @param string $name cache filename to hash
     * @return string hashed name with prefix
     */
    public static function hashFilename(string $name): string {
        $result = preg_replace('/[^a-zA-Z0-9]/', '', $name);
        return md5($result);
    }

     /**
     * Sets the cache file extension type
     * @param string $extension 
     * @return FileSystemCache $this
     */
    public function setExtension(string $extension): self{
        $this->cacheFileExtension = $extension;
        return $this;
    }

     /**
     * Sets the cache debugging mode
     * @param bool $mode 
     * @return FileSystemCache $this
     */
    public function setDebugMode(bool $mode): self {
        $this->isDebugging = $mode;
        return $this;
    }

     /**
     * Sets the cache state mode, if disabled cache system will always return new data not cached version 
     * @param bool $enable 
     * @return FileSystemCache $this
     */
    public function setEnableCache(bool $enable): self {
        $this->isCacheEnabled = $enable;
        return $this;
    }

     /**
     * Sets the cache expiry time duration
     * @param int $time 
     * @return FileSystemCache $this
     */
    public function setExpire(int $time): self {
        $this->cacheTime = $time;
        return $this;
    }

     /**
     * Sets the cache lock
     * @param bool $lock lock catch to avoid deletion even when cache time expire
     * @return FileSystemCache $this
     */
    public function setLock(bool $lock): self {
        $this->cacheLock = $lock;
        return $this;
    }

     /**
     * Enable the cache to store data in base64 encoded.
     * @param bool $encode true or false
     * @return FileSystemCache $this
     */
    public function enableBase64(bool $encode): self {
        $this->encodeInBase64 = $encode;
        return $this;
    }

    /**
     * Enable the cache delete expired data
     * @param bool $allow true or false
     * @return FileSystemCache $this
     */
    public function enableDeleteExpired(bool $allow): self {
        $this->canDeleteExpired = $allow;
        if($this->canDeleteExpired){
            $this->removeIfExpired();
        }
        return $this;
    }

    /**
     * Enable the cache to store secure data in php file extension.
     * @param bool $encode true or false
     * @return FileSystemCache $this
     */
    public function enableSecureAccess(bool $secure): self {
        $this->cacheSecurity = $secure;
        return $this;
    }


     /**
     * Gets Combines directory, filename and extension into a full filepath
     * @return string
     */
    public function getCacheFilePath(): string {
        return $this->cacheLocation . $this->cacheFilenameHashed . $this->cacheFileExtension;
    }

    /**
     * Creates cache timestamp expired status
     * @param int $timestamp old timestamp
     * @param int $expiration The number of seconds after the timestamp expires
     * @return bool true or false
     */
    private function diffTime(int $timestamp, int $expiration): bool {
        return (time() - $timestamp) >= $expiration;
    }


    /**
     * Loads, create, update and delete cache with fewer options
     * @param string $key cache key
     * @param object|callable $cacheCallback Callback called when data needs to be refreshed.
     * @return mixed Data currently stored under key
     * @throws ErrorException if the file cannot be saved
     */
    public function onExpired(string $key, object $cacheCallback): mixed {
        return $this->get($key, $cacheCallback, $this->cacheTime, $this->cacheLock);
    }

    /**
     * Loads, create, update and delete cache with FileCacheItem model
     * @param string $key cache key
     * @param object|callable $cacheCallback Callback called when data needs to be refreshed.
     * @return mixed Data currently stored under key
     * @throws ErrorException if the file cannot be saved
     */
    public function onCache(string $key, object $cacheCallback): mixed {
        if(empty($key)) {
            throw new ErrorException('Invalid argument, cache $key cannot be empty');
        }

        if($this->isCacheEnabled){
            if ($this->hasExpired($key)){
                $result = $cacheCallback(new FileCacheItem());
                if ($result instanceof FileCacheItem) {
                    if(!empty($result->getData())){
                        $this->buildCache($key, $result->getData(), $result->getExpiry(), $result->getLock());
                        return  $result->getData();
                    }
                }
                throw new ErrorException('Invalid argument, $cacheCallback require FileCacheItem ' . gettype($result) . ' is giving');
            }
            return $this->retrieveCache($key);
        }

        return $cacheCallback(new FileCacheItem());
    }

    /**
     * Loads, create, update and delete cache with full options
     * @param string $key cache key
     * @param object|callable $cacheCallback Callback called when data needs to be refreshed.
     * @param int $time cache expiry time
     * @param bool $lock lock catch to avoid deletion even when cache time expire
     * @return mixed|null Data currently stored under key
     * @throws ErrorException if the file cannot be saved
     */
    public function get(string $key, object $cacheCallback, int $time, bool $lock): mixed {
        if(empty($key)) {
            throw new ErrorException('Invalid argument, cache $key cannot be empty');
        }
		if($this->isCacheEnabled){
            if ($this->hasExpired($key)){
                $result = $cacheCallback();
                if(!empty($result)){
                    $this->buildCache($key, $result, $time, $lock);
                    return $result;
                }
            }
            return $this->retrieveCache($key);
        }
        return $cacheCallback();
    }


    /**
     * Creates, Reloads and retrieve cache once class is created
     * @return object $this
     * @throws ErrorException if there is a problem loading the cache
     */
    public function create(): self {
        $this->cacheArray = $this->fetchCatchData();
        return $this;
    }

    /**
     * Checks if cache key exist
     * @param string $key cache key
     * @return bool true or false
     */
    public function hasCached(string $key): bool {
        return isset($this->cacheArray[$key]);
    }

     /**
     * Remove expired cache by key
     * @return int number of deleted keys
     */
    public function removeIfExpired(): int {
        $counter = 0;
        foreach ($this->cacheArray as $key => $value) {
            if ($this->hasExpired($key) && !$value["lock"]) {
                //$this->remove($key);
                unset($this->cacheArray[$key]);
                $counter++;
            }
        }

        if ($counter > 0){
            $this->writeCache();
        }
        return $counter;
    }

    /**
     * Checks if the cache timestamp has expired by key
     * @param string $key cache key
     * @return bool true or false
     */
    public function hasExpired(string $key): bool {
        if ($this->hasCached($key)){
            $item = $this->cacheArray[$key];
            return $this->diffTime($item["time"], $item["expire"]);
            
        }
        return true;
    }

    /**
     * Deletes data associated with $key
     * @param string $key cache key
     * @return bool true or false
     * @throws ErrorException if the file cannot be saved
     */
    public function remove(string $key): bool {
        if ($this->hasCached($key)) {
            unset($this->cacheArray[$key]);
            $this->writeCache();
            return true;
        }
      
        return false;
    }

    /**
     * Deletes data associated array of keys
     * @param array $array cache keys
     * @return Generator
     * @throws ErrorException if the file cannot be saved
     */
    public function removeList(array $array): Generator {
        foreach($array as $key){
            yield $this->remove($key);
        }
    }

    /**
     * Builds cache data to save
     * @param string $key cache keys
     * @param mixed $data cache data
     * @param string $expiration cache expiration time
     * @param bool $lock cache lock expiry deletion
     * @throws ErrorException if the file cannot be saved
     * @return FileSystemCache $this
     */
    protected function buildCache(string $key, mixed $data, int $expiration = 60, bool $lock = false): self {
        $cacheString = serialize($data);
        if ($cacheString === false) {
            throw new ErrorException("Failed to create cache file!");
        }

        $this->cacheArray[$key] = [
            "time" => time(),
            "expire" => ($this->isCacheEnabled ? $expiration : 1),
            "data" => ($this->encodeInBase64 ? base64_encode($cacheString) : $cacheString),
            "lock" => $lock
        ];
        $this->writeCache();
        return $this;
    }

    /**
     * Fetch cache data from disk
     * @return mixed cached data
     * @throws ErrorException if cannot load cache, unable to unserialize, hash sum not found or invalid key
     */
    protected function fetchCatchData(): mixed {
    
        $filepath = $this->getCacheFilePath();

        if (is_readable( $filepath )) {

            $file = file_get_contents($filepath);
         
            if ($file === false) {
                throw new ErrorException("Cannot load cache file! ({$this->cacheFilenameHashed})");
            }

            $data = unserialize($this->unlockSecurity($file));

            if ($data === false) {
                unlink($filepath);
                throw new ErrorException("Failed to unserialize cache file, cache file deleted. ({$this->cacheFilenameHashed})");
            }
           
     
            if (isset($data["hash-sum"])) {

                $hash = $data["hash-sum"];
                unset($data["hash-sum"]);

                if ($hash !== md5(serialize($data))) {
                    unlink($filepath);
                    throw new ErrorException("Cache data miss-hashed, cache file deleted");
                }

                return $data;
            }

            unlink($filepath);
            throw new ErrorException("No hash found in cache file, cache file deleted");
        }
        //throw new ErrorException('File: ' .  $filepath . ' is not readable');
        return [];
    }

    /**
     * Remove the security line in php file cache
     * @param string $str cache string
     * @return string cache text without the first security line
     */
    protected function unlockSecurity(string $str): string {
        $position = strpos($str, PHP_EOL);
        if ($position === false){
            return $str;
        }
        return substr($str, $position + 1);
    }

    /**
     * Retrieve cache data from disk
     * @param string $key cache key
     * @return mixed returns data if $key is valid and not expired, NULL otherwise
     * @throws ErrorException if the file cannot be saved
     */
    public function retrieveCache(string $key): mixed {
    
        if($this->canDeleteExpired){
            $this->removeIfExpired();
        }
    
        if (isset($this->cacheArray[$key])){
            $data = $this->cacheArray[$key];
            return unserialize($this->encodeInBase64 ? base64_decode($data["data"]) : $data["data"]);
        }

        return null; 
    }

    /**
     * Clears the cache
     * @throws ErrorException if the file cannot be saved
     */
    public function clearCache(): void {
        $this->cacheArray = [];
        $this->writeCache();
    }

     /**
     * Write the cache data disk.
     * @return FileSystemCache $this
     * @throws ErrorException if the file cannot be saved
     */

    protected function writeCache(): self {

        /*if (!is_writeable($this->cacheLocation )) {
           throw new ErrorException('Path: ' . $this->cacheLocation . ' is not writable');
        }*/

        if (!file_exists($this->cacheLocation)) {
            mkdir($this->cacheLocation, 0755, true);
        }        
    
        $cache = $this->cacheArray;
        $cache["hash-sum"] = md5(serialize($cache));

        $writeLine = '';
        if ($this->cacheFileExtension == self::PHP && $this->cacheSecurity) {
            $writeLine = '<?php header("Content-type: text/plain"); die("Access denied"); ?>' . PHP_EOL;
        }
    
        $writeLine .= serialize($cache);
    
        $filePath = $this->getCacheFilePath();
        $saved = file_put_contents($filePath, $writeLine);
    
        if ($saved === false) {
            throw new ErrorException('RuntimeException: Cannot save cache');
        }
        
    
        return $this;
    }
    
	
	/**
     * Remove cache file
     * @return bool true if file path exist else false
     */
    public function removeCache(): bool {
		$fileCache = $this->getCacheFilePath();
		if(file_exists($fileCache)){
			return unlink($fileCache);
		}
		return false;
    }

    /**
     * Remove cache file from disk with full path
     * @param string $path cache full path /
     * @param array $filenames cache file array names
     * @param string $extension cache file extension type
     * @return bool
     */
    public function removeCacheDisk(string $path, array $filenames, string $extension = self::JSON): bool {
        $success = true;
        foreach($filenames as $name){
            $fileCache = $path . self::hashFilename($name) . $extension;
            if(file_exists($fileCache)){
                if (!unlink($fileCache)) {
                    $success = false;
                }
            }
        }
        return $success;
    }

}
