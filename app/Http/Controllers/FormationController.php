<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\DaysFormation;
use App\Models\Formation;
use App\Models\FormationHasDayFormation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        try {
            DB::beginTransaction();
            $formationValidator = Validator::make($request->all(), [
                'label' => ['required', Rule::unique('formations', 'label')->where(function ($query) use ($request) {
                    return $query->where(DB::raw('LOWER(label)'), strtolower($request->label));
                })],
                'plan' => 'required', Rule::in(['paid', 'free']),
                'level' => Rule::in(['beginner', 'confirmed', 'expert']),
                'start_date' => 'date',
                'end_date' => 'date',
                'description_formation' => 'string',
                'description_calendar' => 'string',
                'category_formation' => 'required|numeric',
                'work_days'=>'required',
                'day_moment'=>'required'
    
            ]);
            if ($formationValidator->fails())
                return response()->json([
                    'errors' => $formationValidator->errors(),
                ]);
    
            $calendar = new Calendar;
            $calendar->start_date = isset($request->start_date) ? $request->start_date : null;
            $calendar->end_date = isset($request->end_date) ? $request->end_date : null;
            $calendar->description = isset($request->description) ? $request->description : null;
            $calendar->save();
            $formation  = new Formation;
            $formation->calendar_id = $calendar->id;
            $formation->label = $request->label;
            $formation->plan = $request->plan;
            $formation->user_id = $request->user()->id;
            $formation->level = $request->level;
            $formation->day_moment = $request->day_moment;
            $formation->description = isset($request->description_formation) ? $request->description_formation : null;
            $formation->category_formation_id = $request->category_formation;
            $formation->save();
            foreach($request->work_days as $day){
                $formation_has_day = new FormationHasDayFormation;
                $formation_has_day->formation_id = $formation->id;
                $formation_has_day->days_formation_id = $day;
                $formation_has_day->save();
            }

            DB::commit();
            return response()->json([
                'message' => 'Formation ajoutee avec success',
                'formation' => $formation
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
           return response()->json([
           'errors'=>$th->getMessage()
           ]);
        }
    }
    public function getMyFormation(Request $request)
    {
        return response()->json($request->user()->formations);
    }
}
