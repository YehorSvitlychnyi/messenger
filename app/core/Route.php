<?php


namespace app\core;


class Route
{
    /**
     * default controller name
     */
    const DEFAULT_CONTROLLER = 'auth';

    /**
     * default action name
     */
    const DEFAULT_ACTION = 'signin';

    /**
     * Parse url path for the controller and action
     */
    static public function init(): void
    {
        $controllerName = self::DEFAULT_CONTROLLER;
        $actionName     = self::DEFAULT_ACTION;
        $urlPath        = $_SERVER['REQUEST_URI'] ?? '/';  //  для бд
        if (strpos($urlPath, '?')) {
            $urlSearchComponents = explode('?', $urlPath);
            $urlPath             = $urlSearchComponents[0];
        }
        $urlComponents = explode('/', $urlPath);
        $urlComponents = array_values(array_filter($urlComponents, function ($component) {
            return !empty($component);
        }));
        if (count($urlComponents) > 2) {
            self::notFound();
        }
        array_walk($urlComponents, function (&$urlComponent) {
            $urlComponent = strtolower($urlComponent);
        });
        if (!empty($urlComponents[0])) {
            $controllerName = $urlComponents[0];
        }
        if (!empty($urlComponents[1])) {
            $actionName = $urlComponents[1];
        }
        $controllerClassName = 'app\controllers\\' . ucfirst($controllerName) . 'Controller';
        if (!class_exists($controllerClassName)) {
            self::notFound();
        }
        $controller = new $controllerClassName();
        if (!method_exists($controller, $actionName)) {
            self::notFound();
        }

        $controller->$actionName();
    }

    /**
     * Send status 404
     * @return never
     */
    static public function notFound(): never
    {
        $response = new Response();
        $response->status(404);
        exit();
    }

    /**
     * create an url string with controller and action
     *
     * @param string $controller
     * @param string $action
     *
     * @return string
     */
    static public function url(string $controller = self::DEFAULT_CONTROLLER, string $action = self::DEFAULT_ACTION): string
    {
        return '/' . strtolower($controller) . '/' . strtolower($action);
    }
}