<?php

namespace App\Http\Controllers\Interview;

use App\Actions\Interview\StoreInterviewAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Interview\CreateRequest;
use App\Models\Interview\Interview;
use App\Models\Interview\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateInterviewController extends Controller
{
    public function store(CreateRequest $createRequest, StoreInterviewAction $storeInterviewAction)
    {
        $data = $createRequest->validated();

        if ($createRequest->hasFile('questions_file')) {
            $data['questions_file']  = $createRequest->file('questions_file');

            $storeInterviewAction->handle($data);

            return response()->json(['success' => true], 200);
        }
    }
}
