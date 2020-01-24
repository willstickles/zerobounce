<?php

namespace Willstickles\LaravelNeutrino\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class NeutrinoController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('willstickles\laravelneutrino::neutrino.validate_email');
    }

    
    /**
     * Validate Email Address with Zerobounce API
     *
     * @param  mixed $response
     *
     * @return void
     */
    public function validateEmail(Response $response) {
        return response()->json($response);
    }
}