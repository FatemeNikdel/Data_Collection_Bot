<?php

namespace App\Http\Controllers;

use App\Exports\ReportAll;
use App\Exports\RobotUnreportedUsersExport;
use App\Exports\TwoWeeksReportUsersExport;
use App\Exports\TwoWeeksUnreportedUsersExport;
use App\RobotUser;
use App\TwoWeeksReport;
use Illuminate\Http\Request;
use App\Exports\RobotUsersExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use File;
use ZipArchive;

class ReportController extends Controller
{
    public function downloadAll(Request $request)
    {
        return Excel::download(new RobotUsersExport, 'users.' . $request->input('type', false));
    }

    public function downloadUnreported(Request $request)
    {
        $result = Excel::download(new RobotUnreportedUsersExport(), 'unreportedUsers.' . $request->input('type', false));
        $completedUsers = RobotUser::where('is_completed', '=', 1)->where('is_reported', '=', 0)->get();
        foreach ($completedUsers as $completedUser) {
            $completedUser->is_reported = 1;
            $completedUser->save();
        }
        return $result;

    }

    public function downloadAllTwoWeeks(Request $request)
    {
        return Excel::download(new TwoWeeksReportUsersExport(), 'allTwoWeeksUsers.' . $request->input('type', false));
    }

    public function downloadUnreportedTwoWeeks(Request $request)
    {
        $result = Excel::download(new TwoWeeksUnreportedUsersExport(), 'twoWeeksUnreportedUsers.' . $request->input('type', false));
        $completedUsers = TwoWeeksReport::where('is_completed', '=', 1)->where('is_reported', '=', 0)->get();
        foreach ($completedUsers as $completedUser) {
            $completedUser->is_reported = 1;
            $completedUser->save();
        }
        return $result;

    }

    public function joinedTables(Request $request)
    {
        return Excel::download(new ReportAll(), 'allUsers.' . $request->input('type', false));


        /*return $user = DB::table('robot_users')
            ->join('two_weeks_reports', function ($join) {
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
            )
            ->get();
        dd($user);*/
    }

    public function voices()
    {
        $zip = new ZipArchive;
        $fileName = 'voices.zip';
        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::files(public_path('/voices/*'));
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
        }
        return response()->download(public_path($fileName));
    }
}
