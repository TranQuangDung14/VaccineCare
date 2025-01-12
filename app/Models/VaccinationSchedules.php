<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationSchedules extends Model
{
    use HasFactory;
    protected $table = 'vaccination_schedules';

    public function patients()
    {
        return $this->belongsTo(Patients::class);
    }

    public function vaccines()
    {
        return $this->belongsTo(Vaccines::class,'vaccine_id');
    }
    public function details()
    {
        return $this->hasMany(SchedulesDetail::class,'vaccination_schedules_id');
    }


}
    