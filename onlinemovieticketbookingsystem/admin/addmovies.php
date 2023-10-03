<?php
include ('header.php');
?>
<?php
session_start();
if(!isset(  $_SESSION['email'] ))
{
    header("location:login.php");
    exit;
}?>
<?php
$servername = "localhost";
$username = "root";
$password = ""; // Provide a valid password here if required
$dbname = "moviebooking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $genre = $_POST['genre'];
    $industry = $_POST['industry'];
    $duration = $_POST['duration'];
    $language = $_POST['language'];
    $reldate = $_POST['reldate'];
    $director = $_POST['director'];
    $actor = $_POST['actor'];
    $price = $_POST['price'];
    $fshow = $_POST['fshow'];
    $sshow = $_POST['sshow'];
    $tshow = $_POST['tshow'];
    $fdate = date('Y-m-d', strtotime($_POST['fdate']));
    $sdate = date('Y-m-d', strtotime($_POST['sdate']));
    $sdate = date('Y-m-d', strtotime($_POST['tdate']));

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

                    // Insert data into the database
                    $sql = "INSERT INTO movie (name, genre, industry, language, duration, reldate, director, actor, price, image, fshow,sshow, tshow, fdate, sdate, tdate) VALUES ('$name', '$genre', '$industry', '$language', '$duration', '$reldate', '$director', '$actor', '$price', '$file_name', '$fshow', '$sshow', '$tshow', '$fdate', '$sdate', '$tdate')";

                    echo 'SQL query: ' . $sql . '<br>'; // Add this line for debugging

                    $result = $conn->query($sql);

                    if ($result) {
                        echo '<script type="text/javascript"> alert("Movie added successfully."); </script>';
                        header("Location: movielist.php");
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
        // Insert data into the database without an image
        $sql = "INSERT INTO movie (name, genre, industry, language, duration, reldate, director, actor, price, fshow, sshow, tshow, fdate, sdate, tdate) VALUES ('$name', '$genre', '$industry', '$language', '$duration', '$reldate', '$director', '$actor', '$price', '$fshow', '$sshow', '$tshow', '$fdate', '$sdate', '$tdate')";

        echo 'SQL query: ' . $sql . '<br>'; // Add this line for debugging

        $result = $conn->query($sql);

        if ($result) {
            echo '<script type="text/javascript"> alert("Movie added successfully."); </script>';
            header("Location: movielist.php");
            exit;
        } else {
            echo '<script type="text/javascript"> alert("Error: ' . $conn->error . '"); </script>';
        }
    }
}
?>


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
<form action="" method="POST" enctype="multipart/form-data">
  <h2><u>Add Movie</u></h2>

  <label for="title">Movie Name:</label>
  <input type="text" id="name" name="name"><br>

  <label for="genre">Genre:</label>
  <input type="text" id="name" name="genre"><br>
  
  <label for="industry">Industry:</label>
  <input type="text" id="name" name="industry"><br>

  <label for="language">Language:</label>
  <input type="text" id="name" name="language"><br>

  <label for="duration">Movie Duration:</label>
  <input type="text" id="name" name="duration"><br>

  <label for="reldate">Released Date:</label>
  <input type="text" id="name" name="reldate"><br>

  <label for="director">Director:</label>
  <input type="text" id="name" name="director"><br>

  <label for="actor">Actors:</label>
  <input type="text" id="name" name="actor"><br>
  
  <label for="price">Ticket Price:</label>
  <input type="number" id="price" name="price"><br>
  
  <label for="image">Movie Poster Image:</label>
  <input type="file" id="image" name="image" ><br>

  <label for="time">First Show</label>
  <input type="time" id="time" name="fshow"><br>

  <label for="time">Second Show</label>
  <input type="time" id="time" name="sshow"><br>

  <label for="time">Third Show</label>
  <input type="time" id="time" name="tshow"><br>

  <label for="fdate">First Show Date:</label>
    <input type="date" id="fdate" name="fdate" required><br>

    <label for="sdate">Second Show Date:</label>
    <input type="date" id="sdate" name="sdate" required><br>

    <label for="sdate">Third Show Date:</label>
    <input type="date" id="sdate" name="tdate" required><br>
  


  <input type="submit" value="Add Movie" name="add">
</form>
