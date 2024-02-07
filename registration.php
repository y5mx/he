<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Registration</title>
    <link rel="stylesheet" href="styles/logreg.css" />
</head>

<body>
    <?php
    require('db.php');

    if (isset($_POST['submit'])) {
        $username = stripslashes($_POST['username']);
        $username = mysqli_real_escape_string($con, $username);
        $email = stripslashes($_POST['email']);
        $email = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $create_datetime = date("Y-m-d H:i:s");

        // Check if the username is the same as the registered email
        if ($username == $email) {
            echo "<div class='form'>
              <h3>Error: Username cannot be the same as the email address.</h3><br/>
              <p class='link'>Click here to <a href='registration.php'>try again</a>.</p>
              </div>";
        } else {
            // Check if the password meets the minimum length requirement
            if (strlen($password) < 8) {
                echo "<div class='form'>
                  <h3>Error: Password should be at least 8 characters long.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>try again</a>.</p>
                  </div>";
            } else {
                // Check if the username is already registered
                $checkUsernameQuery = "SELECT * FROM `users` WHERE username='$username'";
                $checkUsernameResult = mysqli_query($con, $checkUsernameQuery);

                // Check if the email is already registered
                $checkEmailQuery = "SELECT * FROM `users` WHERE email='$email'";
                $checkEmailResult = mysqli_query($con, $checkEmailQuery);

                if (mysqli_num_rows($checkUsernameResult) > 0) {
                    echo "<div class='form'>
                      <h3>Error: Username already exists.</h3><br/>
                      <p class='link'>Click here to <a href='registration.php'>try again</a>.</p>
                      </div>";
                } elseif (mysqli_num_rows($checkEmailResult) > 0) {
                    echo "<div class='form'>
                      <h3>Error: Email address already registered.</h3><br/>
                      <p class='link'>Click here to <a href='registration.php'>try again</a>.</p>
                      </div>";
                } else {
                    // Proceed with registration
                    $content = [
                        "embeds" => [
                            [
                                "title" => "Registration System",
                                "description" => "A new user has registered.",
                                "color" => 3447003, // Blue color
                                "fields" => [
                                    ["name" => "Username", "value" => $username, "inline" => true],
                                    ["name" => "Email", "value" => $email, "inline" => true],
                                ],
                                "footer" => ["text" => "Registration Time: $create_datetime"],
                            ],
                        ],
                    ];
                    $content = json_encode($content);

                    $link = 'https://discord.com/api/webhooks/1201929457850667079/9fLkrZLfAgS039dbP8fX3AO1j6xdTD3FWj6GirsEjvegniOyJkwP_dOo12bTSUPI7qNt';
                    $hookarray = [
                        'http' => [
                            'header' => "Content-type: application/json\r\n",
                            "method" => "POST",
                            "content" => $content,
                        ],
                    ];
                    file_get_contents($link, false, stream_context_create($hookarray));
                    $query = "INSERT INTO `users` (username, password, email, create_datetime)
                          VALUES ('$username', '" . md5($password) . "', '$email', '$create_datetime')";
                    $result = mysqli_query($con, $query);

                    if ($result) {
                        echo "<div class='form'>
                          <h3 style='color: #007bff;'>Success: You are registered successfully.</h3><br/>
                          <p class='link'>Click here to <a href='login.php'>Login</a></p>
                          </div>";
                    } else {
                        echo "<div class='form'>
                          <h3>Error: Registration failed.</h3><br/>
                          <p class='link'>Click here to <a href='registration.php'>try again</a>.</p>
                          </div>";
                    }
                }
            }
        }
    } else {
        ?>
        <form class="form" action="" method="post">
            <h1 class="login-title">Registration</h1>
            <input type="text" id="username" class="login-input" name="username" placeholder="Username" required />
            <input type="text" id="email" class="login-input" name="email" placeholder="Email Adress">
            <input type="password" class="login-input" name="password" placeholder="Password">
            <input type="submit" name="submit" value="Register" class="login-button">
            <p class="link">Already have an account? <a href="login.php">Login here</a></p>
        </form>
        <?php
    }
    ?>
</body>

</html>