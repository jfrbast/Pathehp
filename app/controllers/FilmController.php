<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Security.php';
require_once __DIR__ . '/../models/Film.php';
require_once __DIR__ . '/../models/Seance.php';

class FilmController extends Controller
{
    public function index(): void
    {
        $films = Film::all();
        $this->render('films/index', ['films' => $films]);
    }

    public function show(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            $error = new ErrorController();
            $error->notFound();
            return;
        }

        $film = Film::find($id);
        if (!$film) {
            $error = new ErrorController();
            $error->notFound();
            return;
        }

        $seances = Seance::forFilm($id);
        $this->render('films/show', [
            'film'    => $film,
            'seances' => $seances,
        ]);
    }
}

