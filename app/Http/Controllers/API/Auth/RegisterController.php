<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Admin;
use App\Models\Agency;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
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


    /**
     * Store a newly created resource in storage.
     */
    public function registerAdminOrAgency(RegisterRequest $request): Response
    {
        if($this->guard_scope != 'superadmin'){
            return $this->respondUnAuthorizedWithMessage('UnAuthorized');
        }
        $input = $request->all();
        if($input['user_type'] == 'admin'){
            $get_details = Admin::where('email', $request->email)->first();
            $user = new Admin();
        }else if($input['user_type'] == 'agency'){
            $get_details = Agency::where('email', $request->email)->first();
            $user = new Agency();
        }

        if ($get_details) {
            return $this->respondWithError('User Already Exist');
        }

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        $user->save();

        if($user){
            return $this->respondSuccessWithMessage('User Created Successfully.');
        }
        else{
            return $this->respondUnAuthorizedWithMessage('User Not Created.');
        }
    }
}
