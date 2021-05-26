<table>
    <thead>
        <tr>
            @foreach ($Headers as $Header)
                <th>{{ $Header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($ClientOverseasFundOutRequests as $Request)
            <tr>
                @foreach ($Request as $key => $value)
                    <td>{{ $value }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
