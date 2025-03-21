<?php

namespace App\Mailers;

use Carbon\Carbon;
use App\Models\Message;
use App\Models\Attendee;
use App\Generators\TicketGenerator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AttendeeMailer extends Mailer
{
    public function sendAttendeeTicket($attendee)
    {
        Log::info('Sending ticket to: '.$attendee->email);

        $data = [
            'attendee' => $attendee,
        ];

        Mail::send('Mailers.TicketMailer.SendAttendeeTicket', $data, function ($message) use ($attendee) {
            $pdf_file = TicketGenerator::generateFileName($attendee->reference);
            $message->to($attendee->email);
            $message->subject(trans('Email.your_ticket_for_event', ['event' => $attendee->order->event->title]));

            $message->attach($pdf_file['fullpath']);
        });
    }

    /**
     * Sends the attendees a message.
     *
     * @param Message $message_object
     */
    public function sendMessageToAttendees(Message $message_object)
    {
        $event = $message_object->event;

        $attendees = ($message_object->recipients == 'all')
            ? $event->attendees // all attendees
            : Attendee::where('ticket_id', '=', $message_object->recipients)->where('account_id', '=',
                $message_object->account_id)->get();

        foreach ($attendees as $attendee) {
            if ($attendee->is_cancelled) {
                continue;
            }

            $data = [
                'attendee'        => $attendee,
                'event'           => $event,
                'message_content' => $message_object->message,
                'subject'         => $message_object->subject,
                'email_logo'      => $attendee->event->organiser->full_logo_path,
            ];

            Mail::send('Emails.messageReceived', $data, function ($message) use ($attendee, $data) {
                $message->to($attendee->email, $attendee->full_name)
                    ->from(config('attendize.outgoing_email_noreply'), $attendee->event->organiser->name)
                    ->replyTo($attendee->event->organiser->email, $attendee->event->organiser->name)
                    ->subject($data['subject']);
            });
        }

        $message_object->is_sent = 1;
        $message_object->sent_at = Carbon::now();
        $message_object->save();
    }

    public function SendAttendeeInvite($attendee)
    {
        Log::info('Sending invite to: '.$attendee->email);

        $data = [
            'attendee' => $attendee,
        ];

        Mail::send('Mailers.TicketMailer.SendAttendeeInvite', $data, function ($message) use ($attendee) {
            $pdf_file = TicketGenerator::generateFileName($attendee->reference);
            $message->to($attendee->email);
            $message->subject(trans('Email.your_ticket_for_event', ['event' => $attendee->order->event->title]));

            $message->attach($pdf_file['fullpath']);
        });
    }
}
