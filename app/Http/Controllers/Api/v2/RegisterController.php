<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function salesPersonStore(Request $request){
        $user             = new User;
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->username   = $request->username ?? $this->username($request->email);
        $user->password   = $request->password;
        $user->phone      = $request->phone;
        $user->address    = $request->address;
        $user->status     = $request->status;

        $user->p3 = 1;

        $user->p1 = 0;
        $user->p2 = 0;
        $user->p4 = 0;
        $user->p5 = 0;
        $user->p6 = 0;
        $user->p7 = 0;
        $user->p8 = 0;
        $user->p9  = 0;
        $user->p10  = 0;
        $user->p11  = 0;
        $user->p12  = 0;


        $user->save();

        if (request()->file('image')) {
            $user->addMedia(request()->file('image'))->toMediaCollection('user');
        }

        $role = Role::find(6);
        $user->assignRole($role->name);

        return response()->json([
            'status'  => 200,
            'message' => 'You order completed successfully.',
            'data'    => $user,
        ], 200);

    }
}
