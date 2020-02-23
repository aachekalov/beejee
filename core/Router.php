<?php
namespace core;

class Router
{
    const DEFAULT_ACTION = 'index';

    /**
     * @param string $defaultRoute
     */
    public function __construct($defaultRoute = 'site')
    {
        $this->defaultRoute = $defaultRoute;
    }

    /**
     * Resolve request URI.
     *
     * @return array
     */
    public function resolve()
    {
        $route = $_SERVER['REQUEST_URI'];
        if (($pos = strpos($route, '?')) !== false) {
            $route = substr($route, 0, $pos);
        }
        $route = explode('/', $route);
        array_shift($route);
        $controllerName = array_shift($route) ?: $this->defaultRoute;
        $actionName = array_shift($route) ?: self::DEFAULT_ACTION;
        return [$controllerName, $actionName, $route];
    }
}
