<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FormationController extends Controller
{
    public function getFormation()
    {
        return response()->json(Formation::paginate(8));
    }

    public function addFormation(Request $request)
    {
        $formationValidator = Validator::make($request->all(), [
            'label' => 'required|unique:formations,label',
            'plan' => 'required', Rule::in(['paid', 'free']),
            'length' => 'required',
            'level' => Rule::in(['beginner', 'confirmed', 'expert'])
        ]);
        if ($formationValidator->fails())
            return response()->json([
                'errors' => $formationValidator->errors(),
            ]);
        $formation  = new Formation();
        $formation->label = $request->label;
        $formation->plan = $request->plan;
        $formation->length = $request->length;
        $formation->user_id = $request->user()->id;
        $formation->level = $request->level;
        $formation->save();
        return response()->json([
            'message' => 'Formation ajoutee avec success',
            'formation' => $formation
        ]);
    }
    public function getMyFormation(Request $request)
    {
        return response()->json($request->user()->formations);
    }
}
