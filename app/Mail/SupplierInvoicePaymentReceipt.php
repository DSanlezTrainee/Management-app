<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupplierInvoicePaymentReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly object $invoice,
        public readonly object $supplier,
        public readonly string $paymentReceiptPath
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): \Illuminate\Mail\Mailables\Envelope
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Payment Receipt - Invoice #' . $this->invoice->number,
            
        );
    }

    /**
     * Get the content definition for the message.
     */
    public function content(): \Illuminate\Mail\Mailables\Content
    {
        return new \Illuminate\Mail\Mailables\Content(
            markdown: 'emails.supplier_invoice_payment_receipt',
            with: [
                'invoice' => $this->invoice,
                'supplier' => $this->supplier,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [
            \Illuminate\Mail\Mailables\Attachment::fromStorageDisk('public', $this->paymentReceiptPath),
        ];
    }
}
