<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class FaceBookController extends Controller
{
/**
 * Login Using Facebook
 */
 public function loginUsingFacebook()
 {
    return Socialite::driver('facebook')->redirect();
 }

 public function callbackFromFacebook()
 {
  try {
       $user = Socialite::driver('facebook')->user();

       $saveUser = User::updateOrCreate([
           'fb_id' => $user->getId(),
         ],[
           'first_name' => $user->getName(),
           'last_name' => '',
           'username'   => $this->username($user->getEmail()),
           'phone' => '',
           'address' => '1',
           'email' => $user->getEmail(),
           'refferal'   => 'RF-'.rand(111111, 999999).'-YUMMY',
           'password' => Hash::make($user->getName().'@'.$user->getId())
            ]);

       Auth::loginUsingId($saveUser->id);

       return redirect()->route('home');
       } catch (\Throwable $th) {
          throw $th;
       }
   }
    private function username($email) {
        $emails = explode('@', $email);
        return $emails[0].mt_rand();
    }
}
