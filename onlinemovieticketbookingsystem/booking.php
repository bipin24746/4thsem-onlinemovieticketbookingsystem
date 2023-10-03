<!DOCTYPE html>
<html>
<head>
    <title>Movie Booking</title>
    <link rel="stylesheet" href="booking.css">
</head>
<body>
    <?php

    include('header.php');
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "moviebooking";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (isset($_POST['book_now'])) {
        if (empty($_POST['mid'])) {
            echo "Movie ID not provided.";
            exit;
        }
        $mid = $_POST['mid'];
    }
    if (isset($_POST['mid'])) {
        $mid = $_POST['mid'];
        $sql = "SELECT * FROM movie WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $mid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $genre = $row['genre'];
            $industry = $row['industry'];
            $language = $row['language'];
            $duration = $row['duration'];
            $reldate = $row['reldate'];
            $director = $row['director'];
            $actor = $row['actor'];
            $image = $row['image'];
            $fdate = $row['fdate'];
            $sdate = $row['sdate'];
            $sdate = $row['tdate'];
            $fshow = $row['fshow'];
            $fshow = $row['sshow'];
            $fshow = $row['tshow'];
            $fdate = date('Y-m-d', strtotime($row['fdate']));
            $sdate = date('Y-m-d', strtotime($row['sdate']));
            $tdate = date('Y-m-d', strtotime($row['tdate']));
            $fshow = date('H:i:s', strtotime($row['fshow']));
            $sshow = date('H:i:s', strtotime($row['sshow']));
            $tshow = date('H:i:s', strtotime($row['tshow']));
            echo "
                <div class='movie-card'>
                    <img src='images/$image' alt='Movie Poster'>
                    <div class='movie-details'>
                        <h1 class='movie-name'>$name</h1>
                        <p><span>Genre:</span> $genre</p>
                        <p><span>Industry:</span> $industry</p>
                        <p><span>Language:</span> $language</p>
                        <p><span>Duration:</span> $duration</p>
                        <p><span>Release Date:</span> $reldate</p>
                        <p><span>Director:</span> $director</p>
                        <p><span>Actor:</span> $actor</p>
                    </div>
                    
                </div>";
        } else {
            echo "Movie not found.";
        }
    }
    ?>
    <div class="booking-form">
    <h2>Select Date and Time</h2>
    <form action="seats.php" method="post">
        <label for="selected_date">Select Date:</label>
        <select name="selected_date">
            <?php
            if (!empty($fdate)) {
                echo "<option value=\"$fdate\">$fdate</option>";
            }
            if (!empty($sdate)) {
                echo "<option value=\"$sdate\">$sdate</option>";
            }
            if (!empty($tdate) && !empty($tdate)) {
                echo "<option value=\"$tdate\">$tdate</option>";
            }
            ?>
        </select>

        <?php
        $selected_date = $_POST['selected_date'] ?? '';
        ?>

        Show:
        <select name="selected_show_time">
            <?php
            if (!empty($fshow)) {
                echo "<option value=\"$fshow\">$fshow</option>";
            }
            // Assuming $sdate is retrieved from the database, just like $fdate and $fshow
            if (!empty($sshow) && !empty($sshow)) {
                echo "<option value=\"$sshow\">$sshow</option>";
            }
            if (!empty($tshow) && !empty($tshow)) {
                echo "<option value=\"$tshow\">$tshow</option>";
            }
            ?>
            
        </select>

        <input type="hidden" name="selected_show_date" value="<?php echo $selected_date; ?>">
        <input type="hidden" name="fshow" value="<?php echo $fshow; ?>">
        <input type="hidden" name="mid" value="<?php echo $mid; ?>">
        <br>
        <input type="submit" name="bookSeats" value="Book Seats">
    </form>
</div>
 
    
    <?php include('footer.php'); ?>
</body>
</html>
