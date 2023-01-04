<?php

namespace App\Http\Controllers;

use App\RobotUser;
use App\TelegramContentModel;
use App\TwoWeeksReport;
use Illuminate\Http\Request;
use App\Http\Traits\WebhookTrait;
use App\Http\Traits\MessageTrait;
use App\Http\Traits\ExtraTrait;
use Carbon\Carbon;

class TelegramController extends Controller
{
    use WebhookTrait;
    use MessageTrait;
    use ExtraTrait;


    public function getUpdate()
    {
        try {
            $data = file_get_contents("php://input");
            $this->info($data);
            $data = json_decode($data, true);
            if (array_key_exists('message', $data)) {
                if (array_key_exists('text', $data['message'])) {
                    if (RobotUser::where('chat_id', '=', $data['message']['from']['id'])->exists()) {
                        $robotUser = RobotUser::where('chat_id', '=', $data['message']['from']['id'])->first();
                    }
                    if ($data['message']['text'] == '/start') {
                        //clear data of user who has been inserted into database
                        if (RobotUser::where('chat_id', '=', $data['message']['from']['id'])->exists()) {
                            RobotUser::where('chat_id', '=', $data['message']['from']['id'])->delete();
                        } else {
                            $this->sendMessage($data['message']['from']['id'], 'به ربات جمع‌آوری داده‌های صوتی کوید - ۱۹ خوش‌آمدید. امیدواریم در ایام کرونا در سلامت کامل باشید. لطفا به سوالات زیر پاسخ دهید. در صورتی که جوابی را اشتباه وارد کردید از قسمت Menu عبارت Start را برای ربات ارسال کنید و مجددا از ابتدا به سوالات پاسخ دهید. زمان تقریبی پاسخ به سوالات ۵ دقیقه می‌باشد و تعداد سوالات ۲۰  عدد می‌باشد.');
                        }
                        $this->sendMessage($data['message']['from']['id'],'در فایل زیر برگه رضایت نامه برای شرکت در تحقیقات و نحوه انجام کار زیر نظر دانشگاه فردوسی مشهد مشاهده می‌شود. در صورت رضایت گزینه موافقم را انتخاب نمایید. سپس ربات شروع به کار خواهد کرد.');
                        $this->sendFile($data['message']['from']['id'],"BQACAgQAAxkDAAIYc2I202ZG-2E4MJEVMs8IW35zUQrQAAJrCwACic64UTFES_8HV_BbIwQ");
                        $this->askQuestion(1, $data['message']['from']['id']);
                        //insert user data into database and start asking questions
                    } elseif (RobotUser::where('chat_id', '=', $data['message']['from']['id'])->exists() && $robotUser->respiratory_disease == 1 && $robotUser->question_counter == 15) {
                        $robotUser->respiratory_name = $data['message']['text'];
                        $robotUser->save();
                        $this->askQuestion(16, $data['message']['from']['id']);
                    } elseif (RobotUser::where('chat_id', '=', $data['message']['from']['id'])->exists() && $robotUser->question_counter == 10) {
//                        $this->editTextMessageButton($data);
                        $robotUser->other_covid_sign = $data['message']['text'];
                        $robotUser->question_counter = '11';
                        $robotUser->save();
                        $this->askQuestion(11, $data['message']['from']['id']);
                    }elseif (RobotUser::where('chat_id', '=', $data['message']['from']['id'])->exists() && $robotUser->question_counter == 23){
//                        $this->editTextMessageButton($data);
                        $twoWeekReportUser = TwoWeeksReport::where('chat_id', '=', $data['message']['from']['id'])->first();
                        $twoWeekReportUser->other_covid_sign = $data['message']['text'];
                        $robotUser->question_counter = '24';
                        $twoWeekReportUser->save();
                        $robotUser->save();
                        $this->askQuestion(24, $data['message']['from']['id']);
                    } elseif (RobotUser::where('chat_id', '=', $data['message']['from']['id'])->exists() && $robotUser->question_counter == 26 && $robotUser->agree == 1 ) {
//                        $this->editTextMessageButton($data);
                        $robotUser->contact_info = $data['message']['text'];
                        $robotUser->question_counter = '27';
                        $robotUser->save();
                        $this->sendMessage($data['message']['from']['id'],'با آروزی سلامتی شما. خدانگهدار');
                    }
                    else {
                        $this->sendMessage($data['message']['from']['id'], 'متاسفانه عبارتی که وارد کرده‌اید نامعتبر می‌باشد. در صورتی که می‌خواهید مجددا اقدام به پر کردن فرم کنید عبارت /start را برای ربات ارسال کنید.');
                    }

                } elseif (array_key_exists('voice', $data['message'])) {
                    if (RobotUser::where('chat_id', '=', $data['message']['from']['id'])->exists()) {
                        $robotUser = RobotUser::where('chat_id', '=', $data['message']['from']['id'])->first();
                        //recieving voices
                        //16 must be 17 and change file id
                        if ($robotUser->question_counter == 17 || $robotUser->question_counter == 25) {
                            if ($robotUser->voice_counter == 0  || $robotUser->voice_counter == 9) {
                                if($robotUser->voice_counter == 0){
                                    $robotUser->deep_breath = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 1;
                                    $robotUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 1);
                                }elseif ($robotUser->voice_counter == 9){
                                    $robotUser->second_deep_breath = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 10;
                                    $robotUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 10);
                                }
                                $this->sendVoiceMessage($data['message']['from']['id'], 2);
                            } elseif ($robotUser->voice_counter == 1 || $robotUser->voice_counter == 10) {
                                if ($robotUser->voice_counter == 1){
                                    $robotUser->breath = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 2;
                                    $robotUser->save();
                                    //$this->sendMessage($data['message']['from']['id'], 'صدای دوم شما دریافت شد. لطفا نمونه سوم صدای خود را ارسال کنید.');
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 2);
                                }elseif ($robotUser->voice_counter == 10){
                                    $robotUser->second_breath = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 11;
                                    $robotUser->save();
                                    //$this->sendMessage($data['message']['from']['id'], 'صدای دوم شما دریافت شد. لطفا نمونه سوم صدای خود را ارسال کنید.');
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 11);
                                }
                                $this->sendVoiceMessage($data['message']['from']['id'], 3);
                            } elseif ($robotUser->voice_counter == 2 || $robotUser->voice_counter == 11 ) {
                                if ($robotUser->voice_counter == 2){
                                    $robotUser->slow_cough = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 3;
                                    $robotUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 3);
                                }elseif ($robotUser->voice_counter == 11){
                                    $robotUser->second_slow_cough = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 12;
                                    $robotUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 12);
                                }
                                $this->sendVoiceMessage($data['message']['from']['id'], 4);
                            } elseif ($robotUser->voice_counter == 3 || $robotUser->voice_counter == 12 ) {
                                if ($robotUser->voice_counter == 3){
                                    $robotUser->cough = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 4;
                                    $robotUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 4);
                                }elseif ($robotUser->voice_counter == 12){
                                    $robotUser->second_cough = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 13;
                                    $robotUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 13);
                                }
                                $this->sendVoiceMessage($data['message']['from']['id'], 5);
                            } elseif ($robotUser->voice_counter == 4 || $robotUser->voice_counter == 13) {
                                if ($robotUser->voice_counter == 4){
                                    $robotUser->slow_numbers = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 5;
                                    $robotUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 5);
                                }elseif ($robotUser->voice_counter == 13){
                                    $robotUser->second_slow_numbers = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 14;
                                    $robotUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 14);
                                }
                                $this->sendVoiceMessage($data['message']['from']['id'], 6);
                            } elseif ($robotUser->voice_counter == 5 || $robotUser->voice_counter == 14) {
                                if ($robotUser->voice_counter == 5){
                                    $robotUser->fast_numbers = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 6;
                                    $robotUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 6);
                                }elseif ($robotUser->voice_counter == 14){
                                    $robotUser->second_fast_numbers = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 15;
                                    $robotUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 15);
                                }
                                $this->sendVoiceMessage($data['message']['from']['id'], 7);
                            } elseif ($robotUser->voice_counter == 6 || $robotUser->voice_counter == 15 ) {
                                if ($robotUser->voice_counter == 6){
                                    $robotUser->a_voice = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 7;
                                    $robotUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 7);
                                }elseif($robotUser->voice_counter == 15){
                                    $robotUser->second_a_voice = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 16;
                                    $robotUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 16);
                                }
                                $this->sendVoiceMessage($data['message']['from']['id'], 8);
                            } elseif ($robotUser->voice_counter == 7 || $robotUser->voice_counter == 16 ) {
                                if ($robotUser->voice_counter == 7){
                                    $robotUser->b_voice = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 8;
                                    $robotUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 8);
                                }elseif($robotUser->voice_counter == 16){
                                    $robotUser->second_b_voice = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 17;
                                    $robotUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 17);
                                }
                                $this->sendVoiceMessage($data['message']['from']['id'], 9);
                            } elseif ($robotUser->voice_counter == 8 || $robotUser->voice_counter == 17) {
                                if ($robotUser->voice_counter == 8){
                                    $robotUser->c_voice = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 9;
                                    $robotUser->is_completed = 1;
                                    $robotUser->save();
                                    //insert user into twoweeksreport tabel
                                    $twoWeekdReportUser = TwoWeeksReport::firstOrNew(array(
                                        'chat_id' => $robotUser->chat_id
                                    ));
                                    $twoWeekdReportUser->username = $robotUser->username;
                                    $twoWeekdReportUser->covid_sign = 'nothing';
                                    $twoWeekdReportUser->have_cold = 0;
                                    $twoWeekdReportUser->have_cough = 0;
                                    $twoWeekdReportUser->have_headache = 0;
                                    $twoWeekdReportUser->have_stomachache = 0;
                                    $twoWeekdReportUser->other_covid_sign = null;
                                    $twoWeekdReportUser->covid_test = null;
                                    $twoWeekdReportUser->is_message_sent = 0;
                                    $twoWeekdReportUser->is_reported = 0;
                                    $twoWeekdReportUser->is_completed = 0;
                                    $twoWeekdReportUser->created_at = Carbon::now();
                                    $twoWeekdReportUser->send_message_date = Carbon::now()->addDays(14)->toDateTimeString();
                                    $twoWeekdReportUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 9);

                                    $this->sendMessage($data['message']['from']['id'], 'به منظور تکمیل اطلاعات شما دو هفته دیگر مجددا سوالاتی از شما پرسیده خواهد شد. با تشکر از همراهی شما');

                                }elseif($robotUser->voice_counter == 17){
                                    $tracking_code = $this->generateBarcodeNumber();
                                    $robotUser->second_c_voice = $data['message']['voice']['file_id'];
                                    $robotUser->voice_counter = 18;
                                    //change is completed to one after two weeks
                                    $robotUser->is_completed = 1;
                                    $robotUser->tracking_code = $tracking_code;
                                    $robotUser->save();
                                    $this->downloadVoiceFile($data['message']['voice']['file_id'], $data['message']['from']['id'], 18);
                                    $this->sendMessage($data['message']['from']['id'], 'با تشکر از همراهی شما. شما می‌توانید جهت کسب اطلاعات بیشتر در رابطه با پژوهش با ارائه کد پیگیری '.$tracking_code.' به آدرس پست الکترونیکی ferdowsi_covidresearch@gmail.com در ارتباط باشید.');
                                    $this->askQuestion(25,$data['message']['from']['id']);
                                }
                                //end
                            } else {
                                $this->sendMessage($data['message']['from']['id'], 'شما دیگر قادر به ارسال پیام صوتی نیستید. در صورتی که میخواهید مجددا صدای خود را ارسال کنید عبارت /start را وارد کنید و از ابتدا به سوالات پاسخ دهید.');
                            }
