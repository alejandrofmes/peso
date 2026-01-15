<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $employee;
    public $applicationData;

    public function __construct($employee, $applicationData)
    {
        $this->employee = $employee;
        $this->applicationData = $applicationData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Update on Your Job Application Status"
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.application_notification',
            with: [
                'employeeName' => $this->employee->fname . ' ' . $this->employee->lname,
                'applicationStatus' => $this->applicationData->applicant_Status,
                'companyRemarks' => $this->applicationData->company_Remarks,
                'jobTitle' => $this->applicationData->job_posting->job_Title,
                'companyName' => $this->applicationData->job_posting->company->business_Name,
                'PESO' => $this->applicationData->job_posting->peso->municipality->municipality_Name,
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
