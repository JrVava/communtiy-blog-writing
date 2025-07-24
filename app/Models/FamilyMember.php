<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FamilyMember extends Model
{
    use HasFactory;

    protected $table = 'family_members';
    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a string

    protected $fillable = [
        'user_id',
        'family_member_id',
        'relationship',
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

    public function familyMember()
    {
        return $this->belongsTo(User::class, 'family_member_id');
    }
}
