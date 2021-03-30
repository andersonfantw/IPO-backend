<?php
namespace App\Traits;

use PDF;

trait Report
{
    use ImageToBase64;

    public function chinayss()
    {
        $logo = $this->imagePathToBase64(public_path('images/logo.png'));
        $pdf = PDF::loadView('pdf.Chinayss', ['logo' => $logo]);
        return $pdf->stream('download.pdf');
    }
}
