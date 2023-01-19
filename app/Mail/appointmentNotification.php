<?php

namespace app\Mail;

use app\Helpers\Main;
use app\Models\mAppointment;
use app\Models\mReminderSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class appointmentNotification extends Mailable
{
    use Queueable, SerializesModels;

    private $id_appointment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id_appointment)
    {
        $this->id_appointment = $id_appointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $appointment = mAppointment
            ::with([
                'patient',
                'patient.province',
                'patient.city',
                'patient.subdistrict',
            ])
            ->where('id_appointment', $this->id_appointment)
            ->first();

        $data = [
            'row' => $appointment,
        ];

        return $this
            ->subject('Registrasi Calon Pasien baru')
            ->from($address = 'no-reply@hubpasien.com', $name = 'Hub Pasien')
            ->view('appointment.appointment.appointmentNotificationEmail')
            ->with($data);
    }
}
