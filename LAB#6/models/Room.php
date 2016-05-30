<?php

class Room extends Main {
    
    public function my_room_id() {
        $file = $this->to_hash( $this->user_hash() );
        if(file_exists($file)) {
            $data = file_get_contents($file);
            return $data;
        } else {
            return False;
        }
    }
    
    public function exists($hash) {
        $file = $this->to_chat_data($hash);
        return file_exists($file);
    }
    
    public function read_data($hash) {
        $file = $this->to_chat_data($hash);
        $data = unserialize(file_get_contents($file));
        if(is_array($data)) {
            return $data;
        } else {
            return False;
        }
    }
    
    public function remove_room_hash($users) {
        foreach($users as $user_hash) {
            $file = $this->to_hash($user_hash);
            if(file_exists($file)) {
                $open = fopen($file, 'w');
                fclose($open);
            }
        }
    }
    
    public function who_is_offline($hash) {
        $ChatData = $this->read_data($hash);
        if(isset($ChatData['users'])) {
            $num = 0;
            foreach($ChatData['users'] as $user_hash) {
                $file = $this->to_hash($user_hash);
                if(file_exists($file)) {
                    $num += 1;
                }
            }

            if($num == 2) {
                return True;
            } else {
                $this->quit($hash);
                return False;
            }
            
        }
    }
    
    public function quit($hash) {
        if($this->exists($hash)) {
            $data = $this->read_data($hash);
            if($data != False) {
                $this->remove_room_hash( array($this->user_hash()) );
                $data['status'] = '0';
                
                // Save
                $file = $this->to_chat_data($hash);
                $open = fopen($file, 'w');
                fwrite($open, serialize($data));
                fclose($open);
            }
        }
    }
    
    public function send($hash, $text) {
        $text = htmlspecialchars($text);
        $text = strip_tags($text);
        $data = $this->read_data($hash);
        
        $size = mb_strlen($text);
        if($size >= 550 || $size <= 0) {
            return False;
        }
        
        $text = '<p><span class="id_'.$this->user_hash().'">name_'.$this->user_hash().':</span> '.$text.'</p>';
        
        foreach($data['users'] as $user_hash) {
            $file = $this->to_chat($hash, $user_hash);
            $open = fopen($file, 'a+');
            fwrite($open, $text);
            fclose($open);
        }
        return True;
    }
    
    public function convert_content($content) {
        $content = str_replace('id_'.$this->user_hash(), 'blue', $content);
        $content = str_replace('name_'.$this->user_hash(), $this->l('you'), $content);
        $content = preg_replace("|id_.{32}|", 'red', $content);
        $content = preg_replace("|name_.{32}|", $this->l('him'), $content);
        $content = $this->smiles_convert($content);
        return $content;
    }
    
    public function get_list_of_smiles() {
        $Smiles = $this->get_smiles_array();
        $html = '';
        if(count($Smiles)) {
            foreach($Smiles as $key=>$image) {
                $html .= '<img onclick="javascript:add_emoticons(\''.$key.'\');" src="templates/'.$this->config('template').'/smiles/'.$image.'">';
            }
        }
        return $html;
    }
    
    public function smiles_convert($content) {
        $Smiles = $this->get_smiles_array();
        
        if(count($Smiles)) {
            foreach($Smiles as $key=>$image) {
                $key = htmlspecialchars($key);
                $Smiles[$key] = 'templates/' . $this->config('template') . '/smiles/' . $image;
                $Smiles[$key] = '<img src="'.$Smiles[$key].'">';
            }
        }
        
        return strtr($content, $Smiles);
    }
    
}