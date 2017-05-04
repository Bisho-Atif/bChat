<script>
  socket.emit('new user', { id: '{{Auth::user()->id}}', nickName : '{{Auth::user()->name}}', to: '{{ $user->id }}'});

  form.submit(function(e){
    e.preventDefault();
    if ($("#message").val() == '') return;
    var data = {};
    data.message = $("#message").val();
    data.senderNickName = '{{ Auth::user()->name }}'
    data.senderId    = '{{ Auth::user()->id }}';
    data.recieverId = '{{ $user->id }}';
    socket.emit('private message', data);
    messagesContainer.append(include_message(data.message, data.senderNickName));
    message.val("");
  });

</script>