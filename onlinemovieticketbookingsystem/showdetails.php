<?php
include("header.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Movie Details</title>
    <link rel="stylesheet" href="booking.css">
</head>
<body>
    <?php
    // Establish a connection to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "moviebooking";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the form is submitted to fetch movie details
    if (isset($_POST['mid'])) {
        $mid = $_POST['mid'];
        $sql = "SELECT * FROM coming_soon WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $mid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $genres = $row['genres'];
            $industry = $row['industry'];
            $language = $row['language'];
       
            $reldate = $row['reldate'];
            $director = $row['director'];
            $cast = $row['cast'];
            $image = $row['image'];
            $trailer = $row['trailer'];

            echo "
                <div class='movie-card'>
                    <img src='images/$image' alt='Movie Poster'>
                    <div class='movie-details'>
                        <h1 class='movie-name'>$name</h1>
                        <p><span>Genres:</span> $genres</p>
                        <p><span>Industry:</span> $industry</p>
                        <p><span>Language:</span> $language</p>
                        <p><span>Release Date:</span> $reldate</p>
                        <p><span>Director:</span> $director</p>
                        <p><span>Cast:</span> $cast</p>
                    </div>
                   
                </div>
                <div>
                <a href='trailer_page.php?trailer=$trailer'  target='_blank'><button><span>Watch Trailer</span></button></a>
            </div>";
        } else {
            echo "Movie not found.";
        }
    }
    $conn->close();
    ?>

    <?php include('footer.php'); ?>
</body>
</html>
