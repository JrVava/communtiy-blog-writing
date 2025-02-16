<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class PostReaction extends Model
{
    use HasFactory;
    protected $table = 'post_reactions';

    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a string
    protected $fillable = ['post_id', 'likes', 'dislikes'];

    protected $casts = [
        'likes' => 'array',
        'dislikes' => 'array',
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

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
