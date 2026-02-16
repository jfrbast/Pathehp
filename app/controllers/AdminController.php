<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Security.php';
require_once __DIR__ . '/../models/Film.php';
require_once __DIR__ . '/../models/Seance.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Reservation.php';

class AdminController extends Controller
{
    private function ensureAdmin(): void
    {
        Security::requireAdmin();
    }

    public function films(): void
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $duration = (int)($_POST['duration'] ?? 0);

            if ($title && $duration > 0) {
                Film::create($title, $description, $duration);
                $_SESSION['flash_success'] = 'Film ajouté.';
            } else {
                $_SESSION['flash_error'] = 'Données invalides pour le film.';
            }
        }

        if (isset($_GET['delete'])) {
            Film::deleteFilm((int)$_GET['delete']);
            $_SESSION['flash_success'] = 'Film supprimé.';
            header('Location: ' . BASE_URL . '?controller=admin&action=films');
            exit;
        }

        $films = Film::all();
        $this->render('admin/films', ['films' => $films]);
    }

    public function seances(): void
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filmId = (int)($_POST['film_id'] ?? 0);
            $startTime = $_POST['start_time'] ?? '';
            $seatsTotal = (int)($_POST['seats_total'] ?? 0);

            if ($filmId > 0 && $startTime && $seatsTotal > 0) {
                Seance::create($filmId, $startTime, $seatsTotal);
                $_SESSION['flash_success'] = 'Séance ajoutée.';
            } else {
                $_SESSION['flash_error'] = 'Données invalides pour la séance.';
            }
        }

        if (isset($_GET['delete'])) {
            Seance::deleteSeance((int)$_GET['delete']);
            $_SESSION['flash_success'] = 'Séance supprimée.';
            header('Location: ' . BASE_URL . '?controller=admin&action=seances');
            exit;
        }

        $seances = Seance::allWithFilms();
        $films = Film::all();
        $this->render('admin/seances', ['seances' => $seances, 'films' => $films]);
    }

    public function users(): void
    {
        $this->ensureAdmin();

        if (isset($_GET['delete'])) {
            $userId = (int)$_GET['delete'];
            Reservation::deleteByUser($userId);
            User::deleteUser($userId);
            $_SESSION['flash_success'] = 'Utilisateur supprimé.';
            header('Location: ' . BASE_URL . '?controller=admin&action=users');
            exit;
        }

        $users = User::all();
        $this->render('admin/users', ['users' => $users]);
    }

    public function reservations(): void
    {
        $this->ensureAdmin();
        // Optionnel : vue d’ensemble des réservations
    }
}

