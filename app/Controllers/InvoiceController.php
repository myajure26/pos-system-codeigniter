<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use TCPDF;

class InvoiceController extends BaseController
{
    public function saleInvoice($id)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();                    // pretty self-explanatory
        $pdf->Write(1, 'Hello world');      // 1 is line height

        $pdf->Output('hello_world.pdf'); 
    }
}
