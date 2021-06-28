<table>
@if (count($data)>0)
    <thead>
        <tr>
            @foreach ($data[0] as $th => $v)
            <th>{{$th}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
    @foreach ($data as $row)
        <tr>
            @foreach ($row as $th => $v)
            <td>{{$v}}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
@endif
</table>