<?php

require_once __DIR__ . '/../vendor/autoload.php';

if (PHP_SAPI == 'cli-server') {
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

$views_dir = realpath(__DIR__ . '/../app/views/');

$router = new App\Router($views_dir);

$router->run($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO']);