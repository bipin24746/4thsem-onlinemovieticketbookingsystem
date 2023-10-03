
<?php

require_once "connection.php";

// Initialize error variables
$emailErr = $passwordErr = $cpasswordErr = $phoneErr = "";

// Check if the registration form is submitted
if (isset($_POST['signupBtn'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $phone = $_POST['phone'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }

    // Check if the email already exists in the database
    $existing_email_query = "SELECT email FROM user WHERE email = '$email'";
    $result = $conn->query($existing_email_query);
    if ($result->num_rows > 0) {
        $emailErr = "Email already exists.";
    }

    // Validate password length
    if (strlen($password) < 6 || strlen($password) > 16) {
        $passwordErr = "Password must be between 6 and 16 characters long.";
        
    }

    // Check if password and confirm password match
    if ($password !== $cpassword) {
        $cpasswordErr = "Passwords do not match.";
    }

    // If there are no errors, proceed with the registration process
    if (empty($emailErr) && empty($passwordErr) && empty($cpasswordErr)) {
        $hashedNewPassword = password_hash($password, PASSWORD_DEFAULT);
        // Insert user data into the database
        $sql = "INSERT INTO user (fname, lname, email, password, phone) VALUES ('$fname', '$lname', '$email', '$hashedNewPassword', '$phone')";
        if ($conn->query($sql) === true) {
            header('location: login.php');
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}


?>
<style>
/* styles.css */

.custom-nav {
background-color: #333;
color: #fff;
font-weight: bold;
padding-left: 1rem;

}

.containernav {
max-width: 1200px;
margin: 0 auto;
padding: 1rem;

}
.registernav{
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
<div class="containernav">
<div class="registernav">
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
        session_start();
        if (isset($_SESSION['email'])) {
            echo '<li class="menu-item">
                    <a href="logout.php" class="menu-link">Logout</a>
                  </li>';
        } else {
            
            echo '<li class="menu-item">
                    <a href="login.php" class="menu-link">Login</a>
                  </li>';
        }
        ?>
    </ul>
</div>
</div>
</div>
<link rel="stylesheet" href="style.css">
<div class="container">
    <div class="form-box">
        <h1 id="Title">Sign Up</h1>
        <h2>LET'S ENJOY MOVIE WORLD</h2>
        <form action="register.php" method="POST">
            <div class="input-group">
                <div class="input-field">
                    <input type="text" placeholder="Enter First Name" id="fname" name="fname" required value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>"><br>
                </div>
                <div class="input-field">
                    <input type="text" placeholder="Enter Last Name" id="lname" name="lname" required value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>"><br>
                </div>

                <!-- Display error message for email -->
                <div class="input-field">
                    <input type="email" placeholder="Enter your Email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"><br>
                </div>
                <div class="error"><?php echo $emailErr; ?></div>

                <!-- Display error message for password -->
                <div class="input-field">
                    <input type="password" placeholder="Enter Your Password" id="password" name="password" required><br>
                </div>
                <div class="error"><?php echo $passwordErr; ?></div>

                <!-- Display error message for confirm password -->
                <div class="input-field">
                    <input type="password" placeholder="Confirm Password" id="cpassword" name="cpassword" required><br>
                </div>
                <div class="error"><?php echo $cpasswordErr; ?></div>

                <!-- Display error message for phone -->
                <div class="input-field">
                    <input type="contact" placeholder="Enter Your Phone Number" id="phone" name="phone" required value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>"><br>
                </div>
                <div class="error"><?php echo $phoneErr; ?>
                </div>

                <div class="SignUp-link">
                    <button type="submit" name="signupBtn">Sign Up</button>
                    <br>
                </div>
                <p>Already have an account? <a href="login.php">Sign in</a></p>
            </div>
        </form>
    </div>
</div>
