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
    
    // 3. Execute SQL (Split by semicolons to handle multiple statements if PDO doesn't automatically)
    // Note: PDO can often execute multiple queries, but specific drivers might differ. 
    // It's safer to execute as one block if supported, or split.
    // For simplicity, we'll try executing the whole block first.
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    echo "<p>✅ Schema executed successfully!</p>";
    echo "<p><strong>Tables created/updated. You can now delete this file and use your application.</strong></p>";
    echo "<a href='/'>Go to Home</a>";

} catch (Exception $e) {
    echo "<h3>❌ Error:</h3>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    echo "<p>Check your configuration variables in Railway.</p>";
}
?>
