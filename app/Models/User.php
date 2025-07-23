<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString(); // Generate UUID
            }
        });
    }

    // app/Models/User.php
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // In your User model
    public function visiblePosts()
    {
        if (auth()->id() === $this->id) {
            return $this->posts();
        }

        return $this->posts()
            ->whereHas('user.followers', function ($query) {
                $query->where('follower_id', auth()->id())
                    ->where('status', Follow::STATUS_ACCEPTED);
            });
    }

    // In your User model
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function acceptedFollowers()
    {
        return $this->followers()->wherePivot('status', Follow::STATUS_ACCEPTED);
    }

    public function pendingFollowRequests()
    {
        return $this->followers()->wherePivot('status', Follow::STATUS_PENDING);
    }

    public function isFollowing(User $user)
    {
        return $this->following()
            ->where('following_id', $user->id)
            ->where('status', Follow::STATUS_ACCEPTED)
            ->exists();
    }

    public function followingUsers()
{
    return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')
        ->wherePivot('status', Follow::STATUS_ACCEPTED)
        ->withTimestamps();
}

    public function hasPendingFollowRequestTo(User $user)
    {
        return $this->following()
            ->where('following_id', $user->id)
            ->where('status', Follow::STATUS_PENDING)
            ->exists();
    }

    public function hasPendingFollowRequestFrom(User $user)
    {
        return $this->followers()
            ->where('follower_id', $user->id)
            ->where('status', Follow::STATUS_PENDING)
            ->exists();
    }

     public function places()
    {
        return $this->hasMany(Place::class);
    }

    public function contacts()
    {
        return $this->hasMany(UserContact::class,'user_id','id');
    }

    public function basicInfo()
    {
        return $this->hasMany(UserBasicInfo::class,'user_id','id');
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class,'user_id','id');
    }

    public function educations()
    {
        return $this->hasMany(Education::class,'user_id','id');
    }
}
