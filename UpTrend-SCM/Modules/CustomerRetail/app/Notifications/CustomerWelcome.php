<?php

namespace Modules\CustomerRetail\App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerWelcome extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        // You can pass user data if needed
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to Uptrend Clothing!')
            ->greeting('Hello ' . ($notifiable->name ?? 'Customer') . '!')
            ->line('Thank you for signing up at Uptrend Clothing. Your account has been created successfully!')
            ->line('You can now browse our latest collections, add items to your cart, and place orders with ease.')
            ->action('Visit Our Store', url('/customer/products'))
            ->line('If you did not create this account, please contact our support team.');
    }
} 