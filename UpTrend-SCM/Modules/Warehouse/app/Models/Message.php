<?php

namespace Modules\Warehouse\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'conversation_id',
    //     'user_id',
    //     'content',
    //     'type',
    // ];
    protected $fillable = [
    'conversation_id',
    'sender_id',
    'receiver_id',
    'content',
    'type',
    'user_id',
    ];

    
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}