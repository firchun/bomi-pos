<div x-cloak x-show="$wire.showAddNewSettingModal" @keydown.escape.window="$wire.closeAddNewSettingModal"
    x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">

    <div @click.outside="$wire.closeAddNewSettingModal" class="bg-white rounded-2xl shadow-xl w-full max-w-md">
        <form wire:submit.prevent="saveNewSetting">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">
                        Tambah Pilihan Baru: <span class="capitalize text-resto-purple">{{ $activeSettingsTab }}</span>
                    </h3>
                    <button type="button" @click="$wire.closeAddNewSettingModal()"
                        class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-5">
                    <div>
                        <label for="newSettingName" class="block text-sm font-medium text-gray-700 mb-1">Nama
                            Pengaturan</label>
                        <input type="text" id="newSettingName" wire:model="newSettingName"
                            placeholder="Contoh: PPN, Diskon Member"
                            class="w-full p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-resto-purple-light text-sm">
                        @error('newSettingName')
                            <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="newSettingValue" class="block text-sm font-medium text-gray-700 mb-1">Tipe &
                            Nilai</label>
                        <div class="flex items-center">
                            <input type="number" id="newSettingValue" wire:model="newSettingValue" step="any"
                                placeholder="0"
                                class="flex-grow p-2.5 border border-r-0 border-gray-300 rounded-l-lg focus:outline-none focus:ring-1 focus:ring-resto-purple-light text-sm focus:z-10">

                            @if ($activeSettingsTab === 'tax' || $activeSettingsTab === 'service')
                                <span
                                    class="px-3 py-2.5 bg-gray-100 border border-l-0 border-gray-300 rounded-r-lg text-sm text-gray-600">
                                    %
                                </span>
                            @else
                                <select wire:model.live="newSettingType"
                                    class="p-3 bg-gray-100 border border-l-0 border-gray-300 rounded-r-lg text-sm text-gray-600 focus:outline-none focus:ring-1 focus:ring-resto-purple-light focus:z-10">
                                    <option value="percentage">%</option>
                                    <option value="fixed">Rp</option>
                                </select>
                            @endif
                        </div>
                        @error('newSettingValue')
                            <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 flex items-center space-x-3 rounded-b-2xl">
                <button type="button" wire:click="closeAddNewSettingModal"
                    class="flex-1 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 text-sm">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2.5 rounded-lg bg-resto-purple text-white font-semibold hover:bg-resto-purple-dark text-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
