<!-- components/navbar.php -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<nav class="fixed top-0 left-0 w-full z-50 bg-gray-900 text-white px-6 py-4 flex justify-between items-center border-b border-gray-800 backdrop-blur">
  <div class="flex items-center space-x-6">
    <a href="#" class="text-2xl font-bold">GitHub Clone</a>

    <!-- Product Dropdown -->
    <div x-data="{ open: false }" class="relative">
      <button @click="open = !open" class="hover:underline flex items-center space-x-1">
        <span>Product</span>
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
      </button>
      <div x-show="open" @click.away="open = false" class="absolute z-50 left-0 mt-2 w-96 bg-white text-black rounded-md shadow-lg p-6 flex gap-6" x-transition>
        <div class="w-1/2 space-y-4">
          <div><p class="font-semibold">GitHub Copilot</p><p class="text-sm text-gray-600">Write better code with AI</p></div>
          <div><p class="font-semibold">GitHub Security</p><p class="text-sm text-gray-600">Find and fix vulnerabilities</p></div>
          <div><p class="font-semibold">Actions</p><p class="text-sm text-gray-600">Automate workflows</p></div>
          <div><p class="font-semibold">Codespaces</p><p class="text-sm text-gray-600">Instant dev environments</p></div>
        </div>
        <div class="w-1/2 space-y-2 border-l pl-6">
          <p class="font-bold">Explore</p>
          <ul class="text-sm text-gray-700 space-y-1">
            <li><a href="#" class="hover:underline">Why GitHub</a></li>
            <li><a href="#" class="hover:underline">Features</a></li>
            <li><a href="#" class="hover:underline">Docs</a></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Solutions Dropdown -->
    <div x-data="{ open: false }" class="relative">
      <button @click="open = !open" class="hover:underline flex items-center space-x-1">
        <span>Solutions</span>
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
      </button>
      <div x-show="open" @click.away="open = false" class="absolute z-50 left-0 mt-2 w-80 bg-white text-black rounded-md shadow-lg p-4 space-y-2" x-transition>
        <div><p class="font-semibold">Enterprise</p><p class="text-sm text-gray-600">Scale with confidence</p></div>
        <div><p class="font-semibold">Startups</p><p class="text-sm text-gray-600">Accelerate growth</p></div>
        <div><p class="font-semibold">Education</p><p class="text-sm text-gray-600">Support students and teachers</p></div>
      </div>
    </div>

    <!-- Resources Dropdown -->
    <div x-data="{ open: false }" class="relative">
      <button @click="open = !open" class="hover:underline flex items-center space-x-1">
        <span>Resources</span>
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
      </button>
      <div x-show="open" @click.away="open = false" class="absolute z-50 left-0 mt-2 w-80 bg-white text-black rounded-md shadow-lg p-4 space-y-2" x-transition>
        <div><a href="#" class="block font-semibold hover:underline">Docs</a></div>
        <div><a href="#" class="block font-semibold hover:underline">GitHub Skills</a></div>
        <div><a href="#" class="block font-semibold hover:underline">Blog</a></div>
        <div><a href="#" class="block font-semibold hover:underline">Community Forum</a></div>
      </div>
    </div>

    <!-- Open Source Dropdown -->
    <div x-data="{ open: false }" class="relative">
      <button @click="open = !open" class="hover:underline flex items-center space-x-1">
        <span>Open Source</span>
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
      </button>
      <div x-show="open" @click.away="open = false" class="absolute z-50 left-0 mt-2 w-80 bg-white text-black rounded-md shadow-lg p-4 space-y-2" x-transition>
        <div><a href="#" class="block font-semibold hover:underline">GitHub Sponsors</a></div>
        <div><a href="#" class="block font-semibold hover:underline">The ReadME Project</a></div>
        <div><a href="#" class="block font-semibold hover:underline">Collections</a></div>
      </div>
    </div>

    <!-- Enterprise Link -->
    <a href="#" class="hover:underline">Enterprise</a>
  </div>

  <!-- Auth Buttons -->
  <div class="space-x-3 hidden md:flex">
    <a href="login.php" class="hover:underline">Sign in</a>
    <a href="#" class="bg-green-600 px-4 py-1 rounded text-sm font-medium hover:bg-green-500">Sign up</a>
  </div>
</nav>
