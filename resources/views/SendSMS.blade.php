<html>
    <head>
    </head>
    <body>
        <form method="post">
            @csrf
            <input id="senderid" name="senderid" type="text" value="CYSS" />
            <textarea id="recipient" rows="10" name="recipient" type="text"></textarea>
            <textarea id="content" rows="10" name="content" type="text" value=""></textarea>
            <button onclick="sendsms()">發送簡訊</button>
        </form>
        <style>
            input, textarea{
                width: 100%;
            }
        </style>
    </body>
</html>
