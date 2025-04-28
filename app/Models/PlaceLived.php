<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PlaceLived extends Model
{
    use HasFactory;

    use HasFactory;

    use HasFactory;
    protected $table = 'place_lives';

    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a string
    protected $fillable = [
        'place',
        'date_moved',
        'user_id',
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
