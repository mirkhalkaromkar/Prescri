<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Patient Files</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e0f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
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
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #00796b;
        }
        input[type="text"], input[type="number"], select, textarea, input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #b0bec5;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #00796b;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 1.2em;
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }
        input[type="submit"]:hover {
            background-color: #004d40;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload Patient Files</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="age">Age:</label>
            <input type="number" name="age" required>

            <label for="gender">Gender:</label>
            <select name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <label for="weight">Weight:</label>
            <input type="number" step="any" name="weight" required>

            <label for="year">Year:</label>
            <input type="number" name="year" required>

            <label for="description">Description:</label>
            <textarea name="description" required></textarea>

            <label for="prescription">Prescription PDF:</label>
            <input type="file" name="prescription" accept=".pdf">

            <label for="report">Report PDF:</label>
            <input type="file" name="report" accept=".pdf">

            <label for="additional_info">Additional Info PDF:</label>
            <input type="file" name="additional_info" accept=".pdf">

            <label for="video">Video File:</label>
            <input type="file" name="video" accept=".mp4">

            <input type="submit" value="Upload">
        </form>
    </div>
</body>
</html>
