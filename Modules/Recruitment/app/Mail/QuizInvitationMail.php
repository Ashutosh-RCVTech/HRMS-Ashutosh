<?php

namespace Modules\Recruitment\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Recruitment\Models\CandidateUser;

class QuizInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;
    public $placement;

    /**
     * Create a new message instance.
     */
    public function __construct($candidate,$placement)
    {
        $this->candidate = $candidate;
        $this->placement=$placement;



        // dd($this->placement, $this->candidate);

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Quiz Invitation: ' . $this->placement->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'recruitment::emails.quiz-invitation',
            with: [
                'candidate' => $this->candidate,
                'placement'=>$this->placement
            ],
        );
    }
} 