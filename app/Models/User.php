<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a string

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'phone',
        'dob',
        'is_admin',
        'is_approve',
        'image'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function countryRecord()
    {
        return $this->hasOne(Country::class, 'id', 'country');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString(); // Generate UUID
            }
        });
    }

    /**
     * Get initials from the full name if the image is null
     */
    public function getInitialsAttribute()
    {
        if ($this->image) {
            return null; // No need for initials if image exists
        }

        $words = explode(' ', trim($this->full_name));
        $initials = strtoupper(substr($words[0], 0, 1)); // First letter of first name

        if (count($words) > 1) {
            $initials .= strtoupper(substr(end($words), 0, 1)); // First letter of last name
        }

        return $initials;
    }
}
