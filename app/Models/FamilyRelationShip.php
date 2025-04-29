<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FamilyRelationShip extends Model
{
    use HasFactory;

    protected $table = 'family_relationships';

    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a string
    protected $fillable = [
        'relationship',
        'user_id',
        'family_id',
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
