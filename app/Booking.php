<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    const PAST = 'past';
    const FUTURE = 'future';

    protected $fillable = [
        'client_id',
        'start',
        'end',
        'notes',
    ];

    protected $dates = [
        'start',
        'end',
    ];

    protected function getTimeSlotAttribute() {
        return Carbon::parse($this->start)->format('l j F Y H:i') . ' to ' . Carbon::parse($this->end)->format('H:i');
    }
}