//                            $robotUser->question_counter = 9;
                        } else {
                            $this->sendMessage($data['message']['from']['id'], 'درحال حاضر نمی‌توانید برای ربات صدا ارسال کنید. لطفا پس از پاسخ به تمامی سوالات، با توجه به صدای نمونه صدای خود را برای ربات ارسال کنید. به منظور ارسال مجدد صدا لطفا بر روی /start کلیک کنید و از ابتدا به سوالات پاسخ دهید.');
                        }
                    }
                }
            } elseif (array_key_exists('callback_query', $data)) {
                $this->editMessage($data);
                $explodedResult = explode('@', $data['callback_query']['data']);
                $this->answerProcess($explodedResult, $data['callback_query']['message']['chat']);
            } else {
                $datas = [
                    'text' => 'اطلاعات داده شده ناقص می‌باشد',
                    'chat_id' => $data['message']['from']['id']
                ];
                file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/sendMessage?" . http_buil_query($datas));
            }
        } catch (Exception $e) {
            dd($e);
        } finally {

        }
    }

    public function twoWeeksReport()
    {

        $date = Carbon::now()->toDateTimeString();
        $date = "'" . $date . "'";
        //another where is neccessary here for message sent part
        $twoWeeksReportUsers = TwoWeeksReport::whereRaw('DATEDIFF(' . $date . ',updated_at) = 14')->where('is_message_sent','=',0)->get();
        foreach ($twoWeeksReportUsers as $twoWeeksReportUser) {
            $twoWeeksReportUser->is_message_sent = 1;
            $twoWeeksReportUser->save();
            $this->askQuestion(17,$twoWeeksReportUser->chat_id);
        }
    }
}
