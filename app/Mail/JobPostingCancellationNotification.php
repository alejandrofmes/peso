<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobPostingCancellationNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $jobApplicants;
    public function __construct($jobApplicants)
    {
        $this->jobApplicants = $jobApplicants;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Application Has Been Canceled',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.job_posting_cancellation_notification',
            with: [
                'applicantName' => $this->jobApplicants->employee->fname . ' ' . $this->jobApplicants->employee->lname,
                'jobTitle' => $this->jobApplicants->job_posting->job_Title,
                'closingDate' => $this->jobApplicants->job_posting->job_Duration->format('F j, Y'),
                'PESO' => $this->jobApplicants->job_posting->peso->municipality->municipality_Name,
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
