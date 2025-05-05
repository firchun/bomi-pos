@extends('layouts.home2')



@section('content')
    <div class="container mx-auto px-4">
        <!-- broadcom -->
        <section
            class="mt-[110px] rounded-2xl bg-white/50 text-purple-700 dark:text-white dark:bg-zinc-800/70 transitions-colors duration-300 p-5 w-full">
            Home / Bomi Product
        </section>

        <!-- hero -->
        <section id="hero"
            class="mb-[100px] mt-[50px] relative w-full h-auto overflow-hidden rounded-[20px] 
         bg-gradient-to-br from-fuchsia-100 to-purple-200 
         dark:from-zinc-900/50 dark:to-zinc-600/50  dark:backdrop-blur-sm
         px-6 py-12 md:py-20 lg:py-28 transition-colors duration-300">
            <div class="container mx-auto relative z-10">
                <!-- Heading -->
                <h1
                    class="text-zinc-700 text-3xl sm:text-4xl lg:text-5xl font-extrabold font-['Lexend'] max-w-xl mb-6 dark:text-white transition-colors duration-300">
                    Make Cashier Tasks Easier with Bomi POS — Every Transaction Done in Seconds!
                </h1>

                <!-- Subheading -->
                <p
                    class="text-zinc-600 text-base sm:text-lg lg:text-xl font-semibold font-['Lexend'] max-w-2xl mb-8 dark:text-zinc-400">
                    We’ve gathered the best features to support your cashier operations. Choose the perfect solution for
                    your
                    business—quickly and easily!
                </p>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{route('register')}}"
                        class="w-full sm:w-56 h-14 bg-purple-700 rounded-[20px] flex items-center justify-center text-white text-lg sm:text-xl font-semibold font-['Lexend'] transition-all duration-300 hover:scale-105">
                        Get Started Free
                    </a>
                    <a href="#"
                        class="w-full sm:w-64 h-14 bg-neutral-900 rounded-[20px] flex items-center justify-center 
         text-white text-lg sm:text-xl font-semibold font-['Lexend'] 
         transition-all duration-300 transform hover:scale-105 
         dark:bg-white dark:text-neutral-900">
                        Download Now
                        <i class="bi bi-google-play ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Image -->
            <img src="{{ asset('home2') }}/assets/img/hero-image2.png" alt="Bomi POS illustration"
            class="absolute right-10 bottom-10 h-3/4 hidden lg:block rounded-lg  object-contain opacity-80 pointer-events-none" />

            <!-- Spotlight gelap -->
            <div id="spotlight"
                class="pointer-events-none absolute w-96 h-96 rounded-full bg-black/25 blur-3xl opacity-0 z-10 transition-opacity duration-300 ease-out mix-blend-multiply">
            </div>
        </section>
        <!-- pricing -->
        <section class="mt-20 container mx-auto px-4 h-full"  x-data="{ tab: 'account' }">
            <!-- Heading -->
            <div
                class="text-center text-zinc-700 text-3xl font-extrabold font-['Lexend'] mb-5 dark:text-white transition-colors duration-300">
                Bomi Products for Your Smarter
                <br>Cashier System
            </div>
            <p>
            <div
                class="text-center justify-start text-neutral-500 dark:text-neutral-200 text-lg font-medium font-['Lexend'] mb-5">
                Complete POS solution from Bomi for fast transactions, <br />organized stock, and automated reports</div>
            </p>

            <!-- Tabs -->
            <div class="flex justify-center items-center gap-4 mb-8">
              <div class="bg-white rounded-3xl px-3 py-2 flex gap-4 items-center dark:bg-neutral-800 transition-colors duration-300">
                  
                  <!-- Tab: Account -->
                  <div id="tab-account"
                      @click="tab = 'account'"
                      :class="tab === 'account' ? 'bg-fuchsia-300 dark:bg-neutral-500/50' : 'bg-transparent'"
                      class="tab-button rounded-2xl px-4 py-2 cursor-pointer flex items-center gap-2 transition-colors duration-300">
                      <i class="bi bi-people text-purple-700 text-xl dark:text-white transition-colors duration-300"></i>
                      <span class="text-purple-700 text-xl font-semibold font-['Lexend'] dark:text-white transition-colors duration-300">
                          Account
                      </span>
                  </div>
          
                  <!-- Tab: Devices -->
                  <div id="tab-devices"
                      @click="tab = 'devices'"
                      :class="tab === 'devices' ? 'bg-fuchsia-300 dark:bg-neutral-500/50' : 'bg-transparent'"
                      class="tab-button rounded-2xl px-4 py-2 cursor-pointer flex items-center gap-2 transition-colors duration-300">
                      <i class="bi bi-laptop text-purple-700 text-xl dark:text-white transition-colors duration-300"></i>
                      <span class="text-purple-700 text-xl font-semibold font-['Lexend'] dark:text-white transition-colors duration-300">
                          Devices
                      </span>
                  </div>
              </div>
          </div>

            <!--price -->
            <div class="flex justify-center py-10 px-10 mx-auto mb-10 transition duration-300"  x-show="tab === 'account'" >
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl w-full" >
                    <!-- Free Account -->
                    <div
                        class="bg-gradient-to-br from-fuchsia-400 to-purple-400 dark:from-fuchsia-700/30 dark:to-purple-800/30 rounded-3xl p-6 h-full text-white  flex flex-col justify-between w-full sm:w-3/4 ">
                        <!-- Konten Atas -->
                        <div>
                            <h3 class="text-xl font-bold text-purple-700 dark:text-purple-300">Free Account</h3>
                            <div class="flex align-star mt-2">
                                <p class="text-6xl font-bold text-white">FREE</p>
                                <span class="ml-2 text-sm font-bold text-neutral-200">/ Lifetime</span>
                            </div>
                            <hr class="my-4 border-white border-t-2 ">
                            <ul class="text-neutral-900 dark:text-neutral-200 font-semibold space-y-2 text-lg">

                                <li><i class="bi bi-check-square-fill text-white"></i> Android Application</li>
                                <li><i class="bi bi-check-square-fill text-white"></i> Dashboard Sales</li>
                                <li><i class="bi bi-check-square-fill text-white"></i> Daily Report</li>
                                <li><i class="bi bi-check-square-fill text-white"></i> Invoice</li>
                                <li><i class="bi bi-check-square-fill text-white"></i> Product List</li>
                                <li><i class="bi bi-check-square-fill text-white"></i> Table Number</li>
                            </ul>
                        </div>
                        <button
                            class="w-full bg-purple-700 py-3  mt-4 rounded-2xl font-bold text-xl hover:bg-white/50 hover:text-purple-700 transition duration-300">
                            Get Started
                        </button>

                    </div>
                    <!-- Pro Account -->
                    <div
                        class="bg-gradient-to-br from-fuchsia-400 to-purple-400 dark:from-fuchsia-700/30 dark:to-purple-800/30 rounded-3xl p-6 h-full text-white  flex flex-col justify-between  w-full sm:w-3/4 scale-110 border-4 border-purple-700 shadow-xl shadow-purple-700  dark:shadow-purple-900">
                        <!-- Konten Atas -->
                        <div>
                            <h3 class="text-xl font-bold text-purple-700 dark:text-purple-300">Pro Account</h3>
                            <div class="flex align-star mt-2">
                                <p class="text-6xl font-bold text-white">$$$$</p>
                                <span class="ml-2 text-sm font-bold text-neutral-200">/ Month<br> (Billed Anually)</span>
                            </div>
                            <hr class="my-4 border-white border-t-2 ">
                            <ul class="text-neutral-900 dark:text-neutral-200  font-semibold space-y-2 text-lg">
                                <li><i class="bi bi-check-square-fill text-white"></i> Free Account Feature</li>
                                <li><i class="bi bi-check-square-fill text-white"></i> Advanced Dashboard</li>
                                <li><i class="bi bi-check-square-fill text-white"></i> Finance Management</li>
                                <li><i class="bi bi-check-square-fill text-white"></i> Income & Expenses</li>
                                <li><i class="bi bi-check-square-fill text-white"></i> Ingredient</li>
                                <li><i class="bi bi-check-square-fill text-white"></i> Advanced Report</li>
                            </ul>
                        </div>
                        <button
                            class="w-full bg-white/80 text-purple-700 py-3  mt-4 rounded-2xl font-bold text-xl  transition duration-300">
                            Activate Now
                        </button>

                    </div>
                </div>
            </div>
            <div class="flex justify-center py-10 px-10 mx-auto mb-10 transition duration-300" x-show="tab === 'devices'" >
              <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl w-full" >
                <!-- packet 1 -->
                <div
                    class="bg-gradient-to-br from-fuchsia-400 to-purple-400 dark:from-fuchsia-700/30 dark:to-purple-800/30 rounded-3xl p-6 h-full text-white  flex flex-col justify-between  w-full sm:w-3/4  ">
                    <!-- Konten Atas -->
                    <div>
                        <h3 class="text-xl font-bold text-purple-700 dark:text-purple-300">Packet 1</h3>
                        <div class="flex align-star mt-2">
                            <p class="text-6xl font-bold text-white">Rp 5 Milo</p>
                            {{-- <span class="ml-2 text-sm font-bold text-neutral-200">/ Month<br> (Billed Anually)</span> --}}
                        </div>
                        <hr class="my-4 border-white border-t-2 ">
                        <ul class="text-neutral-900 dark:text-neutral-200  font-semibold space-y-2 text-lg">
                            <li><i class="bi bi-check-square-fill text-white"></i> 1 Tablet Android 8 Inch </li>
                            <li><i class="bi bi-check-square-fill text-white"></i> 1 Stand Tablet </li>
                            <li><i class="bi bi-check-square-fill text-white"></i> 1 Printer Bluetooth Struk Thermal 58mm</li>
                            <li><i class="bi bi-check-square-fill text-white"></i> 1 Bomi Pos Pro Account</li>
                            <li><i class="bi bi-check-square-fill text-white"></i> 6 Month Devices Warranty</li>
                            <li><i class="bi bi-check-square-fill text-white"></i>Initial setup assistance</li>
                        </ul>
                    </div>
                    <button
                            class="w-full bg-purple-700 py-3  mt-4 rounded-2xl font-bold text-xl hover:bg-white/50 hover:text-purple-700 transition duration-300">
                            Order Now
                        </button>
                </div>
                <!-- packet 2 -->
                <div
                    class="bg-gradient-to-br from-fuchsia-400 to-purple-400 dark:from-fuchsia-700/30 dark:to-purple-800/30 rounded-3xl p-6 h-full text-white  flex flex-col justify-between  w-full sm:w-3/4 scale-110 border-4 border-purple-700 shadow-xl shadow-purple-700  dark:shadow-purple-900">
                    <!-- Konten Atas -->
                    <div>
                        <h3 class="text-xl font-bold text-purple-700 dark:text-purple-300">Packet 2</h3>
                        <div class="flex align-star mt-2">
                            <p class="text-6xl font-bold text-white">Rp 8 Milo</p>
                            {{-- <span class="ml-2 text-sm font-bold text-neutral-200">/ Month<br> (Billed Anually)</span> --}}
                        </div>
                        <hr class="my-4 border-white border-t-2 ">
                        <ul class="text-neutral-900 dark:text-neutral-200  font-semibold space-y-2 text-lg">
                            <li><i class="bi bi-check-square-fill text-white"></i> 1 Tablet Android 10 Inch </li>
                            <li><i class="bi bi-check-square-fill text-white"></i> 1 Stand Tablet </li>
                            <li><i class="bi bi-check-square-fill text-white"></i> 1 Printer Bluetooth Struk Thermal 80mm</li>
                            <li><i class="bi bi-check-square-fill text-white"></i> 1 Bomi Pos Pro Account</li>
                            <li><i class="bi bi-check-square-fill text-white"></i> 12 Month Devices Warranty</li>
                            <li><i class="bi bi-check-square-fill text-white"></i>Initial setup assistance</li>
                            <li><i class="bi bi-check-square-fill text-white"></i>Quick Start Training</li>
                        </ul>
                    </div>
                    <button
                        class="w-full bg-white/80 text-purple-700 py-3  mt-4 rounded-2xl font-bold text-xl  transition duration-300">
                        Order Now
                    </button>
                </div>
               
            </div>
            </div>
        </section>
        <section class="container mx-auto px-4 mb-10">
            <div class="max-w-2xl w-full mx-auto">
                <h2 class="text-3xl font-bold text-center text-purple-900 dark:text-purple-200 mb-2">
                    Frequently Asked Questions
                </h2>
                <p class="text-center text-gray-500 dark:text-gray-400 mb-8">
                    Answered all frequently asked questions, Still confused? <br />
                    feel free contact with us
                </p>

                <div x-data="{ selected: null }" class="space-y-4">

                    <!-- FAQ Item -->
                    <div class="border-b border-gray-300 dark:border-gray-600">
                        <button @click="selected !== 1 ? selected = 1 : selected = null"
                            class="w-full text-left py-4 flex justify-between items-center font-semibold text-gray-800 dark:text-white">
                            Do I get free updates?
                            <span class="text-2xl">+</span>
                        </button>
                        <div x-show="selected === 1" x-collapse class="text-gray-600 dark:text-gray-300 pb-4">
                            Yes, Bomi POS provides free updates regularly to ensure better performance, security
                            improvements, and new features for your cafe or retail operations.
                        </div>
                    </div>

                    <!-- FAQ Item -->
                    <div class="border-b border-gray-300 dark:border-gray-600">
                        <button @click="selected !== 2 ? selected = 2 : selected = null"
                            class="w-full text-left py-4 flex justify-between items-center font-semibold text-gray-800 dark:text-white">
                            What does the number of "Projects" refer to?
                            <span class="text-2xl">+</span>
                        </button>
                        <div x-show="selected === 2" x-collapse class="text-gray-600 dark:text-gray-300 pb-4">
                            In Bomi POS, "Projects" refer to the different outlets or business branches you manage using a
                            single account — such as multiple cafes, kiosks, or stores.
                        </div>
                    </div>

                    <!-- FAQ Item -->
                    <div class="border-b border-gray-300 dark:border-gray-600">
                        <button @click="selected !== 3 ? selected = 3 : selected = null"
                            class="w-full text-left py-4 flex justify-between items-center font-semibold text-gray-800 dark:text-white">
                            Can I upgrade to a higher plan?
                            <span class="text-2xl">+</span>
                        </button>
                        <div x-show="selected === 3" x-collapse class="text-gray-600 dark:text-gray-300 pb-4">
                            Absolutely! You can upgrade to the Pro plan anytime to access advanced features such as
                            financial reports, ingredient tracking, and detailed sales analytics.
                        </div>
                    </div>

                    <!-- FAQ Item -->
                    <div class="border-b border-gray-300 dark:border-gray-600">
                        <button @click="selected !== 4 ? selected = 4 : selected = null"
                            class="w-full text-left py-4 flex justify-between items-center font-semibold text-gray-800 dark:text-white">
                            What does "Unlimited Projects" mean?
                            <span class="text-2xl">+</span>
                        </button>
                        <div x-show="selected === 4" x-collapse class="text-gray-600 dark:text-gray-300 pb-4">
                            "Unlimited Projects" means you can create and manage as many outlets or stores as you want
                            within the platform, without any additional charges per location.
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Event listener untuk tombol "Baca Selengkapnya"
            document.querySelectorAll('.view-product').forEach(button => {
                button.addEventListener('click', function() {
                    const name = this.getAttribute('data-name');
                    const description = this.getAttribute('data-description') ||
                        'No description available';
                    const price = parseFloat(this.getAttribute('data-price')).toLocaleString();
                    const photo = this.getAttribute('data-photo') ?
                        `/storage/${this.getAttribute('data-photo')}` :
                        '/images/default-product.png';
                    const phone = this.getAttribute('data-phone');

                    document.getElementById('modalProductName').textContent = name;
                    document.getElementById('modalProductDescription').textContent = description;
                    document.getElementById('modalProductPrice').textContent = price;
                    document.getElementById('modalProductImage').setAttribute('src', photo);

                    if (phone) {
                        const waLink =
                            `https://wa.me/${phone}?text=Halo,%20saya%20tertarik%20dengan%20produk%20${name}`;
                        document.getElementById('modalProductWhatsapp').setAttribute('href',
                            waLink);
                        document.getElementById('modalProductWhatsapp').style.display = 'block';
                    } else {
                        document.getElementById('modalProductWhatsapp').style.display = 'none';
                    }
                });
            });
        });
    </script>
@endpush
