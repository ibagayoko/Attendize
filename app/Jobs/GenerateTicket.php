<?php

namespace App\Jobs;

use App\Models\Order;
use Barryvdh\DomPDF\Facade as PDF;
use App\Generators\TicketGenerator;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateTicket extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $reference;
    protected $order_reference;
    protected $attendee_reference_index;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reference)
    {
        Log::info('Generating ticket: #'.$reference);
        $this->reference = $reference;
        $this->order_reference = explode('-', $reference)[0];
        if (strpos($reference, '-')) {
            $this->attendee_reference_index = explode('-', $reference)[1];
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // Generate file name
        $pdf_file = TicketGenerator::generateFileName($this->reference);
        // Check if file exist before create it again
        if (file_exists($pdf_file['fullpath'])) {
            Log::info('Use ticket from cache: '.$pdf_file['fullpath']);

            return;
        }

        $order = Order::where('order_reference', $this->order_reference)->first();
        Log::info($order);
        $event = $order->event;

        $query = $order->attendees();
        if ($this->isAttendeeTicket()) {
            $query = $query->where('reference_index', '=', $this->attendee_reference_index);
        }
        $order->attendees = $query->get();

        // generating
        $tk_generator = new TicketGenerator($order);
        $tickets = $tk_generator->createTickets();

        $data = [
            'event'     => $event,
            'tickets'    => $tickets,
        ];
        try {
            PDF::loadView('Public.ViewEvent.Partials.PDFTicket', $data)->save($pdf_file['fullpath']);
            Log::info('Ticket generated!');
        } catch (\Exception $e) {
            Log::error('Error generating ticket. This can be due to permissions on vendor/nitmedia/wkhtml2pdf/src/Nitmedia/Wkhtml2pdf/lib. This folder requires write and execute permissions for the web user');
            Log::error('Error message. '.$e->getMessage());
            Log::error('Error stack trace'.$e->getTraceAsString());
            $this->fail($e);
        }
    }

    private function isAttendeeTicket()
    {
        return $this->attendee_reference_index != null;
    }
}
