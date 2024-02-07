<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Change Password</title>
    <link rel="stylesheet" href="styles/logreg.css"/>
</head>
<body>
<?php
require('db.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

if (isset($_POST['submit'])) {
    $oldPassword = stripslashes($_POST['old_password']);
    $oldPassword = mysqli_real_escape_string($con, $oldPassword);
    $newPassword = stripslashes($_POST['new_password']);
    $newPassword = mysqli_real_escape_string($con, $newPassword);
    $confirmPassword = stripslashes($_POST['confirm_password']);
    $confirmPassword = mysqli_real_escape_string($con, $confirmPassword);

    // Check if the old password matches the stored password
    $checkPasswordQuery = "SELECT * FROM `users` WHERE username='$username' AND password='" . md5($oldPassword) . "'";
    $checkPasswordResult = mysqli_query($con, $checkPasswordQuery);
    $rows = mysqli_num_rows($checkPasswordResult);

    if ($rows == 1) {
        // Check if the new password and confirmation match
        if ($newPassword == $confirmPassword) {
            // Update the password in the database
            $updatePasswordQuery = "UPDATE `users` SET password='" . md5($newPassword) . "' WHERE username='$username'";
            $updatePasswordResult = mysqli_query($con, $updatePasswordQuery);

            if ($updatePasswordResult) {
                echo "<div class='form'>
                      <h3 style='color: #28a745;'>Password updated successfully.</h3><br/>
                      <p class='link'>Click here to <a href='index.php'>Go to Home</a></p>
                      </div>";
            } else {
                echo "<div class='form'>
                      <h3>Password update failed.</h3><br/>
                      <p class='link'>Click here to <a href='change_password.php'>try again</a>.</p>
                      </div>";
            }
        } else {
            echo "<div class='form'>
                  <h3>New password and confirmation do not match.</h3><br/>
                  <p class='link'>Click here to <a href='change_password.php'>try again</a>.</p>
                  </div>";
        }
    } else {
        echo "<div class='form'>
              <h3>Incorrect old password.</h3><br/>
              <p class='link'>Click here to <a href='change_password.php'>try again</a>.</p>
              </div>";
    }
} else {
?>
    <form class="form" method="post">
        <h1 class="login-title">Change Password</h1>
        <input type="password" class="login-input" name="old_password" placeholder="Old Password" required />
        <input type="password" class="login-input" name="new_password" placeholder="New Password" required />
        <input type="password" class="login-input" name="confirm_password" placeholder="Confirm New Password" required />
        <input type="submit" name="submit" value="Change Password" class="login-button">
        <p class="link">Back to <a href="index.php">Home</a></p>
    </form>
<?php
}
?>
</body>
</html>
