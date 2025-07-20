@props(['message'])

<div class="flex {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
    <div class="max-w-sm rounded-lg p-3 {{ $message->user_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
        <p>{{ $message->content }}</p>
        <span class="text-xs">{{ $message->created_at->format('H:i') }}</span>
    </div>
</div>