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
use Luminova\Exceptions\RuntimeException; 
use Luminova\Exceptions\ClassException;
use Luminova\Exceptions\InvalidObjectException; 
use Luminova\Exceptions\InvalidException; 
use Luminova\Cache\Compress;
use Luminova\Cache\Optimizer;
use Luminova\Template\Smarty;
use Luminova\Base\BaseConfig;
use App\Controllers\Config\Template as TemplateConfig;
use Luminova\Exceptions\AppException; 

trait Template 
{ 
    /** 
     * Holds the project base directory
     * 
     * @var string $baseTemplateDir __DIR__
    */
    private string $baseTemplateDir = '';

    /** 
     * Holds the project template filename
     * 
     * @var string $templateFile 
    */
    private string $templateFile = '';

    /**
     * Holds the project template directory
     * 
     * @var string $templateDir 
    */
    private string $templateDir = '';

    /** 
     * Holds the template engin file extension 
     * 
     * @var string $templateEngin 
    */
    private string $templateEngin = 'default';

    /** 
     * Holds the project template file directory path
     * 
     * @var string $templateFolder 
    */
    private string $templateFolder = 'resources/views';

    /** 
     * Holds the view template optimize file directory path
     * 
     * @var string $optimizerFolder 
    */
    private string $optimizerFolder = "writeable/caches/optimize";

    /** 
     * Holds the view template optimize full file directory path
     * 
     * @var string $optimizerFile 
    */
    private string $optimizerFile = '';

    /** 
     * Holds the sub view template directory path
     * 
     * @var string $optimizerFile 
    */
    private string $subViewFolder = '';

    /** 
     * Holds template assets folder
     * 
     * @var string $assetsFolder 
    */
    private string $assetsFolder = 'assets';

    /** 
     * Holds the router active page name
     * 
     * @var string $activeView 
    */
    private string $activeView = '';

    /** 
     * Holds the array attributes
     * 
     * @var array $attributes 
    */
    private array $attributes = [];

    /** 
     * Holds the array classes
     * 
     * @var array $classes 
    */
    private array $classes = [];

    /** 
     * Ignore view optimization
     * 
     * @var array $ignoreViewOptimizer 
    */
    private array $ignoreViewOptimizer = [];

    /** 
     * Holds template project root
     * 
     * @var string $appPublicFolder 
    */
    private string $appPublicFolder = '';

    /**
     * Holds template html content
     * 
     * @var string $contents 
    */
    private string $contents = '';

    /**
     * Holds relative file position depth 
     * 
     * @var int $relativeLevel 
    */
    private int $relativeLevel = 0;

    /**
     * Holds current router request base
     * 
     * @var string $currentRequestBase 
    */
    private string $currentRequestBase = '/';

    /**
     * Holds directory separator
     * 
     * @var string $ds 
    */
    private static $ds = DIRECTORY_SEPARATOR;

     /**
     * Response cache key
     * 
     * @var string|null $responseCacheKey 
    */
    private ?string $responseCacheKey = null;

    /**
     * Response cache expiry
     * 
     * @var int|null $responseCacheExpiry 
    */
    private ?int $responseCacheExpiry = null;

    /**
     * Should optimize view base
     * 
     * @var bool $optimizeBase 
    */
    private bool $optimizeBase = true;

    /**
     * Should ignore codeblock minification
     * 
     * @var bool $ignoreCodeblock 
    */
    private bool $ignoreCodeblock = false;

    /**
     * Should access options as variable
     * 
     * @var bool $optionsAsVariable 
    */
    private bool $optionsAsVariable = false;


    /** 
    * Initialize template
    *
    * @param TemplateConfig $config template config
    * @param string $dir template base directory
    *
    * @return void
    */
    public function initializeTemplate(TemplateConfig $config, string $dir =__DIR__): void
    {
        $this->baseTemplateDir = BaseConfig::root($dir);
        $this->templateEngin = $config::ENGINE;
        $this->templateFolder = $config::$templateFolder;
        $this->optimizerFolder = $config::$optimizerFolder;
        $this->assetsFolder = $config::$assetsFolder;
        $this->optionsAsVariable = $config::$optionsAsVariable;
        if (BaseConfig::usePublic()) {
            // If the document root is not changed to "public", manually enable the app to use "public" as the default
            $this->setDocumentRoot("public");
        }
    }
    

