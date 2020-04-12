<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Area</th>
            <th>Tanggal Kejadian</th>
            <th>Tanggal Berakhir</th>
            <th>Ketinggian Air</th>
            <th>Jenis Banjir</th>
            <th>Kerusakan</th>
            <th>Jumlah Korban</th>
            <th>deskripsi perkiraan penyebab</th>
            <th>Status</th>
            <th>Koordinat</th>
        </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($fields as $item)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $item->area_name }}</td>
            <td>{{ $item->event_start }}</td>
            <td>{{ $item->event_end }}</td>
            <td>{{ $item->water_level }}</td>
            <td>{{ $item->flood_type }}</td>
            <td>{{ $item->damage }}</td>
            <td>{{ $item->civilians }}</td>
            <td>{{ $item->description }}</td>
            <td>{{ $item->status }}</td>
            <td>{{ $item->geometries->coordinates }}</td>
        </tr>
    @endforeach
    </tbody>
</table>