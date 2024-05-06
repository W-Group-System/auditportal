<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;
class ActionPlanNotif extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $table;
    public function __construct($table)
    {
        //
        $this->table = $table;
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
        ->greeting('Greetings!')
        ->subject('Status of Action Plans')
        ->line('We would like to follow up on the current status of the agreed action plans as '.date('F Y'))
        ->line('Please submit proof for all completed action plans in order to close the findings.')
        ->line('If there are any action plans that will not be completed by the stated target date, please provide us with a new target date so that we can update our monitoring.')
        // ->line('ACR Code : '.$this->observation->code)
        ->line(new HtmlString($this->table))
        ->line('Please click the button provided for faster transaction')
        ->action('Action Plans', url('/action-plans'))
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
