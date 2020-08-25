<?php declare(strict_types=1);

namespace App;

class Router
{
    private static array $methods = [
        'GET' => 'pages',
        'POST' => 'api',
    ];
    
    private string $views_dir;

    public function __construct(string $views_dir) {
        $this->views_dir = $views_dir;
    }

    public function run(string $method, string $path) {
        $view_subdir = $this->getViewDirFromHttpMethod($method);
        $view = $this->getViewFromUrlPath($path);
        set_error_handler(fn() => die('Error 404'));
        include join('/', [
            $this->views_dir,
            $view_subdir,
            $view . '.php',
        ]);
        restore_error_handler();
    }

    private function getViewDirFromHttpMethod($method): string {
        return static::$methods[$method];
    }

    private function getViewFromUrlPath(string $path): string {
        $segments = explode('/', $path);
        $segments = array_filter($segments);
        return $segments[array_key_first($segments)];
    }
}
