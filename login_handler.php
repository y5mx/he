<?php
session_start();
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Perform a simple authentication check (replace with a more secure method in production)
    $query = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
    $query->bind_param("ss", $username, $password);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $_SESSION["authenticated"] = true;
        header("Location: cards.php");
        exit();
    } else {
        // Invalid credentials
        header("Location: adminlogin.php");
        exit();
    }
} else {
    // Redirect to the login page if accessed directly
    header("Location: adminlogin.php");
    exit();
}
?>
