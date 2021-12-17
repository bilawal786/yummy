<?php

namespace App\Http\Controllers\Auth;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\DeliveryBoyAccount;
use App\Providers\RouteServiceProvider;
use App\Refferal;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	 */

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::HOME;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data) {
		return Validator::make($data, [
				'roles'                => ['required', 'numeric'],
				'first_name'           => ['required', 'string', 'max:255'],
				'last_name'            => ['required', 'string', 'max:255'],
				'phone'                => ['required', 'string', 'max:255'],
				'address'              => ['nullable', 'numeric'],
				'email'                => ['required', 'string', Rule::unique("users", "email"), 'email', 'max:100'],
				'username'             => request('username')?['required', 'string', Rule::unique("users", "username"), 'max:60']:['nullable'],
				'password'             => ['required', 'string', 'min:6', 'confirmed'],
				'terms_and_conditions' => ['accepted']
			]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return \App\User
	 */
	protected function create(array $data) {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'username'   => $data['username'] ?? $this->username($data['email']),
            'phone'      => $data['phone'],
            'address'    => $data['address'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
            'refferal'   => 'RF-'.rand(111111, 999999).'-YUMMY',
        ]);

        $role = Role::find($data['roles']);
        if ( !blank($user) && !blank($role) ) {
            $user->assignRole($role->name);
        }
        $refferal_user = User::whereNotNull('refferal')->where('refferal', $data['refferal'])->first();
        if ($refferal_user){
            $refferal = new Refferal();
            $refferal->user_id = $user->id;
            $refferal->refferal_user = $refferal_user->id;
            $refferal->save();

            $user_balance1 = Balance::where('id', $user->balance_id)->first();
            $user_balance1->balance = $user_balance1->balance + 2000;
            $user_balance1->save();

        }
        /*if ( !blank($role) && ($role->id == 4) ) {
            $deliveryBoyAccount                  = new DeliveryBoyAccount();
            $deliveryBoyAccount->user_id         = $user->id;
            $deliveryBoyAccount->delivery_charge = 0;
            $deliveryBoyAccount->balance         = 0;
            $deliveryBoyAccount->save();
        }*/
        return $user;
	}

	private function username($email) {
		$emails = explode('@', $email);
		return $emails[0].mt_rand();
	}
}
