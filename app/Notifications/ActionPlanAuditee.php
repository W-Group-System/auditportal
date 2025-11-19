<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActionPlanAuditee extends Notification
{
    use Queueable;

    private $action_plan;
    private $attachments;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($action_plan, $attachments = [])
    {
        $this->action_plan = $action_plan;
        $this->attachments = $attachments;
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
        $mail = (new MailMessage)
            ->subject('New Action Plan Assigned')
            ->greeting('Hello ' . $notifiable->name)
            ->line('A new action plan has been assigned to you.')
            ->line('Findings: ' . $this->action_plan->findings)
            ->line('Action Plan: ' . $this->action_plan->action_plan)
            ->line('Target Date: ' . $this->action_plan->target_date)
            ->line('Please see the attached files.')
            ->line('Thank you.')
            ->action('View Action Plan', url('/action-plan/'));

        foreach ($this->attachments as $file) {
            $filePath = public_path($file);

            if (file_exists($filePath)) {
                $mail->attach($filePath, [
                    'as' => basename($filePath),
                    'mime' => mime_content_type($filePath)
                ]);
            }
        }

        return $mail;
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
