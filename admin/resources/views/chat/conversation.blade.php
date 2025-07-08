{{-- @dd($messages) --}}
<x-app-layout>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <script src="//js.pusher.com/7.0/pusher.min.js"></script>
<script src="/js/app.js"></script>
{{-- Make sure app.js correctly initializes window.Echo and Pusher --}}

{{-- <script>
    // Ensure this script runs after the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Get references to your chat elements
        const chatForm = document.getElementById('chat-form'); // Assuming your form has id="chat-form"
        const messageInput = document.getElementById('message-input');
        const chatBox = document.getElementById('chat-box'); // Assuming your chat display area has id="chat-box"

        // --- PART 1: Handle Sending Messages via AJAX (Stops Raw JSON Display) ---
        if (chatForm) { // Check if the form exists
            chatForm.addEventListener('submit', async function(e) {
                e.preventDefault(); // <--- CRUCIAL: Prevents default form submission (stops raw JSON display)

                let content = messageInput.value.trim();
                if (content === '') {
                    return; // Don't send empty messages
                }

                let data = {
                    content: content, // Use 'content' as per your message model/validation
                    receiver_id: {{ $user->id }},
                    conversation_id: {{ $conversation->id }}
                };

                try {
                    const response = await fetch('{{ route("messages.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(data)
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        console.error('Error sending message:', errorData);
                        alert('Failed to send message: ' + (errorData.message || 'Unknown error. Check console.'));
                        return;
                    }

                    const sentMessage = await response.json(); // This is the message object from backend
                    console.log('Message sent and confirmed:', sentMessage);

                    // Clear the input field immediately
                    messageInput.value = '';

                    // The message will be appended via the Echo listener (see Part 2).
                    // This way, both the sender and receiver use the same logic for displaying.

                } catch (error) {
                    console.error('Network or client-side error:', error);
                    alert('An error occurred while sending the message. Please try again.');
                }
            });
        }


        // --- PART 2: Laravel Echo Listener for Real-time Updates ---
        // Make sure `window.Echo` is correctly initialized in /js/app.js
        // The channel name 'chat.{{ $conversation->id }}' implies a private channel,
        // so ensure your Laravel broadcasting routes (routes/channels.php) are set up for it.
        // Also, ensure your backend event (e.g., NewMessageSent) broadcasts with
        // `broadcastAs('message.sent')` or you listen for the class name.

        if (window.Echo) {
            window.Echo.private('chat.{{ $conversation->id }}') // Listen to the private chat channel
                .listen('.message.sent', (e) => { // Listen for the '.message.sent' event
                    console.log('New message received via WebSocket:', e.message);

                    // Create and append the message element
                    appendMessageToChat(e.message);

                    // Scroll to the bottom of the chat box
                    chatBox.scrollTop = chatBox.scrollHeight;
                })
                .error((error) => {
                    console.error('Echo channel error:', error);
                    // Handle authentication errors or other WebSocket issues
                });
        } else {
            console.warn("Laravel Echo is not initialized. Real-time features will not work.");
        }


        // --- Helper function to append a message to the chat box ---
        function appendMessageToChat(message) {
            // Check if the message is already displayed to prevent duplicates
            // (especially if the sender also listens to the same broadcast)
            if (document.getElementById(`message-${message.id}`)) {
                return;
            }

            let div = document.createElement('div');
            div.id = `message-${message.id}`; // Give it an ID to prevent duplicates
            div.style.textAlign = message.sender_id === {{ auth()->id() }} ? 'right' : 'left';
            div.style.marginBottom = '8px'; // Add some spacing for better readability

            // Safely get sender name. `e.message.sender` should be loaded on the backend event.
            // If sender is current user, display 'You', otherwise display the other user's name.
            // Assuming `e.message.sender.name` is available from the broadcasted event
            // and `$user->name` is the name of the *other* user in the conversation.
            let senderDisplayName = '';
            if (message.sender_id === {{ auth()->id() }}) {
                senderDisplayName = 'You';
            } else {
                // If the message is from the other user, use their name.
                // It's safer to pass `sender.name` in the event data from backend.
                senderDisplayName = '{{ $user->name }}'; // This relies on Blade variable for the *other* user
                                                      // For generic chats with multiple users, `message.sender.name` from broadcast is better.
            }


            div.innerHTML = `
                <div style="
                    background-color: ${message.sender_id === {{ auth()->id() }} ? '#DCF8C6' : '#FFFFFF'};
                    padding: 8px 12px;
                    border-radius: 12px;
                    display: inline-block;
                    max-width: 80%;
                    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
                ">
                    <strong style="color: #333;">${senderDisplayName}</strong>: ${message.content}
                    <small style="display: block; font-size: 0.75em; color: #666; margin-top: 4px;">
                        ${new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                    </small>
                </div>
            `;
            chatBox.appendChild(div);
        }

        // --- PART 3: Initial Message Loading (Optional Improvement) ---
        // You can still call fetchMessages once on page load if you want to ensure
        // all existing messages are there, especially if you're not streaming all historical data.
        // Remove the setInterval polling as it's no longer needed for real-time.

        fetchMessages(); // Call once on page load to populate initial messages

        // NO LONGER NEEDED: REMOVE THIS LINE when Echo is fully working
        // setInterval(fetchMessages, 3000); // poll every 3 seconds

        function fetchMessages() {
            $.get('/api/messages/{{ $user->id }}', function(data) {
                // Clear the chat box only if you want to re-render everything
                // For a more efficient approach, check if message.id already exists
                // and only append new ones, but clearing is simpler for now.
                chatBox.innerHTML = ''; // Clears existing messages before re-rendering

                data.forEach(msg => {
                    // Re-use the same append function for consistency
                    appendMessageToChat(msg);
                });
                chatBox.scrollTop = chatBox.scrollHeight;
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error fetching messages:", textStatus, errorThrown);
            });
        }
    });
