<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Suggest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ProfileController extends BackendController
{

    public function index()
    {
        $this->data['user'] = auth()->user();
        return view('admin.profile.index', $this->data);
    }

    public function bankDetails(){
        $this->data['user'] = auth()->user();
        return view('admin.profile.bankDetails', $this->data);
    }

    public function bankDetailsStore(Request $request){
        $bankDetailsStore = User::find(Auth::user()->id);
        $bankDetailsStore->iban = $request->iban;
        $bankDetailsStore->company_name = $request->company_name;
        $bankDetailsStore->siret = $request->siret;
        $bankDetailsStore->update();
        return redirect()->back();
    }

    public function adminBank(){
        $role = Role::find(3);
        $this->data['bankdetails'] = User::role($role->name)->get();
        return view('admin.bank.index', $this->data);
    }

    public function update(ProfileRequest $request)
    {
        $user             = auth()->user();
        $user->first_name = $request->get('first_name');
        $user->last_name  = $request->get('last_name');
        $user->email      = $request->get('email');
        $user->phone      = $request->get('phone');
        $user->username   = $request->username ?? $this->username($request->email);
        $user->address    = $request->get('address');
        $user->save();

        if (request()->file('image')) {
            $user->media()->delete();
            $user->addMedia(request()->file('image'))->toMediaCollection('user');
        }

        return redirect(route('admin.profile'))->withSuccess('The Data Updated Successfully');
    }

    public function change(ChangePasswordRequest $request)
    {
        $user           = auth()->user();
        $user->password = Hash::make(request('password'));
        $user->save();
        return redirect(route('admin.profile'))->withSuccess('The Password updated successfully');
    }

    private function username($email) {
        $emails = explode('@', $email);
        return $emails[0].mt_rand();
    }
    public function suggestions(){
        $suggestions = Suggest::latest()->get();
        return view('admin.suggestions.index', compact('suggestions'));
    }

    public function suggestDelete($id){
        $suggestDelete = Suggest::find($id);
        $suggestDelete->delete();
        return redirect()->back()->withSuccess('Supprimé avec succès');
    }

    public function sendNotifications(){
        return view('admin.suggestions.sendNotifications');
    }

    public function storeNotifications(Request $request){
        $role = Role::find(2);
        $firebaseToken = User::role($role->name)->whereNotNull('device_token')->pluck('device_token')->all();
dd($firebaseToken);
        $SERVER_API_KEY = 'AAAAZuszcYE:APA91bFT8MAEAO0V4RndUefwj7ApFilhZ0vifGbAZNWv2YMVgSBElTkCiy4ntKyH_gKxfn1Bny36DCXcEJ4tK8wy9pS251AaXmjb1PNTkbE_FuAnXLgdlJtRW5NIGNQIPO1qn4vjdWb6';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => "YUMMY BOX",
                "body" => "Message de l'administrateur :".$request->message,
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
}
