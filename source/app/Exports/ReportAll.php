<?php

namespace App\Exports;

use App\RobotUser;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportAll implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return $user = RobotUser::join('two_weeks_reports', function ($join) {
                $join->on('robot_users.chat_id', '=', 'two_weeks_reports.chat_id')
                    ->where('robot_users.is_completed', '=', 1)
                    ->where('two_weeks_reports.is_completed', '=', 1);
            })->select('robot_users.*',
                'two_weeks_reports.covid_sign as after_two_week_covid_sign',
                'two_weeks_reports.have_cold as after_two_week_have_cold',
                'two_weeks_reports.have_cough as after_two_week_have_cough',
                'two_weeks_reports.have_headache as after_two_week_have_headache',
                'two_weeks_reports.have_stomachache as after_two_week_have_stomachache',
                'two_weeks_reports.other_covid_sign as after_two_week_other_covid_sign',
                'two_weeks_reports.covid_test as after_two_week_covid_test'
            );
    }

    public function headings(): array
    {
        return [
            'chat_id',
            'username',
            'sex (0=F,1=M)',
            'age((n-1)*10 - n*10)',
            'covid_test(0=N , 1=p)',
            'covid_sign(0=N , 1=p)',
            'have_cold(0=N , 1=p)',
            'have_cough(0=N , 1=p)',
            'have_headache(0=N , 1=p)',
            'have_stomachache(0=N , 1=p)',
            'is_vaccinated(0=N , 1=p)',
            'other_covid_sign',
            'covid_test(0=N , 1=p)',
            'covid_relation(0=N , 1=p)',
            'respiratory_disease(0=N , 1=p)',
            'respiratory_name',
            'voices links',
            'registered_at',
            'after_two_week_covid_sign',
            'after_two_week_have_cold',
            'after_two_week_have_cough',
            'after_two_week_have_headache',
            'after_two_week_have_stomachache',
            'after_two_week_other_covid_sign',
            'after_two_week_covid_test',
            'tracking_code',
            'contact_info'
        ];
    }

    public function map($robotUser): array
    {
        return [
            $robotUser->chat_id,
            $robotUser->username,
            $robotUser->sex,
            $robotUser->age,
            $robotUser->covid_test,
            $robotUser->covid_sign,
            $robotUser->have_cold,
            $robotUser->have_cough,
            $robotUser->have_headache,
            $robotUser->have_stomachache,
            $robotUser->is_vaccinated,
            $robotUser->other_covid_sign,
            $robotUser->covid_test,
            $robotUser->covid_relation,
            $robotUser->respiratory_disease,
            $robotUser->respiratory_name,
            public_path() .'/voices/'. $robotUser->chat_id,
            $robotUser->created_at,
            $robotUser->after_two_week_covid_sign,
            $robotUser->after_two_week_have_cold,
            $robotUser->after_two_week_have_cough,
            $robotUser->after_two_week_have_headache,
            $robotUser->after_two_week_have_stomachache,
            $robotUser->after_two_week_other_covid_sign,
            $robotUser->after_two_week_covid_test,
            $robotUser->contact_info,
            $robotUser->tracking_code
        ];
    }
}
