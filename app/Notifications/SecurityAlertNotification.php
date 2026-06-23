<?php

namespace App\Notifications;

use App\Models\SecurityLog;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SecurityAlertNotification extends Notification
{
    use Queueable;

    protected SecurityLog $securityLog;

    public function __construct(SecurityLog $securityLog)
    {
        $this->securityLog = $securityLog;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $severityEmoji = match($this->securityLog->severity) {
            SecurityLog::SEVERITY_CRITICAL => '🔴',
            SecurityLog::SEVERITY_HIGH => '🟠',
            SecurityLog::SEVERITY_MEDIUM => '🟡',
            default => '🟢',
        };

        return (new MailMessage)
            ->subject("{$severityEmoji} Security Alert: {$this->securityLog->event_type}")
            ->greeting("Security Alert - {$this->securityLog->severity}")
            ->line("**Event:** {$this->securityLog->event_type}")
            ->line("**Description:** {$this->securityLog->description}")
            ->line("**IP Address:** {$this->securityLog->ip_address}")
            ->line("**Time:** {$this->securityLog->created_at}")
            ->action('View Security Dashboard', route('admin.security.index'))
            ->line('Please investigate this security event immediately.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'security_alert',
            'security_log_id' => $this->securityLog->id,
            'event_type' => $this->securityLog->event_type,
            'severity' => $this->securityLog->severity,
            'description' => $this->securityLog->description,
            'ip_address' => $this->securityLog->ip_address,
        ];
    }
}
