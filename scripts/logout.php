<?php

// Start the session
session_start();

// Unset all session variables
$_SESSION = array();
session_unset();
// Destroy the session
session_destroy();

unset($_COOKIE["name"]);

// Redirect to the login page
header("Location: ../pages/index.php");
exit;
