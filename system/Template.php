<?php 
namespace Luminova;
use Luminova\Exceptions\PageNotFoundException; 
use Luminova\Exceptions\ClassNotFoundException; 
use Luminova\Exceptions\InvalidArgumentException; 
use Luminova\Cache\Compress;
class Template extends Compress{ 
    /** Holds the project base directory
     * @var string|path|dir $baseTemplateDir __DIR__
    */
    private $baseTemplateDir;

    /** Holds the debug state
     * @var bool $isDebugMode true 0r false
    */
    private $isDebugMode = false;

    /** Holds the project template filename
     * @var string $templateFile 
    */
    private $templateFile = "404";

    /** Holds the project template file directory path
     * @var string $templateFolder 
    */
    private $templateFolder = "resources/views";

    /** Holds template assets folder
     * @var object $assetsFolder 
    */
    public $assetsFolder = "resources/assets";

    /** Holds the router active page name
     * @var string $activeView 
    */
    private $activeView = "";

    /** Holds the array attributes
     * @var object|array $attributesMapper 
    */
    protected $attributesMapper = [];

    /** Holds the array classes
     * @var object|array $attributesMapper 
    */
    protected $classMapper = [];

    /** Holds template project root
     * @var object|Config $appPublicFolder 
    */
    private $appPublicFolder = "";

    /**
     * Holds router param value to share across
     */
    protected $paramAttributes = null;

    /**
     * Holds template html content
    */
    protected $contents = "";
    /**
     * Holds relative file position depth 
    */
    private $calculateDepth = 0;

    /**
     * Holds current router request base
    */
    private $currentRequestBase = "/";

    /**
     * Holds directory separator
    */
    private $ds = DIRECTORY_SEPARATOR;

    /**
     * Holds system keywords
    */
    private const SYSTEM_VARIABLES = [
        "user",
        "func",
        "config",
        "instance",
        "class",
        "function",
        "static",
        "object",
        "this"
    ];

    /** 
    * Initialize class construct
    */
    public function __construct(string $dir =__DIR__, bool $debug = false){
        $this->baseTemplateDir = dirname($dir);
        $this->isDebugMode = $debug;
        //$compress = new Compress();
        parent::__construct();
    }


    public function __get(string $propertyName): mixed {
        if (array_key_exists($propertyName, $this->attributesMapper)) {
            return $this->attributesMapper[$propertyName];
        } elseif (array_key_exists($propertyName, $this->classMapper)) {
            return $this->classMapper[$propertyName];
        } else {
            throw new ClassNotFoundException("Property $propertyName is not registered.");
        }
    }

    public function setDept(string $depth): Template{
        $this->calculateDepth = $depth;
        return $this;
    }

    public function setBasePath(string $base): Template{
        $this->currentRequestBase = $base;
        return $this;
    }

    public function getDir(): string{
        if(empty($this->baseTemplateDir)){
            $this->baseTemplateDir = dirname(__DIR__);
        }
        return $this->baseTemplateDir;
    }
    
    /** 
    * Set the template directory path
    * @param string $path the file path directory
    * @return Template $this
    */
    public function setTemplatePath(string $path): Template{
        $this->templateFolder = trim( $path, "/" );
        return $this;
    }

    /** 
    * render the template full path
    * @param string $file the file name
    * @return Template $this
    */
    public function render(string $viewName): Template {
        $this->templateFile = "{$this->getDir()}{$this->ds}{$this->templateFolder}{$this->ds}{$viewName}.php";
        $this->activeView = $viewName;
        return $this;
    }

    /** 
     * Register a class instance to template
    * @param String $className the class name/identifier
    * @param Class|Object $classInstance class instance
    * @return Template $this
    */
    public function registerClass(string $className, object $classInstance = null): Template {
        if (empty($className) || !is_string($className)) {
            throw new ClassNotFoundException("Invalid class name: $className");
        }
    
        if ($classInstance === null) {
            // If $classInstance is not provided, create a new instance
            if (class_exists($className)) {
                $classInstance = new $className();
            } else {
                throw new ClassNotFoundException("Class $className does not exist.");
            }
        } elseif (!is_object($classInstance)) {
            throw new ClassNotFoundException("Invalid class object: $className");
        }
    
        $this->classMapper[$className] = $classInstance;
        return $this;
    }    
    
    /** 
     * Initialize class instance by name
    * @param String $name the class name/identifier
    * @return Object $classInstance
    */
    public function newClass(string $className): object {
        return $this->classMapper[$className]??(object)[];
    }

    /** 
     * Set project application document root
     * public_html default
    * @param String $root base directory
    * @return Template $this
    */
    public function setDocumentRoot(string $root): Template {
        $this->appPublicFolder = $root;
        return $this;
    }

    /**
     * Sets project template options
     * @param  array $attributes
     * @return self
     * @throws Exception
     */
   
    public function setAttributes(array $attributes): Template{
        if (!is_array($attributes)) {
            throw new InvalidArgumentException("Attributes must be an array");
        }
        foreach ($attributes as $name => $value) {
            if (!is_string($name)) {
                throw new InvalidArgumentException("Invalid attribute name: $name");
            }

            if (in_array($name, self::SYSTEM_VARIABLES)) {
                throw new InvalidArgumentException("Invalid attribute name: $name");
            }

            if (empty($value)) {
                throw new InvalidArgumentException("Invalid class object for attribute $name");
            }
            $this->attributesMapper["_{$name}"] = $value;
        }

        return $this;
    }

    /*public function setSystemAttributes($name, $class){
        if (!is_object($class)) {
            throw new InvalidArgumentException("Attributes must be an array");
        }

        if (!is_string($name)) {
            throw new InvalidArgumentException("Invalid attribute name: $name");
        }
        if (empty($class)) {
            throw new InvalidArgumentException("Invalid class object for attribute $name");
        }
        $this->attributesMapper[$name] = $class;
    
        return $this;
    }*/

