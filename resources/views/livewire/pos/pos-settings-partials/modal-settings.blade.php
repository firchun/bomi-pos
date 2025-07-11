<div x-cloak x-show="$wire.showSettingsModal" @keydown.escape.window="$wire.showSettingsModal = false" x-transition.opacity
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 flex items-center justify-center p-4">
    <div @click.outside="if (!$wire.showAddNewSettingModal) $wire.showSettingsModal = false" 
         class="bg-white rounded-2xl shadow-xl w-full max-w-lg">
        <div class="p-6">
            <div class="min-h-[20rem]">
                <div x-show="$wire.activeSettingsTab === 'tax'">
                    {{-- 1. Judul di tengahkan dengan text-center --}}
                    <p class="font-semibold mb-4 text-center">Pilih Pajak</p>
                    {{-- 2. Diubah menjadi format tabel --}}
                    @include('livewire.pos.pos-settings-partials.settings-table', ['presets' => $taxPresets])
                </div>
                <div x-show="$wire.activeSettingsTab === 'service'">
                    <p class="font-semibold mb-4 text-center">Pilih Biaya Layanan</p>
                    @include('livewire.pos.pos-settings-partials.settings-table', ['presets' => $servicePresets])
                </div>
                <div x-show="$wire.activeSettingsTab === 'discount'">
                    <p class="font-semibold mb-4 text-center">Pilih Diskon</p>
                    @include('livewire.pos.pos-settings-partials.settings-table', ['presets' => $discountPresets])
                </div>
            </div>
            <div class="mt-4 pt-4 border-t">
                <button wire:click="openAddNewSettingModal" class="w-full bg-resto-purple text-white py-3 rounded-lg font-semibold hover:bg-resto-purple-dark transition-colors">
                    + Tambah Pilihan Baru
                </button>
            </div>
        </div>
    </div>
</div>