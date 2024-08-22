<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @vite('resources/css/app.css')
  <title>PosyanduBu</title>
  <link rel="stylesheet" href="dist/styles.css" />
  {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
  <script src="dist/script.js"></script>
</head>

<body>
  <!-- Navigation -->
@include('layout.partial.heder')
 
  
  <!-- Hero -->
  <section
    class="pt-24 md:mt-0 md:h-screen flex flex-col justify-center text-center md:text-left md:flex-row md:justify-between md:items-center lg:px-48 md:px-12 px-4 bg-secondary">
    <div class="md:flex-1 md:mr-10">
      <h1 class="font-pt-serif text-5xl font-bold mb-7">
        Ayok periksa keluarga anda,
        <span class=" bg-left-bottom bg-no-repeat pb-2 bg-100%">
          balita sehat ibu hebat.
        </span>
      </h1>
      <p class="font-pt-serif font-normal mb-7">
        {{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum harum --}}
        {{-- tempore consectetur voluptas, cumque nobis laboriosam voluptatem. --}}
        Posyandu (Pos Pelayanan Terpadu) adalah program kesehatan masyarakat yang didirikan
        oleh pemerintah Indonesia untuk meningkatkan kesehatan ibu dan anak di wilayah perkotaan
        dan pedesaan. 
      </p>
      <div class="font-montserrat hidden md:block">
        {{-- <button class="bg-black px-6 py-4 rounded-lg border-2 border-black border-solid text-white mr-2 mb-2">
          Saran
        </button> --}}
        {{-- <button class="px-6 py-4 border-2 border-black border-solid rounded-lg"> --}}
             {{-- <button class="px-6 py-4 border-2 border-black border-solid rounded-lg bg-white text-black font-bold transition duration-300 mr-6 focus:outline-none focus:ring-2 focus:ring-black hover:bg-black hover:text-white hover:border-black">Get started</button> --}}
          {{-- get started
        </button> --}}
      </div>
    </div>
    <div class="flex justify-around md:block mt-8 md:mt-0 md:flex-1">
      <div class="relative">
        <img src='dist/assets/Highlight1.svg' alt="" class="absolute -top-8 -left-9" />
      </div>
      {{-- <img src='dist/assets/MacBook Pro.png' alt="Macbook" /> --}}
      <img src='dist/assets/png image hero.png' alt="hero"/>
      <div class="relative">
        <img src='dist/assets/Highlight2.svg' alt="" class="absolute -bottom-9 -right-0 -left-auto" />
      </div>
    </div>
  </section>

  <!-- jadwal posyandu -->
  <section class="bg-black text-white sectionSize" id="jadwal" style="padding-top: 6rem">
    <div>
      <h2 class="secondaryTitle bg-underline2 bg-100%">Jadwal & lokasi posyandu</h2>
    </div>
    {{-- bagian satu --}}
    <div class="flex flex-col md:flex-row">
      <div class="flex-1 mx-8 flex flex-col items-center my-4">
        <div class="border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
          1
        </div> 
        <h3 class="font-montserrat font-medium text-xl mb-2">Hujan gerimis satu</h3>
        <p class="text-center font-montserrat">
          setiap tanggal 8, lokasi di rumah ibuk saenah beak daya
        </p>
      </div>
      <div class="flex-1 mx-8 flex flex-col items-center my-4">
        <div class="border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
          2
        </div>
        <h3 class="font-montserrat font-medium text-xl mb-2">Hujan gerimis dua</h3>
        <p class="text-center font-montserrat">
          Stiap tanggal 10, lokasi di rumah pak RT dusun beak daya
        </p>
      </div>
      <div class="flex-1 mx-8 flex flex-col items-center my-4">
        <div class="border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
          3
        </div>
        <h3 class="font-montserrat font-medium text-xl mb-2">posyandu dua bersaudara</h3>
        <p class="text-center font-montserrat">
          setiap tanggal 12 lokasi di rumah kepala wilayah dusun beak lauk
        </p>
      </div>
    </div>
    {{-- bagian dua --}}
    <div class="flex flex-col md:flex-row">
      <div class="flex-1 mx-8 flex flex-col items-center my-4">
        <div class="border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
          4
        </div>
        <h3 class="font-montserrat font-medium text-xl mb-2">Mekar sari satu</h3>
        <p class="text-center font-montserrat">
          Setiap tanggal 13 lokasi rumah bapak pak RT dusun Baret Orong.
        </p>
      </div>
      <div class="flex-1 mx-8 flex flex-col items-center my-4">
        <div class="border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
          5
        </div>
        <h3 class="font-montserrat font-medium text-xl mb-2">Mekar sari dua</h3>
        <p class="text-center font-montserrat">
          Setiap tanggal 14 lokasi rumah bapak pak RT dusun Terutuk.
        </p>
      </div>
      <div class="flex-1 mx-8 flex flex-col items-center my-4">
        <div class="border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
          6
        </div>
        <h3 class="font-montserrat font-medium text-xl mb-2">Segar wangi satu</h3>
        <p class="text-center font-montserrat">
          Setipa tanggal 15 lokasi rumah pak RT dusun jorong daya satu.
        </p>
      </div>
    </div>
    {{-- bagian tiga --}}
    <div class="flex flex-col md:flex-row">
      <div class="flex-1 mx-8 flex flex-col items-center my-4">
        <div class="border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
          7
        </div>
        <h3 class="font-montserrat font-medium text-xl mb-2">segar wangi dua</h3>
        <p class="text-center font-montserrat">
          Setiap tanggal 19 lokasi rumah pak RT dusun jorong daya dua.
        </p>
      </div>
      <div class="flex-1 mx-8 flex flex-col items-center my-4">
        <div class="border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
          8
        </div>
        <h3 class="font-montserrat font-medium text-xl mb-2">Mekar sari</h3>
        <p class="text-center font-montserrat">
          Setiap tanggal 20 lokasi rumah pak RT dusun jorong daya dua.
        </p>
      </div>
      <div class="flex-1 mx-8 flex flex-col items-center my-4">
        <div class="border-0 rounded-full  text-black h-12 w-12 flex justify-center items-center mb-3">
          
        </div>
        <h3 class="font-montserrat font-medium text-xl mb-2"></h3>
        <p class="text-center font-montserrat">
        </p>
      </div>
    </div>
  </section>

  <!-- kegiatan -->
  <section class="sectionSize bg-secondary" id="kegiatan" style="padding-top: 6rem">
    <div>
      <h2 class="secondaryTitle bg-underline3 bg-100%">kegiatan</h2>
    </div>
    <div class="md:grid md:grid-cols-2 md:grid-rows-2">

      <div class="flex items-start font-montserrat my-6 mr-10">
        <img src='dist/assets/logos/Heart.svg' alt='' class="h-7 mr-4" />
        <div>
          <h3 class="font-semibold text-2xl">Pendaftaran #1</h3>
          <p>
            Tahap awal di Posyandu di mana individu atau keluarga 
            mendaftar untuk mendapatkan layanan kesehatan.
            Pendaftaran ini penting untuk mencatat data penerima
            layanan kesehatan dan mempermudah pemantauan kesehatan
            secara individu.
          </p>
        </div>
      </div>

      <div class="flex items-start font-montserrat my-6 mr-10">
        <img src='dist/assets/logos/Heart.svg' alt='' class="h-7 mr-4" />
        <div>
          <h3 class="font-semibold text-2xl">Penimbangan & Pengukuran #2</h3>
          <p>
            Dilakukan untuk memantau perkembangan kesehatan, Baik pada 
            balita, ibu hamil dan lansia.Penimbangan dan pengukuran ini
            membantu dalam mendeteksi masalah kesehatan yang mungkin
            timbul atau pemantauan kesehatan secara keseluruhan.
          </p>
        </div>
      </div>

      <div class="flex items-start font-montserrat my-6 mr-10">
        <img src='dist/assets/logos/Heart.svg' alt='' class="h-7 mr-4" />
        <div>
          <h3 class="font-semibold text-2xl">Pencatatan dan Pemeriksaan #3</h3>
          <p>
            Proses pencatatan data kesehatan yang penting untuk melacak riwayat
            kesehatan peserta posyandu. Pemeriksaan dilakukan untuk menilai kondisi
            kesehatan secara menyeluruh dan mendeteksi masalah kesehatan
            yang perlu penanganan lebih lanjut.
          </p>
        </div>
      </div>

      <div class="flex items-start font-montserrat my-6 mr-10">
        <img src='dist/assets/logos/Heart.svg' alt='' class="h-7 mr-4" />
        <div>
          <h3 class="font-semibold text-2xl">Pelayanan Kesehatan & Penyuluhan #4</h3>
          <p>
            Memberikan pelayanan kesehatan yang meliputi imunisasi, pengobatan
            sederhana, dan konsultasi kesehatan.Penyuluhan tentang kesehatan, 
            gizi, dan perawatan anak juga menjadi bagian penting dari
            pelayanan Posyandu.
          </p>
        </div>
      </div>

    </div>
  </section>

  <!-- dokumentasi -->
  {{-- <section class="sectionSize bg-secondary py-0" id="dokumentasi"> --}}
    {{-- <div>
      <h2 class="secondaryTitle bg-underline4 mb-0 bg-100%">Dokumentasi</h2>
    </div>
    <div class="flex w-full flex-col md:flex-row"> --}}

      {{-- <div class='flex-1 flex flex-col mx-6 shadow-2xl relative bg-secondary rounded-2xl py-5 px-8 my-8 md:top-24 '> --}}
     {{-- <h3 class="font-pt-serif font-normal text-2xl mb-4">
          The Good
        </h3> --}}
        {{-- <img src="{{ asset('images/konten1.jpg') }}" alt=""> --}}
        {{-- <h3 class="font-pt-serif font-normal text-2xl mb-4">
          The Good
        </h3>
        <div class="font-montserrat font-bold text-2xl mb-4">
          $25
          <span class="font-normal text-base"> / month</span>
        </div>

        <div class="flex">
          <img src='dist/assets/logos/CheckedBox.svg' alt="" class="mr-1" />
          <p>Benefit #1</p>
        </div>
        <div class="flex">
          <img src='dist/assets/logos/CheckedBox.svg' alt="" class="mr-1" />
          <p>Benefit #2</p>
        </div>
        <div class="flex">
          <img src='dist/assets/logos/CheckedBox.svg' alt="" class="mr-1" />
          <p>Benefit #3</p>
        </div> --}}
        {{-- <button class=" border-2 border-solid border-black rounded-xl text-lg py-3 mt-4">
          Choose plan
        </button> --}}
       {{-- </div>  --}}

      {{-- <div class='flex-1 flex flex-col mx-6 shadow-2xl relative bg-secondary rounded-2xl py-5 px-8 my-8 md:top-12'>
        <h3 class="font-pt-serif font-normal text-2xl mb-4">
          The Bad
        </h3>
        <div class="font-montserrat font-bold text-2xl mb-4">
          $40
          <span class="font-normal text-base"> / month</span>
        </div>

        <div class="flex">
          <img src='dist/assets/logos/CheckedBox.svg' alt="" class="mr-1" />
          <p>Benefit #1</p>
        </div>
        <div class="flex">
          <img src='dist/assets/logos/CheckedBox.svg' alt="" class="mr-1" />
          <p>Benefit #2</p>
        </div>
        <div class="flex">
          <img src='dist/assets/logos/CheckedBox.svg' alt="" class="mr-1" />
          <p>Benefit #3</p>
        </div>

        <button class=" border-2 border-solid border-black rounded-xl text-lg py-3 mt-4">
          Choose plan
        </button>
      </div>

      <div class='flex-1 flex flex-col mx-6 shadow-2xl relative bg-secondary rounded-2xl py-5 px-8 my-8 md:top-24'>
        <h3 class="font-pt-serif font-normal text-2xl mb-4">
          The Ugly
        </h3>
        <div class="font-montserrat font-bold text-2xl mb-4">
          $50
          <span class="font-normal text-base"> / month</span>
        </div>

        <div class="flex">
          <img src='dist/assets/logos/CheckedBox.svg' alt="" class="mr-1" />
          <p>Benefit #1</p>
        </div>
        <div class="flex">
          <img src='dist/assets/logos/CheckedBox.svg' alt="" class="mr-1" />
          <p>Benefit #2</p>
        </div>
        <div class="flex">
          <img src='dist/assets/logos/CheckedBox.svg' alt="" class="mr-1" />
          <p>Benefit #3</p>
        </div>

        <button class=" border-2 border-solid border-black rounded-xl text-lg py-3 mt-4">
          Choose plan
        </button>
      </div>

    </div> --}}
  {{-- </section> --}}

  <!-- FAQ  -->
  {{-- <section class="sectionSize items-start pt-8 md:pt-36 bg-black text-white">
    <div>
      <h2 class="secondaryTitle bg-highlight3 p-10 mb-0 bg-center bg-100%">
        FAQ
      </h2>
    </div>

    <div toggleElement class="w-full py-4">
      <div class="flex justify-between items-center">
        <div question class="font-montserrat font-medium mr-auto">
          Where can I get this HTML template?
        </div>
        <img src='dist/assets/logos/CaretRight.svg' alt="" class="transform transition-transform" />
      </div>
      <div answer class="font-montserrat text-sm font-extralight pb-8 hidden">
        You can download it on Gumroad.com
      </div>
    </div>
    <hr class="w-full bg-white" />

    <div toggleElement class="w-full py-4">
      <div class="flex justify-between items-center">
        <div question class="font-montserrat font-medium mr-auto">
          Is this HTML template free?
        </div>
        <img src='dist/assets/logos/CaretRight.svg' alt="" class="transform transition-transform" />
      </div>
      <div answer class="font-montserrat text-sm font-extralight pb-8 hidden">
        Yes! For you it is free.
      </div>
    </div>
    <hr class="w-full bg-white" />

    <div toggleElement class="w-full py-4">
      <div class="flex justify-between items-center">
        <div question class="font-montserrat font-medium mr-auto">
          Am I awesome?
        </div>
        <img src='dist/assets/logos/CaretRight.svg' alt="" class="transform transition-transform" />
      </div>
      <div answer class="font-montserrat text-sm font-extralight pb-8 hidden">
        Yes! No doubt about it.
      </div>
    </div>
    <hr class="w-full bg-white" />

  </section> --}}
{{-- @yield('content') --}}
  <!-- Footer -->
 @include('layout.partial.footer')
 {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}
</body>
</html>