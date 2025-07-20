{{-- @dd($messages) --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat</title>
    <script src="//js.pusher.com/7.0/pusher.min.js"></script>
<script src="/js/app.js"></script>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>
<nav class="flex items-center justify-between px-6 py-4 bg-indigo-950 text-white shadow-sm border-b">
    <div class="flex items-center gap-6 text-white">
      <div class="text-2xl font-bold ">
        <i class="fas fa-tshirt mr-2 "></i>
        UpTrend Clothing Store
      </div>
      <ul class="flex gap-8">
        <li>
          <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-white font-medium text-blue-600 border-b-2 border-blue-600 pb-1">
            <i class="fas fa-chart-line"></i> DASHBOARD
        </a>
      </li>
      <li>
        <a href="{{ route('suppliers.index') }}" class="flex items-center gap-2 text-white hover:text-blue-500 transition-colors">
            <i class="fas fa-truck"></i> SUPPLIERS
        </a>
      </li>
      <li>
          <a href="{{ route('orders.index') }}" class="flex items-center gap-2 text-white hover:text-blue-500 transition-colors">
            <i class="fas fa-shopping-cart"></i> ORDERS
        </a>
      </li>
      <li>
          <a href="{{ route('materials.index') }}" class="flex items-center gap-2 text-white hover:text-blue-500 transition-colors">
            <i class="fas fa-boxes"></i> MATERIALS
        </a>
      </li>
      <li>
          <a href="{{ route('performance.index') }}" class="flex items-center gap-2 text-white hover:text-blue-500 transition-colors">
            <i class="fas fa-chart-bar"></i> PERFORMANCE
        </a>
      </li>
    </ul>
    </div>
    <div class="flex items-center gap-4">
      <div x-data="{ open: false }" class="relative text-sm text-white cursor-pointer select-none">
        <div @click="open = !open" class="flex items-center">
          <a href="{{ route('vendor.chat.index') }}">
          <i class="fas fa-comment mr-1" style="margin-right: 15px"></i> 
          </a>
          <i class="fas fa-user-circle mr-1"></i>
          {{ Auth::user()->name ?? 'Admin' }}
        </div>
        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white rounded shadow-lg z-50" style="display: none;">
          <form method="POST" action="{{ route('logout') }}" class="block">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </nav>
      <h3 style="font-size: 2rem">Chat with {{ $user->name }}</h3>

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


<form action="{{ route('vendor.messages.store') }}" method="POST" enctype="multipart/form-data" 
class="mt-3" id="chat-form">
        @csrf
        <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">

        <div class="mb-2">
            {{-- <textarea name="content" class="form-control" placeholder="Type your message..."></textarea> --}}
         <textarea
        class="flex-grow px-4 py-2 bg-gray-100 text-gray-800 placeholder-gray-400 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        rows="1" name = "content"
        placeholder="Type your message..."
        style="min-height: 40px; width: 100vw" ></textarea>
        </div>

        {{-- <div class="mb-2">
            <input type="file" name="file" class="form-control">
        </div> --}}

        {{-- <button type="submit" class="btn btn-primary">Send</button> --}}
    <button
        type="submit"
        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg font-semibold flex-shrink-0"
    >
        Send
    </button>
    </form>
</body>
</html>