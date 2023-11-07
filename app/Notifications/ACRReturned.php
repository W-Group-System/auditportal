<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ACRReturned extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $observation;
    protected $remarks;
    public function __construct($observation,$remarks)
    {
        //
        $this->observation = $observation;
        $this->remarks = $remarks;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->greeting('Good Day!')
        ->subject($this->observation->code)
        ->line('Your new ACR has been returned. Kindly edit and resubmit it.')
        ->line('ACR Code : '.$this->observation->code)
        ->line('Remarks : '.$this->remarks)
        ->line('Please click the button provided for faster transaction')
        ->action('ACR', url('/edit-observation/'.$this->observation->id))
        ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
