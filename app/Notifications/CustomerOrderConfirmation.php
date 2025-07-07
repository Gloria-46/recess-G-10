<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerOrderConfirmation extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
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
        $mail = (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Order Confirmation - Uptrend Clothing')
            ->greeting('Hello ' . ($notifiable->name ?? 'Customer') . '!')
            ->line('Thank you for your order. Here are your order details:')
            ->line('Order Number: ' . $this->order->order_number)
            ->line('Shipping Address: ' . $this->order->shipping_address);

        // Add order items
        $mail->line('Items Ordered:');
        foreach ($this->order->items as $item) {
            $mail->line('- ' . $item->product->name .
                ' | Qty: ' . $item->quantity .
                ' | Size: ' . ($item->size ?? '-') .
                ' | Color: ' . ($item->color ?? '-') .
                ' | Price: UGX ' . number_format($item->price)
            );
        }

        $mail->line('Total Amount: UGX ' . number_format($this->order->total_amount));
        $mail->action('View Your Orders', url('/customer/orders'));
        $mail->line('Thank you for shopping with Uptrend Clothing!');

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
