<html>
    <head>
    </head>
    <body>
        <form method="post">
            @csrf
            <h1>簡訊發送工具</h1>
            <h5>顯示名稱</h5>
            <input id="senderid" name="senderid" type="text" value="CYSS" />
            <h5>接收人電話 (以換行，或逗號分隔)</h5>
            <textarea id="recipient" rows="10" name="recipient" type="text"></textarea>
            <h5>簡訊內容</h5>
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
