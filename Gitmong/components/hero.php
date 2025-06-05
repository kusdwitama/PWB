<section 
  x-data="{ glow: false }" 
  x-init="window.addEventListener('scroll', () => glow = window.scrollY > 100)" 
  class="pt-24 min-h-screen flex flex-col items-center justify-start bg-gradient-to-b from-gray-900 via-gray-800 to-black text-white px-6 space-y-16"
>
  <!-- Hero content -->
  <div 
    :class="glow ? 'shadow-2xl shadow-purple-500/30 scale-[1.02]' : ''" 
    class="transition-all duration-500 ease-in-out bg-gray-900/80 backdrop-blur-md rounded-xl p-8 max-w-5xl w-full mt-8"
  >
    <h1 class="text-4xl md:text-6xl font-bold mb-4 text-center">
      Build and ship software on a single, collaborative platform
    </h1>
    <p class="text-gray-300 text-center mb-6">
      Join the world’s largest developer platform.
    </p>
    <div class="flex justify-center">
      <input type="email" placeholder="Enter your email" class="px-4 py-2 rounded-l bg-white text-black focus:outline-none">
      <button class="bg-green-600 text-white px-4 py-2 rounded-r hover:bg-green-500">
        Sign up
      </button>
    </div>
  </div>

  <!-- Misi dan Visi Section -->
  <div class="max-w-4xl text-center">
    <h2 class="text-3xl font-semibold mb-2">Our Mission</h2>
    <p class="text-gray-300 mb-6">Empowering every developer to build the future of software through collaboration, openness, and innovation.</p>
    <h2 class="text-3xl font-semibold mb-2">Our Vision</h2>
    <p class="text-gray-300">To be the backbone of open-source and enterprise software development globally.</p>
  </div>

  <!-- Tabs Section -->
  <div x-data="{ tab: 'Code' }" class="w-full max-w-5xl">
    <div class="flex justify-center space-x-4 mb-6 border-b border-gray-600 pb-2">
      <button @click="tab = 'Code'" :class="tab === 'Code' ? 'text-green-400 font-semibold' : 'text-white'">Code</button>
      <button @click="tab = 'Plan'" :class="tab === 'Plan' ? 'text-green-400 font-semibold' : 'text-white'">Plan</button>
      <button @click="tab = 'Collaborate'" :class="tab === 'Collaborate' ? 'text-green-400 font-semibold' : 'text-white'">Collaborate</button>
      <button @click="tab = 'Secure'" :class="tab === 'Secure' ? 'text-green-400 font-semibold' : 'text-white'">Secure</button>
    </div>
    <div class="text-center text-gray-300">
      <div x-show="tab === 'Code'">Powerful code editors, version control, and development tools at your fingertips.</div>
      <div x-show="tab === 'Plan'">Organize, prioritize, and track your work in a centralized workspace.</div>
      <div x-show="tab === 'Collaborate'">Collaborate in real-time with pull requests, issues, and code reviews.</div>
      <div x-show="tab === 'Secure'">Keep your code safe with built-in security and compliance tools.</div>
    </div>
  </div>

  <!-- Scrolling Partner Logos -->
  <div class="overflow-hidden w-full max-w-6xl">
    <div class="flex space-x-10 animate-scroll-left items-center whitespace-nowrap">
      <img src="../assets/img/logoUSM.png" alt="Logo 1" class="h-12">
      <img src="../assets/img/logoUSM.png" alt="Logo 2" class="h-12">
      <img src="../assets/img/logoUSM.png" alt="Logo 3" class="h-12">
      <img src="../assets/img/logoUSM.png" alt="Logo 4" class="h-12">
      <img src="../assets/img/logoUSM.png" alt="Logo 5" class="h-12">
      <img src="../assets/img/logoUSM.png" alt="Logo 1" class="h-12">
      <img src="../assets/img/logoUSM.png" alt="Logo 2" class="h-12">
      <img src="../assets/img/logoUSM.png" alt="Logo 3" class="h-12">
      <img src="../assets/img/logoUSM.png" alt="Logo 1" class="h-12">
      <img src="../assets/img/logoUSM.png" alt="Logo 2" class="h-12">
      <img src="../assets/img/logoUSM.png" alt="Logo 3" class="h-12">
      <img src="../assets/img/logoUSM.png" alt="Logo 1" class="h-12">
      <img src="../assets/img/logoUSM.png" alt="Logo 2" class="h-12">
      <img src="../assets/img/logoUSM.png" alt="Logo 3" class="h-12">
    </div>
  </div>
</section>

<!-- Section: Automate workflow -->
<section class="bg-[#0d1117] text-white py-16 px-6">
  <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
    <div>
      <h2 class="text-2xl font-bold mb-4">Automate any workflow</h2>
      <p class="mb-4">Optimize your process with simple and secured CI/CD.</p>
      <a href="#" class="text-blue-400 hover:underline">Discover GitHub Actions &rarr;</a>
      <ul class="mt-6 space-y-4">
        <li>➕ Get up and running in seconds</li>
        <li>➕ Build on the go</li>
        <li>➕ Integrate the tools you love</li>
      </ul>
    </div>
    <div class="rounded-xl bg-[#161b22] p-6 shadow-2xl" style="box-shadow: 0 0 50px 10px rgba(168, 85, 247, 0.3);">
      <img src="/assets/workflow.png" alt="Workflow preview">
    </div>
  </div>
</section>

<!-- Section: Millions of developers -->
<section class="bg-[#0d1117] text-white py-24 text-center">
  <div class="max-w-3xl mx-auto">
    <h2 class="text-4xl md:text-5xl font-bold mb-6">Millions of developers and businesses call GitHub home</h2>
    <p class="text-gray-400 mb-8">Join the world’s most widely adopted AI-powered developer platform.</p>
    <div class="flex flex-col md:flex-row justify-center gap-4">
      <input type="email" placeholder="Enter your email" class="px-4 py-2 rounded-l bg-white text-black w-full md:w-auto">
      <button class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-500">Sign up for GitHub</button>
    </div>
  </div>
</section>

<style>
@keyframes scroll-left {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.animate-scroll-left {
  animation: scroll-left 30s linear infinite;
}

</style>
