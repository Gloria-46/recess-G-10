<x-app-layout>
    <div class="flex items-start w-full h-screen" style="margin-left: 20%;">
        <x-app.navbar />
        <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-lg" style="height: auto">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 border-b pb-4 border-gray-200" style="margin-top: -13%">
                Chat with a User
            </h2>
            @php $hasUsers = false; @endphp
            @foreach($groups as $role => $users)
                @if($users->count())
                    @php $hasUsers = true; @endphp
                    <h3 class="text-lg font-semibold mt-6 mb-2 text-blue-700">{{ $role }}</h3>
                    <ul class="divide-y divide-gray-100 list-none mb-4">
                        @foreach($users as $userItem)
                            <li>
                                <a href="{{ route('admin.chat.with', $userItem->id) }}"
                                   class="flex items-center px-3 py-4 gap-4 transition-all duration-200 rounded-xl hover:bg-gray-50 hover:scale-[1.02] hover:shadow-md group">
                                    <div class="relative flex items-center justify-center" style="width: 48px; height: 48px;">
                                        <img src="{{ $userItem->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($userItem->name) . '&background=0D8ABC&color=fff&size=48&rounded=true' }}"
                                             alt="{{ $userItem->name }}"
                                             class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 bg-transparent">
                                        <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full border-2 border-white {{ $userItem->is_online ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                    </div>
                                    <div class="flex flex-col min-w-0 flex-grow">
                                        <span class="text-base font-semibold text-gray-900 group-hover:text-blue-700 truncate" style="font-size: 19px">
                                            {{ $userItem->name }}</span>
                                        <span class="text-sm text-gray-500 truncate" style="font-size: 17px; margin-top: -10px; margin-left: 10px">
                                            {{ $userItem->last_message_snippet ?? 'No messages yet.' }}
                                        </span>
                                    </div>
                                    @if(($userItem->unread_count ?? 0) > 0)
                                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full flex-shrink-0 ml-auto">
                                            {{ $userItem->unread_count }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endforeach
            @unless($hasUsers)
                <p class="text-center text-gray-500 py-4">No other users available to chat with.</p>
            @endunless
        </div>
    </div>
</x-app-layout>