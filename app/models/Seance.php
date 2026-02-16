<?php

require_once __DIR__ . '/../core/Model.php';

class Seance extends Model
{
    public static function find(int $id): ?array
    {
        $model = new self();
        $stmt = $model->db->prepare('SELECT * FROM seances WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function forFilm(int $filmId): array
    {
        $model = new self();
        $stmt = $model->db->prepare(
            'SELECT * FROM seances WHERE film_id = :film_id AND start_time >= NOW() ORDER BY start_time ASC'
        );
        $stmt->execute(['film_id' => $filmId]);
        return $stmt->fetchAll();
    }

    public static function allWithFilms(): array
    {
        $model = new self();
        $stmt = $model->db->query(
            'SELECT s.*, f.title AS film_title
             FROM seances s
             JOIN films f ON s.film_id = f.id
             ORDER BY s.start_time DESC'
        );
        return $stmt->fetchAll();
    }

    public static function create(int $filmId, string $startTime, int $seatsTotal): bool
    {
        $model = new self();
        $stmt = $model->db->prepare(
            'INSERT INTO seances (film_id, start_time, seats_total)
             VALUES (:film_id, :start_time, :seats_total)'
        );
        return $stmt->execute([
            'film_id'     => $filmId,
            'start_time'  => $startTime,
            'seats_total' => $seatsTotal,
        ]);
    }

    public static function deleteSeance(int $id): bool
    {
        $model = new self();
        $stmt = $model->db->prepare('DELETE FROM seances WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public static function remainingSeats(int $seanceId): int
    {
        $model = new self();
        $stmt = $model->db->prepare(
            'SELECT s.seats_total - COALESCE(SUM(r.seats), 0) AS remaining
             FROM seances s
             LEFT JOIN reservations r ON r.seance_id = s.id
             WHERE s.id = :id
             GROUP BY s.id'
        );
        $stmt->execute(['id' => $seanceId]);
        $row = $stmt->fetch();
        if (!$row) {
            return 0;
        }
        return (int)$row['remaining'];
    }
}

