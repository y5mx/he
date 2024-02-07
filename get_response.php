<?php
require_once("config.php");

if (isset($_POST['your_name'], $_POST['your_email']) && !empty($_POST['your_name']) && !empty($_POST['your_email'])) {
    require_once("contact_mail.php");

    $yourName = $conn->real_escape_string($_POST['your_name']);
    $yourEmail = $conn->real_escape_string($_POST['your_email']);
    $yourPhone = $conn->real_escape_string($_POST['your_phone']);
    $comments = $conn->real_escape_string($_POST['comments']);

    $sql = "INSERT INTO contact_form_info (name, email, phone, comments) 
            VALUES ('" . $yourName . "','" . $yourEmail . "', '" . $yourPhone . "', '" . $comments . "')";

    if (!$result = $conn->query($sql)) {
        die('There was an error running the query [' . $conn->error . ']');
    } else {
        $ticketNumber = $conn->insert_id;
        $userToken = $_POST['user_token'];
        $name = stripslashes($_POST['your_name']);
        $email = stripslashes($_POST['your_email']);
        $phone = stripslashes($_POST['your_phone']);
        $details = stripslashes($_POST['comments']);
        $create_datetime = date("Y-m-d H:i:s");

        $content = [
            "embeds" => [
                [
                    "title" => "Support Ticket",
                    "description" => "A new support ticket has been submitted.",
                    "color" => 3447003, // Blue color
                    "fields" => [
                        ["name" => "Ticket Number", "value" => $ticketNumber, "inline" => true],
                        ["name" => "Name", "value" => $name, "inline" => true],
                        ["name" => "Email", "value" => $email, "inline" => true],
                        ["name" => "Phone", "value" => $phone, "inline" => true],
                        ["name" => "Details", "value" => $details],
                    ],
                    "footer" => ["text" => "Registration Time: $create_datetime"],
                ],
            ],
        ];
        $content = json_encode($content);
        $webhookUrl = 'https://discord.com/api/webhooks/1201922005595869184/i56JHhKyz_R6V7VHVSmTr5fp3VKQX4mRIseShflD2uhUKNSjrwsE23kw8pwzB4_mAMqB'; // Replace with your Discord webhook URL
        $hookarray = [
            'http' => [
                'header' => "Content-type: application/json\r\n",
                "method" => "POST",
                "content" => $content,
            ],
        ];

        file_get_contents($webhookUrl, false, stream_context_create($hookarray));
    }

    // Redirect to success.php with the ticket number
    header("Location: success.php?ticket=" . $ticketNumber);
    exit();
} else {
    echo "Please fill Name and Email";
}
?>
