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

        $SERVER_API_KEY = 'AAAAAjqrxA4:APA91bH2gSA-MK-gvM4ASC7-xfx7Fg--FMCzg1KdZ5wkwQb1fCOkWdDKvLWSHW4dJAwvX9SVjYWVQwHeYxElsi7fuwu3fuidKJzyWI0YlCipcGK5DnTStSmwvDNdCAfMxrYyDcqSRtEm';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => "Yummy Box",
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
