<?php 
namespace Luminova;
use \Luminova\Router;
use \Luminova\Template;
use \App\Controllers\Func;
use \App\Controllers\Config;
//use \Luminova\Functions;
use \Luminova\Config\DotEnv;
//use \Luminova\Config\ConfigManager;
use \Luminova\Sessions\Session;
use \Luminova\Security\CsrfToken;
use \Luminova\Seo\MetaObjectGraph;  

class AppController extends Template {
    public const SESSION = "session";
    public const FUNC = "func";
    public const CONFIG = "config";
    public const CRSF = "csrf";
    public const META = "meta";
    private static $instance = null;
    /*
    * Router $router
    * @var object Router
    */
    private $router;

    public function __construct(string $dir = __DIR__, bool $debug = false){
        // Initialize the session manager
        Session::initializeSessionManager();
        /*
        Register dotenv variables
        */
        DotEnv::register($this->getDir() . DIRECTORY_SEPARATOR . '.env');

        /*
        Add default classes to application
        */
        $this->registerClass(self::SESSION, new Session(Session::LIVE));
        $this->registerClass(self::FUNC, new Func());
        $this->registerClass(self::CONFIG, new Config());
        $this->registerClass(self::CRSF, new CsrfToken());
        $this->registerClass(self::META, new MetaObjectGraph($this));
        //$this->registerClass(CsrfToken::class);
       
        
        /*
        Initialize router instance
        */
        $this->router = new Router();
        $this->router->setNamespace('\App\Controllers');
        
        /*
        Initialize template Engin 
        */
        parent::__construct($dir, $debug);
        /*
        * If document root is not changed to public
        * Then manually enable app to use public as default
        */
        if($this->isLocal()){
            $this->setDocumentRoot("public");
        }
        /*
        Set cache control for application cache
        */
        $this->setCacheControl($_SERVER["cache.control"]);

        /*
        * Set the current dept for template url relative paths
        */
        $this->setDept( substr_count(trim($this->getCurrentUri(), DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR) );

        /*
        * Set the project base path
        */
        $this->setBasePath( $this->getBasePath() );

        /*
        * Set the canonical url
        Uncomment to use www canonical version
        $this->meta->setCanonical($this->config::base_www_url() . $this->router->getCurrentUri());
        */
        $this->meta->setCanonical($this->config::baseUrl() . $this->router->getCurrentUri());

        /*
        Initialize global error handler
        */
        $this->router->setErrorHandler(function() {
            exit($this->render("404")->view(["error_url" => $this->config::baseUrl() . $this->router->getCurrentUri()]));
        });
    }

	public function getHostname(): string
    {
        return $_SERVER['SERVER_NAME'];
    }

	public function isLocal(): bool
    {
		return ($this->getHostname() === "localhost");
	}

	/*public function getAssets(){
		return "https:" . ($this->isLocal() ? "//localhost/" : "//") . self::HOSTNAME . "/{$this->assetsFolder}/";
	}*/

    public function getAssets(): string
    {
		return ($this->isLocal() ? $this->getBasePath() : "/") . "{$this->assetsFolder}/";
	}

	public function useMinify(string $type): string
    {
		return (!$this->isLocal() ? ".min." : ".") . "{$type}?version=" . $_SERVER['file.version'];
	}

	public function addJsFile(string $from): string
    {
		return  $this->getAssets() . "js/{$from}" . $this->useMinify("js");
	}

	public function addCssFile(string $from): string
    {
		return  $this->getAssets() . "css/{$from}" . $this->useMinify("css");
	}

    public function getCurrentUri(): string
    {
        return $this->router->getCurrentUri();
    }
    public function getBasePath(): string{
        return $this->router->getBasePath();
    }

    public static function getInstance(string $dir = __DIR__, bool $debug = false): AppController 
    {
        if (self::$instance === null) {
            self::$instance = new self($dir, $name);
        }
        return self::$instance;
    }

    public function getRouterInstance(): Router 
    {
        return $this->router;
    }

    public function readManifest(): object
    {
        $jsonString = file_get_contents($this->getDir() . DIRECTORY_SEPARATOR . 'meta.config.json');
        $config = json_decode($jsonString);

        if ($config === null) {
            return (object)[];
        }
        return $config;
    }
    
}