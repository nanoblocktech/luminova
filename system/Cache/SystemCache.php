<?php 
namespace Luminova\Cache;
class SystemCache extends \Peterujah\NanoBlock\Cache{
    public const PROJECTS = "projects";
    public const OPEN_SOURCE = "opensource";
    public const MAIN = "main";
    public const BLOG = "blog";
    public const REVIEW = "reviews";
    public const CAREER = "career";
    public const TIMELINE = "timelines";
    public const AFTER_24_HOURS = 86400;
    public const AFTER_30_MINUTES = 1800;

    public function __construct(){ }

    private static function isLocal(){
        return ($_SERVER['SERVER_NAME'] == "localhost");
    }

    public static function pub($name, $sub = "", $count = 2){
        $sub = (!empty($sub) ? "/{$sub}/" : "/");
        return array(
            $name, 
            self::localPath($count) . "{$name}{$sub}"
        );
    }

    public static function pri($name, $user, $sub = "", $count = 2){
        $sub = (!empty($sub) ? "/{$sub}/" : "/");
        return array(
            $name, 
            self::localPath($count) . "{$user}/{$name}{$sub}"
        );
    }

    private static function localPath($count = 2){
        $path = self::pathDept($count);
        if(!self::isLocal()){
            $path .= "/../private";
        }
        $path .= "/caches/";
        return $path;
    }

    private static function pathDept($count) {
        $path = str_repeat('/../', $count);
        $path = preg_replace('#/{2,}#', '/', $path);
        return rtrim($path, '/');
    }

    public function intPublic($name, $dir, $sub = "", $count = 2){
        $this->setFilename($name);
        $this->setCacheLocation($dir . self::pub($name, $sub, $count)[1]);
        $this->addConfig();
        return $this;
    }

    public function fromPath($name, $path){
        $this->setFilename($name);
        $this->setCacheLocation($path);
        $this->addConfig();
        return $this;
    }

    public function intPrivate($name, $user, $dir, $sub = "", $count = 2){
        $this->setFilename($name);
        $this->setCacheLocation($dir . self::pri($name, $user, $sub, $count)[1]);
        $this->addConfig();
        return $this;
    }

    private function addConfig(){
        $this->setExtension(parent::JSON);
        $this->setDebugMode(self::isLocal());
        $this->enableDeleteExpired(true);
        $this->onCreate();
        //$this->setExpire(5.000004 * 10);
        $this->setExpire(self::AFTER_24_HOURS);
    }
}