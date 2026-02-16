    <?php

session_start();

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/Router.php';


if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
    session_unset();
    session_destroy();
    session_start();
}
$_SESSION['last_activity'] = time();

spl_autoload_register(function (string $class) {
    $baseDir = __DIR__ . '/../app/';
    $paths = [
        $baseDir . 'controllers/' . $class . '.php',
        $baseDir . 'models/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

if (empty($_SESSION['user_id']) && class_exists('User')) {
    if (method_exists('User', 'loginFromRememberMe')) {
        User::loginFromRememberMe();
    }
}

Router::dispatch();

