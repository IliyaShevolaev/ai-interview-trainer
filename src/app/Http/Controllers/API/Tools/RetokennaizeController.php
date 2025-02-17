<?php

namespace App\Http\Controllers\API\Tools;

use App\Models\Interview\Interview;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RetokennaizeController extends Controller
{
    public function __invoke($token)
    {
        try {
            $interview = Interview::where('token', $token)->firstOrFail();
            return response()->json(['id' => $interview->id], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Interview not found'], 404);
        }
    }
}