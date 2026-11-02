<?php

namespace App\Core;

class Controller {
    protected function render(string $view, array $data = []): void {
        extract($data);
        $viewPath = dirname(__DIR__, 2) . '/views/' . str_replace('.', '/', $view) . '.php';

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "Error: View <code>" . e($view) . "</code> tidak ditemukan di <code>" . e($viewPath) . "</code>";
        }
    }
}

