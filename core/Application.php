<?php
namespace core;

use Illuminate\Database\Capsule\Manager as Capsule;

class Application
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var string
     */
    private $controllerNamespace;

    /**
     * @param array $config name-value pairs that will be used to initialize the object properties.
     */
    public function __construct($config = [])
    {
        $this->router = isset($config['defaultRoute']) ? new Router($config['defaultRoute']) : new Router();
        $this->controllerNamespace = $config['controllerNamespace'];

        $capsule = new Capsule();
        $capsule->addConnection($config['db']);
        $capsule->bootEloquent();
    }

    /**
     * Runs the application.
     * This is the main entrance of an application.
     */
    public function run()
    {
        session_start();

        list($controllerName, $actionName, $params) = $this->router->resolve();

        $result = $this->runAction($controllerName, $actionName, $params);
    }

    /**
     * Runs a controller action.
     *
     * @param string $controllerName
     * @param string $actionName
     * @param string $params
     */
    public function runAction($controllerName, $actionName, $params)
    {
        $controller = $this->createController($controllerName);
        $actionName = 'action' . ucfirst($actionName);
        echo $controller->$actionName();
    }

    /**
     * Create Controller by name.
     *
     * @param string $controllerName
     * @return Controller
     */
    public function createController($controllerName)
    {
        $className = ucfirst($controllerName) . 'Controller';
        $className = $this->controllerNamespace . '\\' . $className;
        $controller = new $className($controllerName);
        return $controller;
    }
}
