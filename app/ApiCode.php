<?php

namespace App;

class ApiCode {
    public const SUCCESS_TRUE = true;
    public const SUCCESS_FALSE = false;
    public const SUCCESS_STATUS = 200;
    public const SOMETHING_WENT_WRONG = 250;
    public const INVALID_CREDENTIALS = 251;
    public const VALIDATION_ERROR = 252;
    public const EMAIL_ALREADY_VERIFIED = 253;
    public const INVALID_EMAIL_VERIFICATION_URL = 254;
    public const INVALID_RESET_PASSWORD_TOKEN = 255;
    public const BAD_REQUEST = 400;
    public const UNAUTHENTICATED_STATUS = 401;
    public const REQUEST_AREA_FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const GENERAL_SERVER_ERROR = 500;

    public const DATA_UPDATED_SUCCESS   = 'Data Updated Successfully';
    public const DATA_NOT_UPDATED       = 'Data Not Update';
    public const DATA_DELETED_SUCCESS   = 'Data Deleted Successfully';
    public const DATA_NOT_DELETE        = 'Data Not Delete';
    public const ACCESS_UNAUTHORIZED    = 'UnAuthorized';

}
