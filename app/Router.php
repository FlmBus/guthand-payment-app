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
        global $db;
        $view_subdir = $this->getViewDirFromHttpMethod($method);
        $view = $this->getViewFromUrlPath($path);
        $file = join('/', [ $this->views_dir, $view_subdir, $view . '.php' ]);
        if (file_exists($file)) {
            include $file;
        } else {
            include join('/', [ $this->views_dir, 'pages', '404.php' ]);
        }
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
