<?php

namespace App\Http\Controllers\API\Auth;

use App\ApiCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\Token;
use Spatie\FlareClient\Api;

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
            return $this->respondErrorWithMessage('Email or password incorrect', ApiCode::INVALID_CREDENTIALS);
        }
    }


    public function userDetails(): Response
    {
        $user = Auth::user();
        if(Auth::user()){
            return $this->respondSuccessWithDataAndMessage($user, 'data');
        }else{
            return $this->respondErrorWithMessage('Record Not Found', ApiCode::NOT_FOUND);
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
            return $this->respondSuccessWithDataAndMessage(null, '','Logout Successfully');
        }else{
            return $this->respondErrorWithMessage('UnAuthorized', ApiCode::UNAUTHENTICATED_STATUS);
        }
    }

}
