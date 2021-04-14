<table>
    <thead>
        <tr>
            @foreach ($Headers as $key => $value)
                <th>{{ $key }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($AyersImportData as $Data)
            <tr>
                @foreach ($Data->getAttributes() as $key => $value)
                    <td>{{ $value }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
