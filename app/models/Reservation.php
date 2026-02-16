<?php

require_once __DIR__ . '/../core/Model.php';

class Reservation extends Model
{
    public static function create(int $userId, int $seanceId, int $seats): bool
    {
        $model = new self();
        $stmt = $model->db->prepare(
            'INSERT INTO reservations (user_id, seance_id, seats, created_at)
             VALUES (:user_id, :seance_id, :seats, NOW())'
        );
        return $stmt->execute([
            'user_id'   => $userId,
            'seance_id' => $seanceId,
            'seats'     => $seats,
        ]);
    }

    public static function forUser(int $userId): array
    {
        $model = new self();
        $stmt = $model->db->prepare(
            'SELECT r.*, s.start_time, f.title AS film_title
             FROM reservations r
             JOIN seances s ON r.seance_id = s.id
             JOIN films f ON s.film_id = f.id
             WHERE r.user_id = :user_id
             ORDER BY r.created_at DESC'
        );
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public static function deleteReservation(int $id): bool
    {
        $model = new self();
        $stmt = $model->db->prepare('DELETE FROM reservations WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public static function deleteByUser(int $userId): bool
    {
        $model = new self();
        $stmt = $model->db->prepare('DELETE FROM reservations WHERE user_id = :user_id');
        return $stmt->execute(['user_id' => $userId]);
    }
}

