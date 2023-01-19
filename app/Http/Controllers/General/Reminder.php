<?php

namespace app\Http\Controllers\General;

use app\Mail\reminderSchedule;
use app\Models\mAction;
use app\Models\mAppointment;
use app\Models\mConsult;
use app\Models\mControl;
use app\Models\mPatient;
use app\Models\mPayment;
use app\Models\mReminderHistory;
use app\Models\mReminderSetting;
use app\Models\mWhatsApp;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;


use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use app\Models\mUser;


class Reminder extends Controller
{

    function run()
    {
        $this->consult();
        $this->action();
        $this->control();
        $this->followup_short();
        $this->followup_long();
        $this->birthday();
        $this->schedule();
    }

    function consult()
    {
        $reminder_setting_consult = mReminderSetting::where('variable', 'reminder_consult')->first();
        $hour_now = date('H');
        $hour_reminder = date('H', strtotime($reminder_setting_consult->target_hour));

        if ($reminder_setting_consult->status == 'active' && $hour_reminder == $hour_now) {

            $date_now = date('Y-m-d');
            $date_filter_raw = strtotime("+" . $reminder_setting_consult->target_day . " day", strtotime($date_now));
            $date_filter = date("Y-m-d", $date_filter_raw);
            $greating = Main::greating();

            $consult = mAppointment
                ::with([
                    'patient'
                ])
                ->whereDate('appointment_time', '=', $date_filter)
                ->where('need_type', 'consult')
                ->where('status', 'prepare')
                ->where('whatsapp_send', 'yes')
                ->get();

            foreach ($consult as $row) {
                $day = Main::day_format_id(date('l', strtotime($row->appointment_time)));
                $date = Main::format_date($row->appointment_time);
                $hours = Main::format_time_label($row->appointment_time);
                $phone_number = '+' . $row->patient->phone_1;

                $message =

$greating . ' 😊

Salam sehat,
Kami ingin menginformasikan bahwa Bapak/Ibu
dengan pasien atas nama : *' . $row->patient->name . '*

Memiliki jadwal untuk melakukan *Konsultasi* 
di Klinik kami pada hari ' . $day . ', ' . $date . ' ' . $hours . '

*Jika Bapak/Ibu ingin merubah jadwal Konsultasi,
Mohon segera melakukan konfirmasi ulang
Kepada admin kami ke nomer Whatsapp dibawah ini. 🔽* 
                    
Hormat kami, 🙏
Rumah Sunat Bali
087-777-11-4800
Jl. Tukad Batang Hari no 42, panjer Denpasar 
www.rumahsunatbali.com
            ';


                $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
                $total_chat_quote = mWhatsApp::where('status', 'use')->value('total_chat_quote');

                if ($total_chat_send < $total_chat_quote) {
                    $response_raw = Main::whatsappSend($phone_number, $message);
                    $response = json_decode($response_raw, TRUE);

                    $data_insert = [
                        'id_appointment' => $row->id_appointment,
                        'status' => 'success',
                        'title' => 'Reminder Konsultasi',
                        'type' => 'reminder_consult',
                        'message' => $message,
                        'phone' => $phone_number,
                        'response' => $response_raw,
                        'success' => $response['success'],
                        'description' => $response['description'],
                        'result_code' => $response['result_code']
                    ];

                    mReminderHistory::create($data_insert);
                    mAppointment::where('id_appointment', $row->id_appointment)->update(['status' => 'send']);
                    $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
                    $total_chat_send_now = $total_chat_send + 1;
                    mWhatsApp::where('status', 'use')->update(['total_chat_send' => $total_chat_send_now]);

                } else {
                    $this->report_whatsapp_quote_empty();
                    break;
                }
            }
        }


    }

