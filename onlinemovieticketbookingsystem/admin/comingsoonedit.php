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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    // Fetch the movie details from the database
    $sql = "SELECT * FROM coming_soon WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $genres = $row['genres'];
        $industry = $row['industry'];
        $language = $row['language'];
        $trailer = $row['trailer'];
        $reldate = $row['reldate'];
        $director = $row['director'];
        $cast = $row['cast'];
        $image = $row['image'];
    } else {
        echo "No movie found with ID: $id";
        exit();
    }

    if (isset($_POST["update"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $genres = $_POST['genres'];
        $industry = $_POST['industry'];
        $language = $_POST['language'];
        $trailer = $_POST['trailer'];
        $reldate = $_POST['reldate'];
        $director = $_POST['director'];
        $cast = $_POST['cast'];

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
                        $image = mysqli_real_escape_string($conn, $file_name);
                        // Update data in the database with image
                        $sql = "UPDATE coming_soon SET name='$name', genres = '$genres', industry = '$industry', language = '$language', reldate = '$reldate', director = '$director', cast = '$cast', image='$image', trailer = '$trailer' WHERE id=$id";
                        $result = $conn->query($sql);

                        if ($result) {
                            header("Location: comingsoonlist.php");
                            exit;
                        } else {
                            echo '<script type="text/javascript"> alert("Error: ' . $conn->error . '"); </script>';
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
            // Update data in the database without an image
            $sql = "UPDATE coming_soon SET name='$name', genres = '$genres', industry = '$industry', language = '$language', reldate = '$reldate', director = '$director', cast = '$cast', trailer = '$trailer' WHERE id=$id";
            $result = $conn->query($sql);

            if ($result) {
                header("Location: comingsoonlist.php");
                exit;
            } else {
                echo '<script type="text/javascript"> alert("Error: ' . $conn->error . '"); </script>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Movie</title>
    <style>
        .h2 {
            text-align: center;
            font-weight: bold;
            font-family: cursive;
        }

        .edit-form {
            width: 50%;
            margin: 0 auto;
        }

        .edit-form label {
            display: block;
            margin-bottom: 10px;
        }

        .edit-form input[type="text"],
        .edit-form input[type="time"],
        .edit-form textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            resize: vertical;
        }

        .edit-form input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2 class="h2">Edit Movie</h2>
    <div class="edit-form">
        <form method="post" action="comingsoonedit.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="name">Movie Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $name; ?>" required>

            <label for="genres">Genre:</label>
            <input type="text" id="name" name="genres" value="<?php echo $genres; ?>" required><br>

            <label for="industry">Industry:</label>
            <input type="text" id="name" name="industry" value="<?php echo $industry; ?>" required><br>

            <label for="language">Language:</label>
            <input type="text" id="name" name="language" value="<?php echo $language; ?>" required><br>

            <label for="reldate">Released Date:</label>
            <input type="text" id="name" name="reldate" value="<?php echo $reldate; ?>" required><br>

            <label for="director">Director:</label>
            <input type="text" id="name" name="director" value="<?php echo $director; ?>" required><br>

            <label for="cast">Cast:</label>
            <input type="text" id="name" name="cast" value="<?php echo $cast; ?>" required><br>

            <label>Trailer:</label>
        <input type="text" name="trailer" required><br>
            <label for="image">Image:</label>
            <input type="file" name="image" accept="image/*"><br>

            <input type="submit" name="update" value="Update">
        </form>
    </div>
</body>
</html>
<?php
$conn->close();
?>
