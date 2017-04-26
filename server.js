var app = require('express')(),
    http = require('http').Server(app),
    io = require('socket.io')(http),
    port = 5000;

http.listen(port, function(){
  console.log('OK, Server is up !!');
});

io.sockets.on('connection', function(socket){
  socket.on('message', function(data){
    io.sockets.emit('new message', data);
  });

});