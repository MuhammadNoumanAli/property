<?php

namespace App\Http\Controllers\API\Agency;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return 'null';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        return 'null';
    }

    /**
     * Display the specified resource.
     */
    public function show(Agency $agency): Response
    {
        return 'null';
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agency $agency): Response
    {
        return 'null';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agency $agency): Response
    {
        return 'null';
    }
}
