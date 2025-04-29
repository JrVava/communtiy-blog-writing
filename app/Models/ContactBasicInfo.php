<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContactBasicInfo extends Model
{
    use HasFactory;

    protected $table = 'contact_basics';

    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a string
    protected $fillable = [
        'email_address',
        'phone_number',
        'relationship_status',
        'birthday',
        'address',
        'website',
        'bio',
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

    public function socialMedia()
    {
        return $this->hasMany(ContactBasicSocialMedia::class, 'contact_basic_id');
    }
}
