<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccines extends Model
{
    use HasFactory;
    protected $table = 'vaccines';

    public function disease()
    {
        return $this->belongsTo(Diseases::class,'diseases_id');
    }
}
