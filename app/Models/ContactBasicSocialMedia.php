<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContactBasicSocialMedia extends Model
{
    use HasFactory;

    protected $table = 'contact_basic_social_medias';

    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a string
    protected $fillable = [
        'social_media_url',
        'contact_basic_id',
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
}
