<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function user(Request $request)
    {
        return $request->user();
    }

    public function welcome(Request $request)
    {
        return view('welcome');
    }

    public function TestRoute(Request $request)
    {
        $route = $request->input('route');
        dd($route);
    }
}
