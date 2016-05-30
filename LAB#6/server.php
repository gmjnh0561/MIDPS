<?php
include_once('header_includes.php');

switch (@$_GET['action']) {

    case 'count':
        $Main = new Main();
        $Main->update_guest_file();
        echo $Main->guests_count();
    break;

    case 'search':
        $Main = new Main();
        $Main->active_search();
        $ChatHash = $Main->can_search();
        if($ChatHash) { $Main->search(); }
    break;
    
    case 'chat':
        $Main = new Main();
        $ChatHash = $Main->chat_hash();
        if($ChatHash) { echo $ChatHash; }
    break;
    
    case 'status':
        $Room = new Room();
        $RoomHash = $Room->my_room_id();
        $status = '0';
        if(strlen($RoomHash) > 5) {
            if($Room->exists($RoomHash)) {
                $ChatData = $Room->read_data($RoomHash);
                $WhosOffline = $Room->who_is_offline($RoomHash);
                if(!$WhosOffline || $ChatData['status'] == '0') {
                    $status = '0';
                } else {
                    $status = '1';
                }
            } else {
                $status = '0';
            }
        } else {
            $status = '0';
        }
        
        if($status === '1') {
            echo '1';
        } else {
            // Exit message...
            echo '<p class="sorry">'.$Room->l('sorry').'</p>';
        }
        
    break;
    
    case 'quit':
        $Room = new Room();
        $RoomHash = $Room->my_room_id();
        if(strlen($RoomHash) > 5) {
            $Room->quit($RoomHash);
        }
    break;
    
    case 'room':
        $Room = new Room();
        $RoomHash = $Room->my_room_id();
        if(strlen($RoomHash) > 5) {
            if($Room->exists($RoomHash)) {
                $file = $Room->to_chat($RoomHash, $Room->user_hash());
                if(file_exists($file)) {
                    $content = file_get_contents($file);
                    if($content) {
                        echo $Room->convert_content($content);
                        $Room->create($file);
                    }
                }
            }
        }
    break;
    
    case 'send':
        $Room = new Room();
        $RoomHash = $Room->my_room_id();
        if(strlen($RoomHash) > 5) {
            if($Room->exists($RoomHash)) {
                if(isset($_POST['text'])) {
                    $Room->send($RoomHash, $_POST['text']);
                }
            }
        }
    break;
    
}