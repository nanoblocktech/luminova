<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Sessions;
use Luminova\Sessions\SessionInterface;
use Luminova\Exceptions\ErrorException;
use App\Controllers\Config\SessionConfig;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
class Session 
{
    use LoggerAwareTrait;
    protected $manager;
    protected static $instance;
    protected SessionConfig $config;

    public function __construct(SessionInterface $manager)
    {
        $this->config = new SessionConfig();
        $this->manager = $manager;
    }

   /**
     * Set the logger for this session.
     *
     * @param LoggerInterface $logger The logger to set.
    */
    public function setLoggerInterface(LoggerInterface $logger): void
    {
        $this->setLogger($logger);
    }

    /**
     * Magic method to retrieve session properties.
     *
     * @param string $propertyName The name of the property to retrieve.
     * @return mixed
     * @throws ErrorException If the property does not exist.
     */
    public function __get(string $propertyName): mixed
    {
        $data = $this->manager->__toArray($propertyName);
        if (empty($data)) {
            throw new ErrorException("Invalid property name: $propertyName is not found.");
        } 
        return $data;
    }

    /**
     * Get an instance of the Session class.
     *
     * @param SessionInterface $manager The session manager.
     * @return self
     */
    public static function getInstance(SessionInterface $manager): self
    {
        if (self::$instance === null) {
            self::$instance = new self($manager);
        }
        return self::$instance;
    }

    /**
     * Set the session manager.
     *
     * @param SessionInterface $manager The session manager to set.
     */
    public function setManager(SessionInterface $manager): void
    {
        $this->manager = $manager;
    }

   /**
     * Set the storage key for the session.
     *
     * @param string $storage The storage key to set.
     */
    public function setStorage(string $storage): void
    {
        $this->manager->setStorage($storage);
    }

    /**
     * Get the value from the session by key.
     *
     * @param string $key The key to retrieve.
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $this->manager->get($key);
    }

    /**
     * Set the value in the session by key.
     *
     * @param string $key The key to set.
     * @param mixed $value The value to set.
     * @return self
     */
    public function set(string $key, $value): self
    {
        $this->manager->set($key, $value);
        return $this;
    }

    /**
     * Add a value to the session by key.
     *
     * @param string $key The key to set.
     * @param mixed $value The value to set.
     * @return self
     */
    public function add(string $key, $value): self
    {
        $this->manager->add($key, $value);
        return $this;
    }

   /**
     * Remove a value from the session by key.
     *
     * @param string $key The key to remove.
     * @return self
     */
    public function remove(string $key): self
    {
        $this->manager->remove($key);
        return $this;
    }

    /**
     * Clear the session storage.
     *
     * @param string $storage The storage key to clear.
     * @return self
     */
    public function clear(string $storage = ''): self
    {
        $this->manager->clear($storage);
        return $this;
    }

     /**
    * Initialize and start session manager.
    *
    * @param string $path The path for the session.
    * @return void
    */
    public function start(): void
    {
        if ((bool) ini_get('session.auto_start')) {
            if ($this->logger) {
                $this->logger->error('Session: session.auto_start is enabled in php.ini. Aborting.');
            }
            return;
        }

        if (session_status() === PHP_SESSION_ACTIVE) {
            if ($this->logger) {
                $this->logger->warning('Session: Sessions is enabled, and one exists. Please don\'t $session->start();');
            }
            return;
        }
        
        if (session_status() === PHP_SESSION_NONE) {
            //session_set_cookie_params(365 * 24 * 60 * 60, $path, ".{$_SERVER['SERVER_NAME']}", true, false);
            $this->sessionConfigure();
            session_start();
        }
    }

    /**
    * Configure session settings.
    *
    * @return void
    */
    protected function sessionConfigure()
    {
      
        $sameSite = "Lax";
        $params = [
            'lifetime' => $this->config->expiration,
            'path'     => $this->config->sessionPath,
            'domain'   => ".{$_SERVER['SERVER_NAME']}",
            'secure'   => true,
            'httponly' => true,
            'samesite' => $sameSite,
        ];

        ini_set('session.name', $this->config->cookieName);
        ini_set('session.cookie_samesite', $sameSite);
        session_set_cookie_params($params);

        if ($this->config->expiration > 0) {
            ini_set('session.gc_maxlifetime', (string) $this->config->expiration);
        }

        if (! empty($this->config->savePath)) {
            ini_set('session.save_path', $this->config->savePath);
        }

        ini_set('session.use_trans_sid', '0');
        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_cookies', '1');
        ini_set('session.use_only_cookies', '1');
    }
}