<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewApplicantNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $applicantInfo;
    public function __construct($applicantInfo)
    {
        $this->applicantInfo = $applicantInfo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You Have a New Applicant: Check Out Their Details',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.new_applicant_notification',
            with: [
                'employerName' => $this->applicantInfo->job_posting->company->business_Name,
                'jobTitle' => $this->applicantInfo->job_posting->job_Title,
                'applicantName' => $this->applicantInfo->employee->fname . ' ' . $this->applicantInfo->employee->lname,
                'applicantEmail' => $this->applicantInfo->employee->user->email,
                'applicantPhone' => $this->applicantInfo->employee->pnumber,
                'PESO' => $this->applicantInfo->job_posting->peso->municipality->municipality_Name,
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
