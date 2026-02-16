<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Security.php';
require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../models\Seance.php';

class ReservationController extends Controller
{
    public function index(): void
    {
        Security::requireLogin();
        $userId = (int)Security::currentUserId();
        $reservations = Reservation::forUser($userId);
        $this->render('reservations/index', ['reservations' => $reservations]);
    }

    public function create(): void
    {
        Security::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL);
            exit;
        }

        $seanceId = isset($_POST['seance_id']) ? (int)$_POST['seance_id'] : 0;
        $seats = isset($_POST['seats']) ? (int)$_POST['seats'] : 1;

        if ($seanceId <= 0 || $seats <= 0) {
            $_SESSION['flash_error'] = 'Données de réservation invalides.';
            header('Location: ' . BASE_URL);
            exit;
        }

        $seance = Seance::find($seanceId);
        if (!$seance) {
            $_SESSION['flash_error'] = 'Séance introuvable.';
            header('Location: ' . BASE_URL);
            exit;
        }

        $remaining = Seance::remainingSeats($seanceId);
        if ($seats > $remaining) {
            $_SESSION['flash_error'] = 'Pas assez de places disponibles.';
            header('Location: ' . BASE_URL . '?controller=film&action=show&id=' . (int)$seance['film_id']);
            exit;
        }

        $ok = Reservation::create((int)Security::currentUserId(), $seanceId, $seats);

        if ($ok) {
            $_SESSION['flash_success'] = 'Réservation enregistrée.';
        } else {
            $_SESSION['flash_error'] = 'Erreur lors de la réservation.';
        }

        header('Location: ' . BASE_URL . '?controller=reservation&action=index');
        exit;
    }
}

