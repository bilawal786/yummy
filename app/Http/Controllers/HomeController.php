<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }
    public function testnotification(){
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = 'AAAAZuszcYE:APA91bFT8MAEAO0V4RndUefwj7ApFilhZ0vifGbAZNWv2YMVgSBElTkCiy4ntKyH_gKxfn1Bny36DCXcEJ4tK8wy9pS251AaXmjb1PNTkbE_FuAnXLgdlJtRW5NIGNQIPO1qn4vjdWb6';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => "YUMMY BOX",
                "body" => "TEST NOTIFICATION",
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        dd($response);
    }
    public function changelocation($id){
        $user = Auth::user();
        $user->address = $id;
        $user->update();
        return redirect()->back();
    }
}
