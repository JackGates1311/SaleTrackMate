<?php

namespace App\Helper;

use Dompdf\Dompdf;

class PdfGenerator
{
    public function generatePdf($data): void
    {
        $html = view('invoice', $data)->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4');
        $pdf->render();
        $pdf->stream('invoice.pdf');
    }

}
