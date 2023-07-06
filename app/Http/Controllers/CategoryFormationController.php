<?php

namespace App\Http\Controllers;

use App\Models\CategoryFormation;
use Illuminate\Http\Request;

class CategoryFormationController extends Controller
{
    public function getCategory(){
        return CategoryFormation::all();
    }
}
