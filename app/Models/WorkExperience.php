<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WorkExperience extends Model
{
    use HasFactory;

    protected $table = 'work_experiences';
    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a string

    protected $fillable = [
        'user_id',
        'position',
        'company',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'description'
    ];

    protected $dates = ['start_date', 'end_date'];

    protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
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

    public function getDurationAttribute()
    {
        $start = $this->start_date;
        $end = $this->is_current ? now() : ($this->end_date ?? now());

        $years = $end->diffInYears($start);
        $months = $end->diffInMonths($start) % 12;

        if ($years > 0 && $months > 0) {
            return "$years yrs $months mos";
        } elseif ($years > 0) {
            return "$years yrs";
        } else {
            return "$months mos";
        }
    }
}
