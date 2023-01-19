<?php

namespace app\Helpers;


use app\Models\mAppointment;
use app\Models\mReminderHistory;
use app\Models\mWhatsApp;

class Reminder
{

    public static function consult()
    {
        $consult = mAppointment
            ::with([
                'patient'
            ])
            ->where([
                'need_type' => 'consult',
                'status' => 'prepare'
            ])
            ->get();

        foreach ($consult as $row) {
            $day = Main::day_format_id(date('l', strtotime($row->appointment_time)));
            $date = Main::format_date($row->appointment_time);
            $hours = Main::format_time_label($row->appointment_time);
            $phone_number = '+' . $row->patient->phone_1;

            $message = '
                Selamat Pagi/Siang/Sore

Salam sehat,
Kami ingin menginformasikan bahwa Bapak/Ibu
dengan pasien atas nama : ' . $row->patient->name . '.

Memiliki jadwal untuk melakukan *Konsultasi* 
di Klinik kami pada hari ' . $day . ', ' . $date . ' ' . $hours . '

Mohon segera melakukan konfirmasi ulang via Whatsapp, jika Bapak/Ibu 
ingin merubah jadwal  Konsultasi dengan klik Link Dibawah ini.

https://api.whatsapp.com/send?phone=6287777114800&text=Konfirmasi%20Konsultasi%20atas%20nama%20' . urlencode($row->patient->name . ' dengan jam ' . $day . ', ' . $date . ' ' . $hours) . '
                    
Hormat kami,
Rumah Sunat Bali
            ';


            $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
            $total_chat_quote = mWhatsApp::where('status', 'use')->value('total_chat_quote');

            if ($total_chat_send <= $total_chat_quote) {
                $response_raw = Main::whatsappSend($phone_number, $message);
                $response = json_decode($response_raw, TRUE);
                $data_insert = [
                    'id_appointment' => $row->id_appointment,
                    'status' => '',
                    'title' => 'Reminder Konsultasi',
                    'message' => $message,
                    'phone' => $phone_number,
                    'response' => $response_raw,
                    'success' => $response['success'],
                    'description' => $response['description'],
                    'result_code' => $response['result_code']
                ];

                mReminderHistory::insert($data_insert);
                mAppointment::where('id_appointment', $row->id_appointment)->update(['status' => 'send']);
                $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
                $total_chat_send_now = $total_chat_send + 1;
                mWhatsApp::where('status', 'use')->update(['total_chat_send' => $total_chat_send_now]);

            } else {
                break;
            }
        }


    }

    public static function action()
    {
        $action = mAppointment
            ::with([
                'patient'
            ])
            ->where([
                'need_type' => 'action',
                'status' => 'prepare'
            ])
            ->get();

        foreach ($action as $row) {
            $day = Main::day_format_id(date('l', strtotime($row->appointment_time)));
            $date = Main::format_date($row->appointment_time);
            $hours = Main::format_time_label($row->appointment_time);
            $phone_number = '+' . $row->patient->phone_1;

            $message = '
                Selamat Pagi/Siang/Sore

Salam sehat,
Kami ingin menginformasikan bahwa Bapak/Ibu
dengan pasien atas nama : ' . $row->patient->name . '.

Memiliki jadwal untuk melakukan *Tindakan* 
di Klinik kami pada hari ' . $day . ', ' . $date . ' ' . $hours . '

Mohon segera melakukan konfirmasi ulang via Whatsapp, jika Bapak/Ibu 
ingin merubah jadwal  Konsultasi dengan klik Link Dibawah ini.

https://api.whatsapp.com/send?phone=6287777114800&text=Konfirmasi%20Tindakan%20atas%20nama%20' . urlencode($row->patient->name . ' dengan jam ' . $day . ', ' . $date . ' ' . $hours) . '
                    
Hormat kami,
Rumah Sunat Bali
            ';

            $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
            $total_chat_quote = mWhatsApp::where('status', 'use')->value('total_chat_quote');

            if ($total_chat_send <= $total_chat_quote) {

                $response_raw = Main::whatsappSend($phone_number, $message);
                $response = json_decode($response_raw, TRUE);

                $data_insert = [
                    'id_appointment' => $row->id_appointment,
                    'status' => '',
                    'title' => 'Reminder Tindakan',
                    'message' => $message,
                    'phone' => $phone_number,
                    'response' => $response_raw,
                    'success' => $response['success'],
                    'description' => $response['description'],
                    'result_code' => $response['result_code']
                ];

                mReminderHistory::insert($data_insert);
                mAppointment::where('id_appointment', $row->id_appointment)->update(['status' => 'send']);
                $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
                $total_chat_send_now = $total_chat_send + 1;
                mWhatsApp::where('status', 'use')->update(['total_chat_send' => $total_chat_send_now]);
            } else {
                break;
            }
        }

    }

    public static function control()
    {
        $control = mAppointment
            ::with([
                'patient'
            ])
            ->where([
                'need_type' => 'control',
                'status' => 'prepare'
            ])
            ->get();

        foreach ($control as $row) {
            $day = Main::day_format_id(date('l', strtotime($row->appointment_time)));
            $date = Main::format_date($row->appointment_time);
            $hours = Main::format_time_label($row->appointment_time);
            $phone_number = '+' . $row->patient->phone_1;

            $message = '
                Selamat Pagi/Siang/Sore

Salam sehat,
Kami ingin menginformasikan bahwa Bapak/Ibu
dengan pasien atas nama : ' . $row->patient->name . '.

Memiliki jadwal untuk melakukan *Kontrol ke ' . $row->control_step . '* 
di Klinik kami pada hari ' . $day . ', ' . $date . ' ' . $hours . '

Mohon segera melakukan konfirmasi ulang via Whatsapp, jika Bapak/Ibu 
ingin merubah jadwal  Konsultasi dengan klik Link Dibawah ini.

https://api.whatsapp.com/send?phone=6287777114800&text=Konfirmasi%20Kontrol%20' . $row->control_step . '%20atas%20nama%20' . urlencode($row->patient->name . ' dengan jam ' . $day . ', ' . $date . ' ' . $hours) . '
                    
Hormat kami,
Rumah Sunat Bali
            ';


            $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
            $total_chat_quote = mWhatsApp::where('status', 'use')->value('total_chat_quote');

            if ($total_chat_send <= $total_chat_quote) {

                $response_raw = Main::whatsappSend($phone_number, $message);
                $response = json_decode($response_raw, TRUE);

                $data_insert = [
                    'id_appointment' => $row->id_appointment,
                    'status' => '',
                    'title' => 'Reminder Kontrol ' . $row->conntrol_step,
                    'message' => $message,
                    'phone' => $phone_number,
                    'response' => $response_raw,
                    'success' => $response['success'],
                    'description' => $response['description'],
                    'result_code' => $response['result_code']
                ];

                mReminderHistory::insert($data_insert);
                mAppointment::where('id_appointment', $row->id_appointment)->update(['status' => 'send']);
                $total_chat_send = mWhatsApp::where('status', 'use')->value('total_chat_send');
                $total_chat_send_now = $total_chat_send + 1;
                mWhatsApp::where('status', 'use')->update(['total_chat_send' => $total_chat_send_now]);
            }
        }
    }

}
