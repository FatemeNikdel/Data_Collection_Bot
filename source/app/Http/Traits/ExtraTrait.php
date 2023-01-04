<?php

namespace App\Http\Traits;

use App\RobotUser;

trait ExtraTrait
{
    private function info($data)
    {
        $myfile = fopen("milad.txt", "w") or die("Unable to open file!");
        try {
            fwrite($myfile, $data);
        } catch (Exception $e) {
            fwrite($myfile, $e->getMessage());
        }
        fclose($myfile);
    }

    private function downloadVoiceFile($file_id, $user_id, $voice_number)
    {
        $dirname = public_path() . '/voices/' . $user_id;
        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }
        $result = file_get_contents('https://api.telegram.org/bot' . env('APITOKEN') . '/getFile?file_id=' . $file_id);
        $result = json_decode($result, true);

        switch ($voice_number) {
            case '1':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(deepBreath).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '2':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(Breath).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '3':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(slowCough).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '4':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(cough).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '5':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(slowNumbers).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '6':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(numbers).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '7':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(A).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '8':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(O).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '9':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(E).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '10':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(secondDeepBreath).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '11':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(secondBreath).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '12':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(secondSlowCough).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '13':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(secondCough).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '14':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(secondSlowNumbers).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '15':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(secondNumbers).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '16':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(secondA).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '17':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(secondO).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                break;
            case '18':
                $downloadResult = file_put_contents($dirname . '/' . $user_id . '(secondE).oga', fopen('https://api.telegram.org/file/bot' . env('APITOKEN') . '/' . $result['result']['file_path'], 'r'));
                if ($downloadResult) {
                    $robotUser = RobotUser::where('chat_id', '=', $user_id)->first();
                    $robotUser->is_downloaded = 1;
                    $robotUser->save();
                }
                break;
            default:
                $this->sendMessage($user_id, 'شما قادر به ارسال صدا نیستید.');
                break;
        }
    }

    public function generateBarcodeNumber()
    {
        $number = mt_rand(100000000, 999999999);
        if ($this->barcodeNumberExists($number)) {
            return $this->generateBarcodeNumber();
        }
        return $number;
    }

    public function barcodeNumberExists($number)
    {
        return RobotUser::where('tracking_code', '=', $number)->exists();
    }
}
