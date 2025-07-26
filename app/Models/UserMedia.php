<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserMedia extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'path', 'is_current'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString(); // Generate UUID
            }
        });
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope for current media
    public function scopeCurrent($query, $type)
    {
        return $query->where('type', $type)
            ->where('is_current', true)
            ->latest();
    }

    // Scope for all media of a type
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type)
            ->latest();
    }
}
