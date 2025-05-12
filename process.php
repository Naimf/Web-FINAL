<?php
// Retrieve the submitted form data from the POST request
$fullName = isset($_POST['full_name']) ? $_POST['full_name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
$dob = isset($_POST['dob']) ? $_POST['dob'] : '';
$country = isset($_POST['country']) ? $_POST['country'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$color = isset($_POST['color']) ? $_POST['color'] : '';
$terms = isset($_POST['terms']) ? $_POST['terms'] : '';

// Check if the form values are valid (You can add further validation here)
$isValid = true;
if ($password !== $confirmPassword) {
    $isValid = false;
    echo "Passwords do not match.<br>";
}

if (!$isValid) {
    echo "There are errors in the form. Please go back and try again.";
    exit;
}

// Show a success message if the form was submitted properly
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .container {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        .form-item {
            margin: 10px 0;
        }

        .form-item label {
            font-weight: bold;
        }

        .back-btn {
            display: block;
            margin-top: 20px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
        }

        .back-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Registration Details</h2>

        <div class="form-item">
            <label>Full Name:</label>
            <p><?php echo htmlspecialchars($fullName); ?></p>
        </div>

        <div class="form-item">
            <label>Email:</label>
            <p><?php echo htmlspecialchars($email); ?></p>
        </div>

        <div class="form-item">
            <label>Password:</label>
            <p><?php echo str_repeat('*', strlen($password)); ?></p>
        </div>

        <div class="form-item">
            <label>Date of Birth:</label>
            <p><?php echo htmlspecialchars($dob); ?></p>
        </div>

        <div class="form-item">
            <label>Country:</label>
            <p><?php echo htmlspecialchars($country); ?></p>
        </div>

        <div class="form-item">
            <label>Gender:</label>
            <p><?php echo htmlspecialchars($gender); ?></p>
        </div>

        <div class="form-item">
            <label>Color Preference:</label>
            <p style="background-color: <?php echo htmlspecialchars($color); ?>; width: 100px; height: 30px;"></p>
        </div>

        <div class="form-item">
            <label>Terms and Conditions:</label>
            <p><?php echo $terms ? "Agreed" : "Not Agreed"; ?></p>
        </div>

        <a href="index.html" class="back-btn">Back to Registration</a>
    </div>

</body>
</html>
