<form enctype="multipart/form-data" method="get" action="{{$url}}">
    <input id="senderid" type="text" value="CYSS" />
    <input id="recipient" type="text" value="" />
    <input id="content" type="text" value="" />
    <input id="dos " type="hidden" value="now" />
    <input id="username" type="hidden" value="{{$username}}" />
    <input id="password" type="hidden" value="{{$password}}" />
    <input id="langeng" type="hidden" value="0" />
    <button type="submit">發送簡訊</button>
</form>