<?php

namespace App\Jobs;

use App\Models\Attendee;
use App\Mailers\AttendeeMailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SendAttendeeInvite extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

    public $attendee;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Attendee $attendee)
    {
        $this->attendee = $attendee;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(AttendeeMailer $attendeeMailer)
    {
        $this->dispatchNow(new GenerateTicket($this->attendee->reference));
        $attendeeMailer->sendAttendeeInvite($this->attendee);
    }
}
