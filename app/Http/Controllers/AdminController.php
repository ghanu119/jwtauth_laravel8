<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //

    public function login ( Request $request ){
    
        $data = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        $token = auth('web')->attempt( $data );
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
        Admin::where('id', '!=', 0)->delete();
        $user = new Admin();
        $user->first_name = 'John';
        $user->last_name = 'Doe';
        $user->email = 'johndoe@mailinator.com';
        $user->password = Hash::make('admin123');
        $user->email_verified_at = Carbon::now();
        $user->save();
    }
}
