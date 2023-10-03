<!DOCTYPE html>
<html>
<head>
    <title>Movie Trailer</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .trailer-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="trailer-container">
        <?php
        if (isset($_GET['trailer'])) {
            $trailer = $_GET['trailer'];
            echo  $trailer; // Debugging line to check the trailer ID
        }
        
        ?>
    </div>
</body>
</html>
