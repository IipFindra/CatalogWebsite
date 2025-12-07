<?php
// config/config.php
// Core configuration for the Catalogue MVC application

// Base URL (adjust if the app resides in a subdirectory)
// Base URL (adjust if the app resides in a subdirectory)
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$scriptDir = str_replace('\\', '/', $scriptDir); // Normalize for Windows
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') 
            ? 'https' : 'http';
define('BASE_URL', rtrim($protocol . '://' . $_SERVER['HTTP_HOST'] . $scriptDir, '/') . '/');

// Database connection
// Check for DATABASE_URL (Railway/Heroku standard)
if ($databaseUrl = getenv('DATABASE_URL')) {
    $dbConfig = parse_url($databaseUrl);
    define('DB_HOST', $dbConfig['host']);
    define('DB_NAME', ltrim($dbConfig['path'], '/'));
    define('DB_USER', $dbConfig['user']);
    define('DB_PASS', $dbConfig['pass']);
    define('DB_PORT', $dbConfig['port'] ?? 3306);
} 
// Check for individual env vars (Railway Managed MySQL specific)
elseif (getenv('MYSQLHOST')) {
    define('DB_HOST', getenv('MYSQLHOST'));
    define('DB_NAME', getenv('MYSQLDATABASE'));
    define('DB_USER', getenv('MYSQLUSER'));
    define('DB_PASS', getenv('MYSQLPASSWORD'));
    define('DB_PORT', getenv('MYSQLPORT') ?? 3306);
}
// Fallback to standard DB_ env vars or localhost
else {
    define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
    define('DB_NAME', getenv('DB_NAME') ?: 'catalogue_db');
    define('DB_USER', getenv('DB_USER') ?: 'root');
    define('DB_PASS', getenv('DB_PASS') ?: '');
    define('DB_PORT', getenv('DB_PORT') ?: 3306);
}

// Autoloader for App and Core namespaces
spl_autoload_register(function ($class) {
    // Remove leading backslash if present
    $class = ltrim($class, '\\');
    $baseDir = __DIR__ . '/../app/';
    // Namespace prefix mappings
    $prefixes = [
        'App\\Controllers\\' => 'controllers/',
        'App\\Models\\'      => 'models/',
        'Core\\'               => 'core/',
    ];
    foreach ($prefixes as $prefix => $dir) {
        if (strpos($class, $prefix) === 0) {
            $relative = substr($class, strlen($prefix));
            $file = $baseDir . $dir . str_replace('\\', '/', $relative) . '.php';
            if (file_exists($file)) {
                require $file;
                return;
            }
        }
    }
    
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});
?>
