<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function getFormation()
    {
        return response()->json(Formation::all());
    }
}
