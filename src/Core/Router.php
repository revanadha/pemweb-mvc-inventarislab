<?php

namespace App\Core;

class Router {
    private array $routes = [];

    public function get(string $path, array|callable $handler): void {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array|callable $handler): void {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, array|callable $handler): void {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => '/' . trim($path, '/'),
            'handler' => $handler
        ];
    }

    public function dispatch(): void {
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $requestUri = $this->getCurrentUri();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $requestUri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->executeHandler($route['handler'], $params);
                return;
            }
        }

        $this->render404($requestUri);
    }

    private function getCurrentUri(): string {
        if (!empty($_GET['url'])) {
            return '/' . trim($_GET['url'], '/');
        }

        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $baseDir = str_replace('\\', '/', dirname($scriptName));

        // Strip query string
        $path = parse_url($requestUri, PHP_URL_PATH) ?? '/';

        // Strip base directory if present
        if ($baseDir !== '/' && str_starts_with($path, $baseDir)) {
            $path = substr($path, strlen($baseDir));
        }

        // Strip index.php if present in path
        if (str_starts_with($path, '/index.php')) {
            $path = substr($path, strlen('/index.php'));
        }

        $clean = '/' . trim($path, '/');
        return $clean === '/' ? '/' : $clean;
    }

    private function executeHandler(array|callable $handler, array $params = []): void {
        if (is_callable($handler)) {
            call_user_func_array($handler, $params);
            return;
        }

        if (is_array($handler) && count($handler) === 2) {
            [$controllerClass, $method] = $handler;
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                if (method_exists($controller, $method)) {
                    call_user_func_array([$controller, $method], $params);
                    return;
                }
            }
        }

        http_response_code(500);
        echo "Error: Handler tidak valid.";
    }

    private function render404(string $uri): void {
        http_response_code(404);
        echo "<!DOCTYPE html>
<html lang=\"id\">
<head>
    <meta charset=\"UTF-8\">
    <title>404 Halaman Tidak Ditemukan</title>
    <link rel=\"stylesheet\" href=\"" . base_url('/css/style.css') . "\">
</head>
<body style=\"background-color: #11181C; color: #FFFFFF; font-family: Inter, sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0;\">
    <div style=\"text-align: center; background: #1A262B; padding: 40px; border-radius: 16px; border: 1px solid #26373F; max-width: 480px;\">
        <h1 style=\"color: #00E599; font-size: 48px; margin: 0 0 16px 0;\">404</h1>
        <h2 style=\"margin: 0 0 12px 0;\">Halaman Tidak Ditemukan</h2>
        <p style=\"color: #8C9DA6; font-size: 14px; margin-bottom: 24px;\">Rute <code>" . e($uri) . "</code> tidak tersedia dalam sistem.</p>
        <a href=\"" . base_url('/') . "\" class=\"btn-primary\" style=\"display: inline-block; padding: 10px 20px; background: #00E599; color: #11181C; text-decoration: none; border-radius: 8px; font-weight: 600;\">Kembali ke Dashboard</a>
    </div>
</body>
</html>";
    }
}