    function action()
    {
        $reminder_setting_action = mReminderSetting::where('variable', 'reminder_action')->first();
        $hour_now = date('H');
        $hour_reminder = date('H', strtotime($reminder_setting_action->target_hour));

        if ($reminder_setting_action->status == 'active' && $hour_reminder == $hour_now) {

            $date_now = date('Y-m-d');
            $date_filter_raw = strtotime("+" . $reminder_setting_action->target_day . " day", strtotime($date_now));
            $date_filter = date("Y-m-d", $date_filter_raw);
            $greating = Main::greating();

            $action = mAppointment
                ::with([
                    'patient'
                ])
                ->whereDate('appointment_time', '=', $date_filter)
                ->where('need_type', 'action')
                ->where('status', 'prepare')
                ->where('whatsapp_send', 'yes')
                ->get();

            foreach ($action as $row) {
                $day = Main::day_format_id(date('l', strtotime($row->appointment_time)));
                $date = Main::format_date($row->appointment_time);
                $hours = Main::format_time_label($row->appointment_time);
                $phone_number = '+' . $row->patient->phone_1;

                $message =
$greating . ' 😊

Salam sehat,
Kami ingin menginformasikan bahwa Bapak/Ibu
dengan pasien atas nama : *' . $row->patient->name . '*

Memiliki jadwal untuk melakukan *Tindakan* 
di Klinik kami pada hari ' . $day . ', ' . $date . ' ' . $hours . '

*Jika Bapak/Ibu ingin merubah jadwal Tindakan,
Mohon segera melakukan konfirmasi ulang
kepada admin kami ke nomer Whatsapp dibawah ini. 🔽* 
                    
Hormat kami, 🙏
Rumah Sunat Bali
087-777-11-4800
Jl. Tukad Batang Hari no 42, panjer Denpasar 
www.rumahsunatbali.com
            ';


                $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
                $total_chat_quote = mWhatsApp::where('status', 'use')->value('total_chat_quote');

                if ($total_chat_send < $total_chat_quote) {
                    $response_raw = Main::whatsappSend($phone_number, $message);
                    $response = json_decode($response_raw, TRUE);

                    $data_insert = [
                        'id_appointment' => $row->id_appointment,
                        'status' => 'success',
                        'title' => 'Reminder Tindakan',
                        'type' => 'reminder_action',
                        'message' => $message,
                        'phone' => $phone_number,
                        'response' => $response_raw,
                        'success' => $response['success'],
                        'description' => $response['description'],
                        'result_code' => $response['result_code']
                    ];

                    mReminderHistory::create($data_insert);
                    mAppointment::where('id_appointment', $row->id_appointment)->update(['status' => 'send']);
                    $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
                    $total_chat_send_now = $total_chat_send + 1;
                    mWhatsApp::where('status', 'use')->update(['total_chat_send' => $total_chat_send_now]);

                } else {
                    $this->report_whatsapp_quote_empty();
                    break;
                }
            }
        }
    }

