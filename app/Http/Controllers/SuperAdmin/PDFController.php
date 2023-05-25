<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PDF;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $data = [
            'title' => 'Welcome to Braincave.com',
            'author' => "John Doe"
        ];
          
        $pdf = PDF::loadView('superadmin.sales.invoice-modal.invoice-pdf', $data);
    
        return $pdf->download('onlinewebtutorblog.pdf');
    }
}

?>