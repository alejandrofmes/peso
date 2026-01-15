<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PESOBranchNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    protected $user;
    protected $password;
    protected $verificationUrl;

    public function __construct($user, $password, $verificationUrl)
    {
        $this->password = $password;
        $this->user = $user;
        $this->verificationUrl = $verificationUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to PESOCareers',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.peso_branch_notification',
            with: [
                'employeeName' => $this->user->peso_accounts->peso_accounts_Fname . ' ' . $this->user->peso_accounts->peso_accounts_Lname,
                'email' => $this->user->email,
                'password' => $this->password,
                'verificationUrl' => $this->verificationUrl,
                'municipality' => $this->user->peso_accounts->peso->municipality->municipality_Name,
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
