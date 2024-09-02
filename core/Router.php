<?php

namespace Core;

class Router
{
    protected $routes = [];

    public function get($uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller) {
        $this->routes['POST'][$uri] = $controller;
    }

    public function direct($uri, $requestType)
    {
        $uri = $this->formatUri($uri);

        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                explode('@', $this->routes[$requestType][$uri])
            );
        }

        // Если точного совпадения нет, проверяем на наличие динамических сегментов
        foreach ($this->routes[$requestType] as $route => $controller) {
            if ($parameters = $this->matchRoute($uri, $route)) {
                return $this->callAction(
                    explode('@', $controller),
                    $parameters
                );
            }
        }
        // Если маршрут не найден, возвращаем ошибку 404
        $this->handleNotFound();
        //throw new \Exception('No route defined for this URI.');
    }

    protected function matchRoute($uri, $route)
    {
        $routePattern = preg_replace('/{[^}]+}/', '([^/]+)', $route);
        $routePattern = "#^$routePattern$#";

        if (preg_match($routePattern, $uri, $matches)) {
            array_shift($matches); // Удаляем полное совпадение
            return $matches;
        }

        return false;
    }

    protected function callAction(array $controllerAction, array $parameters = []) {
        [$controller, $action] = $controllerAction;

        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (!method_exists($controller, $action)) {
            throw new \Exception(
                "{$controller} does not respond to the {$action} action."
            );
        }

        return call_user_func_array([$controller, $action], $parameters);
    }

    protected function formatUri($uri)
    {
        return trim($uri, '/');
    }

    /**
     * Функция перенаправляет на ошибку 404 если нет такой url
     * @return void
     */
    protected function handleNotFound()
    {
        http_response_code(404); // Устанавливаем HTTP статус 404
        require '../app/views/errors/404.php'; // Подключаем файл с 404 страницей
        exit(); // Останавливаем дальнейшее выполнение
    }
}
