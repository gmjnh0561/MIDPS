<?php

function path($to) {
    $path = ROOT . DS . $to;
    $path = str_replace('//', '/', $path);
    return $path;
}

function path_file_name($path) {
    $parts = explode('/', $path);
    preg_match('#(.+?)\.php#i', $parts[count($parts)-1], $matches);
    return $matches[1];
}