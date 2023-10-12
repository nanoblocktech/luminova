<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Template;
use Luminova\Exceptions\ViewNotFoundException; 
use Luminova\Exceptions\ErrorException; 
use Luminova\Exceptions\NotFoundException; 
use Luminova\Exceptions\ClassException;
use Luminova\Exceptions\InvalidObjectException; 
use Luminova\Exceptions\InvalidException; 
use Luminova\Cache\Compress;
use Luminova\Cache\Optimizer;
class Template extends Compress{ 
    /** Holds the default project template engine
     * @var static|string DEFAULT_TEMPLATE 
    */
    public const DEFAULT_TEMPLATE = ".php";

    /** Holds the project template engine for smarty
    * @var static|string SMARTY_TEMPLATE 
    */
    public const SMARTY_TEMPLATE = ".tpl";

    /** Holds the project base directory
     * @var string $baseTemplateDir __DIR__
    */
    private string $baseTemplateDir;

    /** Holds the project template filename
     * @var string $templateFile 
    */
    private string $templateFile = "404";

    /** Holds the project template directory
     * @var string $templateDir 
    */
    private string $templateDir = '';

    /** Holds the template engin file extension 
     * @var string $templateEngin 
    */
    private string $templateEngin = ".php";

    /** Holds the project template file directory path
     * @var string $templateFolder 
    */
    private string $templateFolder = "resources/views";

    /** Holds the view template optimize file directory path
     * @var string $optimizerFolder 
    */
    private string $optimizerFolder = "writeable/caches/optimize";

    /** Holds the view template optimize full file directory path
     * @var string $optimizerFile 
    */
    private string $optimizerFile = "";

    /** Holds the sub view template directory path
     * @var string $optimizerFile 
    */
    private string $subViewFolder = "";

    /** Holds template assets folder
     * @var object $assetsFolder 
    */
    public string $assetsFolder = "assets";

    /** Holds the router active page name
     * @var string $activeView 
    */
    private string $activeView = "";

    /** Holds the array attributes
     * @var array $attributesMapper 
    */
    protected array $attributesMapper = [];

    /** Holds the array classes
     * @var array $attributesMapper 
    */
    protected array $classMapper = [];

    /** Ignore view optimization
     * @var array $ignoreViewOptimizer 
    */
    protected array $ignoreViewOptimizer = [];

    /** Holds template project root
     * @var string $appPublicFolder 
    */
    private string $appPublicFolder = "";

    /**
     * Holds router param value to share across
     */
    protected mixed $paramAttributes = null;

    /**
     * Holds template html content
    */
    protected string $contents = "";
    /**
     * Holds relative file position depth 
    */
    private int $calculateDepth = 0;

    /**
     * Holds current router request base
    */
    private string $currentRequestBase = "/";

