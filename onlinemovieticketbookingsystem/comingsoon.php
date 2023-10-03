<?php
include("header.php");
?>

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
    height: 275px;
    border: 2px solid #ccc;
    
    margin: 10px;
    width: calc(25% - 20px); /* Two cards per row */
    box-sizing: border-box;
    justify-content: center;
    align-items: center;
}

.coming-soon-container .movie-poster {
    height: 220px;
    width: 100%;
    object-fit: cover;
}

.coming-soon-container .movie-name {
    font-size: 16px;
    font-weight: bold;
    margin-top: 5px;
    margin-bottom: 5px;
    text-align: center;
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
