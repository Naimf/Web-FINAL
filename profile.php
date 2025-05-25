<?php
session_start();
$bgColor = isset($_SESSION['color_preference']) ? $_SESSION['color_preference'] : '#ffffff';

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aqi";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];
$passwordChangeMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["changePassword"])) {
        $newPassword = $_POST["newPassword"];
        $confirmPassword = $_POST["confirmPassword"];

        if ($newPassword === $confirmPassword) {
            $stmt = $conn->prepare("UPDATE user SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $newPassword, $email);
            $passwordChangeMessage = $stmt->execute() ? "Password changed successfully." : "Error updating password.";
            $stmt->close();
        } else {
            $passwordChangeMessage = "Passwords do not match.";
        }
    }

    if (isset($_POST["updateColor"])) {
        $newColor = $_POST["newColorPreference"];
        if (preg_match('/^#[a-fA-F0-9]{6}$/', $newColor)) {
            $stmt = $conn->prepare("UPDATE user SET color_preference = ? WHERE email = ?");
            $stmt->bind_param("ss", $newColor, $email);
            if ($stmt->execute()) {
                $_SESSION['color_preference'] = $newColor;
                $passwordChangeMessage = "Preferred color updated successfully.";
            } else {
                $passwordChangeMessage = "Error updating preferred color.";
            }
            $stmt->close();
        } else {
            $passwordChangeMessage = "Invalid color format.";
        }
    }
}

$stmt = $conn->prepare("SELECT full_name, dob, country, gender, color_preference FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: <?php echo htmlspecialchars($bgColor); ?>;
            padding: 50px 20px;
            color: #343a40;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: <?php echo htmlspecialchars($user['color_preference']); ?>;
            color: #fff;
            font-size: 40px;
            line-height: 120px;
            margin: 0 auto 20px auto;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        h2 {
            margin-bottom: 10px;
            font-size: 26px;
            color: #212529;
        }

        .profile-info p {
            margin: 10px 0;
            font-size: 16px;
        }

        .form-section {
            text-align: left;
            margin-top: 30px;
        }

        .form-section h3 {
            color: #495057;
            margin-bottom: 10px;
        }

        input[type="password"],
        input[type="color"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ced4da;
            font-size: 15px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            width: 100%;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.3s;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 20px;
            font-weight: bold;
            color: #28a745;
        }

        .nav-buttons {
            margin-top: 30px;
        }

        .nav-buttons a {
            text-decoration: none;
            margin: 0 12px;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
            background: #6c757d;
            color: white;
            transition: background 0.3s ease;
        }

        .nav-buttons a:hover {
            background: #495057;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="avatar">
        <?php
        $names = explode(" ", $user['full_name']);
        $initials = "";
        foreach ($names as $namePart) {
            $initials .= strtoupper($namePart[0]);
        }
        echo $initials;
        ?>
    </div>

    <h2>Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h2>

    <div class="profile-info">
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['dob']); ?></p>
        <p><strong>Country:</strong> <?php echo htmlspecialchars($user['country']); ?></p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
        <p><strong>Preferred Color:</strong>
            <span style="color:<?php echo htmlspecialchars($user['color_preference']); ?>;">
                <?php echo htmlspecialchars($user['color_preference']); ?>
            </span>
        </p>
    </div>

    <div class="form-section">
        <h3>Change Password</h3>
        <form method="POST">
            <input type="password" name="newPassword" placeholder="New Password" required>
            <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
            <button type="submit" name="changePassword">Update Password</button>
        </form>
    </div>

    <div class="form-section">
        <h3>Update Preferred Color</h3>
        <form method="POST">
            <input type="color" name="newColorPreference" value="<?php echo htmlspecialchars($user['color_preference']); ?>" required>
            <button type="submit" name="updateColor">Update Color</button>
        </form>
    </div>

    <?php if (!empty($passwordChangeMessage)): ?>
        <div class="message"><?php echo $passwordChangeMessage; ?></div>
    <?php endif; ?>

    <div class="nav-buttons">
        <a href="checkboxrequestedaqi.php">Back to AQI</a>
        <a href="logout.php">Logout</a>
    </div>
</div>
</body>
</html>
