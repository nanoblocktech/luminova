<?php 
namespace Luminova\SessionManager;
class Session {
    public const GUEST = "_liminova_app_guest_";
    public const LIVE = "_liminova_app_live_";
    protected $db;
    protected $conn;
    public function __construct($db) {
        $this->db = $db;
    }
  
    public function add($key, $value){
        $_SESSION[$this->db][$key] = $value;
        return $this;
    }

    public function set($key, $value){
        $_SESSION[$key] = $value;
        return $this;
    }

    public function get($index){
        return $_SESSION[$this->db][$index]??null;
    }

    public function getFrom($index, $db = self::GUEST){
        return $_SESSION[$db][$index]??null;
    }

    public function unset($key){
        unset($_SESSION[$key]);
        return $this;
    }

    public function remove($index){
        unset($_SESSION[$this->db][$index]);
        return $this;
    }

    public function clear(){
        unset($_SESSION[$this->db]);
        return $this;
    }

    public function id(){
        return $this->get("_id");
    }

    public function online(){
        return $this->on($this->db);
    }

    public function onLive(){
        return $this->on(self::LIVE);
    }

    public function onGuest(){
        return $this->on(self::GUEST);
    }

    public function on($db){
        return (isset($_SESSION[$db]) && !empty($_SESSION[$db]["_id"]));
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
        return $_SESSION[$this->db]??[];
    }

}