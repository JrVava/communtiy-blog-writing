<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Comment extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'comments';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'post_id',
        'comment'
    ];

    protected $dates = ['deleted_at'];

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
}
