<?php

require_once __DIR__ . '/../core/Controller.php';

class ErrorController extends Controller
{
    public function notFound(): void
    {
        http_response_code(404);
        $this->render('errors/404');
    }
}

