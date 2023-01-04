<?php

namespace App\Exports;


use App\TwoWeeksReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TwoWeeksUnreportedUsersExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public function query()
    {
        return $milad = TwoWeeksReport::where('is_completed', '=', 1)->where('is_reported', '=', 0);
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
