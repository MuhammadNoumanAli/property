<?php

namespace App\Http\Controllers\API\Auth;

use App\ApiCode;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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


    public function loginUser(Request $request): Response
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $credentials = ['email' => $input['email'], 'password' => $input['password']];
        if(Auth::guard($this->guard_scope)->attempt($credentials)){
            $user = Auth::guard($this->guard_scope)->user();
            $token = $user->createToken('SuperadminToken', [$this->guard_scope])->accessToken;
            $success['success'] = ApiCode::SUCCESS_TRUE;
            $success['token'] = $token;
            return response($success, ApiCode::SUCCESS_STATUS);
        }
        else{
            $success['success'] = ApiCode::SUCCESS_FALSE;
            $success['message'] = 'Email or password incorrect';
            return response($success, ApiCode::UNAUTHENTICATED_STATUS);
        }
    }

    public function registerAdminOrAgency(RegisterRequest $request): Response
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        if($input['user_type'] == 'admin'){
            $get_details = Admin::where('email', $request->email)->first();
            $user = new Admin();
        }else if($input['user_type'] == 'agency'){
            $get_details = Agency::where('email', $request->email)->first();
            $user = new Agency();
        }

        if ($get_details) {
            $success['success'] = ApiCode::SUCCESS_TRUE;
            $success['token'] = 'User Already Exist';
            return response($success, ApiCode::UNAUTHENTICATED_STATUS);
        }

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        $user->save();

        if($user){
           $success['success'] = ApiCode::SUCCESS_TRUE;
           $success['token'] = 'User Created Successfully';
           return response($success, ApiCode::SUCCESS_STATUS);
        }
        else{
            $success['success'] = ApiCode::SUCCESS_FALSE;
            $success['message'] = 'User Not Created';
            return response($success, ApiCode::UNAUTHENTICATED_STATUS);
        }
    }




    public function userDetails()
    {
        $user = Auth::user();
        $success['success'] = ApiCode::SUCCESS_TRUE;
        $success['data'] = $user;
        return response($success, ApiCode::SUCCESS_STATUS);
    }


    public function logoutUser()
    {
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();
        $success['success'] = ApiCode::SUCCESS_TRUE;
        $success['token'] = 'Logout Successfully';
        return response($success, ApiCode::SUCCESS_STATUS);
    }

    protected function sendResponse($success, $index, $data, $requestResponse){
        $success['success'] = $success;
        $success[$index] = $data;
        return response($success, $requestResponse);
    }
}
