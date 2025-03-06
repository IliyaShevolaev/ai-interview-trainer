<?php

namespace App\Http\Controllers\API\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModelsController extends Controller
{
    public function index()
    {
        $modelsList = config('aimodels.models');
        $selectedModel = Auth::user()->selected_model;

        $resultArray = [];
        foreach($modelsList as $key => $value) {
            $isSelected = false;
            if ($selectedModel === $value) {
                $isSelected = true;
            }

            array_push($resultArray, [
                'name' => $key,
                'isSelected' => $isSelected,
            ]);
        }

        return response()->json($resultArray, 200);
    }

    public function set(Request $request)
    {
        $data = $request->validate([
            'newModelName' => 'required|string',
        ]);

        $user = Auth::user();
        $user->update([
            'selected_model' => config('aimodels.models')[$data['newModelName']],
        ]);

        return response()->json($user, 200);
    }
}
