<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProgramCompleteNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $employee;
    public $trainingPosting;

    public function __construct($employee, $trainingPosting)
    {
        $this->employee = $employee;
        $this->trainingPosting = $trainingPosting;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Training Program Has Been Completed!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.program_complete_notification',
            with: [
                'employeeName' => $this->employee->fname . ' ' . $this->employee->lname,
                'programTitle' => $this->trainingPosting->program_Title,
                'providerName' => $this->trainingPosting->program_Host,
                'programLocation' => $this->trainingPosting->program_Location,
                'PESO' => $this->trainingPosting->peso->municipality->municipality_Name,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
