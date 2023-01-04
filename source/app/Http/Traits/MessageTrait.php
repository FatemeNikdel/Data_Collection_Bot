<?php

namespace App\Http\Traits;

use App\RobotUser;
use App\TwoWeeksReport;
use function Symfony\Component\String\b;

trait MessageTrait
{
    public function deleteMessage($data)
    {
        $datas = [
            'chat_id' => $data['callback_query']['message']['chat']['id'],
            'message_id' => $data['callback_query']['message']['message_id'],
        ];
        file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/deleteMessage?" . http_build_query($datas));
    }

    public function sendMessage($chatId, $text, $keyboard = [])
    {
        if (empty($keyboard)) {
            $datas = [
                'text' => $text,
                'chat_id' => $chatId
            ];
            file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/sendMessage?" . http_build_query($datas));
        } else {
            $keyboard = json_encode($keyboard, true);
            $sendTo = "https://api.telegram.org/bot" . env('APITOKEN') . "/sendMessage?chat_id=" . $chatId . "&text=" . $text . "&parse_mode=HTML&reply_markup=$keyboard";
            file_get_contents($sendTo);
        }
    }

    public function sendFile($chatId, $file_id)
    {
            //https://api.telegram.org/bot2008132576:AAEip18zYOyUNdFk9tebxFcFS7rUA8a_nTo/sendDocument?chat_id=129101046
            $sendTo = "https://api.telegram.org/bot" . env('APITOKEN') . "/sendDocument?chat_id=" . $chatId . "&document=" . $file_id . "&parse_mode=HTML";
            file_get_contents($sendTo);
    }

    public function sendVoiceMessage($chatId, $voiceNumber)
    {

        switch ($voiceNumber) {
            case '1':
                $file_id = 'AwACAgQAAxkDAAIJVGGCSO3e_mWEom2edjnw5R6gdgYrAALmDQACnHsRUCo6Hza5XNymIQQ';
                file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/sendVoice?chat_id=" . $chatId . '&voice=' . $file_id);
                break;
            case '2':
                $this->sendMessage($chatId, 'لطفا به صورت صدای ارسال شده کم عمق تنفس کنید.');
                $file_id = 'AwACAgQAAxkDAAIJVWGCU3A3mas1iS8feXQFvaXnM0M1AAL1DQACnHsRUF-YjOXGaOpiIQQ';
                file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/sendVoice?chat_id=" . $chatId . '&voice=' . $file_id);
                break;
            case '3':
                $this->sendMessage($chatId, 'لطفا به صورت فایل نمونه عمیق سرفه کنید.');
                $file_id = 'AwACAgQAAxkDAAIJVmGCU5iDddIz5-Ekr3RyC2IKsNr9AAL2DQACnHsRUMFLPRZvrLQwIQQ';
                file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/sendVoice?chat_id=" . $chatId . '&voice=' . $file_id);
                break;
            case '4':
                $this->sendMessage($chatId, 'لطفا به صورت فایل نمونه کم عمق سرفه کنید. ');
                $file_id = 'AwACAgQAAxkDAAIJV2GCU8Tax3rNvITuX6I_coxjJ0lWAAL4DQACnHsRUKLscA3EHqvuIQQ';
                file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/sendVoice?chat_id=" . $chatId . '&voice=' . $file_id);
                break;
            case '5':
                $this->sendMessage($chatId, 'لطفا به صورت فایل نمونه اعداد را آهسته بشمارید.');
                $file_id = 'AwACAgQAAxkDAAIJWGGCU9kUadBDSqCwROuSyFK1vAN8AAL5DQACnHsRUE9XL5tLv3TeIQQ';
                file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/sendVoice?chat_id=" . $chatId . '&voice=' . $file_id);
                break;
            case '6':
                $this->sendMessage($chatId, 'لطفا به صورت صدای ارسال شده اعداد را سریع بشمارید.');
                $file_id = 'AwACAgQAAxkDAAIJWWGCU_DsTbolybqexZ26Oschd_dJAAL6DQACnHsRUJQwBXHA0OKuIQQ';
                file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/sendVoice?chat_id=" . $chatId . '&voice=' . $file_id);
                break;
            case '7':
                $this->sendMessage($chatId, 'لطفا به صورت کشیده آآآ بگویید.');
                $file_id = 'AwACAgQAAxkDAAIJWmGCVAcAAU8Eb5l-SaqcB8skX6PkOQAC-w0AApx7EVCH9msYMrVGRyEE';
                file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/sendVoice?chat_id=" . $chatId . '&voice=' . $file_id);
                break;
            case '8':
                $this->sendMessage($chatId, 'لطفا به صورت کشیده اُاُاُ بگویید.');
                $file_id = 'AwACAgQAAxkDAAIJW2GCVBqHzFaNA_weXBHhpFma_yBqAAL8DQACnHsRUEoD3b5jbj11IQQ';
                file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/sendVoice?chat_id=" . $chatId . '&voice=' . $file_id);
                break;
            case '9':
                $this->sendMessage($chatId, 'لطفا به صورت کشیده اِاِاِ بگویید.');
                $file_id = 'AwACAgQAAxkDAAIJXGGCVCs7Zo84IJOvtfq_mWlnuOxNAAL9DQACnHsRUIetZLsaiL_XIQQ';
                file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/sendVoice?chat_id=" . $chatId . '&voice=' . $file_id);
                break;
        }
    }

