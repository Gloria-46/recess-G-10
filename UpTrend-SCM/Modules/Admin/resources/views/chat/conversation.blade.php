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
<div style = "margin-left: 20%"> 
@include('admin::components.app.navbar')
</div>
<div id="chat-box" 
style="overflow-y: auto; height: 60vh; padding: 1rem; background-color: #f5f5f5; margin-left: 20%">
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


<form action="{{ route('admin.messages.store') }}" style="margin-left: 20%;"
method="POST" enctype="multipart/form-data" class="mt-3" id="chat-form">
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