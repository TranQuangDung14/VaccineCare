<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;
    protected $table = 'patients';
    public function schedules()
    {
        return $this->hasMany(VaccinationSchedules::class,'patient_id');
    }
}
