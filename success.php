<?php
// Check if the 'ticket' parameter is set in the URL
$ticketNumber = isset($_GET['ticket']) ? htmlspecialchars($_GET['ticket']) : '';

// If 'ticket' parameter is not set, redirect the user back to the form page
if (empty($ticketNumber)) {
    header("Location: contact.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="styles/success.css">
</head>

<body>

    <div class="success-container">
        <div class="tick animate__animated animate__bounceIn">&#10004;</div>
        <?php
        // Retrieve the ticket number from URL parameters
        $ticketNumber = isset($_GET['ticket']) ? htmlspecialchars($_GET['ticket']) : '';
        ?>
        <h2>Your Ticket has been submitted and will be reviewed shortly!</h2>
        <h4 class="ticket-number">Ticket Number:
            <?php echo $ticketNumber; ?>
        </h4>
    </div>

</body>

</html>