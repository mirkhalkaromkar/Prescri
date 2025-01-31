<?php
session_start();

$target_dir = "uploads/";

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $weight = $_POST['weight'];
    $year = $_POST['year'];
    $description = $_POST['description'];

    // Insert patient record
    $sql = "INSERT INTO patients (name, age, gender, weight, year, description) VALUES ('$name', $age, '$gender', $weight, $year, '$description')
            ON DUPLICATE KEY UPDATE name=VALUES(name), age=VALUES(age), gender=VALUES(gender), weight=VALUES(weight), year=VALUES(year), description=VALUES(description)";

    if ($conn->query($sql) === TRUE) {
        $patient_id = $conn->insert_id;
        $_SESSION['message'] = "New record created successfully with ID $patient_id";
    } else {
        $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
    }

    // Function to handle file upload
    function handleFileUpload($fileInputName, $fileType) {
        global $target_dir, $conn, $patient_id;

        if (isset($_FILES[$fileInputName])) {
            $file_name = basename($_FILES[$fileInputName]['name']);
            $file_tmp = $_FILES[$fileInputName]['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $target_file = $target_dir . $file_name;

            // Check if file is a valid format
            if ($fileType == 'pdf' && $file_ext != 'pdf') {
                $_SESSION['warning'] = "Sorry, only PDF files are allowed for $fileInputName.";
                return;
            } elseif ($fileType == 'video' && $file_ext != 'mp4') {
                $_SESSION['warning'] = "Sorry, only MP4 files are allowed for $fileInputName.";
                return;
            }

            if (move_uploaded_file($file_tmp, $target_file)) {
                $_SESSION['message'] = "The file $file_name has been uploaded.";
                $file_url = $target_file;

                // Update the database
                $column_name = '';
                switch ($fileInputName) {
                    case 'prescription':
                        $column_name = 'prescription_url';
                        break;
                    case 'report':
                        $column_name = 'report_url';
                        break;
                    case 'additional_info':
                        $column_name = 'additional_info_url';
                        break;
                    case 'video':
                        $column_name = 'video_url';
                        break;
                }

                $sql = "UPDATE patients SET $column_name='$file_url' WHERE id=$patient_id";
                if ($conn->query($sql) === TRUE) {
                    $_SESSION['message'] .= " Record updated successfully with $file_name";
                } else {
                    $_SESSION['error'] = "Error updating record for $file_name: " . $conn->error;
                }
            } else {
                $_SESSION['error'] = "Sorry, there was an error uploading your file $file_name.";
            }
        }
    }

    // Handle each file input
    handleFileUpload('prescription', 'pdf');
    handleFileUpload('report', 'pdf');
    handleFileUpload('additional_info', 'pdf');
    handleFileUpload('video', 'video');

    // Redirect to avoid resubmission
    header("Location: upload.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Form</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e0f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 20px;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            text-align: center;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
        }
        .alert-success {
            background-color: #4caf50;
        }
        .alert-warning {
            background-color: #ff9800;
        }
        .alert-danger {
            background-color: #f44336;
        }
        button {
            padding: 12px 24px;
            background-color: #00796b;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        button:hover {
            background-color: #004d40;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['message']; ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['warning'])): ?>
            <div class="alert alert-warning"><?php echo $_SESSION['warning']; ?></div>
            <?php unset($_SESSION['warning']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="logout.php" method="post">
            <button type="submit">Logout</button>
        </form>
        <br>
        <form action="qr.png" method="get">
            <button type="submit">Show QR Code</button>
        </form>
    </div>
</body>
</html>
