<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cities'])) {
    // Get the selected city IDs from the form
    $selected_ids = $_POST['cities'];

    // Ensure that exactly 10 cities are selected
    if (count($selected_ids) !== 10) {
        die("You must select exactly 10 cities.");
    }

    // Connect to database
    $conn = new mysqli("localhost", "root", "", "aqi"); // Change to your DB credentials

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the list of IDs for SQL query
    $ids_string = implode(",", array_map('intval', $selected_ids));

    // Query to fetch AQI data for the selected cities
    $sql = "SELECT * FROM info WHERE id IN ($ids_string)";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Selected AQI Data</title>
    <style>
        body {
            background-color: #add8e6;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            color: navy;
            margin-top: 20px;
        }

        table {
            background-color: white;
            border-collapse: collapse;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        th, td {
            padding: 10px 16px;
            border: 1px solid black;
            text-align: center;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background-color: navy;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }

        a:hover {
            background-color: darkblue;
        }

        .aqi-high {
            background-color: #ff4c4c; /* Red */
            color: white;
            font-weight: bold;
        }

        .aqi-medium {
            background-color: #ffeb3b; /* Yellow */
            color: black;
            font-weight: bold;
        }

        .aqi-normal {
            background-color: #66bb6a; /* Green */
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Selected Cities - AQI Data</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>City</th>
            <th>Country</th>
            <th>AQI</th>
        </tr>

        <?php
        // Check if results exist and display data
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $city = $row['city'];
                $country = $row['country'];
                $aqi = $row['aqi'];

                // Determine AQI class based on AQI value
                if ($aqi >= 201) {
                    $aqi_class = 'aqi-high';     // Red
                } elseif ($aqi >= 101) {
                    $aqi_class = 'aqi-medium';   // Yellow
                } else {
                    $aqi_class = 'aqi-normal';   // Green
                }

                // Output the city data in a table row
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
    <a href="showaqi.php">← Go Back</a>
</body>
</html>

<?php
    // Close the database connection
    $conn->close();
} else {
    echo "No valid data submitted.";
}
?>
