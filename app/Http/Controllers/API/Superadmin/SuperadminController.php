<?php

namespace App\Http\Controllers\API\Superadmin;

use App\ApiCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Superadmin\AdminAgencyUpdateRequest;
use App\Models\Admin;
use App\Models\Agency;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class SuperadminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:superadmin-api');
    }


    /**
     * Display a listing of the resource.
     */
    public function indexAgency(): Response
    {
        $agencies = Agency::orderBy('id', 'DESC')->get();
        return $this->respondSuccessWithDataAndMessage($agencies, 'data');
    }

    /**
     * Display a listing of the resource.
     */
    public function indexAdmin(): Response
    {
        $admins = Admin::orderBy('id', 'DESC')->get();
        return $this->respondSuccessWithDataAndMessage($admins, 'data');
    }


    /**
     * Display the specified resource.
     */
    public function showAgency(Agency $agency): Response
    {
        return $this->respondSuccessWithDataAndMessage($agency, 'data');
    }


    /**
     * Display the specified resource.
     */
    public function showAdmin(Admin $admin): Response
    {
        return $this->respondSuccessWithDataAndMessage($admin, 'data');
    }


    /**
     * Display the specified resource.
     */
    public function editAgency(Agency $agency): Response
    {
        return $this->respondSuccessWithDataAndMessage($agency, 'data');
    }


    /**
     * Display the specified resource.
     */
    public function editAdmin(Admin $admin): Response
    {
        return $this->respondSuccessWithDataAndMessage($admin, 'data');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateAgency(AdminAgencyUpdateRequest $request, Agency $agency): Response
    {
        $agency->name = $request->name;
        $agency->password = Hash::make($request->password);
        $result = $agency->save();
        if($result){
            return $this->respondSuccessWithMessage(ApiCode::DATA_UPDATED_SUCCESS);
        }else{
            return $this->respondUnAuthorizedWithMessage(ApiCode::DATA_NOT_UPDATED);
        }
//        $agency->update($request->validated());
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateAdmin(AdminAgencyUpdateRequest $request, Admin $admin): Response
    {
        $admin->name = $request->name;
        $admin->password = Hash::make($request->password);
        $result = $admin->save();
        if($result){
            return $this->respondSuccessWithMessage(ApiCode::DATA_UPDATED_SUCCESS);
        }else{
            return $this->respondUnAuthorizedWithMessage(ApiCode::DATA_NOT_UPDATED);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyAgency(Agency $agency): Response
    {
        $result = $agency->delete();
        if($result){
            return $this->respondSuccessWithMessage(ApiCode::DATA_DELETED_SUCCESS);
        }else{
            return $this->respondUnAuthorizedWithMessage(ApiCode::DATA_NOT_DELETE);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroyAdmin(Admin $admin): Response
    {
        $result = $admin->delete();
        if($result){
            return $this->respondSuccessWithMessage(ApiCode::DATA_DELETED_SUCCESS);
        }else{
            return $this->respondUnAuthorizedWithMessage(ApiCode::DATA_NOT_DELETE);
        }
    }
}
