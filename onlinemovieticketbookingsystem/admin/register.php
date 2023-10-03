<?php

$servername = "localhost";
$username = "root";
$dbname = "moviebooking";

//create connection
$conn = new mysqli($servername, $username, "", $dbname);

//checking
if($conn->connect_error){
    die('connection failed ' .$conn->connect_error);
}else{
    echo '';
}

//process of submission
if(isset($_POST['signupBtn'])) {

    //get data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $phone = $_POST['phone'];

    $hashedNewPassword = password_hash($password, PASSWORD_DEFAULT);
    //inserting
    $sql = " INSERT INTO admin(name, email, password, phone) VALUES('$name', '$email', '$hashedNewPassword','$phone')";
if(!$password == $cpassword)
{
    echo"password is not same";
}elseif ($conn->query($sql) === true) {
        header ('location: login.php');
} else {
        echo "Error: " .$conn->error;
}
}
?>

<?php
include('header.php');

?>
<link rel="stylesheet" href="style.css">
    <div class="container">
        <div class="form-box">
           <h1 id="Title">Register</h1>
    <form action="register.php" method="POST">
    <div class="input-group">
            <div class="input-field">
                <input type="text" placeholder="Enter Your Name" id="name" name="name" required><br>
            </div>
            <div class="input-field">
            <input type="email" placeholder=" Enter your Email" id="email" name="email" required><br>
        </div>
        <div class="input-field">
            <input type="password" placeholder="Enter Your Password" id="password" name="password" required><br>
        </div>
        <div class="input-field">
            <input type="password" placeholder="Confirm Password" id="cpassword" name="cpassword" required><br>
        </div>
        <div class="input-field">
            <input type="contact" placeholder="Enter Your Phone Number" id="phone" name="phone" required><br>
        </div>
        <div class="SignUp-link">
                    <button type="submit" name="signupBtn">Sign Up</button>
                    <br>
                    </div>
                   <p>Already have an account.....? <a href="login.php">Sign in</a></p>
        </div>
    </form>
</body>
</html>