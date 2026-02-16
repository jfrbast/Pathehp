<?php

abstract class Controller
{
    protected function render(string $view, array $params = []): void
    {
        extract($params);
        $viewFile = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo 'Vue introuvable';
            return;
        }

        require __DIR__ . '/../views/layouts/header.php';
        require $viewFile;
        require __DIR__ . '/../views/layouts/footer.php';
    }
}

