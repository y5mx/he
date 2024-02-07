<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/admin.css">    
    <title>Admin Login</title>
</head>

<body>
<form  method="POST" class="form" name="login" action="login_handler.php" onsubmit="return validateForm()">
        <h1 class="login-title">Admin Login</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Password"/>
        <input type="submit" value="Login" name="submit" class="login-button"/>
  </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
        function validateForm() {
            // You can add more complex validation logic here if needed
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            // Simple validation example (replace with more secure validation)
            if (username === "" || password === "") {
                alert("Please enter both username and password");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>


