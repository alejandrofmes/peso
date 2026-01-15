<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmTraining extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

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
            subject: 'Confirmation of Your Slot for ' . $this->trainingPosting->program_Title . '!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.confirm_training_notification',
            with: [
                'employeeName' => $this->employee->fname . ' ' . $this->employee->lname,
                'programTitle' => $this->trainingPosting->program_Title,
                'providerName' => $this->trainingPosting->program_Host,
                'trainingUrl' => route('training.show', ['id' => $this->trainingPosting->program_id]),
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
