<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'messages';

    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a string

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'messages',
        'is_read'
    ];

    protected $dates = ['deleted_at'];
}
