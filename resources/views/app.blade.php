<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>bChat</title>
</head>
<body>
  <ul id="messages"></ul>
  <form action="" id="message_form">
    <input id="message" autocomplete="off" /><button type="submit">Send</button>
  </form>
  <ul id="users"></ul>
  <script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
  <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
  <script>

    var socket = io.connect('http://localhost:5000');
    socket.emit('new user', { new_name: '{{Auth::user()->name}}'});

    var form = $("#message_form");
    var messages = $("#messages");
    var message  = $("#message");
    var users    = $("#users");

    form.submit(function(e){
      e.preventDefault();
      var data = {};
      data.message = $("#message").val();
      data.user_name    = '{{ Auth::user()->name }}';
      socket.emit('send message', data);
      message.val("");
    });

    socket.on('new message', function(data){
      messages.append("<li><b>" + data.user_name + ": </b>" + data.message + "</li>" );
    });

    socket.on('users', function(data){
      users.text("");
      unique_users = $.unique(data.user_names);
      unique_users.forEach(function(user)
      {
        users.append("<li>" + user + "</li>");
      });
    })

  </script>
</body>
</html>
