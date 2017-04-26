<!DOCTYPE html>
<html lang="en">
<head>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font: 13px Helvetica, Arial; }
    form { background: #000; padding: 3px; position: fixed; bottom: 0; width: 100%; }
    form input { border: 0; padding: 10px; width: 90%; margin-right: .5%; }
    form button { width: 9%; background: rgb(130, 224, 255); border: none; padding: 10px; }
    #messages { list-style-type: none; margin: 0; padding: 0; }
    #messages li { padding: 5px 10px; }
    #messages li:nth-child(odd) { background: #eee; }
    #messages { margin-bottom: 40px }
  </style>  
  <meta charset="UTF-8">
  <title>bChat</title>
</head>
<body>

  <ul id="messages"></ul>
  <form action="" id="message_form">
    <input id="message" autocomplete="off" /><button type="submit">Send</button>
  </form>
  <script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
  <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
  <script>

    var socket = io.connect('http://localhost:5000');

    var form = $("#message_form");
    var messages = $("#messages");
    var message  = $("#message");

    form.submit(function(e){
      e.preventDefault();
      socket.emit('message', {message: $("#message").val()});
      message.val("");
    });

    socket.on('new message', function(data){
      messages.append("<li>" + data.message + "</li>");
    });


  </script>
</body>
</html>
