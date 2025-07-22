<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';
    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is a 

    protected $fillable = [
        'user_id',
        'school',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
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
        $end = $this->end_date ?? now();

        return $end->diffInYears($start) . ' yrs';
    }
}
