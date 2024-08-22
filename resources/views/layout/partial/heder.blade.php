  <nav class="fixed flex justify-between py-6 w-full lg:px-48 md:px-12 px-4 content-center bg-secondary z-10">
    <div class="flex items-center">
      <img src='{{ asset('images/logo-brand-black.png') }}' alt="Logo" class="h-8 w-auto" />
    </div>
    <ul class="font-montserrat items-center hidden md:flex">
      <li class="mx-3 ">
        <a class="growing-underline" href="#">
          Home
        </a>
      </li>
      <li class="growing-underline mx-3">
        <a href="#jadwal">jadwal</a>
      </li>
      <li class="growing-underline mx-3">
        <a href="#kegiatan">kegiatan</a>
      </li>
      </li>
      {{-- <li class="growing-underline mx-3">
        <a href="#dokumentasi">dokumentasi</a>
      </li> --}}
    </ul>
    <div class="font-montserrat hidden md:block">
      <a href="admin/login">
          
        <button class="mr-6 growing-underline mx-3 font-bold">Login</button>
        </a>
    </div>
    <div id="showMenu" class="md:hidden">
      <img src='dist/assets/logos/Menu.svg' alt="Menu icon" />
    </div>
  </nav>
  <div id='mobileNav' class="hidden px-4 py-6 fixed top-0 left-0 h-full w-full bg-secondary z-20 animate-fade-in-down">
    <div id="hideMenu" class="flex justify-end">
      <img src='dist/assets/logos/Cross.svg' alt="" class="h-16 w-16" />
    </div>
    <ul class="font-montserrat flex flex-col mx-8 my-24 items-center text-3xl">
      <li class="my-6 growing-underline mx-3">
        <a href="#">Home</a>
      </li>
      <li class="my-6 growing-underline mx-3">
        <a href="#jadwal">jadwal</a>
      </li>
      <li class="my-6 growing-underline mx-3">
        <a href="#kegiatan">kegiatan</a>
      </li>
      {{-- <li class="my-6 growing-underline mx-3">
        <a href="#dokumentasi">dokumentasi</a>
      </li> --}}
      <li class="my-6 growing-underline mx-3">
         <a href="admin/login">
          {{-- <button class="px-6 py-4 border-2 border-black border-solid rounded-lg bg-white text-black font-bold transition duration-300 mr-6 focus:outline-none focus:ring-2 focus:ring-black hover:bg-black hover:text-white hover:border-black">Login</button> --}}
        <button class="mr-6 growing-underline mx-3 font-bold">Login</button>
        </a>
      </li>
    </ul>
  </div>
