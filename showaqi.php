<?php
$conn = new mysqli("localhost", "root", "", "aqi"); // Change credentials

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch 20 rows
$sql = "SELECT * FROM info LIMIT 20";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Select up to 10 Cities</title>
    <style>
    body {
        background-color: lightgreen;
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

    input[type="submit"] {
        padding: 10px 20px;
        font-size: 16px;
        background-color: navy;
        color: white;
        border: none;
        cursor: pointer;
        margin-bottom: 30px;
        border-radius: 5px;
    }

    input[type="submit"]:hover {
        background-color: darkblue;
    }

    input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        transform: scale(1.5);
        accent-color: navy;
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
    <h2>Select up to 10 Cities to View AQI</h2>
    <form method="POST" action="checkboxrequestedaqi.php">
        <table border="1" cellpadding="8">
            <tr>
                <th>Select</th>
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

                    // Determine AQI class
                    if ($aqi >= 201) {
                        $aqi_class = 'aqi-high';     // Red
                    } elseif ($aqi >= 101) {
                        $aqi_class = 'aqi-medium';   // Yellow
                    } else {
                        $aqi_class = 'aqi-normal';   // Green
                    }

                    echo "<tr>";
                    echo "<td><input type='checkbox' name='cities[]' value='$id'></td>"; // Add checkboxes for city selection
                    echo "<td>$id</td>";
                    echo "<td>$city</td>";
                    echo "<td>$country</td>";
                    echo "<td class='$aqi_class'>$aqi</td>";
                    echo "</tr>";
                }
            }
            ?>

        </table>
        <br>
        <input type="submit" value="Submit Selected Cities">
    </form>
</body>
</html>

<?php $conn->close(); ?>
