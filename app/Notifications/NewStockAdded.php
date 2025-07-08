<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewStockAdded extends Notification implements ShouldQueue
{
    use Queueable;

    public $product;
    public $batch;

    public function __construct($product, $batch)
    {
        $this->product = $product;
        $this->batch = $batch;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Stock Added: ' . $this->product->name)
            ->greeting('Hello!')
            ->line('New stock has been added to your product: ' . $this->product->name)
            ->line('Batch No: ' . $this->batch->batch_no)
            ->line('Quantity Added: ' . $this->batch->quantity_added)
            ->line('Received At: ' . $this->batch->received_at->format('Y-m-d H:i'))
            ->action('View Inventory', url(route('retailer.inventory')))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'batch_no' => $this->batch->batch_no,
            'quantity_added' => $this->batch->quantity_added,
            'received_at' => $this->batch->received_at->format('Y-m-d H:i'),
        ];
    }
} 