<?php

namespace App\Http\Controllers\API\Auth;

use App\ApiCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Response;

class ForgotPasswordController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('api');
    }

    public function sendResetLinkEmail(Request $request): Response
    {
        $validate = $this->validateEmail($request);
        $resetter = $this->getGuardResetterTable($this->guard_scope);
        $broker = Password::broker($resetter); // table name
        $response = $broker->sendResetLink($request->only('email'));

        if ($response === Password::RESET_LINK_SENT) {
            return $this->respondSuccessWithDataAndMessage(null, '', 'Password reset link sent successfully');
        }else{
            return $this->respondErrorWithMessage('Password reset link not sent', ApiCode::BAD_REQUEST);
        }
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        if ($user = Auth::guard($this->guard_scope)->getProvider()->retrieveByCredentials(['email' => $request->email])) {
            $request->merge(['user_id' => $user->id]);
        } else {
            return $this->respondErrorWithMessage('User with email address not found.', ApiCode::NOT_FOUND);
        }
    }


}
