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
use \Luminova\Exceptions\ErrorException;
class BaseFileCache {

    /**
     * Hold the cache extension type PHP, JSON, TEXT
     * @var string
     */
    public const PHP = ".catch.php";
    public const JSON = ".json";
    public const TEXT = ".txt";

     /**
     * Hold the cache file hash
     * @var string
     */
    private string $cacheFilenameHashed;
    /**
     * Hold the cache directory path
     * @var string
     */
    protected string $cacheLocation;

    /**
     * Hold the cache security status option
     * @var bool
     */
    protected bool $cacheSecurity = true;

    /**
     * Hold the cache file extension type
     * @var string
     */
    protected string $cacheFileExtension;

    /**
     * Hold the cache debug status option
     * @var bool
     */
    protected bool $isDebugging = false;

    /**
     * Hold the cache state mode 
     * @var bool
     */
    protected bool $isCacheEnabled = true;
    
    /**
     * Hold the cache details array 
     * @var array
     */
    protected array $cacheArray = [];

    /**
     * Hold the cache expiry delete option
     * @var bool
     */
    private bool $canDeleteExpired = true;

    /**
     * Hold the cache base64 enabling option
     * @var bool
     */
    private bool $encodeInBase64 = true;

    /**
     * Hold the cache expiry time
     * @var int
     */
    private int $cacheTime = 60;

     /**
     * Constructor.
     * @param string $name cache file name
     * @param string $path cache directory. Must end with "/"
     */
	public function __construct(string $name = "writable", string $path = "cache"){
        $this->setFilename("writable");
        $this->setCacheLocation(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR);
        //$this->setCacheLocation("cache" . DIRECTORY_SEPARATOR);
        $this->setExtension(self::JSON);
        $this->initializeEngine();
	}

    /**
     * Set the new cache directory path
     * @param string $path cache directory must end with 
     * @return BaseFileCache $this
     */
    public function setCacheLocation(string $path): BaseFileCache {
        $path = rtrim($path, DIRECTORY_SEPARATOR);
        $path .= DIRECTORY_SEPARATOR;
        $this->cacheLocation = $path;
        return $this;
    }

     /**
     * Sets the new cache file name.
     * @param string $name cache file name
     * @return BaseFileCache $this
     */
    public function setFilename(string $name): BaseFileCache {
        $this->cacheFilename = $name;
        $this->cacheFilenameHashed = md5($name);
        return $this;
    }

     /**
     * Sets the cache file extension type
     * @param string $extension 
     * @return BaseFileCache $this
     */
    public function setExtension(string $extension): BaseFileCache{
        $this->cacheFileExtension = $extension;
        return $this;
    }

     /**
     * Sets the cache debugging mode
     * @param bool $mode 
     * @return BaseFileCache $this
     */
    public function setDebugMode(bool $mode): BaseFileCache {
        $this->isDebugging = $mode;
        return $this;
    }

    public function setEnableCache(bool $enable): BaseFileCache {
        $this->isCacheEnabled = $enable;
        return $this;
    }

     /**
     * Sets the cache expiry time duration
     * @param int $time 
     * @return BaseFileCache $this
     */
    public function setExpire(int $time = 60): BaseFileCache {
        $this->cacheTime = $time;
        return $this;
    }

     /**
     * Enable the cache to store data in base64 encoded.
     * @param bool $encode true or false
     * @return BaseFileCache $this
     */
    public function enableBase64(bool $encode): BaseFileCache {
        $this->encodeInBase64 = $encode;
        return $this;
    }

    /**
     * Enable the cache delete expired data
     * @param bool $allow true or false
     * @return BaseFileCache $this
     */
    public function enableDeleteExpired(bool $allow): BaseFileCache {
        $this->canDeleteExpired = $allow;
        if($this->canDeleteExpired){
            $this->removeIfExpired();
        }
        return $this;
    }

