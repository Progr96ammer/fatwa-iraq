<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewFatwaSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public $fatwa)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

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

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('تم طرح فتوى جديدة')
            ->line('تم طرح فتوى جديدة من قبل المستخدم: ' . $this->fatwa->user->name)
            ->action('عرض الفتوى', url('/fatwas/' . $this->fatwa->id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'new_fatwa',
            'message' => 'تم طرح فتوى جديدة من ' . $this->fatwa->user->name,
            'url' => '/fatwas/' . $this->fatwa->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'type' => 'new_fatwa',
            'message' => 'تم طرح فتوى جديدة من ' . $this->fatwa->user->name,
            'url' => '/fatwas/' . $this->fatwa->id,
        ]);
    }
}
