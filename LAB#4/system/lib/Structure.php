<?php

class Structure {
    
    protected static $instance = null;
    
    protected static function run() {
        
        if(!is_object(self::$instance)) {
            self::$instance = new DB;
            self::$instance->table = forward_static_call(
                    array( get_called_class() , 'table_name')
            );
        }
    }
    
    public static function where($row, $symbol, $value) {
        self::run();
        return self::$instance->where($row, $symbol, $value);
    }
    
    public static function table($name) {
        self::run();
        return self::$instance->table($name);
    }
    
    public static function orWhere($row, $symbol, $value) {
        self::run();
        return self::$instance->orWhere($row, $symbol, $value);
    }
    
    public static function orderBy($col_name, $value) {
        self::run();
        return self::$instance->orderBy($col_name, $value);
    }
    
    public static function limit($offset, $rows=null) {
        self::run();
        return self::$instance->limit($offset, $rows=null);
    }
    
    public static function col($col) {
        self::run();
        return self::$instance->col($col);
    }
    
    public static function first($cols) {
        self::run();
        return self::$instance->first($cols);
    }
    
    public static function table_name() {
        return static::table;
    }
    
}

