<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Read environment variables, provide defaults for local setup
$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '5432';
$db   = getenv('DB_NAME') ?: 'registration_db';
$user = getenv('DB_USER') ?: 'postgres';
$pass = getenv('DB_PASS') ?: '';

// DSN for connecting to the database
$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    // Connect to PostgreSQL
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    echo "Connected to PostgreSQL database '$db' successfully.\n";

    // Create registrations table if it doesn't exist
    $sql = "
    CREATE TABLE IF NOT EXISTS registrations (
        id SERIAL PRIMARY KEY,
        fullname VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";

    $pdo->exec($sql);

    echo "Table 'registrations' created or already exists.\n";
    exit(0);

} catch (PDOException $e) {
    // If the database doesn't exist, try to create it
    if (strpos($e->getMessage(), 'does not exist') !== false) {
        try {
            // Connect without specifying a database
            $dsnNoDb = "pgsql:host=$host;port=$port";
            $pdo = new PDO($dsnNoDb, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            // Create database
            $pdo->exec("CREATE DATABASE \"$db\";");
            echo "Database '$db' created successfully.\n";

            // Reconnect to the newly created database
            $dsn = "pgsql:host=$host;port=$port;dbname=$db";
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            // Create registrations table
            $sql = "
            CREATE TABLE IF NOT EXISTS registrations (
                id SERIAL PRIMARY KEY,
                fullname VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                phone VARCHAR(50),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );";
            $pdo->exec($sql);

            echo "Database '$db' and table 'registrations' created successfully.\n";
            exit(0);

        } catch (PDOException $e2) {
            echo "Failed to create database or table: " . $e2->getMessage() . "\n";
            exit(1);
        }
    } else {
        echo "Database connection failed: " . $e->getMessage() . "\n";
        exit(1);
    }
}
