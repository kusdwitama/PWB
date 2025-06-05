<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen">
  <nav class="bg-gray-800 p-4 flex justify-between items-center">
    <div class="text-xl font-semibold">Dashboard</div>
    <div>
      <span class="mr-4">👋 <?php echo $_SESSION['username']; ?></span>
      <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded">Logout</a>
    </div>
  </nav>

  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Welcome, <?php echo $_SESSION['username']; ?>!</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div class="bg-gray-800 p-4 rounded shadow">
        <h2 class="text-lg font-semibold mb-2">Repository Stats</h2>
        <p>You have 6 repositories.</p>
      </div>

      <div class="bg-gray-800 p-4 rounded shadow">
        <h2 class="text-lg font-semibold mb-2">Latest Activity</h2>
        <ul class="text-sm list-disc pl-5">
          <li>Pushed code to `technical-test-zihub`</li>
          <li>Created repository `CODINGAN-GUEH`</li>
        </ul>
      </div>

      <div class="bg-gray-800 p-4 rounded shadow">
        <h2 class="text-lg font-semibold mb-2">Explore</h2>
        <a href="#" class="text-blue-400 hover:underline text-sm">Trending Repositories</a><br>
        <a href="#" class="text-blue-400 hover:underline text-sm">Recommended Projects</a>
      </div>
    </div>
  </div>
</body>
</html>
