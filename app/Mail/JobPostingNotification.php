<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobPostingNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $employee;
    public $jobPosting;

    public function __construct($employee, $jobPosting)
    {
        $this->employee = $employee;
        $this->jobPosting = $jobPosting;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Don’t Miss Out: New Job Posting in Your Area of Interest',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.job_posting_notification',
            with: [
                'employeeName' => $this->employee->fname . ' ' . $this->employee->lname,
                'jobTitle' => $this->jobPosting->job_Title,
                'companyName' => $this->jobPosting->company->business_Name,
                'jobLocation' => $this->jobPosting->job_Address . ', ' . $this->jobPosting->barangay->barangay_Name . ', ' . $this->jobPosting->barangay->municipality->municipality_Name . ', ' . $this->jobPosting->barangay->municipality->province->province_Name,
                'jobPostingUrl' => route('jobpost.show', ['id' => $this->jobPosting->job_id]),
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
