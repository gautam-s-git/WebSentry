<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\MonitoringProcessLog;

class MonitoringProcessNotification extends Notification
{
    use Queueable;

    public $monitoringProcessLog;

    /**
     * Create a new notification instance.
     */
    public function __construct(MonitoringProcessLog $monitoringProcessLog)
    {
        $this->monitoringProcessLog = $monitoringProcessLog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $log = $this->monitoringProcessLog;
        $website = $log->website;

        return (new MailMessage)
            ->subject('🔴 Website Down Alert - ' . $website->name)
            ->error()
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your website **' . $website->url . '** is currently DOWN.')
            ->line('**URL:** ' . $website->url)
            ->line('**Status Code:** ' . $log->status_code)
            ->line('Please check your website immediately.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'website_id' => $this->monitoringProcessLog->website_id,
            'status' => $this->monitoringProcessLog->status,
            'status_code' => $this->monitoringProcessLog->status_code,
            'error' => $this->monitoringProcessLog->failure_error,
        ];
    }
}