    function control()
    {
        $reminder_setting_control = mReminderSetting::where('variable', 'reminder_control')->first();
        $hour_now = date('H');
        $hour_reminder = date('H', strtotime($reminder_setting_control->target_hour));

        if ($reminder_setting_control->status == 'active' && $hour_reminder == $hour_now) {

            $date_now = date('Y-m-d');
            $date_filter_raw = strtotime("+" . $reminder_setting_control->target_day . " day", strtotime($date_now));
            $date_filter = date("Y-m-d", $date_filter_raw);
//            $user = Session::all();
            $user_nama = 'Komang';
            $greating = Main::greating();

            $control = mAppointment
                ::with([
                    'patient'
                ])
                ->whereDate('appointment_time', '=', $date_filter)
                ->where('need_type', 'control')
                ->where('status', 'prepare')
                ->where('whatsapp_send', 'yes')
                ->get();

            foreach ($control as $row) {
                $day = Main::day_format_id(date('l', strtotime($row->appointment_time)));
                $date = Main::format_date($row->appointment_time);
                $hours = Main::format_time_label($row->appointment_time);
                $phone_number = '+' . $row->patient->phone_1;

                $message =
$greating . ' 😊
                
Perkenalkan saya perawat ' . $user_nama . '

Salam sehat,
Kami ingin menginformasikan bahwa Bapak/Ibu
dengan pasien atas nama : *'.$row->patient->name.'*

Memiliki jadwal untuk melakukan *Kontrol #'.$row->control_step.'*
di Klinik kami pada hari *' . $day . '. Tanggal ' . $date . '. Jam ' . $hours . '*

*Jika Bapak/Ibu ingin merubah jadwal Kontrol,
Mohon segera melakukan konfirmasi ulang
kepada admin kami ke nomer Whatsapp dibawah ini. 🔽*  
                 
Hormat Kami 🙏
Rumah Sunat Bali
087-777-11-4800
Jl. Tukad Batang Hari no 42, panjer Denpasar 
www.rumahsunatbali.com
            ';


                $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
                $total_chat_quote = mWhatsApp::where('status', 'use')->value('total_chat_quote');

                if ($total_chat_send < $total_chat_quote) {
                    $response_raw = Main::whatsappSend($phone_number, $message);
                    $response = json_decode($response_raw, TRUE);

                    $data_insert = [
                        'id_appointment' => $row->id_appointment,
                        'status' => 'success',
                        'title' => 'Reminder Kontrol',
                        'type' => 'reminder_control',
                        'message' => $message,
                        'phone' => $phone_number,
                        'response' => $response_raw,
                        'success' => $response['success'],
                        'description' => $response['description'],
                        'result_code' => $response['result_code']
                    ];

                    mReminderHistory::create($data_insert);
                    mAppointment::where('id_appointment', $row->id_appointment)->update(['status' => 'send']);
                    $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
                    $total_chat_send_now = $total_chat_send + 1;
                    mWhatsApp::where('status', 'use')->update(['total_chat_send' => $total_chat_send_now]);

                } else {
                    $this->report_whatsapp_quote_empty();
                    break;
                }
            }
        }


    }

    function followup_short()
    {
        $reminder_setting_followup_short = mReminderSetting::where('variable', 'reminder_followup_short')->first();
        $hour_now = date('H');
        $hour_reminder = date('H', strtotime($reminder_setting_followup_short->target_hour));

        if ($reminder_setting_followup_short->status == 'active' && $hour_reminder == $hour_now) {

            $date_now = date('Y-m-d');
            $date_filter_raw = strtotime("-" . $reminder_setting_followup_short->target_day . " day", strtotime($date_now));
            $date_filter = date("Y-m-d", $date_filter_raw);
//            $user = Session::all();
            $user_nama = 'Komang';
            $greating = Main::greating();

            $action = mAction
                ::with([
                    'patient'
                ])
                ->whereDate('action_time', '=', $date_filter)
                ->where('status', 'done')
                ->where('whatsapp_status_short', 'not_yet')
                ->get();

            foreach ($action as $row) {
                $phone_number = '+' . $row->patient->phone_1;

                $message =
$greating . ' 😊
                
Perkenalkan saya perawat ' . $user_nama . '

Hari ini kami ingin melakukan Follow Up
kepada *' . $row->patient->name . '*
Setelah '.$reminder_setting_followup_short->target_day.' hari melakukan Sirkumsisi / Sunat / khitan.

Apakah ada keluhan dari ' . $row->patient->name . '? 
Apakah ada pendarahan aktif (netes)?
Mohon dilampirkan foto kondisi luka saat ini setelah Sirkumsisi / Khitan / Sunat.
Agar kami mengetahui perkembangan kondisi luka saat ini.

*Mohon segera melakukan konfirmasi kepada admin kami ke nomer Whatsapp dibawah ini. 🔽*

Hormat Kami 🙏
Rumah Sunat Bali
087-777-11-4800
Jl. Tukad Batang Hari no 42, panjer Denpasar 
www.rumahsunatbali.com
            ';


                $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
                $total_chat_quote = mWhatsApp::where('status', 'use')->value('total_chat_quote');

                if ($total_chat_send < $total_chat_quote) {
                    $response_raw = Main::whatsappSend($phone_number, $message);
                    $response = json_decode($response_raw, TRUE);

                    mAction
                        ::where('id_action', $row->id_action)
                        ->update(['whatsapp_status_short' => 'send']);

                    $data_insert = [
                        'id_action' => $row->id_action,
                        'status' => 'success',
                        'title' => 'Follow Up Terdekat setelah Tindakan',
                        'type' => 'reminder_followup_short',
                        'message' => $message,
                        'phone' => $phone_number,
                        'response' => $response_raw,
                        'success' => $response['success'],
                        'description' => $response['description'],
                        'result_code' => $response['result_code']
                    ];

                    mReminderHistory::create($data_insert);
                    $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
                    $total_chat_send_now = $total_chat_send + 1;
                    mWhatsApp::where('status', 'use')->update(['total_chat_send' => $total_chat_send_now]);

                } else {
                    $this->report_whatsapp_quote_empty();
                    break;
                }
            }
        }


    }

