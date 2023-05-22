<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Laravel\Passport\Exceptions\MissingScopeException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
//use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found.'
                ], 404);
            }
        });

//        $this->renderable(function (MissingScopeException $e, Request $request) {
//            if ($request->is('api/*')) {
//                return response()->json([
//                    'success' => false,
//                    'message' => 'Unauthenticated.'
//                ], 401);
//            }
//        });

//        $this->renderable(function (AuthorizationException $e, Request $request) {
//            if ($request->is('api/*')) {
//                return response()->json([
//                    'success' => false,
//                    'message' => 'Unauthorization.'
//                ], 403);
//            }
//        });



//        $this->renderable(function (AccessDeniedHttpException $e, Request $request) {
//            if ($request->is('api/*')) {
//                return response()->json([
//                    'success' => false,
//                    'message' => 'Access Denied.'
//                ], 403);
//            }
//        });

//        $this->renderable(function (\BadMethodCallException $e, Request $request) {
//            if ($request->is('api/*')) {
//                return response()->json([
//                    'success' => false,
//                    'message' => 'Not Found.'
//                ], 400);
//            }
//        });


//        We are not using this exception right now
//        $this->renderable(function (HttpException $e, Request $request) {
//            if ($request->is('api/*')) {
//                return response()->json([
//                    'success' => false,
//                    'message' => 'Not Found.'
//                ], 404);
//            }
//        });

    }
}
