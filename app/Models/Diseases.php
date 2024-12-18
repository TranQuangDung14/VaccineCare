<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diseases extends Model
{
    use HasFactory;
    protected $table = 'diseases';

    public function Vaccines()
    {
        return $this->hasMany(Vaccines::class,'diseases_id');
    }

}
