<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Prescri+</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('wlbc.webp') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            text-align: center;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            max-width: 80%;
            width: 600px;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #333;
        }
        p {
            font-size: 1.2em;
            margin-bottom: 40px;
            color: #555;
        }
        .button {
            display: inline-block;
            padding: 15px 30px;
            font-size: 1.2em;
            color: #fff;
            background-color: #5cb85c;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Prescri+</h1>
        <p>Manage and view patient information easily. Upload documents, videos, and more with our streamlined interface.</p>
        <a href="login.php" class="button">Get Started</a>
    </div>
</body>
</html>
