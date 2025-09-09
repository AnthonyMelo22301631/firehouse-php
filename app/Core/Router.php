<?php
namespace App\Core;

class Router {
    private array $routes = ['GET' => [], 'POST' => []];

    public function get(string $path, $action) {
        $this->routes['GET'][$path] = $action;
    }

    public function post(string $path, $action) {
        $this->routes['POST'][$path] = $action;
    }
    
    private function normalize($uri) {
        $u = parse_url($uri, PHP_URL_PATH);
        // Remove o prefixo da pasta do projeto
        $u = str_replace('/firehouse-php/public', '', $u);
        return rtrim($u, '/') ?: '/';
    }

   public function dispatch($method, $uri) {
    $path = $this->normalize($uri);
    $action = $this->routes[$method][$path] ?? null;

    if (!$action) {
        http_response_code(404);
        echo "404 - Página não encontrada<br>";
        echo "Tentou acessar: $path";
        return;
    }

    if (is_callable($action)) {
        echo $action();             // <--- echo aqui
        return;
    }

    [$controller, $method] = explode('@', $action);
    $fqcn = "App\\Controllers\\$controller";

    $obj = new $fqcn();
    echo $obj->$method();           // <--- echo aqui
}
}
