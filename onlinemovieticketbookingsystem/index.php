<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie World</title>

    <style>
        /* styles.css */

.custom-nav {
    background-color: #333;
    color: #fff;
    font-weight: bold;
    padding-left: 1rem;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem;
}
.containerindex{
    display: flex;
    justify-content: space-between;
}

.logo {
    text-decoration: none;
    font-size: 24px;
    color: #fff;
}

.menu {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.menu-item {
    margin-right: 1rem;
    position: relative;
}

.menu-link {
    padding: 10px;
    text-decoration: none;
    color: #fff;
}

.sub-menu {
    
    width: 9rem;
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: #333;
    list-style: none;
    margin: 0;
    padding: 0;
}

.sub-menu-item {
    font-size: 20px;
    text-decoration: none;
    color: #fff;
}

.menu-item:hover .sub-menu {
    display: block;
}

    </style>
</head>
<body>
<!-- Header section -->
<div class="custom-nav">
    <div class="container">
        <div class="containerindex">
            <a href="index.php" class="logo">MOVIE WORLD</a>
            <!-- Navigation menu -->
            <ul class="menu">
                <li class="menu-item">
                    <a href="#" class="menu-link" id="movies-link">Movies</a>
                    <!-- Dropdown menu for movies -->
                    <ul class="sub-menu" id="movies-dropdown">
                        <li><a href="nowshowing.php" class="sub-menu-item">Now Showing</a></li>
                        <li><a href="comingsoon.php" class="sub-menu-item">Coming Soon</a></li>
                    </ul>
                </li>
                
                <?php
                // Check if a user is logged in and display appropriate menu option
                session_start();
                if (isset($_SESSION['email'])) {
                    echo '<li class="menu-item"><a href="mybookings.php" class="menu-link">My Bookings</a></li>
                    <li class="menu-item">
                            <a href="logout.php" class="menu-link">Logout</a>
                          </li>';
                } else {
                    echo '<li class="menu-item">
                            <a href="login.php" class="menu-link">Login</a>
                          </li>';
                    echo '<li class="menu-item">
                            <a href="register.php" class="menu-link">Register</a>
                          </li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>


<!-- Main content section -->
<style>
   
   .custom-heading {
    font-weight: bold;
    text-align: center;
}


.movie-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    
}

.movie-card {

    height: 295px;
    border: 2px solid #ccc;
    
    margin: 10px;
    width: calc(25% - 20px); /* 3 cards per row */
    box-sizing: border-box;
    justify-content: center;
    align-items: center;
}



.movie-poster {

width: 100%;
    min-height: 235px;
    object-fit: cover;
}

.movie-name {
    font-size: 16px;
    font-weight: bold;
    margin-top: 5px;
    margin-bottom: 5px;
    text-align: center;
}

.book-button {
    width: 100%;
    height: 25px;
    
    background-color: #4CAF50;
    color: #fff;
    padding: 5px 10px;
    
    font-size: 14px;
    font-weight: bold;
    border: none;
    cursor: pointer;
    
}

</style>

<h2 class="custom-heading">Now Showing</h2>


    <!-- Movie cards container -->
    <div class="movie-container">
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

        // Retrieve movies from the database
        $sql = "SELECT * FROM movie";
        $result = $conn->query($sql);

        // Display movie cards
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $mid = $row['id'];
                $name = $row['name'];
                $image = $row['image'];

                echo "
                <div class='movie-card index'>
                    <img src='images/$image' alt='Movie Poster' class='movie-poster index'>
                    <div class='movie-details'>
                        <h5 class='movie-name'>$name</h5>";

                // Check if a user is logged in and display "Book Now" button
                if (isset($_SESSION['email'])) {
                    echo "<form action='booking.php' method='post'>
                            <input type='hidden' name='mid' value='$mid'>
                            <input type='hidden' name='mname' value='$name'>
                            <input type='submit' name='book_now' value='Book Now' class='book-button'>
                          </form>";
                }
                echo "</div>
                </div>";
            }
        } else {
            echo "No movies found.";
        }
        $conn->close();
        ?>
    </div>
</div>


<script>
    // Dropdown menu functionality
    const moviesLink = document.getElementById('movies-link');
    const moviesDropdown = document.getElementById('movies-dropdown');

    moviesLink.addEventListener('click', function (event) {
        event.preventDefault();
        moviesDropdown.classList.toggle('hidden');
    });
</script>



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

// Retrieve coming soon movies from the database
$sql = "SELECT * FROM coming_soon";
$result = $conn->query($sql);

?>

<style>
    .division{
        border: 2px solid black;
        margin: 2rem 0 2rem 0;
    }
    .custom-heading {
    font-weight: bold;
    text-align: center;
}


.coming-soon-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.coming-soon-container .movie-card {
    height: 314px;
    border: 2px solid #ccc;
    
    margin: 10px;
    width: calc(25% - 20px); /* Two cards per row */
    box-sizing: border-box;
}

.coming-soon-container .movie-poster {
    min-height: 255px;
    width: 100%;
    object-fit: cover;
}

.coming-soon-container .movie-name {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 5px;
}

.coming-soon-container .book-button {
    width: 100%;
    height: 25px;
    background-color: #4CAF50;
    color: #fff;
    
    font-size: 14px;
    font-weight: bold;
    border: none;
    cursor: pointer;
    text-align: center; /* Center-align the text within the button */
}

</style>
<div class="division"></div>

<h2 class="custom-heading">Coming Soon</h2>

<div class="coming-soon-container">
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mid = $row['id'];
            $name = $row['name'];
            $image = $row['image'];

            echo "
            <div class='movie-card'>
                <img src='images/$image' alt='Movie Poster' class='movie-poster'>
                <div class='movie-details'>
                    <h5 class='movie-name'>$name</h5>";

            // Add more details if needed
            if (isset($_SESSION['email'])) {
                echo "<form action='showdetails.php' method='post'>
                        <input type='hidden' name='mid' value='$mid'>
                        <input type='hidden' name='mname' value='$name'>
                        <input type='submit' name='book_now' value='Show Details' class='book-button'>
                      </form>";
            }
            echo "</div>
            </div>";
        }
    } else {
        echo "No coming soon movies found.";
    }
    $conn->close();
    ?>
</div>

    
<script>
    // Dropdown menu functionality
    const moviesLink = document.getElementById('movies-link');
    const moviesDropdown = document.getElementById('movies-dropdown');

    moviesLink.addEventListener('click', function (event) {
        event.preventDefault();
        moviesDropdown.classList.toggle('hidden');
    });
</script>
</body>
</html>
