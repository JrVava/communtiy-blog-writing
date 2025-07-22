<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a string
    protected $fillable = [
        'content',
        'user_id',
        'media_path',
        'media_type',
        'is_active'
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

    // Add this accessor for easy media URL retrieval
    public function getMediaUrlAttribute()
    {
        if (!$this->media_path) {
            return null;
        }

        // Handle both old and new path formats for backward compatibility
        $path = str_starts_with($this->media_path, 'post_media/')
            ? $this->media_path
            : 'post_media/' . $this->user_id . '/' . $this->media_path;

        return asset('storage/' . $path);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeVisibleTo($query, User $user): mixed
    {
        return $query->whereHas('user.followers', function ($q) use ($user) {
            $q->where('follower_id', $user->id)
                ->where('status', Follow::STATUS_ACCEPTED);
        });
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function commentsCount()
    {
        return $this->hasMany(Comment::class)->selectRaw('post_id, count(*) as count')
            ->groupBy('post_id');
    }

    public function reactions()
    {
        return $this->hasOne(PostReaction::class,"post_id",'id');
    }
    public function getReactionSummary(): array
{
    if (!$this->reactions) {
        return [];
    }

    $summary = [];
    foreach ($this->reactions->getReactionCounts() as $type => $count) {
        if ($count > 0) {
            $summary[$type] = [
                'count' => $count,
                'emoji' => PostReaction::$reactionTypes[$type]
            ];
        }
    }
    return $summary;
}

}