    public function editMessage($data)
    {
        $datas = [
            'chat_id' => $data['callback_query']['message']['chat']['id'],
            'message_id' => $data['callback_query']['message']['message_id'],
            'keyboard' => null
        ];
        file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/editMessageReplyMarkup?" . http_build_query($datas));
    }

    public function editTextMessageButton($data)
    {
        $datas = [
            'chat_id' => $data['message']['chat']['id'],
            'message_id' => $data['message']['message_id'],
            'keyboard' => null
        ];
        file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/editMessageReplyMarkup?" . http_build_query($datas));
    }

    public function askQuestion($questionNumber, $chatId)
    {
        switch ($questionNumber) {
            case '1':
                $keyboard = array(
                    "inline_keyboard" => array(array(array("text" => "موافق نیستم", "callback_data" => "0@1"), array("text" => "موافقم", "callback_data" => "1@1")))
                );
                $this->sendMessage($chatId, '۱ - آیا مایل به ضبط صدای خود برای تشخیص بیماری هستید؟', $keyboard);
                break;
            case '2':
                $keyboard = array(
                    "inline_keyboard" => array(
                        array(
                            array("text" => "زیر ۲۰ سال", "callback_data" => "1@2"),
                            array("text" => "بین ۲۰ تا ۴۰ سال", "callback_data" => "2@2"),
                        ),
                        array(
                            array("text" => "بین ۴۰ تا ۶۰ سال", "callback_data" => "3@2"),
                            array("text" => "بالای ۶۰ سال", "callback_data" => "4@2"),
                        )
                    )
                );
                $this->sendMessage($chatId, '۲ - سن شما چقدر است؟', $keyboard);
                break;
            case '3':
                $keyboard = array(
                    "inline_keyboard" => array(array(array("text" => "زن", "callback_data" => "0@3"), array("text" => "مرد", "callback_data" => "1@3")))
                );
                $this->sendMessage($chatId, '۳ - جنسیت شما چیست؟', $keyboard);
                break;
            case '4':
                $keyboard = array(
                    "inline_keyboard" => array(
                        array(
                            array("text" => "خیر", "callback_data" => "0@4"), array("text" => "بله", "callback_data" => "1@4")
                        ),
                        array(
                            array("text" => "نمی‌دانم", "callback_data" => "2@4"), array("text" => "احتمال می‌دهم", "callback_data" => "3@4")
                        )
                    )
                );
                $this->sendMessage($chatId, '۴ - آیا به بیماری کرونا مبتلا هستید؟', $keyboard);
                break;
            case '5':
                $keyboard = array(
                    "inline_keyboard" => array(array(array("text" => "خیر", "callback_data" => "0@5"), array("text" => "بله", "callback_data" => "1@5")))
                );
                $this->sendMessage($chatId, '۵ - آیا تب و لرز دارید؟', $keyboard);
                break;
            case '6':
                $keyboard = array(
                    "inline_keyboard" => array(array(array("text" => "خیر", "callback_data" => "0@6"), array("text" => "بله", "callback_data" => "1@6")))
                );
                $this->sendMessage($chatId, '۶ - آیا سرفه می‌کنید؟', $keyboard);
                break;
            case '7':
                $keyboard = array(
                    "inline_keyboard" => array(array(array("text" => "خیر", "callback_data" => "0@7"), array("text" => "بله", "callback_data" => "1@7")))
                );
                $this->sendMessage($chatId, '۷ - آیا سردرد دارید؟', $keyboard);
                break;
            case '8':
                $keyboard = array(
                    "inline_keyboard" => array(array(array("text" => "خیر", "callback_data" => "0@8"), array("text" => "بله", "callback_data" => "1@8")))
                );
                $this->sendMessage($chatId, '۸ - آیا تنگی نفس دارید؟', $keyboard);
                break;

            case '9':
                $keyboard = array(
                    "inline_keyboard" => array(array(array("text" => "علائم دیگری ندارم", "callback_data" => "0@9"), array("text" => "علامت دیگری دارم", "callback_data" => "1@9")))
                );
                $this->sendMessage($chatId, '۹ - در صورتی که از علائم شایع کرونا علامت دیگری نیز دارید برای ربات ارسال کنید و در غیر اینصورت دکمه زیر را فشار دهید.', $keyboard);
                break;
            case '10':
                $this->sendMessage($chatId, 'دیگر علائم خود را ارسال بفرمایید.');
                break;
            case '11':
                $keyboard = array(
                    "inline_keyboard" => array(
                        array(
                            array("text" => "بله، نتیجه مثبت بود", "callback_data" => "2@11"), array("text" => "بله، نتیجه منفی بود", "callback_data" => "1@11")
                        ),
                        array(
                            array("text" => "خیر", "callback_data" => "0@11")
                        )
                    )
                );
                $this->sendMessage($chatId, '۱۰ - آیا آزمایش تشخیص کرونا داده‌اید؟', $keyboard);
                break;
            case '12':
                $keyboard = array(
                    "inline_keyboard" => array(
                        array(
                            array("text" => "خیر", "callback_data" => "0@12"), array("text" => "بله", "callback_data" => "1@12")
                        )
                    )
                );
                $this->sendMessage($chatId, '۱۱ - آیا طی یک ماه اخیر با افراد مبتلا به کوید در ارتباط بوده‌اید؟', $keyboard);
                break;
            case '13':
                $keyboard = array(
                    "inline_keyboard" => array(
                        array(
                            array("text" => "بله دوز اول", "callback_data" => "1@13"), array("text" => "بله دوز دوم", "callback_data" => "2@13"),array("text" => "بله دوز سوم", "callback_data" => "3@13")
                        ),
                        array(
                            array("text" => "خیر", "callback_data" => "0@13")
                        ),
                        array(
                            array("text" => "مایل به پاسخ گویی نیستم", "callback_data" => "4@13")
                        )
                    )
                );
                $this->sendMessage($chatId, '۱۲ - آیا واکسن کرونا زده‌اید؟', $keyboard);
                break;
            case '14':
                $keyboard = array(
                    "inline_keyboard" => array(
                        array(
                            array("text" => "آسم", "callback_data" => "2@14"),
                            array("text" => "آنفولانزا", "callback_data" => "3@14"),
                            array("text" => "آلرژی", "callback_data" => "4@14")
                        ),
                        array(
                            array("text" => "برونشیت", "callback_data" => "5@14"),
                            array("text" => "سرماخوردگی", "callback_data" => "6@14"),
                            array("text" => "سایر بیماری‌ها", "callback_data" => "1@14")
                        ),
                        array(
                            array("text" => "خیر", "callback_data" => "0@14")
                        )
                    )
                );
                $this->sendMessage($chatId, '۱۳ - آیا به بیماری‌های زیر مبتلا هستید؟', $keyboard);
                break;
            case '15':
                $this->sendMessage($chatId, 'نام بیماری خود را بنویسید.');
                break;
            case '16':
                $robotUser = RobotUser::where('chat_id', '=', $chatId)->first();
                $robotUser->question_counter = 17;
                $robotUser->save();
                $this->sendMessage($chatId,'لطفا گوشی خود را در فاصله یک وجبی از دهان خود نگه دارید و مانند نمونه‌های صوتی که برایتان ارسال می‌شود صدای خود را ضبط و ارسال کنید.');
                $this->sendMessage($chatId, 'لطفا به صورت فایل نمونه نقس عمیق بکشید.');
                $this->sendVoiceMessage($chatId, 1);
                //sending sample void

                break;
            case '17':
                $keyboard = array(
                    "inline_keyboard" => array(array(array("text" => "خیر", "callback_data" => "0@17"), array("text" => "بله", "callback_data" => "1@17")))
                );
                $this->sendMessage($chatId, '۱۴ - آیا علائم کرونا را دارید؟', $keyboard);
                break;
            case '18':
                $keyboard = array(
                    "inline_keyboard" => array(array(array("text" => "خیر", "callback_data" => "0@18"), array("text" => "بله", "callback_data" => "1@18")))
                );
                $this->sendMessage($chatId, '۱۵ - آیا تب و لرز دارید؟', $keyboard);
                break;
            case '19':
                $keyboard = array(
                    "inline_keyboard" => array(array(array("text" => "خیر", "callback_data" => "0@19"), array("text" => "بله", "callback_data" => "1@19")))
                );
                $this->sendMessage($chatId, '۱۶ - آیا سرفه می‌کنید؟', $keyboard);
                break;
            case '20':
                $keyboard = array(
                    "inline_keyboard" => array(array(array("text" => "خیر", "callback_data" => "0@20"), array("text" => "بله", "callback_data" => "1@20")))
                );
                $this->sendMessage($chatId, '۱۷ - آیا سردرد دارید؟', $keyboard);
                break;
            case '21':
                $keyboard = array(
                    "inline_keyboard" => array(array(array("text" => "خیر", "callback_data" => "0@21"), array("text" => "بله", "callback_data" => "1@21")))
                );
                $this->sendMessage($chatId, '۱۸ - آیا تنگی نفس دارید؟', $keyboard);
                break;
            case '22':
                $keyboard = array(
                    "inline_keyboard" => array(array(array("text" => "علائم دیگری ندارم", "callback_data" => "0@22"), array("text" => "علامت دیگری دارم", "callback_data" => "1@22")))
                );
                $this->sendMessage($chatId, '۱۹ - در صورتی که از علائم شایع کرونا علامت دیگری نیز دارید برای ربات ارسال کنید و در غیر اینصورت دکمه زیر را فشار دهید.', $keyboard);
                break;
            case '24':
                $keyboard = array(
                    "inline_keyboard" => array(
                        array(
                            array("text" => "بله، نتیجه مثبت بود", "callback_data" => "2@24"), array("text" => "بله، نتیجه منفی بود", "callback_data" => "1@24")
                        ),
                        array(
                            array("text" => "خیر", "callback_data" => "0@24")
                        )
                    )
                );
                $this->sendMessage($chatId, '۲۰ - آیا آزمایش تشخیص کرونا داده‌اید؟', $keyboard);
                break;
            case '25':
                $keyboard = array(
                    "inline_keyboard" => array(array(array("text" => "خیر", "callback_data" => "0@25"), array("text" => "بله", "callback_data" => "1@25")))
                );
                $this->sendMessage($chatId, 'آیا در صورت نیاز مایل به همکاری و نمونه‌گیری حضوری هستید؟', $keyboard);
                break;
            default:
                $this->sendMessage($chatId, 'سوالات شما به پایان رسید.');
                break;
        }
    }

