<?php

namespace App\Http\Controllers\API;

use App\ApiCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
            'guard_name' => 'required',
        ]);

        $permission = Permission::create([
                        'name' => $request->input('name'),
                        'guard_name' => $request->input('guard_name')
                    ]);
        if($permission){
            return $this->respondSuccessWithDataAndMessage(null, '','Permission Add Successfully');
        }else{
            return $this->respondErrorWithMessage('Permission Not Added.', ApiCode::UNAUTHENTICATED_STATUS);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
