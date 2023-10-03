<?php include('header.php'); ?>

<style>
  .booking-list {
    margin-top: 50px;
  }

  .booking-list h2 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
  }

  .booking-list table {
    width: 100%;
    border-collapse: collapse;
  }

  .booking-list th,
  .booking-list td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  .booking-list th {
    background-color: #f2f2f2;
  }
</style>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moviebooking";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all the bookings with real date and time, and count the number of seats booked for each booking
$sql = "SELECT booking.*, movie.name AS movie_name, GROUP_CONCAT(seat_id ORDER BY seat_id) AS seat_numbers, COUNT(*) AS num_seats_booked FROM booking JOIN movie ON booking.movie_id = movie.id GROUP BY booking_date, booking_time";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<div class='booking-list'>";
    echo "<h2>Booking List</h2>";

    echo "<table>";
    echo "<tr>
            <th>Name</th>
            <th>Movie Name</th>
            <th>Show Date</th>
            <th>Show Time</th>
            <th>Booking Date</th>
            <th>Booking Time</th>
            <th>Seats Booked</th>
            <th>Seat Numbers</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        $fname = $row['fname'];
        $movieName = $row['movie_name'];
        $showDate = date('F j, Y', strtotime($row['show_date'])); // Format the date
        $showTime = date('h:i A', strtotime($row['show_time'])); // Format the time
        $bookingDate = date('F j, Y', strtotime($row['booking_date'])); // Format the booking date
        $bookingTime = date('h:i A', strtotime($row['booking_time'])); // Format the booking time
        $seatNumbers = $row['seat_numbers'];
        $numSeatsBooked = $row['num_seats_booked'];

        echo "<tr>
                <td>$fname</td>
                <td>$movieName</td>
                <td>$showDate</td>
                <td>$showTime</td>
                <td>$bookingDate</td>
                <td>$bookingTime</td>
                <td>$numSeatsBooked</td>
                <td>$seatNumbers</td>
              </tr>";
    }

    echo "</table>";
    echo "</div>";
} else {
    echo "No bookings found.";
}

$conn->close();
?>