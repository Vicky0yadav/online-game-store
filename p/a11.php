<!DOCTYPE html>
<html>
<head>
    <title>Contact Handler</title>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $answer = $_POST["answer"];
    $email = $_POST["email"];

    // Assuming you have a mail server set up, you can use the mail() function to send an email.
    $to = $email;
    $subject = "Response Recorded";
    $message = "Hi $name,\n\nYour response has been recorded. We will try to contact you within 24 hours at $email.";
    $headers = "From: webmaster@example.com"; // Change this to a valid email address

    if (mail($to, $subject, $message, $headers)) {
        echo "Response recorded successfully. We will try to contact you within 24 hours at $email.";
    } else {
        echo "Error occurred while sending email. Please try again later.";
    }
}
?>

<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
    Name: <input type="text" name="name"><br>
    Answer: <input type="text" name="answer"><br>
    Email: <input type="email" name="email"><br>
    <input type="submit" value="Submit">
</form>

</body>
</html>