    public function answerProcess($explodedResult, $chat)
    {
        switch ($explodedResult[1]) {
            case '1':
                if ($explodedResult[0]) {
                    $robotUser = new RobotUser();
                    $robotUser->chat_id = $chat['id'];
                    $robotUser->username = $chat['username'];
                    $robotUser->question_counter = '2';
                    $robotUser->save();
                    $this->sendMessage($chat['id'], 'ممنون از انتخاب شما. لطفا به سوالات با دقت پاسخ دهید.');
                    $this->askQuestion(2, $chat['id']);
                } else {
                    $this->sendMessage($chat['id'], 'جواب شما منفی بود. درصورتی که می‌خواهید از ربات استفاده کنید عبارت /start را بزنید. ');
                }
                break;
            case '2':

                $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                $robotUser->age = $explodedResult[0];
                $robotUser->question_counter = '3';
                $robotUser->save();

                switch ($explodedResult[0]) {
                    case '1':
                        $this->sendMessage($chat['id'], 'سن شما کمتر ۲۰ سال است.');
                        break;
                    case '2':
                        $this->sendMessage($chat['id'], 'سن شما در بازه‌ی بین ۲۰ تا ۴۰ سال قرار دارد.');
                        break;
                    case '3':
                        $this->sendMessage($chat['id'], 'سن شما در بازه‌ی بین ۴۰ تا ۶۰ سال قرار دارد.');
                        break;
                    case '4':
                        $this->sendMessage($chat['id'], 'سن شما بیشتر از ۶۰ سال است.');
                        break;
                    default:
                        $this->sendMessage($chat['id'], 'سن شما در بازه‌ی تعریف شده نمی‌باشد.');
                        break;
                }
                $this->askQuestion(3, $chat['id']);
                break;
            case '3':

                $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                $robotUser->sex = $explodedResult[0];
                $robotUser->question_counter = '4';
                $robotUser->save();
                $sex = ($explodedResult[0]) ? 'مرد' : 'زن';
                $this->sendMessage($chat['id'], 'جنسیت شما ' . $sex . ' است.');
                $this->askQuestion(4, $chat['id']);

                break;

            case '4':
            case '17':
                if ($explodedResult[1] == '4') {
//                    $question_counter = ($explodedResult[0]) ? 5 : 11;
                    $question_counter = ($explodedResult[0]) ? 5 : 5;
                    $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                    $robotUser->covid_sign = $explodedResult[0];
                    $robotUser->question_counter = $question_counter;
                    $robotUser->save();
//                    $covid_sign = ($explodedResult[0]) ? 'هستید.' : 'نیستید.';

                    switch ($explodedResult[0]){
                        case '0':
                            $this->sendMessage($chat['id'], 'شما به بیماری کرونا مبتلا نیستید.');
                            break;
                        case '1':
                            $this->sendMessage($chat['id'], 'شما به بیماری کرونا مبتلا هستید.');
                            break;
                        case '2':
                        case '3':
                            $this->sendMessage($chat['id'], 'ممکن است شما به بیماری کرونا مبتلا باشید.');
                            break;
                        default:
                            $this->sendMessage($chat['id'], 'جواب شما معتبر نیست.');
                            break;
                    }

                    $this->askQuestion($question_counter, $chat['id']);
                } elseif ($explodedResult[1] == '17') {
                    $question_counter = ($explodedResult[0]) ? 18 : 18;
                    $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                    $twoWeeksReportUser = TwoWeeksReport::where('chat_id', '=', $chat['id'])->first();
                    $robotUser->question_counter = $question_counter;
                    $twoWeeksReportUser->covid_sign = $explodedResult[0];
                    $robotUser->save();
                    $twoWeeksReportUser->save();
//                    $covid_sign = ($explodedResult[0]) ? 'هستید.' : 'نیستید.';
//                    $this->sendMessage($chat['id'], 'شما به بیماری کرونا مبتلا ' . $covid_sign);
                    switch ($explodedResult[0]){
                        case '0':
                            $this->sendMessage($chat['id'], 'شما به بیماری کرونا مبتلا نیستید.');
                            break;
                        case '1':
                            $this->sendMessage($chat['id'], 'شما به بیماری کرونا مبتلا هستید.');
                            break;
                        case '2':
                        case '3':
                            $this->sendMessage($chat['id'], 'ممکن است شما به بیماری کرونا مبتلا باشید.');
                            break;
                        default:
                            $this->sendMessage($chat['id'], 'جواب شما معتبر نیست.');
                            break;
                    }
                    $this->askQuestion($question_counter, $chat['id']);
                }
                break;
            case '5':
            case '18':
                if ($explodedResult[1] == '5') {
                    $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                    $robotUser->have_cold = $explodedResult[0];
                    $robotUser->question_counter = '6';
                    $robotUser->save();
                    $have_cold = ($explodedResult[0]) ? 'دارید.' : 'ندارید.';
                    $this->sendMessage($chat['id'], 'شما تب و لرز ' . $have_cold);
                    $this->askQuestion(6, $chat['id']);
                } elseif ($explodedResult[1] == '18') {
                    $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                    $twoWeeksReportUser = TwoWeeksReport::where('chat_id', '=', $chat['id'])->first();
                    $twoWeeksReportUser->have_cold = $explodedResult[0];
                    $robotUser->question_counter = '19';
                    $robotUser->save();
                    $twoWeeksReportUser->save();
                    $have_cold = ($explodedResult[0]) ? 'دارید.' : 'ندارید.';
                    $this->sendMessage($chat['id'], 'شما تب و لرز ' . $have_cold);
                    $this->askQuestion(19, $chat['id']);
                }
                break;
            case '6':
            case '19':
                if ($explodedResult[1] == '6') {
                    $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                    $robotUser->have_cough = $explodedResult[0];
                    $robotUser->question_counter = '7';
                    $robotUser->save();
                    $have_cough = ($explodedResult[0]) ? 'می‌کنید.' : 'نمی‌کنید.';
                    $this->sendMessage($chat['id'], 'شما سرفه ' . $have_cough);
                    $this->askQuestion(7, $chat['id']);
                } elseif ($explodedResult[1] == '19') {
                    $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                    $twoWeeksReportUser = TwoWeeksReport::where('chat_id', '=', $chat['id'])->first();
                    $twoWeeksReportUser->have_cough = $explodedResult[0];
                    $robotUser->question_counter = '20';
                    $robotUser->save();
                    $twoWeeksReportUser->save();
                    $have_cough = ($explodedResult[0]) ? 'می‌کنید.' : 'نمی‌کنید.';
                    $this->sendMessage($chat['id'], 'شما سرفه ' . $have_cough);
                    $this->askQuestion(20, $chat['id']);
                }
                break;
            case '7':
            case '20':
                if ($explodedResult[1] == '7') {
                    $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                    $robotUser->have_headache = $explodedResult[0];
                    $robotUser->question_counter = '8';
                    $robotUser->save();
                    $have_headache = ($explodedResult[0]) ? 'دارید.' : 'ندارید.';
                    $this->sendMessage($chat['id'], 'شما سر درد ' . $have_headache);
                    $this->askQuestion(8, $chat['id']);
                } elseif ($explodedResult[1] == '20') {
                    $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                    $twoWeeksReportUser = TwoWeeksReport::where('chat_id', '=', $chat['id'])->first();
                    $twoWeeksReportUser->have_headache = $explodedResult[0];
                    $robotUser->question_counter = '21';
                    $robotUser->save();
                    $twoWeeksReportUser->save();
                    $have_headache = ($explodedResult[0]) ? 'دارید.' : 'ندارید.';
                    $this->sendMessage($chat['id'], 'شما سر درد ' . $have_headache);
                    $this->askQuestion(21, $chat['id']);
                }
                break;
            case '8':
            case '21':
                if ($explodedResult[1] == '8') {
                    $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                    $robotUser->have_stomachache = $explodedResult[0];
                    $robotUser->question_counter = '9';
                    $robotUser->save();
                    $have_stomachache = ($explodedResult[0]) ? 'دارید.' : 'ندارید.';
                    $this->sendMessage($chat['id'], 'شما تنگی نفس ' . $have_stomachache);
                    $this->askQuestion(9, $chat['id']);
                } elseif ($explodedResult[1] == '21') {
                    $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                    $twoWeeksReportUser = TwoWeeksReport::where('chat_id', '=', $chat['id'])->first();
                    $twoWeeksReportUser->have_stomachache = $explodedResult[0];
                    $robotUser->question_counter = '22';
                    $twoWeeksReportUser->save();
                    $robotUser->save();
                    $have_stomachache = ($explodedResult[0]) ? 'دارید.' : 'ندارید.';
                    $this->sendMessage($chat['id'], 'شما تنگی نفس ' . $have_stomachache);
                    $this->askQuestion(22, $chat['id']);
                }
                break;
            case '9':
            case '22':
                if ($explodedResult[1] == '9') {
                    $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                    $robotUser->other_covid_sign = $explodedResult[0];
                    $robotUser->question_counter = '10';
                    $robotUser->save();
                    $other_covid_sign = ($explodedResult[0]) ? 'دارید.' : 'ندارید.';
                    $this->sendMessage($chat['id'], 'شما علامت دیگری  ' . $other_covid_sign);
                    ($explodedResult[0]) ? $this->askQuestion(10, $chat['id']) : $this->askQuestion(11, $chat['id']);
                } elseif ($explodedResult[1] == '22') {
                    $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                    $twoWeeksReportUser = TwoWeeksReport::where('chat_id', '=', $chat['id'])->first();
                    $twoWeeksReportUser->other_covid_sign = $explodedResult[0];
                    $robotUser->question_counter = '23';
                    $twoWeeksReportUser->save();
                    $robotUser->save();
                    $other_covid_sign = ($explodedResult[0]) ? 'دارید.' : 'ندارید.';
                    $this->sendMessage($chat['id'], 'شما علامت دیگری  ' . $other_covid_sign);
                    ($explodedResult[0]) ? $this->askQuestion(10, $chat['id']) : $this->askQuestion(24, $chat['id']);
                }
                break;
            case '11':
            case '24':
                if ($explodedResult[1] == '11') {
                    $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                    $robotUser->covid_test = $explodedResult[0];
                    $robotUser->question_counter = '12';
                    $robotUser->save();
                    if ($explodedResult[0] == 0) {
                        $covidResult = 'شما آزمایش کرونا نداده‌اید.';
                    } elseif ($explodedResult[0] == 1) {
                        $covidResult = 'نتیجه تست کرونای شما منفی بوده است. ';
                    } else {
                        $covidResult = 'نتیجه تست کرونای شما مثبت بوده است. ';
                    }
                    $this->sendMessage($chat['id'], $covidResult);
                    $this->askQuestion(12, $chat['id']);
                } elseif ($explodedResult[1] == '24') {
                    $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                    $twoWeeksReportUser = TwoWeeksReport::where('chat_id', '=', $chat['id'])->first();
                    $twoWeeksReportUser->covid_test = $explodedResult[0];
                    $twoWeeksReportUser->is_completed = 1;
                    $robotUser->question_counter = '25';
                    $tracking_code = $robotUser->tracking_code;
                    $twoWeeksReportUser->save();
                    $robotUser->save();
                    if ($explodedResult[0] == 0) {
                        $covidResult = 'شما آزمایش کرونا نداده‌اید.';
                    } elseif ($explodedResult[0] == 1) {
                        $covidResult = 'نتیجه تست کرونای شما منفی بوده است. ';
                    } else {
                        $covidResult = 'نتیجه تست کرونای شما مثبت بوده است. ';
                    }
                    $this->sendMessage($chat['id'], $covidResult);

                    //sending voice messasge after two weeks
                    $this->sendMessage($chat['id'],'لطفا گوشی خود را در فاصله یک وجبی از دهان خود نگه دارید و مانند نمونه‌های صوتی که برایتان ارسال می‌شود صدای خود را ضبط و ارسال کنید.');
                    $this->sendMessage($chat['id'], 'لطفا به صورت فایل نمونه نقس عمیق بکشید.');
                    $this->sendVoiceMessage($chat['id'], 1);

                    //must be sent after all voice messages
//                    $this->sendMessage($chat['id'], 'با تشکر از همراهی شما. همچنین میتوانید جهت کسب اطلاعات بیشتر در رابطه با پژوهش با ارائه کد پیگیری' . $tracking_code . ' به آدرس پست الکترونیکی nikdel_fateme@mail.um.ac.ir در ارتباط باشید.');
                }

                break;
            case '12':

                $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                $robotUser->covid_relation = $explodedResult[0];
                $robotUser->question_counter = '13';
                $robotUser->save();
                $covid_relation_text = ($explodedResult[0]) ? 'بوده‌اید.' : 'نبوده‌اید.';
                $this->sendMessage($chat['id'], 'شما با افراد مبتلا به کویید در ارتباط ' . $covid_relation_text);
                $this->askQuestion(13, $chat['id']);

                break;
            case '13':

                $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                $robotUser->is_vaccinated = $explodedResult[0];
                $robotUser->question_counter = '14';
                $robotUser->save();

//                $is_vaccinated = ($explodedResult[0]) ? 'زده‌اید.' : 'نزده‌اید';
//                $this->sendMessage($chat['id'], 'شما واکسن کرونا را ' . $is_vaccinated);
            switch ($explodedResult[0]){
                case '0':
                    $this->sendMessage($chat['id'], 'شما واکسن کرونا نزده‌اید.');
                    break;
                case '1':
                    $this->sendMessage($chat['id'], 'شما دوز اول واکسن را زده‌اید.');
                    break;
                case '2':
                    $this->sendMessage($chat['id'], 'شما دوز دوم واکسن را زده‌اید');
                    break;
                case '3':
                    $this->sendMessage($chat['id'], 'شما دوز سوم واکسن را زده‌اید.');
                    break;
                case '4':
                    $this->sendMessage($chat['id'], 'شما مایل به پاسخ گویی نمی‌باشید.');
                    break;
            }
                $this->askQuestion(14, $chat['id']);
                break;
            case '14':

                $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                switch ($explodedResult[0]) {
                    case '0':
                        $robotUser->respiratory_disease = 0;
                        $robotUser->question_counter = '16';
                        $robotUser->save();
                        $this->sendMessage($chat['id'], 'شما به بیماری تنفسی مبتلا نیستید.');
                        $this->askQuestion(16, $chat['id']);
                        break;
                    case '1':
                        $robotUser->respiratory_disease = 1;
                        $robotUser->question_counter = '15';
                        $robotUser->save();
                        $this->sendMessage($chat['id'], 'شما به بیماری تنفسی مبتلا هستید.');
                        $this->askQuestion(15, $chat['id']);
                        break;
                    case '2':
                        $robotUser->respiratory_disease = 1;
                        $robotUser->respiratory_name = 'آسم';
                        $robotUser->question_counter = '16';
                        $robotUser->save();
                        $this->sendMessage($chat['id'], 'شما به بیماری آسم مبتلا هستید.');
                        $this->askQuestion(16, $chat['id']);
                        break;
                    case '3':
                        $robotUser->respiratory_disease = 1;
                        $robotUser->respiratory_name = 'آنفولانزا';
                        $robotUser->question_counter = '16';
                        $robotUser->save();
                        $this->sendMessage($chat['id'], 'شما به بیماری آنفولانزا مبتلا هستید.');
                        $this->askQuestion(16, $chat['id']);
                        break;
                    case '4':
                        $robotUser->respiratory_disease = 1;
                        $robotUser->respiratory_name = 'آلرژی';
                        $robotUser->question_counter = '16';
                        $robotUser->save();
                        $this->sendMessage($chat['id'], 'شما به بیماری آلرژی مبتلا هستید.');
                        $this->askQuestion(16, $chat['id']);
                        break;
                    case '5':
                        $robotUser->respiratory_disease = 1;
                        $robotUser->respiratory_name = 'برونشیت';
                        $robotUser->question_counter = '16';
                        $robotUser->save();
                        $this->sendMessage($chat['id'], 'شما به بیماری برونشیت مبتلا هستید.');
                        $this->askQuestion(16, $chat['id']);
                        break;
                    case '6':
                        $robotUser->respiratory_disease = 1;
                        $robotUser->respiratory_name = 'سرماخوردگی';
                        $robotUser->question_counter = '16';
                        $robotUser->save();
                        $this->sendMessage($chat['id'], 'شما به بیماری سرماخوردگی مبتلا هستید.');
                        $this->askQuestion(16, $chat['id']);
                        break;
                    default:
                        $this->sendMessage($chat['id'], 'مقدار وارد شده نامعتبر است.');
                        break;
                }
                break;
            case '25':
                $robotUser = RobotUser::where('chat_id', '=', $chat['id'])->first();
                $robotUser->agree = $explodedResult[0];
                $robotUser->question_counter = '26';
                $robotUser->save();
                if($explodedResult[0]){
                    $this->sendMessage($chat['id'],'لطفا شماره تماس یا آیدی تلگرام خود را وارد نمایید.');
                }else{
                    $this->sendMessage($chat['id'],'با آروزی سلامتی شما. خدانگهدار');
                }
                break;
            default:
                $this->sendMessage($chat['id'], 'سوالات شما به پایان رسید.');
                break;
        }
    }
}
