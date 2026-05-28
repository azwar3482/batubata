<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfContent;
    public $startDate;
    public $endDate;

    public function __construct($pdfContent, $startDate, $endDate)
    {
        $this->pdfContent = $pdfContent;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Laporan Platform KOMPASKARIR (' . $this->startDate . ' - ' . $this->endDate . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.report',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, 'Laporan-Platform-' . now()->format('Y-m-d') . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
