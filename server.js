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
  socket.on('private message', function(data){
    user_names[data.to].socket.emit('private message', {message: data.message, from: data.from});
    // io.sockets.emit('private message', data);
  });

  socket.on('new user', function(data){
    if(!(data.id in user_names)) 
    {
      user_names[data.id] = {
        socket: socket,
        id: data.id,
        nickName: data.nickName,
      };
      socket.user = data.id;  
    }
    update_users(getNickNames(user_names), Object.keys(user_names));
  });

  socket.on('disconnect', function(data){
    var deletedUser = socket.user;
    delete user_names[deletedUser];
    update_users(getNickNames(user_names), Object.keys(user_names));
  });

});

function update_users(nickNames, ids)
{
  io.sockets.emit('users', {userData: getNickNames(user_names) });
}

function getNickNames(users)
{
  var nickNames = [];
  Object.keys(users).forEach(function(user){
    nickNames.push({nickName: users[user].nickName, id: users[user].id});
  });
  return nickNames;
}