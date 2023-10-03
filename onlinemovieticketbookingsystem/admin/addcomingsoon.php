<?php
include('header.php');
?>
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:login.php");
    exit;
}
?>
<?php
// Database connection credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moviebooking";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// If the form is submitted
if (isset($_POST['add'])) {
    $name = $_POST["name"];
    $reldate = $_POST["reldate"];
    $trailer = $_POST["trailer"];
    $genres = $_POST["genres"];
    $director = $_POST["director"];
    $cast = $_POST["cast"];
    $language = $_POST["language"];
    $industry = $_POST["industry"];

    // Image upload
    if ($_FILES["image"]["name"]) {
        $file_name = $_FILES["image"]["name"];
        $file_size = $_FILES["image"]["size"];
        $file_tmp = $_FILES["image"]["tmp_name"];
        $file_type = $_FILES["image"]["type"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = array("jpg", "jpeg", "png"); // Add any additional allowed extensions here

        if (in_array($file_ext, $allowed_extensions)) {
            if ($file_size < 5242880) { // Max file size: 5MB (you can adjust this value)
                $destination = "../images/" . $file_name;

                if (move_uploaded_file($file_tmp, $destination)) {
                    $image = mysqli_real_escape_string($conn, $destination);
                    // Insert data into the 'coming_soon' table
                    $sql = "INSERT INTO coming_soon (name, genres, industry, language, reldate, director, cast, image, trailer) VALUES ('$name', '$genres', '$industry', '$language', '$reldate', '$director', '$cast', '$file_name', '$trailer')";
                    echo 'SQL query: ' . $sql . '<br>'; // Add this line for debugging

                    $result = $conn->query($sql);

                    if ($result) {
                        echo '<script type="text/javascript"> alert("Movie added successfully."); </script>';
                        header("Location: comingsoonlist.php");
                        exit;
                    } else {
                        echo '<script type="text/javascript"> alert("Error: ' . $conn->error .  '"); </script>';
                    }
                } else {
                    echo '<script type="text/javascript"> alert("Error moving uploaded file."); </script>';
                }
            } else {
                echo '<script type="text/javascript"> alert("File size exceeds the maximum limit."); </script>';
            }
        } else {
            echo '<script type="text/javascript"> alert("Invalid file format. Only JPG, JPEG, and PNG files are allowed."); </script>';
        }
    } else {
        // Insert data into the database without an image
        $sql = "INSERT INTO coming_soon (name, genres, industry, language, reldate, director, cast, trailer) VALUES ('$name', '$genres', '$industry', '$language', '$reldate', '$director', '$cast', '$trailer')";
        echo 'SQL query: ' . $sql . '<br>'; // Add this line for debugging

        $result = $conn->query($sql);

        if ($result) {
            echo '<script type="text/javascript"> alert("Movie added successfully."); </script>';
            header("Location: comingsoonlist.php");
            exit;
        } else {
            echo '<script type="text/javascript"> alert("Error: ' . $conn->error . '"); </script>';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Coming Soon Movie</title>
    <style>
        form {
            width: 500px;
            height: max-content;
            margin-top: 20px;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
            margin-left: 30%;
            margin-right: 30%;
        }

        h2 {
            text-align: center;
        }

        label {
            display: flex;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        textarea {
            height: 100px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Add Coming Soon Movie</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label>Movie Name:</label>
        <input type="text" name="name" required><br>
        <label>Release Date:</label>
        <input type="date" name="reldate" required><br>
        <label>Trailer:</label>
        <input type="text" name="trailer" required><br>
        <label>Image:</label>
        <input type="file" name="image" accept="image/*"><br>
        <label>Genres:</label>
        <input type="text" name="genres" required><br>
        <label>Director:</label>
        <input type="text" name="director" required><br>
        <label>Cast:</label>
        <textarea name="cast" rows="4" required></textarea><br>
        <label>Language:</label>
        <input type="text" name="language" required><br>
        <label>Industry:</label>
        <input type="text" name="industry" required><br>
        <input type="submit" value="Add" name="add">
    </form>
</body>
</html>