    /**
     * Enable the cache to store secure data in php file extension.
     * @param bool $encode true or false
     * @return BaseFileCache $this
     */
    public function enableSecureAccess(bool $secure): BaseFileCache {
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
     * Loads, create, update and delete cache with more options
     * @param string $key cache key
     * @param int $time cache expiry time
     * @param bool $lock lock catch to avoid deletion even when cache time expire
     * @param object|callable $cacheCallback Callback called when data needs to be refreshed.
     * @return mixed|null Data currently stored under key
     * @throws ErrorException if the file cannot be saved
     */
    public function widthExpired(string $key, object $cacheCallback, int $time, bool $lock): mixed {
		if(!$this->isCacheEnabled){
			return $cacheCallback();
		}

        if ($this->hasExpired($key)){
            $funcResponse = $cacheCallback();
            if(!empty($funcResponse)){
                $this->buildCache($key, $funcResponse, $time, $lock);
            }
        }

        return $this->retrieveCache($key);
    }


    /**
     * Loads, create, update and delete cache with fewer options
     * @param string $key cache key
     * @param object|callable $cacheCallback Callback called when data needs to be refreshed.
     * @return mixed|null Data currently stored under key
     * @throws ErrorException if the file cannot be saved
     */
    public function onExpired(string $key, object $cacheCallback): mixed {
        if(empty($key)) {
            throw new ErrorException('Invalid argument, cache $key cannot be empty');
        }
        return $this->widthExpired($key, $cacheCallback, $this->cacheTime, false);
    }

    /**
     * Creates, Reloads and retrieve cache once class is created
     * @return object $this
     * @throws ErrorException if there is a problem loading the cache
     */
    protected function initializeEngine(): BaseFileCache {
        /*if (!is_file($this->cacheLocation )) {
            throw new ErrorException('InvalidArgumentException: Path ' . $this->cacheLocation  . ' must be a directory, got "' . gettype($this->cacheLocation ) . '" instead');
        }*/
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
            if ($this->hasExpired($key) && !($value["lock"]??false)) {
                $this->remove($key);
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
        if (!$this->hasCached($key)){
            return true;
        }

        $item = $this->cacheArray[$key];
        return $this->diffTime($item["time"], $item["expire"]);
    }

    /**
     * Deletes data associated with $key
     * @param string $key cache key
     * @return bool true or false
     * @throws ErrorException if the file cannot be saved
     */
    public function remove(string $key): bool {
        if (!$this->hasCached($key)) {
            return false;
        }
        unset($this->cacheArray[$key]);
        $this->writeCache();
        return true;
    }

    /**
     * Deletes data associated array of keys
     * @param array $array cache keys
     * @return \Generator
     * @throws ErrorException if the file cannot be saved
     */
    public function removeList(array $array): \Generator {
        foreach($array as $key){
            yield $this->remove($key);
        }
    }

    /**
     * Builds cache data to save
     * @param string $key cache keys
     * @param string|int|array|object $data cache data
     * @param string $expiration cache expiration time
     * @param string $lock cache lock expiry deletion
     * @throws ErrorException if the file cannot be saved
     * @return BaseFileCache $this
     */
    protected function buildCache(string $key,  $data, int $expiration = 60, $lock = false): BaseFileCache {
        $serializeData = serialize($data);
        if ($serializeData !== false) {
            $this->cacheArray[$key] = array(
                "time" => time(),
                "expire" => ($this->isCacheEnabled ? $expiration : 1),
                "data" => ($this->encodeInBase64 ? base64_encode($serializeData) : $serializeData),
                "lock" => $lock
            );
            $this->writeCache();
        }else{
            throw new ErrorException("Failed to create cache file!");
        }
        return $this;
    }

    /**
     * Fetch cache data from disk
     * @return string|int|array|object  $this
     */
    protected function fetchCatchData(): mixed {
    
        $filepath = $this->getCacheFilePath();
        if (!is_readable( $filepath )) {
            return [];
            //throw new ErrorException('File: ' .  $filepath . ' is not readable');
        }
       
        $file = file_get_contents($filepath);

        if ($file === false) {
            throw new ErrorException("Cannot load cache file! ({$this->cacheFilename})");
        }

        $data = unserialize($this->unlockSecurity($file));

        if ($data === false) {
            unlink($filepath);
            throw new ErrorException("Failed to unserialize cache file, cache file deleted. ({$this->cacheFilename})");
        }

        if (!isset($data["hash-sum"])) {
            unlink($filepath);
            throw new ErrorException("No hash found in cache file, cache file deleted");
        }

        $hash = $data["hash-sum"];
        unset($data["hash-sum"]);

        if ($hash !== md5(serialize($data))) {
            unlink($filepath);
            throw new ErrorException("Cache data miss-hashed, cache file deleted");
        }

        return $data;
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
     * @return mixed|null returns data if $key is valid and not expired, NULL otherwise
     * @throws ErrorException if the file cannot be saved
     */
    public function retrieveCache($key): mixed {
    
        if($this->canDeleteExpired){
            $this->removeIfExpired();
        }
    
        if (!isset($this->cacheArray[$key])){
            return null;
		}
        $data = $this->cacheArray[$key];
       return unserialize($this->encodeInBase64 ? base64_decode($data["data"]) : $data["data"]);    
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
     * @return BaseFileCache $this
     * @throws ErrorException if the file cannot be saved
     */

    protected function writeCache(): BaseFileCache {

        /*if (!is_writeable($this->cacheLocation )) {
           throw new ErrorException('Path: ' . $this->cacheLocation . ' is not writable');
        }*/

        if (!file_exists($this->cacheLocation)) {
            //mkdir($this->cacheLocation, 0700, true);
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
		if(@file_exists($fileCache)){
			@unlink($fileCache);
			return true;
		}
		return false;
    }

    /**
     * Remove cache file from disk with full path
     * @param string $path cache full path /
     * @param array $names cache file array names
     * @param string $extension cache file extension type
     */
    public function removeCacheDisk(string $path, array $names, string $extension = self::JSON): BaseFileCache {
        foreach($names as $name){
            $fileCache = $path . md5($name) . $extension;
            if(@file_exists($fileCache)){
                @unlink($fileCache);
            }
        }
        return $this;
    }

}