    function followup_long()
    {
        $reminder_setting_followup_long = mReminderSetting::where('variable', 'reminder_followup_long')->first();
        $hour_now = date('H');
        $hour_reminder = date('H', strtotime($reminder_setting_followup_long->target_hour));

        if ($reminder_setting_followup_long->status == 'active' && $hour_reminder == $hour_now) {

            $date_now = date('Y-m-d');
            $date_filter_raw = strtotime("-" . $reminder_setting_followup_long->target_day . " day", strtotime($date_now));
            $date_filter = date("Y-m-d", $date_filter_raw);
//            $user = Session::all();
            $user_nama = 'Komang';
            $greating = Main::greating();

            $action = mAction
                ::with([
                    'patient'
                ])
                ->whereDate('action_time', '=', $date_filter)
                ->where('status', 'done')
                ->where('whatsapp_status_long', 'not_yet')
                ->get();

            foreach ($action as $row) {
                $phone_number = '+' . $row->patient->phone_1;

                $message =
$greating . ' 😊
                
Perkenalkan saya perawat ' . $user_nama . '

Kami hari ini ingin menanyakan kondisi  
dengan pasien atas nama : *' . $row->patient->name . '*
setelah '.$reminder_setting_followup_long->target_day.' hari melakukan
Sirkumsisi / Khitan / Sunat di Rumah Sunat Bali.

Apakah ada keluhan untuk hari ini ?
Jika ada keluhan mohon disampaikan kepada kami dan
bisa dilampirkan foto kondisi luka setelah Sirkumsisi / Khitan / Sunat.
Agar kami mengetahui kondisi luka saat ini.

*Mohon segera melakukan konfirmasi kepada admin kami ke nomer Whatsapp dibawah ini. 🔽 *
                 

Hormat Kami 🙏
Rumah Sunat Bali
087-777-11-4800
Jl. Tukad Batang Hari no 42, panjer Denpasar 
www.rumahsunatbali.com
            ';

                $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
                $total_chat_quote = mWhatsApp::where('status', 'use')->value('total_chat_quote');

                if ($total_chat_send < $total_chat_quote) {
                    $response_raw = Main::whatsappSend($phone_number, $message);
                    $response = json_decode($response_raw, TRUE);

                    mAction
                        ::where('id_action', $row->id_action)
                        ->update(['whatsapp_status_long' => 'send']);

                    $data_insert = [
                        'id_action' => $row->id_action,
                        'status' => 'success',
                        'title' => 'Follow Up',
                        'type' => 'reminder_followup_long',
                        'message' => $message,
                        'phone' => $phone_number,
                        'response' => $response_raw,
                        'success' => $response['success'],
                        'description' => $response['description'],
                        'result_code' => $response['result_code']
                    ];

                    mReminderHistory::create($data_insert);
                    $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
                    $total_chat_send_now = $total_chat_send + 1;
                    mWhatsApp::where('status', 'use')->update(['total_chat_send' => $total_chat_send_now]);

                } else {
                    $this->report_whatsapp_quote_empty();
                    break;
                }
            }
        }
    }