    /**
     * Holds directory separator
    */
    private string $ds = DIRECTORY_SEPARATOR;


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
        "this",
        "self"
    ];

    /** 
    * Initialize class construct
    * @param string $dir template base directory
    */
    public function __construct(string $dir =__DIR__){
        //$this->baseTemplateDir = dirname($dir);
        $this->baseTemplateDir = parent::getRootDirectory($dir);
        parent::__construct();
    }

    /** 
    * Get public class member 
    * @throws NotFoundException
    * @return mixed 
    */
    public function __get(string $propertyName): mixed {
        $property = $this->getSafeProperties($propertyName);
        if($property == null || empty($property)) {
            throw new NotFoundException("Property name: $propertyName is not found.");
        }
        return $property;
    }

    /** 
    * Get property without exception throw
    * @return mixed 
    */
    private function getSafeProperties(string $propertyName): mixed {
        if (array_key_exists($propertyName, $this->attributesMapper)) {
            return $this->attributesMapper[$propertyName];
        } elseif (array_key_exists($propertyName, $this->classMapper)) {
            return $this->classMapper[$propertyName];
        } else {
           return null;
        }
    }

    /** 
    * Set view level 
    * @param int $level level
    * @return Template $this
    */
    public function setDept(int $level): Template{
        $this->calculateDepth = $level;
        return $this;
    }

    /** 
    * Set current view base folder
    * @param string $base the base directory
    * @return Template $this
    */
    public function setBasePath(string $base): Template{
        $this->currentRequestBase = $base;
        return $this;
    }
   
    /** 
    * Get view root folder
    * @return string root
    */
    public function getRootDir(): string{
        if(empty($this->baseTemplateDir)){
            $this->baseTemplateDir = dirname(__DIR__, 2);
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
    * Set sub view folder
    * @param string $path folder name
    * @return Template $this
    */
    public function setFolder(string $path): Template{
        $this->subViewFolder =  trim( $path, "/" );
        return $this;
    }

     /** 
    * Set optimizer ignore view
    * @param array|string $path folder name
    * @throws InvalidException
    * @return Template $this
    */
    public function addIgnoreOptimizer(mixed $viewName): Template{
        if(is_array($viewName)){
            $this->ignoreViewOptimizer = $viewName;
        }else if(is_string($viewName)){
            $this->ignoreViewOptimizer[] = $viewName;
        }else{
            throw new InvalidException('Invalid argument, $viewName required (string or array), ' . gettype($viewName) . ' is given instead');
        }
        return $this;
    }

    public function setTemplateEngin(string $engin){
        $this->templateEngin = $engin;
    }

    /** 
    * render render template view
    * @param string $viewName view name
    * @return Template $this
    */
    public function render(string $viewName): Template {
        $this->templateDir = "{$this->getRootDir()}{$this->ds}{$this->templateFolder}{$this->ds}";
        //$this->templateFile = "{$this->getRootDir()}{$this->ds}{$this->templateFolder}{$this->ds}";
        $this->optimizerFile = "{$this->getRootDir()}{$this->ds}{$this->optimizerFolder}{$this->ds}";
        if($this->subViewFolder !== ''){
            $this->templateDir .= $this->subViewFolder . $this->ds;
        }
        $this->templateFile = "{$this->templateDir}{$viewName}{$this->templateEngin}";
        $this->activeView = $viewName;
        return $this;
    }

    /** 
    * redirect to template view
    * @param string $viewName view name
    * @return Template $this
    */
    public function redirect(string $viewName = ''): void {
        $to = parent::baseUrl();
        if ($viewName !== '' && $viewName !== '/') {
            $to .= '/' . $viewName;
        }
        header("Location: {$to}");
        exit();
    }

    /**
     * Register a class instance to the template.
     *
     * @param string|object $classNameOrInstance The class name or instance to register.
     * @param object|null $classInstance The class instance (optional).
     * @return Template $this
     * @throws ErrorException If there is an error during registration.
     * @throws ClassException If the class does not exist.
     * @throws InvalidObjectException If an invalid object is provided.
     */
    public function registerClass(mixed $classNameOrInstance, ?object $classInstance = null): Template {
        if (empty($classNameOrInstance)) {
            throw new ErrorException("Error: Empty class name or invalid input.");
        }

        if (is_object($classNameOrInstance)) {
            $classNameOrInstance = get_class($classNameOrInstance);
        }

        if (!is_string($classNameOrInstance) || $classNameOrInstance === false) {
            throw new ErrorException("Invalid class name: {$classNameOrInstance}. Expected a string.");
        }

        if ($classInstance === null) {
            if (class_exists($classNameOrInstance)) {
                $classInstance = new $classNameOrInstance();
            } else {
                throw new ClassException("Class not found: {$classNameOrInstance}");
            }
        } elseif (!is_object($classInstance)) {
            throw new InvalidObjectException("Invalid class instance provided.");
        }

        $this->classMapper[$classNameOrInstance] = $classInstance;
        return $this;
    }


    /** 
     * Set project application document root
     * public_html default
    * @param string $root base directory
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
     * @throws ErrorException
     */
   
    public function setAttributes(array $attributes): Template{
        if (!is_array($attributes)) {
            throw new ErrorException("Attributes must be an array");
        }
        foreach ($attributes as $name => $value) {
            if (!is_string($name)) {
                throw new ErrorException("Invalid attribute name: $name");
            }

            if (in_array($name, self::SYSTEM_VARIABLES)) {
                throw new ErrorException("Invalid attribute name: $name");
            }

            if (empty($value)) {
                throw new ErrorException("Invalid class object for attribute $name");
            }
            $this->attributesMapper["_{$name}"] = $value;
        }

        return $this;
    }

    /**
     * Attach an object to a server
     *
     * Accepts an instantiated object to use when handling requests.
     *
     * @param mixed $param
     * @return self
     * @throws InvalidObjectException|ErrorException
     */
    public function setParam(mixed $param): Template{
        if (empty($param) OR !is_object($param)) {
            throw new InvalidObjectException($param);
        }

        if (isset($this->paramAttributes)) {
            throw new ErrorException('An object has already been registered');
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
    * @param string $relativePath app relative directory path to then template file
    * @param array $options additional parameters to pass in the template file
    * @throws ViewNotFoundException
    */
    public function renderViewContent(string $relativePath, array $options = []): void {
        $root =  (parent::isProduction() ? $this->ds : $relativePath);
        $base =  rtrim($root . $this->appPublicFolder, "/") . "/";

        if(empty($options["active"])){
            $options["active"] = $this->activeView;
        }

        if(!isset($options["optimize"])){
            $options["optimize"] = true;
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

        if($this->activeView == "404"){
            //Set this in other to allow back to view not mater the base view 404 is triggered
            $base = $this->currentRequestBase;
        }

        if(empty($options["base"])){
            $options["base"] = $base;
        }

        if(empty($options["assets"])){
            $options["assets"] = "{$base}{$this->assetsFolder}/";
        }
        
        $options["root"] = $root;
        
        
        $options["baseAssets"] = "{$root}{$this->assetsFolder}/";
       /* if($this->templateEngin == self::SMARTY_ENGINE){
            $smarty = new \Smarty\Smarty();
            $smarty->setTemplateDir($this->templateDir);
           // $smarty->setCompileDir('templates_c');
           // $smarty->setConfigDir('configs');
            $smarty->setCacheDir($this->optimizerFile);

            // Set options (optional)
            $smarty->caching = parent::getVariables("enable.optimize.page");
            //$smarty->compile_check = true; 

            foreach($options as $k => $v){
                $smarty->assign($k, $v);
            }
            $smarty->display($this->activeView . '.tpl');
        }else{*/
            $this->setAttributes($options);
            /*
                can access key as variable
                extract($options);
            */

            if(isset($this->classMapper["Meta"])){
                $this->classMapper["Meta"]->setTitle($this->_title);
            }

            if (!defined('ALLOW_ACCESS')){
                define("ALLOW_ACCESS", true);
            }
        //}
       

        if (!file_exists($this->templateFile)) {
            throw new ViewNotFoundException($this->activeView);
        }
        
        $shouldSaveCache = false;
        
        if (parent::getVariables("enable.optimize.page") && $options["optimize"] && !in_array($this->activeView, $this->ignoreViewOptimizer)) {
            $optimizer = new Optimizer(600, $this->optimizerFile);
            $optimizer->setKey($this->templateFile);
            if ($optimizer->hasCache() && $optimizer->getCache()) {
                exit('<!-- File was optimized compiled on - '. $optimizer->getFileTime().', Using : Luminova Optimizer tool v1.0 -->');
            } else {
                $shouldSaveCache = true;
            }
        }
        
        ob_start();
        include_once $this->templateFile;
        $this->contents = ob_get_clean();
        
        if ($shouldSaveCache) {
            $optimizer->saveCache(parent::minifyIgnoreCodeblock($this->contents));
        }
        
        $this->displayContent($this->contents, $options["ContentType"]);
    }

    /** 
    * Display view content compress if enabled 
    * @param mixed $contents view contents
    * @param string $contentType content type
    */
    private function displayContent(mixed $contents, string $contentType): void{
        if(parent::getVariables("enable.compression") == 1){
            switch($contentType){
                case "json":
                    $this->json( $contents );
                break;
                case "text":
                    $this->text( $contents );
                    break;
                case "html": default:
                    $this->html( $contents );
                break;
            }
            $this->contents = $this->getCompressed();
        }else{
            header('X-Powered-By: Luminova');
            exit($contents);
        }
    }

    /** 
    * Shorthand to build and Render template by including the accessible global variable within the template file.
    * @param int $level the directory location dept
    * @param array $options additional parameters to pass in the template file
    */
    public function view(array $options = [], ?int $level = null): void {
        $this->calculateDepth = ( !is_null($level) ? $level : $this->calculateDepth);
        $this->renderViewContent(self::getRelativePath($this->calculateDepth), $options);
    }

    /** 
    * Fixes the broken css,image & links when added additional slash(/) at the router link
    * The function will add the appropriate relative base based on how many invalid link detected.
    * @param int $level the directory level from base directory controller/foo(1) controller/foo/bar(2)
    * @return string relative path 
    */
    private static function getRelativePath(int $level = 0): string {
        $uri = $_SERVER['REQUEST_URI'];
        if (substr($uri, -1) == '/') {
            if (!parent::isProduction() && strpos($uri, '/public/') !== false) {
                list(, $uri) = explode('/public', $uri, 2);
            }
  
            $level = substr_count($uri, '/');
            if ($level == 1 && parent::isProduction()) {
                $level = 0;
            }
        }else if($level == 0){
            if(!parent::isProduction() && strpos($uri, '/public') !== false){
                list(, $uri) = explode('/public', $uri, 2);
            }
            $level = substr_count($uri, '/');
        }

        if ($level >= 2) {
            return str_repeat('../', $level);
        }
       
        return ($level == 1 ? '../' : './');
    }

    /** 
    * Convert view name to title
    * @param string $view view name
    * @param string $suffix view title suffix
    * @return string view title
    */
    private static function toTitle(string $view, bool $suffix = false): string {
        $view = str_replace(['_', '-'], ' ', $view);
        $view = ucwords($view);
        $view = str_replace(',', '', $view);
        return ($suffix ? self::addTitleSuffix($view) : $view);
    }

    /** 
    * Add title suffix to view name title
    * @param string $title view name
    * @return string view title
    */
    private static function addTitleSuffix(string $title): string{
        $appName = parent::getVariables("app.name");
        if (strpos($title, "| {$appName}") === false) {
            $title = " {$title} | {$appName}";
        }
        return $title;
    }
    
}
