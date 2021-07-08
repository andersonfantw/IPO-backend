<html>
    <head>
    </head>
    <body>
        <form method="post">
            @csrf
            <input id="senderid" type="text" value="CYSS" />
            <input id="recipient" type="text" value="" />
            <input id="content" type="text" value="" />
            <button onclick="sendsms()">發送簡訊</button>
        </form>
    </body>
</html>
