<script type="text/javascript">
  var socket = io.connect('http://localhost:5000');

  var form                 = $("#message_form");
  var messagesContainer    = $("#messages");
  var message              = $("#message");
  var onlineUsersContainer = $("#users");

  socket.on('private message', function(data){
    messagesContainer.append(include_message(data.message, data.senderNickName));
  });

  socket.on('load old messages', function(data){
    data.messages.forEach(function(message){
      messagesContainer.append(include_message(message.message, message.senderNickName));
    })
  });

  socket.on('users', function(data){
    showUsers(data.userData , onlineUsersContainer);
  });

  function include_message(message, user_name){
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

  function include_user(name, id){
    var html = '<li class="media">'+
                  '<div class="media-body">'+
                    '<div class="media">'+
                      '<a class="pull-left" href="#">'+
                        '<img class="media-object img-circle" style="max-height:40px;" src="/img/user.png" /></a>'+
                      '<div class="media-body" >'+
                        '<h5>' + name + '</h5>'+
                        '<form action="/private/' + id + '" method="POST">' +
                        '{{ csrf_field() }}' +
                        '<button class="btn btn-success" type="submit">Chat</button>'+
                        '</form>'+
                      '</div>'+
                    '</div>'+
                  '</div>'+
                '</li>';
    return html;
  }

  function showUsers(usersData, container){
    container.text("");
    usersData.forEach(function(user){
      if(user.nickName !== '{{ Auth::user()->name }}'){
        container.append(include_user(user.nickName, user.id));
      }
    });
  }  
</script>
