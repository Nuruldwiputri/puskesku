<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AppointmentStatusEnum;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'doctor_id',
        'schedule_id',
        'appointment_date',
        'appointment_time',
        'queue_number',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'appointment_time' => 'datetime:H:i:s', // Cast to time format
            'status' => AppointmentStatusEnum::class, // Akan kita buat Enums-nya
        ];
    }

    /**
     * Define a many-to-one relationship with User (Pasien).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define a many-to-one relationship with Doctor.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Define a many-to-one relationship with Schedule.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}