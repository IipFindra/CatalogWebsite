<?php
// setup_database.php
// A simple script to initialize the database on Railway
// USAGE: Upload this, then visit /setup_database.php in your browser ONCE.
// SECURITY: Delete this file after successful setup!

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/core/Database.php';

use Core\Database;

try {
    echo "<h1>Database Setup</h1>";
    
    // 1. Get Connection
    $db = Database::getInstance()->getConnection();
    echo "<p>✅ Database connection successful!</p>";

    // 2. Read Schema File
    $schemaFile = __DIR__ . '/database/schema.sql';
    if (!file_exists($schemaFile)) {
        throw new Exception("Schema file not found at: " . $schemaFile);
    }
    $sql = file_get_contents($schemaFile);
    
    // 3. Execute SQL (Split by semicolons)
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    echo "<ul>";
    foreach ($statements as $i => $stmtSql) {
        if (!empty($stmtSql)) {
            echo "<li>Executing statement #" . ($i + 1) . "... ";
            try {
                $db->exec($stmtSql);
                echo "<strong style='color:green'>OK</strong></li>";
            } catch (PDOException $e) {
                echo "<strong style='color:red'>FAILED</strong>: " . htmlspecialchars($e->getMessage()) . "</li>";
                // Don't stop on drop error, but stop on create errors potentially.
                // For now, let's just log and continue to see full picture, or re-throw?
                // Re-throwing is safer to avoid partial state.
                throw $e;
            }
        }
    }
    echo "</ul>";
    
    echo "<p>✅ Schema executed successfully!</p>";
    echo "<p><strong>Tables created/updated. You can now delete this file and use your application.</strong></p>";
    echo "<a href='/'>Go to Home</a>";

} catch (Exception $e) {
    echo "<h3>❌ Error:</h3>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    echo "<p>Check your configuration variables in Railway.</p>";
}
?>
