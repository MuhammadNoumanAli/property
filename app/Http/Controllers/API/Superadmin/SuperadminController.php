<?php

namespace App\Http\Controllers\API\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Agency;
use App\Models\Superadmin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SuperadminController extends Controller
{
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        //
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Superadmin $superadmin): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Superadmin $superadmin): Response
    {
        //
    }
}
