<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>YouTube Clone - CRUD</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="https://www.youtube.com/s/desktop/6a6c93dd/img/favicon.ico">
</head>
<body class="bg-gray-100 text-gray-800">
  <!-- Navbar -->
  <div class="flex items-center justify-between p-4 bg-white shadow">
    <div class="flex items-center space-x-4">
      <img src="https://www.youtube.com/s/desktop/6a6c93dd/img/favicon_32x32.png" class="h-6 w-6" alt="YouTube Logo">
      <span class="font-bold text-xl">YouTube</span>
    </div>
    <div class="flex-grow max-w-lg mx-4">
      <input type="text" placeholder="Search" class="w-full px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring">
    </div>
    <div class="flex items-center space-x-4">
      <button class="bg-gray-100 p-2 rounded-full hover:bg-gray-200">
        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
          <path d="M21 8V7l-3 2-2-1-4 4-2-2-5 6h16z"/>
        </svg>
      </button>
      <div class="bg-gray-300 w-8 h-8 rounded-full"></div>
    </div>
  </div>

  <!-- Sidebar & Content -->
  <div class="flex">
    <!-- Sidebar -->
    <div class="w-1/6 bg-white p-4 shadow hidden md:block">
      <ul class="space-y-4 text-sm">
        <li class="font-semibold">Home</li>
        <li>Trending</li>
        <li>Subscriptions</li>
        <hr>
        <li>Library</li>
        <li>History</li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-4">
      <h2 class="text-xl font-semibold mb-4">Recommended</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <!-- Example Video Card -->
        <?php for ($i = 1; $i <= 8; $i++): ?>
        <div class="bg-white shadow rounded overflow-hidden">
          <img src="https://i.ytimg.com/vi/dQw4w9WgXcQ/hqdefault.jpg" alt="Thumbnail" class="w-full h-40 object-cover">
          <div class="p-3">
            <h3 class="font-semibold text-sm">Sample Video Title <?= $i ?></h3>
            <p class="text-xs text-gray-500">Channel Name • 1M views • 1 day ago</p>
          </div>
        </div>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</body>
</html>
