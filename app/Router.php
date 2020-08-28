<?php declare(strict_types=1);

namespace App;

use App\Exceptions\ViewNotFoundException;
use InvalidArgumentException;

class Router
{
    private static array $valid_methods = [
        'GET',
        'POST',
    ];

    private string $views_dir;

    public function __construct(string $views_dir) {
        $real_path = realpath($views_dir);
        if ($real_path === false) {
            throw new InvalidArgumentException("'$views_dir' does not exist.");
        }

        $this->views_dir = $views_dir;
    }

    public function run(string $method, string $path) {
        $split = preg_split('/[\?\#]/', $path);
        $path = $split[array_key_first($split)];

        if (!in_array($method, self::$valid_methods)) {
            return $this->loadPage('500');
        }
        
        $view = $this->getViewFromUrlPath($path);
        
        try {
            return ($method == 'GET'
                ? $this->loadPage('dashboard')
                : $this->loadApiEndpoint($view));
        } catch (ViewNotFoundException $ex) {
            return $this->loadPage('404');
        }
    }

    private function getViewFromUrlPath(string $path): ?string {
        $segments = explode('/', $path);
        $segments = array_filter($segments);
        return $segments[array_key_first($segments)] ?? null;
    }

    private function loadPage(string $page) {
        return $this->loadView('pages', $page);
    }

    private function loadApiEndpoint(string $endpoint) {
        return $this->loadView('api', $endpoint);
    }

    private function loadView(string $sub_dir, string $page) {
        global $db; // Poor man's dependency injection :wink:

        $path =  realpath(join('/', [
            $this->views_dir,
            $sub_dir,
            "$page.php",
        ]));

        if ($path !== false && !is_dir($path)) {
            return include $path;
        }

        throw new ViewNotFoundException("File '$path' not found.");
    }
}
