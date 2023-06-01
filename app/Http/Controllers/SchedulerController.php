<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Scheduler;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SchedulerController extends Controller
{
    //creation des horaires pour une formation
    public function newSchedule(Calendar $calendar, Request $request)
    {
        if (!isset($calendar->start_date))
            return response()->json(["error" => "Le calendrier n'est pas encore cree"]);
        $scheduleValidator = Validator::make($request->all(), [
            '*.start_time' => ['date', 'after:' . strval($calendar->start_date), 'before:*.end_time'],
            '*.end_time' => 'date|before:' . strval($calendar->end_date),
            '*.title' => ['string', 'required', Rule::unique('schedulers', 'title')->where(function ($query) use ($request) {
                $titles = collect($request->input('*.title'))->map(function ($title) {
                    return strtolower($title);
                })->all();
                return $query->where(DB::raw('LOWER(title)'), $titles);
            })],
            '*.description' => ['string', 'required', Rule::unique('schedulers', 'description')->where(function ($query) use ($request) {
                $descriptions = collect($request->input('*.description'))->map(function ($description) {
                    return strtolower($description);
                })->all();
                return $query->where(DB::raw('LOWER(description)'), $descriptions);
            })],
        ]);
        if ($scheduleValidator->fails())
            return response()->json([$scheduleValidator->errors()]);
        foreach ($request->input() as $schedule) {
            $schedule['calendar_id'] = $calendar->id;
            Scheduler::create([
                'start_time' => $schedule['start_time'],
                'end_time' => $schedule['end_time'],
                'calendar_id' => $calendar['id'],
                'description' => $schedule['description'],
                'title' => $schedule['title']
            ]);
        }
        return response()->json(['message' => 'horaire(s) crees avec sucdes']);
    }
}
