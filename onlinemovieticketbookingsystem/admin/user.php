<?php
include('header.php');
?>
<style>
  .h2 {
    text-align: center;
    font-weight: bold;
    font-family: cursive;
  }

  .edit-delete-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    margin-top: 20px;
  }

  .edit-delete-table th,
  .edit-delete-table td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  .edit-delete-table th {
    background-color: #f2f2f2;
  }

  .edit-delete-table td button {
    padding: 6px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .edit-delete-table .edit-button {
    background-color: #4caf50;
    color: white;
    margin-right: 5px;
  }

  .edit-delete-table .delete-button {
    background-color: #f44336;
    color: white;
  }
</style>

<h2 class="h2">User List</h2>

<table class="edit-delete-table">
  <tr>
    <th>User ID</th>
    <th>User Name</th>
    <th>Email</th>
    <th>Phone Number</th>
  </tr>
  <?php
  $conn = new mysqli("localhost", "root", "", "moviebooking");
  if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM user";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $uid = $row['uid'];
      $fname = $row['fname'];
      $lname = $row['lname'];
      $email = $row['email'];
      $phone = $row['phone'];
      echo "
      <tr>
        <td>$uid</td>
        <td>$fname $lname</td>
        <td>$email</td>
        <td>$phone</td>
      </tr>
      ";
    }
  } else {
    echo "<tr><td colspan='4'>No users found</td></tr>";
  }

  $conn->close();
  ?>
</table>



</body>
</html>
