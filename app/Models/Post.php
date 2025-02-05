<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'description',
        'image',
        'is_approve',
        'created_by'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','created_by');
    }
}
