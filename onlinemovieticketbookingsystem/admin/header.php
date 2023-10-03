<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="head bg-gray-900 py-2">
        <h1 class="text-white text-center">Welcome Administrator</h1>
    </div>
    <nav class="flex bg-red-400">
        <ul class="flex w-full text-lg">
            <li class="py-2 border-b border-black flex-grow text-center">
                <a href="addmovies.php" class="block px-4 hover:text-red-600">Add Movies</a>
            </li>
            <li class="py-2 border-b border-black flex-grow text-center">
                <a href="movielist.php" class="block px-4">Movie List</a>
            </li>
            <li class="py-2 border-b border-black flex-grow text-center">
                <a href="booking.php" class="block px-4">Booking List</a>
            </li>
            <li class="py-2 border-b border-black flex-grow text-center">
                <a href="user.php" class="block px-4">Users</a>
            </li>
            <li class="py-2 border-b border-black flex-grow text-center">
                <a href="addcomingsoon.php" class="block px-4">Comingsoon</a>
            </li>
            <li class="py-2 border-b border-black flex-grow text-center">
                <a href="comingsoonlist.php" class="block px-4">Comingsoonlist</a>
            </li>
            <li class="py-2 flex-grow text-center">
                <a href="logout.php" class="block px-4">Logout</a>
            </li>
        </ul>
    </nav>
</body>
</html>
