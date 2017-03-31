<html>
<head>
    <title>Realtime Notifications</title>
    <script src="//js.pusher.com/3.1/pusher.min.js" type="text/javascript"></script>
    <script src="//code.jquery.com/jquery-2.1.3.min.js" type="text/javascript"></script>
</head>
<body>

<div class="notification"></div>

<script>

    var pusher = new Pusher('277668');

    var notificationsChannel = pusher.subscribe('notifications');

    notificationsChannel.bind('new_notification', function(notification){
        var message = notification.message;
        $('div.notification').text(message);
    });

</script>

</body>
</html>
