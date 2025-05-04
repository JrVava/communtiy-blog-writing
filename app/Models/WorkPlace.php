<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WorkPlace extends Model
{
    use HasFactory;

    protected $table = 'workplaces';

    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a string
    protected $fillable = [
        'workplace',
        'position',
        'start_date',
        'end_date',
        'city',
        'description',
        'user_id',
        'type'
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
