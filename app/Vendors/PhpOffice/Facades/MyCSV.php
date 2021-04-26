<?php
namespace App\Vendors\PhpOffice\Facades;

use Illuminate\Support\Facades\Facade;

class MyCSV extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mycsv';
    }
}
