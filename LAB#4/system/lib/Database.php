<?php

class Database {
    
    protected static $table = 'pages';
    protected static $db;
    public static $affected_rows = 0;
    
    public static function connections() {
        $dsn = 'mysql:dbname='.Config::get('database.name').';';
        $dsn .= 'host=' . Config::get('database.host');
        try {
            self::$db = new PDO($dsn, Config::get('database.user'), Config::get('database.password'));
            self::$db->exec("SET NAMES utf8");
        } catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
            exit();
        }
    }
    
    public static function rows_by_id($id) {
        $result = self::$db->prepare("SELECT * FROM ".self::$table." WHERE `id`= ?");
        $result->execute(array($id));
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function row_by_id($id, $row) {
        $result = self::$db->prepare("SELECT `{$row}` FROM ".self::$table." WHERE `id`= ?");
        $result->execute(array($id));
        $result = $result->fetch(PDO::FETCH_ASSOC);
        return $result[$row];
    }

    public static function insert($rows) {
        $placeholders = self::placeholders(count($rows));
        $prepare_rows = self::prepare_rows($rows);
        $result = self::$db->prepare("INSERT INTO ".self::$table." ({$prepare_rows}) VALUES ({$placeholders})");
        $result->execute( array_values($rows) );
        return self::$db->lastInsertId();
    }
    
    public static function update_by_id($id, $rows) {
        $prepare_rows = self::prepare_update($rows);
        $result = self::$db->prepare("UPDATE ".self::$table." SET {$prepare_rows} WHERE `id`= ?");
        $values = array_values($rows);
        $values[] = $id;
        $execute = $result->execute( $values );
        self::$affected_rows = $result->rowCount();
        echo self::$affected_rows;
        return $execute;
    }
    
    public static function delete_by_id($id) {
        $result = self::$db->prepare("DELETE FROM ".self::$table." WHERE `id`= ?");
        $execute = $result->execute(array($id));
        self::$affected_rows = $result->rowCount();
        return $execute;
    }
    
    protected static function placeholders($count) {
        $result = array();
        for($n=1; $n<=$count; $n++) {
            $result[] = '?';
        }
        return implode(', ', $result);
    }

    protected static function prepare_rows($data) {
        $result = array();
        foreach($data as $key=>$value) {
            $result[] = "`{$key}`";
        }
        return implode(', ', $result);
    }
    
    protected static function prepare_update($data) {
        $result = array();
        foreach($data as $key=>$value) {
            $result[] = "`{$key}`=?";
        }
        return implode(', ', $result);
    }
    
}