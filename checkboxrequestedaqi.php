<?php
session_start();

// Set background color from session or default
$bgColor = isset($_SESSION['color_preference']) ? $_SESSION['color_preference'] : '#ffffff';

// Redirect if city selection is missing or invalid
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cities'])) {
    $selected_ids = $_POST['cities'];

    if (count($selected_ids) !== 10) {
        die("You must select exactly 10 cities.");
    }

    $_SESSION['selected_cities'] = $selected_ids;
} elseif (!isset($_SESSION['selected_cities']) || count($_SESSION['selected_cities']) !== 10) {
    header("Location: showaqi.php");
    exit;
}

// Fetch selected cities from session
$selected_ids = $_SESSION['selected_cities'];

// Connect to database
$conn = new mysqli("localhost", "root", "", "aqi");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute query
$ids_string = implode(",", array_map('intval', $selected_ids));
$sql = "SELECT * FROM info WHERE id IN ($ids_string)";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Selected AQI Data</title>
    <style>
        body {
            background-color: <?php echo htmlspecialchars($bgColor); ?>;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        .header-bar {
            width: 100%;
            background-color: navy;
            color: white;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 10px 20px;
            box-sizing: border-box;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .header-bar .welcome {
            margin-right: auto;
            font-weight: 700;
            font-size: 1.1rem;
        }
        .header-bar a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .header-bar a:hover {
            color: #b0c4de;
        }
        .avatar-circle {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid white;
            background: #444;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            line-height: 40px;
            text-align: center;
            user-select: none;
            margin-left: 15px;
        }

        h2 {
            color: navy;
            margin: 30px 0 20px 0;
            font-weight: 700;
            text-align: center;
        }

        table {
            background-color: white;
            border-collapse: collapse;
            margin-bottom: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            border-radius: 10px;
            overflow: hidden;
            width: 90%;
            max-width: 900px;
        }

        th, td {
            padding: 14px 20px;
            border-bottom: 1px solid #ddd;
            text-align: center;
            font-size: 1rem;
        }
        th {
            background-color: navy;
            color: white;
            font-weight: 700;
            letter-spacing: 0.05em;
        }
        tr:last-child td {
            border-bottom: none;
        }

        .aqi-high {
            background-color: #ff4c4c;
            color: white;
            font-weight: 700;
            border-radius: 6px;
            padding: 10px 0;
        }
        .aqi-medium {
            background-color: #ffeb3b;
            color: #222;
            font-weight: 700;
            border-radius: 6px;
            padding: 10px 0;
        }
        .aqi-normal {
            background-color: #66bb6a;
            color: white;
            font-weight: 700;
            border-radius: 6px;
            padding: 10px 0;
        }

        @media (max-width: 600px) {
            th, td {
                padding: 10px 8px;
                font-size: 0.9rem;
            }
            .header-bar .welcome {
                font-size: 1rem;
            }
            .avatar-circle {
                width: 35px;
                height: 35px;
                font-size: 1rem;
                line-height: 35px;
            }
        }
    </style>
</head>
<body>
    <div class="header-bar">
        <div class="welcome">
            Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>
        </div>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
        <a href="profile.php" class="avatar-circle" title="<?php echo htmlspecialchars($_SESSION['full_name']); ?>">
            <?php
                $names = explode(" ", $_SESSION['full_name']);
                $initials = "";
                foreach ($names as $namePart) {
                    $initials .= strtoupper($namePart[0]);
                }
                echo $initials;
            ?>
        </a>
    </div>

    <h2>Selected Cities - AQI Data</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>City</th>
            <th>Country</th>
            <th>AQI</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $city = $row['city'];
                $country = $row['country'];
                $aqi = $row['aqi'];

                if ($aqi >= 201) {
                    $aqi_class = 'aqi-high';
                } elseif ($aqi >= 101) {
                    $aqi_class = 'aqi-medium';
                } else {
                    $aqi_class = 'aqi-normal';
                }

                echo "<tr>";
                echo "<td>$id</td>";
                echo "<td>$city</td>";
                echo "<td>$country</td>";
                echo "<td class='$aqi_class'>$aqi</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No data found.</td></tr>";
        }
        ?>
    </table>

</body>
</html>

<?php
$conn->close();
?>
