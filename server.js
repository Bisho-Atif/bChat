//DB Config
var host = 'localhost',
    db   = 'bChat';

var app = require('express')(),
    http = require('http').Server(app),
    io = require('socket.io')(http),
    port = 5000,
    mongoose = require('mongoose');

var users = {};

http.listen(port, function(){
  console.log('OK, Server is up !!');
});

mongoose.connect('mongodb://' + host + '/' + db, function(err){
  if(err){
    console.log('Error with DB');
  }
  else{
    console.log('Connected to the DB!');
  }  
});

var privateChatSchema = mongoose.Schema({
  senderId: String,
  senderNickName: String,
  recieverId: String,
  message: String,
  created: {type:Date, default:Date.now}
});

var privateChat = mongoose.model('privateMessage', privateChatSchema);

io.sockets.on('connection', function(socket){
  socket.on('private message', function(data){
    var newMessage = new privateChat(data);
    newMessage.save();
    if(String(data.recieverId) in users){
      users[data.recieverId].socket.emit('private message', {message: data.message, senderNickName: data.senderNickName});
    }
  });

  socket.on('new user', function(data){
    var query = privateChat.find({
      $or: [
        {recieverId: data.id, senderId: data.to},
        {recieverId: data.to, senderId: data.id}
      ]
    }).sort('-created').limit(3);

    query.exec(function(err, results){
      if(err) throw err;
      socket.emit('load old messages', {messages: results.reverse()});
    });
    
    if(!(data.id in users)){
      users[data.id] = {
        socket: socket,
        id: data.id,
        nickName: data.nickName,
      };
      socket.to = data.to;
    }
    update_users(getNickNames(users), Object.keys(users));
  });

  socket.on('disconnect', function(data){
    var deletedUser = socket.user;
    delete users[deletedUser];
    update_users(getNickNames(users), Object.keys(users));
  });

});

function update_users(nickNames){
  io.sockets.emit('users', {userData: getNickNames(users) });
}

function getNickNames(users){
  var nickNames = [];
  Object.keys(users).forEach(function(user){
    nickNames.push({nickName: users[user].nickName, id: users[user].id});
  });
  return nickNames;
}