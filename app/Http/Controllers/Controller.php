<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
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
}
