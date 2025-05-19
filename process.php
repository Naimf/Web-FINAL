<?php
// ==== DATABASE CONNECTION ====
$servername = "localhost";
$username = "root";
$password = ""; // Update if your DB has a password
$dbname = "your_database_name"; // Change this to your actual DB name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// ==== FORM HANDLER ====
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formType = $_POST['formType'];

    // === REGISTRATION FORM ===
    if ($formType === "register") {
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

        $stmt = $conn->prepare("INSERT INTO aqi (full_name, email, password, dob, country, gender, color_preference) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $fullName, $email, $password, $dob, $country, $gender, $colorPreference);

        if ($stmt->execute()) {
            echo "<h2>Registration Successful!</h2>";
            echo "<p><strong>Name:</strong> $fullName</p>";
            echo "<p><strong>Email:</strong> $email</p>";
            echo "<p><strong>Date of Birth:</strong> $dob</p>";
            echo "<p><strong>Country:</strong> $country</p>";
            echo "<p><strong>Gender:</strong> $gender</p>";
            echo "<p><strong>Preferred Color:</strong> <span style='color:$colorPreference;'>$colorPreference</span></p>";
            echo "<form><button onclick='history.back()'>Confirm</button></form>";
        } else {
            echo "<h2>Error: " . $stmt->error . "</h2>";
        }

        $stmt->close();
    }

    // === LOGIN FORM ===
    elseif ($formType === "login") {
        $email = $_POST['loginEmail'];
        $password = $_POST['loginPassword'];

        $stmt = $conn->prepare("SELECT password FROM aqi WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($storedPassword);
            $stmt->fetch();

            if ($password === $storedPassword) {
                header("Location: showaqi.php");
                exit;
            } else {
                echo "<h2>Incorrect password.</h2>";
            }
        } else {
            echo "<h2>Email not found.</h2>";
        }

        $stmt->close();
    }

    $conn->close();
}
?>