</script> --}}


</head>
<body style=" margin-left: 20%">
    <x-app.navbar /> 
    <h3>Chat with {{ $user->name }}</h3>

{{-- <div id="chat-box" style="overflow-y: scroll; height: 60vh;">
    @foreach($messages as $msg)
        <div style="text-align: {{ $msg->sender_id === auth()->id() ? 'right' : 'left' }};">
            <strong>{{ $msg->sender_id === auth()->id() ? 'You' : $user->name }}</strong>: 
            {{ $msg->content }}
        </div>
    @endforeach
</div> --}}
<div id="chat-box" style="overflow-y: auto; height: 60vh; padding: 1rem; background-color: #f5f5f5;">
    @foreach($messages as $msg)
        @php
            $isMe = $msg->sender_id === auth()->id();
        @endphp

        <div style="display: flex; justify-content: {{ $isMe ? 'flex-end' : 'flex-start' }}; margin-bottom: 10px;">
            <div style="
                max-width: 70%;
                background-color: {{ $isMe ? '#d1e7dd' : '#ffffff' }};
                padding: 10px 15px;
                border-radius: 20px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                text-align: left;
                word-wrap: break-word;
            ">
                <strong style="display: block; margin-bottom: 4px; font-size: 0.85rem; color: #555;">
                    {{ $isMe ? 'You' : $user->name }}
                </strong>
                <span style="font-size: 0.95rem; color: #333;">
                    {{ $msg->content }}
                </span>
            </div>
        </div>
    @endforeach
</div>


<form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data" class="mt-3" id="chat-form">
        @csrf
        <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">

        <div class="mb-2">
            <textarea name="content" class="form-control" placeholder="Type your message..."></textarea>
        </div>

        {{-- <div class="mb-2">
            <input type="file" name="file" class="form-control">
        </div> --}}

        <button type="submit" class="btn btn-primary">Send</button>
    </form>
</body>
</html>
</x-app-layout>