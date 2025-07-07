<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class SheikhAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    public $fatwa;

    public function __construct($fatwa)
    {
        $this->fatwa = $fatwa;
    }

    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('تم تعيينك للإجابة على فتوى')
            ->line('لقد تم تعيينك للإجابة على سؤال جديد من المستخدم: ' . $this->fatwa->user->name)
            ->action('عرض الفتوى', url('/fatwas/' . $this->fatwa->id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'assigned_fatwa',
            'message' => 'تم تعيينك للإجابة على فتوى جديدة.',
            'url' => '/fatwas/' . $this->fatwa->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'type' => 'assigned_fatwa',
            'message' => 'تم تعيينك للإجابة على فتوى جديدة.',
            'url' => '/fatwas/' . $this->fatwa->id,
        ]);
    }
}
