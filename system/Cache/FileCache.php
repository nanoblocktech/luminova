<?php 
namespace Luminova\Cache;
class FileCache extends \Peterujah\NanoBlock\Cache{
    
    public const AFTER_24_HOURS = 86400;
    public const AFTER_30_MINUTES = 1800;

    public function __construct(){ }

    private static function isLocal(): bool 
    {
        return ($_SERVER['SERVER_NAME'] == "localhost");
    }

    public static function storage(string $name, ?string $sub = null, ?string $user = null, int $count = 2): array{
       
        $cachePath = (!empty($user) ? "{$user}/{$name}" : $name);
        $cachePath .= (!empty($sub) ? "/{$sub}/" : "/");
        return array(
            $name, 
            self::localPath($count) . $cachePath
        );
    }

    private static function localPath(int $count = 2): string{
        $path = self::pathDept($count);
        if(!self::isLocal()){
            $path .= "/../private";
        }
        $path .= "/caches/";
        return $path;
    }

    private static function pathDept(int $count): string {
        $path = str_repeat('/../', $count);
        $path = preg_replace('#/{2,}#', '/', $path);
        return rtrim($path, '/');
    }

    public function global(string $name, string $dir, string $sub = '', int $count = 2): FileCache 
    {
        $this->setFilename($name);
        $this->setCacheLocation($dir . self::storage($name, $sub, null, $count)[1]);
        $this->addConfig();
        return $this;
    }

    public function user(string $name, string $user, string $dir, string $sub = '', int $count = 2): FileCache 
    {
        $this->setFilename($name);
        $this->setCacheLocation($dir . self::storage($name, $sub, $user, $count)[1]);
        $this->addConfig();
        return $this;
    }

    public function fromPath(string $name, string $path): FileCache 
    {
        $this->setFilename($name);
        $this->setCacheLocation($path);
        $this->addConfig();
        return $this;
    }

    private function addConfig(): void{
        $this->setExtension(parent::JSON);
        $this->setDebugMode(self::isLocal());
        $this->enableDeleteExpired(true);
        $this->onCreate();
        //$this->setExpire(5.000004 * 10);
        $this->setExpire(self::AFTER_24_HOURS);
    }
}