    /**
     * Attach an object to a server
     *
     * Accepts an instantiated object to use when handling requests.
     *
     * @param any $param
     * @return self
     * @throws Exception
     */
    public function setParam(mixed $param): Template{
        if (empty($param) OR !is_object($param)) {
            throw new \Exception(sprintf(
                'Invalid object argument (%s)',
                gettype($param)
            ));
        }

        if (isset($this->paramAttributes)) {
            throw new \Exception(
                'An object has already been registered with this soap server instance'
            );
        }

        $this->paramAttributes = $param;
        return $this;
    }

    /** 
     * Get object instance
    * @return mixed
    */
    public function getParam(): mixed{
        return $this->paramAttributes;
    }

    /** 
     * Get view contents 
    * @return mixed
    */
    public function getContents(): mixed{
        return $this->contents;
    }

    /** 
    * Creates and Render template by including the accessible global variable within the template file.
    * @param string|path $relativePath app relative directory path to then template file
    * @param array $options additional parameters to pass in the template file
    */
    public function renderViewContent(string $relativePath, array $options = []): void {
        $root =  ($this->isDebugMode ? $relativePath : $this->ds);
        $base =  rtrim($root . $this->appPublicFolder, "/") . "/";
 
        if(empty($options["active"])){
            $options["active"] = $this->activeView;
        }
        if(empty($options["ContentType"])){
            $options["ContentType"] = "html";
        }

        if(empty($options["title"])){
            $options["title"] = self::toTitle($options["active"], true);
        }else{
            $options["title"] = self::addTitleSuffix($options["title"]);
        }

        if(empty($options["subtitle"])){
            $options["subtitle"] = self::toTitle($options["active"]);
        }
       
        /*
        Set this in other to allow back to page not mater the base 404 is triggered
        */
        if($this->activeView == "404"){
            $base =  $this->currentRequestBase;
        }

        if(empty($options["base"])){
            $options["base"] = $base;
        }
        
        $options["root"] = $root;
        $this->setAttributes($options);
        /*
            can access key as variable
            extract($options);
        */
        $this->meta->setTitle($this->_title);

        if (!defined('ALLOW_ACCESS')){
            define("ALLOW_ACCESS", true);
        }
        if (!defined('ASSETS')){
            define("ASSETS", "{$root}{$this->assetsFolder}{$this->ds}");
        }
        if (!defined('BASE_ASSETS')){
            define("BASE_ASSETS", "{$base}{$this->assetsFolder}{$this->ds}");
        }

        if (! file_exists($this->templateFile)) {
            //$this->templateFile = "404";
            throw new PageNotFoundException($this->activeView);
        }else{
            ob_start();
            include_once $this->templateFile;
            $this->contents = ob_get_clean();
            if(self::getVariables("enable.compression") == 1){
                switch($options["ContentType"]){
                    case "json":
                        $this->json( $this->contents );
                    break;
                    case "text":
                        $this->text( $this->contents );
                        break;
                    case "html": default:
                        $this->html( $this->contents );
                    break;
                }
                $this->contents = $this->getCompressed();
            }else{
                header('X-Powered-By: Luminova');
                exit($this->contents);
            }
        }
    }

    /** 
    * Shorthand to build and Render template by including the accessible global variable within the template file.
    * @param int $depth the directory location dept
    * @param array $options additional parameters to pass in the template file
    */
    public function view(array $options = [], int $depth = null): void {
        $this->calculateDepth = ( !is_null($depth) ? ($depth??0) : $this->calculateDepth);
        $this->renderViewContent(self::getRelativePath($this->calculateDepth), $options);
    }

    /** 
    * Fixes the broken css,image & links when added additional slash(/) at the router link
    * The function will add the appropriate relative base based on how many invalid link detected.
    * @param int $depth the directory location dept from base directory index.php/fee(1) index.php/foo/bar(2)
    * @return string|path relative path 
    */
    private static function getRelativePath(int $depth = 0): string {
        $uri = $_SERVER['REQUEST_URI'];
        if (substr($uri, -1) == '/') {
            if (self::isLocalhost() && strpos($uri, '/public/') !== false) {
                list(, $uri) = explode('/public', $uri, 2);
            }
  
            $depth = substr_count($uri, '/');
            if ($depth == 1 && !self::isLocalhost()) {
                $depth = 0;
            }
        }else {
            if(self::isLocalhost() && strpos($uri, '/public') !== false){
                list(, $uri) = explode('/public', $uri, 2);
            }
            $depth = substr_count($uri, '/');
        }

        if ($depth >= 2) {
            return str_repeat('../', $depth);
        }
       
        return ($depth == 1 ? '../' : './');
    }

    public static function isLocalhost(): string{
        return ($_SERVER['HTTP_HOST'] === 'localhost');
    }

    private static function toTitle(string $input, bool $suffix = false): string {
        $input = str_replace(['_', '-'], ' ', $input);
        $input = ucwords($input);
        $input = str_replace(',', '', $input);
        return ($suffix ? self::addTitleSuffix($input) : $input);
    }

    private static function addTitleSuffix(string $title): string{
        $appName = self::getVariables("app.name");
        if (strpos($title, "| {$appName}") === false) {
            $title = " {$title} | {$appName}";
        }
        return $title;
    }

    private static function getVariables(string $key, mixed $default = null): mixed {
        if (getenv($key) !== false) {
            return getenv($key);
        }

        if (!empty($_ENV[$key])) {
            return $_ENV[$key];
        }

        if (!empty($_SERVER[$key])) {
            return $_SERVER[$key];
        }

        return $default;
    }
    
}
