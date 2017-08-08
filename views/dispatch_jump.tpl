<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>跳转提示</title>
    <style type="text/css">
        *{ padding: 0; margin: 0; }
        body{ background: #fff; font-family: "Microsoft Yahei","Helvetica Neue",Helvetica,Arial,sans-serif; color: #333; font-size: 16px; }
        .system-message{ padding: 24px 48px; }
        .system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
        .system-message .jump{ padding-top: 10px;  font-size: 12px; }
        .system-message .jump a{ color: #333; text-decoration:underline;}
        .system-message ,.system-message{ line-height: 1.8em; font-size: 36px; }
        .system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display: none; }
    </style>
</head>
<body>
<div class="system-message">
    {php}
        if($code==1){
        {/php}
            <h1>:)</h1>
            <p class="success"><?php echo(strip_tags($msg));?></p>
        {php}
        }else{
        {/php}
            <h1>:(</h1>
            <p class="error"><?php echo(strip_tags($msg));?></p>
        {php}
        }
    {/php}
    <p class="detail"></p>
    <span class="jump">
            页面自动 <a id="href" onclick="jump();">跳转</a>
            等待时间： <span id="wait">{$wait}</span>
</div>
<script type="text/javascript">
    var url = '{$url}';
    (function(){
        var wait = document.getElementById('wait'), interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time === 0 ) {
                parent.window.location.href = url;
                clearInterval(interval);
            }
        }, 1000);
    })();

    function jump(){
        parent.window.location.href = url;
        clearInterval(interval);
    }
</script>
</body>
</html>
