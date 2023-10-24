<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ACRApproved extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $observation;
    public function __construct($observation)
    {
        //
        $this->observation = $observation;

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
        ->line('Kindly fill out Explanation, Cause, Agreed action plan (Corrective and Correction), Responsible party, and Target date.')
        ->line('ACR Code : '.$this->observation->code)
        ->line('Please click the button provided for faster transaction')
        ->action('ACR Approval', url('/for-explanation'))
        ->line('An Explanation must be submitted within twenty-four (24) hours from the date of issuance. Failure to submit within the said period shall be deemed a waiver of your opportunity to explain and leave the auditors with no recourse but to submit our report based on available documents.')
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
