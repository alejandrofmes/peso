<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobpostCancelledNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $jobPosting;

    public function __construct($jobPosting)
    {
        $this->jobPosting = $jobPosting;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Jobpost Cancelled Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.jobpost_cancelled_notification',
            with: [
                'employerName' => $this->jobPosting->company->business_Name,
                'jobTitle' => $this->jobPosting->job_Title,
                'applicationStatus' => $this->jobPosting->job_Status,
                'pesoRemarks' => $this->jobPosting->peso_Remarks,
                'PESO' => $this->jobPosting->peso->municipality->municipality_Name,
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
