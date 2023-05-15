<?php

namespace App\Http\Controllers\API\Auth;

use App\ApiCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
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

    public function sendResetLinkEmail(Request $request)
    {
        $validate = $this->validateEmail($request);
        $resetter = $this->getGuardResetterTable($this->guard_scope);
        $broker = Password::broker($resetter); // table name
        $response = $broker->sendResetLink($request->only('email'));

        if ($response === Password::RESET_LINK_SENT) {

            $success['success'] = ApiCode::SUCCESS_TRUE;
            $success['message'] = 'Password reset link sent successfully';
            return response($success, ApiCode::SUCCESS_STATUS);
        }
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
//        $guardName = 'agency';
        if ($user = Auth::guard($this->guard_scope)->getProvider()->retrieveByCredentials(['email' => $request->email])) {
            $request->merge(['user_id' => $user->id]);
        } else {
            $success['success'] = ApiCode::SUCCESS_TRUE;
            $success['message'] = 'User with email address not found.';
            return response($success, ApiCode::EMAIL_NOT_FOUND);
        }
    }


}
