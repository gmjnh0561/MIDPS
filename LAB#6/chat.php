<?php
include_once('header_includes.php');

$Room = new Room();

$RoomHash = $Room->my_room_id();
if($RoomHash) {
    if($Room->exists($RoomHash)) {
        include_once('templates/'.$Config['template'].'/chat.php');
    } else {
        $Room->redirect('/');
    }
} else {
    $Room->redirect('/');
}