<script type="text/javascript">
  socket.emit('new user', { id: '{{Auth::user()->id}}', nickName : '{{Auth::user()->name}}'});
</script>