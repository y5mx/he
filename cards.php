<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: adminlogin.php");
    exit();
}

require_once("config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/cards.css">
    <title>Ticket Form Submissions</title>
</head>

<body>

    <div class="container">
        <h1>Ticket Submissions</h1>

        <?php
        require_once("config.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
            $ticketNumberToDelete = $_POST["delete"];
            $conn->query("DELETE FROM contact_form_info WHERE ticket_number = $ticketNumberToDelete");
        }

        $result = $conn->query("SELECT * FROM contact_form_info");

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="card">
                    <h4>Name:
                        <?php echo $row['name']; ?>
                    </h4>
                    <p>Email:
                        <?php echo $row['email']; ?>
                    </p>
                    <p>Phone:
                        <?php echo $row['phone']; ?>
                    </p>
                    <!-- Inside the while loop where comments are displayed -->
                    <p style="background-color: #e2f4ff; border: 1px solid #4da8da; padding: 5px;">
                        Comments:
                        <?php echo $row['comments']; ?>
                    </p>
                    <p>Submitted At:
                        <?php echo $row['created_at']; ?>
                    </p>
                    <p>Ticket Number: <span style="color: red;">
                            <?php echo $row['ticket_number']; ?>
                        </span></p>
                    <form method="POST" action="">
                        <input type="hidden" name="delete" value="<?php echo $row['ticket_number']; ?>">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
                <?php
            }
        } else {
            echo "<p>No Ticket forms submissions found.</p>";
        }
        ?>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</body>

</html>