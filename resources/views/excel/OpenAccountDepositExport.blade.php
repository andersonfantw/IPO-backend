<table>
    <thead>
        <tr>
            @foreach ($Headers as $Header)
                <th>{{ $Header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($OpenAccountDeposits as $Deposit)
            <tr>
                @foreach ($Deposit as $key => $value)
                    <td>{{ $value }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
