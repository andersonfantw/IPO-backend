<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            function sendsms(){
                params = ['senderid','recipient','content','dos','username','password','langeng'];
                o = [];
                for(i=0;i<params.length;i++) o.push(params[i]+'='+$('#'+params[i]).value);
                window.open('{{$url}}?'+o.join('&'));
            }
        </script>
    </head>
    <body>
        <input id="senderid" type="text" value="CYSS" />
        <input id="recipient" type="text" value="" />
        <input id="content" type="text" value="" />
        <input id="dos " type="hidden" value="now" />
        <input id="username" type="hidden" value="{{$username}}" />
        <input id="password" type="hidden" value="{{$password}}" />
        <input id="langeng" type="hidden" value="0" />
        <button onclick="sendsms()">發送簡訊</button>
    </body>
</html>
