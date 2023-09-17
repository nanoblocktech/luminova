<?php 
namespace Luminova\Sessions;
class Session {
    public const GUEST = "_system_application_guest_";
    public const LIVE = "_system_application_live_";
    protected $key;
    protected $conn;
    protected static $instance;
    public function __construct(string $key) 
    {
        $this->key = $key;
    }

    public static function getInstance(string $key): Session
    {
        if (self::$instance === null) {
            self::$instance = new self($key);
        }
        return self::$instance;
    }
  
    public function add(string $key, mixed $value): Session
    {
        $_SESSION[$this->key][$key] = $value;
        return $this;
    }
    public function userAdd(string $index, mixed $value): Session
    {
        $_SESSION[$this->key]["user_session_profile"][$index] = $value;
        return $this;
    }

    public function set(string $key, mixed $value): Session
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    public function get(string $index): mixed
    {
        return $_SESSION[$this->key][$index]??null;
    }

    public function userGet(string $index): mixed 
    {
        return ($this->user()[$index]??null);
    }

    public function getFrom(string $index, string $key = self::GUEST): mixed
    {
        return $_SESSION[$key][$index]??null;
    }

    public function user(): array{
        return $_SESSION[$this->key]["user_session_profile"]??[];
    }

    public function unset(string $key): Session
    {
        unset($_SESSION[$key]);
        return $this;
    }

    public function remove(string $index): Session
    {
        unset($_SESSION[$this->key][$index]);
        return $this;
    }

    public function clear(): Session
    {
        unset($_SESSION[$this->key]);
        return $this;
    }

    public function id(): string
    {
        return $this->userGet("user_id");
    }

    public function uuid(): string
    {
        return $this->userGet("user_uuid");
    }

    public function userHash(): string
    {
        return "{$this->userGet("user_uuid")}-{$this->userGet("user_id")}";
    }

    public function online(): bool
    {
        return $this->on($this->key);
    }

    public function onLive(): bool
    {
        return $this->on(self::LIVE);
    }

    public function onGuest(): bool 
    {
        return $this->on(self::GUEST);
    }

    public function on(string $key): bool 
    {
        return (isset($_SESSION[$key]) && !empty($_SESSION[$key]["user_id"]));
    }

    public function forceAuthLogin(): void
    {
        if(!$this->online()){
            header("Location:./"); exit();
        }
    }

    public function forceDashboard(): void 
    {
        if($this->online()){
            header("Location:dashboard"); exit();
        }
    }

    public function arrayData(): array 
    {
        return $_SESSION[$this->key]??[];
    }

    public static function initializeSessionManager(string $path = "/"): void 
    {
        if ((bool) ini_get('session.auto_start')) {
            //$this->logger->error('Session: session.auto_start is enabled in php.ini. Aborting.');
            return;
        }
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params(365 * 24 * 60 * 60, $path, ".{$_SERVER['SERVER_NAME']}", true, false);
            session_start();
        }
    }

}