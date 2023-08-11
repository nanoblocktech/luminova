<?php 
namespace Luminova;
use \Luminova\Exceptions\PageNotFoundException; 
use \Luminova\Exceptions\ClassNotFoundException; 
use \Luminova\Exceptions\InvalidArgumentException; 
use \Luminova\Cache\Compress;
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

    /** Holds the array classes
     * @var object|array $attributesMapper 
    */
    protected $attributesMapper = array();

    /** Holds template project root
     * @var object|Config $appPublicFolder 
    */
    private $appPublicFolder = "";

    /**
     * Object registered with this server
     */
    protected $paramAttributes;

    private $calculateDepth = 0;
    private $currentRequestBase = "/";
    private $ds = DIRECTORY_SEPARATOR;

    /** 
    * Initialize class construct
    */
    public function __construct($dir =__DIR__, $debug = false){
        $this->baseTemplateDir = dirname($dir);
        $this->isDebugMode = $debug;
        //$compress = new Compress();
        parent::__construct();
    }

    public function __get($key) {
        if (isset($this->attributesMapper[$key])) {
            return $this->attributesMapper[$key];
        }
        return null;
    }

    public function setDept($depth){
        $this->calculateDepth = $depth;
        return $this;
    }

    public function setBasePath($base){
        $this->currentRequestBase = $base;
        return $this;
    }

    public function getDir(){
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
    public function setTemplatePath($path){
        $this->templateFolder = trim( $path, "/" );
        return $this;
    }

    /** 
    * render the template full path
    * @param string $file the file name
    * @return Template $this
    */
    public function render($viewName): Template {
        $this->templateFile = "{$this->getDir()}{$this->ds}{$this->templateFolder}{$this->ds}{$viewName}.php";
        $this->activeView = $viewName;
        return $this;
    }

    /** 
     * Register a class instance to template
    * @param String $name the class name/identifier
    * @param Class|Object $class class instance
    * @return Template $this
    */
    public function addClass($name, $class) {
        if (empty($name) || !is_string($name)) {
            throw new ClassNotFoundException("Invalid class name: $name");
        }

        if (empty($class) || !is_object($class)) {
            throw new ClassNotFoundException("Invalid class object: $class");
        }

        $this->attributesMapper[$name] = $class;
        return $this;
    }
    
    /** 
     * Initialize class instance by name
    * @param String $name the class name/identifier
    * @return Object $classInstance
    */
    public function newClass($name) {
        return $this->attributesMapper[$name]??null;
    }

    /** 
     * Set project application document root
     * public_html default
    * @param String $root base directory
    * @return Template $this
    */
    public function setDocumentRoot($root) {
        $this->appPublicFolder = $root;
        return $this;
    }

    /**
     * Sets project template options
     * @param  array $attributes
     * @return self
     * @throws Exception
     */
    public function setAttributes($attributes){
        if (!is_array($attributes)) {
            throw new InvalidArgumentException("Attributes must be an array");
        }

        foreach ($attributes as $name => $value) {
            if (!is_string($name)) {
                throw new InvalidArgumentException("Invalid attribute name: $name");
            }

            if (empty($value)) {
                throw new InvalidArgumentException("Invalid class object for attribute $name");
            }

            $this->attributesMapper[$name] = $value;
        }

        return $this;
    }

    /**
     * Attach an object to a server
     *
     * Accepts an instantiated object to use when handling requests.
     *
     * @param  object $param
     * @return self
     * @throws Exception
     */
    public function setParam($param){
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
    * @return Object
    */
    public function getParam(){
        return ($this->paramAttributes??(object)[]);
    }

    /** 
    * Creates and Render template by including the accessible global variable within the template file.
    * @param string|path $relativePath app relative directory path to then template file
    * @param array $options additional parameters to pass in the template file
    */
    public function renderViewContent($relativePath, $options = []) {
        $content = null;
        $root =  ($this->isDebugMode ? $relativePath : $this->ds);
        $base =  ($root . $this->appPublicFolder);
 
        if(empty($options["active"])){
            $options["active"] = $this->activeView;
        }
        if(empty($options["ContentType"])){
            $options["ContentType"] = "html";
        }

        /*
        Set this in other to allow back to page not mater the base 404 is triggered
        */
        if($this->activeView == "404"){
            $base =  $this->currentRequestBase;
        }
        $options["base"] = $base;
        $options["root"] = $root;
        $this->setAttributes($options);
        /*
            extract($options);
            can access key as variable
        */


        if (!defined('ALLOW_ACCESS')){
            define("ALLOW_ACCESS", true);
        }
        if (!defined('ASSETS')){
            define("ASSETS", "{$root}{$this->assetsFolder}{$this->ds}");
        }
        if (!defined('BASE_ASSETS')){
            define("BASE_ASSETS", "{$base}{$this->assetsFolder}{$this->ds}");
        }

        if (! is_file($this->templateFile)) {
            throw new PageNotFoundException($this->activeView);
        }else{
            ob_start();
            include_once $this->templateFile;
            $content = ob_get_clean();
            if($_SERVER["enable.compression"] == 1){
                switch($options["ContentType"]){
                    case "json":
                        $this->json( $content );
                    break;
                    case "text":
                        $this->text( $content );
                        break;
                    case "html": default:
                        $this->html( $content );
                    break;
                }
                $content = $this->getCompressed();
            }else{
                echo  $content;
            }
        }
        return $content;
    }

    /** 
    * Shorthand to build and Render template by including the accessible global variable within the template file.
    * @param int $depth the directory location dept
    * @param array $options additional parameters to pass in the template file
    */
    public function view($options = [], $depth = 0) {
        return $this->renderViewContent($this->getRelativePath($this->calculateDepth), $options);
        // $this->renderViewContent($this->getRelativePath($deep), $options);
    }

    /** 
    * Fixes the broken css,image & links when added additional slash(/) at the router link
    * The function will add the appropriate relative base based on how many invalid link detected.
    * @param int $depth the directory location dept from base directory index.php/fee(1) index.php/foo/bar(2)
    * @return string|path relative path 
    */
    private function getRelativePath($depth = 0) {
        $uri = $_SERVER['REQUEST_URI'];
        if (substr($uri, -1) == '/') {
            $slashCount = substr_count($uri, '/');
            if ($depth == 1 && $_SERVER['HTTP_HOST'] === 'localhost' && $slashCount === 3) {
                return './';
            }
            return str_repeat('../', $slashCount);
        } else if ($depth >= 2) {
            return str_repeat('../', $depth);
        }
        return ($depth > 0 ? '../' : './');
    }
    
}
