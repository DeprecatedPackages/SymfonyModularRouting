<?php declare(strict_types=1);

namespace Symplify\ModularRouting\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\RouterInterface;

final class CompleteTest extends TestCase
{
    /**
     * @var RouterInterface
     */
    private $router;

    protected function setUp(): void
    {
        $kernel = new AppKernel;
        $kernel->boot();

        $this->router = $kernel->getContainer()
            ->get('router');
    }

    public function testRouter(): void
    {
        $this->assertInstanceOf(RouterInterface::class, $this->router);
    }

    public function testMatchRouteFromRouteCollectionProvider(): void
    {
        $route = $this->router->match('/hello');
        $this->assertInternalType('array', $route);
        $this->assertSame(['_route' => 'my_route'], $route);
    }

    public function testFileLoadedRoutes(): void
    {
        $route = $this->router->match('/yml-route');
        $this->assertSame('yml-loaded-file', $route['_route']);
        $this->assertSame('YmlLoadedController', $route['_controller']);

        $route = $this->router->match('/xml-route');
        $this->assertSame('xml-loaded-file', $route['_route']);
        $this->assertSame('XmlLoadedController', $route['_controller']);
    }
}
