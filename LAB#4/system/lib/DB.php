<?php

class DB {
    
    public $table;
    protected $db = null;
    protected $where = array();
    protected $orWhere = array();
    protected $cols = array();
    protected $placeholders = array();
    protected $order_by = array();
    protected $limit = array();
    protected $fetch = PDO::FETCH_ASSOC;
    
    public function __construct() {
        $this->connections();
    }
    
    public function connections() {
        $dsn = 'mysql:dbname='.Config::get('database.name').';';
        $dsn .= 'host=' . Config::get('database.host');
        try {
            $this->db = new PDO($dsn, Config::get('database.user'), Config::get('database.password'));
            $this->db->exec("SET NAMES utf8");
        } catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
            exit();
        }
    }
    
    public function prepare_select() {
        $cols_sql = $this->prepare_col();
        $where_sql = $this->prepare_where();
        $orWhere_sql = $this->prepare_orWhere( (bool)$where_sql );
        $orderBy_sql = $this->prepare_orderBy();
        $limit_sql = $this->prepare_limit();
        $SQL = "SELECT {$cols_sql} FROM `{$this->table}` {$where_sql} {$orWhere_sql} {$orderBy_sql} {$limit_sql}";
        return $SQL;
    }
    
    public function table($name) {
        $this->table = $name;
        return $this;
    }
    
    public function where($row, $symbol, $value) {
        $this->where[] = array($row, $symbol, $value);
        return $this;
    }
    
    public function orWhere($row, $symbol, $value) {
        $this->orWhere[] = array($row, $symbol, $value);
        return $this;
    }
    
    public function orderBy($col_name, $value) {
        $this->order_by = array($col_name, $value);
        return $this;
    }
    
    public function limit($offset, $rows=null) {
        if($rows == null) {
            $this->limit = array($offset);
        } else {
            $this->limit = array($offset, $rows);
        }
        return $this;
    }
    
    public function col($col) {
        $this->cols = array($col);
        $SQL = $this->prepare_select();
        
        $result = $this->db->prepare($SQL);
        $result->execute( $this->placeholders );
        $result = $result->fetch( $this->fetch );
        
        $this->clean();
        return $result[$col];
    }
    
    public function first($cols = array()) {
        $this->cols = $cols;
        $SQL = $this->prepare_select();
        $result = $this->db->prepare($SQL);
        $result->execute( $this->placeholders );
        
        $this->clean();
        return $result->fetch( $this->fetch );
    }
    
    
    protected function prepare_col() {
        if(!count($this->cols)) { return '*'; }
        $result = array();
        foreach($this->cols as $col) {
            $result[] = "`{$col}`";
        }
        return implode(', ', $result);
    }
    
    protected function prepare_rows($data) {
        $result = array();
        foreach($data as $key=>$value) {
            $result[] = "`{$key}`";
        }
        return implode(', ', $result);
    }
    
    protected function prepare_where() {
        if(!count($this->where)) { return ''; }
        $query = array();
        foreach($this->where as $part) {
            $query[] = "`{$part[0]}` {$part[1]} ?";
            $this->placeholders[] = $part[2];
        }

        return ' WHERE ' . implode(' AND ', $query);
    }
    
    protected function prepare_orWhere($add_prefix_where = False) {
        if(!count($this->orWhere)) { return ''; }
        $query = array();
        $SQL = '';
        foreach($this->orWhere as $part) {
            $query[] = "`{$part[0]}` {$part[1]} ?";
            $this->placeholders[] = $part[2];
        }

        $SQL = ($add_prefix_where)? ' OR ' : ' WHERE ';
        return $SQL . implode(' OR ', $query);
    }
    
    protected function prepare_orderBy() {
        if(!count($this->order_by)) { return ''; }
        $sort = strtoupper($this->order_by[1]);
        return ' ORDER BY `' . $this->order_by[0] . '` ' . $sort .' ';
    }
    
    protected function prepare_limit() {
        if(!count($this->limit)) { return ''; }
        if(isset($this->limit[1])) {
            return " LIMIT {$this->limit[0]}, {$this->limit[1]} ";
        } else {
            return " LIMIT {$this->limit[0]} ";
        }
    }
    
    protected function clean() {
        $this->cols = array();
        $this->where = array();
        $this->orWhere = array();
        $this->order_by = array();
        $this->limit = array();
        $this->placeholders = array();
    }
    
}