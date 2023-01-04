<?php

namespace App\Exports;

use App\TwoWeeksReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TwoWeeksReportUsersExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        $completedUsers = TwoWeeksReport::where('is_completed','=',1)->get();
        foreach ($completedUsers as $completedUser){
            $completedUser->is_reported = 1;
            $completedUser->save();
        }
        return TwoWeeksReport::where('is_completed', '=', 1);
    }

    public function headings(): array
    {
        return [
            'chat_id',
            'username',
            'covid_sign',
            'have_cold',
            'have_cough',
            'have_headache',
            'have_stomachache',
            'other_covid_sign',
            'covid_test',
            'registered_at'
        ];
    }

    public function map($twoWeeksReport): array
    {
        return [
            $twoWeeksReport->chat_id,
            $twoWeeksReport->username,
            $twoWeeksReport->covid_sign,
            $twoWeeksReport->have_cold,
            $twoWeeksReport->have_cough,
            $twoWeeksReport->have_headache,
            $twoWeeksReport->have_stomachache,
            $twoWeeksReport->other_covid_sign,
            $twoWeeksReport->covid_test
        ];
    }
}
