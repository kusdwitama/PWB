<?php
session_start();
if (isset($_SESSION['username'])) {
  header('Location: index2.php');~
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign in to GitHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white h-screen flex items-center justify-center">
  <div class="w-full max-w-sm">
    <div class="flex justify-center mb-6">
      <img src="https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png" alt="GitHub" class="w-12">
    </div>
    <form class="bg-gray-800 p-6 rounded shadow" action="signin.php" method="post">
      <h2 class="text-center text-xl mb-4">Sign in to GitHub</h2>
      <label class="block text-sm mb-2" for="username">Username or email address</label>
      <input name="username" id="username" type="text" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white mb-4" required>

      <div class="flex justify-between items-center">
        <label class="text-sm" for="password">Password</label>
        <a href="#" class="text-sm text-blue-500 hover:underline">Forgot password?</a>
      </div>
      <input name="password" id="password" type="password" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white mb-4" required>

      <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded">Sign in</button>
    </form>
    <div class="bg-gray-800 p-4 mt-4 text-center text-sm rounded">
      New to GitHub? <a href="signin.php" class="text-blue-500 hover:underline">Create an account</a>
    </div>
  </div>
</body>
</html>
