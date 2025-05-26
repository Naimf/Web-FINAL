<?php
session_start();


if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}


if (isset($_SESSION['selected_cities']) && !empty($_SESSION['selected_cities'])) {
    header("Location: checkboxrequestedaqi.php");
    exit;
}


$bgColor = isset($_SESSION['color_preference']) ? $_SESSION['color_preference'] : '#ffffff';

$conn = new mysqli("localhost", "root", "", "aqi");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// first 20 cities
$sql = "SELECT * FROM info LIMIT 20";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Select up to 10 Cities</title>
    <style>
        body {
            background-color: <?php echo htmlspecialchars($bgColor); ?>;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .navbar {
            width: 100%;
            background: #2c3e50;
            color: white;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 12px 25px;
            box-sizing: border-box;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar .welcome {
            margin-right: auto;
            font-weight: 700;
            font-size: 18px;
            user-select: none;
        }
        .navbar a {
            color: white;
            margin-left: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: color 0.3s ease;
        }
        .navbar a:hover {
            color: #3498db;
        }
        .navbar .avatar {
            display: inline-block;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid white;
            background: #34495e;
            color: white;
            font-weight: 700;
            font-size: 18px;
            line-height: 44px;
            text-align: center;
            user-select: none;
            cursor: default;
            margin-left: 15px;
        }
        h2 {
            color: #2c3e50;
            margin-top: 30px;
            font-weight: 700;
            text-shadow: 1px 1px 2px #ccc;
        }
        table {
            background-color: #fff;
            border-collapse: collapse;
            margin: 20px auto 40px auto;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
            width: 90%;
            max-width: 900px;
        }
        th, td {
            padding: 14px 20px;
            border-bottom: 1px solid #ddd;
            text-align: center;
            font-weight: 500;
            font-size: 16px;
        }
        thead {
            background: #34495e;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 14px;
        }
        tbody tr:hover {
            background-color: #f1f7fb;
            cursor: pointer;
        }
        input[type="submit"] {
            padding: 12px 28px;
            font-size: 18px;
            background-color: #2980b9;
            color: white;
            border: none;
            cursor: pointer;
            margin-bottom: 40px;
            border-radius: 30px;
            box-shadow: 0 5px 15px rgba(41, 128, 185, 0.4);
            transition: background-color 0.3s ease;
            font-weight: 600;
        }
        input[type="submit"]:hover {
            background-color: #1f618d;
        }
        input[type="checkbox"] {
            width: 22px;
            height: 22px;
            cursor: pointer;
            accent-color: #2980b9;
            transform: scale(1.3);
        }
        .aqi-high {
            background-color: #e74c3c; 
            color: white;
            font-weight: 700;
            border-radius: 5px;
            padding: 6px 12px;
        }
        .aqi-medium {
            background-color: #f1c40f; 
            color: #222;
            font-weight: 700;
            border-radius: 5px;
            padding: 6px 12px;
        }
        .aqi-normal {
            background-color: #27ae60; 
            color: white;
            font-weight: 700;
            border-radius: 5px;
            padding: 6px 12px;
        }
    </style>

    <script>
        window.onload = function () {
            const form = document.querySelector("form");
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');

            function toggleCheckboxLimit() {
                const checkedCount = document.querySelectorAll('input[type="checkbox"]:checked').length;
                checkboxes.forEach(cb => {
                    cb.disabled = checkedCount >= 10 && !cb.checked;
                });
            }

            checkboxes.forEach(cb => {
                cb.addEventListener("change", toggleCheckboxLimit);
            });

            toggleCheckboxLimit(); 

            form.addEventListener("submit", function (e) {
                const checkedCount = document.querySelectorAll('input[type="checkbox"]:checked').length;
                if (checkedCount !== 10) {
                    e.preventDefault();
                    alert("You must select exactly 10 cities.");
                }
            });
        };
    </script>
</head>
<body>
    <div class="navbar">
        <div class="welcome">
            Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>
        </div>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
        <div class="avatar">
            <?php
                $names = explode(" ", $_SESSION['full_name']);
                $initials = "";
                foreach ($names as $namePart) {
                    $initials .= strtoupper($namePart[0]);
                }
                echo $initials;
            ?>
        </div>
    </div>

    <h2>Select up to 10 Cities to View AQI</h2>

    <form method="POST" action="checkboxrequestedaqi.php">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>AQI</th>
                    <th>Select</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $selectedCities = isset($_SESSION['selected_cities']) ? $_SESSION['selected_cities'] : [];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = (int)$row['id'];
                        $city = htmlspecialchars($row['city']);
                        $country = htmlspecialchars($row['country']);
                        $aqi = (int)$row['aqi'];

                        // Determine AQI class
                        if ($aqi >= 201) {
                            $aqi_class = 'aqi-high';
                        } elseif ($aqi >= 101) {
                            $aqi_class = 'aqi-medium';
                        } else {
                            $aqi_class = 'aqi-normal';
                        }

                        
                        $checked = in_array($id, $selectedCities) ? "checked" : "";

                        echo "<tr>";
                        echo "<td>{$id}</td>";
                        echo "<td>{$city}</td>";
                        echo "<td>{$country}</td>";
                        echo "<td class='{$aqi_class}'>{$aqi}</td>";
                        echo "<td><input type='checkbox' name='cities[]' value='{$id}' {$checked}></td>";
                        echo "</tr>";
                    }
                } else {
                    echo '<tr><td colspan="5">No data found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <input type="submit" value="Submit Selected Cities">
    </form>
</body>
</html>

<?php
$conn->close();
?>
