<?php

namespace Modules\CustomerRetail\App\Http\Controllers\Retailer;

use Modules\CustomerRetail\App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\CustomerRetail\App\Events\MessageSent;
use Modules\CustomerRetail\App\Events\MessageRead;
use App\Models\User;
use Modules\CustomerRetail\App\Models\Conversation;
// use App\Http\Controllers\Conversation;
use Modules\CustomerRetail\Http\Controllers\Controller;
use App\Services\ChatUserService;

class MessageController extends Controller
{
    public function index()
    {
        $authUser = auth()->user();
        $authId = $authUser->user_id ?? $authUser->id;
        $users = User::where('id', '!=', $authId)->get();

        foreach ($users as $user) {
            $lastMessage = Message::where(function ($query) use ($authId, $user) {
                    $query->where('sender_id', $authId)->where('receiver_id', $user->id);
                })
                ->orWhere(function ($query) use ($authId, $user) {
                    $query->where('sender_id', $user->id)->where('receiver_id', $authId);
                })
                ->orderByDesc('created_at')
                ->first();

            $user->last_message_snippet = $lastMessage ? $lastMessage->content : null;
        }

        return view('customerretail::retailer.chat.index', compact('users'));
    }
    /**
     * Store a new message (including file uploads).
     */

    public function show(Conversation $conversation)
    {
        $conversation->load('messages.user');
        return view('conversations.show', compact('conversation'));
    }

    public function store(Request $request)
    {
        $authUser = auth()->user();
        $authId = $authUser->user_id ?? $authUser->id;

        if (!\App\Models\User::find($authId)) {
            abort(404, 'User not found in users table.');
        }

        $validated = $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => $authId,
            'user_id' => $authId,
            'receiver_id' => $request->receiver_id,
            'content' => $validated['content'],
            'type' => 'text',
            'module' => 'retailer',
        ]);

        \Log::info('Message Saved', ['id' => $message->id]);

        broadcast(new MessageSent($message, $message->conversation))->toOthers();

        return redirect()->back();
    }
//     public function store(Request $request): JsonResponse
// {
//     \Log::info('Incoming Request', $request->all());

//     $request->validate([
//         'conversation_id' => 'required|exists:conversations,id',
//         'receiver_id' => 'required|exists:users,id',
//         'content' => 'required|string|max:1000',
//     ]);

//     $message = Message::create([
//         'conversation_id' => $request->conversation_id,
//         'sender_id' => auth()->id(),
//         'receiver_id' => $request->receiver_id,
//         'content' => $request->input('content'),
//         'type' => 'text',
//     ]);

//     \Log::info('Message Saved', ['id' => $message->id]);

//     return response()->json($message);
// }

    public function chatWithUser(User $user)
    {
        $authUser = auth()->user();
        $authId = $authUser->user_id ?? $authUser->id;

        // Ensure both IDs exist in users table
        if (!\App\Models\User::find($authId) || !\App\Models\User::find($user->id)) {
            abort(404, 'User not found in users table.');
        }

        $conversation = Conversation::firstOrCreate([
            'user_one_id' => min($authId, $user->id),
            'user_two_id' => max($authId, $user->id),
        ]);

        $messages = Message::where('conversation_id', $conversation->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('customerretail::retailer.chat.conversation', [
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