<?php


class Config {
    
    public static $keys = array();
    
    public static function load_files( ) {
        $allFiles = glob( ROOT . DS . 'config' . DS . '*.php' );
        foreach($allFiles as $path) {
            $filename = path_file_name($path);
            self::$keys[$filename] = include_once($path);
        }
    }
    
    public static function get($name) {
        $parts = explode('.', $name);
        $values = self::$keys;
        foreach($parts as $key) {
            if(isset($values[$key])) {
                if(is_array($values[$key])) {
                    $values = $values[$key];
                } else {
                    return $values[$key];
                }
            }
        }
        return $values;
    }
    
}
