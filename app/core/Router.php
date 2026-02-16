<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/Security.php';

class Router
{
    public static function dispatch(): void
    {
        $controllerParam = $_GET['controller'] ?? 'film';
        $action = $_GET['action'] ?? 'index';

        $controllerClass = ucfirst(strtolower($controllerParam)) . 'Controller';

        if (!class_exists($controllerClass)) {
            $controllerClass = 'ErrorController';
            $action = 'notFound';
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $action)) {
            if ($controller instanceof ErrorController) {
                $controller->notFound();
            } else {
                $errorController = new ErrorController();
                $errorController->notFound();
            }
            return;
        }

        $controller->$action();
    }
}

