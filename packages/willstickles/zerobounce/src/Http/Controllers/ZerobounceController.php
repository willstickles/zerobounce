<?php

namespace Willstickles\Zerobounce\Http\Controllers;

use App\Http\Controllers\Controller;
use Facades\Willstickles\Zerobounce\Repository\ZeroBounce;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ZeroBounceController extends Controller
{
    
    protected $api_user_id = '';
    protected $api_key = '';

    public function __construct()
    {
        $this->api_user_id = config('zerobounce.zerobounce.user_id');
        $this->api_key = config('zerobounce.zerobounce.api_key');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('willstickles\zerobounce::zerobounce.validate_email');
    }

    public function validateEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $ip_address = ($request->ip_address) ? $request->ip_address : '';

        $client = new Client();
        $url = "https://api.zerobounce.net/v2/validate";

        $res = $client->request('GET', $url, [
           "query" => [ 
               'api_key' => $this->api_key,
               'email' => $request->email,
               'ip_address' => $ip_address
               ]
        ]);
        $this->response_data = json_decode((string) $res->getBody(), true);

        if ( config('zerobounce.zerobounce.cache.use_cache') ) {
            $cacheKey = ZeroBounce::getCacheKey('email');

            $expire_days = config('zerobounce.zerobounce.cache.expire');

            return cache()->remember($cacheKey, Carbon::now()->addDays($expire_days), function() {
                return $this->response_data;
            });
        } else {
            return response()->json($this->response_data, 200);
        }

    }

    /**
     * Get credit balance from ZeroBounce
     *
     * @param  mixed $response
     *
     * @return void
     */
    public function getCreditBalance ()
    {
        $client = new Client();
        $base_url = "https://api.zerobounce.net/v2/getcredits?api_key=";

        $res = $client->request('GET', $base_url, [
            'query' => [
                'api_key' => $this->api_key,
            ]
        ]);
   
        return $res->getBody();
    }

    /**
     * Send File to Zero Bounce
     *
     * @return void
     */
    public function sendFile()
    {
        return view('willstickles\zerobounce::zerobounce.send_file');
    }

    public function fileUpload(Request $request)
    {
        $file = $request->file('filename');
        
        // dd($file);

        $filename = $file->getRealPath().'.'.$file->getClientOriginalExtension();
        // $request->file->move(public_path('files'), $filename);

        $client = new Client();
        $url = "https://bulkapi.zerobounce.net/v2/sendfile";

        $res = $client->request('POST', $url, [
            'multipart' => [
                [
                    'file' => $filename,
                    'api_key' => $this->api_key,
                    'email_address_column' => 1,
                    'contents' => fopen($filename, 'r')
                ]
            ]
        ]);
            dd($res);
        $response_data = json_decode((string) $res->getBody(), true);

        dd($response_data);

        return response()->json($response_data, 200);
    }

    public function fileStatus()
    {
        //
    }

    public function getFile() 
    {
        //
    }

    public function deleteFile()
    {
        //
    }
    
}