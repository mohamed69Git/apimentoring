<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Http\Request;

class DemandeController extends Controller
{
    public function newQuery(Request $request)
    {
        $demande = new Demande();
        $demande->user_id = $request->user()->id;
        $demande->enabled = false;
        $demande->save();
        $request->user()->state = 'pending';
        $request->user()->save();
        return response()->json($demande);
    }
}
