<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class APIController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $email)
    {
        $user = User::where('email', $request->email)->first();
        if(!isset($user)){
            return response()->json(['status' => 'invalidUserError', 'message' => 'Register and Contact the Admin'], 403);
        }
        if(strtolower(request()->server()['REQUEST_METHOD']) !== 'post'){
            return response()->json(['status' => 'invalidMethodError', 'message' => 'Invalid method. Please check that your method is post'], 403);
        }
        if($request->tableName == 'centroid'){
            $requestPayload = $request->all();
            $requiredFields = ['origin', 'destinations'];
            foreach($requiredFields as $required){
                if(!array_key_exists($required, $requestPayload)){
                    return response()->json(['status' => 'errMsg', 'message' => 'Required parameter "'.$required.'" not found'], 404);
                }
            }
            $origin = $request->origin;
            $destinations = $request->destinations;
            $user = User::where('email', 'ademola@adewumi.com')->first();
            $key = $user->name;
            $payload = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$origin&destinations=$destinations&key=$key";
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$payload",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    return $response;
            }
        }
        elseif($request->tableName == 'adm1'){
            $requestPayload = $request->all();
            $requiredFields = ['value'];
            foreach($requiredFields as $required){
                if(!array_key_exists($required, $requestPayload)){
                    return response()->json(['status' => 'errMsg', 'message' => 'Required parameter "'.$required.'" not found'], 404);
                }
            }
            $reponse = \DB::table('communities')->where($request->tableName, $request->value)->get();
            return response()->json($reponse, 200);
        }
        else{
            return response()->json(['status' => 'errMsg', 'message' => 'Table not found. Contact the Adminstrator for list of tables'], 404);
        }
        
    }

    public function testEndpoint(Request $request, $email)
    {
        print 'Welcome '.$request->email.'. <br /> You have succesfully tested the endpoint and you can now make requests to the /communities/{email} endpoint.';
        die();
    }
}
