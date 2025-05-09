
<div id="searchNavModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center">
    <!-- Modal Box -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl w-full max-w-2xl p-6 mx-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Search outlet or Product</h2>
            <button onclick="toggleSearchNavModal()" class="text-zinc-500 hover:text-zinc-800 dark:hover:text-white">
                ✕
            </button>
        </div>
        <input type="search"
            class="w-full p-3 border border-purple-700 rounded-2xl text-purple-700 bg-white dark:bg-zinc-800 dark:text-white transition-colors duration-300"
            placeholder="Type to search..." autofocus oninput="handleSearchNav(this.value)" />
        <!-- Optional: Results -->
        <!-- Optional: Results -->
        <div class="mt-6 space-y-3 search-results-navbar">
            <!-- Result item -->


        </div>
    </div>
</div>
@push('js')
    <script>
        function handleSearchNav(query) {
            if (!query.trim()) return;

            fetch(`/search?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    const resultsContainer = document.querySelector('.search-results-navbar');
                    resultsContainer.innerHTML = '';

                    data.products.forEach(product => {
                        resultsContainer.innerHTML += `
                       <a href="/shop/${product.outlet.slug}" class="block">
                            <div class="flex items-center justify-between p-3 bg-zinc-100 dark:bg-zinc-800 rounded-xl transition hover:bg-purple-100 dark:hover:bg-purple-900 cursor-pointer">
                                <div>
                                    <div class="text-zinc-800 dark:text-white font-medium">${product.name}</div>
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">Outlet: ${product.outlet.name || '-'}</div>
                                </div>
                                <div class="text-purple-700 font-semibold text-sm">Rp ${Number(product.price).toLocaleString()}</div>
                            </div>
                        </a>
                    `;
                    });

                    data.outlets.forEach(outlet => {
                      resultsContainer.innerHTML += `
                          <a href="/shop/${outlet.slug}" class="block">
                              <div class="flex items-center justify-between p-3 bg-zinc-100 dark:bg-zinc-800 rounded-xl transition hover:bg-purple-100 dark:hover:bg-purple-900 cursor-pointer">
                                  <div>
                                      <div class="text-zinc-800 dark:text-white font-medium">${outlet.name}</div>
                                      <div class="text-sm text-zinc-500 dark:text-zinc-400">Outlet</div>
                                  </div>
                                  <div class="text-purple-700 font-semibold text-sm">📍 ${outlet.location || '-'}</div>
                              </div>
                          </a>
                      `;
                  });
                });
        }
    </script>
@endpush
