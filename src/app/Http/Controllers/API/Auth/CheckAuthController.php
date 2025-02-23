<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckAuthController extends Controller
{
    public function __invoke()
    {
        if (Auth::user()) {
            return response()->json([
                'message' => 'success'
            ], 200);
        }

        return response()->json([
            'message' => 'unauthorized'
        ], 204);
    }
}
