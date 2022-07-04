<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PDFViewController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Welcome to laratutorials.com',
            'date' => date('m/d/Y')
        ];
          
        $pdf = PDF::loadView('myPDF', $data);
    
        return $pdf->download('laratutorials.pdf');
    }
}
