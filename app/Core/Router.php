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
    $u = str_replace('/firehouse-php/public', '', $u);
    $u = '/' . ltrim($u, '/'); // ✅ garante barra no início
    return rtrim($u, '/') ?: '/';
}

   public function dispatch($method, $uri) {
    $path = $this->normalize($uri);
    $action = $this->routes[$method][$path] ?? null;

   if (!$action) {
    http_response_code(404);
    echo "404 - Página não encontrada<br>";
    echo "Tentou acessar: $path<br>";
    echo "<pre>";
    print_r(array_keys($this->routes[$method]));
    echo "</pre>";
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
