<?php

require_once __DIR__ . '/../core/Model.php';

class User extends Model
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $role;
    public ?string $remember_token;
    public ?string $remember_token_expires_at;

    public static function findByEmail(string $email): ?array
    {
        $model = new self();
        $stmt = $model->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function findById(int $id): ?array
    {
        $model = new self();
        $stmt = $model->db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function create(string $name, string $email, string $password, string $role = 'user'): bool
    {
        $model = new self();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $model->db->prepare(
            'INSERT INTO users (name, email, password, role, created_at)
             VALUES (:name, :email, :password, :role, NOW())'
        );

        try {
            return $stmt->execute([
                'name'     => $name,
                'email'    => $email,
                'password' => $hash,
                'role'     => $role,
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function updateUser(int $id, string $name, string $email, ?string $password = null): bool
    {
        $model = new self();

        if ($password !== null && $password !== '') {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = 'UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id';
            $params = [
                'name'     => $name,
                'email'    => $email,
                'password' => $hash,
                'id'       => $id,
            ];
        } else {
            $sql = 'UPDATE users SET name = :name, email = :email WHERE id = :id';
            $params = [
                'name'  => $name,
                'email' => $email,
                'id'    => $id,
            ];
        }

        $stmt = $model->db->prepare($sql);
        return $stmt->execute($params);
    }

    public static function deleteUser(int $id): bool
    {
        $model = new self();
        $stmt = $model->db->prepare('DELETE FROM users WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public static function all(): array
    {
        $model = new self();
        $stmt = $model->db->query('SELECT * FROM users ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public static function setRememberToken(int $id, string $token, string $expiresAt): bool
    {
        $model = new self();
        $stmt = $model->db->prepare(
            'UPDATE users SET remember_token = :token, remember_token_expires_at = :expires WHERE id = :id'
        );
        return $stmt->execute([
            'token'   => $token,
            'expires' => $expiresAt,
            'id'      => $id,
        ]);
    }

    public static function clearRememberToken(int $id): bool
    {
        $model = new self();
        $stmt = $model->db->prepare(
            'UPDATE users SET remember_token = NULL, remember_token_expires_at = NULL WHERE id = :id'
        );
        return $stmt->execute(['id' => $id]);
    }

    public static function loginFromRememberMe(): void
    {
        if (empty($_COOKIE[REMEMBER_ME_COOKIE])) {
            return;
        }

        $token = $_COOKIE[REMEMBER_ME_COOKIE];
        $model = new self();

        $stmt = $model->db->prepare(
            'SELECT * FROM users WHERE remember_token = :token AND remember_token_expires_at > NOW() LIMIT 1'
        );
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
        } else {
            setcookie(REMEMBER_ME_COOKIE, '', time() - 3600, BASE_URL);
        }
    }
}

