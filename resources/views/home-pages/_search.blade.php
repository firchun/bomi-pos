<section
    class="mt-[30px] flex space-x-4 items-center justify-between bg-white/30 dark:bg-zinc-800/70 rounded-2xl p-5 cursor-pointer"
    onclick="toggleSearchModal()">
    <input type="text"
        class="p-3 border border-purple-700 rounded-2xl w-full bg-white/50 text-purple-700 dark:text-white dark:bg-zinc-800 transition-colors duration-300 cursor-pointer"
        placeholder="Search Outlet or Product" readonly />
</section>

<div id="searchModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center">
    <!-- Modal Box -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl w-full max-w-2xl p-6 mx-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Search outlet or Product</h2>
            <button onclick="toggleSearchModal()" class="text-zinc-500 hover:text-zinc-800 dark:hover:text-white">
                ✕
            </button>
        </div>
        <input type="search"
            class="w-full p-3 border border-purple-700 rounded-2xl text-purple-700 bg-white dark:bg-zinc-800 dark:text-white transition-colors duration-300"
            placeholder="Type to search..." autofocus oninput="handleSearch(this.value)" />
        <!-- Optional: Results -->
        <!-- Optional: Results -->
        <div class="mt-6 space-y-3 search-results">
            <!-- Result item -->


        </div>
    </div>
</div>
@push('js')
    <script>
        function handleSearch(query) {
            const resultsContainer1 = document.querySelector('.search-results');
            if (!query.trim()) return;

            // Tampilkan loading
            resultsContainer1.innerHTML = `
            <div class="p-3 text-center text-sm text-zinc-500 dark:text-zinc-400">Searching...</div>
        `;

            fetch(`/search?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    resultsContainer1.innerHTML = '';
                    let hasResults = false;

                    if (data.products && data.products.length > 0) {
                        data.products.forEach(product => {
                            hasResults = true;
                            resultsContainer1.innerHTML += `
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
                    }

                    if (data.outlets && data.outlets.length > 0) {
                        data.outlets.forEach(outlet => {
                            hasResults = true;
                            resultsContainer1.innerHTML += `
                            <a href="/shop/${outlet.slug}" class="block">
                                <div class="flex items-center justify-between p-3 bg-zinc-100 dark:bg-zinc-800 rounded-xl transition hover:bg-purple-100 dark:hover:bg-purple-900 cursor-pointer">
                                    <div>
                                        <div class="text-zinc-800 dark:text-white font-medium">${outlet.name}</div>
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400">Outlet</div>
                                    </div>
                                    <div class="text-purple-700 font-semibold text-sm">
                                        <i class="bi bi-pin-map-fill mr-3"></i> ${outlet.address || '-'}
                                    </div>
                                </div>
                            </a>
                        `;
                        });
                    }

                    if (!hasResults) {
                        resultsContainer1.innerHTML = `
                        <div class="p-3 text-center text-sm text-zinc-500 dark:text-zinc-400">No results found</div>
                    `;
                    }
                })
                .catch(err => {
                    resultsContainer1.innerHTML = `
                    <div class="p-3 text-center text-sm text-red-500">An error occurred during the search</div>
                `;
                    console.error('Search error:', err);
                });
        }
    </script>
@endpush
