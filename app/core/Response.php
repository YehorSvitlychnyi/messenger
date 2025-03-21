<?php

namespace app\core;

class Response
{
    public function status(int $statusCode): void
    {
        http_response_code($statusCode);
    }
    public function view(string $viewName, array $params = []): void
    {
        $viewFile = dirname(__DIR__) . '/views/pages/' . $viewName . '_page.php';
        $templateFile = dirname(__DIR__) . '/views/templates/default_template.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo "View not found: $viewFile";
            exit();
        }

        // Додаємо змінні у область видимості
        extract($params);

        $pagePath = $viewFile;
        $title = ucfirst($viewName);

        if (!file_exists($templateFile)) {
            http_response_code(500);
            echo "Template not found: $templateFile";
            exit();
        }

        include_once $templateFile;
    }
}