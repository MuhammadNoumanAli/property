<?php

namespace App\Http\Controllers;

use App\ApiCode;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
//use Illuminate\Support\Facades\Lang;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getGuardResetterTable($params)
    {
        $type = 'superadmins';
        if($params == 'agency'){
            $type = 'agencies';
        }
        if ($params == 'admin'){
            $type = 'admins';
        }
        return $type;
    }


    public function respondSuccessWithDataAndMessage($data = null, $array_parameter = null, $msg = null): Response
    {
        $success['success'] = ApiCode::SUCCESS_TRUE;
        if(!empty($data)){
            $success[$array_parameter] = $data;
        }else{
            $success['message'] = $msg;
        }
        return response($success, ApiCode::SUCCESS_STATUS);
    }


    public function respondErrorWithMessage($msg, $response_code): Response
    {
        $success['success'] = ApiCode::SUCCESS_FALSE;
        $success['message'] = $msg;
        return response($success, $response_code);
    }


    public function updateDataSuccessOrNot($response): Response
    {
        if($response){
            return $this->respondSuccessWithDataAndMessage(null, '', trans('messages.update_success'));
        }else{
            return $this->respondErrorWithMessage(trans('messages.not_update'), ApiCode::DATA_NOT_UPDATED);
        }
    }


    public function deleteDataSuccessOrNot($response): Response
    {
        if($response){
            return $this->respondSuccessWithDataAndMessage(null, '', trans('messages.delete_success'));
        }else{
            return $this->respondErrorWithMessage(trans('messages.not_delete'), ApiCode::DATA_NOT_UPDATED);
        }
    }

}
