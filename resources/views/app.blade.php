<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>bChat</title>
    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet" />
  </head>

  <body style="font-family:Verdana">
    <div class="container">
      <div class="row " style="padding-top:40px;">
      <h3 class="text-center" >bChat </h3>
      <br/><br/>
      <div class="col-md-8">
      <div class="panel panel-info">
        <div class="panel-heading">RECENT CHAT HISTORY</div>
          <div class="panel-body">
            <ul class="media-list" id="messages">

            </ul>
          </div>
        <div class="panel-footer">
          <div class="input-group">
            <form action="" id="message_form">
              <input type="text" class="form-control" id="message" placeholder="Enter Message" />
              <span class="input-group-btn">
              <button class="btn btn-info" type="submit">SEND</button>
              </span>
            </form>
          </div>
        </div>
      </div>
    </div>

      <div class="col-md-4">
        <div class="panel panel-primary">
          <div class="panel-heading">
          ONLINE USERS
          </div>
            <div class="panel-body">
              <ul class="media-list" id="users">

              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.slim.min.js"></script>  
    <script src="/js/jquery-3.2.1.min.js"></script>
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
        messages.append(include_message(data.message, data.user_name));
      });

      socket.on('users', function(data){
        users.text("");
        unique_users = $.unique(data.user_names);
        unique_users.forEach(function(user)
        {
          users.append(include_user(user));
        });
      });

      function include_message(message, user_name)
      {
        var html  = '<li class="media">' +
                      '<div class="media-body">' +
                        '<div class="media">' +
                          '<a class="pull-left" href="#"><img class="media-object img-circle " src="/img/user.png" /></a>' +
                          '<div class="media-body" >' + message + '<br/><small class="text-muted">' + user_name + '</small><hr /></div>'+
                        '</div>'+
                      '</div>'+
                    '</li>';
        return html;
      }

      function include_user(user)
      {
        var html = '<li class="media">'+
                      '<div class="media-body">'+
                        '<div class="media">'+
                          '<a class="pull-left" href="#">'+
                            '<img class="media-object img-circle" style="max-height:40px;" src="/img/user.png" /></a>'+
                          '<div class="media-body" >'+
                            '<h5>' + user + '</h5>' +
                          '</div>'+
                        '</div>'+
                      '</div>'+
                    '</li>';
        return html;
      }
    </script>
  </body>
</html>
