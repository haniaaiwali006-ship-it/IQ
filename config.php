<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'rsoa_rsoa278_31');
define('DB_PASS', '123456');
define('DB_NAME', 'rsoa_rsoa278_31');

// Create connection
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Test duration in seconds (30 minutes)
define('TEST_DURATION', 1800);

// Score calculation parameters
define('AVERAGE_IQ', 100);
define('IQ_STANDARD_DEVIATION', 15);
?>
