<?php

namespace Willstickles\LaravelNeutrino\Http\Controllers;

use App\Http\Controllers\Controller;
use Facades\Willstickles\LaravelNeutrino\Repository\Neutrino;
use Illuminate\Support\Facades\Cache;

class NeutrinoController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $value = Neutrino::all('email');
        dd($value);

        return view('willstickles\laravelneutrino::neutrino.validate_email');
    }

    
    /**
     * Validate Email Address with Zerobounce API
     *
     * @param  mixed $response
     *
     * @return void
     */
    public function submit(Request $request) 
    {
        dd($request);

        $this->validate($request, [
            'email' => 'required|email'
        ]);

        return response()->json(null, 200);
    }
}