<?php

namespace app\Mail;

use app\Helpers\Main;
use app\Models\mAppointment;
use app\Models\mReminderSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class reminderSchedule extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $reminder_setting_schedule = mReminderSetting::where('variable', 'reminder_schedule')->first();
        $date_now = date('Y-m-d');
        $date_filter_raw = strtotime("+" . $reminder_setting_schedule->target_day . " day", strtotime($date_now));
        $date_filter = date("Y-m-d", $date_filter_raw);
        $date_filter_title = Main::format_date_label($date_filter);
        $appointment = mAppointment
            ::select([
                'appointment.*',
                'patient.*',
                'appointment.status AS appointment_status',
                'action_method.title AS action_method_title'
            ])
            ->leftJoin('patient', 'patient.id_patient', '=', 'appointment.id_patient')
            ->leftJoin('control', 'control.id_control', '=', 'appointment.id_control')
            ->leftJoin('action', 'action.id_action', '=', 'control.id_action')
            ->leftJoin('action_method', 'action_method.id_action_method', '=', 'action.id_action_method')
            ->whereDate('appointment_time', $date_filter)
            ->whereIn('appointment.status', ['prepare', 'send'])
            ->orderBy('appointment_time', 'ASC')
            ->get();

        $data = [
            'appointment' => $appointment,
            'date_filter' => $date_filter_title
        ];

        return $this
            ->subject('Jadwal '.$date_filter_title.' - Rumah Sunat Bali')
            ->from($address = 'no-reply@hubpasien.com', $name = 'Hub Pasien')
            ->view('reminderSchedule.reminderSchedule')
            ->with($data);
    }
}
