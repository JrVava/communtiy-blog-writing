<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a string

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'post_owner_id',
        'user_id',
        'comment_id',
        'reaction',
        'is_read',
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

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'id','comment_id');
    }

    public function post(){
        return $this->hasOne(Post::class,'id','post_id');
    }
}
