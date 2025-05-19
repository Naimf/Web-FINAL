<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = htmlspecialchars($_POST['fullName']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $dob = htmlspecialchars($_POST['dob']);
    $country = htmlspecialchars($_POST['country']);
    $gender = htmlspecialchars($_POST['gender']);
    $colorPreference = htmlspecialchars($_POST['colorPreference']);
    $termsAccepted = isset($_POST['terms']);

    if (!$termsAccepted) {
        echo "<h2>You must accept the terms and conditions to continue.</h2>";
        exit;
    }

    if ($password !== $confirmPassword) {
        echo "<h2>Passwords do not match. Please go back and try again.</h2>";
        exit;
    }

    echo "<h2>Registration Successful!</h2>";
    echo "<p><strong>Name:</strong> $fullName</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Date of Birth:</strong> $dob</p>";
    echo "<p><strong>Country:</strong> $country</p>";
    echo "<p><strong>Gender:</strong> $gender</p>";
    echo "<p><strong>Preferred Color:</strong> <span style='color:$colorPreference;'>$colorPreference</span></p>";
    echo "<form><button onclick='history.back()'>confirm</button></form>";
}
?>
