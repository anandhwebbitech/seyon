<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use PDF;
use Mpdf\Mpdf;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        try {
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_top' => 10,
                'margin_bottom' => 10,
            ]);

            $html = view('frontend.product.invoice', ['data' => $this->data])->render();
            $mpdf->WriteHTML($html);
            $pdf = $mpdf->Output('', 'S');

            return $this->subject('Invoice - ' . $this->data['invoiceNumber'])
                        ->view('frontend.product.invoice')
                        ->with(['data' => $this->data])
                        ->attachData($pdf, 'invoice.pdf', [
                            'mime' => 'application/pdf',
                        ]);
        } catch (\Exception $e) {
            \Log::error('InvoiceMail build failed: ' . $e->getMessage());
            throw $e;
        }
    }
}