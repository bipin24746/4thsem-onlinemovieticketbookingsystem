<?php
include('header.php');
$conn = new mysqli("localhost", "root", "", "moviebooking");
if ($conn->connect_error) {
  die("Connection error: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST["id"];

  // Fetch the movie details from the database
  $sql = "SELECT * FROM movie WHERE id = $id";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $genre = isset($row['genre']);
    $industry = $row['industry'];
    $language = $row['language'];
    $duration = $row['duration'];
    $reldate = $row['reldate'];
    $director = $row['director'];
    $actor = $row['actor'];
    $price = $row['price'];
    $fdate = $row['fdate'];
    $sdate = $row['sdate'];
    $tdate = $row['tdate'];
    $fshow = $row['fshow'];
    $sshow = $row['sshow'];
    $tshow = $row['tshow'];
    $image = $row['image'];

    if (isset($_POST["update"])) {
      $id = $_POST["id"];
      $name = $_POST["name"];
      $genre = $_POST['genre'];
    $industry = $_POST['industry'];
    $duration = $_POST['duration'];
    $language = $_POST['language'];
    $reldate = $_POST['reldate'];
    $director = $_POST['director'];
    $actor = $_POST['actor'];
      $price = $_POST["price"];
      $fdate = $_POST['fdate'];
      $sdate = $_POST['sdate'];
      $sdate = $_POST['sdate'];
      $tdate = $_POST['tdate'];
      $fshow = $_POST["fshow"];
      $sshow = $_POST["sshow"];
      $tshow = $_POST["tshow"];
  
      if ($_FILES["image"]["name"]) {
        $file_name = $_FILES["image"]["name"];
        $file_size = $_FILES["image"]["size"];
        $file_tmp = $_FILES["image"]["tmp_name"];
        $file_type = $_FILES["image"]["type"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = array("jpg", "JPEG", "png"); // Add any additional allowed extensions here

        if (in_array($file_ext, $allowed_extensions)) {
          if ($file_size < 5242880) { // Max file size: 5MB (you can adjust this value)
            $destination = "../images/" . $file_name;

            if (move_uploaded_file($file_tmp, $destination)) {
              $image = mysqli_real_escape_string($conn, $file_name);

              // Update data in the database with image
              $sql = "UPDATE movie SET name='$name', genre = '$genre', industry = '$industry', language = '$language', duration = '$duration', reldate = '$reldate', director = '$director', actor = '$actor', price='$price', fdate='$fdate', sdate = '$sdate', tdate = '$tdate', fshow = '$fshow', sshow = '$sshow', tshow = '$tshow', image='$image' WHERE id=$id";
              $result = $conn->query($sql);

              if ($result) {
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
        // Update data in the database without image
        $sql = "UPDATE movie SET name='$name', genre = '$genre', industry = '$industry', language = '$language', duration = '$duration', reldate = '$reldate', director = '$director', actor = '$actor', price='$price', fdate='$fdate', sdate = '$sdate', tdate = '$tdate', fshow='$fshow', sshow = '$sshow', tshow = '$tshow' WHERE id=$id";
        $result = $conn->query($sql);

        if ($result) {
          header("Location: movielist.php");
          exit;
        } else {
          echo '<script type="text/javascript"> alert("Error: ' . $conn->error . '"); </script>';
        }
      }
    }
  } else {
    echo "No movie found with ID: $id";
    exit();
  }
}
?>
<?php
session_start();
if(!isset(  $_SESSION['email'] ))
{
    header("location:login.php");
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
    <form method="post" action="edit.php" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <label for="name">Movie Name:</label>
      <input type="text" name="name" id="name" value="<?php echo $name; ?>" required>

      <label for="genre">Genre:</label>
  <input type="text" id="name" name="genre" value="<?php echo $genre; ?>"  required><br>
  
  <label for="industry">Industry:</label>
  <input type="text" id="name" name="industry" value="<?php echo $industry; ?>"  required><br>

  <label for="language">Language:</label>
  <input type="text" id="name" name="language" value="<?php echo $language; ?>"  required><br>

  <label for="duration">Movie Duration:</label>
  <input type="text" id="name" name="duration" value="<?php echo $duration; ?>" required><br>

  <label for="reldate">Released Date:</label>
  <input type="text" id="name" name="reldate" value="<?php echo $reldate; ?>"  required><br>

  <label for="director">Director:</label>
  <input type="text" id="name" name="director" value="<?php echo $director; ?>"  required><br>

  <label for="actor">Actors:</label>
  <input type="text" id="name" name="actor" value="<?php echo $actor; ?>"  required><br>


      <label for="price">Price:</label>
      <input type="text" name="price" id="price" value="<?php echo $price; ?>" required>

      <label for="fdate">First Date:</label>
  <input type="date" id="name" name="fdate" value="<?php echo $fdate; ?>"  required><br>

  <label for="sdate">Second Date:</label>
<input type="date" id="name" name="sdate" value="<?php echo isset($sdate) ? $sdate : ''; ?>"><br>

<label for="tdate">Third Date:</label>
<input type="date" id="name" name="tdate" value="<?php echo isset($tdate) ? $tdate : ''; ?>" required><br>


      <label for="time">First Show</label>
      <input type="time" name="fshow" id="time" value="<?php echo $fshow; ?>" required><br><br>

      <label for="sshow">Second Show:</label>
<input type="time" name="sshow" id="time" value="<?php echo isset($sshow) ? $sshow : ''; ?>" required><br><br>

<label for="tshow">Third Show:</label>
<input type="time" name="tshow" id="time" value="<?php echo isset($tshow) ? $tshow : ''; ?>" required><br>

     
      <label for="image">Movie Poster Image:</label>
      <input type="file" id="image" name="image"><br> 
      <input type="submit" name="update" value="Update">
    </form>
  </div>
</body>
</html>

<?php
$conn->close();
?>