    /** 
    * Get property from $this->attributes or $this->classes
    *
    * @param string $key property name 
    *
    * @return mixed 
    */
    public function __get(string $key): mixed 
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }

        return $this->getClass($key);
    }

    /** 
    * Get registered class object $this->classes
    *
    * @param string $key object class name 
    *
    * @return object|null 
    */
    public function getClass(string $key): ?object 
    {
        if (isset($this->classes[$key])) {
            return $this->classes[$key];
        } 

        return $this->{$key} ?? null;
    }

    /** 
    * Check if class registered 
    *
    * @param string $class object class name 
    *
    * @return bool If class is registered
    */
    public function hasClass(string $class): bool 
    {
        if (isset($this->classes[$class]) && is_object($this->classes[$class])) {
            return true;
        } 

        if (isset($this->{$class}) && is_object($this->{$class})) {
            return true;
        } 

        return false;
    }

    /** 
    * Set view level 
    *
    * @param int $level level
    *
    * @return self $this
    */
    public function setLevel(int $level): self
    {
        $this->relativeLevel = $level;
        return $this;
    }

    /** 
    * Set if base template should be optimized
    *
    * @param bool $allow true or false
    *
    * @return self $this
    */
    public function setOptimizeBase(bool $allow): self 
    {
        $this->optimizeBase = $allow;
        return $this;
    }

    /** 
    * Set if compress should ignore code block minification
    *
    * @param bool $ignore true or false
    *
    * @return self $this
    */
    public function setCompressIgnoreCodeblock(bool $ignore): self 
    {
        $this->ignoreCodeblock = $ignore;
        return $this;
    }

    /** 
    * Set current view base folder
    *
    * @param string $base the base directory
    *
    * @return self $this
    */
    public function setBasePath(string $base): self
    {
        $this->currentRequestBase = $base;
        return $this;
    }
   
    /** 
    * Get view root folder
    *
    * @return string root
    */
    public function getRootDir(): string
    {
        if(empty($this->baseTemplateDir)){
            $this->baseTemplateDir = dirname(__DIR__, 2);
        }
        return $this->baseTemplateDir;
    }
    
    /** 
    * Set the template directory path
    *
    * @param string $path the file path directory
    *
    * @return self $this
    */
    public function setTemplatePath(string $path): self
    {
        $this->templateFolder = trim( $path, "/" );
        return $this;
    }

    /** 
    * Set template engine 
    *
    * @param string $engin template engine name
    *
    * @return self $this
    */
    public function setTemplateEngin(string $engin): self
    {
        $this->templateEngin = $engin;
        return $this;
    }

    /** 
    * Get template engine 
    *
    * @return string $$engin template extension
    */
    private function getTemplateEngin(): string
    {
        $engin = $this->templateEngin === 'smarty' ? '.tpl' : '.php';

        return $engin;
    }

    /** 
    * Set sub view folder
    *
    * @param string $path folder name
    *
    * @return self $this
    */
    public function setFolder(string $path): self
    {
        $this->subViewFolder =  trim( $path, "/" );
        return $this;
    }

    /** 
    * Set optimizer ignore view
    *
    * @param array|string $viewName view name
    *
    * @throws InvalidException
    * @return self $this
    */
    public function addIgnoreOptimizer(array|string $viewName): self
    {
        if(is_array($viewName)){
            $this->ignoreViewOptimizer = $viewName;
        }else if(is_string($viewName)){
            $this->ignoreViewOptimizer[] = $viewName;
        }else{
            throw new InvalidException('Invalid argument, $viewName required (string or array), ' . gettype($viewName) . ' is given instead');
        }
        
        return $this;
    }

    /** 
    * render render template view
    *
    * @param string $viewName view name
    *
    * @return self $this
    */
    public function render(string $viewName): self 
    {
        $this->templateDir = $this->getBaseViewFolder();
        $this->optimizerFile = $this->getBaseOptimizerFolder();
        if($this->subViewFolder !== ''){
            $this->templateDir .= $this->subViewFolder . self::$ds;
        }
        $this->templateFile = "{$this->templateDir}{$viewName}{$this->getTemplateEngin()}";
        $this->activeView = $viewName;

        return $this;
    }

    /** 
    * redirect to template view
    *
    * @param string $viewName view name
    *
    * @return void
    */
    public function redirect(string $viewName = ''): void 
    {
        $to = BaseConfig::baseUrl();
        if ($viewName !== '' && $viewName !== '/') {
            $to .= '/' . $viewName;
        }
        header("Location: {$to}");
        exit();
    }

    /** 
    * redirect to url view
    *
    * @param string $url view name
    *
    * @return void 
    */
    public function redirectTo(string $url): void 
    {
        header("Location: $url", true, 302);
        exit();
    }    

    /** 
    * Set project application document root
    * public_html default
    *
    * @param string $root base directory
    *
    * @return self $this
    */
    public function setDocumentRoot(string $root): self 
    {
        $this->appPublicFolder = $root;
        return $this;
    }

    /**
     * Register a class instance to the template.
     *
     * @param string|object $classNameOrInstance The class name or instance to register.
     * @param object|null $classInstance The class instance (optional).
     * @return self $this
     * 
     * @throws RuntimeException If there is an error during registration.
     * @throws ClassException If the class does not exist.
     * @throws InvalidObjectException If an invalid object is provided.
    */
    public function registerClass(string|object $classNameOrInstance, ?object $classInstance = null): self 
    {
        if (empty($classNameOrInstance)) {
            throw new RuntimeException("Error: Empty class name or invalid input.");
        }

        if (is_object($classNameOrInstance)) {
            $classNameOrInstance = get_class($classNameOrInstance);
        }

        if (!is_string($classNameOrInstance) || $classNameOrInstance === '') {
            throw new RuntimeException("Invalid class name: '{$classNameOrInstance}'. Expected a non-empty string.");
        }

        if ($classInstance === null) {
            if (class_exists($classNameOrInstance)) {
                $classInstance = new $classNameOrInstance();
            } else {
                throw new ClassException("Class not found: '{$classNameOrInstance}'");
            }
        } elseif (!is_object($classInstance)) {
            throw new InvalidObjectException("Invalid class instance provided.");
        }

        $this->classes[$classNameOrInstance] = $classInstance;
        
        return $this;
    }

    /**
     * Sets project template options.
     * 
     * @param  array $attributes
     * 
     * @return self
     * @throws RuntimeException If there is an error setting the attributes.
    */
    public function setAttributes(array $attributes): self
    {
        if (!is_array($attributes)) {
            throw new RuntimeException("Invalid attributes: '{$attributes}'. Expected an array.");
        }

        foreach ($attributes as $name => $value) {
            if (empty($name) || !is_string($name)) {
                throw new RuntimeException("Invalid attribute name: '{$name}'. Attribute names must be non-empty strings.");
            }

            $this->attributes["_{$name}"] = $value;
        }

        return $this;
    }

    /** 
     * Get view contents 
     * 
     * @return mixed
    */
    public function getContents(): mixed
    {
        return $this->contents;
    }

    /** 
    * Get base view file directory
    *
    * @return string path
    */
    private function getBaseViewFolder(): string 
    {
        return "{$this->getRootDir()}" . self::$ds . "{$this->templateFolder}" . self::$ds;
    }

    /** 
    * Get error file from directory
    *
    * @param string $filename file name
    *
    * @return string path
    */
    private function getBaseErrorViewFolder(string $filename): string 
    {
        return $this->getBaseViewFolder() . "system_errors" . self::$ds . "{$filename}.php";
    }

    /** 
    * Get optimizer file directory
    *
    * @return string path
    */
    private function getBaseOptimizerFolder(): string
    {
        return "{$this->getRootDir()}" . self::$ds . "{$this->optimizerFolder}" . self::$ds;
    }

    /** 
     * Cache response use before respond() method
     * 
     * @param string $cacheKey Cache key
     * @param int|null $expire Cache expiration
     * 
     * @return self $this
    */
    public function cache(string $cacheKey, ?int $expiry = null): self 
    {
        $this->responseCacheKey = $cacheKey;
        $this->responseCacheExpiry = $expiry ?? BaseConfig::get("page.optimize.expiry");
        return $this;
    }

    /** 
     * Cache response
     * 
     * @param mixed $content Cache key
     * @param string $type Cache type [json, html, xml, text]
     * 
     * @return void
    */
    public function respond(mixed $content, string $type): void 
    {
        $shouldSaveCache = false;
        $optimizer = null;
        $result = $content;
        $saveContent = $content;
        $saveInfo = [];
        // Set the project script execution time
        set_time_limit(BaseConfig::getInt("script.execution.limit", 90));
        // Set cache control for application cache
        ignore_user_abort(BaseConfig::getBoolean('script.ignore.abort', true));
        // Set output handler
        ob_start(BaseConfig::getMixedNull('script.ob.handler', null));

        if ($this->responseCacheKey !== null) {
            $shouldSaveCache = true;
            $optimizerFile = $this->getBaseOptimizerFolder();;
            $optimizer = new Optimizer($this->responseCacheExpiry, $optimizerFile);
            $optimizer->setKey($this->responseCacheKey);
            if ($optimizer->hasCache() && $optimizer->getCache()) {
                $this->responseCacheKey = null;
                $this->responseCacheExpiry = null;
                exit(0);
            }
        }

        if(BaseConfig::getBoolean("enable.compression")){
            $compress = $this->renderWithMinification($content, $type);
            $result = 0;
            $saveContent = $compress->getMinified();
            $saveInfo = $compress->getInfo();
        }

        if ($shouldSaveCache && $optimizer !== null && $saveContent != null) {
            $optimizer->saveCache($saveContent, null, $saveInfo);
        }

        $this->responseCacheKey = null;
        $this->responseCacheExpiry = null;
        exit($result);
    }

    /** 
    * Creates and Render template by including the accessible global variable within the template file.
    *
    * @param array $options additional parameters to pass in the template file
    *
    * @return void
    * @throws ViewNotFoundException
    */
    private function renderViewContent(array $options = []): void 
    {
        
        $shouldSaveCache = false;
        $optimizer = null;
        if (!defined('ALLOW_ACCESS')){
            define("ALLOW_ACCESS", true);
        }
  
        try {
            if (!file_exists($this->templateFile)) {
                throw new ViewNotFoundException($this->activeView);
            }

            // Set the project script execution time
            set_time_limit(BaseConfig::getInt("script.execution.limit", 90));
            // Set cache control for application cache
            ignore_user_abort(BaseConfig::getBoolean('script.ignore.abort', true));
            // Set output handler
            ob_start(BaseConfig::getMixedNull('script.ob.handler', null));
            
            if($this->templateEngin === 'smarty'){
                $smarty = new Smarty($this->getRootDir());
                $smarty->setDirectories(
                    $this->templateDir, 
                    TemplateConfig::$smartyCompileFolder,
                    TemplateConfig::$smartyConfigFolder,
                    TemplateConfig::$smartyCacheFolder
                );
                $smarty->assignOptions($options);
                $smarty->caching($this->shouldOptimize());
                $smarty->display($this->activeView . $this->getTemplateEngin());
                exit(0);
            }else{
                if($this->optionsAsVariable){
                    // can access options as variable
                    extract($options);
                }else{
                    $this->setAttributes($options);
                }
            }

            /**
             * Check If The Application Is Under Maintenance
             * 
             * If the application is in maintenance load maintenance and exit immediately
             * instead of starting the framework, which could cause an exception.
            */
            if(BaseConfig::isMaintenance()){
                $maintenanceView = $this->getBaseErrorViewFolder('maintenance');
                include_once $maintenanceView;
                exit(0);
            }

            if ($this->shouldOptimize()) {
                $shouldSaveCache = true;
                $optimizer = new Optimizer(BaseConfig::get("page.optimize.expiry"), $this->optimizerFile);
                $optimizer->setKey($this->getTemplateBaseUri());
                if ($optimizer->hasCache() && $optimizer->getCache()) {
                    exit(0);
                }
            }

            if($this->hasClass('Meta')){
                $this->getClass('Meta')?->setTitle($options['title'] ?? '');
            }
           
            include_once $this->templateFile;
            $viewContents = ob_get_clean();
            if(BaseConfig::getBoolean("enable.compression")){
                $contentType = $options["ContentType"] ?? 'html';
                $this->displayCompressedContent($viewContents, $optimizer, $contentType, $shouldSaveCache);
            }else{
                
                if ($shouldSaveCache && $optimizer !== null) {
                    $optimizer->saveCache($viewContents, BaseConfig::copyright(), $this->requestHeaders());
                }
                exit($viewContents);
            }
            exit(0);
        } catch (AppException $e) {
            $this->handleException($e, $options);
        }
    }

    /** 
    * Display view content compress if enabled 
    *
    * @param mixed $contents view contents
    * @param Optimizer $optimizer optimizer 
    * @param string $type content type
    * @param bool $save 
    *
    * @return void 
    */
    private function displayCompressedContent(mixed $contents, ?Optimizer $optimizer = null, string $type = 'html', bool $save = false): void
    {
        $compress = $this->renderWithMinification($contents, $type);
 
        if ($save && $optimizer !== null) {
            $optimizer->saveCache($compress->getMinified(), BaseConfig::copyright(), $compress->getInfo());
        }
    }

    /** 
    * Render minification
    *
    * @param mixed $contents view contents
    * @param string $type content type
    *
    * @return Compress 
    */
    private function renderWithMinification(mixed $contents, string $type = 'html'): Compress 
    {
        $compress = new Compress();
        // Set cache control for application cache
        $compress->setCacheControl(BaseConfig::getBoolean("cache.control"));

        // Set response compression level
        $compress->setCompressionLevel(BaseConfig::getInt("compression.level", 6));
        $compress->setIgnoreCodeblock($this->ignoreCodeblock);
       
        switch($type){
            case "json":
                $compress->json( $contents );
            break;
            case "text":
                $compress->text( $contents );
            break;
            case "html": 
                $compress->html( $contents );
            break;
            case "xml": 
                $compress->xml( $contents );
            break;
            default:
                $compress->run($contents, $type);
            break;
        }

        return $compress;
    }

    /** 
    * Get output headers
    * 
    * @return array $info
    */
    private function requestHeaders(): array
    {
        $responseHeaders = headers_list();
        $info = [];

        foreach ($responseHeaders as $header) {
            // Check for Content-Type header
            if (strpos($header, 'Content-Type:') === 0) {
                $info['Content-Type'] = trim(str_replace('Content-Type:', '', $header));
            }

            // Check for Content-Length header
            if (strpos($header, 'Content-Length:') === 0) {
                $info['Content-Length'] = (int) trim(str_replace('Content-Length:', '', $header));
            }

            // Check for Content-Encoding header
            if (strpos($header, 'Content-Encoding:') === 0) {
                $info['Content-Encoding'] = trim(str_replace('Content-Encoding:', '', $header));
            }
        }

        return $info;
    }

    /** 
    * Calls after render() to display your template view and
    * Include any accessible global variable within the template file.
    *
    * @param array $options additional parameters to pass in the template file $this->_myOption
    * @param int $level Optional directory relative level to fix your file location
    * 
    * @return void
    * @throws InvalidException
    */
    public function view(array $options = [], int $level = 0): void 
    {
        $level =  (int) ( $level > 0 ? $level : $this->relativeLevel);
        $relative = $this->calculateLevel($level);
        $path = (BaseConfig::isProduction() ? self::$ds : $relative);
        $base = rtrim($path . $this->appPublicFolder, "/") . "/";


        if(!isset($options["active"])){
            $options["active"] = $this->activeView;
        }

        if(isset($options["optimize"])){
            if($options["optimize"]){
                if(isset($options["ContentType"])){
                    $contentType = strtolower($options["ContentType"]);
                    if(!in_array($contentType, ['html', 'json', 'text', 'xml'])){
                        throw new InvalidException('Invalid argument, $options["ContentType"] required (html, json, text or xml), ' . gettype($contentType) . ' is given instead');
                    }
                }else{
                    $options["ContentType"] = "html";
                }
            }else{
                $this->ignoreViewOptimizer[] = $this->activeView;
            }
        }

        if(!isset($options["title"])){
            $options["title"] = self::toTitle($options["active"], true);
        }

        if(!isset($options["subtitle"])){
            $options["subtitle"] = self::toTitle($options["active"]);
        }

        if($this->activeView === '404'){
            //Set this in other to allow back to view not mater the base view 404 is triggered
            $base = $this->currentRequestBase;
        }

        if(!isset($options["base"])){
            $options["base"] = $base;
        }

        if(!isset($options["assets"])){
            $options["assets"] = "{$base}{$this->assetsFolder}/";
        }
        
        //$options["root"] = $path;
       // $options["rootAssets"] = "{$path}{$this->assetsFolder}/";

        $this->renderViewContent($options);
    }

    /** 
    * Check if view should be optimized or not
    *
    * @return bool 
    */
    private function shouldOptimize(): bool 
    {
        return $this->optimizeBase && BaseConfig::getBoolean("enable.optimize.page") && !in_array($this->activeView, $this->ignoreViewOptimizer);
    }

    /** 
    * Fixes the broken css,image & links when added additional slash(/) at the router link
    * The function will add the appropriate relative base based on how many invalid link detected.
    *
    * @param int $level the directory level from base directory controller/foo(1) controller/foo/bar(2)
    *
    * @return string relative path 
    */
    private function calculateLevel(int $level = 0): string 
    {
        if($level === 0){
            $uri = $this->getTemplateBaseUri();
           

            if (!BaseConfig::isProduction() && strpos($uri, '/public') !== false) {
                [, $uri] = explode('/public', $uri, 2);
            }

            $level = substr_count($uri, '/');

            if ($level == 1 && BaseConfig::isProduction()) {
                $level = 0;
            }
        }

        return str_repeat(($level >= 2 ? '../' : ($level == 1 ? '../' : './')), $level);
    }


    /** 
    * Get template base view segments
    *
    * @return string template view segments
    */
    private function getTemplateBaseUri(): string
    {
        $url = '';
        if(isset($_SERVER['REQUEST_URI'])){
            $base = '';
            if (isset($_SERVER['SCRIPT_NAME'])) {
                $base = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
            }
            $url = substr(rawurldecode($_SERVER['REQUEST_URI']), mb_strlen($base));
            if (strstr($url, '?')) {
                $url = substr($url, 0, strpos($url, '?'));
            }
        }
        return '/' . trim($url, '/');
    }

    /** 
    * Handle exceptions
    *
    * @param AppException $exception
    * @param array $options view options
    *
    * @return void 
    */
    private function handleException(AppException $exception, array $options): void 
    {
        /*if ($exception instanceof ViewNotFoundException) {
            // Handle file not found exception
            Log::error("Template file '$templateName' not found");
        } elseif ($exception instanceof NotFoundException) {
            // Handle issues with the rendering process
            Log::error("Issue rendering template: $templateName");
            $this->cache->clear($templateName); // Clear the cache
        } elseif ($exception instanceof ErrorException) {
            // Handle issues with the rendering process
            Log::error("Issue rendering template: $templateName");
            $this->cache->clear($templateName); // Clear the cache
        } elseif ($exception instanceof ClassException) {
            // Handle issues with the rendering process
            Log::error("Issue rendering template: $templateName");
            $this->cache->clear($templateName); // Clear the cache
        } elseif ($exception instanceof InvalidObjectException) {
            // Handle issues with the rendering process
            Log::error("Issue rendering template: $templateName");
            $this->cache->clear($templateName); // Clear the cache
        } elseif ($exception instanceof InvalidException) {
            // Handle issues with the rendering process
            Log::error("Issue rendering template: $templateName");
            $this->cache->clear($templateName); // Clear the cache
        } else {
            // A general catch-all for any other exceptions
            Log::error("Unhandled exception in template: $templateName");
        }*/

        $exceptionView = $this->getBaseErrorViewFolder('exceptions');

        include_once $exceptionView;

        $exception->logException();
    }
    

    /** 
    * Convert view name to title
    *
    * @param string $view view name
    * @param string $suffix view title suffix
    *
    * @return string view title
    */
    private static function toTitle(string $view, bool $suffix = false): string 
    {
        $view = str_replace(['_', '-'], ' ', $view);
        $view = ucwords($view);
        $view = str_replace(',', '', $view);
        return ($suffix ? self::addTitleSuffix($view) : trim($view));
    }

    /** 
    * Add title suffix to view name title
    *
    * @param string $title view name
    *
    * @return string view title
    */
    private static function addTitleSuffix(string $title): string
    {
        $appName = BaseConfig::get("app.name");
        if (strpos($title, "| {$appName}") === false) {
            $title = " {$title} | {$appName}";
        }

        return trim($title);
    }
    
}