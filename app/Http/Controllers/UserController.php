<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function login ( Request $request ){
        // $this->register();
        $data = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        $token = auth('api')->attempt( $data );
        if( !$token ){
            $response = [
                'success' => false,
                'message' => 'Error! Invalid credentials.',
            ];
            return response()->json( $response, 500);
        }
        $response = [
            'success' => true,
            'message' => 'Success! Login successfully',
            'token' => $token,
            'type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];

        return response()->json( $response, 200);

    }

    public function register ( ){
        User::where('id', '!=', 0)->delete();
        $user = new User();
        $user->name = 'Jane Doe';
        $user->email = 'janedoe@mailinator.com';
        $user->password = Hash::make('user123');
        $user->email_verified_at = Carbon::now();
        $user->save();
    }
}
