<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('DS', '/');
define('ROOT', __DIR__ );

// Main framework loader.
include_once(ROOT . DS . 'system' . DS . 'Heart.php');
$Heart = new Heart();

// Include user helpers.
$Heart->load_libs( 'helpers' );

// Include routes settings.
include_once(ROOT . DS . 'routes.php');

// Template Engine settings.
$View = new Miranda(
    // Path to template files.
    Config::get('project.template_files')
);

Route::start();

