<?php

namespace Willstickles\Zerobounce\Http\Controllers;

use App\Http\Controllers\Controller;
use Facades\Willstickles\Zerobounce\Repository\ZeroBounce;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ZeroBounceController extends Controller
{
    
    protected $api_user_id = '';
    protected $api_key = '';

    /**
     * __construct
     *
     * @return void
     */
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

    /**
     * Validate an email address with Zerobounce API
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function validateEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $ip_address = ($request->ip_address) ? $request->ip_address : '';

        $client = new GuzzleClient();
        $url = "https://api.zerobounce.net/v2/validate";

        $email = trim( strtolower($request->email) );

        $res = $client->request('GET', $url, [
           "query" => [ 
               'api_key' => $this->api_key,
               'email' => $email, 
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
     * Get credit balance from Zerobounce API
     *
     * @param  mixed $response
     *
     * @return void
     */
    public function getCreditBalance ()
    {
        $client = new GuzzleClient();
        $base_url = "https://api.zerobounce.net/v2/getcredits";

        $res = $client->request('GET', $base_url, [
            'query' => [
                'api_key' => $this->api_key,
            ]
        ]);
   
        return $res->getBody();
    }

    /**
     * Display form to upload file for Zerobounce API
     *
     * @return void
     */
    public function sendFile()
    {
        return view('willstickles\zerobounce::zerobounce.send_file');
    }

    /**
     * Upload a file and send it to Zerobounce API
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function fileUpload(Request $request)
    {
        $file = Storage::putfile('emailFiles', $request->file('filename'), 'public');
        
        // $filename = $file->getRealPath().'.'.$file->getClientOriginalExtension();
        // $request->file->move(public_path('files'), $filename);
        $headers = [
            'Content-Type' => 'multipart/form-data'
        ];

        $client = new GuzzleClient([
            'headers' => $headers
        ]);
        $url = "https://bulkapi.zerobounce.net/v2/sendfile";

        $res = $client->request('POST', $url, [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => Storage::get($file),
                    'filename' => $file
                ],
                [
                    'name' => 'api_key',
                    'contents' => $this->api_key,
                ],
                [
                    'name' => 'email_address_column',
                    'contents' => 1
                ]
            ]
            
        ]);
        $response_data = json_decode((string) $res->getBody(), true);

        return response()->json($response_data->getBody(), 200);
    }

    /**
     * Get status of a file sent to Zerobounce API
     *
     * @param  mixed $file_id
     *
     * @return void
     */
    public function fileStatus($file_id)
    {
        $client = new GuzzleClient();
        $base_url = "https://api.zerobounce.net/v2/filestatus";

        $res = $client->request('GET', $base_url, [
            'query' => [
                'api_key' => $this->api_key,
                'file_id' => $file_id
            ]
        ]);
   
        return $res->getBody();
    }

    /**
     * Get file uploaded to Zerobounce API
     *
     * @param  mixed $file_id
     *
     * @return void
     */
    public function getFile($file_id) 
    {
        $client = new GuzzleClient();
        $base_url = "https://api.zerobounce.net/v2/getfile";

        $res = $client->request('GET', $base_url, [
            'query' => [
                'api_key' => $this->api_key,
                'file_id' => $file_id
            ]
        ]);
   
        return $res->getBody();
    }

    /**
     * Delete file sent to Zerobounce API
     *
     * @param  mixed $file_id
     *
     * @return void
     */
    public function deleteFile($file_id)
    {
        $client = new GuzzleClient();
        $base_url = "https://api.zerobounce.net/v2/deletefile";

        $res = $client->request('GET', $base_url, [
            'query' => [
                'api_key' => $this->api_key,
                'file_id' => $file_id
            ]
        ]);
   
        return $res->getBody();
    }
    
}