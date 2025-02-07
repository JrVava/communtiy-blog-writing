<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Follow extends Model
{
    use HasFactory;

    protected $table = 'follows';

    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a string

    protected $fillable = [
        'user_id',
        'following_id'
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

    public function followBack(){
        return $this->hasOne(User::class,'id','following_id');
    }
}
