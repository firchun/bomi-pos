@foreach ($reportData as $index => $item)
    <tr>
        <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
        <td>{{ $item['nama_product'] }}</td>
        <td>{{ $item['jumlah_beli'] }}</td>
        <td>Rp{{ number_format($item['harga_satuan'], 0, ',', '.') }}</td>
        <td>Rp{{ number_format($item['total_harga'], 0, ',', '.') }}</td>
        <td>Rp{{ number_format($item['diskon'], 0, ',', '.') }}</td>
        <td>Rp{{ number_format($item['total_setelah_diskon'], 0, ',', '.') }}</td>
    </tr>
@endforeach