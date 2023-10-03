<?php
session_start();
include('header.php');
if(isset($_POST['signinBtn'])) {
    // Get the username and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    $servername = "localhost";
    $username = "root";
    $dbname = "moviebooking";
    $conn = new mysqli($servername, $username, "", $dbname);
    if($conn->connect_error) {
        die ("Connection failed ".$conn->connect_error);
    }

    $sql = "SELECT * FROM admin WHERE email = '$email'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];

        // Verify the provided plain-text password with the stored hashed password
        if (password_verify($password, $storedPassword)) {
        // Start the session and store the user's email
        $_SESSION['email'] = $email;
        // Redirect the user to the home page
        header ('location: index.php');
        // echo "<script>window.location.href = 'index.php';</script>";
        exit();
    }
    else {
        echo "email or password invalid";
    }
}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Add Tailwind CSS CDN link here -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .form-box {
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex justify-center items-center min-h-screen">
        <div class="form-box bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h1 class="text-2xl text-center font-bold mb-6">Sign In</h1>
            <form method="post" action="login.php">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" placeholder="Enter your email" name="email" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="Enter your password" name="password" required>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-sm">
                        <a class="text-blue-500 hover:text-blue-700" href="forgot.html">Forgot Password?</a>
                    </p>
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="signinBtn">
                        Sign In
                    </button>
                    
                </div>
                    <p>Don't have an account.....? <br><a href="register.php">Register</a></p>
            </form>
        </div>
    </div>
</body>

</html>