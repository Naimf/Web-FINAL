<?php
session_start();

// DATABASE CONNECTION
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aqi";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("<div class='message error'>Database Connection failed: " . $conn->connect_error . "</div>");
}

// A simple function to show messages with styles
function showMessage($type, $title, $content = '') {
    $color = $type === 'error' ? '#e74c3c' : '#27ae60'; // red or green
    $icon = $type === 'error' ? '❌' : '✅';

    echo <<<HTML
    <div class="message {$type}">
        <div class="icon">$icon</div>
        <h2>$title</h2>
        <p>$content</p>
        <a href="index.php" class="btn">Submit</a>
        <a href="index.php" class="btn cancel-btn">Cancel</a>
    </div>
    HTML;
}

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
            showMessage('error', 'Terms Not Accepted', 'You must accept the terms and conditions to continue.');
            exit;
        }

        if ($password !== $confirmPassword) {
            showMessage('error', 'Password Mismatch', 'Passwords do not match. Please go back and try again.');
            exit;
        }

        // Hash password for security (highly recommended)
        // Removed as per your request (original code kept)
        // $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Using plain password as-is (not recommended)
        $passwordHash = $password;

        $stmt = $conn->prepare("INSERT INTO user (full_name, email, password, dob, country, gender, color_preference) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $fullName, $email, $passwordHash, $dob, $country, $gender, $colorPreference);

        if ($stmt->execute()) {
            $colorStyle = "style='color:$colorPreference;'";
            showMessage('success', "
                <strong>Name:</strong> $fullName<br>
                <strong>Email:</strong> $email<br>
                <strong>Date of Birth:</strong> $dob<br>
                <strong>Country:</strong> $country<br>
                <strong>Gender:</strong> $gender<br>
                <strong>Preferred Color:</strong> <span $colorStyle>$colorPreference</span>
            ");
        } else {
            showMessage('error', 'Database Error', $stmt->error);
        }

        $stmt->close();
    }
    // === LOGIN FORM ===
    elseif ($formType === "login") {
        $email = $_POST['loginEmail'];
        $password = $_POST['loginPassword'];

        $stmt = $conn->prepare("SELECT full_name, password, color_preference FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($storedFullName, $storedPasswordHash, $colorPreference);
            $stmt->fetch();

            // Verify hashed password (removed for you)
            // Just compare plain text password
            if ($password === $storedPasswordHash) {
                $_SESSION['email'] = $email;
                $_SESSION['full_name'] = $storedFullName;
                $_SESSION['color_preference'] = $colorPreference;

                // Check cookie for preferred cities
                if (isset($_COOKIE['preferred_cities']) && !empty($_COOKIE['preferred_cities'])) {
                    $cookieCities = explode(',', $_COOKIE['preferred_cities']);
                    if (count($cookieCities) === 10) {
                        $_SESSION['selected_cities'] = $cookieCities;
                        header("Location: checkboxrequestedaqi.php");
                        exit;
                    }
                }

                if (isset($_SESSION['selected_cities']) && !empty($_SESSION['selected_cities'])) {
                    header("Location: checkboxrequestedaqi.php");
                    exit;
                } else {
                    header("Location: showaqi.php");
                    exit;
                }
            } else {
                showMessage('error', 'Login Failed', 'Incorrect password. Please try again.');
                exit;
            }
        } else {
            showMessage('error', 'User Not Found', 'Please register first.');
            exit;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #6b73ff 0%, #000dff 100%);
        color: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
    }
    .message {
        background: white;
        padding: 30px 40px;
        border-radius: 12px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.2);
        max-width: 450px;
        text-align: center;
        color: #333;
        animation: fadeIn 0.7s ease forwards;
        position: relative;
    }
    .message.success {
        border-left: 8px solid #27ae60;
    }
    .message.error {
        border-left: 8px solid #e74c3c;
        color: #e74c3c;
    }
    .message h2 {
        margin-top: 0;
        font-size: 1.8rem;
    }
    .message p {
        font-size: 1.1rem;
        margin: 15px 0 25px;
        line-height: 1.5;
    }
    .btn {
        display: inline-block;
        padding: 12px 28px;
        background-color: black;
        color: white;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        box-shadow: 0 5px 15px rgba(0,13,255,0.5);
        transition: background-color 0.3s ease;
        cursor: pointer;
        margin: 0 10px;
    }
    .btn:hover {
        background-color: #0027ff;
    }
    .cancel-btn {
        background-color: #e74c3c !important;
    }
    .cancel-btn:hover {
        background-color: #c0392b !important;
    }
    .icon {
        font-size: 48px;
        margin-bottom: 12px;
    }
    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(20px);}
        to {opacity: 1; transform: translateY(0);}
    }
</style>
