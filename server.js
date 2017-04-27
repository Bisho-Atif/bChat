var app = require('express')(),
    http = require('http').Server(app),
    io = require('socket.io')(http),
    port = 5000;

var user_names = [];

http.listen(port, function(){
  console.log('OK, Server is up !!');
});

io.sockets.on('connection', function(socket){
  socket.on('send message', function(data){
    io.sockets.emit('new message', data);
  });

  socket.on('new user', function(data){
    user_names.push(data.new_name);
    socket.user_name = data.new_name;
    update_users(user_names);
  });

  socket.on('disconnect', function(data){
    if (user_names.indexOf(socket.user_name) > -1)
    {
      user_names.splice(user_names.indexOf(socket.user_name), 1);
    }
    update_users(user_names);
  });

});

function update_users(users)
{
  io.sockets.emit('users', {user_names: users});
}