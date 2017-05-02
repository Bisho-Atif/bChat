<script>
  socket.emit('new user', { id: '{{Auth::user()->id}}', nickName : '{{Auth::user()->name}}'});
  
  form.submit(function(e){
    e.preventDefault();
    if ($("#message").val() == '') return;
    var data = {};
    data.message = $("#message").val();

    data.from    = '{{ Auth::user()->name }}';
    data.to = '{{ $user->id }}';
    socket.emit('private message', data);
    messages.append(include_message(data.message, data.from));
    message.val("");
  });
</script>