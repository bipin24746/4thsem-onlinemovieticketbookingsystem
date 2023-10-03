<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
    exit;
}

?>


<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" type="text/css" href="index.css">
<style>
  .content {
  margin: 20px;
  padding: 20px;
  height: 100%;
  background-color:#f2f2f2;
  border: 1px solid #ddd;
  }

.content p {
  margin-bottom: 10px;
}

.content p:first-child {
  font-size: 18px;
  font-weight: bold;
}

.content p:nth-child(2) {
  font-style: italic;
}

.content p:nth-child(3) {
  margin-top: 20px;
  font-weight: bold;
}

.table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
  justify-content: center;
  display: flex;
  padding-right: 250px;
  
}
.update{
  justify-content: center;

}
.update h4,h5{
  margin-left: 350px;
 text-align: center;
 padding-right: 350px;
}

tr,td,th {
  border: 1px solid #ddd;
  padding: 8px;
  
}

input[type="text"] {
  width: 350px;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  justify-content: center;
}
input[type="submit"] {
  background-color: #4caf50;
  color: white;
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
input[type="submit"]:hover {
  background-color: #45a049;
}
/* end add movie css */


</style>
<body>
  <?php include ('header.php'); ?>
  <div class="content">
    <p>Welcome to the admin dashboard. Here, you can manage various aspects of the movie ticket booking system.</p><br>
    <p>Let's Start to Manage the Admin Dashboard</p><br>
  </div>
</body>
</html>
