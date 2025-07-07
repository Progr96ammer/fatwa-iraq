<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class FatwaAnswered extends Notification implements ShouldQueue
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
            ->subject('تمت الإجابة على سؤالك')
            ->line('لقد تمت الإجابة على سؤالك من قبل الشيخ: ' . $this->fatwa->sheikh->name)
            ->action('عرض الفتوى', url('/fatwas/' . $this->fatwa->id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'fatwa_answered',
            'message' => 'تمت الإجابة على سؤالك من قبل الشيخ ' . $this->fatwa->sheikh->name,
            'url' => '/fatwas/' . $this->fatwa->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'type' => 'fatwa_answered',
            'message' => 'تمت الإجابة على سؤالك من قبل الشيخ ' . $this->fatwa->sheikh->name,
            'url' => '/fatwas/' . $this->fatwa->id,
        ]);
    }
}
