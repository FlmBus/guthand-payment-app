<?php declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Router;

final class RouterTest extends TestCase
{
    private string $views_dir = __DIR__ . '/test_views/';

    public function testCanBeInstantiatedWithValidViewsdir(): void {
        $router = new Router($this->views_dir);
        $this->assertInstanceOf(
            Router::class,
            $router,
        );
    }

    /**
     * @depends testCanBeInstantiatedWithValidViewsdir
     */
    public function testFailsToInstantiateWithInvalidViewsdir(): void {
        $this->expectException(\InvalidArgumentException::class);
        $views_dir = 'non/existant/dir/';
        $router = new Router($views_dir);
    }

    /**
     * @depends testCanBeInstantiatedWithValidViewsdir
     */
    public function testCanBeRunWithValidGetRequest(): void {
        $router = new Router($this->views_dir);
        $res = $router->run('GET', '/test');
        $this->assertEquals('TEST_PAGE_LOADED', $res);
    }

    /**
     * @depends testCanBeInstantiatedWithValidViewsdir
     */
    public function testCanBeRunWithValidPostRequest(): void {
        $router = new Router($this->views_dir);
        $res = $router->run('POST', '/test');
        $this->assertEquals('TEST_API_LOADED', $res);
    }

    /**
     * @depends testCanBeInstantiatedWithValidViewsdir
     */
    public function testFailsToRunWithInvalidRequestMethod(): void {
        $router = new Router($this->views_dir);
        $res = $router->run('INVALID', '/test');
        $this->assertEquals('500_PAGE_LOADED', $res);
    }

    /**
     * @depends testCanBeInstantiatedWithValidViewsdir
     */
    public function testAlwaysLoadsDashboardOnGetRequest(): void {
        $router = new Router($this->views_dir);
        $res = $router->run('GET', '/nonexistant');
        $this->assertEquals('TEST_PAGE_LOADED', $res);
    }
}