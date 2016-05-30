<?php
include_once('header_includes.php');

$Main = new Main();
$Main->refresh_hash_file();
include_once('templates/'.$Config['template'].'/enter.php');