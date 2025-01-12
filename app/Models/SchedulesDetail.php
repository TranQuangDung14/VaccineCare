<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulesDetail extends Model
{
    use HasFactory;
    protected $table = 'schedules_detail';

    public function vaccinationschedules()
    {
        return $this->belongsTo(VaccinationSchedules::class);
    }
}
