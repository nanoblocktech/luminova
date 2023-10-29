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
use App\Controllers\Config\Session as SessionConfig;
use Luminova\Logger\LoggerInterface;
class Session 
{
    /**
     * @var SessionInterface $manager session interface
    */
    protected SessionInterface $manager;

    /**
     * @var LoggerInterface $logger logger interface
    */
    protected LoggerInterface $logger;

    /**
     * @var static $instance static class instance
    */
    protected static $instance;

    /**
     * @var SessionConfig $config session config instance
    */
    protected SessionConfig $config;

    /**
     * Initializes session constructor
     *
     * @param SessionInterface $manager The session manager.
    */
    public function __construct(SessionInterface $manager)
    {
        $this->config = new SessionConfig();
        $this->manager = $manager;
    }

    /**
     * Get an instance of the Session class.
     *
     * @param SessionInterface $manager The session manager.
     * @return static self instance
    */
    public static function getInstance(SessionInterface $manager): static
    {
        if (static::$instance === null) {
            static::$instance = new static($manager);
        }
        return static::$instance;
    }

    /*
    public static function getInstance(SessionInterface $manager): self
    {
        if (self::$instance === null) {
            self::$instance = new self($manager);
        }
        return self::$instance;
    }*/

   /**
     * Set the logger for this session.
     *
     * @param LoggerInterface $logger The logger to set.
    */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /** 
     * Get data as array from current session storage 
     * @param string $index optional key to get
     * @return array
    */
    public function toArray(string $index = ''): array
    {
        return $this->manager->toArray($index);
    }

    /** 
     * Get data as object from current session storage
     * @param string $index optional key to get
     * @return object
    */
    public function toObject(string $index = ''): object
    {
        return $this->manager->toObject($index);
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
    public function setStorage(string $storage): self
    {
        $this->manager->setStorage($storage);
        return $this;
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
     * Get data from specified storage instance
     * @param string $index value key to get
     * @param string $storage Storage key name
     * @return mixed
    */
    public function getFrom(string $index, string $storage): mixed
    {
        return $this->manager->getFrom($index, $storage);
    }

    /** 
     * Get data from specified storage instance
     * @param string $index value key to get
     * @param mixed $data data to set
     * @param string $storage Storage key name
     * @return self
    */
    public function setTo(string $index, mixed $data, string $storage): self
    {
        $this->manager->setTo($index, $data, $storage);
        return $this;
    }

    /** 
     * Check if session user is online from any storage instance
     * @param string $storage optional storage instance key
     * @return bool
    */
    public function online(string $storage = ''): bool
    {
        return $this->manager->online($storage);
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
            $this->sessionConfigure();
            session_start();
        }
    }

    /**
     * Start an online session with an optional IP address.
     *
     * @param string $ip The IP address.
     * @return self
     */
    public function goOnline(string $ip = ''): self
    {
        $this->manager->set("_online", "YES");
        if($ip !== ''){
            $this->manager->set("_online_session_id", $ip);
        }
        return $this;
    }

    /**
    * Configure session settings.
    *
    * @return void
    */
    protected function sessionConfigure(): void
    {
        $cookieParams = [
            'lifetime' => $this->config->expiration,
            'path'     => $this->config->sessionPath,
            'domain'   => $this->config->sessionDomain,
            'secure'   => true,
            'httponly' => true,
            'samesite' => $this->config->sameSite,
        ];
        ini_set('session.name', $this->config->cookieName);
        ini_set('session.cookie_samesite', $this->config->sameSite);
        session_set_cookie_params($cookieParams);

        if ($this->config->expiration > 0) {
            ini_set('session.gc_maxlifetime', (string) $this->config->expiration);
        }

        if (!empty($this->config->savePath)) {
            ini_set('session.save_path', $this->config->savePath);
        }

        ini_set('session.use_trans_sid', '0');
        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_cookies', '1');
        ini_set('session.use_only_cookies', '1');
    }
}