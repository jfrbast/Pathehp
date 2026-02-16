<?php

require_once __DIR__ . '/../core/Model.php';

class Film extends Model
{
    public static function all(): array
    {
        $model = new self();
        $stmt = $model->db->query('SELECT * FROM films ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $model = new self();
        $stmt = $model->db->prepare('SELECT * FROM films WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $film = $stmt->fetch();
        return $film ?: null;
    }

    public static function create(string $title, string $description, int $duration): bool
    {
        $model = new self();
        $stmt = $model->db->prepare(
            'INSERT INTO films (title, description, duration, created_at)
             VALUES (:title, :description, :duration, NOW())'
        );
        return $stmt->execute([
            'title'       => $title,
            'description' => $description,
            'duration'    => $duration,
        ]);
    }

    public static function updateFilm(int $id, string $title, string $description, int $duration): bool
    {
        $model = new self();
        $stmt = $model->db->prepare(
            'UPDATE films SET title = :title, description = :description, duration = :duration WHERE id = :id'
        );
        return $stmt->execute([
            'title'       => $title,
            'description' => $description,
            'duration'    => $duration,
            'id'          => $id,
        ]);
    }

    public static function deleteFilm(int $id): bool
    {
        $model = new self();
        $stmt = $model->db->prepare('DELETE FROM films WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}

