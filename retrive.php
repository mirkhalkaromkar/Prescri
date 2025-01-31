<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "patient_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch distinct years from the database
$yearsResult = $conn->query("SELECT DISTINCT year FROM patients ORDER BY year DESC");

$selectedYear = isset($_GET['year']) ? intval($_GET['year']) : null;

$sql = "SELECT * FROM patients";
if ($selectedYear) {
    $sql .= " WHERE year = $selectedYear";
}
$result = $conn->query($sql);

if (isset($_POST['delete'])) {
    $idToDelete = intval($_POST['id']);
    $deleteSql = "DELETE FROM patients WHERE id = $idToDelete";
    if ($conn->query($deleteSql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    // Refresh the page after deletion
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Records</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e0f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }
        .container:hover {
            transform: scale(1.02);
        }
        h1 {
            text-align: center;
            color: #00796b;
            margin-bottom: 30px;
            font-size: 2em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .filter {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        .filter select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .filter input[type="submit"] {
            padding: 12px;
            background-color: #00796b;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }
        .filter input[type="submit"]:hover {
            background-color: #004d40;
            transform: scale(1.05);
        }
        .delete-icon {
            color: red;
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
            border: none;
            background: none;
            font-size: 1.2em;
        }
        .delete-icon:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Patient Records</h1>
        <div class="filter">
            <form method="get" action="">
                <label for="year">Filter by Year:</label>
                <select name="year" id="year">
                    <option value="">All Years</option>
                    <?php
                    if ($yearsResult->num_rows > 0) {
                        while ($yearRow = $yearsResult->fetch_assoc()) {
                            $year = $yearRow['year'];
                            $selected = $selectedYear == $year ? 'selected' : '';
                            echo "<option value=\"$year\" $selected>$year</option>";
                        }
                    }
                    ?>
                </select>
                <input type="submit" value="Filter">
            </form>
        </div>
        <?php
        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Weight</th>
                        <th>Year</th>
                        <th>Description</th>
                        <th>Prescription PDF</th>
                        <th>Report PDF</th>
                        <th>Additional Info PDF</th>
                        <th>Video</th>
                        <th>Delete</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['age']) . "</td>
                        <td>" . htmlspecialchars($row['gender']) . "</td>
                        <td>" . htmlspecialchars($row['weight']) . "</td>
                        <td>" . htmlspecialchars($row['year']) . "</td>
                        <td>" . htmlspecialchars($row['description']) . "</td>
                        <td>";
                if ($row['prescription_url']) {
                    echo "<a href='" . htmlspecialchars($row['prescription_url']) . "' target='_blank'>View Prescription</a>";
                } else {
                    echo "No Prescription";
                }
                echo "</td>
                        <td>";
                if ($row['report_url']) {
                    echo "<a href='" . htmlspecialchars($row['report_url']) . "' target='_blank'>View Report</a>";
                } else {
                    echo "No Report";
                }
                echo "</td>
                        <td>";
                if ($row['additional_info_url']) {
                    echo "<a href='" . htmlspecialchars($row['additional_info_url']) . "' target='_blank'>View Additional Info</a>";
                } else {
                    echo "No Additional Info";
                }
                echo "</td>
                        <td>";
                if ($row['video_url']) {
                    echo "<a href='" . htmlspecialchars($row['video_url']) . "' target='_blank'>View Video</a>";
                } else {
                    echo "No Video";
                }
                echo "</td>
                        <td>
                            <form method='post' action='' style='display:inline;'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
                                <button type='submit' name='delete' class='delete-icon'>&#10060;</button>
                            </form>
                        </td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
