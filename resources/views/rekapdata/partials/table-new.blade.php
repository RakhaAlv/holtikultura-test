<tbody>

@foreach($rows as $komoditas)

    <tr class="bg-gray-200">
        <td colspan="16" class="font-bold p-3">
            {{ $komoditas['komoditas'] }}
        </td>
    </tr>

    @foreach($komoditas['provinsi'] as $provinsi)

        <tr>

            <td>
                {{ $provinsi['provinsi'] }}
            </td>

            <td>{{ $provinsi['target'] }}</td>
            <td>{{ $provinsi['realisasi'] }}</td>
            <td>{{ $provinsi['progress'] }}%</td>

            <td colspan="12"></td>

        </tr>

    @endforeach

@endforeach

</tbody>