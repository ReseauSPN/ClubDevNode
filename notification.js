var watch = require('node-watch');
var http = require('http');
var fs = require('fs');

var server = http.createServer(function (req, res) {});


var io = require('socket.io').listen(server);

watch('./spool/', {recursive: false, followSymLinks: false}, function (filename) {
    console.log('nouveau fichier : ' + filename);
    emitFile(filename);
});

var emitFile = function (path) {

    fs.readFile(path, 'utf8', function (err, contents) {
        if (!err) {
            var data = JSON.parse(contents);            
            data.nbuser = Object.keys(io.sockets.connected).length;                        
            io.sockets.emit('update', data);
            fs.unlinkSync(path);
        }
    });
};


io.sockets.on('connection', function () {
    console.log('connection');
    var nb = Object.keys(io.sockets.connected).length;
    io.sockets.emit('nbuser', nb);
});


server.listen(8080);