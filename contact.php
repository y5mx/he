<?php
    require('db.php');
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/contact.css">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h1>Support Ticket</h1>
                <form name="contact-form" method="post" id="contact-form" action="get_response.php" >
                    <input type="hidden" name="user_token" value="<?php echo session_id(); ?>">
                    <div class="form-group">
                        <label for="Name">Name</label>
                        <input type="text" class="form-control" id="Name" name="your_name" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="your_email"
                            placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="Phone">Phone</label>
                        <input type="text" class="form-control" id="Phone" name="your_phone" placeholder="Phone"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="comments">Details</label>
                        <textarea name="comments" id="comments" class="form-control" rows="3" cols="28" rows="5"
                            placeholder="Details" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit" value="Submit"
                        id="submit_form">Submit</button>
                </form>

                <div class="response_msg"></div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</body>

</html>