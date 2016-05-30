<?php

class User extends Structure {
    
    const table = 'pages';
    
    public static function title() {
        return self::first(array('title', 'key'));
    }
    
}
