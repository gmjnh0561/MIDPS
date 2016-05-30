<?php

class Route {
    
    public static $segments = array();
    public static $controllers = array();
    
    public static function add($name, $class) {
        self::$controllers[$name] = $class;
    }
    
    private static function prepare() {
        $uri = substr($_SERVER['REQUEST_URI'], 1); // ignore first '/'
        self::$segments = explode('/', $uri);
        self::$segments = array_map('strtolower', self::$segments);
        $last = count(self::$segments)-1;
        
        if(isset(self::$segments[$last])) {
            if(!self::$segments[$last]) {
                unset(self::$segments[$last]);
            }
        }
        
    }
    
    public static function start() {
        self::prepare();
        echo self::controller();
    }
    
    public static function structure() {
        $structure = array();
        $structure['params'] = array();
        
        if(!isset(self::$segments[0])) {
            self::$segments[0] = '/';
        }
          
        if(!isset(self::$segments[1])) {
            $structure['method'] = 'index';
        } else {
            $structure['method'] = self::$segments[1];
            $structure['params'] = self::enumerate($start_key = 2);
        }
        
        if(array_key_exists(self::$segments[0], self::$controllers) ) {
            $structure['controller'] = self::$controllers[ self::$segments[0] ];
        } else {
            $structure['controller'] = self::$controllers['/'];
            $structure['method'] = 'index';
            $structure['params'] = self::enumerate($start_key = 0);
        }
        
        return $structure;
    }
    
    public static function controller() {
        $structure = self::structure();
        return call_user_func(
                $structure['controller'].'::'.$structure['method'],
                $structure['params']
        );
    }
    
    private static function enumerate($start) {
        $result = array();
        while(True) {
            if(!isset(self::$segments[$start])) {break;}
            $result[] = self::$segments[$start];
            $start += 1;
        }
        return $result;
    }
    
}