    function birthday()
    {
        $reminder_setting_birthday = mReminderSetting::where('variable', 'reminder_birthday')->first();
        $hour_now = date('H');
        $hour_reminder = date('H', strtotime($reminder_setting_birthday->target_hour));

        if ($reminder_setting_birthday->status == 'active' && $hour_reminder == $hour_now) {

            $date_now = date('Y-m-d');
            $date_filter_raw = strtotime("+" . $reminder_setting_birthday->target_day . " day", strtotime($date_now));
            $year_filter = date("Y", $date_filter_raw);
            $month_filter = date("m", $date_filter_raw);
            $day_filter = date("d", $date_filter_raw);

            $birthday = mPatient
                ::whereDay('birthday', '=', $day_filter)
                ->whereMonth('birthday', '=', $month_filter)
                ->get();

            foreach ($birthday as $row) {
                $phone_number = '+' . $row->phone_1;
                $age = Main::age($row->birthday);

                $message = '
Selamat Ulang Tahun *' . $row->name . '* 🎊🎉😄,
Selamat atas hari Ulang Tahun ke '.$age.' dan
semoga di hari ini *' . $row->name . '* merasa bahagia dengan pelayanan kami dan
terus mempercayakan kami untuk selalu bersama. 

Semoga di hari ulang tahun ini ' . $row->name . ' senantiasa diberikan Kesehatan.   
                                
Terimakasih dan Salam sehat dari kami 🙏

Rumah Sunat Bali
087-777-11-4800
Jl. Tukad Batang Hari no 42, panjer Denpasar 
www.rumahsunatbali.com';
                $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
                $total_chat_quote = mWhatsApp::where('status', 'use')->value('total_chat_quote');

                /**
                 * Digunakan untuk mengecheck, apakah sudah mengirim ucapan ulang tahun di hari ini atau tidak,
                 * jika tidak, maka akan dikirimkan,
                 * jika ada, maka tidak dikirimkan
                 */
                $check_reminder_birthday_exist = mReminderHistory
                    ::where(array(
                        'type'=>'reminder_birthday',
                        'id_patient'=>$row->id_patient
                    ))
                    ->whereDate('created_at', $year_filter.'-'.$month_filter.'-'.$day_filter)
                    ->count();

                if ($total_chat_send < $total_chat_quote && $check_reminder_birthday_exist == 0) {

                    $response_raw = Main::whatsappSend($phone_number, $message);
                    $response = json_decode($response_raw, TRUE);

                    $data_insert = [
                        'id_patient' => $row->id_patient,
                        'status' => 'success',
                        'title' => 'Reminder Ulang Tahun Pasien',
                        'type' => 'reminder_birthday',
                        'message' => $message,
                        'phone' => $phone_number,
                        'response' => $response_raw,
                        'success' => $response['success'],
                        'description' => $response['description'],
                        'result_code' => $response['result_code']
                    ];

                    mReminderHistory::create($data_insert);
                    $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
                    $total_chat_send_now = $total_chat_send + 1;
                    mWhatsApp::where('status', 'use')->update(['total_chat_send' => $total_chat_send_now]);

                } else if($total_chat_send > $total_chat_quote) {
                    $this->report_whatsapp_quote_empty();
                    break;
                }
            }
        }

    }

