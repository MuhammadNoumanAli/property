<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\ApiCode;

class ResetPasswordController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->guard_scope = \Request::segment(2);
    }


    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('api');
    }


    public function reset(Request $request)
    {
        $validate = $request->validate($this->rules(), $this->validationErrorMessages());
        $resetter = $this->getGuardResetterTable($this->guard_scope);
        $response = Password::broker($resetter)->reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($response === Password::PASSWORD_RESET) {
            $success['success'] = ApiCode::SUCCESS_TRUE;
            $success['message'] = 'Your password has been reset.';
            return response($success, ApiCode::SUCCESS_STATUS);
        }else{
            $this->sendResetFailedResponse($request, $response);
        }
    }
}
