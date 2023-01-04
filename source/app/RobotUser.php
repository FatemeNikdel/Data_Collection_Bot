<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RobotUser extends Model
{
    protected $fillable = [
        'chat_id',
        'username',
        'sex',
        'age',
        'covid_test',
        'covid_relation',
        'respiratory_disease',
        'respiratory_name',
        'question_counter',
        'voice_file_id',
        'is_completed',
        'is_reported',
        'is_downloaded'
    ];

    public function twoWeeksReport(){
        return $this->hasOne(TwoWeeksReport::class,'chat_id','chat_id');
    }
}
