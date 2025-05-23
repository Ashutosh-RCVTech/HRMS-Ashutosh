<?php

namespace Modules\Recruitment\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Recruitment\Models\CandidateUser;

class NewCandidateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct(CandidateUser $candidate, $password)
    {
        $this->candidate = $candidate;
        $this->password = $password;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Our Recruitment Portal',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'recruitment::emails.new-candidate',
            with: [
                'candidate' => $this->candidate,
                'password' => $this->password,
            ],
        );
    }
} 