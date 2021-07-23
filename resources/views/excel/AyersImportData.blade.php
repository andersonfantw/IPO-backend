<table>
    <thead>
        <tr>
            @foreach ($Headers as $Header)
                <th>{{ $Header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($AyersImportDatas as $AyersImportData)
            <tr>
                @foreach ($Headers as $Header)
                    <td>{{ $AyersImportData[$Header] }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
