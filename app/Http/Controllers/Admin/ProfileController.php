<?php

namespace App\Http\Controllers\Admin;

use App\Favourite;
use App\Http\Controllers\BackendController;
use App\Http\NotificationHelper;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Location;
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
        $locations = Location::all();
        $role = Role::find(2);
        $role1 = Role::find(3);
        $users = User::role($role)->get();
        $traders = User::role($role1)->get();
        return view('admin.suggestions.sendNotifications', compact('locations', 'users', 'traders'));
    }
    public function sendNotificationsVendor(){
       $users_id = Favourite::where('product_creator', Auth::user()->id)->pluck('user_id');
       $users = User::whereIn('id', $users_id)->get();
        return view('admin.suggestions.sendNotificationsVendor', compact( 'users'));
    }

    public function storeNotificationsvendor(Request $request){
        if ($request->user_id[0] == "send_to_all"){
            $users_id = Favourite::where('product_creator', Auth::user()->id)->pluck('user_id');
            $firebaseTokens = User::whereIn('id', $users_id)->whereNotNull('device_token')->get();
        }else{
            $firebaseTokens = User::whereIn('id', $request->user_id)->whereNotNull('device_token')->get();
        }
        foreach ($firebaseTokens as $UserToken){
            $url = 'https://fcm.googleapis.com/fcm/send';
            if ($UserToken->device_type == "android"){
                $fields = array (
                    'registration_ids' => array (
                        $UserToken->device_token
                    ),
                    'data' => array (
                        "title" => "Yummy Box",
                        "message" => $request->message,
                        "click_action" => "NotificationLunchScreen",
                    )
                );
            }else{
                $fields = array (
                    'registration_ids' => array (
                        $UserToken->device_token
                    ),
                    'notification' => array (
                        "title" => "Yummy Box",
                        "body" => $request->message,
                        "click_action" => "NotificationLunchScreen",
                    )
                );
            }
            $fields = json_encode ( $fields );
            $headers = array (
                'Authorization: key=' . "AAAAAjqrxA4:APA91bH2gSA-MK-gvM4ASC7-xfx7Fg--FMCzg1KdZ5wkwQb1fCOkWdDKvLWSHW4dJAwvX9SVjYWVQwHeYxElsi7fuwu3fuidKJzyWI0YlCipcGK5DnTStSmwvDNdCAfMxrYyDcqSRtEm",
                'Content-Type: application/json'
            );
            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $url );
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
            $result = curl_exec ( $ch );
            curl_close ( $ch );
        }
        return redirect()->back()->withSuccess('Envoyé avec succès à tous');
    }

    public function storeNotifications(Request $request){
        $role = Role::find($request->type);
        if ($request->user_id[0] == "send_to_all"){
            $firebaseTokens = User::role($role->name)->where('address', $request->country_id)->whereNotNull('device_token')->get();
            $users = User::role($role->name)->where('address', $request->country_id)->get();
        }else{
            $firebaseTokens = User::whereIn('id', $request->user_id)->whereNotNull('device_token')->get();
            $users = User::whereIn('id', $request->user_id)->get();
        }
        $activity = "Message de l'administrateur";
        $msg = $request->message;
        foreach ($users as $user){
            NotificationHelper::addtoNitification(0, $user->id, $msg, 0, $activity, $user->address);
        }

        foreach ($firebaseTokens as $UserToken){
            $url = 'https://fcm.googleapis.com/fcm/send';
            if ($UserToken->device_type == "android"){
                $fields = array (
                    'registration_ids' => array (
                        $UserToken->device_token
                    ),
                    'data' => array (
                        "title" => "Yummy Box",
                        "message" => $request->message,
                        "click_action" => "NotificationLunchScreen",
                    )
                );
            }else{
                $fields = array (
                    'registration_ids' => array (
                        $UserToken->device_token
                    ),
                    'notification' => array (
                        "title" => "Yummy Box",
                        "body" => $request->message,
                        "click_action" => "NotificationLunchScreen",
                    )
                );
            }
            $fields = json_encode ( $fields );
            $headers = array (
                'Authorization: key=' . "AAAAAjqrxA4:APA91bH2gSA-MK-gvM4ASC7-xfx7Fg--FMCzg1KdZ5wkwQb1fCOkWdDKvLWSHW4dJAwvX9SVjYWVQwHeYxElsi7fuwu3fuidKJzyWI0YlCipcGK5DnTStSmwvDNdCAfMxrYyDcqSRtEm",
                'Content-Type: application/json'
            );
            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $url );
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
            $result = curl_exec ( $ch );
            curl_close ( $ch );
        }

        return redirect()->back()->withSuccess('Envoyé avec succès à tous');
    }
}
