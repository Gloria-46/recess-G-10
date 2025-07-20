import Echo from 'laravel-echo';
import io from 'socket.io-client';

window.io = io;

const echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':3000'
});

echo.private(`chat.${conversationId}`)
    .listen('MessageSent', (e) => {
        appendMessage(e.message);
    })
    .listenForWhisper('typing', (e) => {
        showTypingIndicator(e.user);
    });