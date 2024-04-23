<?php
session_start();

// Cek jika user belum login, redirect ke halaman login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <!-- header -->
    <?php include 'header.php'; ?>

    <!-- content -->
    <?php
    // ambil alamat email dari session
    $email = $_SESSION['email'];
    ?>

    <div class="container mx-auto px-4 py-8">
        <!-- profile box -->
        <div class="bg-white rounded-lg shadow-lg p-4 mb-4 flex items-center">
            <!-- avatar border -->
            <div class="bg-gray-200 w-16 h-16 rounded-full overflow-hidden mr-4">
                <img src="https://i.pinimg.com/474x/13/a3/b9/13a3b9e367d03820eb71aeb7dd7bcf26.jpg" alt="Avatar" class="w-full h-full object-cover">
            </div>
            <!-- profile Information -->
            <div>
                <h1 class="text-2xl font-bold mb-2">Welcome!</h1>
                <p>email: <?php echo $email; ?></p>
            </div>
        </div>

        <!-- button logout -->
        <form action="logout.php" method="post">
            <button type="submit" class="mt-4 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Logout</button>
        </form>
    </div>

    <!-- footer -->
    <?php include 'footer.php'; ?>

</body>

</html>