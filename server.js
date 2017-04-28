var app = require('express')(),
    http = require('http').Server(app),
    io = require('socket.io')(http),
    port = 5000;

var mongo = require('mongodb').MongoClient;

var user_names = {};

http.listen(port, function(){
  console.log('OK, Server is up !!');
});

io.sockets.on('connection', function(socket){
  socket.on('send message', function(data){
    io.sockets.emit('new message', data);
  });

  socket.on('new user', function(data){
    if(!(data.new_name in user_names)) 
    {
      user_names[data.email] = {
        socket: socket,
        name: data.new_name
      };
      socket.user_name = data.new_name;  
    }
    update_users(Object.keys(user_names));
  });

  socket.on('disconnect', function(data){
    delete user_names[socket.user_name];
    update_users(Object.keys(user_names));
  });

});

function update_users(users)
{
  io.sockets.emit('users', {user_names: users});
}