    function schedule()
    {
        $reminder_setting_schedule = mReminderSetting::where('variable', 'reminder_schedule')->first();
        $hour_now = date('H');
        //echo ',';
        $hour_reminder = date('H', strtotime($reminder_setting_schedule->target_hour));
        //echo ',';
        $date_now = date('Y-m-d');

        $check = mReminderHistory::where('type', 'reminder_schedule')->whereDate('created_at', $date_now)->count();

//        echo 'reminder_setting_schedule_status : '.$reminder_setting_schedule->status;
//        echo '<br />';
//        echo 'hour_reminder : '.$hour_reminder;
//        echo '<br />';
//        echo 'hour_now : '.$hour_now;
//        echo '<br />';
//        echo 'check : '.$check;

        if ($reminder_setting_schedule->status == 'active' && $hour_reminder == $hour_now && $check == 0) {
//            echo '1';
            Mail::to("sunatuntuksemua@gmail.com")->send(new reminderSchedule());
//            Mail::to("mahendra.adi.wardana@gmail.com")->send(new reminderSchedule());

            $data_reminder_history = [
                'status' => 'success',
                'title' => 'Reminder Jadwal',
                'type' => 'reminder_schedule',
                'message' => 'Check Inbox Email sunatuntuksemua@gmail.com',
                'email' => 'sunatuntuksemua@gmail.com'
            ];

            mReminderHistory::create($data_reminder_history);

        } else {
//            echo '2';
        }


    }

    function schedule_2()
    {
        $reminder_setting_schedule = mReminderSetting::where('variable', 'reminder_schedule')->first();
        $hour_now = date('H');
        //echo ',';
        $hour_reminder = date('H', strtotime($reminder_setting_schedule->target_hour));
        //echo ',';
        $date_now = date('Y-m-d');

        $check = mReminderHistory::where('type', 'reminder_schedule')->whereDate('created_at', $date_now)->count();

        echo 'reminder_setting_schedule_status : '.$reminder_setting_schedule->status;
        echo '<br />';
        echo 'hour_reminder : '.$hour_reminder;
        echo '<br />';
        echo 'hour_now : '.$hour_now;
        echo '<br />';
        echo 'check : '.$check;

//        if ($reminder_setting_schedule->status == 'active' && $hour_reminder == $hour_now && $check == 0) {
//            echo '1';
//            Mail::to("sunatuntuksemua@gmail.com")->send(new reminderSchedule());
            Mail::to("mahendra.adi.wardana@gmail.com")->send(new reminderSchedule());

//            $data_reminder_history = [
//                'status' => 'success',
//                'title' => 'Reminder Jadwal',
//                'type' => 'reminder_schedule',
//                'message' => 'Check Inbox Email sunatuntuksemua@gmail.com',
//                'email' => 'sunatuntuksemua@gmail.com'
//            ];
//
//            mReminderHistory::create($data_reminder_history);

//        } else {
//            //echo '2';
//        }


    }

    function report_whatsapp_quote_empty()
    {
        $greating = Main::greating();
        $message_client = $greating . ' 😄
Kepada Rumah Sunat Bali, Kuota WhatsApp Anda sudah Habis.
Silahkan Hubungi Tim IT dengan klik Link dibawah untuk mengisi Kuota WhatsApp.

https://api.whatsapp.com/send?phone=6281934364063&text=' . urlencode('Kuota WhatsApp Rumah Sunat Bali Habis') . '

Salam Saya,
Mahendra Wardana.
081 934 364 063
www.mahendrawardana.com';

        $message_admin = $greating . ' 😄
Client Rumah Sunat Bali, Kuota WhatsAppnya sudah Habis.
Silahkan Hubungi Rumah Sunat Bali untuk segera mengisi kuota WhatsAppnya.

https://api.whatsapp.com/send?phone=6287777114800&text=' . urlencode($greating . ', Kuota WhatsAppnya sudah habis, mohon untuk segera mengisi kuota WhatsAppnya.') . '';

        Main::whatsappSend('+6287777114800', $message_client);
        Main::whatsappSend('+6281934364063', $message_admin);

    }

    function test_cron_job()
    {
        $data = [
            'id_appointmemnt' => '1',
            'status' => 'success',
            'title' => 'test title',
            'message' => 'test message'
        ];

        mReminderHistory::create($data);
    }


}
