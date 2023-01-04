<?php

namespace App\Exports;

use App\RobotUser;
use App\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RobotUsersExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $completedUsers = RobotUser::where('is_completed','=',1)->get();
        foreach ($completedUsers as $completedUser){
            $completedUser->is_reported = 1;
            $completedUser->save();
        }
        return RobotUser::where('is_completed', '=', 1);
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
            'tracking_code',
            'contact_info'
        ];
    }

    public function map($robotUsers): array
    {
        return [
            $robotUsers->chat_id,
            $robotUsers->username,
            $robotUsers->sex,
            $robotUsers->age,
            $robotUsers->covid_test,
            $robotUsers->covid_sign,
            $robotUsers->have_cold,
            $robotUsers->have_cough,
            $robotUsers->have_headache,
            $robotUsers->have_stomachache,
            $robotUsers->is_vaccinated,
            $robotUsers->other_covid_sign,
            $robotUsers->covid_test,
            $robotUsers->covid_relation,
            $robotUsers->respiratory_disease,
            $robotUsers->respiratory_name,
            public_path() .'/voices/'. $robotUsers->chat_id,
            $robotUsers->created_at,
            $robotUsers->tracking_code,
            $robotUsers->contact_info

        ];
    }
}
