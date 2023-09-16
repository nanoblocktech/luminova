<?php 
namespace Luminova\Sessions;
class Session {
    public const GUEST = "_system_application_guest_";
    public const LIVE = "_system_application_live_";
    protected $key;
    protected $conn;
    protected static $instance;
    public function __construct($key) {
        $this->key = $key;
    }

    public static function getInstance($key) {
        if (self::$instance === null) {
            self::$instance = new self($key);
        }
        return self::$instance;
    }
  
    public function add($key, $value){
        $_SESSION[$this->key][$key] = $value;
        return $this;
    }
    public function userAdd($index, $value){
        $_SESSION[$this->key]["user_session_profile"][$index] = $value;
        return $this;
    }

    public function set($key, $value){
        $_SESSION[$key] = $value;
        return $this;
    }

    public function get($index){
        return $_SESSION[$this->key][$index]??null;
    }

    public function userGet($index){
        return ($this->user()[$index]??null);
    }

    public function getFrom($index, $key = self::GUEST){
        return $_SESSION[$key][$index]??null;
    }

    public function user(){
        return $_SESSION[$this->key]["user_session_profile"]??[];
    }

    public function unset($key){
        unset($_SESSION[$key]);
        return $this;
    }

    public function remove($index){
        unset($_SESSION[$this->key][$index]);
        return $this;
    }

    public function clear(){
        unset($_SESSION[$this->key]);
        return $this;
    }

    public function id(){
        return $this->userGet("user_id");
    }

    public function uuid(){
        return $this->userGet("user_uuid");
    }

    public function userHash(){
        return "{$this->userGet("user_uuid")}-{$this->userGet("user_id")}";
    }

    public function online(){
        return $this->on($this->key);
    }

    public function onLive(){
        return $this->on(self::LIVE);
    }

    public function onGuest(){
        return $this->on(self::GUEST);
    }

    public function on($key){
        return (isset($_SESSION[$key]) && !empty($_SESSION[$key]["user_id"]));
    }

    public function forceAuthLogin(){
        if(!$this->online()){
            header("Location:./"); exit();
        }
    }

    public function forceDashboard(){
        if($this->online()){
            header("Location:dashboard"); exit();
        }
    }

    public function arrayData(){
        return $_SESSION[$this->key]??[];
    }

    public static function initializeSessionManager($path = "/"){
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params(365 * 24 * 60 * 60, $path, ".{$_SERVER['SERVER_NAME']}", true, false);
            session_start();
        }
    }

}