<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\App\Models\Message;
use App\Services\ChatUserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Admin\App\Events\MessageSent;
use Modules\Admin\App\Events\MessageRead;
use App\Models\User;
use Modules\Admin\App\Models\Conversation;
use App\Http\Controllers\Controller;
// use App\Http\Controllers\Conversation;

class MessageController extends Controller
{
    public function index()
    {
        $authUser = auth()->user();
        $groups = \App\Services\ChatUserService::getAvailableChatUsersGrouped($authUser);
        return view('admin::chat.index', compact('groups'));
    }
    /**
     * Store a new message (including file uploads).
     */

    public function show(Conversation $conversation)
    {
        $conversation->load('messages.user');
        return view('admin::conversations.show', compact('conversation'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // dd(auth()->id());
        \Log::info('Message Request', $request->all());
        \Log::info('Auth ID', ['user_id' => auth()->id()]);

        $validated = $request->validate([
        'conversation_id' => 'required|exists:conversations,id',
        'receiver_id' => 'required|exists:users,id',
        'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => auth()->id(),
            'user_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            // 'content' => $request->message,
            // 'content' => $request->input('content'),
            'content' => $validated['content'], 
            'type' => 'text',
            'module' => 'admin',
        ]);

        \Log::info('Message Saved', ['id' => $message->id]);

        broadcast(new MessageSent($message, $message->conversation))->toOthers();

        // return response()->json($message);
        return redirect()->back();
    }

    public function chatWithUser(User $user)
    {
        // Load messages between logged-in user and selected user
        $authUser = auth()->user();
       
        $conversation = Conversation::firstOrCreate([
            'user_one_id' => min($authUser->id, $user->id),
            'user_two_id' => max($authUser->id, $user->id),
        ]);

         $messages = Message::where('conversation_id', $conversation->id)
        ->orderBy('created_at', 'asc')
        ->get();

        // return view('', compact('user', 'messages', 'conversation'));
        return view('admin::chat.conversation', [
            'user' => $user,
            'messages' => $messages,
            'conversation' => $conversation,
        ]);

    }

    /**
     * Mark a message as read (for read receipts).
     */
    public function markAsRead(Message $message): void
    {
        if ($message->user_id !== auth()->id() && is_null($message->read_at)) {
            $message->update(['read_at' => now()]);
            broadcast(new MessageRead($message))->toOthers();
        }
    }
}