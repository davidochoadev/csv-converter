<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_form',
        'first_name',
        'last_name',
        'phone_number',
        'first_consent',
        'second_consent',
        'third_consent',
        'response_type',
        'start_date',
        'submit_date',
        'stage_date',
        'network_id',
    ];

    
}
