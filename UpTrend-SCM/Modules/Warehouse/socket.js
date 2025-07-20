const server = require('http').createServer();
const io = require('socket.io')(server);
const Redis = require('ioredis');
const redis = new Redis();

io.on('connection', (socket) => {
    console.log('A user connected');

    socket.on('join-room', (roomId) => {
        socket.join(`chat.${roomId}`);
    });

    socket.on('typing', (data) => {
        socket.to(`chat.${data.conversationId}`)
            .emit('typing', {
                user: data.user,
                conversationId: data.conversationId
            });
    });

    socket.on('disconnect', () => {
        console.log('User disconnected');
    });
});

redis.subscribe('laravel_database_chat');

redis.on('message', (channel, message) => {
    message = JSON.parse(message);
    io.to(`chat.${message.conversation.id}`).emit(message.event, message.data);
});

server.listen(3000, () => {
    console.log('Socket server is running on port 3000');
});