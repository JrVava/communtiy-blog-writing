<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Relationship extends Model
{
    use HasFactory;

    protected $table = 'relationships';
    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a string

    protected $fillable = [
        'user_id',
        'status',
        'partner_id',
        'anniversary_date'
    ];
    protected $dates = [
        'anniversary_date',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'anniversary_date' => 'date',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }
}
