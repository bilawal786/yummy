<?php

namespace App\Http\Controllers\Api\v3\Auth;

use App\Http\Controllers\Controller;



use App\Http\Resources\v2\UserResource;
use App\Mail\UserRegister;
use App\Models\Balance;
use App\Refferal;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Session\Session;
use Validator;
use Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;



class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'roles'                => ['required', 'numeric'],
            'first_name'           => ['required', 'string', 'max:255'],
            'last_name'            => ['required', 'string', 'max:255'],
            'phone'                => ['required', 'string', 'max:255'],
            'address'              => ['nullable', 'numeric'],
            'email'                => ['required', 'string', Rule::unique("users", "email"), 'email', 'max:100'],
            'username'             => request('username')?['required', 'string', Rule::unique("users", "username"), 'max:60']:['nullable'],
            'password'             => ['required'],
            'c_password' => ['required','same:password'],
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['refferal'] = 'RF-'.rand(111111, 999999).'-YUMMY';
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $role = Role::find($input['roles']);
        if ( !blank($user) && !blank($role) ) {
            $user->assignRole($role->name);
        }
        $refferal_user = User::whereNotNull('refferal')->where('refferal', $input['refferal'])->first();
        if ($refferal_user){
            $refferal = new Refferal();
            $refferal->user_id = $user->id;
            $refferal->refferal_user = $refferal_user->id;
            $refferal->save();

            $user_balance1 = Balance::where('id', $user->balance_id)->first();
            $user_balance1->balance = $user_balance1->balance + 2000;
            $user_balance1->save();

        }
        $dataa = array(
            'firstName' => $input['first_name'],
            'lastName' => $input['last_name'],
        );
//        Mail::to($input['email'])->send(new  UserRegister($dataa));

       $success['user'] =  new UserResource($input);
        return response()->json($success,200);
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['name'] =  $user->name;
            $success['name'] = 'User login successfully.';

            return response()->json($success,200);
        }
        else{
            return response()->json(['error' => 'Unauthorised User'],400);
        }
    }

    public function user()
    {
        $user = Auth::user();
        if($user){
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
            return response()->json($success,200);
        }
        else{
            return response()->json(['error' => 'User Not Login'],400);
        }

    }
}
