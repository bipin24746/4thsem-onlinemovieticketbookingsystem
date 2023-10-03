<?php
include("header.php");
?>
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
    height: 240px;
    width: 100%;
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
                <div class='movie-card'>
                    <img src='images/$image' alt='Movie Poster' class='movie-poster'>
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
