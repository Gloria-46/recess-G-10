@extends('customerretail::layouts.retailer')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-2xl font-bold mb-4 text-orange-700 flex items-center gap-2">
            <i class="fas fa-comments"></i> Chat with {{ $user->name }}
        </h2>
        <div id="chat-box" class="overflow-y-auto h-96 p-4 bg-orange-50 rounded-xl mb-4 border border-orange-100">
            @foreach($messages as $msg)
                @php $isMe = $msg->sender_id === auth()->id(); @endphp
                <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} mb-2">
                    <div class="max-w-[70%] px-4 py-2 rounded-2xl shadow {{ $isMe ? 'bg-gradient-to-r from-orange-400 to-yellow-400 text-white' : 'bg-white text-gray-800 border border-orange-100' }}">
                        <div class="text-xs font-semibold mb-1 {{ $isMe ? 'text-yellow-100' : 'text-orange-700' }}">
                            {{ $isMe ? 'You' : $user->name }}
                        </div>
                        <div class="text-base">{{ $msg->content }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        <form action="{{ route('retailer.chat.send') }}" method="POST" class="flex gap-2 mt-4">
            @csrf
            <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
            <input type="hidden" name="receiver_id" value="{{ $user->id }}">
            <textarea name="content" class="flex-1 rounded-xl border border-orange-200 px-4 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none resize-none" placeholder="Type your message..." rows="2" required></textarea>
            <button type="submit" class="bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-bold px-6 py-2 rounded-xl shadow hover:from-orange-600 hover:to-yellow-600 transition">Send</button>
        </form>
    </div>
</div>
@endsection