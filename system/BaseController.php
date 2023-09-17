<?php 
namespace Luminova;

use \App\Controllers\Func;
use \App\Controllers\Config;
use \Luminova\Router\Router;
use \Luminova\Config\DotEnv;
use \Luminova\Sessions\Session;
use \Luminova\Security\Csrf;
use \Luminova\Template\Template;
use \Luminova\Seo\Meta;  

class BaseController extends Template {

    private static $instance = null;
    /*
    * Router $router
    * @var object Router
    */
    private $router;

    public function __construct(string $dir = __DIR__){
        // Initialize the session manager
        Session::initializeSessionManager();
        /*
        Register dotenv variables
        */
        DotEnv::register($this->getRootDir() . DIRECTORY_SEPARATOR . '.env');

        /*
        Add default classes to application
        */
        $this->registerClass("session", new Session(Session::LIVE));
        $this->registerClass("func", new Func());
        $this->registerClass("config", new Config());
        $this->registerClass("csrf", new Csrf());
        $this->registerClass("meta", new Meta($this));
        //$this->registerClass(Csrf::class);
        //$this->registerClass(Csrf::class, new Csrf());
       
        
        /*
        Initialize router instance
        */
        $this->router = new Router();


        $this->router->setNamespace('\App\Controllers');
        
        /*
        Initialize template Engin 
        */
        parent::__construct($dir);
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
        $this->setCacheControl(parent::getVariables("cache.control"));

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

    public function getAssets(): string
    {
		return ($this->isLocal() ? $this->getBasePath() : "/") . "{$this->assetsFolder}/";
	}

	public function useMinify(string $type): string
    {
		return (!$this->isLocal() ? ".min." : ".") . "{$type}?version=" . parent::getVariables("file.version");
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

    public static function getInstance(string $dir = __DIR__, bool $debug = false): BaseController 
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
        $jsonString = file_get_contents($this->getRootDir() . DIRECTORY_SEPARATOR . 'meta.config.json');
        $config = json_decode($jsonString);

        if ($config === null) {
            return (object)[];
        }
        return $config;
    }
    
}