<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalendarReminderController extends Controller
{
    public function index(){
        return view('Admin.pages.calendar_reminder.calendar_reminder');
    }
}
