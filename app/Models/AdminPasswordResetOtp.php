<?php
// app/Mail/AdminPasswordResetOtp.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminPasswordResetOtp extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * SECURITY: OTP is passed in as a constructor argument, not stored as a
     * public property on the class, to prevent accidental serialisation/logging
     * of the raw OTP value. It is stored protected.
     */
    public function __construct(protected string $otp) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Admin Password Reset OTP');
    }

    public function content(): Content
    {
        return new Content(
            text: 'emails.admin.password-reset-otp-text',
            with: [
                // Pass OTP to the view. The view should display it plainly.
                // NEVER log $this->otp anywhere in this class.
                'otp'        => $this->otp,
                'expiryMins' => 5,
            ]
        );
    }
}