<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class PostReaction extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['post_id', 'reactions'];

    protected $casts = [
        'reactions' => 'array'
    ];

    // Default reactions with their emoji
    public static $reactionTypes = [
        'like' => '👍',
        'love' => '❤️',
        'haha' => '😆',
        'wow' => '😮',
        'sad' => '😢',
        'angry' => '😡'
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

    public function getReactionCounts()
    {
        $counts = [];
        foreach ($this->reactions as $type => $userIds) {
            $counts[$type] = count($userIds);
        }
        return $counts;
    }

    public function getTotalReactions()
    {
        return array_sum($this->getReactionCounts());
    }
    public function getUserReaction(string $userId): ?string
    {
        foreach ($this->reactions as $type => $userIds) {
            if (in_array($userId, $userIds)) {
                return $type;
            }
        }
        return null;
    }
}
