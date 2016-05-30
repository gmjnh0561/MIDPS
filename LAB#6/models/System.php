<?php

class System {
    
    public function config($key) {
        global $Config;
        if(isset($Config[$key])) {
            return $Config[$key];
        } else {
            return '';
        }
    }
    
    public function l($line, $data=array()) {
        global $Lang;
        if(isset($Lang[$line])) {
            if(count($data)) {
                return strtr($Lang[$line], $data);
            } else {
                return $Lang[$line];
            }
        } else {
            return $line;
        }
    }
    
    public function put_session($name, $value) {
        if(@$_SESSION[$name] != $value) {
            $_SESSION[$name] = $value;
        }
    }
    
    public function get_session($name) {
        if(isset($_SESSION[$name])) {
            return $_SESSION[$name];
        } else {
            return '';
        }
    }
    
    public function ip() {
        if(isset($_SERVER['HTTP_X_REAL_IP'])) {
            return $_SERVER['HTTP_X_REAL_IP'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
    
    public function agent() {
        return $_SERVER['HTTP_USER_AGENT'];
    }
    
    public function redirect($uri) {
        header('Location: ' . $uri);
    }
    
    public static function create($file, $content='') {
        $open = fopen($file, 'w');
        fwrite($open, $content);
        fclose($open);
    }
    
}
