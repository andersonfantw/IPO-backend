<table>
    <thead>
        <tr>
            @foreach ($Headers as $Header)
                <th>{{ $Header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($Datas as $Data)
            <tr>
                @foreach ($Headers as $Header)
                    <td>{{ $Data[$Header] }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
