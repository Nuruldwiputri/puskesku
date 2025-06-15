<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'specialization',
        'phone_number',
        'email',
    ];

    /**
     * Define a one-to-many relationship with schedules.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Define a one-to-many relationship with appointments.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}