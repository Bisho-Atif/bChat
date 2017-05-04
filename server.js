//DB Config
var host = 'localhost',
    db   = 'bChat';

var app = require('express')(),
    http = require('http').Server(app),
    io = require('socket.io')(http),
    port = 5000,
    mongoose = require('mongoose');

var user_names = {};

mongoose.connect('mongodb://' + host + '/' + db, function(err)
{
  if(err)
  {
    console.log('Error with DB');
  }
  else
  {
    console.log('Connected to the DB!');
  }  
});

var privateChatSchema = mongoose.Schema({
  senderId: String,
  senderNickName: String,
  recieverId: String,
  message: String
});

var privateChat = mongoose.model('privateMessage', privateChatSchema);


http.listen(port, function(){
  console.log('OK, Server is up !!');
});

io.sockets.on('connection', function(socket){
  socket.on('private message', function(data){
    var newMessage = new privateChat(data);
    newMessage.save();
    if(str(data.recieverId) in user_names)
    {
      user_names[data.recieverId].socket.emit('private message', {message: data.message, senderNickName: data.senderNickName});
    }
  });

  socket.on('new user', function(data){
    privateChat.find({$or: [{recieverId: data.id, senderId: data.to}, {recieverId: data.to, senderId: data.id}]}, function(err, results){
      if(err) throw err;
      socket.emit('load old messages', {messages: results});
    });
    if(!(data.id in user_names)) 
    {
      user_names[data.id] = {
        socket: socket,
        id: data.id,
        nickName: data.nickName,
      };
      socket.to = data.to
    }
    update_users(getNickNames(user_names), Object.keys(user_names));
  });

  socket.on('disconnect', function(data){
    var deletedUser = socket.user;
    delete user_names[deletedUser];
    update_users(getNickNames(user_names), Object.keys(user_names));
  });

});

function update_users(nickNames)
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