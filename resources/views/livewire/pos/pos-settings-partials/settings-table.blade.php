<div class="overflow-y-auto max-h-60">
    <table class="w-full text-sm">
        <thead class="sticky top-0 bg-resto-purple-dark text-white">
            <tr>
                <th class="p-2 text-left w-10">No.</th>
                <th class="p-2 text-left">Nama</th>
                <th class="p-2 text-left">Nilai</th>
                <th class="p-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($presets as $index => $preset)
                <tr class="border-t">
                    <td class="p-2">{{ $loop->iteration }}</td>
                    <td class="p-2 font-medium">{{ $preset['name'] }}</td>
                    <td class="p-2">
                        @if ($preset['type'] === 'percentage')
                            {{ $preset['value'] }} %
                        @else
                            Rp {{ $preset['value'] }}
                        @endif
                    </td>
                    <td class="p-2 text-center space-x-0.5">
                        {{-- Tombol Terapkan/Pilih (Icon Plus) --}}
                        <button wire:click="applySetting({{ $index }})" class="text-blue-600 hover:text-blue-800"
                            title="Terapkan">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>

                        {{-- Tombol Hapus (Icon Tempat Sampah) --}}
                        <button wire:click="deleteSetting({{ $index }})" class="text-red-600 hover:text-red-800"
                            title="Hapus">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-500 py-4">Belum ada pilihan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
