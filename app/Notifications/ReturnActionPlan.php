<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReturnActionPlan extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $remarks;
    protected $action_plan;
    public function __construct($remarks,$action_plan)
    {
        //
        $this->remarks = $remarks;
        $this->action_plan = $action_plan;

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
        ->subject('Your action plan has been returned.')
        ->line('Action Plan # : AP-'.$this->action_plan)
        ->line('Remarks : '.$this->remarks)
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
