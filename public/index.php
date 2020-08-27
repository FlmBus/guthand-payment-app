<?php

if (PHP_SAPI == 'cli-server') {
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require_once __DIR__ . '/../vendor/autoload.php';

$config = require_once __DIR__ . '/../config.php';

use Illuminate\Database\Capsule\Manager as Database;
$db = new Database();
$db->addConnection($config['database']);
$db->setAsGlobal();
$db->bootEloquent();


session_start();

$router = new App\Router($config['views_dir']);

$router->run(
    $_SERVER['REQUEST_METHOD'] ?? 'GET',
    $_SERVER['PATH_INFO'] ?? ''
);
