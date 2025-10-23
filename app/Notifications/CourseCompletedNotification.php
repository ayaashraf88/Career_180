<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Course;
use Illuminate\Contracts\Queue\ShouldQueue;

class CourseCompletedNotification extends Notification implements ShouldQueue

{
    use Queueable;

    public function __construct(public Course $course)
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Congratulations — Course Completed!')
                    ->greeting('Congratulations!')
                    ->line('You have completed the course: ' . $this->course->name)
                    ->action('View Certificate', url('/courses/' . $this->course->id))
                    ->line('Keep learning — check out more courses on Career 180!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'course_id' => $this->course->id,
            'course_name' => $this->course->name,
            'message' => 'You have completed the course: ' . $this->course->name,
        ];
    }
}
