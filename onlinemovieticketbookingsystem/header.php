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
