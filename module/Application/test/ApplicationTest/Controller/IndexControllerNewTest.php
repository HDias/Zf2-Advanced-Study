<?php
namespace ApplicationTest\Controller;

use Application\Controller\IndexController;
use Zend\Http\Request;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\MvcEvent;
use ApplicationTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;

class IndexControllerNewTest extends \PHPUnit_Framework_TestCase
{

    protected $controller;

    protected $request;

    protected $response;

    protected $routeMatch;

    protected $event;

    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $this->controller = new IndexController();
        $this->request = new Request();
        $this->routeMatch = new RouteMatch(array(
            'controller' => 'index'
        ));
        $this->event = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
        
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'index');
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode());
        
        //1 forma de testar retorno do viewModel
        $var = $result->getVariables();
        $this->assertArrayHasKey('tasks', $var);
        
        //2 forma de testar retorno do viewModel
        $vars = $result->getVariables();
        $this->assertTrue(isset($vars['tasks']));
    }
}