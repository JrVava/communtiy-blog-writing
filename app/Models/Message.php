<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';
    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a string

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'is_read'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString(); // Generate UUID
            }
        });
    }

    /**
     * Get the sender of the message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the receiver of the message.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Scope a query to only include messages between two users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $senderId
     * @param int $receiverId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBetweenUsers($query, $senderId, $receiverId)
    {
        return $query->where(function ($q) use ($senderId, $receiverId) {
            $q->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($q) use ($senderId, $receiverId) {
            $q->where('sender_id', $receiverId)
                ->where('receiver_id', $senderId);
        });
    }

    /**
     * Scope a query to only include unread messages.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Mark the message as read.
     *
     * @return bool
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            return $this->update(['is_read' => true]);
        }
        return false;
    }
}
