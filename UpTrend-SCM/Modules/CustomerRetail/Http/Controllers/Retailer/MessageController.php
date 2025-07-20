<?php

namespace Modules\CustomerRetail\Http\Controllers\Retailer;

use Modules\CustomerRetail\App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Events\MessageSent;
use App\Events\MessageRead;
use App\Services\ChatUserService;
use App\Models\User;
use Modules\CustomerRetail\App\Models\Conversation;
// use App\Http\Controllers\Conversation;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function index()
    {
        $authId = auth()->id();
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

        return view('customerretail::retailer::chat.index', compact('users'));
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
            'module' => 'retailer',
        ]);

        \Log::info('Message Saved', ['id' => $message->id]);

        broadcast(new MessageSent($message, $message->conversation))->toOthers();

        // return response()->json($message);
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
        // Load messages between logged-in user and selected user
        $authUser = auth()->user();

        // $messages = Message::where(function ($query) use ($authUser, $user) {
        //     $query->where('sender_id', $authUser->id)->where('receiver_id', $user->id);
        // })->orWhere(function ($query) use ($authUser, $user) {
        //     $query->where('sender_id', $user->id)->where('receiver_id', $authUser->id);
        // // })->orderBy('created_at')->get();
        // })->orderBy('created_at', 'asc')->get();


        // return view('chat.conversation', compact('user', 'messages'));
    // Find existing conversation or create a new one
        // $conversation = Conversation::firstOrCreate([
        //     'user_one_id' => min($authUser->id, $user->id),
        //     'user_two_id' => max($authUser->id, $user->id),
        // ]);

        // // Fetch messages between the two users
        // $messages = Message::where('conversation_id', $conversation->id)
        //     ->orderBy('created_at', 'asc')
        //     ->get();

        // return view('chat.conversation', [
        //     'user' => $user,
        //     'messages' => $messages,
        //     'conversation' => $conversation
        // ]);
       
        $conversation = Conversation::firstOrCreate([
            'user_one_id' => min($authUser->id, $user->id),
            'user_two_id' => max($authUser->id, $user->id),
        ]);

        // $messages = Message::where(function ($query) use ($authUser, $user) {
        //     $query->where('sender_id', $authUser->id)
        //         ->where('receiver_id', $user->id);
        // })->orWhere(function ($query) use ($authUser, $user) {
        //     $query->where('sender_id', $user->id)
        //         ->where('receiver_id', $authUser->id);
        // })->orderBy('created_at', 'asc')->get();
         $messages = Message::where('conversation_id', $conversation->id)
        ->orderBy('created_at', 'asc')
        ->get();

        // return view('chat.conversation', compact('user', 'messages', 'conversation'));
        return view('customerretail::retailer::chat.conversation', [
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