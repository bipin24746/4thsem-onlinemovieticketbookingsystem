<?php include('header.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Booking Success</title>
    <style>
        /* Your existing styles here */

        .bill {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .bill p {
            margin: 5px 0;
        }

        .bill strong {
            display: inline-block;
            width: 120px;
        }

        .download-link {
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<?php

// Get the email address of the logged-in user
$email = $_SESSION['email'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moviebooking";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the latest booking details from the database and assign them to variables
$sqlBookingDetails = "SELECT * FROM booking WHERE email = '$email' ORDER BY booking_date DESC, booking_time DESC LIMIT 1";
$resultBookingDetails = $conn->query($sqlBookingDetails);

if ($resultBookingDetails && $resultBookingDetails->num_rows > 0) {
    $row = $resultBookingDetails->fetch_assoc();
    $fname = $row['fname'];
    $movie_id = $row['movie_id'];
    $booking_date = $row['booking_date'];
    $booking_time = $row['booking_time'];
    $selectedDate = $row['show_date'];
    $selectedShowTime = $row['show_time'];
    $seat_id = $row['seat_id'];
    $bookingDate = $row['booking_date'];
    $totalAmount = $row['total_price'];

    // Retrieve movie details based on the movie_id
    $sqlMovieDetails = "SELECT * FROM movie WHERE id = '$movie_id'";
    $resultMovieDetails = $conn->query($sqlMovieDetails);
    if ($resultMovieDetails && $resultMovieDetails->num_rows > 0) {
        $movieData = $resultMovieDetails->fetch_assoc();
        $movieName = $movieData['name'];
    } else {
        $movieName = 'Movie Not Found';
    }

    // Calculate the total number of booked seats for the specific booking_date and booking_time
    $sqlCountBookedSeats = "SELECT COUNT(*) AS total_booked_seats, GROUP_CONCAT(seat_id ORDER BY seat_id ASC) AS booked_seats FROM booking WHERE booking_date = '$booking_date' AND booking_time = '$booking_time'";
    $resultCountBookedSeats = $conn->query($sqlCountBookedSeats);
    if ($resultCountBookedSeats && $resultCountBookedSeats->num_rows > 0) {
        $data = $resultCountBookedSeats->fetch_assoc();
        $totalBookedSeats = intval($data['total_booked_seats']);
        $bookedSeats = $data['booked_seats'];
    } else {
        $totalBookedSeats = 0;
        $bookedSeats = '';
    }
} else {
    echo "Booking details not found.";
    exit;
}
?>

<body>
    
    <!-- Your existing code here -->

    <div class="container">
        <h1>Booking Success</h1>
        <div class="bill">
            <p><strong>Name:</strong> <?php echo $fname; ?></p>
            <p><strong>Movie Name:</strong> <?php echo $movieName; ?></p>
            <p><strong>Show Date:</strong> <?php echo $selectedDate; ?></p>
            <p><strong>Show Time:</strong> <?php echo $selectedShowTime; ?></p>
            <p><strong>Booking Date:</strong> <?php echo $booking_date; ?></p>
            <p><strong>Booking Time:</strong> <?php echo $booking_time; ?></p>
            
           
            <p><strong>Seat Numbers:</strong> <?php echo $bookedSeats; ?></p>
            <p><strong>Total Seats:</strong> <?php echo $totalBookedSeats; ?></p>
        </div>
        <div class="total-amount">
            <span>Total Amount Needs to Pay:</span>
            <span>Rs. <?php echo $totalAmount; ?></span>
        </div>
        <div class="thank-you">
            
            <p>Thank you for booking with us. Enjoy the movie!</p>
        </div>
        
        <a class="download-link" href="download_bill.php?fname=<?php echo $fname; ?>&movieName=<?php echo $movieName; ?>&selectedDate=<?php echo $selectedDate; ?>&booking_date=<?php echo $booking_date; ?>&booking_time=<?php echo $booking_time; ?>&selectedShowTime=<?php echo $selectedShowTime; ?>&bookingDate=<?php echo $bookingDate; ?>&bookedSeats=<?php echo $bookedSeats; ?>&totalBookedSeats=<?php echo $totalBookedSeats; ?>&totalAmount=<?php echo $totalAmount; ?>">Download Bill</a>
    </div>
</body>
</html>
