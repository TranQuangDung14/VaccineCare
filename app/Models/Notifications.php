<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $table = 'notifications';

    protected $fillable = [
        'schedule_id',  
        'schedules_detail_id',
        'notification_type',
        'status',
        'sent_at',
        'message',
    ];
}
