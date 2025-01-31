<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use PDF;
use Storage;

class GenerateTransportVoucherPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $type;
    public $page_title;
    /**
     * Create a new job instance.
     */
    public function __construct($data, $type, $page_title)
    {
        $this->data = $data;
        $this->type = $type;
        $this->page_title = $page_title;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Set up PDF options
        $options = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ]);

        $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext($options);

        // Load the view for generating the PDF
        $pdf = $pdf->loadView('voucher_view.transportVoucher.print_transport_voucher_monthly', [
            'data' => $this->data,
            'type' => $this->type,
            'pge_title' => $this->page_title
        ]);

        // Save the generated PDF to storage
        $filePath = 'pdfs/transport_voucher_' . time() . '.pdf';
        Storage::put($filePath, $pdf->output());

        // You can now store the path in the database or perform other operations
        // Example: save $filePath in the database or notify the user
    }
}
