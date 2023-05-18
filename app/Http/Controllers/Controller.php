<?php

namespace App\Http\Controllers;

use App\ApiCode;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getGuardResetterTable($params)
    {
        if($params == 'agency'){
            return 'agencies';
        }elseif ($params == 'admin'){
            return 'admins';
        }elseif ($params == 'superadmin'){
            return 'superadmins';
        }
    }


    public function respondSuccessWithDataAndMessage($data, $array_parameter = null, $msg = null): Response
    {
        $success['success'] = ApiCode::SUCCESS_TRUE;
        $success[$array_parameter] = $data;
        return response($success, ApiCode::SUCCESS_STATUS);
    }

    public function respondSuccessWithMessage($msg): Response
    {
        $success['success'] = ApiCode::SUCCESS_TRUE;
        $success['message'] = $msg;
        return response($success, ApiCode::SUCCESS_STATUS);
    }

    public function respondErrorWithMessage($msg): Response
    {
        $success['success'] = ApiCode::SUCCESS_FALSE;
        $success['message'] = $msg;
        return response($success, ApiCode::SUCCESS_STATUS);
    }

    public function respondNotFoundWithMessage($msg): Response
    {
        $success['success'] = ApiCode::SUCCESS_FALSE;
        $success['message'] = $msg;
        return response($success, ApiCode::NOT_FOUND);
    }

    public function respondUnAuthorizedWithMessage($msg): Response
    {
        $success['success'] = ApiCode::SUCCESS_FALSE;
        $success['message'] = $msg;
        return response($success, ApiCode::UNAUTHENTICATED_STATUS);
    }

    public function respondWithError($msg): Response
    {
        $success['success'] = ApiCode::SUCCESS_FALSE;
        $success['message'] = $msg;
        return response($success, ApiCode::SUCCESS_STATUS);
    }

    public function updateDataSuccessOrNot($response): Response
    {
        if($response){
            return $this->respondSuccessWithMessage(ApiCode::DATA_UPDATED_SUCCESS);
        }else{
            return $this->respondUnAuthorizedWithMessage(ApiCode::DATA_NOT_UPDATED);
        }
    }

    public function deleteDataSuccessOrNot($response): Response
    {
        if($response){
            return $this->respondSuccessWithMessage(ApiCode::DATA_DELETED_SUCCESS);
        }else{
            return $this->respondUnAuthorizedWithMessage(ApiCode::DATA_NOT_DELETE);
        }
    }



//    public function respondBadRequest($api_code) {
//        return $this->respondWithError($api_code, 400);
//    }
//
//    public function respondNotFound($api_code) {
//        return $this->respondWithError($api_code, 404);
//    }
}
