<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\PersonalAccessToken;

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


    public function loginUser(LoginRequest $request): Response
    {
        $input = $request->all();
        $credentials = ['email' => $input['email'], 'password' => $input['password']];
        if(Auth::guard($this->guard_scope)->attempt($credentials)){
            $user = Auth::guard($this->guard_scope)->user();
            $token = $user->createToken('SuperadminToken', [$this->guard_scope])->accessToken;
            return $this->respondSuccessWithDataAndMessage($token, 'token');
        }
        else{
            return $this->respondUnAuthorizedWithMessage('Email or password incorrect');
        }
    }


    public function userDetails(): Response
    {
        $user = Auth::user();
        if($user){
            return $this->respondSuccessWithDataAndMessage($user, 'data');
        }else{
            return $this->respondNotFoundWithMessage('Record Not Found');
        }
    }


    public function logoutUser(): Response
    {
        $accessToken = Auth::user()->token();

        if($accessToken){
            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update([
                    'revoked' => true
                ]);
            $accessToken->revoke();
            return $this->respondSuccessWithMessage('Logout Successfully');
        }else{
            return $this->respondUnAuthorizedWithMessage('UnAuthorized');
        }
    }

}
