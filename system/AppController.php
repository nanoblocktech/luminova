<?php 
namespace Luminova;
use \Luminova\Router;
use \Luminova\Template;
use \Luminova\Functions;
use \Luminova\Config\DotEnv;
use \Luminova\Config\ConfigManager;
use \Luminova\SessionManager\Session;

class AppController extends Template {
    private static $instance = null;
    /*
    * Router $router
    * @var object Router
    */
    private $router;

    public function __construct($dir = __DIR__, $debug = false){
        /*
        Register dotenv variables
        */
        DotEnv::register($this->getDir() . DIRECTORY_SEPARATOR . '.env');

        /*
        Add default classes to application
        */
        $this->addClass("session", new Session(Session::LIVE));
        $this->addClass("func", new Functions());
        $this->addClass("config", new ConfigManager());

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
        $this->setDocumentRoot("../public");

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
        Initialize global error handler
        */
        $this->router->setErrorHandler(function() {
            exit($this->render("404")->view());
        });
    }

	public function getHostname(){
        return $_SERVER['SERVER_NAME'];
    }
	public function isLocal(){
		return ($this->getHostname() == "localhost");
	}

	/*public function getAssets(){
		return "https:" . ($this->isLocal() ? "//localhost/" : "//") . self::HOSTNAME . "/{$this->assetsFolder}/";
	}*/

    public function getAssets(){
		return ($this->isLocal() ? $this->getBasePath() : "/") . "{$this->assetsFolder}/";
	}

	public function useMinify($type){
		return (!$this->isLocal() ? ".min." : ".") . "{$type}?version=" . $_SERVER['file.version'];
	}

	public function addJsFile($from){
		return  $this->getAssets() . "js/{$from}" . $this->useMinify("js");
	}

	public function addCssFile($from){
		return  $this->getAssets() . "css/{$from}" . $this->useMinify("css");
	}

    public function getCurrentUri(){
        return $this->router->getCurrentUri();
    }
    public function getBasePath(){
        return $this->router->getBasePath();
    }

    public static function getInstance($dir = __DIR__, $debug = false) {
        if (self::$instance === null) {
            self::$instance = new self($dir, $name);
        }
        return self::$instance;
    }

    public function getRouter() : Router {
        return $this->router;
    }
    
}