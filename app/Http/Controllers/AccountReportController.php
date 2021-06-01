<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Image;
use PDF;

class AccountReportController extends HomeController
{
    use Image;

    protected $name = 'AccountReport';

    public function showPdf(){
        $logo = $this->imagePathToBase64(public_path('images/logo.png'));
        $data = [
            'logo' => $logo,
        ];
        $pdf = PDF::loadView('pdf.AnnualAccountReport',$data);
        $pdf->setOptions(['isPhpEnabled' => true]);
        return $pdf->stream('AnnualAccountReport.pdf');
    }

    public function showHtml(){
        $logo = $this->imagePathToBase64(public_path('images/logo.png'));
        $data = [
            'logo' => $logo,
        ];
        return View('pdf.AnnualAccountReport',$data);
    }
}
