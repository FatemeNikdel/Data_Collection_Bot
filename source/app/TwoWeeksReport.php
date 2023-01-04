<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwoWeeksReport extends Model
{
    protected $fillable =[
        'chat_id',
        'username',
        'covid_sign',
        'have_cold',
        'have_cough',
        'have_headache',
        'have_stomachache',
        'other_covid_sign',
        'covid_test',
        'is_reported',
        'is_completed',
        'send_message_date',
        'created_at'
    ];

    public function robotUser(){
        return $this->belongsTo(RobotUser::class,'chat_id','chat_id');
    }
}
