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

        $split = preg_split('/[\?\#]/', $path);
        $path = $split[array_key_first($split)];
        
        if ($method == 'GET') {
            include join('/', [ $this->views_dir, 'pages', 'dashboard.php' ]);
        } else {
            $view = $this->getViewFromUrlPath($path);
            include join('/', [ $this->views_dir, 'api', $view . '.php' ]);
        }
    }

    private function getViewDirFromHttpMethod($method): string {
        return static::$methods[$method];
    }

    private function getViewFromUrlPath(string $path): ?string {
        $segments = explode('/', $path);
        $segments = array_filter($segments);
        return $segments[array_key_first($segments)] ?? null;
    }
}
