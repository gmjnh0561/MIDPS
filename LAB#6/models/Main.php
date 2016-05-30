<?php

class Main extends System {
    
    public function __construct() {
        global $Config;
        $this->put_session('user_hash', $this->user_hash());
        $this->Config = $Config;
    }
    
    public function user_hash() {
        return md5($this->ip().$this->agent());
    }
    
    public function to_hash($hash) {
        return 'storage/guests/' . $hash . '.txt';
    }
    
    public function to_chat($hash, $user_hash) {
        return 'storage/chat/' . $user_hash .'_'. $hash . '.html';
    }
    
    public function to_chat_data($hash) {
        return 'storage/chat/' . $hash . '_data.txt';
    }
    
    public function refresh_hash_file() {
        $open = fopen( $this->to_hash($this->user_hash()), 'w');
        fclose($open);
    }
    
    public function to_smiles($file) {
        return 'templates/' . $this->config('template') . '/smiles/' . $file;
    }
    
    public function get_smiles_array() {
        $SmilesConfig = $this->to_smiles('CONFIG.txt');
        
        $result = array();
        if(file_exists($SmilesConfig)) {
            $Data = file_get_contents($SmilesConfig);
            $Data = explode("\n", $Data);
            if(count($Data)) {
                foreach($Data as $line) {
                    if(trim($line) == '') {continue;}
                    $part = explode('==', $line);
                    $result[trim($part[0])] = trim($part[1]);
                }
            }
        }
        return $result;
    }
    
    public function create_chat_file($chat_hash, $interlocutor) {
        foreach( array($interlocutor, $this->user_hash()) as $user ) {
            $open = fopen( $this->to_chat($chat_hash, $user), 'w' );
            fwrite($open, '<p>'.$this->l('hi_message').'</p>');
            fclose($open);
        }
        
    }
    
    public function is_fresh($file) {
        if( (filemtime($file) + 10) >= time()) {
            return True;
        } else {
            return False;
        }
    }
    
    public function update_guest_file() {
        $file = $this->to_hash( $this->user_hash() );
        if(file_exists($file) && $this->is_fresh($file)) {
            $guest = touch($file);
        } else {
            $guest = fopen($file, 'w');
            fclose($guest);
        }
    }
    
    public function guests_count() {
        $count = 0;
        $files = glob( $this->to_hash('*') );
        if(count($files)) {
            foreach($files as $file) {
                if( $this->is_fresh($file) ) {
                    $count += 1;
                } else {
                    unlink($file);
                }
            }
            
            return $count;
            
        } else {
            return 0;
        }
    }
    
    public function active_search() {
        $file = $this->to_hash( $this->user_hash() );
        if(file_exists($file)) {
            $size = filesize($file);
            if($size <= 5) {
                $open = fopen($file, 'w');
                fwrite($open, '1');
                fclose($open);
            }
        }
    }
    
    public function can_add($hash) {
        $file = $this->to_hash( $hash );
        if(file_exists($file)) {
            if(filesize($file) > 5) {
                return False;
            }
        } else {
            return False;
        }
        
        return True;
    }
    
    public function put_content($hash, $content) {
        $file = $this->to_hash( $hash );
        $open = fopen($file, 'w');
        fwrite($open, $content);
        fclose($open);
        return True;
    }
    
    public function generate_chat_data($hash, $interlocutor) {
        $data = array(
            'users' =>  array($this->user_hash(), $interlocutor),
            'status' => '1',
        );
        
        $file = $this->to_chat_data($hash);
        $open = fopen($file, 'w');
        fwrite($open, serialize($data));
        fclose($open);
        return True;
    }
    
    public function create_room($interlocutor) {
        $chat_hash = md5($this->user_hash() . $interlocutor . time());
        $this->put_content($interlocutor, $chat_hash);
        $this->put_content($this->user_hash(), $chat_hash);
        $this->create_chat_file($chat_hash, $interlocutor);
        $this->generate_chat_data($chat_hash, $interlocutor);
        return True;
    }
    
    public function search() {
        $files = glob( $this->to_hash('*') );
        if(count($files)) {
            $friends = array();
            foreach($files as $file) {
                if(filesize($file) < 5 && filesize($file) !== 0) {
                    preg_match("#guests/(.+?).txt#i", $file, $matches);
                    if(isset($matches[1])) {
                        if($matches[1] != $this->user_hash()) {
                            $friends[] = $matches[1];
                        }
                    }
                }
            }
            
            if(count($friends)) {
                $dialog_with = $friends[rand(0, count($friends) - 1)];
                if($this->can_add($dialog_with)) {
                    $this->create_room($dialog_with);
                }
            }
            
        }
    }
    
    public function can_search() {
        return $this->can_add($this->user_hash());
    }
    
    public function chat_hash() {
        $file = $this->to_hash( $this->user_hash() );
        $data = file_get_contents($file);
        if(strlen($data) >= 3) {
            return $data;
        } else {
            return False;
        }
    }
    
}