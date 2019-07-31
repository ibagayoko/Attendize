<?php

namespace App\Jobs;

use App\Models\Order;
use App\Mailers\OrderMailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SendOrderTickets extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

    public $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(OrderMailer $orderMailer)
    {
        $this->dispatchNow(new GenerateTicket($this->order->order_reference));
        $orderMailer->sendOrderTickets($this->order);
    }
}
