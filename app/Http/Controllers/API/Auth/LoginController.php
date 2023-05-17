<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use App\Models\Agency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class LoginController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->guard_scope = \Request::segment(2);
    }


    public function loginUser(LoginRequest $request)
    {
        $input = $request->all();

        $credentials = ['email' => $input['email'], 'password' => $input['password']];
        if(Auth::guard($this->guard_scope)->attempt($credentials)){
            $user = Auth::guard($this->guard_scope)->user();
            $token = $user->createToken('SuperadminToken', [$this->guard_scope])->accessToken;
            $this->respondSuccessWithDataAndMessage($token, 'token');
        }
        else{
            $this->respondUnAuthorizedWithMessage('Email or password incorrect');
        }
    }

    public function registerAdminOrAgency(RegisterRequest $request)
    {
        $input = $request->all();
        if($input['user_type'] == 'admin'){
            $get_details = Admin::where('email', $request->email)->first();
            $user = new Admin();
        }else if($input['user_type'] == 'agency'){
            $get_details = Agency::where('email', $request->email)->first();
            $user = new Agency();
        }

        if ($get_details) {
            $this->respondWithError('User Already Exist');
        }

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        $user->save();

        if($user){
            $this->respondSuccessWithMessage('User Created Successfully.');
        }
        else{
            $this->respondUnAuthorizedWithMessage('User Not Created.');
        }
    }




    public function userDetails()
    {
        $user = Auth::user();
        if($user){
            $this->respondSuccessWithDataAndMessage($user, 'data');
        }else{
            $this->respondNotFoundWithMessage('Record Not Found');
        }
    }


    public function logoutUser()
    {
        $accessToken = Auth::user()->token();
        if($accessToken){
            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update([
                    'revoked' => true
                ]);
            $accessToken->revoke();
            $this->respondSuccessWithMessage('Logout Successfully');
        }else{
            $this->respondUnAuthorizedWithMessage('UnAuthorized');
        }
    }

}
